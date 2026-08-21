<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Photo;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Intervention\Image\Facades\Image;
use Illuminate\Support\Facades\File;

class PhotoController extends Controller
{
    /**
     * Liste toutes les photos pour l'administration
     */
    public function index()
    {
        $photos = Photo::with('category')->latest()->paginate(12);
        return view('admin.photos.index', compact('photos'));
    }

    /**
     * Formulaire d'ajout de photo
     */
    public function create()
    {
        $categories = Category::all();
        return view('admin.photos.create', compact('categories'));
    }

    /**
     * Enregistrer plusieurs photos avec leurs miniatures
     */
    public function store(Request $request)
    {
        $request->validate([
            'category_id' => 'required|exists:categories,id',
            'images'      => 'required|array',
            'images.*'    => 'image|mimes:jpeg,png,jpg,webp|max:20480', // Max 20Mo par photo
        ]);

        if ($request->hasFile('images')) {
            $originalPath  = public_path('uploads/photos/hd/');
            $thumbnailPath = public_path('uploads/photos/thumbnails/');

            if (!File::exists($originalPath)) {
                File::makeDirectory($originalPath, 0755, true);
            }
            if (!File::exists($thumbnailPath)) {
                File::makeDirectory($thumbnailPath, 0755, true);
            }

            $count = 0;

            foreach ($request->file('images') as $image) {
                // Génération d'un nom basé sur le nom d'origine sans extension
                $originalName = pathinfo($image->getClientOriginalName(), PATHINFO_FILENAME);
                $cleanName    = Str::slug($originalName);
                $filename     = time() . '_' . uniqid() . '_' . $cleanName . '.' . $image->getClientOriginalExtension();

                // 1. Sauvegarde de la photo HD
                $image->move($originalPath, $filename);

                // 2. Génération automatique de la miniature (600x400)
                $img = Image::make($originalPath . $filename);
                $img->fit(600, 400, function ($constraint) {
                    $constraint->upsize();
                })->save($thumbnailPath . $filename, 80);

                // 3. Enregistrement en base de données
                Photo::create([
                    'title'          => ucfirst(str_replace(['-', '_'], ' ', $originalName)),
                    'category_id'    => $request->category_id,
                    'code'           => 'IMG-' . strtoupper(Str::random(6)),
                    'original_path'  => 'uploads/photos/hd/' . $filename,
                    'thumbnail_path' => 'uploads/photos/thumbnails/' . $filename,
                    'download_count' => 0,
                ]);

                $count++;
            }

            return redirect()->route('admin.photos.index')->with('success', "$count photo(s) ajoutée(s) avec succès !");
        }

        return back()->with('error', 'Veuillez sélectionner au moins une image.');
    }
    /**
     * Formulaire de modification d'une photo
     */
    public function edit(Photo $photo)
    {
        $categories = Category::all();
        return view('admin.photos.edit', compact('photo', 'categories'));
    }

    /**
     * Mettre à jour une photo existante
     */
    public function update(Request $request, Photo $photo)
    {
        $request->validate([
            'title'       => 'required|string|max:255',
            'category_id' => 'required|exists:categories,id',
            'code'        => 'nullable|string|max:50|unique:photos,code,' . $photo->id,
            'image'       => 'nullable|image|mimes:jpeg,png,jpg,webp|max:20480',
        ]);

        $photo->title = $request->title;
        $photo->category_id = $request->category_id;
        if ($request->filled('code')) {
            $photo->code = $request->code;
        }

        // Si une nouvelle image est téléversée
        if ($request->hasFile('image')) {
            // Suppression des anciens fichiers
            if (File::exists(public_path($photo->original_path))) {
                File::delete(public_path($photo->original_path));
            }
            if (File::exists(public_path($photo->thumbnail_path))) {
                File::delete(public_path($photo->thumbnail_path));
            }

            // Enregistrement des nouvelles images
            $image = $request->file('image');
            $filename = time() . '_' . Str::slug($request->title) . '.' . $image->getClientOriginalExtension();

            $originalPath  = public_path('uploads/photos/hd/');
            $thumbnailPath = public_path('uploads/photos/thumbnails/');

            $image->move($originalPath, $filename);

            $img = Image::make($originalPath . $filename);
            $img->fit(600, 400, function ($constraint) {
                $constraint->upsize();
            })->save($thumbnailPath . $filename, 80);

            $photo->original_path  = 'uploads/photos/hd/' . $filename;
            $photo->thumbnail_path = 'uploads/photos/thumbnails/' . $filename;
        }

        $photo->save();

        return redirect()->route('admin.photos.index')->with('success', 'Photo mise à jour avec succès !');
    }

    /**
     * Supprimer une photo de la BDD et du serveur
     */
    public function destroy(Photo $photo)
    {
        // Supprimer les fichiers physiques du serveur
        if (File::exists(public_path($photo->original_path))) {
            File::delete(public_path($photo->original_path));
        }
        if (File::exists(public_path($photo->thumbnail_path))) {
            File::delete(public_path($photo->thumbnail_path));
        }

        // Supprimer l'enregistrement en base de données
        $photo->delete();

        return redirect()->route('admin.photos.index')->with('success', 'Photo supprimée définitivement !');
    }

    
}