<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\Stock;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class StockController extends Controller
{
    // LIST STOCK
    public function index()
    {
        $products = Product::with('stocks')->get();
        return view('admin.stock.stock', compact('products'));
    }

    // FORM TAMBAH STOCK
    public function create()
    {
        $products = Product::all();
        return view('admin.stock.add-stock', compact('products'));
    }

    // SIMPAN STOCK MASUK
    public function store(Request $request)
    {
        $request->validate([
            'product_id' => 'required|exists:products,id',
            'quantity'   => 'required|numeric|min:1',
            'note'       => 'nullable|string',
        ]);

        DB::beginTransaction();

        try {
            Stock::create([
                'product_id' => $request->product_id,
                'quantity'   => $request->quantity,
                'type'       => 'in',
                'note'       => $request->note,
            ]);

            DB::commit();

            return redirect()
                ->route('admin.stock.index')
                ->with('success', 'Stok berhasil ditambahkan');
        } catch (\Throwable $e) {
            DB::rollBack();

            return redirect()
                ->back()
                ->withInput()
                ->with('error', 'Gagal menambahkan stok');
        }
    }


    // RESTOCK VIA MODAL
    public function restock(Request $request)
    {
        $request->validate([
            'product_id' => 'required|exists:products,id',
            'quantity'   => 'required|numeric|min:1',
        ]);

        DB::beginTransaction();

        try {
            Stock::create([
                'product_id' => $request->product_id,
                'quantity'   => $request->quantity,
                'type'       => 'in',
                'note'       => 'Restock Manual',
            ]);

            DB::commit();

            return back()->with('success', 'Stok berhasil diupdate');
        } catch (\Throwable $e) {
            DB::rollBack();

            return back()
                ->withInput()
                ->with('error', 'Gagal melakukan restock');
        }
    }
}
