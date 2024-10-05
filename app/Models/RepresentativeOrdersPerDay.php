<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RepresentativeOrdersPerDay extends Model
{
    use HasFactory;

    protected $fillable = [
        "date",
        "representative_id",
        "orders_count",
        "deserve",
        "is_paid",
        "payment_date",
        "transaction_id"
    ];
}
