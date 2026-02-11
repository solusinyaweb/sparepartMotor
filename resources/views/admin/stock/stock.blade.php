@extends('index')

@section('content')
    <div class="container-fluid py-4" id="main-content-area">
        <div class="row">
            <div class="col-lg-12">
                <div class="card border-0 shadow-sm mb-4">
                    <div class="card-header bg-white py-4 border-0">
                        <div class="d-flex justify-content-between align-items-center">
                            <div class="ms">
                                <h5 class="mb-0 fw-bold text-dark">Manajemen Stok Sparepart</h5>
                                <p class="text-muted small mb-0">Kelola ketersediaan produk dan update stok secara berkala
                                </p>
                            </div>

                        </div>
                        <div class="ms-auto">
                                <a href="/add-stock"
                                    class="btn btn-primary px-4 py-2 fw-bold shadow-sm d-flex align-items-center">
                                    <i class="feather feather-plus me-2"></i> TAMBAH STOK BARU
                                </a>
                            </div>
                    </div>

                    <div class="card-body p-0">
                        <div class="table-responsive">
                            <table class="table table-hover align-middle mb-0 custom-table">
                                <thead>
                                    <tr class="bg-light text-muted text-uppercase fw-bold"
                                        style="font-size: 11px; letter-spacing: 1px;">
                                        <th class="ps-4 border-0">KODE</th>
                                        <th class="border-0">NAMA PRODUK</th>
                                        <th class="border-0">KATEGORI</th>
                                        <th class="border-0">HARGA</th>
                                        <th class="border-0 text-center">STOK</th>
                                        <th class="border-0 text-end pe-4">AKSI</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td class="ps-4"><span class="badge bg-soft-primary text-primary">BRK-001</span>
                                        </td>
                                        <td>
                                            <span class="fw-bold text-dark d-block">Kampas Rem Depan Vario</span>
                                            <small class="text-muted">Honda Genuine Part</small>
                                        </td>
                                        <td>Pengereman</td>
                                        <td class="fw-bold">Rp 85.000</td>
                                        <td class="text-center">
                                            <span class="badge rounded-pill bg-soft-success text-success px-3 py-2">24
                                                Unit</span>
                                        </td>
                                        <td class="text-end pe-4">
                                            <div class="hstack gap-2 justify-content-end">
                                                <button class="btn btn-icon btn-soft-info"
                                                    onclick="openModalRestock('BRK-001', 'Kampas Rem Depan Vario')" title="Re-Stock">
                                                    <i class="feather feather-plus-circle"></i>
                                                </button>
                                                <button class="btn btn-icon btn-soft-primary"
                                                    onclick="openModalHistory('BRK-001', 'Kampas Rem Depan Vario')" title="Riwayat Stok">
                                                    <i class="feather feather-clock"></i>
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

    <div class="modal fade" id="modalRestock" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content border-0 shadow-lg">
                <div class="modal-header border-0 pt-4 px-4">
                    <h5 class="modal-title fw-bold">Restock Sparepart</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form action="/update-stock" method="POST">
                    @csrf
                    <div class="modal-body px-4">
                        <div class="mb-4 bg-light p-3 rounded-3 border-start border-primary border-4">
                            <label class="d-block text-muted small mb-1 fw-bold text-uppercase">Produk Dipilih</label>
                            <span id="restockProductName" class="fw-bold text-dark fs-6">-</span>
                            <input type="hidden" name="product_code" id="restockProductCode">
                        </div>
                        <div class="mb-3">
                            <label class="form-label fw-bold">Jumlah Stok Masuk</label>
                            <div class="input-group">
                                <span class="input-group-text bg-white"><i class="feather feather-package"></i></span>
                                <input type="number" name="quantity" class="form-control form-control-lg" placeholder="0"
                                    required min="1">
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer border-0 pb-4 px-4">
                        <button type="button" class="btn btn-light px-4" data-bs-dismiss="modal">Batal</button>
                        <button type="submit" class="btn btn-primary px-4 fw-bold">Update Stok</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div class="modal fade" id="modalHistory" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-centered">
            <div class="modal-content border-0 shadow-lg">
                <div class="modal-header border-0 pt-4 px-4">
                    <div>
                        <h5 class="modal-title fw-bold">Riwayat Stok</h5>
                        <small class="text-muted" id="historyProductSub"></small>
                    </div>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body px-4">
                    <div class="table-responsive rounded-3 border">
                        <table class="table table-hover align-middle mb-0">
                            <thead class="bg-light">
                                <tr class="text-muted small fw-bold">
                                    <th class="ps-3 border-0">TANGGAL</th>
                                    <th class="border-0">KETERANGAN</th>
                                    <th class="border-0 text-center">JUMLAH</th>
                                </tr>
                            </thead>
                            <tbody id="historyTableBody"></tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <style>
        body.modal-open #main-content-area {
            filter: none !important;
            transform: none !important;
        }

        .modal-backdrop {
            z-index: 1040 !important;
        }

        .modal {
            z-index: 1050 !important;
        }

        .btn-icon {
            width: 36px;
            height: 36px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            border-radius: 8px;
            border: none;
            transition: 0.2s;
        }

        .btn-icon:hover {
            transform: translateY(-2px);
        }

        .bg-soft-primary {
            background-color: rgba(13, 110, 253, 0.1);
            color: #0d6efd;
        }

        .bg-soft-info {
            background-color: rgba(13, 202, 240, 0.1);
            color: #0dcaf0;
        }

        .btn-soft-info {
            background-color: rgba(13, 202, 240, 0.1);
            color: #0dcaf0;
        }

        .btn-soft-info:hover {
            background-color: #0dcaf0;
            color: #fff;
        }

        .btn-soft-primary {
            background-color: rgba(13, 110, 253, 0.1);
            color: #0d6efd;
        }

        .btn-soft-primary:hover {
            background-color: #0d6efd;
            color: #fff;
        }
    </style>

    <script>
        function openModalRestock(code, name) {
            document.getElementById('restockProductName').innerText = name;
            document.getElementById('restockProductCode').value = code;
            const modalEl = document.getElementById('modalRestock');
            document.body.appendChild(modalEl);
            const myModal = new bootstrap.Modal(modalEl);
            myModal.show();
        }

        function openModalHistory(code, name) {
            document.getElementById('historyProductSub').innerText = name + " (" + code + ")";
            const data = [{
                tgl: '10 Feb 2026',
                ket: 'Restock Masuk',
                qty: '+10'
            }, {
                tgl: '09 Feb 2026',
                ket: 'Penjualan',
                qty: '-2'
            }];
            let html = '';
            data.forEach(item => {
                html +=
                    `<tr><td class="ps-3">${item.tgl}</td><td>${item.ket}</td><td class="text-center fw-bold">${item.qty}</td></tr>`;
            });
            document.getElementById('historyTableBody').innerHTML = html;
            const modalEl = document.getElementById('modalHistory');
            document.body.appendChild(modalEl);
            const myModal = new bootstrap.Modal(modalEl);
            myModal.show();
        }
    </script>
@endsection
