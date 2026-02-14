@extends('index')

@section('content')
    <div class="container-fluid">
        <div class="row">

            {{-- ================= LEFT : LIST PRODUK ================= --}}
            <div class="col-lg-8">
                <div class="card border-0 shadow-sm">
                    <div class="card-header bg-white py-3">
                        <h5 class="mb-0 fw-bold">Daftar Belanja Anda</h5>
                    </div>

                    <div class="card-body p-0">
                        <div class="table-responsive">
                            <table class="table table-hover align-middle mb-0">
                                <thead class="table-light">
                                    <tr>
                                        <th class="ps-4">Sparepart</th>
                                        <th>Harga</th>
                                        <th width="140">Qty</th>
                                        <th class="text-end pe-4">Subtotal</th>
                                    </tr>
                                </thead>
                                <tbody>

                                    @php $total = 0; @endphp

                                    @forelse($cart as $id => $item)
                                        @php
                                            $subtotal = $item['price'] * $item['qty'];
                                            $total += $subtotal;
                                        @endphp

                                        <tr>
                                            <td class="ps-4">
                                                <div class="fw-bold">{{ $item['name'] }}</div>
                                            </td>

                                            <td>
                                                Rp {{ number_format($item['price'], 0, ',', '.') }}
                                            </td>

                                            <td>
                                                {{-- Update Qty Form --}}
                                                <form action="{{ route('customer.cart.update', $id) }}" method="POST"
                                                    class="d-flex align-items-center gap-1">
                                                    @csrf

                                                    {{-- Tombol Minus (Diubah ke Button Biasa + JS) --}}
                                                    <button type="button"
                                                        class="btn btn-sm btn-outline-secondary"
                                                        onclick="updateQuantity('{{ $id }}', -1)"
                                                        {{ $item['qty'] <= 1 ? 'disabled' : '' }}>
                                                        -
                                                    </button>

                                                    {{-- Input Qty --}}
                                                    <input type="number" name="qty" id="qty-input-{{ $id }}"
                                                        value="{{ $item['qty'] }}"
                                                        min="1" class="form-control form-control-sm text-center"
                                                        style="width:60px" onchange="this.form.submit()">

                                                    {{-- Tombol Plus --}}
                                                    <button type="button"
                                                        class="btn btn-sm btn-outline-secondary"
                                                        onclick="updateQuantity('{{ $id }}', 1)">
                                                        +
                                                    </button>
                                                </form>
                                            </td>

                                            <td class="text-end pe-4">
                                                <div class="d-flex justify-content-end align-items-center">
                                                    <span class="fw-bold me-3">Rp {{ number_format($subtotal, 0, ',', '.') }}</span>

                                                    {{-- Tombol Hapus Satuan --}}
                                                    <form action="{{ route('customer.cart.remove', $id) }}" method="POST" class="d-inline">
                                                        @csrf
                                                        <button class="btn btn-sm text-danger border-0 p-0">
                                                            <i class="feather feather-x"></i> Hapus
                                                        </button>
                                                    </form>
                                                </div>
                                            </td>
                                        </tr>

                                    @empty
                                        <tr>
                                            <td colspan="4" class="text-center p-4">
                                                Keranjang masih kosong
                                            </td>
                                        </tr>
                                    @endforelse

                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>


            {{-- ================= RIGHT : CHECKOUT ================= --}}
            <div class="col-lg-4">

                <div class="card border-0 shadow-sm">
                    <div class="card-header bg-white py-3">
                        <h5 class="mb-0 fw-bold">Ringkasan Transaksi</h5>
                    </div>

                    <div class="card-body">

                        <div class="d-flex justify-content-between mb-2">
                            <span>Total Belanja</span>
                            <span class="fw-bold">
                                Rp {{ number_format($total, 0, ',', '.') }}
                            </span>
                        </div>

                        <hr>

                        <div class="d-flex justify-content-between mb-4">
                            <span class="h5 fw-bold">Grand Total</span>
                            <span class="h5 fw-bold text-primary">
                                Rp {{ number_format($total, 0, ',', '.') }}
                            </span>
                        </div>

                        <form action="{{ route('customer.checkout') }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            <div class="mb-3">
                                <label class="form-label fw-bold small">
                                    Upload Bukti Transfer
                                </label>
                                <input type="file" name="payment_proof" class="form-control" required>
                            </div>

                            <div class="d-grid gap-2">
                                <button type="submit" class="btn btn-primary btn-lg shadow-sm" {{ $total == 0 ? 'disabled' : '' }}>
                                    Bayar Sekarang
                                </button>

                                {{-- TOMBOL BATAL ORDER DI SINI --}}
                                {{-- <a href="{{ route('customer.cart') }}" class="btn btn-outline-danger btn-sm border-0 mt-1"
                                   onclick="return confirm('Apakah Anda yakin ingin membatalkan order ini?')">
                                    <i class="feather feather-trash-2"></i> Batal Order & Kosongkan
                                </a> --}}
                            </div>
                        </form>

                    </div>
                </div>

            </div>

        </div>
    </div>

    {{-- SCRIPT AGAR TOMBOL PLUS MINUS BEKERJA --}}
    <script>
        function updateQuantity(id, change) {
            const input = document.getElementById('qty-input-' + id);
            let currentVal = parseInt(input.value);
            let newVal = currentVal + change;

            if(newVal >= 1) {
                input.value = newVal;
                input.form.submit(); // Otomatis kirim form setelah nilai berubah
            }
        }
    </script>
@endsection
