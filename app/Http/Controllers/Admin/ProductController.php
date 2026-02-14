<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    // ===============================
    // TAMPILKAN SEMUA DATA
    // ===============================
    public function index()
    {
        $products = Product::latest()->get();
        return view('admin.product.product', compact('products'));
    }

    // ===============================
    // FORM TAMBAH DATA
    // ===============================
    public function create()
    {
        return view('admin.product.add-product');
    }

    // ===============================
    // SIMPAN DATA BARU
    // ===============================
    public function store(Request $request)
    {
        $request->validate([
            'code'     => 'required|string|max:255|unique:products,code',
            'name'     => 'required|string|max:255',
            'category' => 'required|string|max:255',
            'price'    => 'required|numeric|min:0',
        ]);

        Product::create($request->all());

        return redirect()
            ->route('admin.products.index')
            ->with('success', 'Produk berhasil ditambahkan');
    }

    // ===============================
    // FORM EDIT
    // ===============================
    public function edit(Product $product)
    {
        return view('admin.product.edit-product', compact('product'));
    }

    // ===============================
    // UPDATE DATA
    // ===============================
    public function update(Request $request, Product $product)
    {
        $request->validate([
            'code'     => 'required|string|max:255|unique:products,code,' . $product->id,
            'name'     => 'required|string|max:255',
            'category' => 'required|string|max:255',
            'price'    => 'required|numeric|min:0',
        ]);

        $product->update($request->all());

        return redirect()
            ->route('admin.products.index')
            ->with('success', 'Produk berhasil diupdate');
    }

    // ===============================
    // HAPUS DATA
    // ===============================
    public function destroy(Product $product)
    {
        $product->delete();

        return redirect()
            ->route('admin.products.index')
            ->with('success', 'Produk berhasil dihapus');
    }
}
