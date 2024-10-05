<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    use HasFactory;

    protected $table = "transactions";

    protected $fillable = [
        "trans_sn",
        "user_id",
        "client_id",
        "representative_id",
        "date",
        "amount",
        "transaction_type_id",
    ];

    public function client()
    {
        return $this->belongsTo(Client::class);
    }
    public function representative()
    {
        return $this->belongsTo(Representative::class);
    }
    public function transactionType()
    {
        return $this->belongsTo(TransactionsType::class);
    }
    public function orders()
    {
        return $this->hasMany(Order::class);
    }
}
