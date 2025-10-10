<?php

namespace App\Livewire\Forms;

use App\Models\User;
use Livewire\Form;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class UserForm extends Form
{
    public ?User $userModel;
    
    public $name = '';
    public $email = '';
    public $role = '';
    public $branch_ids = [];

    public function rules(): array
    {
        return [
			'name' => 'required|string',
			'email' => 'required|string',
            'role' => 'nullable|string|exists:roles,name',
            'branch_ids' => 'nullable|array',
            'branch_ids.*' => 'exists:branches,id',
        ];
    }

    public function setUserModel(User $userModel): void
    {
        $this->userModel = $userModel;
        
        $this->name = $this->userModel->name;
        $this->email = $this->userModel->email;
        $this->role = $this->userModel->roles()->first()?->name ?? '';

        $this->branch_ids = $this->userModel->branches()->pluck('branches.id')->toArray();
    }

    public function store(): void
    {
        $validated = $this->validate();

        $user = User::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'email_verified_at' => now(),
            'password' => Hash::make('password'),
            'remember_token' => Str::random(10),
        ]);

        if (!empty($validated['role'])) {
            $user->assignRole($validated['role']);
        } 
        else {
            $user->assignRole('user');
        }

        if (!empty($this->branch_ids)) {
            $user->branches()->sync($this->branch_ids);
        }

        $this->reset();
    }

    public function update(): void
    {
        $validated = $this->validate();

        $data = [
            'name' => $validated['name'],
            'email' => $validated['email'],
        ];
        $this->userModel->update($data);

        if (!empty($validated['role'])) {
            $this->userModel->syncRoles([$validated['role']]);
        }

        $this->userModel->branches()->sync($this->branch_ids);

        $this->reset();
    }
}
