<?php

namespace App\Livewire\Transactions;

use App\Livewire\Forms\TransactionForm;
use App\Models\Transaction;
use App\Models\Branch;
use App\Models\Product;
use Livewire\Component;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class Edit extends Component
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
    
         // Populate items from transaction details if available
        $this->items = $transaction->items->map(function($item) {
            return [
                'product_id' => $item->product_id,
                'quantity'   => $item->quantity,
                'type'       => $item->type,
            ];
        })->toArray();

        // Fallback if no items exist
        if (empty($this->items)) {
            $this->items = [
                ['product_id' => '', 'quantity' => '', 'type' => '']
            ];
        }
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
            $transaction = $this->form->transactionModel;

            // Revert old stock if transaction already completed
            if ($transaction->status === 'Completed') {
                foreach ($transaction->items as $oldItem) {
                    $product = $oldItem->product;
                    if ($oldItem->type === 'In') {
                        $product->decrement('quantity', $oldItem->quantity);
                    } elseif ($oldItem->type === 'Out') {
                        $product->increment('quantity', $oldItem->quantity);
                    }
                }
            }

            // Update transaction main fields
            $transaction->update([
                'branch_id'   => $this->form->branch_id,
                'name'        => $this->form->name,
                'description' => $this->form->description,
                'notes'       => $this->form->notes,
                'order_date'  => $this->form->order_date,
                'status'      => $this->form->status,
            ]);

            // Remove old items
            $transaction->items()->delete();

            // Insert new items & update stock if needed
            foreach ($this->items as $item) {
                $transaction->items()->create([
                    'product_id' => $item['product_id'],
                    'quantity'   => $item['quantity'],
                    'type'       => $item['type'],
                ]);

                if ($transaction->status === 'Completed') {
                    $product = Product::find($item['product_id']);
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

        return view('livewire.transaction.edit', [
            'branches' => $branches,
            'products' => Product::orderBy('name')->get(),
            'transaction' => $this->form->transactionModel,
        ]);
    }
}
