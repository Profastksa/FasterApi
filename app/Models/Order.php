<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Client;
use App\Traits\ModelEventLogger;

class Order extends Model
{
    use ModelEventLogger;
    use HasFactory;
    const STATUS = ['pending', 'pickup', 'inProgress', 'delivered', 'completed', 'returned', 'canceled'];

    // const COD_METHOD = ["on_receiving", 'balance', 'on_sending'];
    const COD_METHOD = ['cash', 'network', 'cash & network'];

    const ORDER_SOURCING = ["SALLA" , "WP", "PRIVATE_KEY", "NORMAL", "CLIENT"];

    public static function boot()
    {
        parent::boot();

        self::created(function ($order) {
            // Update the client's 'in_accounts_order' field when a new order is created
            Client::find($order->client_id)->update(['in_accounts_order' => 1]);

            // Set 'is_company_fees_collected' to 1 if the service_id is not 1
            if ($order->service_id != 1) {
                $order->is_company_fees_collected = 1;
                $order->save(); // Save changes to the order
            }
        });

        self::updated(function ($order) {
            // Log information about the update
          //  info("Order was updated");


            // Check if the status was changed to 'completed'
            if ($order->wasChanged('status')
            && $order->status === 'completed'
            && $order->getOriginal('status') !== 'completed'
            && in_array($order->service_id, [2, 3, 4, 5])
            && is_null($order->completed_at)) {

            // Update completed_at only if it hasn't been set yet
            $order->update(['completed_at' => now()]);

            // Optional: Trigger event if shipping details are needed
            // if ($order->relationLoaded('Shipping')) {
            //     $shipping_details = $order->Shipping;
            //     if ($shipping_details) {
            //         event(new OrderShippingCreated($shipping_details));
            //     }
            // }
        }



        });


    }


    protected $fillable = ['service_id', 'tracking_number', 'orderRef', 'client_id', 'sender_name', 'sender_area_id', 'sender_sub_area_id', 'sender_address', 'sender_phone', 'representative_id', 'receiver_name', 'receiver_area_id', 'receiver_sub_area_id', 'receiver_address', 'receiver_phone_no', 'police_file', 'receipt_file', 'note', 'delivery_fees', 'order_fees', 'total_fees', 'payment_method', 'is_company_fees_collected', 'is_client_payment_made', 'order_date', 'delivery_date', 'status', 'transaction_id', 'client_payment_transaction_id', 'is_police_file_sent', 'invoice_sn', 'number_of_pieces', 'is_deleted', 'order_weight', 'order_value', 'is_collected', 'transfer_number', 'file', 'order_value', 'cash_amount', 'COD_payment_method', 'E_transfer_amount', 'E_transfer_number', "order_source", "completed_at"];

    public function service()
    {
        return $this->belongsTo(Service::class, 'service_id', 'id');
    }
    public function client()
    {
        return $this->belongsTo(Client::class, 'client_id', 'id');
    }
    public function representative()
    {
        return $this->belongsTo(Representative::class, 'representative_id', 'id');
    }
    public function receiverArea()
    {
        return $this->belongsTo(Area::class, 'receiver_area_id', 'id');
    }
    public function receiverSubArea()
    {
        return $this->belongsTo(SubArea::class, 'receiver_sub_area_id', 'id');
    }
    public function senderArea()
    {
        return $this->belongsTo(Area::class, 'sender_area_id', 'id');
    }
    public function senderSubArea()
    {
        return $this->belongsTo(SubArea::class, 'sender_sub_area_id', 'id');
    }

    public function scopeIsDeleted($query)
    {
        return $query->where('is_deleted', 0);
    }

    public function scopeShowDeleted($query)
    {
        return $query->where('is_deleted', 1);
    }

    public function OrderTracking()
    {
        return $this->hasMany(OrderTracking::class, 'order_id', 'tracking_number');
    }

    public function scopeToDate($q, $to_date)
    {
        return $q->when($to_date, function ($query, $to_date) {
            return $query->where('order_date', '<=', $to_date . ' 23:59:59');
        });
    }

    public function scopeFromDate($q, $from_date)
    {
        return $q->when($from_date, function ($query, $from_date) {
            return $query->where('order_date', '>=', $from_date . ' 00:00:00');
        });
    }

    public function serviceid($q, $serviceid)
    {
        return $q->when($serviceid, function ($query, $serviceid) {
            return $query->where('service_id', $serviceid);
        });
    }

    public function scopeStatusFilter($q, $status)
    {
        return $q->when($status, function ($query, $status) {
            if ($status == -1) {
                return $query->where('is_deleted', 1);
            } else {
                return $query->where('status', $status);
            }
        });
    }

    public function scopeStatusFilter1($q, $status_filter1)
    {
        return $q->when($status_filter1, function ($query, $status_filter1) {
            // dd($status);
            return $query->where('service_id', $status_filter1);
        });
    }

    public function scopecleintfilter($q, $cleint_filter)
    {
        return $q->when($cleint_filter, function ($query, $cleint_filter) {
            // dd($status);
            return $query->where('client_id', $cleint_filter);
        });
    }

    public function Shipping()
    {
        return $this->hasOne(OrderShiping::class, 'order_id');
    }

    public function scopeCoustmerServiceFilter($query, $coustmer_service_Filter)
    {
        return $query->when($coustmer_service_Filter, function ($query, $coustmer_service_Filter) {
            // Remove known prefixes from the input
            $normalizedFilter = preg_replace('/^\+966|^00966|^0/', '', $coustmer_service_Filter);

            // Check if the normalized filter is empty
            if (empty($normalizedFilter)) {
                // Return the query without any conditions, effectively returning no results
                return $query->whereRaw('1 = 0');
            }

            // Use 'like' with the normalized input
            return $query
                ->orWhere('receiver_phone_no', 'like', '%' . $normalizedFilter . '%')
                ->orWhere('sender_phone', 'like', '%' . $normalizedFilter . '%')
                ->orWhereHas('Client', function (\Illuminate\Database\Eloquent\Builder $query2) use ($normalizedFilter) {
                    $query2->where('phone', 'like', '%' . $normalizedFilter . '%');
                });
        });
    }

    public function getStatusAttribute($value)
    {
        if (in_array($this->service_id, [2, 3]) && $value === 'completed') {
            return $this->is_deleted ? 'deleted - ' . 'isShipped' : 'isShipped';
        }
        return $this->is_deleted ? 'deleted - ' . $value : $value;
    }

    public function getOrderSourceStatus(): string{
        switch ($this->order_source) {
            case "SALLA":
                return '<span class="badge badge-success">' . __("translation.salla") .'</span>';
            case "WP":
                return '<span class="badge badge-info">' . __("translation.wordpress") .'</span>';
            case "PRIVATE_KEY":
                return '<span class="badge badge-warning">' . __("translation.private_key") .'</span>';
            case "NORMAL":
                return '<span class="badge badge-info"> ' .  __("translation.normal_order") .'</span>';
            case "CLIENT":
                return '<span class="badge badge-danger"> ' .  __("translation.client_application") .'</span>';
            default:
                return '<span class="badge badge-info">' . __("translation.normal_order") .'</span>';
        }
    }
}
