<div class="inner-content">

    <div class="header-detail-maker h-60px border d-flex gap-2 align-items-center px-3">
        <a href="#" onclick="history.back();" class="d-flex align-items-center gap-3">
            <span><i class="fa-solid fa-arrow-left"></i></span>
            <span>KO</span>
        </a>
    </div>

    <div class="detail-approval-content d-flex">

        <div class="detail-left border-end border-1">

            <div class="info bg-white">

                <div class="info-item p-3 border-bottom border-1">

                    <div class="created d-flex flex-column gap-2">

                        <h6 class="fw-normal">Category</h6>

                        <div class="item-content d-flex gap-1 align-items-center">
                            <span class="opacity-50"></span>
                            <span>
                                {{$unit->koSpipType->koSpipCategory->name}}
                            </span>
                        </div>

                    </div><!-- /.author -->

                </div><!-- /.info-items -->

                <div class="info-item p-3 border-bottom border-1">

                    <div class="created d-flex flex-column gap-2">

                        <h6 class="fw-normal">Type</h6>

                        <div class="item-content d-flex gap-1 align-items-center">
                            <span class="opacity-50"></span>
                            <span>
                                {{$unit->koSpipType->name}}
                            </span>
                        </div>

                    </div><!-- /.author -->

                </div><!-- /.info-items -->

                <div class="info-item p-3 border-bottom border-1">

                    <div class="created d-flex flex-column gap-2">

                        <h6 class="fw-normal">Description</h6>

                        <div class="item-content d-flex gap-1 align-items-center">
                            <span class="opacity-50"></span>
                            <span>
                                {{$unit->name}}
                            </span>
                        </div>

                    </div><!-- /.author -->

                </div><!-- /.info-items -->

                <div class="info-item p-3 border-bottom border-1">

                    <div class="created d-flex flex-column gap-2">

                        <h6 class="fw-normal">Created</h6>

                        <div class="item-content d-flex gap-1 align-items-center">
                            <span class="opacity-50">at</span>
                            <span>
                                {{date("d-F-Y", strtotime($unit->created_at))}}
                            </span>
                        </div>

                    </div><!-- /.author -->

                </div><!-- /.info-items -->

            </div><!-- /.info -->

        </div>

        <!-- center -->
        <div class="section-content w-100 py-3 px-5 d-flex flex-column gap-3">

            <div class="section-info py-3 px-2 d-flex flex-column gap-2">

                <h5 class="fw-normal">
                    Attachment Fields
                    <a href="#" data-bs-toggle="modal" data-bs-target="#attachment-field-modal" class="btn btn-outline-default bg-green align-item-center text-white position-relative m-2">
                        <i class="fa fa-edit"></i>
                    </a>
                </h5>

                <div class="content-section d-flex flex-column gap-1">

                    <div class="module-info-items row">
                        <!-- <div class="col-4 opacity-50">Number</div> -->
                        <div class="col-12">
                            @foreach($unit->attachment_field as $key => $field)
                                - {{$field}}<br>
                            @endforeach
                        </div>
                    </div><!-- /.module-info-items -->

                </div><!-- /.content-section -->

            </div><!-- /.section-info -->

            <div class="section-info py-3 px-2 d-flex flex-column gap-2">

                <h5 class="fw-normal">
                    Commisioning Fields
                    <a href="#" data-bs-toggle="modal" data-bs-target="#commissioning-field-modal" class="btn btn-outline-default bg-green align-item-center text-white position-relative m-2">
                        <i class="fa fa-edit"></i>
                    </a>
                </h5>

                <div class="content-section d-flex flex-column gap-1">

                    <div class="module-info-items row">
                        <!-- <div class="col-4 opacity-50">Number</div> -->
                        <div class="col-12">
                            @foreach($unit->koCommisioningFields as $key => $field)
                                {{$field->number}}. {{$field->question}}<br>
                            @endforeach
                        </div>
                    </div><!-- /.module-info-items -->

                </div><!-- /.content-section -->

            </div><!-- /.section-info -->

            <div class="section-info py-3 px-2 d-flex flex-column gap-2">

                <h5 class="fw-normal">DATA PENGGUNA</h5>

                <div class="content-section d-flex flex-column gap-1">

                    <div class="module-info-items row">
                        <div class="col-4 opacity-50">Departement</div>
                        <div class="col-8">-</div>
                    </div><!-- /.module-info-items -->

                </div><!-- /.content-section -->

            </div><!-- /.section-info -->


            {{--<div class="footer-action mb-2">
                <div class="action-wrapper d-flex align-items-center justify-content-end gap-2">

                    @if($koProposal->status == 'Review Verifier')
                        <a href="#" wire:click="verify()" class="btn btn-outline-default bg-green align-item-center text-white position-relative px-4">
                            Verify
                        </a>
                    @endif

                    @if($koProposal->status == 'Review Coordinator')
                        <a href="#" wire:click="verifyCoordinator()" class="btn btn-outline-default bg-green align-item-center text-white position-relative px-4">
                            Verify
                        </a>
                    @endif

                </div>
            </div>--}}

            <!-- modal -->
            <div class="modal fade" id="attachment-field-modal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
                aria-labelledby="CommentModal" aria-hidden="true" wire:ignore.self>
                <div class="modal-dialog modal-dialog-centered">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="CommentModal">Attachment Fields</h5>
                            <button type="button" class="btn-close" wire:click="closeModal()" data-bs-dismiss="modal"
                                aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <div class="row">
                                <label for="comment" class="col-sm-3 col-form-label">Fields</label>

                                <div class="col-sm-9">
                                    <x-ko-select-2-multiple wire:model.defer="attachment_fields" id="attachment_fields" name="attachment_fields[]" class="form-select" placeholder="">
                                            <option value="stnk">stnk</option>
                                            <option value="nota_pajak">nota_pajak</option>
                                            <option value="surat_pengantar">surat_pengantar</option>
                                            <option value="re_manufacture">re_manufacture</option>
                                            <option value="oem">oem</option>
                                            <option value="dokumen_sertifikat">dokumen_sertifikat</option>
                                            <option value="inspeksi_p3k">inspeksi_p3k</option>
                                            <option value="kir">kir</option>
                                            <option value="uji_pjit">uji_pjit</option>
                                            <option value="pra_komisioning">pra_komisioning</option>
                                            <option value="setting_radio">setting_radio</option>
                                            <option value="slo">slo</option>
                                            <option value="komisioning_internal">komisioning_internal</option>
                                            <option value="com">com</option>
                                    </x-ko-select-2-multiple>
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal"
                                wire:click="closeModal()">Close</button>
                            <button type="button" wire:click="saveAttachmentField()"
                                class="btn btn-outline-success bg-green text-white bg-hover-light-success">
                                Submit
                            </button>
                        </div>
                    </div>
                </div>
            </div>
            <!-- /.modal -->

            <!-- modal -->
            <div class="modal fade" id="commissioning-field-modal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
                aria-labelledby="CommentModal" aria-hidden="true" wire:ignore.self>
                <div class="modal-dialog modal-dialog-centered">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="CommentModal">Add Commisioning Field Fields</h5>
                            <button type="button" class="btn-close" wire:click="closeModal()" data-bs-dismiss="modal"
                                aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <div class="row">
                                <label for="comment" class="col-sm-3 col-form-label">Number</label>
                                <div class="col-sm-9">
                                    <x-inputs.text type="text" wire:model="number" class="form-control" id="number" placeholder="Number" :error="'number'"></x-inputs.text>
                                </div>
                            </div>

                            <div class="row">
                                <label for="comment" class="col-sm-3 col-form-label">Question</label>
                                <div class="col-sm-9">
                                    <x-inputs.text type="text" wire:model="question" class="form-control" id="question" placeholder="Komisioning" :error="'question'"></x-inputs.text>
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal"
                                wire:click="closeModal()">Close</button>
                            <button type="button" wire:click="storeCommisioningField()"
                                class="btn btn-outline-success bg-green text-white bg-hover-light-success">
                                Submit
                            </button>
                        </div>
                    </div>
                </div>
            </div>
            <!-- /.modal -->

        </div><!-- /.section-content -->


        <div class="detail-right border-start border-1">
            <div class="info bg-white px-3">
            </div>
        </div>

    </div>
</div>

@push('scripts')
    <script>
        window.addEventListener('closeModal', event => {
            $('#attachment-field-modal').modal('hide');
        });
    </script>
@endpush
