<?php

namespace App\Livewire\Transactions;

use App\Models\Transaction;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\View\View;
use Livewire\Component;
use Livewire\WithPagination;
use Illuminate\Support\Facades\Auth;
use App\Exports\TransactionsExport;
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
        $filename = 'transactions_export_' . now()->format('Y-m-d_His') . '.xlsx';
        return Excel::download(new TransactionsExport($this->search, $this->filter), $filename);
    }

    public function render(): View
    {
        $user = Auth::user();
        $searchTerms = explode(' ', $this->search);
        $transactions = Transaction::query()
            ->when(!$user->hasAnyRole(['system-administrator', 'developer']), function ($query) use ($user) {
                $query->whereIn('branch_id', $user->branches->pluck('id'));
            })
            ->when($this->search, function (Builder $q) use ($searchTerms) {
                $q->where(function ($query) use ($searchTerms) {
                    foreach ($searchTerms as $term) {
                        $query->where(function ($q2) use ($term) {
                            $q2->where('id', 'like', "%{$term}%")
                            ->orWhere('description', 'like', "%{$term}%")
                            ->orWhere('notes', 'like', "%{$term}%")
                            ->orWhere('order_date', 'like', "%{$term}%")
                            ->orWhere('status', 'like', "%{$term}%")
                            ->orWhereHas('branch', fn($q3) => $q3->where('name', 'like', "%{$term}%"))
                            ->orWhereHas('company', fn($q3) => $q3->where('name', 'like', "%{$term}%"))
                            ->orWhereHas('items.product', function ($q3) use ($term) {
                                $q3->whereRaw("CONCAT(name, ' - ', size, ' - ', brand) LIKE ?", ["%{$term}%"]);
                            })
                            ->orWhereHas('user', fn($q3) => $q3->where('name', 'like', "%{$term}%"));
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

        return view('livewire.transaction.index', [
            'transactions' => $transactions,
            'filters' => $this->filters,
            'i' => $this->getPage() * $transactions->perPage(),
        ]);
    }

    public function delete(Transaction $transaction)
    {
        // Only revert stock if the transaction is completed
        if ($transaction->status === 'Completed') {
            foreach ($transaction->items as $item) {
                $product = $item->product;

                if ($item->type === 'In') {
                    // Revert an incoming transaction
                    $product->decrement('quantity', $item->quantity);
                } elseif ($item->type === 'Out') {
                    // Revert an outgoing transaction
                    $product->increment('quantity', $item->quantity);
                }
            }
        }
        $transaction->delete();

        return $this->redirectRoute('transactions.index', navigate: true);
    }
}
