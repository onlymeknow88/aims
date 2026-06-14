<div>
    <div class="mb-5">
        <button class="btn btn-outline-upload w-100 position-relative h-128px" type="button">
            <span><img src="{{ asset('/images/icons/upload.png') }}" alt="image upload" /></span>
            <span class="text-upload">Drop or <a href="#">Select File</a></span>
            {{-- <input type="file" wire:model.defer="{{ $docs }}" id="" /> --}}
            <input type="file" id="" />

        </button>
    </div>
    <div class="list-files">

        <div class="module-attachment-items d-flex flex-wrap gap-2">

            <div class="files-content d-flex gap-2 flex-wrap">

                {{-- <div
                    class="image position-relative d-flex flex-column align-items-start justify-content-center bg-white rounded p-3 border border-1"
                    data-bs-toggle="tooltip"
                    data-bs-placement="top"
                    title="attachment"
                >
                    <div class="thumb mb-2">
                        <img src="{{ asset('./images/icons/excel.png') }}" alt="excel">
                    </div>
                    <div class="img-name">Nama Panjang ...</div>
                    <div class="img-size opacity-50">3.2 Mb</div>
                    <button class="btn-closed position-absolute"><img src="{{asset('/images/icons/delete.png')}}" alt=""></button>
                </div><!-- image -->

                <div class="image position-relative d-flex flex-column align-items-start justify-content-center bg-white rounded p-3 border border-1">
                    <div class="thumb mb-2">
                        <img src="{{ asset('./images/icons/pdf.png') }}" alt="pdf">
                    </div>
                    <div class="img-name">File Name.pdf</div>
                    <div class="img-size opacity-50">3.2 Mb</div>
                    <button class="btn-closed position-absolute"><img src="{{asset('/images/icons/delete.png')}}" alt=""></button>
                </div><!-- image -->

                <div class="image position-relative d-flex flex-column align-items-start justify-content-center bg-white rounded p-3 border border-1">
                    <div class="thumb mb-2">
                        <img src="{{ asset('./images/icons/excel.png') }}" alt="excel">
                    </div>
                    <div class="img-name">Evidence Data</div>
                    <div class="img-size opacity-50">3.2 Mb</div>
                    <button class="btn-closed position-absolute"><img src="{{asset('/images/icons/delete.png')}}" alt=""></button>
                </div><!-- image -->

                <div class="image position-relative d-flex flex-column align-items-start justify-content-center bg-white rounded p-3 border border-1">
                    <div class="thumb mb-2">
                        <img src="{{ asset('./images/icons/pdf.png') }}" alt="pdf">
                    </div>
                    <div class="img-name">File Name.pdf</div>
                    <div class="img-size opacity-50">3.2 Mb</div>
                    <button class="btn-closed position-absolute"><img src="{{asset('/images/icons/delete.png')}}" alt=""></button>
                </div><!-- image -->

                <div class="image position-relative d-flex flex-column align-items-start justify-content-center bg-white rounded p-3 border border-1">
                    <div class="thumb mb-2">
                        <img src="{{ asset('./images/icons/excel.png') }}" alt="excel">
                    </div>
                    <div class="img-name">Evidence Data</div>
                    <div class="img-size opacity-50">3.2 Mb</div>
                    <button class="btn-closed position-absolute"><img src="{{asset('/images/icons/delete.png')}}" alt=""></button>
                </div><!-- image -->

                <div class="image position-relative d-flex flex-column align-items-start justify-content-center bg-white rounded p-3 border border-1">
                    <div class="thumb mb-2">
                        <img src="{{ asset('./images/icons/pdf.png') }}" alt="pdf">
                    </div>
                    <div class="img-name">File Name.pdf</div>
                    <div class="img-size opacity-50">3.2 Mb</div>
                    <button class="btn-closed position-absolute"><img src="{{asset('/images/icons/delete.png')}}" alt=""></button>
                </div><!-- image -->

                <div class="image position-relative d-flex flex-column align-items-start justify-content-center bg-white rounded p-3 border border-1">
                    <div class="thumb mb-2">
                        <img src="{{ asset('./images/icons/excel.png') }}" alt="excel">
                    </div>
                    <div class="img-name">Evidence Data</div>
                    <div class="img-size opacity-50">3.2 Mb</div>
                    <button class="btn-closed position-absolute"><img src="{{asset('/images/icons/delete.png')}}" alt=""></button>
                </div><!-- image -->

                <div class="image position-relative d-flex flex-column align-items-start justify-content-start bg-white rounded p-3 border border-1">
                    <div class="thumb mb-2">
                        <img src="{{ asset('./images/icons/pdf.png') }}" alt="pdf">
                    </div>
                    <div class="img-name">File Name.pdf</div>
                    <div class="img-size opacity-50">3.2 Mb</div>
                    <button class="btn-closed position-absolute"><img src="{{asset('/images/icons/delete.png')}}" alt=""></button>
                </div><!-- image --> --}}

            </div><!-- /.files-content -->

        </div><!-- /.module-attachment-items -->

    </div><!-- /.list-files -->
</div>

@once
    @push('styles')
        <link rel="stylesheet" href="https://unpkg.com/dropzone@5/dist/min/dropzone.min.css" type="text/css" />
    @endpush
@endonce

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
