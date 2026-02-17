@extends('index')

@section('content')
    <div class="row g-4">

        {{-- STOK HAMPIR HABIS --}}
        <div class="col-md-4">
            <div class="card border-0 shadow-sm bg-danger text-white">
                <div class="card-body">
                    <h6>Stok Hampir Habis</h6>
                    <h2>{{ $lowStocks->count() }} <small>Produk</small></h2>
                </div>
            </div>
        </div>

        {{-- PENDAPATAN HARI INI --}}
        <div class="col-md-4">
            <div class="card border-0 shadow-sm">
                <div class="card-body">
                    <h6>Pendapatan Hari Ini</h6>
                    <h2 class="text-primary">
                        Rp {{ number_format($todayRevenue, 0, ',', '.') }}
                    </h2>
                </div>
            </div>
        </div>

        {{-- OMSET BULAN INI --}}
        <div class="col-md-4">
            <div class="card border-0 shadow-sm">
                <div class="card-body">
                    <h6>Estimasi Omset Bulan Ini</h6>
                    <h2 class="text-success">
                        Rp {{ number_format($monthlyRevenue, 0, ',', '.') }}
                    </h2>
                </div>
            </div>
        </div>

    </div>

    {{-- PRODUK TERLARIS --}}
    <div class="card mt-4 border-0 shadow-sm">
        <div class="card-header bg-white">
            <h5 class="mb-0 fw-bold">Produk Terlaris Minggu Ini</h5>
        </div>
        <div class="card-body p-0">
            <table class="table mb-0">
                <thead class="bg-light">
                    <tr>
                        <th>Produk</th>
                        <th>Terjual</th>
                        <th>Total Pendapatan</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($topProducts as $item)
                        <tr>
                            <td>{{ $item->product->name ?? '-' }}</td>
                            <td>{{ $item->total_qty }} Pcs</td>
                            <td>Rp {{ number_format($item->total_revenue, 0, ',', '.') }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="3" class="text-center">Belum ada data</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    {{-- PERINGATAN STOK --}}
    <div class="card mt-4 border-0 shadow-sm">
        <div class="card-header bg-white">
            <h5 class="mb-0 text-danger fw-bold">Peringatan Stok</h5>
        </div>
        <div class="card-body">
            @forelse($lowStocks as $product)
                <div class="d-flex justify-content-between border-bottom py-2">
                    <div>
                        <strong>{{ $product->name }}</strong><br>
                        <small>Stok tersisa: {{ $product->total_stock ?? 0 }}</small>
                    </div>
                </div>
            @empty
                <p class="text-muted">Semua stok aman 👍</p>
            @endforelse
        </div>
    </div>

    {{-- LAPORAN HARIAN --}}
    <div class="card mt-4 border-0 shadow-sm mb-5">
        <div class="card-header bg-white">
            <h5 class="mb-0 fw-bold">Laporan Ringkasan Penjualan</h5>
        </div>
        <div class="card-body p-0">
            <table class="table mb-0">
                <thead class="bg-light">
                    <tr>
                        <th>Tanggal</th>
                        <th>Total Transaksi</th>
                        <th>Total Omset</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($dailyReport as $report)
                        <tr>
                            <td>{{ \Carbon\Carbon::parse($report->date)->format('d M Y') }}</td>
                            <td>{{ $report->total_orders }}</td>
                            <td>Rp {{ number_format($report->total_revenue, 0, ',', '.') }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="3" class="text-center">Belum ada transaksi</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
@endsection
