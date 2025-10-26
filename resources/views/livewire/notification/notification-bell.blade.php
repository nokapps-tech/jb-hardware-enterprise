<flux:dropdown align="right">
    {{-- Notification Button --}}
    <flux:button 
        variant="ghost" 
        size="sm" 
        icon="bell" 
        class="relative hover:bg-gray-200/20 transition"
    >
        @if($unreadCount > 0)
            <span class="absolute -top-1.5 -right-1.5 bg-red-500 text-white text-[10px] font-medium px-1.5 rounded-full min-w-[16px] text-center">
                {{ $unreadCount }}
            </span>
        @endif
    </flux:button>

    {{-- Notification Menu --}}
    <flux:menu class="w-80 max-h-80 overflow-y-auto rounded-lg border border-gray-200 dark:border-gray-700 dark:bg-gray-800 shadow-sm">
        {{-- Header --}}
        <div class="flex items-center justify-between px-4 py-2.5 border-b border-gray-100 dark:border-gray-700 rounded-t-lg">
            <span class="text-sm font-semibold text-gray-900 dark:text-gray-100 tracking-wide">
                Notifications
            </span>
            @if($notifications->count() > 0)
                <button wire:click="markAllAsRead" class="text-xs text-gray-600 dark:text-gray-300 hover:text-gray-800 dark:hover:text-white hover:underline transition">
                    Mark all as read
                </button>
            @endif
        </div>

        {{-- Notification List --}}
        <div class="divide-y divide-gray-100 dark:divide-gray-700">
            @forelse($notifications as $notification)
                @php 
                    $isUnread = is_null($notification->read_at); 
                    $data = $notification->data;
                @endphp

                <flux:menu.item
                    wire:click="markAsRead('{{ $notification->id }}')"
                    class="flex items-start gap-3 px-4 py-3 cursor-pointer transition hover:bg-gray-50 dark:hover:bg-gray-700 {{ $isUnread ? 'bg-gray-50 dark:bg-gray-700' : 'bg-transparent dark:bg-transparent' }}"
                >
                    {{-- Icon --}}
                    <div class="flex-shrink-0 w-8 h-8 flex items-center justify-center rounded-md {{ $isUnread ? 'bg-gray-200 dark:bg-gray-600 text-gray-700 dark:text-gray-100' : 'bg-gray-100 dark:bg-gray-700 text-gray-600 dark:text-gray-300' }}">
                        <flux:icon name="package" class="w-4 h-4" />
                    </div>

                    {{-- Content --}}
                    <div class="flex-1">
                        <div class="text-sm font-medium text-gray-900 dark:text-gray-100">
                            {{ $data['product_name'] ?? 'Product' }}
                        </div>
                        <div class="text-sm text-gray-700 dark:text-gray-300">
                            Stock is low 
                            <span class="font-semibold text-gray-900 dark:text-gray-100">
                                ({{ $data['quantity'] ?? 0 }}/{{ $data['threshold'] ?? '-' }})
                            </span>
                        </div>
                        <div class="text-xs text-gray-500 dark:text-gray-400 mt-1">
                            {{ $notification->created_at->diffForHumans() }}
                        </div>
                    </div>

                    {{-- Unread dot --}}
                    @if($isUnread)
                        <div class="flex-shrink-0 w-1.5 h-1.5 bg-gray-600 dark:bg-gray-300 rounded-full mt-2"></div>
                    @endif
                </flux:menu.item>
            @empty
                {{-- Empty State --}}
                <div class="flex flex-col items-center justify-center py-8 text-gray-500 dark:text-gray-400">
                    <flux:icon name="bell-off" class="w-6 h-6 mb-2" />
                    <p class="text-sm">No new notifications</p>
                </div>
            @endforelse
        </div>
    </flux:menu>
</flux:dropdown>
