<?php

namespace App\Livewire\Transactions;

use App\Livewire\Forms\TransactionForm;
use App\Models\Transaction;
use Livewire\Component;

class Edit extends Component
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
        $this->form->update();

        return $this->redirectRoute('transactions.index', navigate: true);
    }

    public function render()
    {
        return view('livewire.transaction.edit', [
            'products' => Product::orderBy('name')->get(),
            'transactions' => $this->form->transactionModel,
        ]);
    }
}
