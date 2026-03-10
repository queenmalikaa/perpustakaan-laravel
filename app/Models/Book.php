<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Category;

class Book extends Model
{
    protected $fillable = [
        'title',
        'cover',
        'author',
        'publisher',
        'description',
        'code',
        'stock',
        'category_id',
        'tahun_terbit'
    ];

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function peminjaman()
    {
        return $this->hasMany(Peminjaman::class);
    }
}
