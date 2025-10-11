<?php

namespace App\Livewire\Dashboard;

use Livewire\Component;
use App\Models\Product;
use App\Models\Supplier;
use App\Models\User;
use App\Models\Transaction;

class Summary extends Component
{
    public $totals = [];

    public function mount()
    {
        $this->totals = [
            [
                'title' => 'Products',
                'count' => Product::count(),
                'icon'  => 'boxes',
                'route' => route('products.index'),
            ],
            [
                'title' => 'Suppliers',
                'count' => Supplier::count(),
                'icon'  => 'truck',
                'route' => route('suppliers.index'),
            ],
            [
                'title' => 'Users',
                'count' => User::count(),
                'icon'  => 'users',
                'route' => route('users.index'),
            ],
            [
                'title' => 'Transactions',
                'count' => Transaction::count(),
                'icon'  => 'arrow-right-left',
                'route' => route('transactions.index'),
            ],
        ];
    }

    public function render()
    {
        return view('livewire.dashboard.summary');
    }
}
