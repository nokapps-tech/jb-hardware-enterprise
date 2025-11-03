<section class="w-full">
    @section('title', 'Products')

    <div class="mb-6">
        <flux:breadcrumbs>
            <flux:breadcrumbs.item icon="home" />
            <flux:breadcrumbs.item>Products</flux:breadcrumbs.item>
        </flux:breadcrumbs>
    </div>

    <flux:separator />

    <div class="flex flex-col xl:justify-between xl:flex-row my-6">
        <div class="mb-6">
            <flux:heading size="xl" level="1">{{ __('Products') }}</flux:heading>
            <flux:subheading size="lg">View and manage all products.</flux:subheading>
        </div>
        <div class="flex items-top gap-2.5">
            @can('admin.products.import')
                <flux:button icon="arrow-down-tray" tooltip="Feature preview only. This feature is under active development.">{{ __('Import') }}</flux:button>
            @endcan
            @can('admin.products.export')
                <flux:button wire:click="export" icon="arrow-up-tray" tooltip="Export current view">{{ __('Export') }}</flux:button>
            @endcan
            @can('admin.products.create')
                <flux:button variant="primary" :href="route('products.create')" icon="plus">{{ __('Add New') }}</flux:button>
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
                                    <flux:input wire:model.live="search" icon="magnifying-glass" placeholder="Search products"/>
                                </div>
                                
                                <div class="flex gap-2 items-center">
                                    @if($filters)
                                        <div x-data="{ open: false }" class="relative">
                                            <flux:button variant="ghost" icon="funnel" icon:variant="outline" @click="open = !open">Filters</flux:button>
                                            <div 
                                                x-show="open" 
                                                x-transition.scale.origin.top.right
                                                x-cloak
                                                @click.away="open = false"
                                                @close-filter-dropdown.window="open = false"
                                                class="absolute right-0 mt-2 w-48 bg-white dark:bg-zinc-800 border border-zinc-200 dark:border-zinc-700 rounded-lg shadow-lg z-50"
                                            >
                                                <ul class="py-1 text-sm text-zinc-700 dark:text-zinc-300">
                                                    @foreach($filters as $value => $label)
                                                        <li>
                                                            <button 
                                                                wire:click="setFilter('{{ $value }}')" 
                                                                class="block w-full text-left px-4 py-2 hover:bg-zinc-100 dark:hover:bg-zinc-700 
                                                                    {{ $filter === $value ? 'bg-zinc-100 dark:bg-zinc-700 font-medium' : '' }}"
                                                                @click="open = false"
                                                            >
                                                                {{ $label }}
                                                            </button>
                                                        </li>
                                                    @endforeach
                                                </ul>
                                            </div>
                                        </div>
                                    @else
                                        <flux:button variant="ghost" icon="funnel" icon:variant="outline" tooltip="No Filter yet">Filters</flux:button>
                                    @endif
                                    <!-- <flux:button variant="ghost" icon="adjustments-horizontal" icon:variant="outline" tooltip="Feature preview only. This feature is under active development.">Edit columns</flux:button> -->
                                </div>
                            </div>

                            @if($filter)
                            <div class="mx-2 mb-4 text-sm text-zinc-600 dark:text-zinc-300">
                                Filtering by: 
                                <span class="inline-block ml-2 px-2 py-1 bg-zinc-100 dark:bg-zinc-700 rounded text-xs font-medium">
                                    {{ str_replace('-', ' ', ucfirst($filter)) }}
                                </span>
                                <button wire:click="$set('filter', null)" class="ml-3 text-sm text-blue-500 hover:underline">Clear</button>
                            </div>
                            @endif

                        <div class="inline-block min-w-full py-2 align-middle">
                            <table class="w-full divide-y divide-zinc-300 dark:divide-zinc-600">
                                <thead>
                                <tr>
                                    	<th scope="col" class="px-3 py-3 text-left text-xs font-semibold uppercase tracking-wide"><flux:text variant="subtle" class="text-xs">Product Code</flux:text></th>
										<th scope="col" class="px-3 py-3 text-left text-xs font-semibold uppercase tracking-wide"><flux:text variant="subtle" class="text-xs">Branch</flux:text></th>
                                        <th scope="col" class="px-3 py-3 text-left text-xs font-semibold uppercase tracking-wide"><flux:text variant="subtle" class="text-xs">Name</flux:text></th>
										<th scope="col" class="px-3 py-3 text-left text-xs font-semibold uppercase tracking-wide"><flux:text variant="subtle" class="text-xs">Product Category</flux:text></th>
										<th scope="col" class="px-3 py-3 text-left text-xs font-semibold uppercase tracking-wide"><flux:text variant="subtle" class="text-xs">Notes</flux:text></th>
										<th scope="col" class="px-3 py-3 text-left text-xs font-semibold uppercase tracking-wide"><flux:text variant="subtle" class="text-xs">Price</flux:text></th>
										<th scope="col" class="px-3 py-3 text-left text-xs font-semibold uppercase tracking-wide"><flux:text variant="subtle" class="text-xs">Cost</flux:text></th>
                                        <th scope="col" class="px-3 py-3 text-left text-xs font-semibold uppercase tracking-wide"><flux:text variant="subtle" class="text-xs">Size</flux:text></th>
                                        <th scope="col" class="px-3 py-3 text-left text-xs font-semibold uppercase tracking-wide"><flux:text variant="subtle" class="text-xs">Brand</flux:text></th>
                                        <th scope="col" class="px-3 py-3 text-left text-xs font-semibold uppercase tracking-wide"><flux:text variant="subtle" class="text-xs">Unit</flux:text></th>
										<th scope="col" class="px-3 py-3 text-left text-xs font-semibold uppercase tracking-wide"><flux:text variant="subtle" class="text-xs">Quantity</flux:text></th>
                                        <th scope="col" class="px-3 py-3 text-left text-xs font-semibold uppercase tracking-wide"><flux:text variant="subtle" class="text-xs">Threshold</flux:text></th>

                                    <th scope="col" class="px-3 py-3 text-left text-xs font-semibold uppercase tracking-wide" width="1%"></th>
                                </tr>
                                </thead>
                                <tbody class="divide-y divide-zinc-200 dark:divide-zinc-700">
                                @foreach ($products as $product)
                                    <tr 
                                        wire:key="{{ $product->id }}" 
                                        class="hover:bg-gray-50 hover:dark:bg-zinc-700 {{ $product->quantity <= $product->threshold ? 'bg-red-100 text-red-800 dark:bg-red-800 dark:text-red-100' : '' }}"
                                    >
                                        	<td class="whitespace-nowrap px-3 py-4 text-sm"><flux:text>{{ $product->product_code }}</flux:text></td>
                                            <td class="whitespace-nowrap px-3 py-4 text-sm">
                                                @if($product->branch)
                                                    <a href="{{ route('branches.show', $product->branch->id) }}" class="text-blue-600 hover:underline">
                                                        {{ $product->branch->name }}
                                                    </a>
                                                @else
                                                    <span class="text-gray-400">—</span>
                                                @endif
                                            </td>
											<td class="whitespace-nowrap px-3 py-4 text-sm"><flux:text>{{ $product->name }}</flux:text></td>
											<td class="whitespace-nowrap px-3 py-4 text-sm">
                                                @if($product->productCategory)
                                                    <a href="{{ route('product-categories.show', $product->productCategory->id) }}" class="text-blue-600 hover:underline">
                                                        {{ $product->productCategory->name }}
                                                    </a>
                                                @else
                                                    <span class="text-gray-400">—</span>
                                                @endif
                                            </td>
											<td class="whitespace-nowrap px-3 py-4 text-sm"><flux:text>{{ $product->notes }}</flux:text></td>
											<td class="whitespace-nowrap px-3 py-4 text-sm"><flux:text>{{ $product->price }}</flux:text></td>
											<td class="whitespace-nowrap px-3 py-4 text-sm"><flux:text>{{ $product->cost }}</flux:text></td>
                                            <td class="whitespace-nowrap px-3 py-4 text-sm"><flux:text>{{ $product->size }}</flux:text></td>
                                            <td class="whitespace-nowrap px-3 py-4 text-sm"><flux:text>{{ $product->brand }}</flux:text></td>
                                            <td class="whitespace-nowrap px-3 py-4 text-sm"><flux:text>{{ $product->unit }}</flux:text></td>
											<td class="whitespace-nowrap px-3 py-4 text-sm"><flux:text>{{ $product->quantity }}</flux:text></td>
                                            <td class="whitespace-nowrap px-3 py-4 text-sm"><flux:text>{{ $product->threshold }}</flux:text></td>
                                        <td class="whitespace-nowrap px-3 py-4 flex gap-1 text-sm font-medium text-gray-900">
                                            @can('admin.products.show')
                                                <flux:button variant="ghost" href="{{ route('products.show', $product->id) }}" icon="magnifying-glass" class="mr-2" size="xs" tooltip="View details">
                                                </flux:button>
                                            @endcan
                                            @can('admin.products.edit')
                                                <flux:button variant="ghost" href="{{ route('products.edit', $product->id) }}" icon="pencil-square" class="mr-2" size="xs" tooltip="Edit">
                                                </flux:button>
                                            @endcan
                                            @can('admin.products.delete')
                                                <flux:modal.trigger name="delete-product-{{ $product->id }}">
                                                    <flux:button variant="ghost" icon="trash" class="text-red-600!" size="xs" tooltip="Delete"></flux:button>
                                                </flux:modal.trigger>

                                                <flux:modal :name="'delete-product-'.$product->id" class="min-w-[22rem]">
                                                    <div class="space-y-6">
                                                        <div>
                                                            <flux:heading size="lg">Delete {{ $product->id }}?</flux:heading>
                                                            <flux:text class="mt-2">
                                                                <p>Are you sure you want to delete this product?</p>
                                                                <p>This action cannot be undone.</p>
                                                            </flux:text>
                                                        </div>
                                                        <div class="flex gap-2">
                                                            <flux:spacer />
                                                            <flux:modal.close>
                                                                <flux:button variant="ghost">Cancel</flux:button>
                                                            </flux:modal.close>
                                                            <flux:button type="button" variant="danger" wire:click="delete({{ $product->id }})">Delete</flux:button>
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
                                {!! $products->withQueryString()->links() !!}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<script>
    document.addEventListener('livewire:initialized', () => {
        Livewire.on('stock-alert', (event) => {
            alert(event.message);
        });
    });
</script>