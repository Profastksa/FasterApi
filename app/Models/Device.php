<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Http;

class Device extends Model
{
    use HasFactory;
    protected $guarded = [];


    public function isActive()
    {
        $response = Http::withoutVerifying()->post(env('URL_WA_SERVER', '127.0.0.1') . '/sessions/status/' . $this->phone);
        // return ;
        if (json_decode($response->body())->success) $this->status = 'disconnected';
        else $this->status = 'connected';
    }
}
