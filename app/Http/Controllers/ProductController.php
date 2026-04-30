<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;

class ProductController extends Controller
{
    public function index(Request $request): JsonResponse
    {
        $products = Product::with('category')
            ->active()
            ->when($request->category, function($query, $category) {
                $query->whereHas('category', fn($q) => $q->where('slug', $category));
            })
            ->when($request->featured, function($query) {
                $query->featured();
            })
            ->when($request->search, function($query, $search) {
                $query->where('name', 'like', "%{$search}%");
            })
            ->when($request->min_price, function($query, $min) {
                $query->where('price', '>=', $min);
            })
            ->when($request->max_price, function($query, $max) {
                $query->where('price', '<=', $max);
            })
            ->paginate(12);

        return response()->json($products);
    }

    public function show(Product $product): JsonResponse
    {
        $product->load('category');
        return response()->json($product);
    }
}