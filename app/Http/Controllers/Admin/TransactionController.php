<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Transaction;
use Illuminate\Http\Request;

class TransactionController extends Controller
{
    public function index(Request $request)
{
    // Mengambil input pencarian
    $search = $request->input('search');

    // Query dasar transaksi
    $query = Transaction::query();

    // Jika ada input pencarian
    if ($search) {
        $query->whereHas('user', function($q) use ($search) {
            $q->where('name', 'like', '%' . $search . '%');
        })->orWhereHas('video', function($q) use ($search) {
            $q->where('title', 'like', '%' . $search . '%');
        })->orWhere('order_id', 'like', '%' . $search . '%');
    }

    // Mendapatkan hasil query dengan pagination
    $transactions = $query->with(['user', 'video'])->paginate(10);

    // Mengirimkan data ke view
    return view('admin.transactions.index', compact('transactions'));
}
}
