<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Mail;
use Barryvdh\DomPDF\Facade as PDF;

class IssueClientStatementCreated extends Mailable
{
    use Queueable, SerializesModels;

    public $pdfContent;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($pdfContent)
    {
        $this->pdfContent = $pdfContent;

    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->subject( 'Profast - فواتير')
        ->view('emails.billInvoice')
        ->attachData($this->pdfContent, 'Invoice.pdf', [
            'mime' => 'application/pdf',
        ]);
    }
}
