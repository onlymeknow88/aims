@props(['placeholder' => 'Select Options', 'id', 'parent' => 'none', 'error' => false, 'disableChange' => true, 'disabled' => false])

<div>
    <select {{ $attributes }} data-placeholder="{{ $placeholder }}" @if ($disabled) disabled @endif
        id="{{ $id }}" class="form-select w-100 select2 form-control @error($error) is-invalid @enderror">
        <option></option>
        {{ $slot }}
    </select>
    @error($error)
        <div class="invalid-feedback">
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
            window.initSelect2 = (id, parent) => {
                let option = {
                    theme: 'bootstrap-5',
                    width: '100%',
                };
                if (parent != 'none') {
                    option = {
                        theme: 'bootstrap-5',
                        width: '100%',
                        dropdownParent: $('#' + parent),
                    };
                }
                $(id).select2(option);
            }

            initSelect2('#{{ $id }}', '{{ $parent }}');

            window.livewire.on('select2', () => {
                initSelect2('#{{ $id }}', '{{ $parent }}');
            });
        });
    </script>

    @if ($disableChange)
        <script>
            $('#{{ $id }}').on('change', function(e) {
                let elementName = $(this).attr('id');
                let child = $(this).data('child');
                @this.set(elementName, e.target.value);
                if (child) {
                    $('#' + child).select2("destroy").select2({
                        theme: 'bootstrap-5',
                    });
                }

            });
        </script>
    @endif
@endpush
