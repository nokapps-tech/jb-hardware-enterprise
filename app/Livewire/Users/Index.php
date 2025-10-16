<?php

namespace App\Livewire\Users;

use App\Models\User;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\View\View;
use Livewire\Component;
use Livewire\WithPagination;
use App\Exports\UsersExport;
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
        $filename = 'users_export_' . now()->format('Y-m-d_His') . '.xlsx';
        return Excel::download(new UsersExport($this->search, $this->filter), $filename);
    }

    public function render(): View
    {
        $users = User::query()
            ->when($this->search, function (Builder $q) {
                $q->where('name', 'like', "%{$this->search}%")
                ->orWhere('email', 'like', "%{$this->search}%")
                ->orWhereHas('roles', fn ($q2) => $q2->where('name', 'like', "%{$this->search}%"));
            })
            ->when($this->filter, function (Builder $q) {
                match ($this->filter) {
                    default => null,
                };
            })
            ->notMe()
            ->notSystemUsers()
            ->latest('updated_at')
            ->paginate();

        return view('livewire.user.index', [
            'users' => $users,
            'filters' => $this->filters,
            'i' => $this->getPage() * $users->perPage(),
        ]);
    }

    public function delete(User $user)
    {
        $user->delete();

        return $this->redirectRoute('users.index', navigate: true);
    }
}
