<?php

namespace App\Jobs;

use App\Helpers\WhatsMessage;
use App\Models\Client;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Mail;


class ExportNotificationJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public $client;
    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(Client $client)
    {
        $this->client = $client;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
       /* $resp = Http::withoutVerifying()
            ->get(
                'https://notify.gulfsmo.net/get-file/' . $this->client->id,
                [
                    'email' =>  $this->client->email,
                    'mobile' => str_replace('+', '', $this->client->phone),
                ]
            );*/
        // $file = $resp->json()['filename'];
        // dd();
        /*
        $json_repsonse = $resp->json();
        $errors = [];
        if ($json_repsonse != null) {
            if ($json_repsonse['filename'] !== true) {
                session()->flash('error_mail', __('translation.file_creation_image'));
            }
            if ($json_repsonse['mail'] !== true) {
                session()->flash('error', __('translation.mail_sending_error'));
            }
            if ($json_repsonse['whatsapp'] !== true) {
                session()->flash('error', __('translation.whatsapp_sending_error'));
            }
        } else {
            session()->flash('error', __('translation.problem_in_send_notification'));
        }*/
    }
}