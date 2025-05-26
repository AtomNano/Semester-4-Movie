<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Movie extends Model
{
    /** @use HasFactory<\Database\Factories\MovieFactory> */
    use HasFactory;

    protected $fillable = [
        'title', 'slug', 'synopsis', 'category_id', 'year', 'actors', 'cover_image'
    ];

    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }
}
