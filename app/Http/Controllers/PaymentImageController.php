<?php

namespace App\Http\Controllers;

use App\Models\NetworkPayment;
use Illuminate\Http\Request;

class PaymentImageController extends Controller
{
    public function AttachImageToOrder(Request $Request)
    {
        // dd('AttachPaymentImageToOrder');
        $Request->validate([
            'order_id' => 'required|exists:orders,id',
            'image' => 'required'
        ]);
        try {
            $payment = NetworkPayment::AttachMUltiFIleFiles([$Request->image], 'orders', $Request);
            $data = ['status' => true, 'message' => 'Image Is Attached Success'];
            return response()->json($data, 200);
        } catch (\Throwable $th) {
            // return $th->getMessage();
            $data = ['status' => false, 'message' => 'Some Thing Went Wrong'];
            return response()->json($data, 500);
        }
    }
}
