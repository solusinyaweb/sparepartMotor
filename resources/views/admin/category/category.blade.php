@extends('index')

@section('content')
<div class="row">
    <div class="col-lg-12">
        <div class="card stretch stretch-full">
            <div class="card-body">

                <div class="d-flex justify-content-between align-items-center mb-4">
                    <div>
                        <h5 class="mb-0">Daftar Kategori Produk</h5>
                        <p class="text-muted small mb-0">Kelola kategori untuk pengelompokan sparepart Anda.</p>
                    </div>
                    <a href="/add-category" class="btn btn-sm btn-primary">
                        <i class="bi bi-plus-lg me-1"></i> Tambah Kategori Baru
                    </a>
                </div>

                <div class="row mb-3">
                    <div class="col-md-12">
                        <div class="input-group">
                            <span class="input-group-text bg-white"><i class="bi bi-search"></i></span>
                            <input type="text" class="form-control" placeholder="Cari kategori...">
                        </div>
                    </div>
                </div>

                <div class="table-responsive">
                    <table class="table table-hover align-middle">
                        <thead class="table-light">
                            <tr>
                                <th style="width: 50px;">No</th>
                                <th>Nama Kategori</th>
                                {{-- <th>Kode Kategori</th> --}}
                                <th>Jumlah Produk</th>
                                <th class="text-end">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>1</td>
                                <td><span class="fw-bold">Mesin (Engine)</span></td>
                                {{-- <td><span class="badge bg-soft-primary text-primary">ENG</span></td> --}}
                                <td>24 Item</td>
                                <td class="text-end">
                                    <div class="btn-group">
                                        <a href="edit-category" class="btn btn-sm btn-light-brand" title="Edit">
                                            <i class="bi bi-pencil"></i>
                                        </a>
                                        <button class="btn btn-sm btn-light-danger" title="Hapus">
                                            <i class="bi bi-trash"></i>
                                        </button>
                                    </div>
                                </td>
                            </tr>

                        </tbody>
                    </table>
                </div>

                <div class="d-flex justify-content-between align-items-center mt-4">
                    <p class="text-muted small mb-0">Menampilkan 1 sampai 2 dari 2 data</p>
                    <nav>
                        <ul class="pagination pagination-sm mb-0">
                            <li class="page-item disabled"><a class="page-link" href="#">Previous</a></li>
                            <li class="page-item active"><a class="page-link" href="#">1</a></li>
                            <li class="page-item"><a class="page-link" href="#">Next</a></li>
                        </ul>
                    </nav>
                </div>

            </div>
        </div>
    </div>
</div>
@endsection
