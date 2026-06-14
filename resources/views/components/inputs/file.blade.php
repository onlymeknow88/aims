@props(['id', 'error'])

<input {{ $attributes }} type="file" class="form-control @error($error) is-invalid @enderror" id="{{ $id }}" />

@error($error)
    <div class="invalid-feedback">
        {{ $message }}
    </div>
@enderror