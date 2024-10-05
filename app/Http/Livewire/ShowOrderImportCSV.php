<?php

namespace App\Http\Livewire;

use App\Models\Area;
use App\Models\Order;
use App\Models\SerialSetting;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Livewire\Component;
use Livewire\WithFileUploads;

class ShowOrderImportCSV extends Component
{
    use WithFileUploads;
    public $CSVFile;
    public $data = [];
    public $data_to_store = [];
    public $csv_file_path;


    public function preview()
    {
        try {
            if ($this->CSVFile) {
                $this->csv_file_path = $this->CSVFile->store('csv');
                $this->data = csvToArray(public_path('uploads/' . $this->csv_file_path));
                //convert array key value
                $this->data = array_column($this->data, null, "line");
                // Start Validation
                $request = new Request($this->data);
                $validatedData = $request->validate([
                    '*.service number' => 'required|numeric|exists:services,id',
                    '*.client number' => 'required|numeric|exists:clients,id',
                    '*.representative number' => 'required|numeric|exists:representatives,id',
                    '*.sender name' => 'required',
                    '*.sender phone' => 'required',
                    '*.sender area number' => 'required|numeric|exists:areas,id',
                    '*.sender sub area number' => 'required|numeric|exists:sub_areas,id',
                    '*.sender address' => 'required',
                    '*.receiver name' => 'required',
                    '*.receiver phone' => 'required',
                    '*.receiver area number' => 'required|numeric|exists:areas,id',
                    '*.receiver subarea number' => 'required|numeric|exists:sub_areas,id',
                    '*.receiver address' => 'required',
                    '*.order fees' => 'required|numeric',
                    '*.payment method' => 'required|in:on_sending,on_receiving,balance',
                    '*.status' => 'required|in:pending,inProgress,delivered,completed,canceled',
                    '*.order date' => 'date',
                ], [
                    "exists" => "القيمه المحدده في السطر رقم :attribute غير موجوده",
                    "required" => "الحقل في السطر رقم :attribute غير موجود",
                    "numeric" => "الحقل في السطر رقم :attribute يجب ان يكون رقما",
                    "in" => "الحقل في السطر رقم :attribute لايطابق الخيارات المتاحه",
                    "date_format" => "الحقل في السطر :attribute يجب ان يكون تاريخا",
                ]);
                $this->data_to_store = $validatedData;
            }
        } catch (\Throwable $th) {
            session()->flash('error', __('translation.file.handling.error'));
        }

        // dd($this->data);
    }

    public function store()
    {
        if ($this->csv_file_path) {
            //remove the stored csv file
            Storage::disk('public')->delete($this->csv_file_path);
        }

        if ($this->data_to_store !== []) {
            //data is validated and good to go
            $final_data = [];
            foreach ($this->data_to_store as $line => $row) {
                $delivery_fees = (int) filter_var(Area::find($row["sender area number"])->fees, FILTER_SANITIZE_NUMBER_INT);
                $total_fees = $delivery_fees + $row["order fees"];
                $representative_deserves = $delivery_fees * env('REPRESENTATIVE_PERCENTAGE') / 100;
                $company_deserves = $delivery_fees - $representative_deserves;
                //generate invoice no
                $inv_no = SerialSetting::first()->inv_no;
                SerialSetting::first()->update(["inv_no" => ($inv_no + 1)]);

                $final_data[$line - 1] = [
                    "service_id" => $row["service number"],
                    "client_id" => $row["client number"],
                    "representative_id" => $row["representative number"],
                    "sender_name" => $row["sender name"],
                    "sender_phone" => $row["sender phone"],
                    "sender_area_id" => $row["sender area number"],
                    "sender_sub_area_id" => $row["sender sub area number"],
                    "sender_address" => $row["sender address"],
                    "receiver_name" => $row["receiver name"],
                    "receiver_phone_no" => $row["receiver phone"],
                    "receiver_area_id" => $row["receiver area number"],
                    "receiver_sub_area_id" => $row["receiver subarea number"],
                    "receiver_address" => $row["receiver address"],
                    "police_file" => null,
                    "is_police_file_sent" => 0,
                    "delivery_fees" => $delivery_fees,
                    "order_fees" => $row["order fees"],
                    "total_fees" => $total_fees,
                    "representative_deserves" => $representative_deserves,
                    "company_deserves" => $company_deserves,
                    "payment_method" => $row["payment method"],
                    "is_company_fees_collected" => 0,
                    "order_date" => date('Y-m-d h:m:s', strtotime($row["order date"])),
                    "delivery_date" => null,
                    "status" => $row["status"],
                    "transaction_id" => null,
                    "invoice_sn" => genInvNo($inv_no),
                    "is_deleted" => 0,
                ];
            }
            // dd($final_data);
            try {
                Order::insert($final_data);
                session()->flash('success', __('translation.item.created.successfully'));
                $this->resetInputFields();
            } catch (\Throwable $th) {
                // dd($th);
                session()->flash('error', __('translation.error.exception'));
            }
        } else {
            //there are validation errors
        }
    }

    private function resetInputFields()
    {
        $this->csv_file_path = '';
        $this->CSVFile = '';
        $this->data = [];
        $this->data_to_store = [];
    }

    public function hydrate()
    {
        $this->emit('dataTable');
    }



    public function sampleDownload()
    {
        return response()->download(public_path('uploads/orderSample.csv'));
    }

    public function render()
    {
        return view('livewire.show-order-importCSV', [
            'data' => $this->data,
        ]);
    }
}
