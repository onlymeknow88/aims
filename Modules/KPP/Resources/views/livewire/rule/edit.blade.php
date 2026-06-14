<div class="inner-content">

    <div class="header-detail-maker h-60px border d-flex gap-2 align-items-center px-3">
        <div class="left-header">
            <a href="#" onclick="history.back();"
                class="d-flex align-items-center gap-3">
                <span><i class="fa-solid fa-arrow-left"></i></span>
                <span>Rules</span>
            </a>
        </div><!-- /.left-header -->
        <div class="right-header">
            <div class="text-white">
                {{-- Last update Sep 24, 2022 . 15.00 pm --}}
            </div>
        </div><!-- /.right-header -->

    </div>

    <div class="addnew-maker-content container py-5 px-3">

        <div class="row justify-content-center">

            <div class="col-8">
                <form class="form-horizontal" enctype="multipart/form-data">
                    <div class="own-info mb-5">
                        <div class="mb-3">
                            <h5 class="fw-normal">Information Kepatuhan</h5>
                        </div>

                        <div class="mb-3 row form-group required">
                            <label for="sop_number" class="col-sm-4 col-form-label">No Peraturan</label>
                            <div class="col-sm-8">
                                <x-inputs.text type="text" wire:model="number" id="number" placeholder="XX-XXXX-XXX" :error="'number'"></x-inputs.text>
                            </div>
                        </div>

                        <div class="mb-3 row form-group required">
                            <label for="title" class="col-sm-4 col-form-label">Judul Peraturan</label>
                            <div class="col-sm-8">
                                <x-inputs.textarea wire:model="title" id="title" placeholder="Title" :error="'title'"></x-inputs.textarea>
                            </div>
                        </div>

                        <div class="mb-3 row form-group required">
                            <label for="department" class="col-sm-4 col-form-label">Jenis Peraturan & Perizinan</label>
                            <div class="col-sm-8">
                                <x-kpp-select-2 wire:model="type" id="type" data-child="section" placeholder="Select Type" :error="'type'">
                                    @foreach ($types as $key => $type)
                                        <option value="{{ $type['id'] }}">{{$type['name']}}</option>
                                    @endforeach
                                </x-kpp-select-2>
                            </div>
                        </div>

                        <!-- <div class="mb-3 row form-group required">
                            <label for="department" class="col-sm-4 col-form-label">Status</label>
                            <div class="col-sm-8">
                                <x-kpp-select-2 wire:model="status" id="status" data-child="status" placeholder="Select Status" :error="'status'" disabled>
                                    <option value="Terdaftar">Terdaftar</option>
                                </x-kpp-select-2>
                            </div>
                        </div> -->

                        <div class="mb-3 row form-group required">
                            <label for="department" class="col-sm-4 col-form-label">Document Type</label>
                            <div class="col-sm-8">
                                <x-kpp-select-2 wire:model="document_type" id="document_type" placeholder="Select Document Type" :error="'document_type'">
                                    @foreach(App\Enums\KPP\RuleDocumentType::toSelectArray() as $key => $value)
                                        <option value="{{ $key }}">{{ $key }}</option>
                                    @endforeach
                                </x-kpp-select-2>
                            </div>
                        </div>

                        <div class="mb-3 row form-group required">
                            <label for="agency_authority" class="col-sm-4 col-form-label">Otoritas Instansi</label>
                            <div class="col-sm-8">
                                <x-kpp-select-2 wire:model="agency_authority" id="agency_authority" data-child="section" placeholder="Select Department" :error="'agency_authority'">
                                    @foreach ($agencyAuthorities as $key => $agencyAuthority)
                                        <option value="{{ $agencyAuthority['id'] }}">
                                            {{$agencyAuthority['name']}}
                                        </option>
                                    @endforeach
                                </x-kpp-select-2>
                            </div>
                        </div>
                    </div>

                    <div class="description mb-5">
                        <div class="mb-3">
                            <h5 class="fw-normal">Description</h5>
                        </div>
                        <div class="mb-3 row form-group">
                            <div class="col-sm-12">
                                <x-inputs.texteditor-custom wire:model.defer="description" id="description" :error="'description'"/>
                            </div>
                        </div>
                    </div>

                    <div class="own-info mb-5">
                        <div class="mb-3">
                            <h5 class="fw-normal">Tanggal Peraturan</h5>
                        </div>
                        <div class="row">
                            <div class="col-sm-6">
                                <div class="mb-3 row form-group required">
                                    <label for="title" class="col-sm-12 col-form-label">Tanggal Disetujui</label>
                                    <div class="col-sm-12">
                                        <x-inputs.datepicker wire:model="approved_date" id="approved_date" :error="'approved_date'"></x-inputs.datepicker>
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="mb-3 row form-group required">
                                    <label for="title" class="col-sm-12 col-form-label">Tanggal Berlaku</label>
                                    <div class="col-sm-12">
                                        <x-inputs.datepicker wire:model="effective_date" id="effective_date" :error="'effective_date'"></x-inputs.datepicker>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row mb-3 form-group required">
                        <div class="col-sm-12">
                            <label for="">Attachment</label>
                            <div class="">
                                <div class="file-upload-wrapper" x-data="fileUpload()">

                                    <div 
                                        class="file-upload-input"
                                        x-on:drop="isDroppingFile = false"
                                        x-on:drop.prevent="handleFileDrop($event)"
                                        x-on:dragover.prevent="isDroppingFile = true"
                                        x-on:dragleave.prevent="isDroppingFile = false"
                                    >
                                        <button class="btn btn-outline-upload w-100 position-relative h-128px"
                                                style="border: 1px dashed #810DA8; background-color: #810DA80A;"
                                                type="button">
                                            <span>
                                                <img src="{{ asset('/images/icons/upload.png') }}" alt="image upload"/>
                                            </span>
                                            <span class="text-upload">
                                                Drop or <a href="#">Select File</a>
                                            </span>
                                            <input type="file" name="" id="" wire:model="temporaryFile"
                                                   accept=".pdf, .png, .jpeg, .jpg" multiple @change="handleFileSelect"/>
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    @foreach ($oldFiles as $keyFile => $itemFile)
                        <div class="row form-group mb-3 m-1">
                            <div class="col-sm-11 bg-white d-flex justify-content-between p-2 file-list">
                                <div>
                                    <a target="blank" href="{{asset('storage/'.$itemFile['file'])}}">
                                        <img src="{{ asset('/images/icons/pdf.png') }}" alt="pdf" />
                                        <span>
                                            {{ $itemFile['name'] }}
                                        </span>
                                    </a>
                                </div>
                                <span>
                                    {{ $itemFile['size'] }}
                                </span>
                            </div>
                            <div class="col-sm-1 text-center p-2" wire:click="removeFile({{$keyFile}})">
                                <button type="button" class="btn btn-light-secondary text-center"
                                    wire:click="deleteOldFile('{{ $itemFile['id'] }}', {{$keyFile}})">
                                    <i class="fa fa-x"></i>
                                </button>
                            </div>
                        </div>
                    @endforeach

                    @foreach ($files_data as $keyFile => $itemFile)
                        <div class="row form-group mb-3 m-1">
                            <div
                                class="col-sm-11 bg-white d-flex justify-content-between p-2 file-list">
                                <div>
                                    <img src="{{ asset('/images/icons/pdf.png') }}" alt="pdf"/>
                                    <span>
                                        {{ $itemFile['name'] }}
                                    </span>
                                </div>
                                <span>
                                    {{ $itemFile['size'] }}
                                </span>
                            </div>
                            <div class="col-sm-1 text-center p-2" wire:click="removeFile({{$keyFile}})">
                                <button type="button" class="btn btn-light-secondary text-center"
                                        wire:click="removeFile({{ $keyFile }})">
                                    <i class="fa fa-x"></i>
                                </button>
                            </div>
                        </div>
                    @endforeach

                    <div class="footer-action mb-2">
                        <div class="action-wrapper d-flex align-items-center justify-content-end gap-2">
                            <a href="#" onclick="history.back();"
                                class="btn btn-outline-secondary">Cancel</a>

                            @if($rule->is_draft == 0)
                                <a href="#" wire:click="save(0)" class="btn btn-outline-default bg-green align-item-center text-white position-relative px-4">Submit</a>
                            @else
                                <div class="button-document">
                                    <button
                                        class="dropdown-toggle btn btn-outline-default bg-green d-flex justify-content-center align-item-center text-white position-relative px-4"
                                        role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                        Submit Action
                                    </button>
                                    <ul class="dropdown-menu">
                                        <li>
                                            <button type="button" wire:click="save(1)" class="dropdown-item"
                                                href="#">
                                                Submit as Draft
                                            </button>
                                        </li>
                                        <li>
                                            <button type="button" wire:click="save(0)" class="dropdown-item"
                                                href="#">
                                                Submit
                                            </button>
                                        </li>
                                    </ul>
                                </div>
                            @endif
                        </div>
                    </div>
                </form>

            </div>

        </div>

    </div>
    <!---/.addnew-maker-content -->

</div>

@push('scripts')
    <script>
        const Toast = Swal.mixin({
            toast: true,
            position: 'top-end',
            showConfirmButton: false,
            timer: 3000,
            timerProgressBar: true,
        })
        function fileUpload() {
            return {
                isDropping: false,
                isUploading: false,
                progress: 0,
                handleFileSelect(event) { 
                    if (event.target.files.length) {
                        this.uploadFiles(event.target.files)
                    }
                },
                handleFileDrop(event) { 
                    if (event.dataTransfer.files.length > 0) {
                        this.uploadFiles(event.dataTransfer.files)
                    }
                },
                uploadFiles(files) {
                    Toast.fire({
                        icon: 'success',
                        title: 'Proses Upload',
                        timer: false,
                    })
                    Toast.showLoading();
                    const $this = this
                    this.isUploading = true
                    @this.uploadMultiple('files', files,
                        function (success) {  //upload was a success and was finished
                            $this.isUploading = false
                            $this.progress = 0
                            Toast.hideLoading();
                            Toast.fire({
                                icon: 'success',
                                title: 'Proses Upload Success',
                                timer: 1000,
                            });
                        },
                        function(error) {  //an error occured
                            console.log('error', error)
                        },
                        function (event) {  //upload progress was made
                            $this.progress = event.detail.progress
                        }
                    )
                },
                removeUpload(filename) { 
                    @this.removeUpload('files', filename)
                }, 
            }
        }
    </script>
@endpush