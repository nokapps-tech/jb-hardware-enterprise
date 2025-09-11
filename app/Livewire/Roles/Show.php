<?php

namespace App\Livewire\Roles;

use App\Livewire\Forms\RoleForm;
use App\Models\Role;
use Livewire\Component;

class Show extends Component
{
    public RoleForm $form;

    public function mount(Role $role)
    {
        $this->form->setRoleModel($role);
    }

    public function render()
    {
        return view('livewire.role.show', ['role' => $this->form->roleModel]);
    }
}
