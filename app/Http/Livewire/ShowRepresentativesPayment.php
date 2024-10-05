<?php

namespace App\Http\Livewire;

use App\Models\Order;
use App\Models\Representative;
use App\Models\RepresentativeOrdersPercentage;
use App\Models\RepresentativeOrdersPerDay;
use App\Models\Setting;
use Illuminate\Support\Facades\DB;
use Livewire\Component;
use Livewire\WithPagination;

class ShowRepresentativesPayment extends Component
{
    use WithPagination;

    protected $paginationTheme = 'bootstrap';
    public $representative_id;
    public $checked_orders = [];
    public $total_fees = 0;
    public $representative_deserves_calculation_method;

    public function mount()
    {
        $this->representative_deserves_calculation_method = Setting::where('key', 'representative_deserves_calculation_method')->first()->value;
    }

    public function updatedCheckedOrders($value, $row_id)
    {
        // dd($row_id);
        if ($this->representative_deserves_calculation_method == "orders_per_day") {
            if ($value) {
                $this->total_fees += RepresentativeOrdersPerDay::find($row_id)->deserve;
            } else {
                $this->total_fees -= RepresentativeOrdersPerDay::find($row_id)->deserve;
            }
        } else {
            if ($value) {
                $this->total_fees += RepresentativeOrdersPercentage::find($row_id)->deserve;
            } else {
                $this->total_fees -= RepresentativeOrdersPercentage::find($row_id)->deserve;
            }
        }
    }

    public function updatedRepresentativeId()
    {
        $this->resetInputFields();
    }

    private function resetInputFields()
    {
        $this->checked_orders = [];
        $this->total_fees = 0;
    }

    public function collectCheckedOrders()
    {
        // dd($this->checked_orders);
        if ($this->total_fees > 0) {
            try {

                if ($this->representative_deserves_calculation_method == 'orders_per_day') {
                    //ORDERS PER DAY PROCESS
                    DB::transaction(function () {

                        //Insert into transactions
                        $transaction_id = insertTransaction('is_representative_payment', $this->representative_id, null, $this->total_fees);
                        foreach ($this->checked_orders as $row_id => $is_checked) {

                            $row = RepresentativeOrdersPerDay::find($row_id);
                            //update table
                            $row->update(['is_paid' => 1, "payment_date" => date('Y-m-d h:m:s'), 'transaction_id' => $transaction_id]);
                        }

                        $representative = Representative::find($this->representative_id);
                        $balance = $representative->account_balance - $this->total_fees;
                        $representative->update(['account_balance' => $balance]);
                    });
                } else {
                    //percentage process
                    DB::transaction(
                        function () {
                            //Insert into transactions
                            $transaction_id = insertTransaction('is_representative_payment', $this->representative_id, null, $this->total_fees);
                            foreach ($this->checked_orders as $row_id => $client_id) {
                                $row = RepresentativeOrdersPercentage::find($row_id);
                                //update table
                                $row->update([
                                    'is_paid' => 1,
                                    'payment_date' => date('Y-m-d h:m:s'),
                                    'transaction_id' => $transaction_id,
                                ]);
                            }
                            //update representative account balance
                            $representative = Representative::find($this->representative_id);
                            $representative_new_balance = ($representative->account_balance - $this->total_fees);
                            $representative->update(['account_balance' => $representative_new_balance]);
                        }
                    );
                }

                session()->flash('success', __('translation.fees.collection.done'));

                $this->resetInputFields();

                $this->resetPage();
            } catch (\Throwable $th) {
                dd($th);
                session()->flash('error', __('translation.fees.collection.error'));
            }
        } else {
            session()->flash('error', __('translation.no.order.chosen.error'));
        }
    }

    public function render()
    {
        // dd($this->representative_deserves_calculation_method);

        if ($this->representative_deserves_calculation_method == "orders_per_day") {
            $representatives = DB::table('representatives')->selectRaw('representatives.*')->get();
            foreach ($representatives as $key => $value) {
                $value->orders_count = RepresentativeOrdersPerDay::where(['representative_id' => $value->id, 'is_paid' => '0'])->count();
            }
            // $this->data = Order::whereRepresentativeIdAndStatus($this->representative_id, 'completed')->isDeleted()->paginate(10);
            //order
            $data = RepresentativeOrdersPerDay::where(['representative_id' => $this->representative_id, 'is_paid' => 0])
                ->where('date', 'NOT LIKE', date('Y-m-d') . '%')->paginate();
        } else {
            $representatives = DB::table('representatives')->selectRaw('representatives.*')->get();
            foreach ($representatives as $key => $value) {
                $value->orders_count = RepresentativeOrdersPercentage::where(['representative_id' => $value->id, 'is_paid' => '0'])->count();
            }
            // $data = RepresentativeOrdersPercentage::where(['representative_id' => $this->representative_id, 'is_paid' => 0])->paginate();
            $data = DB::table('representative_orders_percentages')->selectRaw('representative_orders_percentages.id, representative_orders_percentages.deserve, orders.id as order_id, orders.total_fees')
                ->join('orders', 'orders.id', '=', 'representative_orders_percentages.order_id')
                ->where(['representative_orders_percentages.representative_id' => $this->representative_id, 'is_paid' => 0])->paginate();
        }
        return view('livewire.show-representatives-payment', [
            'data' => $data,
            'representatives' => $representatives,
        ]);
    }
}
