<?php

namespace App\Http\Livewire;

use App\Models\Client;
use App\Models\Order;
use App\Models\Service;
use Livewire\Component;

class ClientAccountDetials extends Component
{
    public $client, $all_toggler = false, $json_ids, $user_id = null, $from_date, $status_filter, $to_date, $ids = [], $searchTerm;

    public function uppendToids($value)
    {
        // dd($value);
        if ($this->user_id == null) {
            $this->emit('ErrorException', __('translation.no_user_is_selected'));
        }
        // dd($this->ids);
        if ($value == 'all') {
            // dd('Heelo ');
            $this->all_toggler = !$this->all_toggler;
            if ($this->all_toggler) {
                $orders = $this->getOrders();
                $ids = $orders->pluck('id')->toArray();
                $this->ids = array_merge($this->ids, $ids);
            } else {
                $this->ids = [];
            }
        } else {

            if (!in_array($value, $this->ids)) {
                array_push($this->ids, $value);
                $this->json_ids = encrypt($this->ids);
            } else {
                $this->ids  = array_filter($this->ids, fn ($el) => $el != $value);
                $this->json_ids = encrypt($this->ids);
            }
        }
    }

    public function getOrders()
    {
        // if ($this->user_id) dd($this->user_id);
        // $searchTerm = '%' . $this->searchTerm . '%';
        return  Order::with('Shipping')
            ->where('client_id', $this->user_id)
            ->ToDate($this->to_date)
            ->FromDate($this->from_date)
            ->StatusFilter($this->status_filter)
            ->IsDeleted()
            ->orderBy('id', 'desc')
            ->paginate(1000);
    }
    public function render()
    {
        $ServiceHeading = [
            1 => [
                '<div>
        <h4> COD Orders - Delivered </h4>
        <h4> الدفع عند الاستلام  - تم التوصيل  </h4> </div>  ',
                '<div>
        <h4> Orders - Delivered </h4>
        <h4> طلبات التوصيل - المدفوعه - تم التوصيل </h4> </div>  ',
            ],
            2 => '<div>
        <h4> Local shipping Orders </h4>
        <h4>  شحن الطلبات خارج المنطقة </h4> </div>',
            3 => '<div>
        <h4> Returned Orders </h4>
        <h4> اعاده الشحنات بعد اعاده التسليم</h4> </div>',
            4 => '<div>
        <h4> International shipping Orders </h4>
        <h4> شحن دولي </h4> </div>',
        ];
        $client = Client::with('orders');
        $data = $this->getOrders();

        return view(
            'livewire.client-account-detials',
            [
                'data' => $data,
                'select_client' => $client,
                'ServiceHeading' => $ServiceHeading,
                'Services' => Service::get(),
            ]
        )
            ->layout('layouts.master');
    }
}
