@extends('index')

@section('content')
    <style>
        /* CSS Tambahan untuk memastikan modal berada di depan */
        .modal {
            background: rgba(0, 0, 0, 0.5);
            /* Overlay gelap transparan */
        }

        #modalBukti {
            z-index: 9999 !important;
        }

        .modal-backdrop {
            display: none !important;
            /* Kita gunakan background modal saja agar tidak double backdrop */
        }
    </style>

    <div class="card shadow-sm">
        <div class="card-header bg-white d-flex justify-content-between align-items-center py-3">
            <h5 class="fw-bold mb-0">Konfirmasi & Validasi Transaksi</h5>

            <div class="btn-group gap-2">
                <a href="{{ route('admin.transaksi') }}"
                    class="btn btn-outline-primary btn-sm {{ !request('status') ? 'active' : '' }}">Semua</a>
                <a href="{{ route('admin.transaksi', ['status' => 'pending']) }}"
                    class="btn btn-outline-warning btn-sm {{ request('status') == 'pending' ? 'active' : '' }}">Pending</a>
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
                            <th class="">Bukti</th>
                            <th>Status</th>
                            <th class="text-start">Aksi</th>
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
                                    <span class="badge bg-info text-dark fw-normal">
                                        {{ $order->items->count() }} Item
                                    </span>
                                    <small class="d-block text-muted text-truncate" style="max-width: 150px;">
                                        {{ $order->items->pluck('produk_nama')->take(2)->implode(', ') }}
                                    </small>
                                </td>

                                <td>
                                    <span class="fw-bold text-dark">Rp
                                        {{ number_format($order->total, 0, ',', '.') }}</span>
                                </td>

                                <td class="text-center">
                                    @if ($order->payment_proof)
                                        <button class="btn btn-sm btn-light border"
                                            onclick="viewImage('{{ asset('storage/' . $order->payment_proof) }}')">
                                            <i class="bi bi-image"></i> Lihat
                                        </button>
                                    @else
                                        <span class="text-muted small">-</span>
                                    @endif
                                </td>

                                <td>
                                    @if ($order->status == 'pending' || $order->status == 'paid')
                                        <span class="badge bg-warning">Menunggu</span>
                                    @elseif($order->status == 'approved')
                                        <span class="badge bg-success">Disetujui</span>
                                    @else
                                        <span class="badge bg-danger">Ditolak</span>
                                    @endif
                                </td>

                                <td class="text-end pe-3">
                                    @if ($order->status == 'paid')
                                        <div class="d-flex justify-content-start gap-2">
                                            <button class="btn btn-success btn-sm px-3 fw-bold"
                                                onclick="updateStatus({{ $order->id }}, 'approved')">
                                                Terima
                                            </button>
                                            <button class="btn btn-danger btn-sm px-3 fw-bold"
                                                onclick="updateStatus({{ $order->id }}, 'rejected')">
                                                Tolak
                                            </button>
                                        </div>
                                    @else
                                        <div class="d-flex justify-content-start gap-2">
                                            <span class="bg-warning bg-sm rounded-5 text-white px-3">
                                                Selesai
                                            </span>
                                        </div>
                                    @endif
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="text-center py-5 text-muted">
                                    <i class="bi bi-inbox fs-1 d-block mb-2"></i>
                                    Tidak ada data transaksi.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    {{-- MODAL BUKTI --}}
    <div class="modal fade" id="modalBukti" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content shadow-lg border-0">
                <div class="modal-header">
                    <h5 class="modal-title fw-bold">Bukti Pembayaran</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body p-2 text-center bg-light">
                    <img id="previewBukti" src="" class="img-fluid rounded shadow-sm" alt="Bukti Transfer">
                </div>
            </div>
        </div>
    </div>

    <script>
        function viewImage(url) {
            const modalElement = document.getElementById('modalBukti');

            // PINDAHKAN MODAL KE BODY (Mencegah blur/tenggelam)
            document.body.appendChild(modalElement);

            const imgElement = document.getElementById('previewBukti');
            imgElement.src = url;

            const myModal = new bootstrap.Modal(modalElement);
            myModal.show();
        }

        function updateStatus(id, status) {
            const pesan = status === 'approved' ? 'Terima pesanan ini?' : 'Tolak pesanan ini?';
            if (!confirm(pesan)) return;

            fetch(`/admin/transaksi/${id}/status`, {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': '{{ csrf_token() }}',
                        'Content-Type': 'application/json',
                        'Accept': 'application/json'
                    },
                    body: JSON.stringify({
                        status: status
                    })
                })
                .then(res => {
                    if (res.ok) {
                        location.reload();
                    } else {
                        alert('Gagal memperbarui status. Pastikan Route POST sudah benar.');
                    }
                })
                .catch(err => {
                    console.error(err);
                    alert('Terjadi kesalahan koneksi.');
                });
        }
    </script>
@endsection
