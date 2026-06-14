@props(['id', 'error'])

<input {{ $attributes }} type="text" class="form-control @error($error) is-invalid @enderror" id="{{ $id }}" />
@error($error)
    <div class="invalid-feedback">
        {{ $message }}
    </div>
@enderror

@once
    @push('plugin-alpine')
        <script src="{{ asset('assets/libs/alpine-mask/cdn.min.js') }}"></script>
    @endpush
@endonce
