<?php

namespace App\Livewire\Storage2Transactions;

use App\Livewire\Forms\Storage2TransactionForm;
use App\Models\Storage2Transaction;
use App\Models\Product;
use App\Models\Supplier;
use Livewire\Component;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class Edit extends Component
{
    public Storage2TransactionForm $form;

    public array $types = [];
    public array $statuses = [];

    public function mount(Storage2Transaction $storage2Transaction)
    {
        $this->form->setStorage2TransactionModel($storage2Transaction);

        $this->types = Storage2Transaction::TYPES;
        $this->statuses = Storage2Transaction::STATUSES;
    }

    public function save()
    {
       DB::beginTransaction();

        try {
            $storage2Transaction = $this->form->storage2TransactionModel;

            if ($storage2Transaction->status === 'Completed') {
                $product = $storage2Transaction->product;
                if ($storage2Transaction->type === 'In') {
                    $product->decrement('quantity', $storage2Transaction->quantity);
                } elseif ($storage2Transaction->type === 'Out') {
                    $product->increment('quantity', $storage2Transaction->quantity);
                }
            }

            $storage2Transaction->update([
                'product_id'         => $this->form->product_id,
                'type'               => $this->form->type,
                'quantity'           => $this->form->quantity,
                'description'        => $this->form->description,
                'notes'              => $this->form->notes,
                'order_date'         => $this->form->order_date,
                'status'             => $this->form->status,
            ]);

            if ($storage2Transaction->status === 'Completed') {
                $product = $storage2Transaction->product;
                if ($storage2Transaction->type === 'In') {
                    $product->increment('quantity', $storage2Transaction->quantity);
                } elseif ($storage2Transaction->type === 'Out') {
                    $product->decrement('quantity', $storage2Transaction->quantity);
                }
            }

            DB::commit();

            return $this->redirectRoute('storage2-transactions.index', navigate: true);
        } catch (\Throwable $e) {
            DB::rollBack();
            throw $e;
        }
    }

    public function render()
    {
        return view('livewire.storage2-transaction.edit', [
            'suppliers' => Supplier::orderBy('contact_person')->get(),
            'products' => Product::orderBy('name')->get(),
            'storage2Transaction' => $this->form->storage2TransactionModel,
        ]);
    }
}
