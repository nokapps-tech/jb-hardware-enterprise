<div class="grid grid-cols-1 sm:grid-cols-2 xl:grid-cols-4 gap-4">
    @foreach ($totals as $item)
        <a href="{{ $item['route'] }}" 
           class="flex flex-col items-center justify-center p-6 text-center 
                  border border-zinc-200 dark:border-zinc-700 
                  rounded-xl bg-gray-50 dark:bg-zinc-800 shadow-sm 
                  transition duration-200 hover:-translate-y-1 hover:shadow-md hover:bg-zinc-100 dark:hover:bg-zinc-700">
            
            <flux:icon icon="{{ $item['icon'] }}" class="size-10 text-blue-500 mb-2" />
            <flux:heading size="lg">{{ $item['count'] }}</flux:heading>
            <flux:text>{{ $item['title'] }}</flux:text>
        </a>
    @endforeach
</div>
