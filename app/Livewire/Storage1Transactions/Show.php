<?php

namespace App\Livewire\Storage1Transactions;

use App\Livewire\Forms\Storage1TransactionForm;
use App\Models\Storage1Transaction;
use Livewire\Component;

class Show extends Component
{
    public Storage1TransactionForm $form;

    public function mount(Storage1Transaction $storage1Transaction)
    {
        $this->form->setStorage1TransactionModel($storage1Transaction);
    }

    public function render()
    {
        return view('livewire.storage1-transaction.show', ['storage1Transaction' => $this->form->storage1TransactionModel]);
    }
}
