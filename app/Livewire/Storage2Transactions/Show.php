<?php

namespace App\Livewire\Storage2Transactions;

use App\Livewire\Forms\Storage2TransactionForm;
use App\Models\Storage2Transaction;
use Livewire\Component;

class Show extends Component
{
    public Storage2TransactionForm $form;

    public function mount(Storage2Transaction $storage2Transaction)
    {
        $this->form->setStorage2TransactionModel($storage2Transaction);
    }

    public function render()
    {
        return view('livewire.storage2-transaction.show', ['storage2Transaction' => $this->form->storage2TransactionModel]);
    }
}
