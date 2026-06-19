@props([
    'placeholder' => 'Select Options',
    'id',
    'parent' => 'none',
    'error' => false,
    'disableChange' => true,
    'disabled' => false
])

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

@php
    $slotStr = (string) $slot;
    $optionsHash = md5($slotStr);
    $wireKey = "select2-wrapper-{$id}-{$optionsHash}";
@endphp

<div>
    <div wire:ignore wire:key="{{ $wireKey }}">
        <select {{ $attributes }} data-placeholder="{{ $placeholder }}" @if ($disabled) disabled @endif
            id="{{ $id }}" class="form-select w-100 select2 form-control @error($error) is-invalid @enderror">
            <option></option>
            {!! $slotStr !!}
        </select>
    </div>
    @error($error)
        <div class="invalid-feedback d-block">
            {{ $message }}
        </div>
    @enderror
</div>

@once
    @push('styles')
        <!-- Select2 -->
        <link href="{{ asset('assets/libs/select2/css/select2.min.css') }}" rel="stylesheet" />
        <link href="{{ asset('assets/libs/select2-bootstrap-5-theme/select2-bootstrap-5-theme.min.css') }}" rel="stylesheet" />
    @endpush
@endonce

@once
    @push('scripts')
        <!-- Select2 -->
        <script src="{{ asset('assets/libs/select2/js/select2.min.js') }}"></script>
    @endpush
@endonce

@push('scripts')
    <script>
        $(function() {
            const initSelect2_{{ str_replace(['-', '.'], '_', $id) }} = () => {
                const $el = $(document.getElementById('{{ $id }}'));
                if (!$el.length) return;

                let option = {
                    theme: 'bootstrap-5',
                    width: '100%',
                    placeholder: '{{ $placeholder }}',
                    allowClear: true
                };
                if ('{{ $parent }}' !== 'none') {
                    option.dropdownParent = $(document.getElementById('{{ $parent }}'));
                }

                // Only initialize if not already initialized
                if (!$el.hasClass("select2-hidden-accessible")) {
                    $el.select2(option);
                }

                // Set value from Livewire if present and different
                const val = @this.get('{{ $modelName }}');
                if (val !== undefined && val !== null && $el.val() !== val) {
                    $el.val(val).trigger('change.select2', [true]);
                }

                @if ($disableChange)
                    // Unbind previous change listeners to prevent duplicates
                    $el.off('change.select2-hook');
                    $el.on('change.select2-hook', function(e, programmatic) {
                        if (programmatic) return;

                        const currentVal = @this.get('{{ $modelName }}');
                        const isSame = (currentVal == e.target.value) || 
                                       ((currentVal === null || currentVal === undefined || currentVal === '') && 
                                        (e.target.value === null || e.target.value === undefined || e.target.value === ''));
                        if (!isSame) {
                            @this.set('{{ $modelName }}', e.target.value, {{ $isDeferred ? 'true' : 'false' }});
                        }
                        let childStr = $(this).data('child');
                        if (childStr) {
                            let children = childStr.split(',');
                            children.forEach(function(childId) {
                                const $child = $(document.getElementById(childId.trim()));
                                if ($child.length) {
                                    $child.val(null).prop('disabled', true).trigger('change', [true]);
                                    const $container = $child.next('.select2-container');
                                    if ($container.length) {
                                        $container.addClass('select2-container--disabled');
                                        $container.css({
                                            'pointer-events': 'none',
                                            'opacity': '0.6'
                                        });
                                    }
                                }
                            });
                        }
                    });
                @endif
            };

            // Run initialization
            initSelect2_{{ str_replace(['-', '.'], '_', $id) }}();

            // Re-initialize when the select2 event is fired
            window.livewire.on('select2', () => {
                initSelect2_{{ str_replace(['-', '.'], '_', $id) }}();
            });
        });
    </script>
@endpush
