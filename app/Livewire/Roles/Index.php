<?php

namespace App\Livewire\Roles;

use App\Models\Role;
use Illuminate\View\View;
use Livewire\Component;
use Livewire\WithPagination;

class Index extends Component
{
    use WithPagination;

    public string $search = '';

    public function render(): View
    {
        # TODO: Add columns to search on with $search here
        $roles = Role::orderBy('updated_at', 'desc')
            ->paginate();

        return view('livewire.role.index', [
            'roles' => $roles,
            'i' => $this->getPage() * $roles->perPage(),
        ]);
    }

    public function delete(Role $role)
    {
        $role->delete();

        return $this->redirectRoute('roles.index', navigate: true);
    }
}
