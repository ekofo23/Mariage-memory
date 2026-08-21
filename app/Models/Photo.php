<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Photo extends Model
{
    protected $fillable = ['title', 'code', 'original_path', 'thumbnail_path', 'category_id', 'download_count'];

    public function category()
    {
        return $this->belongsTo(Category::class);
    }
}