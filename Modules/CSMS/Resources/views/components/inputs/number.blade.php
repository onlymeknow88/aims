@props(['id', 'error'])

<input {{ $attributes }} type="number" class="form-control opacity-80 @error($error) is-invalid @enderror" id="{{ $id }}" />
@error($error)
    <div class="invalid-feedback">
        {{ $message }}
    </div>
@enderror
