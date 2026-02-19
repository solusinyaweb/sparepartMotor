@extends('index')

@section('content')
    <div class="container-fluid">
        @if (session('error'))
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <i class="mdi mdi-close-circle me-2"></i>
                {{ session('error') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        @if (session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                <i class="mdi mdi-check-all me-2"></i>
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif
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
                <span class="fw-bold text-dark">
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

            <form action="{{ route('customer.checkout') }}" method="POST" enctype="multipart/form-data" id="checkoutForm">
                @csrf

                <div class="mb-3">
                    <label class="form-label fw-bold small">Pilih Metode Pembayaran</label>
                    <select name="payment_method" id="payment_method" class="form-select" required onchange="handlePaymentChange()">
                        <option value="" selected disabled>-- Pilih Metode --</option>
                        <option value="cash">Uang Tunai (Cash)</option>
                        <option value="transfer">Transfer Bank</option>
                    </select>
                </div>

                <div id="transfer_section" style="display: none;" class="mb-3">
                    <label class="form-label fw-bold small text-muted">Upload Bukti Transfer</label>
                    <input type="file" name="payment_proof" id="payment_proof" class="form-control">
                    <div class="form-text small text-info">Format: JPG, PNG, PDF (Maks 2MB)</div>
                </div>

                <div id="cash_section" style="display: none;">
                    <div class="mb-3">
                        <label class="form-label fw-bold small text-muted">Nominal Uang Bayar</label>
                        <div class="input-group">
                            <span class="input-group-text">Rp</span>
                            <input type="number" id="cash_amount" name="cash_amount" class="form-control" placeholder="Contoh: 50000" oninput="calculateChange()">
                        </div>
                    </div>

                    <div class="mb-3 p-3 bg-light border rounded">
                        <div class="d-flex justify-content-between align-items-center">
                            <span class="small fw-bold">Kembalian:</span>
                            <span id="change_display" class="h6 mb-0 fw-bold">Rp 0</span>
                        </div>
                    </div>
                </div>

                <div class="d-grid gap-2 mt-4">
                    <button type="submit" id="btn_submit" class="btn btn-primary btn-lg shadow-sm" {{ $total == 0 ? 'disabled' : '' }}>
                        Proses Pembayaran
                    </button>

                    <a href="{{ route('customer.cart') }}" class="btn btn-link btn-sm text-decoration-none text-muted mt-1">
                        Kembali ke Keranjang
                    </a>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    // Ambil nilai total dari PHP ke JS
    const totalBelanja = {{ $total }};

    function handlePaymentChange() {
        const method = document.getElementById('payment_method').value;
        const transferSection = document.getElementById('transfer_section');
        const cashSection = document.getElementById('cash_section');
        const proofInput = document.getElementById('payment_proof');
        const cashInput = document.getElementById('cash_amount');
        const btnSubmit = document.getElementById('btn_submit');

        // Toggle Tampilan
        if (method === 'transfer') {
            transferSection.style.display = 'block';
            cashSection.style.display = 'none';
            // Set Atribut Required
            proofInput.required = true;
            cashInput.required = false;
            btnSubmit.disabled = false;
        } else if (method === 'cash') {
            transferSection.style.display = 'none';
            cashSection.style.display = 'block';
            // Set Atribut Required
            proofInput.required = false;
            cashInput.required = true;
            calculateChange(); // Validasi ulang tombol
        }
    }

    function calculateChange() {
        const cashValue = parseFloat(document.getElementById('cash_amount').value) || 0;
        const changeDisplay = document.getElementById('change_display');
        const btnSubmit = document.getElementById('btn_submit');

        const selisih = cashValue - totalBelanja;

        if (cashValue === 0) {
            changeDisplay.innerText = "Rp 0";
            changeDisplay.className = "h6 mb-0 fw-bold text-dark";
            btnSubmit.disabled = true;
        } else if (selisih >= 0) {
            // Jika uang cukup atau pas
            changeDisplay.innerText = "Rp " + new Intl.NumberFormat('id-ID').format(selisih);
            changeDisplay.className = "h6 mb-0 fw-bold text-success";
            btnSubmit.disabled = false;
        } else {
            // Jika uang kurang
            changeDisplay.innerText = "Uang Kurang!";
            changeDisplay.className = "h6 mb-0 fw-bold text-danger";
            btnSubmit.disabled = true;
        }
    }
</script>

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
