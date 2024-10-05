<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LogActivity extends Model
{
    use HasFactory;
    protected $table = "log_activity";

    protected $fillable = ['action','content_type','content_id','description','details','user_id'];

    public function user()
    {
        return $this->belongsTo('App\User','user_id');
    }
}
