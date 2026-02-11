@extends('index')

@section('content')
    <div class="row">
        <div class="col-lg-12">
            <div class="card stretch stretch-full">
                <div class="card-body">

                    <div class="d-flex justify-content-between align-items-center mb-4">
                        <div>
                            <h5 class="mb-0">Tambah Data Stok Sparepart</h5>
                            <p class="text-muted small mb-0">Silahkan lengkapi detail informasi sparepart di bawah ini.</p>
                        </div>
                        <button type="button" class="btn btn-outline-primary btn-sm" data-bs-toggle="modal"
                            data-bs-target="#modalTambahKategori">
                            <i class="feather feather-plus me-1"></i> Tambah Kategori
                        </button>
                    </div>

                    <form action="#" method="POST">
                        @csrf
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Kode Sparepart</label>
                                <input type="text" name="kode_sparepart" class="form-control"
                                    placeholder="Contoh: BRK-001">
                            </div>

                            <div class="col-md-6 mb-3">
                                <label class="form-label">Kategori</label>
                                <select name="kategori" class="form-control">
                                    <option value="">-- Pilih Kategori --</option>
                                    <option value="Mesin">Mesin</option>
                                    <option value="Kelistrikan">Kelistrikan</option>
                                    <option value="Body">Body</option>
                                    <option value="Ban">Ban & Roda</option>
                                </select>
                            </div>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Nama Sparepart</label>
                            <input type="text" name="nama_sparepart" class="form-control"
                                placeholder="Masukkan nama sparepart">
                        </div>

                        <div class="row">
                            <div class="col-md-12 mb-3">
                                <label class="form-label">Harga (Rp)</label>
                                <div class="input-group">
                                    <span class="input-group-text">Rp</span>
                                    <input type="number" name="harga" class="form-control" placeholder="0">
                                </div>
                            </div>

                            {{-- <div class="col-md-6 mb-3">
                                <label class="form-label">Stok</label>
                                <input type="number" name="stok" class="form-control"
                                    placeholder="Jumlah stok saat ini">
                            </div> --}}
                        </div>

                        <hr class="my-4">

                        <div class="d-flex justify-content-end gap-2">
                            <a href="javascript:history.back()" class="btn btn-light">Batal</a>
                            <button type="submit" class="btn btn-primary">Simpan Data Barang</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="modalTambahKategori" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header border-bottom-0">
                    <h5 class="modal-title">Tambah Kategori Baru</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label">Nama Kategori</label>
                        <input type="text" class="form-control" placeholder="Masukkan kategori baru">
                    </div>
                    <div class="d-flex justify-content-between align-items-center mt-4">
                        <button type="button" class="btn btn-link btn-sm text-primary p-0 text-decoration-none"
                            onclick="switchModal('#modalTambahKategori', '#modalKelolaKategori')">
                            <i class="feather feather-edit-3 me-1"></i> Ubah/Hapus Kategori
                        </button>
                        <button type="button" class="btn btn-primary">Simpan</button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="modalKelolaKategori" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Daftar Kategori</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body p-0">
                    <div class="table-responsive">
                        <table class="table table-hover mb-0">
                            <thead class="table-light">
                                <tr>
                                    <th class="ps-4">NAMA KATEGORI</th>
                                    <th class="text-center" style="width: 100px;">AKSI</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td class="ps-4">Mesin</td>
                                    <td class="text-center">
                                        <button type="button" class="btn-hapus-kategori"
                                            onclick="confirmDelete(this, 'Mesin')">
                                            <i class="feather feather-trash-2"></i>
                                        </button>
                                    </td>
                                </tr>
                                <tr>
                                    <td class="ps-4">Kelistrikan</td>
                                    <td class="text-center">
                                        <button type="button" class="btn-hapus-kategori"
                                            onclick="confirmDelete(this, 'Kelistrikan')">
                                            <i class="feather feather-trash-2"></i>
                                        </button>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="modal-footer d-flex justify-content-start border-top-0">
                    <button type="button" class="btn btn-light btn-sm"
                        onclick="switchModal('#modalKelolaKategori', '#modalTambahKategori')">
                        <i class="feather feather-arrow-left me-1"></i> Kembali ke Tambah
                    </button>
                </div>
            </div>
        </div>
    </div>

    <style>
        /* 1. Fix Efek Blur Duralux */
        body.modal-open .nxl-container,
        body.modal-open .nxl-content {
            filter: none !important;
        }

        /* 2. Style Tombol Hapus */
        .btn-hapus-kategori {
            width: 32px;
            height: 32px;
            border-radius: 6px;
            border: 1px solid #e2e8f0;
            background-color: #ffffff;
            color: #64748b;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            transition: all 0.2s ease;
        }

        /* 3. Efek Hover Merah */
        .btn-hapus-kategori:hover {
            background-color: #ef4444 !important;
            /* Merah */
            color: #ffffff !important;
            /* Ikon Putih */
            border-color: #ef4444 !important;
            transform: translateY(-2px);
        }
    </style>

    <script>
        // Fungsi pindah modal tanpa error backdrop
        function switchModal(fromId, toId) {
            const fromModalEl = document.querySelector(fromId);
            const toModalEl = document.querySelector(toId);

            const fromModal = bootstrap.Modal.getInstance(fromModalEl);
            fromModal.hide();

            setTimeout(() => {
                const nextModal = new bootstrap.Modal(toModalEl);
                nextModal.show();
            }, 350);
        }

        // Fungsi simulasi hapus
        function confirmDelete(btn, nama) {
            if (confirm('Hapus kategori ' + nama + '?')) {
                const row = btn.closest('tr');
                row.style.opacity = '0';
                setTimeout(() => row.remove(), 300);
            }
        }
    </script>
@endsection
