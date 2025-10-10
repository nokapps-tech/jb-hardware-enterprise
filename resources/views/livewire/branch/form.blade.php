<div class="space-y-6">
    
    <div>
        <flux:input wire:model="form.name" :label="__('Name')" type="text" autocomplete="form.name"/>
    </div>
    <div>
        <flux:input wire:model="form.contact_number" :label="__('Contact Number')" type="text" autocomplete="form.contact_number"/>
    </div>
    <div>
        <flux:input wire:model="form.address" :label="__('Address')" type="text" autocomplete="form.address"/>
    </div>
    <div>
        <flux:input wire:model="form.description" :label="__('Description')" type="text" autocomplete="form.description"/>
    </div>

    <div class="flex items-center gap-4">
        <flux:button variant="primary" type="submit">{{ __('Submit') }}</flux:button>
    </div>
</div>