<?php

namespace App\Livewire\Dashboard;

use Livewire\Component;
use App\Models\Product;
use App\Models\Supplier;
use App\Models\User;
use App\Models\Transaction;
use App\Models\Branch;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class Summary extends Component
{
    public $totals = [];
    public $branches = [];
    public $recentTransactions = [];

    public function mount()
    {
        $user = Auth::user();

        // Summary cards
        $this->totals = [
            [
                'title'=>'Products',
                'count'=>Product::count(),
                'icon'=>'boxes',
                'route'=>route('products.index'),
                'bgColor'=>'bg-blue-50 dark:bg-blue-900',
                'textColor'=>'text-blue-500',
            ],
            [
                'title'=>'Suppliers',
                'count'=>Supplier::count(),
                'icon'=>'truck',
                'route'=>route('suppliers.index'),
                'bgColor'=>'bg-green-50 dark:bg-green-900',
                'textColor'=>'text-green-500',
            ],
            [
                'title'=>'Users',
                'count'=>User::count(),
                'icon'=>'users',
                'route'=>route('users.index'),
                'bgColor'=>'bg-purple-50 dark:bg-purple-900',
                'textColor'=>'text-purple-500',
            ],
            [
                'title'=>'Transactions',
                'count'=>Transaction::count(),
                'icon'=>'arrow-right-left',
                'route'=>route('transactions.index'),
                'bgColor'=>'bg-yellow-50 dark:bg-yellow-900',
                'textColor'=>'text-yellow-500',
            ],
            [
                'title'=>'Low Stock',
                'count'=>Product::whereColumn('quantity', '<=', 'threshold')->count(),
                'icon'=>'exclamation-triangle',
                'route'=>route('products.index',['filter'=>'low-stock']),
                'bgColor'=>'bg-red-50 dark:bg-red-900',
                'textColor'=>'text-red-500',
            ],
        ];

        // Get branches user has access to
        $branches = Branch::query();
        if(!$user->hasAnyRole(['system-administrator','developer'])){
            $branches->whereIn('id', $user->branches->pluck('id'));
        }
        $branches = $branches->get();

        // Get transactions grouped by branch
        $this->branches = Transaction::query()
            ->when(
                !$user->hasAnyRole(['system-administrator', 'developer']),
                fn($q) => $q->whereIn('branch_id', $user->branches->pluck('id'))
            )
            ->select('branch_id', DB::raw('COUNT(*) as transactions_count'))
            ->groupBy('branch_id')
            ->get()
            ->map(function ($t) {
                $branch = Branch::find($t->branch_id);
                return (object)[
                    'id' => $t->branch_id,
                    'name' => $branch?->name ?? "Branch {$t->branch_id}",
                    'transactions_count' => $t->transactions_count,
                ];
            });

        // Recent transactions
        $transactionQuery = Transaction::with(['branch','product','company','user'])->latest();
        if(!$user->hasAnyRole(['system-administrator','developer'])){
            $transactionQuery->whereIn('branch_id', $user->branches->pluck('id'));
        }
        $this->recentTransactions = $transactionQuery->take(10)->get();
    }

    public function render()
    {
        return view('livewire.dashboard.summary');
    }
}
