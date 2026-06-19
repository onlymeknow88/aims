<div class="inner-content">

    <div
        class="header-content-inspeksi-food-hygiene h-60px bg-white shadow-sm d-flex gap-2 align-items-center justify-content-between px-3">
        <div class="left-header">
            <a href="javascript:history.go(-1)" class="d-flex align-items-center gap-3">
                <span><i class="fa-solid fa-arrow-left"></i></span>
                <span>Memo KTT</span>
            </a>
        </div><!-- /.left-header -->
    </div><!-- /.header-content-inspeksi-food-hygiene -->

    <div class="addnew-maker-content container py-5 px-3">

        <div class="row justify-content-center">

            <div class="col-8">

                <form class="form-horizontal" method="post" enctype="multipart/form-data">

                    <div class="own-info mb-5">

                        <div class="mb-5">
                            <h5 class="fw-normal">Memo KTT</h5>
                        </div>

                        <div class="row mb-3 form-group required">
                            <label for="memo_number" class="col col-form-label">
                                Memo Number
                            </label>
                            <div class="col-8">
                                <x-inputs.text wire:model.defer="memo_number" id="memo_number" placeholder="Memo Number"
                                    :error="'memo_number'" />
                            </div>
                        </div><!-- /.form-group criteria -->

                        <div class="row mb-3 form-group required">
                            <label for="title" class="col col-form-label">
                                Title
                            </label>
                            <div class="col-8">
                                <x-inputs.text wire:model.defer="title" id="title" placeholder="Title"
                                    :error="'title'" />
                            </div>
                        </div><!-- /.form-group criteria -->

                        <div class="row mb-3 form-group required">
                            <label for="ccow_id" class="col col-form-label">
                                CCOW
                            </label>
                            <div class="col-8">

                                <x-csms-select2 id="ccow_id" placeholder="CCOW" :error="'ccow_id'"
                                    wire:model.defer="ccow_id">
                                    @foreach ($this->ccows as $index => $item)
                                        <option value="{{ $item->id }}">
                                            {{ $item->company_name }}
                                        </option>
                                    @endforeach
                                </x-csms-select2>

                            </div>
                        </div><!-- /.form-group ccow -->

                        <div class="row mb-3 form-group required">
                            <label for="ktt_id" class="col col-form-label">
                                Initiator KTT
                            </label>
                            <div class="col-8">
                                <x-inputs.text wire:model.defer="ktt_id" id="ktt_id" placeholder="Initiator KTT"
                                    :error="'ktt_id'" disabled />
                            </div>
                        </div><!-- /.form-group criteria -->

                        <div class="row mb-3 form-group required">
                            <label for="date" class="col col-form-label">
                                Date
                            </label>
                            <div class="col-8">
                                <x-inputs.datepicker wire:model.defer="date" id="date" :error="'date'"
                                    placeholder="Select Date" />
                            </div>
                        </div><!-- /.form-group date -->

                        <div class="row mb-3 form-group required">

                            <label for="kompetensi" class="col col-form-label">
                                Upload Memo
                            </label>
                            <div class="">
                                <button class="btn btn-outline-upload w-100 position-relative h-128px"
                                    style="border: 1px dashed #810DA8; background-color: #810DA80A;" type="button">
                                    <span><img src="{{ asset('/images/icons/upload.png') }}"
                                            alt="image upload" /></span>
                                    <span class="text-upload">Drop or <a href="#">Select
                                            File</a></span>
                                    <input type="file" name="" id="" wire:model.defer="temporaryFile"
                                        accept=".pdf, .png, .jpeg, .jpg" multiple />

                                </button>
                            </div>

                        </div><!-- /.form-group -->

                        <div class="module-attachment-items gap-2">

                            <div class="files-content d-flex flex-column gap-2">
                                @foreach ($files as $keyFile => $itemFile)
                                    <div class="image d-flex w-100 align-items-center bg-white rounded p-3 border border-1"
                                        data-bs-toggle="tooltip" data-bs-placement="top" title="attachment">
                                        <div class="thumb">
                                            <img src="{{ asset('/images/icons/pdf.png') }}" alt="pdf" />
                                        </div>
                                        <div class="img-name">{{ $itemFile['name'] }}</div>
                                        <div class="img-size opacity-50 ms-auto">{{ $itemFile['size'] }} Kb</div>
                                        <div class="delete-icon">
                                            <img src="{{ asset('/images/icons/delete-top.svg') }}" alt=""
                                                wire:click="removeFile({{ $keyFile }})">
                                        </div>
                                    </div><!-- image -->
                                @endforeach
                            </div>
                        </div>

                        <div class="row mb-3 mt-3 form-group required">
                            <label for="date" class="col col-form-label">
                                Desciption
                            </label>
                            <div class="col-8">
                                <textarea type="text" wire:model.defer="description" class="form-control" rows="4" placeholder="Description"></textarea>
                            </div>
                        </div><!-- /.form-group date -->

                    </div><!-- ./content-label -->

                    <div class="footer-action mb-2">
                        <div class="action-wrapper d-flex align-items-center justify-content-end gap-2">
                            <a href="javascript:history.go(-1)" class="btn btn-outline-secondary" wire:loading.remove
                                wire:target='saved'>
                                Cancel
                            </a>
                            <x-button-spinner target="saved" :text="trans('global.processing')"></x-button-spinner>
                            <div class="button-document" wire:loading.remove wire:target='saved'>
                                <button
                                    class="btn btn-outline-default bg-green d-flex justify-content-center align-item-center text-white position-relative px-4"
                                    role="button" data-bs-toggle="dropdown" aria-expanded="false"wire:click="saved">
                                    Submit
                                </button>
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
