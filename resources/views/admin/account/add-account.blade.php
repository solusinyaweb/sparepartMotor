@extends('index')

@section('content')
<div class="row">
    <div class="col-lg-12">
        <div class="card stretch stretch-full">
            <div class="card-body">

                <!-- JUDUL -->
                <div class="mb-4">
                    <h5 class="mb-0">Tambah Data Pelanggan</h5>
                </div>

                <!-- FORM -->
                <form action="#" method="POST">
                    {{-- @csrf --}}

                    <div class="mb-3">
                        <label class="form-label">Nama Pelanggan</label>
                        <input type="text" class="form-control" placeholder="Masukkan nama pelanggan">
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Alamat</label>
                        <textarea class="form-control" rows="3" placeholder="Masukkan alamat"></textarea>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">No Telepon</label>
                        <input type="text" class="form-control" placeholder="Masukkan no telepon">
                    </div>

                    <!-- BUTTON -->
                    <div class="d-flex justify-content-end gap-2">
                        <a href="javascript:history.back()" class="btn btn-light">
                            Batal
                        </a>
                        <button type="submit" class="btn btn-primary">
                            Simpan
                        </button>
                    </div>

                </form>
                <!-- END FORM -->

            </div>
        </div>
    </div>
</div>
@endsection
