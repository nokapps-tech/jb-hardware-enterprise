<?php

namespace App\Livewire\ProductCategories;

use App\Livewire\Forms\ProductCategoryForm;
use App\Models\ProductCategory;
use Livewire\Component;

class Create extends Component
{
    public ProductCategoryForm $form;

    public function mount(ProductCategory $productCategory)
    {
        $this->form->setProductCategoryModel($productCategory);
    }

    public function save()
    {
        $this->form->store();

        return $this->redirectRoute('product-categories.index', navigate: true);
    }

    public function render()
    {
        return view('livewire.product-category.create');
    }
}
