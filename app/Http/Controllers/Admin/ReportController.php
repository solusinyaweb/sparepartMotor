<?php

namespace App\Http\Controllers\Admin; // Pastikan namespace sesuai folder

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Carbon\Carbon;
use App\Models\Order; // Tambahkan ini agar 'Order' tidak merah
use Barryvdh\DomPDF\Facade\Pdf; // Jika pakai DomPDF

class ReportController extends Controller
{
    public function exportCustom(Request $request)
    {
        $request->validate([
            'start_date' => 'required|date',
            'end_date'   => 'required|date|after_or_equal:start_date', // Gunakan after_or_equal
        ]);

        $start = $request->start_date;
        $end = $request->end_date;

        $data = Order::whereBetween('created_at', [$start . ' 00:00:00', $end . ' 23:59:59'])
            ->selectRaw('DATE(created_at) as date, COUNT(*) as total_orders, SUM(total_price) as total_revenue')
            ->groupBy('date')
            ->get();

        // Lanjut ke logika PDF...
    }
}
