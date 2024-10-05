<?php

namespace App\Http\Livewire;

use App\Http\Resources\AreaService;
use App\Models\Area;
use App\Models\AreaServices;
use App\Models\Client;
use App\Models\ClientServicePrice;
use App\Models\Order;
use App\Models\orderTracking;
use App\Models\Representative;
use App\Models\RepresentativeOrdersPercentage;
use App\Models\SerialSetting;
use App\Models\Service;
use App\Models\Setting;
use App\Models\SubArea;
use Dotenv\Exception\ValidationException;
use Exception;
use Illuminate\Support\Facades\DB;
use Livewire\Component;
use Livewire\WithFileUploads;
use Livewire\WithPagination;
use Nette\Utils\Random;
use Carbon\Carbon;


class ShowOrder extends Component
{
    use WithPagination;
    use WithFileUploads;
    public $updateMode, $status_filter, $delivery_fees, $coustmer_service_Filter, $status_filter1, $cleint_filter, $ids, $shiping_type, $json_ids , $paginatenum;
    public  $Status = ['pending', 'pickup', 'inProgress', 'delivered', 'completed'];
    protected $paginationTheme = 'bootstrap';
    public $service_id, $client_id, $representative_id,
        $sender_name, $sender_phone, $sender_area_id,
        $sender_sub_area_id, $sender_address,
        $receiver_name, $receiver_phone_no,
        $receiver_area_id, $receiver_sub_area_id,
        $receiver_address, $police_file, $order_fees = 0, $is_payment_on_delivery, $payment_method = 'balance', $status, $orede_Note;
    public $is_fill_sender = 1;
    public $showCODPrice  = false;
    public $update_mode = false;
    public $order_id;
    public $searchTerm, $from_date, $to_date, $all_toggler;
    public $NewRep,  $NewStatus, $NewStatus1 = "5", $NewStatus2 = "0";
    protected $listeners = ['orderDelete'];
    // Last Edition On The Client By Mohammed Altigani Osamn
    public $order_weight = 5, $order_value = 0, $number_of_pieces = 1;
    // last edit in this class by jksa  ############################
    public $SenderSubArea, $ResevierSubArea, $SendingArea, $ResevingArea;




    public function mount()
    {
        $this->SendingArea = Area::withCount('subAreas')->get();
        $this->ResevingArea = Area::withCount('subAreas')->get();
        $this->ResevierSubArea = SubArea::get();
        $this->SenderSubArea = SubArea::get();
        $this->ids = [];
        $this->from_date = Carbon::now()->format('Y-m-d');
        $this->to_date = Carbon::now()->format('Y-m-d');
        $this->paginatenum = 50;
    }

    public function updatedServiceId($service_id)
    {
        //  dd('hello');
        $AreaSendingIds =  AreaServices::where('service_id', $service_id)->where('is_sending', 1)->get()->pluck('area_id');
        $AreaResivingIds =  AreaServices::where('service_id', $service_id)->where('is_resiving', 1)->get()->pluck('area_id');
        // $this->Area = Area::withCount('subAreas')->whereIn('id', $AreaSendingIds)->get();
        $this->ResevingArea = Area::withCount('subAreas')->whereIn('id', $AreaResivingIds)->get();
        $this->SendingArea = Area::withCount('subAreas')->whereIn('id', $AreaSendingIds)->get();
        // dd( $this->Areas);
        if ($service_id)
            $this->is_fill_sender = Service::find($service_id)->is_fill_sender;


        if ($this->service_id == 1)
            $this->showCODPrice = true;
        else
            $this->showCODPrice = false;
    }

    public function HandelServiceChange($id)
    {
      //  dd($this->service_id);
    }
    public function updatedSenderAreaId($val)
    {
        $this->SenderSubArea = SubArea::where('area_id', $val)->get();
    }
    public function updatedcoustmerserviceFilter($val)
    {

        // $this->SenderSubArea = SubArea::where('area_id', $val)->get();
    }
    public function updatedReceiverAreaId($val)
    { #receiver_area_id
        $this->updatedServiceId($this->service_id);
        $this->ResevierSubArea = SubArea::where('area_id', $val)->get();
    }
    public function HandelCahnge($id)
    {
        $id1 = $id;
        // dd($id);
    }

    // public function updatedServiceId

    public function updated()
    {
        $this->updatedServiceId($this->service_id);
    }
    public function hydrate()
    {
        $this->emit('select2');
    }

    public function orderDelete($order_id)
    {
        $status = Order::find($order_id)->update(['is_deleted' => 1]);
        if ($status) {
            session()->flash('success', __('translation.item.deleted.successfully'));
            $this->render();
        } else {
            session()->flash('success', __('translation.delete.exception'));
        }
    }

    public function updatedClientId($clientId)
    {
        try {
            //  dd($clientId);
            $this->validate(['client_id' => 'exists:clients,id']);
            $client = Client::find($clientId);

            if ($this->is_fill_sender) {
                $this->sender_name = $client->fullname;
                $this->sender_phone = $client->phone;
                $this->sender_area_id = $client->subArea->area_id;
                $this->sender_sub_area_id = $client->sub_area_id;
                $this->sender_address = $client->address;
            } else {
                $this->receiver_name = $client->fullname;
                $this->receiver_phone_no = $client->phone;
                $this->receiver_area_id = $client->subArea->area_id;
                $this->receiver_sub_area_id = $client->sub_area_id;
                $this->receiver_address = $client->address;
            }

            //  dd($client);

        } catch (Exception $e) {
        }
    }



    public function chkAll()
    {
        if ($this->all_toggler) {
            $orders = $this->getOrders();
            $ids = $this->getOrdersIds()->toArray();
            $this->ids = array_merge($this->ids, $ids);
        } else {
            $this->ids = [];
        }
        $this->json_ids = encrypt($this->ids);
    }

    public function uppendToids($value)
    {
       // $orders = $this->getOrders();
     // $ids = //$orders->pluck('id')->toArray();
        // $this->all_toggler =  Count(array_diff($ids, $this->ids)) == 0;
         $this->json_ids = encrypt($this->ids);
    }

    public function store()
    {
        $validatedData = $this->validate([
            'service_id' => 'required|exists:services,id',
            'client_id' => 'required|exists:clients,id',
            'sender_name' => 'required|string',
            'sender_area_id' => 'required|exists:areas,id',
            'sender_sub_area_id' => 'required|exists:sub_areas,id',
            'sender_address' => 'required',
            'receiver_name' => 'required|string',
            'receiver_area_id' => 'required|exists:areas,id',
            'receiver_sub_area_id' => 'required|exists:sub_areas,id',
            'receiver_address' => 'required',
            'representative_id' => 'nullable|exists:representatives,id',
            //'payment_method' => 'required|in:"on_sending", "on_receiving","balance"',
            'order_fees' => 'numeric|min:0',
            'police_file' => 'nullable|mimes:jpg,jpeg,png,bmp,svg,webp,pdf',
            'number_of_pieces' => 'required',
            'order_weight' => 'required',
            'sender_phone' => 'required|string',
            'receiver_phone_no' => 'required|string',
            'order_value' => 'numeric|min:0',
        ]);

        try {
            // $this->order_fees = 0;



            $validatedData["payment_method"] = 'balance';

            if ($this->police_file) {
                $police_file_path = $this->police_file->store('orders');
            } else {
                $police_file_path = "";
            }

            $Client = Client::find($this->client_id);
            if ($Client->is_has_custom_price) {
                $validatedData['delivery_fees'] = (double) filter_var(ClientServicePrice::where('service_id', $this->service_id)->where('client_id', $Client->id)->first()->price, FILTER_SANITIZE_NUMBER_FLOAT, FILTER_FLAG_ALLOW_FRACTION);
                $validatedData['total_fees'] = $validatedData['order_fees'] - $validatedData['delivery_fees'];
            } else {
                $validatedData['delivery_fees'] = (double) filter_var(service::find($this->service_id)->price, FILTER_SANITIZE_NUMBER_FLOAT, FILTER_FLAG_ALLOW_FRACTION);
                $validatedData['total_fees'] = $validatedData['order_fees'] - $validatedData['delivery_fees'];
            }

            $validatedData['order_date'] = date('Y-m-d H:i:s');
            $validatedData['status'] =  $this->status;
            $validatedData['police_file'] = $police_file_path;
            $validatedData['note'] = $this->orede_Note;

            //$Client = Client::find($request->client_id);

            $status = $Client->update([
                "in_accounts_order" => 1,

            ]);

            DB::transaction(function () use ($validatedData, $Client) {
                //generate invoice no
                $inv_no = SerialSetting::first()->inv_no;
                SerialSetting::first()->update(["inv_no" => ($inv_no + 1)]);
                $validatedData['invoice_sn'] = genInvNo($inv_no);
                $validatedData['tracking_number'] = orderTracking::generateUniqueTrackingNumber();
                $user_name = auth()->user()->name;
                $note = "في الطريق للاستلام من المرسل "; //" تم اضافه الطلب من قبل الاداره بواسطه ($user_name)";
                if ($this->representative_id) {
                    $representative_name = Representative::find($validatedData['representative_id'])->fullname;
                    $note .= "and assigned to representative ($representative_name)";
                } else {
                    $this->representative_id = null;
                }
                //$order_id = Order::insertGetId($validatedData);

                $newOrder = Order::create($validatedData);
                $order_id = $newOrder->id;

                //insert order tracking
                orderTracking::insertOrderTracking($order_id,  __('translation.' . $validatedData['status']), $note, 'admin', auth()->user()->id);
                $Client->account_balance = $Client->account_balance +  $validatedData['total_fees'];
                $Client->save();
            });



            session()->flash('success', __('translation.item.created.successfully'));

            $this->resetPage();

            $this->resetInputFieldsafteradd();

            $this->emit('stored'); // Close model to using to jquery
            // } catch (ValidationException $exception) {
            // dd($exception->errors());
        } catch (\Throwable $th) {
            //   throw $th;
            //  dd($th);
            $this->emit('storedError');
            $this->resetPage();
            session()->flash('error', __('translation.error.exception'));
        }
    }

    private function resetInputFieldsafteradd()
    {
        $this->receiver_name = '';
        $this->receiver_phone_no = '';
        $this->receiver_area_id = '';
        $this->receiver_sub_area_id = '';
        $this->receiver_address = '';
    }


    private function resetInputFields()
    {
        $this->service_id = '';
        $this->order_id = '';
        $this->client_id = '';
        $this->sender_name = '';
        $this->sender_phone = '';
        $this->sender_area_id = '';
        $this->sender_sub_area_id = '';
        $this->sender_address = '';
        $this->receiver_name = '';
        $this->receiver_phone_no = '';
        $this->receiver_area_id = '';
        $this->receiver_sub_area_id = '';
        $this->receiver_address = '';
        $this->representative_id = '';
        $this->order_fees = 0;
        //$this->payment_method = '';
        $this->police_file = '';
        $this->is_payment_on_delivery = '';
        $this->delivery_fees = "";
    }

    public function edit($id)
    {
        $this->updateMode = true;
        $order = Order::where('id', $id)->first();
        $this->order_id = $id;
        $this->service_id = $order->service_id;
        $this->client_id = $order->client_id;
        $this->sender_name = $order->sender_name;
        $this->sender_phone = $order->sender_phone;
        $this->sender_area_id = $order->sender_area_id;
        $this->sender_sub_area_id = $order->sender_sub_area_id;
        $this->sender_address = $order->sender_address;
        $this->receiver_name = $order->receiver_name;
        $this->receiver_phone_no = $order->receiver_phone_no;
        $this->receiver_area_id = $order->receiver_area_id;
        $this->receiver_sub_area_id = $order->receiver_sub_area_id;
        $this->receiver_address = $order->receiver_address;
        $this->representative_id = $order->representative_id;
        $this->delivery_fees = $order->delivery_fees;
        $this->order_fees = $order->order_fees;
        $this->order_value = $order->order_value;
        $this->payment_method = $order->payment_method;
        $this->police_file = $order->police_file;
        $this->is_payment_on_delivery = $order->is_payment_on_delivery;

        $this->updatedServiceId($this->service_id);
    }

    public function update()
    {
        $validatedData = $this->validate([
            'service_id' => 'required|exists:services,id',
            'client_id' => 'required|exists:clients,id',
            'sender_name' => 'required|string',
            'sender_phone' => 'required',
            'sender_area_id' => 'required|exists:areas,id',
            'sender_sub_area_id' => 'required|exists:sub_areas,id',
            'sender_address' => 'required',
            'receiver_name' => 'required|string',
            'receiver_phone_no' => 'required|String',
            'receiver_area_id' => 'required|exists:areas,id',
            'receiver_sub_area_id' => 'required|exists:sub_areas,id',
            'receiver_address' => 'required',
            'representative_id' => 'nullable|exists:representatives,id',
            'order_fees' => 'numeric|min:0',
            'payment_method' => 'required|in:"on_sending", "on_receiving", "balance"',
            'police_file' => 'nullable',
            'number_of_pieces' => 'required',
            'order_weight' => 'required',
            'order_value' => 'required',
            "delivery_fees" => "required"
            // 'is_payment_on_delivery' => 'nullable',
        ]);
        try {

            if ($this->order_id) {
                $order = Order::find($this->order_id);
                if ($this->police_file != $order['police_file']) {
                    $photo_path = $this->police_file->store('orders');
                } else {
                    $photo_path = $order['police_file'];
                }

                //ensure order fees is 0 when payment method = balance
                // if ($validatedData['payment_method'] == "balance") {
                //     $validatedData["order_fees"] = 0;
                // }

                if ($this->order_fees !== $order->order_fees ||  $this->delivery_fees !== $order->delivery_fees) {
                    $Client = Client::find($this->client_id);
                    // $validatedData['delivery_fees'] = (int) filter_var(service::find($this->service_id)->price, FILTER_SANITIZE_NUMBER_INT);
                    // $validatedData['total_fees'] =  $validatedData['order_fees'] - $validatedData['delivery_fees'];


                //    if( $this->delivery_fees == $order->delivery_fees){
                //     $validatedData['delivery_fees'] = (double) filter_var(ClientServicePrice::where('service_id', $this->service_id)->where('client_id', $Client->id)->first()->price, FILTER_SANITIZE_NUMBER_FLOAT, FILTER_FLAG_ALLOW_FRACTION);
                //    }else{
                //     $validatedData['delivery_fees'] = $this->delivery_fees;
                //    }


                if ($Client->is_has_custom_price) {
                    $validatedData['delivery_fees'] = (double) filter_var(ClientServicePrice::where('service_id', $this->service_id)->where('client_id', $Client->id)->first()->price, FILTER_SANITIZE_NUMBER_FLOAT, FILTER_FLAG_ALLOW_FRACTION);

                } else {
                    $validatedData['delivery_fees'] = (double) filter_var(service::find($this->service_id)->price, FILTER_SANITIZE_NUMBER_FLOAT, FILTER_FLAG_ALLOW_FRACTION);

                }

                  $validatedData['total_fees'] = $validatedData['order_fees'] - $validatedData['delivery_fees'];

                    // sub old value and add new Fees
                    $Client->account_balance = $Client->account_balance  - $order->total_fees + $validatedData['total_fees'];
                    // add new order fees
                    // $Client->account_balance =   $Client->account_balance + $request->order_fess;
                    $Client->save();
                }
                if (!$this->representative_id)
                    $validatedData['representative_id'] = null;
                    $validatedData['representative_deserves'] = (int) filter_var(Area::find($this->sender_area_id)->fees, FILTER_SANITIZE_NUMBER_INT) * (env('REPRESENTATIVE_PERCENTAGE') / 100);
                    // $validatedData['company_deserves'] = $validatedData['delivery_fees'] - $validatedData['representative_deserves'];
                    // $validatedData['is_payment_on_delivery'] = $validatedData['is_payment_on_delivery'] ? 1 : 0;
                    // $validatedData['order_date'] = date('Y-m-d H:i:s');
                    // $validatedData['status'] = 'inProgress';
                $validatedData['police_file'] = $photo_path;

                $order->update($validatedData);
                $this->updateMode = false;
                session()->flash('success', __('translation.item.updated.successfully'));
                $this->emit('updated'); // Close model to using to jquery
                $this->resetInputFields();
            }
        } catch (\Exception $e) {
            // dd($e);
            session()->flash('error', $e);
            $this->emit('updated');
        }
    }

    public function cancel()
    {
        $this->updateMode = false;
        $this->resetInputFields();
    }

    public function updatingSearchTerm()
    {
        $this->resetPage();
    }

    public function updatedPaymentMethod($value)
    {
    }

    public function ChangeOrdersStatus()
    {

        $orders =  Order::whereIn('id', $this->ids)->get();
        foreach ($orders as $key => $order) {

            $order->status = $this->NewStatus;
            $order->save();

            orderTracking::insertOrderTracking($order->id, $this->NewStatus, 'تم تغير حالة الطلب', auth()->user()->name, auth()->user()->id);
        }

        $this->emit('hidemodel');
        session()->flash('success', __('translation.item.updated.successfully'));
        $this->emit('updated'); // Close model to using to jquery


    }




    public function getOrders()
    {
        $searchTerm = '%' . $this->searchTerm . '%';


        if ($this->coustmer_service_Filter) {

            return  Order::with('Shipping')
                ->CoustmerServiceFilter($this->coustmer_service_Filter)
                // ->IsDeleted()
                ->orderBy('id', 'desc');
        } else if ($this->searchTerm) {

            return  Order::with('Shipping')
                ->where('tracking_number', 'like', $searchTerm)
                ->orwhere('id', 'like', $searchTerm)
                ->orwhere('orderRef', 'like', $searchTerm)

                // ->IsDeleted()
                ->orderBy('id', 'desc');
        } else {
            return  Order::with('Shipping')
                ->where('tracking_number', 'like', $searchTerm)
                ->orwhere('id', 'like', $searchTerm)
                ->orwhere('orderRef', 'like', $searchTerm)
                ->ToDate($this->to_date)
                ->FromDate($this->from_date)
                ->StatusFilter($this->status_filter)
                ->StatusFilter1($this->status_filter1)
                ->cleintfilter($this->cleint_filter)
                // ->IsDeleted()
                ->orderBy('id', 'desc');

            // dd(Order::coustmerServiceFilter($this->coustmer_service_Filter)->toSql());

        }
    }

    public function getOrdersIds()
    {
        $searchTerm = '%' . $this->searchTerm . '%';

        // Start with the base query
        $query = Order::query()->select('id')->orderBy('id', 'desc');

        // Apply the customer service filter if it's set
        if ($this->coustmer_service_Filter) {
            $query->CoustmerServiceFilter($this->coustmer_service_Filter);
        }

        // Apply search term filter if provided
        if ($this->searchTerm) {
            $query->where(function ($q) use ($searchTerm) {
                $q->where('tracking_number', 'like', $searchTerm)
                  ->orWhere('id', 'like', $searchTerm)
                  ->orWhere('orderRef', 'like', $searchTerm);
            });
        }

        // Apply additional filters if no customer service filter or search term is provided
        if (!$this->coustmer_service_Filter && !$this->searchTerm) {
            $query->ToDate($this->to_date)
                  ->FromDate($this->from_date)
                  ->StatusFilter($this->status_filter)
                  ->StatusFilter1($this->status_filter1)
                  ->cleintfilter($this->cleint_filter);
        }

        // Use pluck to only retrieve the 'id' column
        return $query->pluck('id');
    }

    public function render()
    {
        $data = $this->getOrders();


        // dd($data[1]->);
        return view('livewire.show-order', [
            'data' => $data->paginate($this->paginatenum ),
            'services' => Service::orderBy('id', 'desc')->get(),
            'sub_areas' => SubArea::orderBy('id', 'desc')->get(),
            'clients' => Client::orderBy('id', 'desc')->get(),
            'representatives' => Representative::orderBy('id', 'desc')->get(),
            'Se  nderSubArea' => $this->SenderSubArea,
            'ResevierSubArea' => $this->ResevierSubArea,
            'ResevingArea' => $this->ResevingArea,
            'SendingArea' => $this->SendingArea,
        ]);
    }
}
