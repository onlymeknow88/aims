@props(['id', 'error' => null])

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

<input {{ $attributes }} type="text" class="form-control datetimepicker-input @error($error) is-invalid @enderror"
    id="{{ $id }}" data-toggle="datepicker" autocomplete="off" />

@once
    @push('styles')
        <!-- datepicker -->
        <link href="https://cdn.jsdelivr.net/npm/bootstrap-datepicker@1.9.0/dist/css/bootstrap-datepicker3.min.css"
            rel="stylesheet">
        </link>
    @endpush
@endonce

@once
    @push('scripts')
        <!-- datepicker -->
        <script src="https://cdn.jsdelivr.net/npm/bootstrap-datepicker@1.9.0/dist/js/bootstrap-datepicker.min.js"></script>
    @endpush
@endonce

@push('scripts')
    <script type="text/javascript">
        $(function() {
            const initDatePicker_{{ str_replace('-', '_', $id) }} = () => {
                const $el = $('#{{ $id }}');
                if (!$el.length) return;

                // Only initialize if not already initialized
                if (!$el.data('datepicker')) {
                    $el.datepicker({
                        format: 'MM dd, yyyy',
                        autoclose: true,
                        todayHighlight: true
                    }).on('changeDate', function(e) {
                        const formattedDate = $el.val();
                        const currentVal = @this.get('{{ $modelName }}');
                        if (currentVal !== formattedDate) {
                            @this.set('{{ $modelName }}', formattedDate, {{ $isDeferred ? 'true' : 'false' }});
                        }
                    });
                }

                // Set value from Livewire if present and different
                const val = @this.get('{{ $modelName }}');
                if (val !== undefined && val !== null && $el.val() !== val) {
                    $el.datepicker('update', val);
                }
            };

            initDatePicker_{{ str_replace('-', '_', $id) }}();

            window.livewire.on('datetimepicker-input', () => {
                initDatePicker_{{ str_replace('-', '_', $id) }}();
            });
        });
    </script>
@endpush
