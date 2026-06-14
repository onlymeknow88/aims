<div class="own-info mb-5">

    <div class="mb-3">
        <h5 class="fw-normal">Owner Information</h4>
    </div>

    <div class="mb-3 row form-group required">

        <label for="company" class="col-sm-4 col-form-label">Company</label>

        <div class="col-sm-8">

            <x-inputs.select2 wire:model="company" id="company" placeholder="Select Company" data-child="department">

                @foreach ($companies as $key => $company)
                <option value="{{ $company['id'] }}">{{$company['company_name']}}</option>
                @endforeach

            </x-inputs.select2>

        </div>

    </div>

    <div class="mb-3 row form-group required">
        <label for="department" class="col-sm-4 col-form-label">Department</label>
        <div class="col-sm-8">
            <x-inputs.select2 wire:model="department" id="department" data-child="section"
                placeholder="Select Department">
                @foreach ($departments as $key => $department)
                <option value="{{ $department['id'] }}">{{$department['name']}}</option>
                @endforeach
            </x-inputs.select2>
        </div>
    </div>

    <div class="mb-3 row form-group required">
        <label for="section" class="col-sm-4 col-form-label">Section</label>
        <div class="col-sm-8">
            <x-inputs.select2 wire:model="section" id="section" data-child="pj" placeholder="Select Section">
                @foreach ($sections as $key => $section)
                <option value="{{ $section['id'] }}">{{$section['name']}}</option>
                @endforeach
            </x-inputs.select2>
        </div>
    </div>

    <div class="mb-3 row form-group required">
        <label for="pj" class="col-sm-4 col-form-label">Penanggung Jawab</label>
        <div class="col-sm-8">
            <x-inputs.select2-avatar wire:model="pj" id="pj" class="form-select" placeholder="Select Penanggung Jawab">

                @foreach ($pjs as $key => $area)
                <option class="d-flex gap-2 align-items-center" value="{{ $area['id'] }}"
                    data-avatar="{{ asset('./images/profile.png') }}" data-email="{{ $area['user']['email'] }}">
                    {{ $area['user']['name'] }}
                </option>
                @endforeach

                </x-inputs-select2-avatar>
        </div>
    </div>

</div>

<div class="map-info mb-5">
    <div class="mb-3">
        <h5 class="fw-normal">Mapping Information</h4>
    </div>
    <div class="mb-3 row form-group required">
        <label for="modules" class="col-sm-4 col-form-label">Module</label>
        <div class="col-sm-8">
            <x-inputs.select2 wire:model="module" data-child="category" id="module" placeholder="Select Module">
                @foreach ($modules as $key => $module)
                <option value="{{ $module['id'] }}">{{$module['name']}}</option>
                @endforeach
            </x-inputs.select2>
        </div>
    </div>

    <div class="mb-3 row form-group required">
        <label for="category" class="col-sm-4 col-form-label">Category</label>
        <div class="col-sm-8">
            <x-inputs.select2 wire:model="category" data-child="map" id="category" placeholder="Select Category Module">
                @foreach ($categories as $key => $category)
                <option value="{{ $category['id'] }}">{{$category['name']}}</option>
                @endforeach
            </x-inputs.select2>
        </div>
    </div>

    <div class="mb-3 row form-group required">
        <label for="mapping" class="col-sm-4 col-form-label">Mapping</label>
        <div class="col-sm-8">
            <x-inputs.select2 wire:model="map" id="map" placeholder="Select Mapping">
                @foreach ($mapping as $key => $mapItem)
                <option value="{{ $mapItem['id'] }}">{{$mapItem['name']}}</option>
                @endforeach
            </x-inputs.select2>
        </div>
    </div>
</div>

<div class="doc-info mb-5">

    <div class="mb-3">
        <h5 class="fw-normal">Document</h4>
    </div>

    <div class="mb-3 row form-group">

        <label for="jenis_upload" class="col-sm-4 col-form-label">Jenis Upload</label>

        <div class="col-sm-8">
            <x-inputs.select2 wire:model="jenis_upload" id="jenis_upload" placeholder="Select Jenis Upload">
                <option value=""></option>
                <option value="{{ App\Enums\DocumentSystem\UploadType::Document()->value }}">
                    {{ App\Enums\DocumentSystem\UploadType::Document()->description }}
                </option>
                <option value="{{ App\Enums\DocumentSystem\UploadType::Record()->value }}">
                    {{ App\Enums\DocumentSystem\UploadType::Record()->description }}
                </option>
            </x-inputs.select2>
        </div>

    </div>

    <div class="mb-3 row form-group">
        <label for="jenis_doc" class="col-sm-4 col-form-label">Jenis Document</label>
        <div class="col-sm-8">
            <x-inputs.select2 wire:model="jenis_doc" id="jenis_doc" placeholder="Select Jenis Document">
                <option value="">Select Jenis Document</option>
                <option value="{{ App\Enums\DocumentSystem\DocumentLevel::Manual()->value }}">
                    {{ App\Enums\DocumentSystem\DocumentLevel::Manual()->description }}
                </option>
                <option value="{{ App\Enums\DocumentSystem\DocumentLevel::Sop()->value }}">
                    {{ App\Enums\DocumentSystem\DocumentLevel::Sop()->description }}
                </option>
                <option value="{{ App\Enums\DocumentSystem\DocumentLevel::Ts()->value }}">
                    {{ App\Enums\DocumentSystem\DocumentLevel::Ts()->description }}
                </option>
            </x-inputs.select2>
        </div>
    </div>

    @if($jenis_doc === App\Enums\DocumentSystem\DocumentLevel::Sop()->value)

    <div class="mb-3 row form-group">
        <label for="sop_number" class="col-sm-4 col-form-label">SOP Number</label>
        <div class="col-sm-8">
            <input type="text" wire:model="sop_number" class="form-control" id="sop_number"
                placeholder="Your ID Document" />
        </div>
    </div>
        @if($activForm)
        <div class="mb-3 row form-group">
            <label for="win_number" class="col-sm-4 col-form-label">WIN Number</label>
            <div class="col-sm-8">
                <input type="text" wire:model="win_number" class="form-control" id="win_number"
                    placeholder="Your ID Document" />
            </div>

        </div>

        <div class="mb-3 row form-group">
            <label for="form_number" class="col-sm-4 col-form-label">Form Number</label>
            <div class="col-sm-8">
                <input type="text" wire:model="form_number" class="form-control" id="form_number"
                    placeholder="Your ID Document" />
            </div>
        </div>
        @endif
    @else
    <div class="mb-3 row form-group">
        <label for="doc_number" class="col-sm-4 col-form-label">Nomor Dokumen </label>
        <div class="col-sm-8">
            <input type="text" wire:model="doc_number" class="form-control" id="doc_number"
                placeholder="Your ID Document" />
        </div>
    </div>

    @endif

</div>

<div class="detail-doc mb-5">

    <div class="mb-3">
        <h5 class="fw-normal">Detailed Document</h4>
    </div>

    <div class="mb-3 row form-group">
        <label for="title" class="col-sm-4 col-form-label">Title</label>
        <div class="col-sm-8">
            <input type="text" wire:model="title" class="form-control" id="title" placeholder="Title" />
        </div>
    </div>

    <div class="mb-3 row form-group required">
        <label for="title" class="col-sm-4 col-form-label">Date of Create Document</label>
        <div class="col-sm-8">
            <x-inputs.datepicker wire:model="doc_created" id="doc_created" :error="'date'" />
        </div>
    </div>
</div>

<div class="invited-people mb-5">
    <div class="mb-5">
        <h5 class="fw-normal">Invited People</h4>
    </div>
    <div class="mb-3 row form-group">
        <div class="col-sm-12">
            <div class="position-relative input-group">
                <span class="input-group-text">
                    <i class="fa fa-envelope"></i>
                </span>
                <input class="form-control" type="email" id="invited_people" wire:model="inputInvited"
                    wire:keydown.enter.prevent="addInvitedPeople()" />
            </div>
        </div>
    </div>

    <div class="mb-3 row form-group d-flex gap-3 flex-wrap">
        @if($invitedPeople)
        @foreach ($invitedPeople as $key => $people)
        <div class="list-people position-relative px-3 py-2 border rounded w-auto d-flex gap-2 align-items-center">
            <span class="opacity-80">{{$people}}</span>
            <button class="btn-closed"><img src="{{asset('/images/icons/delete.png')}}"
                    wire:click.prevent="removeInvited('{{$people}}')" alt=""></button>
        </div>
        @endforeach
        @endif
    </div>
</div>

<div class="description mb-5">
    <div class="mb-3">
        <h5 class="fw-normal">Description</h4>
    </div>
    <div class="mb-3 row form-group required">
        <div class="col-sm-12">
            <x-inputs.texteditor wire:model.defer="description" id="description" :error="'description'" />
        </div>
    </div>
</div>

<div class="attachment mb-5">
    <div class="mb-3">
        <h5 class="fw-normal">Attachment</h4>
    </div>
    <div class="mb-3 row form-group required">
        <div class="col-sm-12">
            <div class="mb-5">
                <button class="btn btn-outline-upload w-100 position-relative h-128px" type="button">
                    <span><img src="{{asset('/images/icons/upload.png')}}" alt="image upload" /></span>
                    <span class="text-upload">Drop or <a href="#">Select File</a></span>
                    <input type="file" wire:model.defer="docs" id="docs" />

                </button>
            </div>

            <div class="list-files">

                <div class="module-attachment-items d-flex flex-wrap gap-2">

                    <div class="files-content d-flex gap-2 flex-wrap">
                        @if ($docs)
                        <div class="image position-relative d-flex flex-column align-items-start justify-content-center bg-white rounded p-3 border border-1"
                            data-bs-toggle="tooltip" data-bs-placement="top"
                            title="Contoh toolpips dengan nama panjang">
                            <div class="thumb mb-2">
                                <img src="{{ asset('./images/icons/pdf.png') }}" alt="pdf">
                            </div>
                            <div class="img-name">{{ $docs->getClientOriginalName() }}</div>
                            <button class="btn-closed position-absolute">
                                <img src="{{asset('/images/icons/delete.png')}}" alt="">
                            </button>
                        </div>
                        @endif
                        @if($attachments && $attachments->count() > 0)
                        @foreach($attachments as $file)
                        <div class="image position-relative d-flex flex-column align-items-start justify-content-center bg-white rounded p-3 border border-1"
                            data-bs-toggle="tooltip" data-bs-placement="top"
                            title="Contoh toolpips dengan nama panjang">
                            <a href="{{ asset($file->path) }}" target="blank">
                                <div class="thumb mb-2">
                                    <img src="{{ asset('./images/icons/pdf.png') }}" alt="pdf">
                                </div>
                                <div class="img-name">{{ $file->file_name }}</div>
                            </a>
                            <a href="" class="btn-closed position-absolute" wire:click.prevent="deleteAttach('{{ $file->id }}' )">
                                <img src="{{asset('/images/icons/delete.png')}}" alt="">
                            </a>
                        </div>
                        @endforeach
                        @endif
                    </div>

                </div>
            </div>
        </div>
    </div>
</div>

@once
@push('scripts')
<script src="https://unpkg.com/dropzone@5/dist/min/dropzone.min.js"></script>
@endpush
@endonce

@push('scripts')
<script>
    $(function() {
            $('#dropzone').dropzone({
                url: "/images",
                maxFilesize: 100,
                paramName: "uploadfile",
                maxThumbnailFilesize: 5,
            });
        })
</script>
@endpush