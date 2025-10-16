<?php

namespace App\Livewire\Companies;

use App\Models\Company;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\View\View;
use Livewire\Component;
use Livewire\WithPagination;
use App\Exports\CompaniesExport;
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
        $filename = 'companies_export_' . now()->format('Y-m-d_His') . '.xlsx';
        return Excel::download(new CompaniesExport($this->search, $this->filter), $filename);
    }

    public function render(): View
    {
        $companies = Company::query()
            ->when($this->search, fn (Builder $q) =>
                $q->where('name', 'like', "%{$this->search}%")
                ->orWhere('industry', 'like', '%' . $this->search . '%')
            )
            ->when($this->filter, function (Builder $q) {
                match ($this->filter) {
                    default => null,
                };
            })
            ->latest('updated_at')
            ->paginate();

        return view('livewire.company.index', [
            'companies' => $companies,
            'filters' => $this->filters,
            'i' => $this->getPage() * $companies->perPage(),
        ]);
    }

    public function delete(Company $company)
    {
        $company->delete();

        return $this->redirectRoute('companies.index', navigate: true);
    }
}
