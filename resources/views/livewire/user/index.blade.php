<section class="w-full">
    @section('title', 'Users')
    
    <div class="mb-6">
        <flux:breadcrumbs>
            <flux:breadcrumbs.item icon="home" />
            <flux:breadcrumbs.item>Users</flux:breadcrumbs.item>
        </flux:breadcrumbs>
    </div>

    <flux:separator />

    <div class="flex flex-col xl:justify-between xl:flex-row my-6">
        <div class="mb-6">
            <flux:heading size="xl" level="1">{{ __('Users') }}</flux:heading>
            <flux:subheading size="lg">View, manage, and control user accounts, roles, and permissions.</flux:subheading>
        </div>
        <div class="flex items-top gap-2.5">
            <!-- @can('admin.users.import')
                <flux:button icon="arrow-down-tray" tooltip="Feature preview only. This feature is under active development.">{{ __('Import') }}</flux:button>
            @endcan
            @can('admin.users.export')
                <flux:button icon="arrow-up-tray" tooltip="Feature preview only. This feature is under active development.">{{ __('Export') }}</flux:button>
            @endcan -->
            @can('admin.users.create')
                <flux:button variant="primary" :href="route('users.create')" icon="plus">{{ __('Add New') }}</flux:button>
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
                                <flux:input wire:model.live="search" icon="magnifying-glass" placeholder="Search users"/>
                            </div>
                            <div>
                                <flux:button variant="ghost" icon="funnel" icon:variant="outline" tooltip="Feature preview only. This feature is under active development.">Filters</flux:button>
                                <!-- <flux:button variant="ghost" icon="adjustments-horizontal" icon:variant="outline" tooltip="Feature preview only. This feature is under active development.">Edit columns</flux:button>     -->
                            </div>
                        </div>
                        <div class="inline-block min-w-full py-2 align-middle">
                            <table class="w-full divide-y divide-zinc-300 dark:divide-zinc-600">
                                <thead>
                                <tr>
                                    <th scope="col" class="px-3 py-3 text-left text-xs font-semibold uppercase tracking-wide"><flux:text variant="subtle" class="text-xs">Name</flux:text></th>
                                    <th scope="col" class="px-3 py-3 text-left text-xs font-semibold uppercase tracking-wide"><flux:text variant="subtle" class="text-xs">Role</flux:text></th>
                                    <th scope="col" class="px-3 py-3 text-left text-xs font-semibold uppercase tracking-wide"><flux:text variant="subtle" class="text-xs">Verified</flux:text></th>
                                    <th scope="col" class="px-3 py-3 text-left text-xs font-semibold uppercase tracking-wide"><flux:text variant="subtle" class="text-xs">Status</flux:text></th>
                                    <th scope="col" class="px-3 py-3 text-left text-xs font-semibold uppercase tracking-wide"><flux:text variant="subtle" class="text-xs">Joined at</flux:text></th>
                                    <th scope="col" class="px-3 py-3 text-left text-xs font-semibold uppercase tracking-wide" width="1%"></th>
                                </tr>
                                </thead>
                                <tbody class="divide-y divide-zinc-200 dark:divide-zinc-700">
                                @foreach ($users as $user)
                                    <tr class="hover:bg-gray-50 hover:dark:bg-zinc-700" wire:key="{{ $user->id }}">
                                        <td class="whitespace-nowrap px-3 py-4 text-sm font-medium"><flux:text variant="strong">
                                            <div class="flex items-center gap-2 sm:gap-4">
                                                <flux:avatar circle size="sm" class="max-sm:size-8" name="{{ $user->name }}" />
                                                <div class="flex flex-col">
                                                    <flux:text variant="strong">{{ $user->name }}</flux:text>
                                                    <flux:text>{{ $user->email }}</flux:text>
                                                </div>
                                            </div>
                                        </flux:text></td>
                                        <td class="whitespace-nowrap px-3 py-4 text-sm"><flux:text>{{ $user->role?->name ?? 'Member' }}</flux:text></td>
                                        <td class="whitespace-nowrap px-3 py-4">
                                            @if ($user->email_verified_at)
                                                <flux:icon.check-circle class="text-lime-700 dark:text-lime-300" />
                                            @else
                                                <flux:icon.x-circle class="text-red-700 dark:text-red-300" />
                                            @endif
                                        </td>
                                        <td class="whitespace-nowrap px-3 py-4 text-sm">
                                            @if ($user->status == 'Active')
                                                <flux:badge color='lime'>{{ $user->status }}</flux:badge>
                                            @else
                                                <flux:badge>{{ $user->status }}</flux:badge>
                                            @endif
                                        </td>
                                        <td class="whitespace-nowrap px-3 py-4 text-sm"><flux:text>{{ $user->created_at_formatted }}</flux:text></td>
                                        <td class="whitespace-nowrap px-3 py-4 flex gap-1 text-sm font-medium">
                                            @can('admin.users.show')
                                                <flux:button variant="ghost" href="{{ route('users.show', $user->id) }}" icon="magnifying-glass" size="xs" tooltip="View details">
                                                </flux:button>
                                            @endcan
                                            @can('admin.users.edit')
                                                <flux:button variant="ghost" href="{{ route('users.edit', $user->id) }}" icon="pencil-square" size="xs" tooltip="Edit">
                                                </flux:button>
                                            @endcan
                                            @can('admin.users.delete')
                                                <flux:modal.trigger name="delete-user-{{ $user->id }}">
                                                    <flux:button variant="ghost" icon="trash" class="text-red-600!" size="xs" tooltip="Delete"></flux:button>
                                                </flux:modal.trigger>

                                                <flux:modal :name="'delete-user-'.$user->id" class="min-w-[22rem]">
                                                    <div class="space-y-6">
                                                        <div>
                                                            <flux:heading size="lg">Delete {{ $user->name }}?</flux:heading>
                                                            <flux:text class="mt-2">
                                                                <p>Are you sure you want to delete this user?</p>
                                                                <p>This action cannot be undone.</p>
                                                            </flux:text>
                                                        </div>
                                                        <div class="flex gap-2">
                                                            <flux:spacer />
                                                            <flux:modal.close>
                                                                <flux:button variant="ghost">Cancel</flux:button>
                                                            </flux:modal.close>
                                                            <flux:button type="button" variant="danger" wire:click="delete({{ $user->id }})">Delete</flux:button>
                                                        </div>
                                                    </div>
                                                </flux:modal>
                                            @endcan
                                        </td>
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>

                            <div class="mt-4 px-3">
                                {!! $users->withQueryString()->links() !!}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>