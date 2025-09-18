<?php

namespace App\Livewire\Forms;

use App\Models\Storage2Transaction;
use Livewire\Form;

class Storage2TransactionForm extends Form
{
    public ?Storage2Transaction $storage2TransactionModel;
    
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

    public function setStorage2TransactionModel(Storage2Transaction $storage2TransactionModel): void
    {
        $this->storage2TransactionModel = $storage2TransactionModel;
        
        $this->transaction_number = $this->storage2TransactionModel->transaction_number;
        $this->supplier_id = $this->storage2TransactionModel->supplier_id;
        $this->product_id = $this->storage2TransactionModel->product_id;
        $this->type = $this->storage2TransactionModel->type;
        $this->quantity = $this->storage2TransactionModel->quantity;
        $this->description = $this->storage2TransactionModel->description;
        $this->notes = $this->storage2TransactionModel->notes;
        $this->order_date = $this->storage2TransactionModel->order_date;
        $this->status = $this->storage2TransactionModel->status;
        $this->created_by = $this->storage2TransactionModel->created_by;
    }

    public function store(): void
    {
        $this->storage2TransactionModel->create($this->validate());

        $this->reset();
    }

    public function update(): void
    {
        $this->storage2TransactionModel->update($this->validate());

        $this->reset();
    }
}
