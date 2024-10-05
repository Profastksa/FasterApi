<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class IssuePhotos extends Model
{
    use HasFactory;
    protected $guarded = [];
    public function Issue(){
        return $this->belongsTo(IssueClientStatement::class, 'issue');
    }

    public function getPhotoAttribute($key)
    {
        return asset('issue/' . $this->issue . '/' . $key);
    }

    public function Photoable()
    {
        return $this->morphTo();
    }
}
