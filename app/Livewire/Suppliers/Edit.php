<?php

namespace App\Livewire\Suppliers;

use App\Livewire\Forms\SupplierForm;
use App\Models\Supplier;
use App\Models\Company;
use Livewire\Component;

class Edit extends Component
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
        $this->form->update();

        return $this->redirectRoute('suppliers.index', navigate: true);
    }

    public function render()
    {
        return view('livewire.supplier.edit', [
            'companies' => Company::orderBy('name')->get(),
            'supplier' => $this->form->supplierModel,
        ]);
    }
}
