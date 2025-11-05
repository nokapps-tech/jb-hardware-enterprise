<section class="w-full space-y-6">
    {{-- Breadcrumbs --}}
    <div class="mb-6">
        <flux:breadcrumbs>
            <flux:breadcrumbs.item icon="home" />
            <flux:breadcrumbs.item :href="route('transactions.index')">Transactions</flux:breadcrumbs.item>
            <flux:breadcrumbs.item>{{ $transaction->transaction_number }}</flux:breadcrumbs.item>
        </flux:breadcrumbs>
    </div>

    <flux:separator />

    {{-- Header --}}
    <div class="flex flex-col xl:flex-row justify-between items-start xl:items-center my-6 gap-4">
        <div>
            <flux:heading size="xl" level="1">Transaction #{{ $transaction->transaction_number }}</flux:heading>
            <flux:subheading size="lg">View details for this transaction</flux:subheading>
        </div>
        <div class="flex gap-2">
            <flux:button icon="pencil-square" href="{{ route('transactions.edit', $transaction->id) }}">Edit</flux:button>
            <flux:button variant="primary" :href="route('transactions.index')" icon="arrow-left">All Transactions</flux:button>
        </div>
    </div>

    {{-- Transaction Details --}}
    <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-3 gap-6">
        <div class="p-6 bg-white dark:bg-zinc-800 rounded-xl shadow-sm border border-zinc-200 dark:border-zinc-700">
            <flux:heading size="md" class="mb-2">Branch</flux:heading>
            <p>
                @if($transaction->branch)
                    <a href="{{ route('branches.show', $transaction->branch->id) }}" class="text-blue-600 hover:underline">{{ $transaction->branch->name }}</a>
                @else
                    <span>-</span>
                @endif
            </p>
        </div>

        <div class="p-6 bg-white dark:bg-zinc-800 rounded-xl shadow-sm border border-zinc-200 dark:border-zinc-700">
            <flux:heading size="md" class="mb-2">Company</flux:heading>
            <p>
                @if($transaction->company)
                    <a href="{{ route('companies.show', $transaction->company->id) }}" class="text-blue-600 hover:underline">{{ $transaction->company->name }}</a>
                @else
                    <span>-</span>
                @endif
            </p>
        </div>

        <div class="p-6 bg-white dark:bg-zinc-800 rounded-xl shadow-sm border border-zinc-200 dark:border-zinc-700">
            <flux:heading size="md" class="mb-2">Created By</flux:heading>
            <p>
                @if($transaction->user)
                    <a href="{{ route('users.show', $transaction->user->id) }}" class="text-blue-600 hover:underline">{{ $transaction->user->name }}</a>
                @else
                    <span>-</span>
                @endif
            </p>
        </div>

        <div class="p-6 bg-white dark:bg-zinc-800 rounded-xl shadow-sm border border-zinc-200 dark:border-zinc-700">
            <flux:heading size="md" class="mb-2">Order Date</flux:heading>
            <p>{{ $transaction->order_date ?? '-' }}</p>
        </div>

        <div class="p-6 bg-white dark:bg-zinc-800 rounded-xl shadow-sm border border-zinc-200 dark:border-zinc-700">
            <flux:heading size="md" class="mb-2">Status</flux:heading>
            <span class="inline-block px-3 py-1 rounded-full text-xs font-semibold
                {{ $transaction->status === 'Completed' ? 'bg-green-100 text-green-700 dark:bg-green-700 dark:text-green-100' : 'bg-yellow-100 text-yellow-700 dark:bg-yellow-700 dark:text-yellow-100' }}">
                {{ $transaction->status ?? '-' }}
            </span>
        </div>
    </div>

    {{-- Description & Notes --}}
    <div class="grid grid-cols-1 xl:grid-cols-2 gap-6">
        <div class="p-6 bg-white dark:bg-zinc-800 rounded-xl shadow-sm border border-zinc-200 dark:border-zinc-700">
            <flux:heading size="md" class="mb-2">Description</flux:heading>
            <p>{{ $transaction->description ?? '-' }}</p>
        </div>
        <div class="p-6 bg-white dark:bg-zinc-800 rounded-xl shadow-sm border border-zinc-200 dark:border-zinc-700">
            <flux:heading size="md" class="mb-2">Notes</flux:heading>
            <p>{{ $transaction->notes ?? '-' }}</p>
        </div>
    </div>

    {{-- Items Table --}}
    <div class="p-6 bg-white dark:bg-zinc-800 rounded-xl shadow-sm border border-zinc-200 dark:border-zinc-700 overflow-x-auto">
        <flux:heading size="md" class="mb-4">Products / Items</flux:heading>
        @if($transaction->items->count())
            <table class="min-w-full divide-y divide-zinc-200 dark:divide-zinc-700">
                <thead class="bg-zinc-50 dark:bg-zinc-700">
                    <tr>
                        <th class="px-4 py-2 text-left text-xs font-medium uppercase">Product</th>
                        <th class="px-4 py-2 text-left text-xs font-medium uppercase">Type</th>
                        <th class="px-4 py-2 text-left text-xs font-medium uppercase">Quantity</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-zinc-200 dark:divide-zinc-700">
                    @foreach($transaction->items as $item)
                        @php $product = $item->product; @endphp
                        <tr>
                            <td class="px-4 py-2 text-sm">
                                @if($product)
                                    <a href="{{ route('products.show', $product->id) }}" class="text-blue-600 hover:underline">
                                        {{ $product->name ?? '-' }} - {{ $product->size ?? '-' }} - {{ $product->brand ?? '-' }}
                                    </a>
                                @else
                                    -
                                @endif
                            </td>
                            <td class="px-4 py-2 text-sm">
                                <span class="inline-block px-2 py-1 rounded-full text-xs font-semibold
                                    {{ $item->type === 'In' ? 'bg-green-100 text-green-700 dark:bg-green-700 dark:text-green-100' : 'bg-red-100 text-red-700 dark:bg-red-700 dark:text-red-100' }}">
                                    {{ $item->type ?? '-' }}
                                </span>
                            </td>
                            <td class="px-4 py-2 text-sm">{{ $item->quantity ?? '-' }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        @else
            <p>No items found for this transaction.</p>
        @endif
    </div>
</section>