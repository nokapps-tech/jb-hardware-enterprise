<?php

namespace App\Livewire\Transactions;

use App\Livewire\Forms\TransactionForm;
use App\Models\Transaction;
use App\Models\Branch;
use App\Models\Product;
use App\Models\Supplier;
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
            $nextNumber = (Transaction::max('transaction_number')) + 1;
            $transaction = Transaction::create([
                'transaction_number' => $nextNumber,
                'branch_id'          => $this->form->branch_id,
                'supplier_id'        => $this->form->supplier_id,
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
        $user = Auth::user();

        if ($user->hasAnyRole(['system-administrator', 'developer'])) {
            $branches = Branch::orderBy('name')->get();
            if ($branches->count() === 1 && !$this->form->branch_id) {
                $this->form->branch_id = $branches->first()->id;
            }
        } else {
            $branches = $user->branches()->orderBy('name')->get();

            if ($branches->count() === 1 && !$this->form->branch_id) {
                $this->form->branch_id = $branches->first()->id;
            }
        }

        return view('livewire.transaction.create', [
            'branches' => $branches,
            'suppliers' => Supplier::orderBy('contact_person')->get(),
            'products' => Product::orderBy('name')->get(),
        ]);
    }
}
