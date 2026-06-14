<div class="inner-content">

    <div class="header-detail-maker h-60px bg-green d-flex gap-2 align-items-center px-3">
        <a href="{{ route('field-leadership::listing.active.index') }}"
            class="d-flex align-items-center gap-3 text-white">
            <span><i class="fa-solid fa-arrow-left"></i></span>
            <span>Field Leadership</span>
        </a>
        <a href="{{ route('field-leadership::listing.active.edit', $field->id) }}"
            class="btn btn-edit text-white bg-146943"> <i class="fas fa-pencil"></i> Edit</a>
    </div>

    <div class="detail-maker-content d-flex">

        <div class="detail-left border-end border-1">

            <div class="info bg-white">

                <div class="info-item p-3 border-bottom border-1">

                    <div class="author d-flex flex-column gap-2">
                        <h6 class="fw-normal">Penanggung Jawab</h6>
                        <div class="item-content d-flex gap-2 align-items-center">
                            <div class="thumb">
                                <img src="{{ asset('./images/author.png') }}" alt="Author">
                            </div>
                            <div class="author-name">Arli Rahman</div>
                        </div>
                    </div><!-- /.author -->

                </div><!-- /.info-items -->

                <div class="info-item p-3 border-bottom border-1">

                    <div class="pt d-flex flex-column gap-2">
                        <h6 class="fw-normal">{{ $field->ccow->company_name }}</h6>
                        <div class="item-content d-flex gap-2 align-items-start">
                            <div class="thumb">
                                <img src="{{ asset('./images/icons/position.png') }}" alt="Position">
                            </div>
                            <div class="position-name d-flex flex-column">
                                <span class="opacity-50">Position</span>
                                <span>Manager</span>
                            </div>
                        </div>
                        <div class="item-content d-flex gap-2 align-items-start">
                            <div class="thumb">
                                <img src="{{ asset('./images/icons/map.png') }}" alt="Location">
                            </div>
                            <div class="location-name d-flex flex-column">
                                <span class="opacity-50">Perusahaan</span>
                                <span>{{ $field->company->company_name }}</span>
                            </div>
                        </div>
                        <div class="item-content d-flex gap-2 align-items-start">
                            <div class="thumb">
                                <img class="w-18px" src="{{ asset('./images/icons/blank.png') }}" alt="Blank">
                            </div>
                            <div class="location-name d-flex flex-column">
                                <span class="opacity-50">Detail Perusahaan</span>
                                <span>{{ $field->detail_company }}</span>
                            </div>
                        </div>
                        <div class="item-content d-flex gap-2 align-items-start">
                            <div class="thumb">
                                <img class="w-18px" src="{{ asset('./images/icons/blank.png') }}" alt="Blank">
                            </div>
                            <div class="department-name d-flex flex-column">
                                <span class="opacity-50">Department</span>
                                <span>{{ $field->department->name }}</span>
                            </div>
                        </div>
                        <div class="item-content d-flex gap-2 align-items-start">
                            <div class="thumb">
                                <img class="w-18px" src="{{ asset('./images/icons/blank.png') }}" alt="Blank">
                            </div>
                            <div class="department-name d-flex flex-column">
                                <span class="opacity-50">Section</span>
                                <span>{{ $field->section->name }}</span>
                            </div>
                        </div>
                        <div class="item-content d-flex gap-2 align-items-start">
                            <div class="thumb">
                                <img class="w-18px" src="{{ asset('./images/icons/blank.png') }}" alt="Blank">
                            </div>
                            <div class="location-name d-flex flex-column">
                                <span class="opacity-50">Location</span>
                                <span>{{ $field->areaLocation->name }}</span>
                            </div>
                        </div>
                        <div class="item-content d-flex gap-2 align-items-start">
                            <div class="thumb">
                                <img class="w-18px" src="{{ asset('./images/icons/blank.png') }}" alt="Blank">
                            </div>
                            <div class="department-name d-flex flex-column">
                                <span class="opacity-50">Detail Location</span>
                                <span>{{ $field->detail_company }}</span>
                            </div>
                        </div>
                    </div><!-- /.author -->

                </div><!-- /.info-items -->

                <div class="info-item p-3 border-bottom border-1">

                    <div class="created d-flex flex-column gap-2">

                        <h6 class="fw-normal">Created</h6>

                        <div class="item-content d-flex gap-1 align-items-center">
                            <span>{{ Carbon\Carbon::parse($field->created_at)->format('F d, Y') }}</span>
                        </div>

                    </div><!-- /.author -->

                </div><!-- /.info-items -->

                <div class="info-item p-3 border-bottom border-1">

                    <div class="author d-flex flex-column gap-2">
                        <h6 class="fw-normal">PJA</h6>
                        <div class="item-content d-flex gap-2 align-items-center">
                            <div class="thumb">
                                <img src="{{ asset('./images/no-profile.png') }}" alt="Author">
                            </div>
                            <div class="author-name">{{ $field->pja->user->name }}</div>
                        </div>
                    </div><!-- /.author -->

                </div><!-- /.info-items -->

                <div class="info-item p-3 border-bottom border-1">

                    <div class="author d-flex flex-column gap-2">
                        <h6 class="fw-normal">PJO / KTT</h6>
                        <div class="item-content d-flex gap-2 align-items-center">
                            <div class="thumb">
                                <img src="{{ asset('./images/no-profile.png') }}" alt="Author">
                            </div>
                            <div class="author-name">{{ $field->pjo->name }}</div>
                        </div>
                    </div><!-- /.author -->

                </div><!-- /.info-items -->

            </div><!-- /.info -->

        </div><!-- /.detail-left -->

        <div class="section-content w-100 py-3 px-5 d-flex flex-column gap-3">

            <div class="section-info py-3 px-2 d-flex flex-column gap-2">

                <h5 class="fw-normal">Field Leadership</h5>

                <div class="content-section d-flex flex-column gap-1">

                    <div class="module-info-items row">
                        <div class="col-4 opacity-50">Jenis Field Leadership</div>
                        <div class="col-8">{{ $field->type }}</div>
                    </div><!-- /.module-info-items -->

                    <div class="module-info-items row">
                        <div class="col-4 opacity-50">Tugas / SOP / WI yang diamati</div>
                        <div class="col-8">{{ $field->job }}</div>
                    </div><!-- /.module-info-items -->

                </div><!-- /.content-section -->

            </div><!-- /.section-info -->

            <div class="section-status py-3 px-2 d-flex flex-column gap-2">

                <h5 class="fw-normal">Waktu Kunjungan</h5>

                <div class="content-section d-flex flex-column gap-1">

                    <div class="module-status-items row">
                        <div class="col-4 opacity-50">Jumlah waktu kunjungan</div>
                        <div class="col-8">{{ $field->visit_time }} Menit</div>
                    </div><!-- /.module-info-items -->

                </div><!-- /.content-section -->

            </div><!-- /.section-status -->

            <div class="section-description py-3 px-2 d-flex flex-column gap-2">

                <h5 class="fw-normal">Kondisi Beresiko</h5>

                @foreach ($field->risks as $risk)
                    <div class="card p-3 mb-5">

                        <div class="module-status-items row mb-3">
                            <div class="col-4 opacity-50">Perilaku/Kondisi Beresiko Yang Diamati</div>
                            <div class="col-8">{{ $risk->risk_condition }}</div>
                        </div><!-- /.module-info-items -->

                        <div class="module-status-items row mb-3">
                            <div class="col-4 opacity-50">Jenis KTA/TTA </div>
                            <div class="col-8">{{ $risk->type->name }}</div>
                        </div><!-- /.module-info-items -->

                        <div class="module-status-items row mb-3">
                            <div class="col-4 opacity-50">Tindakan Perbaikan</div>
                            <div class="col-8">{{ $risk->repair_action }}</div>
                        </div><!-- /.module-info-items -->

                        <div class="module-status-items row mb-3">
                            <div class="col-4 opacity-50">Kategori </div>
                            <div class="col-8">{{ $risk->category->name }}</div>
                        </div><!-- /.module-info-items -->

                        <div class="module-status-items row mb-3">
                            <div class="col-4 opacity-50">Tingkat Risiko / Potensi</div>
                            <div class="col-8">{{ $risk->potency->name }}</div>
                        </div><!-- /.module-info-items -->

                        <div class="module-status-items row mb-3">
                            <div class="col-4 opacity-50">Target Waktu Penyelesaian</div>
                            <div class="col-8">{{ Carbon\Carbon::parse($risk->due_date)->format('F d, Y') }}</div>
                        </div><!-- /.module-info-items -->

                        <div class="module-status-items row mb-3">
                            <div class="col-4 opacity-50">Attachment</div>
                            <div class="col-8">
                                @foreach ($risk->files as $keyFile => $itemFile)
                                    <div class="row form-group mb-3 bg-white rounded p-3 border border-1">
                                        <div class="col-sm-12 bg-white d-flex justify-content-between file-list">
                                            <div>
                                                <img src="{{ asset('/images/icons/pdf.png') }}" alt="pdf" />
                                                <span>
                                                    {{ Str::limit(explode('/', $itemFile->file)[4], 15) }}
                                                </span>
                                            </div>
                                            <span>
                                                {{ $itemFile->size }}
                                            </span>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div><!-- /.module-info-items -->

                    </div>
                @endforeach

            </div><!-- /.section-description -->

            <div class="section-attachment px-2 d-flex flex-column gap-2 mb-5">

                <h5 class="fw-normal">Anggota Tim</h5>

                <div class="content-section d-flex flex-column gap-1">

                    <div class="module-attachment-items d-flex flex-wrap gap-2">

                        <div class="files-content d-flex gap-2 flex-wrap">

                            @foreach ($field->members as $member)
                                <div class="image d-flex flex-column align-items-start justify-content-center bg-white rounded p-3 border border-1"
                                    data-bs-toggle="tooltip" data-bs-placement="top"
                                    title="Contoh toolpips dengan nama panjang">
                                    <div class="thumb mb-2">
                                        <img src="{{ asset('./images/no-profile.png') }}" alt="excel">
                                    </div>
                                    <div class="img-name">{{ $member->employee->name ?? null }}</div>
                                    <div class="img-size opacity-50">{{ $member->type }}</div>
                                </div><!-- image -->
                            @endforeach

                        </div><!-- /.files-content -->

                    </div><!-- /.module-attachment-items -->

                </div><!-- /.content-section -->

            </div><!-- /.section-Attachment -->

        </div><!-- /.section-content -->

        <div class="detail-right border-start border-1">

            <div class="info bg-white px-3">

                <h6 class="fw-normal">Activity</h6>

                <div class="info-item">

                    <div class="activity d-flex flex-column gap-2">

                        <div class="item-content d-flex gap-1 align-items-center">

                            <div class="activity-item d-flex flex-column gap-2">

                                <div class="activity-header d-flex justify-content-between align-items-center gap-2">
                                    <div class="d-flex align-items-center gap-2">
                                        <div class="thumb">
                                            <img src="{{ asset('./images/profile.png') }}" alt="Profile">
                                        </div>
                                        <div class="title d-flex flex-column">
                                            <span>Iqbal Ramadhan</span>
                                            <span class="opacity-50">Departement Name</span>
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
                                        <div class="desc">Lorem ipsum dolor sit amet, consectetur adipiscing elit,
                                            sed do eiusmod tempor incididunt ut labor...</div>
                                        <div class="images">
                                            <h6 class="fw-normal">Images</h6>
                                            <div
                                                class="image d-flex align-items-center justify-content-between bg-white rounded p-2 border border-1 mb-2">
                                                <div class="d-flex gap-2 align-items-center">
                                                    <div class="thumb">
                                                        <img src="{{ asset('./images/activity.png') }}"
                                                            alt="activity">
                                                    </div>
                                                    <div class="img-name">Image.jpg</div>
                                                </div>
                                                <div class="img-size opacity-50">3.2 Mb</div>
                                            </div><!-- image -->
                                            <div
                                                class="image d-flex align-items-center justify-content-between bg-white rounded p-2 border border-1 mb-2">
                                                <div class="d-flex gap-2 align-items-center">
                                                    <div class="thumb">
                                                        <img src="{{ asset('./images/activity.png') }}"
                                                            alt="activity">
                                                    </div>
                                                    <div class="img-name">Image.jpg</div>
                                                </div>
                                                <div class="img-size opacity-50">3.2 Mb</div>
                                            </div><!-- image -->
                                        </div><!-- /.images -->
                                        <div class="images">
                                            <h6 class="fw-normal">Files</h6>
                                            <div
                                                class="image d-flex align-items-center justify-content-between bg-white rounded p-2 border border-1 mb-2">
                                                <div class="d-flex gap-2 align-items-center">
                                                    <div class="thumb">
                                                        <img src="{{ asset('./images/icons/excel.png') }}"
                                                            alt="excel">
                                                    </div>
                                                    <div class="img-name">Evidence Data</div>
                                                </div>
                                                <div class="img-size opacity-50">3.2 Mb</div>
                                            </div><!-- image -->
                                            <div
                                                class="image d-flex align-items-center justify-content-between bg-white rounded p-2 border border-1 mb-2">
                                                <div class="d-flex gap-2 align-items-center">
                                                    <div class="thumb">
                                                        <img src="{{ asset('./images/icons/pdf.png') }}"
                                                            alt="pdf">
                                                    </div>
                                                    <div class="img-name">File Name.pdf</div>
                                                </div>
                                                <div class="img-size opacity-50">3.2 Mb</div>
                                            </div><!-- image -->
                                        </div><!-- /.images -->
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

                                <div class="activity-footer opacity-50">2 days ago</div>

                            </div><!-- /.activity-item -->

                        </div>

                    </div><!-- /.author -->

                </div><!-- /.info-items -->

                <div class="info-item">

                    <div class="activity d-flex flex-column gap-2">

                        <div class="item-content d-flex gap-1 align-items-center">

                            <div class="activity-item d-flex flex-column gap-2">

                                <div class="activity-header d-flex justify-content-between align-items-center gap-2">
                                    <div class="d-flex align-items-center gap-2">
                                        <div class="thumb">
                                            <img src="{{ asset('./images/profile.png') }}" alt="Profile">
                                        </div>
                                        <div class="title d-flex flex-column">
                                            <span>Iqbal Ramadhan</span>
                                            <span class="opacity-50">Departement Name</span>
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
                                        <div class="desc">Lorem ipsum dolor sit amet, consectetur adipiscing elit,
                                            sed do eiusmod tempor incididunt ut labor...</div>
                                        <div class="images">
                                            <h6 class="fw-normal">Images</h6>
                                            <div
                                                class="image d-flex align-items-center justify-content-between bg-white rounded p-2 border border-1 mb-2">
                                                <div class="d-flex gap-2 align-items-center">
                                                    <div class="thumb">
                                                        <img src="{{ asset('./images/activity.png') }}"
                                                            alt="activity">
                                                    </div>
                                                    <div class="img-name">Image.jpg</div>
                                                </div>
                                                <div class="img-size opacity-50">3.2 Mb</div>
                                            </div><!-- image -->
                                            <div
                                                class="image d-flex align-items-center justify-content-between bg-white rounded p-2 border border-1 mb-2">
                                                <div class="d-flex gap-2 align-items-center">
                                                    <div class="thumb">
                                                        <img src="{{ asset('./images/activity.png') }}"
                                                            alt="activity">
                                                    </div>
                                                    <div class="img-name">Image.jpg</div>
                                                </div>
                                                <div class="img-size opacity-50">3.2 Mb</div>
                                            </div><!-- image -->
                                        </div><!-- /.images -->
                                        <div class="images">
                                            <h6 class="fw-normal">Files</h6>
                                            <div
                                                class="image d-flex align-items-center justify-content-between bg-white rounded p-2 border border-1 mb-2">
                                                <div class="thumb">
                                                    <img src="{{ asset('./images/icons/excel.png') }}"
                                                        alt="excel">
                                                </div>
                                                <div class="img-name">Evidence Data</div>
                                                <div class="img-size opacity-50">3.2 Mb</div>
                                            </div><!-- image -->
                                            <div
                                                class="image d-flex align-items-center justify-content-between bg-white rounded p-2 border border-1 mb-2">
                                                <div class="thumb">
                                                    <img src="{{ asset('./images/icons/pdf.png') }}" alt="pdf">
                                                </div>
                                                <div class="img-name">File Name.pdf</div>
                                                <div class="img-size opacity-50">3.2 Mb</div>
                                            </div><!-- image -->
                                        </div><!-- /.images -->
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

                                <div class="activity-footer opacity-50">2 days ago</div>

                            </div><!-- /.activity-item -->

                        </div>

                    </div><!-- /.author -->

                </div><!-- /.info-items -->

                <div class="info-item">

                    <div class="activity d-flex flex-column gap-2">

                        <div class="item-content d-flex gap-1 align-items-center">

                            <div class="activity-item d-flex flex-column gap-2">

                                <div class="activity-header d-flex justify-content-between align-items-center gap-2">
                                    <div class="d-flex align-items-center gap-2">
                                        <div class="thumb">
                                            <img src="{{ asset('./images/profile.png') }}" alt="Profile">
                                        </div>
                                        <div class="title d-flex flex-column">
                                            <span>Iqbal Ramadhan</span>
                                            <span class="opacity-50">Departement Name</span>
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

                                    <div class="activity-inner h-auto d-flex flex-column gap-2"
                                        :class="contentOpen ? 'height-auto' : ''" x-transition.delay.5s>
                                        <div class="desc">Lorem ipsum dolor sit amet, consectetur adipiscing elit,
                                            sed do eiusmod tempor incididunt ut labor...</div>
                                    </div><!-- /.actifity-content -->

                                    <div class="activity-footer opacity-50">2 days ago</div>

                                </div><!-- /.activity-item -->

                            </div>

                        </div><!-- /.author -->

                    </div><!-- /.info-items -->

                </div><!-- /.info -->

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
