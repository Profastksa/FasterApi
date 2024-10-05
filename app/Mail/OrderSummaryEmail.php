<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class OrderSummaryEmail extends Mailable
{

    use Queueable, SerializesModels;

    public $summary;

    public function __construct($summary)
    {
        $this->summary = $summary;
    }

    public function build()
    {
        return $this->view('emails.order-summary')
                    ->subject('Daily Order Summary');

    }
}
