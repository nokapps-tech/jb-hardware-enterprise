<?php

namespace App\Livewire\Forms;

use App\Models\ProductCategory;
use Livewire\Form;

class ProductCategoryForm extends Form
{
    public ?ProductCategory $productCategoryModel;
    
    public $name = '';
    public $notes = '';

    public function rules(): array
    {
        return [
			'name' => 'required|string',
			'notes' => 'nullable|string',
        ];
    }

    public function setProductCategoryModel(ProductCategory $productCategoryModel): void
    {
        $this->productCategoryModel = $productCategoryModel;
        
        $this->name = $this->productCategoryModel->name;
        $this->notes = $this->productCategoryModel->notes;
    }

    public function store(): void
    {
        $this->productCategoryModel->create($this->validate());

        $this->reset();
    }

    public function update(): void
    {
        $this->productCategoryModel->update($this->validate());

        $this->reset();
    }
}
