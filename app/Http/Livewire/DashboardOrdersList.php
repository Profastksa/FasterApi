<?php

namespace App\Http\Livewire;

use App\Models\Order;
use Livewire\Component;

class DashboardOrdersList extends Component
{
    public $data;
    public function getOrders($status)
    {
        $this->data = Order::when($status, function ($query, $status) {
            $query->where('status', $status);
        })->isDeleted()->orderBy('order_date', 'DESC')->limit(10)->get();
    }

    public function mount()
    {
        $this->data = Order::IsDeleted()->orderBy('order_date', 'desc')->limit(10)->get();
    }
    public function render()
    {
        return view('livewire.dashboard-orders-list', [
            'data' => $this->data,
        ]);
    }
}
