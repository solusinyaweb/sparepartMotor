<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

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

        if (!$cart) {
            return back()->with('error', 'Keranjang kosong');
        }

        $total = 0;

        foreach ($cart as $item) {
            $total += $item['price'] * $item['qty'];
        }

        $invoice = 'INV-' . time();

        $file = $request->file('payment_proof');
        $filename = $invoice . '.' . $file->getClientOriginalExtension();
        $file->move(public_path('uploads'), $filename);

        $order = Order::create([
            'user_id' => Auth::user()->id,
            'invoice' => $invoice,
            'total' => $total,
            'payment_proof' => $filename,
            'status' => 'paid'
        ]);

        foreach ($cart as $id => $item) {
            OrderItem::create([
                'order_id' => $order->id,
                'product_id' => $id,
                'qty' => $item['qty'],
                'price' => $item['price']
            ]);
        }

        session()->forget('cart');

        return redirect()->route('customer.catalog')->with('success', 'Transaksi berhasil');
    }

    public function history()
    {
        $orders = Order::with('items')
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
