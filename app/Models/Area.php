<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Representative;
use App\Models\RepresentativeArea;

class Area extends Model
{
    use HasFactory;

    protected $fillable = [
        "name",
        "fees",
        "country_code",
    ];

    // public function getFeesAttribute($value)
    // {
    //     return number_format($value) . " " . __('translation.real.sign');
    // }

    public function orders()
    {
        return $this->hasMany(Order::class, 'sender_area_id', 'id');
    }

    public function representatives()
    {
        return $this->belongsToMany(Representative::class, "representative_areas", "area_id", "representative_id");
    }

    public function subAreas()
    {
        return $this->hasMany(SubArea::class);
    }
    public function ServiceModel(){
        return $this->hasMany(IsServiceModel::class);
    }
}
