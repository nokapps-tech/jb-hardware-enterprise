<?php

namespace App\Livewire\Roles;

use App\Models\Role;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\View\View;
use Livewire\Component;
use Livewire\WithPagination;
use App\Exports\RolesExport;
use Maatwebsite\Excel\Facades\Excel;
use Symfony\Component\HttpFoundation\BinaryFileResponse;

class Index extends Component
{
    use WithPagination;

    public string $search = '';
    public ?string $filter = null;

    /** @var array<string, string> */
    public array $filters = [];
    
    protected $queryString = [
        'filter' => ['except' => null],
        'search' => ['except' => ''],
    ];

    public function setFilter(?string $value)
    {
        $this->filter = $value;
        $this->resetPage();

        $this->dispatch('close-filter-dropdown');
    }

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function updatingFilter()
    {
        $this->resetPage();
    }

    public function mount()
    {
        $this->filter = request()->query('filter', $this->filter);
    }

    public function export(): BinaryFileResponse
    {
        $filename = 'roles_export_' . now()->format('Y-m-d_His') . '.xlsx';
        return Excel::download(new RolesExport($this->search, $this->filter), $filename);
    }

    public function render(): View
    {
        # TODO: Add columns to search on with $search here
        $roles = Role::query()
            ->when($this->search, fn (Builder $q) =>
                $q->where('display_text', 'like', "%{$this->search}%")
                ->orWhere('name', 'like', '%' . $this->search . '%')
                ->orWhere('description', 'like', '%' . $this->search . '%')
            )
            ->when($this->filter, function (Builder $q) {
                match ($this->filter) {
                    default => null,
                };
            })
            ->latest('updated_at')
            ->paginate();

        return view('livewire.role.index', [
            'roles' => $roles,
            'filters' => $this->filters,
            'i' => $this->getPage() * $roles->perPage(),
        ]);
    }

    public function delete(Role $role)
    {
        $role->delete();

        return $this->redirectRoute('roles.index', navigate: true);
    }
}
