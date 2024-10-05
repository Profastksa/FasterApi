<?php

namespace App\Http\Controllers;

use App\Http\Livewire\ClientStatementIsues;
use App\Models\Client;
use App\Models\IssueClientStatement;
use App\Models\IssuePhotos;
use App\Models\Order;
use App\Models\Service;
use Exception;
use Illuminate\Http\Client\Response;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Mail; // Add this line to import Mail
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Crypt; // Add this line to import Crypt Add this line to import the Cache facade

class ClientIssuesController extends Controller
{
    public function showIssue($id)
    {
        $ClientStatementIsues = \App\Models\IssueClientStatement::with('Photos')->find($id);
        if(!$ClientStatementIsues){
            session()->flash('success',' الكشف المطلوب غير موجود او تم حذفه أو إزالتها');
            return redirect()->route('ClientStatementIsues');
        }
        $Orders = Order::whereIn('id', $ClientStatementIsues->orders_ids)->get();


       //   $Orderss = Order::whereIn('status', [ 'pickup' , 'inProgress'])->get();

         //  $client1 = Client::with('ServicePrice')->where('status', $Orderss[0]->client_id)->first();
        $client = Client::with('ServicePrice')->where('id', $Orders[0]->client_id)->first();
        $Services  = Service::get();
        $ServicePrice =$client->is_has_custom_price ? $client->ServicePrice : $Services;
        // $cleint = Client::where('id' , 1)->first();
        // dd($ServicePrice);
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

                 <h4> International shipping Orders </h4>
            <h4> الشحن الدوالى </h4> </div>',
            4 => '<div>
            <h4> Returned Orders by the Client </h4>

            <h4> استرجاع الطلبات من العميل </h4> </div>',

             5 => '<div>
                      <h4> Retrieving orders after unsuccessful delivery </h4>

            <h4>استرجاع الطلبات بعد محاولة التسليم  </h4> </div>',

        ];

        // return $Orders;
        return view('clients.isues', compact('Orders', 'ServicePrice',  'ClientStatementIsues', 'ServiceHeading' ,'id', 'Services', 'client'));
    }
    public function StatusIssue($id)
    {
        $IssueClientStatement = IssueClientStatement::find($id);
        $IssueClientStatement->status =  $IssueClientStatement->status == 'paid' ? 'unpaid' : 'paid';
        $IssueClientStatement->save();
        return redirect()->back();
    }

    public function cancelIssue(Request $request, $id)
    {
        $otp = rand(100000, 999999);
        $expiry = now()->addMinutes(2);

        Cache::put('otp_' . $id, $otp, $expiry);

        // Create a secure token
        $token = Crypt::encrypt(['id' => $id, 'otp' => $otp, 'expiry' => $expiry]);

        // Fetch ClientStatementIsues for email
        $ClientStatementIsues = IssueClientStatement::with('Client')->find($id);

        // Send email with the confirmation link
        $confirmationLink = route('client.issue.confirm', ['token' => $token]);

         // Send email with the confirmation link
         $confirmationLink = route('client.issue.confirm', ['token' => $token]);

         Mail::to(['faster.saudi@gmail.com', 'ahmedict6@gmail.com'])->send(new \App\Mail\IssueCancellationMail($confirmationLink, $otp, $ClientStatementIsues));

         return response()->json(['message' => 'تم ارسال اميل يحتوي رمز التحقق الرجاء التحقق من البريد الالكتروني'], 200);
    }

    public function confirmIssue(Request $request)
    {
        $token = $request->query('token');

        try {
            $data = Crypt::decrypt($token);
            $id = $data['id'];
            $otp = $data['otp'];
            $expiry = $data['expiry'];

            if (now()->greaterThan($expiry)) {
                return response('<html><body><h1>الرابط منتهي الصلاحية</h1></body></html>', 200)
                            ->header('Content-Type', 'text/html');
            }

            $ClientStatementIsues = IssueClientStatement::with('Client')->find($id);

            if (!$ClientStatementIsues) {
                return response('<html><body><h1>الرابط غير صالح أو منتهي الصلاحية</h1></body></html>', 200)
                            ->header('Content-Type', 'text/html');
            }

            IssueClientStatement::destroy($id);
            Cache::forget('otp_' . $id);
            return response('<html><body><h1>تم إلغاء كشق الحساب بنجاح</h1></body></html>', 200)
                            ->header('Content-Type', 'text/html');
        } catch (Exception $e) {
            return response('<html><body><h1>الرابط غير صالح أو منتهي الصلاحية</h1></body></html>', 200)
                            ->header('Content-Type', 'text/html');
        }
    }



    public function verifyOtp(Request $request, $id)
    {
        $otp = Cache::get('otp_' . $id);

        if ($otp && $otp == $request->otp) {
            IssueClientStatement::destroy($id);
            Cache::forget('otp_' . $id);
            return response()->json(['message' => 'Issue cancelled successfully']);
        } else {
            return response()->json(['message' => 'Invalid or expired OTP'], 400);
        }
    }



    public function UploadFiles(Request $request, $id)
    {
        // return $request;
        try{
        $name = $request->file->getClientOriginalName();
        // dd($name);
        $moved = $request->file->move(public_path("issue/{$id}"), $name);
        IssuePhotos::create([
            'issue' => $id,
            'photo' => $name,
        ]);
        }catch(Exception $e){
        return redirect()->back();
       }
        return redirect()->back();
    }
    public function ShowImage($id)
    {
        try {
            $IssuePhotos  = IssuePhotos::find($id);
            $Photo = $IssuePhotos->getRawOriginal('photo');
            $path = public_path("issue/{$IssuePhotos->issue}/{$Photo}");
            return response()->file($path);
        } catch (Exception $e) {
            return redirect()->back();
        }
    }

    public function downloadImage($id)
    {
        try {
            $IssuePhotos  = IssuePhotos::find($id);
            $Photo = $IssuePhotos->getRawOriginal('photo');
            $path = public_path("issue/{$IssuePhotos->issue}/{$Photo}");
            $headers = ['Content-Type: image/jpeg'];
            return response()->download($path, $Photo, $headers);
        } catch (Exception $e) {
            return redirect()->back();
        }
    }

    public function DeletImage($id)
    {
        try {
            $IssuePhotos  = IssuePhotos::find($id);
            $Photo = $IssuePhotos->getRawOriginal('photo');
            $path = public_path("issue/{$IssuePhotos->issue}/{$Photo}");
            unlink($path);
            $IssuePhotos->delete();
            return redirect()->back();
        } catch (Exception $e) {
            return redirect()->back();
        }
    }

    public function showPreview($clientId)
    {
        $client = Client::where('id', $clientId)->with('ServicePrice', 'Orders')->first();
        $Orders = $client->Orders->where('is_collected', 0)->where('status', 'completed')->groupBy('service_id')->map(function ($group) {
            return $group->sortBy('id');
        });

        // dd($Orders);

        $Services = Service::get();
        $ServicePrice = $client->is_has_custom_price ? $client->ServicePrice : $Services;

        $ServiceHeading = [
            1 => [
                '<div>
                    <h4> COD Orders - Delivered </h4>
                    <h4> الدفع عند الاستلام  - تم التوصيل  </h4>
                </div>',
                '<div>
                    <h4> Orders - Delivered </h4>
                    <h4> طلبات التوصيل - المدفوعه - تم التوصيل </h4>
                </div>',
            ],
            2 => '<div>
                <h4> Local shipping Orders </h4>
                <h4>  شحن الطلبات خارج المنطقة </h4>
            </div>',
            3 => '<div>
                <h4> International shipping Orders </h4>
                <h4> الشحن الدوالى </h4>
            </div>',
            4 => '<div>
                <h4> Returned Orders by the Client </h4>
                <h4> استرجاع الطلبات من العميل </h4>
            </div>',
            5 => '<div>
                <h4> Retrieving orders after unsuccessful delivery </h4>
                <h4>استرجاع الطلبات بعد محاولة التسليم  </h4>
            </div>',
        ];

        $ClientStatementIsues = 0;
        return view('livewire.new-client-statement-preview', compact('Orders', 'ServicePrice',  'ClientStatementIsues', 'ServiceHeading'  , 'Services', 'client'));
    }
}
