<?php

namespace App\Exports;

use App\Models\ProductCategory;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;

class ProductCategoriesExport implements FromCollection, WithHeadings, WithMapping, ShouldAutoSize
{
    protected $search;
    protected $filter;

    public function __construct(string $search = '', ?string $filter = null)
    {
        $this->search = $search;
        $this->filter = $filter;
    }

    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection(): Collection
    {
        return ProductCategory::query()
            ->when($this->search, fn (Builder $q) =>
                $q->where('name', 'like', "%{$this->search}%")
            )
            ->when($this->filter, function (Builder $q) {
                match ($this->filter) {
                    default => null,
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
            'Name',
            'Notes',
            'Created At',
        ];
    }

    /**
     * Map a Product model to an array that matches the headings order.
     */
    public function map($productCategory): array
    {
        return [
            $productCategory->id,
            $productCategory->name ?? '',
            $productCategory->notes ?? '',
            optional($productCategory->created_at)->format('Y-m-d H:i:s'),
        ];
    }
}
