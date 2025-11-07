<?php

namespace App\Livewire\Transactions;

use App\Livewire\Forms\TransactionForm;
use App\Models\Transaction;
use App\Models\Branch;
use App\Models\Product;
use Livewire\Component;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class Create extends Component
{
    public TransactionForm $form;

    public array $items = [];

    public array $types = [];
    public array $statuses = [];

    public function mount(Transaction $transaction)
    {
        $this->form->setTransactionModel($transaction);

        $this->types = Transaction::TYPES;
        $this->statuses = Transaction::STATUSES;

        $this->items = [
            ['product_id' => '', 'quantity' => '', 'type' => '']
        ];
    }

    public function addItem()
    {
        $this->items[] = ['product_id' => '', 'quantity' => '', 'type' => ''];
    }

    public function removeItem($index)
    {
        unset($this->items[$index]);
        $this->items = array_values($this->items);
    }

    public function save()
    {
        DB::beginTransaction();

        try {
            $nextNumber = (Transaction::withTrashed()->max('transaction_number') ?? 0) + 1;

            // Create the main transaction
            $transaction = Transaction::create([
                'transaction_number' => $nextNumber,
                'branch_id'          => $this->form->branch_id,
                'name'               => $this->form->name,
                'description'        => $this->form->description,
                'notes'              => $this->form->notes,
                'order_date'         => $this->form->order_date,
                'status'             => $this->form->status,
                'created_by'         => Auth::id(),
            ]);

            // Loop through each item
            foreach ($this->items as $item) {
                $transactionItem = $transaction->items()->create($item);

                // Update stock if transaction completed
                if ($this->form->status === 'Completed') {
                    $product = $transactionItem->product;
                    if ($item['type'] === 'In') {
                        $product->increment('quantity', $item['quantity']);
                    } elseif ($item['type'] === 'Out') {
                        $product->decrement('quantity', $item['quantity']);
                    }
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
            'products' => Product::orderBy('name')->get(),
        ]);
    }
}
