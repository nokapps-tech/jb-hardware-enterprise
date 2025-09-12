<?php

namespace App\Livewire\Companies;

use App\Livewire\Forms\CompanyForm;
use App\Models\Company;
use Livewire\Component;

class Edit extends Component
{
    public CompanyForm $form;

    public function mount(Company $company)
    {
        $this->form->setCompanyModel($company);
    }

    public function save()
    {
        $this->form->update();

        return $this->redirectRoute('companies.index', navigate: true);
    }

    public function render()
    {
        return view('livewire.company.edit', [
            'company' => $this->form->companyModel,
        ]);
    }
}
