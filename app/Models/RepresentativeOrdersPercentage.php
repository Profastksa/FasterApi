<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RepresentativeOrdersPercentage extends Model
{
    use HasFactory;

    protected $fillable = [
        "representative_id",
        "order_id",
        "deserve",
        "is_paid",
        "payment_date",
        "transaction_id"
    ];
}
