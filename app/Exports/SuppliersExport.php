<?php

namespace App\Exports;

use App\Models\Supplier;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;

class SuppliersExport implements FromCollection, WithHeadings, WithMapping, ShouldAutoSize
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
        return Supplier::with('company')
            ->when($this->search, fn ($q) =>
                $q->whereHas('company', fn ($q2) => $q2->where('name', 'like', "%{$this->search}%"))
                ->orWhere('contact_person', 'like', "%{$this->search}%")
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
            'Company Name',
            'Contact Person',
            'Email',
            'Phone',
            'Address',
            'Segment',
            'Type',
            'Created At',
        ];
    }

    /**
     * Map a Supplier model to an array that matches the headings order.
     */
    public function map($supplier): array
    {
        return [
            $supplier->id,
            $supplier->company->name ?? '',
            $supplier->contact_person ?? '',
            $supplier->email ?? '',
            $supplier->phone ?? '',
            $supplier->address ?? '',
            $supplier->segment ?? '',
            $supplier->type ?? '',
            optional($supplier->created_at)->format('Y-m-d H:i:s'),
        ];
    }
}
