@extends('index')

@section('content')
    <div class="row g-4">
        <div class="col-md-4">
            <div class="card stretch stretch-full border-0 shadow-sm"
                style="background: linear-gradient(135deg, #ff5f6d, #ffc371);">
                <div class="card-body p-4">
                    <div class="d-flex align-items-center justify-content-between">
                        <div>
                            <h6 class="text-white text-uppercase ls-1 mb-2 fw-semibold"
                                style="font-size: 11px; opacity: 0.85;">Stok Hampir Habis</h6>
                            <h2 class="fw-bold mb-0 text-white">08 <small class="fw-light text-white-50"
                                    style="font-size: 14px;">Produk</small></h2>
                        </div>
                        <div class="rounded-3 d-flex align-items-center justify-content-center"
                            style="width: 50px; height: 50px; background: rgba(255,255,255,0.2);">
                            <i class="feather-alert-triangle text-white fs-4"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-4">
            <div class="card stretch stretch-full border-0 shadow-sm">
                <div class="card-body p-4">
                    <div class="d-flex align-items-center justify-content-between">
                        <div>
                            <h6 class="text-muted text-uppercase ls-1 mb-2 fw-semibold" style="font-size: 11px;">Pendapatan
                                Hari Ini</h6>
                            <h2 class="fw-bold mb-0 text-dark">Rp 1.250.000</h2>
                        </div>
                        <div class="bg-soft-primary rounded-3 d-flex align-items-center justify-content-center"
                            style="width: 50px; height: 50px;">
                            <i class="feather-trending-up text-primary fs-4"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-4">
            <div class="card stretch stretch-full border-0 shadow-sm">
                <div class="card-body p-4">
                    <div class="d-flex align-items-center justify-content-between">
                        <div>
                            <h6 class="text-muted text-uppercase ls-1 mb-2 fw-semibold" style="font-size: 11px;">Estimasi
                                Omset Bulan Ini</h6>
                            <h2 class="fw-bold mb-0 text-success">Rp 45.800.000</h2>
                        </div>
                        <div class="bg-soft-success rounded-3 d-flex align-items-center justify-content-center"
                            style="width: 50px; height: 50px;">
                            <i class="feather-shopping-bag text-success fs-4"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row mt-2 g-4">
        <div class="col-lg-8">
            <div class="card border-0 shadow-sm">
                <div class="card-header bg-transparent border-0 py-4">
                    <div class="d-flex align-items-center">
                        <div class="bg-warning me-3" style="width: 4px; height: 20px; border-radius: 10px;"></div>
                        <h5 class="mb-0 fw-bold text-dark" style="letter-spacing: -0.5px;">Produk Terlaris Minggu Ini</h5>
                    </div>
                </div>
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-hover align-middle mb-0">
                            <thead>
                                <tr class="bg-light text-muted text-uppercase fw-bold"
                                    style="font-size: 10px; letter-spacing: 1px;">
                                    <th class="ps-4 border-0">Informasi Produk</th>
                                    <th class="border-0">Kategori</th>
                                    <th class="text-center border-0">Volume Terjual</th>
                                    <th class="text-end pe-4 border-0">Total Pendapatan</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td class="ps-4">
                                        <span class="fw-bold text-dark d-block mb-0">Oli Motul 5100 10W-40 1L</span>
                                        <small class="text-muted" style="font-size: 11px;">SKU: MOT-5100-01</small>
                                    </td>
                                    <td><span class="text-secondary fw-medium">Pelumas</span></td>
                                    <td class="text-center"><span
                                            class="badge rounded-pill bg-soft-primary text-primary px-3 py-2">45 Pcs</span>
                                    </td>
                                    <td class="text-end pe-4 fw-bold text-dark">Rp 6.750.000</td>
                                </tr>
                                <tr>
                                    <td class="ps-4">
                                        <span class="fw-bold text-dark d-block mb-0">Kampas Rem Depan Vario 125/150</span>
                                        <small class="text-muted" style="font-size: 11px;">SKU: HON-PAD-021</small>
                                    </td>
                                    <td><span class="text-secondary fw-medium">Suku Cadang</span></td>
                                    <td class="text-center"><span
                                            class="badge rounded-pill bg-soft-primary text-primary px-3 py-2">32 Pcs</span>
                                    </td>
                                    <td class="text-end pe-4 fw-bold text-dark">Rp 1.440.000</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-lg-4">
            <div class="card border-0 shadow-sm">
                <div class="card-header bg-transparent border-0 pt-4 pb-2">
                    <h5 class="mb-0 fw-bold text-danger" style="letter-spacing: -0.5px;">Peringatan Stok</h5>
                </div>
                <div class="card-body px-4 pb-4 pt-2">
                    <div class="stock-container">
                        <div
                            class="stock-item mb-3 d-flex justify-content-between align-items-center pb-2 border-bottom border-light">
                            <div>
                                <span class="text-dark fw-bold d-block mb-0" style="font-size: 14px;">Ban Luar IRC
                                    80/90-14</span>
                                <small class="text-muted" style="font-size: 11px;">Min. Stok: 5 Unit</small>
                            </div>
                            <div class="text-end d-flex flex-column align-items-end gap-1">
                                <span class="badge bg-danger rounded-pill px-3 py-1 fw-bold" style="font-size: 10px;">Sisa
                                    2</span>
                                <a href="/stock" class="btn btn-sm btn-soft-primary py-0 px-2 fw-bold"
                                    style="font-size: 10px;" onclick="restokItem('Ban Luar IRC')">
                                    <i class="feather-plus"></i> Restok
                                </a>
                            </div>
                        </div>

                        <div class="stock-item d-flex justify-content-between align-items-center">
                            <div>
                                <span class="text-dark fw-bold d-block mb-0" style="font-size: 14px;">Busi NGK
                                    Iridium</span>
                                <small class="text-muted" style="font-size: 11px;">Min. Stok: 10 Unit</small>
                            </div>
                            <div class="text-end d-flex flex-column align-items-end gap-1">
                                <span class="badge bg-danger rounded-pill px-3 py-1 fw-bold" style="font-size: 10px;">Sisa
                                    3</span>
                                <button class="btn btn-sm btn-soft-primary py-0 px-2 fw-bold" style="font-size: 10px;"
                                    onclick="restokItem('Busi NGK Iridium')">
                                    <i class="feather-plus"></i> Restok
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <style>
            /* Tambahan style untuk tombol restok agar terlihat halus */
            .btn-soft-primary {
                background-color: rgba(13, 110, 253, 0.1);
                color: #0d6efd;
                border: none;
                transition: all 0.2s;
            }

            .btn-soft-primary:hover {
                background-color: #0d6efd;
                color: white;
            }
        </style>

        <script>
            function restokItem(nama) {
                // Anda bisa mengarahkan ke halaman edit produk atau munculkan modal input stok
                alert('Proses restok untuk: ' + nama);
            }
        </script>
    </div>

    <div class="row mt-4 mb-5">
        <div class="col-lg-12">
            <div class="card border-0 shadow-sm">
                <div class="card-header bg-white border-0 py-4 d-flex justify-content-between align-items-center">
                    <h5 class="mb-0 fw-bold text-dark">Laporan Ringkasan Penjualan</h5>
                    <nav>
                        <div class="nav nav-tabs border-0 bg-light p-1 rounded-3" id="nav-tab" role="tablist">
                            <button class="nav-link border-0 px-4 py-2 fw-semibold active" id="harian-tab"
                                data-bs-toggle="tab" data-bs-target="#harian" type="button"
                                style="font-size: 12px; border-radius: 6px;">Harian</button>
                            <button class="nav-link border-0 px-4 py-2 fw-semibold" id="bulanan-tab" data-bs-toggle="tab"
                                data-bs-target="#bulanan" type="button"
                                style="font-size: 12px; border-radius: 6px;">Bulanan</button>
                        </div>
                    </nav>
                </div>
                <div class="card-body p-0">
                    <div class="tab-content" id="nav-tabContent">
                        <div class="tab-pane fade show active" id="harian">
                            <div class="table-responsive p-4">
                                <table class="table align-middle">
                                    <thead class="bg-light">
                                        <tr class="text-muted fw-bold" style="font-size: 10px; letter-spacing: 1px;">
                                            <th class="ps-3">TANGGAL</th>
                                            <th class="text-center">VOLUME ORDER</th>
                                            <th class="text-center">ITEM TERJUAL</th>
                                            <th class="text-end pe-3">NOMINAL OMSET</th>
                                        </tr>
                                    </thead>
                                    <tbody class="border-top-0">
                                        <tr>
                                            <td class="ps-3 fw-medium">11 Feb 2026</td>
                                            <td class="text-center text-dark">12 Transaksi</td>
                                            <td class="text-center text-dark">24 Produk</td>
                                            <td class="text-end pe-3 fw-bold text-primary">Rp 1.250.000</td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

<style>
    /* TYPOGRAPHY & COLOR SYSTEM */
    body {
        font-family: 'Inter', sans-serif;
        background-color: #f8f9fa;
    }

    .ls-1 {
        letter-spacing: 1px;
    }

    .text-dark {
        color: #2d3436 !important;
    }

    .text-muted {
        color: #636e72 !important;
    }

    /* SOFT BADGES */
    .bg-soft-primary {
        background-color: rgba(13, 110, 253, 0.08);
        color: #0d6efd;
    }

    .bg-soft-success {
        background-color: rgba(25, 135, 84, 0.08);
        color: #198754;
    }

    .bg-soft-danger {
        background-color: rgba(220, 53, 69, 0.08);
        color: #dc3545;
    }

    /* TABS STYLING */
    .nav-tabs .nav-link {
        color: #636e72;
        background: transparent;
        transition: all 0.2s;
    }

    .nav-tabs .nav-link.active {
        background: #fff !important;
        color: #0d6efd !important;
        box-shadow: 0 2px 4px rgba(0, 0, 0, 0.05);
    }

    /* TABLE HOVER */
    .table-hover tbody tr:hover {
        background-color: rgba(248, 249, 250, 1);
    }

    .table thead th {
        border-bottom: none !important;
    }

    /* SCROLLBAR CUSTOM */
    ::-webkit-scrollbar {
        width: 6px;
    }

    ::-webkit-scrollbar-thumb {
        background: #dfe6e9;
        border-radius: 10px;
    }
</style>
