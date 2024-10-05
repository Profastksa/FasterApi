<?php

namespace App\Traits;

use App\Models\Order;

trait  FilterOrders {
    
 public function GetOrdersWithAllFilter($client_id ,$order_date , $to_order_date ,  $order_status)
{
    $query = Order::query();
    $query->when($client_id != null, function ($q) use($client_id) {
    $q->where('client_id' , $client_id);
    });
    $query->whereIn('status' , ['completed' , 'returned']);
    $query->when($order_date != null, function ($q) use($order_date) {
        return $q->where('order_date', '>', $order_date);
    });
    $query->when($to_order_date != null, function ($q) use($to_order_date) {
        return $q->where('order_date', '<', $to_order_date);
    });

    $query->when($order_status != null, function ($q)  use ($order_status){
        return $q->where('status', $order_status);
    });
    return  $query->get();
}
}