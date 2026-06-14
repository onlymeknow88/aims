@php
    $id = empty($id) ? null : $id;
@endphp

<div class="container-spinner container-progress summary-wrapper  rounded-2 p-3">

    {{-- @if (count($data) == 0)
        <div class="spinner spinner-border" role="status">
            <span class="visually-hidden">Loading...</span>
        </div>
    @endif --}}

    <div class="container-right-top title-progress text-secondary pb-3">
        <label>By Category</label>
        <div class="item">
            <a href="#" data-bs-toggle="modal" data-bs-target="#ModalCategory{{ $id }}"> Show all</a>
        </div>
    </div>

    @php
        $color = ['#00552F', '#91BA5F', '#A5C882', '#ECF39E', '#00552F', '#91BA5F', '#A5C882', '#ECF39E', '#00552F', '#91BA5F', '#A5C882', '#ECF39E', '#00552F', '#91BA5F', '#A5C882', '#ECF39E'];
    @endphp

    <div class="progress-body">
        @foreach ($data as $index => $list)
            <div class="progress-item text-secondary">
                <label>{{ $list['name'] }}</label>
                <div class="progress-container">
                    <div class="progress">
                        <div class="progress-bar" role="progressbar"
                            style="width: {{ $list['value'] }}%; background:{{ $color[$index] }}"
                            aria-valuenow="{{ $list['value'] }}" aria-valuemin="0" aria-valuemax="100"></div>
                    </div>
                    <div class="progress-value">{{ $list['value'] }}%</div>
                </div>
            </div>
        @endforeach

    </div>

    {{-- include popup --}}
    @include('livewire.main-dashboard.public.components.modal.modalCategory', [
        'data' => $data,
        'id' => $id,
    ])

</div>
