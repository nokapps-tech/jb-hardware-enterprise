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
    <div class="space-y-2">
        <label class="block text-sm font-medium">{{ __('Branches') }}</label>
        <div class="grid grid-cols-2 gap-2">
            @foreach($branches as $branch)
                <label class="flex items-center space-x-2">
                    <input
                        type="checkbox"
                        wire:model="form.branch_ids"
                        value="{{ $branch->id }}"
                        class="rounded border-gray-300 text-primary focus:ring-primary"
                    >
                    <span>{{ $branch->name }}</span>
                </label>
            @endforeach
        </div>
    </div>


    <div class="flex items-center gap-4">
        <flux:button variant="primary" type="submit">{{ __('Submit') }}</flux:button>
    </div>
</div>