<?php

namespace App\Http\Controllers;

use App\Models\Client;
use App\Models\Order;
use App\Models\Representative;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $clients_total = Client::count();
        $representatives_total = Representative::count();
        $pending_orders = Order::where('status', 'pending')->count();
        $todays_orders = Order::where('order_date', 'like', date('Y-m-d') . "%")->count();
        // dd($todays_orders);
        $chartOne = DB::select('SELECT DAYNAME(order_date) as label , Count(id) as Data FROM orders where order_date > CURRENT_DATE() -7 GROUP BY date(order_date)');
        $charttwo = DB::select('SELECT Count(id) as `Data` ,status as label FROM `orders` GROUP by status');
        return view('home', compact(['clients_total', 'representatives_total', 'pending_orders', 'todays_orders' , 'chartOne' ,'charttwo']));
    }

    public function getActiveDriverCount(){

    }
}
