<?php

namespace App\Http\Livewire;

use App\Models\Order;
use App\Models\Transaction;
use App\Models\TransactionsType;
use Illuminate\Support\Facades\DB;
use Livewire\Component;
use Livewire\WithPagination;

class ShowTransactions extends Component
{
    use WithPagination;
    protected $paginationTheme = "bootstrap";
    public $from_date, $to_date, $transaction_type_id;
    public $transaction_orders = [];
    public $fees_collection_details = [];
    public $client_payment_details = [];
    public $representative_payment_details = [];

    protected $listeners = ['close'];

    public function mount()
    {
        $this->from_date = date('Y-m-d');
        $this->to_date = date('Y-m-d');
    }

    public function close()
    {
        // dd("dsd");
        $this->transaction_orders = [];
        $this->fees_collection_details = [];
        $this->client_payment_details = [];
        $this->representative_payment_details = [];
    }

    public function showFeesCollectionModal($transaction_id)
    {
        // dd($transaction_id);
        $this->transaction_orders = Transaction::find($transaction_id)->orders;

        $this->fees_collection_details = DB::select("SELECT sum(order_fees) as client_fees, clients.fullname
        FROM `orders`
        JOIN transactions on orders.transaction_id = transactions.id
        JOIN clients on clients.id = orders.client_id
        WHERE orders.transaction_id = ?  AND transactions.transaction_type_id = 1
        GROUP BY orders.client_id

        UNION

        SELECT sum(delivery_fees), 'company'
        FROM `orders`
        JOIN transactions on orders.transaction_id = transactions.id
        WHERE orders.transaction_id = ?  AND transactions.transaction_type_id = 1

        -- UNION

        -- SELECT sum(deserve), 'representative'
        -- FROM `orders`
        -- JOIN transactions on orders.transaction_id = transactions.id
        -- JOIN representative_percentages_union_representative_per_days ON representative_percentages_union_representative_per_days.transaction_id = transactions.id
        -- WHERE orders.transaction_id = ?  AND transactions.transaction_type_id = 1
        ", [$transaction_id, $transaction_id]);
    }

    public function showRepresentativePaymentModal($transaction_id)
    {
        // dd($transaction_id);
        $this->representative_payment_details = DB::table('representative_percentages_union_representative_per_days')
            ->where('transaction_id', $transaction_id)
            ->select(['deserve', 'payment_date', 'created_at'])
            ->get();
    }
    public function showClientPaymentModal($transaction_id)
    {
        // dd($transaction_id);
        $this->client_payment_details = DB::table('orders')
            ->where('client_payment_transaction_id', $transaction_id)
            ->select(['orders.id', 'orders.order_fees'])
            ->get();
    }

    public function render()
    {
        $data = Transaction::whereBetween('date', [$this->from_date . ' 00:00:00', $this->to_date . ' 23:59:59'])
            ->when($this->transaction_type_id, function ($query) {
                $query->where('transaction_type_id', $this->transaction_type_id);
            })
            ->orderBy('id', 'desc')->paginate(1000);
        return view('livewire.show-transactions', [
            'data' => $data,
            'transactions_types' => TransactionsType::orderBy('id', 'desc')->get(),
        ]);
    }
}
