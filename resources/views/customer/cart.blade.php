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
                                        <th width="120">Qty</th>
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

                                                <form action="{{ route('customer.cart.update', $id) }}" method="POST"
                                                    class="d-flex align-items-center gap-1">
                                                    @csrf

                                                    {{-- Tombol Minus --}}
                                                    <button type="submit" name="qty" value="{{ $item['qty'] - 1 }}"
                                                        class="btn btn-sm btn-outline-secondary"
                                                        {{ $item['qty'] <= 1 ? 'disabled' : '' }}>
                                                        -
                                                    </button>

                                                    {{-- Input Qty --}}
                                                    <input type="number" name="qty" value="{{ $item['qty'] }}"
                                                        min="1" class="form-control form-control-sm text-center"
                                                        style="width:60px" onchange="this.form.submit()">

                                                    {{-- Tombol Plus --}}
                                                    <button type="submit" name="qty" value="{{ $item['qty'] + 1 }}"
                                                        class="btn btn-sm btn-outline-secondary">
                                                        +
                                                    </button>
                                                </form>

                                            </td>

                                            <td class="text-end pe-4 fw-bold">
                                                Rp {{ number_format($subtotal, 0, ',', '.') }}

                                                {{-- Tombol Hapus --}}
                                                <form action="{{ route('customer.cart.remove', $id) }}" method="POST"
                                                    class="d-inline">
                                                    @csrf
                                                    <button class="btn btn-sm btn-danger ms-2">
                                                        x
                                                    </button>
                                                </form>
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

                <form action="{{ route('customer.checkout') }}" method="POST" enctype="multipart/form-data">
                    @csrf

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

                            <div class="mb-3">
                                <label class="form-label fw-bold small">
                                    Upload Bukti Transfer
                                </label>

                                <input type="file" name="payment_proof" class="form-control" required>
                            </div>

                            <div class="d-grid">
                                <button type="submit" class="btn btn-primary btn-lg">
                                    Bayar Sekarang
                                </button>
                            </div>

                        </div>
                    </div>

                </form>

            </div>

        </div>
    </div>
@endsection
