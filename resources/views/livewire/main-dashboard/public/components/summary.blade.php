<div class="container-spinner container-summary summary-wrapper  rounded-2 p-3">

    @if ($data['count'] == '')
        <div class="spinner spinner-border" role="status">
            <span class="visually-hidden">Loading...</span>
        </div>
    @endif

    <label class="text-secondary">YTD</label>

    <div class="summary-count">
        {{ $data['count'] != '' ? $data['count'] : '-' }}
    </div>

    <div class="progress-container">
        <div class="progress">
            <div class="progress-bar" role="progressbar" style="width:  {{ $data['progress'] }}%; background:#00552F;"
                aria-valuenow="{{ $data['progress'] }}" aria-valuemin="0" aria-valuemax="100"></div>
        </div>
        <div class="progress-value">{{ $data['progress'] }}%</div>
    </div>

</div>
