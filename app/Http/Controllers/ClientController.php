<?php

namespace App\Http\Controllers;

use App\Events\BordcastToAllRepresetitve;
use App\Http\Resources\AreaService;
use App\Models\Area;
use App\Models\AreaServices;
use App\Models\Client;
use App\Models\ClientServicePrice;
use App\Models\ClientsTokens;
use App\Models\Order;
use App\Models\orderTracking;
use App\Models\SerialSetting;
use App\Models\Service;
use App\Models\SubArea;
use App\Traits\SendNotifcationWithFirebaseTrait;
use Beste\Json;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Intervention\Image\ImageManager;
use Intervention\Image\ImageManagerStatic as Image;
use App\Traits\CreateUserWithFireBase;
use Exception;
use App\Traits\OrderCheckTrait;


class ClientController extends Controller
{
    use SendNotifcationWithFirebaseTrait, CreateUserWithFireBase , OrderCheckTrait;
    public function index()
    {
        return view('clients.index');
    }
    public function payment()
    {
        return view('clients.payment');
    }

    public function updateClientAccount(Request $request)
    {
        $fields = $request->validate([
            'fullname' => 'string',
            'email' => 'required_without:phone|email',
            'phone' => 'sometimes',
            'sub_area_id' => 'required|exists:sub_areas,id',
            'area_id' => 'required|exists:areas,id',
            'address' => 'required',
            'activity' => 'required',
            'name_in_invoice' => 'required',
            'bank_account_owner' => 'required',
            'bank_account_number' => 'required',
            'iban_number' => 'required',
            'civil_registry' => 'required',
        ]);
        try {
            $client = Client::find(auth()->user()->id);
            // update Valid Date                                    ######################
            $client = $client->update($fields);
            if ($client) {
                return response([
                    'status' => true,
                    'message' => 'Data updated successfully!',
                    'data' => $client,
                ]);
            } else {
                return response([
                    'status' => false,
                    'message' => 'Something went wrong!',
                ]);
            }
        } catch (\Throwable $th) {
            return response([
                'status' => false,
                'message' => 'Something went wrong!',
            ]);
        }
    }

    public function addOrder(Request $request)
    {
        $validatedData = $request->validate([
            'service_id' => 'required|exists:services,id',
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
            // 'representative_id' => 'required|exists:representatives,id',
            'payment_method' => 'required|in:"on_sending", "on_receiving","balance"',
            'order_fees' => 'numeric|min:0',
            'police_file' => 'nullable',
            'receipt_file' => 'nullable',
            'note' => 'nullable',
            'number_of_pieces' => 'nullable',
            'order_weight' => 'required',
            'order_value' => 'required',
        ]);
        try {
            $Client = Client::find(auth()->user()->id);
            $status = $Client->update([
                'in_accounts_order' => 1,
                'client_id' => auth()->user()->id,
            ]);
            if ($request->police_file) {
                $police_file_url = '/images/police_file/' . 'police_file-' . auth()->user()->id . '-' . time() . '.png';
                $path = public_path() . $police_file_url;
                Image::make(file_get_contents($request->police_file))->save($path);
                $police_file_path = $police_file_url;
            } else {
                $police_file_path = '';
            }
            if ($request->receipt_file) {
                $receipt_file_url = '/images/receipt_file/' . 'receipt_file-' . auth()->user()->id . '-' . time() . '.png';
                $path = public_path() . $receipt_file_url;
                Image::make(file_get_contents($request->receipt_file))->save($path);
                $receipt_file_path = $receipt_file_url;
            } else {
                $receipt_file_path = '';
            }
            if ($Client->is_has_custom_price) {
                $validatedData['delivery_fees'] = (int) filter_var(
                    ClientServicePrice::where('service_id', $validatedData['service_id'])
                        ->where('client_id', $Client->id)
                        ->first()->price,
                    FILTER_SANITIZE_NUMBER_INT,
                );
                $validatedData['total_fees'] = $validatedData['order_fees'] - $validatedData['delivery_fees'];
            } else {
                $validatedData['delivery_fees'] = (int) filter_var(service::find($validatedData['service_id'])->price, FILTER_SANITIZE_NUMBER_INT);
                $validatedData['total_fees'] = $validatedData['order_fees'] - $validatedData['delivery_fees'];
            }
            $validatedData['representative_deserves'] = ($validatedData['delivery_fees'] * env('REPRESENTATIVE_PERCENTAGE')) / 100;
            $validatedData['company_deserves'] = $validatedData['delivery_fees'] - $validatedData['representative_deserves'];
            // $validatedData['is_payment_on_delivery'] = $validatedData['is_payment_on_delivery'] ? 1 : 0;
            $validatedData['order_date'] = date('Y-m-d H:i:s');
            $validatedData['status'] = 'pending';
            //base46Image
            $validatedData['police_file'] = $police_file_path;
            //base46Image
            $validatedData['receipt_file'] = $receipt_file_path;
            $validatedData['client_id'] = auth()->user()->id;
            $validatedData['tracking_number'] = orderTracking::generateUniqueTrackingNumber();
            //generate invoice no
            $inv_no = SerialSetting::first()->inv_no;
            SerialSetting::first()->update(['inv_no' => $inv_no + 1]);
            $validatedData['invoice_sn'] = genInvNo($inv_no);
            // dd($validatedData);                -----------------------------
            $order = Order::create($validatedData);
            // descount account blance from a user ----------------------------
            $Client->account_balance = $Client->account_balance + $validatedData['total_fees'];
            $Client->save();
            orderTracking::insertOrderTracking($order->id, __('translation.' . $order->status), ' تم اضافه طلب جديد بواسطه  ' . auth()->user()->fullname . ' بتاريخ  ' . $order->created_at, auth()->user()->fullname, auth()->user()->id, ' تمت اضافه عنصر بواسطه  ' . auth()->user()->fullname . 'في' . $order->created_at);
            if ($order) {
                // fire event when order Created     -------------------
                // event(new BordcastToAllRepresetitve('representative.' . $validatedData['receiver_area_id'] , __('translation.OrderMangemnt') , __('translation.added_New_OrderBy') ." ". auth()->user()->fullname, '' , $order->id));
                // Return Response Order Is Created    ------------------
                $Order = DB::table('orders_full_data')
                    ->where('client_id', '=', auth()->user()->id)
                    ->where('is_deleted', '=', '0')
                    ->where('id', $order->id)
                    ->first();
                return response([
                    'status' => true,
                    'message' => 'Order Created Successfully!',
                    'data' => $Order,
                ]);
            } else {
                return response([
                    'status' => false,
                    'message' => 'Something Went Wrong',
                ]);
            }
        } catch (Exception $e) {
            throw $e;
            return response([
                'status' => false,
                'message' => 'Something Went Wrong',
            ]);
        }
    }
    public function EditOrder(Request $request)
    {
        $validatedData = $request->validate([
            'id' => 'required|exists:orders,id',
            'service_id' => 'required|exists:services,id',
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
            // 'representative_id' => 'required|exists:representatives,id',
            'payment_method' => 'required|in:"on_sending", "on_receiving","balance"',
            'order_fees' => 'numeric|min:0',
            'police_file' => 'nullable',
            'receipt_file' => 'nullable',
            'order_weight' => 'required',
            'order_value' => 'required',
            'note' => 'nullable',
        ]);
        try {
            //ensure order fees is 0 when payment method = balance
            // if ($validatedData['payment_method'] == "balance") {
            //     $validatedData["order_fees"] = 0;
            // }

            if ($request->police_file) {
                $police_file_url = '/images/police_file/' . 'police_file-' . auth()->user()->id . '-' . time() . '.png';
                $path = public_path() . $police_file_url;
                Image::make(file_get_contents($request->police_file))->save($path);
                $police_file_path = $police_file_url;
            } else {
                $police_file_path = '';
            }
            if ($request->receipt_file) {
                $receipt_file_url = '/images/receipt_file/' . 'receipt_file-' . auth()->user()->id . '-' . time() . '.png';
                $path = public_path() . $receipt_file_url;
                Image::make(file_get_contents($request->receipt_file))->save($path);
                $receipt_file_path = $receipt_file_url;
            } else {
                $receipt_file_path = '';
            }
            /*
            if (4 == $validatedData['service_id']) {
                $validatedData['delivery_fees'] = 20;
            } else if (5 == $validatedData['service_id']) {
                $validatedData['delivery_fees'] = 30;
            } else {
                $validatedData['delivery_fees'] = (int) filter_var(Area::find($request->sender_area_id)->fees, FILTER_SANITIZE_NUMBER_INT);
            } */

            //   $validatedData['representative_deserves'] = $validatedData['delivery_fees'] * env('REPRESENTATIVE_PERCENTAGE') / 100;

            //   $validatedData['company_deserves'] = $validatedData['delivery_fees'] - $validatedData['representative_deserves'];
            // $validatedData['is_payment_on_delivery'] = $validatedData['is_payment_on_delivery'] ? 1 : 0;
            $validatedData['order_date'] = date('Y-m-d H:i:s');
            // $validatedData['status'] = 'pending';
            $validatedData['police_file'] = $police_file_path;
            $validatedData['receipt_file'] = $receipt_file_path;
            $validatedData['client_id'] = auth()->user()->id;

            //$validatedData['tracking_number'] = orderTracking::generateUniqueTrackingNumber();

            //generate invoice no
            // $inv_no = SerialSetting::first()->inv_no;
            // SerialSetting::first()->update(["inv_no" => ($inv_no + 1)]);
            // $validatedData['invoice_sn'] = genInvNo($inv_no);

            // dd($validatedData);
            //  return $validatedData;
            $order = Order::find($validatedData['id']);
            if ($request->order_fees !== $order->order_fees) {
                $validatedData['delivery_fees'] = (int) filter_var(service::find($request->service_id)->price, FILTER_SANITIZE_NUMBER_INT);
                $validatedData['total_fees'] = $validatedData['order_fees'];
                $Client = Client::find(auth()->user()->id);
                // sub old value and add new Fees
                $Client->account_balance = $Client->account_balance - $order->total_fees + $validatedData['total_fees'];
                // $Client->account_balance =   $Client->account_balance + $request->order_fess;
                $Client->save();
            }

            $OrderUpdate = $order->update($validatedData);

            if ($order) {
                return response([
                    'status' => true,
                    'message' => 'Order updated successfully!',
                ]);
            } else {
                return response([
                    'status' => false,
                    'message' => 'Something Went Wrong',
                ]);
            }
        } catch (\Throwable $th) {
            throw $th;
            // return response([
            //     'status' => false,
            //     'message' => 'Something Went Wrong'
            // ]);
        }
    }
    public function getOrder(Request $request)
    {
        $validatedData = $request->validate([
            'order_id' => 'required|exists:orders,id',
        ]);
        try {
            //code...
            // $order = Order::with('service')->isDeleted()->find($validatedData['order_id']);
            $order = DB::table('orders_full_data')
                ->select('*')
                ->where('id', '=', $validatedData['order_id'])
                ->where('is_deleted', '=', '0')
                ->get();

            return response([
                'status' => true,
                'data' => $order,
            ]);
        } catch (\Throwable $th) {
            //throw $th;
            return response([
                'status' => false,
                'message' => 'Something Went Wrong',
            ]);
        }
    }

    public function getClientOrders(Request $request)
    {
        $validatedData = $request->validate([
            'is_history_orders' => 'required|in:0,1',
        ]);
        try {
            // $orders = Order::isDeleted()->where('client_id', auth()->user()->id)->get();
            $orders = DB::table('orders_full_data')
                ->where('client_id', '=', auth()->user()->id)
                ->where('is_deleted', '=', '0')
                ->when(
                    $validatedData['is_history_orders'],
                    function ($query) {
                        $query->whereIn('status', ['completed', 'delivered', 'returned']);
                    },
                    function ($query) {
                        $query->whereIn('status', ['pending', 'pickup', 'inProgress']);
                    },
                )
                ->orderBy('id', 'desc')
                ->get();
            return response([
                'status' => true,
                'data' => $orders,
            ]);
        } catch (\Throwable $th) {
            throw $th;
            return response([
                'status' => false,
                'message' => 'Something Went Wrong',
            ]);
        }
    }

    public function cancelOrder(Request $request)
    {
        $validatedData = $request->validate([
            'order_id' => 'required|exists:orders,id',
        ]);

        try {
            Order::find($validatedData['order_id'])->update([
                'status' => 'canceled',
            ]);

            return response([
                'status' => true,
                'message' => 'Order canceled successfully',
            ]);
        } catch (\Throwable $th) {
            // return $th;
            return response([
                'status' => false,
                'message' => 'Something Went Wrong',
            ]);
        }
    }

    public function getClient(Request $request)
    {
        $validatedData = $request->validate([]);
        try {
            $client = Client::where('is_active', 1)->find(auth()->user()->id);
            if ($client) {
                return response([
                    'status' => true,
                    'data' => $client,
                ]);
            } else {
                return response([
                    'status' => false,
                    'message' => 'Something Went Wrong',
                ]);
            }
        } catch (\Throwable $th) {
            //throw $th;
            return response([
                'status' => false,
                'message' => 'Something Went Wrong',
            ]);
        }
    }

    public function getAllServices(Request $request)
    {
        try {
            $services = Service::with('notes')->get();

            return response([
                'r' => $request,
                'status' => true,
                'data' => $services,
            ]);
        } catch (\Throwable $th) {
            //throw $th;
            return response([
                'status' => false,
                'message' => 'Something Went Wrong',
            ]);
        }
    }
    public function getAllAreas(Request $request)
    {
        try {
            //$areas = Area::where with('subAreas')->get();
            $areas = Area::where('id', '!=', 11)->with('subAreas')->get();

            return response([
                'status' => true,
                'data' => $areas,
            ]);
        } catch (\Throwable $th) {
            //throw $th;
            return response([
                'status' => false,
                'message' => 'Something Went Wrong',
            ]);
        }
    }

    public function getAllAreas2(Request $request)
    {
        try {
            $areas = Area::where('id', '!=', 11)
                ->with('subAreas')
                ->whereIn('id', [0, 5])
                ->get();

            return response([
                'status' => true,
                'data' => $areas,
            ]);
        } catch (\Throwable $th) {
            //throw $th;
            return response([
                'status' => false,
                'message' => 'Something Went Wrong',
            ]);
        }
    }

    public function getAllAreasByServiceId(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), [
                'service_id' => 'required|integer',
                'is_sending' => 'nullable|integer',
                'is_resiving' => 'nullable|integer',
            ]);

            if ($validator->fails()) {
                return $validator->errors();
            }

            $IsSending = $request->is_sending;
            $IsReseving = $request->is_resiving;
            // dd([$IsSending , $IsReseving]);

            if ($IsSending == null && $IsReseving == null) {
                $ids = AreaServices::where('service_id', $request->service_id)
                    ->get()
                    ->pluck('area_id');
            } elseif ($IsSending !== null && $IsReseving == null) {
                $ids = AreaServices::where('service_id', $request->service_id)
                    ->where('is_sending', 1)
                    ->get()
                    ->pluck('area_id');
            } elseif ($IsSending == null && $IsReseving !== null) {
                $ids = AreaServices::where('service_id', $request->service_id)
                    ->where('is_resiving', 1)
                    ->get()
                    ->pluck('area_id');
            } else {
                // dd($IsReseving);
                $ids = AreaServices::where('service_id', $request->service_id)
                    ->where('is_resiving', $IsReseving)
                    ->where('is_sending', $IsSending)
                    ->get()
                    ->pluck('area_id');
            }

            // return $ids;
            // $areas = Area::with('subAreas')->get();
            $data = Area::where('id', '!=', 11)->with('subAreas')->whereIn('id', $ids)->get();
            return response([
                'status' => true,
                'data' => $data,
            ]);
        } catch (\Throwable $th) {
            throw $th;
            return response([
                'status' => false,
                'message' => 'Something Went Wrong',
            ]);
        }
    }

    public function getSubAreaByAreaId(Request $request)
    {
        $validatedData = $request->validate([
            'area_id' => 'required|exists:areas,id',
        ]);
        try {
            $sub_areas = SubArea::where('area_id', $validatedData['area_id'])->get();

            return response([
                'status' => true,
                'data' => $sub_areas,
            ]);
        } catch (\Throwable $th) {
            //throw $th;
            return response([
                'status' => false,
                'message' => 'Something Went Wrong',
            ]);
        }
    }

    public function getallSubArea()
    {
        try {
            $sub_areas = SubArea::get();
            return response([
                'status' => true,
                'data' => $sub_areas,
            ]);
        } catch (\Throwable $th) {
            //throw $th;
            return response([
                'status' => false,
                'message' => 'Something Went Wrong',
            ]);
        }
    }

    public function addOrderWithApiKeyForWP(Request $request)
    {
        $validatedData = $request->validate([
            'Ref_orderId' => 'required',
            'receiver_name' => 'required',
            'receiver_phone_no' => 'required',
            'receiver_area_id' => 'required',
            'receiver_sub_area_id' => 'required',
            'receiver_address' => 'required',
            'order_value' => 'required',
            'note' => 'nullable',
        ]);

        $results = [];

        try {
            $Client = $this->getClientWithApiKey($request);

            for ($i = 0; $i < count($request->Ref_orderId); $i++) {

                $OrderData = $this->getOrderData($Client, $request, $i);

                try {
                    $order_id = -1;
                    if ($i)
                    DB::transaction(function () use ($OrderData, $Client, &$order_id) {
                        $order_id =  $this->createOrderAndOrderTrackingAndUpdateClient($OrderData, $Client, "WP");
                    });

                    $results[] = ['order_id' => $request->Ref_orderId[$i], 'status' => 'success', 'Profast_id' => $order_id];
                } catch (\Throwable $th) {
                    DB::rollBack();
                    $results[] = ['order_id' => $request->Ref_orderId[$i], 'status' => 'failed', 'error' => "validation error"];
                }
            }

            return response([
                'status' => true,
                'message' => 'Orders processed',
                'results' => $results,
            ]);

        } catch (\Throwable $th) {
            return response([
                'status' => false,
                'message' => 'Something Went Wrong',
                'error' => $th->getMessage(),
            ]);
        }
    }

    public function addOrderWithApiKey(Request $request)
    {
        $validatedData = $request->validate([
            'Ref_orderId' => 'required',
            'receiver_name' => 'required',
            'receiver_phone_no' => 'required',
            'receiver_area_id' => 'required',
            'receiver_sub_area_id' => 'required',
            'receiver_address' => 'required',
            'order_value' => 'required',
            'note' => 'nullable',
        ]);

        $results = [];

        try {
            $Client = $this->getClientWithApiKey($request);

            for ($i = 0; $i < count($request->Ref_orderId); $i++) {

                $OrderData = $this->getOrderData($Client, $request, $i);

                try {
                    $order_id = -1;
                    if ($i)
                        DB::transaction(function () use ($OrderData, $Client, &$order_id) {
                            $order_id =  $this->createOrderAndOrderTrackingAndUpdateClient($OrderData, $Client, Order::ORDER_SOURCING[2]);
                        });

                    $results[] = ['order_id' => $request->Ref_orderId[$i], 'status' => 'success', 'Profast_id' => $order_id];
                } catch (\Throwable $th) {
                    DB::rollBack();
                    $results[] = ['order_id' => $request->Ref_orderId[$i], 'status' => 'failed', 'error' => "validation error"];
                }
            }

            return response([
                'status' => true,
                'message' => 'Orders processed',
                'results' => $results,
            ]);

        } catch (\Throwable $th) {
            return response([
                'status' => false,
                'message' => 'Something Went Wrong',
                'error' => $th->getMessage(),
            ]);
        }
    }
    public function addOrderWithApiKeyForV2(Request $request)
    {
        $validatedData = $request->validate([
            'order_ref' => 'required',
            'receiver_name' => 'required',
            'receiver_phone' => 'required',
            'receiver_address' => 'required',
            'area_id' => 'required',
            'sub_area_id' => 'required',
            'order_value' => 'required',
            'note' => 'nullable',
        ]);

        $results = [];

        try {
            $Client = $this->getClientWithApiKey($request);

            for ($i = 0; $i < count($request->Ref_orderId); $i++) {

                $OrderData = $this->getOrderData($Client, $request, $i);

                try {
                    $order_id = -1;
                    if ($i)
                        DB::transaction(function () use ($OrderData, $Client, &$order_id) {
                            $order_id =  $this->createOrderAndOrderTrackingAndUpdateClient($OrderData, $Client);
                        });

                    $results[] = ['order_id' => $request->Ref_orderId[$i], 'status' => 'success', 'Profast_id' => $order_id];
                } catch (\Throwable $th) {
                    DB::rollBack();
                    $results[] = ['order_id' => $request->Ref_orderId[$i], 'status' => 'failed', 'error' => "validation error"];
                }
            }

            return response([
                'status' => true,
                'message' => 'Orders processed',
                'results' => $results,
            ]);

        } catch (\Throwable $th) {
            return response([
                'status' => false,
                'message' => 'Something Went Wrong',
                'error' => $th->getMessage(),
            ]);
        }
    }
    public function addOrdersWithApiKeyForFasterSuadi(Request $request)
    {
        $validatedData = $request->validate([
            'Ref_orderId' => 'required',
            'receiver_name' => 'required',
            'receiver_phone_no' => 'required',
            'receiver_area_id' => 'required',
            'receiver_sub_area_id' => 'required',
            'receiver_address' => 'required',
            'order_value' => 'required',
            'vendor_id' => 'required',
            'note' => 'nullable',
        ]);

        $results = [];

        try {
            $apikey = $request->api_key;
            $clientsTokens = ClientsTokens::with('Client')
                ->select('client_id')
                ->where('api_key', $apikey)
                ->where('api_secret_token', $request->api_secret_token)
                ->first();

            //dd($clientsTokens);
            $Client = $clientsTokens->Client;
            $knownAreas = Area::all();
            $jazanArea = Area::where('name', 'جازان')->first();
            if ($Client->id != 525) {
                return response([
                    'status' => false,
                    'message' => 'Something Went Wrong',
                    'error' => 'invalid USR',
                ]);
            }

            // client array

            for ($i = 0; $i < count($request->Ref_orderId); $i++) {
                $Client = Client::find($this->getClientIdFromFasterSuadi($request->vendor_id[$i]));

                $OrderData = [
                    'sender_name' => $Client->fullname,
                    'sender_phone' => $Client->phone,
                    'sender_area_id' => $Client->area_id,
                    'sender_sub_area_id' => $Client->sub_area_id,
                    'sender_address' => $Client->address,
                    'client_id' => $Client->id,
                ];

                try {
                    if ($request->receiver_area_id[$i] == 'SA') {
                        $SAsubAreas = Area::where('id', 4)->get();
                        $JeezansubAreas = Area::where('id', 5)->get();

                        $closesSASubtArea = $this->findClosestArea($request->receiver_sub_area_id[$i], $SAsubAreas->first()->subAreas()->get());
                        $closesJezzanSubtArea = $this->findClosestArea($request->receiver_sub_area_id[$i], $JeezansubAreas->first()->subAreas()->get());

                        $closestArea = null;
                        $closestDistance = PHP_INT_MAX;

                        // Determine the closest sub-area between the two
                        if ($closesSASubtArea !== null && $closesSASubtArea['distance'] < $closestDistance) {
                            $closestArea = $closesSASubtArea['area'];
                            $closestDistance = $closesSASubtArea['distance'];
                        }

                        if ($closesJezzanSubtArea !== null && $closesJezzanSubtArea['distance'] < $closestDistance) {
                            $closestArea = $closesJezzanSubtArea['area'];
                            $closestDistance = $closesJezzanSubtArea['distance'];
                        }

                        if ($closestArea !== null) {
                            $OrderData['receiver_area_id'] = $closestArea->area_id; // Assuming 'area_id' is the field you want
                            $OrderData['receiver_sub_area_id'] = $closestArea->id; // Assuming 'id' is the sub-area ID field
                        } else {
                            // Handle the case where no close sub-area is found
                            $OrderData['receiver_area_id'] = 11;
                            $OrderData['receiver_sub_area_id'] = 506;
                        }
                    } else {
                        $knownsubAreas = Area::where('country_code', $request->receiver_area_id[$i])->get();

                        if ($knownsubAreas->isEmpty()) {
                            // Handle the case where no areas are found
                            $OrderData['receiver_area_id'] = 11;
                            $OrderData['receiver_sub_area_id'] = 506;
                        } else {
                            // Use the first area to set receiver_area_id
                            $OrderData['receiver_area_id'] = $knownsubAreas->first()->id;

                            // Find the closest sub-area
                            $closesSubtArea = $this->findClosestArea($request->receiver_sub_area_id[$i], $knownsubAreas->first()->subAreas()->get());

                            if ($closesSubtArea !== null) {
                                $OrderData['receiver_sub_area_id'] = $closesSubtArea['area']->id; // Assuming 'id' is the sub-area ID field
                            } else {
                                $OrderData['receiver_sub_area_id'] = 506;
                            }
                        }
                    }
                } catch (\Throwable $th) {
                    // Handle exceptions and set default values
                    $OrderData['receiver_area_id'] = 11;
                    $OrderData['receiver_sub_area_id'] = 506;

                    return response([
                        'status' => false,
                        'message' => 'Something Went Wrong in area sections',
                        'error' => $th->getMessage(),
                    ]);
                }

                $OrderData['receiver_address'] = $request->receiver_address[$i];
                if($OrderData['receiver_sub_area_id'] == 506) {
                    $OrderData['receiver_address'] .= " , " . $request->receiver_sub_area_id[$i];
                }

                if($OrderData['receiver_area_id'] == 11) {
                    $OrderData['receiver_address'] .= " , " . $request->receiver_area_id[$i] ;
                }

                $OrderData['service_id'] = $this->determineService($OrderData['sender_area_id'], $OrderData['receiver_area_id']);
                $OrderData['receiver_name'] = $request->receiver_name[$i];
                $OrderData['receiver_phone_no'] = $request->receiver_phone_no[$i];
                $OrderData['orderRef'] = $request->Ref_orderId[$i] ?? null;
                $OrderData['note'] = $request->note[$i] ?? null;

                $OrderData['order_fees'] = 0;
                $OrderData['order_value'] = $request->order_value[$i];
                $OrderData['payment_method'] = 'balance';
                $OrderData['order_date'] = date('Y-m-d H:i:s');
                $OrderData['status'] = 'pending';
                $OrderData['number_of_pieces'] = $request->number_of_pieces[$i] ?? 1; //1;
                $OrderData['order_weight'] = $request->order_weight[$i] ?? 5; //5;

                if ($Client->is_has_custom_price) {
                    $OrderData['delivery_fees'] = (int) filter_var(
                        ClientServicePrice::where('service_id', $OrderData['service_id'])
                            ->where('client_id', $Client->id)
                            ->first()->price,
                        FILTER_SANITIZE_NUMBER_FLOAT,
                        FILTER_FLAG_ALLOW_FRACTION,
                    );
                    $OrderData['total_fees'] = $OrderData['order_value'] - $OrderData['delivery_fees'];
                } else {
                    $OrderData['delivery_fees'] = (int) filter_var(service::find($OrderData['service_id'])->price, FILTER_SANITIZE_NUMBER_FLOAT, FILTER_FLAG_ALLOW_FRACTION);
                    $OrderData['total_fees'] = $OrderData['order_value'] - $OrderData['delivery_fees'];
                }

                try {
                    $order_id = -1;

                    DB::transaction(function () use ($OrderData, $Client, &$order_id) {
                        $inv_no = SerialSetting::first()->inv_no;
                        SerialSetting::first()->update(['inv_no' => $inv_no + 1]);
                        $OrderData['invoice_sn'] = genInvNo($inv_no);
                        $OrderData['tracking_number'] = orderTracking::generateUniqueTrackingNumber();
                        $user_name = $Client->name;
                        $note = " تم اضافه الطلب بواسطه ($user_name)";

                        $newOrder = Order::create($OrderData);
                        $order_id = $newOrder->id;

                        orderTracking::insertOrderTracking($order_id, __('translation.' . $OrderData['status']), $note, 'API', $Client->id);
                        $Client->account_balance += $OrderData['total_fees'];
                        $Client->save();
                    });
                    $results[] = ['order_id' => $request->Ref_orderId[$i], 'status' => 'success', 'Profast_id' => $order_id];
                } catch (\Throwable $th) {
                    $results[] = ['order_id' => $request->Ref_orderId[$i], 'status' => 'failed', 'error' => $th->getMessage()];
                }
            }

            return response([
                'status' => true,
                'message' => 'Orders processed',
                'results' => $results,
            ]);
        } catch (\Throwable $th) {
            return response([
                'status' => false,
                'message' => 'Something Went Wrong',
                'error' => $th->getMessage(),
            ]);
        }
    }

    private $countries = [['name' => 'الامارات العربية المتحدة', 'country_code' => 'UA'], ['name' => 'المملكة العربية السعودية', 'country_code' => 'SA'], ['name' => 'السعودية', 'country_code' => 'SA'], ['name' => 'جازان', 'country_code' => 'SA'], ['name' => 'قطر', 'country_code' => 'QA'], ['name' => 'عمان', 'country_code' => 'OM'], ['name' => 'الكويت', 'country_code' => 'KW'], ['name' => 'الأردن', 'country_code' => 'JO'], ['name' => 'البحرين', 'country_code' => 'BH'], ['name' => 'AA', 'country_code' => 'AA']];
    public function getSallaCountryByName($name)
    {
        $filteredCountries = array_filter($this->countries, function ($country) use ($name) {
            return $country['name'] === $name;
        });

        return count($filteredCountries) > 0 ? array_values($filteredCountries)[0] : null;
    }

    public function addOrderWithApiKeyForsallaChromePlugin(Request $request)
    {
        $validatedData = $request->validate([
            'Ref_orderId' => 'required',
            'receiver_name' => 'required',
            'receiver_phone_no' => 'required',
            'receiver_area_id' => 'required',
            'receiver_sub_area_id' => 'required',
            'receiver_address' => 'required',
            'order_value' => 'required',
            'note' => 'nullable',
        ]);

        $results = [];

        try {
            $apikey = $request->api_key;
            $clientsTokens = ClientsTokens::with('Client')
                ->select('client_id')
                ->where('api_key', $apikey)
                ->where('api_secret_token', $request->api_secret_token)
                ->first();

            $Client = $clientsTokens->Client;
            $knownAreas = Area::all();
            $jazanArea = Area::where('name', 'جازان')->first();

            $receiver_area_ids = $request->receiver_area_id;
            $receiver_sub_area_ids = $request->receiver_sub_area_id;

            for ($i = 0; $i < count($request->Ref_orderId); $i++) {
                $OrderData = [
                    'sender_name' => $Client->fullname,
                    'sender_phone' => $Client->phone,
                    'sender_area_id' => $Client->area_id,
                    'sender_sub_area_id' => $Client->sub_area_id,
                    'sender_address' => $Client->address,
                    'client_id' => $Client->id,
                ];

                try {
                    $countryitem = $this->getSallaCountryByName($receiver_area_ids[$i]);
                    if ($countryitem) {
                        $receiver_area_ids[$i] = $countryitem['country_code'];
                    } else {
                        $results[] = ['order_id' => $request->Ref_orderId[$i], 'status' => 'failed', 'error' => 'no country selected'];
                        continue; // Skip this iteration if no country is selected
                    }

                    if ($receiver_area_ids[$i] == 'SA') {
                        $SAsubAreas = Area::where('id', 4)->get();
                        $JeezansubAreas = Area::where('id', 5)->get();

                        $closesSASubtArea = $this->findClosestArea($receiver_sub_area_ids[$i], $SAsubAreas->first()->subAreas()->get());
                        $closesJezzanSubtArea = $this->findClosestArea($receiver_sub_area_ids[$i], $JeezansubAreas->first()->subAreas()->get());

                        $closestArea = null;
                        $closestDistance = PHP_INT_MAX;

                        // Determine the closest sub-area between the two
                        if ($closesSASubtArea !== null && $closesSASubtArea['distance'] < $closestDistance) {
                            $closestArea = $closesSASubtArea['area'];
                            $closestDistance = $closesSASubtArea['distance'];
                        }

                        if ($closesJezzanSubtArea !== null && $closesJezzanSubtArea['distance'] < $closestDistance) {
                            $closestArea = $closesJezzanSubtArea['area'];
                            $closestDistance = $closesJezzanSubtArea['distance'];
                        }

                        if ($closestArea !== null) {
                            $OrderData['receiver_area_id'] = $closestArea->area_id; // Assuming 'area_id' is the field you want
                            $OrderData['receiver_sub_area_id'] = $closestArea->id; // Assuming 'id' is the sub-area ID field
                        } else {
                            // Handle the case where no close sub-area is found
                            $OrderData['receiver_area_id'] = 11;
                            $OrderData['receiver_sub_area_id'] = 506;
                        }
                    } else {
                        $knownsubAreas = Area::where('country_code', $receiver_area_ids[$i])->get();

                        if ($knownsubAreas->isEmpty()) {
                            // Handle the case where no areas are found
                            $OrderData['receiver_area_id'] = 11;
                            $OrderData['receiver_sub_area_id'] = 506;
                        } else {
                            // Use the first area to set receiver_area_id
                            $OrderData['receiver_area_id'] = $knownsubAreas->first()->id;

                            // Find the closest sub-area
                            $closesSubtArea = $this->findClosestArea($receiver_sub_area_ids[$i], $knownsubAreas->first()->subAreas()->get());

                            if ($closesSubtArea !== null) {
                                $OrderData['receiver_sub_area_id'] = $closesSubtArea['area']->id; // Assuming 'id' is the sub-area ID field
                            } else {
                                $OrderData['receiver_sub_area_id'] = 506;
                            }
                        }
                    }
                } catch (\Throwable $th) {
                    // Handle exceptions and set default values
                    $OrderData['receiver_area_id'] = 11;
                    $OrderData['receiver_sub_area_id'] = 506;

                    return response([
                        'status' => false,
                        'message' => 'Something Went Wrong in area sections',
                        'error' => $th->getMessage(),
                    ]);
                }

                $OrderData['receiver_address'] = $request->receiver_address[$i];
                if($OrderData['receiver_sub_area_id'] == 506) {
                    $OrderData['receiver_address'] .= " , " . $request->receiver_sub_area_id[$i];
                }

                if($OrderData['receiver_area_id'] == 11) {
                    $OrderData['receiver_address'] .= " , " . $request->receiver_area_id[$i] ;
                }

                $OrderData['service_id'] = $this->determineService($OrderData['sender_area_id'], $OrderData['receiver_area_id']);
                $OrderData['receiver_name'] = $request->receiver_name[$i];
                $OrderData['receiver_phone_no'] = $request->receiver_phone_no[$i];
                $OrderData['orderRef'] = $request->Ref_orderId[$i] ?? null;
                $OrderData['note'] = $request->note[$i] ?? null;

                $OrderData['order_fees'] = $request->order_value[$i];
                $OrderData['order_value'] = 0;
                $OrderData['payment_method'] = 'balance';
                $OrderData['order_date'] = date('Y-m-d H:i:s');
                $OrderData['status'] = 'pending';
                $OrderData['number_of_pieces'] = $request->number_of_pieces[$i] ?? 1;
                $OrderData['order_weight'] = $request->order_weight[$i] ?? 5;

                if ($Client->is_has_custom_price) {
                    $OrderData['delivery_fees'] = (int) filter_var(
                        ClientServicePrice::where('service_id', $OrderData['service_id'])
                            ->where('client_id', $Client->id)
                            ->first()->price,
                        FILTER_SANITIZE_NUMBER_FLOAT,
                        FILTER_FLAG_ALLOW_FRACTION,
                    );
                    $OrderData['total_fees'] = $OrderData['order_value'] - $OrderData['delivery_fees'];
                } else {
                    $OrderData['delivery_fees'] = (int) filter_var(service::find($OrderData['service_id'])->price, FILTER_SANITIZE_NUMBER_FLOAT, FILTER_FLAG_ALLOW_FRACTION);
                    $OrderData['total_fees'] = $OrderData['order_value'] - $OrderData['delivery_fees'];
                }

                try {
                    $order_id = -1;

                    DB::transaction(function () use ($OrderData, $Client, &$order_id) {
                        $inv_no = SerialSetting::first()->inv_no;
                        SerialSetting::first()->update(['inv_no' => $inv_no + 1]);
                        $OrderData['invoice_sn'] = genInvNo($inv_no);
                        $OrderData['tracking_number'] = orderTracking::generateUniqueTrackingNumber();
                        $user_name = $Client->name;
                        $note = " تم اضافه الطلب بواسطه ($user_name)";

                        $newOrder = Order::create($OrderData);
                        $order_id = $newOrder->id;

                        orderTracking::insertOrderTracking($order_id, __('translation.' . $OrderData['status']), $note, 'API', $Client->id);
                        $Client->account_balance += $OrderData['total_fees'];
                        $Client->save();
                    });
                    $results[] = ['order_id' => $request->Ref_orderId[$i], 'status' => 'success', 'Profast_id' => $order_id];
                } catch (\Throwable $th) {
                    $results[] = ['order_id' => $request->Ref_orderId[$i], 'status' => 'failed', 'error' => $th->getMessage()];
                }
            }

            return response([
                'status' => true,
                'message' => 'Orders processed',
                'results' => $results,
            ]);
        } catch (\Throwable $th) {
            return response([
                'status' => false,
                'message' => 'Something Went Wrong',
                'error' => $th->getMessage(),
            ]);
        }
    }

    public function addOrderWithApiKeyForsallaChromePluginV2(Request $request)
    {
        $validatedData = $request->validate([
            'Ref_orderId' => 'required',
            'receiver_name' => 'required',
            'receiver_phone_no' => 'required',
            'receiver_area_id' => 'required',
            'receiver_sub_area_id' => 'required',
            'receiver_address' => 'required',
            'order_value' => 'required',
            'note' => 'nullable',
        ]);

        $results = [];
        //dd($request->all());
        try {
            $apikey = $request->api_key;
            $clientsTokens = ClientsTokens::with('Client')
                ->select('client_id')
                ->where('api_key', $apikey)
                ->where('api_secret_token', $request->api_secret_token)
                ->first();

            $Client = $clientsTokens->Client;
            $knownAreas = Area::all();
            $jazanArea = Area::where('name', 'جازان')->first();

            $receiver_area_ids = $request->receiver_area_id;
            $receiver_sub_area_ids = $request->receiver_sub_area_id;

            for ($i = 0; $i < count($request->Ref_orderId); $i++) {

             $existingOrderResult = $this->checkExistingOrder($Client->id, $request->Ref_orderId[$i]);
                if ($existingOrderResult) {
                    $results[] = $existingOrderResult;
                    continue;
                }

                $OrderData = [
                    'sender_name' => $Client->fullname,
                    'sender_phone' => $Client->phone,
                    'sender_area_id' => $Client->area_id,
                    'sender_sub_area_id' => $Client->sub_area_id,
                    'sender_address' => $Client->address,
                    'client_id' => $Client->id,
                    "order_source" => "SALLA"
                ];

                try {
                    $countryitem = $this->getSallaCountryByName($receiver_area_ids[$i]);

                    if ($countryitem) {
                        $receiver_area_ids[$i] = $countryitem['country_code'];
                    } else {
                        $results[] = ['order_id' => $request->Ref_orderId[$i], 'status' => 'failed', 'error' => 'no country selected'];
                        continue; // Skip this iteration if no country is selected
                    }

                    if ($receiver_area_ids[$i] == 'SA') {
                        $SAsubAreas = Area::where('id', 4)->get();
                        $JeezansubAreas = Area::where('id', 5)->get();

                        $closesSASubtArea = $this->findClosestArea($receiver_sub_area_ids[$i], $SAsubAreas->first()->subAreas()->get());
                        $closesJezzanSubtArea = $this->findClosestArea($receiver_sub_area_ids[$i], $JeezansubAreas->first()->subAreas()->get());

                        $closestArea = null;
                        $closestDistance = PHP_INT_MAX;

                        // Determine the closest sub-area between the two
                        if ($closesSASubtArea !== null && $closesSASubtArea['distance'] < $closestDistance) {
                            $closestArea = $closesSASubtArea['area'];
                            $closestDistance = $closesSASubtArea['distance'];
                        }

                        if ($closesJezzanSubtArea !== null && $closesJezzanSubtArea['distance'] < $closestDistance) {
                            $closestArea = $closesJezzanSubtArea['area'];
                            $closestDistance = $closesJezzanSubtArea['distance'];
                        }
                        // echo json_encode($closesSASubtArea);
                        // return;

                        if ($closestArea !== null) {
                            $OrderData['receiver_area_id'] = $closestArea->area_id; // Assuming 'area_id' is the field you want
                            $OrderData['receiver_sub_area_id'] = $closestArea->id; // Assuming 'id' is the sub-area ID field
                        } else {
                            // Handle the case where no close sub-area is found
                            $OrderData['receiver_area_id'] = 11;
                            $OrderData['receiver_sub_area_id'] = 506;
                        }
                    } else {
                        $knownsubAreas = Area::where('country_code', $receiver_area_ids[$i])->get();

                        if ($knownsubAreas->isEmpty()) {
                            // Handle the case where no areas are found
                            $OrderData['receiver_area_id'] = 11;
                            $OrderData['receiver_sub_area_id'] = 506;
                        } else {
                            // Use the first area to set receiver_area_id
                            $OrderData['receiver_area_id'] = $knownsubAreas->first()->id;

                            // Find the closest sub-area
                            $closesSubtArea = $this->findClosestArea($receiver_sub_area_ids[$i], $knownsubAreas->first()->subAreas()->get());

                            if ($closesSubtArea !== null) {
                                $OrderData['receiver_sub_area_id'] = $closesSubtArea['area']->id; // Assuming 'id' is the sub-area ID field
                            } else {
                                $OrderData['receiver_sub_area_id'] = 506;
                            }
                        }
                    }
                } catch (\Throwable $th) {
                    // Handle exceptions and set default values
                    $OrderData['receiver_area_id'] = 11;
                    $OrderData['receiver_sub_area_id'] = 506;

                    return response([
                        'status' => false,
                        'message' => 'Something Went Wrong in area sections',
                        'error' => $th->getMessage(),
                    ]);
                }
                $OrderData['receiver_address'] = $request->receiver_address[$i];
                if($OrderData['receiver_sub_area_id'] == 506) {
                    $OrderData['receiver_address'] .= " , " . $request->receiver_sub_area_id[$i];
                }

                if($OrderData['receiver_area_id'] == 11) {
                    $OrderData['receiver_address'] .= " , " . $request->receiver_area_id[$i] ;
                }


                $OrderData['service_id'] = $this->determineService($OrderData['sender_area_id'], $OrderData['receiver_area_id']);
                $OrderData['receiver_name'] = $request->receiver_name[$i];
                $OrderData['receiver_phone_no'] = $request->receiver_phone_no[$i];
                $OrderData['orderRef'] = $request->Ref_orderId[$i] ?? null;
                $OrderData['note'] = $request->note[$i] ?? null;
                if ($request->payment_method[$i] == "الدفع عند الاستلام") {
                    $OrderData['order_value'] = $request->order_value[$i];
                    $OrderData['order_fees'] = 0;

                }
                else
                {
                    $OrderData['order_fees'] = $request->order_value[$i];
                    $OrderData['order_value'] = 0;
                }

                $OrderData['payment_method'] = 'balance';
                $OrderData['order_date'] = date('Y-m-d H:i:s');
                $OrderData['status'] = 'pending';
                $OrderData['number_of_pieces'] = $request->number_of_pieces[$i] ?? 1;
                $OrderData['order_weight'] = $request->order_weight[$i] ?? 5;

                if ($Client->is_has_custom_price) {
                    $OrderData['delivery_fees'] = (int) filter_var(
                        ClientServicePrice::where('service_id', $OrderData['service_id'])
                            ->where('client_id', $Client->id)
                            ->first()->price,
                        FILTER_SANITIZE_NUMBER_FLOAT,
                        FILTER_FLAG_ALLOW_FRACTION,
                    );
                    $OrderData['total_fees'] = $OrderData['order_value'] - $OrderData['delivery_fees'];
                } else {
                    $OrderData['delivery_fees'] = (int) filter_var(service::find($OrderData['service_id'])->price, FILTER_SANITIZE_NUMBER_FLOAT, FILTER_FLAG_ALLOW_FRACTION);
                    $OrderData['total_fees'] = $OrderData['order_value'] - $OrderData['delivery_fees'];
                }

                try {
                    $order_id = -1;

                    DB::transaction(function () use ($OrderData, $Client, &$order_id) {
                        $inv_no = SerialSetting::first()->inv_no;
                        SerialSetting::first()->update(['inv_no' => $inv_no + 1]);
                        $OrderData['invoice_sn'] = genInvNo($inv_no);
                        $OrderData['tracking_number'] = orderTracking::generateUniqueTrackingNumber();
                        $user_name = $Client->name;
                        $note = " تم اضافه الطلب بواسطه ($user_name)";

                        $newOrder = Order::create($OrderData);
                        $order_id = $newOrder->id;

                        orderTracking::insertOrderTracking($order_id, __('translation.' . $OrderData['status']), $note, 'API', $Client->id);
                        $Client->account_balance += $OrderData['total_fees'];
                        $Client->save();
                    });
                    $results[] = ['order_id' => $request->Ref_orderId[$i], 'status' => 'success', 'Profast_id' => $order_id];
                } catch (\Throwable $th) {
                    $results[] = ['order_id' => $request->Ref_orderId[$i], 'status' => 'failed', 'error' => $th->getMessage()];
                }
            }

            return response([
                'status' => true,
                'message' => 'Orders processed',
                'results' => $results,
            ]);
        } catch (\Throwable $th) {
            return response([
                'status' => false,
                'message' => 'Something Went Wrong',
                'error' => $th->getMessage(),
            ]);
        }
    }

    public function addOrdersWithApiKeySallaChromePluginAdmin(Request $request)
    {
        $validatedData = $request->validate([
            'Ref_orderId' => 'required',
            'receiver_name' => 'required',
            'receiver_phone_no' => 'required',
            'receiver_area_id' => 'required',
            'receiver_sub_area_id' => 'required',
            'receiver_address' => 'required',
            'order_value' => 'required',
            'vendor_id' => 'required',
            'note' => 'nullable',
        ]);

        $results = [];

        try {
            $apikey = $request->api_key;
            $clientsTokens = ClientsTokens::with('Client')
                ->select('client_id')
                ->where('api_key', $apikey)
                ->where('api_secret_token', $request->api_secret_token)
                ->first();

            //dd($clientsTokens);
            $Client = $clientsTokens->Client;
            $knownAreas = Area::all();
            $jazanArea = Area::where('name', 'جازان')->first();
            if ($Client->id != 525) {
                return response([
                    'status' => false,
                    'message' => 'Something Went Wrong',
                    'error' => 'invalid USR',
                ]);
            }

            // client array

            for ($i = 0; $i < count($request->Ref_orderId); $i++) {
                $Client = Client::find($this->getClientIdFromFasterSuadi($request->vendor_id[$i]));

                $OrderData = [
                    'sender_name' => $Client->fullname,
                    'sender_phone' => $Client->phone,
                    'sender_area_id' => $Client->area_id,
                    'sender_sub_area_id' => $Client->sub_area_id,
                    'sender_address' => $Client->address,
                    'client_id' => $Client->id,
                ];

                try {
                    if ($request->receiver_area_id[$i] == 'SA') {
                        $SAsubAreas = Area::where('id', 4)->get();
                        $JeezansubAreas = Area::where('id', 5)->get();

                        $closesSASubtArea = $this->findClosestArea($request->receiver_sub_area_id[$i], $SAsubAreas->first()->subAreas()->get());
                        $closesJezzanSubtArea = $this->findClosestArea($request->receiver_sub_area_id[$i], $JeezansubAreas->first()->subAreas()->get());

                        $closestArea = null;
                        $closestDistance = PHP_INT_MAX;

                        // Determine the closest sub-area between the two
                        if ($closesSASubtArea !== null && $closesSASubtArea['distance'] < $closestDistance) {
                            $closestArea = $closesSASubtArea['area'];
                            $closestDistance = $closesSASubtArea['distance'];
                        }

                        if ($closesJezzanSubtArea !== null && $closesJezzanSubtArea['distance'] < $closestDistance) {
                            $closestArea = $closesJezzanSubtArea['area'];
                            $closestDistance = $closesJezzanSubtArea['distance'];
                        }

                        if ($closestArea !== null) {
                            $OrderData['receiver_area_id'] = $closestArea->area_id; // Assuming 'area_id' is the field you want
                            $OrderData['receiver_sub_area_id'] = $closestArea->id; // Assuming 'id' is the sub-area ID field
                        } else {
                            // Handle the case where no close sub-area is found
                            $OrderData['receiver_area_id'] = 11;
                            $OrderData['receiver_sub_area_id'] = 506;
                        }
                    } else {
                        $knownsubAreas = Area::where('country_code', $request->receiver_area_id)->get();

                        if ($knownsubAreas->isEmpty()) {
                            // Handle the case where no areas are found
                            $OrderData['receiver_area_id'] = 11;
                            $OrderData['receiver_sub_area_id'] = 506;
                        } else {
                            // Use the first area to set receiver_area_id
                            $OrderData['receiver_area_id'] = $knownsubAreas->first()->id;

                            // Find the closest sub-area
                            $closesSubtArea = $this->findClosestArea($request->receiver_sub_area_id[$i], $knownsubAreas->first()->subAreas()->get());

                            if ($closesSubtArea !== null) {
                                $OrderData['receiver_sub_area_id'] = $closesSubtArea['area']->id; // Assuming 'id' is the sub-area ID field
                            } else {
                                $OrderData['receiver_sub_area_id'] = 506;
                            }
                        }
                    }
                } catch (\Throwable $th) {
                    // Handle exceptions and set default values
                    $OrderData['receiver_area_id'] = 11;
                    $OrderData['receiver_sub_area_id'] = 506;


                    return response([
                        'status' => false,
                        'message' => 'Something Went Wrong in area sections',
                        'error' => $th->getMessage(),
                    ]);
                }

                $OrderData['receiver_address'] = $request->receiver_address[$i];
                if($OrderData['receiver_sub_area_id'] == 506) {
                    $OrderData['receiver_address'] .= " , " . $request->receiver_sub_area_id[$i];
                }

                if($OrderData['receiver_area_id'] == 11) {
                    $OrderData['receiver_address'] .= " , " . $request->receiver_area_id[$i] ;
                }

                $OrderData['service_id'] = $this->determineService($OrderData['sender_area_id'], $OrderData['receiver_area_id']);
                $OrderData['receiver_name'] = $request->receiver_name[$i];
                $OrderData['receiver_phone_no'] = $request->receiver_phone_no[$i];
                $OrderData['orderRef'] = $request->Ref_orderId[$i] ?? null;
                $OrderData['note'] = $request->note[$i] ?? null;

                $OrderData['order_fees'] = 0;
                $OrderData['order_value'] = $request->order_value[$i];
                $OrderData['payment_method'] = 'balance';
                $OrderData['order_date'] = date('Y-m-d H:i:s');
                $OrderData['status'] = 'pending';
                $OrderData['number_of_pieces'] = $request->number_of_pieces[$i] ?? 1; //1;
                $OrderData['order_weight'] = $request->order_weight[$i] ?? 5; //5;

                if ($Client->is_has_custom_price) {
                    $OrderData['delivery_fees'] = (int) filter_var(
                        ClientServicePrice::where('service_id', $OrderData['service_id'])
                            ->where('client_id', $Client->id)
                            ->first()->price,
                        FILTER_SANITIZE_NUMBER_FLOAT,
                        FILTER_FLAG_ALLOW_FRACTION,
                    );
                    $OrderData['total_fees'] = $OrderData['order_value'] - $OrderData['delivery_fees'];
                } else {
                    $OrderData['delivery_fees'] = (int) filter_var(service::find($OrderData['service_id'])->price, FILTER_SANITIZE_NUMBER_FLOAT, FILTER_FLAG_ALLOW_FRACTION);
                    $OrderData['total_fees'] = $OrderData['order_value'] - $OrderData['delivery_fees'];
                }

                try {
                    $order_id = -1;

                    DB::transaction(function () use ($OrderData, $Client, &$order_id) {
                        $inv_no = SerialSetting::first()->inv_no;
                        SerialSetting::first()->update(['inv_no' => $inv_no + 1]);
                        $OrderData['invoice_sn'] = genInvNo($inv_no);
                        $OrderData['tracking_number'] = orderTracking::generateUniqueTrackingNumber();
                        $user_name = $Client->name;
                        $note = " تم اضافه الطلب بواسطه ($user_name)";

                        $newOrder = Order::create($OrderData);
                        $order_id = $newOrder->id;

                        orderTracking::insertOrderTracking($order_id, __('translation.' . $OrderData['status']), $note, 'API', $Client->id);
                        $Client->account_balance += $OrderData['total_fees'];
                        $Client->save();
                    });
                    $results[] = ['order_id' => $request->Ref_orderId[$i], 'status' => 'success', 'Profast_id' => $order_id];
                } catch (\Throwable $th) {
                    $results[] = ['order_id' => $request->Ref_orderId[$i], 'status' => 'failed', 'error' => $th->getMessage()];
                }
            }

            return response([
                'status' => true,
                'message' => 'Orders processed',
                'results' => $results,
            ]);
        } catch (\Throwable $th) {
            return response([
                'status' => false,
                'message' => 'Something Went Wrong',
                'error' => $th->getMessage(),
            ]);
        }
    }

    function getClientIdFromFasterSuadi($fasterSuadiStoreId)
    {
        // Define the mapping between System A and System B clients
        $clientMapping = [
            'FasterSuaidID' => 'ProFastID',
            '502' => '297', // https://fastersaudi.com/store/suzan/
            '2550' => '469', // https://fastersaudi.com/store/arwa/
            '8574' => '352', //https://fastersaudi.com/store/roz/
            // "4" => "104"
        ];

        // Check if the provided client ID exists in the mapping
        if (array_key_exists($fasterSuadiStoreId, $clientMapping)) {
            return $clientMapping[$fasterSuadiStoreId];
        } else {
            return 525;
        }
    }

    private function determineService($senderAreaId, $receiverAreaId)
    {
        // Example criteria for determining the service

        if (($senderAreaId == 5) & ($receiverAreaId == 5)) {
            return 1; // Local delivery service ID
        } elseif (($senderAreaId == 5) & ($receiverAreaId == 4)) {
            return 2; // Local delivery service ID
        } else {
            return 3; // Local delivery service ID
        }
    }
    public function findClosestArea($name, $knownAreas, $threshold = 1)
    {
        if (!is_string($name)) {
            // Handle invalid input
            return null;
        }

        $closestArea = null;
        $shortestDistance = -1;

        // Normalize the input name
        $normalizedInputName = $this->normalizeString($name);
        $inputPhonetic = $this->getPhonetic($normalizedInputName);

        foreach ($knownAreas as $area) {
            // Normalize the area name
            $normalizedAreaName = $this->normalizeString($area->name);
            $areaPhonetic = $this->getPhonetic($normalizedAreaName);

            // Calculate Levenshtein distance
            $levDistance = levenshtein($inputPhonetic, $areaPhonetic);

            if ($levDistance == 0) {
                // Exact match found
                return [
                    'area' => $area,
                    'distance' => $levDistance,
                ];
            }

            if ($levDistance < $shortestDistance || $shortestDistance < 0) {
                // Found a closer match
                $closestArea = $area;
                $shortestDistance = $levDistance;
            }
        }

        // Check if the closest match is within the acceptable threshold
        if ($shortestDistance > $threshold) {
            // No reasonably close match found
            return null;
        }

        return [
            'area' => $closestArea,
            'distance' => $shortestDistance,
        ];
    }

    private function normalizeString($string)
    {
        // Convert to lowercase
        $string = mb_strtolower($string, 'UTF-8');

        // Remove diacritics and non-alphanumeric characters
        $string = preg_replace('/[^\p{L}\p{N}\s]/u', '', $string);

        return $string;
    }

    private function getPhonetic($string)
    {
        // Simplified Arabic phonetic conversion
        $replacements = [
            'ا' => 'A',
            'أ' => 'A',
            'إ' => 'A',
            'آ' => 'A',
            'ب' => 'B',
            'ت' => 'T',
            'ث' => 'TH',
            'ج' => 'J',
            'ح' => 'H',
            'خ' => 'KH',
            'د' => 'D',
            'ذ' => 'DH',
            'ر' => 'R',
            'ز' => 'Z',
            'س' => 'S',
            'ش' => 'SH',
            'ص' => 'S',
            'ض' => 'D',
            'ط' => 'T',
            'ظ' => 'DH',
            'ع' => 'A',
            'غ' => 'GH',
            'ف' => 'F',
            'ق' => 'Q',
            'ك' => 'K',
            'ل' => 'L',
            'م' => 'M',
            'ن' => 'N',
            'ه' => 'H',
            'و' => 'W',
            'ي' => 'Y',
            'ى' => 'A',
            'ة' => 'H',
        ];

        $string = strtr($string, $replacements);
        return $string;
    }

    public function test()
    {
        // $this->AllRepresentiveNotifcation();
        $this->AddUserToFirebase('jksa.work.1@gmail.com12312', 'mohammed1234');
    }

    public function AreaStatic()
    {
        try {
            $Sql = 'SELECT COUNT(orders.id)  as data , orders.sender_area_id, areas.name as label  from orders , areas WHERE areas.id = orders.sender_area_id and orders.client_id = ? GROUP BY orders.sender_area_id';
            $order = DB::select($Sql, [auth()->user()->id]);
            return response([
                'status' => true,
                'data' => $order,
            ]);
        } catch (Exception $e) {
            return $e;
            return response([
                'status' => true,
                'data' => 'something Went Worng',
            ]);
        }
    }
    public function updateToken(Request $request)
    {
        // Validate the request data
        $request->validate([
            'message_token' => 'required|string',
        ]);

        // Get the authenticated client
        $client = Client::findOrFail(auth()->user()->id);

        // Update the message token
        $client->update([
            'message_token' => $request->input('message_token'),
        ]);

        // Return a success response
        return response()->json(['message' => 'Message token updated successfully']);
    }

    public function getOrderAnalytics()
    {
        $userId = auth()->user()->id;

        $data = DB::table('orders as o')->join('sub_areas as a', 'o.receiver_sub_area_id', '=', 'a.id')->join('services as s', 'o.service_id', '=', 's.id')->select('a.name AS AreaName', DB::raw("SUM(CASE WHEN s.name = 'توصيل الطلبات للمتاجر' THEN 1 ELSE 0 END) AS DeliveryToStores"), DB::raw("SUM(CASE WHEN s.name = 'شحن الطلبات للمتاجر' THEN 1 ELSE 0 END) AS ShippingToStores"), DB::raw("SUM(CASE WHEN s.name = 'استرجاع الطلبات من العميل' THEN 1 ELSE 0 END) AS ReturnFromCustomer"), DB::raw("SUM(CASE WHEN s.name = 'استرجاع الطلبات بعد محاولة التسليم' THEN 1 ELSE 0 END) AS ReturnAfterDeliveryAttempt"), DB::raw("SUM(CASE WHEN s.name = 'الشحن الدولي' THEN 1 ELSE 0 END) AS InternationalShipping"), DB::raw('COUNT(*) AS TotalOrders'))->where('o.client_id', $userId)->where('o.is_deleted', 0)->groupBy('a.name')->havingRaw('TotalOrders > 0')->orderBy('TotalOrders', 'DESC')->get();

        // Transform the data to match the desired format
        $formattedData = [];
        foreach ($data as $item) {
            $formattedData[] = [
                'AreaName' => $item->AreaName,
                'DeliveryToStores' => $item->DeliveryToStores,
                'ShippingToStores' => $item->ShippingToStores,
                'ReturnFromCustomer' => $item->ReturnFromCustomer,
                'ReturnAfterDeliveryAttempt' => $item->ReturnAfterDeliveryAttempt,
                'InternationalShipping' => $item->InternationalShipping,
                'TotalOrders' => $item->TotalOrders,
            ];
        }
        return response([
            'status' => true,
            'data' => $formattedData,
        ]);
        //return response()->json($formattedData);
    }

    public function serachInCleint(Request $request)
    {
        $prams = $request->all();
        $clients = Client::where(function ($q) use ($prams) {
            foreach ($prams as $key => $value) {
                $q->orWhere($key, 'like', '%' . $value . '%')
                    ->orWhere($key, 'like', '%' . $value)
                    ->orWhere($key, 'like', $value . '%')
                    ->orWhere($key, 'like', $value);
            }
        })->get();
        return response()->json(
            [
                'cleints' => $clients,
                'status' => 0,
            ],
            200,
        );
    }

    public function OrdrsBelongToClient($id)
    {
        $orders = Order::where('client_id', $id)->get();
        return response()->json(
            [
                'orders' => $orders,
                'status' => 0,
            ],
            200,
        );
    }

    public function ClientAjaxSearch(Request $request)
    {
        $search = $request->search;
        $prams = ['fullname', 'phone'];
        $employees = Client::when($search != null, function ($query) use ($prams, $search) {
            $query->orWhere(function ($q) use ($prams, $search) {
                foreach ($prams as $key) {
                    $q->orWhere($key, 'like', '%' . $search . '%')
                        ->orWhere($key, 'like', '%' . $search)
                        ->orWhere($key, 'like', $search . '%')
                        ->orWhere($key, 'like', $search);
                }
            });
        })

            ->orderby('fullname', 'asc')
            ->select('id', 'fullname')
            ->limit(5)
            ->get();
        //  Return Reponose
        $response = [];
        foreach ($employees as $employee) {
            $response[] = [
                'id' => $employee->id,
                'text' => $employee->fullname,
            ];
        }
        return response()->json($response);
    }

    private function getOrderData(Client $Client , Request $request, int $i)
    {
        $OrderData = [
            'sender_name' => $Client->fullname,
            'sender_phone' => $Client->phone,
            'sender_area_id' => $Client->area_id,
            'sender_sub_area_id' => $Client->sub_area_id,
            'sender_address' => $Client->address,
            'client_id' => $Client->id,
        ];

        try {
            if ($request->receiver_area_id[$i] == 'SA') {
                $SAsubAreas = Area::where('id', 4)->get();
                $JeezansubAreas = Area::where('id', 5)->get();

                $closesSASubtArea = $this->findClosestArea($request->receiver_sub_area_id[$i], $SAsubAreas->first()->subAreas()->get());
                $closesJezzanSubtArea = $this->findClosestArea($request->receiver_sub_area_id[$i], $JeezansubAreas->first()->subAreas()->get());

                $closestArea = null;
                $closestDistance = PHP_INT_MAX;

                // Determine the closest sub-area between the two
                if ($closesSASubtArea !== null && $closesSASubtArea['distance'] < $closestDistance) {
                    $closestArea = $closesSASubtArea['area'];
                    $closestDistance = $closesSASubtArea['distance'];
                }

                if ($closesJezzanSubtArea !== null && $closesJezzanSubtArea['distance'] < $closestDistance) {
                    $closestArea = $closesJezzanSubtArea['area'];
                    $closestDistance = $closesJezzanSubtArea['distance'];
                }

                if ($closestArea !== null) {
                    $OrderData['receiver_area_id'] = $closestArea->area_id; // Assuming 'area_id' is the field you want
                    $OrderData['receiver_sub_area_id'] = $closestArea->id; // Assuming 'id' is the sub-area ID field
                } else {
                    // Handle the case where no close sub-area is found
                    $OrderData['receiver_area_id'] = 11;
                    $OrderData['receiver_sub_area_id'] = 506;
                }
            } else {
                $knownsubAreas = Area::where('country_code', $request->receiver_area_id[$i])->get();

                if ($knownsubAreas->isEmpty()) {
                    // Handle the case where no areas are found
                    $OrderData['receiver_area_id'] = 11;
                    $OrderData['receiver_sub_area_id'] = 506;
                } else {
                    // Use the first area to set receiver_area_id
                    $OrderData['receiver_area_id'] = $knownsubAreas->first()->id;

                    // Find the closest sub-area
                    $closesSubtArea = $this->findClosestArea($request->receiver_sub_area_id[$i], $knownsubAreas->first()->subAreas()->get());

                    if ($closesSubtArea !== null) {
                        $OrderData['receiver_sub_area_id'] = $closesSubtArea['area']->id; // Assuming 'id' is the sub-area ID field
                    } else {
                        $OrderData['receiver_sub_area_id'] = 506;
                    }
                }
            }
        } catch (\Throwable $th) {

            return response([
                'status' => false,
                'message' => 'Something Went Wrong in area sections',
                'error' => $th->getMessage(),
            ]);
        }

        $OrderData['receiver_address'] = $request->receiver_address[$i];
        if($OrderData['receiver_sub_area_id'] == 506) {
            $OrderData['receiver_address'] .= " , " . $request->receiver_sub_area_id[$i];
        }

        if($OrderData['receiver_area_id'] == 11) {
            $OrderData['receiver_address'] .= " , " . $request->receiver_area_id[$i] ;
        }

        $OrderData['service_id'] = $this->determineService($OrderData['sender_area_id'], $OrderData['receiver_area_id']);
        $OrderData['receiver_name'] = $request->receiver_name[$i];
        $OrderData['receiver_phone_no'] = $request->receiver_phone_no[$i];
        $OrderData['orderRef'] = $request->Ref_orderId[$i] ?? null;
        $OrderData['note'] = $request->note[$i] ?? null;

        $OrderData['order_fees'] = 0;
        $OrderData['order_value'] = $request->order_value[$i];
        $OrderData['payment_method'] = 'balance';
        $OrderData['order_date'] = date('Y-m-d H:i:s');
        $OrderData['status'] = 'pending';
        $OrderData['number_of_pieces'] = $request->number_of_pieces[$i] ?? 1; //1;
        $OrderData['order_weight'] = $request->order_weight[$i] ?? 5; //5;

        if ($Client->is_has_custom_price) {
            $OrderData['delivery_fees'] = (int) filter_var(
                ClientServicePrice::where('service_id', $OrderData['service_id'])
                    ->where('client_id', $Client->id)
                    ->first()->price,
                FILTER_SANITIZE_NUMBER_FLOAT,
                FILTER_FLAG_ALLOW_FRACTION,
            );
            $OrderData['total_fees'] = $OrderData['order_value'] - $OrderData['delivery_fees'];
        } else {
            $OrderData['delivery_fees'] = (int) filter_var(service::find($OrderData['service_id'])->price, FILTER_SANITIZE_NUMBER_FLOAT, FILTER_FLAG_ALLOW_FRACTION);
            $OrderData['total_fees'] = $OrderData['order_value'] - $OrderData['delivery_fees'];
        }
        return $OrderData;
    }

    private function createOrderAndOrderTrackingAndUpdateClient(array $OrderData, mixed $Client, $source = "NORMAL"): int
    {
        // Prepare Serial Setting  And invoice Sn
        $inv_no = SerialSetting::first()->inv_no;
        SerialSetting::first()->update(['inv_no' => $inv_no + 1]);
        $OrderData['invoice_sn'] = genInvNo($inv_no);

        $OrderData["order_source"] = $source;

        // Order Tracking Generate
        $OrderData['tracking_number'] = orderTracking::generateUniqueTrackingNumber();
        $note = " تم اضافه الطلب بواسطه ($Client->name)";
        // Create Order And Update Order Tracking
        $newOrder = Order::create($OrderData);
        $order_id = $newOrder->id;

        orderTracking::insertOrderTracking($order_id, __('translation.' . $OrderData['status']), $note, 'API', $Client->id);
        //    Increase Client Balance
        $Client->account_balance += $OrderData['total_fees'];
        $Client->save();

        return $order_id;
    }

    /**
     * @param Request $request
     * @return \Illuminate\Database\Eloquent\HigherOrderBuilderProxy|mixed
     */
    public function getClientWithApiKey(Request $request): mixed
    {
        $apikey = $request->api_key;
        $clientsTokens = ClientsTokens::with('Client')
            ->select('client_id')
            ->where('api_key', $apikey)
            ->where('api_secret_token', $request->api_secret_token)
            ->first();

        $Client = $clientsTokens->Client;
        return $Client;
    }
}
