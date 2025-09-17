<div class="space-y-6">
    <div>
        <flux:select 
            wire:model="form.company_id" 
            :label="__('Company')"
        >
            <option value="">{{ __('-- Select Company --') }}</option>
            @foreach($companies as $company)
                <option value="{{ $company->id }}">{{ $company->name }}</option>
            @endforeach
        </flux:select>
    </div>
    <div>
        <flux:input wire:model="form.contact_person" :label="__('Contact Person')" type="text" autocomplete="form.contact_person"/>
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

    <div class="flex items-center gap-4">
        <flux:button variant="primary" type="submit">{{ __('Submit') }}</flux:button>
    </div>
</div>