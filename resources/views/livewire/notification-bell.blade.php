<flux:dropdown align="right">
    <flux:button variant="ghost" size="sm" icon="bell" class="relative">
        @if(count($notifications) > 0)
            <span class="absolute -top-1 -right-1 bg-red-600 text-white text-xs px-1 rounded-full">
                {{ count($notifications) }}
            </span>
        @endif
    </flux:button>

    <flux:menu class="w-64 max-h-60 overflow-y-auto">
        @forelse($notifications as $notification)
            <flux:menu.item
                wire:click="markAsRead('{{ $notification->id }}')"
                class="flex flex-col items-start"
            >
                <span class="text-sm">
                    {{ $notification->data['product_name'] ?? 'Product' }} stock is low 
                    ({{ $notification->data['quantity'] ?? 0 }}/{{ $notification->data['threshold'] ?? '-' }})
                </span>
                <span class="text-xs text-gray-500">
                    {{ $notification->created_at->diffForHumans() }}
                </span>
            </flux:menu.item>
        @empty
            <flux:menu.item disabled class="text-gray-500 text-sm">
                No new notifications
            </flux:menu.item>
        @endforelse
    </flux:menu>
</flux:dropdown>