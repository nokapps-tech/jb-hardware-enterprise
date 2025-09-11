<div class="space-y-6">
    
    <div>
        <flux:input wire:model="form.display_text" :label="__('Display Text')" type="text" autocomplete="form.display_text"/>
    </div>
    <div>
        <flux:input wire:model="form.name" :label="__('Name')" type="text" autocomplete="form.name"/>
    </div>
    <div>
        <flux:input wire:model="form.guard_name" :label="__('Guard Name')" type="text" autocomplete="form.guard_name"/>
    </div>
    <div>
        <flux:input wire:model="form.description" :label="__('Description')" type="text" autocomplete="form.description"/>
    </div>
    <div>
        <flux:input wire:model="form.readonly" :label="__('Readonly')" type="text" autocomplete="form.readonly"/>
    </div>

    <div class="flex items-center gap-4">
        <flux:button variant="primary" type="submit">{{ __('Submit') }}</flux:button>
    </div>
</div>