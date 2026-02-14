@extends('index')

@section('content')
    @if (session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <i class="mdi mdi-check-all me-2"></i>
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    <div class="row">
        <div class="col-lg-12">
            <div class="card stretch stretch-full">
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <div class="dataTables_wrapper dt-bootstrap5 no-footer">

                            <div class="row p-4 pb-0">
                                <div class="col-sm-12 col-md-6">
                                    <h5 class="mb-0">Daftar Stok Sparepart</h5>
                                </div>
                                <div class="col-sm-12 col-md-6 d-flex justify-content-end">
                                    <a href="{{ route('admin.products.create') }}"
                                        class="btn btn-primary btn-sm mb-3 text-white">
                                        <i class="feather feather-plus me-1"></i> Tambah Sparepart
                                    </a>
                                </div>
                            </div>

                            <div class="row dt-row">
                                <div class="col-sm-12">
                                    <table class="table table-hover dataTable no-footer">
                                        <thead>
                                            <tr>
                                                <th style="width: 120px;">Kode</th>
                                                <th>Nama Sparepart</th>
                                                <th>Kategori</th>
                                                <th>Harga</th>
                                                <th class="text-start" style="width: 100px;">Aksi</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($products as $product)
                                                <tr>
                                                    <td>
                                                        <span class="badge bg-soft-primary text-primary">
                                                            {{ $product->code }}
                                                        </span>
                                                    </td>
                                                    <td class="fw-bold">{{ $product->name }}</td>
                                                    <td>
                                                        <span class="text-muted">
                                                            {{ $product->category }}
                                                        </span>
                                                    </td>
                                                    <td>
                                                        Rp {{ number_format($product->price, 0, ',', '.') }}
                                                    </td>
                                                    <td>
                                                        <div class="hstack gap-2 justify-content-start">

                                                            <a href="{{ route('admin.products.edit', $product->id) }}"
                                                                class="avatar-text avatar-md" title="Edit">
                                                                <i class="feather feather-edit"></i>
                                                            </a>

                                                            <form
                                                                action="{{ route('admin.products.destroy', $product->id) }}"
                                                                method="POST">
                                                                @csrf
                                                                @method('DELETE')
                                                                <button type="submit"
                                                                    class="avatar-text avatar-md text-danger border-0 bg-transparent"
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
