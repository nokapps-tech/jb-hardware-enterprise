<?php

namespace App\Livewire\Forms;

use App\Models\Branch;
use Livewire\Form;

class BranchForm extends Form
{
    public ?Branch $branchModel;
    
    public $name = '';
    public $contact_number = '';
    public $address = '';
    public $description = '';

    public function rules(): array
    {
        return [
			'name' => 'string',
			'contact_number' => 'string',
			'address' => 'string',
			'description' => 'string',
        ];
    }

    public function setBranchModel(Branch $branchModel): void
    {
        $this->branchModel = $branchModel;
        
        $this->name = $this->branchModel->name;
        $this->contact_number = $this->branchModel->contact_number;
        $this->address = $this->branchModel->address;
        $this->description = $this->branchModel->description;
    }

    public function store(): void
    {
        $this->branchModel->create($this->validate());

        $this->reset();
    }

    public function update(): void
    {
        $this->branchModel->update($this->validate());

        $this->reset();
    }
}
