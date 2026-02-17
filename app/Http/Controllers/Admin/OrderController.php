<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\Product;
use App\Models\Stock;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

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
        DB::beginTransaction();

        try {

            $order = Order::with('items')->findOrFail($id);

            // ==============================
            // JIKA STATUS = REJECTED
            // ==============================
            if ($request->status == 'rejected') {

                // Pastikan hanya dikembalikan jika sebelumnya belum pernah rejected
                if ($order->status != 'rejected') {

                    foreach ($order->items as $item) {

                        // Kembalikan stok dengan INSERT STOCK IN
                        Stock::create([
                            'product_id' => $item->product_id,
                            'quantity'   => $item->qty,
                            'type'       => 'in',
                            'note'       => 'Pengembalian dari Order ' . $order->invoice
                        ]);
                    }
                }
            }

            // ==============================
            // UPDATE STATUS
            // ==============================
            $order->status = $request->status;
            $order->save();

            DB::commit();

            return response()->json(['success' => true]);
        } catch (\Exception $e) {

            DB::rollBack();

            return response()->json([
                'error' => 'Terjadi kesalahan server'
            ], 500);
        }
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
