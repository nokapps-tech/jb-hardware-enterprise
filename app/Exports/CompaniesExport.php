<?php

namespace App\Exports;

use App\Models\Company;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;

class CompaniesExport implements FromCollection, WithHeadings, WithMapping, ShouldAutoSize
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
        return Company::query()
            ->when($this->search, fn (Builder $q) =>
                $q->where('name', 'like', "%{$this->search}%")
                ->orWhere('industry', 'like', '%' . $this->search . '%')
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
            'Industry',
            'Website',
            'Email',
            'Phone',
            'Address',
            'Postal Code',
            'Created At',
        ];
    }

    /**
     * Map a Company model to an array that matches the headings order.
     */
    public function map($company): array
    {
        return [
            $company->id,
            $company->name ?? '',
            $company->industry ?? '',
            $company->website ?? '',
            $company->email ?? '',
            $company->phone ?? '',
            $company->address ?? '',
            $company->postal_code ?? '',
            optional($company->created_at)->format('Y-m-d H:i:s'),
        ];
    }
}
