<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Product extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'category_id',
        'name',
        'slug',
        'description',
        'price',
        'stock',
        'image_path',
        'wattage',
        'capacity_ah',
        'voltage',
        'is_featured'
    ];

    /**
     * Get the category that owns the solar product.
     */
    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }
}
