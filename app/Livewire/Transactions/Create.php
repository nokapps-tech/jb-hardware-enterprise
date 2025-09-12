<?php

namespace App\Livewire\Transactions;

use App\Livewire\Forms\TransactionForm;
use App\Models\Transaction;
use App\Models\Product;
use Livewire\Component;

class Create extends Component
{
    public TransactionForm $form;

    public array $types = [];
    public array $statuses = [];

    public function mount(Transaction $transaction)
    {
        $this->form->setTransactionModel($transaction);

        $this->types = Transaction::TYPES;
        $this->statuses = Transaction::STATUSES;
    }

    public function save()
    {
        $this->form->store();

        return $this->redirectRoute('transactions.index', navigate: true);
    }

    public function render()
    {
        return view('livewire.transaction.create', [
            'products' => Product::orderBy('name')->get(),
        ]);
    }
}
