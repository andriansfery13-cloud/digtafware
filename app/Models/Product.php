<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    /** @use HasFactory<\Database\Factories\ProductFactory> */
    use HasFactory;

    protected $fillable = [
        'title',
        'slug',
        'category_id',
        'description',
        'features',
        'requirements',
        'price',
        'is_enterprise',
        'demo_url',
        'demo_video_url',
        'version',
        'file_path',
        'thumbnail',
        'download_count',
        'status'
    ];

    protected $casts = [
        'is_enterprise' => 'boolean',
        'price' => 'decimal:2',
    ];

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function screenshots()
    {
        return $this->hasMany(ProductScreenshot::class)->orderBy('sort_order');
    }

    public function changelogs()
    {
        return $this->hasMany(ProductChangelog::class)->orderBy('released_at', 'desc');
    }

    public function reviews()
    {
        return $this->hasMany(Review::class);
    }

    public function getAverageRatingAttribute()
    {
        return $this->reviews()->avg('rating') ?? 0;
    }

    public function orderItems()
    {
        return $this->hasMany(OrderItem::class);
    }
}
