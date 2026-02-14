@extends('index')

@section('content')
<div class="row">
    <div class="col-lg-12">
        <div class="card stretch stretch-full">
            <div class="card-body">

                <div class="mb-4">
                    <h5 class="mb-0">Ubah Data Pelanggan</h5>
                </div>

                <form action="{{ route('admin.customers.update', $customer->id) }}" method="POST">
                    @csrf
                    @method('PUT')

                    <div class="mb-3">
                        <label class="form-label">Nama Pelanggan</label>
                        <input type="text" name="name" class="form-control"
                            value="{{ old('name', $customer->name) }}"
                            placeholder="Masukkan nama pelanggan">
                    </div>

                    <div class="mb-3">
                            <label class="form-label">Email Pelanggan</label>
                            <input type="email" name="email" class="form-control" value="{{ old('email', $customer->email) }}"
                                placeholder="Masukkan email pelanggan" required>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Password Pelanggan</label>
                            <input type="password" name="password" class="form-control"
                                placeholder="Masukkan password pelanggan" required>
                        </div>

                    <div class="mb-3">
                        <label class="form-label">Alamat</label>
                        <textarea name="address" class="form-control" rows="3"
                            placeholder="Masukkan alamat">{{ old('address', $customer->address) }}</textarea>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">No Telepon</label>
                        <input type="number" name="phone" class="form-control"
                            value="{{ old('phone', $customer->phone) }}"
                            placeholder="Masukkan no telepon">
                    </div>

                    <div class="d-flex justify-content-end gap-2">
                        <a href="{{ route('admin.customers.index') }}" class="btn btn-light">
                            Batal
                        </a>
                        <button type="submit" class="btn btn-primary">
                            Simpan
                        </button>
                    </div>

                </form>

            </div>
        </div>
    </div>
</div>
@endsection
