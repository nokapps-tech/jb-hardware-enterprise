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
			'name' => 'nullable|string',
			'guard_name' => 'nullable|string',
			'description' => 'nullable|string',
			'readonly' => 'nullable',
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
        $validated = $this->validate();

        $validated['name'] = strtolower(str_replace(' ', '-', $validated['display_text']));
        $validated['guard_name'] = 'web';
        $validated['readonly'] = 1;
        
        Role::create($validated);

        $this->reset();
    }

    public function update(): void
    {
        $validated = $this->validate();

        // format before updating
        $validated['name'] = strtolower(str_replace(' ', '-', $validated['display_text']));
        $validated['guard_name'] = 'web';
        $validated['readonly'] = 1;

        $this->roleModel->update($validated);

        $this->reset();
    }
}
