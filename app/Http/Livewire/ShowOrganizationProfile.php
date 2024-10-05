<?php

namespace App\Http\Livewire;

use App\Models\OrganizationProfile;
use Livewire\Component;
use Livewire\WithFileUploads;

class ShowOrganizationProfile extends Component
{
    use WithFileUploads;
    public $logo, $name, $address, $email, $phone_no, $whatsapp_no , $countery_key;
    public function updatedLogo()
    {
        $this->validate([
            'logo' => 'image|max:1024',
        ]);
    }

    public function mount()
    {
        $org = OrganizationProfile::first();
        $this->name = $org->name;
        $this->address = $org->address;
        $this->phone_no = $org->phone_no;
        $this->whatsapp_no = $org->whatsapp_no;
        $this->email = $org->email;
        $this->logo = $org->logo;
        $this->countery_key = $org->countery_key;
    }

    public function update()
    {
        $validatedData = $this->validate([
            'name' => 'string|required',
            'phone_no' => 'string|required',
            'whatsapp_no' => 'string|required',
            'address' => 'string|required',
            'email' => 'string|required|email',
            'countery_key'=> 'nullable',
        ]);
        // jksa altigaini osamn             ------------------------
        $org = OrganizationProfile::first();
        if ($this->logo !== $org->logo) {
            $path = $this->logo->store('logos');
            $validatedData['logo'] = $path;
        }
        $status = OrganizationProfile::first()->update($validatedData);
        if ($status) {
            session()->flash('success', __('translation.item.updated.successfully'));
        } else {
            session()->flash('error', __('translation.error.exception'));
        }
    }

    public function render()
    {
        return view('livewire.show-organization-profile', [
            "data" => OrganizationProfile::first(),
        ]);
    }
}
