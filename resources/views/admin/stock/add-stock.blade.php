@extends('index')

@section('content')
    <div class="row">
        <div class="col-lg-12">
            <div class="card stretch stretch-full border-0 shadow-sm">
                <div class="card-body p-5">
                    <div class="d-flex justify-content-between align-items-center mb-4">
                        <div>
                            <h5 class="mb-0 fw-bold">Update / Tambah Stok Sparepart</h5>
                            <p class="text-muted small mb-0">Pilih produk yang ingin ditambahkan stoknya secara manual.</p>
                        </div>
                        <a href="/sparepart-list" class="btn btn-light btn-sm">
                            <i class="feather feather-list me-1"></i> Lihat Semua Stok
                        </a>
                    </div>

                    <form action="#" method="POST">
                        @csrf
                        <div class="row">
                            <div class="col-md-8 mb-4">
                                <label class="form-label fw-bold text-dark">Pilih Produk Sparepart</label>
                                <select name="product_id" id="selectProduct" class="form-control" required>
                                    <option value="">-- Cari Nama Produk atau Kode --</option>
                                    <option value="1" data-stok="24" data-kode="BRK-001">Kampas Rem Depan Vario
                                        (BRK-001)</option>
                                    <option value="2" data-stok="5" data-kode="OIL-X1">Oli Mesin MPX2 1L (OIL-X1)
                                    </option>
                                    <option value="3" data-stok="10" data-kode="BS-NGK">Busi NGK Iridium (BS-NGK)
                                    </option>
                                </select>
                                <div class="mt-2" id="productInfo" style="display: none;">
                                    <span class="badge bg-soft-info text-info">Kode: <span id="infoKode">-</span></span>
                                    <span class="badge bg-soft-success text-success ms-1">Stok Saat Ini: <span
                                            id="infoStok">0</span> Unit</span>
                                </div>
                            </div>

                            <div class="col-md-4 mb-4">
                                <label class="form-label fw-bold text-dark">Jumlah Stok Masuk</label>
                                <div class="input-group">
                                    <input type="number" name="jumlah_stok"
                                        class="form-control form-control-lg border-end-0" placeholder="0" required
                                        min="1">
                                    <span class="input-group-text bg-white border-start-0 text-muted fw-bold">Unit</span>
                                </div>
                            </div>
                        </div>

                        <div class="mb-4">
                            <label class="form-label fw-bold text-dark">Catatan / Keterangan (Opsional)</label>
                            <textarea name="catatan" class="form-control" rows="2" placeholder="Contoh: Stok masuk dari Supplier Jaya Motor"></textarea>
                        </div>

                        <hr class="my-4 border-light">

                        <div class="d-flex justify-content-end gap-2">
                            <a href="javascript:history.back()" class="btn btn-light px-4">Batal</a>
                            <button type="submit" class="btn btn-primary px-4 fw-bold shadow-sm">
                                <i class="feather feather-check-circle me-1"></i> Simpan Update Stok
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const selectEl = document.getElementById('selectProduct');
            const infoDiv = document.getElementById('productInfo');
            const infoKode = document.getElementById('infoKode');
            const infoStok = document.getElementById('infoStok');

            selectEl.addEventListener('change', function() {
                const selectedOption = this.options[this.selectedIndex];

                if (this.value !== "") {
                    // Ambil data dari atribut data-stok dan data-kode
                    const kode = selectedOption.getAttribute('data-kode');
                    const stok = selectedOption.getAttribute('data-stok');

                    infoKode.innerText = kode;
                    infoStok.innerText = stok;
                    infoDiv.style.display = 'block';
                } else {
                    infoDiv.style.display = 'none';
                }
            });
        });
    </script>

    <style>
        /* Style agar tampilan input group terlihat lebih clean */
        .form-control-lg {
            font-size: 1rem;
            padding: 0.75rem 1rem;
        }

        .input-group-text {
            padding-right: 1.25rem;
        }

        .bg-soft-info {
            background-color: rgba(13, 202, 240, 0.1);
            color: #0dcaf0;
        }

        .bg-soft-success {
            background-color: rgba(25, 135, 84, 0.1);
            color: #198754;
        }
    </style>
@endsection
