<div class="space-y-6">
    
    <div>
        <flux:input wire:model="form.name" :label="__('Name')" type="text" autocomplete="form.name"/>
    </div>
    <div>
        <flux:select 
            wire:model="form.segment" 
            :label="__('Segment')"
        >
            <option value="">{{ __('-- Select Segment --') }}</option>
            @foreach($segments as $segment)
                <option value="{{ $segment }}">{{ $segment }}</option>
            @endforeach
        </flux:select>
    </div>
    <div>
        <flux:select 
            wire:model="form.type" 
            :label="__('Type')"
        >
            <option value="">{{ __('-- Select Type --') }}</option>
            @foreach($types as $type)
                <option value="{{ $type }}">{{ $type }}</option>
            @endforeach
        </flux:select>
    </div>
    <div>
        <flux:input wire:model="form.email" :label="__('Email')" type="text" autocomplete="form.email"/>
    </div>
    <div>
        <flux:input wire:model="form.phone" :label="__('Phone')" type="text" autocomplete="form.phone"/>
    </div>
    <div>
        <flux:select 
            wire:model="form.contact_id" 
            :label="__('Contact')"
        >
            <option value="">{{ __('-- Select Contact --') }}</option>
            @foreach($contacts as $contact)
                <option value="{{ $contact->id }}">{{ $contact->first_name }} {{ $contact->last_name }}</option>
            @endforeach
        </flux:select>
    </div>
    <div>
        <flux:input wire:model="form.address" :label="__('Address')" type="text" autocomplete="form.address"/>
    </div>

    <div class="flex items-center gap-4">
        <flux:button variant="primary" type="submit">{{ __('Submit') }}</flux:button>
    </div>
</div>