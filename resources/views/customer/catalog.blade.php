@extends('index')

@section('content')
    <div class="row">
        <div class="col-lg-12">
            <div class="card stretch stretch-full">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h5 class="mb-0">Katalog Sparepart</h5>
                    <a href="{{ route('customer.cart') }}" class="btn btn-warning position-relative">
                        <i class="feather feather-shopping-cart me-2"></i> Keranjang
                        <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger"
                            id="cart-count">
                            {{ session('cart') }}
                        </span>
                    </a>
                </div>

                <div class="card-body p-0">
                    <div class="table-responsive">
                        <div id="productList_wrapper" class="dataTables_wrapper dt-bootstrap5 no-footer p-3">
                            <table class="table table-hover dataTable no-footer" id="productList">
                                <thead>
                                    <tr>
                                        <th class="sorting">Kode</th>
                                        <th class="sorting">Nama Sparepart</th>
                                        <th class="sorting">Harga</th>
                                        <th class="sorting">Stok Tersedia</th>
                                        <th class="text-center">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($products as $product)
                                        <tr>
                                            <td>{{ $product->code }}</td>
                                            <td>{{ $product->name }}</td>
                                            <td>Rp {{ number_format($product->price, 0, ',', '.') }}</td>
                                            <td>{{ $product->stocks->sum('quantity') }}</td>
                                            <td>
                                                <button onclick="addToCart({{ $product->id }})"
                                                    class="btn btn-primary btn-sm">
                                                    + Keranjang
                                                </button>
                                            </td>
                                        </tr>
                                    @endforeach

                                </tbody>
                            </table>

                            <div class="row mt-4">
                                <div class="col-sm-12 col-md-5">
                                    <div class="dataTables_info">Menampilkan 1 sampai 2 dari 2 produk</div>
                                </div>
                                <div class="col-sm-12 col-md-7 d-flex justify-content-end">
                                    <nav>
                                        <ul class="pagination">
                                            <li class="page-item disabled"><a class="page-link" href="#">Previous</a>
                                            </li>
                                            <li class="page-item active"><a class="page-link" href="#">1</a></li>
                                            <li class="page-item disabled"><a class="page-link" href="#">Next</a></li>
                                        </ul>
                                    </nav>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="toast-container position-fixed bottom-0 end-0 p-3">
        <div id="cartToast" class="toast align-items-center text-white bg-success border-0" role="alert"
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
        .btn-tambah-keranjang {
            transition: all 0.2s ease;
        }

        .btn-tambah-keranjang:active {
            transform: scale(0.9);
        }

        .table-hover tbody tr:hover {
            background-color: rgba(0, 123, 255, 0.05);
        }

        /* Menghaluskan tampilan toast */
        .toast {
            border-radius: 10px;
            font-size: 0.9rem;
        }
    </style>

        <script>
            function addToCart(id) {
                fetch('/customer/cart/add/' + id, {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    }
                }).then(() => {
                    alert('Berhasil ditambah');
                });
            }
    </script>

    <script>
        let count = 0;

        function tambahKeKeranjang(namaProduk) {
            // 1. Update Badge Count
            count++;
            document.getElementById('cart-count').innerText = count;

            // 2. Munculkan Notifikasi Toast (Pengganti Alert)
            const toastEl = document.getElementById('cartToast');
            const toastMessage = document.getElementById('toastMessage');
            const toast = new bootstrap.Toast(toastEl, {
                delay: 2000
            }); // Hilang dalam 2 detik

            toastMessage.innerText = namaProduk + " ditambah ke keranjang!";
            toast.show();
        }
    </script>
@endsection
