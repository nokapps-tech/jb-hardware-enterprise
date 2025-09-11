<?php

namespace App\Livewire\Users;

use App\Livewire\Forms\UserForm;
use App\Models\User;
use Livewire\Component;

class Edit extends Component
{
    public UserForm $form;

    public function mount(User $user)
    {
        $this->form->setUserModel($user);
    }

    public function save()
    {
        $this->form->update();

        return $this->redirectRoute('users.index', navigate: true);
    }

    public function render()
    {
        return view('livewire.user.edit', ['user' => $this->form->userModel]);
    }
}
