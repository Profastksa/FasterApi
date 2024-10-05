<?php

use App\Models\Client;
use App\Models\Representative;
use App\Models\SerialSetting;
use App\Models\SubArea;
use App\Models\Transaction;
use App\Models\TransactionsType;
use App\Scope\ApprovedScope;
use Carbon\Carbon;

// GENERATE TRANSACTION NO
if (!function_exists('GenTransNo')) {
    function genTransNo($trans_no)
    {
        return "TRANS-" . date("Y") . "-" . sprintf("%04d", $trans_no);
    }
}

//GENERATE INVOICE NO
if (!function_exists('GenInvNo')) {
    function genInvNo($inv_no)
    {
        return "INV-" . date("Y") . "-" . sprintf("%04d", $inv_no);
    }
}

// INSERT NEW TRANSACTION
if (!function_exists('insertTransaction')) {
    function insertTransaction($payment_flag, $representative_id, $client_id, $amount)
    {
        //Insert into transactions
        $trans_sn = SerialSetting::first()->trans_no;
        $r = SerialSetting::first()->update(["trans_no" => ($trans_sn + 1)]);
        // dd($r);
        $transaction_type_id = TransactionsType::where($payment_flag, 1)->first()->id;
        $transaction_id = Transaction::insertGetId([
            'trans_sn' => genTransNo($trans_sn),
            'user_id' => auth()->user()->id,
            'representative_id' => $representative_id,
            'client_id' => $client_id,
            'date' => date("Y-m-d h:m:s"),
            'amount' => $amount,
            'transaction_type_id' => $transaction_type_id,
        ]);
        return $transaction_id;
    }
}


    function getSubAreaCountByAreaId($id){
        return SubArea::where('area_id', $id)->get()->count();
    }




// CONVERT CSV FILE TO ARRAY
if (!function_exists('csvToArray')) {
    function csvToArray($filename = '', $delimiter = ',')
    {
        if (!file_exists($filename) || !is_readable($filename))
            return false;

        $header = null;
        $data = array();
        $line = 1;
        if (($handle = fopen($filename, 'r')) !== false) {
            while (($row = fgetcsv($handle, 1000, $delimiter)) !== false) {
                if (!$header) {
                    $row[] = "line";
                    $header = $row;
                } else {
                    $row[] = $line;
                    $data[] = array_combine($header, $row);
                    $line++;
                }
            }
            fclose($handle);
        }

        return $data;
    }

    function GetModelItemCount($model){
        if($model == 'Client'){
            return Client::withoutGlobalScope(new ApprovedScope)->where('is_approved' , 0)->get()->count();
        }else{
            return Representative::withoutGlobalScope(new ApprovedScope)->where('is_approved' , 0)->get()->count();
        }
    }
}
