@extends('index')

@section('content')

<div class="row g-4">

    {{-- STOK HAMPIR HABIS --}}
    <div class="col-md-4">
        <div class="card border-0 shadow-sm bg-danger text-white h-100">
            <div class="card-body">
                <h6>Stok Hampir Habis</h6>
                <h2 class="fw-bold">
                    {{ $lowStocks->count() }}
                    <small class="fs-6">Produk</small>
                </h2>
            </div>
        </div>
    </div>

    {{-- PENDAPATAN HARI INI --}}
    <div class="col-md-4">
        <div class="card border-0 shadow-sm h-100">
            <div class="card-body">
                <h6>Pendapatan Hari Ini</h6>
                <h2 class="text-primary fw-bold">
                    Rp {{ number_format($todayRevenue, 0, ',', '.') }}
                </h2>
            </div>
        </div>
    </div>

    {{-- OMSET BULAN INI --}}
    <div class="col-md-4">
        <div class="card border-0 shadow-sm h-100">
            <div class="card-body">
                <h6>Estimasi Omset Bulan Ini</h6>
                <h2 class="text-success fw-bold">
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
        <table class="table table-hover mb-0">
            <thead class="table-light">
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
                        <td class="text-success fw-semibold">
                            Rp {{ number_format($item->total_revenue, 0, ',', '.') }}
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="3" class="text-center text-muted">
                            Belum ada data
                        </td>
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
            <p class="text-muted mb-0">Semua stok aman 👍</p>
        @endforelse
    </div>
</div>


{{-- LAPORAN RINGKASAN PENJUALAN --}}
<div class="card mt-4 border-0 shadow-sm mb-5">

    <div class="card-header bg-white">
        <div class="row align-items-end">

            <div class="col-md-4">
                <h5 class="fw-bold mb-0">Laporan Ringkasan Penjualan</h5>
            </div>

            <div class="col-md-8">
                <form action="{{ route('admin.report.export') }}"
                      method="GET"
                      target="_blank"
                      class="row g-2 justify-content-end">

                    <div class="col-md-4">
                        <label class="form-label small">Tanggal Awal</label>
                        <input type="date"
                               name="start_date"
                               class="form-control form-control-sm"
                               required>
                    </div>

                    <div class="col-md-4">
                        <label class="form-label small">Tanggal Akhir</label>
                        <input type="date"
                               name="end_date"
                               class="form-control form-control-sm"
                               required>
                    </div>

                    <div class="col-md-3 d-grid">
                        <button type="submit" class="btn btn-danger btn-sm">
                            <i class="bi bi-file-earmark-pdf"></i> Export PDF
                        </button>
                    </div>

                </form>
            </div>

        </div>
    </div>

    <div class="card-body p-0">
        <table class="table table-hover mb-0">
            <thead class="table-light">
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
                        <td class="fw-semibold text-success">
                            Rp {{ number_format($report->total_revenue, 0, ',', '.') }}
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="3" class="text-center text-muted">
                            Belum ada transaksi
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

</div>

@endsection
