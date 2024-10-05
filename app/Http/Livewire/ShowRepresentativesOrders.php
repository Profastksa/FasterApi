<?php

namespace App\Http\Livewire;

use App\Models\Order;
use App\Models\orderTracking;
use App\Models\Representative;
use App\Models\Setting;
use Illuminate\Support\Facades\DB;
use Livewire\Component;
use Livewire\WithPagination;
use App\Events\SendNotifcationWithFireBase;
use App\Traits\SendNotifcationWithFirebaseTrait;
use Exception;

use App\Models\RepresentativeOrdersPercentage;
use App\Models\RepresentativeOrdersPerDay;
use App\Exceptions\NotifcationException;

use function PHPUnit\Framework\isEmpty;

class ShowRepresentativesOrders extends Component
{
    use WithPagination;
    protected $paginationTheme = 'bootstrap';
    protected $listeners = ["status_change_confirmation" => 'status_change_confirmed', 'representative_change_confirmation' => 'representative_change_confirmed'];
    public $representative_id, $status = "pickup";
    public $order_transfer_data;
    public $status_change_data, $ids = [], $shiping_type, $json_ids;
    public  $Status = ['pending', 'pickup', 'inProgress', 'delivered', 'completed'];
    public $NewRep,  $NewStatus, $NewStatus1 = "5", $NewStatus2 = "0";
    public $order_Collection, $iscollection = false, $RepCollectionData = [], $order_value = 0, $checked_orders = [], $Collection_representative_id, $all_toggler;
    public $paymentDetails = [];
    public $totalFees = 0;
    public $totalCash = 0;
    public $representativeModel;
    public $totalTransfer = 0;
    public $selectedOrders = [], $selectedOrdersData = [], $disabled = [];
    public $allSelected = false;



    protected $rules = [
        'RepCollectionData.*.cash_amount' => 'required|numeric|min:0',
        'RepCollectionData.*.COD_payment_method' => 'required|string', // Make it nullable
        'RepCollectionData.*.E_transfer_amount' => 'required|numeric|min:0',
        'RepCollectionData.*.E_transfer_number' => 'nullable|string'
    ];
    public function isCashAmountDisabled($index)
    {
        try {
            return $this->RepCollectionData[$index]['COD_payment_method'] === 'transfer'
                || $this->RepCollectionData[$index]['COD_payment_method'] === 'cash_transfer';
        } catch (\Throwable $th) {

            return false;
        }
    }

    public function isTransferAmountDisabled($index)
    {
        try {
        return $this->RepCollectionData[$index]['COD_payment_method'] === 'cash'
            || $this->RepCollectionData[$index]['COD_payment_method'] === 'cash_transfer';
        } catch (\Throwable $th) {

            return false;
        }
    }


    public function mount()
    {
        // Assuming $RepCollectionData is populated here or elsewhere
        // Initialize paymentDetails for each order
        foreach ($this->RepCollectionData as $index => $order) {
            $this->paymentDetails[$index] = [
                'cash_amount' => $order->cash_amount ?? 0,
                'COD_payment_method' => isEmpty($order->COD_payment_method) ? 'Cash' : $order->COD_payment_method,
                'E_transfer_amount' => $order->E_transfer_amount ?? 0,
                'E_transfer_number' => $order->E_transfer_number ?? '',
            ];
        }
    }

    public function updatedRepCollectionData()
    {
        $this->calculateTotals();
    }


    public function calculateTotals()
    {
        $this->totalFees = 0;
        $this->totalCash = 0;
        $this->totalTransfer = 0;

        // Iterate over selected rows using $this->selectedOrders
        foreach ($this->selectedOrders as $order_id) {
            $selectedRow = $this->RepCollectionData->where('id', $order_id)->first();

            if ($selectedRow) {
                // Validate the input data before summing
                $orderValue = isset($selectedRow['order_value']) ? floatval($selectedRow['order_value']) : 0;
                $cashAmount = isset($selectedRow['cash_amount']) ? floatval($selectedRow['cash_amount']) : 0;
                $transferAmount = isset($selectedRow['E_transfer_amount']) ? floatval($selectedRow['E_transfer_amount']) : 0;

                // Ensure that the input data is numeric and non-negative
                if ($orderValue >= 0 && $cashAmount >= 0 && $transferAmount >= 0) {
                    $this->totalFees += $orderValue;
                    $this->totalCash += $cashAmount;
                    $this->totalTransfer += $transferAmount;
                } else {
                    // Handle invalid data, log an error, or take appropriate action
                    // For example, you can set an error message or throw an exception.
                    // $this->addError('RepCollectionData', 'Invalid input data');
                }
            }
        }
    }





    public function updated($propertyName)
    {
        $this->validateOnly($propertyName);
    }

    public function hydrate()
    {
        $this->emit('select2');
    }

    public function updatedStatusChangeData($status_change_data)
    {

        $status_change_data = json_decode($status_change_data);

        if ($status_change_data->status == "pending") {
            $this->emit('status_change_to_pending_confirmation', $status_change_data);
        } else {
            $this->emit('status_change_confirmation', $status_change_data);
            // dd('emit' , $status_change_data);
        }
    }
    public function ShowCollectionForRep($id)
    {
        $this->checked_orders = [];
        // $this->representative_id = $id;
        $this->Collection_representative_id = $id;
        $this->order_value = 0;
        $this->iscollection = true;
        $this->RepCollectionData = Order::whereRepresentativeIdAndStatus($id, 'delivered')->where('service_id', 1)->where('is_collected', 0)->where('is_company_fees_collected', 0)->isDeleted()->get();
    }
    public function updatedCheckedOrders($value, $order_id)
    {
        // dd($order_id);
        if ($value) {
            $this->order_value += Order::find($order_id)->order_value;
        } else {
            $this->order_value -= Order::find($order_id)->order_value;
        }
    }

    public function cancel()
    {
        $this->resetCollectionFields();
    }

    public function resetCollectionFields()
    {
        $this->checked_orders = [];
        $this->order_value = 0;
        $this->iscollection = false;
        $this->selectedOrders = [];
    }

    public function toggleSelectAll()
    {
        if ($this->allSelected) {
            $this->selectedOrders = $this->RepCollectionData->pluck('id')->toArray();
        } else {
            $this->selectedOrders = [];
        }
    }

    public function updatedRepresentativeId($id)
    {
        $this->representativeModel = Representative::find($id);
    }

    public function uppendToids($value)
    {
        if ($value == 'all') {
            $this->all_toggler = !$this->all_toggler;
            if ($this->all_toggler) {
                // Select all orders
                $this->selectedOrders = $this->data->pluck('id')->toArray();
            } else {
                // Deselect all orders
                $this->selectedOrders = [];
            }
        } else {
            if (!in_array($value, $this->selectedOrders)) {
                array_push($this->selectedOrders, $value);
            } else {
                $this->selectedOrders = array_diff($this->selectedOrders, [$value]);
            }
        }
    }
    public function MakeCollectionForRepnew()
    {
        $this->calculateTotals();

        $this->validateSelectedOrders();

        if (!empty($this->selectedOrdersData)) {
            try {


                DB::transaction(function () {
                    $transaction_id = insertTransaction('is_fees_collection', $this->Collection_representative_id, null, $this->order_value);

                    foreach ($this->selectedOrdersData as $orderData) {
                        $order = Order::find($orderData['id']);
                        if ($order) {

                            $paymentDetails = $this->paymentDetails[$orderData['id']] ?? null;

                            $order->update([
                                'status' => 'completed',
                                'is_company_fees_collected' => 1,
                                'transaction_id' => $transaction_id,
                                // Update with new payment details, ensure null safety or defaults as needed
                                'COD_payment_method' => $paymentDetails['COD_payment_method'] ?? null,
                                'cash_amount' => $paymentDetails['cash_amount'] ?? 0,
                                'E_transfer_amount' => $paymentDetails['E_transfer_amount'] ?? 0,
                                'E_transfer_number' => $paymentDetails['E_transfer_number'] ?? null,
                            ]);
                        }
                    }
                });
                $this->emit('CollectionComplted');
                session()->flash('success', __('translation.fees.collection.done'));
                $this->resetCollectionFields();
            }
            // catch (\NotificationException $Ne) {
            //     session()->flash('error', __('translation.Notification_Send_Error'));
            // }
            catch (\Throwable $th) {
               // dd($th); // Consider removing or replacing this with logging in production
                session()->flash('error', __('translation.fees.collection.error'));
            }
        } else {
            session()->flash('error', __('translation.no.order.chosen.error'));
        }


    }





    protected function validateSelectedOrders()
    {
        if (empty($this->selectedOrders)) {
            $this->addError('no_selected_rows', __('translation.no.order.chosen.error'));
            return;
        }

        if ($this->totalFees != ($this->totalCash + $this->totalTransfer)) {
            $this->addError('totalFees', 'مجموع الرسوم غير متطابق مع المجموع المحدد.');
            return;
        }

        //    dd($this->totalFees != ($this->totalCash + $this->totalTransfer ));

        $validationRules = [];
        $totalFeesValidation = false;

        foreach ($this->selectedOrders as $order_id) {
            $repCollectionArray = $this->RepCollectionData->toArray();
            $index = array_search($order_id, array_column($repCollectionArray, 'id'));

            if ($index !== false) {
                $validationRules["RepCollectionData.$index.cash_amount"] = 'required|numeric|min:0';
                $validationRules["RepCollectionData.$index.COD_payment_method"] = 'required|string';
                $validationRules["RepCollectionData.$index.E_transfer_amount"] = 'required|numeric|min:0';
                $validationRules["RepCollectionData.$index.E_transfer_number"] = 'nullable|string';


                $this->selectedOrdersData[] = $this->RepCollectionData[$index];
            }
        }





       if( !$this->validate($validationRules))
       {
        return;
       }
    }






    // change Orders Status        ########################
    public function ChangeOrdersStatus()
    {

        Order::whereIn('id', $this->ids)->update(['status' => $this->NewStatus]);
        $orders = Order::whereIn('id', $this->ids)->get();
        $orders = Order::find($this->ids);
        foreach ($orders as $key => $order) {
            orderTracking::insertOrderTracking($order->id, $this->NewStatus, 'تم تغير حالة الطلب', 'Admin', auth()->user()->id);
        }


        $this->emit('hidemodel');
        session()->flash('success', __('translation.item.updated.successfully'));
        $this->emit('updated'); // Close model to using to jquery


    }
    public function status_change_confirmed($status_change_data)
    {

        // dd($status_change_data);
        try {
            $order = Order::find($status_change_data['order_id']);
            $noteFromOuteScope  = DB::transaction(function () use ($status_change_data, $order) {
                if ($status_change_data['status'] == "pending") {
                    $order->update(['status' => $status_change_data['status'], 'representative_id' => null]);
                    // session()->flash('success', __('translation.item.updated.successfully'));
                } else if ($status_change_data['status'] == "returned") {
                    $order_return_price = Setting::where('key', 'order_return_price')->first()->value;
                    $order->update(['delivery_fees' => $order_return_price, 'status' => $status_change_data['status']]);
                    // session()->flash('success', __('translation.item.updated.successfully'));
                } else {
                    $order->update(['status' => $status_change_data['status']]);
                    // session()->flash('success', __('translation.item.updated.successfully'));
                }

                // insert into order tracking
                $user_name = auth()->user()->name;
                $Representative = Representative::find($order->representative_id);
                $note = " تم تغيير حالة الطلب الي " . $status_change_data['status'] . "  بواسطه الاداره عبر ($user_name)";
                $note_ar = __('translation.Order_status_change_to') . " " . __('translation.' . $status_change_data['status']) . " " . __('translation.By') . " " . ($user_name);
                orderTracking::insertOrderTracking($status_change_data['order_id'], __('translation.' . $status_change_data['status']), $note, 'admin', auth()->user()->id, $note_ar);
                session()->flash('success', __('translation.item.status.updated.successfully'));
                return [$note, $note_ar];
            });
            $Representative = Representative::find($order->representative_id);
            event(new SendNotifcationWithFireBase($Representative->message_token, __('translation.OrderMangemnt'), $noteFromOuteScope[1], '', $order->id));
            // dd($noteFromOuteScope[1]);
            session()->flash('sccuess', __('translation.ChangeRepreSentiveSuccessFuly'));
        } catch (NotifcationException $Ne) {
            session()->flash('error', __('translation.Notification_Send_Error'));
        } catch (\Throwable $th) {
            // dd($th);
            session()->flash('error', __('translation.error.exception'));
        }
    }



    public function updatedOrderTransferData($order_transfer_data)
    {
        $this->emit('representative_change_confirmation', $order_transfer_data);
    }
    public function representative_change_confirmed($order_transfer_data)
    {
        $order_transfer_data = json_decode($order_transfer_data);
        // dd($order_transfer_data);

        try {
            if ($order_transfer_data) {
                $order = Order::find($order_transfer_data->order_id);
                // dd($order_transfer_data['representative_id']);
                if ($order->representative_id == $order_transfer_data->representative_id) return;
                $representativeMessageToken  = Representative::find($order_transfer_data->representative_id)->message_token;
                $CancelNotification = __('translation.Notification_Cancel_order') . " " . $order_transfer_data->order_id . " " . __('translation.ByMangement');
                event(new SendNotifcationWithFireBase($representativeMessageToken, __('translation.OrderMangemnt'), $CancelNotification, '', null));
                $order->update(['representative_id' => $order_transfer_data->representative_id]);
                // insert into order tracking
                $user_name = auth()->user()->name;
                $representative2 = Representative::find($order_transfer_data->representative_id);
                $status = $order->status;
                $note = " تم تغير الطلب الي مندوب اخر ( " . $representative2->fullname . " ) بواسطه الادراه  ($user_name)";
                $note_ar = __('translation.Admin_Order_representative_change_to') . " $representative2->fullname ";
                orderTracking::insertOrderTracking($order_transfer_data->order_id, __('translation.' . $status), $note, 'admin', auth()->user()->id);
                $NotificationNote = __('translation.OrderMangemnt_Add_New_Order_You') . " " .  $order->id . " " . __('translation.ByMangement');
                $this->render();
                session()->flash('success', __('translation.ChangeRepreSentiveSuccessFuly'));
                event(new SendNotifcationWithFireBase($representative2->message_token, __('translation.OrderMangemnt'), $NotificationNote, '', null));


                // dd([ $CancelNotification , $NotificationNote ]);
            }
        } catch (NotifcationException $Ne) {
            session()->flash('error', __('translation.Notification_Send_Error'));
        } catch (\Throwable $th) {
            // dd($th);
            session()->flash('error', __('translation.error.exception'));
        }
    }


    public function render()
    {
        $representative = Representative::find($this->representative_id);

        $data = Order::when($this->representative_id, function ($query) {
            $query->where(['representative_id' => $this->representative_id]);

        })->when($this->status, function ($query) {
            if($this->status == 'running_to_delivery') {
            return $query->whereIn('status', ['inProgress', 'delivered'])->orderby("status", "DESC");
            }else{
             return $query->where(['status' => $this->status]);
            }
        })->IsDeleted()->paginate(1000);
        $this->calculateTotals();
        return view('livewire.show-representatives-orders', [
            'data' => $data,
            'representatives' => Representative::get(),
            "representative" => $representative,
        ]);
    }
}
