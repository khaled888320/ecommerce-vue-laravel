<?php

namespace App\Http\Controllers;

use App\Models\CartItem;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;

class CartItemController extends Controller
{
    public function index(Request $request): JsonResponse
    {
        $cartItems = CartItem::with('product')
            ->where('user_id', $request->user()->id)
            ->get();

        $total = $cartItems->sum(function($item) {
            return $item->product->current_price * $item->quantity;
        });

        return response()->json([
            'items' => $cartItems,
            'total' => $total,
        ]);
    }

    public function store(Request $request): JsonResponse
    {
        $request->validate([
            'product_id' => 'required|exists:products,id',
            'quantity'   => 'required|integer|min:1',
        ]);

        $cartItem = CartItem::updateOrCreate(
            [
                'user_id'    => $request->user()->id,
                'product_id' => $request->product_id,
            ],
            [
                'quantity' => $request->quantity,
            ]
        );

        $cartItem->load('product');

        return response()->json($cartItem, 201);
    }

    public function destroy(CartItem $cartItem): JsonResponse
    {
        $cartItem->delete();
        return response()->json(['message' => 'Produs șters din coș!']);
    }
}