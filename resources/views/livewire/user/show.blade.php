<section class="w-full">
    <div class="mb-6">
        <flux:breadcrumbs>
            <flux:breadcrumbs.item icon="home" />
            <flux:breadcrumbs.item :href="route('users.index')">Users</flux:breadcrumbs.item>
            <flux:breadcrumbs.item>{{ $user->name }}</flux:breadcrumbs.item>
        </flux:breadcrumbs>
    </div>

    <flux:separator />

    <div class="flex flex-col xl:justify-between xl:flex-row my-6">
        <div class="mb-6">
            <flux:heading size="xl" level="1">{{ $user->name }}</flux:heading>
            <flux:subheading size="lg">View details for this user.</flux:subheading>
        </div>
        <div class="flex items-top gap-2.5">
            @can('admin.users.edit')
                <flux:button icon="pencil-square" href="{{ route('users.edit', $user->id) }}">{{ __('Edit') }}</flux:button>
            @endcan
            <flux:button variant="primary" :href="route('users.index')" icon="arrow-left">{{ __('All Users') }}</flux:button>
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
                                    <flux:heading size="lg" level="2">User Details</flux:heading>
                                </div>
                                <div class="px-4 py-6 sm:grid sm:grid-cols-4 sm:gap-4 sm:px-0">
                                    <dt class="text-sm font-medium leading-6 text-gray-900"><flux:text variant="strong">Name</flux:text></dt>
                                    <dd class="mt-1 text-sm leading-6 text-gray-700 sm:col-span-3 sm:mt-0"><flux:text>{{ $user->name }}</flux:text></dd>
                                </div>
                                <div class="px-4 py-6 sm:grid sm:grid-cols-4 sm:gap-4 sm:px-0">
                                    <dt class="text-sm font-medium leading-6 text-gray-900"><flux:text variant="strong">Email</flux:text></dt>
                                    <dd class="mt-1 text-sm leading-6 text-gray-700 sm:col-span-3 sm:mt-0"><flux:text>{{ $user->email }}</flux:text></dd>
                                </div>
                                <div class="px-4 py-6 sm:grid sm:grid-cols-4 sm:gap-4 sm:px-0">
                                    <dt class="text-sm font-medium leading-6 text-gray-900"><flux:text variant="strong">Roles</flux:text></dt>
                                    <dd class="mt-1 text-sm leading-6 text-gray-700 sm:col-span-3 sm:mt-0"><flux:text>{{ $user->roles->first()->display_text ?? '--' }}</flux:text></dd>
                                </div>
                                <div class="px-4 py-6 sm:grid sm:grid-cols-4 sm:gap-4 sm:px-0">
                                    <dt class="text-sm font-medium leading-6 text-gray-900">
                                        <flux:text variant="strong">Assigned Branches</flux:text>
                                    </dt>
                                    <dd class="mt-1 text-sm leading-6 text-gray-700 sm:col-span-3 sm:mt-0">
                                        @if($user->branches->isNotEmpty())
                                            @foreach($user->branches as $branch)
                                                <flux:text>{{ $branch->name }}</flux:text>
                                            @endforeach
                                        @else
                                            <flux:text>--</flux:text>
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