<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Product;
use App\Models\Stock;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class CatalogController extends Controller
{
    public function catalog()
    {
        $products = Product::with('stocks')->get();

        return view('customer.catalog', compact('products'));
    }

    public function addToCart($id)
    {
        $product = Product::findOrFail($id);

        $cart = session()->get('cart', []);

        if (isset($cart[$id])) {
            $cart[$id]['qty']++;
        } else {
            $cart[$id] = [
                "name" => $product->name,
                "price" => $product->price,
                "qty" => 1
            ];
        }

        session()->put('cart', $cart);

        return response()->json(['success' => true]);
    }

    public function cart()
    {
        $cart = session()->get('cart', []);
        return view('customer.cart', compact('cart'));
    }

    public function updateCart(Request $request, $id)
    {
        $cart = session()->get('cart', []);

        if (isset($cart[$id])) {

            $qty = (int) $request->qty;

            if ($qty < 1) {
                $qty = 1;
            }

            $cart[$id]['qty'] = $qty;

            session()->put('cart', $cart);
        }

        return back();
    }

    public function removeCart($id)
    {
        $cart = session()->get('cart', []);

        if (isset($cart[$id])) {
            unset($cart[$id]);
            session()->put('cart', $cart);
        }

        return back();
    }

    public function checkout(Request $request)
    {
        $request->validate([
            'payment_proof' => 'required|image|max:2048'
        ]);

        $cart = session()->get('cart');

        if (!$cart || count($cart) == 0) {
            return back()->with('error', 'Keranjang kosong');
        }

        DB::beginTransaction();

        try {

            $total = 0;

            // ==============================
            // 1️⃣ CEK SEMUA STOK DULU
            // ==============================
            foreach ($cart as $id => $item) {

                $product = Product::with('stocks')->findOrFail($id);

                $stockIn = $product->stocks()->where('type', 'in')->sum('quantity');
                $stockOut = $product->stocks()->where('type', 'out')->sum('quantity');

                $currentStock = $stockIn - $stockOut;

                if ($currentStock < $item['qty']) {
                    DB::rollBack();
                    return back()->with('error', 'Stok tidak cukup untuk produk ' . $product->name);
                }

                $total += $item['price'] * $item['qty'];
            }

            // ==============================
            // 2️⃣ BUAT INVOICE
            // ==============================
            $invoice = 'INV-' . time();

            $file = $request->file('payment_proof');
            $filename = $invoice . '.' . $file->getClientOriginalExtension();
            $file->storeAs('payment_proof', $filename, 'public');

            // ==============================
            // 3️⃣ BUAT ORDER
            // ==============================
            $order = Order::create([
                'user_id' => Auth::id(),
                'invoice' => $invoice,
                'total' => $total,
                'payment_proof' => $filename,
                'status' => 'paid'
            ]);

            // ==============================
            // 4️⃣ SIMPAN ORDER ITEM + STOCK OUT
            // ==============================
            foreach ($cart as $id => $item) {

                OrderItem::create([
                    'order_id' => $order->id,
                    'product_id' => $id,
                    'qty' => $item['qty'],
                    'price' => $item['price']
                ]);

                // Catat stok keluar (OUT)
                Stock::create([
                    'product_id' => $id,
                    'quantity' => $item['qty'],
                    'type' => 'out',
                    'note' => 'Penjualan - Invoice ' . $invoice
                ]);
            }

            // ==============================
            // 5️⃣ CLEAR CART
            // ==============================
            session()->forget('cart');

            DB::commit();

            return redirect()
                ->route('customer.catalog')
                ->with('success', 'Transaksi berhasil');
        } catch (\Exception $e) {

            DB::rollBack();

            return back()->with('error', 'Terjadi kesalahan saat checkout');
        }
    }


    public function history()
    {
        $orders = Order::with('items.product', 'user')
            ->where('user_id', Auth::id())
            ->latest()
            ->get();

        return view('customer.history', compact('orders'));
    }

    public function showNota($id)
    {
        $order = Order::with('items')
            ->where('user_id', Auth::id())
            ->findOrFail($id);

        return view('customer.nota', compact('order'));
    }
}
