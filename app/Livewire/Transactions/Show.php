<?php

namespace App\Livewire\Transactions;

use App\Livewire\Forms\TransactionForm;
use App\Models\Transaction;
use Livewire\Component;

class Show extends Component
{
    public TransactionForm $form;

    public function mount(Transaction $transaction)
    {
        $this->form->setTransactionModel($transaction);
    }

    public function render()
    {
        return view('livewire.transaction.show', ['transaction' => $this->form->transactionModel]);
    }
}
