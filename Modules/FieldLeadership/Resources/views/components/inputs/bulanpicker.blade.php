@props(['id', 'error'])

<input {{ $attributes }} type="text" class="form-control datetimepicker-input @error($error) is-invalid @enderror" id="{{ $id }}" data-toggle="datetimepicker" data-target="#{{ $id }}"
onchange="this.dispatchEvent(new InputEvent('input'))"
/>
@error($error)
    <div class="invalid-feedback">
        {{ $message }}
    </div>
@enderror


@once
    @push('styles')
        <!-- datepicker -->
        <link href="{{ asset('assets/libs/bootstrap-datepicker/css/bootstrap-datepicker3.min.css') }}"
            rel="stylesheet">
        </link>
    @endpush
@endonce

@once
    @push('scripts')
        <!-- datepicker -->
        <script src="{{ asset('assets/libs/bootstrap-datepicker/js/bootstrap-datepicker.min.js') }}"></script>
    @endpush
@endonce

@push('scripts')
    <script type="text/javascript">
        $('#{{ $id }}').datepicker({
            format: "mm-yyyy",
            viewMode: "months",
            minViewMode: "months"
        });
    </script>
@endpush
