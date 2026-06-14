<div class="inner-content">
    <div class="header-detail-maker h-60px border d-flex gap-2 align-items-center px-3">

        <a href="javascript:history.go(-1)" class="d-flex align-items-center gap-3">
            <span><i class="fa-solid fa-arrow-left"></i></span>
            <span>DETAIL POST BIDDING</span>
        </a>

        @can('CSMS - Bidding Reviewer OHS')
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
        @endcan

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
                                    <div class="author-name">{{ $maker->name }}</div>
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
                                    {{ $created_at }}
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
                                    {{ $updated_at }}
                                </span>
                            </div>
                        </div><!-- /.review -->
                    </div><!-- /.info-items -->
                </div><!-- /.info -->
            </div><!-- /.detail-left -->

            <div class="col pb-7 border-end border-start border-1">

                <div id="label" class="section border-1 border-bottom p-5">
                    <div class="text-center">
                        <h5 class="mb-0 fw-normal title-accordion">DETAIL POST BIDDING</h5>
                    </div>

                    <div class="wrapper-content-section overflow-hidden position-relative transition-all duration-700">
                        <div class="content-section m-4">
                            <div class="mb-3 mcu-detail-item row">
                                <label class="col-6 opacity-80">CCOW</label>
                                <div class="col-6 content">
                                    <div class="content">{{ $bidding->ccow->company_name }}</div>
                                </div>
                            </div>
                            <div class="mb-3 mcu-detail-item row">
                                <label class="col-6 opacity-80">Jenis Badan Usaha</label>
                                <div class="col-6 content">
                                    <div class="content">{{ $bidding->business_entity->name }}</div>
                                </div>
                            </div>
                            <div class="mb-3 mcu-detail-item row">
                                <label class="col-6 opacity-80">Nama Perusahaan</label>
                                <div class="col-6 content">
                                    <div class="content">{{ $bidding->company_name }}</div>
                                </div>
                            </div>
                            <div class="mb-3 mcu-detail-item row">
                                <label class="col-6 opacity-80">Alamat Perusahaa</label>
                                <div class="col-6 content">
                                    <div class="content">{!! $bidding->address !!}</div>
                                </div>
                            </div>
                            <div class="mb-3 mcu-detail-item row">
                                <label class="col-6 opacity-80">Site Perusahaan</label>
                                <div class="col-6 content">
                                    <div class="content">{!! $bidding->company_site !!}</div>
                                </div>
                            </div>
                            <div class="mb-3 mcu-detail-item row">
                                <label class="col-6 opacity-80">Nomor Ijin Badan Usaha</label>
                                <div class="col-6 content">
                                    <div class="content">{{ $bidding->license_number }}</div>
                                </div>
                            </div>
                            <div class="mb-3 mcu-detail-item row">
                                <label class="col-6 opacity-80">Kriteria Jasa Perusahaan</label>
                                <div class="col-6 content">
                                    <div class="content">{{ $bidding->service_criteria }}</div>
                                </div>
                            </div>

                            @if ($bidding->service_criteria == Modules\CSMS\Enums\ServiceCriteria::SubContractor)
                                <div class="mb-3 mcu-detail-item row">
                                    <label class="col-6 opacity-80">Perusahaan Induk</label>
                                    <div class="col-6 content">
                                        <div class="content">{{ $bidding->parent_company->company_name }}</div>
                                    </div>
                                </div>
                            @endif

                            <div class="mb-3 mcu-detail-item row">
                                <label class="col-6 opacity-80">Penanggungjawab Bidding</label>
                                <div class="col-6 content">
                                    <div class="content">{{ $bidding->person_in_charge }}</div>
                                </div>
                            </div>

                            <hr>
                            {{-- public $questionnaire = [], $company_nickname, $scope_of_business, $contract_period, $number_of_workers, $number_of_spv_pop, $number_of_spv_pom, $number_of_spv_pou, $number_of_spv_imp_smkp, $number_of_spv_auditor_smkp, $equipped_name, $equipped_position, $equipped_telephone, $equipped_email,  $questionnaire_file, $risk_category; --}}

                            <div class="mb-3 mcu-detail-item row">
                                <label class="col-6 opacity-80">Singkatan Nama Perusahaan</label>
                                <div class="col-6 content">
                                    <div class="content">{{ $company_nickname }}</div>
                                </div>
                            </div>
                            <div class="mb-3 mcu-detail-item row">
                                <label class="col-6 opacity-80">Lingkup Usaha/Jasa</label>
                                <div class="col-6 content">
                                    <div class="content">{{ $scope_of_business }}</div>
                                </div>
                            </div>
                            <div class="mb-3 mcu-detail-item row">
                                <label class="col-6 opacity-80">Periode Kontrak</label>
                                <div class="col-6 content">
                                    <div class="content">{{ $contract_period }}</div>
                                </div>
                            </div>
                            <div class="mb-3 mcu-detail-item row">
                                <label class="col-6 opacity-80">Jumlah Pekerja yang bekerja di
                                    Adaro</label>
                                <div class="col-6 content">
                                    <div class="content">{{ $number_of_workers }}</div>
                                </div>
                            </div>
                            <div class="mb-3 mcu-detail-item row">
                                <label class="col-6 opacity-80">Jumlah Pengawas yang Berkompetensi POP</label>
                                <div class="col-6 content">
                                    <div class="content">{{ $number_of_spv_pop }}</div>
                                </div>
                            </div>
                            <div class="mb-3 mcu-detail-item row">
                                <label class="col-6 opacity-80">Jumlah Pengawas yang Berkompetensi POM</label>
                                <div class="col-6 content">
                                    <div class="content">{{ $number_of_spv_pom }}</div>
                                </div>
                            </div>
                            <div class="mb-3 mcu-detail-item row">
                                <label class="col-6 opacity-80">Jumlah Pengawas yang Berkompetensi POU</label>
                                <div class="col-6 content">
                                    <div class="content">{{ $number_of_spv_pou }}</div>
                                </div>
                            </div>
                            <div class="mb-3 mcu-detail-item row">
                                <label class="col-6 opacity-80">Jumlah Pengawas yang Berkompetensi SMKP</label>
                                <div class="col-6 content">
                                    <div class="content">{{ $number_of_spv_imp_smkp }}</div>
                                </div>
                            </div>
                            <div class="mb-3 mcu-detail-item row">
                                <label class="col-6 opacity-80">Jumlah Pengawas yang Berkompetensi Auditor SMKP</label>
                                <div class="col-6 content">
                                    <div class="content">{{ $number_of_spv_auditor_smkp }}</div>
                                </div>
                            </div>
                            <div class="mb-3 mcu-detail-item row">
                                <label class="col-6 opacity-80">Dilengkapi oleh</label>
                                <div class="col-6 content">
                                    <div class="content">{{ $equipped_name }}</div>
                                </div>
                            </div>
                            <div class="mb-3 mcu-detail-item row">
                                <label class="col-6 opacity-80"></label>
                                <div class="col-6 content">
                                    <div class="content">{{ $equipped_position }}</div>
                                </div>
                            </div>
                            <div class="mb-3 mcu-detail-item row">
                                <label class="col-6 opacity-80"></label>
                                <div class="col-6 content">
                                    <div class="content">{{ $equipped_telephone }}</div>
                                </div>
                            </div>
                            <div class="mb-3 mcu-detail-item row">
                                <label class="col-6 opacity-80"></label>
                                <div class="col-6 content">
                                    <div class="content">{{ $equipped_email }}</div>
                                </div>
                            </div>
                            <div class="mb-3 mcu-detail-item row">
                                <label class="col-6 opacity-80">File Scan Kuesioner CSMS</label>
                                <div class="col-6 content">
                                    <div class="content">{{ $questionnaire_file ? $questionnaire_file : '-' }}</div>
                                </div>
                            </div>

                            <div class="mb-3 mcu-detail-item row">
                                <label class="col-6 opacity-80">Kategori
                                    Resiko</label>
                                <div class="col-6 content">
                                    <div class="content">{{ $risk_category }}</div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>


                <div class="text-center">
                    <h5 class="mt-3 mb-0 fw-normal title-accordion">Checklist Post Bidding</h5>
                </div>
                @foreach ($bidding->checklists as $i => $checklist)
                    <div id="{{ $checklist->id }}" class="section border-1 border-bottom p-5">
                        <div class="header-section d-flex justify-content-between w-100 border-0 bg-white my-3 mx-4">
                            <h6 class="mb-0 fw-normal">{{ $checklist->crtiteria }}</h6>
                        </div>

                        <div
                            class="wrapper-content-section overflow-hidden position-relative transition-all duration-700">

                            @if ($checklist->value == 'Ya')
                                <div class="content-section m-4 text-success">
                                @else
                                    <div class="content-section m-4 text-danger">
                            @endif
                            <div class="mb-3 mcu-detail-item row">
                                <label class="col-9 opacity-80">{!! $checklist->legal_base !!}</label>
                                <br>
                                <br>
                                <label class="col-9 opacity-80">{!! $checklist->note !!}</label>

                                <div class="col-3 content">
                                    <div class="content">Nilai :
                                        {{ isset($checklist->value) ? $checklist->value : '-' }}</div>
                                    {{-- @if ($checklist->value != 'Ya')
                                        <div class="content">
                                            <a class="btn btn-sm btn-outline-primary" href="#" target="_blank"><i class="fa fa-file"></i>
                                                Link File
                                            </a>
                                        </div>
                                        <div class="content">Catatan :
                                            <pre>{!! $checklist->comment !!}</pre>
                                        </div>
                                    @endif --}}
                                </div>
                            </div>
                        </div>
                    </div>

            </div>
            @endforeach

            {{-- <div id="summary" class="section border-1 border-bottom p-5">
                <div class="header-section text-center">
                    <h6 class="mb-0 fw-normal title-accordion">RINGKASAN HASIL INSPEKSI</h6>
                </div>
                <hr>

                <div class="wrapper-content-section overflow-hidden position-relative transition-all duration-700">
                    <div class="content-section m-4">
                        <div class="mb-3 mcu-detail-item row">
                            <div class="col-12 content">
                                <div class="content">{!! $bidding->id !!}</div>
                            </div>
                        </div>

                    </div>
                </div>
            </div> --}}
        </div>

    </div><!-- /.row -->


    <div id="action" class="section-action border-1 border-bottom p-5">
        <div class="wrapper-content-section overflow-hidden position-relative transition-all duration-700">
            <div class="content-section m-4">
                <div class="footer-action mb-2 align-center">
                    <div class="action-wrapper d-flex align-items-center justify-content-end gap-2 mb-5">

                        <a href="javascript:history.go(-1)" class="btn btn-outline-secondary">Cancel</a>

                        @if (auth()->user()->can('CSMS - Bidding Reviewer OHS') ||
                                auth()->user()->can('CSMS - Bidding Reviewer D/H OHS') ||
                                auth()->user()->can('CSMS - Bidding Reviewer KTT'))
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

                                    @can('CSMS - Bidding Reviewer OHS')
                                        <li>
                                            <button type="button"
                                                wire:click="approve('{{ App\Enums\CSMS\CsmsStatus::OnReviewDHOHS }}', '{{ App\Enums\CSMS\CsmsStatus::Approved }}')"
                                                class="dropdown-item" href="#">
                                                Submit to DH OHS
                                            </button>
                                        </li>
                                    @endcan
                                    @can('CSMS - Bidding Reviewer D/H OHS')
                                        <li>
                                            <button type="button"
                                                wire:click="approve('{{ App\Enums\CSMS\CsmsStatus::OnReviewKTT }}', '{{ App\Enums\CSMS\CsmsStatus::Approved }}')"
                                                class="dropdown-item" href="#">
                                                Submit to KTT
                                            </button>
                                        </li>
                                    @endcan
                                    @can('CSMS - Bidding Reviewer KTT')
                                        <li>
                                            <button type="button"
                                                wire:click="approve('{{ App\Enums\CSMS\CsmsStatus::Approved }}', '{{ App\Enums\CSMS\CsmsStatus::Approved }}')"
                                                class="dropdown-item" href="#">
                                                Approve Post Bidding
                                            </button>
                                        </li>
                                    @endcan

                                </ul>
                            </div>
                        @endif

                        @if ($bidding->status == App\Enums\CSMS\CsmsStatus::Approved)
                            <div class="button-document">
                                <button
                                    class="dropdown-toggle btn btn-outline-default bg-green d-flex justify-content-center align-item-center text-white position-relative px-4"
                                    role="button" data-bs-toggle="dropdown" aria-expanded="true">
                                    More Action
                                </button>
                                <ul class="dropdown-menu">
                                    <li>
                                        <button type="button" wire:click="renewal_bidding()" class="dropdown-item"
                                            href="#">
                                            Renewal Bidding
                                        </button>
                                    </li>
                                    <li>
                                        <button type="button" wire:click="inactive_bidding()" class="dropdown-item"
                                            href="#">
                                            Inactive Bidding
                                        </button>
                                    </li>
                                    <li>
                                        <button type="button" wire:click="obsolete_bidding()" class="dropdown-item"
                                            href="#">
                                            Obsolete Bidding
                                        </button>
                                    </li>
                                </ul>
                            </div>
                        @endif

                        <br>
                        <br>
                        <br>
                        <br>
                        <br>
                        <br>
                        <br>
                        <br>
                        <br>
                        <br>
                        <br>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div><!-- /.container -->

</div>
