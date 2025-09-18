<?php

namespace App\Livewire\Storage1Transactions;

use App\Models\Storage1Transaction;
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
        $storage1Transactions = Storage1Transaction::orderBy('updated_at', 'desc')
            ->paginate();

        return view('livewire.storage1-transaction.index', [
            'storage1Transactions' => $storage1Transactions,
            'i' => $this->getPage() * $storage1Transactions->perPage(),
        ]);
    }

    public function delete(Storage1Transaction $storage1Transaction)
    {
        $storage1Transaction->delete();

        return $this->redirectRoute('storage1-transactions.index', navigate: true);
    }
}
