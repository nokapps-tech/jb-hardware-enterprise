<?php

namespace App\Livewire\Forms;

use App\Models\Company;
use Livewire\Form;

class CompanyForm extends Form
{
    public ?Company $companyModel;
    
    public $name = '';
    public $industry = '';
    public $website = '';
    public $email = '';
    public $phone = '';
    public $address = '';
    public $postal_code = '';

    public function rules(): array
    {
        return [
			'name' => 'required|string',
			'industry' => 'nullable|string',
			'website' => 'nullable|string',
			'email' => 'nullable|string',
			'phone' => 'nullable|string',
			'address' => 'nullable|string',
			'postal_code' => 'nullable|string',
        ];
    }

    public function setCompanyModel(Company $companyModel): void
    {
        $this->companyModel = $companyModel;
        
        $this->name = $this->companyModel->name;
        $this->industry = $this->companyModel->industry;
        $this->website = $this->companyModel->website;
        $this->email = $this->companyModel->email;
        $this->phone = $this->companyModel->phone;
        $this->address = $this->companyModel->address;
        $this->postal_code = $this->companyModel->postal_code;
    }

    public function store(): void
    {
        $this->companyModel->create($this->validate());

        $this->reset();
    }

    public function update(): void
    {
        $this->companyModel->update($this->validate());

        $this->reset();
    }
}
