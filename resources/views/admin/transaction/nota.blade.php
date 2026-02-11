@extends('index')

@section('content')
<div class="row">
    <div class="col-lg-12">
        <div class="card stretch stretch-full shadow-sm">
            <div class="card-header d-flex justify-content-between align-items-center bg-white py-3">
                <h5 class="mb-0 fw-bold">Daftar Nota Penjualan</h5>
                <div class="hstack gap-2">
                    <button class="btn btn-outline-primary btn-sm"><i class="feather-download me-1"></i> Export Excel</button>
                </div>
            </div>
            <div class="card-body p-0">
                <div class="table-responsive">
                    <div id="notaList_wrapper" class="dataTables_wrapper dt-bootstrap5 no-footer p-3">
                        <table class="table table-hover align-middle dataTable no-footer" id="notaList">
                            <thead class="table-light">
                                <tr>
                                    <th class="ps-4">Pelanggan</th>
                                    <th>Tanggal Transaksi</th>
                                    <th>Total Bayar</th>
                                    <th class="text-center">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr class="single-item">
                                    <td class="ps-4">
                                        <div class="hstack gap-3">
                                            <div>
                                                <span class="fw-bold d-block">Budi Santoso</span>
                                                <span class="text-muted small">ID: #TRX-99281</span>
                                            </div>
                                        </div>
                                    </td>
                                    <td>12 Mei 2024</td>
                                    <td><span class="fw-bold text-dark">Rp 315.000</span></td>
                                    <td class="text-center">
                                        <div class="d-flex justify-content-center gap-2">
                                            <button class="btn btn-primary btn-sm px-3"
                                                onclick="showDetailOrder('#TRX-99281', '315.000')"
                                                title="Lihat Detail">
                                                <i class="feather feather-eye me-1"></i> Detail
                                            </button>

                                            <a href="/nota-print/99281" target="_blank"
                                               class="btn btn-warning btn-sm px-3 text-white"
                                               title="Cetak Nota">
                                                <i class="feather feather-printer me-1"></i> Nota
                                            </a>
                                        </div>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="modalDetailNota" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0 shadow-lg">
            <div class="modal-header bg-light">
                <h5 class="modal-title fw-bold text-dark">Detail Pesanan</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="mb-3 border-bottom pb-2">
                    <small class="text-muted d-block">No. Transaksi</small>
                    <span id="displayID" class="fw-bold text-primary"></span>
                </div>
                <div id="itemContainer">
                    <div class="d-flex justify-content-between mb-2">
                        <span>Kampas Rem (1x)</span>
                        <span class="fw-bold">Rp 45.000</span>
                    </div>
                    <div class="d-flex justify-content-between mb-2">
                        <span>Oli Motul (2x)</span>
                        <span class="fw-bold">Rp 270.000</span>
                    </div>
                </div>
                <div class="mt-4 pt-3 border-top d-flex justify-content-between align-items-center">
                    <span class="h6 mb-0 fw-bold">Total Pembayaran</span>
                    <span class="h5 mb-0 fw-bold text-success" id="displayTotal"></span>
                </div>
            </div>
            <div class="modal-footer border-0">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
            </div>
        </div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Fix Modal Blur
        const modal = document.getElementById('modalDetailNota');
        if (modal) document.body.appendChild(modal);
    });

    function showDetailOrder(id, total) {
        document.getElementById('displayID').innerText = id;
        document.getElementById('displayTotal').innerText = 'Rp ' + total;

        const modalElement = document.getElementById('modalDetailNota');
        const instance = bootstrap.Modal.getOrCreateInstance(modalElement);
        instance.show();
    }
</script>

<style>
    /* Styling Button */
    .btn-sm {
        border-radius: 5px;
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .btn-warning {
        background-color: #ffc107;
        border-color: #ffc107;
    }

    .btn-warning:hover {
        background-color: #e0a800;
        border-color: #d39e00;
    }

    /* Pastikan tabel rapi */
    #notaList thead th {
        font-size: 11px;
        text-transform: uppercase;
        letter-spacing: 1px;
        color: #717171;
    }
</style>
@endsection
