<?php

namespace App\Livewire\Forms;

use App\Models\Product;
use Livewire\Form;

class ProductForm extends Form
{
    public ?Product $productModel;
    
    public $product_code = '';
    public $name = '';
    public $product_category_id = '';
    public $notes = '';
    public $price = '';
    public $cost = '';
    public $size = '';
    public $unit = '';
    public $quantity = '';
    public $threshold = '';

    public function rules(): array
    {
        return [
            'product_code' => 'nullable|string',
            'name' => 'required|string',
            'product_category_id' => 'required|exists:product_categories,id',
            'notes' => 'nullable|string',
            'price' => 'nullable|numeric|min:0',
            'cost' => 'nullable|numeric|min:0',
            'size' => 'nullable|string',
            'unit' => 'nullable|string',
            'quantity' => 'required|integer|min:0',
            'threshold' => 'nullable|integer|min:0',
        ];
    }

    public function setProductModel(Product $productModel): void
    {
        $this->productModel = $productModel;
        
        $this->product_code = $this->productModel->product_code;
        $this->name = $this->productModel->name;
        $this->product_category_id = $this->productModel->product_category_id;
        $this->notes = $this->productModel->notes;
        $this->price = $this->productModel->price;
        $this->cost = $this->productModel->cost;
        $this->size = $this->productModel->size;
        $this->unit = $this->productModel->unit;
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
            $this->dispatch('stock-alert', message: "{$this->productModel->name} stock is low! (Stock: {$this->productModel->quantity}, Threshold: {$this->productModel->threshold})");
        }

        $this->reset();
    }
}
