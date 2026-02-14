@extends('index')

@section('content')
    <div class="row">
        <div class="col-lg-12">
            <div class="card shadow-sm">
                <div class="card-header bg-white py-3">
                    <h5 class="mb-0 fw-bold">Riwayat Pesanan Saya</h5>
                </div>

                <div class="card-body p-0">
                    <div class="table-responsive p-3">
                        <table class="table table-hover align-middle">
                            <thead class="table-light">
                                <tr>
                                    <th>Tanggal</th>
                                    <th>Total</th>
                                    <th>Status</th>
                                    <th class="text-center">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($orders as $order)
                                    <tr>
                                        <td>
                                            <strong>{{ $order->created_at->format('d M Y') }}</strong>
                                            <br>
                                            <small class="text-muted">
                                                ID: {{ $order->kode_transaksi }}
                                            </small>
                                        </td>

                                        <td>
                                            <strong>Rp {{ number_format($order->total, 0, ',', '.') }}</strong>
                                        </td>

                                        <td>
                                            @if ($order->status == 'approved')
                                                <span class="badge bg-success">Disetujui</span>
                                            @elseif($order->status == 'pending')
                                                <span class="badge bg-warning">Pending</span>
                                            @elseif ($order->status == 'paid')
                                                <span class="badge bg-danger">Menunggu konfirmasi</span>
                                            @endif
                                        </td>

                                        <td class="text-center">
                                            <button class="btn btn-primary btn-sm"
                                                onclick="showDetail({{ $order->id }})">
                                                Detail
                                            </button>

                                            <a href="{{ route('customer.nota.show', $order->id) }}" target="_blank"
                                                class="btn btn-warning btn-sm text-white">
                                                Cetak Nota
                                            </a>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="4" class="text-center text-muted">
                                            Belum ada pesanan
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
    <div class="modal fade" id="modalDetail" tabindex="-1">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content shadow-lg border-0">
                <div class="modal-header">
                    <h5 class="modal-title fw-bold">
                        Detail Order <span id="orderKode"></span>
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>

                <div class="modal-body">
                    <ul class="list-group" id="detailList"></ul>

                    <div class="d-flex justify-content-between mt-3">
                        <strong>Total</strong>
                        <strong class="text-primary" id="detailTotal"></strong>
                    </div>
                </div>
            </div>
        </div>
    </div>


    <script>
        const orders = @json($orders);

        function showDetail(id) {
            const order = orders.find(o => o.id === id);

            document.getElementById('orderKode').innerText = order.kode_transaksi;

            let html = '';
            order.items.forEach(item => {
                html += `
            <li class="list-group-item d-flex justify-content-between">
                <div>
                    <strong>${item.produk_nama}</strong><br>
                    <small>Qty: ${item.qty} x Rp ${Number(item.harga).toLocaleString('id-ID')}</small>
                </div>
                <strong>Rp ${Number(item.subtotal).toLocaleString('id-ID')}</strong>
            </li>
        `;
            });

            document.getElementById('detailList').innerHTML = html;
            document.getElementById('detailTotal').innerText =
                "Rp " + Number(order.total).toLocaleString('id-ID');

            new bootstrap.Modal(document.getElementById('modalDetail')).show();
        }
    </script>
@endsection
