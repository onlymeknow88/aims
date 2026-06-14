@push('styles')
    <link rel="stylesheet" href="https://code.jquery.com/ui/1.13.2/themes/base/jquery-ui.css">
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        #dropdown_submit {
            display: none;
        }
        .alert-warning {
            background: rgba(255, 199, 0, 0.06);
            border: 1px solid #FFC700;
            border-radius: 8px;
        }
        #dropbox {
            width: 100%;
            height: 100px;
            background: rgba(129, 13, 168, 0.04);
            display: flex;
            align-items: center;
            justify-content: center;
            border: 1.5px dashed #810DA8;
            border-radius: 12px;
        }
        #dropbox.active {
            background: rgba(129, 13, 168, 0.1);
        }
        #select {
            text-decoration: underline;
            cursor: pointer;
        }
        #file {
            display: none;
        }

        .review-box {
            background: #FFFFFF;
            border: 1px solid #E5E5E5;
            border-radius: 8px;
            width: 100%;
            height: 150px;
            padding: 10px;
        }
        .review-box .name {
            width: 90%;
            overflow: hidden;
            text-overflow: ellipsis;
            white-space: nowrap;
            margin-top: 8px;
        }
        .review-box .header .delete-icon {
            cursor: pointer;
        }
        .review-box .header .file-icon {
            width: 30px;
            height: 30px;
        }
        .document-prefix {
            background-color: transparent !important;
            width: auto !important;
            border: 1px solid #ced4da;
            border-right: none !important;
        }
        .input-group-doc-form input {
            border-left: none !important;
        }
        .input-group-doc-form input:focus {
            border-color: #ced4da !important;
        }
        .input-group-text.is-invalid {
            border: 1px solid #dc3545;
            border-right: none;
        }

        .wrapping_table {
            overflow-x: scroll;

        }
        .form_table {
            overflow-x: scroll;
        }
        .form_table th,
        .form_table td {
            min-width: 150px;
            white-space: unset;
            vertical-align: middle;
            text-align: center;
            padding: unset;
            position: unset;
            font-size: 11px;
            border-color: black;
        }
        .form_table td.title a {
            white-space: unset;
            max-width: unset;
            display: unset;
            align-items: unset;
        }
        .form_table td a:hover {
            font-weight: unset;
        }
        .form_table td.td-check {
            width: unset;
        }
        .form_table tr {
            border-left: unset;
            border-color: black;
        }
        .form_table tbody tr:hover {
            border-left-color:unset;
            background-color: unset;
            cursor: unset;
        }
        .form_table tbody tr td .icon-checked {
            display: unset;
            align-items: unset;
            width: unset;
            height: unset;
            background-position: unset;
            background-size: unset;
        }
        .form_table tbody tr:hover td .icon-checked{
            background-image: unset;
        }
        .form_table tbody tr td .icon-checked.selected {
            background-image: unset;
        }

        .tooltip_info {
            display: flex;
            justify-content: center;
            align-items: center;
            border-radius: 9999px;
            border-width: 1px;
            border-color: black;
        }

        .tooltip_info p{
            margin: 0;
            font-size: 12px;
        }

        .border_add_modal {
            border-width: 1px;
            border-style: dashed;
            border-color: green;
        }

        label {
            font-size: 13px!important;
            color: black!important;
            font-weight: 500;
        }

        .form-control {
            font-size: 13px!important;
        }

        .select2-container--bootstrap-5 .select2-selection--single .select2-selection__rendered {
            font-size: 13px!important;
        }

        .input_tags {
            font-size:13px!important;
            padding-left: 4px;
        }

        .input_tags::placeholder {
            font-size:13px!important;
            font-weight: 400;
            line-height: 1.5;
            color: #6c757d;
            padding-left: 4px;
        }

    </style>
@endpush

<div class="inner-content">

    <div class="header-detail-maker h-60px border d-flex gap-2 align-items-center px-3">
        <div class="left-header">
            <a href="{{ route('ibpr-and-bowtie::bowtie.list-active-bowtie')}}" class="d-flex align-items-center gap-3">
                <span><i class="fa-solid fa-arrow-left"></i></span>
                <span>@lang('global.add_new')</span>
            </a>
        </div><!-- /.left-header -->
    </div>

    <div class="addnew-maker-content container py-5 px-3">
        <div class="row justify-content-center">
            <div class="col-8">
                <form wire:ignore.self class="form-horizontal">
                    <div>
                        <p class="text-lg mb-5">Company Information</p>
                    </div>
                    <div class="mb-3 row form-group required">
                        <label for="ccow_id" class="col-sm-4 col-form-label">Company</label>
                        <div class="col-sm-8">
                            <x-ibprandbowtie-select-2
                                id="ccow_id"
                                placeholder="Select Company"
                                :error="'ccow_id'"
                                wire:model="ccow_id"
                                >
                                @foreach ($ccow as $index => $item)
                                    <option value="{{ $item->id }}">{{ $item->company_name }}</option>
                                @endforeach
                            </x-inputs.select2>
                        </div>
                    </div>
                    <div class="mb-3 row form-group ">
                        <label for="iup" class="col-sm-4 col-form-label">Perusahaan IUP <span class="text-red-600">*</span></label>
                        <div class="col-sm-8">
                            <x-ibprandbowtie-select-2
                                disabled
                                id="iup"
                                placeholder="Perusahaan IUP"
                                :error="'iup'"
                                wire:model="iup">
                                    <option value="INTERNAL">INTERNAL</option>
                                    <option value="CONTRACTOR">CONTRACTOR</option>
                                    <option value="SUBCONTRACTOR">SUBCONTRACTOR</option>
                            </x-inputs.select2>
                        </div>
                    </div>
                    <div class="mb-3 row form-group ">
                        <label for="contractor_id" class="col-sm-4 col-form-label">Mitra Kerja</label>
                        <div class="col-sm-8">
                            <x-ibprandbowtie-select-2
                                id="contractor_id"
                                placeholder="Select Mitra Kerja"
                                :error="'contractor_id'"
                                wire:model="contractor_id"
                                >

                                @foreach ($contractors as $key => $contractor)
                                    <option value="{{ $contractor->id }}">{{$contractor->company_name}}</option>
                                @endforeach
                            </x-ibprandbowtie-select-2>
                        </div>
                    </div>
                    <div class="mb-3 row form-group ">
                        <label for="sub_contractor_id" class="col-sm-4 col-form-label">Sub Mitra Kerja</label>
                        <div class="col-sm-8">
                            <x-ibprandbowtie-select-2
                                id="sub_contractor_id"
                                placeholder="Select Sub Mitra Kerja"
                                :error="'sub_contractor_id'"
                                wire:model="sub_contractor_id"
                                >

                                @foreach ($sub_contractors as $key => $sub_contractor)
                                <option value="{{ $sub_contractor->id }}">{{$sub_contractor->company_name}}</option>
                            @endforeach
                            </x-ibprandbowtie-select-2>
                        </div>
                    </div>
                    <div class="mb-3 row form-group ">
                        <label for="pja_id" class="col-sm-4 col-form-label">Penanggung Jawab Risiko <span class="text-red-600">*</span></label>
                        <div class="col-sm-8">
                            <x-ibprandbowtie-select-2
                                id="pja_id"
                                placeholder="Select Penanggung Jawab"
                                :error="'pja_id'"
                                wire:model="pja_id"
                                >

                                @foreach ($pja as $key => $user)
                                    <option value="{{ $user->id }}">{{$user->name}}</option>
                                @endforeach
                            </x-ibprandbowtie-select-2>
                        </div>
                    </div>


                    <div wire:ignore class="mb-3 row form-group">
                        <label for="teams" class="col-sm-4 col-form-label flex">Tim Management Risiko <span class="text-red-600">*</span>
                        </label>
                        <div class="col-sm-8 px-[0.8] flex justify-center">
                            <div class="w-full border flex flex-wrap rounded-md">
                                <div id="tags-list" class="flex items-center flex-wrap gap-y-5">
                                    <div class="h-full"><input type="text" id="tags-input" name="tags" class="px-2 rounded-md input_tags h-full focus:outline-none" placeholder="Input here"/></div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div wire:ignore class="mb-3 row form-group">
                        <label for="teams" class="col-sm-4 col-form-label flex">Judul Risiko
                            <span class="text-red-600">*</span>

                        </label>
                        <div class="col-sm-8 px-[0.8] flex justify-center">
                            <div class="h-full w-full">
                                    <x-inputs.text
                                        class="w-full form-control"
                                        wire:model.defer="risk_title"
                                        id="risk_title"
                                        error="'risk_title'"
                                        placeholder="Judul Risiko"
                                    />
                            </div>
                        </div>
                    </div>
                    <div class="border-t mt-5">
                        <p class="text-lg my-5">Detailed Document</p>
                    </div>
                    <div class="mb-3 row form-group">
                        <label for="document_no" class="col-sm-4 col-form-label flex">No. Dokumen

                        </label>
                        <div class="col-sm-8">
                            <x-inputs.text wire:model="document_no"
                                disabled
                                id="document_no"
                                error="document_no"
                                placeholder="No. Dokumen"/>
                        </div>
                    </div>
                    <div class="mb-3 row form-group ">
                        <label for="request_date" class="col-sm-4 col-form-label flex">Tanggal Diajukan

                        </label>
                        <div class="col-sm-8">
                            <x-inputs.datepicker
                                placeholder="Tanggal diajukan"
                                wire:model="request_date"
                                id="request_date"
                                :error="'request_date'"/>
                        </div>
                    </div>

                    <div class="mb-3 row form-group ">
                        <label for="next_date" class="col-sm-4 col-form-label flex">Tanggal Review Selanjutnya

                        </label>
                        <div class="col-sm-8">
                            <x-inputs.datepicker
                                disabled
                                placeholder="Tanggal selanjutnya"
                                value="{{Carbon\Carbon::parse($request_date)->addYear()->format('F d, Y') }}"
                                id="next_date"
                                :error="'next_date'"/>
                        </div>
                    </div>

                    <div class="mb-3 row form-group ">
                        <label for="ohs_id" class="col-sm-4 col-form-label">Nama OHS <span class="text-red-600">*</span></label>
                        <div class="col-sm-8">
                            <x-ibprandbowtie-select-2
                                id="ohs_id"
                                placeholder="Select"
                                :error="'ohs_id'"
                                wire:model="ohs_id"
                                >

                                @foreach ($ohs as $key => $user)
                                    <option value="{{ $user->id }}">{{$user->name}}</option>
                                @endforeach
                            </x-ibprandbowtie-select-2>
                        </div>
                    </div>
                    <div class="my-5 border-t">

                    </div>
                    <div class="mb-5 mt-5">
                <div class="mt-5">
                    <div class="mt-10 flex">
                        <div class="w-[50%]">
                            <p class="text-sm">Event BOWTIE</p>
                        </div>
                        <div class="w-full">
                           @if(count($event) > 0)
                           <div class="text-blue-800 font-semibold text-sm cursor-pointer" wire:click="goto_list_ibpr">{{count($event)}} BOWTIE Active Record</div>
                           @else
                            <p class="text-blue-800 font-semibold text-sm cursor-pointer" onclick="tryToOpenModal()">+ Add new Event</p>
                           @endif
                        </div>

                    </div>
                </div>
                <div class="mt-5">
                    <div class="mt-10 flex">
                        <div class="w-[50%]">
                            <p class="text-sm">CCA BOWTIE</p>
                        </div>
                        <div class="w-full">
                           @if(count($cca) > 0)
                           <div class="text-blue-800 font-semibold text-sm cursor-pointer" wire:click="goto_list_cca">{{count($cca)}} BOWTIE CCA Active Record</div>
                           @else
                            <p class="text-blue-800 font-semibold text-sm cursor-pointer" onclick="tryToOpenModalCca()">+ Add new CCA</p>
                           @endif
                        </div>

                    </div>
                </div>
                <div class="mt-5">
                    <div class="mt-10 flex">
                        <div class="w-[50%]">
                            <p class="text-sm">Performance Standard BOWTIE</p>
                        </div>
                        <div class="w-full">
                           @if(count($performance_standard) > 0)
                           <div class="text-blue-800 font-semibold text-sm cursor-pointer" wire:click="goto_list_performance">{{count($performance_standard)}} BOWTIE Performance Standard Active Record</div>
                           @else
                            <p class="text-blue-800 font-semibold text-sm cursor-pointer" onclick="openModalPerformance()">+ Add new Performance Standard</p>
                           @endif
                        </div>

                    </div>
                </div>

                <div class="mt-5">
                    <div class="mt-10 flex">
                        <div class="w-[50%]">
                            <p class="text-sm">Loss Callculation BOWTIE</p>
                        </div>
                        <div class="w-full">
                           @if(count($loss_callculation) > 0)
                           <div class="text-blue-800 font-semibold text-sm cursor-pointer" wire:click="goto_list_lost_callculation">{{count($loss_callculation)}} BOWTIE Loss Callculation Active Record</div>
                           @else
                            <p class="text-blue-800 font-semibold text-sm cursor-pointer" onclick="openModalLossCallculation()">+ Add new Loss Callculation</p>
                           @endif
                        </div>

                    </div>
                </div>
                </div>
                    <div class="w-full flex">
                        <div class="w-full flex justify-end gap-2 footer-action">
                            <button type="button" wire:click="cancel" class="btn btn-outline-secondary">
                                CANCEL
                            </button>
                            <div class="action-wrapper d-flex align-items-center justify-content-end gap-2">

                                <div class="button-document">
                                    <button wire:loading.attr="disabled"
                                        class="dropdown-toggle btn btn-outline-default bg-green d-flex justify-content-center align-item-center text-white position-relative px-4"
                                        role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                        Submit Action
                                    </button>
                                    <ul class="dropdown-menu" wire:ignore>
                                        <li>
                                            <button type="button" wire:loading.attr="disabled" wire:click="save_bowtie('Draft')" class="dropdown-item"
                                                href="#">
                                                Save as Draft
                                            </button>
                                        </li>
                                        <li>
                                            <button type="button" wire:loading.attr="disabled" wire:click="save_bowtie('Pengajuan Kepada DH/OHS')" class="dropdown-item"
                                                href="#">
                                                Ajukan ke OHS
                                            </button>
                                        </li>
                                        <li>
                                            <button type="button" wire:loading.attr="disabled" wire:click="save_bowtie('Temporary')" class="dropdown-item"
                                                href="#">
                                                Ajukan sebagai Daftar Bowtie Sementara
                                            </button>
                                        </li>
                                    </ul>
                                </div>
                           </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>

@livewire('ibprandbowtie::bowtie.modal.modal-event', ['bowtie_id'=>$bowtie_id])
<!-- <livewire:ibprandbowtie::bowtie.modal.modal-event :bowtie_id="$bowtie_id"/> -->
<livewire:ibprandbowtie::bowtie.modal.modal-cca :bowtie_id="$bowtie_id"/>
<livewire:ibprandbowtie::bowtie.modal.modal-performance :bowtie_id="$bowtie_id"/>
<livewire:ibprandbowtie::bowtie.modal.modal-loss-callculation :bowtie_id="$bowtie_id"/>



@push('scripts')
    <script src="https://code.jquery.com/ui/1.13.2/jquery-ui.js"></script>

    <script>
        let teams = [];
        $(document).ready(function() {

            $('#tags-input').on('keydown', function(event) {
                if (event.keyCode === 13) { // 13 is the keycode for the Enter key
                    var team = $(this).val().trim();
                    teams.push(team);
                    if (team !== '') {
                        $('#tags-list').before('<div class="tag bg-gray-100 px-3 flex items-center mr-2 ml-2 rounded-md my-1">' + team + '<button type="button" class="close ml-2 border rounded-full h-3 w-3 flex items-center justify-center p-2 border-black" data-name="'+ team +'" aria-label="Close"><span aria-hidden="true">x</span></button></div>');
                        $(this).val('');
                    }

                    @this.set('teams', teams);
                }
            });

            $('body').on('click', '.close', function() {
                var name = $(this).data('name');

                let newValue = teams.filter(e => e !== name)
                teams = newValue;

                $(this).parent().remove();
                @this.set('teams', newValue);
            });

            // $('#staticBackdropLabel').text('Create Event');

        });

        function tryToOpenModalCca() {
            Livewire.emit('check_event');

            $("#modal_cca").modal("show");

        }

        $('#modal_cca').on('hide.bs.modal', function (e) {
            Livewire.emit('check_event');
        });


        function tryToOpenModal() {
            $("#staticBackdrop").modal("show");
        }

        function toggle_dropdown_submit(){
            $('#dropdown_submit').toggle();
        }

        $(document).ready(function() {
            // Attach a change event handler to the form
            $('#document_no').change(function() {
                // Code to execute when the form value changes
                let val =  $('#document_no').val();
                $('#staticBackdropLabel').text(val);
            });
        });

        $('#staticBackdrop').on('hide.bs.modal', function (e) {
            Livewire.emit('check_event');
        });

        $('#modal_performance').on('hide.bs.modal', function (e) {
            Livewire.emit('check_event');
        });


        $('#modal_loss_calculation').on('hide.bs.modal', function (e) {
            Livewire.emit('check_event');
        });

    </script>
@endpush
