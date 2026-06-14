@props(['id', 'error'])

<textarea {{ $attributes }} name="description" class="form-control @error($error) is-invalid @enderror" id="{{ $id }}"></textarea>
@error($error)
    <div class="invalid-feedback">
        {{ $message }}
    </div>
@enderror
