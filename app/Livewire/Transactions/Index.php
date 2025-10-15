<?php

namespace App\Livewire\Transactions;

use App\Models\Transaction;
use Illuminate\View\View;
use Livewire\Component;
use Livewire\WithPagination;
use Illuminate\Support\Facades\Auth;

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

    public function render(): View
    {
        $user = Auth::user();
        $transactions = Transaction::query()
            ->when(!$user->hasAnyRole(['system-administrator', 'developer']), function ($query) use ($user) {
                $query->whereIn('branch_id', $user->branches->pluck('id'));
            })
            ->when($this->search, fn (Builder $q) =>
                $q->where('name', 'like', "%{$this->search}%")
            )
            ->when($this->filter, function (Builder $q) {
                match ($this->filter) {
                    default => null,
                };
            })
            ->latest('updated_at')
            ->paginate();

        return view('livewire.transaction.index', [
            'transactions' => $transactions,
            'filters' => $this->filters,
            'i' => $this->getPage() * $transactions->perPage(),
        ]);
    }

    public function delete(Transaction $transaction)
    {
        $transaction->delete();

        return $this->redirectRoute('transactions.index', navigate: true);
    }
}
