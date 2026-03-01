<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Stock;
use Carbon\Carbon;
use PDF;
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

    // =========================
    // EXPORT HARIAN
    // =========================
    public function exportDaily()
    {
        $today = Carbon::today();

        $orders = Order::whereDate('created_at', $today)
            ->where('status', 'approved')
            ->get();

        $totalRevenue = $orders->sum('total');
        $totalOrders = $orders->count();

        $items = DB::table('order_items')
            ->join('products', 'order_items.product_id', '=', 'products.id')
            ->join('orders', 'order_items.order_id', '=', 'orders.id')
            ->whereDate('orders.created_at', $today)
            ->where('orders.status', 'approved')
            ->select(
                'products.name',
                DB::raw('SUM(order_items.qty) as total_qty'),
                DB::raw('SUM(order_items.qty * order_items.price) as total_revenue')
            )
            ->groupBy('products.name')
            ->get();

        $pdf = Pdf::loadview('admin.reports.daily_pdf', compact(
            'today',
            'totalRevenue',
            'totalOrders',
            'items'
        ))->setPaper('a4', 'portrait');

        return $pdf->stream('Laporan-Harian-' . $today->format('d-m-Y') . '.pdf');
    }


    // =========================
    // EXPORT BULANAN
    // =========================
    public function exportMonthly()
    {
        $now = Carbon::now();

        $orders = Order::whereMonth('created_at', $now->month)
            ->whereYear('created_at', $now->year)
            ->where('status', 'approved')
            ->get();

        $totalRevenue = $orders->sum('total');
        $totalOrders = $orders->count();

        $items = DB::table('order_items')
            ->join('products', 'order_items.product_id', '=', 'products.id')
            ->join('orders', 'order_items.order_id', '=', 'orders.id')
            ->whereMonth('orders.created_at', $now->month)
            ->whereYear('orders.created_at', $now->year)
            ->where('orders.status', 'approved')
            ->select(
                'products.name',
                DB::raw('SUM(order_items.qty) as total_qty'),
                DB::raw('SUM(order_items.qty * order_items.price) as total_revenue')
            )
            ->groupBy('products.name')
            ->get();

        $pdf = Pdf::loadview('admin.reports.monthly_pdf', compact(
            'now',
            'totalRevenue',
            'totalOrders',
            'items'
        ))->setPaper('a4', 'portrait');

        return $pdf->stream('Laporan-Bulanan-' . $now->format('m-Y') . '.pdf');
    }
}
