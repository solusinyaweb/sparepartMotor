@extends('index')

@section('content')
    <div class="row">
        <div class="col-lg-12">
            <div class="card stretch stretch-full shadow-sm">
                <div class="card-header d-flex justify-content-between align-items-center bg-white py-3">
                    <h5 class="mb-0 fw-bold">Konfirmasi & Validasi Transaksi</h5>
                    <div class="hstack gap-2">
                        <button class="btn btn-light-primary btn-sm fw-bold">Semua</button>
                        <button class="btn btn-light-warning btn-sm fw-bold">Pending</button>
                    </div>
                </div>
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <div id="paymentList_wrapper" class="dataTables_wrapper dt-bootstrap5 no-footer p-3">
                            <table class="table table-hover align-middle dataTable no-footer" id="paymentList">
                                <thead class="table-light">
                                    <tr>
                                        <th class="ps-4">Pelanggan</th>
                                        <th>Detail Belanja</th>
                                        <th>Total Bayar</th>
                                        <th class="text-center">Bukti</th>
                                        <th>Status</th>
                                        <th class="text-end pe-4">Aksi Verifikasi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr class="single-item">
                                        <td class="ps-4">
                                            <div class="hstack gap-3">
                                                <div>
                                                    <span class="fw-bold d-block">Budi Santoso</span>
                                                    <span class="text-muted small">0812-3456-7890</span>
                                                </div>
                                            </div>
                                        </td>
                                        <td>
                                            <span class="badge bg-soft-info text-info">3 Spareparts</span>
                                            <small class="d-block text-muted mt-1 text-truncate" style="max-width: 150px;">Kampas Rem, Oli Motul...</small>
                                        </td>
                                        <td><span class="fw-bold">Rp 315.000</span></td>
                                        <td class="text-center">
                                            <div class="hstack gap-1 justify-content-center">
                                                <button class="btn btn-icon btn-sm btn-soft-secondary" onclick="viewImage('assets/images/bukti-transfer.jpg')" title="Lihat Bukti">
                                                    <i class="feather-eye"></i>
                                                </button>
                                                <a href="assets/images/bukti-transfer.jpg" download class="btn btn-icon btn-sm btn-soft-primary" title="Download Bukti">
                                                    <i class="feather-download"></i>
                                                </a>
                                            </div>
                                        </td>
                                        <td>
                                            <span class="badge bg-warning">Menunggu Validasi</span>
                                        </td>
                                        <td class="text-end pe-4">
                                            <div class="hstack gap-2 justify-content-end">
                                                <button onclick="confirmTransaction('terima', 'Budi Santoso')" class="btn btn-success btn-sm px-3">
                                                    Terima
                                                </button>
                                                <button onclick="confirmTransaction('tolak', 'Budi Santoso')" class="btn btn-outline-danger btn-sm px-3">
                                                    Tolak
                                                </button>
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

    <div class="modal fade" id="modalViewBukti" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content border-0 shadow-lg">
                <div class="modal-header">
                    <h5 class="modal-title fw-bold">Bukti Pembayaran</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body text-center bg-light">
                    <img id="imgPreview" src="" class="img-fluid rounded border shadow-sm" style="max-height: 500px; width: auto;">
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                </div>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // SOLUSI BLUR: Pindahkan modal ke body
            const modalView = document.getElementById('modalViewBukti');
            if (modalView) {
                document.body.appendChild(modalView);
            }
        });

        function viewImage(url) {
            const modalElement = document.getElementById('modalViewBukti');
            document.getElementById('imgPreview').src = url;
            const instance = bootstrap.Modal.getOrCreateInstance(modalElement);
            instance.show();
        }

        function confirmTransaction(tipe, nama) {
            let config = {
                terima: { text: `Validasi transaksi ${nama}?`, action: 'Diterima' },
                tolak: { text: `Tolak transaksi ${nama}?`, action: 'Ditolak' }
            };

            if (confirm(config[tipe].text)) {
                alert(`Status: Transaksi ${config[tipe].action}`);
                location.reload();
            }
        }
    </script>

    <style>
        /* Styling khusus tombol icon agar berbentuk bulat/persegi rapi */
        .btn-icon {
            width: 32px;
            height: 32px;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 0;
        }
        .btn-soft-secondary {
            background-color: #f1f2f4;
            color: #495057;
            border: none;
        }
        .btn-soft-secondary:hover { background-color: #e2e6ea; }

        .btn-soft-primary {
            background-color: rgba(13, 110, 253, 0.1);
            color: #0d6efd;
            border: none;
        }
        .btn-soft-primary:hover { background-color: rgba(13, 110, 253, 0.2); }
    </style>
@endsection
