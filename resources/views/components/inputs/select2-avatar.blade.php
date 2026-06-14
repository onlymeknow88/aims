@props(['placeholder' => 'Select Options', 'id', 'error' => false])

<div>
    <select {{ $attributes }}
        id="{{ $id }}"
        data-placeholder="{{ $placeholder }}"
        class="w-full form-select @error($error) is-invalid @enderror">
        <option></option>
        {{-- <option data-avatar="{{asset('./images/no-profile.png')}}" selected>{{ $placeholder }}</option> --}}
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
            window.initAvatar = () => {
                $('#{{ $id }}').select2({
                    placeholder: 'test',
                    theme: 'bootstrap-5',
                    templateResult: formatState,
                    templateSelection: formatState,
                });
            }

            function formatState(state) {
                var selectedItems = '<span class="selected-item"></span>';

                var avatar = $(state.element).data('avatar');
                var email = $(state.element).data('email');
                var emailText = '';
                if (email) {
                    emailText = '<i class="fa-solid fa-circle"></i><span class="email">' + email + '</span>';
                }
                if (!state.id) {
                    return state.text;
                }
                var $state = $(
                    selectedItems + '<span><img src="' + avatar +
                    '" class="img-profile" /></span><span class="text">' + state.text + '</span>' + emailText
                );
                return $state;
            };

            initAvatar();

            $('#{{ $id }}').on('change', function(e) {
                let elementName = $(this).attr('id');
                @this.set(elementName, e.target.value);
            });

            window.livewire.on('select2',()=>{
                initAvatar();
            });
        });
    </script>
@endpush
