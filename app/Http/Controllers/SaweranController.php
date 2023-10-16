<?php

namespace App\Http\Controllers;

use App\Models\Saweran;
use Illuminate\Http\Request;

class SaweranController extends Controller
{
    public function __construct()
    {
        \Midtrans\Config::$serverKey = config('services.midtrans.serverKey');
        \Midtrans\Config::$isProduction = config('services.midtrans.isProduction');
        \Midtrans\Config::$isSanitized = config('services.midtrans.isSanitized');
        \Midtrans\Config::$is3ds = config('services.midtrans.is3ds');
    }

    public function index(){
        $sawerans = Saweran::orderBy('id', 'desc')->paginate(8);
        return view('welcome', compact('sawerans'));
    }
    public function create(){
        return view('saweran');
    }

    public function store(Request $request)
    {
        \DB::transaction(function() use($request) {
            $sawer = Saweran::create([
                'sawer_code' => 'SANDBOX' . uniqid(),
                'sawer_name' => $request->sawer_name,
                'sawer_email' => $request->sawer_email,
                'sawer_type' => $request->sawer_type,
                'amount' => floatval($request->amount),
                'note' => $request->note,
            ]);

            $payload = [
                'transaction_details' => [
                    'order_id'      => $sawer->sawer_code,
                    'gross_amount'  => $sawer->amount,
                ],
                'customer_details' => [
                    'first_name'    => $sawer->sawer_name,
                    'email'         => $sawer->sawer_email,
                    // 'phone'         => '08888888888',
                    // 'address'       => '',
                ],
                'item_details' => [
                    [
                        'id'       => $sawer->sawer_type,
                        'price'    => $sawer->amount,
                        'quantity' => 1,
                        'name'     => ucwords(str_replace('_', ' ', $sawer->sawer_type))
                    ]
                ]
            ];
            $snapToken =  \Midtrans\Snap::getSnapToken($payload);
            $sawer->snap_token = $snapToken;
            $sawer->save();

            $this->response['snap_token'] = $snapToken;
        });

        return response()->json($this->response);
    }

    public function notification(Request $request)
    {
        $notif = new \Midtrans\Notification();
        \DB::transaction(function() use($notif) {

          $transaction = $notif->transaction_status;
          $type = $notif->payment_type;
          $orderId = $notif->order_id;
          $fraud = $notif->fraud_status;
          $sawer = Saweran::findOrFail($orderId);

          if ($transaction == 'capture') {
            if ($type == 'credit_card') {

              if($fraud == 'challenge') {
                $sawer->setStatusPending();
              } else {
                $sawer->setStatusSuccess();
              }

            }
          } elseif ($transaction == 'settlement') {

            $sawer->setStatusSuccess();

          } elseif($transaction == 'pending'){

              $sawer->setStatusPending();

          } elseif ($transaction == 'deny') {

              $sawer->setStatusFailed();

          } elseif ($transaction == 'expire') {

              $sawer->setStatusExpired();

          } elseif ($transaction == 'cancel') {

              $sawer->setStatusFailed();

          }

        });

        return;
    }
}
