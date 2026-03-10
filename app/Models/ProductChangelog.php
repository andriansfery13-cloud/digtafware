<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProductChangelog extends Model
{
    protected $fillable = [
        'product_id',
        'version',
        'content',
        'released_at'
    ];

    protected $casts = [
        'released_at' => 'datetime',
    ];

    public function product()
    {
        return $this->belongsTo(Product::class);
    }
}
