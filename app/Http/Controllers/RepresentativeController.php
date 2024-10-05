<?php

namespace App\Http\Controllers;

use App\Events\SendNotifcationWithFireBase;
use App\Models\Area;
use App\Models\Client;
use App\Models\clientsFile;
use App\Models\Order;
use App\Models\orderTracking;
use App\Models\OrganizationProfile;
use App\Models\Representative;
use App\Models\RepresentativeArea;
use App\Models\Service;
use App\Models\Setting;
use App\Models\SubArea;
use Exception;
use Hamcrest\Arrays\IsArray;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;


class RepresentativeController extends Controller
{
    public function index()
    {
        return view('representatives.index');
    }

    public function representativesOrders()
    {
        return view('representatives.representatives-orders');
    }

    public function representativesFeesCollection()
    {
        return view('representatives.representatives-fees-collection');
    }

    public function representativesPayment()
    {
        return view('representatives.representatives-payment');
    }

    // *******************Apis**************

    public function getAllAreas(Request $request)
    {
        try {
            $areas = Area::where('id', '!=', 11)->get();

            return response([
                "status" => true,
                "data" => $areas
            ]);
        } catch (\Throwable $th) {
            //throw $th;
            return response([
                'status' => false,
                'message' => 'Something Went Wrong'
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
                "status" => true,
                "data" => $sub_areas
            ]);
        } catch (\Throwable $th) {
            //throw $th;
            return response([
                'status' => false,
                'message' => 'Something Went Wrong'
            ]);
        }
    }
    public function acceptOrder(Request $request)
    {
        $validatedData = $request->validate([

            'order_id' => 'required|exists:orders,id',
        ]);
        try {
            $order = Order::find($validatedData['order_id']);
            // return $representative->representative_id;
            if ($order->representative_id) {
                return response([
                    "status" => false,
                    "message" => 'This order is accepted by another representative'
                ]);
            }
            DB::transaction(function () use ($order, $validatedData) {

                $status = $order->update([
                    "status" => "pickup",
                    "representative_id" => auth()->user()->id,
                ]);

                //insert into order Tracking
                $representative = auth()->user()->fullname;
                $note = " تم استلام الطلب بواسطه  ( $representative )";
                orderTracking::insertOrderTracking($validatedData['order_id'], "استلام الطلب", $note, 'representative', auth()->user()->id);
                // dd($OrderTrak);
            });
            $CLient = Client::find($order->client_id);
            // Event To Send The  Notification To User Commit           ######
            // event(new SendNotifcationWithFireBase($CLient->message_token, __('translation.OrderMangemnt'), __('translation.Order_has_Been_Accepted_by') ." ". auth()->user()->fullname, '' ,$order->id));
            return response([
                "status" => true,
                "message" => 'Order accepted successfully'
            ]);
        } catch (\Throwable $th) {
            //throw $th;
            return response([
                'status' => false,
                'message' => 'Something Went Wrong'
            ]);
        }
    }
    //////////////////////////////////////////////////////////////////////////////////////////////////////


  public function deliverOrder2(Request $request)
    {
        // Validate the request data
        $request->validate([
            'order_id' => 'required|exists:orders,id',
            'transfer_number'=> 'required|String',
            'payment_method'=> 'required|String',

        ]);


        try {



            DB::transaction(function () use ($validatedData) {
                $Order = Order::find($validatedData['order_id']);


                $status = $Order->update([

                    "status" => "delivered",
                    "delivery_date" => date('Y-m-d h:m:s'),
                    "transfer_number" => $validatedData['transfer_number'],
                    "payment_method" => $validatedData['payment_method'],


                ]);

                //insert into order Tracking
                $representative = auth()->user()->fullname;
                $note = "تم تسليم الطلب عبر المندوب  ( $representative )";
                $Client = Client::find($Order->client_id);
                // Event To Send Firebase Notification To  Comment          ----------------
                // event(new SendNotifcationWithFireBase(
                //     $Client->message_token,
                //     __('translation.OrderMangemnt'),
                //     __('translation.YourOrderWasDliverdSuccessfuly') . " " . auth()->user()->fullname ,
                //      '' , #filename TO Send With Out Image
                //     $Order->id,
                // ));

                orderTracking::insertOrderTracking($validatedData['order_id'], "تم التسليم", $note, 'representative', auth()->user()->id);
            });
             // Get the uploaded file
    //    $file = $request->file('file');

        // Store the file in a designated folder (e.g., storage/app/images)
    //    $filePath = $file->store('images');

            return response([
                "status" => true,
                "message" => 'Order delivered successfully'
            ]);
        } catch (\Throwable $th) {
            //throw $th;
            return response([
                'status' => false,
                'message' => 'Something Went Wrong'
            ]);
        }
        // Perform any necessary operations with the uploaded file and additional data
        // ...

        // Return a response indicating success or failure
      //  return response()->json(['message' => 'Image uploaded successfully']);
    }
    ///////////////////////////////////////////////////////////
     public function deliverOrder(Request $request)
    {
        $validatedData = $request->validate([
            'order_id' => 'required|exists:orders,id'
        ]);
        try {
            DB::transaction(function () use ($validatedData) {
                $Order = Order::find($validatedData['order_id']);
                $status = $Order->update([
                    "status" => "delivered",
                    "delivery_date" => date('Y-m-d h:m:s'),
                ]);

                //insert into order Tracking
                $representative = auth()->user()->fullname;
                $note = "تم تسليم الطلب عبر المندوب  ( $representative )";
                $Client = Client::find($Order->client_id);
                // Event To Send Firebase Notification To  Comment          ----------------
                // event(new SendNotifcationWithFireBase(
                //     $Client->message_token,
                //     __('translation.OrderMangemnt'),
                //     __('translation.YourOrderWasDliverdSuccessfuly') . " " . auth()->user()->fullname ,
                //      '' , #filename TO Send With Out Image
                //     $Order->id,
                // ));

                orderTracking::insertOrderTracking($validatedData['order_id'], "تم التسليم", $note, 'representative', auth()->user()->id);
            });
            return response([
                "status" => true,
                "message" => 'Order delivered successfully'
            ]);
        } catch (\Throwable $th) {
            //throw $th;
            return response([
                'status' => false,
                'message' => 'Something Went Wrong'
            ]);
        }
    }
   public function deliverOrdepppppr(Request $request)
    {
       try {
        // Validate the request data
        $validatedData = $request->validate([
            'order_id' => 'required|exists:orders,id',
            'image' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'transfer_number' => 'required|string',
            'payment_method' => 'required|string',
        ]);

        // Get the order from the database
        $order = Order::find($validatedData['order_id']);

        // Update the order with the new data
        $order->status= "delivered";
        $order->transfer_number = $validatedData['transfer_number'];
        $order->payment_method = $validatedData['payment_method'];

        // Check if an image was uploaded
        if ($request->hasFile('image')) {
            // Get the uploaded image file
            $image = $request->file('image');

            // Generate a unique name for the image
            $imageName = time() . '.' . $image->getClientOriginalExtension();

            // Store the image in the storage directory
            Storage::disk('public')->putFileAs('images', $image, $imageName);

            // Update the order with the image path
            $order->image = 'images/' . $imageName;
        }

        // Save the updated order
        $order->save();
         $representative = auth()->user()->fullname;
         $note = "تم تسليم الطلب عبر المندوب  ( $representative )";
         $Client = Client::find($order->client_id);
         orderTracking::insertOrderTracking($validatedData['order_id'], "تم التسليم", $note, 'representative', auth()->user()->id);

        return response([
                "status" => true,
                "message" => 'Order delivered successfully'
            ]);
    } catch (\Exception $e) {
        // Handle any exceptions that occur during the update
        return "An error occurred: " . $e->getMessage();
    }
    }
    ///////////////////////////////////////////////////////////////////
    public function deliverOrderWithoutImage(Request $request)
    {
       try {
        // Validate the request data
        $validatedData = $request->validate([
            'order_id' => 'required|exists:orders,id',
            'transfer_number' => 'required|string',
            'payment_method' => 'required|string',
        ]);

        // Get the order from the database
        $order = Order::find($validatedData['order_id']);

        // Update the order with the new data
        $order->status= "delivered";
        $order->transfer_number = $validatedData['transfer_number'];
        $order->payment_method = $validatedData['payment_method'];

        // Save the updated order
        $order->save();
        ////
         $representative = auth()->user()->fullname;
         $note = "تم تسليم الطلب عبر المندوب  ( $representative )";
         $Client = Client::find($order->client_id);
         orderTracking::insertOrderTracking($validatedData['order_id'], "تم التسليم", $note, 'representative', auth()->user()->id);
        ////////
        return response([
                "status" => true,
                "message" => 'Order delivered successfully'
            ]);
    } catch (\Exception $e) {
        // Handle any exceptions that occur during the update
        return "An error occurred: " . $e->getMessage();
    }
    }

  //////////////////////////////////////////////////////////////////
     public function addOrderTrackingMassage(Request $request)
    {
        $validatedData = $request->validate([
            'order_id' => 'required|exists:orders,id',
            'message'=>'String'
        ]);
        try {
            DB::transaction(function () use ($validatedData) {


                $Order = Order::find($validatedData['order_id']);

                //insert into order Tracking
                $representative = auth()->user()->fullname;
                $note =$validatedData['message'] ." عبر المندوب  ( $representative )";
               // $Client = Client::find($Order->client_id);
                // Event To Send Firebase Notification To  Comment          ----------------
                // event(new SendNotifcationWithFireBase(
                //     $Client->message_token,
                //     __('translation.OrderMangemnt'),
                //     __('translation.YourOrderWasDliverdSuccessfuly') . " " . auth()->user()->fullname ,
                //      '' , #filename TO Send With Out Image
                //     $Order->id,
                // ));
                orderTracking::insertOrderTracking($validatedData['order_id'], "اخرى", $note, 'representative', auth()->user()->id,$note);
            });
            return response([
                "status" => true,
                "message" => 'Order tracking added successfully'
            ]);
        } catch (\Throwable $th) {
            throw $th;
            return response([
                'status' => false,
                'message' => 'Something Went Wrong'
            ]);
        }
    }

////////////////////////////////////////////////////////////////////

public function addOrderTrackingMassage1(Request $request)
    {
        $validatedData = $request->validate([
            'id' => 'required|exists:id',
            'message'=>'String'
        ]);
        try {
            DB::transaction(function () use ($validatedData) {


                $Order = Order::find($validatedData['id']);

                //insert into order Tracking
                $representative = auth()->user()->fullname;
                $note =$validatedData['message'] ." عبر المندوب  ( $representative )";
               // $Client = Client::find($Order->client_id);
                // Event To Send Firebase Notification To  Comment          ----------------
                // event(new SendNotifcationWithFireBase(
                //     $Client->message_token,
                //     __('translation.OrderMangemnt'),
                //     __('translation.YourOrderWasDliverdSuccessfuly') . " " . auth()->user()->fullname ,
                //      '' , #filename TO Send With Out Image
                //     $Order->id,
                // ));
                Order::insertOrderTracking($validatedData['id'], "اخرى", $note, 'representative', auth()->user()->id,$note);
            });
            return response([
                "payment_method2" => 'nnnnn',
                "transfer_number" => '123',
                "message" => 'Order tracking added successfully'
            ]);
        } catch (\Throwable $th) {
            throw $th;
            return response([
                'status' => false,
                'message' => 'Something Went Wrong'
            ]);
        }
    }





/////////////////////////////////////////////////////////////////





    public function transferOrder(Request $request)
    {
        $validatedData = $request->validate([
            'order_id' => 'required|exists:orders,id',
            'representative_id' => 'required|exists:representatives,id',
        ]);

        try {
            $order = Order::find($validatedData['order_id']);
            if ($order->status == 'completed' || $order->status == 'delivered' || $order->status == 'returned' || $order->status == 'canceled') {
                return response([
                    'status' => false,
                    'message' => 'Something Went Wrong'
                ]);
            }

            DB::transaction(function () use ($validatedData) {
                $order = Order::find($validatedData['order_id']);
                $order->update(
                    [
                        "representative_id" => $validatedData["representative_id"], "status" => (($order->status == "pending") ? "pickup" : "inProgress")
                    ]
                );
                // insert into order tracking
                $user_name = auth()->user()->name;
                $representative = Representative::find($validatedData['representative_id'])->fullname;
                $status = $order->status;
                $note = "order has been transferred to another representative ( " . $representative . " ) by representative ( $user_name )";
                orderTracking::insertOrderTracking($validatedData['order_id'],__('translation.'.$status) , $note, 'representative', auth()->user()->id);
            });


            return response([
                "status" => true,
                "message" => 'Order transferred successfully'
            ]);
        } catch (\Throwable $th) {
            //throw $th;
            return response([
                'status' => false,
                'message' => 'Something Went Wrong'
            ]);
        }
    }

    public function transferMultiOrders(Request $request){

        $validatedData = $request->validate([
            'order_ids' => 'required|exists:orders,id',
            'representative_id' => 'required|exists:representatives,id',
        ]);

        $orders = Order::whereIn('id', $validatedData['order_ids'])->update(
            [
                "representative_id" => $validatedData["representative_id"],
            ]
        );
        return response([
            "status" => true,
            "message" => 'Order transferred successfully'
        ]);
    }
    public function getRepresentative(Request $request)
    {
        try {
            $representative = Representative::with('areas', 'subareas')->where('is_active', 1)->find(auth()->user()->id);
            if ($representative) {
                return response([
                    "status" => true,
                    "data" => $representative
                ]);
            } else {
                return response([
                    'status' => false,
                    'message' => 'Something Went Wrong'
                ]);
            }
        } catch (\Throwable $th) {
            //throw $th;
            return response([
                'status' => false,
                'message' => 'Something Went Wrong'
            ]);
        }
    }
    public function updateRepresentativeAreas(Request $request)
    {
        $validatedData = $request->validate([
            'areas' => 'required',
        ]);
        // return $request->areas;
        $validatedData_array = ($validatedData['areas']);
        try {
            RepresentativeArea::where('representative_id', auth()->user()->id)->delete();
            $areas_to_store = [];
            foreach ($validatedData_array as $key => $value) {
                $areas_to_store[$key] = ["representative_id" => auth()->user()->id, "subarea_id" => $value];
            }
            $new_areas = RepresentativeArea::insert($areas_to_store);
            if ($new_areas) {
                return response([
                    "status" => true,
                    "data" => RepresentativeArea::with('subareas')->where('representative_id', auth()->user()->id)->get(),
                ]);
            } else {
                return response([
                    'status' => false,
                    'message' => 'Something Went Wrong',
                ]);
            }
        } catch (\Throwable $th) {
            return response([
                'status' => false,
                'message' => 'Something Went Wrong'
            ]);
        }
    }
   public function getOrder(Request $request)
    {
        $validatedData = $request->validate([
            'order_id' => 'required|exists:orders,tracking_number',
            'representative_id' => 'required|exists:representatives,id'
        ]);
        try {
            //code...
            // $order = Order::with('service')->isDeleted()->find($validatedData['order_id']);
            $order = DB::table('orders_full_data')
            ->select("*")
            ->where('tracking_number', '=', $validatedData['order_id'])
            ->where(function ($query) use ($validatedData) {
                $query->where('representative_id', '=', $validatedData['representative_id'])
                    ->orWhere('representative_id', '=', null);
            })
            ->where('is_deleted', '=', '0')
            ->get();
               return response([
                       "status" => true,
                        "data" => $order,
                           ]);

            } catch (\Throwable $th) {
            //throw $th;
            return response([
                'status' => false,
                'message' => 'Something Went Wrong'
            ]);
        }
    }
    public function getBalance(Request $request)
    {

        try {
            //code...
            $representative = Representative::find(auth()->user()->id);

            return response([
                "status" => true,
                "data" => $representative->account_balance,
            ]);
        } catch (\Throwable $th) {
            //throw $th;
            return response([
                'status' => false,
                'message' => 'Something Went Wrong'
            ]);
        }
    }
    public function getAllRepresentatives()
    {

        try {
            $representative = Representative::where('is_active', '1')->get(['id', 'fullname']);

            return response([
                "status" => true,
                "data" => $representative,
            ]);
        } catch (\Throwable $th) {
            //throw $th;
            return response([
                'status' => false,
                'message' => 'Something Went Wrong'
            ]);
        }
    }
    public function getRepresentativeAreasOrders(Request $request)
    {



        try {
            $representative_areas = DB::table('areas')->select(["name", "area_id", "fees"])
                ->join('representative_areas', 'areas.id', '=', 'representative_areas.area_id', 'inner')
                ->where('representative_areas.representative_id', '=', auth()->user()->id)->get();

            foreach ($representative_areas as $key => $value) {
                $value->orders = DB::table('orders_full_data')
                    ->where('sender_area_id', "=", $value->area_id)
                    ->where('representative_id', "=", auth()->user()->id)
                    ->where('is_deleted', 0)->orderBy("order_date", "DESC")->get();
            }

            return response([
                "status" => true,
                "data" => $representative_areas,
            ]);
        } catch (\Throwable $th) {
            throw $th;
            return response([
                'status' => false,
                'message' => 'Something Went Wrong'
            ]);
        }
    }
    public function getRepresentativeAreaOrders(Request $request)
    {
        $validatedData = $request->validate([
            'area_id' => 'required|exists:areas,id'
        ]);
        try {


            $orders = DB::table('orders_full_data')
                ->where('sender_area_id', "=", $validatedData['area_id'])
                ->where('representative_id', "=", auth()->user()->id)
                ->where('is_deleted', 0)->orderBy("order_date", "DESC")->get();

            return response([
                "status" => true,
                "data" => $orders,
            ]);
        } catch (\Throwable $th) {
            throw $th;
            return response([
                'status' => false,
                'message' => 'Something Went Wrong'
            ]);
        }
    }

    public function getRepresentativeOrdersByOrderStatus(Request $request)
    {
        $validatedData = $request->validate([
            'order_status' => 'required|in:pending,inProgress,delivered,completed,canceled,pickup,pickup-all'
        ]);

        try {
            if ($validatedData['order_status'] != 'pickup-all') {
                $orders = DB::table('orders_full_data')->where(
                    [
                        'status' => $validatedData['order_status'],
                        'representative_id' => auth()->user()->id
                    ]
                )->orderBy("order_date", "DESC")->get();
            } else {
                $orders = DB::table('orders_full_data')
                    ->where(["status" => "pickup"])
                    ->orderBy("order_date", "DESC")
                    ->get();
            }
            return response([
                "status" => true,
                "data" => $orders,
            ]);
        } catch (\Throwable $th) {
            // throw $th;
            return response([
                'status' => false,
                'message' => 'Something Went Wrong'
            ]);
        }
    }
     public function getRepresentativeAreasPendingOrders(Request $request)
    {
        try {
            $orders = DB::table('representatives')
                ->join("representative_areas as ra", "ra.representative_id", "representatives.id")
                ->join("orders_full_data", "orders_full_data.sender_sub_area_id", "ra.subarea_id")
                ->selectRaw("orders_full_data.*")
                ->where([
                    'orders_full_data.status' => 'pending',
                    'ra.representative_id' => auth()->user()->id,
                ])->orderBy("order_date", "DESC")
                ->get();

            // return $orders;

            return response([
                "status" => true,
                "data" => $orders,
            ]);
        } catch (\Throwable $th) {
            throw $th;
            return response([
                'status' => false,
                'message' => 'Something Went Wrong'
            ]);
        }
    }


      public function getClientOrdersByIdAndSubAreaAndStatus(Request $request)
    {

        $validatedData = $request->validate([
            'ClientId' => 'int',
            'clientSenderAreaId' => 'int',
            'status'=>'String'
        ]);


        try {
            $orders = DB::table('representatives')
                ->join("representative_areas as ra", "ra.representative_id", "representatives.id")
                ->join("orders_full_data", "orders_full_data.sender_sub_area_id", "ra.subarea_id")
                ->selectRaw("orders_full_data.*")
                ->where([
                    'orders_full_data.status' => $validatedData["status"],
                    'orders_full_data.sender_sub_area_id' => $validatedData["clientSenderAreaId"],
                    'orders_full_data.client_id' =>  $validatedData["ClientId"],
                    'ra.representative_id' => auth()->user()->id,
                ])->orderBy("order_date", "DESC")
                ->get();

            // return $orders;

            return response([
                "status" => true,
                "data" => $orders,
            ]);
        } catch (\Throwable $th) {
            throw $th;
            return response([
                'status' => false,
                'message' => 'Something Went Wrong'
            ]);
        }
    }

public function getRepresentativeSummaryAreasOrdersbyStatus(Request $request)
    {
        $validatedData = $request->validate([
            'status'=>'String'
        ]);
        try {
          $orders = DB::table('representatives')
            ->join('representative_areas as ra', 'ra.representative_id', '=', 'representatives.id')
            ->join('orders_full_data', 'orders_full_data.sender_sub_area_id', '=', 'ra.subarea_id')
            ->join('clients', 'clients.id', '=', 'orders_full_data.client_id')
            ->select(
                'clients.fullname',
                'clients.id',
                DB::raw('COUNT(orders_full_data.id) as order_count'),
                'clients.address as client_address',
                'orders_full_data.sender_area_id',
                'orders_full_data.sender_area_name',
                'orders_full_data.sender_sub_area_id',
                'orders_full_data.sender_sub_area_name',
                DB::raw('MAX(orders_full_data.order_date) as latest_order_date')
            )
            ->where('orders_full_data.status', '=', $validatedData["status"])
            ->where('ra.representative_id', '=',  auth()->user()->id)
            ->groupBy(
                'clients.id',
                'clients.fullname',
                'clients.address',
                'orders_full_data.sender_area_id',
                'orders_full_data.sender_area_name',
                'orders_full_data.sender_sub_area_id',
                'orders_full_data.sender_sub_area_name'
            )
            ->orderBy('latest_order_date', 'DESC')
            ->get();


            // return $orders;

            return response([
                "status" => true,
                "data" => $orders,
            ]);
        } catch (\Throwable $th) {
            throw $th;
            return response([
                'status' => false,
                'message' => 'Something Went Wrong'
            ]);
        }
    }

    public function getRepresentativeSubAreas()
    {
        try {
            $sub_areas = DB::table('representatives')
                ->join("representative_areas as ra", "ra.representative_id", "representatives.id")
                ->join("sub_areas", "sub_areas.id", "ra.subarea_id")
                ->selectRaw("sub_areas.name")
                ->where([
                    'ra.representative_id' => auth()->user()->id,
                ])
                ->get();

            // return $orders;

            return response([
                "status" => true,
                "data" => $sub_areas,
            ]);
        } catch (\Throwable $th) {
            throw $th;
            return response([
                'status' => false,
                'message' => 'Something Went Wrong'
            ]);
        }
    }
    public function getMyOrders(Request $request)
    {
        $validatedData = $request->validate([
            'from_date' => 'sometimes|date'
        ]);
        try {
            $orders = DB::table('orders_full_data')
                ->when(isset($validatedData['from_date']), function ($query) use ($validatedData) {
                    $month = date('m', strtotime($validatedData['from_date']));
                    $year = date('Y', strtotime($validatedData['from_date']));
                    $query->where('order_date', 'like', $year . "-" . $month . "%");
                }, function ($query) {
                    $query->where('order_date', 'like', date('Y-m') . "%");
                })
                ->where('representative_id', auth()->user()->id)
                ->orderBy("order_date", "DESC")
                ->get();

            return response([
                "status" => true,
                "data" => $orders,
            ]);
        } catch (\Throwable $th) {
            throw $th;
            return response([
                'status' => false,
                'message' => 'Something Went Wrong'
            ]);
        }
    }
    public function getCompanyWhatsAppNo(Request $request)
    {
        try {
            $whatsapp_no = OrganizationProfile::first()->get('whatsapp_no');
            return response([
                "status" => true,
                "data" => $whatsapp_no,
            ]);
        } catch (\Throwable $th) {
            throw $th;
            return response([
                'status' => false,
                'message' => 'Something Went Wrong'
            ]);
        }
    }

    public function getAllServices(Request $request)
    {
        try {
            $services = Service::get('name');
            return response([
                "status" => true,
                "data" => $services
            ]);
        } catch (\Throwable $th) {
            //throw $th;
            return response([
                'status' => false,
                'message' => 'Something Went Wrong'
            ]);
        }
    }
    public function returnOrder(Request $request)
    {
        $validatedData = $request->validate([
            'order_id' => 'required|exists:orders,id'
        ]);
        try {
            DB::transaction(function () use ($validatedData) {
                $return_price = Setting::where('key', 'order_return_price')->first()->value;
                $status = Order::find($validatedData['order_id'])->update([
                    "status" => "returned",
                    "delivery_fees" => $return_price,
                ]);
                //insert into order Tracking
                $representative = auth()->user()->fullname;
                $note = "order has been returned by representative ( $representative )";
                orderTracking::insertOrderTracking($validatedData['order_id'], "استرجاع", $note, 'representative', auth()->user()->id);
            });

            return response([
                "status" => true,
            ]);
        } catch (\Throwable $th) {
            //throw $th;
            return response([
                'status' => false,
                'message' => 'Something Went Wrong'
            ]);
        }
    }
    public function inProgressOrder(Request $request)
    {
        $validatedData = $request->validate([
            'order_id' => 'required|exists:orders,id'
        ]);
        try {
            DB::transaction(function () use ($validatedData) {
                $status = Order::find($validatedData['order_id'])->update([
                    "status" => "inProgress",
                    "representative_id" => auth()->user()->id
                ]);

                //insert into order Tracking
                $representative = auth()->user()->fullname;
                $note = " يعمل المندوب علي توصيل الطلب ( $representative )";
                orderTracking::insertOrderTracking($validatedData['order_id'], "توصيل", $note, 'representative', auth()->user()->id);
            });

            return response([
                "status" => true,
            ]);
        } catch (\Throwable $th) {
            //throw $th;
            return response([
                'status' => false,
                'message' => 'Something Went Wrong'
            ]);
        }
    }

    public function getRepresentativeCompanyDeserves(Request $request)
    {
        try {
            $deserves = DB::table('orders')->where([
                "representative_id" => auth()->user()->id,
                "is_company_fees_collected" => 0,
            ])->select(DB::raw("sum(total_fees) as company_deserves"))
                ->get();

            if ($deserves) {
                return response([
                    "status" => true,
                    "data" => $deserves
                ]);
            } else {
                return response([
                    'status' => false,
                    'message' => 'Something Went Wrong'
                ]);
            }
        } catch (\Throwable $th) {
            return response([
                'status' => false,
                'message' => 'Something Went Wrong'
            ]);
        }
    }

    public function ScanBarCode(Request $request){
        $validator =  validator($request->all(), [
            'order_ids' => 'required|array',
            'status' => 'required|in:pending,inProgress,pickup,delivered',
        ]);
        // return $request->order_ids;
        // validaotr Section ----------------
        if($validator->fails()) return $validator->errors();


        //add order tracking

        foreach ($request->order_ids as $key => $value) {

            $order = Order::find($value);

            $representative = auth()->user()->fullname;


            if(($order->status =='pending' && $request->status == 'inProgress') || $request->status == 'pickup' )
             {

                $note = " تم استلام الطلب بواسطه  ( $representative )";
                orderTracking::insertOrderTracking($order->id, "استلام الطلب", $note, 'representative', auth()->user()->id);
            }

           if( $request->status == 'inProgress')
            {
            $note = " يعمل المندوب علي توصيل الطلب ( $representative )";
            orderTracking::insertOrderTracking($order->id, " توصيل ", $note, 'representative', auth()->user()->id);
            }

        }

        Order::whereIn('id' , $request->order_ids)->update(
            [
                'representative_id' => auth()->user()->id,
                'status' => $request->status,
            ]);
            return response([
                "status" => true,
                "data" => $request->status,
            ]);


    }

    public function AreaStatic(){
        try{
            $Sql = "SELECT COUNT(orders.id)  as data , orders.sender_area_id, areas.name as label  from orders , areas WHERE areas.id = orders.sender_area_id and orders.representative_id = ? GROUP BY orders.sender_area_id";
            $order = DB::select($Sql, [auth()->user()->id]);
            return response([
                "status" => true,
                "data" => $order,
            ]);
        }catch(Exception $e){
            return response([
                "status" => true,
                "data" => 'something Went Worng',
            ]);
        }
    }
}
