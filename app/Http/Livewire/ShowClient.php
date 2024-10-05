<?php

namespace App\Http\Livewire;

use App\Exceptions\UserWasNotRegisterInFireBase;
use App\Models\Area;
use Livewire\Component;
use App\Models\Client;
use App\Models\ClientServicePrice;
use App\Models\clientsFile;
use App\Models\ClientsTokens;
use App\Models\OrganizationProfile;
use App\Models\Service;
use App\Models\SubArea;
use Exception;
use Livewire\WithPagination;
use App\Traits\CreateUserWithFireBase;
use Livewire\WithFileUploads;

use function PHPSTORM_META\type;

class ShowClient extends Component
{
    use WithFileUploads;
    use WithPagination , CreateUserWithFireBase;

    protected $paginationTheme = 'bootstrap';
    public $fullname,
     $address, $email, $password ="Aa123456", $passwordConfirm="Aa123456", $is_active, $sub_area_id,
    $phone, $discount_rate, $account_balance, $identify_image , $area_id,  $civil_registry ="0",
    $bank_account_owner= "0" , $bank_account_number = "0" , $iban_number = "0", $commrical_record_image ,
    $bank_account_image , $client_type , $bank="0";
    public $client_id , $APIKey , $APISecretKey , $public_key_id;
    public $updateMode = false;
    public $serviec_1, $serviec_2, $serviec_3, $serviec_4,$serviec_5, $serviec_11, $is_has_custom_price, $ClientServices = [];
    public $searchTerm , $ServicesName;
    protected $listeners = ['deleted', 'DonePayment'];

    public function ToggleUpdateModel($val){
        if($val == null){
            $this->emit('updating_Area_show');
        }else{
            $this->emit('updating_Area_hidden');
        }
    }

    public function mount(){
        $this->ServicesName = [
            'service_1' => __('translation.service_1_translation'),
            'service_2' => __('translation.service_2_translation'),
            'service_3' => __('translation.service_3_translation'),
            'service_4' => __('translation.service_4_translation'),
           'service_5' => __('translation.service_5_translation'),
            'service_11' => __('translation.service_11_translation'),
        ];
    }

    public function store()
    {
            $validatedData = $this->validate([
                'fullname' => 'required|string',
                'address' => 'required|string',
                'email' => 'required|email',
                'sub_area_id' => 'required|exists:sub_areas,id',
                'area_id' => 'required|exists:areas,id',
                'phone' => 'required|numeric',
                'password'=> 'required',
                'passwordConfirm' => 'required|same:password',
                'civil_registry' => 'required',
                'bank_account_owner' => 'required',
                'bank_account_number' => 'required',
                'iban_number' => 'required',
                'client_type' => 'required',
                'bank' => 'required',
                'is_has_custom_price' => 'nullable',
                'serviec_1' => 'required_if:is_has_custom_price,true',
                'serviec_2' => 'required_if:is_has_custom_price,true',
                'serviec_3' => 'required_if:is_has_custom_price,true',
                'serviec_4' => 'required_if:is_has_custom_price,true',
                'serviec_5' => 'required_if:is_has_custom_price,true',
                'serviec_11' => 'required_if:is_has_custom_price,true',
            ]);
            try{
            $OrgnazationProfile = OrganizationProfile::first();

            $validatedData['password'] = bcrypt($this->password);
            if ($this->is_has_custom_price) {
                $validatedData['is_has_custom_price'] = 1;
            } else {
                $validatedData['is_has_custom_price'] = 0;
            }
            $validatedData['is_approved'] = 1;
            $phone = $validatedData['phone'];
            $validatedData['phone'] = $phone;//"$OrgnazationProfile->countery_key $phone";
            // dd($validatedData['phone'] = "+249$phone");

            $Client =  Client::create($validatedData);
            if($this->identify_image || $this->bank_account_image){
                if($this->identify_image) {
                    $path = $this->identify_image->storePublicly('images');
                    clientsFile::create([
                        'client_id' => $Client->id,
                        'file' => $path,
                        'type' => 'commercial_record',
                    ]);
                }
                if($this->bank_account_image){
                    $path = $this->bank_account_image->storePublicly('images');
                    clientsFile::create([
                        'file' => $path,
                        'client_id' =>  $Client->id,
                        'type' => 'bank_account_image',
                    ]);
                }
                }
            if ($this->is_has_custom_price) {
                // inint data to database
                $InsertData  = [
                    ['client_id' => $Client->id, 'service_id' => 1,   'price' => $this->serviec_1 ,  'type' => ''],
                    ['client_id' => $Client->id, 'service_id' => 2,  'price' => $this->serviec_2 , 'type' => ''],
                    ['client_id' => $Client->id, 'service_id' => 3, 'price' => $this->serviec_3 , 'type' => ''],
                    ['client_id' => $Client->id, 'service_id' => 4,   'price' => $this->serviec_4 , 'type' => ''],
                    ['client_id' => $Client->id, 'service_id' => 5,   'price' => $this->serviec_5 , 'type' => ''],
                    ['client_id' => $Client->id, 'service_id' => 1,  'price' => $this->serviec_11 , 'type' => 'pickup'],
                ];
                // dd($InsertData);
                $ServicePrice = ClientServicePrice::insert($InsertData);
                $this->serviec_1 = $this->serviec_2 = $this->serviec_3 = $this->serviec_4 = $this->serviec_5 = $this->serviec_11  = $this->is_has_custom_price =  '';
            }
            $this->AddUserToFirebase($this->email , $this->password);
            session()->flash('success', __('translation.item.created.successfully'));
            $this->resetPage();
            $this->resetInputFields();
            $this->emit('stored');
        }catch(UserWasNotRegisterInFireBase $UFire){
            session()->flash("error", __('translation.error.exception'));
        }
        catch(Exception $e){
            dd($e);
            session()->flash("error", __('translation.error.exception'));
        }
         // Close model to using to jquery
    }
    private function resetInputFields()
    {
        $this->fullname = '';
        $this->address = '';
        $this->email = '';
        $this->password = '';
        $this->passwordConfirm = '';
        $this->sub_area_id = '';
        $this->phone = '';
        $this->discount_rate = '';
        $this->account_balance = '';
        $this->iban_number = '';
        $this->bank_account_number = '';
        $this->bank_account_owner = '';
        $this->civel_name = '';
    }
    public function deleted($status)
    {
        if ($status) {
            session()->flash('success', __('translation.item.deleted.successfully'));
            $this->render();
        } else {
            session()->flash('success', __('translation.delete.exception'));
        }
    }

    public function edit($id)
    {
        $this->updateMode = true;
        $client = Client::where('id', $id)->first();
        // dd();
        $this->client_id = $id;
        // dd($this->client_id);
        $this->ClientServices = ClientServicePrice::where('client_id', $id)->where('type' , '')
    ->get()
    ->map(function ($item) {
        $item->price = number_format($item->price , 2); // Double the price and format to two decimal points
        return $item;
    })
    ->keyBy('service_id')
    ->toArray();
        // dd(ClientServicePrice::where('client_id', $id)->get()->keyBy('service_id')->toArray() , $id);

        // check if client has a custom price -----------------------------
      if($client->is_has_custom_price){

        if (isset($this->ClientServices[1])) {
            // dd($this->ClientServices );
            $this->is_has_custom_price = true;
            $price = ClientServicePrice::where('client_id', $id)->where(['type' => 'pickup', 'service_id' => 1])
            ->get() // Retrieve the collection
            ->map(function ($item) {
                $item->price = number_format($item->price, 2); // Double the price and format to two decimal points
                return $item;
            })
            ->first(); // Get the first item in the collection


            $this->emit('has_custom', true);
            if ($this->ClientServices[1] != null) {
                $this->serviec_1 = $this->ClientServices[1]['price'];
                $this->serviec_2 = $this->ClientServices[2]['price'];
                $this->serviec_3 = $this->ClientServices[3]['price'];
                $this->serviec_4 = $this->ClientServices[4]['price'];
                $this->serviec_5 = $this->ClientServices[5]['price'];
                $this->serviec_11 = $price ? $price['price'] : null;
                // dd($this->serviec_1);
            }
        } else {
            $this->emit('has_custom', false);
            $this->is_has_custom_price = null;
        }
    }else{
        $this->emit('has_custom', false);
        $this->is_has_custom_price = null;
    }





        // value="{{ ?  ?  :"" :"" }}"
        $this->fullname = $client->fullname;
        $this->address = $client->address;
        // $this->password = $client->password;
        // $this->passwordConfirm = $client->password;
        $this->email = $client->email;
        $this->is_active = $client->is_active;
        $this->sub_area_id = $client->sub_area_id;
        $this->area_id = $client->area_id;
        $this->phone = trim($client->orignal_phone);
        $this->discount_rate = $client->discount_rate;
        $this->account_balance = $client->account_balance;
        $this->bank_account_number = $client->bank_account_number;
        $this->bank_account_owner = $client->bank_account_owner;
        $this->civil_registry = $client->civil_registry;
        $this->iban_number = $client->iban_number;
        $this->bank = $client->bank;
        $this->client_type = $client->client_type;
        // dd($this->phone);
    }
    public function update()
    {
        $validatedData = $this->validate([
            'fullname' => 'required|string',
            'address' => 'required|string',
            'email' => 'required|email',
            'sub_area_id' => 'required|exists:sub_areas,id',
            'phone' => 'required|numeric',
            'discount_rate' => 'required|numeric',
            'account_balance' => 'required|numeric',
            'client_type' => 'required',
            // 'civil_registry' => 'required',
                // 'bank_account_owner' => 'required',
                // 'bank_account_number' => 'required',
                // 'iban_number' => 'required',
                // 'bank' => 'required',
            'serviec_1' => 'required_if:is_has_custom_price,true',
            'serviec_2' => 'required_if:is_has_custom_price,true',
            'serviec_3' => 'required_if:is_has_custom_price,true',
            'serviec_4' => 'required_if:is_has_custom_price,true',
            'serviec_5' => 'required_if:is_has_custom_price,true',
            'serviec_11' => 'required_if:is_has_custom_price,true',
        ]);

        // $validatedData['password'] = bcrypt($this->password);

        // $validatedData['password'] = bcrypt($this->password);
        $phone = $validatedData['phone'];
        $OrgnazationProfile = OrganizationProfile::first();
        $validatedData['phone'] = $phone;// "$OrgnazationProfile->countery_key $phone";
        $validatedData['is_approved'] = 1;
        // add custom price --------------------------------
        if ($this->is_has_custom_price) {

            $validatedData['is_has_custom_price'] = 1;
        } else {
            $validatedData['is_has_custom_price'] = 0;
        }
        if ($this->client_id) {
            $Client = Client::find($this->client_id);
            $Client->update($validatedData);
            // update custom price
            $ClientServices = ClientServicePrice::where('client_id', $this->client_id)->delete();
            if ($this->is_has_custom_price) {
                // inint data to database
                $InsertData  = [
                    ['client_id' => $Client->id, 'service_id' => 1,   'price' => $this->serviec_1 , 'type' => ''] ,
                    ['client_id' => $Client->id, 'service_id' => 2,  'price' => $this->serviec_2 , 'type' => ''],
                    ['client_id' => $Client->id, 'service_id' => 3, 'price' => $this->serviec_3 , 'type' => ''],
                    ['client_id' => $Client->id, 'service_id' => 4,   'price' => $this->serviec_4 , 'type' => ''],
                    ['client_id' => $Client->id, 'service_id' => 5,   'price' => $this->serviec_5 , 'type' => ''],
                    ['client_id' => $Client->id, 'service_id' => 1,  'price' => $this->serviec_11 , 'type' => 'pickup'],
                ];
                //dd($InsertData);
                $ServicePrice = ClientServicePrice::insert($InsertData);
                $this->serviec_1 = $this->serviec_2 = $this->serviec_3 = $this->serviec_4 = $this->serviec_5  = '';
            }

            $this->updateMode = false;
            session()->flash('success', __('translation.item.updated.successfully'));
            $this->emit('updated'); // Close model to using to jquery
            $this->resetInputFields();
        }
    }
    public function cancel()
    {
        $this->updateMode = false;
        $this->resetInputFields();
    }

    public function updatingSearchTerm()
    {
        $this->resetPage();
    }

    public function assginClient($id){
        $this->public_key_id = $id;
        $client = Client::find($id);
        if($client->ClientKeys){
            $this->APIKey = $client->ClientKeys->api_key;
            $this->APISecretKey = $client->ClientKeys->api_secret_token;
        }else{
            $this->APIKey = '';
            $this->APISecretKey ='';
        }
    }
    public function GenrateKeys(){
        // dd('genrated key');
        $client = Client::find($this->public_key_id);
        $api_key = ClientsTokens::generateUniqueApiKey();
        $date = date('y-m-d h:m:s');
        $api_secret_token = md5("{$client->name}-{$client->id}-{$date}");
        if($client->ClientKeys){
            $client->ClientKeys->update(['api_key'=> $api_key, 'api_secret_token' => $api_secret_token]);
        }else{
            ClientsTokens::create(
                ['client_id' => $client->id ,'api_key'=> $api_key , 'api_secret_token' => $api_secret_token]
            );
        }
        $this->emit('GenrateDone');
        session()->flash('success', __('translation.item.updated.successfully'));
    }
    public function render()
    {
            $Banks  = [
                    'البنك الأهلي التجاري' ,
                    'بنك الرياض',
                    'بنك البلاد',
                    'مصرف الراجحي',
                    ' بنك الجزيرة',
                    ' البنك السعودي للاستثمار',
                    'سامبا المالية',
                    'البنك السعودي البريطاني',
                    'البنك السعودي الهولندي',
                    'البنك السعودي الفرنسي' ,
                    'البنك العربي الوطني'
            ];

        $searchTerm = '%' . $this->searchTerm . '%';
        $idTearm = (int) filter_var($this->searchTerm, FILTER_SANITIZE_NUMBER_INT);
        $normalizedPhoneFilter = preg_replace('/^\+966|^00966|^0/', '', $this->searchTerm);
        $normalizedPhoneFilter = '%' . $normalizedPhoneFilter . '%';

        //dd($normalizedPhoneFilter);

        $services = Service::select('id', 'name')->get();
        $data =  (Client::where('fullname', 'like', $searchTerm)->orwhere('phone', 'like', $normalizedPhoneFilter)->orwhere('id', '=',  abs($idTearm))->orwhere('email', 'like', $searchTerm)->where('is_approved' , 1)->with('ServicePrice' , 'Area')->orderBy('id', 'desc')->paginate(1000));
        if($this->area_id){
            $subArea =  SubArea::where('area_id' , $this->area_id)->orderBy('id', 'desc')->get();
        }
        else{
            $subArea =  SubArea::where('id' , $this->area_id)->orderBy('id', 'desc')->get();
        }
        return view('livewire.show-client', [
            'data' => $data,
            'sub_areas' =>$subArea,
            'areas' => Area::orderBy('id', 'desc')->get(),
            'services' => $services,
            'Banks' => $Banks,
            'ServicesName' => $this->ServicesName,
        ])->layout('admin.master');
    }
}
