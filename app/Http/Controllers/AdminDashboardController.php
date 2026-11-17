<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\User;
use Illuminate\Contracts\View\View;

class AdminDashboardController extends Controller
{
    public function index(): View
    {
        // Total seluruh produk
        $totalProducts = Product::count();

        // Total produk berdasarkan jenis
        $typeResults = Product::query()
            ->selectRaw('LOWER(type) as type, COUNT(*) as total')
            ->whereNotNull('type')
            ->groupByRaw('LOWER(type)')
            ->pluck('total', 'type');

        // Jenis produk yang tersedia
        $typeCounts = [
            'jual' => (int) ($typeResults['sale'] ?? 0),
            'sewa' => (int) ($typeResults['rent'] ?? 0),
        ];

        // Preview 4 produk terbaru
        $previewProducts = Product::latest()
            ->take(3)
            ->get();


        // Total produk berdasarkan kategori
        $categoryCounts = Product::query()
            ->select('category')
            ->selectRaw('COUNT(*) as total')
            ->whereNotNull('category')
            ->where('category', '<>', '')
            ->groupBy('category')
            ->orderBy('category')
            ->get();

        return view('admin.dashboard', compact(
            'totalProducts',
            'typeCounts',
            'categoryCounts',
            'previewProducts'
        ));
    }
}
