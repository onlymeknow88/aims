<div class="inner-content">

    <div class="header-detail-maker h-60px border d-flex gap-2 align-items-center px-3">
        <a href="/ibpr-and-bowtie/bowtie/list"
           class="d-flex align-items-center gap-3">
            <span><i class="fa-solid fa-arrow-left"></i></span>
            <span>BOWTIE</span>
        </a>
        <a href="/ibpr-and-bowtie/bowtie/detail/edit/{{$field->id}}"
           class="btn btn-edit text-white bg-146943"> <i class="fas fa-pencil"></i> Edit</a>

        <a href="" wire:click.prevent="export('{{ $field->id }}')" class="btn btn-outline-danger"><i
                class="fa-solid fa-file-export"></i> Export</a>
    </div>

    <div class="detail-maker-content d-flex">
        <div class="detail-left border-end border-1">
            <div class="info bg-white">
                <div class="info-item p-3 border-bottom border-1 px-3">
                    <div class="author d-flex flex-column gap-2">
                        <div class="item-content d-flex gap-2 align-items-center">
                            <div class="thumb">
                                <img src="{{ asset('./images/author.png') }}" alt="Author">
                            </div>
                            <div class="author-name text-[16px]">{{$field->pja->name ?? ''}}</div>
                        </div>
                    </div><!-- /.author -->
                </div><!-- /.info-items -->

                <div class="info-item p-3 border-bottom border-1">

                    <div class="created d-flex flex-column gap-2 p-3">

                        <h6 class="fw-normal">Tgl. Diajukan</h6>

                        <div class="item-content d-flex gap-1 align-items-center">
                            <span>{{ Carbon\Carbon::parse($field->request_date)->format('F d, Y') }}</span>
                        </div>

                    </div><!-- /.author -->

                </div><!-- /.info-items -->

                <div class="info-item p-3 border-bottom border-1">

                    <div class="created d-flex flex-column gap-2 p-3">

                        <h6 class="fw-normal">Tgl. Selanjutnya</h6>

                        <div class="item-content d-flex gap-1 align-items-center">
                            <span>{{ Carbon\Carbon::parse($field->next_date)->format('F d, Y') }}</span>
                        </div>

                    </div><!-- /.author -->

                </div><!-- /.info-items -->

                <div class="info-item p-3 border-bottom border-1">

                    <div class="created d-flex flex-column gap-2 p-3">

                        <h6 class="fw-normal">Status Document</h6>

                        <!-- <div class="item-content d-flex gap-1 align-items-center">
                            <span>Revisi {{ number_format($field->revisi_number, 1) }}</span>
                        </div> -->
                        <div class="item-content d-flex gap-1 align-items-center">
                            <span>{{ $field->status }}</span>
                        </div>

                    </div><!-- /.author -->

                </div><!-- /.info-items -->

            </div><!-- /.info -->

        </div><!-- /.detail-left -->

        <div class="section-content w-100 py-3 px-5 d-flex flex-column gap-3">

            <div class="section-info py-3 px-2 d-flex flex-column gap-2">
                <div class="content-section d-flex flex-column gap-1">
                    <div class="module-info-items row">
                        <div class="col-4 opacity-50">Nomor Dokumen</div>
                        <div class="col-8">{{ $field->document_no }}</div>
                    </div><!-- /.module-info-items -->
                </div>
            </div>

            <div class="section-info py-3 px-2 d-flex flex-column gap-2">

                <h5 class="fw-normal">Informasi Perusahaan</h5>

                <div class="content-section d-flex flex-column gap-1">

                    <div class="module-info-items row">
                        <div class="col-4 opacity-50">CCOW</div>
                        <div class="col-8">{{ $field->ccow->company_name ?? '' }}</div>
                    </div><!-- /.module-info-items -->

                    <div class="module-info-items row">
                        <div class="col-4 opacity-50">Kriteria Analisa</div>
                        <div class="col-8">{{ $field->kriteria }}</div>
                    </div><!-- /.module-info-items -->

                    <div class="module-info-items row">
                        <div class="col-4 opacity-50">Perusahaan IUP</div>
                        <div class="col-8">{{ $field->iup }}</div>
                    </div><!-- /.module-info-items -->

                    <div class="module-info-items row">
                        <div class="col-4 opacity-50">Mitra Kerja</div>
                        <div class="col-8">{{ $field->contractor->company_name ?? '-' }}</div>
                    </div><!-- /.module-info-items -->

                    <div class="module-info-items row">
                        <div class="col-4 opacity-50">Sub Mitra Kerja</div>
                        <div class="col-8">{{ $field->sub_contractor->company_name ?? '-' }}</div>
                    </div><!-- /.module-info-items -->

                    <div class="module-info-items row">
                        <div class="col-4 opacity-50">Penanggung Jawab Resiko</div>
                        <div class="col-8">{{ $field->pja->name ?? '' }}</div>
                    </div><!-- /.module-info-items -->

                    <div class="module-info-items row">
                        <div class="col-4 opacity-50">Judul Risiko</div>
                        <div class="col-8">{{ $field->risk_title ?? '' }}</div>
                    </div><!-- /.module-info-items -->

                    @if($field->status === 'Di Reject')
                    <div class="module-info-items row">
                        <div class="col-4 opacity-50">Alasan Di Reject</div>
                        <div class="col-8">{{ $field->reject_reason }}</div>
                    </div><!-- /.module-info-items -->
                    @endif
                    

                </div>
            </div>

            @if (count($field->teams) > 0)
            <div class="section-invited-email py-3 px-2 d-flex flex-column gap-2">

                <h5 class="fw-normal">Tim Managejement Resiko</h5>

                <div class="content-section d-flex flex-column gap-1">

                    <div class="module-invited-email-items d-flex flex-wrap gap-2 ">
                        @foreach($field->teams as $team)
                            <div class="btn btn-outline-secondary">{{ $team->user_name ?? '' }}</div>
                        @endforeach

                    </div><!-- /.module-invited-items -->

                </div><!-- /.content-section -->

            </div><!-- /.section-invited-email -->
            @endif   

            <div class="section-info py-3 px-2 d-flex flex-column gap-2">

                <!-- <h5 class="fw-normal"></h5> -->

                <div class="content-section d-flex flex-column gap-1">

                    <div class="module-info-items row">
                        <div class="col-4 opacity-50">Event BOWTIE</div>
                        <div class="col-8">
                            <a href="#" class="" wire:click="goto_list_event">{{count($field->events)}} BOWTIE Active Record</a>
                        </div>
                    </div><!-- /.module-info-items -->

                    <div class="module-info-items row">
                        <div class="col-4 opacity-50">CCA BOWTIE</div>
                        <div class="col-8">
                            <a href="#" class="" wire:click="goto_list_cca">{{count($cca)}} BOWTIE CCA Active Record</a>
                        </div>
                    </div><!-- /.module-info-items -->

                    <div class="module-info-items row">
                        <div class="col-4 opacity-50">Performance Standard</div>
                        <div class="col-8">
                            <a href="#" class="" wire:click="goto_list_performance">{{count($performance)}} BOWTIE Performance Standard Active Record</a>
                        </div>
                    </div><!-- /.module-info-items -->

                    <div class="module-info-items row">
                        <div class="col-4 opacity-50">Lost Calculation</div>
                        <div class="col-8">
                            <a href="#" class="" wire:click="goto_list_lost_callculation">{{count($lost_callculation)}} BOWTIE Lost Callculation Active Record</a>
                        </div>
                    </div><!-- /.module-info-items -->

                </div>
            </div> 

            <div class="footer-action mb-2">
                <div class="action-wrapper d-flex align-items-center justify-content-end gap-2">
                    <div class="button-document">
                        @if($field->status === 'Draft' || $field->status === 'Di Reject')
                            <button type="button" wire:click="changeStatus"
                                    class="btn btn-outline-default bg-green align-item-center text-white position-relative px-4">
                                Ajukan Kepada DH/OHS
                            </button>
                        @elseif($field->status === 'Temporary')
                            <button type="button" wire:click="changeStatus"
                                    class="btn btn-outline-default bg-green align-item-center text-white position-relative px-4">
                                Ajukan Kepada DH/OHS
                            </button>
                        @elseif($field->status === 'Di Reject')
                            <div class="items-center">
                                <p class="text-[16px] font-[600]">{{ $field->status }}</p>
                                <p class="text-red-500 text-sm">{{ $field->reject_reason }}</p>
                            </div>
                        @elseif($field->status === 'Pengajuan Kepada DH/OHS')
                            <div class="flex gap-2">
                                <button type="button" onclick="reject()"
                                        class="btn btn-outline-danger px-4">
                                    Reject
                                </button>
                                <button type="button" wire:click="changeStatus"
                                        class="btn btn-outline-default bg-green align-item-center text-white position-relative px-4">
                                    Setujui
                                </button>
                            </div>
                        @elseif($field->status === 'Pengajuan Kepada KTT')
                            <div class="flex gap-2">
                                <button type="button" onclick="reject()"
                                        class="btn btn-outline-danger px-4">
                                    Reject
                                </button>
                                <button type="button" wire:click="changeStatus"
                                        class="btn btn-outline-default bg-green align-item-center text-white position-relative px-4">
                                    Setujui
                                </button>
                            </div>
                        @endif
                    </div>
                </div>
            </div>

        </div><!-- /.section-content -->

        <div class="detail-right border-start border-1">

            <div class="info bg-white px-3">

                <h6 class="fw-normal">Activity</h6>

                @foreach($field->activity as $index => $activity)
                    <div class="info-item mb-3">

                        <div class="activity d-flex flex-column gap-2">

                            <div class="item-content d-flex gap-1 align-items-center">

                                <div class="activity-item d-flex flex-column gap-2">

                                    <div
                                        class="activity-header d-flex justify-content-between align-items-center gap-2">
                                        <div class="d-flex align-items-center gap-2">
                                            <div class="thumb">
                                                <img src="{{ asset('./images/profile.png') }}" alt="Profile">
                                            </div>
                                            <div class="title d-flex flex-column">
                                                <span>{{ $activity->user_name }}</span>
                                                
                                            </div>
                                        </div>
                                    </div><!-- /.activity-item -->


                                    <div class="activity-content" x-data="{
                                        contentOpen: true,
                                        height: $refs.containerInner.getBoundingClientRect().height,
                                        buttonShow: false,
                                        init() {
                                            if (this.height > 60) {
                                                this.contentOpen = false;
                                                this.buttonShow = true;
                                            }
                                        }
                                    }">

                                        <div x-ref="containerInner" class="activity-inner d-flex flex-column gap-2">
                                            <div class="desc">
                                                <b>{{ $activity->title }}</b>
                                                <p>{{ $activity->description }}</p>
                                            </div>
                                        </div><!-- /.actifity-inner -->

                                    </div><!-- /.actifity-content -->

                                    <div class="activity-footer opacity-50">
                                        @php($timestamp = strtotime($activity->created_at))
                                        @php($now = Carbon\Carbon::now())
                                        @php($datetime = Carbon\Carbon::createFromTimestamp($timestamp))

                                        @if($datetime->diffInDays($now) > 0)
                                            {{ $datetime->diffInDays($now) . " hari yang lalu" }}
                                        @elseif($datetime->diffInDays($now) === 0)
                                            Kurang dari 1 jam yang lalu
                                        @else
                                            {{ $datetime->diffInHours($now) . " jam yang lalu" }}
                                        @endif
                                    </div>

                                </div><!-- /.activity-item -->

                            </div>

                        </div><!-- /.author -->

                    </div><!-- /.info-items -->
                @endforeach
            </div><!-- /.detail-left -->

        </div><!-- /.detail-maker -->

        <div wire:ignore.self class="modal fade" id="rejectForm" data-bs-backdrop="static" data-bs-keyboard="false"
             tabindex="-1" aria-labelledby="rejectFormLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Reject BOWTIE</h5>
                        <button class="" data-bs-dismiss="modal" aria-label="Close">X</button>
                    </div>
                    <div class="modal-body">
                        <div class="mb-3 form-group">
                            <label for="reject_reason" class="text-base mb-2 font-[500]">Reject Reason</label>
                            <div class="w-full">
                                <x-inputs.text
                                    id="reject_reason"
                                    error="reject_reason"
                                    wire:model="reject_reason"
                                    placeholder="Reject Reason"/>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer w-full flex justify-end footer-action">
                        <div>
                            <button type="button" onclick="closeModalReject()" class="btn btn-outline-secondary">
                                Cancel
                            </button>
                        </div>
                        <div>
                            <button type="button" wire:click.stop="submit_reject"
                                    class="btn btn-outline-default bg-green align-item-center text-white position-relative px-4">
                                Submit
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

{{--<livewire:ibprandbowtie::bowtie.modal.modal-event :bowtie_id="$field->id"/>
<livewire:ibprandbowtie::bowtie.modal.modal-cca :bowtie_id="$field->id"/>
<livewire:ibprandbowtie::bowtie.modal.modal-performance :bowtie_id="$field->id"/>
<livewire:ibprandbowtie::bowtie.modal.modal-loss-callculation :bowtie_id="$field->id"/>--}}


@push('scripts')
    <script src="https://code.jquery.com/ui/1.13.2/jquery-ui.js"></script>

    <script>

        Livewire.on('openModal', () => {
            let preliminary_main_risk = $('#preliminary_main_risk').val();
            chooseModaelOfCurrent(preliminary_main_risk)
            $("#staticBackdrop").modal("show");
        });

        Livewire.on('closeModal', () => {
            $("#staticBackdrop").hide();
            $("#rejectForm").modal('hide');
        });

        Livewire.on('successApprove', () => {
            newSwal.fire({
                title: 'Success',
                icon: 'success',
                text: "Success melakukan persetujuan",
            });
        });


        Livewire.on('successReject', () => {
            newSwal.fire({
                title: 'Success',
                icon: 'success',
                text: "Success melakukan reject",
            });
            $("#rejectForm").modal('hide');
        });


        function reject() {
            $("#rejectForm").modal("show");
        }

        function closeModalReject() {
            $("#rejectForm").modal('hide');
        }


        $('#staticBackdrop').on('hide.bs.modal', function (e) {
            Livewire.emit('check_event');
        });

        $('#modal_cca').on('hide.bs.modal', function (e) {
            Livewire.emit('check_event');
        });


        $('#modal_performance').on('hide.bs.modal', function (e) {
            Livewire.emit('check_event');
        });


        $('#modal_loss_calculation').on('hide.bs.modal', function (e) {
            Livewire.emit('check_event');
        });

        function tryToOpenModalCca() {
            $("#modal_cca").modal("show");
        }

        // 

        window.addEventListener('send_approval', (detail) => {
            newSwal.fire({
                title: 'Are you sure?',
                text: detail.detail.text,
                icon: 'info',
                showCancelButton: true,
                confirmButtonText: "Yes",
                cancelButtonText: "No",
                allowOutsideClick: () => !Swal.isLoading(),
                preConfirm: function(result) {
                    if (result) {
                        return @this.call('send_approval');
                    }
                },
            });
        });
    </script>
@endpush

