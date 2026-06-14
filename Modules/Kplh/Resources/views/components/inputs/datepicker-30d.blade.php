@props(['id', 'placeholder', 'error' => null])

<input {{ $attributes }} type="text" class="form-control datetimepicker-input @error($error) is-invalid @enderror"
    id="{{ $id }}" data-toggle="datetimepicker" data-target="#{{ $id }}"  data-placeholder="{{$placeholder}}"
    onchange="this.dispatchEvent(new InputEvent('input'))" autocomplete="off" />
@error($error)
    <div class="invalid-feedback">
        {{ $message }}
    </div>
@enderror

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
        $('#{{ $id }}').datepicker({
            date: new Date(),
            format: 'MM dd, yyyy',
            autoclose: true,
            todayHighlight: true,
            startDate: '-30d',
            endDate: '1d'
        });

        window.initDatePicker = () => {
            $('.datetimepicker-input').datepicker({
                format: 'MM dd, yyyy',
                autoclose: true
            });
        }

        initDatePicker('.datetimepicker-input');

        window.livewire.on('datetimepicker-input', () => {
            initDatePicker();
        });
    </script>
@endpush
