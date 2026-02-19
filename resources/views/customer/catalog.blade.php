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
            <div class="card stretch stretch-full shadow-sm">
                <div class="card-header d-flex justify-content-between align-items-center bg-white py-3">
                    <h5 class="mb-0 fw-bold">Katalog Sparepart</h5>
                    <a href="{{ route('customer.cart') }}" class="btn btn-warning position-relative shadow-sm">
                        <i class="feather feather-shopping-cart me-2"></i> Keranjang
                        <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger shadow"
                            id="cart-count">
                            {{-- Cek session cart, jika tidak ada tampilkan 0 --}}
                            @php
                                $cart = session('cart', []);
                                $initialCount = is_array($cart) ? count($cart) : 0;
                            @endphp
                            {{ $initialCount }}
                        </span>
                    </a>
                </div>

                <div class="card-body p-0">
                    <div class="table-responsive">
                        <div id="productList_wrapper" class="dataTables_wrapper dt-bootstrap5 no-footer p-3">
                            <table class="table table-hover align-middle" id="productList">
                                <thead class="table-light">
                                    <tr>
                                        <th>Kode</th>
                                        <th>Nama Sparepart</th>
                                        <th>Harga</th>
                                        <th>Stok Tersedia</th>
                                        <th class="text-center">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($products as $product)
                                        <tr>
                                            <td class="fw-bold">{{ $product->code }}</td>
                                            <td>{{ $product->name }}</td>
                                            <td><strong>Rp {{ number_format($product->price, 0, ',', '.') }}</strong></td>
                                            {{-- <td>{{ $product->stocks->sum('quantity') }}</td> --}}
                                            <td>{{ $product->total_stock }}</td>
                                            <td class="text-center">
                                                {{-- Mengirim ID dan Nama Produk ke JavaScript --}}
                                                <button onclick="addToCart({{ $product->id }}, '{{ $product->name }}')"
                                                    class="btn btn-primary btn-sm btn-tambah-keranjang px-3">
                                                    + Keranjang
                                                </button>
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

    {{-- NOTIFIKASI TOAST --}}
    <div class="toast-container position-fixed bottom-0 end-0 p-3" style="z-index: 1060;">
        <div id="cartToast" class="toast align-items-center text-white bg-success border-0 shadow-lg" role="alert"
            aria-live="assertive" aria-atomic="true">
            <div class="d-flex">
                <div class="toast-body">
                    <i class="feather feather-check-circle me-2"></i>
                    <span id="toastMessage">Produk berhasil ditambah!</span>
                </div>
                <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast"
                    aria-label="Close"></button>
            </div>
        </div>
    </div>

    <style>
        .btn-tambah-keranjang:active {
            transform: scale(0.9);
        }
        #cart-count {
            transition: transform 0.2s cubic-bezier(0.175, 0.885, 0.32, 1.275);
        }
    </style>

    <script>
        function addToCart(id, productName) {
            // 1. Jalankan Fetch ke backend (tanpa mengubah logic controller)
            fetch('/customer/cart/add/' + id, {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                }
            })
            .then(response => {
                // Kita tidak peduli apa return dari backend, kita langsung update UI-nya

                // 2. Update Angka Badge secara manual di layar
                const badge = document.getElementById('cart-count');
                let currentCount = parseInt(badge.innerText) || 0;
                badge.innerText = currentCount + 1;

                // Efek animasi pop pada badge
                badge.style.transform = 'scale(1.5)';
                setTimeout(() => { badge.style.transform = 'scale(1)'; }, 200);

                // 3. Munculkan Toast (Pengganti Alert)
                const toastEl = document.getElementById('cartToast');
                const toastMessage = document.getElementById('toastMessage');
                const toast = new bootstrap.Toast(toastEl, { delay: 2000 });

                toastMessage.innerText = productName + " masuk keranjang!";
                toast.show();
            })
            .catch(error => {
                console.error('Error:', error);
            });
        }
    </script>
@endsection
