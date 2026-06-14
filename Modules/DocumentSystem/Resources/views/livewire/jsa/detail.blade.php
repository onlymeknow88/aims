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
            min-height: 50px;
        }

        .activity-content .images .img-name,
        #modalActivity .images .img-name {
            overflow: hidden;
            cursor: pointer;
            white-space: nowrap;
            text-overflow: ellipsis;
            width: 180px;
        }

        #modalActivity .images .img-name {
            margin-bottom: 0;
            width: 95%;
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
    </style>
@endpush

<div class="inner-content">

    <div class="header-detail-maker h-60px border d-flex gap-2 align-items-center px-3">
        <a href="{{ $back_url }}" class="d-flex align-items-center gap-3 ">
            <span><i class="fa-solid fa-arrow-left"></i></span>
            <span>{{ $detail->title }}</span>
        </a>

        @if (
            ($detail->status == \Modules\DocumentSystem\Entities\JsaDocument::EXPIRED ||
                $detail->status == \Modules\DocumentSystem\Entities\JsaDocument::ACTIVE) &&
                $detail->is_obsolate == 0)
            <a class="btn btn-edit text-white bg-146943" type="button" wire:click="confirmUpdateDocument">
                <i class="fas fa-pencil"></i> Update Document
            </a>
        @endif

        @if ($detail->status == \Modules\DocumentSystem\Entities\JsaDocument::DRAFT)
            <a href="{{ route('document-systems::jsa.edit', ['id' => $id_maker]) }}"
                class="btn btn-edit text-white bg-146943"> <i class="fas fa-pencil"></i> Edit Document</a>
        @endif
    </div>

    <div class="detail-maker-content d-flex">

        <div class="detail-left border-end border-1">

            <div class="info bg-white">

                <div class="info-item p-3 border-bottom border-1">

                    <div class="author d-flex flex-column gap-2">
                        <div class="item-content d-flex gap-2 align-items-center">
                            <span class="profile-image">
                                <!--<img src="{{ asset('images/profile.png') }}" alt="Profile images" srcset="{{ asset('images/profile.png') }}">-->
                                <span
                                    class="text-profile">{{ preg_filter('/[^A-Z]/', '', ucfirst($detail->user->name)) }}</span>
                            </span>
                            <span class="profile-text">{{ ucfirst($detail->user->name) }}</span>
                        </div>
                    </div><!-- /.author -->

                </div><!-- /.info-items -->

                <div class="info-item p-3 border-bottom border-1">

                    <div class="created d-flex flex-column gap-2">

                        <h6 class="fw-normal">Company</h6>

                        <div class="item-content d-flex gap-1 align-items-center">
                            <span class="fw-normal">{{ $detail->department->company->company_name }}</span>
                        </div>

                    </div><!-- /.author -->

                </div><!-- /.info-items -->

                <div class="info-item p-3 border-bottom border-1">

                    <div class="created d-flex flex-column gap-2">

                        <h6 class="fw-normal">Department</h6>

                        <div class="item-content d-flex gap-1 align-items-center">
                            <span class="fw-normal">{{ $detail->department->name }}</span>
                        </div>

                    </div><!-- /.author -->

                </div><!-- /.info-items -->

                <div class="info-item p-3 border-bottom border-1">

                    <div class="created d-flex flex-column gap-2">

                        <h6 class="fw-normal">Location</h6>

                        <div class="item-content d-flex gap-1 align-items-center">
                            <span class="fw-normal">{{ $detail->department->company->address }}</span>
                        </div>

                    </div><!-- /.author -->

                </div><!-- /.info-items -->

                <div class="info-item p-3 border-bottom border-1">

                    <div class="created d-flex flex-column gap-2">

                        <h6 class="fw-normal">Created</h6>

                        <div class="item-content d-flex gap-1 align-items-center">
                            {{-- <span class="opacity-50">by</span>
                            <span>PT. Maruawai</span>
                            <span class="opacity-50">on</span> --}}
                            <span>{{ date('d F Y', strtotime($detail->doc_created)) }}</span>
                        </div>

                    </div><!-- /.author -->

                </div><!-- /.info-items -->

                @if ($detail->status == Modules\DocumentSystem\Entities\JsaDocument::ACTIVE)
                    <div class="info-item p-3 border-bottom border-1">

                        <div class="expired d-flex flex-column gap-2">

                            <h6 class="fw-normal">Expired</h6>

                            <div class="item-content d-flex gap-1 align-items-center">
                                {{-- <span class="opacity-50">by</span>
                                <span>System</span>
                                <span class="opacity-50">on</span> --}}
                                <span>{{ $detail->expired }}</span>
                            </div>

                        </div><!-- /.author -->

                    </div><!-- /.info-items -->
                @endif

                @if ($detail->status == Modules\DocumentSystem\Entities\JsaDocument::OBSOLATE || $detail->revision > 0)
                    <div class="info-item p-3 border-bottom border-1">

                        <div class="expired d-flex flex-column gap-2">

                            <h6 class="fw-normal">@lang('global.status_document')</h6>

                            <div class="item-content d-flex gap-1 align-items-center">
                                <span>@lang('global.revision') {{ $detail->revision == '' ? 0 : $detail->revision }}.0</span>
                            </div>

                        </div><!-- /.author -->

                    </div><!-- /.info-items -->
                @endif

                @if (
                    !auth()->user()->can('Document System - Approve Document Level 1') &&
                        !auth()->user()->can('Document System - Approve Document Level 2'))
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

                <h5 class="fw-normal">Detailed Document</h5>

                <div class="content-section d-flex flex-column gap-1">

                    <div class="module-info-items row">
                        <div class="col-4 opacity-50">Document Number</div>
                        <div class="col-8">{{ ucfirst($detail->document_number) }}</div>
                    </div><!-- /.module-info-items -->

                    <div class="module-info-items row">
                        <div class="col-4 opacity-50">Title </div>
                        <div class="col-8">{{ ucfirst($detail->title) }}</div>
                    </div><!-- /.module-info-items -->

                    <div class="module-info-items row">
                        <div class="col-4 opacity-50">Detail Location</div>
                        <div class="col-8">{{ ucfirst($detail->detail_location) }}</div>
                    </div><!-- /.module-info-items -->

                    <div class="module-info-items row">
                        <div class="col-4 opacity-50">Status</div>
                        <div class="col-8">{!! $detail->status_badge !!}</div>
                    </div><!-- /.module-info-items -->

                </div><!-- /.content-section -->

            </div><!-- /.section-info -->

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

                    <div class="module-attachment-items d-flex flex-wrap gap-2">

                        <div class="files-content d-flex gap-2 flex-wrap">
                            @foreach ($attachments as $item)
                                <div class="image d-flex flex-column align-items-start justify-content-center bg-white rounded p-3 border border-1"
                                    wire:click.prevent="detailAttachment('{{ $item->id }}')">
                                    <div class="thumb mb-2">
                                        <img src="{{ $item->icon_file_type }}" alt="pdf">
                                    </div>
                                    <div class="img-name">{{ Str::limit($item->file_name, 25) }}</div>
                                    <div class="img-size opacity-50">{{ $item->file_size }} Kb</div>
                                </div><!-- image -->
                            @endforeach

                        </div><!-- /.files-content -->

                    </div><!-- /.module-attachment-items -->

                </div><!-- /.content-section -->

            </div><!-- /.section-Attachment -->

        </div><!-- /.section-content -->

        <div class="detail-right border-start border-1">

            @include('documentsystem::livewire.jsa.components.activity', [
                'activities' => $activities,
                'images' => $image_media,
                'files' => $file_media,
                'related' => $detail->related_document_number,
                'related_id' => $detail->related_document_id,
            ])

        </div><!-- /.detail-left -->

    </div><!-- /.detail-maker -->

    <!-- Modal actifity -->
    <div class="modal fade" id="modalActivity" wire:ignore.self tabindex="-1" aria-labelledby="modalActivity"
        aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <form action="#">
                    <div class="modal-header">
                        <h5 class="modal-title fw-normal" id="modalActivityLabel">Activity</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"
                            aria-label="Close"></button>
                    </div>

                    @if ($detailActivity)
                        <div class="modal-body">

                            <div class="activity d-flex flex-column gap-2">

                                <div class="item-content d-flex gap-1 align-items-center">

                                    <div class="activity-item d-flex flex-column gap-2 w-100">

                                        <div
                                            class="activity-header d-flex justify-content-start align-items-center gap-2">
                                            <div class="thumb">
                                                <img src="{{ asset('./images/profile.png') }}" alt="Profile">
                                            </div>
                                            <div class="title d-flex flex-column">
                                                <span>{{ $detailActivity['user']['name'] }}</span>
                                                <span
                                                    class="opacity-50">{{ $detailActivity['user']['department'] ? $detailActivity['user']['department']['name'] : '' }}</span>
                                            </div>
                                        </div><!-- /.activity-item -->

                                        <div class="activity-content">

                                            <div class="activity-inner d-flex flex-column gap-2">

                                                <div class="desc">{{ $detailActivity['description'] }}</div>

                                                @if (count($detailActivity['attachments']) > 0)
                                                    @if (isset($detailActivity['attachments']['image']))
                                                        <div class="images">
                                                            <h6 class="fw-normal">Images</h6>

                                                            <div class="images-content d-flex gap-2 flex-wrap">
                                                                @foreach ($detailActivity['attachments']['image'] as $attach)
                                                                    <div class="image d-flex flex-column align-items-start justify-content-center bg-white rounded p-3 border border-1"
                                                                        wire:click.prevent="detailItem('{{ $attach['id'] }}')"
                                                                        data-bs-toggle="tooltip"
                                                                        data-bs-placement="top"
                                                                        title="{{ $attach['name'] }}">
                                                                        <div class="thumb mb-2">
                                                                            <img src="{{ $attach['path'] }}"
                                                                                style="width: 30px; height: 30px;"
                                                                                alt="activity">
                                                                        </div>
                                                                        <p class="img-name">
                                                                            {{ Str::limit($attach['name'], 25) }}
                                                                        </p>
                                                                        <div class="img-size opacity-50">
                                                                            {{ $attach['file_size'] }} Kb</div>

                                                                    </div><!-- image -->
                                                                @endforeach
                                                            </div><!-- /.images-content -->
                                                        </div><!-- /.images -->
                                                    @endif
                                                    @if (isset($detailActivity['attachments']['file']))
                                                        <div class="images">
                                                            <h6 class="fw-normal">Files</h6>

                                                            <div class="files-content d-flex gap-2 flex-wrap">
                                                                @foreach ($detailActivity['attachments']['file'] as $attach)
                                                                    <div class="image d-flex flex-column align-items-start justify-content-center bg-white rounded p-3 border border-1"
                                                                        wire:click.prevent="detailItem('{{ $attach['id'] }}')"
                                                                        data-bs-toggle="tooltip"
                                                                        data-bs-placement="top"
                                                                        title="{{ $attach['name'] }}">
                                                                        <div class="thumb mb-2">
                                                                            <img src="{{ $attach['icon_preview'] }}"
                                                                                alt="excel">
                                                                        </div>
                                                                        <p class="img-name">
                                                                            {{ Str::limit($attach['name'], 25) }}
                                                                        </p>
                                                                        <div class="img-size opacity-50">
                                                                            {{ $attach['file_size'] }} Kb</div>
                                                                    </div><!-- image -->
                                                                @endforeach
                                                            </div><!-- /.files-content -->
                                                        </div><!-- /.images -->
                                                    @endif
                                                @endif

                                            </div><!-- /.actifity-inner -->

                                        </div><!-- /.actifity-content -->

                                        <div class="activity-footer opacity-50">
                                            {{ \Carbon\Carbon::parse($detailActivity['created_at'])->diffForHumans() }}
                                        </div>

                                    </div><!-- /.activity-item -->

                                </div>

                            </div><!-- /.author -->

                        </div>
                    @endif
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
                    <h1 class="modal-title fs-5" id="modalRevisionLabel">
                        Renew Attachment and Detail Location
                    </h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="form-group mb-2">
                        <label for="new_detail_location" class="form-label">
                            Detail Location
                        </label>
                        <x-inputs.text wire:model="new_detail_location" id="new_detail_location"
                            error="new_detail_location"></x-inputs.text>
                    </div>

                    <div class="form-group">
                        <label for="" class="form-label">
                            Attachment
                        </label>
                        <div class="mb-3 row form-group ">

                            <div class="col-sm-12">
                                {{-- <x-inputs.upload-files :docs="$docs" id="docs" :error="'docs'" /> --}}
                                <div id="dropbox">
                                    Drop or <span id="select" class="ms-2">Select File</span>
                                </div>

                                <input type="file" wire:model="file" id="file" style="display: none;">
                            </div>

                        </div><!-- /.form-group -->

                        {{-- review --}}
                        @if (count($tmp) > 0)
                            <div class="row">
                                @foreach ($tmp as $item)
                                    @php
                                        $id_media = null;
                                        if (isset($item['id'])) {
                                            $id_media = $item['id'];
                                        }
                                    @endphp
                                    <div class="col-md-3 mb-2">
                                        <div class="review-box">
                                            <div class="header d-flex align-items-center justify-content-between">
                                                <img class="file-icon" src="{{ $item['ext_icon'] }}" alt="">
                                                <img class="delete-icon"
                                                    wire:click="removeFile('{{ $item['name'] }}', '{{ $id_media }}')"
                                                    src="{{ asset('images/icons/delete.png') }}" alt="">
                                            </div>
                                            <div class="body mt-4">
                                                <p class="name">{{ $item['name'] }}</p>
                                                <p class="size">{{ $item['size'] }} Kb</p>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        @endif
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal" wire:loading.remove
                        wire:target='renew'>Close</button>
                    <button type="button" class="btn bg-green text-white no-hover" wire:click.prevent="renew"
                        wire:loading.remove wire:target='renew'>Submit</button>
                    <x-button-spinner target="renew" :text="trans('global.processing')"></x-button-spinner>
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
        window.addEventListener('open-modal-activity', () => {
            $('#modalActivity').modal('show');
        });
        window.addEventListener('detail-media', (path) => {
            window.open(path.detail, '_blank');
        });
        // window.addEventListener('confirm-rooting-approval', (detail) => {
        //     let type = detail.detail;
        //     let textConfirm;
        //     if (type == 'final') {
        //         textConfirm = "{{ trans('global.confirm_finalize_document') }}";
        //     } else {
        //         textConfirm = "{{ trans('global.confirm_rooting_approval') }}";
        //     }
        //     newSwal.fire({
        //         title: 'Are you sure?',
        //         text: textConfirm,
        //         icon: 'info',
        //         showCancelButton: true,
        //         confirmButtonText: "{{ trans('global.yes') }}",
        //         cancelButtonText: "{{ trans('global.cancel') }}",
        //         allowOutsideClick: () => !Swal.isLoading(),
        //         preConfirm: function(result) {
        //             if (result) {
        //                 if (type == 'final') {
        //                     return @this.call('submitDocument');
        //                 } else {
        //                     return @this.call('submitRootingApproval');
        //                 }
        //             }
        //         },
        //     });
        // });
        // window.addEventListener('confirm-update-document', () => {
        //     newSwal.fire({
        //         title: 'Are you sure?',
        //         text: "You can renew this document or create a new one based on it.",
        //         icon: 'info',
        //         showCancelButton: true,
        //         confirmButtonText: "Renew Document",
        //         cancelButtonText: "Create New",
        //         allowOutsideClick: () => !Swal.isLoading(),
        //         preConfirm: function(result) {
        //             if (result) {
        //                 return @this.call('confirmRenewDocument');
        //             }
        //         },
        //     }).then((result) => {
        //         if (!result.isConfirmed) {
        //             return @this.call('confirmCreateNew');
        //         }
        //     });
        // });
        window.addEventListener('modal-renew-document', () => {
            $('#modalRevision').modal('show');
        });

        // begin::custom dropbox
        let dropbox;
        dropbox = document.getElementById("dropbox");
        window.addEventListener("dragenter", dragenter, false);
        window.addEventListener("dragover", dragover, false);
        window.addEventListener("drop", drop, false);

        function dragenter(e) {
            e.stopPropagation();
            e.preventDefault();
            $('#dropbox').addClass('active');
        }

        function dragover(e) {
            e.stopPropagation();
            e.preventDefault();
        }

        function drop(e) {
            e.stopPropagation();
            e.preventDefault();
            $('#dropbox').removeClass('active');

            const dt = e.dataTransfer;
            const files = dt.files[0];
            let form = new FormData();
            form.append('file', files);
            uploadTmpFileJsa(form);
        }

        $('#select').on('click', function(e) {
            e.preventDefault();

            $('#file').click();
        })

        $('#file').on('change', function(e) {
            e.preventDefault();
            let input = this;
            let form = new FormData();
            form.append('file', input.files[0]);
            uploadTmpFileJsa(form);
        });

        function uploadTmpFileJsa(data) {
            $.ajax({
                type: "POST",
                cache: false,
                contentType: false,
                processData: false,
                headers: {
                    'X-CSRF-TOKEN': "{{ csrf_token() }}"
                },
                url: "{{ route('document-systems::jsa.files.renew-document') }}",
                data: data,
                success: function(res) {
                    console.log(res);
                    @this.createdFiles(res);
                },
                error: function(err) {
                    console.log('err', err);
                }
            })
        }
        // end::custom dropbox

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
