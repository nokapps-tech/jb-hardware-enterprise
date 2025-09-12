<section class="w-full">
    <div class="mb-6">
        <flux:breadcrumbs>
            <flux:breadcrumbs.item icon="home" />
            <flux:breadcrumbs.item :href="route('contacts.index')">Contacts</flux:breadcrumbs.item>
            <flux:breadcrumbs.item>{{ $contact->id }}</flux:breadcrumbs.item>
        </flux:breadcrumbs>
    </div>

    <flux:separator />

    <div class="flex flex-col xl:justify-between xl:flex-row my-6">
        <div class="mb-6">
            <flux:heading size="xl" level="1">{{ $contact->id }}</flux:heading>
            <flux:subheading size="lg">View details for this contact.</flux:subheading>
        </div>
        <div class="flex items-top gap-2.5">
            <flux:button icon="pencil-square" href="{{ route('contacts.edit', $contact->id) }}">{{ __('Edit') }}</flux:button>
            <flux:button variant="primary" :href="route('contacts.index')" icon="arrow-left">{{ __('All Contacts') }}</flux:button>
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
                                    <flux:heading size="lg" level="2">Contact Details</flux:heading>
                                </div>
                                
                                        <div class="px-4 py-6 sm:grid sm:grid-cols-4 sm:gap-4 sm:px-0">
                                            <dt class="text-sm font-medium leading-6"><flux:text variant="strong">First Name</flux:text></dt>
                                            <dd class="mt-1 text-sm leading-6 sm:col-span-3 sm:mt-0"><flux:text>{{ $contact->first_name ?? 'None' }}</flux:text></dd>
                                        </div>
                                        <div class="px-4 py-6 sm:grid sm:grid-cols-4 sm:gap-4 sm:px-0">
                                            <dt class="text-sm font-medium leading-6"><flux:text variant="strong">Last Name</flux:text></dt>
                                            <dd class="mt-1 text-sm leading-6 sm:col-span-3 sm:mt-0"><flux:text>{{ $contact->last_name ?? 'None' }}</flux:text></dd>
                                        </div>
                                        <div class="px-4 py-6 sm:grid sm:grid-cols-4 sm:gap-4 sm:px-0">
                                            <dt class="text-sm font-medium leading-6"><flux:text variant="strong">Email</flux:text></dt>
                                            <dd class="mt-1 text-sm leading-6 sm:col-span-3 sm:mt-0"><flux:text>{{ $contact->email ?? 'None' }}</flux:text></dd>
                                        </div>
                                        <div class="px-4 py-6 sm:grid sm:grid-cols-4 sm:gap-4 sm:px-0">
                                            <dt class="text-sm font-medium leading-6"><flux:text variant="strong">Phone</flux:text></dt>
                                            <dd class="mt-1 text-sm leading-6 sm:col-span-3 sm:mt-0"><flux:text>{{ $contact->phone ?? 'None' }}</flux:text></dd>
                                        </div>
                                        <div class="px-4 py-6 sm:grid sm:grid-cols-4 sm:gap-4 sm:px-0">
                                            <dt class="text-sm font-medium leading-6"><flux:text variant="strong">Company Id</flux:text></dt>
                                            <dd class="mt-1 text-sm leading-6 sm:col-span-3 sm:mt-0"><flux:text>{{ $contact->company_id ?? 'None' }}</flux:text></dd>
                                        </div>
                                        <div class="px-4 py-6 sm:grid sm:grid-cols-4 sm:gap-4 sm:px-0">
                                            <dt class="text-sm font-medium leading-6"><flux:text variant="strong">Company Name</flux:text></dt>
                                            <dd class="mt-1 text-sm leading-6 sm:col-span-3 sm:mt-0"><flux:text>{{ $contact->company?->name ?? 'None' }}</flux:text></dd>
                                        </div>
                                        <div class="px-4 py-6 sm:grid sm:grid-cols-4 sm:gap-4 sm:px-0">
                                            <dt class="text-sm font-medium leading-6"><flux:text variant="strong">Job Title</flux:text></dt>
                                            <dd class="mt-1 text-sm leading-6 sm:col-span-3 sm:mt-0"><flux:text>{{ $contact->job_title ?? 'None' }}</flux:text></dd>
                                        </div>

                            </dl>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>