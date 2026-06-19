@props(['placeholder' => 'Select Options', 'id'])

@php
    $modelName = null;
    $isDeferred = false;
    if ($attributes->has('wire:model')) {
        $modelName = $attributes->get('wire:model');
    } elseif ($attributes->has('wire:model.defer')) {
        $modelName = $attributes->get('wire:model.defer');
        $isDeferred = true;
    } elseif ($attributes->has('wire:model.lazy')) {
        $modelName = $attributes->get('wire:model.lazy');
    } else {
        foreach ($attributes->getAttributes() as $key => $value) {
            if (str_starts_with($key, 'wire:model')) {
                $modelName = $value;
                if (str_contains($key, '.defer')) {
                    $isDeferred = true;
                }
                break;
            }
        }
    }
    $modelName = $modelName ?? $id;
@endphp

<div wire:ignore>
    <select {{ $attributes }} data-placeholder="{{$placeholder}}" id="{{ $id }}" class="form-select w-100 select2" multiple="multiple">
        <option></option>
        {{ $slot }}
    </select>
</div>

@once
    @push('styles')
        <!-- Select2 -->
        <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/select2-bootstrap-5-theme@1.3.0/dist/select2-bootstrap-5-theme.min.css" />
    @endpush
@endonce

@once
    @push('scripts')
    <!-- Select2 -->
        <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    @endpush
@endonce

@push('scripts')
    <script>
        $(function() {
            const initSelect2Mult_{{ str_replace('-', '_', $id) }} = () => {
                const $el = $('#{{ $id }}');
                if (!$el.length) return;

                if (!$el.hasClass("select2-hidden-accessible")) {
                    $el.select2({
                        theme: 'bootstrap-5',
                        placeholder: '{{ $placeholder }}',
                        allowClear: true
                    });
                }

                // Set value from Livewire if present and different
                const val = @this.get('{{ $modelName }}');
                if (val !== undefined && val !== null && JSON.stringify($el.val()) !== JSON.stringify(val)) {
                    $el.val(val).trigger('change.select2');
                }

                $el.off('change.select2-hook');
                $el.on('change.select2-hook', function (e) {
                    var data = $(this).val();
                    let elementName = $(this).attr('id');
                    const currentVal = @this.get('{{ $modelName }}');
                    if (JSON.stringify(currentVal) !== JSON.stringify(data)) {
                        @this.set(elementName, data, {{ $isDeferred ? 'true' : 'false' }});
                    }
                });
            };

            initSelect2Mult_{{ str_replace('-', '_', $id) }}();

            window.livewire.on('select2', () => {
                initSelect2Mult_{{ str_replace('-', '_', $id) }}();
            });
        })
    </script>
@endpush