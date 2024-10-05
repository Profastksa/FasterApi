<?php

namespace App\Http\Livewire;

use App\Models\Order;
use App\Models\Representative;
use Exception;
use Livewire\Component;
use App\Models\orderTracking;
use Illuminate\Support\Carbon;

use DB;

class MultiOrderMangement extends Component
{

    public $orders, $reps,  $AddedID, $ids = [], $Status = ['pending', 'pickup', 'inProgress', 'delivered', 'completed'];
    public $NewRep,  $NewStatus, $NewStatus1="5", $NewStatus2="0";
    protected $listeners  = ['OrdesRetrive',  'refreshComponent' => '$refresh'];


    public function  mount()
    {
        $this->orders = [];
        $this->reps = Representative::all();
    }

    public function OrdesRetrive()
    {
        try {
            DB::beginTransaction();
            $orders = Order::whereIn('tracking_number', $this->ids)->get();//Order::find($this->ids);

            foreach ($orders as $key => $order) {



                $existingOrder = Order::where('tracking_number',  $order->tracking_number.'-04')->where('is_deleted',0)->get();
                if($existingOrder->count()>0)
                    continue;




                $newOrder = $order->replicate();
                $newOrder->created_at = Carbon::now();
                $newOrder->order_date = Carbon::now();
                $newOrder->tracking_number =    $newOrder->tracking_number.'-04';
                $newOrder->save();

                $newOrder->update([
                    'sender_name' => $order->receiver_name,
                    'sender_phone' => $order->receiver_phone_no,
                    'sender_area_id' => $order->receiver_area_id,
                    'sender_sub_area_id' => $order->receiver_sub_area_id,
                    'sender_address' => $order->receiver_address,
                    'receiver_name' => $order->sender_name,
                    'receiver_phone_no' => $order->sender_phone,
                    'receiver_area_id' => $order->sender_area_id,
                    'receiver_sub_area_id' => $order->sender_sub_area_id,
                    'receiver_address' => $order->sender_address,
                    'service_id' => 4,
                    'staus'=>'pending',
                    'order_fees'=>'0',
                    'order_value'=>'0',
                    'orderRef'=>$order->tracking_number,
                ]);

               // $newOrder->save();
               // $order->update(['staus'=>'complated']);

                 orderTracking::insertOrderTracking($newOrder->id,'مرتجع','تم سترجاع الطلب ','Admin', auth()->user()->id);


                $this->removeFromOrder($order->id);

                // throw new  Exception("Error Processing Request", 1);
            }

            DB::commit();
            $this->emit('OrdersOprationSuccess');
        } catch (\Throwable $th) {
            DB::rollback();
            $this->emit('ErrorException');
        }
    }
    public function AddIdToIds()
    {
        $this->validate(
            [
                'AddedID' => 'integer|exists:orders,tracking_number'
            ],
            [
                'integer' => 'يجب ان يكوت الحقل رقمي',
                'exists' => 'رقم الطلب غير موجود',
            ]
        );
        array_push($this->ids, $this->AddedID);
        $this->orders = Order::whereIn('tracking_number', $this->ids)->get();
        $this->AddedID = '';
    }
    //  remove Order From List  ##########################
    public function removeFromOrder($id)
    {
        $this->ids = array_filter($this->ids, fn ($el) => $el != $id);
        $this->orders = Order::whereIn('tracking_number', $this->ids)->get();
    }
    // change Orders Status        ########################
    public function ChangeOrdersStatus()
    {
        Order::whereIn('tracking_number', $this->ids)->update(['status' => $this->NewStatus]);
        $this->orders = Order::whereIn('tracking_number', $this->ids)->get();
         $orders = Order::find($this->ids);
            foreach ($orders as $key => $order) {
         // orderTracking::insertOrderTracking($order->id,'مرتجعع','تم سترجاع الطلب ','Admin', auth()->user()->id);
         orderTracking::insertOrderTracking($order->id,$this->NewStatus,'تم تغير حالة الطلب','Admin', auth()->user()->id);
            }
                // dd('OrdersOprationSuccess');
        $this->emit('hidemodel');


    }


    public function ReturnOrderAfterDeliveryfailld0()
    {
        Order::whereIn('tracking_number', $this->ids)->update(['service_id' => $this->NewStatus1]);
        $this->orders = Order::whereIn('tracking_number', $this->ids)->get();
         $orders = Order::find($this->ids);
            foreach ($orders as $key => $order) {
         // orderTracking::insertOrderTracking($order->id,'مرتجعع','تم سترجاع الطلب ','Admin', auth()->user()->id);
        //orderTracking::insertOrderTracking($order->id,'استرجاع الطلبات بعد الشحن','','Admin', auth()->user()->id);

                // orderTracking::insertOrderTracking($order->id,'مرتجعع','تم سترجاع الطلب ','Admin', auth()->user()->id);
        orderTracking::insertOrderTracking($order->id,'استرجاع الطابات بعد  الشحن','تم تغير الخدمة','Admin', auth()->user()->id);

            }

        $this->emit('hidemodel');
    }


    public function ReturnOrderAfterDeliveryfailld()
    {
        //dd('ReturnOrderAfterDeliveryfailld');
        try {
            DB::beginTransaction();
            $orders = Order::whereIn('tracking_number', $this->ids)->get();//Order::find($this->ids);

            $this->ids = [];
            foreach ($orders as $key => $order) {

                $existingOrder = Order::where('tracking_number',  $order->tracking_number.'-05')->where('is_deleted',0)->get();
                if($existingOrder->count()>0)
                    continue;
                $newOrder = $order->replicate();

                $newOrder->created_at = Carbon::now();
                $newOrder->order_date = Carbon::now();
                $newOrder->tracking_number =    $newOrder->tracking_number.'-05';
                 $newOrder->save();

                //dd($newOrder);
                // Update specific fields in the new order
                $newOrder->update([
                    'sender_name' => $order->receiver_name,
                    'sender_phone' => $order->receiver_phone_no,
                    'sender_area_id' => $order->receiver_area_id,
                    'sender_sub_area_id' => $order->receiver_sub_area_id,
                    'sender_address' => $order->receiver_address,
                    'receiver_name' => $order->sender_name,
                    'receiver_phone_no' => $order->sender_phone,
                    'receiver_area_id' => $order->sender_area_id,
                    'receiver_sub_area_id' => $order->sender_sub_area_id,
                    'receiver_address' => $order->sender_address,
                    'service_id' => 5,
                    'staus'=>'pending',
                    'order_fees'=>'0',
                    'order_value'=>'0',
                    'orderRef'=>$order->tracking_number,
                ]);

               // $newOrder->save();

                $order->update([
                    'status'=>'canceled',
                    'representative_id'=>null,
                ]);

                orderTracking::insertOrderTracking($newOrder->id,'استرجاع الطابات بعد  الشحن','تم تغير الخدمة','Admin', auth()->user()->id);
                orderTracking::insertOrderTracking($order->id,'استرجاع الطابات بعد الشحن','تم تغير الخدمة','Admin', auth()->user()->id);
                array_push($this->ids, $newOrder->tracking_number);
                $this->orders = Order::whereIn('tracking_number', $this->ids)->where('is_deleted',0)->get();

                //$this->removeFromOrder($order->id);

                // throw new  Exception("Error Processing Request", 1);
            }

            DB::commit();
            $this->emit('OrdersOprationSuccess');
        } catch (\Throwable $th) {
            DB::rollback();
            dd($th);
            $this->emit('ErrorException');
        }
    }

    public function ChangeOrdersStatus2()
    {
        Order::whereIn('tracking_number', $this->ids)->update(['representative_id' => $this->NewStatus2]);
        $this->orders = Order::whereIn('tracking_number', $this->ids)->get();
         $orders = Order::find($this->ids);
            foreach ($orders as $key => $order) {


        orderTracking::insertOrderTracking($order->id,$this->NewStatus2,',وصلت الشحنة الى مركز بروفاست لفرز الشحنات,  ','Admin', auth()->user()->id);

            }


        $this->emit('hidemodel');
    }

    public function ChangeRep()
    {
        // dd($this->NewRep);
        Order::whereIn('tracking_number', $this->ids)->update(['representative_id' => $this->NewRep]);
        $this->orders = Order::whereIn('tracking_number', $this->ids)->get();
         $orders = Order::find($this->ids);
            foreach ($orders as $key => $order) {


        orderTracking::insertOrderTracking($order->id,'مندوب','تم تغير المندوب','Admin', auth()->user()->id);

            }


        $this->emit('hidemodel');
    }
    public function render()
    {
        return view('livewire.multi-order-mangement', [
            "orders" => $this->orders,
            'representatives' => Representative::all(),
        ])
            ->layout('layouts.master');;
    }
}



