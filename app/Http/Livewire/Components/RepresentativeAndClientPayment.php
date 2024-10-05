<?php

namespace App\Http\Livewire\Components;

use App\Events\SendNotifcationWithFireBase;
use App\Models\Client;
use App\Models\SerialSetting;
use App\Models\Transaction;
use App\Models\TransactionsType;
use Illuminate\Database\Eloquent\Model;
use Livewire\Component;
use DB;
use Illuminate\Support\Facades\DB as FacadesDB;
use App\Exceptions\NotifcationException;

class RepresentativeAndClientPayment extends Component
{
    public $amountToPay, $is_client, $representative_id, $client_id, $payment_flag;
    public Model $model;

    protected $rules = [
        'amountToPay' => 'required|numeric'
    ];

    public function mount($model, $isClient, $paymentFlag)
    {
        // dd($model, $isClient, $paymentFlag);
        $this->model = $model;
        $this->is_client = $isClient;
        $this->payment_flag = $paymentFlag;
        if ($this->is_client == "true") {
            $this->client_id = $this->model->id;
            $this->representative_id = null;
        } else if ($this->is_client == "false") {
            $this->representative_id = $this->model->id;
            $this->client_id = null;
        }
    }

    public function pay()
    {
        $this->validate($this->rules);
        try {
            //check current balance
            if ($this->model->account_balance < $this->amountToPay) {
                $this->emit("DonePayment", "amountError", $this->model->id);
                $this->resetInputFields();
                return;
            }

            DB::transaction(function () {
                //Insert into transactions
                insertTransaction($this->payment_flag, $this->representative_id, $this->client_id, $this->amountToPay);
                //update client balance
                $new_balance = ($this->model->account_balance - $this->amountToPay);
                $this->model->update(['account_balance' => $new_balance]);
            });
            // SendNotifcationWithFireBas
            event(new SendNotifcationWithFireBase($this->model->message_token , __('translation.CollectionMnagement') , __('translation.CollecionWasDoneSuccessfuly')));
            $this->emit("DonePayment", "success", $this->model->id);
            $this->resetInputFields();
        }
        catch(NotifcationException $Ne){
            session()->flash('error' ,__('translation.Notification_Send_Error'));
            $this->emit("DonePayment", "error", $this->model->id);
        }
        catch (\Throwable $th) {
            // throw $th;
            // dd($th);
            $this->emit("DonePayment", "error", $this->model->id);
        }
    }
    private function resetInputFields()
    {
        $this->amountToPay = '';
    }

    public function render()
    {
        return view('livewire.components.representative-and-client-payment');
    }
}
