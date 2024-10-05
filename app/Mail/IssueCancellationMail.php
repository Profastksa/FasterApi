<?php
namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class IssueCancellationMail extends Mailable
{
    use Queueable, SerializesModels;

    public $link;
    public $otp;
    public $ClientStatementIsues;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($link, $otp, $ClientStatementIsues)
    {
        $this->link = $link;
        $this->otp = $otp;
        $this->ClientStatementIsues = $ClientStatementIsues;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->view('emails.client-issue-cancellation')
                    ->with([
                        'link' => $this->link,
                        'otp' => $this->otp,
                        'ClientStatementIsues' => $this->ClientStatementIsues,
                    ])
                    ->subject('تأكيد إلغاء كشف حساب تم تصديره');
    }
}

