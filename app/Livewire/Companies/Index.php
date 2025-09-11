<?php

namespace App\Livewire\Companies;

use App\Models\Company;
use Illuminate\View\View;
use Livewire\Component;
use Livewire\WithPagination;

class Index extends Component
{
    use WithPagination;

    public string $search = '';

    public function render(): View
    {
        # TODO: Add columns to search on with $search here
        $companies = Company::orderBy('updated_at', 'desc')
            ->paginate();

        return view('livewire.company.index', [
            'companies' => $companies,
            'i' => $this->getPage() * $companies->perPage(),
        ]);
    }

    public function delete(Company $company)
    {
        $company->delete();

        return $this->redirectRoute('companies.index', navigate: true);
    }
}
