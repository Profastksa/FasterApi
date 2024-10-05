<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ReportController extends Controller
{
    public function clientAccountStatement()
    {
        return view("reports.client-account-statement");
    }
    public function representativeAccountStatement()
    {
        return view("reports.representative-account-statement");
    }
    public function ordersReport()
    {
        return view("reports.orders-reports");
    }

    public function clientAccountTransactions(){
        return view('reports.orders-account-transactions');
    }

    public function transactionsReport()
    {
        return view("transactions.index");
    }
    public function ordersPerMonthReport()
    {
        return view("reports.orders-per-month-reports");
    }
    public function ordersInOutAreaReport()
    {
        return view("reports.orders-in-out-area-reports");
    }
    public function representativeOrdersAndDeservesReport()
    {
        return view("reports.representatives-orders-and-deserves-reports");
    }
}
