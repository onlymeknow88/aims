@props(['id', 'error'])

<div class="form-check">
    <input {{ $attributes }} class="form-check-input" type="radio" name="type" id="{{ $id }}-1"
        value="Planned Task Observation">
    <label class="form-check-label" for="{{ $id }}-1">Planned Task Observation</label>
</div>
<div class="form-check">
    <input {{ $attributes }} class="form-check-input" type="radio" name="type" id="{{ $id }}-1"
        value="Take Time Talk">
    <label class="form-check-label" for="{{ $id }}-2">Take Time Talk</label>
</div>
<div class="form-check">
    <input {{ $attributes }} class="form-check-input" type="radio" name="type" id="{{ $id }}-1"
        value="Hazard Report">
    <label class="form-check-label" for="{{ $id }}-2">Hazard Report</label>
</div>
