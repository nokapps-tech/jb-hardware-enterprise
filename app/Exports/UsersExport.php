<?php

namespace App\Exports;

use App\Models\User;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;

class UsersExport implements FromCollection, WithHeadings, WithMapping, ShouldAutoSize
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
        return User::query()
            ->when($this->search, function (Builder $q) {
                $q->where('name', 'like', "%{$this->search}%")
                ->orWhere('email', 'like', "%{$this->search}%")
                ->orWhereHas('roles', fn ($q2) => $q2->where('name', 'like', "%{$this->search}%"));
            })
            ->when($this->filter, function (Builder $q) {
                match ($this->filter) {
                    default => null,
                };
            })
            ->notMe()
            ->notSystemUsers()
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
            'Email',
            'Role',
            'Created At',
        ];
    }

    /**
     * Map a User model to an array that matches the headings order.
     */
    public function map($user): array
    {
        return [
            $user->id,
            $user->name ?? '',
            $user->email ?? '',
            $user->roles->first()->display_text ?? '',
            optional($user->created_at)->format('Y-m-d H:i:s'),
        ];
    }
}
