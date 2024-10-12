<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Video;
use App\Models\Transaction;
use Illuminate\Support\Facades\Storage;

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

    public function download(Video $video)
    {
    $user = Auth::user();

    // Pastikan user sudah membeli video ini
    $transaction = Transaction::where('user_id', $user->id)
        ->where('video_id', $video->id)
        ->where('payment_status', 'completed') // Pastikan pembelian sudah selesai
        ->first();

    if (!$transaction) {
        return redirect()->route('videos.index')->with('error', 'Anda belum membeli video ini.');
    }

    // Path ke file video
    $filePath = storage_path('app/public/' . $video->video_path);

    // Pastikan file ada
    if (!file_exists($filePath)) {
        return redirect()->route('videos.index')->with('error', 'Video tidak ditemukan.');
    }

    // Kirim file ke user
    return response()->download($filePath, $video->title . '.mp4');
    }




    
}
