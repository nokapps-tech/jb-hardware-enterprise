<?php

namespace App\Livewire\ProductCategories;

use App\Livewire\Forms\ProductCategoryForm;
use App\Models\ProductCategory;
use Livewire\Component;

class Show extends Component
{
    public ProductCategoryForm $form;

    public function mount(ProductCategory $productCategory)
    {
        $this->form->setProductCategoryModel($productCategory);
    }

    public function render()
    {
        return view('livewire.product-category.show', ['productCategory' => $this->form->productCategoryModel]);
    }
}
