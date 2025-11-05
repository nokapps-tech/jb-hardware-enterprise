<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Transaction;
use App\Models\TransactionItem;

class TransactionItemSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
         Transaction::withTrashed()->chunk(100, function ($transactions) {
            foreach ($transactions as $transaction) {
                // Skip if items already exist
                if ($transaction->items()->exists()) continue;

                $transaction->items()->create([
                    'product_id' => $transaction->product_id,
                    'quantity'   => $transaction->quantity,
                    'type'       => $transaction->type,
                ]);
            }
        });
    }
}
