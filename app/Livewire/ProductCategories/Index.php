<?php

namespace App\Livewire\ProductCategories;

use App\Models\ProductCategory;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\View\View;
use Livewire\Component;
use Livewire\WithPagination;

class Index extends Component
{
    use WithPagination;

    public string $search = '';
    public ?string $filter = null;

    /** @var array<string, string> */
    public array $filters = [];
    
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

    public function render(): View
    {
        $productCategories = ProductCategory::query()
            ->when($this->search, fn (Builder $q) =>
                $q->where('name', 'like', "%{$this->search}%")
            )
            ->when($this->filter, function (Builder $q) {
                match ($this->filter) {
                    default => null,
                };
            })
            ->latest('updated_at')
            ->paginate();

        return view('livewire.product-category.index', [
            'productCategories' => $productCategories,
            'filters' => $this->filters,
            'i' => $this->getPage() * $productCategories->perPage(),
        ]);
    }

    public function delete(ProductCategory $productCategory)
    {
        $productCategory->delete();

        return $this->redirectRoute('product-categories.index', navigate: true);
    }
}
