<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SerialSetting extends Model
{
    use HasFactory;

    protected $fillable = [
        "inv_no",
        "trans_no",
    ];
}
