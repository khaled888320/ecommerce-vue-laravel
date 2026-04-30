<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\CartItem;
use App\Models\OrderItem;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\DB;

class OrderController extends Controller
{
    public function index(Request $request): JsonResponse
    {
        $orders = Order::with('items.product')
            ->where('user_id', $request->user()->id)
            ->latest()
            ->get();

        return response()->json($orders);
    }

    public function store(Request $request): JsonResponse
    {
        $request->validate([
            'payment_method' => 'required|string',
            'notes'          => 'nullable|string',
        ]);

        // Ia coșul userului
        $cartItems = CartItem::with('product')
            ->where('user_id', $request->user()->id)
            ->get();

        if ($cartItems->isEmpty()) {
            return response()->json([
                'message' => 'Coșul este gol!'
            ], 400);
        }

        // Calculează totalurile
        $subtotal = $cartItems->sum(fn($item) => 
            $item->product->current_price * $item->quantity
        );
        $tax      = $subtotal * 0.19;
        $shipping = 15.00;
        $total    = $subtotal + $tax + $shipping;

        // Creează comanda într-o tranzacție
        $order = DB::transaction(function() use ($request, $cartItems, $subtotal, $tax, $shipping, $total) {
            
            $order = Order::create([
                'user_id'        => $request->user()->id,
                'order_number'   => Order::generateOrderNumber(),
                'status'         => 'pending',
                'subtotal'       => $subtotal,
                'tax'            => $tax,
                'shipping'       => $shipping,
                'total'          => $total,
                'payment_status' => 'unpaid',
                'payment_method' => $request->payment_method,
                'notes'          => $request->notes,
            ]);

            // Creează order items
            foreach ($cartItems as $cartItem) {
                OrderItem::create([
                    'order_id'   => $order->id,
                    'product_id' => $cartItem->product_id,
                    'quantity'   => $cartItem->quantity,
                    'price'      => $cartItem->product->current_price,
                    'total'      => $cartItem->product->current_price * $cartItem->quantity,
                ]);
            }

            // Golește coșul
            CartItem::where('user_id', $request->user()->id)->delete();

            return $order;
        });

        $order->load('items.product');

        return response()->json($order, 201);
    }

    public function show(Request $request, Order $order): JsonResponse
    {
        // Verifică că comanda aparține userului
        if ($order->user_id !== $request->user()->id) {
            return response()->json([
                'message' => 'Nu ai acces la această comandă!'
            ], 403);
        }

        $order->load('items.product');
        return response()->json($order);
    }
}