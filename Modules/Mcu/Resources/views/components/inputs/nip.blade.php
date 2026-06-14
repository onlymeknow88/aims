@props(['id', 'error'])

<input {{ $attributes }} type="text" class="form-control @error($error) is-invalid @enderror" id="{{ $id }}" />
@error($error)
    <div class="invalid-feedback">
        {{ $message }}
    </div>
@enderror

@once
    @push('plugin-alpine')
        <script defer src="https://unpkg.com/@alpinejs/mask@3.x.x/dist/cdn.min.js"></script>
    @endpush
@endonce
