<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Product;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function index(Request $request)
    {
        $user = Auth::user();

        if ($user->role === 'admin') {
            // Statistik Umum
            $totalRevenue = Order::where('status', 'completed')->sum('total_amount');
            $newOrdersCount = Order::where('status', 'pending')->count();
            $totalProducts = Product::count();
            $totalUsers = User::where('role', 'user')->count();
            $latestOrders = Order::latest()->take(5)->get();

            // Rekap Penjualan Harian (7 hari terakhir)
            $dailySales = Order::where('status', 'completed')
                ->where('created_at', '>=', Carbon::now()->subDays(7))
                ->select(DB::raw('DATE(created_at) as date'), DB::raw('sum(total_amount) as total'))
                ->groupBy('date')
                ->orderBy('date', 'asc')
                ->get();
            
            // Format data untuk Chart.js
            $dailyLabels = $dailySales->pluck('date')->map(function ($date) {
                return Carbon::parse($date)->format('d M');
            });
            $dailyData = $dailySales->pluck('total');

            // Rekap Penjualan Bulanan (12 bulan terakhir)
            $monthlySales = Order::where('status', 'completed')
                ->where('created_at', '>=', Carbon::now()->subMonths(12))
                ->select(DB::raw('YEAR(created_at) as year, MONTH(created_at) as month'), DB::raw('sum(total_amount) as total'))
                ->groupBy('year', 'month')
                ->orderBy('year', 'asc')->orderBy('month', 'asc')
                ->get();

            // Rekap Penjualan Tahunan
            $annualSales = Order::where('status', 'completed')
                ->select(DB::raw('YEAR(created_at) as year'), DB::raw('sum(total_amount) as total'))
                ->groupBy('year')
                ->orderBy('year', 'asc')
                ->get();

            return view('admin.dashboard', compact(
                'totalRevenue', 'newOrdersCount', 'totalProducts', 'totalUsers', 'latestOrders',
                'dailyLabels', 'dailyData', 'monthlySales', 'annualSales'
            ));
            
        } else {
            // Logika untuk user biasa
            $latestOrder = $user->orders()->latest()->first();
            $featuredProducts = Product::latest()->take(4)->get();
            return view('dashboard', compact('user', 'latestOrder', 'featuredProducts'));
        }
    }
}