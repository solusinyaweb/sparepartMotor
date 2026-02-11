@extends('index')

@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-8">
                <div class="card border-0 shadow-sm">
                    <div class="card-header bg-white py-3">
                        <h5 class="mb-0 fw-bold">Daftar Belanja Anda</h5>
                    </div>
                    <div class="card-body p-0">
                        <div class="table-responsive">
                            <table class="table table-hover align-middle mb-0">
                                <thead class="table-light">
                                    <tr>
                                        <th class="ps-4">Sparepart</th>
                                        <th>Harga</th>
                                        <th style="width: 150px;">Qty</th>
                                        <th class="text-end pe-4">Subtotal</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr class="produk-row" data-harga="45000">
                                        <td class="ps-4">
                                            <div class="fw-bold">Kampas Rem Honda Vario</div>
                                            <small class="text-muted">BRK-001</small>
                                        </td>
                                        <td>Rp 45.000</td>
                                        <td>
                                            <div class="input-group input-group-sm border rounded">
                                                <button class="btn btn-link text-decoration-none btn-min fw-bold"
                                                    type="button">-</button>
                                                <input type="text"
                                                    class="form-control border-0 text-center qty-input bg-transparent"
                                                    value="1" readonly>
                                                <button class="btn btn-link text-decoration-none btn-plus fw-bold"
                                                    type="button">+</button>
                                            </div>
                                        </td>
                                        <td class="text-end pe-4 fw-bold subtotal-text">Rp 45.000</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-lg-4">
                <div class="card border-0 shadow-sm">
                    <div class="card-header bg-white py-3">
                        <h5 class="mb-0 fw-bold">Ringkasan Transaksi</h5>
                    </div>
                    <div class="card-body">
                        <div class="d-flex justify-content-between mb-2">
                            <span>Total Belanja</span>
                            <span id="totalBelanja" class="fw-bold">Rp 45.000</span>
                        </div>
                        <hr>
                        <div class="d-flex justify-content-between mb-4">
                            <span class="h5 fw-bold">Grand Total</span>
                            <span id="grandTotal" class="h5 fw-bold text-primary">Rp 45.000</span>
                        </div>
                        <div class="d-grid gap-2">
                            <button class="btn btn-primary btn-lg" type="button" onclick="bukaModalKonfirmasi()">
                                Setuju & Bayar Sekarang
                            </button>
                            <button class="btn btn-outline-danger" type="button" onclick="batalkanTransaksi()">
                                Batalkan
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="modalUpload" tabindex="-1" aria-hidden="true" data-bs-backdrop="static">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content shadow-lg border-0">
                <div class="modal-header">
                    <h5 class="modal-title fw-bold">Konfirmasi Pembayaran</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="p-3 bg-light rounded mb-3">
                        <p class="small mb-1">Transfer ke Rekening:</p>
                        <h6 class="fw-bold mb-0">BCA 123456789 A/N LYORA</h6>
                    </div>
                    <div class="mb-3">
                        <label class="form-label small fw-bold">Upload Bukti Transfer</label>
                        <input type="file" id="inputBukti" class="form-control" accept="image/*">
                    </div>
                    <div id="previewArea" class="text-center d-none border rounded p-2">
                        <img src="" id="imgPreview" style="max-height: 200px; width: auto;"
                            class="img-fluid rounded">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-light px-4" data-bs-dismiss="modal">Batal</button>
                    <button type="button" id="btnKirimBukti" class="btn btn-primary px-4" disabled
                        onclick="prosesKirim()">Kirim & Konfirmasi</button>
                </div>
            </div>
        </div>
    </div>

    <script>
        // 1. PINDAHKAN MODAL KE BODY (Solusi Masalah Blur/Gelap)
        document.addEventListener('DOMContentLoaded', function() {
            const modalElement = document.getElementById('modalUpload');
            if (modalElement) {
                document.body.appendChild(modalElement);
            }

            // --- Logika Update Harga ---
            const rows = document.querySelectorAll('.produk-row');

            function updateSemuaHarga() {
                let total = 0;
                document.querySelectorAll('.produk-row').forEach(row => {
                    const harga = parseInt(row.dataset.harga);
                    const qty = parseInt(row.querySelector('.qty-input').value);
                    const subtotal = harga * qty;
                    row.querySelector('.subtotal-text').innerText = 'Rp ' + subtotal.toLocaleString(
                    'id-ID');
                    total += subtotal;
                });
                document.getElementById('totalBelanja').innerText = 'Rp ' + total.toLocaleString('id-ID');
                document.getElementById('grandTotal').innerText = 'Rp ' + total.toLocaleString('id-ID');
            }

            rows.forEach(row => {
                const plus = row.querySelector('.btn-plus');
                const min = row.querySelector('.btn-min');
                const input = row.querySelector('.qty-input');

                plus.addEventListener('click', () => {
                    input.value = parseInt(input.value) + 1;
                    updateSemuaHarga();
                });

                min.addEventListener('click', () => {
                    if (parseInt(input.value) > 1) {
                        input.value = parseInt(input.value) - 1;
                        updateSemuaHarga();
                    }
                });
            });

            // --- Logika Preview Gambar ---
            const inputBukti = document.getElementById('inputBukti');
            inputBukti.addEventListener('change', function() {
                if (this.files && this.files[0]) {
                    const reader = new FileReader();
                    reader.onload = function(e) {
                        document.getElementById('imgPreview').src = e.target.result;
                        document.getElementById('previewArea').classList.remove('d-none');
                        document.getElementById('btnKirimBukti').disabled = false;
                    }
                    reader.readAsDataURL(this.files[0]);
                }
            });
        });

        // 2. FUNGSI PEMANGGIL MODAL
        function bukaModalKonfirmasi() {
            const modalElement = document.getElementById('modalUpload');
            const instance = bootstrap.Modal.getOrCreateInstance(modalElement);
            instance.show();
        }

        function prosesKirim() {
            let btn = document.getElementById('btnKirimBukti');
            btn.innerHTML = '<span class="spinner-border spinner-border-sm me-2"></span>Mengirim...';
            btn.disabled = true;
            setTimeout(() => {
                alert('Bukti pembayaran berhasil dikirim!');
                location.reload();
            }, 2000);
        }

        function batalkanTransaksi() {
            if (confirm('Yakin batalkan transaksi?')) window.location.href = '/katalog';
        }
    </script>

    <style>
        /* Hindari penggunaan z-index manual yang berlebihan */
        .btn-link {
            color: #0d6efd;
            font-size: 1.2rem;
            line-height: 1;
        }

        .btn-link:hover {
            color: #0a58ca;
        }

        .qty-input:focus {
            box-shadow: none;
        }
    </style>
@endsection
