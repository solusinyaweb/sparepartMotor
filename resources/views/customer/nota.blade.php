<!DOCTYPE html>
<html>
<head>
    <title>Nota Pembayaran - #TRX-99281</title>
    <style>
        body { font-family: sans-serif; padding: 30px; line-height: 1.6; }
        .nota-header { border-bottom: 2px solid #333; padding-bottom: 10px; margin-bottom: 20px; }
        .table { width: 100%; border-collapse: collapse; }
        .table th, .table td { border-bottom: 1px solid #ddd; padding: 10px; text-align: left; }
        .total { font-size: 1.2rem; font-weight: bold; text-align: right; margin-top: 20px; }
        @media print { .no-print { display: none; } } /* Sembunyikan tombol cetak saat diprint */
    </style>
</head>
<body>
    <div class="no-print">
        <button onclick="window.print()">Cetak Nota</button>
        <hr>
    </div>

    <div class="nota-header">
        <h2>NOTA PEMBELIAN #TRX-99281</h2>
        <p>Bengkel Sejahtera<br>Tanggal: 12 Mei 2024</p>
    </div>

    <table class="table">
        <thead>
            <tr>
                <th>Item</th>
                <th>Qty</th>
                <th>Harga</th>
                <th>Subtotal</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td>Kampas Rem Honda Vario</td>
                <td>1</td>
                <td>Rp 45.000</td>
                <td>Rp 45.000</td>
            </tr>
        </tbody>
    </table>

    <div class="total">
        TOTAL: Rp 45.000
    </div>
</body>
</html>
