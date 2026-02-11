@extends('index')
@section('content')
    <div class="row">
        <div class="col-lg-12">
            <div class="card stretch stretch-full">
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <div id="paymentList_wrapper" class="dataTables_wrapper dt-bootstrap5 no-footer">
                            <div class="row">

    <div class="d-flex justify-content-end mb-3">
    <a href="/add-account" class="btn btn-primary text-white">
       <i class="feather feather-plus me-1"></i> Tambah Data
    </a>
</div>



                            </div>
                            <div class="row dt-row">
                                <div class="col-sm-12">
                                    <table class="table table-hover dataTable no-footer" id="paymentList"
                                        aria-describedby="paymentList_info">
                                        <thead>
                                            <tr>

                                                <th class="sorting" tabindex="0" aria-controls="paymentList"
                                                    rowspan="1" colspan="1"
                                                    aria-label="Invoice: activate to sort column ascending"
                                                    style="width: 61.0312px;">Nama Pelanggan</th>

                                                <th class="text-start sorting" tabindex="0" aria-controls="paymentList"
                                                    rowspan="1" colspan="1"
                                                    aria-label="Actions: activate to sort column ascending"
                                                    style="width: 95.1094px;">Alamat</th>
                                                <th class="text-start sorting" tabindex="0" aria-controls="paymentList"
                                                    rowspan="1" colspan="1"
                                                    aria-label="Actions: activate to sort column ascending"
                                                    style="width: 95.1094px;">No Telepon</th>
                                                <th class="text-start sorting" tabindex="0" aria-controls="paymentList"
                                                    rowspan="1" colspan="1"
                                                    aria-label="Actions: activate to sort column ascending"
                                                    style="width: 95.1094px;">Aksi</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr class="single-item odd">

                                                <td>321456</td>
                                                <td>321456</td>
                                                <td>321456</td>


                                                <td>
                                                    <div class="hstack gap-2 justify-content-start">

                                                        <a href="/edit-account" class="avatar-text avatar-md">
                                                            <i class="feather feather-edit"></i>
                                                        </a>
                                                        <a href="javascript:void(0);" class="avatar-text avatar-md">
                                                            <i class="feather feather-trash-2"></i>
                                                        </a>
                                                    </div>
                                                </td>
                                            </tr>

                                        </tbody>
                                    </table>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-sm-12 col-md-5">
                                    <div class="dataTables_info" id="paymentList_info" role="status"
                                        aria-live="polite">Showing 1 to 10 of 10 entries</div>
                                </div>
                                <div class="col-sm-12 col-md-7">
                                    <div class="dataTables_paginate paging_simple_numbers" id="paymentList_paginate">
                                        <ul class="pagination">
                                            <li class="paginate_button page-item previous disabled"
                                                id="paymentList_previous"><a href="#" aria-controls="paymentList"
                                                    data-dt-idx="previous" tabindex="0" class="page-link">Previous</a>
                                            </li>
                                            <li class="paginate_button page-item active"><a href="#"
                                                    aria-controls="paymentList" data-dt-idx="0" tabindex="0"
                                                    class="page-link">1</a></li>
                                            <li class="paginate_button page-item next disabled" id="paymentList_next"><a
                                                    href="#" aria-controls="paymentList" data-dt-idx="next"
                                                    tabindex="0" class="page-link">Next</a></li>
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
