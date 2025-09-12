<?php

namespace App\Livewire\Suppliers;

use App\Models\Supplier;
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
        $suppliers = Supplier::orderBy('updated_at', 'desc')
            ->paginate();

        return view('livewire.supplier.index', [
            'suppliers' => $suppliers,
            'i' => $this->getPage() * $suppliers->perPage(),
        ]);
    }

    public function delete(Supplier $supplier)
    {
        $supplier->delete();

        return $this->redirectRoute('suppliers.index', navigate: true);
    }
}
