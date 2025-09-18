<section class="w-full">
    <div class="mb-6">
        <flux:breadcrumbs>
            <flux:breadcrumbs.item icon="home" />
            <flux:breadcrumbs.item :href="route('storage1-transactions.index')">Storage A Transactions</flux:breadcrumbs.item>
            <flux:breadcrumbs.item>{{ $storage1Transaction->id }}</flux:breadcrumbs.item>
        </flux:breadcrumbs>
    </div>

    <flux:separator />

    <div class="flex flex-col xl:justify-between xl:flex-row my-6">
        <div class="mb-6">
            <flux:heading size="xl" level="1">{{ $storage1Transaction->id }}</flux:heading>
            <flux:subheading size="lg">View details for this storage A Transaction.</flux:subheading>
        </div>
        <div class="flex items-top gap-2.5">
            <flux:button icon="pencil-square" href="{{ route('storage1-transactions.edit', $storage1Transaction->id) }}">{{ __('Edit') }}</flux:button>
            <flux:button variant="primary" :href="route('storage1-transactions.index')" icon="arrow-left">{{ __('All Storage A Transactions') }}</flux:button>
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
                                    <flux:heading size="lg" level="2">Storage A Transaction Details</flux:heading>
                                </div>
                                
                                        <div class="px-4 py-6 sm:grid sm:grid-cols-4 sm:gap-4 sm:px-0">
                                            <dt class="text-sm font-medium leading-6"><flux:text variant="strong">Transaction Number</flux:text></dt>
                                            <dd class="mt-1 text-sm leading-6 sm:col-span-3 sm:mt-0"><flux:text>{{ $storage1Transaction->transaction_number ?? 'None' }}</flux:text></dd>
                                        </div>
                                        <div class="px-4 py-6 sm:grid sm:grid-cols-4 sm:gap-4 sm:px-0">
                                            <dt class="text-sm font-medium leading-6">
                                                <flux:text variant="strong">Supplier</flux:text>
                                            </dt>
                                            <dd class="mt-1 text-sm leading-6 sm:col-span-3 sm:mt-0">
                                                @if($storage1Transaction->supplier)
                                                    <a href="{{ route('suppliers.show', $storage1Transaction->supplier->id) }}" 
                                                    class="text-blue-600 hover:underline">
                                                        {{ $storage1Transaction->supplier->contact_person }}
                                                    </a>
                                                @else
                                                    <flux:text>{{ $storage1Transaction->supplier?->contact_person ?? 'None' }}</flux:text>
                                                @endif
                                            </dd>
                                        </div>
                                        <div class="px-4 py-6 sm:grid sm:grid-cols-4 sm:gap-4 sm:px-0">
                                            <dt class="text-sm font-medium leading-6">
                                                <flux:text variant="strong">Product</flux:text>
                                            </dt>
                                            <dd class="mt-1 text-sm leading-6 sm:col-span-3 sm:mt-0">
                                                @if($storage1Transaction->product)
                                                    <a href="{{ route('products.show', $storage1Transaction->product->id) }}" 
                                                    class="text-blue-600 hover:underline">
                                                        {{ $storage1Transaction->product->name }}
                                                    </a>
                                                @else
                                                    <flux:text>{{ $storage1Transaction->product?->name ?? 'None' }}</flux:text>
                                                @endif
                                            </dd>
                                        </div>
                                        <div class="px-4 py-6 sm:grid sm:grid-cols-4 sm:gap-4 sm:px-0">
                                            <dt class="text-sm font-medium leading-6"><flux:text variant="strong">Type</flux:text></dt>
                                            <dd class="mt-1 text-sm leading-6 sm:col-span-3 sm:mt-0"><flux:text>{{ $storage1Transaction->type ?? 'None' }}</flux:text></dd>
                                        </div>
                                        <div class="px-4 py-6 sm:grid sm:grid-cols-4 sm:gap-4 sm:px-0">
                                            <dt class="text-sm font-medium leading-6"><flux:text variant="strong">Quantity</flux:text></dt>
                                            <dd class="mt-1 text-sm leading-6 sm:col-span-3 sm:mt-0"><flux:text>{{ $storage1Transaction->quantity ?? 'None' }}</flux:text></dd>
                                        </div>
                                        <div class="px-4 py-6 sm:grid sm:grid-cols-4 sm:gap-4 sm:px-0">
                                            <dt class="text-sm font-medium leading-6"><flux:text variant="strong">Description</flux:text></dt>
                                            <dd class="mt-1 text-sm leading-6 sm:col-span-3 sm:mt-0"><flux:text>{{ $storage1Transaction->description ?? 'None' }}</flux:text></dd>
                                        </div>
                                        <div class="px-4 py-6 sm:grid sm:grid-cols-4 sm:gap-4 sm:px-0">
                                            <dt class="text-sm font-medium leading-6"><flux:text variant="strong">Notes</flux:text></dt>
                                            <dd class="mt-1 text-sm leading-6 sm:col-span-3 sm:mt-0"><flux:text>{{ $storage1Transaction->notes ?? 'None' }}</flux:text></dd>
                                        </div>
                                        <div class="px-4 py-6 sm:grid sm:grid-cols-4 sm:gap-4 sm:px-0">
                                            <dt class="text-sm font-medium leading-6"><flux:text variant="strong">Order Date</flux:text></dt>
                                            <dd class="mt-1 text-sm leading-6 sm:col-span-3 sm:mt-0"><flux:text>{{ $storage1Transaction->order_date ?? 'None' }}</flux:text></dd>
                                        </div>
                                        <div class="px-4 py-6 sm:grid sm:grid-cols-4 sm:gap-4 sm:px-0">
                                            <dt class="text-sm font-medium leading-6"><flux:text variant="strong">Status</flux:text></dt>
                                            <dd class="mt-1 text-sm leading-6 sm:col-span-3 sm:mt-0"><flux:text>{{ $storage1Transaction->status ?? 'None' }}</flux:text></dd>
                                        </div>
                                        <div class="px-4 py-6 sm:grid sm:grid-cols-4 sm:gap-4 sm:px-0">
                                            <dt class="text-sm font-medium leading-6"><flux:text variant="strong">Created By</flux:text></dt>
                                            <dd class="mt-1 text-sm leading-6 sm:col-span-3 sm:mt-0">
                                                @if($storage1Transaction->user)
                                                    <a href="{{ route('users.show', $storage1Transaction->user->id) }}" 
                                                    class="text-blue-600 hover:underline">
                                                        {{ $storage1Transaction->user->name }}
                                                    </a>
                                                @else
                                                    <flux:text>{{ $storage1Transaction->user?->name ?? 'None' }}</flux:text>
                                                @endif
                                            </dd>
                                        </div>

                            </dl>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>