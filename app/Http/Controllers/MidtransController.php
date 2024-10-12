<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Midtrans\Config;
use Midtrans\Snap;
use App\Models\Transaction;
use Illuminate\Support\Facades\Log;


class MidtransController extends Controller
{
    public function createPayment(Request $request, $videoId)
{
    // Validasi input
    $request->validate([
        'amount' => 'required|numeric',
        'video_id' => 'required|integer',
    ]);

    // Konfigurasi Midtrans
    Config::$serverKey = config('midtrans.server_key');
    Config::$isProduction = false; // Ubah menjadi true untuk produksi
    Config::$isSanitized = true;
    Config::$is3ds = true;

    // Buat transaksi
    $order_id = 'order-' . time();
    $transaction_details = [
        'order_id' => $order_id,
        'gross_amount' => $request->amount,
    ];

    // Item details
    $item_details = [
        [
            'id' => $request->video_id,
            'price' => $request->amount,
            'quantity' => 1,
            'name' => 'Video Purchase',
        ],
    ];

    // Customer details
    $customer_details = [
        'first_name' => auth()->user()->name,
        'email' => auth()->user()->email,
    ];

    // Payload untuk Midtrans
    $payload = [
        'transaction_details' => $transaction_details,
        'item_details' => $item_details,
        'customer_details' => $customer_details,
    ];

    try {
        $snapToken = Snap::getSnapToken($payload);
        Log::info('Snap Token generated successfully: ' . $snapToken);
         // Simpan transaksi ke database
         $transaction = new Transaction();
         $transaction->order_id = $order_id; // Simpan order_id
         $transaction->user_id = auth()->user()->id; // Simpan user_id
         $transaction->video_id = $request->video_id; // Simpan video_id
         $transaction->amount = $request->amount; // Simpan jumlah
         $transaction->payment_status = 'success'; // Status awal
         $transaction->save(); // Simpan ke database

        return response()->json(['snap_token' => $snapToken, 'video_id' => $request->video_id]);
    } catch (\Exception $e) {
        Log::error('Error occurred while processing payment: ' . $e->getMessage());
        return response()->json(['error' => 'Payment processing error: ' . $e->getMessage()], 500);
    }
}



public function paymentCallback(Request $request)
{
    $data = json_decode($request->getContent(), true);

    // Log untuk memastikan callback diterima
    Log::info('Midtrans Callback:', $data);

    if (!isset($data['order_id'], $data['transaction_status'], $data['gross_amount'])) {
        return response()->json(['status' => 'fail', 'message' => 'Invalid data'], 400);
    }

    // Cari transaksi berdasarkan order_id
    $transaction = Transaction::where('order_id', $data['order_id'])->first();

    if (!$transaction) {
        return response()->json(['status' => 'fail', 'message' => 'Transaction not found'], 404);
    }

    // Update status transaksi
    switch ($data['transaction_status']) {
        case 'capture':
        case 'settlement':
            $transaction->payment_status = 'success';
            break;

        case 'deny':
        case 'expire':
        case 'cancel':
            $transaction->payment_status = 'failed';
            break;

        default:
            return response()->json(['status' => 'fail', 'message' => 'Unknown transaction status'], 400);
    }

    // Simpan status transaksi yang diupdate
    $transaction->save(); // Pastikan model ini disimpan ke database

    return response()->json(['status' => 'success'], 200);
}
  
}
