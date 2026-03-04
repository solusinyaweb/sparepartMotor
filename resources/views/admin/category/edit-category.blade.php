@extends('index')

@section('content')
<div class="row">
    <div class="col-lg-12">
        <div class="card stretch stretch-full shadow-sm">
            <div class="card-body">

                <div class="d-flex justify-content-between align-items-center mb-4 border-bottom pb-3">
                    <div>
                        <h5 class="fw-bold mb-1 text-dark">Ubah Data Kategori Produk</h5>
                        <p class="text-muted small mb-0">Silahkan lengkapi detail informasi kategori produk di bawah ini.</p>
                    </div>
                    {{-- <button type="button" class="btn btn-primary btn-sm px-3" data-bs-toggle="modal" data-bs-target="#modalTambahKategori">
                        <i class="bi bi-plus-lg me-1"></i> Tambah Kategori
                    </button> --}}
                </div>

                <form action="#" method="POST">
                    @csrf

                    {{-- <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label fw-semibold text-dark">Kode Sparepart</label>
                            <input type="text" name="code" class="form-control"
                                value="{{ old('code') }}"
                                placeholder="Contoh: BRK-001">
                        </div>

                        <div class="col-md-6 mb-3">
                            <label class="form-label fw-semibold text-dark">Pilih Kategori</label>
                            <select name="category" class="form-select">
                                <option value="" selected disabled>-- Pilih Kategori --</option>
                                <option value="1">Mesin (Engine)</option>
                                <option value="2">Pengereman (Brake System)</option>
                                <option value="3">Kelistrikan (Electrical)</option>
                            </select>
                        </div>
                    </div> --}}

                    <div class="mb-3">
                        <label class="form-label fw-semibold text-dark">Nama Kategori</label>
                        <input type="text" name="name" class="form-control"
                            value="{{ old('name') }}"
                            placeholder="Contoh: Mesin (Engine)">
                    </div>

                    {{-- <div class="row">
                        <div class="col-md-12 mb-3">
                            <label class="form-label fw-semibold text-dark">Harga Jual (Rp)</label>
                            <div class="input-group">
                                <span class="input-group-text bg-light text-muted">Rp</span>
                                <input type="number" name="price" class="form-control"
                                    value="{{ old('price') }}"
                                    placeholder="0">
                            </div>
                        </div>
                    </div> --}}

                    <hr class="my-4 border-dashed">

                    <div class="d-flex justify-content-end gap-2">
                        <a href="#" class="btn btn-light px-4">Batal</a>
                        <button type="submit" class="btn btn-sm btn-primary px-4">
                            <i class="bi bi-save me-1"></i> Simpan Data Kategori
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<div class="modal fade shadow-lg" id="modalTambahKategori" tabindex="-1" aria-labelledby="modalTambahKategoriLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0">
            <div class="modal-header bg-primary text-white">
                <h5 class="modal-title" id="modalTambahKategoriLabel">
                    <i class="bi bi-folder-plus me-2"></i>Tambah Kategori Baru
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>

            <form action="#" id="formTambahKategori">
                <div class="modal-body p-4">
                    <div class="mb-3">
                        <label class="form-label fw-bold">Nama Kategori</label>
                        <input type="text" id="inputNamaKategori" class="form-control form-control-lg"
                            placeholder="Masukkan nama kategori baru..." required>
                        <div class="form-text mt-2">
                            <i class="bi bi-info-circle me-1"></i> Kategori akan langsung muncul di pilihan dropdown setelah disimpan.
                        </div>
                    </div>
                </div>
                <div class="modal-footer border-0 bg-light">
                    <button type="button" class="btn btn-secondary px-4" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary px-4">Simpan Kategori</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
