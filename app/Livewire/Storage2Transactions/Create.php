<?php

namespace App\Livewire\Storage2Transactions;

use App\Livewire\Forms\Storage2TransactionForm;
use App\Models\Storage2Transaction;
use App\Models\Product;
use App\Models\Supplier;
use Livewire\Component;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class Create extends Component
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
            $nextNumber = (Storage2Transaction::max('transaction_number')) + 1;
            $storage2Transaction = Storage2Transaction::create([
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
                $product = $storage2Transaction->product;
                if ($this->form->type === 'In') {
                    $product->increment('quantity', $this->form->quantity);
                } elseif ($this->form->type === 'Out') {
                    $product->decrement('quantity', $this->form->quantity);
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
        return view('livewire.storage2-transaction.create', [
            'suppliers' => Supplier::orderBy('contact_person')->get(),
            'products' => Product::orderBy('name')->get(),
        ]);
    }
}
