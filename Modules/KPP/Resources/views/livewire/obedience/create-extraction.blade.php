<div class="inner-content">

    <div class="header-detail-maker h-60px border d-flex gap-2 align-items-center px-3">
        <div class="left-header">
            <a href="{{route('kpp::obediences.detail', ['id' => $this->obedience->id])}}"
                class="d-flex align-items-center gap-3">
                <span><i class="fa-solid fa-arrow-left"></i></span>
                <span>Kepatuhan</span>
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
                            <h5 class="fw-normal">Peraturan</h5>
                        </div>

                        <div class="mb-3 row form-group">
                            <label for="bidang" class="col-sm-4 col-form-label">Nomor Peraturan</label>
                            <div class="col-sm-8">
                                <input class="form-control" type="text" value="{{$this->obedience->rule->number ?? '-'}}" disabled>
                            </div>
                        </div>

                        <div class="mb-3 row form-group">
                            <label for="bidang" class="col-sm-4 col-form-label">Judul Peraturan</label>
                            <div class="col-sm-8">
                                <input class="form-control" type="text" value="{{$this->obedience->rule->title ?? '-'}}" disabled>
                            </div>
                        </div>

                        <div class="mb-3 row form-group">
                            <label for="bidang" class="col-sm-4 col-form-label">Tipe Peraturan</label>
                            <div class="col-sm-8">
                                <input class="form-control" type="text" value="{{$this->obedience->rule->ruleType->name ?? '-'}}" disabled>
                            </div>
                        </div>
                    </div>

                    <div class="own-info mb-5">
                        <div class="mb-3">
                            <h5 class="fw-normal">Information</h5>
                        </div>

                        <div class="mb-3 row form-group required">
                            <label for="bidang" class="col-sm-4 col-form-label">Bidang</label>
                            <div class="col-sm-8">
                                <x-inputs.text type="text" wire:model="bidang" id="bidang" placeholder="Bidang" :error="'bidang'"/>
                            </div>
                        </div>

                        <div class="mb-3 row form-group required">
                            <label for="sub_bidang" class="col-sm-4 col-form-label">Sub Bidang</label>
                            <div class="col-sm-8">
                                <x-inputs.textarea wire:model="sub_bidang" id="sub_bidang" placeholder="Sub Bidang" :error="'sub_bidang'"></x-inputs.textarea>
                            </div>
                        </div>

                        <div class="mb-3 row form-group required">
                            <label for="section_id" class="col-sm-4 col-form-label">Section</label>
                            <div class="col-sm-8">
                                <x-kpp-select-2 wire:model="section_id" id="section_id" placeholder="Select Section" :error="'section_id'">
                                    @foreach ($sections as $key => $section)
                                        <option value="{{ $section['id'] }}">{{$section['name']}}</option>
                                    @endforeach
                                </x-kpp-select-2>
                            </div>
                        </div>

                        <div class="mb-3 row form-group required">

                            <label for="responsible_id" class="col-sm-4 col-form-label">Penanggung Jawab</label>
                            <div class="col-sm-8">
                                <x-kpp-select-2-avatar wire:model="responsible_id" id="responsible_id" name="responsible_id" placeholder="Select Penanggung Jawab" :error="'responsible_id'">

                                    @foreach ($users as $key => $itemPj)
                                        <option class="d-flex gap-2 align-items-center" value="{{ $itemPj['id'] }}" data-avatar="@if ($itemPj['avatar']) $itemPj['avatar'] @else {{ asset('./images/profile.png') }}  @endif" data-email="@if ($itemPj['email']) {{ $itemPj['email'] }}  @endif">{{$itemPj['name']}}</option>
                                    @endforeach

                                </x-kpp-select-2-avatar>
                            </div>
                        </div><!-- /.form-group -->

                        <div class="mb-3 row form-group required">
                            <label for="compliance_level" class="col-sm-4 col-form-label">Compliance Level</label>
                            <div class="col-sm-8">
                                <x-kpp-select-2 wire:model="compliance_level" id="compliance_level" placeholder="Select Compliance Level" :error="'compliance_level'">
                                    <option value="N">N</option>
                                    <option value="IA">IA</option>
                                    <option value="IIA">IIA</option>
                                    <option value="IIIA">IIIA</option>
                                    <option value="IIIB">IIIB</option>
                                </x-kpp-select-2>
                            </div>
                        </div>

                        <!-- <div class="mb-3 row form-group required">
                            <label for="article" class="col-sm-4 col-form-label">Pasal</label>
                            <div class="col-sm-8">
                                <x-inputs.text type="text" wire:model="article" id="article" placeholder="Pasal" :error="'article'"/>
                            </div>
                        </div> -->

                        <div class="mb-3 row form-group required">
                            <label for="ccow_id" class="col-sm-4 col-form-label">Pasal</label>
                            <div class="col-sm-8">
                                <x-ko-select-2 wire:model="article_id" id="article_id" placeholder="Select Pasal">
                                    @foreach ($articles as $key => $article)
                                        <option
                                            value="{{ $article->id }}">{{$article->name}}</option>
                                    @endforeach
                                    <option value="new">-- Pasal Baru --</option>
                                </x-ko-select-2>
                            </div>
                        </div>

                        @if ($article_id === 'new')
                            <div class="mb-3 row form-group required">
                                <label for="applicant_email" class="col-sm-4 col-form-label">Tambah Pasal Baru</label>
                                <div class="col-sm-8">
                                    <x-inputs.text type="text" wire:model="new_article" class="form-control" id="new_article" placeholder="Pasal Baru" :error="'new_article'"></x-inputs.text>
                                </div>
                            </div>
                        @endif

                        <div class="mb-3 row form-group required">
                            <label for="sub_section" class="col-sm-4 col-form-label">Ayat</label>
                            <div class="col-sm-8">
                                <x-inputs.text type="text" wire:model="sub_section" id="sub_section" placeholder="Ayat" :error="'sub_section'"/>
                            </div>
                        </div>

                        <div class="mb-3 row form-group">
                            <label for="lampiran" class="col-sm-4 col-form-label">Lampiran</label>
                            <div class="col-sm-8">
                                <x-inputs.textarea wire:model="lampiran" id="lampiran" placeholder="Lampiran" :error="'lampiran'"></x-inputs.textarea>
                            </div>
                        </div>

                        <div class="mb-3 row form-group required">
                            <label for="content" class="col-sm-4 col-form-label">Konten Ekstraksi</label>
                            <div class="col-sm-8">
                                <x-inputs.textarea wire:model="content" id="content" placeholder="Content Ekstraksi" :error="'content'"></x-inputs.textarea>
                            </div>
                        </div>

                        <div class="mb-3 row form-group required">
                            <label for="disobedience" class="col-sm-4 col-form-label">Isi Ketidakpatuhan</label>
                            <div class="col-sm-8">
                                <x-inputs.textarea wire:model="disobedience" id="disobedience" placeholder="Isi Ketidakpatuhan" :error="'disobedience'"></x-inputs.textarea>
                            </div>
                        </div>

                        <div class="mb-3 row form-group required">
                            <label for="consequence" class="col-sm-4 col-form-label">Konsekuensi</label>
                            <div class="col-sm-8">
                                <x-inputs.text type="text" wire:model="consequence" id="consequence" placeholder="Konsekuensi" :error="'consequence'"/>
                            </div>
                        </div>

                        <div class="mb-3 row form-group required">
                            <label for="title" class="col-sm-4 col-form-label">Tenggat Waktu Pemenuhan</label>
                            <div class="col-sm-8">
                                <x-inputs.datepicker wire:model="date" id="date" :error="'date'" />
                            </div>
                        </div>

                        <div class="row mb-3 form-group required">
                            <div class="col-sm-12">
                                <label for="">Lampiran Temuan Resiko</label>
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

                        @foreach ($files_data as $keyFile => $itemFile)
                            <div class="row form-group mb-3 m-1">
                                <div
                                    class="col-sm-11 bg-white d-flex justify-content-between p-2 file-list">
                                    <div>
                                        <img src="{{ asset('/images/icons/pdf.png') }}" alt="pdf" />
                                        <span>
                                            {{ $itemFile['name'] }}
                                        </span>
                                    </div>
                                    <span>
                                        {{ $itemFile['size'] }}
                                    </span>
                                </div>
                                <div class="col-sm-1 text-center p-2"
                                    wire:click="removeFile({{$keyFile}})">
                                    <button type="button" class="btn btn-light-secondary text-center"
                                        wire:click="removeFile({{ $keyFile }})">
                                        <i class="fa fa-x"></i>
                                    </button>
                                </div>
                            </div>
                        @endforeach

                    </div>

                    <div class="footer-action mb-2">
                        <div class="action-wrapper d-flex align-items-center justify-content-end gap-2">
                            <a href="{{route('kpp::obediences.detail', ['id' => $this->obedience->id])}}" class="btn btn-outline-secondary">Cancel</a>
                            <div class="button-document">
                                <button
                                    class="dropdown-toggle btn btn-outline-default bg-green d-flex justify-content-center align-item-center text-white position-relative px-4"
                                    role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                    Submit Action
                                </button>
                                <ul class="dropdown-menu">
                                    <li>
                                        <button type="button" wire:click="save(0)" class="dropdown-item"
                                            href="#">
                                            Save
                                        </button>
                                    </li>
                                    <li>
                                        <button type="button" wire:click="save(1)" class="dropdown-item"
                                            href="#">
                                            Save and Create Another
                                        </button>
                                    </li>
                                </ul>
                            </div>
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