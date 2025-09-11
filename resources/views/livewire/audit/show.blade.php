<section class="w-full">
    <div class="mb-6">
        <flux:breadcrumbs>
            <flux:breadcrumbs.item icon="home" />
            <flux:breadcrumbs.item :href="route('audits.index')">Audits</flux:breadcrumbs.item>
            <flux:breadcrumbs.item>{{ $audit->summary }}</flux:breadcrumbs.item>
        </flux:breadcrumbs>
    </div>

    <flux:separator />

    <div class="flex flex-col xl:justify-between xl:flex-row my-6">
        <div class="mb-6">
            <flux:heading size="xl" level="1">{{ $audit->summary }}</flux:heading>
            <flux:subheading size="lg">See what details were changed by this user activity.</flux:subheading>
        </div>
        <div class="flex items-top gap-2.5">
            <flux:button variant="primary" :href="route('audits.index')" icon="arrow-left">{{ __('All Audits') }}</flux:button>
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
                                    <flux:heading size="lg" level="2">Audit Details</flux:heading>
                                </div>
                                <div class="px-4 py-6 sm:grid sm:grid-cols-4 sm:gap-4 sm:px-0">
                                    <dt class="text-sm leading-6">
                                        <flux:text class="font-medium" variant="strong">User</flux:text>
                                        <flux:text>The user who performed the change</flux:text>
                                    </dt>
                                    <dd class="mt-1 text-sm leading-6 text-gray-700 sm:col-span-3 sm:mt-0">
                                        <div class="flex items-center gap-2 sm:gap-4">
                                            <flux:avatar circle size="lg" class="max-sm:size-8" name="{{ $audit->user->name }}" />
                                            <div class="flex flex-col">
                                                <flux:heading>
                                                    {{ $audit->user->name }}
                                                    @if ($audit->user_id === auth()->id())
                                                        <flux:badge size="sm" class="ml-1 max-sm:hidden">You</flux:badge>
                                                    @endif
                                                </flux:heading>
                                                <flux:text>{{ $audit->user->email }}</flux:text>
                                            </div>
                                        </div>
                                    </dd>
                                </div>
                                <div class="px-4 py-6 sm:grid sm:grid-cols-4 sm:gap-4 sm:px-0">
                                    <dt class="text-sm font-medium leading-6"><flux:text variant="strong">Summary</flux:text></dt>
                                    <dd class="mt-1 text-sm leading-6 text-gray-700 sm:col-span-3 sm:mt-0"><flux:text>{{ $audit->summary }}</flux:text></dd>
                                </div>
                                <div class="px-4 py-6 sm:grid sm:grid-cols-4 sm:gap-4 sm:px-0">
                                    <dt class="text-sm leading-6">
                                        <flux:text class="font-medium" variant="strong">Item {{ $audit->event }}</flux:text>
                                        <flux:text>The item changed by the user</flux:text>
                                    </dt>
                                    <dd class="mt-1 text-sm leading-6 text-gray-700 sm:col-span-3 sm:mt-0">
                                        <flux:text>
                                        @if ($audit->auditable && !$audit->auditable->trashed())
                                            <flux:link href="{{ route($audit->auditable_route . '.show', $audit->auditable_id) }}">{{ $audit->auditable_type_formatted }} {{ $audit->auditable_text_id }}</flux:link>
                                        @else
                                            {{ $audit->auditable_type_formatted }} {{ $audit->auditable_text_id }}
                                        @endif
                                        </flux:text>
                                    </dd>
                                </div>
                                <div class="px-4 py-6 sm:grid sm:grid-cols-4 sm:gap-4 sm:px-0">
                                    <dt class="text-sm font-medium leading-6"><flux:text variant="strong">Tags</flux:text></dt>
                                    <dd class="mt-1 text-sm leading-6 text-gray-700 sm:col-span-3 sm:mt-0"><flux:text>{{ $audit->tags ?? 'None' }}</flux:text></dd>
                                </div>
                                <div class="px-4 py-6 sm:grid sm:grid-cols-4 sm:gap-4 sm:px-0">
                                    <dt class="text-sm font-medium leading-6"><flux:text variant="strong">Timestamp</flux:text></dt>
                                    <dd class="mt-1 text-sm leading-6 text-gray-700 sm:col-span-3 sm:mt-0"><flux:text>{{ $audit->created_at_formatted }}</flux:text></dd>
                                </div>
                                <flux:separator/>

                                <div class="px-4 py-6 sm:px-0">
                                    <flux:heading size="lg" level="2">Changes Made</flux:heading>
                                </div>
                                <div class="px-4 py-6 sm:grid sm:grid-cols-4 sm:gap-4 sm:px-0">
                                    <dt class="text-sm font-medium leading-6"><flux:text variant="strong">Old Values</flux:text></dt>
                                    <dd class="mt-1 text-sm leading-6 text-gray-700 sm:col-span-3 sm:mt-0"><flux:text>{{ $audit->old_values }}</flux:text></dd>
                                </div>
                                <div class="px-4 py-6 sm:grid sm:grid-cols-4 sm:gap-4 sm:px-0">
                                    <dt class="text-sm font-medium leading-6"><flux:text variant="strong">New Values</flux:text></dt>
                                    <dd class="mt-1 text-sm leading-6 text-gray-700 sm:col-span-3 sm:mt-0"><flux:text>{{ $audit->new_values }}</flux:text></dd>
                                </div>
                                <flux:separator/>
                                <div class="px-4 py-6 sm:px-0">

                                    <flux:heading size="lg" level="2">Technical Details</flux:heading>
                                </div>
                                <div class="px-4 py-6 sm:grid sm:grid-cols-4 sm:gap-4 sm:px-0">
                                    <dt class="text-sm font-medium leading-6"><flux:text variant="strong">URL</flux:text></dt>
                                    <dd class="mt-1 text-sm leading-6 text-gray-700 sm:col-span-3 sm:mt-0"><flux:text>{{ $audit->url }}</flux:text></dd>
                                </div>
                                <div class="px-4 py-6 sm:grid sm:grid-cols-4 sm:gap-4 sm:px-0">
                                    <dt class="text-sm font-medium leading-6"><flux:text variant="strong">IP Address</flux:text></dt>
                                    <dd class="mt-1 text-sm leading-6 text-gray-700 sm:col-span-3 sm:mt-0"><flux:text>{{ $audit->ip_address }}</flux:text></dd>
                                </div>
                                <div class="px-4 py-6 sm:grid sm:grid-cols-4 sm:gap-4 sm:px-0">
                                    <dt class="text-sm font-medium leading-6"><flux:text variant="strong">Browser</flux:text></dt>
                                    <dd class="mt-1 text-sm leading-6 text-gray-700 sm:col-span-3 sm:mt-0"><flux:text>{{ $audit->browser }}</flux:text></dd>
                                </div>
                                <div class="px-4 py-6 sm:grid sm:grid-cols-4 sm:gap-4 sm:px-0">
                                    <dt class="text-sm font-medium leading-6"><flux:text variant="strong">Operating System</flux:text></dt>
                                    <dd class="mt-1 text-sm leading-6 text-gray-700 sm:col-span-3 sm:mt-0"><flux:text>{{ $audit->os }}</flux:text></dd>
                                </div>
                                <div class="px-4 py-6 sm:grid sm:grid-cols-4 sm:gap-4 sm:px-0">
                                    <dt class="text-sm font-medium leading-6"><flux:text variant="strong">Device</flux:text></dt>
                                    <dd class="mt-1 text-sm leading-6 text-gray-700 sm:col-span-3 sm:mt-0"><flux:text>{{ $audit->device }}</flux:text></dd>
                                </div>
                            </dl>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>