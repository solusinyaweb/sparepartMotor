<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <title>Nota {{ $order->invoice }}</title>
    <style>
        body {
            font-family: 'Helvetica Neue', Helvetica, Arial, sans-serif;
            color: #333;
            max-width: 800px;
            margin: auto;
            padding: 30px;
            line-height: 1.5;
        }

        /* Header Nota */
        .invoice-header {
            display: flex;
            justify-content: space-between;
            border-bottom: 2px solid #333;
            padding-bottom: 15px;
            margin-bottom: 20px;
        }

        .company-info h1 {
            margin: 0;
            color: #2c3e50;
            font-size: 28px;
            text-transform: uppercase;
        }

        .invoice-details {
            text-align: right;
        }

        .invoice-details p {
            margin: 0;
            color: #7f8c8d;
        }

        /* Informasi Pelanggan */
        .customer-section {
            margin-bottom: 30px;
        }

        .customer-section h4 {
            margin-bottom: 5px;
            color: #7f8c8d;
            text-transform: uppercase;
            font-size: 12px;
        }

        /* Tabel Produk */
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 10px;
        }

        th {
            background-color: #f8f9fa;
            color: #2c3e50;
            text-align: left;
            padding: 12px;
            border-bottom: 2px solid #dee2e6;
            text-transform: uppercase;
            font-size: 13px;
        }

        td {
            padding: 12px;
            border-bottom: 1px solid #eee;
        }

        .text-right { text-align: right; }
        .text-center { text-align: center; }

        /* Bagian Total */
        .summary-wrapper {
            margin-top: 30px;
            width: 100%;
        }

        .total-box {
            float: right;
            width: 250px;
            background: #f8f9fa;
            padding: 15px;
            border-radius: 5px;
        }

        .total-row {
            display: flex;
            justify-content: space-between;
            margin-bottom: 5px;
        }

        .grand-total {
            border-top: 2px solid #333;
            margin-top: 10px;
            padding-top: 10px;
            font-size: 18px;
            font-weight: bold;
            color: #e74c3c;
        }

        .footer {
            margin-top: 100px;
            text-align: center;
            font-size: 12px;
            color: #bdc3c7;
        }

        /* CSS khusus cetak */
        @print {
            body { padding: 0; }
        }
    </style>
</head>

<body>

    <div class="invoice-header">
        <div class="company-info">
            <h1>LYORA SPAREPART</h1>
            <p>Alamat Lengkap Toko, Kota<br>Telp: 0812-3456-7890</p>
        </div>
        <div class="invoice-details">
            <h2 style="margin-top: 0; color: #7f8c8d;">INVOICE</h2>
            <p><strong>#{{ $order->invoice }}</strong></p>
            <p>{{ $order->created_at->format('d F Y') }}</p>
        </div>
    </div>

    <div class="customer-section">
        <h4>Ditujukan Kepada:</h4>
        <strong>{{ $order->user->name }}</strong><br>
        {{ $order->user->phone ?? '-' }}
    </div>

    <table>
        <thead>
            <tr>
                <th width="40%">Produk</th>
                <th class="text-center">Qty</th>
                <th class="text-right">Harga</th>
                <th class="text-right">Subtotal</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($order->items as $item)
                <tr>
                    <td>
                        <strong>{{ $item->product->name }}</strong>
                    </td>
                    <td class="text-center">{{ $item->qty }}</td>
                    <td class="text-right">Rp {{ number_format($item->price, 0, ',', '.') }}</td>
                    @php $subtotal = $item->price * $item->qty; @endphp
                    <td class="text-right">Rp {{ number_format($subtotal, 0, ',', '.') }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <div class="summary-wrapper">
        <div class="total-box">
            <div class="total-row">
                <span>Subtotal:</span>
                <span>Rp {{ number_format($order->total, 0, ',', '.') }}</span>
            </div>
            <div class="total-row grand-total">
                <span>TOTAL:</span>
                <span>Rp {{ number_format($order->total, 0, ',', '.') }}</span>
            </div>
        </div>
        <div style="clear: both;"></div>
    </div>

    <div class="footer">
        <p>Terima kasih telah berbelanja bersama kami!</p>
        <p>Barang yang sudah dibeli tidak dapat ditukar atau dikembalikan.</p>
    </div>

</body>

</html>
