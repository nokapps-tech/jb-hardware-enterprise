<?php

namespace App\Livewire\Storage1Transactions;

use App\Livewire\Forms\Storage1TransactionForm;
use App\Models\Storage1Transaction;
use App\Models\Product;
use App\Models\Supplier;
use Livewire\Component;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class Create extends Component
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
            $nextNumber = (Storage1Transaction::max('transaction_number')) + 1;
            $storage1Transaction = Storage1Transaction::create([
                'transaction_number' => $nextNumber,
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
                $product = $storage1Transaction->product;
                if ($this->form->type === 'In') {
                    $product->increment('quantity', $this->form->quantity);
                } elseif ($this->form->type === 'Out') {
                    $product->decrement('quantity', $this->form->quantity);
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
        return view('livewire.storage1-transaction.create', [
            'suppliers' => Supplier::orderBy('contact_person')->get(),
            'products' => Product::orderBy('name')->get(),
        ]);
    }
}
