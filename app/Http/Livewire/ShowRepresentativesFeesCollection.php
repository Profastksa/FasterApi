<?php

namespace App\Http\Livewire;

use App\Events\SendNotifcationWithFireBase;
use App\Models\Client;
use App\Models\Order;
use App\Models\OrderRange;
use App\Models\Representative;
use App\Models\RepresentativeOrdersPercentage;
use App\Models\RepresentativeOrdersPerDay;
use App\Models\SerialSetting;
use App\Models\Setting;
use App\Models\Transaction;
use App\Models\TransactionsType;
use Livewire\Component;
use Livewire\WithPagination;
use Illuminate\Support\Facades\DB;
use App\Exceptions\NotifcationException;

class ShowRepresentativesFeesCollection extends Component
{
    use WithPagination;

    protected $paginationTheme = 'bootstrap';
    public $representative_id;
    public $checked_orders = [],$selectedOrders = [];
    public $order_value = 0,$allSelected=FALSE;

    public function updatedCheckedOrders($value, $order_id)
    {
        // dd($order_id);
        if ($value) {
            $this->order_value += Order::find($order_id)->order_value;
        } else {
            $this->order_value -= Order::find($order_id)->order_value;
        }

    }

    public function toggleSelectAll()
    {
        if ($this->allSelected) {
            $this->checked_orders = $this->getOrders()->pluck('id','id')->toArray();
            $this->order_value = $this->getOrders()->sum("order_value");
        } else {
            $this->checked_orders = [];
            $this->order_value = 0;
        }

    }


    public function updatedRepresentativeId()
    {
        $this->resetInputFields();
    }

    private function resetInputFields()
    {
        $this->checked_orders = [];
        $this->order_value = 0;
    }

    public function collectCheckedOrders()
    {
        if ($this->order_value > 0  OR $this->checked_orders > 0 ) {
            try {
                // dd($this->checked_orders);
                // $representative_deserves_calculation_method = Setting::where('key', 'representative_deserves_calculation_method')->first()->value;
                // if ($representative_deserves_calculation_method == 'orders_per_day') {
                //     $representative_todays_orders = RepresentativeOrdersPerDay::where('date', 'like', date('Y-m-d') . '%')->where('representative_id', $this->representative_id)->first();
                //     // dd($representative_todays_orders);

                //     if ($representative_todays_orders) {
                //         // has orders today
                //         $order_range = OrderRange::where('from', '<', count($this->checked_orders))->where('to', '>', count($this->checked_orders))->first();
                //         if ($order_range) {
                //             // return '1';
                //             // dd($representative_todays_orders);
                //             DB::transaction(
                //                 function () use ($representative_todays_orders, $order_range) {
                //                     //update rep today's deserves
                //                     $rep_new_deserve = $representative_todays_orders->deserve + $order_range->price;

                //                     $rep_new_orders_count = $representative_todays_orders->orders_count + count($this->checked_orders);

                //                     $representative_todays_orders->update(['orders_count' => $rep_new_orders_count, 'deserve' => $rep_new_deserve]);

                //                     // update rep balance
                //                     $rep = Representative::find($this->representative_id);

                //                     $rep_new_balance = $rep->account_balance + $order_range->price;

                //                     $rep->update(['account_balance' => $rep_new_balance]);

                //                     //insert into transaction
                //                     // $transaction_id = insertTransaction('is_fees_collection', $this->representative_id, null, $order_range->price);
                //                 }
                //             );
                //         } else {
                            //orders count exceeded max order range
                        //     $exceeding_order_ranges_bounce = Setting::where('key', 'exceeding_order_ranges_bounce')->first()->value;
                        //     $max_orders_range = OrderRange::max('to');
                        //     // dd($max_orders_range);
                        //     $deserve = (count($this->checked_orders) - $max_orders_range) * $exceeding_order_ranges_bounce;

                        //     DB::transaction(
                        //         function () use ($representative_todays_orders, $deserve) {

                        //             //update rep today's deserves
                        //             $rep_new_deserve = $representative_todays_orders->deserve + $deserve;

                        //             $rep_new_orders_count = $representative_todays_orders->orders_count + count($this->checked_orders);

                        //             $representative_todays_orders->update(['orders_count' => $rep_new_orders_count, 'deserve' => $rep_new_deserve]);

                        //             // update rep balance
                        //             $rep = Representative::find($this->representative_id);

                        //             $rep_new_balance = $rep->account_balance + $deserve;

                        //             $rep->update(['account_balance' => $rep_new_balance]);

                        //             //insert into transaction
                        //             // $transaction_id = insertTransaction('is_fees_collection', $this->representative_id, null, $this->total_fees);
                        //         }
                        //     );
                        // }
                    // } else {
                        // doesn't have orders today
                        // $order_range = OrderRange::where('from', '<', count($this->checked_orders))->where('to', '>', count($this->checked_orders))->first();
                        // if ($order_range) {
                        //     DB::transaction(
                        //         function () use ($representative_todays_orders, $order_range) {
                        //             //insert rep today's deserves

                        //             RepresentativeOrdersPerDay::create(['orders_count' => count($this->checked_orders), 'deserve' => $order_range->price, 'representative_id' => $this->representative_id]);

                        //             // update rep balance
                        //             $rep = Representative::find($this->representative_id);

                        //             $rep_new_balance = $rep->account_balance + $order_range->price;

                        //             $rep->update(['account_balance' => $rep_new_balance]);
                        //         }
                        //     );
                        // } else {
                            //orders count exceeded max order range
                //             $exceeding_order_ranges_bounce = Setting::where('key', 'exceeding_order_ranges_bounce')->first()->value;
                //             $max_orders_range = OrderRange::max('to');
                //             // dd($max_orders_range);
                //             $deserve = (count($this->checked_orders) - $max_orders_range) * $exceeding_order_ranges_bounce;

                //             DB::transaction(
                //                 function () use ($representative_todays_orders, $deserve) {

                //                     //insert rep today's deserves
                //                     RepresentativeOrdersPerDay::create(['orders_count' => count($this->checked_orders), 'deserve' => $deserve, 'representative_id' => $this->representative_id]);

                //                     // update rep balance
                //                     $rep = Representative::find($this->representative_id);

                //                     $rep_new_balance = $rep->account_balance + $deserve;

                //                     $rep->update(['account_balance' => $rep_new_balance]);
                //                 }
                //             );
                //         }
                //     }
                // } else {
                //     //percentage process
                //     DB::transaction(
                //         function () {
                //             $rep_percentage = Setting::where('key', 'representative_percentage')->first()->value;
                //             $representative = Representative::find($this->representative_id);
                //             foreach ($this->checked_orders as $order_id => $client_id) {
                //                 //update account balance
                //                 $order = Order::find($order_id);
                //                 $rep_deserves = $order->delivery_fees * ($rep_percentage / 100);
                //                 $representative_account_balance = $representative->account_balance;
                //                 $representative_new_balance = ($rep_deserves + $representative_account_balance);
                //                 $representative->update(['account_balance' => $representative_new_balance]);

                //                 //insert transaction


                //                 //add representative deserves
                //                 // RepresentativeOrdersPercentage::create([
                //                 //     'representative_id' => $this->representative_id,
                //                 //     'order_id' => $order_id,
                //                 //     'deserve' => $rep_deserves,
                //                 // ]);
                //             }
                //         }
                //     );
                // }

                //applicable to all cases
                DB::transaction(
                    function () {
                        //Insert into transactions
                        //$transaction_id = insertTransaction('is_fees_collection', $this->representative_id, null, $this->order_value);

                        foreach ($this->checked_orders as $order_id => $client_id) {
                            // dd($this->checked_orders);
                            $order = Order::find($order_id);
                            //Give Representative deserves
                            // $representative_deserves = $order->representative_deserves;
                            // $representative = Representative::find($this->representative_id);
                            // $representative_account_balance = $representative->account_balance;
                            // $representative_new_balance = ($representative_deserves + $representative_account_balance);
                            // $representative->update(['account_balance' => $representative_new_balance]);

                            //Give Client deserves
                           // $order_value = $order->order_value;
                            // if ($order_fees > 0) {
                            //     $client = Client::find($client_id);
                            //     $client_account_balance = $client->account_balance;
                            //     $client_new_balance = ($order_fees + $client_account_balance);
                            //     $client->update(['account_balance' => $client_new_balance]);
                            // }
                            //change order Status and is_company_fees_collected flag
                            $order->update([
                                'status' => 'completed',
                                'is_company_fees_collected' => 1
                            ]);
                        }
                    }
                );
                session()->flash('success', __('translation.fees.collection.done'));
                $this->resetInputFields();
                $representative = Representative::find($this->representative_id);
              //  event(new SendNotifcationWithFireBase($representative->message_token , __('translation.CollectionMnagement') , __('translation.CollecionWasDoneSuccessfuly')));
                $this->resetPage();
            // }catch(NotifcationException $Ne){
            //     session()->flash('error' ,__('translation.Notification_Send_Error'));
             }
            catch (\Throwable $th) {
                dd($th);
                session()->flash('error', __('translation.fees.collection.error'));
            }
        } else {
            session()->flash('error', __('translation.no.order.chosen.error'));
        }
    }
    public function getOrders()
    {
return Order::whereRepresentativeIdAndStatus($this->representative_id, 'delivered')->isDeleted()->paginate(50);
//->where('service_id' , 1)
    }

    public function render()
    {
        $data = $this->getOrders();
        $representatives = DB::table('representatives')->selectRaw('representatives.*')->get();
        foreach ($representatives as $key => $value) {
            $value->orders_count = Order::where(['representative_id' => $value->id, 'status' => 'delivered' ,'is_deleted' => 0]  )->count();
            //'service_id' => 1,
        }
        return view('livewire.show-representatives-fees-collection', [
            'data' =>  $data,
            'representatives' => $representatives,
        ]);
    }
}
