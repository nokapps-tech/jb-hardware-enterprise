<div class="space-y-6">
    
    <div>
        <flux:input wire:model="form.product_code" :label="__('Product Code')" type="text" autocomplete="form.product_code"/>
    </div>
    <div>
        <flux:input wire:model="form.name" :label="__('Name')" type="text" autocomplete="form.name"/>
    </div>
    <div>
        <flux:select 
            wire:model="form.product_category_id" 
            :label="__('Product')"
        >
            <option value="">{{ __('-- Select Product --') }}</option>
            @foreach($product_categories as $product_category)
                <option value="{{ $product_category->id }}">{{ $product_category->name }}</option>
            @endforeach
        </flux:select>
    </div>
    <div>
        <flux:input wire:model="form.notes" :label="__('Notes')" type="text" autocomplete="form.notes"/>
    </div>
    <div>
        <flux:input wire:model="form.price" :label="__('Price')" type="text" autocomplete="form.price"/>
    </div>
    <div>
        <flux:input wire:model="form.cost" :label="__('Cost')" type="text" autocomplete="form.cost"/>
    </div>
    <div>
        <flux:input wire:model="form.size" :label="__('Size')" type="text" autocomplete="form.size"/>
    </div>
    <div>
        <flux:input wire:model="form.unit" :label="__('Unit')" type="text" autocomplete="form.unit"/>
    </div>
    <div>
        <flux:input wire:model="form.quantity" :label="__('Quantity')" type="text" autocomplete="form.quantity"/>
    </div>
    <div>
        <flux:input wire:model="form.threshold" :label="__('Threshold')" type="text" autocomplete="form.threshold"/>
    </div>

    <div class="flex items-center gap-4">
        <flux:button variant="primary" type="submit">{{ __('Submit') }}</flux:button>
    </div>
</div>