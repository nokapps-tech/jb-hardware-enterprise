<?php

namespace App\Livewire\Forms;

use App\Models\Supplier;
use Livewire\Form;

class SupplierForm extends Form
{
    public ?Supplier $supplierModel;
    
    public $company_id = '';
    public $contact_person = '';
    public $email = '';
    public $phone = '';
    public $address = '';
    public $segment = '';
    public $type = '';

    public function rules(): array
    {
        return [
            'company_id' => 'required|exists:companies,id',
			'contact_person' => 'nullable|string',
            'email' => 'nullable|string',
			'phone' => 'nullable|string',
			'address' => 'nullable|string',
			'segment' => 'nullable|string',
            'type' => 'nullable|string',
        ];
    }

    public function setSupplierModel(Supplier $supplierModel): void
    {
        $this->supplierModel = $supplierModel;
        
        $this->company_id = $this->supplierModel->company_id;
        $this->contact_person = $this->supplierModel->contact_person;
        $this->email = $this->supplierModel->email;
        $this->phone = $this->supplierModel->phone;
        $this->address = $this->supplierModel->address;
        $this->segment = $this->supplierModel->segment;
        $this->type = $this->supplierModel->type;
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
