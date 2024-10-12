<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Video;
use App\Models\Transaction;

class UserVideoController extends Controller
{
    public function dashboard()
    {
        // Ambil semua transaksi berdasarkan user yang sedang login
        $user = auth()->user();
        $transactions = Transaction::where('user_id', $user->id)
                                   ->where('status', 'paid') // Pastikan status transaksi 'paid'
                                   ->get();

        // Ambil video yang terkait dari transaksi yang sudah dibeli
        $videos = Video::whereIn('id', $transactions->pluck('video_id'))->get();

        // Tampilkan view dashboard dengan video yang dibeli
        return view('dashboard', compact('videos'));
    }
}
