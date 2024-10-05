<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Mail\Mailables\Attachment;

class ExportNotificationMail extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        // dd('Hello');
        return $this->view('emails.export_notification');
    }

    public function attachments(): array
    {
        return [
            Attachment::fromPath('uploads/images/5YLI5qTSbDfxxMeADJpKESWgLB0rkQRuVb3ZnUGE.jpg')
                ->as('name.pdf')
                ->withMime('application/pdf'),
        ];
    }
}
