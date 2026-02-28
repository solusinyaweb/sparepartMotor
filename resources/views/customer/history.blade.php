@extends('index')

@section('content')
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

        /* ================= ANTI BLUR TOTAL ================= */
        .modal {
            z-index: 1060 !important;
            filter: none !important;
            backdrop-filter: none !important;
        }

        .modal-content {
            filter: none !important;
            backdrop-filter: none !important;
            opacity: 1 !important;
            border-radius: 1rem;
        }

        body.modal-open {
            filter: none !important;
        }

        .modal-backdrop {
            backdrop-filter: none !important;
            background-color: rgba(0, 0, 0, .5) !important;
            z-index: 1050 !important;
        }
    </style>

    <div class="row">
        <div class="col-lg-12">
            <div class="card shadow-sm border-0 mb-4">
                <div class="card-header bg-white py-3 border-bottom">
                    <h5 class="mb-0 fw-bold">Riwayat Pesanan Saya</h5>
                </div>

                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-hover align-middle mb-0">
                            <thead class="bg-light">
                                <tr>
                                    <th class="ps-4">Invoice</th>
                                    <th>Total</th>
                                    <th>Status</th>
                                    <th class="text-center pe-4">Opsi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($orders as $order)
                                    <tr>
                                        <td class="ps-4">
                                            <div class="fw-bold">{{ $order->created_at->format('d M Y') }}</div>
                                            <span class="badge bg-light text-primary">
                                                #{{ $order->invoice }}
                                            </span>
                                        </td>

                                        <td>
                                            <div class="fw-bold">
                                                Rp {{ number_format($order->total, 0, ',', '.') }}
                                            </div>
                                            <small class="text-muted">
                                                Metode: {{ ucfirst($order->payment_method ?? '-') }}
                                            </small>
                                        </td>

                                        <td>
                                            @if ($order->status == 'approved')
                                                <span class="badge bg-success">Disetujui</span>
                                            @elseif ($order->status == 'paid')
                                                <span class="badge bg-info">Menunggu Konfirmasi</span>
                                            @elseif ($order->status == 'pending')
                                                <span class="badge bg-warning text-dark">Pending</span>
                                            @elseif ($order->status == 'rejected')
                                                <span class="badge bg-danger">Ditolak</span>
                                            @endif
                                        </td>

                                        <td class="text-center pe-4">
                                            <button class="btn btn-outline-primary btn-sm"
                                                onclick="showDetail({{ $order->id }})">
                                                Detail
                                            </button>
                                            <a href="{{ route('customer.nota.show', $order->id) }}" target="_blank"
                                                class="btn btn-warning btn-sm text-white">
                                                Cetak
                                            </a>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="4" class="text-center py-5 text-muted">
                                            Belum ada riwayat transaksi
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

    {{-- ================= MODAL DETAIL ================= --}}
    <div class="modal fade" id="modalDetail" tabindex="-1" data-bs-backdrop="static" data-bs-focus="false">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content shadow border-0">
                <div class="modal-header border-0">
                    <h5 class="modal-title fw-bold">
                        Detail Invoice <span id="orderKode" class="text-primary"></span>
                    </h5>
                    <button class="btn-close" data-bs-dismiss="modal"></button>
                </div>

                <div class="modal-body">
                    <div class="mb-2">
                        <strong>Status:</strong>
                        <span id="detailStatus"></span>
                    </div>

                    <div class="mb-3">
                        <strong>Metode Pembayaran:</strong>
                        <span id="detailPaymentMethod"></span>
                    </div>

                    {{-- CASH ONLY --}}
                    <div id="cashInfo" class="mb-3 d-none">
                        <div>Uang Cash:
                            <strong id="detailCashAmount"></strong>
                        </div>
                        <div>Kembalian:
                            <strong id="detailChangeAmount"></strong>
                        </div>
                    </div>

                    <hr>

                    <ul class="list-group list-group-flush" id="detailList"></ul>
                </div>

                <div class="modal-footer bg-light">
                    <span class="fw-bold">Total</span>
                    <span class="fw-bold text-primary" id="detailTotal"></span>
                </div>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const modal = document.getElementById('modalDetail');
            if (modal && modal.parentElement !== document.body) {
                document.body.appendChild(modal);
            }
        });
    </script>

    <script>
        const dataOrders = @json($orders);

        function showDetail(id) {
            const order = dataOrders.find(o => o.id == id);
            if (!order) return;

            // INVOICE
            document.getElementById('orderKode').innerText = '#' + order.invoice;

            // STATUS
            const statusMap = {
                approved: '<span class="badge bg-success">Disetujui</span>',
                paid: '<span class="badge bg-info">Menunggu Konfirmasi</span>',
                pending: '<span class="badge bg-warning text-dark">Pending</span>',
                rejected: '<span class="badge bg-danger">Ditolak</span>',
            };
            document.getElementById('detailStatus').innerHTML =
                statusMap[order.status] ?? '-';

            // PAYMENT METHOD
            const paymentEl = document.getElementById('detailPaymentMethod');
            const cashInfo = document.getElementById('cashInfo');

            cashInfo.classList.add('d-none');

            if (order.payment_method === 'cash') {
                paymentEl.innerHTML = '<span class="badge bg-success">Cash</span>';

                document.getElementById('detailCashAmount').innerText =
                    'Rp ' + Number(order.cash_amount).toLocaleString('id-ID');

                document.getElementById('detailChangeAmount').innerText =
                    'Rp ' + Number(order.change_amount).toLocaleString('id-ID');

                cashInfo.classList.remove('d-none');
            } else {
                paymentEl.innerHTML = '<span class="badge bg-primary">Transfer</span>';
            }

            // ITEMS
            let html = '';
            (order.items || []).forEach(item => {
                const subtotal = item.qty * item.price;
                html += `
                <li class="list-group-item d-flex justify-content-between">
                    <div>
                        <strong>${item.product?.name ?? '-'}</strong><br>
                        <small>${item.qty} x Rp ${item.price.toLocaleString('id-ID')}</small>
                    </div>
                    <strong>Rp ${subtotal.toLocaleString('id-ID')}</strong>
                </li>
            `;
            });
            document.getElementById('detailList').innerHTML = html;

            document.getElementById('detailTotal').innerText =
                'Rp ' + Number(order.total).toLocaleString('id-ID');

            new bootstrap.Modal(document.getElementById('modalDetail')).show();
        }
    </script>
@endsection
