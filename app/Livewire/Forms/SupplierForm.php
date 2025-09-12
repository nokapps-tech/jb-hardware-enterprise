<?php

namespace App\Livewire\Forms;

use App\Models\Supplier;
use Livewire\Form;

class SupplierForm extends Form
{
    public ?Supplier $supplierModel;
    
    public $name = '';
    public $segment = '';
    public $type = '';
    public $email = '';
    public $phone = '';
    public $contact_id = '';
    public $address = '';

    public function rules(): array
    {
        return [
			'name' => 'required|string',
			'segment' => 'nullable|string',
            'type' => 'nullable|string',
			'email' => 'string',
			'phone' => 'string',
            'contact_id' => 'required|exists:contacts,id',
			'address' => 'string',
        ];
    }

    public function setSupplierModel(Supplier $supplierModel): void
    {
        $this->supplierModel = $supplierModel;
        
        $this->name = $this->supplierModel->name;
        $this->segment = $this->supplierModel->segment;
        $this->type = $this->supplierModel->type;
        $this->email = $this->supplierModel->email;
        $this->phone = $this->supplierModel->phone;
        $this->contact_id = $this->supplierModel->contact_id;
        $this->address = $this->supplierModel->address;
    }

    public function store(): void
    {
        $this->supplierModel->create($this->validate());

        $this->reset();
    }

    public function update(): void
    {
        $this->supplierModel->update($this->validate());

        $this->reset();
    }
}
