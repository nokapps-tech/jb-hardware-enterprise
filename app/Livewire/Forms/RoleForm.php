<?php

namespace App\Livewire\Forms;

use App\Models\Role;
use Livewire\Form;

class RoleForm extends Form
{
    public ?Role $roleModel;
    
    public $display_text = '';
    public $name = '';
    public $guard_name = '';
    public $description = '';
    public $readonly = '';

    public function rules(): array
    {
        return [
			'display_text' => 'required|string',
			'name' => 'required|string',
			'guard_name' => 'required|string',
			'description' => 'nullable|string',
			'readonly' => 'required',
        ];
    }

    public function setRoleModel(Role $roleModel): void
    {
        $this->roleModel = $roleModel;
        
        $this->display_text = $this->roleModel->display_text;
        $this->name = $this->roleModel->name;
        $this->guard_name = $this->roleModel->guard_name;
        $this->description = $this->roleModel->description;
        $this->readonly = $this->roleModel->readonly;
    }

    public function store(): void
    {
        $this->roleModel->create($this->validate());

        $this->reset();
    }

    public function update(): void
    {
        $this->roleModel->update($this->validate());

        $this->reset();
    }
}
