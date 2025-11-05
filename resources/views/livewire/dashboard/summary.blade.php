<div class="space-y-6">
    <!-- Summary Cards -->
    <div class="grid grid-cols-1 sm:grid-cols-2 xl:grid-cols-5 gap-6">
        @foreach ($totals as $item)
            <a href="{{ $item['route'] }}" 
               class="group flex flex-col items-center justify-center p-6 text-center
                      border border-zinc-200 dark:border-zinc-700 rounded-xl bg-white dark:bg-zinc-800
                      shadow-sm transition duration-300 transform hover:-translate-y-1 hover:shadow-lg">

                <div class="flex items-center justify-center w-16 h-16 mb-4 rounded-full {{ $item['bgColor'] }}">
                    <flux:icon icon="{{ $item['icon'] }}" class="size-8 {{ $item['textColor'] }} group-hover:text-opacity-80 transition-colors" />
                </div>

                <flux:heading size="lg" class="font-semibold text-gray-800 dark:text-gray-100 mb-1">
                    {{ $item['count'] }}
                </flux:heading>
                <flux:text class="text-gray-500 dark:text-gray-400 font-medium">{{ $item['title'] }}</flux:text>
            </a>
        @endforeach
    </div>

    <!-- Branch Overview -->
    @if($branches->count())
    <div class="grid grid-cols-1 sm:grid-cols-2 xl:grid-cols-4 gap-6 mb-6">
        @foreach ($branches as $branch)
            <div class="p-6 bg-white dark:bg-zinc-800 rounded-xl shadow-sm border border-zinc-200 dark:border-zinc-700">
                <flux:heading size="md" class="mb-2">{{ $branch->name }}</flux:heading>
                <flux:text class="text-gray-500 dark:text-gray-400 mb-1">Transactions: {{ $branch->transactions_count }}</flux:text>            </div>
        @endforeach
    </div>
    @endif

    <!-- Recent Transactions -->
    <div class="p-6 bg-white dark:bg-zinc-800 rounded-xl shadow-sm border border-zinc-200 dark:border-zinc-700 overflow-x-auto">
        <table class="w-full text-left">
            <thead>
                <tr>
                    <th class="px-4 py-2">Date</th>
                    <th class="px-4 py-2">Branch</th>
                    <th class="px-4 py-2">Product / Supplier</th>
                    <th class="px-4 py-2">Type</th>
                    <th class="px-4 py-2">Quantity</th>
                    <th class="px-4 py-2">User</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($recentTransactions as $t)
                <tr class="border-b border-zinc-200 dark:border-zinc-700">
                    <td class="px-4 py-2">{{ $t->created_at->format('M d, Y H:i') }}</td>
                    <td class="px-4 py-2">{{ $t->branch->name ?? '-' }}</td>
                    <td class="px-4 py-2">
                        @if($t->items->count())
                            @foreach($t->items as $item)
                                @php
                                    $product = $item->product;
                                    $name = $product?->name ?? '-';
                                    $size = $product?->size ?? '-';
                                    $brand = $product?->brand ?? '-';
                                @endphp
                                {{ $name }} - {{ $size }} - {{ $brand }}<br>
                            @endforeach
                        @else
                            -
                        @endif
                    </td>
                    <td class="px-4 py-2">
                        @if($t->items->count())
                            @foreach($t->items as $item)
                                {{ ucfirst($item->type) }}<br>
                            @endforeach
                        @else
                            -
                        @endif
                    </td>
                    <td class="px-4 py-2">
                        @if($t->items->count())
                            @foreach($t->items as $item)
                                {{ $item->quantity }}<br>
                            @endforeach
                        @else
                            -
                        @endif
                    </td>

                    <td class="px-4 py-2">{{ ucfirst($t->type) }}</td>
                    <td class="px-4 py-2">{{ $t->quantity }}</td>
                    <td class="px-4 py-2">{{ $t->user->name ?? '-' }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
