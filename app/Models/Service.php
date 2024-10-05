<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Traits\ModelEventLogger;

class Service extends Model
{
    use HasFactory;
    use ModelEventLogger;

    protected $fillable = [
        'name',
        'price',
        'descr',
        'is_active',
        'cod',
        'photo',
    ];

    public function notes()
    {
        return $this->hasMany(ServiceNote::class);
    }

    public function clientPrices()
    {
        return $this->hasMany(ClientServicePrice::class, 'service_id');
    }

    // Custom method to get cod based on a specific client ID and service ID
    public function getCodSericePriceByClientId($clientId)
    {
        // Find the client
        $client = Client::find($clientId);

        // Check if the client exists and has a custom price flag
        if ($client && $client->is_has_custom_price) {
            // Find the client-specific price for this service
            $clientServicePrice = $this->clientPrices()
                                       ->where('client_id', $clientId)
                                       ->where('service_id', $this->id)
                                       ->where('type', 'pickup')
                                       ->first();

            // If client-specific price exists, return it
            if ($clientServicePrice) {
                return $clientServicePrice->price;
            }
        }

        // If no custom price exists or the client doesn't have a custom price, return the original service cod
        return $this->attributes['cod'];
    }

    public function getServicePriceByClientId($clientId)
    {
        // Find the client
        $client = Client::find($clientId);

        // Check if the client exists and has a custom price flag
        if ($client && $client->is_has_custom_price) {
            // Find the client-specific price for this service
            $clientServicePrice = $this->clientPrices()
                                       ->where('client_id', $clientId)
                                       ->where('service_id', $this->id)
                                       ->first();

            // If client-specific price exists, return it
            if ($clientServicePrice) {
                return $clientServicePrice->price;
            }
        }

        // If no custom price exists or the client doesn't have a custom price, return the original service cod
        return $this->attributes['price'];
    }

    protected $casts = [
        'is_active' => 'boolean',
        'is_fill_sender' => 'boolean',
    ];
}
