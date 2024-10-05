<?php

use Alhoqbani\SmsaWebService\Smsa;
use App\Http\Controllers\Api\WhatServicesControll;
use App\Http\Livewire\OrderShippingResult;
use App\Models\Order;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Session;

use App\Http\Controllers\Permission\RoleController;
use App\Http\Controllers\Permission\UserController;
use App\Http\Controllers\AreaController;
use App\Http\Controllers\ClientController;
use App\Http\Controllers\ClientIssuesController;
use App\Http\Controllers\DeviceController;
use App\Http\Controllers\FireBaseNotificationHistoryController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\HelpCenterController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\PrivacyPolicy;
use App\Http\Controllers\RegistrationRequestToBoth;
use App\Http\Controllers\Select2Controller;
use App\Http\Controllers\SubAreaController;
use App\Http\Controllers\ServiceController;
use App\Http\Controllers\ServiceToArea;
use App\Http\Controllers\SettingsController;
use App\Http\Controllers\SyncShipingWithOrderController;
use App\Http\Livewire\AddOrder;
use App\Http\Livewire\ClientAccountDetials;
use App\Http\Livewire\ClientsPay;
use App\Http\Livewire\ClientStatementIsues;
use App\Http\Livewire\MultiOrderMangement;
use App\Http\Livewire\ReprestiveOrderSearch;
use App\Jobs\ExportNotificationJob;
use App\Mail\ExportNotificationMail;
use App\Models\Client;
use App\Models\OrderShiping;
use App\Models\Service;
use App\Models\Setting;
use App\Services\Shiping\SMSAShipingService;
use App\Services\Shiping\SMSAShipingServiceAPI;
use Illuminate\Support\Facades\Http;
use App\Http\Livewire\AnalyticsLivewire;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/
use App\Http\Controllers\SendEmailController;
use App\Http\Livewire\ClientOrders;
use App\Http\Livewire\OrdersFollowUp;
use App\Http\Controllers\LogActivityController;
use Illuminate\Support\Facades\View;


Route::get('send-email', [SendEmailController::class, 'index']);
// Route::get('/', function () {
//     return view('welcome');
// });

Route::get('print-invoice/{id}', [SyncShipingWithOrderController::class, 'printInvocie'])->name('print_shiping_invoice');


/*--------------------------------------------------------------------------
| change language route
|--------------------------------------------------------------------------*/

Route::get('locale/{locale}', function ($locale) {

    Session::put('locale', $locale);

    return redirect()->back();
})->name('switchLan');  //add name to router

/*--------------------------------------------------------------------------
| END change language route
|--------------------------------------------------------------------------*/

/*--------------------------------------------------------------------------
| AUTH ROUTES
|--------------------------------------------------------------------------*/

Auth::routes(['register' => false]);

/*--------------------------------------------------------------------------
| END AUTH ROUTES
|--------------------------------------------------------------------------*/


/*--------------------------------------------------------------------------
| DASHBOARD
|--------------------------------------------------------------------------*/

Route::get('/', [App\Http\Controllers\HomeController::class, 'index'])->name('home')->middleware('auth');
Route::get('/help', [App\Http\Controllers\HelpCenterController::class, 'index'])->name('help')->middleware('auth');

/*--------------------------------------------------------------------------
| END DASHBOARD
|--------------------------------------------------------------------------*/


/*--------------------------------------------------------------------------
| USERS MANAGEMENT ROUTES
|--------------------------------------------------------------------------*/
Route::group(['middleware' => ['auth'], 'prefix' => 'users-management'], function () {
    Route::resource('roles', RoleController::class)->middleware('permission:roles-management');
    Route::resource('users', UserController::class)->middleware('permission:users-management');
});
/*--------------------------------------------------------------------------
| END USERS MANAGEMENT ROUTES
|--------------------------------------------------------------------------*/

/*--------------------------------------------------------------------------
| SETTINGS ROUTES
|--------------------------------------------------------------------------*/

Route::group(['middleware' => ['auth'], 'prefix' => 'settings'], function () {
    Route::get('areas', [AreaController::class, 'index'])->name('areas.index')->middleware('permission:areas-management');
    Route::get('sub_areas/{id}', [SubAreaController::class, 'index'])->name('sub_areas.index')->middleware('permission:areas-management');
    Route::get('getSubAreas/{id?}', [SubAreaController::class, 'getSubAreas'])->name('getSubAreas');
    Route::get('getAreasForServices/{service_id?}/{sending?}', [SubAreaController::class, 'getAreasForServices'])->name('getAreasForServices');
    Route::get('services', [ServiceController::class, 'index'])->name('services.index')->middleware('permission:services-management');
    Route::get('organization-profile', [ServiceController::class, 'organizationProfile'])->name('organization.profile')->middleware('permission:organization-profile-management');
    Route::get('general-settings', [ServiceController::class, 'generalSettings'])->name('general.settings')->middleware('permission:general-settings-management');
    Route::get('privacy-policy', [ServiceController::class,  'PrivacyPolice'])->name('privacy.police');
    Route::post('store-privacy-policy', [ServiceController::class,  'StorePrivacyPolice'])->name('store.privacy');

    Route::get('/log-activities', [LogActivityController::class, 'index'])->name('log.activities.index');
    Route::get('/log-activities/filter', [LogActivityController::class, 'filter'])->name('log.activities.filter');

});



/*--------------------------------------------------------------------------
| END SETTINGS ROUTES
|--------------------------------------------------------------------------*/
Route::middleware('auth')->prefix('registartion-request')->group(function () {
    Route::get('representatives', [RegistrationRequestToBoth::class, 'getUnAprrovedrepresentatives'])->name('getUnAprrovedrepresentatives');
    Route::get('clients', [RegistrationRequestToBoth::class, 'getUnAprrovedclient'])->name('getUnAprrovedclient');
    Route::get('approvement/{id}/{type}', [RegistrationRequestToBoth::class, 'aprrove'])->name('approvement');
    Route::get('Delete/{id}/{type}', [RegistrationRequestToBoth::class, 'Delete'])->name('Delete');
    Route::get('attachments/{type}/{clientId}', [RegistrationRequestToBoth::class, 'attachments'])->name('attachments');
    Route::get('download-client-file/{id}', [RegistrationRequestToBoth::class, 'download'])->name('downloadClientFile');
    Route::get('show-attachment-files/{id}', [RegistrationRequestToBoth::class, 'ShowFile'])->name('ShowFileInBlank');
});

/*--------------------------------------------------------------------------
| CLIENTS
|--------------------------------------------------------------------------*/
Route::group(['middleware' => ['auth', 'permission:clients-management'], 'prefix' => 'clients-management'], function () {

    Route::get('/clients', [App\Http\Controllers\ClientController::class, 'index'])->name('clients');
    Route::get('/payment', [App\Http\Controllers\ClientController::class, 'payment'])->name('clients.payment');
    Route::get('/client-account-transactions/{id}', [ClientIssuesController::class, 'showPreview'])->name('client.account.transactions.Preview');
    Route::get('/client-account-transactions', [App\Http\Controllers\ReportController::class, 'clientAccountTransactions'])->name('client.account.transactions');
    // Route::get('/client-payment' , ClientsPay::class)->name('client.payment.procces');
    Route::get('cleint-account-detaisl', ClientAccountDetials::class)->name('cleint_account_details');
    Route::get('getClient/{id}', fn ($id) =>  response()->json(
        [
            'client' =>  Client::find($id)
        ],
        200.
    ))->name('getClient');
});

/*--------------------------------------------------------------------------
| END CLIENTS
|--------------------------------------------------------------------------*/

/*--------------------------------------------------------------------------
| REPRESENTATIVES
|--------------------------------------------------------------------------*/

// Route::get('/representatives', [App\Http\Controllers\RepresentativeController::class, 'index'])->name('representatives')->middleware('auth');
Route::group(['middleware' => ['auth'], 'prefix' => 'representatives-management'], function () {
    Route::get('representatives', [App\Http\Controllers\RepresentativeController::class, 'index'])->name('representatives')->middleware('permission:representatives-management');
    Route::get('representatives/orders', [App\Http\Controllers\RepresentativeController::class, 'representativesOrders'])->name('representatives.orders')->middleware('permission:representatives-orders-management');
    Route::get('representatives/fees-collection', [App\Http\Controllers\RepresentativeController::class, 'representativesFeesCollection'])->name('representatives.fees.collection')->middleware('permission:representatives-fees-collection-management');
    Route::get('representatives/representatives-payment', [App\Http\Controllers\RepresentativeController::class, 'representativesPayment'])->name('representatives.payment')->middleware('permission:representatives-payment-management');

    Route::get('represntive-orders', ReprestiveOrderSearch::class)->name('represtative_order_search');
    Route::get('representvie-ajax-search', [Select2Controller::class, 'RepresetiveAjaxSearch'])->name('RepresetiveAjaxSearch');
});

Route::middleware('auth')->group(function () {
    Route::resource('notification', FireBaseNotificationHistoryController::class);
});



/*--------------------------------------------------------------------------
| END REPRESENTATIVES
|--------------------------------------------------------------------------*/

/*--------------------------------------------------------------------------
| ORDERS
|--------------------------------------------------------------------------*/
Route::prefix('orders')->middleware('auth')->group(function () {
    Route::get('new', [App\Http\Controllers\OrderController::class, 'index'])->name('orders')->middleware('permission:orders-management');
    Route::get('order-shiping-result', OrderShippingResult::class)->name('orders.shipping.result')->middleware('permission:orders-management');
    Route::get('add-order',  AddOrder::class)->name('add_order');
    Route::get('analytics', AnalyticsLivewire::class)->name('analytics');

   //  Route::post('add-order',  [AddOrder::class, 'SaveOrder'])->name('SaveOrder');
   Route::post('add-order',  [OrderController::class, 'SaveOrder'])->name('SaveOrder');
   // Route::get('search',  [App\Http\Controllers\costmerController::class, 'index'])->name('orders.search');
    Route::get('/order-details/{id}', [OrderController::class, 'show'])->name('orders.show.details');
    Route::get('/{id}/invoice', [App\Http\Controllers\OrderController::class, 'printInvoice'])->name('print.invoice')->middleware('permission:orders-management');
    Route::get('/importCSV', [App\Http\Controllers\OrderController::class, 'importCSV'])->name('orders.importCSV')->middleware('permission:orders-importCSV-management');
    Route::get('mulit-order-mangment', MultiOrderMangement::class)->name('multi.order.mangemnt');

    Route::get('/Client-order', ClientOrders::class)->name('orders.Client-order');
    Route::get('/orders-follow-up', OrdersFollowUp::class)->name('orders.OrdersFollowUp');


    Route::prefix('shiping')->group(function () {
        Route::get('shipinig-orders', [SyncShipingWithOrderController::class, 'index'])->name('ShipingOrders');
        Route::get('shiping-orders', [SyncShipingWithOrderController::class, 'syncOrder'])->name('preShiping');
        Route::post('sync-shiping-with-order', [SyncShipingWithOrderController::class, 'syncShipingWithOrder'])->name('syncShipingWithOrder');
        Route::get('print-invoice/{id}', [SyncShipingWithOrderController::class, 'printInvocie'])->name('print_shiping_invoice');
        Route::get('Prinr-orders-invoice', [SyncShipingWithOrderController::class, 'BulkPrint'])->name('print_shiping_invoices');
        Route::post('cancel-shiping',  [SyncShipingWithOrderController::class, 'cancel'])->name('cancel_shiping');
    });
});
Route::post('print-invoices', [App\Http\Controllers\OrderController::class, 'printInvoices'])->name('print.invoices');
Route::post('printPDF-invoices', [App\Http\Controllers\OrderController::class, 'printPDFInvoices'])->name('printPDF.invoices');
/*--------------------------------------------------------------------------
| END ORDERS
|--------------------------------------------------------------------------*/
/*--------------------------------------------------------------------------
| REPORTS
|--------------------------------------------------------------------------*/
Route::prefix('reports')->middleware(['auth', 'permission:reports-management'])->group(function () {
    Route::get('/client-account-statement', [App\Http\Controllers\ReportController::class, 'clientAccountStatement'])->name('client.account.statement');
    // Route::get('/client-account-transactions' ,[App\Http\Controllers\ReportController::class, 'clientAccountTransactions'])->name('client.account.transactions');
    Route::get('/representative-account-statement', [App\Http\Controllers\ReportController::class, 'representativeAccountStatement'])->name('representative.account.statement');
    Route::get('/orders-report', [App\Http\Controllers\ReportController::class, 'ordersReport'])->name('orders.reports');
    Route::get('/orders-per-month-report', [App\Http\Controllers\ReportController::class, 'ordersPerMonthReport'])->name('orders.per.month.reports');
    Route::get('/orders-in-out-area-report', [App\Http\Controllers\ReportController::class, 'ordersInOutAreaReport'])->name('orders.in.out.area.reports');
    Route::get('/representatives-orders-and-deserves-report', [App\Http\Controllers\ReportController::class, 'representativeOrdersAndDeservesReport'])->name('representatives.orders.and.deserves.reports');
    Route::get('/transactions', [App\Http\Controllers\ReportController::class, 'transactionsReport'])->name('transactions');
});

Route::get('privacy-policy', [PrivacyPolicy::class, 'index']);

/*--------------------------------------------------------------------------
| END REPORTS
|--------------------------------------------------------------------------*/
/*--------------------------------------------------------------------------
| User Profile
|--------------------------------------------------------------------------*/

Route::get('/user-profile', [UserController::class, 'userProfile'])->name('user.profile')->middleware('auth');

/*--------------------------------------------------------------------------
| END User Profile
|--------------------------------------------------------------------------*/
/*--------------------------------------------------------------------------
| User Profile
|--------------------------------------------------------------------------*/

Route::get('/order-tracking/{tracking_id?}', [OrderController::class, 'orderTracking'])->name('order.tracking');
// Route::view('/order-tracking', 'orders.tracking')->name('order.tracking');

/*--------------------------------------------------------------------------
| END User Profile
|--------------------------------------------------------------------------*/
Route::get('test/{file_path}', function () {

        if(request()->file_path){
            $filePath = decrypt(request()->file_path);
        }else{
            $filePath = public_path('/smsa_invoices/24_09_19_10_48_41_smsa.pdf'); // Adjust the path as needed
        }
        // Check if the file exists
        if (file_exists($filePath)) {
            // Clear the output buffer
            ob_clean();
            ob_end_flush();

            // Set headers to force download or open in browser
            header('Content-Type: application/pdf');
            header('Content-Disposition: inline; filename="' . basename($filePath) . '"'); // Inline for viewing in browser
            header('Content-Transfer-Encoding: binary');
            header('Accept-Ranges: bytes');
            header('Content-Length: ' . filesize($filePath));

            // Stream the PDF file content
            readfile($filePath);

            // End the script execution
            exit();
        } else {
            // Handle the case where the file doesn't exist
            abort(404, "PDF Not Found");
        }

})->name("test");
Route::get('client_notification/{id}', function ($id) {

    // DD hello
    // $data['tax_value'] = Setting::
    $data['tax_value'] = Setting::where('key', 'tax_precntage')->first()->value;
    $client = Client::with(['ServicePrice', 'Orders' => function ($q) {
        $q->where('is_collected', 0);
        $q->where('status', 'completed');
    }])->find($id);

    $data['clients'] = [$client];
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
        <h4> Returned Orders </h4>
        <h4> اعاده الشحنات بعد اعاده التسليم</h4> </div>',
        4 => '<div>
        <h4> International shipping Orders </h4>
        <h4> شحن دولي </h4> </div>',
    ];

    $data = array_merge($data, [
        'Services' => Service::all(),
        'ServiceHeading'  => $ServiceHeading
    ]);
    return view('client_export_notification', $data);

    dispatch(new ExportNotificationJob(Client::find(3)));
    // dd('Done');
    $data["email"] = "jksa.work.1@gmail.com";
    $data["title"] =  __('translation.export_notification');

    $files = [
        public_path('uploads/images/5YLI5qTSbDfxxMeADJpKESWgLB0rkQRuVb3ZnUGE.jpg'),
    ];

    Mail::to('jksa.work.1@gmail.com')->send(
        new ExportNotificationMail
    );


    Mail::send('emails.export_notification', $data, function ($message) use ($data, $files) {

        $message->to($data["email"], $data["email"])
            ->subject($data["title"]);

        foreach ($files as $file) {

            $message->attach($file);
        }
    });



    echo "Mail send successfully!!";
});


Route::get('client-issue/confirm', [ClientIssuesController::class, 'confirmIssue'])->name('client.issue.confirm');
Route::middleware('auth')->group(function () {

    Route::post('add-service-to-area', [ServiceToArea::class, 'index'])->name('area_servises');
    Route::post('update-area-service', [ServiceToArea::class, 'UpdateAreaServices'])->name('area_servises.updated');

    Route::get('client-issue/{id}', [ClientIssuesController::class, 'showIssue'])->name('client.issue');
//  Route::get('client-issue/{id}', [ClientIssuesController::class, 'showIssue'])->name('client.issue');
    Route::post('client-issue/{id}/cancel', [ClientIssuesController::class, 'cancelIssue'])->name('client.issue.cancel');
    Route::get('client-issue/{id}', [ClientIssuesController::class, 'showIssue'])->name('client.issue');

    Route::post('client-issue/{id}/verify-otp', [ClientIssuesController::class, 'verifyOtp'])->name('client.issue.verify-otp');

    Route::get('client-issue-status/{id}', [ClientIssuesController::class, 'StatusIssue'])->name('issue.status');
    Route::post('upload-file/{id}', [ClientIssuesController::class, 'UploadFiles'])->name('UploadFiles');
    Route::get('show-issue-image/{id}', [ClientIssuesController::class, 'ShowImage'])->name('showFile');
    Route::get('download-issue-image/{id}', [ClientIssuesController::class, 'downloadImage'])->name('downloadImage');
    Route::get('delete-issue-image/{id}', [ClientIssuesController::class, 'DeletImage'])->name('DeletImage2');

    Route::get('client-statment-issue', ClientStatementIsues::class)->name('ClientStatementIsues');
    Route::get('cleint-ajax-search', [ClientController::class, 'ClientAjaxSearch'])->name('ClientAjaxSearch');

});

Route::get('AreaStatic', [ClientController::class, 'AreaStatic']);

Route::get('client', fn () => view('client'));


Route::middleware(['auth'])->group(function () {
    Route::prefix('devices')->group(function () {
        Route::get('scan-device/{id}', [DeviceController::class,  'scanDevice'])->name('scanDevice');
        Route::get('add-device', [DeviceController::class,  'addDevice'])->name('addDevice');
        Route::post('store-device', [DeviceController::class, 'StoreDevice'])->name('storeDevices');
        Route::get('show-devices', [DeviceController::class, 'index'])->name('Devices');
        Route::delete('Devices/{id}', [DeviceController::class, 'destroy'])->name('Devices.delete');
    });
});


Route::get('/test-shipping-label', function () {
    // Provide a test AWB number for testing


    $awbNo = '1234567890';
    $url = 'https://ecomapis.smsaexpress.com/api/shipment/b2c/query/' . $awbNo;

    // Make the API call to SMSA Express
    $response = Http::withHeaders([
        'apikey' => "ArT@5162",
    ])->get($url);


    return  $response ;


    // Call the printAllLabel method
    //return SMSAShipingServiceAPI::printAllLabel($awbNo);
});
