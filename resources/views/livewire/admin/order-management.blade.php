<div>
    <div class="page-heading">
        <h3>Manajemen Pesanan</h3>
    </div>

    <section class="section">
        <div class="card">
            <div class="card-header">
                <h4 class="card-title">Daftar Semua Pesanan</h4>
            </div>
            <div class="card-body">

                <!-- Filter dan Search -->
                <div class="row mb-3">
                    <div class="col-md-4">
                        <input type="text" class="form-control" placeholder="Cari ID Pesanan/Pelanggan..." wire:model.live.debounce.300ms="search">
                    </div>
                    <div class="col-md-4">
                        <select class="form-select" wire:model.live="statusFilter">
                            <option value="">Filter Status (Semua)</option>
                            @foreach($availableStatuses as $key => $label)
                                <option value="{{ $key }}">{{ $label }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-4 text-end">
                        <button class="btn btn-sm btn-light" wire:click="resetFilters">Reset Filter</button>
                    </div>
                </div>

                <div class="table-responsive">
                    <table class="table table-hover table-lg">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Tanggal</th>
                                <th>Pelanggan</th>
                                <th>Total Bayar</th>
                                <th>Status</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($orders as $order)
                            <tr>
                                <td class="text-bold-500">#{{ $order->id }}</td>
                                <td>{{ $order->created_at->format('d M Y') }}</td>
                                <td>{{ $order->user->name ?? 'User Dihapus' }}</td>
                                <td class="text-bold-500">
                                    Rp {{ number_format($order->total_amount, 0, ',', '.') }}
                                </td>
                                <td>
                                    @php
                                        $statusClass = [
                                            'pending' => 'warning', 'verifying' => 'info', 
                                            'paid' => 'success', 'processed' => 'secondary', 
                                            'shipped' => 'primary', 'delivered' => 'dark', 
                                            'canceled' => 'danger'
                                        ][$order->status] ?? 'light';
                                        $statusLabel = $availableStatuses[$order->status] ?? ucfirst($order->status);
                                    @endphp
                                    <span class="badge bg-{{ $statusClass }}">{{ $statusLabel }}</span>
                                </td>
                                <td>
                                    <button class="btn btn-sm btn-info" wire:click="showDetailModal({{ $order->id }})">Detail</button>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="6" class="text-center p-3">Tidak ada pesanan yang ditemukan.</td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                <div class="mt-4">
                    {{ $orders->links() }}
                </div>
            </div>
        </div>
    </section>

    {{-- MODAL DETAIL PESANAN --}}
    @if($isDetailModalOpen && $selectedOrder)
        <div class="modal-backdrop fade show"></div>
        <div class="modal fade show" id="orderDetailModal" tabindex="-1" style="display: block;">
            <div class="modal-dialog modal-lg" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Detail Pesanan #{{ $selectedOrder->id }}</h5>
                        <button type="button" class="btn-close" wire:click="closeDetailModal" aria-label="Close"></button>
                    </div>
                    
                    <div class="modal-body" style="max-height: 70vh; overflow-y: auto;">
                        <h6 class="text-primary">Informasi Pelanggan & Pengiriman</h6>
                        <dl class="row">
                            <dt class="col-sm-4">Nama Penerima:</dt>
                            <dd class="col-sm-8">{{ $selectedOrder->recipient_name }}</dd>
                            <dt class="col-sm-4">Nomor HP:</dt>
                            <dd class="col-sm-8">{{ $selectedOrder->phone_number }}</dd>
                            <dt class="col-sm-4">Alamat Pengiriman:</dt>
                            <dd class="col-sm-8">{{ $selectedOrder->shipping_address }}</dd>
                            <dt class="col-sm-4">Metode Bayar:</dt>
                            <dd class="col-sm-8">{{ $selectedOrder->payment_method }}</dd>
                            <dt class="col-sm-4">Tanggal Pesan:</dt>
                            <dd class="col-sm-8">{{ $selectedOrder->created_at->format('d F Y H:i') }}</dd>
                        </dl>
                        
                        {{-- Tampilkan Bukti Pembayaran jika ada --}}
                        @if ($selectedOrder->payment_proof_path)
                            <h6 class="text-primary mt-3">Bukti Pembayaran</h6>
                            <a href="{{ asset('storage/' . $selectedOrder->payment_proof_path) }}" target="_blank">
                                <img src="{{ asset('storage/' . $selectedOrder->payment_proof_path) }}" alt="Bukti Pembayaran" class="img-fluid rounded shadow-sm" style="max-height: 200px;">
                            </a>
                        @endif

                        <h6 class="text-primary mt-4">Rincian Barang Pesanan</h6>
                        <div class="table-responsive">
                            <table class="table table-sm table-striped">
                                <thead>
                                    <tr>
                                        <th>Produk</th>
                                        <th>Harga Satuan</th>
                                        <th>Qty</th>
                                        <th>Subtotal</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($selectedOrder->items as $item)
                                    <tr>
                                        <td>{{ $item->product->name ?? $item->product_name ?? 'Produk Dihapus/Tidak Diketahui' }}</td>
                                        <td>Rp {{ number_format($item->price_at_purchase, 0, ',', '.') }}</td>
                                        <td>{{ $item->quantity }}</td>
                                        <td>Rp {{ number_format($item->price_at_purchase * $item->quantity, 0, ',', '.') }}</td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                        
                        <div class="text-end fw-bold fs-5 mt-3">
                            TOTAL KESELURUHAN: Rp {{ number_format($selectedOrder->total_amount, 0, ',', '.') }}
                        </div>
                        
                        <h6 class="text-primary mt-4">Ubah Status Pesanan</h6>
                        <form wire:submit.prevent="updateStatus">
                            <div class="input-group">
                                <select class="form-select" wire:model.live="newStatus">
                                    @foreach($availableStatuses as $key => $label)
                                        <option value="{{ $key }}">{{ $label }}</option>
                                    @endforeach
                                </select>
                                <button type="submit" class="btn btn-success" wire:loading.attr="disabled">
                                    <span wire:loading wire:target="updateStatus" class="spinner-border spinner-border-sm me-1" role="status"></span>
                                    Update Status
                                </button>
                            </div>
                            @error('newStatus') <span class="text-danger mt-1">{{ $message }}</span> @enderror
                        </form>
                        
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" wire:click="closeDetailModal">Tutup</button>
                    </div>
                </div>
            </div>
        </div>
    @endif
</div>