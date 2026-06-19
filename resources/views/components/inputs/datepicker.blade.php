@props(['id', 'error' => null])

<div>
    <input {{ $attributes }} type="text" class="form-control datetimepicker-input @error($error) is-invalid @enderror"
           id="{{ $id }}" data-toggle="datetimepicker" data-target="#{{ $id }}"
           onchange="this.dispatchEvent(new InputEvent('input'))" autocomplete="off"/>
    @error($error)
    <div class="invalid-feedback d-block">
        {{ $message }}
    </div>
    @enderror
</div>

@once
    @push('styles')
        <link rel="stylesheet" href="{{ asset('assets/libs/bootstrap-datepicker/css/bootstrap-datepicker3.min.css') }}">
    @endpush
@endonce

@once
    @push('scripts')
        <script src="{{ asset('assets/libs/bootstrap-datepicker/js/bootstrap-datepicker.min.js') }}"></script>
    @endpush
@endonce

@push('scripts')
    <script type="text/javascript">
        $(function() {
            const $el = $('#{{ $id }}');
            if (!$el.length) return;

            const initPicker = () => {
                if (!$el.data('datepicker')) {
                    $el.datepicker({
                        format: 'MM dd, yyyy',
                        autoclose: true,
                        todayHighlight: true,
                    });
                }
            };

            initPicker();

            // Re-initialize on livewire events if needed
            window.livewire.on('datetimepicker-input', () => {
                initPicker();
            });
        });
    </script>
@endpush
