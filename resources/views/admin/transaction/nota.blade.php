@extends('index')

@section('content')
    <div class="card shadow-sm">
        <div class="card-header bg-white">
            <h5 class="fw-bold">Daftar Nota Penjualan</h5>
        </div>

        <div class="card-body p-3">
            <table class="table table-hover">
                <thead class="table-light">
                    <tr>
                        <th>Pelanggan</th>
                        <th>Kode</th>
                        <th>Tanggal</th>
                        <th>Total</th>
                        <th class="text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($orders as $order)
                        <tr>
                            <td>
                                <strong>{{ $order->user->name }}</strong><br>
                            </td>
                            <td><small>ID: {{ $order->invoice }}</small></td>
                            <td>{{ $order->created_at->format('d M Y') }}</td>
                            <td><strong>Rp {{ number_format($order->total, 0, ',', '.') }}</strong></td>
                            <td class="text-center">
                                <a href="{{ route('admin.nota.print', $order->id) }}" target="_blank"
                                    class="btn btn-warning btn-sm text-white">
                                    Cetak Nota
                                </a>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
@endsection
