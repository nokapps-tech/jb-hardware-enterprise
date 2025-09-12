<?php

namespace App\Livewire\Transactions;

use App\Models\Transaction;
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
        $transactions = Transaction::orderBy('updated_at', 'desc')
            ->paginate();

        return view('livewire.transaction.index', [
            'transactions' => $transactions,
            'i' => $this->getPage() * $transactions->perPage(),
        ]);
    }

    public function delete(Transaction $transaction)
    {
        $transaction->delete();

        return $this->redirectRoute('transactions.index', navigate: true);
    }
}
