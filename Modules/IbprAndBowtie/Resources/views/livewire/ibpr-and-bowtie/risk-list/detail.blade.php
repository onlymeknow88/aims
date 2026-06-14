@push('styles')
    <script src="https://cdn.tailwindcss.com"></script>
    <style>

    </style>
@endpush
<div class="inner-content">

    <div class="header-detail-maker h-60px border d-flex gap-2 align-items-center px-3">
        <a href="/ibpr-and-bowtie/risk-list/list"
            class="d-flex align-items-center gap-3">
            <span><i class="fa-solid fa-arrow-left"></i></span>
            <span>Document Daftar Risiko</span>
        </a>
    </div>

    <div class="detail-maker-content d-flex">
        <div class="detail-left border-end border-1">
            <div class="info bg-white">
                <div class="info-item p-3 border-bottom border-1 px-3">
                    <div class="author d-flex flex-column gap-2">
                        <div class="item-content d-flex gap-2 align-items-center">
                            <div class="thumb">
                                <img src="{{ asset('./images/author.png') }}" alt="Author">
                            </div>
                            <div class="author-name text-[16px]">Bambang Sunaryo</div>
                        </div>
                    </div><!-- /.author -->
                </div><!-- /.info-items -->
                <div class="info-item p-3 border-bottom border-1">
                    <div class="p-3 grid grid-cols-1 gap-y-4">
                        <div>
                            <p>PT Lahai Coal</p>
                        </div>
                        <div class="flex gap-3">
                            <div>
                                <img src="{{ asset('./images/icons/profile.png') }}" alt="Author">
                            </div>
                            <div>
                                <div class="-mt-1">
                                    <p class="text-[13px] text-gray-400">User Role</p>
                                    <p class="text-[14px] text-black">Maker, Checker</p>
                                </div>
                            </div>
                        </div>
                        <div class="flex gap-3">
                            <div>
                                <img src="{{ asset('./images/icons/company.png') }}" alt="Author">
                            </div>
                            <div>
                                <div class="-mt-1">
                                    <p class="text-[13px] text-gray-400">Department</p>
                                    <p class="text-[14px] text-black">Environment</p> 
                                </div>
                                <div class="mt-3">
                                    <p class="text-[13px] text-gray-400">Position</p>
                                    <p class="text-[14px] text-black turn">Environmental, Reclamation</p>
                                </div>
                            </div>
                        </div>
                    </div>

                </div><!-- /.info-items -->

                
                <div class="info-item p-3 border-bottom border-1">
                    <div class="created d-flex flex-column gap-2 p-3">
                        <h6 class="fw-normal">Address</h6>
                        <div>
                            <p>
                                RT.5/RW.2, Gambir, Kecamatan Gambir, Kota Jakarta Pusat, Daerah Khusus Ibukota Jakarta 10110
                            </p>
                        </div>

                    </div><!-- /.author -->

                </div><!-- /.info-items -->

                <div class="info-item p-3 border-bottom border-1">

                    <div class="created d-flex flex-column gap-2 p-3">

                        <h6 class="fw-normal">Tgl. Diajukan</h6>

                        <div class="item-content d-flex gap-1 align-items-center">
                            <span>22 Maret 2023</span>
                        </div>

                    </div><!-- /.author -->

                </div><!-- /.info-items -->

                <div class="info-item p-3 border-bottom border-1">

                    <div class="created d-flex flex-column gap-2 p-3">

                        <h6 class="fw-normal">Tgl. Selanjutnya</h6>

                        <div class="item-content d-flex gap-1 align-items-center">
                            <span>22 Maret 2023</span>
                        </div>

                    </div><!-- /.author -->

                </div><!-- /.info-items -->

                <div class="info-item p-3 border-bottom border-1">

                    <div class="created d-flex flex-column gap-2 p-3">

                        <h6 class="fw-normal">Status Document</h6>

                        <div class="item-content d-flex gap-1 align-items-center">
                            <span>Revisi 1-0</span>
                        </div>

                    </div><!-- /.author -->

                </div><!-- /.info-items -->

            </div><!-- /.info -->

        </div><!-- /.detail-left -->

        <div class="section-content w-100 py-3 px-5 d-flex flex-column gap-3">

          <div class="py-3">
            <div>
                <p class="font-bold text-lg text-black">Aktifitas Daftar Risiko</p>
            </div>

            <div class="pt-5">
                <div>
                    <p>Company Information</p>
                </div>
                <div class="grid grid-cols-1 w-full pt-4 gap-y-5">
                    <div class="w-full flex border-b py-2">
                        <div class="w-52">
                            <p class="text-[13px]">CCOW</p>
                        </div>
                        <div>
                            <p class="text-[13px]">PT Company Coal 1</p>
                        </div>
                    </div>
                    <div class="w-full flex border-b py-2">
                        <div class="w-52">
                            <p class="text-[13px]">Kriteria ANalisa</p>
                        </div>
                        <div>
                            <p class="text-[13px]">IBPR</p>
                        </div>
                    </div>
                    <div class="w-full flex border-b py-2">
                        <div class="w-52">
                            <p class="text-[13px]">Perusahan IUP</p>
                        </div>
                        <div>
                            <p class="text-[13px]">Internal Company</p>
                        </div>
                    </div>
                    <div class="w-full flex border-b py-2">
                        <div class="w-52">
                            <p class="text-[13px]">Mitra Kerja</p>
                        </div>
                        <div>
                            <p class="text-[13px]">PT Melaway Coal</p>
                        </div>
                    </div>
                    <div class="w-full flex border-b py-2">
                        <div class="w-52">
                            <p class="text-[13px]">Sub Mitra Kerja</p>
                        </div>
                        <div>
                            <p class="text-[13px]">PT Away Coal</p>
                        </div>
                    </div>
                    <div class="w-full flex border-b py-2">
                        <div class="w-52">
                            <p class="text-[13px]">Penanggung Jawab</p>
                        </div>
                        <div class="flex items-center gap-3">
                            <div class="w-7 h-7">
                                <img src="{{ asset('./images/author.png') }}" alt="Author">
                            </div>
                            <p class="text-[13px]">Bambang Sunaryo</p>
                        </div>
                    </div>
                </div>
            </div>
          </div>

        </div><!-- /.section-content -->

        <div class="detail-right border-start border-1">

            <div class="info bg-white px-3">

                <h6 class="fw-normal">Activity</h6>
                <div class="grid grid-cols-1 mt-5 gap-y-5">
                    <div class="bg-[#F5F5F5] py-3 px-4 rounded-md">
                        <div class="flex gap-3">
                            <div class="w-[10%]">
                                <img src="{{ asset('./images/icons/quote.png') }}" alt="Author">
                            </div>
                            <div class="-mt-1 w-[60%]">
                                <p class="text-sm">Iqbal Ramadhan</p>
                                <p class="text-gray-500 text-sm">Department Name</p>
                            </div>
                            <div class="justify-end w-[30%] flex">
                                <img src="{{ asset('./images/icons/menu.png') }}" class="w-4 h-4" alt="Author">
                            </div>
                        </div>
                        <div class="mt-4">
                            <p class="text-black">Rooting approval</p>
                        </div>
                        <div class="mt-3">
                            <p class="text-xs text-gray-500">2 days ago</p>
                        </div>
                    </div>
                    <div class="bg-[#F5F5F5] py-3 px-4 rounded-md">
                        <div class="flex gap-3">
                            <div class="w-[10%]">
                                <img src="{{ asset('./images/icons/quote.png') }}" alt="Author">
                            </div>
                            <div class="-mt-1 w-[60%]">
                                <p class="text-sm">Iqbal Ramadhan</p>
                                <p class="text-gray-500 text-sm">Department Name</p>
                            </div>
                            <div class="justify-end w-[30%] flex">
                                <img src="{{ asset('./images/icons/menu.png') }}" class="w-4 h-4" alt="Author">
                            </div>
                        </div>
                        <div class="mt-4">
                            <p class="text-black">Rooting approval</p>
                        </div>
                        <div class="mt-3">
                            <p class="text-xs text-gray-500">2 days ago</p>
                        </div>
                    </div>
                    <div class="bg-[#F5F5F5] py-3 px-4 rounded-md">
                        <div class="flex gap-3">
                            <div class="w-[10%]">
                                <img src="{{ asset('./images/icons/quote.png') }}" alt="Author">
                            </div>
                            <div class="-mt-1 w-[60%]">
                                <p class="text-sm">Iqbal Ramadhan</p>
                                <p class="text-gray-500 text-sm">Department Name</p>
                            </div>
                            <div class="justify-end w-[30%] flex">
                                <img src="{{ asset('./images/icons/menu.png') }}" class="w-4 h-4" alt="Author">
                            </div>
                        </div>
                        <div class="mt-4">
                            <p class="text-black">Rooting approval</p>
                        </div>
                        <div class="mt-3">
                            <p class="text-xs text-gray-500">2 days ago</p>
                        </div>
                    </div>
                </div>

                {{-- @foreach ($this->activities as $item)
                    <div class="info-item mb-3">

                        <div class="activity d-flex flex-column gap-2">

                            <div class="item-content d-flex gap-1 align-items-center">

                                <div class="activity-item d-flex flex-column gap-2">

                                    <div
                                        class="activity-header d-flex justify-content-between align-items-center gap-2">
                                        <div class="d-flex align-items-center gap-2">
                                            <div class="thumb">
                                                <img src="{{ asset('./images/profile.png') }}" alt="Profile">
                                            </div>
                                            <div class="title d-flex flex-column">
                                                <span>{{ $item->user->employee->name }}</span>
                                                <span class="opacity-50">{{ $item->user->department->name }}</span>
                                            </div>
                                        </div>
                                        <div class="tools">
                                            <a href="#" role="button" data-bs-toggle="modal"
                                                data-bs-target="#modalActivity">
                                                <img src="{{ asset('./images/icons/menu.png') }}" alt="menu">
                                            </a>
                                        </div>
                                    </div><!-- /.activity-item -->

                                    <div class="activity-content" x-data="{ contentOpen: false }"">

                                        <div class="activity-inner d-flex flex-column gap-2"
                                            :class="contentOpen ? 'height-auto' : ''" x-transition.delay.5s>
                                            <div class="desc">
                                                {{ $item->description }}
                                            </div>

                                            @foreach ($item->files->where('type_file', '!=', 'pdf') as $value)
                                                <div class="images">
                                                    @if ($loop->index == 0)
                                                        <h6 class="fw-normal">Images</h6>
                                                    @endif
                                                    <div
                                                        class="image d-flex align-items-center justify-content-between bg-white rounded p-2 border border-1 mb-2">
                                                        <div class="d-flex gap-2 align-items-center">
                                                            <div class="thumb">
                                                                <img src="{{ asset('./images/activity.png') }}"
                                                                    alt="activity">
                                                            </div>
                                                            <div class="img-name">
                                                                {{ Str::limit(explode('/', $value->file)[4], 15) }}
                                                            </div>
                                                        </div>
                                                        <div class="img-size opacity-50">{{ $value->size }}</div>
                                                    </div><!-- image -->
                                                </div><!-- /.images -->
                                            @endforeach
                                            @foreach ($item->files->where('type_file', 'pdf') as $value)
                                                <div class="images">
                                                    @if ($loop->index == 0)
                                                        <h6 class="fw-normal">Files</h6>
                                                    @endif
                                                    <div
                                                        class="image d-flex align-items-center justify-content-between bg-white rounded p-2 border border-1 mb-2">
                                                        <div class="d-flex gap-2 align-items-center">
                                                            <div class="thumb">
                                                                <img src="{{ asset('./images/icons/pdf.png') }}"
                                                                    alt="excel">
                                                            </div>
                                                            <div class="img-name">
                                                                {{ Str::limit(explode('/', $value->file)[4], 15) }}
                                                            </div>
                                                        </div>
                                                        <div class="img-size opacity-50">{{ $value->size }}</div>
                                                    </div><!-- image -->
                                                </div><!-- /.images -->
                                            @endforeach
                                        </div><!-- /.actifity-inner -->
                                        <div class="button-showless">
                                            <button
                                                class="d-flex gap-1 justify-content-center w-100 align-items-center py-2"
                                                type="button" @click="contentOpen = ! contentOpen">
                                                <span>Show Less</span>
                                                <span class="icon-btn"><i class="fa-solid fa-angle-down"></i></span>
                                            </button>
                                        </div><!-- /.button-showless -->

                                    </div><!-- /.actifity-content -->

                                    <div class="activity-footer opacity-50">{{ $item->created_at->diffForHumans() }}
                                    </div>

                                </div><!-- /.activity-item -->

                            </div>

                        </div><!-- /.author -->

                    </div><!-- /.info-items -->
                @endforeach --}}
            </div><!-- /.detail-left -->

        </div><!-- /.detail-maker -->

        <!-- Modal actifity -->
        <div class="modal fade" id="modalActivity" tabindex="-1" aria-labelledby="modalActivity"
            aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <form action="#">
                        <div class="modal-header">
                            <h5 class="modal-title fw-normal" id="exampleModalLabel">Activity</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal"
                                aria-label="Close"></button>
                        </div>
                        <div class="modal-body">

                            <div class="activity d-flex flex-column gap-2">

                                <div class="item-content d-flex gap-1 align-items-center">

                                    <div class="activity-item d-flex flex-column gap-2">

                                        <div
                                            class="activity-header d-flex justify-content-start align-items-center gap-2">
                                            <div class="thumb">
                                                <img src="{{ asset('./images/profile.png') }}" alt="Profile">
                                            </div>
                                            <div class="title d-flex flex-column">
                                                <span>Iqbal Ramadhan</span>
                                                <span class="opacity-50">Departement Name</span>
                                            </div>
                                        </div><!-- /.activity-item -->

                                        <div class="activity-content">

                                            <div class="activity-inner d-flex flex-column gap-2">

                                                <div class="desc">Lorem ipsum dolor sit amet, consectetur adipiscing
                                                    elit, sed do eiusmod tempor incididunt ut labor...</div>
                                                <div class="images">
                                                    <h6 class="fw-normal">Files</h6>
                                                    <div class="files-content d-flex gap-2 flex-wrap">
                                                        <div
                                                            class="image d-flex flex-column align-items-start justify-content-center bg-white rounded p-3 border border-1">
                                                            <div class="thumb mb-2">
                                                                <img src="{{ asset('./images/icons/excel.png') }}"
                                                                    alt="excel">
                                                            </div>
                                                            <div class="img-name">Evidence Data</div>
                                                            <div class="img-size opacity-50">3.2 Mb</div>
                                                        </div><!-- image -->
                                                        <div
                                                            class="image d-flex flex-column align-items-start justify-content-center bg-white rounded p-3 border border-1">
                                                            <div class="thumb mb-2">
                                                                <img src="{{ asset('./images/icons/pdf.png') }}"
                                                                    alt="pdf">
                                                            </div>
                                                            <div class="img-name">File Name.pdf</div>
                                                            <div class="img-size opacity-50">3.2 Mb</div>
                                                        </div><!-- image -->
                                                    </div><!-- /.files-content -->
                                                </div><!-- /.images -->

                                                <div class="images">
                                                    <h6 class="fw-normal">Images</h6>
                                                    <div class="images-content d-flex gap-2 flex-wrap">
                                                        <div class="image d-flex flex-column align-items-start justify-content-center bg-white rounded p-3 border border-1"
                                                            data-bs-toggle="tooltip" data-bs-placement="top"
                                                            title="Contoh toolpips dengan nama panjang">
                                                            <div class="thumb mb-2">
                                                                <img src="{{ asset('./images/activity.png') }}"
                                                                    alt="activity">
                                                            </div>
                                                            <div class="img-name">Nama Panjang ...</div>
                                                            <div class="img-size opacity-50">3.2 Mb</div>

                                                        </div><!-- image -->
                                                        <div
                                                            class="image d-flex flex-column align-items-start justify-content-center bg-white rounded p-3 border border-1">
                                                            <div class="thumb mb-2">
                                                                <img src="{{ asset('./images/activity.png') }}"
                                                                    alt="activity">
                                                            </div>
                                                            <div class="img-name">Image.jpg</div>
                                                            <div class="img-size opacity-50">3.2 Mb</div>
                                                        </div><!-- image -->
                                                        <div
                                                            class="image d-flex flex-column align-items-start justify-content-center bg-white rounded p-3 border border-1">
                                                            <div class="thumb mb-2">
                                                                <img src="{{ asset('./images/activity.png') }}"
                                                                    alt="activity">
                                                            </div>
                                                            <div class="img-name">Image.jpg</div>
                                                            <div class="img-size opacity-50">3.2 Mb</div>
                                                        </div><!-- image -->
                                                        <div
                                                            class="image d-flex flex-column align-items-start justify-content-center bg-white rounded p-3 border border-1">
                                                            <div class="thumb mb-2">
                                                                <img src="{{ asset('./images/activity.png') }}"
                                                                    alt="activity">
                                                            </div>
                                                            <div class="img-name">Image.jpg</div>
                                                            <div class="img-size opacity-50">3.2 Mb</div>
                                                        </div><!-- image -->
                                                        <div
                                                            class="image d-flex flex-column align-items-start justify-content-center bg-white rounded p-3 border border-1">
                                                            <div class="thumb mb-2">
                                                                <img src="{{ asset('./images/activity.png') }}"
                                                                    alt="activity">
                                                            </div>
                                                            <div class="img-name">Image.jpg</div>
                                                            <div class="img-size opacity-50">3.2 Mb</div>
                                                        </div><!-- image -->
                                                    </div><!-- /.images-content -->
                                                </div><!-- /.images -->

                                            </div><!-- /.actifity-inner -->

                                        </div><!-- /.actifity-content -->

                                        <div class="activity-footer opacity-50">2 days ago</div>

                                    </div><!-- /.activity-item -->

                                </div>

                            </div><!-- /.author -->

                        </div>
                    </form>
                </div>
            </div>
        </div><!-- modal activity -->

    </div>
    </div>

