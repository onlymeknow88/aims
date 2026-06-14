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
    </style>
@endpush

<div class="inner-content">

    <div class="header-detail-maker h-60px border d-flex gap-2 align-items-center px-3">
        <a href="{{ $back_url }}" class="d-flex align-items-center gap-3 ">
            <span><i class="fa-solid fa-arrow-left"></i></span>
            <span>{{ $detail->title }}</span>
        </a>
        @if (
            ($detail->status == \Modules\DocumentSystem\Entities\Document::ON_REVISION ||
                $detail->status == \Modules\DocumentSystem\Entities\Document::DRAFT ||
                ($detail->status == \Modules\DocumentSystem\Entities\Document::PREPARE_ROOTING_REVIEW &&
                    (auth()->user()->id == $detail->created_by || auth()->user()->id == $detail->user_id))) &&
                (auth()->user()->can('Document System - Edit Document') ||
                    auth()->user()->can('Document System - Edit JSA')))
            <a href="{{ route('document-systems::edit-maker', ['id' => $id_maker]) }}"
                class="btn btn-edit text-white bg-146943"> <i class="fas fa-pencil"></i> Edit Document</a>
        @endif

        @if (
            ($detail->status == \Modules\DocumentSystem\Entities\Document::EXPIRED ||
                $detail->status == \Modules\DocumentSystem\Entities\Document::ACTIVE) &&
                $detail->is_obsolate == 0 &&
                auth()->user()->can('Document System - Edit Document'))
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

                @if ($detail->status == Modules\DocumentSystem\Entities\Document::ACTIVE)
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

                @if ($detail->status == Modules\DocumentSystem\Entities\Document::OBSOLATE || $detail->revision > 0)
                    <div class="info-item p-3 border-bottom border-1">

                        <div class="expired d-flex flex-column gap-2">

                            <h6 class="fw-normal">@lang('global.status_document')</h6>

                            <div class="item-content d-flex gap-1 align-items-center">
                                <span>@lang('global.revision') {{ $detail->revision ?? '0' }}.0</span>
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

                <h5 class="fw-normal">Detail Document</h5>

                <div class="content-section d-flex flex-column gap-1">

                    <div class="module-info-items row">
                        <div class="col-4 opacity-50">Title</div>
                        <div class="col-8">{{ ucfirst($detail->title) }}</div>
                    </div><!-- /.module-info-items -->

                </div><!-- /.content-section -->

            </div><!-- /.section-info -->

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

                    <div class="module-status-items row">
                        <div class="col-4 opacity-50">ID Document</div>
                        <div class="col-8">{{ $detail->fix_document_number }}</div>
                    </div><!-- /.module-status-items -->

                    <div class="module-info-items row">
                        <div class="col-4 opacity-50">Status</div>
                        <div class="col-8">{!! $detail->status_badge !!}</div>
                    </div><!-- /.module-info-items -->

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

                        <div class="files-content d-flex flex-column gap-2">
                            @foreach ($attachments as $item)
                                <div class="image d-flex w-100 align-items-center bg-white rounded p-3 border border-1"
                                    data-bs-toggle="tooltip" data-bs-placement="top"
                                    wire:click.prevent="detailAttachment('{{ $item->id }}')">
                                    <div class="thumb mb-2">
                                        <img src="{{ $item->icon_file_type }}" alt="pdf">
                                    </div>
                                    <div class="img-name">{{ Str::limit($item->file_name, 25) }}</div>
                                    <div class="img-size opacity-50 ms-auto">{{ $item->file_size }} Kb</div>
                                </div><!-- image -->
                            @endforeach

                        </div><!-- /.files-content -->

                    </div><!-- /.module-attachment-items -->

                </div><!-- /.content-section -->

            </div><!-- /.section-Attachment -->

            @if (
                (auth()->user()->can('Document System - Approve Document Level 1') &&
                    $detail->status == \Modules\DocumentSystem\Entities\Document::WAITNG_REVIEW) ||
                    (auth()->user()->can('Document System - Approve Document Level 2') &&
                        ($detail->status == \Modules\DocumentSystem\Entities\Document::ROOTING_REVIEW ||
                            $detail->status == \Modules\DocumentSystem\Entities\Document::PREPARE_ROOTING_REVIEW)))
                <div class="section-action py-3 px-2 d-flex align-items-center justify-content-end">
                    <div class="footer-action mb-2">
                        <div class="action-wrapper d-flex align-items-center justify-content-end gap-2">
                            <a href="{{ route('document-systems::maker') }}" class="btn btn-outline-secondary"
                                wire:loading.remove wire:target='saveData'>
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
                                        if ($detail->status == \Modules\DocumentSystem\Entities\Document::ROOTING_REVIEW || $detail->status == \Modules\DocumentSystem\Entities\Document::PREPARE_ROOTING_REVIEW) {
                                            $type = 'final';
                                        }
                                    @endphp
                                    <li>
                                        <button type="button" wire:click="confirmRooting('{{ $type }}')"
                                            class="dropdown-item">
                                            @if ($detail->status == \Modules\DocumentSystem\Entities\Document::ROOTING_REVIEW || $detail->status == \Modules\DocumentSystem\Entities\Document::PREPARE_ROOTING_REVIEW)
                                                @lang('global.approve')
                                            @else
                                                @lang('global.rooting_approval')
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

            @include('documentsystem::livewire.maker.components.activity', [
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
                                @foreach ($tmp as $key => $item)
                                    <div class="proof-item item position-relative"
                                        id="proof-key-{{ $key }}">
                                        <img src="{{ $item['img_preview'] ? $item['img_preview'] : $item['ext_icon'] }}"
                                            alt="">
                                        <img src="{{ asset('images/icons/delete-top.svg') }}"
                                            style="width: 20px; height: 20px; position: absolute; top: -5px; right: -5px; cursor: pointer;"
                                            alt="cancel" wire:click="deleteProof(`{{ $item['name'] }}`)">
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
        //         text: "{{ trans('global.confirm_update_document') }}",
        //         icon: 'info',
        //         showCancelButton: true,
        //         confirmButtonText: "{{ trans('global.yes') }}",
        //         cancelButtonText: "{{ trans('global.cancel') }}",
        //         allowOutsideClick: () => !Swal.isLoading(),
        //         preConfirm: function(result) {
        //             if (result) {
        //                 return @this.call('updateDocument');
        //             }
        //         },
        //     });
        // });

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
