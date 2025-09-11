<?php

namespace App\Livewire\Roles;

use App\Livewire\Forms\RoleForm;
use App\Models\Role;
use Livewire\Component;

class Edit extends Component
{
    public RoleForm $form;
    public Role $role;

    public function mount(Role $role)
    {
        $this->role = $role;
        $this->form->setRoleModel($role);
    }

    public function save()
    {
        $this->form->update();

        return $this->redirectRoute('roles.index', navigate: true);
    }

    public function render()
    {
        return view('livewire.role.edit', [
            'role' => $this->role,
        ]);
    }
}
