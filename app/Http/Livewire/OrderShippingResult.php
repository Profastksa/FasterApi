<?php

namespace App\Http\Livewire;

use App\Models\Order;
use Livewire\Component;

class OrderShippingResult extends Component
{

    public function render()
    {

        $messages = session()->get("messages");
        $OrderErrors = collect($messages["errors"]);

        $details = $OrderErrors->union($messages["success"]);

        $errors_ids = $OrderErrors->keys();
        $orders_id = $details->keys();
        $orders = Order::with("Shipping")->find($orders_id);
        $details = ($details->toArray());

        // dd($errors->getBag());
        return view('livewire.order-shipping-result',
        ["data" => $orders, "details" => $details, "errors_ids" =>$errors_ids]
        )->layout("layouts.master");
    }
}
