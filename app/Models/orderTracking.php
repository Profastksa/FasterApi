<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class orderTracking extends Model
{
    use HasFactory;
    protected $fillable = [
        'order_id',
        'date',
        'status',
        'by',
        'note',
        'note_ar',
        'user_id'
    ];

    protected $appends =  ['receiver_phone_no' , 'sender_phone'];



    public function getSenderPhoneAttribute($key)
    {
        return $this->Order->sender_phone;
    }


    public function getReceiverPhoneNoAttribute($key)
    {
        return $this->Order->receiver_phone_no;
    }


    public static function insertOrderTracking($order_id, $status, $note, $by, $user_id, $note_ar = null)
    {
        $order = self::create([
            'date' => date('Y-m-d h:m:s'),
            'status' => $status,
            'order_id' => $order_id,
            'note' => $note,
            'note_ar'=> $note_ar,
            'by' => $by,
            'user_id' => $user_id,
        ]);
        // dd($order);
    }
    public static function generateUniqueTrackingNumber()
    {
        $rand = rand(99999, 10000000);
        $randIsExist = Order::where('tracking_number', '=', $rand)->count();

        if (!$randIsExist) {
            # code...
            return $rand;
        } else {
            static::generateUniqueTrackingNumber();
        }
    }


    public function Order(){
        return $this->belongsTo(Order::class);
    }
}
