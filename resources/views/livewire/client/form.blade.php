<div class="space-y-6">
    
    <div>
        <flux:input wire:model="form.name" :label="__('Name')" type="text" autocomplete="form.name"/>
    </div>
    <div>
        <flux:input wire:model="form.email" :label="__('Email')" type="text" autocomplete="form.email"/>
    </div>
    <div>
        <flux:input wire:model="form.phone" :label="__('Phone')" type="text" autocomplete="form.phone"/>
    </div>
    <div>
        <flux:input wire:model="form.address" :label="__('Address')" type="text" autocomplete="form.address"/>
    </div>
    <div>
        <flux:input wire:model="form.notes" :label="__('Notes')" type="text" autocomplete="form.notes"/>
    </div>

    <div class="flex items-center gap-4">
        <flux:button variant="primary" type="submit">{{ __('Submit') }}</flux:button>
    </div>
</div>