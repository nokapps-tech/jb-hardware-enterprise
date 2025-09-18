<?php

namespace App\Livewire\Storage1Transactions;

use App\Livewire\Forms\Storage1TransactionForm;
use App\Models\Storage1Transaction;
use App\Models\Product;
use App\Models\Supplier;
use Livewire\Component;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class Edit extends Component
{
    public Storage1TransactionForm $form;

    public array $types = [];
    public array $statuses = [];

    public function mount(Storage1Transaction $storage1Transaction)
    {
        $this->form->setStorage1TransactionModel($storage1Transaction);

        $this->types = Storage1Transaction::TYPES;
        $this->statuses = Storage1Transaction::STATUSES;
    }

    public function save()
    {
        DB::beginTransaction();

        try {
            $storage1Transaction = $this->form->storage1TransactionModel;

            if ($storage1Transaction->status === 'Completed') {
                $product = $storage1Transaction->product;
                if ($storage1Transaction->type === 'In') {
                    $product->decrement('quantity', $storage1Transaction->quantity);
                } elseif ($storage1Transaction->type === 'Out') {
                    $product->increment('quantity', $storage1Transaction->quantity);
                }
            }

            $storage1Transaction->update([
                'supplier_id'        => $this->form->supplier_id,
                'product_id'         => $this->form->product_id,
                'type'               => $this->form->type,
                'quantity'           => $this->form->quantity,
                'description'        => $this->form->description,
                'notes'              => $this->form->notes,
                'order_date'         => $this->form->order_date,
                'status'             => $this->form->status,
            ]);

            if ($storage1Transaction->status === 'Completed') {
                $product = $storage1Transaction->product;
                if ($storage1Transaction->type === 'In') {
                    $product->increment('quantity', $storage1Transaction->quantity);
                } elseif ($storage1Transaction->type === 'Out') {
                    $product->decrement('quantity', $storage1Transaction->quantity);
                }
            }

            DB::commit();

            return $this->redirectRoute('storage1-transactions.index', navigate: true);
        } catch (\Throwable $e) {
            DB::rollBack();
            throw $e;
        }
    }

    public function render()
    {
        return view('livewire.storage1-transaction.edit', [
            'suppliers' => Supplier::orderBy('contact_person')->get(),
            'products' => Product::orderBy('name')->get(),
            'storage1Transaction' => $this->form->storage1TransactionModel,
        ]);
    }
}
