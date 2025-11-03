<?php

namespace App\Livewire\Products;

use App\Models\Product;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\View\View;
use Livewire\Component;
use Livewire\WithPagination;
use App\Exports\ProductsExport;
use Maatwebsite\Excel\Facades\Excel;
use Symfony\Component\HttpFoundation\BinaryFileResponse;

class Index extends Component
{
    use WithPagination;

    public string $search = '';
    public ?string $filter = null;

    /** @var array<string, string> */
    public array $filters = [
        'over-threshold' => 'Over Threshold',
        'low-stock' => 'Low Stock',
        'out-of-stock' => 'Out of Stock',
    ];

    protected $queryString = [
        'filter' => ['except' => null],
        'search' => ['except' => ''],
    ];

    public function setFilter(?string $value)
    {
        $this->filter = $value;
        $this->resetPage();

        $this->dispatch('close-filter-dropdown');
    }


    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function updatingFilter()
    {
        $this->resetPage();
    }

    public function mount()
    {
        $this->filter = request()->query('filter', $this->filter);
    }

    public function export(): BinaryFileResponse
    {
        $filename = 'products_export_' . now()->format('Y-m-d_His') . '.xlsx';
        return Excel::download(new ProductsExport($this->search, $this->filter), $filename);
    }

    public function render(): View
    {
        $products = Product::query()
            ->when($this->search, function (Builder $q) {
                $search = $this->search;
                $q->where(function (Builder $q) use ($search) {
                    $q->where('name', 'like', "%{$search}%")
                    ->orWhere('product_code', 'like', "%{$search}%")
                    ->orWhere('brand', 'like', "%{$search}%")
                    ->orWhere('size', 'like', "%{$search}%")
                    ->orWhereHas('productCategory', function (Builder $q) use ($search) {
                        $q->where('name', 'like', "%{$search}%");
                    })
                    ->orWhereHas('branch', function (Builder $q) use ($search) {
                        $q->where('name', 'like', "%{$search}%");
                    });
                });
            })
            ->when($this->filter, function (Builder $q) {
                match ($this->filter) {
                    'over-threshold' => $q->whereColumn('quantity', '>', 'threshold'),
                    'low-stock'      => $q->whereColumn('quantity', '<', 'threshold')->where('quantity', '>', 0),
                    'out-of-stock'   => $q->where('quantity', 0),
                    default           => null,
                };
            })
            ->latest('updated_at')
            ->paginate();

        return view('livewire.product.index', [
            'products' => $products,
            'filters' => $this->filters,
            'i' => $this->getPage() * $products->perPage(),
        ]);
    }


    public function delete(Product $product)
    {
        $product->delete();

        return $this->redirectRoute('products.index', navigate: true);
    }
}
