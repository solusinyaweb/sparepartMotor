<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\Product;
use App\Models\Stock;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    public function index(Request $request)
    {
        $query = Order::with(['user', 'items'])->latest();

        if ($request->status == 'pending') {
            $query->where('status', 'pending');
        }

        $orders = $query->get();

        return view('admin.transaction.transaction', compact('orders'));
    }

    // public function updateStatus(Request $request, $id)
    // {
    //     $order = Order::findOrFail($id);

    //     $order->status = $request->status;
    //     $order->save();

    //     return response()->json(['success' => true]);
    // }

    public function updateStatus(Request $request, $id)
    {
        $order = Order::with('items')->findOrFail($id);

        if ($request->status == 'approved') {

            foreach ($order->items as $item) {

                // cek stok lagi biar aman
                $stockIn = Stock::where('product_id', $item->product_id)
                    ->where('type', 'in')
                    ->sum('quantity');

                $stockOut = Stock::where('product_id', $item->product_id)
                    ->where('type', 'out')
                    ->sum('quantity');

                $availableStock = $stockIn - $stockOut;

                if ($availableStock < $item->qty) {
                    return response()->json([
                        'error' => 'Stok tidak cukup'
                    ], 400);
                }

                // INSERT LOG STOCK OUT
                // Stock::create([
                //     'product_id' => $item->product_id,
                //     'quantity' => $item->qty,
                //     'type' => 'out',
                //     'note' => 'Order ' . $order->invoice
                // ]);
            }
        }

        $order->status = $request->status;
        $order->save();

        return response()->json(['success' => true]);
    }


    public function notaList()
    {
        $orders = Order::with('user')
            ->where('status', 'approved')
            ->latest()
            ->get();

        return view('admin.transaction.nota', compact('orders'));
    }

    public function notaDetail($id)
    {
        $order = Order::with(['user', 'items'])->findOrFail($id);
        return view('admin.transaction.nota-print', compact('order'));
    }
}
