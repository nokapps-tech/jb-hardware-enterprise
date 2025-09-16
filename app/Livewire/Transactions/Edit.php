<?php

namespace App\Livewire\Transactions;

use App\Livewire\Forms\TransactionForm;
use App\Models\Transaction;
use App\Models\Product;
use Livewire\Component;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

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
        DB::beginTransaction();

        try {
            $transaction = $this->form->transactionModel;

            if ($transaction->status === 'Completed') {
                $product = $transaction->product;
                if ($transaction->type === 'In') {
                    $product->decrement('quantity', $transaction->quantity);
                } elseif ($transaction->type === 'Out') {
                    $product->increment('quantity', $transaction->quantity);
                }
            }

            $transaction->update([
                'transaction_number' => $this->form->transaction_number,
                'product_id'         => $this->form->product_id,
                'type'               => $this->form->type,
                'quantity'           => $this->form->quantity,
                'description'        => $this->form->description,
                'notes'              => $this->form->notes,
                'order_date'         => $this->form->order_date,
                'status'             => $this->form->status,
            ]);

            if ($transaction->status === 'Completed') {
                $product = $transaction->product;
                if ($transaction->type === 'In') {
                    $product->increment('quantity', $transaction->quantity);
                } elseif ($transaction->type === 'Out') {
                    $product->decrement('quantity', $transaction->quantity);
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
        return view('livewire.transaction.edit', [
            'products' => Product::orderBy('name')->get(),
            'transaction' => $this->form->transactionModel,
        ]);
    }
}
