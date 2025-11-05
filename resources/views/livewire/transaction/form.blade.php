<div class="space-y-6">
    <flux:select 
        wire:model="form.branch_id"
        :label="__('Branch')"
        :disabled="($branches->count() === 1)"
    >
        <option value="">{{ __('-- Select Branch --') }}</option>
        @foreach($branches as $branch)
            <option value="{{ $branch->id }}">{{ $branch->name }}</option>
        @endforeach
    </flux:select>

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
    <div class="space-y-4">
        @foreach ($items as $index => $item)
        <div class="flex items-end gap-3">
            <flux:select
                wire:model="items.{{ $index }}.product_id"
                :label="__('Product') . ' #' . ($index + 1)"
                class="flex-1"
            >
                <option value="">{{ __('-- Select Product --') }}</option>
                @foreach ($products as $product)
                    <option value="{{ $product->id }}">{{ $product->name }} - {{ $product->size }} - {{ $product->brand }}</option>
                @endforeach
            </flux:select>

            <flux:input
                wire:model="items.{{ $index }}.quantity"
                :label="__('Qty')"
                type="text"
                class="w-28"
            />

            <flux:select
                wire:model="items.{{ $index }}.type"
                :label="__('Type')"
                class="w-36"
            >
                <option value="">{{ __('-- Select Type --') }}</option>
                @foreach ($types as $type)
                    <option value="{{ $type }}">{{ $type }}</option>
                @endforeach
            </flux:select>

            @if ($loop->last)
                <flux:button wire:click="addItem" icon="plus" variant="primary" />
            @else
                <flux:button wire:click="removeItem({{ $index }})" icon="minus" variant="danger"/>
            @endif
        </div>
    @endforeach
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