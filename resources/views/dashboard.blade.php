<x-layouts.app>
    @section('title', 'Dashboard')

    <div class="mb-6 flex justify-between">
        <flux:breadcrumbs>
            <flux:breadcrumbs.item icon="home" />
            <flux:breadcrumbs.item>Dashboard</flux:breadcrumbs.item>
        </flux:breadcrumbs>
         @livewire('notification-bell')
    </div>

    <flux:separator />

    <div class="flex flex-col xl:justify-between xl:flex-row my-6">
        <div class="mb-6">
            <flux:heading size="xl" level="1">{{ __('Dashboard') }}</flux:heading>
            <flux:subheading size="lg">A central place to manage your application and monitor activity.</flux:subheading>
        </div>
    </div>

    <div class="relative h-100 flex items-center justify-center overflow-hidden rounded-xl bg-gray-50 dark:bg-zinc-700 border border-neutral-200 dark:border-neutral-700">
        <div class="flex flex-col gap-2 items-center">
            <flux:icon.chart-bar-square class="size-12" />
            <flux:text>Nothing here yet.</flux:text>
        </div>
    </div>
</x-layouts.app>
