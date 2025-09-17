<?php

namespace App\Livewire\Suppliers;

use App\Livewire\Forms\SupplierForm;
use App\Models\Supplier;
use App\Models\Company;
use Livewire\Component;

class Create extends Component
{
    public SupplierForm $form;
    
    public array $segments = [];
    public array $types = [];

    public function mount(Supplier $supplier)
    {
        $this->form->setSupplierModel($supplier);

        $this->segments = Supplier::SEGMENTS;
        $this->types = Supplier::TYPES;
    }

    public function save()
    {
        $this->form->store();

        return $this->redirectRoute('suppliers.index', navigate: true);
    }

    public function render()
    {
        return view('livewire.supplier.create', [
            'companies' => Company::orderBy('name')->get(),
        ]);
    }
}
