@props(['id', 'error', 'files'])

<div class="file-upload-wrapper" x-data="{{ $id }}_fileUpload()">

    <div 
        class="file-upload-input"
        x-on:drop="isDroppingFile = false"
        x-on:drop.prevent="handleFileDrop($event)"
        x-on:dragover.prevent="isDroppingFile = true"
        x-on:dragleave.prevent="isDroppingFile = false"
    >
        <div class="btn btn-outline-upload w-100 position-relative h-128px">
            <span><img src="{{asset('/images/icons/upload.png')}}" alt="image upload" /></span>
            <span class="text-upload">Drop or <a href="#">Select File</a></span>
            <input {{ $attributes }} type="file" class="form-control @error($error) is-invalid @enderror" id="{{ $id }}" @change="handleFileSelect" />
        </div>

        @error($error)
            <div class="invalid-feedback">
                {{ $message }}
            </div>
        @enderror
    </div><!-- /.file-upload-input -->
    
    @if($files)
        <div class="list-files mt-3">

            <div class="module-attachment-items d-flex flex-column gap-2">
            
                @foreach($files as $file)
                    @php
                        $base = log($file->getSize(), 1024);
                        $suffixes = array('', 'Kb', 'Mb', 'Gb', 'Tb'); 
                        $file_size = round(pow(1024, $base - floor($base)), 2) .' '. $suffixes[floor($base)];
                    @endphp
                    <div>
                        <div class="image position-relative d-flex gap-3 align-items-center bg-white rounded p-2 border border-1 w-100">
                            <div class="thumb">
                                <img src="{{$file->temporaryUrl()}}" class=" w-40px h-40px object-fit-contain" alt="pdf">
                            </div>
                            <div class="img-name">{{$file->getClientOriginalName()}}</div>
                            <div class="img-size opacity-50">{{$file_size}}</div>
                            <button class="btn-closed ms-auto"><img src="{{asset('/images/icons/delete.png')}}" @click.prevent="removeUpload('{{$file->getFilename()}}')"></button>
                        </div><!-- image -->
                    </div>
                @endforeach
                
            </div><!-- /.files-content -->

        </div><!-- /.module-attachment-items -->

    @endif

</div><!-- /.file-upload-wrapper -->

@push('scripts')
    <script>
        const Toast = Swal.mixin({
            toast: true,
            position: 'top-end',
            showConfirmButton: false,
            timer: 3000,
            timerProgressBar: true,
        })
        function {{ $id }}_fileUpload() {
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

