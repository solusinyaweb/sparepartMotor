@extends('index')
@section('content')
@if (session('success'))
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        <i class="mdi mdi-check-all me-2"></i>
        {{ session('success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
@endif
    <div class="row">
        <div class="col-lg-12">
            <div class="card stretch stretch-full">
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <div id="paymentList_wrapper" class="dataTables_wrapper dt-bootstrap5 no-footer">
                            <div class="row">

                                <div class="d-flex justify-content-end mb-3">
                                    <a href="{{ route('admin.customers.create') }}" class="btn btn-primary text-white">
                                        <i class="feather feather-plus me-1"></i> Tambah Data
                                    </a>
                                </div>

                            </div>
                            <div class="row dt-row">
                                <div class="col-sm-12">
                                    <table class="table table-hover dataTable no-footer" id="paymentList">
                                        <thead>
                                            <tr>
                                                <th>Nama Pelanggan</th>
                                                <th class="text-start">Email</th>
                                                <th class="text-start">Alamat</th>
                                                <th class="text-start">No Telepon</th>
                                                <th class="text-start">Aksi</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($customers as $customer)
                                                <tr class="single-item odd">
                                                    <td>{{ $customer->name }}</td>
                                                    <td>{{ $customer->email }}</td>
                                                    <td>{{ $customer->address }}</td>
                                                    <td>{{ $customer->phone }}</td>

                                                    <td>
                                                        <div class="hstack gap-2 justify-content-start">

                                                            <a href="{{ route('admin.customers.edit', $customer->id) }}"
                                                                class="avatar-text avatar-md">
                                                                <i class="feather feather-edit"></i>
                                                            </a>

                                                            <form action="{{ route('admin.customers.destroy', $customer->id) }}"
                                                                method="POST">
                                                                @csrf
                                                                @method('DELETE')
                                                                <button type="submit"
                                                                    class="avatar-text avatar-md border-0 bg-transparent"
                                                                    onclick="return confirm('Yakin ingin menghapus data ini?')">
                                                                    <i class="feather feather-trash-2"></i>
                                                                </button>
                                                            </form>

                                                        </div>
                                                    </td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
