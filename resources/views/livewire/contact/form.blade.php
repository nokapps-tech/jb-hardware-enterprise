<div class="space-y-6">
    
    <div>
        <flux:input wire:model="form.first_name" :label="__('First Name')" type="text" autocomplete="form.first_name"/>
    </div>
    <div>
        <flux:input wire:model="form.last_name" :label="__('Last Name')" type="text" autocomplete="form.last_name"/>
    </div>
    <div>
        <flux:input wire:model="form.email" :label="__('Email')" type="text" autocomplete="form.email"/>
    </div>
    <div>
        <flux:input wire:model="form.phone" :label="__('Phone')" type="text" autocomplete="form.phone"/>
    </div>
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
        <flux:input wire:model="form.job_title" :label="__('Job Title')" type="text" autocomplete="form.job_title"/>
    </div>

    <div class="flex items-center gap-4">
        <flux:button variant="primary" type="submit">{{ __('Submit') }}</flux:button>
    </div>
</div>