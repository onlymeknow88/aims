<div class="section-content w-100 py-3 px-5 d-flex flex-column gap-3">

    <div class="section-info py-3 px-2 d-flex flex-column gap-2">

        <h5 class="fw-normal">Module Information</h5>

        <div class="content-section d-flex flex-column gap-1">

            <div class="module-info-items row">
                <div class="col-4 opacity-50">Module</div>
                <div class="col-8">{{ $document->mapping->category->module->name }}</div>
            </div><!-- /.module-info-items -->

            <div class="module-info-items row">
                <div class="col-4 opacity-50">Category</div>
                <div class="col-8">{{ $document->mapping->category->name }}</div>
            </div><!-- /.module-info-items -->

            <div class="module-info-items row">
                <div class="col-4 opacity-50">Mapping</div>
                <div class="col-8">{{ $document->mapping->name }}</div>
            </div><!-- /.module-info-items -->

        </div><!-- /.content-section -->

    </div><!-- /.section-info -->

    <div class="section-status py-3 px-2 d-flex flex-column gap-2">

        <h5 class="fw-normal">Status Dokumen</h5>

        <div class="content-section d-flex flex-column gap-1">

            <div class="module-status-items row">
                <div class="col-4 opacity-50">Jenis Upload</div>
                <div class="col-8">{{
                    \App\Enums\DocumentSystem\UploadType::fromValue($document->upload_type)->description }}</div>
            </div><!-- /.module-info-items -->

            <div class="module-status-items row">
                <div class="col-4 opacity-50">Dokumen</div>
                <div class="col-8">{{
                    \App\Enums\DocumentSystem\DocumentLevel::fromValue($document->document_level)->description }}</div>
            </div>

            @if(\App\Enums\DocumentSystem\DocumentLevel::Sop()->value == $document->document_level)
            <div class="module-status-items row">
                <div class="col-4 opacity-50">SOP Number</div>
                <div class="col-8">
                    {{ $document->sop_number }}
                </div>
            </div>
            <div class="module-status-items row">
                <div class="col-4 opacity-50">WIN Number</div>
                <div class="col-8">
                    {{ $document->sop_add_win }}
                </div>
            </div>
            <div class="module-status-items row">
                <div class="col-4 opacity-50">Form Number</div>
                <div class="col-8">
                    {{ $document->sop_add_form }}
                </div>
            </div>
            @else
            <div class="module-status-items row">
                <div class="col-4 opacity-50">Nomor Dokumen</div>
                <div class="col-8">
                    {{ $document->document_number }}
                </div>
            </div>
            @endif

        </div><!-- /.content-section -->

    </div><!-- /.section-status -->

    <div class="section-invited-email py-3 px-2 d-flex flex-column gap-2">

        <h5 class="fw-normal">Invited Email</h5>

        <div class="content-section d-flex flex-column gap-1 h-200px overflow-auto">

            <div class="module-invited-email-items d-flex flex-wrap gap-2 ">
                @foreach(json_decode($document->related_people) as $people)
                <div class="btn btn-outline-secondary">{{ $people }}</div>
                @endforeach
            </div><!-- /.module-info-items -->

        </div><!-- /.content-section -->

    </div><!-- /.section-invited-email -->

    <div class="section-description py-3 px-2 d-flex flex-column gap-2">

        <h5 class="fw-normal">Description Document</h5>

        <div class="content-section d-flex flex-column gap-1">

            <div class="module-description-items d-flex flex-wrap gap-2">
                {!! $document->description !!}
            </div><!-- /.module-info-items -->

        </div><!-- /.content-section -->

    </div><!-- /.section-description -->
    @if ($document->attachments->count() > 0)
    <div class="section-description py-3 px-2 d-flex flex-column gap-2">

        <h5 class="fw-normal">Attachment</h5>

        <div class="content-section d-flex flex-column gap-1">
            <div class="list-files">

                <div class="module-attachment-items d-flex flex-wrap gap-2">

                    <div class="files-content d-flex gap-2 flex-wrap">

                        
                        @foreach($document->attachments as $docAttach)
                        <div class="image position-relative d-flex flex-column align-items-start justify-content-center bg-white rounded p-3 border border-1"
                            data-bs-toggle="tooltip" data-bs-placement="top"
                            title="Contoh toolpips dengan nama panjang">
                            <a href="{{ asset($docAttach->path) }}" target="blank">
                                <div class="thumb mb-2">
                                    <img src="{{ asset('./images/icons/pdf.png') }}" alt="pdf">
                                </div>
                                <div class="img-name" style="font-size:12px">{{ $docAttach->file_name }}</div>
                            </a>
                            <div class="img-size opacity-50" style="font-size:12px">{{ $docAttach->file_size_mb }}</div>
                            {{-- <button class="btn-closed position-absolute">
                                <img src="{{asset('/images/icons/delete.png')}}" alt="">
                            </button> --}}
                        </div>
                        @endforeach
                        
                    </div>
                </div>
            </div>

        </div>

    </div>
    @endif

    @if($document->reviewable)
    <div class="footer-action">
        <div class="action-wrapper d-flex align-items-center justify-content-end gap-2">
            <a href="{{ route('document-systems::review') }}" class="btn btn-outline-secondary">Cancel</a>
            <div class="button-document">
                <button
                    class="dropdown-toggle btn btn-outline-default bg-green d-flex justify-content-center align-item-center text-white position-relative"
                    role="button" data-bs-toggle="dropdown" aria-expanded="false">
                    Document Action
                </button>
                <ul class="dropdown-menu">
                    <li>
                        @if($approved)
                        <a class="dropdown-item" href="#" wire:click="saveToApproved">
                            Approved
                        </a>
                        @else
                        <a class="dropdown-item" href="#" wire:click="saveToRoutingApproval">
                            Routing Approval
                        </a>
                        @endif
                    </li>
                    <li>
                        <a class="dropdown-item" href="#" data-bs-toggle="modal" data-bs-target="#modalReview">
                            Return with comment
                        </a>
                    </li>
                </ul>
            </div>
        </div>
    </div>
    @endif
</div><!-- /.section-content -->