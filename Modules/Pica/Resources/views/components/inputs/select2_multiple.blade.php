@props(['placeholder' => 'Select Options', 'id'])

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
            $('#{{ $id }}').select2({
                    theme: 'bootstrap-5',
                });
            
            $('#{{ $id }}').on('change', function (e) {
                var data = $(this).select2("val");
                let elementName = $(this).attr('id');
                @this.set(elementName, data);
            });
        })
    </script>
@endpush