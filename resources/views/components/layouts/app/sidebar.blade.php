<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="dark">
    <head>
        @include('partials.head')
    </head>
    <body class="min-h-screen bg-white dark:bg-zinc-800">
        <flux:sidebar sticky stashable class="border-e border-zinc-200 bg-zinc-50 dark:border-zinc-700 dark:bg-zinc-900">
            <flux:sidebar.toggle class="lg:hidden" icon="x-mark" />

            <a href="{{ route('dashboard') }}" class="me-5 mb-4 flex items-center space-x-2 rtl:space-x-reverse" wire:navigate>
                <x-app-logo />
            </a>

            <flux:navlist variant="outline">
                <flux:navlist.group :heading="__('Overview')" class="grid mb-4 font-medium">
                    <flux:navlist.item icon="chart-bar-square" :href="route('dashboard')" :current="request()->routeIs('dashboard')" wire:navigate>{{ __('Dashboard') }}</flux:navlist.item>
                </flux:navlist.group>

                @canany(['admin.product-categories.index', 'admin.products.index'])
                <flux:navlist.group :heading="__('Inventory Core')" class="grid mb-4 font-medium">
                    @can('admin.product-categories.index')
                        <flux:navlist.item icon="blocks" :href="route('product-categories.index')" :current="request()->routeIs('product-categories.*')" wire:navigate>{{ __('Product Categories') }}</flux:navlist.item>
                    @endcan
                    @can('admin.products.index')
                        <flux:navlist.item icon="boxes" :href="route('products.index')" :current="request()->routeIs('products.*')" wire:navigate>{{ __('Products') }}</flux:navlist.item>
                    @endcan
                </flux:navlist.group>
                @endcanany

                @canany(['admin.storage1-transactions.index'])
                <flux:navlist.group :heading="__('Storage A')" class="grid mb-4 font-medium">
                    @can('admin.storage1-transactions.index')
                        <flux:navlist.item icon="arrow-right-left" :href="route('storage1-transactions.index')" :current="request()->routeIs('storage1-transactions.*')" wire:navigate>{{ __('Storage A Transactions') }}</flux:navlist.item>
                    @endcan
                </flux:navlist.group>
                @endcanany

                @canany(['admin.storage2-transactions.index'])
                <flux:navlist.group :heading="__('Storage B')" class="grid mb-4 font-medium">
                    @can('admin.storage2-transactions.index')
                        <flux:navlist.item icon="arrow-right-left" :href="route('storage2-transactions.index')" :current="request()->routeIs('storage2-transactions.*')" wire:navigate>{{ __('Storage B Transactions') }}</flux:navlist.item>
                    @endcan
                </flux:navlist.group>
                @endcanany

                @canany(['admin.companies.index', 'admin.suppliers.index'])
                <flux:navlist.group :heading="__('Contacts')" class="grid mb-4 font-medium">
                    @can('admin.companies.index')
                        <flux:navlist.item icon="building-2" :href="route('companies.index')" :current="request()->routeIs('companies.*')" wire:navigate>{{ __('Companies') }}</flux:navlist.item>
                    @endcan
                    @can('admin.suppliers.index')
                        <flux:navlist.item icon="package" :href="route('suppliers.index')" :current="request()->routeIs('suppliers.*')" wire:navigate>{{ __('Suppliers') }}</flux:navlist.item>
                    @endcan
                </flux:navlist.group>
                @endcanany

                @canany(['admin.users.index', 'admin.roles.index', 'admin.audits.index'])
                <flux:navlist.group :heading="__('System')" class="grid mb-4 font-medium">
                    @can('admin.users.index')
                        <flux:navlist.item icon="user" :href="route('users.index')" :current="request()->routeIs('users.*')" wire:navigate>{{ __('Users') }}</flux:navlist.item>
                    @endcan
                    @can('admin.roles.index')
                        <flux:navlist.item icon="user-round-cog" :href="route('roles.index')" :current="request()->routeIs('roles.*')" wire:navigate>{{ __('Roles') }}</flux:navlist.item>
                    @endcan
                    @can('admin.audits.index')
                        <flux:navlist.item icon="shield-check" :href="route('audits.index')" :current="request()->routeIs('audits.*')" wire:navigate>{{ __('Audit Log') }}</flux:navlist.item>
                    @endcan
                </flux:navlist.group>
                @endcanany
            </flux:navlist>

            <flux:spacer />

            <flux:navlist variant="outline">
                @can('admin.account.edit')
                    <flux:navlist.item icon="cog-6-tooth" :href="route('settings.profile')" :current="request()->routeIs('settings.*')"  wire:navigate>
                    {{ __('Settings') }}
                    </flux:navlist.item>
                @endcan
            </flux:navlist>

            <!-- Desktop User Menu -->
            <flux:dropdown class="hidden lg:block" position="bottom" align="start">
                <flux:profile
                    :name="auth()->user()->name"
                    :initials="auth()->user()->initials()"
                    icon:trailing="chevrons-up-down"
                />

                <flux:menu class="w-[220px]">
                    <flux:menu.radio.group>
                        <div class="p-0 text-sm font-normal">
                            <div class="flex items-center gap-2 px-1 py-1.5 text-start text-sm">
                                <span class="relative flex h-8 w-8 shrink-0 overflow-hidden rounded-lg">
                                    <span
                                        class="flex h-full w-full items-center justify-center rounded-lg bg-neutral-200 text-black dark:bg-neutral-700 dark:text-white"
                                    >
                                        {{ auth()->user()->initials() }}
                                    </span>
                                </span>

                                <div class="grid flex-1 text-start text-sm leading-tight">
                                    <span class="truncate font-semibold">{{ auth()->user()->name }}</span>
                                    <span class="truncate text-xs">{{ auth()->user()->email }}</span>
                                </div>
                            </div>
                        </div>
                    </flux:menu.radio.group>

                    <flux:menu.separator />

                    <form method="POST" action="{{ route('logout') }}" class="w-full">
                        @csrf
                        <flux:menu.item as="button" type="submit" icon="arrow-right-start-on-rectangle" class="w-full">
                            {{ __('Log Out') }}
                        </flux:menu.item>
                    </form>
                </flux:menu>
            </flux:dropdown>
        </flux:sidebar>

        <!-- Mobile User Menu -->
        <flux:header class="lg:hidden">
            <flux:sidebar.toggle class="lg:hidden" icon="bars-2" inset="left" />

            <flux:spacer />

            <flux:dropdown position="top" align="end">
                <flux:profile
                    :initials="auth()->user()->initials()"
                    icon-trailing="chevron-down"
                />

                <flux:menu>
                    <flux:menu.radio.group>
                        <div class="p-0 text-sm font-normal">
                            <div class="flex items-center gap-2 px-1 py-1.5 text-start text-sm">
                                <span class="relative flex h-8 w-8 shrink-0 overflow-hidden rounded-lg">
                                    <span
                                        class="flex h-full w-full items-center justify-center rounded-lg bg-neutral-200 text-black dark:bg-neutral-700 dark:text-white"
                                    >
                                        {{ auth()->user()->initials() }}
                                    </span>
                                </span>

                                <div class="grid flex-1 text-start text-sm leading-tight">
                                    <span class="truncate font-semibold">{{ auth()->user()->name }}</span>
                                    <span class="truncate text-xs">{{ auth()->user()->email }}</span>
                                </div>
                            </div>
                        </div>
                    </flux:menu.radio.group>

                    <flux:menu.separator />

                    <form method="POST" action="{{ route('logout') }}" class="w-full">
                        @csrf
                        <flux:menu.item as="button" type="submit" icon="arrow-right-start-on-rectangle" class="w-full">
                            {{ __('Log Out') }}
                        </flux:menu.item>
                    </form>
                </flux:menu>
            </flux:dropdown>
        </flux:header>

        {{ $slot }}

        @fluxScripts
    </body>
</html>
