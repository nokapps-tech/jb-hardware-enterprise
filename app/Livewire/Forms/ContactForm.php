<?php

namespace App\Livewire\Forms;

use App\Models\Contact;
use Livewire\Form;

class ContactForm extends Form
{
    public ?Contact $contactModel;
    
    public $first_name = '';
    public $last_name = '';
    public $email = '';
    public $phone = '';
    public $company_id = '';
    public $job_title = '';

    public function rules(): array
    {
        return [
			'first_name' => 'required|string',
			'last_name' => 'required|string',
			'email' => 'string',
			'phone' => 'string',
			'job_title' => 'string',
            'company_id' => 'nullable|exists:companies,id',
        ];
    }

    public function setContactModel(Contact $contactModel): void
    {
        $this->contactModel = $contactModel;
        
        $this->first_name = $this->contactModel->first_name;
        $this->last_name = $this->contactModel->last_name;
        $this->email = $this->contactModel->email;
        $this->phone = $this->contactModel->phone;
        $this->company_id = $this->contactModel->company_id;
        $this->job_title = $this->contactModel->job_title;
    }

    public function store(): void
    {
        $this->contactModel->create($this->validate());

        $this->reset();
    }

    public function update(): void
    {
        $this->contactModel->update($this->validate());

        $this->reset();
    }
}
