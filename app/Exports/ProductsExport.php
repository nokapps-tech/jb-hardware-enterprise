<?php

namespace App\Exports;

use App\Models\Product;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;

class ProductsExport implements FromCollection, WithHeadings, WithMapping, ShouldAutoSize
{
    protected $search;
    protected $filter;

    public function __construct(string $search = '', ?string $filter = null)
    {
        $this->search = $search;
        $this->filter = $filter;
    }

    /**
     * Return the collection of products (with relations eager loaded).
     */
    public function collection(): Collection
    {
        return Product::query()
            ->when($this->search, fn($q) => $q->where('name', 'like', "%{$this->search}%"))
            ->when($this->filter, function ($q) {
                match ($this->filter) {
                    'over-threshold' => $q->whereColumn('quantity', '>', 'threshold'),
                    'low-stock'      => $q->whereColumn('quantity', '<', 'threshold')->where('quantity', '>', 0),
                    'out-of-stock'   => $q->where('quantity', 0),
                    default           => null,
                };
            })
            ->latest('updated_at')
            ->get();
    }

    /**
     * Headings for the exported sheet.
     */
    public function headings(): array
    {
        return [
            'ID',
            'Product Code',
            'Name',
            'Category',
            'Notes',
            'Price',
            'Cost',
            'Size',
            'Unit',
            'Quantity',
            'Threshold',
            'Created At',
        ];
    }

    /**
     * Map a Product model to an array that matches the headings order.
     */
    public function map($product): array
    {
        return [
            $product->id,
            $product->product_code ?? '',
            $product->name ?? '',
            $product->productCategory->name ?? '',
            $product->description ?? '',
            $product->price ?? '',
            $product->cost ?? '',
            $product->size ?? '',
            $product->unit ?? '',
            $product->quantity ?? '',
            $product->threshold ?? '',
            optional($product->created_at)->format('Y-m-d H:i:s'),
        ];
    }
}
