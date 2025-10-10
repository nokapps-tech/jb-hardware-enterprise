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

    public function render(): View
    {
        $user = Auth::user();

        $transactions = Transaction::orderBy('updated_at', 'desc')
            ->when(!$user->hasAnyRole(['system-administrator', 'developer']), function ($query) use ($user) {
                $query->whereIn('branch_id', $user->branches->pluck('id'));
            })
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
