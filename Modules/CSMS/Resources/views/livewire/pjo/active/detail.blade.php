<div class="inner-content">
    <div class="header-detail-maker h-60px border d-flex gap-2 align-items-center px-3">

        <a href="javascript:history.go(-1)" class="d-flex align-items-center gap-3">
            <span><i class="fa-solid fa-arrow-left"></i></span>
            <span>DETAIL PJO</span>
        </a>

        {{-- @can('CSMS - Bidding Reviewer OHS')
            @if ($bidding->criteria == App\Enums\CSMS\CsmsStatus::Bidding)
                <a href="{{ route('csms::post-bidding.edit', $bidding->id) }}" class="btn btn-edit text-white bg-146943">
                    <i class="fas fa-pencil"></i>
                    Edit
                </a>
            @endif
            @if ($bidding->criteria == App\Enums\CSMS\CsmsStatus::PostBidding)
                <a href="{{ route('csms::post-bidding.edit', $bidding->id) }}" class="btn btn-edit text-white bg-146943">
                    <i class="fas fa-pencil"></i>
                    Edit
                </a>
            @endif
            @if ($bidding->criteria == App\Enums\CSMS\CsmsStatus::Renewal)
                <a href="{{ route('csms::renewal.edit', $bidding->id) }}" class="btn btn-edit text-white bg-146943">
                    <i class="fas fa-pencil"></i>
                    Edit
                </a>
            @endif
        @endcan --}}

    </div><!-- /.header-edit-event -->

    <div class="container-fluid g-0 position-relative">
        <div class="row g-0">

            <div class="detail-left col-3">
                <div class="position-sticky top-0 bg-white pb-4">
                    <div class="info-item py-3 px-4 border-bottom border-1">

                        <div class="info-item p-3  border-1">

                            <div class="author d-flex flex-column gap-2">
                                <h6>Maker</h6>
                                <div class="item-content d-flex gap-2 align-items-center">
                                    <div class="thumb">
                                        <img src="{{ asset('./images/author.png') }}" alt="Author">
                                    </div>
                                    <div class="author-name">{{ $pjo->createdBy->name }}</div>
                                </div>
                            </div><!-- /.author -->

                        </div><!-- /.info-items -->

                    </div><!-- /.info-items -->
                    {{-- <div class="info-item py-3 px-4 border-bottom border-1">
                        <div class="nip d-flex flex-column">
                            <h6>NIP/NIK</h6>
                            <div class="item-content d-flex gap-1 align-items-center">
                                <span class="opacity-80">
                                    {{ $maker->employee->number }} / {{ $maker->employee->id_number }}
                                </span>
                            </div>
                        </div>
                    </div> --}}
                    <div class="info-item py-3 px-4 border-bottom border-1">
                        <div class="created d-flex flex-column">
                            <h6>Dibuat</h6>
                            <div class="item-content d-flex gap-1 align-items-center">
                                <span class="opacity-80">pada</span>
                                <span>
                                    {{ Carbon\Carbon::parse($pjo->created_at)->format('d F Y') }}
                                </span>
                            </div>
                        </div><!-- /.created -->
                    </div><!-- /.info-items -->
                    <div class="info-item py-3 px-4 border-bottom border-1">
                        <div class="review d-flex flex-column">
                            <h6>Terakhir Diupdate</h6>
                            <div class="item-content d-flex gap-1 align-items-center">
                                <span class="opacity-80">pada</span>
                                <span>
                                    {{ Carbon\Carbon::parse($pjo->updated_at)->format('d F Y') }}
                                </span>
                            </div>
                        </div><!-- /.review -->
                    </div><!-- /.info-items -->
                </div><!-- /.info -->
            </div><!-- /.detail-left -->

            <div class="col pb-7 border-end border-start border-1">

                <div id="label" class="section border-1 border-bottom p-5">
                    <div class="text-center">
                        <h5 class="mb-0 fw-normal title-accordion">DETAIL PJO</h5>
                    </div>

                    <div class="wrapper-content-section overflow-hidden position-relative transition-all duration-700">
                        <div class="content-section m-4">
                            <div class="mb-3 mcu-detail-item row">
                                <label class="col-3 opacity-80">Nama Perusahaan</label>
                                <div class="col-6 content">
                                    <div class="content">{{ $pjo->company->company_name }}</div>
                                </div>
                            </div>
                            <div class="mb-3 mcu-detail-item row">
                                <label class="col-3 opacity-80">Kriteria Jasa Perusahaan</label>
                                <div class="col-6 content">
                                    <div class="content">{{ $pjo->company->service_criteria }}</div>
                                </div>
                            </div>
                            <div class="mb-3 mcu-detail-item row">
                                <label class="col-3 opacity-80">Perusahaan Induk </label>
                                <div class="col-6 content">
                                    <div class="content">{{ $pjo->ccow ? $pjo->ccow->company_name : '-' }}</div>
                                </div>
                            </div>
                            <div class="mb-3 mcu-detail-item row">
                                <label class="col-3 opacity-80">Pengajuan</label>
                                <div class="col-6 content">
                                    <div class="content">{{ $pjo->submission }}</div>
                                </div>
                            </div>

                            <hr>

                            <div class="mb-3 mcu-detail-item row">
                                <label class="col-3 opacity-80">Number PJO</label>
                                <div class="col-6 content">
                                    <div class="content">{{ $pjo->number_pjo }}</div>
                                </div>
                            </div>
                            <div class="mb-3 mcu-detail-item row">
                                <label class="col-3 opacity-80">Nama PJO</label>
                                <div class="col-6 content">
                                    <div class="content">{{ $pjo->name }}</div>
                                </div>
                            </div>
                            <div class="mb-3 mcu-detail-item row">
                                <label class="col-3 opacity-80">Tanggal Lahir</label>
                                <div class="col-6 content">
                                    <div class="content">
                                        {{ Carbon\Carbon::parse($pjo->date_of_birth)->format('d F Y') }}
                                    </div>
                                </div>
                            </div>
                            <div class="mb-3 mcu-detail-item row">
                                <label class="col-3 opacity-80">Nomor Handphone</label>
                                <div class="col-6 content">
                                    <div class="content">{{ $pjo->phone }}</div>
                                </div>
                            </div>
                            <div class="mb-3 mcu-detail-item row">
                                <label class="col-3 opacity-80">Alamat Email </label>
                                <div class="col-6 content">
                                    <div class="content">{{ $pjo->email }}</div>
                                </div>
                            </div>

                            <hr>
                        </div>
                    </div>
                </div>


                <div id="label" class="section border-1 border-bottom p-5">
                    <div class="text-center">
                        <h5 class="mt-3 mb-0 fw-normal title-accordion">Lampiran</h5>
                    </div>

                    <div class="row mb-3 mt-5 form-group">

                        <label for="kompetensi" class="col col-form-label">
                            Sertifikat Kompetensi (POP/POM/POU), ISMKP, ASMKP
                        </label>

                        @if (!empty($files['competency_file']))
                            <div class="module-attachment-items gap-2">

                                <div class="files-content d-flex flex-column gap-2">
                                    @foreach ($files['competency_file'] as $keyFile => $itemFile)
                                        <a href="{{ asset($itemFile['file']) }}">
                                            <div class="image d-flex w-100 align-items-center bg-white rounded p-3 border border-1"
                                                data-bs-toggle="tooltip" data-bs-placement="top" title="attachment">
                                                <div class="thumb">
                                                    <img src="{{ asset('/images/icons/pdf.png') }}" alt="excel">
                                                </div>
                                                <div class="img-name">{{ $itemFile['name'] }}</div>
                                                <div class="img-size opacity-50 ms-auto">{{ $itemFile['size'] }}</div>
                                            </div><!-- image -->
                                        </a>
                                    @endforeach
                                </div>
                            </div>
                        @endif

                    </div><!-- /.form-group -->

                    <div class="row mb-3 mt-5 form-group">

                        <label for="kompetensi" class="col col-form-label">
                            Sertifikat Lainnya (Bila ada)
                        </label>

                        @if (!empty($files['other_file']))
                            <div class="module-attachment-items gap-2">

                                <div class="files-content d-flex flex-column gap-2">
                                    @foreach ($files['other_file'] as $keyFile => $itemFile)
                                        <a href="{{ asset($itemFile['file']) }}">
                                            <div class="image d-flex w-100 align-items-center bg-white rounded p-3 border border-1"
                                                data-bs-toggle="tooltip" data-bs-placement="top" title="attachment">
                                                <div class="thumb">
                                                    <img src="{{ asset('/images/icons/pdf.png') }}" alt="excel">
                                                </div>
                                                <div class="img-name">{{ $itemFile['name'] }}</div>
                                                <div class="img-size opacity-50 ms-auto">{{ $itemFile['size'] }}</div>
                                            </div><!-- image -->
                                        </a>
                                    @endforeach
                                </div>
                            </div>
                        @endif

                    </div><!-- /.form-group -->

                    <div class="row mb-3 mt-5 form-group">

                        <label for="kompetensi" class="col col-form-label">
                            Curriculum Vitae
                        </label>

                        @if (!empty($files['competency_file']))
                            <div class="module-attachment-items gap-2">

                                <div class="files-content d-flex flex-column gap-2">
                                    @foreach ($files['competency_file'] as $keyFile => $itemFile)
                                        <a href="{{ asset($itemFile['file']) }}">
                                            <div class="image d-flex w-100 align-items-center bg-white rounded p-3 border border-1"
                                                data-bs-toggle="tooltip" data-bs-placement="top" title="attachment">
                                                <div class="thumb">
                                                    <img src="{{ asset('/images/icons/pdf.png') }}" alt="excel">
                                                </div>
                                                <div class="img-name">{{ $itemFile['name'] }}</div>
                                                <div class="img-size opacity-50 ms-auto">{{ $itemFile['size'] }}</div>
                                            </div><!-- image -->
                                        </a>
                                    @endforeach
                                </div>
                            </div>
                        @endif

                    </div><!-- /.form-group -->

                    <div class="row mb-3 mt-5 form-group">

                        <label for="kompetensi" class="col col-form-label">
                            Surat Penunjukan PJO oleh Direksi
                        </label>

                        @if (!empty($files['appoinment_file']))
                            <div class="module-attachment-items gap-2">

                                <div class="files-content d-flex flex-column gap-2">
                                    @foreach ($files['appoinment_file'] as $keyFile => $itemFile)
                                        <a href="{{ asset($itemFile['file']) }}">
                                            <div class="image d-flex w-100 align-items-center bg-white rounded p-3 border border-1"
                                                data-bs-toggle="tooltip" data-bs-placement="top" title="attachment">
                                                <div class="thumb">
                                                    <img src="{{ asset('/images/icons/pdf.png') }}" alt="excel">
                                                </div>
                                                <div class="img-name">{{ $itemFile['name'] }}</div>
                                                <div class="img-size opacity-50 ms-auto">{{ $itemFile['size'] }}</div>
                                            </div><!-- image -->
                                        </a>
                                    @endforeach
                                </div>
                            </div>
                        @endif

                    </div><!-- /.form-group -->

                    <div class="row mb-3 mt-5 form-group">

                        <label for="kompetensi" class="col col-form-label">
                            Struktur Organisasi
                        </label>

                        @if (!empty($files['organizational_file']))
                            <div class="module-attachment-items gap-2">

                                <div class="files-content d-flex flex-column gap-2">
                                    @foreach ($files['organizational_file'] as $keyFile => $itemFile)
                                        <a href="{{ asset($itemFile['file']) }}">
                                            <div class="image d-flex w-100 align-items-center bg-white rounded p-3 border border-1"
                                                data-bs-toggle="tooltip" data-bs-placement="top" title="attachment">
                                                <div class="thumb">
                                                    <img src="{{ asset('/images/icons/pdf.png') }}" alt="excel">
                                                </div>
                                                <div class="img-name">{{ $itemFile['name'] }}</div>
                                                <div class="img-size opacity-50 ms-auto">{{ $itemFile['size'] }}</div>
                                            </div><!-- image -->
                                        </a>
                                    @endforeach
                                </div>
                            </div>
                        @endif

                    </div><!-- /.form-group -->

                    <div class="row mb-3 mt-5 form-group">

                        <label for="kompetensi" class="col col-form-label">
                            Persyaratan Administratif
                        </label>

                        @if (!empty($files['administration_file']))
                            <div class="module-attachment-items gap-2">

                                <div class="files-content d-flex flex-column gap-2">
                                    @foreach ($files['administration_file'] as $keyFile => $itemFile)
                                        <a href="{{ asset($itemFile['file']) }}">
                                            <div class="image d-flex w-100 align-items-center bg-white rounded p-3 border border-1"
                                                data-bs-toggle="tooltip" data-bs-placement="top" title="attachment">
                                                <div class="thumb">
                                                    <img src="{{ asset('/images/icons/pdf.png') }}" alt="excel">
                                                </div>
                                                <div class="img-name">{{ $itemFile['name'] }}</div>
                                                <div class="img-size opacity-50 ms-auto">{{ $itemFile['size'] }}</div>
                                            </div><!-- image -->
                                        </a>
                                    @endforeach
                                </div>
                            </div>
                        @endif

                    </div><!-- /.form-group -->

                    <div class="row mb-3 mt-5 form-group">

                        <label for="kompetensi" class="col col-form-label">
                            Surat Pernyataan Komitmen
                        </label>

                        @if (!empty($files['commitment_file']))
                            <div class="module-attachment-items gap-2">

                                <div class="files-content d-flex flex-column gap-2">
                                    @foreach ($files['commitment_file'] as $keyFile => $itemFile)
                                        <a href="{{ asset($itemFile['file']) }}">
                                            <div class="image d-flex w-100 align-items-center bg-white rounded p-3 border border-1"
                                                data-bs-toggle="tooltip" data-bs-placement="top" title="attachment">
                                                <div class="thumb">
                                                    <img src="{{ asset('/images/icons/pdf.png') }}" alt="excel">
                                                </div>
                                                <div class="img-name">{{ $itemFile['name'] }}</div>
                                                <div class="img-size opacity-50 ms-auto">{{ $itemFile['size'] }}</div>
                                            </div><!-- image -->
                                        </a>
                                    @endforeach
                                </div>
                            </div>
                        @endif

                    </div><!-- /.form-group -->

                    <div class="row mb-3 mt-5 form-group">

                        <label for="kompetensi" class="col col-form-label">
                            Surat Persetujuan
                        </label>

                        @if (!empty($files['approval_letter']))
                            <div class="module-attachment-items gap-2">

                                <div class="files-content d-flex flex-column gap-2">
                                    @foreach ($files['approval_letter'] as $keyFile => $itemFile)
                                        <a href="{{ asset($itemFile['file']) }}">
                                            <div class="image d-flex w-100 align-items-center bg-white rounded p-3 border border-1"
                                                data-bs-toggle="tooltip" data-bs-placement="top" title="attachment">
                                                <div class="thumb">
                                                    <img src="{{ asset('/images/icons/pdf.png') }}" alt="excel">
                                                </div>
                                                <div class="img-name">{{ $itemFile['name'] }}</div>
                                                <div class="img-size opacity-50 ms-auto">{{ $itemFile['size'] }}</div>
                                            </div><!-- image -->
                                        </a>
                                    @endforeach
                                </div>
                            </div>
                        @endif

                    </div><!-- /.form-group -->

                </div>
            </div>
        </div>

    </div><!-- /.row -->


    <div id="action" class="section-action border-1 border-bottom p-5">
        <div class="wrapper-content-section position-relative transition-all duration-700">
            <div class="content-section m-4">
                <div class="footer-action mb-2 align-center">
                    <div class="action-wrapper d-flex align-items-center justify-content-end gap-2 mb-5">

                        <a href="javascript:history.go(-1)" class="btn btn-outline-secondary">Cancel</a>

                        @if (auth()->user()->can('CSMS - Pjo Reviewer OHS') ||
                                auth()->user()->can('CSMS - Pjo Reviewer Evaluator') ||
                                auth()->user()->can('CSMS - Pjo Reviewer KTT'))
                            <div class="button-document">
                                <button
                                    class="dropdown-toggle btn btn-outline-default bg-green d-flex justify-content-center align-item-center text-white position-relative px-4"
                                    role="button" data-bs-toggle="dropdown" aria-expanded="true">
                                    Action
                                </button>
                                <ul class="dropdown-menu">

                                    <li>
                                        <button type="button" wire:click.prevent="return_maker()"
                                            class="dropdown-item" href="#">
                                            Return to Maker
                                        </button>
                                    </li>

                                    @can('CSMS - Pjo Reviewer OHS')
                                        <li>
                                            <button type="button"
                                                wire:click="approve('{{ App\Enums\CSMS\CsmsStatus::OnReviewOHS }}', '{{ App\Enums\CSMS\CsmsStatus::RequestedEvaluator }}')"
                                                class="dropdown-item" href="#">
                                                Submit to Evaluator
                                            </button>
                                        </li>
                                    @endcan
                                    @can('CSMS - Pjo Reviewer Evaluator')
                                        <li>
                                            <button type="button"
                                                wire:click="approve('{{ App\Enums\CSMS\CsmsStatus::OnReviewKTT }}', '{{ App\Enums\CSMS\CsmsStatus::RequestedKTT }}')"
                                                class="dropdown-item" href="#">
                                                Submit to KTT
                                            </button>
                                        </li>
                                    @endcan
                                    @can('CSMS - Pjo Reviewer KTT')
                                        <li>
                                            <button type="button"
                                                wire:click="approve('{{ App\Enums\CSMS\CsmsStatus::Approved }}', '{{ App\Enums\CSMS\CsmsStatus::Approved }}')"
                                                class="dropdown-item" href="#">
                                                Approve Bidding
                                            </button>
                                        </li>
                                    @endcan

                                </ul>
                            </div>
                        @endif

                    </div>
                </div>
            </div>
        </div>
    </div>
</div><!-- /.container -->
