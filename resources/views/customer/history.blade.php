@extends('index')

@section('content')
    <div class="row">
        <div class="col-lg-12">
            <div class="card stretch stretch-full shadow-sm">
                <div class="card-header d-flex justify-content-between align-items-center bg-white py-3">
                    <h5 class="mb-0 fw-bold">Riwayat Pesanan Saya</h5>
                </div>
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <div id="orderHistory_wrapper" class="dataTables_wrapper dt-bootstrap5 no-footer p-3">
                            <table class="table table-hover align-middle" id="orderHistory">
                                <thead class="table-light">
                                    <tr>
                                        <th class="ps-4">Tanggal Order</th>
                                        <th>Total Bayar</th>
                                        <th>Status Pembayaran</th>
                                        <th class="text-center">Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td class="ps-4">
                                            <span class="fw-bold d-block">12 Mei 2024</span>
                                            <small class="text-muted">ID Transaksi: #TRX-99281</small>
                                        </td>
                                        <td><span class="fw-bold text-dark">Rp 315.000</span></td>
                                        <td>
                                            <span class="badge bg-success">Approved (Sudah Divalidasi)</span>
                                        </td>
                                        <td class="text-center">
                                            <div class="d-flex justify-content-center gap-2">

                                                <button class="btn btn-primary btn-sm px-3"
                                                    onclick="showDetailOrder('#TRX-99281')" title="Lihat Detail">
                                                    <i class="feather feather-eye"></i>
                                                </button>

                                                <a href="/nota" target="_blank"
                                                    class="btn btn-warning btn-sm px-3 text-white" title="Cetak Nota">
                                                    <i class="feather feather-printer"></i>
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

    <div class="modal fade" id="modalDetailOrder" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content border-0 shadow-lg">
                <div class="modal-header bg-light">
                    <h5 class="modal-title fw-bold">Rincian Barang Yang Dibeli</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <h6 class="small fw-bold text-muted">Order ID: <span id="displayOrderID"
                                class="text-primary"></span></h6>
                    </div>
                    <ul class="list-group list-group-flush border-top border-bottom mb-3" id="itemList">
                        <li class="list-group-item d-flex justify-content-between align-items-center px-0">
                            <div>
                                <span class="fw-bold d-block">Kampas Rem Honda Vario</span>
                                <small class="text-muted">Qty: 1 x Rp 45.000</small>
                            </div>
                            <span class="fw-bold">Rp 45.000</span>
                        </li>
                        <li class="list-group-item d-flex justify-content-between align-items-center px-0">
                            <div>
                                <span class="fw-bold d-block">Oli Mesin Motul Expert</span>
                                <small class="text-muted">Qty: 2 x Rp 135.000</small>
                            </div>
                            <span class="fw-bold">Rp 270.000</span>
                        </li>
                    </ul>
                    <div class="d-flex justify-content-between align-items-center px-0">
                        <span class="h6 fw-bold">Total Harga</span>
                        <span class="h5 fw-bold text-primary" id="totalDetail">Rp 315.000</span>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                </div>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // SOLUSI ANTI-BLUR: Pindahkan modal ke body terluar
            const modalDetail = document.getElementById('modalDetailOrder');
            if (modalDetail) {
                document.body.appendChild(modalDetail);
            }
        });

        function showDetailOrder(orderID) {
            document.getElementById('displayOrderID').innerText = orderID;

            const modalElement = document.getElementById('modalDetailOrder');
            const instance = bootstrap.Modal.getOrCreateInstance(modalElement);
            instance.show();
        }
    </script>

    <style>
        /* Mengatur style tabel agar konsisten */
        #orderHistory thead th {
            font-weight: 600;
            text-transform: uppercase;
            font-size: 11px;
            letter-spacing: 0.5px;
        }

        .badge {
            padding: 6px 12px;
            font-weight: 500;
        }

        /* Pastikan modal tidak terhalang */
        .modal {
            z-index: 1060 !important;
        }

        .modal-backdrop {
            z-index: 1050 !important;
        }
    </style>
@endsection
