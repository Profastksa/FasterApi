<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Order;
use App\Mail\OrderSummaryEmail;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\DB; // Import DB facade

use Carbon\Carbon;



class DailyOrderSummary extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'orders:summary';
    protected $description = 'Send daily summary report of orders';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $today = Carbon::today()->subDay();
        //$today = $today;
  //      __('translation.'.$order->status)
        // Fetch orders grouped by status
        $ordersByStatus = Order::whereDate('created_at', $today)
            ->select('status', DB::raw('count(*) as total'))
            ->groupBy('status')
            ->get();

        // إنشاء تقرير الملخص
        $summary = "<h2>ملخص طلبات اليومي ليوم " . $today->toDateString() . "</h2>";
        $summary .= "<table border='1'>";
        $summary .= "<tr><th>الحالة</th><th>عدد الطلبات</th></tr>";

        foreach ($ordersByStatus as $group) {
            $status = __('translation.' . $group->status); // Translate status
            $summary .= "<tr><td>{$status}</td><td>{$group->total}</td></tr>";
        }

        $summary .= "</table>";


        // إرسال البريد الإلكتروني
        $email = new OrderSummaryEmail($summary);
        Mail::to(['faster.saudi@gmail.com', 'ahmedict6@gmail.com'])->send($email);

        $this->info('تم إرسال بريد إلكتروني بملخص الطلبات اليومي بنجاح.');

    }
}
