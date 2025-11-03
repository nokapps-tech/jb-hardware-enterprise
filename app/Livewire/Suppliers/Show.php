<?php

namespace App\Livewire\Suppliers;

use App\Livewire\Forms\SupplierForm;
use App\Models\Supplier;
use App\Models\Transaction;
use Illuminate\Support\Facades\Auth;
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
        $user = Auth::user();

        $branchIds = $user->hasAnyRole(['system-administrator', 'developer'])
            ? null
            : $user->branches->pluck('id');

        $transactions = Transaction::where('supplier_id', $supplier->id)
            ->when($branchIds, fn($q) => $q->whereIn('branch_id', $branchIds))
            ->get();

        return view('livewire.supplier.show', [
            'supplier' => $supplier,
            'transactions' => $transactions,
        ]);
    }
}
