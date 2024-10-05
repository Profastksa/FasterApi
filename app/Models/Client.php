<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\SubArea;
use App\Scope\ApprovedScope;
use Laravel\Sanctum\HasApiTokens;
use PhpParser\Node\Stmt\Static_;
use App\Traits\ModelEventLogger;
use App\Events\NewUserCreated;


class Client extends Model
{
    use HasFactory, HasApiTokens;
    use ModelEventLogger;
    protected $fillable = [
        'fullname',
        'email',
        'password',
        'sub_area_id',
        'phone',
        'address',
        'is_active',
        'is_approved',
        'discount_rate',
        'account_balance',
        'is_has_custom_price',
        'message_token',
        'area_id',
        'in_accounts_order',
        'client_type',
        'bank' ,
        'activity' ,
        'name_in_invoice' ,
        'bank_account_owner' ,
        'bank_account_number' ,
        'iban_number' ,
        'civil_registry',
        'is_guest',
    ];

    protected static function boot(){
        parent::boot();
        Static::addGlobalScope(new ApprovedScope);

        static::created(function ($client) {
            event(new NewUserCreated($client));
        });
    }
    // protected $append = ['orignalPhone'];
    protected $hidden = [
        'password',
        'remember_token',
    ];
     protected $appends = ['area_id' , 'orignal_phone'];

    public function subArea()
    {
        return $this->belongsTo(SubArea::class, 'sub_area_id');
    }
    public function Area()
    {
        return $this->belongsTo(Area::class, 'area_id');
    }

    public function getAreaIdAttribute($key)
    {
       return  $this->subArea->area_id;
    }

    public function ServicePrice(){
        return $this->hasMany(ClientServicePrice::class);
    }

    // public function Area(){
    //     return $this->hasOne(Area::class);
    // }

    public function ClientKeys(){
        return $this->hasOne(ClientsTokens::class);
    }
    public function getOrignalPhoneAttribute(){
        return $this->phone;// return substr($this->phone, 4);
    }

    public function Orders(){
        return $this->hasMany(Order::class)->where('is_collected' , 0)->isdeleted();
    }

    public function Files()
    {
        return $this->morphMany(clientsFile::class, 'fileable');
    }
 // Method to fetch pending orders
 public function pendingOrders()
 {
     return $this->orders()->where('status', 'pending')->IsDeleted()->get();
 }

 // Method to fetch picked up orders
 public function pickedUpOrders()
 {
     return $this->orders()->where('status', 'pickup')->IsDeleted()->get();
 }

 // Method to fetch in-progress orders
 public function inProgressOrders()
 {
     return $this->orders()->where('status', 'inprogress')->IsDeleted()->get();
 }
    // function s
    public function removeGuestFlag(){
        $this->is_guest = !$this->is_guest;
        $this->save();
    }
}
