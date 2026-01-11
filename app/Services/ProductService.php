<?php

namespace App\Services;

use App\Models\Product;
use Illuminate\Database\Eloquent\Collection;

class ProductService
{
    /**
     * Get all active products, optionally filtered by category.
     */
    public function getActiveProducts(?string $category = null): Collection
    {
        return Product::query()
            ->when($category, function ($query, $category) {
                return $query->where('category', $category);
            })
            ->where('is_active', true)
            ->orderBy('product_code')
            ->get();
    }

    /**
     * Get a single product by ID.
     */
    public function getProductById(string $id): ?Product
    {
        return Product::find($id);
    }

    /**
     * Get all unique categories from active products.
     */
    public function getUniqueCategories(): \Illuminate\Support\Collection
    {
        return Product::select('category')
            ->distinct()
            ->orderBy('category')
            ->pluck('category');
    }
}
