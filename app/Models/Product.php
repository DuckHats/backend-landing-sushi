<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $fillable = [
        'product_code',
        'name',
        'price',
        'category',
        'secondary_category',
        'image',
        'description',
        'ingredients',
        'allergens',
    ];

    protected $casts = [
        'price' => 'decimal:2',
        'ingredients' => 'array',
        'allergens' => 'array',
    ];

    /**
     * Get formatted price with currency symbol
     */
    public function getFormattedPriceAttribute(): string
    {
        return number_format((float) $this->price, 2) . '€';
    }
}
