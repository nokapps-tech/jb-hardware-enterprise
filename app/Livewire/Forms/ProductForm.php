<?php

namespace App\Livewire\Forms;

use App\Models\Product;
use Livewire\Form;

class ProductForm extends Form
{
    public ?Product $productModel;
    
    public $product_code = '';
    public $sku = '';
    public $name = '';
    public $product_category_id = '';
    public $description = '';
    public $price = '';
    public $cost = '';
    public $quantity = '';
    public $threshold = '';

    public function rules(): array
    {
        return [
            'product_code' => 'required|string',
            'sku' => 'required|string',
            'name' => 'required|string',
            'product_category_id' => 'required|exists:product_categories,id',
            'description' => 'nullable|string',
            'price' => 'nullable|numeric|min:0',
            'cost' => 'nullable|numeric|min:0',
            'quantity' => 'required|integer|min:0',
            'threshold' => 'nullable|integer|min:0',
        ];
    }

    public function setProductModel(Product $productModel): void
    {
        $this->productModel = $productModel;
        
        $this->product_code = $this->productModel->product_code;
        $this->sku = $this->productModel->sku;
        $this->name = $this->productModel->name;
        $this->product_category_id = $this->productModel->product_category_id;
        $this->description = $this->productModel->description;
        $this->price = $this->productModel->price;
        $this->cost = $this->productModel->cost;
        $this->quantity = $this->productModel->quantity;
        $this->threshold = $this->productModel->threshold;
    }

    public function store(): void
    {
        $this->productModel->create($this->validate());

        $this->reset();
    }

    public function update(): void
    {
        $this->productModel->update($this->validate());
        
        // Check threshold and trigger browser event
        if ($this->productModel->quantity <= $this->productModel->threshold && $this->productModel->quantity > 0) {
            $this->dispatch('stock-alert', message: "{$this->productModel->name} stock is low! (Stock: {$this->productModel->stock}, Threshold: {$this->productModel->threshold})");
        }

        $this->reset();
    }
}
