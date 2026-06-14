<div class="inner-content">

    <div
        class="header-content-inspeksi-food-hygiene h-60px bg-white shadow-sm d-flex gap-2 align-items-center justify-content-between px-3">
        <div class="left-header">
            <a href="javascript:history.go(-1)" class="d-flex align-items-center gap-3">
                <span><i class="fa-solid fa-arrow-left"></i></span>
                <span>Create PJO</span>
            </a>
        </div><!-- /.left-header -->
    </div><!-- /.header-content-inspeksi-food-hygiene -->

    <div class="addnew-maker-content container py-5 px-3">

        <div class="row justify-content-center">

            <div class="col-8">

                <form class="form-horizontal" method="post" enctype="multipart/form-data">

                    <div class="own-info mb-5">

                        <div class="mb-5">
                            <h5 class="fw-normal">Ajukan Data PJO</h5>
                        </div>

                        <div class="row mb-3 form-group required">
                            <label for="companyId" class="col col-form-label">
                                Company
                            </label>
                            <div class="col-8">
                                <x-csms-select2 id="company_id" placeholder="Nama Perusahaan" :error="'company_id'"
                                    wire:model.defer="company_id">
                                    @foreach ($this->biddingCompanies as $index => $c)
                                        <option value="{{ $c->id }}">{{ $c->company_name }}
                                        </option>
                                    @endforeach
                                </x-csms-select2>
                            </div>
                        </div><!-- /.form-group companyId -->

                        <div class="row mb-3 form-group required">
                            <label for="criteria" class="col col-form-label">
                                Criteria Company
                            </label>
                            <div class="col-8">
                                <x-inputs.text wire:model="criteria" id="criteria" placeholder="Kriteria Perusahaan"
                                    :error="'criteria'" disabled />
                            </div>
                        </div><!-- /.form-group criteria -->

                        @if ($criteria == Modules\CSMS\Enums\ServiceCriteria::SubContractor->value)
                            <div class="row mb-3 form-group required">
                                <label for="ccow_id" class="col col-form-label">CCOW</label>
                                <div class="col-8">

                                    <x-csms-select2 id="ccow_id" placeholder="CCOW" :error="'ccow_id'"
                                        wire:model.defer="ccow_id" disabled>
                                        @foreach ($this->ccows as $index => $item)
                                            <option value="{{ $item->id }}">
                                                {{ $item->company_name }}
                                            </option>
                                        @endforeach
                                    </x-csms-select2>

                                </div>
                            </div><!-- /.form-group ccow -->
                        @endif

                        <div class="row mb-3 form-group">
                            <label for="submission" class="col-lg-4 col-md-12 col-form-label">
                                Submission
                            </label>
                            <div class="col-lg-8 col-md-12">
                                <x-inputs.text wire:model="submission" id="submission" placeholder="Pengajuan"
                                    :error="'submission'" />
                            </div>
                        </div><!-- /.form-group penajuan -->

                        <div class="row mb-3 form-group required">
                            <label for="number_pjo" class="col col-form-label">
                                Number PJO
                            </label>
                            <div class="col-8">
                                <x-inputs.text wire:model="number_pjo" id="number_pjo" placeholder="Number PJO"
                                    :error="'number_pjo'" disabled />
                            </div>
                        </div><!-- /.form-group Number PJO -->

                        <div class="row mb-3 form-group required">
                            <label for="name" class="col col-form-label">
                                Name
                            </label>
                            <div class="col-8">
                                <x-inputs.text wire:model="name" id="name" placeholder="Name" :error="'name'" />
                            </div>
                        </div><!-- /.form-group Name -->

                        <div class="row mb-3 form-group required">
                            <label for="date_of_birth" class="col col-form-label">
                                Date of Birth
                            </label>
                            <div class="col-8">
                                <x-inputs.datepicker wire:model="date_of_birth" id="date_of_birth" :error="'date_of_birth'"
                                    placeholder="Select Date" />
                            </div>
                        </div><!-- /.form-group date -->

                        <div class="row mb-3 form-group required">
                            <label for="phone" class="col col-form-label">
                                Phone Number
                            </label>
                            <div class="col-8">
                                <x-inputs.text wire:model="phone" id="phone" placeholder="Phone Number"
                                    :error="'phone'" />
                            </div>
                        </div><!-- /.form-group Phone Number -->

                        <div class="row mb-3 form-group required">
                            <label for="email" class="col col-form-label">
                                Email
                            </label>
                            <div class="col-8">
                                <x-inputs.text wire:model="email" id="email" placeholder="Email"
                                    :error="'email'" />
                            </div>
                        </div><!-- /.form-group Email -->

                        <div class="row mb-3 form-group required">

                            <label for="kompetensi" class="col col-form-label">
                                Sertifikat Kompetensi (POP/POM/POU), ISMKP, ASMKP
                            </label>
                            <div class="">
                                <button class="btn btn-outline-upload w-100 position-relative h-128px"
                                    style="border: 1px dashed #810DA8; background-color: #810DA80A;" type="button">
                                    <span><img src="{{ asset('/images/icons/upload.png') }}"
                                            alt="image upload" /></span>
                                    <span class="text-upload">Drop or <a href="#">Select
                                            File</a></span>
                                    <input type="file" name="" id=""
                                        wire:model="temporaryFile.competency_file" accept=".pdf, .png, .jpeg, .jpg"
                                        multiple />

                                </button>
                            </div>

                        </div><!-- /.form-group -->

                        @if (!empty($files['competency_file']))
                            <div class="module-attachment-items gap-2">

                                <div class="files-content d-flex flex-column gap-2">
                                    @foreach ($files['competency_file'] as $keyFile => $itemFile)
                                        <div class="image d-flex w-100 align-items-center bg-white rounded p-3 border border-1"
                                            data-bs-toggle="tooltip" data-bs-placement="top" title="attachment">
                                            <div class="thumb">
                                                <img src="{{ asset('/images/icons/pdf.png') }}" alt="excel">
                                            </div>
                                            <div class="img-name">{{ $itemFile['name'] }}</div>
                                            <div class="img-size opacity-50 ms-auto">{{ $itemFile['size'] }}</div>
                                            <div class="delete-icon">
                                                <img src="/images/icons/delete-top.svg" alt=""
                                                    wire:click="removeFile('competency_file', '{{ $loop->index }}')">
                                            </div>
                                        </div><!-- image -->
                                    @endforeach
                                </div>
                            </div>
                        @endif

                        <div class="row mb-3 form-group">

                            <label for="other" class="col col-form-label">
                                Sertifikat Lainnya (Bila ada)
                            </label>
                            <div class="">
                                <button class="btn btn-outline-upload w-100 position-relative h-128px"
                                    style="border: 1px dashed #810DA8; background-color: #810DA80A;" type="button">
                                    <span><img src="{{ asset('/images/icons/upload.png') }}"
                                            alt="image upload" /></span>
                                    <span class="text-upload">Drop or <a href="#">Select
                                            File</a></span>
                                    <input type="file" name="" id=""
                                        wire:model="temporaryFile.other_file" accept=".pdf, .png, .jpeg, .jpg"
                                        multiple />

                                </button>
                            </div>

                        </div><!-- /.form-group -->

                        @if (!empty($files['other_file']))
                            <div class="module-attachment-items gap-2">

                                <div class="files-content d-flex flex-column gap-2">
                                    @foreach ($files['other_file'] as $keyFile => $itemFile)
                                        <div class="image d-flex w-100 align-items-center bg-white rounded p-3 border border-1"
                                            data-bs-toggle="tooltip" data-bs-placement="top" title="attachment">
                                            <div class="thumb">
                                                <img src="{{ asset('/images/icons/pdf.png') }}" alt="excel">
                                            </div>
                                            <div class="img-name">{{ $itemFile['name'] }}</div>
                                            <div class="img-size opacity-50 ms-auto">{{ $itemFile['size'] }}</div>
                                            <div class="delete-icon">
                                                <img src="/images/icons/delete-top.svg" alt=""
                                                    wire:click="removeFile('other_file', '{{ $loop->index }}')">
                                            </div>
                                        </div><!-- image -->
                                    @endforeach
                                </div>
                            </div>
                        @endif

                    </div><!-- ./content-label -->

                    <div class="own-info mb-3">

                        <div class="mb-5">
                            <h5 class="fw-normal">Lampiran</h5>
                        </div>

                        <div class="row mb-3 form-group required">

                            <label for="other" class="col col-form-label">
                                Curriculum Vitae
                            </label>
                            <div class="">
                                <button class="btn btn-outline-upload w-100 position-relative h-128px"
                                    style="border: 1px dashed #810DA8; background-color: #810DA80A;" type="button">
                                    <span><img src="{{ asset('/images/icons/upload.png') }}"
                                            alt="image upload" /></span>
                                    <span class="text-upload">Drop or <a href="#">Select
                                            File</a></span>
                                    <input type="file" name="" id=""
                                        wire:model="temporaryFile.cv_file" accept=".pdf, .png, .jpeg, .jpg"
                                        multiple />

                                </button>
                            </div>

                        </div><!-- /.form-group -->

                        @if (!empty($files['cv_file']))
                            <div class="module-attachment-items gap-2">

                                <div class="files-content d-flex flex-column gap-2">
                                    @foreach ($files['cv_file'] as $keyFile => $itemFile)
                                        <div class="image d-flex w-100 align-items-center bg-white rounded p-3 border border-1"
                                            data-bs-toggle="tooltip" data-bs-placement="top" title="attachment">
                                            <div class="thumb">
                                                <img src="{{ asset('/images/icons/pdf.png') }}" alt="excel">
                                            </div>
                                            <div class="img-name">{{ $itemFile['name'] }}</div>
                                            <div class="img-size opacity-50 ms-auto">{{ $itemFile['size'] }}</div>
                                            <div class="delete-icon">
                                                <img src="/images/icons/delete-top.svg" alt=""
                                                    wire:click="removeFile('cv_file', '{{ $loop->index }}')">
                                            </div>
                                        </div><!-- image -->
                                    @endforeach
                                </div>
                            </div>
                        @endif

                        <div class="row mb-3 form-group required">

                            <label for="other" class="col col-form-label">
                                Surat Penunjukan PJO oleh Direksi
                            </label>
                            <div class="">
                                <button class="btn btn-outline-upload w-100 position-relative h-128px"
                                    style="border: 1px dashed #810DA8; background-color: #810DA80A;" type="button">
                                    <span><img src="{{ asset('/images/icons/upload.png') }}"
                                            alt="image upload" /></span>
                                    <span class="text-upload">Drop or <a href="#">Select
                                            File</a></span>
                                    <input type="file" name="" id=""
                                        wire:model="temporaryFile.appoinment_file" accept=".pdf, .png, .jpeg, .jpg"
                                        multiple />

                                </button>
                            </div>

                        </div><!-- /.form-group -->

                        @if (!empty($files['appoinment_file']))
                            <div class="module-attachment-items gap-2">

                                <div class="files-content d-flex flex-column gap-2">
                                    @foreach ($files['appoinment_file'] as $keyFile => $itemFile)
                                        <div class="image d-flex w-100 align-items-center bg-white rounded p-3 border border-1"
                                            data-bs-toggle="tooltip" data-bs-placement="top" title="attachment">
                                            <div class="thumb">
                                                <img src="{{ asset('/images/icons/pdf.png') }}" alt="excel">
                                            </div>
                                            <div class="img-name">{{ $itemFile['name'] }}</div>
                                            <div class="img-size opacity-50 ms-auto">{{ $itemFile['size'] }}</div>
                                            <div class="delete-icon">
                                                <img src="/images/icons/delete-top.svg" alt=""
                                                    wire:click="removeFile('appoinment_file', '{{ $loop->index }}')">
                                            </div>
                                        </div><!-- image -->
                                    @endforeach
                                </div>
                            </div>
                        @endif

                        <div class="row mb-3 form-group required">

                            <label for="other" class="col col-form-label">
                                Struktur Organisasi
                            </label>
                            <div class="">
                                <button class="btn btn-outline-upload w-100 position-relative h-128px"
                                    style="border: 1px dashed #810DA8; background-color: #810DA80A;" type="button">
                                    <span><img src="{{ asset('/images/icons/upload.png') }}"
                                            alt="image upload" /></span>
                                    <span class="text-upload">Drop or <a href="#">Select
                                            File</a></span>
                                    <input type="file" name="" id=""
                                        wire:model="temporaryFile.organizational_file"
                                        accept=".pdf, .png, .jpeg, .jpg" multiple />

                                </button>
                            </div>

                        </div><!-- /.form-group -->

                        @if (!empty($files['organizational_file']))
                            <div class="module-attachment-items gap-2">

                                <div class="files-content d-flex flex-column gap-2">
                                    @foreach ($files['organizational_file'] as $keyFile => $itemFile)
                                        <div class="image d-flex w-100 align-items-center bg-white rounded p-3 border border-1"
                                            data-bs-toggle="tooltip" data-bs-placement="top" title="attachment">
                                            <div class="thumb">
                                                <img src="{{ asset('/images/icons/pdf.png') }}" alt="excel">
                                            </div>
                                            <div class="img-name">{{ $itemFile['name'] }}</div>
                                            <div class="img-size opacity-50 ms-auto">{{ $itemFile['size'] }}</div>
                                            <div class="delete-icon">
                                                <img src="/images/icons/delete-top.svg" alt=""
                                                    wire:click="removeFile('organizational_file', '{{ $loop->index }}')">
                                            </div>
                                        </div><!-- image -->
                                    @endforeach
                                </div>
                            </div>
                        @endif

                        <div class="attachment mb-5 mt-5">
                            <div class="upload-file mb-3">
                                <div class="row">
                                    <label for="date" class="col-4 col-form-label">
                                        Persyaratan Administratif
                                    </label>
                                    <h6 for="date" class="col-8 col-form-label">
                                        <a wire:click="exportAdministration" class="cursor-pointer" target="_blank"
                                            style="color: #00552f">
                                            Download F-MAC-IMS-11-001 Persyaratan Administratif Calon PJO
                                        </a>
                                    </h6>
                                </div>
                                <input wire:model='temporaryFile.administration_file' type="file" multiple
                                    class="form-control @error('temporaryFile.administration_file') is-invalid @enderror"
                                    id="file_upload" />
                            </div>

                        </div><!-- /.attachment -->

                        <div class="attachment mb-5">
                            <div class="upload-file mb-3">
                                <div class="row">
                                    <label for="date" class="col-4 col-form-label">
                                        Surat Pernyataan Komitmen
                                    </label>
                                    <h6 for="date" class="col-8 col-form-label">
                                        <a wire:click="exportCommitment" class="cursor-pointer" target="_blank"
                                            style="color: #00552f">
                                            Download F-MAC-IMS-11-002 Surat Pernyataan Komitmen Calon PJO
                                        </a>
                                    </h6>
                                </div>
                                <input wire:model='temporaryFile.commitment_file' type="file" multiple
                                    class="form-control @error('temporaryFile.commitment_file') is-invalid @enderror"
                                    id="file_upload" />
                            </div>

                        </div><!-- /.attachment -->

                        <div class="row mb-3 mt-3 form-group">
                            <label for="date_submission" class="col col-form-label">
                                Tanggal Pengajuan Evaluasi
                            </label>
                            <div class="col-8">
                                <x-inputs.datepicker wire:model="date_submission" id="date_submission"
                                    :error="'date_submission'" placeholder="Select Date" />
                            </div>
                        </div><!-- /.form-group date -->

                        @if (isset($date_approved))
                            <div class="row mb-3 mt-3 form-group">
                                <label for="date" class="col col-form-label">
                                    Tanggal Evaluasi Yang Disetujui
                                </label>
                                <div class="col-8">
                                    <label for="date" class="col col-form-label">
                                        {{ Carbon\Carbon::parse($date_approved)->format('d F Y') }}
                                    </label>
                                </div>
                            </div><!-- /.form-group date -->
                        @endif

                    </div>

                    @if (auth()->user()->can('CSMS - Pjo Reviewer OHS') ||
                            auth()->user()->can('CSMS - Pjo Reviewer Evaluator') ||
                            auth()->user()->can('CSMS - Pjo Reviewer KTT'))
                        <div class="comment mb-5">

                            <div class="mb-3 row form-group ">
                                <label for="date" class="col col-form-label">
                                    Comment
                                </label>
                                <div class="col-sm-12">
                                    <x-inputs.texteditor-custom wire:model="comment" id="comment" model="comment"
                                        :error="'comment'" />
                                </div>

                            </div><!-- /.form-group -->


                        </div><!-- /.description -->
                    @endif

                    @if (auth()->user()->can('CSMS - Pjo Reviewer KTT'))
                        <div class="attachment mb-5">
                            <div class="upload-file mb-3">
                                <div class="row">
                                    <label for="date" class="col-4 col-form-label">
                                        Surat Persetujuan KTT
                                    </label>
                                    {{-- <h6 for="date" class="col-8 col-form-label">
                                    <a wire:click="exportCommitment" class="cursor-pointer" target="_blank"
                                        style="color: #00552f">
                                        Download F-MAC-IMS-11-002 Surat Pernyataan Komitmen Calon PJO
                                    </a>
                                </h6> --}}
                                </div>
                                <input wire:model='temporaryFile.approval_letter' type="file" multiple
                                    class="form-control @error('temporaryFile.approval_letter') is-invalid @enderror"
                                    id="file_upload" />
                            </div>

                        </div><!-- /.attachment -->
                    @endif

                    <div class="footer-action mb-2">
                        <div class="action-wrapper d-flex align-items-center justify-content-end gap-2">
                            <a href="javascript:history.go(-1)" class="btn btn-outline-secondary" wire:loading.remove
                                wire:target='saved'>
                                Cancel
                            </a>
                            <x-button-spinner target="saved" :text="'Processing'"></x-button-spinner>
                            <div class="button-document" wire:loading.remove wire:target='saved'>
                                <button
                                    class="dropdown-toggle btn btn-outline-default bg-green d-flex justify-content-center align-item-center text-white position-relative px-4"
                                    role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                    Submit Action
                                </button>
                                <ul class="dropdown-menu">
                                    <li>
                                        <button type="button" wire:click="saved('Draft')" class="dropdown-item"
                                            href="#">
                                            Submit as draft
                                        </button>
                                    </li>
                                    <li>
                                        <button type="button" wire:click="saved('Publish')" class="dropdown-item"
                                            href="#">
                                            Submit for review
                                        </button>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>

                </form>

            </div>
        </div>
    </div><!-- /.content-inspeksi-food-hygiene -->

</div><!-- /.inner-content -->

@push('scripts')
    <script>
        const Toast = Swal.mixin({
            toast: true,
            position: 'top-end',
            showConfirmButton: false,
            timer: 3000,
            timerProgressBar: true,
        })
        document.addEventListener("DOMContentLoaded", () => {
            Livewire.hook('message.sent', (message, component) => {

                if (message.updateQueue[0].payload.method === 'startUpload') {
                    Toast.fire({
                        icon: 'success',
                        title: 'Proses Upload File',
                        timer: false,
                        didOpen: (toast) => {
                            Toast.showLoading();
                        }
                    });
                }

                if (message.updateQueue[0].payload.method === "finishUpload") {
                    console.log(message.updateQueue[0].payload.params[0])
                    Toast.fire({
                        icon: 'success',
                        title: 'Proses Upload File Success',
                        timer: 2000,
                    });
                }

            })

        });
    </script>
@endpush
