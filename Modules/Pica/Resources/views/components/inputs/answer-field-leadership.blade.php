@props(['id', 'name', 'error'])

<div class="form-check">
    <input {{ $attributes }} class="form-check-input" type="radio" name="{{ $name }}" id="{{ $id }}-1"
        value="Ya">
    <label class="label">Ya</label>
</div>
<div class="form-check">
    <input {{ $attributes }} class="form-check-input" type="radio" name="{{ $name }}"
        id="{{ $id }}-1" value="Tidak">
    <label class="label">Tidak</label>
</div>
