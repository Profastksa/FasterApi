<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Traits\ModelEventLogger;
use App\Events\IssueClientStatementCreated;
use Illuminate\Support\Facades\DB;

class IssueClientStatement extends Model
{
    use HasFactory;
    use ModelEventLogger;
    protected $guarded = [];

    public static function boot(){
        parent::boot();
        self::Created(function($model){
            $model->issue_date = date('y-m-d');
            $model->save();

            event(new IssueClientStatementCreated($model));
        });

        static::deleting(function ($issueClientStatement) {
            // Apply your custom logic here
            // Update the orders set 'is_collected' to 0
            $orderIds = $issueClientStatement->orders_ids;
            DB::table('orders')
                ->whereIn('id', $orderIds)
                ->update(['is_collected' => 0]);

            // Update the client set 'in_accounts_order' to 0
            $client = $issueClientStatement->Client;
            if ($client) {
                $client->in_accounts_order = 1;
                $client->save();
            }

        });
    }

    public function Client(){
        return $this->belongsTo(Client::class);
    }

    public function getOrdersIdsAttribute($key)
    {
        return json_decode($key);
    }

    public function Photos(){
        return $this->hasMany(IssuePhotos::class , 'issue');
    }
}
