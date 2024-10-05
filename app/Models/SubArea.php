<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Client;

class SubArea extends Model
{
    use HasFactory;

    protected $fillable = ['area_id', 'name'];

    public function clients()
    {
        return $this->hasMany(Client::class, 'sub_area_id');
    }
    public function area()
    {
        return $this->belongsTo(Area::class);
    }
}
