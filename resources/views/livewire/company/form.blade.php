<div class="space-y-6">
    
    <div>
        <flux:input wire:model="form.name" :label="__('Name')" type="text" autocomplete="form.name"/>
    </div>
    <div>
        <flux:input wire:model="form.industry" :label="__('Industry')" type="text" autocomplete="form.industry"/>
    </div>
    <div>
        <flux:input wire:model="form.website" :label="__('Website')" type="text" autocomplete="form.website"/>
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
        <flux:input wire:model="form.postal_code" :label="__('Postal Code')" type="text" autocomplete="form.postal_code"/>
    </div>

    <div class="flex items-center gap-4">
        <flux:button variant="primary" type="submit">{{ __('Submit') }}</flux:button>
    </div>
</div>