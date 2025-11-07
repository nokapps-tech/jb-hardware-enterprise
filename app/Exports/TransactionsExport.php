<?php

namespace App\Exports;

use App\Models\Transaction;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;

class TransactionsExport implements FromCollection, WithHeadings, WithMapping, ShouldAutoSize
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
        $user = Auth::user();
        $searchTerms = explode(' ', $this->search);
        $transactions = Transaction::query()
            ->when(!$user->hasAnyRole(['system-administrator', 'developer']), function ($query) use ($user) {
                $query->whereIn('branch_id', $user->branches->pluck('id'));
            })
            ->when($this->search, function (Builder $q) use ($searchTerms) {
                $q->where(function ($query) use ($searchTerms) {
                    foreach ($searchTerms as $term) {
                        $query->where(function ($q2) use ($term) {
                            $q2->where('id', 'like', "%{$term}%")
                            ->orWhere('description', 'like', "%{$term}%")
                            ->orWhere('notes', 'like', "%{$term}%")
                            ->orWhere('order_date', 'like', "%{$term}%")
                            ->orWhere('status', 'like', "%{$term}%")
                            ->orWhereHas('branch', fn($q3) => $q3->where('name', 'like', "%{$term}%"))
                            ->orWhereHas('company', fn($q3) => $q3->where('name', 'like', "%{$term}%"))
                            ->orWhereHas('items.product', function ($q3) use ($term) {
                                $q3->whereRaw("CONCAT(name, ' - ', size, ' - ', brand) LIKE ?", ["%{$term}%"]);
                            })
                            ->orWhereHas('user', fn($q3) => $q3->where('name', 'like', "%{$term}%"));
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

        $rows = collect();
        foreach ($transactions as $transaction) {
            foreach ($transaction->items as $item) {
                $rows->push([
                    'transaction' => $transaction,
                    'item' => $item,
                ]);
            }
        }

        return $rows;
    }

    /**
     * Headings for the exported sheet.
     */
    public function headings(): array
    {
        return [
            'Transaction ID',
            'Transaction Number',
            'Branch Name',
            'Name',
            'Product Name',
            'Product Size',
            'Product Brand',
            'Type',          // In / Out
            'Quantity',
            'Description',
            'Notes',
            'Order Date',
            'Status',
            'Created By',
            'Created At',
        ];
    }


    /**
     * Map a Transaction model to an array that matches the headings order.
     */
    public function map($row): array
    {
        $transaction = $row['transaction'];
        $item = $row['item'];
        $product = $item->product;

        return [
            $transaction->id,
            $transaction->transaction_number ?? '',
            $transaction->branch?->name ?? '',
            $transaction->name ?? '',
            $product?->name ?? '',
            $product?->size ?? '',
            $product?->brand ?? '',
            $item->type ?? '',
            $item->quantity ?? '',
            $transaction->description ?? '',
            $transaction->notes ?? '',
            $transaction->order_date ?? '',
            $transaction->status ?? '',
            $transaction->user?->name ?? '',
            optional($transaction->created_at)->format('Y-m-d H:i:s'),
        ];
    }

}
