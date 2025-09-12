<?php

namespace App\Livewire\Forms;

use App\Models\ProductCategory;
use Livewire\Form;

class ProductCategoryForm extends Form
{
    public ?ProductCategory $productCategoryModel;
    
    public $name = '';
    public $description = '';

    public function rules(): array
    {
        return [
			'name' => 'required|string',
			'description' => 'string',
        ];
    }

    public function setProductCategoryModel(ProductCategory $productCategoryModel): void
    {
        $this->productCategoryModel = $productCategoryModel;
        
        $this->name = $this->productCategoryModel->name;
        $this->description = $this->productCategoryModel->description;
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
