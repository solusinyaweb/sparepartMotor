<!DOCTYPE html>
<html>

<head>
    <title>Nota {{ $order->kode_transaksi }}</title>
    <style>
        body {
            font-family: sans-serif;
            padding: 40px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        th,
        td {
            padding: 10px;
            border-bottom: 1px solid #ddd;
        }

        .total {
            text-align: right;
            font-weight: bold;
            font-size: 18px;
            margin-top: 20px;
        }
    </style>
</head>

<body>

    <h2>NOTA PENJUALAN</h2>
    <p>
        ID: {{ $order->invoice }} <br>
        Pelanggan: {{ $order->user->name }} <br>
        Tanggal: {{ $order->created_at->format('d M Y') }}
    </p>

    <table>
        <thead>
            <tr>
                <th>Produk</th>
                <th>Qty</th>
                <th>Harga</th>
                <th>Subtotal</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($order->items as $item)
                <tr style="text-align: center">
                    <td>{{ $item->product->name }}</td>
                    <td>{{ $item->qty }}</td>
                    <td>Rp {{ number_format($item->price, 0, ',', '.') }}</td>
                    @php
                        $subtotal = $item->price * $item->qty;
                    @endphp
                    <td>Rp {{ number_format($subtotal, 0, ',', '.') }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <div class="total">
        TOTAL: Rp {{ number_format($order->total, 0, ',', '.') }}
    </div>

</body>

</html>
