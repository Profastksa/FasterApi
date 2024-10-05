<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class TransactionsTypesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table("transactions_types")->insert([
            [
                "type" => "fees_collection",
                "is_fees_collection" => "1",
                "is_representative_payment" => "0",
                "is_client_payment" => "0",
            ],
            [
                "type" => "representative_payment",
                "is_fees_collection" => "0",
                "is_representative_payment" => "1",
                "is_client_payment" => "0",
            ],
            [
                "type" => "client_payment",
                "is_fees_collection" => "0",
                "is_representative_payment" => "0",
                "is_client_payment" => "1",
            ],
        ]);
    }
}
