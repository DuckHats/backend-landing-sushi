<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;

class ProductController extends Controller
{
    /**
     * Display a listing of products.
     * Supports optional category filtering via query parameter.
     */
    public function index(Request $request): JsonResponse
    {
        $query = Product::query();

        // Filter by category if provided
        if ($request->has('category')) {
            $query->where('category', $request->query('category'));
        }

        $products = $query->orderBy('product_code')->get();

        return response()->json([
            'success' => true,
            'data' => $products,
            'count' => $products->count(),
        ]);
    }

    /**
     * Display the specified product.
     */
    public function show(string $id): JsonResponse
    {
        $product = Product::find($id);

        if (!$product) {
            return response()->json([
                'success' => false,
                'message' => 'Product not found',
            ], 404);
        }

        return response()->json([
            'success' => true,
            'data' => $product,
        ]);
    }

    /**
     * Get all unique categories.
     */
    public function categories(): JsonResponse
    {
        $categories = Product::select('category')
            ->distinct()
            ->orderBy('category')
            ->pluck('category');

        return response()->json([
            'success' => true,
            'data' => $categories,
        ]);
    }
}
