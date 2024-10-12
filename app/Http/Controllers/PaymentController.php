<?php

namespace App\Http\Controllers;

use App\Models\Transaction;
use App\Models\Video;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Midtrans\Config;
use Midtrans\Snap;
use Illuminate\Support\Facades\Log;

class PaymentController extends Controller
{
    public function purchase(Video $video)
    {
        if ($video->price <= 0) {
            return redirect()->route('videos.show', $video);
        }

        return view('payments.purchase', compact('video'));
    }

    public function createPayment(Request $request, Video $video)
    {
        // Validasi input
        $request->validate([
            'amount' => 'required|numeric',
            'video_id' => 'required|integer',
        ]);

        // Konfigurasi Midtrans
        Config::$serverKey = config('midtrans.server_key'); // Pastikan server key benar
        Config::$isProduction = false; // Set true untuk produksi
        Config::$isSanitized = true;
        Config::$is3ds = true;

        // Buat transaksi
        $order_id = 'order-' . time(); // generate order id unik
        $transaction_details = [
            'order_id' => $order_id,
            'gross_amount' => $request->amount, // Jumlah pembayaran
        ];

        // Item yang dibeli (bisa video)
        $item_details = [
            [
                'id' => 'video_' . $video->id,
                'price' => $video->price,
                'quantity' => 1,
                'name' => $video->title,
            ],
        ];

        // Data pembeli
        $customer_details = [
            'first_name' => $request->user()->name,
            'email' => $request->user()->email,
        ];

        // Parameter ke Midtrans
        $params = [
            'transaction_details' => $transaction_details,
            'item_details' => $item_details,
            'customer_details' => $customer_details,
        ];

        try {
            // Generate Snap Token dari Midtrans
            $snapToken = Snap::getSnapToken($params);

            // Simpan transaksi sementara di database
            $transaction = new Transaction();
            $transaction->order_id = $order_id; // Simpan order_id
            $transaction->user_id = $request->user()->id; // Simpan user_id
            $transaction->video_id = $video->id; // Simpan video_id
            $transaction->amount = $request->amount; // Simpan jumlah
            $transaction->payment_status = 'pending'; // Status awal
            $transaction->save(); // Simpan ke database

            return response()->json(['snap_token' => $snapToken]);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Payment processing error: ' . $e->getMessage()], 500);
        }
    }

    public function paymentCallback(Request $request)
    {
        // Handle callback dari Midtrans
        $data = json_decode($request->getContent(), true);

        // Log untuk debugging
        Log::info('Midtrans Callback: ', $data);

        // Pastikan ada order_id dan transaction_status
        if (!isset($data['order_id'], $data['transaction_status'], $data['gross_amount'])) {
            return response()->json(['status' => 'fail', 'message' => 'Invalid data'], 400);
        }

        // Cari transaksi berdasarkan order_id
        $transaction = Transaction::where('order_id', $data['order_id'])->first();

        if (!$transaction) {
            return response()->json(['status' => 'fail', 'message' => 'Transaction not found'], 404);
        }

        // Update status transaksi sesuai hasil pembayaran
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

        $transaction->save(); // Simpan status terbaru ke database

        return response()->json(['status' => 'success'], 200);
    }
}
