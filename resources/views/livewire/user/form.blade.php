<div class="space-y-6">
    
    <div>
        <flux:input wire:model="form.name" :label="__('Name')" type="text" autocomplete="form.name"/>
    </div>
    <div>
        <flux:input wire:model="form.email" :label="__('Email')" type="email" autocomplete="form.email"/>
    </div>
    <div>
        <flux:select 
            wire:model="form.role"
            :label="__('Role')"
        >
            <option value="">{{ __('Select Role') }}</option>
            @foreach(\Spatie\Permission\Models\Role::all() as $role)
                <option value="{{ $role->name }}">{{ ucfirst($role->display_text) }}</option>
            @endforeach
        </flux:select>
    </div>

    <div class="flex items-center gap-4">
        <flux:button variant="primary" type="submit">{{ __('Submit') }}</flux:button>
    </div>
</div>