<?php

namespace App\Console\Commands;

use App\Models\User;
use Carbon\Carbon;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class ExpiredTokenJob extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'command:ExpiredTokenJob';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Delete All Expird Token From Database';

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
        #  DB::tabel('personal_access_tokens')


        $PersonalAccessToken  =   DB::table('personal_access_tokens')->where( 'created_at', '<', Carbon::now()->subDays(90))
        ->delete();
        if($PersonalAccessToken){
            info(now() . ' Old Token Is Delted');
        }else{
            info(now() . ' No Thing To Delete It');
        }

    }
}
