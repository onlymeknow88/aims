<div class="inner-content">

    <div class="header-detail-maker h-60px border d-flex gap-2 align-items-center px-3">
        <a href="/ibpr-and-bowtie/iadl/active/list"
            class="d-flex align-items-center gap-3">
            <span><i class="fa-solid fa-arrow-left"></i></span>
            <span>IADL</span>
        </a>
        <a href="/ibpr-and-bowtie/iadl/active/edit/{{$field->id}}"
            class="btn btn-edit text-white bg-146943"> <i class="fas fa-pencil"></i> Edit</a>
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
                        <div class="col-4 opacity-50">Penanggung Jawab</div>
                        <div class="col-8">{{ $field->pja->name ?? '' }}</div>
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
                        <div class="col-4 opacity-50">Form IBPR</div>
                        <div class="col-8">
                            <a href="#" class="" wire:click="goto_list_iadl">{{count($field->forms)}} IADL Active Record</a>
                        </div>
                    </div><!-- /.module-info-items -->

                </div>
            </div>

            <div class="footer-action mb-2">
                <div class="action-wrapper d-flex align-items-center justify-content-end gap-2">
                    <div class="button-document">
                        @if($field->status === 'DRAFT' || $field->status === 'Di Reject')
                            <button type="button" wire:click="changeStatus" class="btn btn-outline-default bg-green align-item-center text-white position-relative px-4">
                                Ajukan Kepada PJA/PJO
                            </button>
                        @elseif($field->status === 'Menuggu Persetujuan ENVIRONTMENT')
                            <button type="button" wire:click="changeStatus" class="btn btn-outline-default bg-green align-item-center text-white position-relative px-4">
                                Ajukan Kepada ENVIRONTMENT
                            </button>

                        @elseif($field->status === 'Menuggu Persetujuan KTT')
                            <button type="button" wire:click="changeStatus" class="btn btn-outline-default bg-green align-item-center text-white position-relative px-4">
                                Ajukan Kepada KTT
                            </button>
                        @elseif(
                                $field->status === 'Pengajuan Kepada PJA' ||
                                $field->status === 'Pengajuan Kepada PJO' ||
                                $field->status === 'Pengajuan Kepada ENVIRONTMENT' ||
                                $field->status === 'Diajukan Untuk Persetujuan KTT'
                                )
                            <div class="flex gap-2">
                                <button type="button" onclick="reject()" class="btn btn-outline-default bg-green align-item-center text-white position-relative px-4">
                                    Reject
                                </button>
                                <button type="button" wire:click="changeStatus" class="btn btn-outline-default bg-green align-item-center text-white position-relative px-4">
                                    Approve
                                </button>
                            </div>
                        @endif
                    </div>
                </div>
            </div>

        </div>

        <div class="detail-right border-start border-1">
            <div class="info bg-white px-3">
            </div>
        </div>
    </div>

    <div wire:ignore.self class="modal fade" id="rejectForm" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="rejectFormLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                <h5 class="modal-title">Reject IADL</h5>
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
                        <button type="button" onclick="closeModalReject()"  class="btn btn-outline-secondary">Cancel</button>
                      </div>
                      <div>
                        <button type="button" wire:click.stop="submit_reject" class="btn btn-outline-default bg-green align-item-center text-white position-relative px-4">Submit</button>
                      </div>
                </div>
            </div>
        </div>
    </div>
</div>


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

    $('#btn-togle-k3').click(function() {
        $('#tooltip_lh').addClass('hidden');
        $('#tooltip_kp').addClass('hidden');
        $('#tooltip_ksl').addClass('hidden');
        $('#tooltip_kk').addClass('hidden');
        $('#tooltip_k3').toggleClass('hidden');
    });

    $('#btn-togle-lh').click(function() {
        $('#tooltip_k3').addClass('hidden');
        $('#tooltip_kp').addClass('hidden');
        $('#tooltip_ksl').addClass('hidden');
        $('#tooltip_kk').addClass('hidden');
        $('#tooltip_lh').toggleClass('hidden');
    });

    $('#btn-togle-kp').click(function() {
        $('#tooltip_k3').addClass('hidden');
        $('#tooltip_lh').addClass('hidden');
        $('#tooltip_ksl').addClass('hidden');
        $('#tooltip_kk').addClass('hidden');
        $('#tooltip_kp').toggleClass('hidden');
    });

    $('#btn-togle-ksl').click(function() {
        $('#tooltip_k3').addClass('hidden');
        $('#tooltip_lh').addClass('hidden');
        $('#tooltip_kk').addClass('hidden');
        $('#tooltip_kp').addClass('hidden');
        $('#tooltip_ksl').toggleClass('hidden');
    });

    $('#btn-togle-kk').click(function() {
        $('#tooltip_k3').addClass('hidden');
        $('#tooltip_lh').addClass('hidden');
        $('#tooltip_kp').addClass('hidden');
        $('#tooltip_ksl').addClass('hidden');
        $('#tooltip_kk').toggleClass('hidden');
    });


    $('#btn-togle-k3-v2').click(function() {
        $('#tooltip_lh-v2').addClass('hidden');
        $('#tooltip_kp-v2').addClass('hidden');
        $('#tooltip_ksl-v2').addClass('hidden');
        $('#tooltip_kk-v2').addClass('hidden');
        $('#tooltip_k3-v2').toggleClass('hidden');
    });

    $('#btn-togle-lh-v2').click(function() {
        $('#tooltip_k3-v2').addClass('hidden');
        $('#tooltip_kp-v2').addClass('hidden');
        $('#tooltip_ksl-v2').addClass('hidden');
        $('#tooltip_kk-v2').addClass('hidden');
        $('#tooltip_lh-v2').toggleClass('hidden');
    });

    $('#btn-togle-kp-v2').click(function() {
        $('#tooltip_k3-v2').addClass('hidden');
        $('#tooltip_lh-v2').addClass('hidden');
        $('#tooltip_ksl-v2').addClass('hidden');
        $('#tooltip_kk-v2').addClass('hidden');
        $('#tooltip_kp-v2').toggleClass('hidden');
    });

    $('#btn-togle-ksl-v2').click(function() {
        $('#tooltip_k3-v2').addClass('hidden');
        $('#tooltip_lh-v2').addClass('hidden');
        $('#tooltip_kk-v2').addClass('hidden');
        $('#tooltip_kp-v2').addClass('hidden');
        $('#tooltip_ksl-v2').toggleClass('hidden');
    });

    $('#btn-togle-kk-v2').click(function() {
        $('#tooltip_k3-v2').addClass('hidden');
        $('#tooltip_lh-v2').addClass('hidden');
        $('#tooltip_kp-v2').addClass('hidden');
        $('#tooltip_ksl-v2').addClass('hidden');
        $('#tooltip_kk-v2').toggleClass('hidden');
    });

    Livewire.on('closeModal', () => {
        $("#staticBackdrop").modal("hide");
         $("#rejectForm").modal("hide");
    });

    Livewire.on('closeAllToooltip', () => {
        closeAllToooltip();
    });

    function closeAllToooltip() {
        $('#tooltip_k3-v2').addClass('hidden');
        $('#tooltip_lh-v2').addClass('hidden');
        $('#tooltip_kp-v2').addClass('hidden');
        $('#tooltip_ksl-v2').addClass('hidden');
        $('#tooltip_kk-v2').addClass('hidden');
        $('#tooltip_k3').addClass('hidden');
        $('#tooltip_lh').addClass('hidden');
        $('#tooltip_kp').addClass('hidden');
        $('#tooltip_ksl').addClass('hidden');
        $('#tooltip_kk').addClass('hidden');
    }


    $('#preliminary_frequence').on('input', function() {
        // Call your function here
        let preliminary_frequence = $('#preliminary_frequence').val();
        Livewire.emit('event_formula_level_of_risk', preliminary_frequence);
    });

    $('#residual_frequence').on('input', function() {
        // Call your function here
        let residual_frequence = $('#residual_frequence').val();
        Livewire.emit('event_formula_level_of_risk_residual', residual_frequence);
    });

    Livewire.on('chooseModaelOfCurrent', (preliminary_main_risk) => {
        chooseModaelOfCurrent(preliminary_main_risk);
    });

    function chooseModaelOfCurrent(preliminary_main_risk) {
        if(preliminary_main_risk === 'Ya') {
            let options = `
                <option value="Interaksi kendaraan">Interaksi kendaraan</option>
                <option value="Pengangkatan">Pengangkatan</option>
                <option value="Penanganan ban">Penanganan ban</option>
                <option value="Bekerja dekat Air">Bekerja dekat Air</option>
            `
            $('#modal_of_current').empty();
            $('#modal_of_current').append(options);
        }

        if(preliminary_main_risk === 'Tidak') {
            let options = `
                <option value="ELIMINASI">ELIMINASI</option>
                <option value="SUBSTITUSI">SUBSTITUSI</option>
                <option value="TEKNIK REKAYASA">TEKNIK REKAYASA</option>
                <option value="ADMINISTRASI">ADMINISTRASI</option>
                <option value="ALAT PELINDUNG DIRI">ALAT PELINDUNG DIRI</option>
            `
            $('#modal_of_current').empty();
            $('#modal_of_current').append(options);

        }
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

