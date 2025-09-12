<?php

namespace App\Livewire\Products;

use App\Livewire\Forms\ProductForm;
use App\Models\Product;
use Livewire\Component;

class Show extends Component
{
    public ProductForm $form;

    public function mount(Product $product)
    {
        $this->form->setProductModel($product);
    }

    public function render()
    {
        return view('livewire.product.show', ['product' => $this->form->productModel]);
    }
}
