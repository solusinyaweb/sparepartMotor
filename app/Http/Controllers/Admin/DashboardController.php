<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Stock;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;


class DashboardController extends Controller
{
    public function index()
{
    // 1️⃣ Stok Hampir Habis (misal < 5)
    $lowStocks = Product::withSum('stocks as total_stock', DB::raw("
        CASE
            WHEN type = 'in' THEN quantity
            WHEN type = 'out' THEN -quantity
        END
    "))
    ->get()
    ->filter(fn($p) => ($p->total_stock ?? 0) < 5);

    // 2️⃣ Pendapatan Hari Ini (status approved)
    $todayRevenue = Order::whereDate('created_at', Carbon::today())
        ->where('status', 'approved')
        ->sum('total');

    // 3️⃣ Omset Bulan Ini
    $monthlyRevenue = Order::whereMonth('created_at', Carbon::now()->month)
        ->whereYear('created_at', Carbon::now()->year)
        ->where('status', 'approved')
        ->sum('total');

    // 4️⃣ Produk Terlaris Minggu Ini
    $topProducts = OrderItem::select(
            'product_id',
            DB::raw('SUM(qty) as total_qty'),
            DB::raw('SUM(qty * price) as total_revenue')
        )
        ->whereHas('order', function ($q) {
            $q->where('status', 'approved')
              ->whereBetween('created_at', [now()->startOfWeek(), now()->endOfWeek()]);
        })
        ->with('product')
        ->groupBy('product_id')
        ->orderByDesc('total_qty')
        ->take(5)
        ->get();

    // 5️⃣ Laporan Harian
    $dailyReport = Order::select(
            DB::raw('DATE(created_at) as date'),
            DB::raw('COUNT(*) as total_orders'),
            DB::raw('SUM(total) as total_revenue')
        )
        ->where('status', 'approved')
        ->groupBy('date')
        ->orderByDesc('date')
        ->take(7)
        ->get();

    return view('admin.dashboard', compact(
        'lowStocks',
        'todayRevenue',
        'monthlyRevenue',
        'topProducts',
        'dailyReport'
    ));
}

}


