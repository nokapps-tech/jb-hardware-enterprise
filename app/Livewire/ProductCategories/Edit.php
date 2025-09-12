<?php

namespace App\Livewire\ProductCategories;

use App\Livewire\Forms\ProductCategoryForm;
use App\Models\ProductCategory;
use Livewire\Component;

class Edit extends Component
{
    public ProductCategoryForm $form;

    public function mount(ProductCategory $productCategory)
    {
        $this->form->setProductCategoryModel($productCategory);
    }

    public function save()
    {
        $this->form->update();

        return $this->redirectRoute('product-categories.index', navigate: true);
    }

    public function render()
    {
        return view('livewire.product-category.edit', [
            'productCategory' => $this->form->productCategoryModel,
        ]);
    }
}
