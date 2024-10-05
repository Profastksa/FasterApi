<?php

use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\GuestController;
use App\Http\Controllers\Api\WhatServicesControll;
use App\Http\Controllers\AuthWithToken;
use App\Http\Controllers\ClientController;
use App\Http\Controllers\ClientsTokensController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\PaymentImageController;
use App\Http\Controllers\RepresentativeController;
use App\Models\Representative;
use Illuminate\Http\Request;
// use Illuminate\Support\Facades\Request as FacadesRequest;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

// Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//     return $request->user();
// });
// gloab route with out auth
Route::prefix('global')->group(function () {
    Route::get('getAllAreas', [App\Http\Controllers\ClientController::class, 'getAllAreas']);
    Route::get('getAllAreas2', [App\Http\Controllers\ClientController::class, 'getAllAreas2']);
    Route::post('getSubAreaByAreaId', [App\Http\Controllers\ClientController::class, 'getSubAreaByAreaId']);
    Route::get('getOrderById/{id}', [OrderController::class, 'getOrderBytrackingId']);
});

// Client Apis
Route::group(['prefix' => 'client'], function () {
    //Area Static
    //register route
    Route::post('clientRegister', [App\Http\Controllers\Api\AuthController::class, 'clientRegister']);
    //login route
    Route::post('clientLogin', [App\Http\Controllers\Api\AuthController::class, 'clientLogin']);
    //get all Areas
    Route::post('GeustLogin', [GuestController::class, 'GeustLogin']);
    //get all Sub Areas
    Route::post('GuestRegisterAccount', [GuestController::class, 'GuestRegisterAccount'])->middleware('auth:sanctum');

    Route::get('getAllServices', [App\Http\Controllers\ClientController::class, 'getAllServices']);
    Route::post('getSubAreaByAreaId', [App\Http\Controllers\ClientController::class, 'getSubAreaByAreaId']);

    Route::get('BillTest', [App\Http\Controllers\OrderController::class, 'BillTest']);
    //get Order Policy Pdf
    Route::get('getOrderPolicyPdf', [App\Http\Controllers\OrderController::class, 'getOrderPolicyPdf']);

    //get all services
    //protected routes
    Route::group(["middleware" => "auth:sanctum"], function () {

        //logout route
        Route::get('AreaStatic', [ClientController::class, 'AreaStatic']);
        Route::get('OrderAnalytics', [ClientController::class, 'getOrderAnalytics']);
        Route::put('update-token', 'App\Http\Controllers\ClientController@updateToken');


        Route::get('getAllAreas', [App\Http\Controllers\ClientController::class, 'getAllAreas']);

        Route::post('clientLogout', [App\Http\Controllers\Api\AuthController::class, 'clientLogout']);
        //Update Client Account
        Route::post('updateClientAccount', [App\Http\Controllers\ClientController::class, 'updateClientAccount']);
        //get client
        Route::post('getClient', [App\Http\Controllers\ClientController::class, 'getClient']);
        //Add Order
        Route::post('addOrder', [App\Http\Controllers\ClientController::class, 'addOrder']);
        //Edit Order
        Route::post('EditOrder', [App\Http\Controllers\ClientController::class, 'EditOrder']);
        //get Order ---------------------------
        Route::post('getOrder', [App\Http\Controllers\ClientController::class, 'getOrder']);
        //get Client Orders
        Route::post('getClientOrders', [App\Http\Controllers\ClientController::class, 'getClientOrders']);
        //Cancel Order
        Route::post('cancelOrder', [App\Http\Controllers\ClientController::class, 'cancelOrder']);
        //get all Sub Areas ----------------------------------------------------------------
        Route::get('getallSubArea', [App\Http\Controllers\ClientController::class, 'getallSubArea']);
    });
    // last modification add is sending is resiving route  --------------------------
    // note appent route to auth group  ----------------------------
    Route::post('getAllAreasByServiceId', [App\Http\Controllers\ClientController::class, 'getAllAreasByServiceId']);
});


// representative Apis
Route::group(['prefix' => 'representative'], function () {
    //public routes
    //Login representative
    Route::post('representativeLogin', [App\Http\Controllers\Api\AuthController::class, 'representativeLogin']);
    Route::post('representativeRegister', [AuthController::class, 'representativeRegister']);
   //get Order Policy Pdf
      Route::get('getOrderPolicyPdf', [App\Http\Controllers\OrderController::class, 'getOrderPolicyPdf']);

    //protected routes
    Route::group(["middleware" => "auth:sanctum"], function () {

        Route::post('getRepresentativeSummaryAreasOrdersbyStatus', [App\Http\Controllers\RepresentativeController::class, 'getRepresentativeSummaryAreasOrdersbyStatus']);
        //get order
        Route::post('getClientOrdersByIdAndSubAreaAndStatus', [App\Http\Controllers\RepresentativeController::class, 'getClientOrdersByIdAndSubAreaAndStatus']);

        //logout route
        Route::post('representativeLogout', [App\Http\Controllers\Api\AuthController::class, 'representativeLogout']);
        //get all Areas
        Route::get('getAllAreas', [App\Http\Controllers\RepresentativeController::class, 'getAllAreas']);
        //get all Sub Areas
        Route::post('getSubAreaByAreaId', [App\Http\Controllers\RepresentativeController::class, 'getSubAreaByAreaId']);
        //Accept order
        Route::post('acceptOrder', [App\Http\Controllers\RepresentativeController::class, 'acceptOrder']);
        //Deliver order
        Route::post('deliverOrder', [App\Http\Controllers\RepresentativeController::class, 'deliverOrder']);
        Route::post('deliverOrderWithoutImage', [App\Http\Controllers\RepresentativeController::class, 'deliverOrderWithoutImage']);
        Route::post('addOrderTrackingMassage', [App\Http\Controllers\RepresentativeController::class, 'addOrderTrackingMassage']);
        //transfer order
        Route::post('transferOrder', [App\Http\Controllers\RepresentativeController::class, 'transferOrder']);
        // transferMultiOrders Transfeerr Multi Orders       --------------------
        Route::post('transferMultiOrders', [RepresentativeController::class, 'transferMultiOrders']);
        //get representative

        Route::post('getRepresentative', [App\Http\Controllers\RepresentativeController::class, 'getRepresentative']);
        //update representative areas
        Route::post('updateRepresentativeAreas', [App\Http\Controllers\RepresentativeController::class, 'updateRepresentativeAreas']);
        //get order
        Route::post('getOrder', [App\Http\Controllers\RepresentativeController::class, 'getOrder']);
        //get balance
        Route::post('getBalance', [App\Http\Controllers\RepresentativeController::class, 'getBalance']);
        //get all representatives
        Route::get('getAllRepresentatives', [App\Http\Controllers\RepresentativeController::class, 'getAllRepresentatives']);
        //get representative areas orders
        Route::post('getRepresentativeAreasOrders', [App\Http\Controllers\RepresentativeController::class, 'getRepresentativeAreasOrders']);
        //get area orders
        Route::post('getRepresentativeAreaOrders', [App\Http\Controllers\RepresentativeController::class, 'getRepresentativeAreaOrders']);
        //get representative orders by order status
        Route::post('getRepresentativeOrdersByOrderStatus', [App\Http\Controllers\RepresentativeController::class, 'getRepresentativeOrdersByOrderStatus']);
        //get representative new orders
        Route::get('getRepresentativeAreasPendingOrders', [App\Http\Controllers\RepresentativeController::class, 'getRepresentativeAreasPendingOrders']);

        //get representative Sub Areas
        Route::get('getRepresentativeSubAreas', [App\Http\Controllers\RepresentativeController::class, 'getRepresentativeSubAreas']);
        //get getMyOrders ---------------------
        Route::post('getMyOrders', [App\Http\Controllers\RepresentativeController::class, 'getMyOrders']);
        //get getCompanyWhatsAppNo
        Route::get('getCompanyWhatsAppNo', [App\Http\Controllers\RepresentativeController::class, 'getCompanyWhatsAppNo']);
        //get all services
        Route::get('getAllServices', [App\Http\Controllers\RepresentativeController::class, 'getAllServices']);
        //returnOrder
        Route::post('returnOrder', [App\Http\Controllers\RepresentativeController::class, 'returnOrder']);
        //inProgressOrder
        Route::post('inProgressOrder', [App\Http\Controllers\RepresentativeController::class, 'inProgressOrder']);
        //getRepresentativeCompanyDeserves
        Route::get('getRepresentativeCompanyDeserves', [App\Http\Controllers\RepresentativeController::class, 'getRepresentativeCompanyDeserves']);
        // transform Orders From Rep To Other Rep
        Route::post('ScanBarCode', [RepresentativeController::class, 'ScanBarCode']);
        Route::get('AreaStatic', [RepresentativeController::class, 'AreaStatic']);

        Route::post('serachInCleint', [ClientController::class, 'serachInCleint']);
        Route::get('getOrdrsBelongToClient/{id}', [ClientController::class, 'OrdrsBelongToClient']);

        Route::post('AttachPaymentImageToOrder', [PaymentImageController::class, 'AttachImageToOrder']);
    });
});


Route::get('whatsService/getNewMessages', [WhatServicesControll::class, 'getNewMessages']);
Route::post('whatsService/SetMessageSent', [WhatServicesControll::class, 'SetMessageSent']);


Route::post('generateApiToken', [ClientsTokensController::class, 'create'])->middleware('auth:sanctum');
Route::post('getUserWithToken', [ClientsTokensController::class, 'show'])->middleware('CheckApiKeyFromOuterResource');



Route::post('addOrdersWithApiKey', [ClientController::class, 'addOrderWithApiKey']);
Route::post('addOrdersWithApiKeyForWP', [ClientController::class, 'addOrderWithApiKeyForWP']);
Route::post('addOrdersWithApiKeyForFasterSuadi', [ClientController::class, 'addOrdersWithApiKeyForFasterSuadi']);

Route::post('addOrderWithApiKeyForsallaChromePlugin', [ClientController::class, 'addOrderWithApiKeyForsallaChromePlugin']);
Route::post('addOrdersWithApiKeySallaChromePluginAdmin', [ClientController::class, 'addOrdersWithApiKeySallaChromePluginAdmin']);
// Version 2
Route::prefix('v2')->group(function () {
    Route::post('addOrderWithApiKeyForsallaChromePlugin', [ClientController::class, 'addOrderWithApiKeyForsallaChromePluginV2']);
});

// Route::post('client-login' , [AuthWithToken::class, 'ClientLogin']);
Route::get('TestLogin/{type?}', [AuthController::class, 'TestLogin']);
