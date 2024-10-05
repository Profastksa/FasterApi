<?php

namespace App\Http\Livewire;

use App\Models\Service;
use Livewire\Component;
use App\Models\Area;
use App\Models\Client;
use App\Models\SubArea;
use App\Models\AreaServices;
use App\Models\ClientServicePrice;

use Exception;


class AddOrder extends Component
{


    public $currentStep = 1;
    public $name, $amount, $description,  $stock;
    public $successMessage = '';


    public $SendingArea, $ResevingArea, $ResevierSubArea, $SenderSubArea;
    // Orders Varibale
    public $is_fill_sender = 1;
    public $showCODPrice  = false;
    public $update_mode = false;
    public $counter = 0;

    public $service_id, $client_id, $representative_id,
        $sender_name, $sender_phone, $sender_area_id,
        $sender_sub_area_id, $sender_address,
        $receiver_name, $receiver_phone_no,
        $receiver_area_id, $receiver_sub_area_id,
        $receiver_address, $police_file, $order_fees=0, $is_payment_on_delivery, $payment_method = 'balance', $status, $orede_Note,$order_value=0;


    public function mount()
    {
        $this->SendingArea = Area::withCount('subAreas')->get();
        $this->ResevingArea = Area::withCount('subAreas')->get();
        $this->ResevierSubArea = SubArea::get();
        $this->SenderSubArea = SubArea::get();
    }

    public function updated()
    {
        // dd($_REQUEST);
        // $this->updatedServiceId($this->service_id);
    }

    public function updatedServiceId($service_id)
    {


      //   dd('updatedServiceId');
        // $AreaSendingIds =  AreaServices::where('service_id', $service_id)->where('is_sending', 1)->get()->pluck('area_id');
        // $this->SendingArea = Area::withCount('subAreas')->whereIn('id', $AreaSendingIds)->get();


        // $AreaResivingIds =  AreaServices::where('service_id', $service_id)->where('is_resiving', 1)->get()->pluck('area_id');
        // $this->ResevingArea = Area::withCount('subAreas')->whereIn('id', $AreaResivingIds)->get();

        if ($service_id)
            $this->is_fill_sender = Service::find($service_id)->is_fill_sender;


        if ($this->service_id == 1)
            $this->showCODPrice = true;
        else
            $this->showCODPrice = false;
    }

    public function updatedClientId($clientId)
    {
        try {

         //   $this->is_fill_sender = Service::find($service_id)->is_fill_sender;
            $this->validate(['client_id' => 'exists:clients,id']);
            $client = Client::find($clientId);
            // dd($client);
            if ($this->is_fill_sender) {
                $this->sender_name = $client->fullname ;
                $this->sender_phone = $client->phone;
                $this->sender_area_id = $client->subArea->area_id;
                $this->sender_sub_area_id = $client->sub_area_id;
                $this->sender_address = $client->address;
            } else {
                $this->receiver_name = $client->fullname ;
                $this->receiver_phone_no = $client->phone;
                $this->receiver_area_id = $client->subArea->area_id;
                $this->receiver_sub_area_id = $client->sub_area_id;
                $this->receiver_address = $client->address;
            }
        } catch (Exception $e) {
           // dd($e);
            $this->emit('ErrorException', __('translation.error_on_chose_the_client'));
        }
    }

    public function render()
    {

        return view(
            'livewire.add-order',
            [
                'services' => Service::all(),
                'SendingArea' => $this->SendingArea,
                'SenderSubArea' => $this->SenderSubArea,
                'ResevingArea' => $this->ResevingArea,
                'ResevierSubArea' => $this->ResevierSubArea,
            ]
        )
            ->layout('layouts.master');
    }



    public function submitFormold()
    {
        dd("heelo");
        // Product::create([
        //     'name' => $this->name,
        //     'amount' => $this->amount,
        //     'description' => $this->description,
        //     'stock' => $this->stock,
        //     'status' => $this->status,
        // ]);
        $this->successMessage = 'Product Created Successfully.';
        $this->clearForm();
        $this->currentStep = 1;
    }

    public function back($step)
    {
        $this->currentStep = $step;
    }


    public function SaveOrder()
    {

        try {
            $this->order_fees = 0;
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
                'payment_method' => 'required|in:"on_sending", "on_receiving","balance"',
                'order_fees' => 'numeric|min:0',
                'police_file' => 'nullable|mimes:jpg,jpeg,png,bmp,svg,webp,pdf',
                'number_of_pieces' => 'required',
                'order_weight' => 'required',
                'order_value' => 'required',
                'status' => 'required',
            ]);



            if ($this->police_file) {
                $police_file_path = $this->police_file->store('orders');
            } else {
                $police_file_path = "";
            }

            $Client = Client::find($this->client_id);
            if ($Client->is_has_custom_price) {
                $validatedData['delivery_fees'] = (int) filter_var(ClientServicePrice::where('service_id',  $validatedData["service_id"])->where('client_id', $Client->id)->first()->price, FILTER_SANITIZE_NUMBER_INT);
                $validatedData['total_fees'] =  $validatedData['order_fees'] - $validatedData['delivery_fees'];
            } else {
                $OrderData['delivery_fees'] = (int) filter_var(service::find( $validatedData["service_id"])->price, FILTER_SANITIZE_NUMBER_INT);
                $validatedData['total_fees'] =  $validatedData['order_fees'] - $validatedData['delivery_fees'];
            }
            $validatedData['order_date'] = date('Y-m-d H:i:s');
            $validatedData['status'] = $this->status;
            $validatedData['police_file'] = $police_file_path;
            $validatedData['note'] = $this->orede_Note;


            DB::transaction(function () use ($validatedData, $Client) {
                //generate invoice no
                $inv_no = SerialSetting::first()->inv_no;
                SerialSetting::first()->update(["inv_no" => ($inv_no + 1)]);
                $validatedData['invoice_sn'] = genInvNo($inv_no);
                $validatedData['tracking_number'] = orderTracking::generateUniqueTrackingNumber();
                $user_name = auth()->user()->name;
                $note ="في الطريق للاستلام من المرسل "; //" تم اضافه الطلب من قبل الاداره بواسطه ($user_name)";
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
                $Client->in_accounts_order = 1;

                $Client->save();
            });



            session()->flash('success', __('translation.item.created.successfully'));

            $this->resetPage();

            $this->resetInputFields();

            $this->emit('stored'); // Close model to using to jquery
            // } catch (ValidationException $exception) {
            // dd($exception->errors());
        } catch (\Throwable $th) {
          //   throw $th;
          //  dd($th);
            session()->flash('error', __('translation.error.exception'));
        }
    }

}
