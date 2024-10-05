<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\Representative;
use App\Models\Area;
use App\Models\OrganizationProfile;
use App\Models\SubArea;
use Livewire\WithPagination;
use App\Traits\CreateUserWithFireBase;

class ShowRepresentative extends Component
{
    use WithPagination , CreateUserWithFireBase;
    protected $paginationTheme = 'bootstrap';
    public $fullname, $address, $email, $password, $passwordConfirm, $phone, $account_balance ,  $area_id , $sub_area_id;
    public $representative_id ;
    public $updateMode = false;
    public $searchTerm;
    protected $listeners = ['deleted' => 'deleted', 'representative_areas_saved' => 'render', 'DonePayment' => 'DonePayment'];

    public function store()
    {
        $validatedData = $this->validate([
            'fullname' => 'required|string',
            'address' => 'required|string',
            'email' => 'required|email',
            'password' => 'required|min:6',
            'area_id' => 'required',
            'sub_area_id' => 'required',
            'passwordConfirm' => 'required|same:password',
            'phone' => 'required|numeric',
        ]);


        $validatedData['password'] = bcrypt($this->password);
        //  Add Countery Key              ----------------
        $OrgnazationProfile = OrganizationProfile::first();
        $phone = $validatedData['phone'];
        $validatedData['phone'] = "$OrgnazationProfile->countery_key $phone";
        $validatedData['is_approved'] = 1;
        Representative::create($validatedData);
        $this->AddUserToFirebase($this->email , $this->password);
        session()->flash('success', __('translation.item.created.successfully'));
        $this->resetPage();
        $this->resetInputFields();
        $this->emit('stored'); // Close Model To Using  Jquery
    }

    // public function updateRepresentativeAreas($representative_id){

    // }

    public function edit($id)
    {
        $this->updateMode = true;
        $representative = Representative::where('id', $id)->first();
        // dd($representative->orignal_phone);
        $this->representative_id = $id;
        $this->fullname = $representative->fullname;
        $this->address = $representative->address;
        $this->email = $representative->email;
        $this->area_id = $representative->area_id;
        $this->sub_area_id = $representative->sub_area_id;
        $this->phone = trim($representative->orignal_phone);
        $this->account_balance = $representative->account_balance;
        // dd($this->phone);
    }
    public function update()
    {
        $validatedData = $this->validate([
            'fullname' => 'required|string',
            'address' => 'required|string',
            'email' => 'required|email',
            'area_id' => 'required',
            'sub_area_id' => 'required',
            'phone' => 'required|numeric',
            'account_balance' => 'required|numeric',
        ]);
        if ($this->representative_id) {
            // dd($validatedData['phone']);
            $representative = Representative::find($this->representative_id);
            // $validatedData['phone'] = '+249' + $validatedData['phone'];
            $OrgnazationProfile = OrganizationProfile::first();
            $phone = $validatedData['phone'] ;
            $validatedData['phone'] = "$OrgnazationProfile->countery_key $phone";
            $representative->update($validatedData);
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


    private function resetInputFields()
    {
        $this->fullname = '';
        $this->address = '';
        $this->email = '';
        $this->password = '';
        $this->passwordConfirm = '';
        $this->phone = '';
        $this->account_balance = '';
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
    public function updatingSearchTerm()
    {
        $this->resetPage();
    }

    public function render()
    {
        $searchTerm = '%' . $this->searchTerm . '%';
        $Areas = Area::where('id', '!=', 11)->get();
        // $Areas = SubArea::get();
        if($this->area_id){
            $subArea =  SubArea::where('area_id' , $this->area_id)->orderBy('id', 'desc')->get();
        }
        else{
            $subArea =  SubArea::where('id' , $this->area_id)->orderBy('id', 'desc')->get();
        }
        return view('livewire.show-representative', [
            'data' => Representative::with('areas','Area')->where('fullname', 'like', $searchTerm)->where('is_approved' , 1)->orderBy('id', 'desc')->paginate(1000),
            'areas' =>$Areas,
            'sub_areas' => $subArea,
        ]);
    }
}
