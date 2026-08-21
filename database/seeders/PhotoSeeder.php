<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Category;
use App\Models\Photo;

class PhotoSeeder extends Seeder
{
    public function run(): void
    {
        // 1. Création des catégories
        $ceremonie = Category::firstOrCreate(['name' => 'Cérémonie'], ['slug' => 'ceremonie']);
        $soiree = Category::firstOrCreate(['name' => 'Soirée'], ['slug' => 'soiree']);
        $vinDhonneur = Category::firstOrCreate(['name' => 'Vin d\'honneur'], ['slug' => 'vin-dhonneur']);

        // 2. Insertion des photos d'origine
        Photo::create([
            'title'          => 'Échange des voeux',
            'code'           => 'IMG-001',
            'original_path'  => 'images/hero/slide1.jpg',
            'thumbnail_path' => 'images/hero/slide1.jpg',
            'category_id'    => $ceremonie->id,
            'download_count' => 0,
        ]);

        Photo::create([
            'title'          => 'Ouverture du bal',
            'code'           => 'IMG-002',
            'original_path'  => 'images/hero/slide2.jpg',
            'thumbnail_path' => 'images/hero/slide2.jpg',
            'category_id'    => $soiree->id,
            'download_count' => 0,
        ]);

        Photo::create([
            'title'          => 'Entrée des mariés',
            'code'           => 'IMG-003',
            'original_path'  => 'images/hero/slide3.jpg',
            'thumbnail_path' => 'images/hero/slide3.jpg',
            'category_id'    => $ceremonie->id,
            'download_count' => 0,
        ]);

        Photo::create([
            'title'          => 'Cocktail & Sourires',
            'code'           => 'IMG-004',
            'original_path'  => 'images/hero/slide4.jpg',
            'thumbnail_path' => 'images/hero/slide4.jpg',
            'category_id'    => $vinDhonneur->id,
            'download_count' => 0,
        ]);
    }
}