<div class="space-y-6">
    
    <div>
        <flux:input wire:model="form.transaction_number" :label="__('Transaction Number')" type="text" autocomplete="form.transaction_number"/>
    </div>
    <div>
        <flux:select 
            wire:model="form.product_id" 
            :label="__('Product')"
        >
            <option value="">{{ __('-- Select Product --') }}</option>
            @foreach($products as $product)
                <option value="{{ $product->id }}">{{ $product->name }}</option>
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
        <flux:input wire:model="form.quantity" :label="__('Quantity')" type="text" autocomplete="form.quantity"/>
    </div>
    <div>
        <flux:input wire:model="form.description" :label="__('Description')" type="text" autocomplete="form.description"/>
    </div>
    <div>
        <flux:input wire:model="form.notes" :label="__('Notes')" type="text" autocomplete="form.notes"/>
    </div>
    <div>
        <flux:input 
            wire:model="form.order_date" 
            :label="__('Order Date')" 
            type="date" 
        />
    </div>
    <div>
        <flux:select 
            wire:model="form.status" 
            :label="__('Status')"
        >
            <option value="">{{ __('-- Select Status --') }}</option>
            @foreach($statuses as $status)
                <option value="{{ $status }}">{{ $status }}</option>
            @endforeach
        </flux:select>
    </div>

    <div class="flex items-center gap-4">
        <flux:button variant="primary" type="submit">{{ __('Submit') }}</flux:button>
    </div>
</div>