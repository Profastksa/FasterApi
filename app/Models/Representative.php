<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\RepresentativeArea;
use App\Models\Area;
use App\Scope\ApprovedScope;
use Laravel\Sanctum\HasApiTokens;
use App\Traits\ModelEventLogger;
use App\Events\NewUserCreated;


class Representative extends Model
{
    use HasFactory, HasApiTokens;
    use ModelEventLogger;

    protected $fillable = [
        'fullname',
        'email',
        'password',
        'phone',
        'address',
        'is_active',
        'account_balance',
        'is_approved',
        'message_token',
        'sub_area_id',
        'area_id',
    ];

    //  add clobal scope to the model
    protected static function boot(){
        parent::boot();
        Static::addGlobalScope(new ApprovedScope);
        static::created(function ($representative) {
            event(new NewUserCreated($representative));
        });
    }

    protected $hidden = [
        'password',
        'remember_token',
    ];
    protected $append = ['orignal_phone' , 'CurrentHoldingAmount'];
    public function areas()
    {
        return $this->belongsToMany(Area::class, "representative_areas", "representative_id", "area_id");
    }
    // Sub Area Realation ----------------------------------
    public function subareas()
    {
        return $this->belongsToMany(SubArea::class, "representative_areas", "representative_id", "subarea_id");
    }
    // new Function Return Representive Area   -------------------
    public function Area(){
        return $this->belongsTo(Area::class);
    }

    public function orders()
    {
        return $this->hasMany(Order::class);
    }

    // public function setPhoneAttribute($key, $value)
    // {
    //     return '+249' + $this->phone;
    // }
    public function getOrignalPhoneAttribute(){
        return substr($this->phone, 5);
    }

    public function getCurrentHoldingAmountAttribute(){
        return  Order::where('representative_id', $this->id)->where('service_id', 1)->where('is_collected',0)->where('status','delivered')->where('is_deleted', 0)->sum('order_value') ?? 0;
    //->where('is_company_fees_collected',0)s
    }




    public function Files()
    {
        return $this->morphMany(clientsFile::class, 'fileable');
    }
}
