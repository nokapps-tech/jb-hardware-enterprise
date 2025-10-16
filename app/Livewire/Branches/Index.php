<?php

namespace App\Livewire\Branches;

use App\Models\Branch;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\View\View;
use Livewire\Component;
use Livewire\WithPagination;
use Illuminate\Support\Facades\Auth;
use App\Exports\BranchesExport;
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
        $filename = 'branches_export_' . now()->format('Y-m-d_His') . '.xlsx';
        return Excel::download(new BranchesExport($this->search, $this->filter), $filename);
    }

    public function render(): View
    {
        $user = auth()->user();

        $branches = Branch::query()
            ->when(!$user->hasAnyRole(['system-administrator','developer']), fn($q) => 
                $q->whereIn('id', $user->branches->pluck('id'))
            )
            ->when($this->search, fn (Builder $q) =>
                $q->where('name', 'like', "%{$this->search}%")
                ->orWhere('address', 'like', '%' . $this->search . '%')
            )
            ->when($this->filter, function (Builder $q) {
                match ($this->filter) {
                    default => null,
                };
            })
            ->latest('updated_at')
            ->paginate();
            
        return view('livewire.branch.index', [
            'branches' => $branches,
            'filters' => $this->filters,
            'i' => $this->getPage() * $branches->perPage(),
        ]);
    }

    public function delete(Branch $branch)
    {
        $branch->delete();

        return $this->redirectRoute('branches.index', navigate: true);
    }
}
