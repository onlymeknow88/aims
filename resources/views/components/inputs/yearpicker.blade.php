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
        <!--<link href="https://cdn.jsdelivr.net/npm/bootstrap-datepicker@1.9.0/dist/css/bootstrap-datepicker3.min.css" rel="stylesheet"></link>-->
        <link rel="stylesheet" href="{{ asset('assets/libs/bootstrap-datepicker/css/bootstrap-datepicker3.min.css') }}">
    @endpush
@endonce

@once
    @push('scripts')
        <!-- datepicker -->
        <!--<script src="https://cdn.jsdelivr.net/npm/bootstrap-datepicker@1.9.0/dist/js/bootstrap-datepicker.min.js"></script>-->
        <script src="{{ asset('assets/libs/bootstrap-datepicker/js/bootstrap-datepicker.min.js') }}"></script>
    @endpush
@endonce

@push('scripts')
    <script type="text/javascript">
        $('#{{ $id }}').datepicker({
            format: "yyyy",
            viewMode: "years",
            minViewMode: "years"
        });
        // $('#{{ $id }}.input-daterange input').each(function() {
        //     $(this).datepicker({
        //         format: "yyyy",
        //         viewMode: "years", 
        //         minViewMode: "years"
        //     });
        // });
        // // $('#{{ $id }}').datepicker({
        // // 	format: 'MM dd, yyyy'
        // // });
    </script>
@endpush
