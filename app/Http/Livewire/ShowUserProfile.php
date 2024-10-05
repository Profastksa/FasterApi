<?php

namespace App\Http\Livewire;

use App\Models\User;
use Livewire\Component;
use Livewire\WithFileUploads;

class ShowUserProfile extends Component
{
    use WithFileUploads;
    public $name, $email, $current_password, $password, $password_confirmation, $photo;

    public function mount()
    {
        $this->name = auth()->user()->name;
        // $this->current_password = auth()->user()->password;
        $this->email = auth()->user()->email;
        $this->photo = auth()->user()->photo;
    }

    public function updatedPhoto()
    {
        $this->validate([
            'photo' => 'image|max:1024'
        ]);
    }

    public function update()
    {
        $validatedData = $this->validate([
            'name' => 'required|string',
            'email' => 'required|email',
            'current_password' => 'required|current_password:web',
            'password' => 'sometimes|confirmed',
        ]);
        if ($this->photo != auth()->user()->photo) {
            $path = $this->photo->store('users_profile');
            $validatedData['photo'] = $path;
        }
        if ($this->password) {
            $validatedData['password'] = bcrypt($this->password);
        } else {
            $validatedData['password'] = bcrypt($this->current_password);
        }

        $status = User::find(auth()->user()->id)->update($validatedData);
        if ($status) {
            session()->flash('success', __('translation.item.updated.successfully'));
            $this->resetInputFields();
        } else {
            session()->flash('error', __('translation.error.exception'));
        }
    }

    private function resetInputFields()
    {
        $this->current_password = '';
        $this->password = '';
        $this->password_confirmation = '';
    }

    public function render()
    {
        return view('livewire.show-user-profile', [
            "data" => auth()->user(),
        ]);
    }
}
