<?php

namespace App\Livewire\ProductCategories;

use App\Models\ProductCategory;
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
        $productCategories = ProductCategory::orderBy('updated_at', 'desc')
            ->paginate();

        return view('livewire.product-category.index', [
            'productCategories' => $productCategories,
            'i' => $this->getPage() * $productCategories->perPage(),
        ]);
    }

    public function delete(ProductCategory $productCategory)
    {
        $productCategory->delete();

        return $this->redirectRoute('product-categories.index', navigate: true);
    }
}
