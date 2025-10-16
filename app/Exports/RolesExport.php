<?php

namespace App\Exports;

use App\Models\Role;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;

class RolesExport implements FromCollection, WithHeadings, WithMapping, ShouldAutoSize
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
        return Role::query()
            ->when($this->search, fn (Builder $q) =>
                $q->where('display_text', 'like', "%{$this->search}%")
                ->orWhere('name', 'like', '%' . $this->search . '%')
                ->orWhere('description', 'like', '%' . $this->search . '%')
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
            'Display Text',
            'Name',
            'Description',
            'Created At',
        ];
    }

    /**
     * Map a Role model to an array that matches the headings order.
     */
    public function map($role): array
    {
        return [
            $role->id,
            $role->display_text ?? '',
            $role->name ?? '',
            $role->description ?? '',
            optional($role->created_at)->format('Y-m-d H:i:s'),
        ];
    }
}
