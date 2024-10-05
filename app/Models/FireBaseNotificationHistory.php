<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FireBaseNotificationHistory extends Model
{
    public static function boot(){
        parent::boot();
        static::creating(function($model)
        {
            $model->notification_date = date('y-m-d H:m:s');
        });
    }

    use HasFactory;
    protected $guarded = [];
    // accessor ansd mutauto  ----------------------
    public function getNotificationDateAttribute($key)
    {
        return Carbon::parse($this->created_at)->diffForHumans();
    }

    public function getImageAttribute($key)
    {
        return $key ? asset('uploads/notification/'.$key) : asset('uploads/notification/defualt.png');
    }

    public function Area(){
        return $this->belongsTo(Area::class);
    }

    public function User(){
        return $this->type == 'client' ? $this->belongsTo(Client::class , 'user_id') : $this->belongsTo(Representative::class , 'user_id') ;
    }
}
