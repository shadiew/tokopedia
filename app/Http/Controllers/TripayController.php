<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\Payment;
use App\Models\Settings;
use Illuminate\Support\Facades\Log;

class TripayController extends Controller
{
    public function callback(Request $request)
    {
        $settings = Settings::getSettings();
        $privateKey = $settings->tripay_privatekey;
        $json = file_get_contents('php://input');
        $signature = hash_hmac('sha256', $json, $privateKey);
        $callbackSignature = $request->header('X-Callback-Signature');
        if ($signature !== $callbackSignature) {
            Log::warning('Tripay callback signature mismatch', ['expected' => $signature, 'got' => $callbackSignature]);
            return response()->json(['success' => false, 'message' => 'Invalid signature'], 403);
        }
        $data = json_decode($json, true);
        if (!$data || empty($data['reference'])) {
            return response()->json(['success' => false, 'message' => 'Invalid data'], 400);
        }
        $reference = $data['reference'];
        $status = $data['status'] ?? null;
        $paidAt = $data['paid_at'] ?? null;
        $order = Order::whereHas('payment', function($q) use ($reference) {
            $q->where('transaction_id', $reference);
        })->first();
        if (!$order) {
            Log::warning('Tripay callback: order not found', ['reference' => $reference]);
            return response()->json(['success' => false, 'message' => 'Order not found'], 404);
        }
        $payment = $order->payment;
        if ($status === 'PAID' || $status === 'paid' || $status === 'SUCCESS' || $status === 'success') {
            $order->status = 'paid';
            $payment->status = 'success';
            $payment->paid_at = $paidAt ? date('Y-m-d H:i:s', $paidAt) : now();
        } elseif ($status === 'EXPIRED' || $status === 'FAILED' || $status === 'CANCEL' || $status === 'FAILED') {
            $order->status = 'failed';
            $payment->status = 'failed';
        } else {
            $order->status = 'pending';
            $payment->status = 'pending';
        }
        $payment->payment_details = json_encode($data);
        $order->save();
        $payment->save();
        return response()->json(['success' => true]);
    }
} 