<?php

namespace App\Livewire\Admin;

use Livewire\Component;
use Livewire\Attributes\Layout;
use App\Models\User;    
use App\Models\Product;  
use App\Models\Order;    
use Carbon\Carbon;
use App\Models\OrderItem;
use Illuminate\Support\Facades\DB;

#[Layout('components.layouts.admin')] 
class Dashboard extends Component
{
    // Tambahan: untuk dropdown filter range bulan
    public $monthRange = 12;

    public function render()
    {
        $totalUsers = User::count();
        $totalProducts = Product::count();
        $totalOrders = Order::count();

        $recentOrders = Order::with('user') 
                                ->latest()     
                                ->take(5)     
                                ->get();

        // --- Grafik Penjualan per Bulan ---
        $salesData = [];
        $salesLabels = [];


        for ($i = $this->monthRange - 1; $i >= 0; $i--) {
            $month = Carbon::now()->subMonths($i);
// Array status yang ingin dihitung
$statusArray = ['verifying', 'paid', 'processed', 'shipped', 'delivered'];

$sales = Order::whereYear('created_at', $month->year)
    ->whereMonth('created_at', $month->month)
    ->whereIn('status', $statusArray) // <-- filter beberapa status sekaligus
    ->sum('total_amount');




            $salesLabels[] = $month->format('M Y'); 
            $salesData[] = (float)$sales;

        }

        //  Query Produk Terlaris ---
        $topProducts = OrderItem::query()
            ->select('product_name', DB::raw('SUM(quantity) as total_sold'))
            ->join('orders', 'order_items.order_id', '=', 'orders.id')
            ->where('orders.status', 'paid')
            ->groupBy('product_name')
            ->orderByDesc('total_sold')
            ->take(5)
            ->get();

        return view('livewire.admin.dashboard', [
            'totalUsers' => $totalUsers,
            'totalProducts' => $totalProducts,
            'totalOrders' => $totalOrders,
            'recentOrders' => $recentOrders,
            'salesLabels' => $salesLabels,
            'salesData' => $salesData,

            'topProducts' => $topProducts,
        ]);
    }
}
