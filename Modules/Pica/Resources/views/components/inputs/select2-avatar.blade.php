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
        <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
        <link rel="stylesheet"
            href="https://cdn.jsdelivr.net/npm/select2-bootstrap-5-theme@1.3.0/dist/select2-bootstrap-5-theme.min.css" />
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
            const initAvatar_{{ str_replace('-', '_', $id) }} = () => {
                const $el = $('#{{ $id }}');
                if (!$el.length) return;

                function formatState(state) {
                    var selectedItems = '<span class="selected-item"></span>';
                    var avatar = $(state.element).data('avatar');
                    var email = $(state.element).data('email');
                    var emailText = '';
                    if (email) {
                        emailText = '<i class="fa-solid fa-circle"></i><span class="email">' + email + '</span>';
                    }
                    if (!state.id) {
                        return state.text;
                    }
                    var $state = $(
                        selectedItems + '<span><img src="' + avatar +
                        '" class="img-profile" /></span><span class="text">' + state.text + '</span>' + emailText
                    );
                    return $state;
                }

                let option = {
                    theme: 'bootstrap-5',
                    width: '100%',
                    placeholder: '{{ $placeholder }}',
                    allowClear: true,
                    templateResult: formatState,
                    templateSelection: formatState
                };
                if ('{{ $parent }}' !== 'none') {
                    option.dropdownParent = $('#{{ $parent }}');
                }

                // Only initialize if not already initialized
                if (!$el.hasClass("select2-hidden-accessible")) {
                    $el.select2(option);
                }

                // Set value from Livewire if present and different
                const val = @this.get('{{ $modelName }}');
                if (val !== undefined && val !== null && $el.val() !== val) {
                    $el.val(val).trigger('change.select2');
                }

                // Unbind previous change listeners to prevent duplicates
                $el.off('change.select2-hook');
                $el.on('change.select2-hook', function(e) {
                    @this.set('{{ $modelName }}', e.target.value, {{ $isDeferred ? 'true' : 'false' }});
                });
            };

            // Run initialization
            initAvatar_{{ str_replace('-', '_', $id) }}();

            // Re-initialize when the select2 event is fired
            window.livewire.on('select2', () => {
                initAvatar_{{ str_replace('-', '_', $id) }}();
            });
        });
    </script>
@endpush
