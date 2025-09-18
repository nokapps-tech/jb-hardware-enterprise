<?php

namespace App\Livewire\Forms;

use App\Models\Storage1Transaction;
use Livewire\Form;

class Storage1TransactionForm extends Form
{
    public ?Storage1Transaction $storage1TransactionModel;
    
    public $transaction_number = '';
    public $supplier_id = '';
    public $product_id = '';
    public $type = '';
    public $quantity = '';
    public $description = '';
    public $notes = '';
    public $order_date = '';
    public $status = '';
    public $created_by = '';

    public function rules(): array
    {
        return [
			'transaction_number' => 'nullable',
            'supplier_id' => 'required|exists:suppliers,id',
            'product_id' => 'required|exists:products,id',
			'type' => 'required|string',
			'quantity' => 'required',
			'description' => 'nullable|string',
			'notes' => 'nullable|string',
            'order_date' => 'nullable|date',
			'status' => 'nullable|string',
            'created_by' => 'nullable|string',
        ];
    }

    public function setStorage1TransactionModel(Storage1Transaction $storage1TransactionModel): void
    {
        $this->storage1TransactionModel = $storage1TransactionModel;
        
        $this->transaction_number = $this->storage1TransactionModel->transaction_number;
        $this->supplier_id = $this->storage1TransactionModel->supplier_id;
        $this->product_id = $this->storage1TransactionModel->product_id;
        $this->type = $this->storage1TransactionModel->type;
        $this->quantity = $this->storage1TransactionModel->quantity;
        $this->description = $this->storage1TransactionModel->description;
        $this->notes = $this->storage1TransactionModel->notes;
        $this->order_date = $this->storage1TransactionModel->order_date;
        $this->status = $this->storage1TransactionModel->status;
        $this->created_by = $this->storage1TransactionModel->created_by;
    }

    public function store(): void
    {
        $this->storage1TransactionModel->create($this->validate());

        $this->reset();
    }

    public function update(): void
    {
        $this->storage1TransactionModel->update($this->validate());

        $this->reset();
    }
}
