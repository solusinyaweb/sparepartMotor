@extends('index')

@section('content')
    <div class="row">
        <div class="col-lg-12">
            <div class="card shadow-sm border-0 mb-4">
                <div class="card-header bg-white py-3 border-bottom">
                    <div class="d-flex align-items-center">
                        <div class="bg-primary bg-opacity-10 p-2 rounded-3 me-3">
                            <i class="feather feather-shopping-bag text-primary"></i>
                        </div>
                        <h5 class="mb-0 fw-bold text-dark">Riwayat Pesanan Saya</h5>
                    </div>
                </div>

                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-hover align-middle mb-0">
                            <thead class="bg-light">
                                <tr>
                                    <th class="ps-4 py-3 text-uppercase small fw-bold text-muted"
                                        style="letter-spacing: 0.5px;">Informasi Invoice</th>
                                    <th class="py-3 text-uppercase small fw-bold text-muted" style="letter-spacing: 0.5px;">
                                        Total Pembayaran</th>
                                    <th class="py-3 text-uppercase small fw-bold text-muted" style="letter-spacing: 0.5px;">
                                        Status Pesanan</th>
                                    <th class="text-center pe-4 py-3 text-uppercase small fw-bold text-muted"
                                        style="letter-spacing: 0.5px;">Opsi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($orders as $order)
                                    <tr>
                                        <td class="ps-4 py-3">
                                            <div class="d-flex align-items-center">
                                                <div>
                                                    <div class="fw-bold text-dark mb-1">
                                                        {{ $order->created_at->format('d M Y') }}</div>
                                                    <span
                                                        class="badge bg-light text-primary border border-primary border-opacity-25 fw-medium">
                                                        #{{ $order->invoice ?? ($order->kode_transaksi ?? $order->id) }}
                                                    </span>
                                                </div>
                                            </div>
                                        </td>
                                        <td class="py-3">
                                            <div class="text-dark fw-bold">Rp
                                                {{ number_format($order->total, 0, ',', '.') }}</div>
                                            <small class="text-muted">Metode: Transfer</small>
                                        </td>
                                        <td class="py-3">
                                            @if ($order->status == 'approved')
                                                <div class="d-flex align-items-center text-success">
                                                    <span class="p-1 bg-success rounded-circle me-2"></span>
                                                    <span class="small fw-bold">Disetujui</span>
                                                </div>
                                            @elseif($order->status == 'pending')
                                                <div class="d-flex align-items-center text-warning">
                                                    <span class="p-1 bg-warning rounded-circle me-2"></span>
                                                    <span class="small fw-bold">Pending</span>
                                                </div>
                                            @elseif ($order->status == 'paid')
                                                <div class="d-flex align-items-center text-info">
                                                    <span class="p-1 bg-info rounded-circle me-2"></span>
                                                    <span class="small fw-bold">Menunggu Konfirmasi</span>
                                                </div>
                                            @endif
                                        </td>
                                        <td class="text-center pe-4 py-3">
                                            <div class="d-flex justify-content-center gap-2">
                                                <button class="btn btn-outline-primary btn-sm px-3 rounded-2 shadow-xs"
                                                    onclick="showDetail({{ $order->id }})">
                                                    <i class="feather feather-eye me-1"></i> Detail
                                                </button>
                                                <a href="{{ route('customer.nota.show', $order->id) }}" target="_blank"
                                                    class="btn btn-warning btn-sm text-white px-3 rounded-2 shadow-xs">
                                                    <i class="feather feather-printer me-1"></i> Cetak
                                                </a>
                                            </div>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="4" class="text-center py-5">
                                            <div class="py-4">
                                                <i
                                                    class="feather feather-inbox fs-1 text-muted opacity-25 mb-3 d-block"></i>
                                                <p class="text-muted mb-0">Belum ada riwayat invoice ditemukan.</p>
                                            </div>
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- MODAL DETAIL --}}
    <div class="modal fade" id="modalDetail" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content shadow border-0">
                <div class="modal-header border-0 pb-0">
                    <h5 class="modal-title fw-bold text-dark">
                        Detail Invoice <span id="orderKode" class="text-primary opacity-75"></span>
                    </h5>
                    <button type="button" class="btn-close shadow-none" data-bs-dismiss="modal"
                        aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="bg-light rounded-3 p-1">
                        <ul class="list-group list-group-flush rounded-3" id="detailList"></ul>
                    </div>
                </div>
                <div class="modal-footer border-0 bg-light rounded-bottom-4 d-flex justify-content-between py-3">
                    <span class="fw-bold text-muted">Total Tagihan</span>
                    <span class="h5 mb-0 fw-bold text-primary" id="detailTotal"></span>
                </div>
            </div>
        </div>
    </div>

    <script>
        const dataOrders = @json($orders);

        function showDetail(id) {
            const order = dataOrders.find(o => o.id == id);
            if (!order) return;

            const invoiceCode = order.invoice || order.invoice || order.invoice || ('INV-' + order.id);
            document.getElementById('orderKode').innerText = '#' + invoiceCode;

            let html = '';
            const items = order.items || order.details || [];

            items.forEach(item => {
                const namaBarang = item.product ?
                    item.product.name :
                    'Produk tidak dikenal';

                const hargaSatuan = item.harga || item.price || 0;
                const qty = item.qty || 0;
                const subTotal = item.subtotal || (hargaSatuan * qty);

                html += `
                    <li class="list-group-item d-flex justify-content-between align-items-center py-3 bg-transparent">
                        <div style="max-width: 70%;">
                            <div class="fw-bold text-dark mb-1" style="font-size: 0.95rem;">${namaBarang}</div>
                            <span class="badge bg-white text-muted border fw-normal text-dark">${qty} pcs x Rp ${Number(hargaSatuan).toLocaleString('id-ID')}</span>
                        </div>
                        <span class="fw-bold text-dark">Rp ${Number(subTotal).toLocaleString('id-ID')}</span>
                    </li>`;
            });

            document.getElementById('detailList').innerHTML = html ||
                '<li class="list-group-item text-center py-3">Data barang tidak ditemukan</li>';
            document.getElementById('detailTotal').innerText = "Rp " + Number(order.total).toLocaleString('id-ID');

            const modalEl = document.getElementById('modalDetail');
            document.body.appendChild(modalEl);

            const myModal = new bootstrap.Modal(modalEl);
            myModal.show();
        }
    </script>

    <style>
        .table thead th {
            font-size: 0.75rem;
            border-top: none;
        }

        .table tbody tr:last-child td {
            border-bottom: none;
        }

        .shadow-xs {
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.05);
        }

        .modal-content {
            border-radius: 1rem;
        }

        .bg-light {
            background-color: #f8f9fa !important;
        }

        .badge.bg-light.text-primary {
            background-color: #f0f4ff !important;
        }

        /* Memastikan posisi modal di depan backdrop */
        .modal {
            z-index: 1060 !important;
        }

        .modal-backdrop {
            z-index: 1050 !important;
        }
    </style>
@endsection
