<div class="k3lh-award">
    <div class="sp-title py-1 container-right-top">
        <h6>Penghargaan K3LH</h6>
        <div class="item">
            <a href="#" data-bs-toggle="modal" data-bs-target="#ModalCategoryK3lhAward"> Show all</a>
        </div>
    </div><!-- /.sp-title -->

    <div class="k3lh-award-body">
        <table class="k3lh-award-table">

            @foreach ($data as $index => $list)
                <tr>
                    <td>
                        <div class="circle bg-secondary">{{ $index + 1 }}</div>
                    </td>
                    <td>
                        <span>{{ $list['company'] }}</span>
                    </td>
                </tr>
            @endforeach

        </table>
    </div>
</div>

{{-- include popup --}}
@include('livewire.main-dashboard.public.components.modal.modalK3lhAward', [
    'data' => $data,
    'id' => 'ModalEmployeeCategory',
])


@push('styles')
    <style>
        .k3lh-award-table {
            width: 100%;
        }

        .k3lh-award-table th,
        .k3lh-award-table td {
            white-space: unset;
            position: unset;
            padding: 8px 5px !important;
            margin: 0px !important;
            height: auto;
            border-bottom: 1px solid rgb(216, 214, 214);
            vertical-align: middle;
        }
        .k3lh-award-table td .bg-secondary{
            background-color: rgba(242, 243, 248, 1) !important;
            color: rgba(50, 49, 48, 1) !important;
        }
        .k3lh-award-table td:nth-child(1){
            width: 15%;
        }
    </style>
@endpush
