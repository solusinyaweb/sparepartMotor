@extends('index')

@section('content')
    <style>
        /* Hilangkan CSS background manual yang sebelumnya agar tidak double */
        #modalBukti {
            z-index: 9999 !important;
        }

        #previewBukti {
            max-height: 85vh;
            width: auto;
            margin: auto;
            display: block;
        }
    </style>

    <div class="card shadow-sm">
        <div class="card-header bg-white d-flex justify-content-between align-items-center py-3">
            <h5 class="fw-bold mb-0">Konfirmasi & Validasi Transaksi</h5>
            <div class="btn-group gap-2">
                <a href="{{ route('admin.transaksi') }}" class="btn btn-outline-primary btn-sm {{ !request('status') ? 'active' : '' }}">Semua</a>
                <a href="{{ route('admin.transaksi', ['status' => 'pending']) }}" class="btn btn-outline-warning btn-sm {{ request('status') == 'pending' ? 'active' : '' }}">Pending</a>
            </div>
        </div>

        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead class="table-light">
                        <tr>
                            <th class="ps-3">Pelanggan</th>
                            <th>Detail</th>
                            <th>Total</th>
                            <th>Bukti</th>
                            <th>Status</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($orders as $order)
                            <tr>
                                <td class="ps-3">
                                    <strong>{{ $order->user->name }}</strong><br>
                                    <small class="text-muted">{{ $order->user->phone }}</small>
                                </td>
                                <td>
                                    <span class="badge bg-info text-dark fw-normal">{{ $order->items->count() }} Item</span>
                                </td>
                                <td>
                                    <span class="fw-bold text-dark">Rp {{ number_format($order->total, 0, ',', '.') }}</span>
                                </td>
                                <td>
                                    @if ($order->payment_proof)
                                        <button class="btn btn-sm btn-light border"
                                            onclick="viewImage('{{ asset('storage/payment_proof/' . $order->payment_proof) }}')">
                                            <i class="bi bi-image"></i> Lihat
                                        </button>
                                    @else
                                        <span class="text-muted small">-</span>
                                    @endif
                                </td>
                                <td>
                                    @if (in_array($order->status, ['pending', 'paid']))
                                        <span class="badge bg-warning text-dark">Menunggu</span>
                                    @elseif($order->status == 'approved')
                                        <span class="badge bg-success">Disetujui</span>
                                    @else
                                        <span class="badge bg-danger">Ditolak</span>
                                    @endif
                                </td>
                                <td class="pe-3">
                                    @if (in_array($order->status, ['pending', 'paid']))
                                        <div class="d-flex gap-2">
                                            <button class="btn btn-success btn-sm px-3 fw-bold" onclick="updateStatus({{ $order->id }}, 'approved')">Terima</button>
                                            <button class="btn btn-danger btn-sm px-3 fw-bold" onclick="updateStatus({{ $order->id }}, 'rejected')">Tolak</button>
                                        </div>
                                    @else
                                        <span class="badge bg-secondary">Selesai</span>
                                    @endif
                                </td>
                            </tr>
                        @empty
                            <tr><td colspan="6" class="text-center py-5 text-muted">Tidak ada data transaksi.</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <div class="modal fade" id="modalBukti" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg">
            <div class="modal-content shadow-lg border-0">
                <div class="modal-header">
                    <h5 class="modal-title fw-bold">Bukti Pembayaran</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body p-1 text-center bg-dark">
                    <img id="previewBukti" src="" class="img-fluid rounded" alt="Bukti Transfer">
                </div>
            </div>
        </div>
    </div>

    <script>
        const BASE_URL = "{{ url('/') }}";

        function viewImage(url) {
            const modalElement = document.getElementById('modalBukti');
            const imgElement = document.getElementById('previewBukti');

            // Trik utama: Pindahkan modal ke luar dari container agar tidak blur/terhalang
            document.body.appendChild(modalElement);

            imgElement.src = url;

            // Gunakan instance Bootstrap Modal
            let myModal = bootstrap.Modal.getOrCreateInstance(modalElement);
            myModal.show();
        }

        function updateStatus(id, status) {
            const pesan = status === 'approved' ? 'Terima pesanan ini?' : 'Tolak pesanan ini?';
            if (!confirm(pesan)) return;

            fetch(`${BASE_URL}/admin/transaksi/${id}/status`, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                    'Accept': 'application/json'
                },
                body: JSON.stringify({ status: status })
            })
            .then(async res => {
                if (res.ok) {
                    location.reload();
                } else {
                    const errorData = await res.json();
                    alert('Gagal: ' + (errorData.message || 'Error Server'));
                }
            })
            .catch(err => {
                console.error(err);
                alert('Terjadi kesalahan koneksi.');
            });
        }
    </script>
@endsection
