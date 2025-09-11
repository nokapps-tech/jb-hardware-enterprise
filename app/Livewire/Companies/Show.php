<?php

namespace App\Livewire\Companies;

use App\Livewire\Forms\CompanyForm;
use App\Models\Company;
use Livewire\Component;

class Show extends Component
{
    public CompanyForm $form;

    public function mount(Company $company)
    {
        $this->form->setCompanyModel($company);
    }

    public function render()
    {
        return view('livewire.company.show', ['company' => $this->form->companyModel]);
    }
}
