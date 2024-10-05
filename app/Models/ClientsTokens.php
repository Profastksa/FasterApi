<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ClientsTokens extends Model
{
    use HasFactory;
    protected $guarded = [];

    // public

    public static function generateUniqueApiKey()
    {
        $rand = rand(99999, 10000000);
        $randIsExist = Order::where('tracking_number', '=', $rand)->count();

        if (!$randIsExist) {
            #code.. .
            return $rand;
        } else {
            static::generateUniqueApiKey();
        }
    }


    // relation to get client  with Token api
    public function Client(){
        return $this->belongsTo(Client::class);
    }
}
