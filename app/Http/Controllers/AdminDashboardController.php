<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Video;
use App\Models\Transaction;

class AdminDashboardController extends Controller
{
    /**
     * Menampilkan dashboard admin.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        // Mengambil data jumlah total
        $totalUsers = User::count();
        $totalVideos = Video::count();
        $totalTransactions = Transaction::count();
        $totalRevenue = Transaction::sum('amount');

        // Mengambil 5 transaksi terakhir
        $recentTransactions = Transaction::with('user', 'video')->latest()->take(5)->get();

        // Mengambil 10 video terbaru
        $videos = Video::with('user')->latest()->take(10)->get();

        // Mengambil 5 user terakhir yang mendaftar
        $latestUsers = User::latest()->take(5)->get();

        return view('admin.dashboard', [
            'totalUsers' => $totalUsers,
            'totalVideos' => $totalVideos,
            'totalTransactions' => $totalTransactions,
            'totalRevenue' => $totalRevenue,
            'recentTransactions' => $recentTransactions,
            'videos' => $videos,
            'latestUsers' => $latestUsers, // Mengirim data pengguna terbaru ke view
        ]);
    }
}
