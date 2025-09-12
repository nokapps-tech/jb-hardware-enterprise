<?php

namespace App\Livewire\Products;

use App\Models\Product;
use Illuminate\View\View;
use Livewire\Component;
use Livewire\WithPagination;

class Index extends Component
{
    use WithPagination;

    public string $search = '';

    public function render(): View
    {
        # TODO: Add columns to search on with $search here
        $products = Product::orderBy('updated_at', 'desc')
            ->paginate();

        return view('livewire.product.index', [
            'products' => $products,
            'i' => $this->getPage() * $products->perPage(),
        ]);
    }

    public function delete(Product $product)
    {
        $product->delete();

        return $this->redirectRoute('products.index', navigate: true);
    }
}
