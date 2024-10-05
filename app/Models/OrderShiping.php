<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Traits\ModelEventLogger;
use App\Events\OrderShipingCreated;



class OrderShiping extends Model
{
    use HasFactory;
    use ModelEventLogger;
    public $fillable = ['order_id', 'shipping_type',  'refrence_id'];
    const TYPES = ['smsa'];


    public static function boot(){
        parent::boot();
    }

    public function Order()
    {
        return $this->belongsTo(Order::class);
    }
}
