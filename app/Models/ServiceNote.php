<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ServiceNote extends Model
{
    use HasFactory;

    protected $fillable = [
        'body',
        'service_id',
    ];

    public function service()
    {
        return $this->belongsTo(Service::class);
    }
}
