<div class="space-y-6">
    
    <div>
        <flux:input wire:model="form.product_code" :label="__('Product Code')" type="text" autocomplete="form.product_code"/>
    </div>
    <div>
        <flux:input wire:model="form.sku" :label="__('Sku')" type="text" autocomplete="form.sku"/>
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
        <flux:input wire:model="form.description" :label="__('Description')" type="text" autocomplete="form.description"/>
    </div>
    <div>
        <flux:input wire:model="form.price" :label="__('Price')" type="text" autocomplete="form.price"/>
    </div>
    <div>
        <flux:input wire:model="form.cost" :label="__('Cost')" type="text" autocomplete="form.cost"/>
    </div>
    <div>
        <flux:input wire:model="form.stock" :label="__('Stock')" type="text" autocomplete="form.stock"/>
    </div>

    <div class="flex items-center gap-4">
        <flux:button variant="primary" type="submit">{{ __('Submit') }}</flux:button>
    </div>
</div>