<div class="inner-content">

    <div
        class="header-content-inspeksi-alat h-60px bg-white shadow-sm d-flex gap-2 align-items-center justify-content-between px-3">
        <div class="left-header">
            <a href="javascript:history.go(-1)" class="d-flex align-items-center gap-3">
                <span><i class="fa-solid fa-arrow-left"></i></span>
                <span>Inspeksi Alat K3 - APAR</span>
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
                            <h4>Inspeksi Alat K3 - APAR</h4>
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

                                                @if ($sectionId)
                                                    <x-inputs.select2 wire:model="area_location_id"
                                                        id="area_location_id" data-child="area_location_id"
                                                        class="form-select" placeholder="Area Lokasi">
                                                        @foreach ($this->areaLocations as $key => $location)
                                                            <option value="{{ $location->id }}">{{ $location->name }}
                                                            </option>
                                                        @endforeach
                                                    </x-inputs.select2>
                                                @else
                                                    <x-inputs.select2 wire:model="area_location_id"
                                                        id="area_location_id" class="form-select"
                                                        placeholder="Area Lokasi" disabled>
                                                    </x-inputs.select2>
                                                @endif

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
                                                <x-inputs.select2 wire:model="kttId" id="kttId"
                                                    class="form-control" placeholder="KTT" disabled>
                                                    @if ($companyId)
                                                    <option value="{{ $kttId ?? null }}" selected>
                                                        {{ $company->user->name ?? null }}
                                                    </option>
                                                @endif

                                                </x-inputs.select2>
                                            </div>
                                        </div><!-- /.form-group kttId -->

                                        <div class="row mb-3 form-group">
                                            <label for="pjaId"
                                                class="col-lg-4 col-md-12 col-form-label">PJA</label>
                                            <div class="col-lg-8 col-md-12">
                                                @if ($sectionId)
                                                    <x-inputs.select2 wire:model="pjaId" id="pjaId"
                                                        class="form-select" placeholder="PJA">
                                                        @foreach ($this->areaManagers as $key => $areaManager)
                                                            <option value="{{ $areaManager->id }}">
                                                                {{ $areaManager->user->employee->name ?? null }}
                                                            </option>
                                                        @endforeach
                                                    </x-inputs.select2>
                                                @else
                                                    <x-inputs.select2 wire:model="pjaId" id="pjaId"
                                                        class="form-select" placeholder="PJA" disabled>
                                                    </x-inputs.select2>
                                                @endif
                                            </div>
                                        </div><!-- /.form-group pjaId -->

                                        <div class="row mb-3 form-group mb-4">
                                            <label for="inspectionOfficer"
                                                class="col-lg-4 col-md-12 col-form-label">Petugas
                                                Inspeksi</label>
                                            <div class="col-lg-8 col-md-12">

                                                <div class="wrapper_inspectionOfficer d-flex flex-column gap-3">

                                                    {{-- @if ($ccow_id) --}}
                                                    <x-kplh-select2 wire:model="inspectionOfficer"
                                                        id="inspectionOfficer" class="form-select"
                                                        placeholder="Petugas Inspeksi" :error="'inspectionOfficer'">
                                                        @foreach ($this->employees as $index => $emp)
                                                            <option value="{{ $emp->id }}">
                                                                {{ $emp->name }}
                                                            </option>
                                                        @endforeach
                                                    </x-kplh-select2>
                                                    {{-- @else
                                                        <x-inputs.select2 class="form-control" disabled></x-inputs.select2>
                                                    @endif --}}

                                                </div><!-- /.wrapper_petugas -->
                                            </div>
                                        </div><!-- /.form-group inspectionOfficer -->

                                    </div><!-- ./content-label -->
                                </div>
                            </div><!-- /.label -->

                            <div id="apar" class="section-apar" x-data="{ accordionOpen: true }">
                                <button
                                    class="header-accordion d-flex justify-content-between w-100 border-0 bg-white py-3 px-0"
                                    @click.prevent="accordionOpen = ! accordionOpen">
                                    <h6 class="mb-0 fw-normal title-accordion">Inspeksi APAR </h6>
                                    <span x-bind:class="accordionOpen ? 'open' : ''"><img
                                            src="{{ asset('/images/icons/angle-down.png') }}"
                                            alt="" /></span>
                                </button>
                                <div class="wrapper-content-accordion max-h-0 overflow-hidden position-relative transition-all duration-700"
                                    x-ref="apar" x-bind:style="accordionOpen ? 'max-height: ' + 20000 + 'px' : ''"
                                    x-transition.delay.5000ms>

                                    <div class="content-section p-4" wire:ignore.self>

                                        <div class="row mb-3 form-group">
                                            <label for="tool_id" class="col col-form-label">No. ID APAR</label>
                                            <div class="col-8">
                                                <x-inputs.text wire:model="tool_id" id="tool_id"
                                                    placeholder="No. ID APAR" :error="'tool_id'" />
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
                                            <label for="isi_apar" class="col-lg-4 col-md-12 col-form-label">Isi
                                                APAR</label>
                                            <div class="col-lg-8 col-md-12">
                                                <div class="wrapper_isi_apar d-flex flex-column gap-3"
                                                    x-data="{ isi_apar: @entangle('isi_apar') }">

                                                    <x-inputs.select2 wire:model="isi_apar" id="isi_apar"
                                                        class="form-select" placeholder="Isi APAR">
                                                        <option value="Powder">Powder</option>
                                                        <option value="Co2">CO2</option>
                                                        <option value="Water">Water</option>
                                                        <option value="Halon">Halon</option>
                                                        <option value="Foam">Foam</option>
                                                    </x-inputs.select2>

                                                    <div x-cloak x-show="isi_apar">
                                                        <x-kplh-texteditor wire:model="isi_apar_note"
                                                            id="isi_apar_note" placeholder="Komentar Isi"
                                                            :error="'isi_apar_note'" />

                                                        @if ($isi_apar_file && !Illuminate\Support\Str::contains($isi_apar_file, 'private/var/folders/'))
                                                            <div class="row mt-3">
                                                                <div class="col-md-3"><button type="button"
                                                                        class="btn btn-outline-secondary"
                                                                        wire:click="setFileNull('isi_apar_file')"><i
                                                                            class="fa fa-edit"></i> Ubah
                                                                        File</button></div>
                                                                <div class="col-md-9">
                                                                    <a class="btn btn-outline-secondary"
                                                                        href="{{ route('kplh::download-file', ['k3', $isi_apar_file]) }}"
                                                                        target="_blank"><i class="fa fa-file"></i>
                                                                        {{ Illuminate\Support\Str::limit($isi_apar_file, 30) }}</a>
                                                                </div>
                                                            </div>
                                                        @else
                                                            <div class="col-md-12 mt-3">
                                                                <x-kplh-file wire:model="isi_apar_file"
                                                                    id="isi_apar_file" placeholder="File"
                                                                    :error="'isi_apar_file'" />
                                                            </div>
                                                        @endif
                                                    </div>
                                                </div><!-- /.wrapper_isi_apar -->
                                            </div><!-- /.col-lg-12 -->
                                        </div><!-- /.form-group isi_apar -->

                                        <div class="row mb-3 form-group">
                                            <label for="gol_apar" class="col-lg-4 col-md-12 col-form-label">Golongan
                                                APAR</label>
                                            <div class="col-lg-8 col-md-12">
                                                <div class="wrapper_inspeksi d-flex flex-column gap-3"
                                                    x-data="{ gol_apar: @entangle('gol_apar') }">

                                                    <x-inputs.select2 wire:model="gol_apar" id="gol_apar"
                                                        class="form-select" placeholder="Golongan APAR">
                                                        <option value="A">A</option>
                                                        <option value="B">B</option>
                                                        <option value="C">C</option>
                                                        <option value="A+B+C">A+B+C</option>
                                                        <option value="N/A">N/A</option>
                                                    </x-inputs.select2>

                                                    <div x-cloak x-show="gol_apar">
                                                        <x-kplh-texteditor wire:model="gol_apar_note"
                                                            id="gol_apar_note" placeholder="Komentar Golongan APAR"
                                                            :error="'gol_apar_note'" />

                                                        @if ($gol_apar_file && !Illuminate\Support\Str::contains($gol_apar_file, 'private/var/folders/'))
                                                            <div class="row mt-3">
                                                                <div class="col-md-3"><button type="button"
                                                                        class="btn btn-outline-secondary"
                                                                        wire:click="setFileNull('gol_apar_file')"><i
                                                                            class="fa fa-edit"></i> Ubah
                                                                        File</button></div>
                                                                <div class="col-md-9">
                                                                    <a class="btn btn-outline-secondary"
                                                                        href="{{ route('kplh::download-file', ['k3', $gol_apar_file]) }}"
                                                                        target="_blank"><i class="fa fa-file"></i>
                                                                        {{ Illuminate\Support\Str::limit($gol_apar_file, 30) }}</a>
                                                                </div>
                                                            </div>
                                                        @else
                                                            <div class="col-md-12 mt-3">
                                                                <x-kplh-file wire:model="gol_apar_file"
                                                                    id="gol_apar_file" placeholder="File"
                                                                    :error="'gol_apar_file'" />
                                                            </div>
                                                        @endif
                                                    </div>
                                                </div><!-- /.wrapper_inspeksi -->
                                            </div><!-- /.col-lg-12 -->
                                        </div><!-- /.form-group gol_apar -->

                                        <div class="row mb-3 form-group">
                                            <label for="kapasitas_apar"
                                                class="col-lg-4 col-md-12 col-form-label">Kapasitas
                                                APAR</label>
                                            <div class="col-lg-8 col-md-12">
                                                <div class="wrapper_inspeksi d-flex flex-column gap-3"
                                                    x-data="{ kapasitas_apar: @entangle('kapasitas_apar') }">

                                                    <x-inputs.select2 wire:model="kapasitas_apar" id="kapasitas_apar"
                                                        class="form-select" placeholder="Kapasitas APAR">
                                                        <option value="1">1KG</option>
                                                        <option value="2">2KG</option>
                                                        <option value="3">3KG</option>
                                                        <option value="4">4KG</option>
                                                        <option value="5">5KG</option>
                                                        <option value="6">6KG</option>
                                                        <option value="7">7KG</option>
                                                        <option value="8">8KG</option>
                                                        <option value="9">9KG</option>
                                                        <option value="10">10KG</option>
                                                        <option value="N/A">N/A</option>
                                                    </x-inputs.select2>

                                                    <div x-cloak x-show="kapasitas_apar">
                                                        <x-kplh-texteditor wire:model="kapasitas_apar_note"
                                                            id="kapasitas_apar_note"
                                                            placeholder="Komentar Kapasitas APAR" :error="'kapasitas_apar_note'" />

                                                        @if ($kapasitas_apar_file && !Illuminate\Support\Str::contains($kapasitas_apar_file, 'private/var/folders/'))
                                                            <div class="row mt-3">
                                                                <div class="col-md-3"><button type="button"
                                                                        class="btn btn-outline-secondary"
                                                                        wire:click="setFileNull('kapasitas_apar_file')"><i
                                                                            class="fa fa-edit"></i> Ubah
                                                                        File</button></div>
                                                                <div class="col-md-9">
                                                                    <a class="btn btn-outline-secondary"
                                                                        href="{{ route('kplh::download-file', ['k3', $kapasitas_apar_file]) }}"
                                                                        target="_blank"><i class="fa fa-file"></i>
                                                                        {{ Illuminate\Support\Str::limit($kapasitas_apar_file, 30) }}</a>
                                                                </div>
                                                            </div>
                                                        @else
                                                            <div class="col-md-12 mt-3">
                                                                <x-kplh-file wire:model="kapasitas_apar_file"
                                                                    id="kapasitas_apar_file" placeholder="File"
                                                                    :error="'kapasitas_apar_file'" />
                                                            </div>
                                                        @endif
                                                    </div>
                                                </div><!-- /.wrapper_inspeksi -->
                                            </div><!-- /.col-lg-12 -->
                                        </div><!-- /.form-group kapasitas_apar -->

                                        <div class="row mb-3 form-group">
                                            <label for="tuas_apar" class="col-lg-4 col-md-12 col-form-label">Tuas
                                                APAR</label>
                                            <div class="col-lg-8 col-md-12">
                                                <div class="wrapper_inspeksi d-flex flex-column gap-3"
                                                    x-data="{ tuas_apar: @entangle('tuas_apar') }">

                                                    <x-inputs.select2 wire:model="tuas_apar" id="tuas_apar"
                                                        class="form-select" placeholder="Tuas APAR">
                                                        <option value="Standard">Standard</option>
                                                        <option value="Tidak Standard">Tidak Standard</option>
                                                    </x-inputs.select2>

                                                    <div x-cloak x-show="tuas_apar === 'Tidak Standard'">
                                                        <x-inputs.select2 wire:model="tuas_apar_2" id="tuas_apar_2"
                                                            class="form-select" placeholder="Kondisi Tuas APAR">
                                                            <option value="Berkarat">Berkarat</option>
                                                            <option value="Rusak">Rusak</option>
                                                            <option value="Lainnya">Lainnya</option>
                                                        </x-inputs.select2>
                                                        <br>
                                                        <x-kplh-texteditor wire:model="tuas_apar_note"
                                                            id="tuas_apar_note" placeholder="Komentar Tuas APAR"
                                                            :error="'tuas_apar_note'">
                                                        </x-kplh-texteditor>

                                                        @if ($tuas_apar_file && !Illuminate\Support\Str::contains($tuas_apar_file, 'private/var/folders/'))
                                                            <div class="row mt-3">
                                                                <div class="col-md-3"><button type="button"
                                                                        class="btn btn-outline-secondary"
                                                                        wire:click="setFileNull('tuas_apar_file')"><i
                                                                            class="fa fa-edit"></i> Ubah
                                                                        File</button></div>
                                                                <div class="col-md-9">
                                                                    <a class="btn btn-outline-secondary"
                                                                        href="{{ route('kplh::download-file', ['k3', $tuas_apar_file]) }}"
                                                                        target="_blank"><i class="fa fa-file"></i>
                                                                        {{ Illuminate\Support\Str::limit($tuas_apar_file, 30) }}</a>
                                                                </div>
                                                            </div>
                                                        @else
                                                            <div class="col-md-12 mt-3">
                                                                <x-kplh-file wire:model="tuas_apar_file"
                                                                    id="tuas_apar_file" placeholder="File"
                                                                    :error="'tuas_apar_file'" />
                                                            </div>
                                                        @endif
                                                    </div>
                                                </div><!-- /.wrapper_inspeksi -->
                                            </div><!-- /.col-lg-12 -->
                                        </div><!-- /.form-group tuas_apar -->

                                        <div class="row mb-3 form-group">
                                            <label for="handle_apar" class="col-lg-4 col-md-12 col-form-label">Handle
                                                APAR</label>
                                            <div class="col-lg-8 col-md-12">
                                                <div class="wrapper_inspeksi d-flex flex-column gap-3"
                                                    x-data="{ handle_apar: @entangle('handle_apar') }">

                                                    <x-inputs.select2 wire:model="handle_apar" id="handle_apar"
                                                        class="form-select" placeholder="Handle APAR">
                                                        <option value="">Handle APAR</option>
                                                        <option value="Standard">Standard</option>
                                                        <option value="Tidak Standard">Tidak Standard</option>
                                                    </x-inputs.select2>

                                                    <div x-cloak x-show="handle_apar === 'Tidak Standard'">
                                                        <x-inputs.select2 wire:model="handle_apar_2"
                                                            id="handle_apar_2" class="form-select"
                                                            placeholder="Kondisi Handle APAR">
                                                            <option value="Berkarat">Berkarat</option>
                                                            <option value="Rusak">Rusak</option>
                                                            <option value="Lainnya">Lainnya</option>
                                                        </x-inputs.select2>
                                                        <br>
                                                        <x-kplh-texteditor wire:model="handle_apar_note"
                                                            id="handle_apar_note" placeholder="Komentar Handle APAR"
                                                            :error="'handle_apar_note'" />

                                                        @if ($handle_apar_file && !Illuminate\Support\Str::contains($handle_apar_file, 'private/var/folders/'))
                                                            <div class="row mt-3">
                                                                <div class="col-md-3"><button type="button"
                                                                        class="btn btn-outline-secondary"
                                                                        wire:click="setFileNull('handle_apar_file')"><i
                                                                            class="fa fa-edit"></i> Ubah
                                                                        File</button></div>
                                                                <div class="col-md-9">
                                                                    <a class="btn btn-outline-secondary"
                                                                        href="{{ route('kplh::download-file', ['k3', $handle_apar_file]) }}"
                                                                        target="_blank"><i class="fa fa-file"></i>
                                                                        {{ Illuminate\Support\Str::limit($handle_apar_file, 30) }}</a>
                                                                </div>
                                                            </div>
                                                        @else
                                                            <div class="col-md-12 mt-3">
                                                                <x-kplh-file wire:model="handle_apar_file"
                                                                    id="handle_apar_file" placeholder="File"
                                                                    :error="'handle_apar_file'" />
                                                            </div>
                                                        @endif
                                                    </div>
                                                </div><!-- /.wrapper_inspeksi -->

                                            </div><!-- /.col-lg-12 -->
                                        </div><!-- /.form-group handle_apar -->

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
                                                            <option value="Low Pressure">Low Pressure</option>
                                                            <option value="Over pressure">Over pressure</option>
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
                                            <label for="pin_apar" class="col-lg-4 col-md-12 col-form-label">Pin
                                                APAR</label>
                                            <div class="col-lg-8 col-md-12">
                                                <div class="wrapper_inspeksi d-flex flex-column gap-3"
                                                    x-data="{ pin_apar: @entangle('pin_apar') }">

                                                    <x-inputs.select2 wire:model="pin_apar" id="pin_apar"
                                                        class="form-select" placeholder="PIN APAR">
                                                        <option value="Standard">Standard</option>
                                                        <option value="Tidak Standard">Tidak Standard</option>
                                                    </x-inputs.select2>

                                                    <div x-cloak x-show="pin_apar === 'Tidak Standard'">
                                                        <x-inputs.select2 wire:model="pin_apar_2" id="pin_apar_2"
                                                            class="form-select" placeholder="Kondisi PIN APAR">
                                                            <option value="Terlepas">Terlepas</option>
                                                            <option value="Berkarat">Berkarat</option>
                                                            <option value="Hilang">Hilang</option>
                                                        </x-inputs.select2>
                                                        <br>
                                                        <x-kplh-texteditor wire:model="pin_apar_note"
                                                            id="pin_apar_note" placeholder="Komentar PIN APAR"
                                                            :error="'pin_apar_note'" />

                                                        @if ($pin_apar_file && !Illuminate\Support\Str::contains($pin_apar_file, 'private/var/folders/'))
                                                            <div class="row mt-3">
                                                                <div class="col-md-3"><button type="button"
                                                                        class="btn btn-outline-secondary"
                                                                        wire:click="setFileNull('pin_apar_file')"><i
                                                                            class="fa fa-edit"></i> Ubah
                                                                        File</button></div>
                                                                <div class="col-md-9">
                                                                    <a class="btn btn-outline-secondary"
                                                                        href="{{ route('kplh::download-file', ['k3', $pin_apar_file]) }}"
                                                                        target="_blank"><i class="fa fa-file"></i>
                                                                        {{ Illuminate\Support\Str::limit($pin_apar_file, 30) }}</a>
                                                                </div>
                                                            </div>
                                                        @else
                                                            <div class="col-md-12 mt-3">
                                                                <x-kplh-file wire:model="pin_apar_file"
                                                                    id="pin_apar_file" placeholder="File"
                                                                    :error="'pin_apar_file'" />
                                                            </div>
                                                        @endif
                                                    </div>
                                                </div><!-- /.wrapper_inspeksi -->
                                            </div><!-- /.col-lg-12 -->
                                        </div><!-- /.form-group pin_apar -->

                                        <div class="row mb-3 form-group">
                                            <label for="hose_apar" class="col-lg-4 col-md-12 col-form-label">Hose
                                                APAR</label>
                                            <div class="col-lg-8 col-md-12">
                                                <div class="wrapper_inspeksi d-flex flex-column gap-3"
                                                    x-data="{ hose_apar: @entangle('hose_apar') }">

                                                    <x-inputs.select2 wire:model="hose_apar" id="hose_apar"
                                                        class="form-select" placeholder="Hose APAR">
                                                        <option value="Standard">Standard</option>
                                                        <option value="Tidak Standard">Tidak Standard</option>
                                                    </x-inputs.select2>

                                                    <div x-cloak x-show="hose_apar === 'Tidak Standard'">
                                                        <x-inputs.select2 wire:model="hose_apar_2" id="hose_apar_2"
                                                            class="form-select" placeholder="Kondisi Hose APAR">
                                                            <option value="Robek">Robek</option>
                                                            <option value="Rusak">Rusak</option>
                                                            <option value="Hilang">Hilang</option>
                                                        </x-inputs.select2>
                                                        <br>
                                                        <x-kplh-texteditor wire:model="hose_apar_note"
                                                            id="hose_apar_note" placeholder="Komentar Hose APAR"
                                                            :error="'hose_apar_note'" />

                                                        @if ($hose_apar_file && !Illuminate\Support\Str::contains($hose_apar_file, 'private/var/folders/'))
                                                            <div class="row mt-3">
                                                                <div class="col-md-3"><button type="button"
                                                                        class="btn btn-outline-secondary"
                                                                        wire:click="setFileNull('hose_apar_file')"><i
                                                                            class="fa fa-edit"></i> Ubah
                                                                        File</button></div>
                                                                <div class="col-md-9">
                                                                    <a class="btn btn-outline-secondary"
                                                                        href="{{ route('kplh::download-file', ['k3', $hose_apar_file]) }}"
                                                                        target="_blank"><i class="fa fa-file"></i>
                                                                        {{ Illuminate\Support\Str::limit($hose_apar_file, 30) }}</a>
                                                                </div>
                                                            </div>
                                                        @else
                                                            <div class="col-md-12 mt-3">
                                                                <x-kplh-file wire:model="hose_apar_file"
                                                                    id="hose_apar_file" placeholder="File"
                                                                    :error="'hose_apar_file'" />
                                                            </div>
                                                        @endif
                                                    </div>
                                                </div><!-- /.wrapper_inspeksi -->
                                            </div><!-- /.col-lg-12 -->
                                        </div><!-- /.form-group hose_apar -->

                                        <div class="row mb-3 form-group">
                                            <label for="nozzle_apar" class="col-lg-4 col-md-12 col-form-label">Nozzle
                                                APAR</label>
                                            <div class="col-lg-8 col-md-12">
                                                <div class="wrapper_inspeksi d-flex flex-column gap-3"
                                                    x-data="{ nozzle_apar: @entangle('nozzle_apar') }">

                                                    <x-inputs.select2 wire:model="nozzle_apar" id="nozzle_apar"
                                                        class="form-select" placeholder="Nozzle APAR">
                                                        <option value="Standard">Standard</option>
                                                        <option value="Tidak Standard">Tidak Standard</option>
                                                    </x-inputs.select2>

                                                    <div x-cloak x-show="nozzle_apar === 'Tidak Standard'">
                                                        <x-inputs.select2 wire:model="nozzle_apar_2"
                                                            id="nozzle_apar_2" class="form-select"
                                                            placeholder="Kondisi Nozzle APAR">
                                                            <option value="Buntu">Buntu</option>
                                                            <option value="Pecah">Pecah</option>
                                                            <option value="Rusak">Rusak</option>
                                                            <option value="Hilang">Hilang</option>
                                                            <option value="Lainnya">Lainnya</option>
                                                        </x-inputs.select2>
                                                        <br>
                                                        <x-kplh-texteditor wire:model="nozzle_apar_note"
                                                            id="nozzle_apar_note" placeholder="Komentar Nozzle APAR"
                                                            :error="'nozzle_apar_note'" />

                                                        @if ($nozzle_apar_file && !Illuminate\Support\Str::contains($nozzle_apar_file, 'private/var/folders/'))
                                                            <div class="row mt-3">
                                                                <div class="col-md-3"><button type="button"
                                                                        class="btn btn-outline-secondary"
                                                                        wire:click="setFileNull('nozzle_apar_file')"><i
                                                                            class="fa fa-edit"></i> Ubah
                                                                        File</button></div>
                                                                <div class="col-md-9">
                                                                    <a class="btn btn-outline-secondary"
                                                                        href="{{ route('kplh::download-file', ['k3', $nozzle_apar_file]) }}"
                                                                        target="_blank"><i class="fa fa-file"></i>
                                                                        {{ Illuminate\Support\Str::limit($nozzle_apar_file, 30) }}</a>
                                                                </div>
                                                            </div>
                                                        @else
                                                            <div class="col-md-12 mt-3">
                                                                <x-kplh-file wire:model="nozzle_apar_file"
                                                                    id="nozzle_apar_file" placeholder="File"
                                                                    :error="'nozzle_apar_file'" />
                                                            </div>
                                                        @endif
                                                    </div>
                                                </div><!-- /.wrapper_inspeksi -->
                                            </div><!-- /.col-lg-12 -->
                                        </div><!-- /.form-group nozzle_apar -->

                                        <div class="row mb-3 form-group">
                                            <label for="kondisi_tabung"
                                                class="col-lg-4 col-md-12 col-form-label">Kondisi
                                                tabung/cylinder APAR</label>
                                            <div class="col-lg-8 col-md-12">
                                                <div class="wrapper_inspeksi d-flex flex-column gap-3"
                                                    x-data="{ kondisi_tabung: @entangle('kondisi_tabung') }">

                                                    <x-inputs.select2 wire:model="kondisi_tabung" id="kondisi_tabung"
                                                        class="form-select"
                                                        placeholder="Kondisi tabung/cylinder APAR">
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
                                                            placeholder="Komentar Kondisi tabung/cylinder APAR"
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
                                            <label for="cat_tabung" class="col-lg-4 col-md-12 col-form-label">Kondisi
                                                Cat Tabung
                                                APAR</label>
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
                                                APAR</label>
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
                                                            <option value="Belum Diperiksa">Belum Diperiksa
                                                            </option>
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
                                                APAR</label>
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
                                                Lokasi APAR</label>
                                            <div class="col-lg-8 col-md-12">
                                                <div class="wrapper_inspeksi d-flex flex-column gap-3"
                                                    x-data="{ label_penanda: @entangle('label_penanda') }">

                                                    <x-inputs.select2 wire:model="label_penanda" id="label_penanda"
                                                        class="form-select" placeholder="Label Penanda">
                                                        <option value="Ada">Ada</option>
                                                        <option value="Tidak Ada">Tidak Ada</option>
                                                    </x-inputs.select2>

                                                    <div x-cloak x-show="label_penanda === 'Tidak Ada'">
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
                                                APAR</label>
                                            <div class="col-lg-8 col-md-12">
                                                <div class="wrapper_inspeksi d-flex flex-column gap-3"
                                                    x-data="{ demarkasi: @entangle('demarkasi') }">

                                                    <x-inputs.select2 wire:model="demarkasi" id="demarkasi"
                                                        class="form-select" placeholder="Demarkasi APAR">
                                                        <option value="Ada Demarkasi">Ada Demarkasi</option>
                                                        <option value="Warna Demarkasi Pudar">Warna Demarkasi Pudar
                                                        </option>
                                                        <option value="Tidak Ada">Tidak Ada Demarkasi</option>
                                                    </x-inputs.select2>

                                                    <div x-cloak
                                                        x-show="demarkasi === 'Tidak Ada' || demarkasi === 'Warna Demarkasi Pudar'">
                                                        <x-kplh-texteditor wire:model="demarkasi_note"
                                                            id="demarkasi_note" placeholder="Komentar Demarkasi APAR"
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
                                            <label for="kain_pelindung" class="col-lg-4 col-md-12 col-form-label">Kain
                                                Pelindung
                                                APAR (Cover APAR)</label>
                                            <div class="col-lg-8 col-md-12">
                                                <div class="wrapper_inspeksi d-flex flex-column gap-3"
                                                    x-data="{ kain_pelindung: @entangle('kain_pelindung') }">

                                                    <x-inputs.select2 wire:model="kain_pelindung" id="kain_pelindung"
                                                        class="form-select" placeholder="Cover APAR">
                                                        <option value="Ada">Ada Pelindung</option>
                                                        <option value="Tidak Ada">Tidak Ada Pelindung</option>
                                                        <option value="Tidak Perlu Pelindung">Tidak Perlu Pelindung
                                                        </option>
                                                    </x-inputs.select2>

                                                    <div x-cloak x-show="kain_pelindung === 'Tidak Ada'">
                                                        <x-kplh-texteditor wire:model="kain_pelindung_note"
                                                            id="kain_pelindung_note" placeholder="Komentar Cover APAR"
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
                                                class="col-lg-4 col-md-12 col-form-label">Kondisi
                                                Kain
                                                Pelindung APAR (Cover APAR)</label>
                                            <div class="col-lg-8 col-md-12">
                                                <div class="wrapper_inspeksi d-flex flex-column gap-3"
                                                    x-data="{ kondisi_kain: @entangle('kondisi_kain') }">

                                                    <x-inputs.select2 wire:model="kondisi_kain" id="kondisi_kain"
                                                        class="form-select" placeholder="Kondisi Cover APAR">
                                                        <option value="Perlu Penggantian">Perlu Penggantian
                                                        </option>
                                                        <option value="Tidak Perlu Penggantian">Tidak Perlu
                                                            Penggantian
                                                        </option>
                                                    </x-inputs.select2>

                                                    <div x-cloak x-show="kondisi_kain === 'Perlu Penggantian'">
                                                        <x-kplh-texteditor wire:model="kondisi_kain_note"
                                                            id="kondisi_kain_note"
                                                            placeholder="Komentar Kondisi Cover APAR"
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
                                                APAR</label>
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
                                                            <option value="">Konsidi Penempatan</option>
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
