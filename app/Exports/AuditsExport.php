<?php

namespace App\Exports;

use App\Models\Audit;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;

class AuditsExport implements FromCollection, WithHeadings, WithMapping, ShouldAutoSize
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
        $searchTerms = collect(explode(' ', $this->search))
            ->filter()
            ->map(fn ($term) => trim($term));

        return Audit::with('user')
            ->when($this->search !== '', function (Builder $query) use ($searchTerms) {
                $query->where(function ($query) use ($searchTerms) {
                    foreach ($searchTerms as $term) {
                        $query->where(function ($q) use ($term) {
                            $q->where('event', 'like', "%{$term}%")
                            ->orWhere('auditable_type', 'like', "%{$term}%")
                            ->orWhere('auditable_id', 'like', "%{$term}%")
                            ->orWhereHas('user', fn ($q2) =>
                                $q2->where('name', 'like', "%{$term}%")
                            );
                        });
                    }
                });
            })
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
            'Summary',
            'User',
            'Event',
            'Browser',
            'System',
            'Device',
            'Created At',
        ];
    }

    /**
     * Map a Audit model to an array that matches the headings order.
     */
    public function map($audit): array
    {
        return [
            $audit->id,
            $audit->summary ?? '',
            $audit->user->name ?? '',
            $audit->event ?? '',
            $audit->browser ?? '',
            $audit->os ?? '',
            $audit->device ?? '',
            optional($audit->created_at)->format('Y-m-d H:i:s'),
        ];
    }
}
