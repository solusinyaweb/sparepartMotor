<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Laporan Bulanan</title>
    <style>
        body {
            font-family: DejaVu Sans, sans-serif;
            font-size: 12px;
            color: #333;
        }

        .header {
            text-align: center;
            margin-bottom: 20px;
        }

        .header h2 {
            margin: 0;
        }

        .line {
            border-bottom: 2px solid #000;
            margin: 10px 0 20px 0;
        }

        .summary {
            margin-bottom: 20px;
        }

        .summary-box {
            display: inline-block;
            width: 48%;
            padding: 10px;
            border: 1px solid #ddd;
            margin-right: 2%;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 15px;
        }

        table th {
            background: #f2f2f2;
            border: 1px solid #ddd;
            padding: 8px;
        }

        table td {
            border: 1px solid #ddd;
            padding: 8px;
        }

        .text-right {
            text-align: right;
        }

        .footer {
            margin-top: 40px;
            text-align: right;
        }
    </style>
</head>
<body>

<div class="header">
    <h2>LAPORAN PENJUALAN BULANAN</h2>
    <small>Bulan: {{ $now->format('F Y') }}</small>
</div>

<div class="line"></div>

<div class="summary">
    <div class="summary-box">
        <strong>Total Transaksi</strong><br>
        {{ $totalOrders }} Transaksi
    </div>

    <div class="summary-box">
        <strong>Total Omset</strong><br>
        Rp {{ number_format($totalRevenue, 0, ',', '.') }}
    </div>
</div>

<h4>Detail Produk Terjual</h4>

<table>
    <thead>
        <tr>
            <th>Produk</th>
            <th>Qty</th>
            <th>Total Pendapatan</th>
        </tr>
    </thead>
    <tbody>
        @forelse($items as $item)
            <tr>
                <td>{{ $item->name }}</td>
                <td>{{ $item->total_qty }}</td>
                <td class="text-right">
                    Rp {{ number_format($item->total_revenue, 0, ',', '.') }}
                </td>
            </tr>
        @empty
            <tr>
                <td colspan="3" align="center">Tidak ada data</td>
            </tr>
        @endforelse
    </tbody>
</table>

<div class="footer">
    Dicetak pada: {{ now()->format('d M Y H:i') }}
</div>

</body>
</html>
