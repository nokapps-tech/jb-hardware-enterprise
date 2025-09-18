<?php

namespace App\Livewire\Storage2Transactions;

use App\Models\Storage2Transaction;
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
        $storage2Transactions = Storage2Transaction::orderBy('updated_at', 'desc')
            ->paginate();

        return view('livewire.storage2-transaction.index', [
            'storage2Transactions' => $storage2Transactions,
            'i' => $this->getPage() * $storage2Transactions->perPage(),
        ]);
    }

    public function delete(Storage2Transaction $storage2Transaction)
    {
        $storage2Transaction->delete();

        return $this->redirectRoute('storage2-transactions.index', navigate: true);
    }
}
