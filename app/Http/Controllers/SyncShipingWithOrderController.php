<?php

namespace App\Http\Controllers;

use App\Jobs\CreateSMSAPDF;
use App\Models\Order;
use App\Models\OrderShiping;
use App\Services\Shiping\SMSAShipingService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Services\Shiping\NewSMSAShippingServiceImplementation;
use SoapFault;

class SyncShipingWithOrderController extends Controller
{
    public function index()
    {
        $data = OrderShiping::all();
        return view('shipping.index', compact('data'));
    }

    public function syncOrder()
    {
        //dd(request());
        // return ;
        request()->validate([
            'ids' => 'required',
        ]);

        $order_ids = decrypt(request()->ids);
       // $orders = Order::find($order_ids);



        // Fetch orders where there is no associated Shipping record
        $orders = Order::doesntHave('Shipping')->whereIn('id', $order_ids)->get();

        //dd($orders);


        //  if(request()->smsaWithSenderEdite)
        return view('shipping.show', compact('orders'));


        // name , phone, address , city , postalcode , wight, number peaces
        // return view('shipping.show');
    }

    public function BulkPrint(Request $request)
    {
        // return ;
        request()->validate([
            'ids' => 'required',
        ]);

        $order_ids = decrypt(request()->ids);

        $orders = Order::with('Shipping')->find($order_ids);
        $reference_id = [];
        foreach ($orders as $key => $value) {
            if ($value->Shipping?->refrence_id)
                $reference_id[] = $value->Shipping->refrence_id;
        }

        if ($reference_id)
            SMSAShipingService::printInvoice($reference_id);
        else {

            session()->flash('error', __('translation.data.not.found'));
            return redirect()->back();
        }
    }

    public function syncShipingWithOrder(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'phone.*' => 'required|regex:/^([0-9\s\-\+\(\)]*)$/|min:10',
            'country.*' => 'required|string',
            'address.*' => 'required|string',
            'name.*' => 'required|string',
            'city.*' => 'required|string',
            'ids' => 'required',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }
        $messages = [];
        $messages["success"] = [];
        $messages["errors"] = [];
        $reference_id = [];
        $order_ids = decrypt(request()->ids);
      //  $orders = Order::find($order_ids);
        $orders = Order::doesntHave('Shipping')->whereIn('id', $order_ids)->get();
        $smsaShippingService = app()->make( NewSMSAShippingServiceImplementation::class);

        foreach ($orders as $key => $value) {
            // Handel Customer Models

            // $customer =  SMSAShipingService::HandelCustomerModel($request, $value->id);
            // $number = SMSAShipingService::shiping($customer);




            try {

                 // Handle Customer Models using the singleton instance
                $customer = $smsaShippingService->handleCustomerModel($request, $value->id);
                // Call the shipping method on the singleton instance
                $number = $smsaShippingService->shipping($customer);

                OrderShiping::create(['order_id' => $value->id, 'shiping_type' => $request->type, 'number' => $number, "refrence_id" => $number]);
                $reference_id[] = $number;
                //code...
               $messages["success"][$value->id]["message"] = __("translation.success_message");
               $messages["success"][$value->id]["status"] = "SHIPPED";
            } catch (\Throwable $th) {
                if($th  instanceof SoapFault) {
                    $messages["errors"][$value->id]["message"] = $th->getMessage();
                    $messages["errors"][$value->id]["status"] = "SMSA_FAULT";
                    continue;
                }

                $messages["errors"][$value->id]["message"] = __('translation.some_went_worng');
                $messages["errors"][$value->id]["status"] = "INTERANL_FAULT";
                continue;
            //   throw $th;
            }
            //  Create Order Shiping Iinstance
        }


        if(count($messages["errors"]) == 0)  $request->session()->flash('success2', __('translation.the_orders_was_synced_sccuessfuly'));
        else $request->session()->flash('errors2', __('translation.some_order_was_not_shpping'));


        $filePath = public_path("/smsa_invoices//") . date('y_m_d_h_i_s') .'_smsa.pdf';
            // Save the merged PDF to the file
        session()->put("file_path", encrypt($filePath));

        // Fire Event
        dispatch(new CreateSMSAPDF($reference_id , $filePath));

        session()->put("messages", $messages);
        return redirect()->route('orders.shipping.result');

    }

    public function printInvocie($ids_key)
    {

        $reference_id = [];
        if (is_string($ids_key)) {
            $shiping_details =  Order::with('Shipping')->find($ids_key)->Shipping;
            $reference_id[] = $shiping_details->refrence_id;



        } elseif (is_array($ids_key)) {
        }
    }

    public function cancel(Request $request)
    {
        // return request();

        $request->validate([
            'refrence_id' => 'required',
            'type' => 'required',
            'order_id' => 'required'
        ]);

        SMSAShipingService::cancel($request->refrence_id, $request->reason);
        OrderShiping::find($request->order_id)->delete();
        $request->session()->flash('success', __('translation.the_shiping_was_canceld'));
        return redirect()->back();
    }
}
