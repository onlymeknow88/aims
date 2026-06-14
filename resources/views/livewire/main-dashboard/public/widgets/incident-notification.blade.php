<div class="incident-notification ">
    <div class="container-right-top">
        <h6>Incident Notification</h6>
        <div class="item">
            <a href="#" data-bs-toggle="modal" data-bs-target="#ModalIncidentNotification"> Show all</a>
        </div>
    </div><!-- /.sp-title -->

    @php
        $color = ['pink', 'orange', 'green', 'blue', 'purple', 'red', '#fc0390', '#fc8803', '#03fc7b', '#033dfc', '#9403fc', 'red', 'green', 'blue'];
    @endphp

    <div class="incident-notification-body">
        <table class="incident-notification-table">
            @foreach ($data as $index => $list)
                <tr @if ($list['slug']) onclick="show('{{ $list['slug'] }}')" @endif>
                    <td>
                        <div
                            style="background:{{ isset($color[$index]) ? $color[$index] : null }}; color:white; font-size:8pt; border-radius:10px; padding:5px">
                            {{ $list['date'] }}</div>
                    </td>
                    <td> {{ $list['case'] }} </td>
                    <td> {{ $list['category'] }} </td>
                </tr>
            @endforeach
        </table>
    </div>
</div>


{{-- include popup --}}
@include('livewire.main-dashboard.public.components.modal.modalIncidentNotification', [
    'data' => $data,
    'id' => 'IncidentNotification',
])

@push('scripts')
    <script>
        function show(slug) {
            window.location.href = window.location.origin + "/incident-notification/" + slug;
        }
    </script>
@endpush

@push('styles')
    <style>
        .incident-notification-table th,
        .incident-notification-table td {
            white-space: unset;
            position: unset;
            padding: 8px 5px !important;
            margin: 0px !important;
            height: auto;
            border-bottom: 1px solid rgb(216, 214, 214);
            color: rgba(50, 49, 48, 1);
        }
    </style>
@endpush
