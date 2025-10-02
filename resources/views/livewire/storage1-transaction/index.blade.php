<section class="w-full">
    @section('title', 'Storage A Transactions')

    <div class="mb-6">
        <flux:breadcrumbs>
            <flux:breadcrumbs.item icon="home" />
            <flux:breadcrumbs.item>Storage A Transactions</flux:breadcrumbs.item>
        </flux:breadcrumbs>
    </div>

    <flux:separator />

    <div class="flex flex-col xl:justify-between xl:flex-row my-6">
        <div class="mb-6">
            <flux:heading size="xl" level="1">{{ __('Storage A Transactions') }}</flux:heading>
            <flux:subheading size="lg">View and manage all storage A Transactions.</flux:subheading>
        </div>
        <div class="flex items-top gap-2.5">
            @can('admin.storage1Transactions.import')
                <flux:button icon="arrow-down-tray" tooltip="Feature preview only. This feature is under active development.">{{ __('Import') }}</flux:button>
            @endcan
            @can('admin.storage1Transactions.export')
                <flux:button icon="arrow-up-tray" tooltip="Feature preview only. This feature is under active development.">{{ __('Export') }}</flux:button>
            @endcan
            @can('admin.storage1Transactions.create')
                <flux:button variant="primary" :href="route('storage1-transactions.create')" icon="plus">{{ __('Add New') }}</flux:button>
            @endcan
        </div>
    </div>

    <div class="max-w-full mx-auto space-y-6 pb-12">
        <div class="p-4 sm:p-8 border border-zinc-200 dark:border-zinc-700 sm:rounded-lg">
            <div class="w-full">
                <div class="flow-root">
                    <div class="overflow-x-auto">
                        <div class="mx-2 mt-2 mb-4 flex flex-col md:flex-row gap-3 justify-between">
                            <div class="w-full max-w-xs">
                                <flux:input wire:model.live="search" icon="magnifying-glass" placeholder="Search storage1Transactions"/>
                            </div>
                            <div>
                                <!-- <flux:button variant="ghost" icon="funnel" icon:variant="outline" tooltip="Feature preview only. This feature is under active development.">Filters</flux:button>
                                <flux:button variant="ghost" icon="adjustments-horizontal" icon:variant="outline" tooltip="Feature preview only. This feature is under active development.">Edit columns</flux:button>     -->
                            </div>
                        </div>
                        <div class="inline-block min-w-full py-2 align-middle">
                            <table class="w-full divide-y divide-zinc-300 dark:divide-zinc-600">
                                <thead>
                                <tr>
                                    										<th scope="col" class="px-3 py-3 text-left text-xs font-semibold uppercase tracking-wide"><flux:text variant="subtle" class="text-xs">Transaction Number</flux:text></th>
										<th scope="col" class="px-3 py-3 text-left text-xs font-semibold uppercase tracking-wide"><flux:text variant="subtle" class="text-xs">Supplier</flux:text></th>
										<th scope="col" class="px-3 py-3 text-left text-xs font-semibold uppercase tracking-wide"><flux:text variant="subtle" class="text-xs">Product</flux:text></th>
										<th scope="col" class="px-3 py-3 text-left text-xs font-semibold uppercase tracking-wide"><flux:text variant="subtle" class="text-xs">Type</flux:text></th>
										<th scope="col" class="px-3 py-3 text-left text-xs font-semibold uppercase tracking-wide"><flux:text variant="subtle" class="text-xs">Quantity</flux:text></th>
										<th scope="col" class="px-3 py-3 text-left text-xs font-semibold uppercase tracking-wide"><flux:text variant="subtle" class="text-xs">Description</flux:text></th>
										<th scope="col" class="px-3 py-3 text-left text-xs font-semibold uppercase tracking-wide"><flux:text variant="subtle" class="text-xs">Notes</flux:text></th>
										<th scope="col" class="px-3 py-3 text-left text-xs font-semibold uppercase tracking-wide"><flux:text variant="subtle" class="text-xs">Order Date</flux:text></th>
										<th scope="col" class="px-3 py-3 text-left text-xs font-semibold uppercase tracking-wide"><flux:text variant="subtle" class="text-xs">Status</flux:text></th>
										<th scope="col" class="px-3 py-3 text-left text-xs font-semibold uppercase tracking-wide"><flux:text variant="subtle" class="text-xs">Created By</flux:text></th>

                                    <th scope="col" class="px-3 py-3 text-left text-xs font-semibold uppercase tracking-wide" width="1%"></th>
                                </tr>
                                </thead>
                                <tbody class="divide-y divide-zinc-200 dark:divide-zinc-700">
                                @foreach ($storage1Transactions as $storage1Transaction)
                                    <tr class="hover:bg-gray-50 hover:dark:bg-zinc-700" wire:key="{{ $storage1Transaction->id }}">
                                        											<td class="whitespace-nowrap px-3 py-4 text-sm"><flux:text>{{ $storage1Transaction->transaction_number }}</flux:text></td>
											<td class="whitespace-nowrap px-3 py-4 text-sm">
                                                @if($storage1Transaction->supplier)
                                                    <a href="{{ route('suppliers.show', $storage1Transaction->supplier->id) }}" class="text-blue-600 hover:underline">
                                                        {{ $storage1Transaction->supplier->contact_person }}
                                                    </a>
                                                @else
                                                    <span class="text-gray-400">—</span>
                                                @endif
                                            </td>
											<td class="whitespace-nowrap px-3 py-4 text-sm">
                                                @if($storage1Transaction->product)
                                                    <a href="{{ route('products.show', $storage1Transaction->product->id) }}" class="text-blue-600 hover:underline">
                                                        {{ $storage1Transaction->product->name }}
                                                    </a>
                                                @else
                                                    <span class="text-gray-400">—</span>
                                                @endif
                                            </td>
											<td class="whitespace-nowrap px-3 py-4 text-sm"><flux:text>{{ $storage1Transaction->type }}</flux:text></td>
											<td class="whitespace-nowrap px-3 py-4 text-sm"><flux:text>{{ $storage1Transaction->quantity }}</flux:text></td>
											<td class="whitespace-nowrap px-3 py-4 text-sm"><flux:text>{{ $storage1Transaction->description }}</flux:text></td>
											<td class="whitespace-nowrap px-3 py-4 text-sm"><flux:text>{{ $storage1Transaction->notes }}</flux:text></td>
											<td class="whitespace-nowrap px-3 py-4 text-sm"><flux:text>{{ $storage1Transaction->order_date }}</flux:text></td>
											<td class="whitespace-nowrap px-3 py-4 text-sm"><flux:text>{{ $storage1Transaction->status }}</flux:text></td>
											<td class="whitespace-nowrap px-3 py-4 text-sm">
                                                @if($storage1Transaction->created_by)
                                                    <a href="{{ route('users.show', $storage1Transaction->user->id) }}" class="text-blue-600 hover:underline">
                                                        {{ $storage1Transaction->user->name }}
                                                    </a>
                                                @else
                                                    <span class="text-gray-400">—</span>
                                                @endif
                                            </td>

                                        <td class="whitespace-nowrap px-3 py-4 flex gap-1 text-sm font-medium text-gray-900">
                                            @can('admin.storage1Transactions.show')
                                                <flux:button variant="ghost" href="{{ route('storage1-transactions.show', $storage1Transaction->id) }}" icon="magnifying-glass" class="mr-2" size="xs" tooltip="View details">
                                                </flux:button>
                                            @endcan
                                            @can('admin.storage1Transactions.edit')
                                                <flux:button variant="ghost" href="{{ route('storage1-transactions.edit', $storage1Transaction->id) }}" icon="pencil-square" class="mr-2" size="xs" tooltip="Edit">
                                                </flux:button>
                                            @endcan
                                            @can('admin.storage1Transactions.delete')
                                                <flux:modal.trigger name="delete-storage1Transaction-{{ $storage1Transaction->id }}">
                                                    <flux:button variant="ghost" icon="trash" class="text-red-600!" size="xs" tooltip="Delete"></flux:button>
                                                </flux:modal.trigger>

                                                <flux:modal :name="'delete-storage1Transaction-'.$storage1Transaction->id" class="min-w-[22rem]">
                                                    <div class="space-y-6">
                                                        <div>
                                                            <flux:heading size="lg">Delete {{ $storage1Transaction->id }}?</flux:heading>
                                                            <flux:text class="mt-2">
                                                                <p>Are you sure you want to delete this storage1Transaction?</p>
                                                                <p>This action cannot be undone.</p>
                                                            </flux:text>
                                                        </div>
                                                        <div class="flex gap-2">
                                                            <flux:spacer />
                                                            <flux:modal.close>
                                                                <flux:button variant="ghost">Cancel</flux:button>
                                                            </flux:modal.close>
                                                            <flux:button type="button" variant="danger" wire:click="delete({{ $storage1Transaction->id }})">Delete</flux:button>
                                                        </div>
                                                    </div>
                                                </flux:modal>
                                            @endcan
                                        </td>
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>

                            <div class="mt-4 px-4">
                                {!! $storage1Transactions->withQueryString()->links() !!}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>