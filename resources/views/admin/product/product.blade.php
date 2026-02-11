@extends('index')

@section('content')
    <div class="row">
        <div class="col-lg-12">
            <div class="card stretch stretch-full">
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <div id="sparepartList_wrapper" class="dataTables_wrapper dt-bootstrap5 no-footer">

                            <div class="row p-4 pb-0">
                                <div class="col-sm-12 col-md-6">
                                    <h5 class="mb-0">Daftar Stok Sparepart</h5>
                                </div>
                                <div class="col-sm-12 col-md-6 d-flex justify-content-end">
                                    <a href="/add-product" class="btn btn-primary btn-sm mb-3 text-white">
                                        <i class="feather feather-plus me-1"></i> Tambah Sparepart
                                    </a>
                                </div>
                            </div>

                            <div class="row dt-row">
                                <div class="col-sm-12">
                                    <table class="table table-hover dataTable no-footer" id="sparepartList"
                                        aria-describedby="sparepartList_info">
                                        <thead>
                                            <tr>
                                                <th class="sorting" style="width: 120px;">Kode</th>
                                                <th class="sorting">Nama Sparepart</th>
                                                <th class="sorting">Kategori</th>
                                                <th class="sorting">Harga</th>
                                                <th class="sorting" style="width: 80px;">Stok</th>
                                                <th class="text-start" style="width: 100px;">Aksi</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr class="single-item odd">
                                                <td><span class="badge bg-soft-primary text-primary">BRK-001</span></td>
                                                <td class="fw-bold">Kampas Rem Depan</td>
                                                <td><span class="text-muted">Pengereman</span></td>
                                                <td>Rp 85.000</td>
                                                <td>
                                                    <span class="fw-bold text-success">24</span>
                                                </td>
                                                <td>
                                                    <div class="hstack gap-2 justify-content-start">
                                                        <a href="/edit-product" class="avatar-text avatar-md"
                                                            title="Edit">
                                                            <i class="feather feather-edit"></i>
                                                        </a>
                                                        <a href="javascript:void(0);"
                                                            class="avatar-text avatar-md text-danger" title="Hapus">
                                                            <i class="feather feather-trash-2"></i>
                                                        </a>
                                                    </div>
                                                </td>
                                            </tr>
                                            <tr class="single-item even">
                                                <td><span class="badge bg-soft-primary text-primary">OIL-X1</span></td>
                                                <td class="fw-bold">Oli Mesin 1L</td>
                                                <td><span class="text-muted">Pelumas</span></td>
                                                <td>Rp 65.000</td>
                                                <td>
                                                    <span class="fw-bold text-danger">5</span>
                                                    <i class="feather feather-alert-circle text-danger"
                                                        title="Stok Menipis"></i>
                                                </td>
                                                <td>
                                                    <div class="hstack gap-2 justify-content-start">
                                                        <a href="/edit-sparepart" class="avatar-text avatar-md">
                                                            <i class="feather feather-edit"></i>
                                                        </a>
                                                        <a href="javascript:void(0);"
                                                            class="avatar-text avatar-md text-danger">
                                                            <i class="feather feather-trash-2"></i>
                                                        </a>
                                                    </div>
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>

                            <div class="row p-4">
                                <div class="col-sm-12 col-md-5">
                                    <div class="dataTables_info" id="sparepartList_info" role="status" aria-live="polite">
                                        Menampilkan 1 sampai 2 dari 2 entri
                                    </div>
                                </div>
                                <div class="col-sm-12 col-md-7">
                                    <div class="dataTables_paginate paging_simple_numbers">
                                        <ul class="pagination justify-content-end">
                                            <li class="paginate_button page-item previous disabled"><a href="#"
                                                    class="page-link">Previous</a></li>
                                            <li class="paginate_button page-item active"><a href="#"
                                                    class="page-link">1</a></li>
                                            <li class="paginate_button page-item next disabled"><a href="#"
                                                    class="page-link">Next</a></li>
                                        </ul>
                                    </div>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
