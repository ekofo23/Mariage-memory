<?php

namespace App\Http\Controllers;

use App\Models\Photo;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use ZipArchive;

class AlbumController extends Controller
{
    public function index()
    {
        $categories = Category::all();
        $photos = Photo::with('category')->latest()->get();

        return view('pages.album', compact('photos', 'categories'));
    }

    public function download(Photo $photo)
    {
        $photo->increment('download_count');
        $filePath = public_path($photo->original_path);

        if (file_exists($filePath)) {
            return response()->download($filePath);
        }

        if (Storage::disk('public')->exists($photo->original_path)) {
            return Storage::disk('public')->download($photo->original_path);
        }

        return back()->with('error', 'Le fichier photo n\'a pas pu être trouvé sur le serveur.');
    }

    /**
     * Génère et télécharge une archive ZIP de toutes les photos
     */
    public function downloadZip()
    {
        $photos = Photo::all();

        if ($photos->isEmpty()) {
            return back()->with('error', 'Aucune photo à télécharger.');
        }

        $zipFileName = 'Album_Mariage_HD_' . date('Y-m-d') . '.zip';
        $zipPath = storage_path('app/public/' . $zipFileName);

        $zip = new ZipArchive();

        if ($zip->open($zipPath, ZipArchive::CREATE | ZipArchive::OVERWRITE) === true) {
            foreach ($photos as $photo) {
                $filePath = public_path($photo->original_path);
                if (file_exists($filePath)) {
                    // Utilise le titre ou le nom du fichier pour nommer l'image dans le ZIP
                    $fileNameInZip = basename($filePath);
                    $zip->addFile($filePath, $fileNameInZip);
                }
            }
            $zip->close();
        } else {
            return back()->with('error', 'Impossible de créer le fichier ZIP.');
        }

        return response()->download($zipPath)->deleteFileAfterSend(true);
    }
}