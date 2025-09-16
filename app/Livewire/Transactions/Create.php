<?php

namespace App\Livewire\Transactions;

use App\Livewire\Forms\TransactionForm;
use App\Models\Transaction;
use App\Models\Product;
use Livewire\Component;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

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
        DB::beginTransaction();
        try {
            $transaction = Transaction::create([
                'transaction_number' => $this->form->transaction_number,
                'product_id'         => $this->form->product_id,
                'type'               => $this->form->type,
                'quantity'           => $this->form->quantity,
                'description'        => $this->form->description,
                'notes'              => $this->form->notes,
                'order_date'         => $this->form->order_date,
                'status'             => $this->form->status,
                'created_by'         => Auth::id(),
            ]);

            if ($this->form->status === 'Completed') {
                $product = $transaction->product;
                if ($this->form->type === 'In') {
                    $product->increment('quantity', $this->form->quantity);
                } elseif ($this->form->type === 'Out') {
                    $product->decrement('quantity', $this->form->quantity);
                }
            }

            DB::commit();

            return $this->redirectRoute('transactions.index', navigate: true);
        } catch (\Throwable $e) {
            DB::rollBack();
            throw $e;
        }
    }

    public function render()
    {
        return view('livewire.transaction.create', [
            'products' => Product::orderBy('name')->get(),
        ]);
    }
}
