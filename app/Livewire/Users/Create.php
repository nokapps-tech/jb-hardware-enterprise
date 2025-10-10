<?php

namespace App\Livewire\Users;

use App\Livewire\Forms\UserForm;
use App\Models\User;
use App\Models\Branch;
use Livewire\Component;

class Create extends Component
{
    public UserForm $form;

    public function mount(User $user)
    {
        $this->form->setUserModel($user);
    }

    public function save()
    {
        $this->form->store();

        return $this->redirectRoute('users.index', navigate: true);
    }

    public function render()
    {
        return view('livewire.user.create', [
            'branches' => Branch::orderBy('name')->get(),
        ]);
    }
}
