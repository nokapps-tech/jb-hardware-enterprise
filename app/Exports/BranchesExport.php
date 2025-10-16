<?php

namespace App\Exports;

use App\Models\Branch;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Illuminate\Support\Facades\Auth;

class BranchesExport implements FromCollection, WithHeadings, WithMapping, ShouldAutoSize
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
        $user = auth()->user();

        return Branch::query()
            ->when(!$user->hasAnyRole(['system-administrator','developer']), fn($q) => 
                $q->whereIn('id', $user->branches->pluck('id'))
            )
            ->when($this->search, fn (Builder $q) =>
                $q->where('name', 'like', "%{$this->search}%")
                ->orWhere('address', 'like', '%' . $this->search . '%')
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
            'Contact Number',
            'Address',
            'Description',
            'Created At',
        ];
    }

    /**
     * Map a Branch model to an array that matches the headings order.
     */
    public function map($branch): array
    {
        return [
            $branch->id,
            $branch->name ?? '',
            $branch->contact_number ?? '',
            $branch->address ?? '',
            $branch->description ?? '',
            optional($branch->created_at)->format('Y-m-d H:i:s'),
        ];
    }
}
