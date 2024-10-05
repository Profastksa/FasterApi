<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RepresentativeArea extends Model
{
    use HasFactory;

    protected $fillable = [
        'representative_id',
        'area_id',
        'subarea_id',
    ];

    public function area()
    {
        return $this->hasOne(Area::class, "id", "area_id");
    }

    public function subareas(){
        return $this->hasOne(SubArea::class, 'id' , 'subarea_id');
    }
}
