<?php

namespace App\Livewire\Companies;

use App\Models\Company;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\View\View;
use Livewire\Component;
use Livewire\WithPagination;

class Index extends Component
{
    use WithPagination;

    public string $search = '';

    public function render(): View
    {
        $companies = Company::when($this->search !== '', function (Builder $query) {
                $query->where(function ($q) {
                    $q->where('name', 'like', '%' . $this->search . '%')
                    ->orWhere('industry', 'like', '%' . $this->search . '%');
                });
            })
            ->orderBy('updated_at', 'desc')
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
