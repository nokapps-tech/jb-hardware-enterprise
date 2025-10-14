<?php

namespace App\Livewire\Products;

use App\Models\Product;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\View\View;
use Livewire\Component;
use Livewire\WithPagination;

class Index extends Component
{
    use WithPagination;

    public string $search = '';
    public ?string $filter = null;

    public function mount()
    {
        $this->filter = request()->query('filter');
    }


    public function render(): View
    {
        $products = Product::query()
            ->when($this->search !== '', function (Builder $query) {
                $query->where('name', 'like', '%'.$this->search.'%');
            })
            ->when($this->filter === 'low-stock', function (Builder $query) {
                $query->whereColumn('quantity', '<', 'threshold');
            })
            ->orderBy('updated_at', 'desc')
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
