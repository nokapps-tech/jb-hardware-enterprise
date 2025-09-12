<section class="w-full">
    <div class="mb-6">
        <flux:breadcrumbs>
            <flux:breadcrumbs.item icon="home" />
            <flux:breadcrumbs.item :href="route('transactions.index')">Transactions</flux:breadcrumbs.item>
            <flux:breadcrumbs.item>{{ $transaction->id }}</flux:breadcrumbs.item>
        </flux:breadcrumbs>
    </div>

    <flux:separator />

    <div class="flex flex-col xl:justify-between xl:flex-row my-6">
        <div class="mb-6">
            <flux:heading size="xl" level="1">{{ $transaction->id }}</flux:heading>
            <flux:subheading size="lg">View details for this transaction.</flux:subheading>
        </div>
        <div class="flex items-top gap-2.5">
            <flux:button icon="pencil-square" href="{{ route('transactions.edit', $transaction->id) }}">{{ __('Edit') }}</flux:button>
            <flux:button variant="primary" :href="route('transactions.index')" icon="arrow-left">{{ __('All Transactions') }}</flux:button>
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
                                    <flux:heading size="lg" level="2">Transaction Details</flux:heading>
                                </div>
                                
                                        <div class="px-4 py-6 sm:grid sm:grid-cols-4 sm:gap-4 sm:px-0">
                                            <dt class="text-sm font-medium leading-6"><flux:text variant="strong">Transaction Number</flux:text></dt>
                                            <dd class="mt-1 text-sm leading-6 sm:col-span-3 sm:mt-0"><flux:text>{{ $transaction->transaction_number ?? 'None' }}</flux:text></dd>
                                        </div>
                                        <div class="px-4 py-6 sm:grid sm:grid-cols-4 sm:gap-4 sm:px-0">
                                            <dt class="text-sm font-medium leading-6"><flux:text variant="strong">Product Id</flux:text></dt>
                                            <dd class="mt-1 text-sm leading-6 sm:col-span-3 sm:mt-0"><flux:text>{{ $transaction->product_id ?? 'None' }}</flux:text></dd>
                                        </div>
                                        <div class="px-4 py-6 sm:grid sm:grid-cols-4 sm:gap-4 sm:px-0">
                                            <dt class="text-sm font-medium leading-6">
                                                <flux:text variant="strong">Product Name</flux:text>
                                            </dt>
                                            <dd class="mt-1 text-sm leading-6 sm:col-span-3 sm:mt-0">
                                                @if($transaction->product)
                                                    <a href="{{ route('contacts.show', $supplier->contact->id) }}" 
                                                    class="text-blue-600 hover:underline">
                                                        {{ $transaction->product->name }}
                                                    </a>
                                                @else
                                                    <flux:text>{{ $transaction->product?->name ?? 'None' }}</flux:text>
                                                @endif
                                            </dd>
                                        </div>
                                        <div class="px-4 py-6 sm:grid sm:grid-cols-4 sm:gap-4 sm:px-0">
                                            <dt class="text-sm font-medium leading-6"><flux:text variant="strong">Type</flux:text></dt>
                                            <dd class="mt-1 text-sm leading-6 sm:col-span-3 sm:mt-0"><flux:text>{{ $transaction->type ?? 'None' }}</flux:text></dd>
                                        </div>
                                        <div class="px-4 py-6 sm:grid sm:grid-cols-4 sm:gap-4 sm:px-0">
                                            <dt class="text-sm font-medium leading-6"><flux:text variant="strong">Quantity</flux:text></dt>
                                            <dd class="mt-1 text-sm leading-6 sm:col-span-3 sm:mt-0"><flux:text>{{ $transaction->quantity ?? 'None' }}</flux:text></dd>
                                        </div>
                                        <div class="px-4 py-6 sm:grid sm:grid-cols-4 sm:gap-4 sm:px-0">
                                            <dt class="text-sm font-medium leading-6"><flux:text variant="strong">Description</flux:text></dt>
                                            <dd class="mt-1 text-sm leading-6 sm:col-span-3 sm:mt-0"><flux:text>{{ $transaction->description ?? 'None' }}</flux:text></dd>
                                        </div>
                                        <div class="px-4 py-6 sm:grid sm:grid-cols-4 sm:gap-4 sm:px-0">
                                            <dt class="text-sm font-medium leading-6"><flux:text variant="strong">Notes</flux:text></dt>
                                            <dd class="mt-1 text-sm leading-6 sm:col-span-3 sm:mt-0"><flux:text>{{ $transaction->notes ?? 'None' }}</flux:text></dd>
                                        </div>
                                        <div class="px-4 py-6 sm:grid sm:grid-cols-4 sm:gap-4 sm:px-0">
                                            <dt class="text-sm font-medium leading-6"><flux:text variant="strong">Order Date</flux:text></dt>
                                            <dd class="mt-1 text-sm leading-6 sm:col-span-3 sm:mt-0"><flux:text>{{ $transaction->order_date ?? 'None' }}</flux:text></dd>
                                        </div>
                                        <div class="px-4 py-6 sm:grid sm:grid-cols-4 sm:gap-4 sm:px-0">
                                            <dt class="text-sm font-medium leading-6"><flux:text variant="strong">Status</flux:text></dt>
                                            <dd class="mt-1 text-sm leading-6 sm:col-span-3 sm:mt-0"><flux:text>{{ $transaction->status ?? 'None' }}</flux:text></dd>
                                        </div>
                                        <div class="px-4 py-6 sm:grid sm:grid-cols-4 sm:gap-4 sm:px-0">
                                            <dt class="text-sm font-medium leading-6"><flux:text variant="strong">Created By</flux:text></dt>
                                            <dd class="mt-1 text-sm leading-6 sm:col-span-3 sm:mt-0"><flux:text>{{ $transaction->created_by ?? 'None' }}</flux:text></dd>
                                        </div>

                            </dl>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>