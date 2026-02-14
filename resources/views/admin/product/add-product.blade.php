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
                </div>

                <form action="{{ route('admin.products.store') }}" method="POST">
                    @csrf

                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Kode Sparepart</label>
                            <input type="text" name="code" class="form-control"
                                value="{{ old('code') }}"
                                placeholder="Contoh: BRK-001">
                        </div>

                        <div class="col-md-6 mb-3">
                            <label class="form-label">Kategori</label>
                            <input type="text" name="category" class="form-control"
                                value="{{ old('category') }}"
                                placeholder="Masukkan kategori">
                        </div>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Nama Sparepart</label>
                        <input type="text" name="name" class="form-control"
                            value="{{ old('name') }}"
                            placeholder="Masukkan nama sparepart">
                    </div>

                    <div class="row">
                        <div class="col-md-12 mb-3">
                            <label class="form-label">Harga (Rp)</label>
                            <div class="input-group">
                                <span class="input-group-text">Rp</span>
                                <input type="number" name="price" class="form-control"
                                    value="{{ old('price') }}"
                                    placeholder="0">
                            </div>
                        </div>
                    </div>

                    <hr class="my-4">

                    <div class="d-flex justify-content-end gap-2">
                        <a href="{{ route('admin.products.index') }}" class="btn btn-light">Batal</a>
                        <button type="submit" class="btn btn-primary">Simpan Data Barang</button>
                    </div>

                </form>
            </div>
        </div>
    </div>
</div>
@endsection
