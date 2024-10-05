<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class clientsFile extends Model
{
    use HasFactory;
    protected $guarded = [];

    public function Client(){
        return $this->belongsTo(Client::class);
    }
    public function fileable()
    {
        return $this->morphTo();
    }
}
