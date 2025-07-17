<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\OrderItem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Jobs\ProcessOrderJob;

class OrderController extends Controller
{
    public function create()
    {
        return view('order.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'customer_name' => 'required|string',
            'products.*.name' => 'required|string',
            'products.*.quantity' => 'required|integer|min:1',
            'products.*.price' => 'required|numeric|min:0',
        ]);

        DB::beginTransaction();

        try {
            $order = Order::create([
                'customer_name' => $validated['customer_name'],
                'total_amount' => collect($validated['products'])->sum(function ($item) {
                    return $item['quantity'] * $item['price'];
                }),
            ]);

            foreach ($validated['products'] as $product) {
                OrderItem::create([
                    'order_id' => $order->id,
                    'product_name' => $product['name'],
                    'quantity' => $product['quantity'],
                    'price' => $product['price'],
                ]);
            }

            DB::commit();

            dispatch(new ProcessOrderJob($order));

            return back()->with('success', 'Order placed and processing started.');

        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Failed to place order: ' . $e->getMessage());
        }
    }
}