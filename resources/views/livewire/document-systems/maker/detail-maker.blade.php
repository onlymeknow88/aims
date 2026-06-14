@push('styles')
    <style>
        .show-more-text {
            color: #00552F;
            font-size: 13px;
        }

        .files-content .img-name {
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
            width: 80%;
        }

        #modalRevision .proof-container {
            display: flex;
            align-items: center;
            flex-wrap: wrap;
            gap: 10px;
            margin-top: 12px;
        }

        #modalRevision .proof-container .proof-item {
            width: 40px;
            height: 40px;
            background: #e6e6e6;
            border-radius: 8px;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        #modalRevision .proof-container .proof-item.item img {
            width: 40px;
            height: 40px;
        }

        .detail-right .info-item {
            margin-bottom: 10px;
        }

        .detail-right .activity-content p.desc {
            display: -webkit-box;
            -webkit-line-clamp: 3;
            -webkit-box-orient: vertical;
            overflow: hidden;
            min-height: 70px;
        }

        .activity-content .images .img-name {
            overflow: hidden;
            cursor: pointer;
            white-space: nowrap;
            text-overflow: ellipsis;
            width: 180px;
        }

        .activity-content .images .img-preview {
            width: 30px;
            height: 30px;
            border-radius: 8px;
        }

        .section-description .content-section>* {
            white-space: unset !important
        }

        .activity-item .activity-inner {
            height: 180px;
        }

        .no-hover:hover {
            background: #00552F;
            color: #fff;
        }
    </style>
@endpush

<div class="inner-content">

    <div class="header-detail-maker h-60px bg-green d-flex gap-2 align-items-center px-3">
        <a href="{{ $back_url }}" class="d-flex align-items-center gap-3 text-white">
            <span><i class="fa-solid fa-arrow-left"></i></span>
            <span>Dokumen Kebijakan</span>
        </a>
        @if (
            ($detail->status == \Modules\DocumentSystem\Entities\Document::ON_REVISION ||
                $detail->status == \Modules\DocumentSystem\Entities\Document::DRAFT ||
                $detail->status == \Modules\DocumentSystem\Entities\Document::PREPARE_ROOTING_REVIEW) &&
                (auth()->user()->hasRole('Document System Maker General') ||
                    auth()->user()->hasRole('Document System Maker Admin')))
            <a href="{{ route('edit-maker', ['id' => $id_maker]) }}" class="btn btn-edit text-white bg-146943"> <i
                    class="fas fa-pencil"></i> Edit Document</a>
        @endif

        @if (
            $detail->status == \Modules\DocumentSystem\Entities\Document::EXPIRED &&
                auth()->user()->can('Update Document'))
            <a class="btn btn-edit text-white bg-146943" type="button" wire:click="confirmUpdateDocument">
                <i class="fas fa-pencil"></i> Update Document
            </a>
        @endif
    </div>

    <div class="detail-maker-content d-flex">

        <div class="detail-left border-end border-1">

            <div class="info bg-white">

                <div class="info-item p-3 border-bottom border-1">

                    <div class="author d-flex flex-column gap-2">
                        <h6 class="fw-normal">@lang('global.pic')</h6>
                        <div class="item-content d-flex gap-2 align-items-center">
                            <div class="thumb">
                                <img src="{{ asset('./images/author.png') }}" alt="Author">
                            </div>
                            <div class="author-name">{{ $detail->user->name }}</div>
                        </div>
                    </div><!-- /.author -->

                </div><!-- /.info-items -->

                <div class="info-item p-3 border-bottom border-1">

                    <div class="pt d-flex flex-column gap-2">
                        <h6 class="fw-normal">{{ $detail->department->company->company_name }}</h6>
                        <div class="item-content d-flex gap-2 align-items-start">
                            <div class="thumb">
                                <img src="{{ asset('./images/icons/position.png') }}" alt="Position">
                            </div>
                            <div class="position-name d-flex flex-column">
                                <span class="opacity-50">Position</span>
                                <span>Manager</span>
                            </div>
                        </div>
                        <div class="item-content d-flex gap-2 align-items-start">
                            <div class="thumb">
                                <img src="{{ asset('./images/icons/map.png') }}" alt="Location">
                            </div>
                            <div class="location-name d-flex flex-column">
                                <span class="opacity-50">@lang('global.location_detail')</span>
                                <span>{{ $detail->department->company->address }}</span>
                            </div>
                        </div>
                        <div class="item-content d-flex gap-2 align-items-start">
                            <div class="thumb">
                                <img class="w-18px" src="{{ asset('./images/icons/blank.png') }}" alt="Blank">
                            </div>
                            <div class="department-name d-flex flex-column">
                                <span class="opacity-50">@lang('global.department')</span>
                                <span>{{ $detail->department->name }}</span>
                            </div>
                        </div>
                    </div><!-- /.author -->

                </div><!-- /.info-items -->

                <div class="info-item p-3 border-bottom border-1">

                    <div class="created d-flex flex-column gap-2">

                        <h6 class="fw-normal">Created</h6>

                        <div class="item-content d-flex gap-1 align-items-center">
                            <span class="opacity-50">by</span>
                            <span>PT. Maruawai</span>
                            <span class="opacity-50">on</span>
                            <span>{{ date('d F Y', strtotime($detail->doc_created)) }}</span>
                        </div>

                    </div><!-- /.author -->

                </div><!-- /.info-items -->

                <div class="info-item p-3 border-bottom border-1">

                    <div class="expired d-flex flex-column gap-2">

                        <h6 class="fw-normal">Expired</h6>

                        <div class="item-content d-flex gap-1 align-items-center">
                            <span class="opacity-50">by</span>
                            <span>System</span>
                            <span class="opacity-50">on</span>
                            <span>{{ $detail->expired }}</span>
                        </div>

                    </div><!-- /.author -->

                </div><!-- /.info-items -->

                @if ($detail->revision)
                    <div class="info-item p-3 border-bottom border-1">

                        <div class="expired d-flex flex-column gap-2">

                            <h6 class="fw-normal">@lang('global.status_document')</h6>

                            <div class="item-content d-flex gap-1 align-items-center">
                                <span>@lang('global.revision') {{ $detail->revision }}.0</span>
                            </div>

                        </div><!-- /.author -->

                    </div><!-- /.info-items -->
                @endif

                @if (
                    !auth()->user()->hasRole('Document System Maker General') &&
                        !auth()->user()->hasRole('Document System Maker Admin'))
                    <div class="info-item p-3 border-bottom border-1">

                        <div class="author d-flex flex-column gap-2">
                            <h6 class="fw-normal">Maker</h6>
                            <div class="item-content d-flex gap-2 align-items-center">
                                <div class="thumb">
                                    <img src="{{ asset('./images/author.png') }}" alt="Author">
                                </div>
                                <div class="author-name">{{ $detail->createdby ? $detail->createdby->name : '-' }}
                                </div>
                            </div>
                        </div><!-- /.author -->

                    </div><!-- /.info-items -->
                @endif

            </div><!-- /.info -->

        </div><!-- /.detail-left -->

        <div class="section-content w-100 py-3 px-5 d-flex flex-column gap-3">

            <div class="section-info py-3 px-2 d-flex flex-column gap-2">

                <h5 class="fw-normal">@lang('global.module_information')</h5>

                <div class="content-section d-flex flex-column gap-1">

                    <div class="module-info-items row">
                        <div class="col-4 opacity-50">@lang('global.module')</div>
                        <div class="col-8">{{ ucfirst($detail->mapping->category->module->name) }}</div>
                    </div><!-- /.module-info-items -->

                    <div class="module-info-items row">
                        <div class="col-4 opacity-50">@lang('global.category')</div>
                        <div class="col-8">{{ ucfirst($detail->mapping->category->name) }}</div>
                    </div><!-- /.module-info-items -->

                    <div class="module-info-items row">
                        <div class="col-4 opacity-50">@lang('global.mapping')</div>
                        <div class="col-8">{{ ucfirst($detail->mapping->name) }}</div>
                    </div><!-- /.module-info-items -->

                </div><!-- /.content-section -->

            </div><!-- /.section-info -->

            <div class="section-status py-3 px-2 d-flex flex-column gap-2">

                <h5 class="fw-normal">Document Status</h5>

                <div class="content-section d-flex flex-column gap-1">

                    <div class="module-status-items row">
                        <div class="col-4 opacity-50">@lang('global.upload_type')</div>
                        <div class="col-8">{{ ucfirst($detail->upload_type) }}</div>
                    </div><!-- /.module-info-items -->

                    <div class="module-status-items row">
                        <div class="col-4 opacity-50">Document</div>
                        <div class="col-8">{{ $detail->documenttype }}</div>
                    </div><!-- /.module-status-items -->

                </div><!-- /.content-section -->

            </div><!-- /.section-status -->

            @if (count($detail->peoples) > 0)
                <div class="section-invited-email py-3 px-2 d-flex flex-column gap-2">

                    <h5 class="fw-normal">Invited Email</h5>

                    <div class="content-section d-flex flex-column gap-1">

                        <div class="module-invited-email-items d-flex flex-wrap gap-2 ">
                            @foreach ($detail->peoples as $item)
                                <div class="btn btn-outline-secondary">{{ $item->email }}</div>
                            @endforeach

                        </div><!-- /.module-invited-items -->

                    </div><!-- /.content-section -->

                    @if (count($detail->peoples) > 8)
                        <div class="text-center">
                            <span class="show-more-text cursor-pointer">@lang('global.show_more')</span>
                        </div>
                    @endif

                </div><!-- /.section-invited-email -->
            @endif

            <div class="section-description py-3 px-2 d-flex flex-column gap-2">

                <h5 class="fw-normal">Description Document</h5>

                <div class="content-section">

                    {{-- <div class="module-description-items d-flex flex-wrap gap-2">
                        <p>
                            <img src="{{ asset('./images/desc.png') }}" alt="Image Desc" class="float-start me-2">
                            Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. ullamco laboris nisi ut.
                            Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. ullamco laboris nisi ut.
                            Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. ullamco laboris nisi ut.
                        </p>
                        <p>Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.</p>
                    </div><!-- /.module-info-items --> --}}
                    {{-- {!! $detail->description !!} --}}
                    <p>
                        {!! $detail->description !!}
                    </p>

                </div><!-- /.content-section -->

            </div><!-- /.section-description -->

            <div class="section-attachment py-3 px-2 d-flex flex-column gap-2">

                <h5 class="fw-normal">Attachment</h5>

                <div class="content-section d-flex flex-column gap-1">

                    <div class="module-attachment-items gap-2">

                        <div class="files-content d-flex gap-2 flex-wrap">
                            @foreach ($attachments as $item)
                                <div class="image d-flex flex-column align-items-start justify-content-center bg-white rounded p-3 border border-1"
                                    wire:click.prevent="detailAttachment('{{ $item->id }}')">
                                    <div class="thumb mb-2">
                                        <img src="{{ $item->icon_file_type }}" alt="pdf">
                                    </div>
                                    <div class="img-name">{{ $item->file_name }}</div>
                                    <div class="img-size opacity-50">{{ $item->file_size }} Kb</div>
                                </div><!-- image -->
                            @endforeach

                        </div><!-- /.files-content -->

                    </div><!-- /.module-attachment-items -->

                </div><!-- /.content-section -->

            </div><!-- /.section-Attachment -->

            @if (
                (auth()->user()->can('Approve Document Level 1') &&
                    $detail->status == \Modules\DocumentSystem\Entities\Document::WAITNG_REVIEW) ||
                    (auth()->user()->can('Approve Document Level 2') &&
                        $detail->status == \Modules\DocumentSystem\Entities\Document::ROOTING_REVIEW))
                <div class="section-action py-3 px-2 d-flex align-items-center justify-content-end">
                    <div class="footer-action mb-2">
                        <div class="action-wrapper d-flex align-items-center justify-content-end gap-2">
                            <a href="{{ route('maker') }}" class="btn btn-outline-secondary" wire:loading.remove
                                wire:target='saveData'>
                                Cancel
                            </a>
                            <x-button-spinner target="confirmRooting" :text="trans('global.processing')"></x-button-spinner>
                            <div class="button-document" wire:loading.remove wire:target='confirmRooting'>
                                <button
                                    class="dropdown-toggle btn btn-outline-default bg-green d-flex justify-content-center align-item-center text-white position-relative px-4"
                                    role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                    Document Action
                                </button>
                                <ul class="dropdown-menu">
                                    @php
                                        $type = 'rooting';
                                        if (
                                            auth()
                                                ->user()
                                                ->hasRole('Document System Checker Final')
                                        ) {
                                            $type = 'final';
                                        }
                                    @endphp
                                    <li>
                                        <button type="button" wire:click="confirmRooting('{{ $type }}')"
                                            class="dropdown-item">
                                            @if (auth()->user()->hasRole('Document System Checker'))
                                                @lang('global.rooting_approval')
                                            @else
                                                @lang('global.approve')
                                            @endif
                                        </button>
                                    </li>
                                    <li>
                                        <button type="button" data-bs-toggle="modal" data-bs-target="#modalRevision"
                                            class="dropdown-item">
                                            @lang('global.return_revision')
                                        </button>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            @endif

        </div><!-- /.section-content -->

        <div class="detail-right border-start border-1">

            @include('livewire.document-systems.maker.components.activity', [
                'activities' => $activities,
                'images' => $image_media,
                'files' => $file_media,
                'related' => $detail->related_document_number,
                'related_id' => $detail->related_document_id,
            ])

        </div><!-- /.detail-left -->

    </div><!-- /.detail-maker -->

    <!-- Modal actifity -->
    <div class="modal fade" id="modalActivity" tabindex="-1" aria-labelledby="modalActivity" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <form action="#">
                    <div class="modal-header">
                        <h5 class="modal-title fw-normal" id="modalActivityLabel">Activity</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"
                            aria-label="Close"></button>
                    </div>
                    <div class="modal-body">

                        <div class="activity d-flex flex-column gap-2">

                            <div class="item-content d-flex gap-1 align-items-center">

                                <div class="activity-item d-flex flex-column gap-2">

                                    <div class="activity-header d-flex justify-content-start align-items-center gap-2">
                                        <div class="thumb">
                                            <img src="{{ asset('./images/profile.png') }}" alt="Profile">
                                        </div>
                                        <div class="title d-flex flex-column">
                                            <span>Iqbal Ramadhan</span>
                                            <span class="opacity-50">Departement Name</span>
                                        </div>
                                    </div><!-- /.activity-item -->

                                    <div class="activity-content">

                                        <div class="activity-inner d-flex flex-column gap-2">

                                            <div class="desc">Lorem ipsum dolor sit amet, consectetur adipiscing
                                                elit, sed do eiusmod tempor incididunt ut labor...</div>
                                            <div class="images">
                                                <h6 class="fw-normal">Files</h6>
                                                <div class="files-content d-flex gap-2 flex-wrap">
                                                    <div
                                                        class="image d-flex flex-column align-items-start justify-content-center bg-white rounded p-3 border border-1">
                                                        <div class="thumb mb-2">
                                                            <img src="{{ asset('./images/icons/excel.png') }}"
                                                                alt="excel">
                                                        </div>
                                                        <div class="img-name">Evidence Data</div>
                                                        <div class="img-size opacity-50">3.2 Mb</div>
                                                    </div><!-- image -->
                                                    <div
                                                        class="image d-flex flex-column align-items-start justify-content-center bg-white rounded p-3 border border-1">
                                                        <div class="thumb mb-2">
                                                            <img src="{{ asset('./images/icons/pdf.png') }}"
                                                                alt="pdf">
                                                        </div>
                                                        <div class="img-name">File Name.pdf</div>
                                                        <div class="img-size opacity-50">3.2 Mb</div>
                                                    </div><!-- image -->
                                                </div><!-- /.files-content -->
                                            </div><!-- /.images -->

                                            <div class="images">
                                                <h6 class="fw-normal">Images</h6>
                                                <div class="images-content d-flex gap-2 flex-wrap">
                                                    <div class="image d-flex flex-column align-items-start justify-content-center bg-white rounded p-3 border border-1"
                                                        data-bs-toggle="tooltip" data-bs-placement="top"
                                                        title="Contoh toolpips dengan nama panjang">
                                                        <div class="thumb mb-2">
                                                            <img src="{{ asset('./images/activity.png') }}"
                                                                alt="activity">
                                                        </div>
                                                        <div class="img-name">Nama Panjang ...</div>
                                                        <div class="img-size opacity-50">3.2 Mb</div>

                                                    </div><!-- image -->
                                                    <div
                                                        class="image d-flex flex-column align-items-start justify-content-center bg-white rounded p-3 border border-1">
                                                        <div class="thumb mb-2">
                                                            <img src="{{ asset('./images/activity.png') }}"
                                                                alt="activity">
                                                        </div>
                                                        <div class="img-name">Image.jpg</div>
                                                        <div class="img-size opacity-50">3.2 Mb</div>
                                                    </div><!-- image -->
                                                    <div
                                                        class="image d-flex flex-column align-items-start justify-content-center bg-white rounded p-3 border border-1">
                                                        <div class="thumb mb-2">
                                                            <img src="{{ asset('./images/activity.png') }}"
                                                                alt="activity">
                                                        </div>
                                                        <div class="img-name">Image.jpg</div>
                                                        <div class="img-size opacity-50">3.2 Mb</div>
                                                    </div><!-- image -->
                                                    <div
                                                        class="image d-flex flex-column align-items-start justify-content-center bg-white rounded p-3 border border-1">
                                                        <div class="thumb mb-2">
                                                            <img src="{{ asset('./images/activity.png') }}"
                                                                alt="activity">
                                                        </div>
                                                        <div class="img-name">Image.jpg</div>
                                                        <div class="img-size opacity-50">3.2 Mb</div>
                                                    </div><!-- image -->
                                                    <div
                                                        class="image d-flex flex-column align-items-start justify-content-center bg-white rounded p-3 border border-1">
                                                        <div class="thumb mb-2">
                                                            <img src="{{ asset('./images/activity.png') }}"
                                                                alt="activity">
                                                        </div>
                                                        <div class="img-name">Image.jpg</div>
                                                        <div class="img-size opacity-50">3.2 Mb</div>
                                                    </div><!-- image -->
                                                </div><!-- /.images-content -->
                                            </div><!-- /.images -->

                                        </div><!-- /.actifity-inner -->

                                    </div><!-- /.actifity-content -->

                                    <div class="activity-footer opacity-50">2 days ago</div>

                                </div><!-- /.activity-item -->

                            </div>

                        </div><!-- /.author -->

                    </div>
                </form>
            </div>
        </div>
    </div><!-- modal activity -->

    {{-- modal revision --}}
    <div class="modal fade" wire:ignore.self id="modalRevision" tabindex="-1" aria-labelledby="modalRevisionLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="modalRevisionLabel">Review Information</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <x-inputs.textarea wire:model="revision_reason" id="revision_reason" cols="5"
                            rows="5" error="revision_reason"></x-inputs.textarea>
                    </div>

                    <div class="form-group">
                        <div class="proof-container">
                            <div class="proof-item add cursor-pointer" id="addFile">
                                <img src="{{ asset('images/icons/add_.png') }}" alt="">
                            </div>
                            <input type="file" style="display: none;" id="fileReasonPicker"
                                wire:model="file_revision" class="@error('revision_proof') is-invalid @enderror"
                                onchange="changeFile(this)">
                            @if (count($tmp) > 0)
                                @foreach ($tmp as $item)
                                    <div class="proof-item item">
                                        <img src="{{ $item['img_preview'] ? $item['img_preview'] : $item['ext_icon'] }}"
                                            alt="">
                                    </div>
                                @endforeach
                            @endif
                            {{-- <div class="proof-item add"></div> --}}
                        </div>
                        @error('revision_proof')
                            <div class="invalid-feedback d-block">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal" wire:loading.remove
                        wire:target='return'>Close</button>
                    <button type="button" class="btn bg-green text-white no-hover" wire:click.prevent="return"
                        wire:loading.remove wire:target='return'>Submit</button>
                    <x-button-spinner target="return" :text="trans('global.processing')"></x-button-spinner>
                </div>
            </div>
        </div>
    </div>

</div>

@push('scripts')
    <script>
        $(document).ready(function() {
            $("#addFile").on('click', (e) => {
                e.preventDefault();

                $('#fileReasonPicker').click();
            });

        });

        // modal events
        const modalRevision = document.getElementById('modalRevision')
        modalRevision.addEventListener('hidden.bs.modal', event => {
            @this.resetFormRevision();
        });

        window.addEventListener('close-modal-revision', () => {
            $('#modalRevision').modal('hide');
        });
        window.addEventListener('detail-media', (path) => {
            window.open(path.detail, '_blank');
        });
        window.addEventListener('confirm-rooting-approval', (detail) => {
            let type = detail.detail;
            let textConfirm;
            if (type == 'final') {
                textConfirm = "{{ trans('global.confirm_finalize_document') }}";
            } else {
                textConfirm = "{{ trans('global.confirm_rooting_approval') }}";
            }
            newSwal.fire({
                title: 'Are you sure?',
                text: textConfirm,
                icon: 'info',
                showCancelButton: true,
                confirmButtonText: "{{ trans('global.yes') }}",
                cancelButtonText: "{{ trans('global.cancel') }}",
                allowOutsideClick: () => !Swal.isLoading(),
                preConfirm: function(result) {
                    if (result) {
                        if (type == 'final') {
                            return @this.call('submitDocument');
                        } else {
                            return @this.call('submitRootingApproval');
                        }
                    }
                },
            });
        });
        window.addEventListener('confirm-update-document', () => {
            newSwal.fire({
                title: 'Are you sure?',
                text: "{{ trans('global.confirm_update_document') }}",
                icon: 'info',
                showCancelButton: true,
                confirmButtonText: "{{ trans('global.yes') }}",
                cancelButtonText: "{{ trans('global.cancel') }}",
                allowOutsideClick: () => !Swal.isLoading(),
                preConfirm: function(result) {
                    if (result) {
                        return @this.call('updateDocument');
                    }
                },
            });
        });

        function uploadTmpFile(data) {
            $.ajax({
                type: "POST",
                cache: false,
                contentType: false,
                processData: false,
                headers: {
                    'X-CSRF-TOKEN': "{{ csrf_token() }}"
                },
                url: "{{ $saveFileUrl }}",
                data: data,
                success: function(res) {
                    console.log('res', res);
                    @this.createdFiles(res);
                },
                error: function(err) {
                    console.log('err', err);
                }
            })
        }

        function changeFile(e) {
            let input = e.files[0];
            let form = new FormData();
            form.append('file', input);
            uploadTmpFile(form);
        }
    </script>
@endpush
