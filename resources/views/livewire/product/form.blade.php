<div class="space-y-6">

    <!-- Product Code -->
    <div class="mt-2 flex items-end gap-2">
        <flux:input wire:model="form.product_code" :label="__('Product Code')" type="text" autocomplete="form.product_code"/>
        <flux:button variant="primary" type="button" id="start-scan">
            {{ __('Scan with Camera') }}
        </flux:button>
    </div>


    <div id="camera-container" class="mt-4 hidden">
        <video id="camera-preview" class="rounded shadow w-80"></video>
        <p id="scan-result" class="mt-2 text-gray-700"></p>
    </div>

    <!-- Other Product Fields -->
    <div>
        <flux:select wire:model="form.branch_id" :label="__('Branch')">
            <option value="">{{ __('-- Select Branch --') }}</option>
            @foreach($branches as $branch)
                <option value="{{ $branch->id }}">{{ $branch->name }}</option>
            @endforeach
        </flux:select>
    </div>
    <div>
        <flux:input wire:model="form.name" :label="__('Name')" type="text" autocomplete="form.name"/>
    </div>
    <div>
        <flux:select wire:model="form.product_category_id" :label="__('Product')">
            <option value="">{{ __('-- Select Product Category --') }}</option>
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
        <flux:input wire:model="form.brand" :label="__('Brand')" type="text" autocomplete="form.brand"/>
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

    <!-- Submit Button -->
    <div class="flex items-center gap-4">
        <flux:button variant="primary" type="submit">{{ __('Submit') }}</flux:button>
    </div>

</div>

<script src="https://cdn.jsdelivr.net/npm/@zxing/library@0.19.1/umd/index.min.js"></script>

<script>
    const startBtn = document.getElementById('start-scan');
    const container = document.getElementById('camera-container');
    const video = document.getElementById('camera-preview');
    const resultEl = document.getElementById('scan-result');

    // Use ZXing from the global object
    const codeReader = new ZXing.BrowserMultiFormatReader();

    startBtn.addEventListener('click', () => {
        container.classList.remove('hidden');

        codeReader.decodeFromVideoDevice(null, video, (result, err) => {
            if (result) {
                const scannedText = result.text; // UMD version uses `text` property
                resultEl.innerText = "Scanned: " + scannedText;

                // Update Livewire fields
                const livewireComponent = Livewire.find(
                    document.querySelector('[wire\\:id]').getAttribute('wire:id')
                );
                livewireComponent.set('form.product_code', scannedText);

                codeReader.reset();
                container.classList.add('hidden');
            }

            if (err && !(err instanceof ZXing.NotFoundException)) {
                console.error('ZXing error:', err);
            }
        });
    });
</script>
