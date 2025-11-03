<section class="w-full">
    <div class="mb-6">
        <flux:breadcrumbs>
            <flux:breadcrumbs.item icon="home" />
            <flux:breadcrumbs.item :href="route('suppliers.index')">Suppliers</flux:breadcrumbs.item>
            <flux:breadcrumbs.item>{{ $supplier->id }}</flux:breadcrumbs.item>
        </flux:breadcrumbs>
    </div>

    <flux:separator />

    <div class="flex flex-col xl:justify-between xl:flex-row my-6">
        <div class="mb-6">
            <flux:heading size="xl" level="1">{{ $supplier->id }}</flux:heading>
            <flux:subheading size="lg">View details for this supplier.</flux:subheading>
        </div>
        <div class="flex items-top gap-2.5">
            <flux:button icon="pencil-square" href="{{ route('suppliers.edit', $supplier->id) }}">{{ __('Edit') }}</flux:button>
            <flux:button variant="primary" :href="route('suppliers.index')" icon="arrow-left">{{ __('All Suppliers') }}</flux:button>
        </div>
    </div>

    <div class="max-w-full mx-auto space-y-6 pb-12">
        <div class="p-4 sm:p-8 border border-zinc-200 dark:border-zinc-700 sm:rounded-lg">
            <div class="w-full">
                <div class="flow-root">
                    <div class="overflow-x-auto">
                        <div class="inline-block min-w-full px-1 py-2 align-middle">
                            <dl>
                                <div class="px-4 pb-6 sm:px-0">
                                    <flux:heading size="lg" level="2">Supplier Details</flux:heading>
                                </div>
                                        <div class="px-4 py-6 sm:grid sm:grid-cols-4 sm:gap-4 sm:px-0">
                                            <dt class="text-sm font-medium leading-6">
                                                <flux:text variant="strong">Company Name</flux:text>
                                            </dt>
                                            <dd class="mt-1 text-sm leading-6 sm:col-span-3 sm:mt-0">
                                                @if($supplier->company)
                                                    <a href="{{ route('companies.show', $supplier->company->id) }}" 
                                                    class="text-blue-600 hover:underline">
                                                        {{ $supplier->company->name }}
                                                    </a>
                                                @else
                                                    <flux:text>{{ $supplier->company?->name ?? 'None' }}</flux:text>
                                                @endif
                                            </dd>
                                        </div>
                                        <div class="px-4 py-6 sm:grid sm:grid-cols-4 sm:gap-4 sm:px-0">
                                            <dt class="text-sm font-medium leading-6"><flux:text variant="strong">Contact Person</flux:text></dt>
                                            <dd class="mt-1 text-sm leading-6 sm:col-span-3 sm:mt-0"><flux:text>{{ $supplier->contact_person ?? 'None' }}</flux:text></dd>
                                        </div>
                                        <div class="px-4 py-6 sm:grid sm:grid-cols-4 sm:gap-4 sm:px-0">
                                            <dt class="text-sm font-medium leading-6"><flux:text variant="strong">Email</flux:text></dt>
                                            <dd class="mt-1 text-sm leading-6 sm:col-span-3 sm:mt-0"><flux:text>{{ $supplier->email ?? 'None' }}</flux:text></dd>
                                        </div>
                                        <div class="px-4 py-6 sm:grid sm:grid-cols-4 sm:gap-4 sm:px-0">
                                            <dt class="text-sm font-medium leading-6"><flux:text variant="strong">Phone</flux:text></dt>
                                            <dd class="mt-1 text-sm leading-6 sm:col-span-3 sm:mt-0"><flux:text>{{ $supplier->phone ?? 'None' }}</flux:text></dd>
                                        </div>
                                        <div class="px-4 py-6 sm:grid sm:grid-cols-4 sm:gap-4 sm:px-0">
                                            <dt class="text-sm font-medium leading-6"><flux:text variant="strong">Address</flux:text></dt>
                                            <dd class="mt-1 text-sm leading-6 sm:col-span-3 sm:mt-0"><flux:text>{{ $supplier->address ?? 'None' }}</flux:text></dd>
                                        </div>
                                        <div class="px-4 py-6 sm:grid sm:grid-cols-4 sm:gap-4 sm:px-0">
                                            <dt class="text-sm font-medium leading-6"><flux:text variant="strong">Segment</flux:text></dt>
                                            <dd class="mt-1 text-sm leading-6 sm:col-span-3 sm:mt-0"><flux:text>{{ $supplier->segment ?? 'None' }}</flux:text></dd>
                                        </div>
                                        <div class="px-4 py-6 sm:grid sm:grid-cols-4 sm:gap-4 sm:px-0">
                                            <dt class="text-sm font-medium leading-6"><flux:text variant="strong">Type</flux:text></dt>
                                            <dd class="mt-1 text-sm leading-6 sm:col-span-3 sm:mt-0"><flux:text>{{ $supplier->type ?? 'None' }}</flux:text></dd>
                                        </div>

                            </dl>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
{{-- Transactions --}}
<div class="p-4 sm:p-8 border border-zinc-200 dark:border-zinc-700 sm:rounded-lg mt-6">
    <div class="px-4 pb-6 sm:px-0">
        <flux:heading size="lg" level="2">Transactions</flux:heading>
    </div>
    <table class="min-w-full divide-y divide-zinc-200 dark:divide-zinc-700">
        <thead class="bg-zinc-50 dark:bg-zinc-800">
            <tr>
                <th class="px-4 py-2 text-left text-sm font-semibold">Transaction Number</th>
                <th class="px-4 py-2 text-left text-sm font-semibold">Branch</th>
                <th class="px-4 py-2 text-left text-sm font-semibold">Date</th>
                <th class="px-4 py-2 text-left text-sm font-semibold">Product</th>
                <th class="px-4 py-2 text-left text-sm font-semibold">Type</th>
                <th class="px-4 py-2 text-left text-sm font-semibold">Quantity</th>
                <th class="px-4 py-2 text-left text-sm font-semibold">Status</th>
            </tr>
        </thead>
        <tbody>
            @forelse($transactions as $index => $transaction)
                <tr>
                    <td class="px-4 py-2">{{ $index + 1 }}</td>
                    <td class="px-4 py-2">
                        @if($transaction->branch)
                            <a href="{{ route('branches.show', $transaction->branch->id) }}" class="text-blue-600 hover:underline">
                                {{ $transaction->branch->name }}
                            </a>
                        @else
                            <span class="text-gray-400">—</span>
                        @endif
                    </td>
                    <td class="px-4 py-2">{{ $transaction->created_at->format('M d, Y') }}</td>
                    <td class="px-4 py-2">
                        @if($transaction->product)
                            <a href="{{ route('products.show', $transaction->product->id) }}" class="text-blue-600 hover:underline">
                                {{ $transaction->product->name }}
                            </a>
                        @else
                            <span class="text-gray-400">—</span>
                        @endif
                    </td>
                    <td class="px-4 py-2">{{ $transaction->type ?? '-' }}</td>
                    <td class="px-4 py-2">{{ $transaction->quantity ?? '-' }}</td>
                    <td class="px-4 py-2">{{ $transaction->status ?? '-' }}</td>
                </tr>
            @empty
                <tr>
                    <td colspan="4" class="px-4 py-4 text-center text-sm text-zinc-500">No transactions found.</td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>

</section>