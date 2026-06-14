@props(['id', 'error'])

<div class="form-check form-check-inline">
    <input {{ $attributes }} class="form-check-input" type="radio" name="jk" id="{{ $id }}-1" value="l">
    <label class="form-check-label" for="{{ $id }}-1">Laki-laki</label>
</div>
<div class="form-check form-check-inline">
    <input {{ $attributes }} class="form-check-input" type="radio" name="jk" id="{{ $id }}-1" value="p">
    <label class="form-check-label" for="{{ $id }}-2">Perempuan</label>
</div>