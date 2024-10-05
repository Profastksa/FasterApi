<?php

namespace App\Jobs;

use App\Traits\CreateUserWithFireBase;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class RegisterClientOnFireBase implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels , CreateUserWithFireBase;

    /**
     * Create A New Job Instance.
     *
     * @return void
     */
    public $email , $password;
    public function __construct($email , $password)
    {
        $this->email = $email;
        $this->password = $password;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        return $this->AddUserToFirebase($this->email, $this->password);
    }
}
