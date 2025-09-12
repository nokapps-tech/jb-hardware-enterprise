<?php

namespace App\Livewire\Products;

use App\Livewire\Forms\ProductForm;
use App\Models\Product;
use Livewire\Component;
use App\Models\ProductCategory;

class Create extends Component
{
    public ProductForm $form;

    public function mount(Product $product)
    {
        $this->form->setProductModel($product);
    }

    public function save()
    {
        $this->form->store();

        return $this->redirectRoute('products.index', navigate: true);
    }

    public function render()
    {
        return view('livewire.product.create', [
            'product_categories' => ProductCategory::orderBy('name')->get(),
        ]);
    }
}
