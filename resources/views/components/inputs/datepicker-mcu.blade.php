@props(['id', 'error' => null, 'formEmployee'])

<input {{ $attributes }} type="text" class="form-control datetimepicker-input @error($error) is-invalid @enderror"
    id="{{ $id }}" data-toggle="datetimepicker" data-target="#{{ $id }}"
    onchange="this.dispatchEvent(new InputEvent('input'))" autocomplete="off" {{ $formEmployee }} />

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
        $('#{{ $id }}').datepicker({
            format: 'MM dd, yyyy'
        });

        window.initDatePicker = () => {
            $('.datetimepicker-input').datepicker({
                format: 'MM dd, yyyy'
            });
        }

        initDatePicker('.datetimepicker-input');

        window.livewire.on('datetimepicker-input', () => {
            initDatePicker();
        });
    </script>
@endpush
