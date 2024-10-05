<?php

namespace App\Traits;

use App\Models\Order;

trait OrderCheckTrait
{
    /**
     * Check if the order reference ID already exists for the same user.
     *
     * @param int $clientId
     * @param string $refOrderId
     * @return array|null
     */
    public function checkExistingOrder($clientId, $refOrderId)
    {
        $existingOrder = Order::where('client_id', $clientId)
            ->where('orderRef', $refOrderId)
            ->first();

        if ($existingOrder) {
            return [
                'order_id' => $refOrderId,
                'status' => 'success',
                'Profast_id' => $existingOrder->id,
                'message' => 'Order already exists for the user',
            ];
        }

        return null;
    }
}
