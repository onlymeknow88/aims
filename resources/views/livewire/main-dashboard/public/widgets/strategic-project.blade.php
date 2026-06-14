<div class="card strategi-project">

    <div class="card-body ">

        <div class="container-right-top">
            <h6>Strategic Project</h6>
            <div class="item">
                <a href="#" data-bs-toggle="modal" data-bs-target="#ModalStrategyProject"> Show all</a>
            </div>
        </div><!-- /.sp-title -->

        <div class="sp-c d-flex flex-column gap-2">
            @foreach ($data as $list)
                <div class="right-c flex-grow-1 d-flex flex-column bg-blue lh-sm  p-3 rounded-3">
                    <a href="{{ route('strategic_project_public_show', $list['slug']) }}">
                        <div class="row">
                            <div class="col-4 m-0 p-1">{{ $list['date'] }}</div>
                            <div class="col-8  m-0 p-1">{{ $list['title'] }}</div>
                        </div>
                    </a>
                </div><!-- /.right-c -->
            @endforeach
        </div><!-- /.sp-c -->

    </div>

</div><!-- /.calendar-of-event-list -->

{{-- include popup --}}
@include('livewire.main-dashboard.public.components.modal.modalStrategyProject', [
    'data' => $data,
    'id' => 'StrategyProject',
])

@push('styles')
    <style>
        .bg-primary-op {
            background-color: rgba(0, 85, 47, 0.3);
        }

        .bg-blue {
            background-color: #ffffff !important;
            border-bottom: 1px solid #e5e5e5;
            border-radius: 0 !important;
            padding: 1rem 0.5rem !important;
        }
    </style>
@endpush
