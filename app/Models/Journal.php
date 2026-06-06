<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Journal extends Model
{
    protected $fillable = [
        'user_id', 'title', 'slug', 'excerpt', 'content',
        'cover_image', 'category', 'read_time', 'status', 'published_at'
    ];

    protected $casts = [
        'published_at' => 'datetime',
    ];

    // TAMBAHKAN ACCESSOR INI - untuk mendapatkan URL lengkap gambar
    public function getCoverImageUrlAttribute()
    {
        if (!$this->cover_image) {
            // Default image jika tidak ada
            return 'https://images.unsplash.com/photo-1556228720-195a672e8a03?w=800&q=80';
        }

        // Jika sudah URL penuh (http:// atau https://)
        if (filter_var($this->cover_image, FILTER_VALIDATE_URL)) {
            return $this->cover_image;
        }

        // Jika path lokal, tambahkan asset()
        return asset($this->cover_image);
    }

    // Relasi ke User (author)
    public function author()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    // Scope untuk published articles
    public function scopePublished($query)
    {
        return $query->where('status', 'published')
                     ->whereNotNull('published_at');
    }
}
