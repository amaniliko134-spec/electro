<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Category extends Model
{
    protected $fillable = ['name', 'slug', 'description'];

    // Connects a category to its many solar products
    public function products(): HasMany
    {
        return $this->hasMany(Product::class);
    }
}
