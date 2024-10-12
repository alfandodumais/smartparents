<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Video;
use App\Models\Transaction;

class UserDashboardController extends Controller
{
    /**
     * Show the user's purchased videos.
     *
     * @return \Illuminate\View\View
     */
    public function dashboard()
    {
        // Mendapatkan user yang sedang login
        $user = Auth::user();

        // Mengambil transaksi user untuk menampilkan video yang telah dibeli
        $transactions = Transaction::where('user_id', $user->id)
            ->where('payment_status', 'completed') // Hanya menampilkan transaksi sukses
            ->with('video') // Include relasi video
            ->get();

        // Tampilkan halaman dashboard dengan daftar video yang telah dibeli
        return view('user.dashboard', [
            'transactions' => $transactions,
            'user' => $user,
        ]);
    }
}
