<?php

namespace App\Livewire\Forms;

use App\Models\Transaction;
use Livewire\Form;

class TransactionForm extends Form
{
    public ?Transaction $transactionModel;
    
    public $transaction_number = '';
    public $branch_id = '';
    public $company_id = '';
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
            'branch_id' => 'required|exists:branches,id',
            'company_id' => 'required|exists:companies,id',
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

    public function setTransactionModel(Transaction $transactionModel): void
    {
        $this->transactionModel = $transactionModel;
        
        $this->transaction_number = $this->transactionModel->transaction_number;
        $this->branch_id = $this->transactionModel->branch_id;
        $this->company_id = $this->transactionModel->company_id;
        $this->product_id = $this->transactionModel->product_id;
        $this->type = $this->transactionModel->type;
        $this->quantity = $this->transactionModel->quantity;
        $this->description = $this->transactionModel->description;
        $this->notes = $this->transactionModel->notes;
        $this->order_date = $this->transactionModel->order_date;
        $this->status = $this->transactionModel->status;
        $this->created_by = $this->transactionModel->created_by;
    }

    public function store(): void
    {
        $this->transactionModel->create($this->validate());

        $this->reset();
    }

    public function update(): void
    {
        $this->transactionModel->update($this->validate());

        $this->reset();
    }
}
