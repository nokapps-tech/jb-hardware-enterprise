<?php

namespace App\Livewire\Forms;

use App\Models\Product;
use Livewire\Form;

class ProductForm extends Form
{
    public ?Product $productModel;
    
    public $product_code = '';
    public $branch_id = '';
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
            'branch_id' => 'required|exists:branches,id',
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
        $this->branch_id = $this->productModel->branch_id;
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
        $this->reset();
    }
}
