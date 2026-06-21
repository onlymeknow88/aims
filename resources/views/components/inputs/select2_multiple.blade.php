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
        {{ $slot }}
    </select>
</div>

@once
    @push('styles')
        <!-- Select2 -->
        <link href="{{ asset('assets/libs/select2/css/select2.min.css') }}" rel="stylesheet" />
        <!--<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />-->
        <!--<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/select2-bootstrap-5-theme@1.3.0/dist/select2-bootstrap-5-theme.min.css" />-->
        <link href="{{ asset('assets/libs/select2-bootstrap-5-theme/select2-bootstrap-5-theme.min.css') }}" rel="stylesheet" />
    @endpush
@endonce

@once
    @push('scripts')
    <!-- Select2 -->
        <!--<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>-->
        <script src="{{ asset('assets/libs/select2/js/select2.min.js') }}"></script>
    @endpush
@endonce

@push('scripts')
    <script>
        $(function() {
            const initSelect2Multiple = () => {
                const $el = $('#{{ $id }}');
                if (!$el.length) return;

                if (!$el.hasClass("select2-hidden-accessible")) {
                    $el.select2({
                        theme: 'bootstrap-5',
                        closeOnSelect: false,
                        placeholder: '{{ $placeholder }}'
                    });
                }

                // Sync from Livewire if needed
                const val = @this.get('{{ $modelName }}');
                if (val !== undefined && val !== null && JSON.stringify($el.val() || []) !== JSON.stringify(val || [])) {
                    $el.val(val).trigger('change.select2');
                }

                $el.off('change.select2-hook');
                $el.on('change.select2-hook', function (e) {
                    var data = $(this).select2("val");
                    const currentVal = @this.get('{{ $modelName }}');
                    const isSame = JSON.stringify(currentVal || []) === JSON.stringify(data || []);
                    
                    if (!isSame) {
                        @this.set('{{ $modelName }}', data, {{ $isDeferred ? 'true' : 'false' }});
                    }
                });
            };

            initSelect2Multiple();

            window.livewire.on('select2', () => {
                initSelect2Multiple();
            });
        })
    </script>
@endpush