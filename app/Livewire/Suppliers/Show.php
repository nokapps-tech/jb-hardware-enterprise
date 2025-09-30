<?php

namespace App\Livewire\Suppliers;

use App\Livewire\Forms\SupplierForm;
use App\Models\Supplier;
use App\Models\Storage1Transaction;
use App\Models\Storage2Transaction;
use Livewire\Component;

class Show extends Component
{
    public SupplierForm $form;

    public function mount(Supplier $supplier)
    {
        $this->form->setSupplierModel($supplier);
    }

    public function render()
    {
        $supplier = $this->form->supplierModel;

        $storage1Transactions = Storage1Transaction::where('supplier_id', $supplier->id)->get();
        $storage2Transactions = Storage2Transaction::where('supplier_id', $supplier->id)->get();

        return view('livewire.supplier.show', [
            'supplier' => $supplier,
            'storage1Transactions' => $storage1Transactions,
            'storage2Transactions' => $storage2Transactions,
        ]);
    }
}
