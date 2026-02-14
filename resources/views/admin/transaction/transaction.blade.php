@extends('index')

@section('content')
    <div class="card shadow-sm">
        <div class="card-header bg-white d-flex justify-content-between">
            <h5 class="fw-bold">Konfirmasi & Validasi Transaksi</h5>

            <div>
                <a href="{{ route('admin.transaksi') }}" class="btn btn-light-primary btn-sm">Semua</a>
                <a href="{{ route('admin.transaksi', ['status' => 'pending']) }}"
                    class="btn btn-light-warning btn-sm">Pending</a>
            </div>
        </div>

        <div class="card-body p-3">
            <table class="table table-hover align-middle">
                <thead class="table-light">
                    <tr>
                        <th>Pelanggan</th>
                        <th>Detail</th>
                        <th>Total</th>
                        <th class="text-center">Bukti</th>
                        <th>Status</th>
                        <th class="text-end">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($orders as $order)
                        <tr>
                            <td>
                                <strong>{{ $order->user->name }}</strong><br>
                                <small>{{ $order->user->phone }}</small>
                            </td>

                            <td>
                                <span class="badge bg-info text-dark">
                                    {{ $order->items->count() }} Item
                                </span>
                                <small class="d-block text-muted">
                                    {{ $order->items->pluck('produk_nama')->take(2)->implode(', ') }}
                                </small>
                            </td>

                            <td>
                                <strong>Rp {{ number_format($order->total, 0, ',', '.') }}</strong>
                            </td>

                            <td class="text-center">
                                @if ($order->payment_proof)
                                    <button class="btn btn-sm btn-secondary"
                                        onclick="viewImage('{{ asset('storage/' . $order->bukti_transfer) }}')">
                                        Lihat
                                    </button>
                                @else
                                    -
                                @endif
                            </td>

                            <td>
                                @if ($order->status == 'pending')
                                    <span class="badge bg-warning">Pending</span>
                                @elseif($order->status == 'approved')
                                    <span class="badge bg-success">Approved</span>
                                @else
                                    <span class="badge bg-danger">Rejected</span>
                                @endif
                            </td>

                            <td class="text-end">
                                @if ($order->status == 'paid')
                                    <button class="btn btn-success btn-sm"
                                        onclick="updateStatus({{ $order->id }}, 'approved')">
                                        Terima
                                    </button>

                                    <button class="btn btn-danger btn-sm"
                                        onclick="updateStatus({{ $order->id }}, 'rejected')">
                                        Tolak
                                    </button>
                                @endif
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

    {{-- MODAL BUKTI --}}
    <div class="modal fade" id="modalBukti">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-body text-center">
                    <img id="previewBukti" class="img-fluid">
                </div>
            </div>
        </div>
    </div>

    <script>
        function viewImage(url) {
            document.getElementById('previewBukti').src = url;
            new bootstrap.Modal(document.getElementById('modalBukti')).show();
        }

        function updateStatus(id, status) {
            if (!confirm('Yakin ubah status?')) return;

            fetch(`/admin/transaksi/${id}/status`, {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': '{{ csrf_token() }}',
                        'Content-Type': 'application/json'
                    },
                    body: JSON.stringify({
                        status: status
                    })
                })
                .then(res => res.json())
                .then(() => location.reload());
        }
    </script>
@endsection
