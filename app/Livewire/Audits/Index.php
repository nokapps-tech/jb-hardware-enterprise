<?php

namespace App\Livewire\Audits;

use App\Models\Audit;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\View\View;
use Livewire\Component;
use Livewire\WithPagination;
use App\Exports\AuditsExport;
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
        $filename = 'audits_export_' . now()->format('Y-m-d_His') . '.xlsx';
        return Excel::download(new AuditsExport($this->search, $this->filter), $filename);
    }

    public function render(): View
    {
        $searchTerms = collect(explode(' ', $this->search))
            ->filter()
            ->map(fn ($term) => trim($term));

        $audits = Audit::with('user')
            ->when($this->search !== '', function (Builder $query) use ($searchTerms) {
                $query->where(function ($query) use ($searchTerms) {
                    foreach ($searchTerms as $term) {
                        $query->where(function ($q) use ($term) {
                            $q->where('event', 'like', "%{$term}%")
                            ->orWhere('auditable_type', 'like', "%{$term}%")
                            ->orWhere('auditable_id', 'like', "%{$term}%")
                            ->orWhereHas('user', fn ($q2) =>
                                $q2->where('name', 'like', "%{$term}%")
                            );
                        });
                    }
                });
            })
            ->when($this->filter, function (Builder $q) {
                match ($this->filter) {
                    default => null,
                };
            })
            ->latest('updated_at')
            ->paginate();

        return view('livewire.audit.index', [
            'audits' => $audits,
            'filters' => $this->filters,
            'i' => $this->getPage() * $audits->perPage(),
        ]);
    }

    public function delete(Audit $audit)
    {
        $audit->delete();

        return $this->redirectRoute('audits.index', navigate: true);
    }
}
