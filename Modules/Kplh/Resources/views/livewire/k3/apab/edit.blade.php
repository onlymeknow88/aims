<div class="inner-content">

    <div
        class="header-content-inspeksi-alat h-60px bg-white shadow-sm d-flex gap-2 align-items-center justify-content-between px-3">
        <div class="left-header">
            <a href="javascript:history.go(-1)" class="d-flex align-items-center gap-3">
                <span><i class="fa-solid fa-arrow-left"></i></span>
                <span>Inspeksi Alat K3 - APAB</span>
            </a>
        </div><!-- /.left-header -->
    </div><!-- /.header-content-inspeksi-alat -->

    <div class="content-inspeksi-alat">
        <div class="container">
            <div class="row justify-content-center">

                <div class="col-12 col-md-12 col-lg-8">
                    <form class="py-4 d-flex flex-column gap-5" action="#" action="post"
                        wire:submit.prevent='save'>

                        <div class="title-form text-center my-3">
                            <h4>Inspeksi Alat K3 - APAB</h4>
                        </div><!-- /.title-form -->

                        <div class="content-form d-flex flex-column gap-3">

                            <div id="label" class="section-label" x-data="{ accordionOpen: true }">
                                <button
                                    class="header-accordion d-flex justify-content-between w-100 border-0 bg-white py-3 px-0"
                                    @click.prevent="accordionOpen = ! accordionOpen">
                                    <h6 class="mb-0 fw-normal title-accordion">Label</h6>
                                    <span x-bind:class="accordionOpen ? 'open' : ''"><img
                                            src="{{ asset('/images/icons/angle-down.png') }}" alt="" /></span>
                                </button>
                                <div class="wrapper-content-accordion max-h-0 overflow-hidden position-relative transition-all duration-700"
                                    x-ref="label"
                                    x-bind:style="accordionOpen ? 'max-height: ' + $refs.label.scrollHeight + 'px' : ''"
                                    x-transition.delay.5000ms>

                                    <div class="content-section p-4" wire:ignore.self>

                                        <div class="row mb-3 form-group">
                                            <label for="date" class="col col-form-label">Tanggal
                                                Inspeksi</label>
                                            <div class="col-8">
                                                <x-kplh-datepicker-30d wire:model="date" id="date"
                                                    placeholder="Tanggal Inspeksi" :error="'date'" />
                                            </div>
                                        </div><!-- /.form-group date -->

                                        <div class="row mb-3 form-group">
                                            <label for="ccow_id" class="col col-form-label">CCOW</label>
                                            <div class="col-8">

                                                <x-inputs.select2 id="ccow_id" placeholder="CCOW"
                                                    :error="'ccow_id'" wire:model.defer="ccow_id">
                                                    @foreach ($this->ccows as $index => $item)
                                                        <option value="{{ $item->id }}">
                                                            {{ $item->company_name }}
                                                        </option>
                                                    @endforeach
                                                </x-inputs.select2>

                                            </div>
                                        </div><!-- /.form-group ccow -->

                                        <div class="row mb-3 form-group">
                                            <label for="companyId" class="col col-form-label">Nama
                                                Perusahaan</label>
                                            <div class="col-8">
                                                <x-inputs.select2 wire:model="companyId" id="companyId"
                                                    class="form-select" placeholder="Nama Perusahaan">
                                                    @foreach ($this->companies as $index => $c)
                                                        <option value="{{ $c->id }}">{{ $c->company_name }}
                                                        </option>
                                                    @endforeach
                                                </x-inputs.select2>
                                            </div>
                                        </div><!-- /.form-group companyId -->

                                        <div class="row mb-3 form-group">
                                            <label for="departmentId" class="col col-form-label">Departemen</label>
                                            <div class="col-8">

                                                @if ($ccow_id)
                                                    <x-inputs.select2 wire:model="departmentId" id="departmentId"
                                                        class="form-select" placeholder="Departemen">
                                                        @foreach ($this->departments as $index => $c)
                                                            <option value="{{ $c->id }}">{{ $c->name }}
                                                            </option>
                                                        @endforeach
                                                    </x-inputs.select2>
                                                @else
                                                    <x-inputs.select2 wire:model="departmentId" id="departmentId"
                                                        class="form-select" placeholder="Departemen" disabled>
                                                    </x-inputs.select2>
                                                @endif

                                            </div>
                                        </div><!-- /.form-group departmentId -->

                                        <div class="row mb-3 form-group">
                                            <label for="sectionId" class="col col-form-label">Section</label>
                                            <div class="col-8">
                                                @if ($departmentId)
                                                    <x-inputs.select2 wire:model="sectionId" id="sectionId"
                                                        class="form-select" placeholder="Departemen">
                                                        @foreach ($this->sections as $index => $s)
                                                            <option value="{{ $s->id }}">{{ $s->name }}
                                                            </option>
                                                        @endforeach
                                                    </x-inputs.select2>
                                                @else
                                                    <x-inputs.select2 wire:model="sectionId" id="sectionId"
                                                        class="form-select" placeholder="Departemen" disabled>
                                                    </x-inputs.select2>
                                                @endif
                                            </div>
                                        </div><!-- /.form-group sectionId -->

                                        <div class="row mb-3 form-group">
                                            <label for="area_location_id" class="col col-form-label">Lokasi</label>
                                            <div class="col-8">

                                                <x-inputs.select2 wire:model="area_location_id" id="area_location_id"
                                                    data-child="area_location_id" class="form-select"
                                                    placeholder="Area Lokasi">
                                                    @foreach ($this->areaLocations as $key => $location)
                                                        <option value="{{ $location->id }}">{{ $location->name }}
                                                        </option>
                                                    @endforeach
                                                </x-inputs.select2>

                                            </div>
                                        </div><!-- /.form-group location -->

                                        <div class="row mb-3 form-group">
                                            <label for="detail_location" class="col col-form-label">Detail
                                                Lokasi</label>
                                            <div class="col-8">
                                                <x-inputs.text wire:model="detail_location" id="detail_location"
                                                    placeholder="Detail Lokasi" :error="'detail_location'" />
                                            </div>
                                        </div><!-- /.form-group detail_location -->

                                        <div class="row mb-3 form-group">
                                            <label for="kttId" class="col-lg-4 col-md-12 col-form-label">KTT/PJO</label>
                                            <div class="col-lg-8 col-md-12">
                                                <select wire:model="kttId" id="kttId" class="form-select"
                                                    placeholder="KTT" disabled>
                                                    @if ($companyId)
                                                    <option value="{{ $kttId ?? null }}" selected>
                                                        {{ $company->user->name ?? null }}
                                                    </option>
                                                @endif

                                                </select>
                                            </div>
                                        </div><!-- /.form-group kttId -->

                                        <div class="row mb-3 form-group">
                                            <label for="pjaId"
                                                class="col-lg-4 col-md-12 col-form-label">PJA</label>
                                            <div class="col-lg-8 col-md-12">
                                                <x-inputs.select2 wire:model="pjaId" id="pjaId"
                                                    class="form-select" placeholder="PJA">
                                                    @foreach ($this->areaManagers as $key => $areaManager)
                                                        <option value="{{ $areaManager->id }}">
                                                            {{ $areaManager->user->employee->name ?? null }}
                                                        </option>
                                                    @endforeach
                                                </x-inputs.select2>
                                            </div>
                                        </div><!-- /.form-group pjaId -->

                                        <div class="row mb-3 form-group mb-4">
                                            <label for="inspectionOfficer"
                                                class="col-lg-4 col-md-12 col-form-label">Petugas
                                                Inspeksi</label>
                                            <div class="col-lg-8 col-md-12">

                                                <div class="wrapper_inspectionOfficer d-flex flex-column gap-3">

                                                    <x-kplh-select2 wire:model="inspectionOfficer"
                                                        id="inspectionOfficer" class="form-select"
                                                        placeholder="Petugas Inspeksi" :error="'inspectionOfficer'">
                                                        @foreach ($this->employees as $index => $emp)
                                                            <option value="{{ $emp->id }}">
                                                                {{ $emp->name }}
                                                            </option>
                                                        @endforeach
                                                    </x-kplh-select2>

                                                </div><!-- /.wrapper_petugas -->
                                            </div>
                                        </div><!-- /.form-group inspectionOfficer -->

                                    </div><!-- ./content-label -->
                                </div>
                            </div><!-- /.label -->

                            <div id="apab" class="section-apab" x-data="{ accordionOpen: true }">
                                <button
                                    class="header-accordion d-flex justify-content-between w-100 border-0 bg-white py-3 px-0"
                                    @click.prevent="accordionOpen = ! accordionOpen">
                                    <h6 class="mb-0 fw-normal title-accordion">Inspeksi APAB </h6>
                                    <span x-bind:class="accordionOpen ? 'open' : ''"><img
                                            src="{{ asset('/images/icons/angle-down.png') }}"
                                            alt="" /></span>
                                </button>
                                <div class="wrapper-content-accordion max-h-0 overflow-hidden position-relative transition-all duration-700"
                                    x-ref="apab" x-bind:style="accordionOpen ? 'max-height: ' + 20000 + 'px' : ''"
                                    x-transition.delay.5000ms>

                                    <div class="content-section p-4" wire:ignore.self>

                                        <div class="row mb-3 form-group">
                                            <label for="tool_id" class="col col-form-label">No. ID APAB</label>
                                            <div class="col-8">
                                                <x-inputs.text wire:model="tool_id" id="tool_id"
                                                    placeholder="No. ID APAB" :error="'tool_id'" />
                                            </div>
                                        </div><!-- /.form-group tool_id -->

                                        <div class="row mb-3 form-group">
                                            <label for="tool_date" class="col col-form-label">Tanggal Service
                                                Tabung
                                                Tertera</label>
                                            <div class="col-8">
                                                <x-inputs.datepicker wire:model="tool_date" id="tool_date"
                                                    placeholder="Tanggal Service Tabung Tertera" :error="'tool_date'" />
                                            </div>
                                        </div><!-- /.form-group tool_date -->

                                        <div class="row mb-3 form-group">
                                            <label for="isi_apab" class="col-lg-4 col-md-12 col-form-label">Isi
                                                APAB</label>
                                            <div class="col-lg-8 col-md-12">

                                                <div class="wrapper_isi_apab d-flex flex-column gap-3"
                                                    x-data="{ isi_apab: @entangle('isi_apab') }">

                                                    <x-inputs.select2 wire:model="isi_apab" id="isi_apab"
                                                        class="form-select" placeholder="Isi APAB">
                                                        <option value="Powder">Powder</option>
                                                        <option value="Co2">Co2</option>
                                                        <option value="Water">Water</option>
                                                        <option value="Halon">Halon</option>
                                                        <option value="Foam">Foam</option>
                                                    </x-inputs.select2>

                                                    <div x-cloak x-show="isi_apab">
                                                        <x-kplh-texteditor wire:model="isi_apab_note"
                                                            id="isi_apab_note" placeholder="Komentar Isi"
                                                            :error="'isi_apab_note'" />

                                                        @if ($isi_apab_file && !Illuminate\Support\Str::contains($isi_apab_file, 'private/var/folders/'))
                                                            <div class="row mt-3">
                                                                <div class="col-md-3"><button type="button"
                                                                        class="btn btn-outline-secondary"
                                                                        wire:click="setFileNull('isi_apab_file')"><i
                                                                            class="fa fa-edit"></i> Ubah
                                                                        File</button></div>
                                                                <div class="col-md-9">
                                                                    <a class="btn btn-outline-secondary"
                                                                        href="{{ route('kplh::download-file', ['k3', $isi_apab_file]) }}"
                                                                        target="_blank"><i class="fa fa-file"></i>
                                                                        {{ Illuminate\Support\Str::limit($isi_apab_file, 30) }}</a>
                                                                </div>
                                                            </div>
                                                        @else
                                                            <div class="col-md-12 mt-3">
                                                                <x-kplh-file wire:model="isi_apab_file"
                                                                    id="isi_apab_file" placeholder="File"
                                                                    :error="'isi_apab_file'" />
                                                            </div>
                                                        @endif

                                                    </div>
                                                </div><!-- /.wrapper_isi_apab -->

                                            </div><!-- /.col-lg-12 -->

                                        </div><!-- /.form-group isi_apab -->

                                        <div class="row mb-3 form-group">
                                            <label for="gol_apab" class="col-lg-4 col-md-12 col-form-label">Golongan
                                                APAB</label>
                                            <div class="col-lg-8 col-md-12">

                                                <div class="wrapper_inspeksi d-flex flex-column gap-3"
                                                    x-data="{ gol_apab: @entangle('gol_apab') }">

                                                    <x-inputs.select2 wire:model="gol_apab" id="gol_apab"
                                                        class="form-select" placeholder="Golongan APAB">
                                                        <option value="a">A</option>
                                                        <option value="b">B</option>
                                                        <option value="c">C</option>
                                                        <option value="abc">A+B+C</option>
                                                        <option value="na">N/A</option>
                                                    </x-inputs.select2>

                                                    <div x-cloak x-show="gol_apab">
                                                        <x-kplh-texteditor wire:model="gol_apab_note"
                                                            id="gol_apab_note" placeholder="Komentar Golongan APAB"
                                                            :error="'gol_apab_note'" />

                                                        @if ($gol_apab_file && !Illuminate\Support\Str::contains($gol_apab_file, 'private/var/folders/'))
                                                            <div class="row mt-3">
                                                                <div class="col-md-3"><button type="button"
                                                                        class="btn btn-outline-secondary"
                                                                        wire:click="setFileNull('gol_apab_file')"><i
                                                                            class="fa fa-edit"></i> Ubah
                                                                        File</button></div>
                                                                <div class="col-md-9">
                                                                    <a class="btn btn-outline-secondary"
                                                                        href="{{ route('kplh::download-file', ['k3', $gol_apab_file]) }}"
                                                                        target="_blank"><i class="fa fa-file"></i>
                                                                        {{ Illuminate\Support\Str::limit($gol_apab_file, 30) }}</a>
                                                                </div>
                                                            </div>
                                                        @else
                                                            <div class="col-md-12 mt-3">
                                                                <x-kplh-file wire:model="gol_apab_file"
                                                                    id="gol_apab_file" placeholder="File"
                                                                    :error="'gol_apab_file'" />
                                                            </div>
                                                        @endif

                                                    </div>
                                                </div><!-- /.wrapper_inspeksi -->

                                            </div><!-- /.col-lg-12 -->

                                        </div><!-- /.form-group gol_apab -->

                                        <div class="row mb-3 form-group">
                                            <label for="kapasitas_apab"
                                                class="col-lg-4 col-md-12 col-form-label">Kapasitas
                                                APAB</label>
                                            <div class="col-lg-8 col-md-12">

                                                <div class="wrapper_inspeksi d-flex flex-column gap-3"
                                                    x-data="{ kapasitas_apab: @entangle('kapasitas_apab') }">

                                                    <x-inputs.select2 wire:model="kapasitas_apab" id="kapasitas_apab"
                                                        class="form-select" placeholder="Kapasitas APAB">
                                                        <option value="25">25KG</option>
                                                        <option value="30">30KG</option>
                                                    </x-inputs.select2>

                                                    <div x-cloak x-show="kapasitas_apab">
                                                        <x-kplh-texteditor wire:model="kapasitas_apab_note"
                                                            id="kapasitas_apab_note"
                                                            placeholder="Komentar Kapasitas APAB" :error="'kapasitas_apab_note'" />

                                                        @if ($kapasitas_apab_file && !Illuminate\Support\Str::contains($kapasitas_apab_file, 'private/var/folders/'))
                                                            <div class="row mt-3">
                                                                <div class="col-md-3"><button type="button"
                                                                        class="btn btn-outline-secondary"
                                                                        wire:click="setFileNull('kapasitas_apab_file')"><i
                                                                            class="fa fa-edit"></i> Ubah
                                                                        File</button></div>
                                                                <div class="col-md-9">
                                                                    <a class="btn btn-outline-secondary"
                                                                        href="{{ route('kplh::download-file', ['k3', $kapasitas_apab_file]) }}"
                                                                        target="_blank"><i class="fa fa-file"></i>
                                                                        {{ Illuminate\Support\Str::limit($kapasitas_apab_file, 30) }}</a>
                                                                </div>
                                                            </div>
                                                        @else
                                                            <div class="col-md-12 mt-3">
                                                                <x-kplh-file wire:model="kapasitas_apab_file"
                                                                    id="kapasitas_apab_file" placeholder="File"
                                                                    :error="'kapasitas_apab_file'" />
                                                            </div>
                                                        @endif

                                                    </div>
                                                </div><!-- /.wrapper_inspeksi -->

                                            </div><!-- /.col-lg-12 -->

                                        </div><!-- /.form-group kapasitas_apab -->

                                        <div class="row mb-3 form-group">
                                            <label for="tuas_apab" class="col-lg-4 col-md-12 col-form-label">Tuas
                                                APAB</label>
                                            <div class="col-lg-8 col-md-12">

                                                <div class="wrapper_inspeksi d-flex flex-column gap-3"
                                                    x-data="{ tuas_apab: @entangle('tuas_apab') }">

                                                    <x-inputs.select2 wire:model="tuas_apab" id="tuas_apab"
                                                        placeholder="Tuas APAB">
                                                        <option value="Standard">Standard</option>
                                                        <option value="Tidak Standard">Tidak Standard</option>
                                                    </x-inputs.select2>

                                                    <div x-cloak x-show="tuas_apab === 'Tidak Standard'">
                                                        <x-inputs.select2 wire:model="tuas_apab_2" id="tuas_apab_2"
                                                            placeholder="Kondisi Tuas APAB">
                                                            <option value="Berkarat">Berkarat</option>
                                                            <option value="rusak">Rusak</option>
                                                            <option value="lainnya">Lainnya</option>
                                                        </x-inputs.select2>
                                                        <br>
                                                        <x-kplh-texteditor wire:model="tuas_apab_note"
                                                            id="tuas_apab_note" placeholder="Komentar Tuas APAB"
                                                            :error="'tuas_apab_note'">
                                                        </x-kplh-texteditor>

                                                        @if ($tuas_apab_file && !Illuminate\Support\Str::contains($tuas_apab_file, 'private/var/folders/'))
                                                            <div class="row mt-3">
                                                                <div class="col-md-3"><button type="button"
                                                                        class="btn btn-outline-secondary"
                                                                        wire:click="setFileNull('tuas_apab_file')"><i
                                                                            class="fa fa-edit"></i> Ubah
                                                                        File</button></div>
                                                                <div class="col-md-9">
                                                                    <a class="btn btn-outline-secondary"
                                                                        href="{{ route('kplh::download-file', ['k3', $tuas_apab_file]) }}"
                                                                        target="_blank"><i class="fa fa-file"></i>
                                                                        {{ Illuminate\Support\Str::limit($tuas_apab_file, 30) }}</a>
                                                                </div>
                                                            </div>
                                                        @else
                                                            <div class="col-md-12 mt-3">
                                                                <x-kplh-file wire:model="tuas_apab_file"
                                                                    id="tuas_apab_file" placeholder="File"
                                                                    :error="'tuas_apab_file'" />
                                                            </div>
                                                        @endif

                                                    </div>
                                                </div><!-- /.wrapper_inspeksi -->

                                            </div><!-- /.col-lg-12 -->

                                        </div><!-- /.form-group tuas_apab -->

                                        <div class="row mb-3 form-group">
                                            <label for="handle_apab" class="col-lg-4 col-md-12 col-form-label">Handle
                                                APAB</label>
                                            <div class="col-lg-8 col-md-12">

                                                <div class="wrapper_inspeksi d-flex flex-column gap-3"
                                                    x-data="{ handle_apab: @entangle('handle_apab') }"">

                                                    <x-inputs.select2 wire:model="handle_apab" id="handle_apab"
                                                        class="form-select" placeholder="Handle APAB">
                                                        <option value="Standard">Standard</option>
                                                        <option value="Tidak Standard">Tidak Standard</option>
                                                    </x-inputs.select2>

                                                    <div x-cloak x-show="handle_apab === 'Tidak Standard'">
                                                        <x-inputs.select2 wire:model="handle_apab_2"
                                                            id="handle_apab_2" class="form-select"
                                                            placeholder="Kondisi Handle APAB">
                                                            <option value="Berkarat">Berkarat</option>
                                                            <option value="rusak">Rusak</option>
                                                            <option value="lainnya">Lainnya</option>
                                                        </x-inputs.select2>
                                                        <br>
                                                        <x-kplh-texteditor wire:model="handle_apab_note"
                                                            id="handle_apab_note" placeholder="Komentar Handle APAB"
                                                            :error="'handle_apab_note'" />

                                                        @if ($handle_apab_file && !Illuminate\Support\Str::contains($handle_apab_file, 'private/var/folders/'))
                                                            <div class="row mt-3">
                                                                <div class="col-md-3"><button type="button"
                                                                        class="btn btn-outline-secondary"
                                                                        wire:click="setFileNull('handle_apab_file')"><i
                                                                            class="fa fa-edit"></i> Ubah
                                                                        File</button></div>
                                                                <div class="col-md-9">
                                                                    <a class="btn btn-outline-secondary"
                                                                        href="{{ route('kplh::download-file', ['k3', $handle_apab_file]) }}"
                                                                        target="_blank"><i class="fa fa-file"></i>
                                                                        {{ Illuminate\Support\Str::limit($handle_apab_file, 30) }}</a>
                                                                </div>
                                                            </div>
                                                        @else
                                                            <div class="col-md-12 mt-3">
                                                                <x-kplh-file wire:model="handle_apab_file"
                                                                    id="handle_apab_file" placeholder="File"
                                                                    :error="'handle_apab_file'" />
                                                            </div>
                                                        @endif

                                                    </div>

                                                </div><!-- /.wrapper_inspeksi -->

                                            </div><!-- /.col-lg-12 -->

                                        </div><!-- /.form-group tuas_apab -->

                                        <div class="row mb-3 form-group">
                                            <label for="pressure_gauge"
                                                class="col-lg-4 col-md-12 col-form-label">Pressure
                                                Gauge</label>
                                            <div class="col-lg-8 col-md-12">

                                                <div class="wrapper_inspeksi d-flex flex-column gap-3"
                                                    x-data="{ pressure_gauge: @entangle('pressure_gauge') }">

                                                    <x-inputs.select2 wire:model="pressure_gauge" id="pressure_gauge"
                                                        class="form-select" placeholder="Pressure Gauge">
                                                        <option value="Standard">Standard</option>
                                                        <option value="Tidak Standard">Tidak Standard</option>
                                                    </x-inputs.select2>

                                                    <div x-cloak x-show="pressure_gauge === 'Tidak Standard'">
                                                        <x-inputs.select2 wire:model="pressure_gauge_2"
                                                            id="pressure_gauge_2" class="form-select"
                                                            placeholder="Kondisi Pressure Gauge">
                                                            <option value="low">Low Pressure</option>
                                                            <option value="over">Over pressure</option>
                                                        </x-inputs.select2>
                                                        <br>
                                                        <x-kplh-texteditor wire:model="pressure_gauge_note"
                                                            id="pressure_gauge_note"
                                                            placeholder="Komentar Pressure Gauge" :error="'pressure_gauge_note'" />

                                                        @if ($pressure_gauge_file && !Illuminate\Support\Str::contains($pressure_gauge_file, 'private/var/folders/'))
                                                            <div class="row mt-3">
                                                                <div class="col-md-3"><button type="button"
                                                                        class="btn btn-outline-secondary"
                                                                        wire:click="setFileNull('pressure_gauge_file')"><i
                                                                            class="fa fa-edit"></i> Ubah
                                                                        File</button></div>
                                                                <div class="col-md-9">
                                                                    <a class="btn btn-outline-secondary"
                                                                        href="{{ route('kplh::download-file', ['k3', $pressure_gauge_file]) }}"
                                                                        target="_blank"><i class="fa fa-file"></i>
                                                                        {{ Illuminate\Support\Str::limit($pressure_gauge_file, 30) }}</a>
                                                                </div>
                                                            </div>
                                                        @else
                                                            <div class="col-md-12 mt-3">
                                                                <x-kplh-file wire:model="pressure_gauge_file"
                                                                    id="pressure_gauge_file" placeholder="File"
                                                                    :error="'pressure_gauge_file'" />
                                                            </div>
                                                        @endif

                                                    </div>
                                                </div><!-- /.wrapper_inspeksi -->

                                            </div><!-- /.col-lg-12 -->

                                        </div><!-- /.form-group pressure_gauge -->

                                        <div class="row mb-3 form-group">
                                            <label for="pin_apab" class="col-lg-4 col-md-12 col-form-label">Pin
                                                APAB</label>
                                            <div class="col-lg-8 col-md-12">

                                                <div class="wrapper_inspeksi d-flex flex-column gap-3"
                                                    x-data="{ pin_apab: @entangle('pin_apab') }">

                                                    <x-inputs.select2 wire:model="pin_apab" id="pin_apab"
                                                        class="form-select" placeholder="PIN APAB">
                                                        <option value="Standard">Standard</option>
                                                        <option value="Tidak Standard">Tidak Standard</option>
                                                    </x-inputs.select2>

                                                    <div x-cloak x-show="pin_apab === 'Tidak Standard'">
                                                        <x-inputs.select2 wire:model="pin_apab_2" id="pin_apab_2"
                                                            class="form-select" placeholder="Kondisi PIN APAB">
                                                            <option value="Terlepas">Terlepas</option>
                                                            <option value="Berkarat">Berkarat</option>
                                                            <option value="Hilang">Hilang</option>
                                                        </x-inputs.select2>
                                                        <br>
                                                        <x-kplh-texteditor wire:model="pin_apab_note"
                                                            id="pin_apab_note" placeholder="Komentar PIN APAB"
                                                            :error="'pin_apab_note'" />

                                                        @if ($pin_apab_file && !Illuminate\Support\Str::contains($pin_apab_file, 'private/var/folders/'))
                                                            <div class="row mt-3">
                                                                <div class="col-md-3"><button type="button"
                                                                        class="btn btn-outline-secondary"
                                                                        wire:click="setFileNull('pin_apab_file')"><i
                                                                            class="fa fa-edit"></i> Ubah
                                                                        File</button></div>
                                                                <div class="col-md-9">
                                                                    <a class="btn btn-outline-secondary"
                                                                        href="{{ route('kplh::download-file', ['k3', $pin_apab_file]) }}"
                                                                        target="_blank"><i class="fa fa-file"></i>
                                                                        {{ Illuminate\Support\Str::limit($pin_apab_file, 30) }}</a>
                                                                </div>
                                                            </div>
                                                        @else
                                                            <div class="col-md-12 mt-3">
                                                                <x-kplh-file wire:model="pin_apab_file"
                                                                    id="pin_apab_file" placeholder="File"
                                                                    :error="'pin_apab_file'" />
                                                            </div>
                                                        @endif

                                                    </div>
                                                </div><!-- /.wrapper_inspeksi -->

                                            </div><!-- /.col-lg-12 -->

                                        </div><!-- /.form-group pin_apab -->

                                        <div class="row mb-3 form-group">
                                            <label for="hose_apab" class="col-lg-4 col-md-12 col-form-label">Hose
                                                APAB</label>
                                            <div class="col-lg-8 col-md-12">

                                                <div class="wrapper_inspeksi d-flex flex-column gap-3"
                                                    x-data="{ hose_apab: @entangle('hose_apab') }">

                                                    <x-inputs.select2 wire:model="hose_apab" id="hose_apab"
                                                        class="form-select" placeholder="Hose APAB">
                                                        <option value="Standard">Standard</option>
                                                        <option value="Tidak Standard">Tidak Standard</option>
                                                    </x-inputs.select2>

                                                    <div x-cloak x-show="hose_apab === 'Tidak Standard'">
                                                        <x-inputs.select2 wire:model="hose_apab_2" id="hose_apab_2"
                                                            class="form-select" placeholder="Kondisi Hose APAB">
                                                            <option value="Robek">Robek</option>
                                                            <option value="Rusak">Rusak</option>
                                                            <option value="Hilang">Hilang</option>
                                                        </x-inputs.select2>
                                                        <br>
                                                        <x-kplh-texteditor wire:model="hose_apab_note"
                                                            id="hose_apab_note" placeholder="Komentar Hose APAB"
                                                            :error="'hose_apab_note'" />

                                                        @if ($hose_apab_file && !Illuminate\Support\Str::contains($hose_apab_file, 'private/var/folders/'))
                                                            <div class="row mt-3">
                                                                <div class="col-md-3"><button type="button"
                                                                        class="btn btn-outline-secondary"
                                                                        wire:click="setFileNull('hose_apab_file')"><i
                                                                            class="fa fa-edit"></i> Ubah
                                                                        File</button></div>
                                                                <div class="col-md-9">
                                                                    <a class="btn btn-outline-secondary"
                                                                        href="{{ route('kplh::download-file', ['k3', $hose_apab_file]) }}"
                                                                        target="_blank"><i class="fa fa-file"></i>
                                                                        {{ Illuminate\Support\Str::limit($hose_apab_file, 30) }}</a>
                                                                </div>
                                                            </div>
                                                        @else
                                                            <div class="col-md-12 mt-3">
                                                                <x-kplh-file wire:model="hose_apab_file"
                                                                    id="hose_apab_file" placeholder="File"
                                                                    :error="'hose_apab_file'" />
                                                            </div>
                                                        @endif

                                                    </div>
                                                </div><!-- /.wrapper_inspeksi -->

                                            </div><!-- /.col-lg-12 -->

                                        </div><!-- /.form-group hose_apab -->

                                        <div class="row mb-3 form-group">
                                            <label for="nozzle_apab" class="col-lg-4 col-md-12 col-form-label">Nozzle
                                                APAB</label>
                                            <div class="col-lg-8 col-md-12">

                                                <div class="wrapper_inspeksi d-flex flex-column gap-3"
                                                    x-data="{ nozzle_apab: @entangle('nozzle_apab') }">

                                                    <x-inputs.select2 wire:model="nozzle_apab" id="nozzle_apab"
                                                        class="form-select" placeholder="Nozzle APAB">
                                                        <option value="Standard">Standard</option>
                                                        <option value="Tidak Standard">Tidak Standard</option>
                                                    </x-inputs.select2>

                                                    <div x-cloak x-show="nozzle_apab === 'Tidak Standard'">
                                                        <x-inputs.select2 wire:model="nozzle_apab_2"
                                                            id="nozzle_apab_2" class="form-select"
                                                            placeholder="Kondisi Nozzle APAB">
                                                            <option value="Buntu">Buntu</option>
                                                            <option value="Pecah">Pecah</option>
                                                            <option value="Rusak">Rusak</option>
                                                            <option value="Hilang">Hilang</option>
                                                            <option value="Lainnya">Lainnya</option>
                                                        </x-inputs.select2>
                                                        <br>
                                                        <x-kplh-texteditor wire:model="nozzle_apab_note"
                                                            id="nozzle_apab_note" placeholder="Komentar Nozzle APAB"
                                                            :error="'nozzle_apab_note'" />

                                                        @if ($nozzle_apab_file && !Illuminate\Support\Str::contains($nozzle_apab_file, 'private/var/folders/'))
                                                            <div class="row mt-3">
                                                                <div class="col-md-3"><button type="button"
                                                                        class="btn btn-outline-secondary"
                                                                        wire:click="setFileNull('nozzle_apab_file')"><i
                                                                            class="fa fa-edit"></i> Ubah
                                                                        File</button></div>
                                                                <div class="col-md-9">
                                                                    <a class="btn btn-outline-secondary"
                                                                        href="{{ route('kplh::download-file', ['k3', $nozzle_apab_file]) }}"
                                                                        target="_blank"><i class="fa fa-file"></i>
                                                                        {{ Illuminate\Support\Str::limit($nozzle_apab_file, 30) }}</a>
                                                                </div>
                                                            </div>
                                                        @else
                                                            <div class="col-md-12 mt-3">
                                                                <x-kplh-file wire:model="nozzle_apab_file"
                                                                    id="nozzle_apab_file" placeholder="File"
                                                                    :error="'nozzle_apab_file'" />
                                                            </div>
                                                        @endif

                                                    </div>
                                                </div><!-- /.wrapper_inspeksi -->

                                            </div><!-- /.col-lg-12 -->

                                        </div><!-- /.form-group nozzle_apab -->

                                        <div class="row mb-3 form-group">
                                            <label for="kondisi_tabung"
                                                class="col-lg-4 col-md-12 col-form-label">Kondisi
                                                tabung/cylinder APAB</label>
                                            <div class="col-lg-8 col-md-12">

                                                <div class="wrapper_inspeksi d-flex flex-column gap-3"
                                                    x-data="{ kondisi_tabung: @entangle('kondisi_tabung') }">

                                                    <x-inputs.select2 wire:model="kondisi_tabung" id="kondisi_tabung"
                                                        class="form-select"
                                                        placeholder="Kondisi tabung/cylinder APAB">
                                                        <option value="Standard">Standard</option>
                                                        <option value="Tidak Standard">Tidak Standard</option>
                                                    </x-inputs.select2>

                                                    <div x-cloak x-show="kondisi_tabung === 'Tidak Standard'">
                                                        <x-inputs.select2 wire:model="kondisi_tabung_2"
                                                            id="kondisi_tabung_2" class="form-select"
                                                            placeholder="Kondisi tabung/cylinder">
                                                            <option value="Berkarat">Berkarat</option>
                                                            <option value="Penyok">Penyok</option>
                                                            <option value="Rusak">Rusak</option>
                                                            <option value="Lainnya">Lainnya</option>
                                                        </x-inputs.select2>
                                                        <br>
                                                        <x-kplh-texteditor wire:model="kondisi_tabung_note"
                                                            id="kondisi_tabung_note"
                                                            placeholder="Komentar Kondisi tabung/cylinder APAB"
                                                            :error="'kondisi_tabung_note'" />

                                                        @if ($kondisi_tabung_file && !Illuminate\Support\Str::contains($kondisi_tabung_file, 'private/var/folders/'))
                                                            <div class="row mt-3">
                                                                <div class="col-md-3"><button type="button"
                                                                        class="btn btn-outline-secondary"
                                                                        wire:click="setFileNull('kondisi_tabung_file')"><i
                                                                            class="fa fa-edit"></i> Ubah
                                                                        File</button></div>
                                                                <div class="col-md-9">
                                                                    <a class="btn btn-outline-secondary"
                                                                        href="{{ route('kplh::download-file', ['k3', $kondisi_tabung_file]) }}"
                                                                        target="_blank"><i class="fa fa-file"></i>
                                                                        {{ Illuminate\Support\Str::limit($kondisi_tabung_file, 30) }}</a>
                                                                </div>
                                                            </div>
                                                        @else
                                                            <div class="col-md-12 mt-3">
                                                                <x-kplh-file wire:model="kondisi_tabung_file"
                                                                    id="kondisi_tabung_file" placeholder="File"
                                                                    :error="'kondisi_tabung_file'" />
                                                            </div>
                                                        @endif

                                                    </div>
                                                </div><!-- /.wrapper_inspeksi -->

                                            </div><!-- /.col-lg-12 -->

                                        </div><!-- /.form-group kondisi_tabung -->

                                        <div class="row mb-3 form-group">
                                            <label for="troli_apab" class="col-lg-4 col-md-12 col-form-label">Troli
                                                APAB</label>
                                            <div class="col-lg-8 col-md-12">

                                                <div class="wrapper_inspeksi d-flex flex-column gap-3"
                                                    x-data="{ troli_apab: @entangle('troli_apab') }">

                                                    <x-inputs.select2 wire:model="troli_apab" id="troli_apab"
                                                        class="form-select" placeholder="Kondisi Troli APAB">
                                                        <option value="Standard">Standard</option>
                                                        <option value="Tidak Standard">Tidak Standard</option>
                                                    </x-inputs.select2>

                                                    <div x-cloak x-show="troli_apab === 'Tidak Standard'">
                                                        <x-inputs.select2 wire:model="troli_apab_2" id="troli_apab_2"
                                                            class="form-select" placeholder="Kondisi tabung/cylinder">
                                                            <option value="rusak">Roda Rusak</option>
                                                            <option value="Berkarat">Troli dan Roda Berkarat</option>
                                                            <option value="lainnya">Lainnya</option>
                                                        </x-inputs.select2>
                                                        <br>
                                                        <x-kplh-texteditor wire:model="troli_apab_note"
                                                            id="troli_apab_note"
                                                            placeholder="Komentar Kondisi Troli APAB"
                                                            :error="'troli_apab_note'" />

                                                        @if ($troli_apab_file && !Illuminate\Support\Str::contains($troli_apab_file, 'private/var/folders/'))
                                                            <div class="row mt-3">
                                                                <div class="col-md-3"><button type="button"
                                                                        class="btn btn-outline-secondary"
                                                                        wire:click="setFileNull('troli_apab_file')"><i
                                                                            class="fa fa-edit"></i> Ubah
                                                                        File</button></div>
                                                                <div class="col-md-9">
                                                                    <a class="btn btn-outline-secondary"
                                                                        href="{{ route('kplh::download-file', ['k3', $troli_apab_file]) }}"
                                                                        target="_blank"><i class="fa fa-file"></i>
                                                                        {{ Illuminate\Support\Str::limit($troli_apab_file, 30) }}</a>
                                                                </div>
                                                            </div>
                                                        @else
                                                            <div class="col-md-12 mt-3">
                                                                <x-kplh-file wire:model="troli_apab_file"
                                                                    id="troli_apab_file" placeholder="File"
                                                                    :error="'troli_apab_file'" />
                                                            </div>
                                                        @endif

                                                    </div>
                                                </div><!-- /.wrapper_inspeksi -->

                                            </div><!-- /.col-lg-12 -->

                                        </div><!-- /.form-group troli_apab -->

                                        <div class="row mb-3 form-group">
                                            <label for="cat_tabung" class="col-lg-4 col-md-12 col-form-label">Kondisi
                                                Cat Tabung
                                                APAB</label>
                                            <div class="col-lg-8 col-md-12">

                                                <div class="wrapper_inspeksi d-flex flex-column gap-3"
                                                    x-data="{ cat_tabung: @entangle('cat_tabung') }">

                                                    <x-inputs.select2 wire:model="cat_tabung" id="cat_tabung"
                                                        class="form-select" placeholder="Cat Tabung">
                                                        <option value="Standard">Standard</option>
                                                        <option value="Tidak Standard">Tidak Standard</option>
                                                    </x-inputs.select2>

                                                    <div x-cloak x-show="cat_tabung === 'Tidak Standard'">
                                                        <x-inputs.select2 wire:model="cat_tabung_2" id="cat_tabung_2"
                                                            class="form-select" placeholder="Kondisi Cat Tabung">
                                                            <option value="Warna Pudar">Warna Pudar</option>
                                                            <option value="Bukan Warna Merah">Bukan Warna Merah
                                                            </option>
                                                        </x-inputs.select2>
                                                        <br>
                                                        <x-kplh-texteditor wire:model="cat_tabung_note"
                                                            id="cat_tabung_note" placeholder="Komentar Cat Tabung"
                                                            :error="'cat_tabung_note'" />

                                                        @if ($cat_tabung_file && !Illuminate\Support\Str::contains($cat_tabung_file, 'private/var/folders/'))
                                                            <div class="row mt-3">
                                                                <div class="col-md-3"><button type="button"
                                                                        class="btn btn-outline-secondary"
                                                                        wire:click="setFileNull('cat_tabung_file')"><i
                                                                            class="fa fa-edit"></i> Ubah
                                                                        File</button></div>
                                                                <div class="col-md-9">
                                                                    <a class="btn btn-outline-secondary"
                                                                        href="{{ route('kplh::download-file', ['k3', $cat_tabung_file]) }}"
                                                                        target="_blank"><i class="fa fa-file"></i>
                                                                        {{ Illuminate\Support\Str::limit($cat_tabung_file, 30) }}</a>
                                                                </div>
                                                            </div>
                                                        @else
                                                            <div class="col-md-12 mt-3">
                                                                <x-kplh-file wire:model="cat_tabung_file"
                                                                    id="cat_tabung_file" placeholder="File"
                                                                    :error="'cat_tabung_file'" />
                                                            </div>
                                                        @endif

                                                    </div>
                                                </div><!-- /.wrapper_inspeksi -->

                                            </div><!-- /.col-lg-12 -->

                                        </div><!-- /.form-group cat_tabung -->

                                        <div class="row mb-3 form-group">
                                            <label for="powder" class="col-lg-4 col-md-12 col-form-label">Kondisi
                                                Powder
                                                APAB</label>
                                            <div class="col-lg-8 col-md-12">

                                                <div class="wrapper_inspeksi d-flex flex-column gap-3"
                                                    x-data="{ powder: @entangle('powder') }">

                                                    <x-inputs.select2 wire:model="powder" id="powder"
                                                        class="form-select" placeholder="Powder">
                                                        <option value="Standard">Standard</option>
                                                        <option value="Tidak Standard">Tidak Standard</option>
                                                    </x-inputs.select2>

                                                    <div x-cloak x-show="powder === 'Tidak Standard'">
                                                        <x-inputs.select2 wire:model="powder_2" id="powder_2"
                                                            class="form-select" placeholder="Kondisi Powder">
                                                            <option value="Beku">Beku</option>
                                                            <option value="Lainnya">Lainnya</option>
                                                        </x-inputs.select2>
                                                        <br>
                                                        <x-kplh-texteditor wire:model="powder_note" id="powder_note"
                                                            placeholder="Komentar Powder" :error="'powder_note'" />

                                                        @if ($powder_file && !Illuminate\Support\Str::contains($powder_file, 'private/var/folders/'))
                                                            <div class="row mt-3">
                                                                <div class="col-md-3"><button type="button"
                                                                        class="btn btn-outline-secondary"
                                                                        wire:click="setFileNull('powder_file')"><i
                                                                            class="fa fa-edit"></i> Ubah
                                                                        File</button></div>
                                                                <div class="col-md-9">
                                                                    <a class="btn btn-outline-secondary"
                                                                        href="{{ route('kplh::download-file', ['k3', $powder_file]) }}"
                                                                        target="_blank"><i class="fa fa-file"></i>
                                                                        {{ Illuminate\Support\Str::limit($powder_file, 30) }}</a>
                                                                </div>
                                                            </div>
                                                        @else
                                                            <div class="col-md-12 mt-3">
                                                                <x-kplh-file wire:model="powder_file" id="powder_file"
                                                                    placeholder="File" :error="'powder_file'" />
                                                            </div>
                                                        @endif

                                                    </div>
                                                </div><!-- /.wrapper_inspeksi -->

                                            </div><!-- /.col-lg-12 -->

                                        </div><!-- /.form-group powder -->

                                        <div class="row mb-3 form-group">
                                            <label for="kip" class="col-lg-4 col-md-12 col-form-label">KIP
                                                (Kartu
                                                Inspeksi
                                                Peralatan)</label>
                                            <div class="col-lg-8 col-md-12">

                                                <div class="wrapper_inspeksi d-flex flex-column gap-3"
                                                    x-data="{ kip: @entangle('kip') }">

                                                    <x-inputs.select2 wire:model="kip" id="kip"
                                                        class="form-select" placeholder="KIP">
                                                        <option value="Standard">Standard</option>
                                                        <option value="Tidak Standard">Tidak Standard</option>
                                                    </x-inputs.select2>

                                                    <div x-cloak x-show="kip === 'Tidak Standard'">
                                                        <x-inputs.select2 wire:model="kip_2" id="kip_2"
                                                            class="form-select" placeholder="Kondisi KIP">
                                                            <option value="Belum Diperiksa">Belum Diperiksa</option>
                                                            <option value="Hilang">Hilang</option>
                                                            <option value="Rusak">Rusak</option>
                                                        </x-inputs.select2>
                                                        <br>
                                                        <x-kplh-texteditor wire:model="kip_note" id="kip_note"
                                                            placeholder="Komentar KIP" :error="'kip_note'" />

                                                        @if ($kip_file && !Illuminate\Support\Str::contains($kip_file, 'private/var/folders/'))
                                                            <div class="row mt-3">
                                                                <div class="col-md-3"><button type="button"
                                                                        class="btn btn-outline-secondary"
                                                                        wire:click="setFileNull('kip_file')"><i
                                                                            class="fa fa-edit"></i> Ubah
                                                                        File</button></div>
                                                                <div class="col-md-9">
                                                                    <a class="btn btn-outline-secondary"
                                                                        href="{{ route('kplh::download-file', ['k3', $kip_file]) }}"
                                                                        target="_blank"><i class="fa fa-file"></i>
                                                                        {{ Illuminate\Support\Str::limit($kip_file, 30) }}</a>
                                                                </div>
                                                            </div>
                                                        @else
                                                            <div class="col-md-12 mt-3">
                                                                <x-kplh-file wire:model="kip_file" id="kip_file"
                                                                    placeholder="File" :error="'kip_file'" />
                                                            </div>
                                                        @endif

                                                    </div>
                                                </div><!-- /.wrapper_inspeksi -->

                                            </div><!-- /.col-lg-12 -->

                                        </div><!-- /.form-group kip -->

                                        <div class="row mb-3 form-group">
                                            <label for="bracket" class="col-lg-4 col-md-12 col-form-label">Bracket
                                                APAB</label>
                                            <div class="col-lg-8 col-md-12">

                                                <div class="wrapper_inspeksi d-flex flex-column gap-3"
                                                    x-data="{ bracket: @entangle('bracket') }">

                                                    <x-inputs.select2 wire:model="bracket" id="bracket"
                                                        class="form-select" placeholder="Bracket">
                                                        <option value="Standard">Standard</option>
                                                        <option value="Tidak Standard">Tidak Standard</option>
                                                    </x-inputs.select2>

                                                    <div x-cloak x-show="bracket === 'Tidak Standard'">
                                                        <x-inputs.select2 wire:model="bracket_2" id="bracket_2"
                                                            class="form-select" placeholder="Kondisi Bracket">
                                                            <option value="Tidak Ada">Tidak ada bracket</option>
                                                            <option value="Berkarat">Bracket Berkarat</option>
                                                        </x-inputs.select2>
                                                        <br>
                                                        <x-kplh-texteditor wire:model="bracket_note" id="bracket_note"
                                                            placeholder="Komentar Bracket" :error="'bracket_note'" />

                                                        @if ($bracket_file && !Illuminate\Support\Str::contains($bracket_file, 'private/var/folders/'))
                                                            <div class="row mt-3">
                                                                <div class="col-md-3"><button type="button"
                                                                        class="btn btn-outline-secondary"
                                                                        wire:click="setFileNull('bracket_file')"><i
                                                                            class="fa fa-edit"></i> Ubah
                                                                        File</button></div>
                                                                <div class="col-md-9">
                                                                    <a class="btn btn-outline-secondary"
                                                                        href="{{ route('kplh::download-file', ['k3', $bracket_file]) }}"
                                                                        target="_blank"><i class="fa fa-file"></i>
                                                                        {{ Illuminate\Support\Str::limit($bracket_file, 30) }}</a>
                                                                </div>
                                                            </div>
                                                        @else
                                                            <div class="col-md-12 mt-3">
                                                                <x-kplh-file wire:model="bracket_file"
                                                                    id="bracket_file" placeholder="File"
                                                                    :error="'bracket_file'" />
                                                            </div>
                                                        @endif

                                                    </div>
                                                </div><!-- /.wrapper_inspeksi -->

                                            </div><!-- /.col-lg-12 -->

                                        </div><!-- /.form-group bracket -->

                                        <div class="row mb-3 form-group">
                                            <label for="label_penanda" class="col-lg-4 col-md-12 col-form-label">Label
                                                Penanda
                                                Lokasi APAB</label>
                                            <div class="col-lg-8 col-md-12">

                                                <div class="wrapper_inspeksi d-flex flex-column gap-3"
                                                    x-data="{ label_penanda: @entangle('label_penanda') }">

                                                    <x-inputs.select2 wire:model="label_penanda" id="label_penanda"
                                                        class="form-select" placeholder="Label Penanda">
                                                        <option value="Ada">Ada</option>
                                                        <option value="Tidak Ada">Tidak Ada</option>
                                                    </x-inputs.select2>

                                                    <div x-cloak x-show="label_penanda === 'Tidak Ada'">
                                                        <br>
                                                        <x-kplh-texteditor wire:model="label_penanda_note"
                                                            id="label_penanda_note"
                                                            placeholder="Komentar Label Penanda" :error="'label_penanda_note'" />

                                                        @if ($label_penanda_file && !Illuminate\Support\Str::contains($label_penanda_file, 'private/var/folders/'))
                                                            <div class="row mt-3">
                                                                <div class="col-md-3"><button type="button"
                                                                        class="btn btn-outline-secondary"
                                                                        wire:click="setFileNull('label_penanda_file')"><i
                                                                            class="fa fa-edit"></i> Ubah
                                                                        File</button></div>
                                                                <div class="col-md-9">
                                                                    <a class="btn btn-outline-secondary"
                                                                        href="{{ route('kplh::download-file', ['k3', $label_penanda_file]) }}"
                                                                        target="_blank"><i class="fa fa-file"></i>
                                                                        {{ Illuminate\Support\Str::limit($label_penanda_file, 30) }}</a>
                                                                </div>
                                                            </div>
                                                        @else
                                                            <div class="col-md-12 mt-3">
                                                                <x-kplh-file wire:model="label_penanda_file"
                                                                    id="label_penanda_file" placeholder="File"
                                                                    :error="'label_penanda_file'" />
                                                            </div>
                                                        @endif

                                                    </div>
                                                </div><!-- /.wrapper_inspeksi -->

                                            </div><!-- /.col-lg-12 -->

                                        </div><!-- /.form-group label_penanda -->

                                        <div class="row mb-3 form-group">
                                            <label for="demarkasi" class="col-lg-4 col-md-12 col-form-label">Demarkasi
                                                APAB</label>
                                            <div class="col-lg-8 col-md-12">

                                                <div class="wrapper_inspeksi d-flex flex-column gap-3"
                                                    x-data="{ demarkasi: @entangle('demarkasi') }">

                                                    <x-inputs.select2 wire:model="demarkasi" id="demarkasi"
                                                        class="form-select" placeholder="Demarkasi APAB">
                                                        <option value="Ada Demarkasi">Ada Demarkasi</option>
                                                        <option value="Warna Demarkasi Pudar">Warna Demarkasi Pudar
                                                        </option>
                                                        <option value="Tidak Ada">Tidak Ada Demarkasi</option>
                                                    </x-inputs.select2>

                                                    <div x-cloak
                                                        x-show="demarkasi === 'Tidak Ada' || demarkasi === 'Warna Demarkasi Pudar'">
                                                        <br>
                                                        <x-kplh-texteditor wire:model="demarkasi_note"
                                                            id="demarkasi_note" placeholder="Komentar Demarkasi APAB"
                                                            :error="'demarkasi_note'" />

                                                        @if ($demarkasi_file && !Illuminate\Support\Str::contains($demarkasi_file, 'private/var/folders/'))
                                                            <div class="row mt-3">
                                                                <div class="col-md-3"><button type="button"
                                                                        class="btn btn-outline-secondary"
                                                                        wire:click="setFileNull('demarkasi_file')"><i
                                                                            class="fa fa-edit"></i> Ubah
                                                                        File</button></div>
                                                                <div class="col-md-9">
                                                                    <a class="btn btn-outline-secondary"
                                                                        href="{{ route('kplh::download-file', ['k3', $demarkasi_file]) }}"
                                                                        target="_blank"><i class="fa fa-file"></i>
                                                                        {{ Illuminate\Support\Str::limit($demarkasi_file, 30) }}</a>
                                                                </div>
                                                            </div>
                                                        @else
                                                            <div class="col-md-12 mt-3">
                                                                <x-kplh-file wire:model="demarkasi_file"
                                                                    id="demarkasi_file" placeholder="File"
                                                                    :error="'demarkasi_file'" />
                                                            </div>
                                                        @endif

                                                    </div>
                                                </div><!-- /.wrapper_inspeksi -->

                                            </div><!-- /.col-lg-12 -->

                                        </div><!-- /.form-group demarkasi -->

                                        <div class="row mb-3 form-group">
                                            <label for="shelter_apab"
                                                class="col-lg-4 col-md-12 col-form-label">Shelter
                                                APAB</label>
                                            <div class="col-lg-8 col-md-12">

                                                <div class="wrapper_inspeksi d-flex flex-column gap-3"
                                                    x-data="{ shelter_apab: @entangle('shelter_apab') }">

                                                    <x-inputs.select2 wire:model="shelter_apab" id="shelter_apab"
                                                        class="form-select" placeholder="Shelter APAB">
                                                        <option value="Ada">Ada Shelter</option>
                                                        <option value="Tidak Ada">Warna Shelter Pudar</option>
                                                        <option value="N/A">N/A</option>
                                                    </x-inputs.select2>

                                                    <div x-cloak
                                                        x-show="shelter_apab === 'Tidak Ada' || shelter_apab === 'N/A'">
                                                        <br>
                                                        <x-kplh-texteditor wire:model="shelter_apab_note"
                                                            id="shelter_apab_note" placeholder="Komentar Shelter APAB"
                                                            :error="'shelter_apab_note'" />

                                                        @if ($shelter_apab_file && !Illuminate\Support\Str::contains($shelter_apab_file, 'private/var/folders/'))
                                                            <div class="row mt-3">
                                                                <div class="col-md-3"><button type="button"
                                                                        class="btn btn-outline-secondary"
                                                                        wire:click="setFileNull('shelter_apab_file')"><i
                                                                            class="fa fa-edit"></i> Ubah
                                                                        File</button></div>
                                                                <div class="col-md-9">
                                                                    <a class="btn btn-outline-secondary"
                                                                        href="{{ route('kplh::download-file', ['k3', $shelter_apab_file]) }}"
                                                                        target="_blank"><i class="fa fa-file"></i>
                                                                        {{ Illuminate\Support\Str::limit($shelter_apab_file, 30) }}</a>
                                                                </div>
                                                            </div>
                                                        @else
                                                            <div class="col-md-12 mt-3">
                                                                <x-kplh-file wire:model="shelter_apab_file"
                                                                    id="shelter_apab_file" placeholder="File"
                                                                    :error="'shelter_apab_file'" />
                                                            </div>
                                                        @endif

                                                    </div>
                                                </div><!-- /.wrapper_inspeksi -->

                                            </div><!-- /.col-lg-12 -->

                                        </div><!-- /.form-group shelter_apab -->

                                        <div class="row mb-3 form-group">
                                            <label for="kain_pelindung" class="col-lg-4 col-md-12 col-form-label">Kain
                                                Pelindung
                                                APAB (Cover APAB)</label>
                                            <div class="col-lg-8 col-md-12">

                                                <div class="wrapper_inspeksi d-flex flex-column gap-3"
                                                    x-data="{ kain_pelindung: @entangle('kain_pelindung') }">

                                                    <x-inputs.select2 wire:model="kain_pelindung" id="kain_pelindung"
                                                        class="form-select" placeholder="Cover APAB">
                                                        <option value="Ada">Ada Pelindung</option>
                                                        <option value="Tidak Ada">Tidak Ada Pelindung</option>
                                                        <option value="Tidak Perlu Pelindung">Tidak Perlu Pelindung
                                                        </option>
                                                    </x-inputs.select2>

                                                    <div x-cloak x-show="kain_pelindung === 'Tidak Ada'">
                                                        <br>
                                                        <x-kplh-texteditor wire:model="kain_pelindung_note"
                                                            id="kain_pelindung_note" placeholder="Komentar Cover APAB"
                                                            :error="'kain_pelindung_note'" />

                                                        @if ($kain_pelindung_file && !Illuminate\Support\Str::contains($kain_pelindung_file, 'private/var/folders/'))
                                                            <div class="row mt-3">
                                                                <div class="col-md-3"><button type="button"
                                                                        class="btn btn-outline-secondary"
                                                                        wire:click="setFileNull('kain_pelindung_file')"><i
                                                                            class="fa fa-edit"></i> Ubah
                                                                        File</button></div>
                                                                <div class="col-md-9">
                                                                    <a class="btn btn-outline-secondary"
                                                                        href="{{ route('kplh::download-file', ['k3', $kain_pelindung_file]) }}"
                                                                        target="_blank"><i class="fa fa-file"></i>
                                                                        {{ Illuminate\Support\Str::limit($kain_pelindung_file, 30) }}</a>
                                                                </div>
                                                            </div>
                                                        @else
                                                            <div class="col-md-12 mt-3">
                                                                <x-kplh-file wire:model="kain_pelindung_file"
                                                                    id="kain_pelindung_file" placeholder="File"
                                                                    :error="'kain_pelindung_file'" />
                                                            </div>
                                                        @endif

                                                    </div>
                                                </div><!-- /.wrapper_inspeksi -->

                                            </div><!-- /.col-lg-12 -->

                                        </div><!-- /.form-group kain_pelindung -->

                                        <div class="row mb-3 form-group">
                                            <label for="kondisi_kain"
                                                class="col-lg-4 col-md-12 col-form-label">Kondisi Kain
                                                Pelindung APAB (Cover APAB)</label>
                                            <div class="col-lg-8 col-md-12">

                                                <div class="wrapper_inspeksi d-flex flex-column gap-3"
                                                    x-data="{ kondisi_kain: @entangle('kondisi_kain') }">

                                                    <x-inputs.select2 wire:model="kondisi_kain" id="kondisi_kain"
                                                        class="form-select" placeholder="Kondisi Cover APAB">
                                                        <option value="Perlu Penggantian">Perlu Penggantian</option>
                                                        <option value="Tidak Perlu Penggantian">Tidak Perlu Penggantian
                                                        </option>
                                                    </x-inputs.select2>

                                                    <div x-cloak x-show="kondisi_kain === 'Perlu Penggantian'">
                                                        <br>
                                                        <x-kplh-texteditor wire:model="kondisi_kain_note"
                                                            id="kondisi_kain_note"
                                                            placeholder="Komentar Kondisi Cover APAB"
                                                            :error="'kondisi_kain_note'" />

                                                        @if ($kondisi_kain_file && !Illuminate\Support\Str::contains($kondisi_kain_file, 'private/var/folders/'))
                                                            <div class="row mt-3">
                                                                <div class="col-md-3"><button type="button"
                                                                        class="btn btn-outline-secondary"
                                                                        wire:click="setFileNull('kondisi_kain_file')"><i
                                                                            class="fa fa-edit"></i> Ubah
                                                                        File</button></div>
                                                                <div class="col-md-9">
                                                                    <a class="btn btn-outline-secondary"
                                                                        href="{{ route('kplh::download-file', ['k3', $kondisi_kain_file]) }}"
                                                                        target="_blank"><i class="fa fa-file"></i>
                                                                        {{ Illuminate\Support\Str::limit($kondisi_kain_file, 30) }}</a>
                                                                </div>
                                                            </div>
                                                        @else
                                                            <div class="col-md-12 mt-3">
                                                                <x-kplh-file wire:model="kondisi_kain_file"
                                                                    id="kondisi_kain_file" placeholder="File"
                                                                    :error="'kondisi_kain_file'" />
                                                            </div>
                                                        @endif

                                                    </div>
                                                </div><!-- /.wrapper_inspeksi -->

                                            </div><!-- /.col-lg-12 -->

                                        </div><!-- /.form-group kondisi_kain -->

                                        <div class="row mb-4 form-group">
                                            <label for="penempatan" class="col-lg-4 col-md-12 col-form-label">Kondisi
                                                Penempatan
                                                APAB</label>
                                            <div class="col-lg-8 col-md-12">

                                                <div class="wrapper_inspeksi d-flex flex-column gap-3"
                                                    x-data="{ penempatan: @entangle('penempatan') }">

                                                    <x-inputs.select2 wire:model="penempatan" id="penempatan"
                                                        class="form-select" placeholder="Penempatan">
                                                        <option value="Mudah Dijangkau">Mudah Dijangkau</option>
                                                        <option value="Terdapat Penghalang">Terdapat Penghalang
                                                        </option>
                                                    </x-inputs.select2>

                                                    <div x-cloak x-show="penempatan === 'Terdapat Penghalang'">
                                                        <x-inputs.select2 wire:model="penempatan_2" id="penempatan_2"
                                                            class="form-select" placeholder="Kondisi Penempatan">
                                                            <option value="Penghalang Dipindahkan">Penghalang
                                                                Dipindahkan
                                                            </option>
                                                            <option
                                                                value="Penghalang Tidak Dapat Penghalang Dipindahkan">
                                                                Penghalang Tidak
                                                                Dapat
                                                                Dipindahkan
                                                            </option>
                                                        </x-inputs.select2>
                                                        <br>
                                                        <x-kplh-texteditor wire:model="penempatan_note"
                                                            id="penempatan_note" placeholder="Komentar Penempatan"
                                                            :error="'penempatan_note'" />

                                                        @if ($penempatan_file && !Illuminate\Support\Str::contains($penempatan_file, 'private/var/folders/'))
                                                            <div class="row mt-3">
                                                                <div class="col-md-3"><button type="button"
                                                                        class="btn btn-outline-secondary"
                                                                        wire:click="setFileNull('penempatan_file')"><i
                                                                            class="fa fa-edit"></i> Ubah
                                                                        File</button></div>
                                                                <div class="col-md-9">
                                                                    <a class="btn btn-outline-secondary"
                                                                        href="{{ route('kplh::download-file', ['k3', $penempatan_file]) }}"
                                                                        target="_blank"><i class="fa fa-file"></i>
                                                                        {{ Illuminate\Support\Str::limit($penempatan_file, 30) }}</a>
                                                                </div>
                                                            </div>
                                                        @else
                                                            <div class="col-md-12 mt-3">
                                                                <x-kplh-file wire:model="penempatan_file"
                                                                    id="penempatan_file" placeholder="File"
                                                                    :error="'penempatan_file'" />
                                                            </div>
                                                        @endif

                                                    </div>
                                                </div><!-- /.wrapper_inspeksi -->

                                            </div><!-- /.col-lg-12 -->
                                            <br>

                                        </div><!-- /.form-group penempatan -->

                                    </div>
                                </div>
                            </div><!-- /.form-group bangunan-k11 -->

                            <hr>
                            <div class="row form-group">
                                <label for="summary" class="col col-form-label">Ringkasan Hasil
                                    Inspeksi</label>
                                <div class="col-8">
                                    <x-kplh-texteditor wire:model="summary" id="summary"
                                        placeholder="Ringkasan Hasil Inspeksi" :error="'summary'" />
                                </div>
                            </div><!-- /.form-group summary -->

                        </div><!-- ./content-bangunan -->

                        <div class="space">
                            <hr>
                        </div>

                        <div class="footer-action mb-2 p-3">
                            <div class="action-wrapper d-flex align-items-center justify-content-end gap-2">

                                <a href="javascript:history.go(-1)" class="btn btn-outline-secondary">Cancel</a>
                                <button type="submit" wire:click="$set('mode','draft')"
                                    class="btn btn-outline-warning d-flex justify-content-center align-item-center position-relative px-4">Save
                                    Draft</button>
                                <button type="submit" wire:click="$set('mode','save')"
                                    class="btn btn-outline-default bg-green d-flex justify-content-center align-item-center text-white position-relative px-4">Save</button>

                            </div>
                        </div>
                    </form>

                </div>
            </div>
        </div>
    </div>
</div>
</div><!-- /.content-inspeksi-alat -->

</div><!-- /.inner-content -->
