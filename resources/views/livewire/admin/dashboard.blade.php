<div>
    <section class="row">

        <div class="col-12">
            <div class="row">
                <div class="col-12 col-sm-6 col-lg-4">
                    <div class="card">
                        <div class="card-body px-4 py-4-5">
                            <div class="row">
                                <div class="col-md-4 col-lg-12 col-xl-12 col-xxl-5 d-flex justify-content-start">
                                    <div class="stats-icon blue mb-2">
                                        <i class="iconly-boldProfile"></i>
                                    </div>
                                </div>
                                <div class="col-md-8 col-lg-12 col-xl-12 col-xxl-7">
                                    <h6 class="text-muted font-semibold">Total Pelanggan</h6>
                                    <h6 class="font-extrabold mb-0">{{ $totalUsers }}</h6>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Total Produk -->
                <div class="col-12 col-sm-6 col-lg-4">
                    <div class="card">
                        <div class="card-body px-4 py-4-5">
                            <div class="row">
                                <div class="col-md-4 col-lg-12 col-xl-12 col-xxl-5 d-flex justify-content-start">
                                    <div class="stats-icon purple mb-2">
                                        <i class="iconly-boldBookmark"></i>
                                    </div>
                                </div>
                                <div class="col-md-8 col-lg-12 col-xl-12 col-xxl-7">
                                    <h6 class="text-muted font-semibold">Total Produk</h6>
                                    <h6 class="font-extrabold mb-0">{{ $totalProducts }}</h6>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Total Pesanan -->
                <div class="col-12 col-sm-6 col-lg-4">
                    <div class="card">
                        <div class="card-body px-4 py-4-5">
                            <div class="row">
                                <div class="col-md-4 col-lg-12 col-xl-12 col-xxl-5 d-flex justify-content-start">
                                    <div class="stats-icon green mb-2">
                                        <i class="iconly-boldBuy"></i>
                                    </div>
                                </div>
                                <div class="col-md-8 col-lg-12 col-xl-12 col-xxl-7">
                                    <h6 class="text-muted font-semibold">Total Pesanan</h6>
                                    <h6 class="font-extrabold mb-0">{{ $totalOrders }}</h6>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-12 mt-4">
            <div class="card">
                <div class="card-header">
                    <h4>Produk Terlaris</h4>
                </div>
                <div class="card-body">
                    @forelse($topProducts as $product)
                    <div class="d-flex align-items-center justify-content-between mb-3">
                        <div class="me-2">
                            <span class="badge bg-primary">#{{ $loop->iteration }}</span>
                        </div>
                        <div class="flex-grow-1">
                            <h6 class="font-bold mb-0" style="font-size: 0.85rem;">{{ Str::limit($product->product_name, 40) }}</h6>
                        </div>
                        <div>
                            <span class="badge bg-light-primary">{{ $product->total_sold }} terjual</span>
                        </div>
                    </div>
                    @empty
                    <div class="text-center py-3">
                        <p class="text-muted mb-0">Belum ada data produk terjual.</p>
                    </div>
                    @endforelse
                </div>
            </div>
        </div>

        <!-- Chart Penjualan bulanan -->
        <div class="col-12 mt-4">
            <div class="card">
                <div class="card-header">
                    <h4>Chart Penjualan Bulanan</h4>
                </div>
                <div class="card-body" wire:ignore>
                    <canvas id="dailyChart"></canvas>
                </div>
            </div>
        </div>

        <!-- Pesanan Terbaru -->
        <div class="col-12 mt-4">
            <div class="card">
                <div class="card-header">
                    <h4>Pesanan Terbaru</h4>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-hover table-lg">
                            <thead>
                                <tr>
                                    <th>ID Pesanan</th>
                                    <th>Pelanggan</th>
                                    <th>Status</th>
                                    <th>Total</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($recentOrders as $order)
                                <tr>
                                    <td class="text-bold-500">#{{ $order->id }}</td>
                                    <td class="text-bold-500">{{ $order->user->name }}</td>
                                    <td>
                                        @if($order->status == 'pending')
                                            <span class="badge bg-warning">Menunggu</span>
                                        @elseif($order->status == 'paid' || $order->status == 'verifying')
                                            <span class="badge bg-success">{{ ucfirst($order->status) }}</span>
                                        @elseif($order->status == 'failed')
                                            <span class="badge bg-danger">Gagal</span>
                                        @else
                                            <span class="badge bg-secondary">{{ ucfirst($order->status) }}</span>
                                        @endif
                                    </td>
                                    <td class="text-bold-500">Rp {{ number_format($order->total_amount, 0, ',', '.') }}</td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="4" class="text-center">
                                        <p class="p-3 mb-0">Belum ada pesanan.</p>
                                    </td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

    </section>

    @push('scripts')

    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/3.9.1/chart.min.js"></script>

    <script>
        (function() {
            setTimeout(function() {
                const canvas = document.getElementById('dailyChart');
                if (!canvas) {
                    console.error('Canvas dailyChart tidak ditemukan');
                    return;
                }
                
                const ctx = canvas.getContext('2d');
                new Chart(ctx, {
                    type: 'line',
                    data: {
                        labels: @json($salesLabels),
                        datasets: [{
                            label: 'Penjualan',
                            data: @json($salesData),
                            borderColor: 'rgb(59, 130, 246)',
                            backgroundColor: 'rgba(59, 130, 246, 0.1)',
                            borderWidth: 2,
                            fill: true,
                            tension: 0.4,
                            pointBackgroundColor: 'rgb(59, 130, 246)',
                            pointBorderColor: '#fff',
                            pointBorderWidth: 2,
                            pointRadius: 5
                        }]
                    },
                    options: {
                        responsive: true,
                        plugins: {
                            legend: {
                                display: false,
                                labels: { font: { size: 12 } }
                            }
                        },
                        scales: {
                            y: {
                                beginAtZero: true,
                                ticks: { font: { size: 12 } }
                            },
                            x: { ticks: { font: { size: 12 } } }
                        }
                    }
                });
            }, 100);
        })();
    </script>
    @endpush
</div>
