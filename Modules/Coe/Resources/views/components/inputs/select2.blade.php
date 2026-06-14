@props(['placeholder' => 'Select Options', 'id'])

<div>
    <select {{ $attributes }} data-placeholder="{{ $placeholder }}" id="{{ $id }}" class="form-select w-100 select2">
        <option></option>
        {{ $slot }}
    </select>
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
            window.initSelect2 = (id) => {
                $(id).select2({
                    theme: 'bootstrap-5',
                });
            }

            initSelect2('#{{ $id }}');

            $('#{{ $id }}').on('change', function(e) {
                let elementName = $(this).attr('wire:model');
                let child = $(this).data('child');
                @this.set(elementName, e.target.value);
                if (child) {
                    $('#' + child).select2("destroy").select2({
                        theme: 'bootstrap-5',
                    });
                }

            });
            window.livewire.on('select2', () => {
                initSelect2('#{{ $id }}');
            });
        })
    </script>
@endpush
