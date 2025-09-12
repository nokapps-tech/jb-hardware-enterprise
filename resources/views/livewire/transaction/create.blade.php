<section class="w-full">
    <div class="mb-6">
        <flux:breadcrumbs>
            <flux:breadcrumbs.item icon="home" />
            <flux:breadcrumbs.item :href="route('transactions.index')">Transactions</flux:breadcrumbs.item>
            <flux:breadcrumbs.item>{{ __('Create') }}</flux:breadcrumbs.item>
        </flux:breadcrumbs>
    </div>

    <flux:separator />

    <div class="flex flex-col xl:justify-between xl:flex-row my-6">
        <div class="mb-6">
            <flux:heading size="xl" level="1">{{ __('Create Transaction') }}</flux:heading>
            <flux:subheading size="lg">Add a new transaction by filling in the required information.</flux:subheading>
        </div>
        <div class="flex items-top gap-2.5">
            <flux:button variant="primary" :href="route('transactions.index')" icon="arrow-left">{{ __('All Transactions') }}</flux:button>
        </div>
    </div>

    <div class="max-w-full mx-auto space-y-6 pb-12">
        <div class="p-4 sm:p-8 border border-zinc-200 dark:border-zinc-700 sm:rounded-lg">
            <div class="w-full">
                <div class="flow-root">
                    <div class="overflow-x-auto">
                        <div class="max-w-xl px-1 py-2 align-middle">
                            <form method="POST" wire:submit="save" role="form" enctype="multipart/form-data">
                                @csrf
                                @include('livewire.transaction.form')
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>