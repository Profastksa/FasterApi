<?php

namespace App\Jobs;

use App\Services\Shiping\SMSAShipingService;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class CreateSMSAPDF implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public  $reference_id , $filePath;
    public function __construct($reference_id, $filePath)
    {
        $this->reference_id = $reference_id;
        $this->filePath = $filePath;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        // \Log::info('Creating SMSA PDF for reference: ' . $this->reference_id);
        \Log::info('Saving to path: ' . $this->filePath);
        SMSAShipingService::printInvoice($this->reference_id, $this->filePath);
    }
}
