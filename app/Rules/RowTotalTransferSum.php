<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;

class RowTotalTransferSum implements Rule
{
    protected $totalFees;

    public function __construct($totalFees)
    {
        $this->totalFees = $totalFees;
    }

    public function passes($attribute, $value)
    {
        // Get the request data
        $data = request()->all();

        // Calculate the sum of cash_amount and E_transfer_amount for all rows
        $calculatedTotal = array_sum(array_column($data['RepCollectionData'], 'cash_amount')) + array_sum(array_column($data['RepCollectionData'], 'E_transfer_amount'));

        // Check if the calculated total matches the provided totalFees
        return $calculatedTotal == $this->totalFees;
    }

    public function message()
    {
        return 'يجب ان يتساوي  مجموع التحويل و الكاش مع اجمالي قيمه المبالغ';
    }
}
