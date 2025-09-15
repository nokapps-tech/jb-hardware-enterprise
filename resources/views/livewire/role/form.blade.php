<div class="space-y-6">
    
    <div>
        <flux:input wire:model="form.display_text" :label="__('Display Text')" type="text" autocomplete="form.display_text"/>
    </div>
    <!-- <div>
        <flux:input wire:model="form.name" :label="__('Name')" type="text" autocomplete="form.name"/>
    </div> -->
    <!-- <div>
        <flux:input wire:model="form.guard_name" :label="__('Guard Name')" type="text" autocomplete="form.guard_name"/>
    </div> -->
    <div>
        <flux:input wire:model="form.description" :label="__('Description')" type="text" autocomplete="form.description"/>
    </div>
    <div>
        <flux:label>{{ __('Permissions') }}</flux:label>

        <div class="space-y-4">
            @foreach($form->availablePermissions() as $category => $permissions)
                <div class="border rounded-lg p-3">
                    <h3 class="font-semibold text-sm text-white-800 mb-2 capitalize">
                        {{ str_replace('_', ' ', $category) }}
                    </h3>

                    <div class="grid grid-cols-2 gap-2">
                        @foreach($permissions as $permission)
                            <label class="flex items-center space-x-2">
                                <input type="checkbox"
                                    wire:model="form.permissions"
                                    value="{{ $permission->name }}"
                                    class="rounded border-gray-300">
                                <span>{{ $permission->display_text ?? $permission->name }}</span>
                            </label>
                        @endforeach
                    </div>
                </div>
            @endforeach
        </div>
    </div>

    <!-- <div>
        <flux:input wire:model="form.readonly" :label="__('Readonly')" type="text" autocomplete="form.readonly"/>
    </div> -->

    <div class="flex items-center gap-4">
        <flux:button variant="primary" type="submit">{{ __('Submit') }}</flux:button>
    </div>
</div>