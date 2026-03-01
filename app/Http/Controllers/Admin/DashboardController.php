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

    public function export(Request $request)
    {
        $request->validate([
            'start_date' => 'required|date',
            'end_date'   => 'required|date|after_or_equal:start_date'
        ]);

        $start = Carbon::parse($request->start_date)->startOfDay();
        $end   = Carbon::parse($request->end_date)->endOfDay();

        $orders = Order::whereBetween('created_at', [$start, $end])
            ->where('status', 'approved')
            ->get();

        $totalRevenue = $orders->sum('total');
        $totalOrders  = $orders->count();

        $items = DB::table('order_items')
            ->join('products', 'order_items.product_id', '=', 'products.id')
            ->join('orders', 'order_items.order_id', '=', 'orders.id')
            ->whereBetween('orders.created_at', [$start, $end])
            ->where('orders.status', 'approved')
            ->select(
                'products.name',
                DB::raw('SUM(order_items.qty) as total_qty'),
                DB::raw('SUM(order_items.qty * order_items.price) as total_revenue')
            )
            ->groupBy('products.name')
            ->orderByDesc('total_qty')
            ->get();

        $pdf = Pdf::loadview('admin.reports.range_pdf', compact(
            'start',
            'end',
            'totalRevenue',
            'totalOrders',
            'items'
        ))->setPaper('a4', 'portrait');

        return $pdf->stream(
            'Laporan-' . $start->format('d-m-Y') . '-sd-' . $end->format('d-m-Y') . '.pdf'
        );
    }
}
