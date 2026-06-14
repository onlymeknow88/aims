<div class="inner-content">

    <div
        class="header-content-inspeksi-alat h-60px bg-white shadow-sm d-flex gap-2 align-items-center justify-content-between px-3">
        <div class="left-header">
            <a href="javascript:history.go(-1)" class="d-flex align-items-center gap-3">
                <span><i class="fa-solid fa-arrow-left"></i></span>
                <span>Inspeksi Alat K3 - Hydrant</span>
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
                            <h4>Inspeksi Alat K3 - Hydrant</h4>
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
                                                <select wire:model="kttId" id="kttId" class="form-control"
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

                            <div id="apab" class="section-apab" x-data="{ accordionOpen: true }">
                                <button
                                    class="header-accordion d-flex justify-content-between w-100 border-0 bg-white py-3 px-0"
                                    @click.prevent="accordionOpen = ! accordionOpen">
                                    <h6 class="mb-0 fw-normal title-accordion">Inspeksi Hydrant </h6>
                                    <span x-bind:class="accordionOpen ? 'open' : ''"><img
                                            src="{{ asset('/images/icons/angle-down.png') }}"
                                            alt="" /></span>
                                </button>
                                <div class="wrapper-content-accordion max-h-0 overflow-hidden position-relative transition-all duration-700"
                                    x-ref="apab" x-bind:style="accordionOpen ? 'max-height: ' + 20000 + 'px' : ''"
                                    x-transition.delay.5000ms>

                                    <div class="content-section p-4" wire:ignore.self>

                                        <div class="row mb-3 form-group">
                                            <label for="tool_id" class="col col-form-label">No. ID Hydrant</label>
                                            <div class="col-8">
                                                <x-inputs.text wire:model="tool_id" id="tool_id"
                                                    placeholder="No. ID Hydrant" :error="'tool_id'" />
                                            </div>
                                        </div><!-- /.form-group tool_id -->

                                        <div class="row mb-3 form-group">
                                            <label for="tool_type" class="col-lg-4 col-md-12 col-form-label">Tipe
                                                Hydrant</label>
                                            <div class="col-lg-8 col-md-12">
                                                <div class="wrapper_tool_type d-flex flex-column gap-3">

                                                    <x-inputs.select2 wire:model="tool_type" id="tool_type"
                                                        class="form-select" placeholder="Tipe Hydrant">
                                                        <option value="John Morish">John Morish</option>
                                                        <option value="Machino">Machino</option>
                                                        <option value="Storz">Storz</option>
                                                        <option value="Lainnya">Tipe Lainnya</option>
                                                    </x-inputs.select2>

                                                </div><!-- /.wrapper_tool_type -->
                                            </div><!-- /.col-lg-12 -->
                                        </div><!-- /.form-group tool_type -->

                                        <div class="row mb-3 form-group">
                                            <label for="ukuran_coupling"
                                                class="col-lg-4 col-md-12 col-form-label">Ukuran
                                                Coupling</label>
                                            <div class="col-lg-8 col-md-12">
                                                <div class="wrapper_inspeksi d-flex flex-column gap-3"
                                                    x-data="{ ukuran_coupling_2: @entangle('ukuran_coupling_2') }">

                                                    <x-inputs.select2 wire:model="ukuran_coupling"
                                                        id="ukuran_coupling" class="form-select"
                                                        placeholder="Ukuran Coupling">
                                                        <option value="1,5 Inch">1,5 Inch</option>
                                                        <option value="2,5 Inch">2,5 Inch</option>
                                                    </x-inputs.select2>

                                                    <x-inputs.select2 wire:model="ukuran_coupling_2"
                                                        id="ukuran_coupling_2" class="form-select"
                                                        placeholder="Versi Coupling">
                                                        <option value="Standard">Standard</option>
                                                        <option value="Tidak Standard">Tidak Standard</option>
                                                    </x-inputs.select2>

                                                    <div x-cloak x-show="ukuran_coupling_2 === 'Tidak Standard'">
                                                        <x-inputs.select2 wire:model="ukuran_coupling_3"
                                                            id="ukuran_coupling_3" class="form-select"
                                                            placeholder="Kondisi Ukuran Coupling">
                                                            <option value="Pecah, Penutup Hilang, Lainnya">Pecah,
                                                                Penutup Hilang, Lainnya
                                                            </option>
                                                            <option value="Penutup Hilang">Penutup Hilang</option>
                                                            <option value="Lainnya">Lainnya</option>
                                                        </x-inputs.select2>
                                                        <br>
                                                        <x-kplh-texteditor wire:model="ukuran_coupling_note"
                                                            id="ukuran_coupling_note"
                                                            placeholder="Komentar Ukuran Coupling" :error="'ukuran_coupling_note'" />

                                                        @if ($ukuran_coupling_file && !Illuminate\Support\Str::contains($ukuran_coupling_file, 'private/var/folders/'))
                                                            <div class="row mt-3">
                                                                <div class="col-md-3"><button type="button"
                                                                        class="btn btn-outline-secondary"
                                                                        wire:click="setFileNull('ukuran_coupling_file')"><i
                                                                            class="fa fa-edit"></i> Ubah
                                                                        File</button></div>
                                                                <div class="col-md-9">
                                                                    <a class="btn btn-outline-secondary"
                                                                        href="{{ route('kplh::download-file', ['k3', $ukuran_coupling_file]) }}"
                                                                        target="_blank"><i class="fa fa-file"></i>
                                                                        {{ Illuminate\Support\Str::limit($ukuran_coupling_file, 30) }}</a>
                                                                </div>
                                                            </div>
                                                        @else
                                                            <div class="col-md-12 mt-3">
                                                                <x-kplh-file wire:model="ukuran_coupling_file"
                                                                    id="ukuran_coupling_file" placeholder="File"
                                                                    :error="'ukuran_coupling_file'" />
                                                            </div>
                                                        @endif
                                                    </div>
                                                </div><!-- /.wrapper_inspeksi -->
                                            </div><!-- /.col-lg-12 -->
                                        </div><!-- /.form-group ukuran_coupling -->

                                        <div class="row mb-3 form-group">
                                            <label for="outer_pilar" class="col-lg-4 col-md-12 col-form-label">Jumlah
                                                Outer
                                                Pilar</label>
                                            <div class="col-lg-8 col-md-12">
                                                <div class="wrapper_inspeksi d-flex flex-column gap-3"
                                                    x-data="{ outer_pilar: @entangle('outer_pilar') }">
                                                    <x-inputs.select2 wire:model="outer_pilar" id="outer_pilar"
                                                        class="form-select" placeholder="Outer Pilar">
                                                        <option value="1">1</option>
                                                        <option value="2">2</option>
                                                    </x-inputs.select2>

                                                    <div x-cloak x-show="outer_pilar">
                                                        <x-kplh-texteditor wire:model="outer_pilar_note"
                                                            id="outer_pilar_note" placeholder="Komentar Outer Pilar"
                                                            :error="'outer_pilar_note'" />

                                                        @if ($outer_pilar_file && !Illuminate\Support\Str::contains($outer_pilar_file, 'private/var/folders/'))
                                                            <div class="row mt-3">
                                                                <div class="col-md-3"><button type="button"
                                                                        class="btn btn-outline-secondary"
                                                                        wire:click="setFileNull('outer_pilar_file')"><i
                                                                            class="fa fa-edit"></i> Ubah
                                                                        File</button></div>
                                                                <div class="col-md-9">
                                                                    <a class="btn btn-outline-secondary"
                                                                        href="{{ route('kplh::download-file', ['k3', $outer_pilar_file]) }}"
                                                                        target="_blank"><i class="fa fa-file"></i>
                                                                        {{ Illuminate\Support\Str::limit($outer_pilar_file, 30) }}</a>
                                                                </div>
                                                            </div>
                                                        @else
                                                            <div class="col-md-12 mt-3">
                                                                <x-kplh-file wire:model="outer_pilar_file"
                                                                    id="outer_pilar_file" placeholder="File"
                                                                    :error="'outer_pilar_file'" />
                                                            </div>
                                                        @endif
                                                    </div>
                                                </div><!-- /.wrapper_inspeksi -->
                                            </div><!-- /.col-lg-12 -->
                                        </div><!-- /.form-group outer_pilar -->

                                        <div class="row mb-3 form-group">
                                            <label for="hose_hydrant" class="col-lg-4 col-md-12 col-form-label">Hose
                                                Hydrant</label>
                                            <div class="col-lg-8 col-md-12">
                                                <div class="wrapper_inspeksi d-flex flex-column gap-3"
                                                    x-data="{ hose_hydrant_2: @entangle('hose_hydrant_2') }">

                                                    <x-inputs.select2 wire:model="hose_hydrant" id="hose_hydrant"
                                                        class="form-select" placeholder="Hose Hydrant">
                                                        <option value="Rubber">Rubber</option>
                                                        <option value="Canvas">Canvas</option>
                                                    </x-inputs.select2>

                                                    <x-inputs.select2 wire:model="hose_hydrant_2" id="hose_hydrant_2"
                                                        class="form-select" placeholder="Hose Hydrant">
                                                        <option value="Standard">Standard</option>
                                                        <option value="Tidak Standard">Tidak Standard</option>
                                                    </x-inputs.select2>

                                                    <div x-cloak x-show="hose_hydrant_2 === 'Tidak Standard'">
                                                        <x-inputs.select2 wire:model="hose_hydrant_3"
                                                            id="hose_hydrant_3" class="form-select"
                                                            placeholder="Kondisi Hose Hydrant">
                                                            <option value="Hose Robek">Hose Robek</option>
                                                            <option value="Coupling Diujung Pecah">Coupling Diujung
                                                                Pecah</option>
                                                            <option value="Seal Dalam Coupling Hose Rusak/Hilang">Seal
                                                                Dalam Coupling Hose Rusak /
                                                                Hilang</option>
                                                            <option value="Saat Dipasang ke Pilar Tidak Proper">Saat
                                                                Dipasang ke Pilar Tidak
                                                                Proper</option>
                                                            <option value="Hilang">Hilang</option>
                                                        </x-inputs.select2>
                                                        <br>
                                                        <x-kplh-texteditor wire:model="hose_hydrant_note"
                                                            id="hose_hydrant_note" placeholder="Komentar Hose Hydrant"
                                                            :error="'hose_hydrant_note'" />

                                                        @if ($hose_hydrant_file && !Illuminate\Support\Str::contains($hose_hydrant_file, 'private/var/folders/'))
                                                            <div class="row mt-3">
                                                                <div class="col-md-3"><button type="button"
                                                                        class="btn btn-outline-secondary"
                                                                        wire:click="setFileNull('hose_hydrant_file')"><i
                                                                            class="fa fa-edit"></i> Ubah
                                                                        File</button></div>
                                                                <div class="col-md-9">
                                                                    <a class="btn btn-outline-secondary"
                                                                        href="{{ route('kplh::download-file', ['k3', $hose_hydrant_file]) }}"
                                                                        target="_blank"><i class="fa fa-file"></i>
                                                                        {{ Illuminate\Support\Str::limit($hose_hydrant_file, 30) }}</a>
                                                                </div>
                                                            </div>
                                                        @else
                                                            <div class="col-md-12 mt-3">
                                                                <x-kplh-file wire:model="hose_hydrant_file"
                                                                    id="hose_hydrant_file" placeholder="File"
                                                                    :error="'hose_hydrant_file'" />
                                                            </div>
                                                        @endif
                                                    </div>
                                                </div><!-- /.wrapper_inspeksi -->
                                            </div><!-- /.col-lg-12 -->
                                        </div><!-- /.form-group hose_hydrant -->

                                        <div class="row mb-3 form-group">
                                            <label for="ukuran_hose" class="col-lg-4 col-md-12 col-form-label">Ukuran
                                                Hose</label>
                                            <div class="col-lg-8 col-md-12">
                                                <div class="wrapper_inspeksi d-flex flex-column gap-3"
                                                    x-data="{ ukuran_hose: @entangle('ukuran_hose') }">

                                                    <x-inputs.select2 wire:model="ukuran_hose" id="ukuran_hose"
                                                        class="form-select" placeholder="Ukuran Hose">
                                                        <option value="1,5 Inch">1,5 Inch</option>
                                                        <option value="2,5 Inch">2,5 Inch</option>
                                                    </x-inputs.select2>

                                                    <div x-cloak x-show="ukuran_hose">
                                                        <x-kplh-texteditor wire:model="ukuran_hose_note"
                                                            id="ukuran_hose_note" placeholder="Komentar Ukuran Hose"
                                                            :error="'ukuran_hose_note'" />

                                                        @if ($ukuran_hose_file && !Illuminate\Support\Str::contains($ukuran_hose_file, 'private/var/folders/'))
                                                            <div class="row mt-3">
                                                                <div class="col-md-3"><button type="button"
                                                                        class="btn btn-outline-secondary"
                                                                        wire:click="setFileNull('ukuran_hose_file')"><i
                                                                            class="fa fa-edit"></i> Ubah
                                                                        File</button></div>
                                                                <div class="col-md-9">
                                                                    <a class="btn btn-outline-secondary"
                                                                        href="{{ route('kplh::download-file', ['k3', $ukuran_hose_file]) }}"
                                                                        target="_blank"><i class="fa fa-file"></i>
                                                                        {{ Illuminate\Support\Str::limit($ukuran_hose_file, 30) }}</a>
                                                                </div>
                                                            </div>
                                                        @else
                                                            <div class="col-md-12 mt-3">
                                                                <x-kplh-file wire:model="ukuran_hose_file"
                                                                    id="ukuran_hose_file" placeholder="File"
                                                                    :error="'ukuran_hose_file'" />
                                                            </div>
                                                        @endif
                                                    </div>
                                                </div><!-- /.wrapper_inspeksi -->
                                            </div><!-- /.col-lg-12 -->
                                        </div><!-- /.form-group ukuran_hose -->

                                        <div class="row mb-3 form-group">
                                            <label for="type_nozzle" class="col-lg-4 col-md-12 col-form-label">Type
                                                Nozzle</label>
                                            <div class="col-lg-8 col-md-12">
                                                <div class="wrapper_inspeksi d-flex flex-column gap-3"
                                                    x-data="{ type_nozzle_2: @entangle('type_nozzle_2') }">
                                                    <x-inputs.select2 wire:model="type_nozzle" id="type_nozzle"
                                                        class="form-select" placeholder="Type Nozzle">
                                                        <option value="Hydrant Straight Nozzle">Hydrant Straight Nozzle
                                                        </option>
                                                        <option value="Variable Head Spray">Variable Head
                                                            Spray
                                                        </option>
                                                        <option value="Gun Nozzle">Gun Nozzle</option>
                                                        <option value="Jenis Lainnya">Jenis Lainnya</option>
                                                    </x-inputs.select2>

                                                    <x-inputs.select2 wire:model="type_nozzle_2" id="type_nozzle_2"
                                                        class="form-select" placeholder="Versi Nozzle">
                                                        <option value="Standard">Standard</option>
                                                        <option value="Tidak Standard">Tidak Standard</option>
                                                    </x-inputs.select2>

                                                    <div x-cloak x-show="type_nozzle_2 === 'Tidak Standard'">
                                                        <x-inputs.select2 wire:model="type_nozzle_3"
                                                            id="type_nozzle_3" class="form-select"
                                                            placeholder="Kondisi Nozzle Hydrant">
                                                            <option value="Kondisi Fisik Rusak">Kondisi Fisik Rusak
                                                            </option>
                                                            <option value="Tidak Dapat Tersambung Dengan Hose">Tidak
                                                                Dapat Tersambung
                                                                Dengan
                                                                Hose
                                                            </option>
                                                            <option value="Tersumbat">Tersumbat</option>
                                                            <option value="Hilang">Hilang</option>
                                                        </x-inputs.select2>
                                                        <br>
                                                        <x-kplh-texteditor wire:model="type_nozzle_note"
                                                            id="type_nozzle_note" placeholder="Komentar Type Nozzle"
                                                            :error="'type_nozzle_note'" />

                                                        @if ($type_nozzle_file && !Illuminate\Support\Str::contains($type_nozzle_file, 'private/var/folders/'))
                                                            <div class="row mt-3">
                                                                <div class="col-md-3"><button type="button"
                                                                        class="btn btn-outline-secondary"
                                                                        wire:click="setFileNull('type_nozzle_file')"><i
                                                                            class="fa fa-edit"></i> Ubah
                                                                        File</button></div>
                                                                <div class="col-md-9">
                                                                    <a class="btn btn-outline-secondary"
                                                                        href="{{ route('kplh::download-file', ['k3', $type_nozzle_file]) }}"
                                                                        target="_blank"><i class="fa fa-file"></i>
                                                                        {{ Illuminate\Support\Str::limit($type_nozzle_file, 30) }}</a>
                                                                </div>
                                                            </div>
                                                        @else
                                                            <div class="col-md-12 mt-3">
                                                                <x-kplh-file wire:model="type_nozzle_file"
                                                                    id="type_nozzle_file" placeholder="File"
                                                                    :error="'type_nozzle_file'" />
                                                            </div>
                                                        @endif
                                                    </div>
                                                </div><!-- /.wrapper_inspeksi -->
                                            </div><!-- /.col-lg-12 -->
                                        </div><!-- /.form-group type_nozzle -->

                                        <div class="row mb-3 form-group">
                                            <label for="box_hydrant" class="col-lg-4 col-md-12 col-form-label">Box
                                                Hydrant</label>
                                            <div class="col-lg-8 col-md-12">

                                                <div class="wrapper_inspeksi d-flex flex-column gap-3"
                                                    x-data="{ box_hydrant: @entangle('box_hydrant') }">

                                                    <x-inputs.select2 wire:model="box_hydrant" id="box_hydrant"
                                                        class="form-select" placeholder="Box Hydrant">
                                                        <option value="Standard">Standard</option>
                                                        <option value="Tidak Standard">Tidak Standard</option>
                                                    </x-inputs.select2>

                                                    <div x-cloak x-show="box_hydrant === 'Tidak Standard'">
                                                        <x-inputs.select2 wire:model="box_hydrant_2"
                                                            id="box_hydrant_2" class="form-select"
                                                            placeholder="Kondisi Box Hydrant">
                                                            <option value="Cat Pudar">Cat Pudar</option>
                                                            <option value="Berkarat">Berkarat</option>
                                                            <option value="Penyok">Penyok</option>
                                                        </x-inputs.select2>
                                                        <br>
                                                        <x-kplh-texteditor wire:model="box_hydrant_note"
                                                            id="box_hydrant_note" placeholder="Komentar Box Hydrant"
                                                            :error="'box_hydrant_note'" />

                                                        @if ($box_hydrant_file && !Illuminate\Support\Str::contains($box_hydrant_file, 'private/var/folders/'))
                                                            <div class="row mt-3">
                                                                <div class="col-md-3"><button type="button"
                                                                        class="btn btn-outline-secondary"
                                                                        wire:click="setFileNull('box_hydrant_file')"><i
                                                                            class="fa fa-edit"></i> Ubah
                                                                        File</button></div>
                                                                <div class="col-md-9">
                                                                    <a class="btn btn-outline-secondary"
                                                                        href="{{ route('kplh::download-file', ['k3', $box_hydrant_file]) }}"
                                                                        target="_blank"><i class="fa fa-file"></i>
                                                                        {{ Illuminate\Support\Str::limit($box_hydrant_file, 30) }}</a>
                                                                </div>
                                                            </div>
                                                        @else
                                                            <div class="col-md-12 mt-3">
                                                                <x-kplh-file wire:model="box_hydrant_file"
                                                                    id="box_hydrant_file" placeholder="File"
                                                                    :error="'box_hydrant_file'" />
                                                            </div>
                                                        @endif
                                                    </div>
                                                </div><!-- /.wrapper_inspeksi -->
                                            </div><!-- /.col-lg-12 -->
                                        </div><!-- /.form-group box_hydrant -->

                                        <div class="row mb-3 form-group">
                                            <label for="penempatan" class="col-lg-4 col-md-12 col-form-label">Kondisi
                                                Penempatan
                                                Hydrant</label>
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
                                        </div><!-- /.form-group penempatan -->

                                        <div class="row mb-3 form-group">
                                            <label for="kip" class="col-lg-4 col-md-12 col-form-label">KIP (Kartu
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
                                                        <x-inputs.select2 x-cloak x-ref='kip_2'
                                                            x-show="kip === 'Tidak Standard'" wire:model="kip_2"
                                                            id="kip_2" class="form-select"
                                                            placeholder="Kondisi KIP">
                                                            <option value="Belum Diperiksa">Belum Diperiksa</option>
                                                            <option value="KIP Hilang">KIP Hilang</option>
                                                            <option value="KIP Rusak">KIP Rusak</option>
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
                                            <label for="label_penanda" class="col-lg-4 col-md-12 col-form-label">Label
                                                Penanda
                                                Lokasi Hydrant</label>
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
                                                Hydrant</label>
                                            <div class="col-lg-8 col-md-12">
                                                <div class="wrapper_inspeksi d-flex flex-column gap-3"
                                                    x-data="{ demarkasi: @entangle('demarkasi') }">

                                                    <x-inputs.select2 wire:model="demarkasi" id="demarkasi"
                                                        class="form-select" placeholder="Demarkasi Hydrant">
                                                        <option value="Ada Demarkasi">Ada Demarkasi</option>
                                                        <option value="Warna Demarkasi Pudar">Warna Demarkasi Pudar
                                                        </option>
                                                        <option value="Tidak Ada">Tidak Ada Demarkasi</option>
                                                    </x-inputs.select2>

                                                    <div x-cloak
                                                        x-show="demarkasi === 'Warna Demarkasi Pudar' || demarkasi === 'Tidak Ada'">
                                                        <x-kplh-texteditor wire:model="demarkasi_note"
                                                            id="demarkasi_note"
                                                            placeholder="Komentar Demarkasi Hydrant"
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
                                            <label for="velve_pipa" class="col-lg-4 col-md-12 col-form-label">Kondisi
                                                Valve Pipa
                                                Air</label>
                                            <div class="col-lg-8 col-md-12">
                                                <div class="wrapper_inspeksi d-flex flex-column gap-3"
                                                    x-data="{ velve_pipa: @entangle('velve_pipa') }">

                                                    <x-inputs.select2 wire:model="velve_pipa" id="velve_pipa"
                                                        class="form-select" placeholder="Velve Pipa">
                                                        <option value="Standard">Standard</option>
                                                        <option value="Tidak Standard">Tidak Standard</option>
                                                    </x-inputs.select2>

                                                    <div x-cloak x-show="velve_pipa === 'Tidak Standard'">
                                                        <x-inputs.select2 x-cloak x-ref='velve_pipa_2'
                                                            x-show="velve_pipa === 'Tidak Standard'"
                                                            wire:model="velve_pipa_2" id="velve_pipa_2"
                                                            class="form-select" placeholder="Kondisi Velve Pipa">
                                                            <option value="Bocor">Bocor</option>
                                                            <option value="Berkarat">Berkarat</option>
                                                            <option value="Patah">Patah</option>
                                                        </x-inputs.select2>
                                                        <br>
                                                        <x-kplh-texteditor wire:model="velve_pipa_note"
                                                            id="velve_pipa_note" placeholder="Komentar Velve Pipa"
                                                            :error="'velve_pipa_note'" />

                                                        @if ($velve_pipa_file && !Illuminate\Support\Str::contains($velve_pipa_file, 'private/var/folders/'))
                                                            <div class="row mt-3">
                                                                <div class="col-md-3"><button type="button"
                                                                        class="btn btn-outline-secondary"
                                                                        wire:click="setFileNull('velve_pipa_file')"><i
                                                                            class="fa fa-edit"></i> Ubah
                                                                        File</button></div>
                                                                <div class="col-md-9">
                                                                    <a class="btn btn-outline-secondary"
                                                                        href="{{ route('kplh::download-file', ['k3', $velve_pipa_file]) }}"
                                                                        target="_blank"><i class="fa fa-file"></i>
                                                                        {{ Illuminate\Support\Str::limit($velve_pipa_file, 30) }}</a>
                                                                </div>
                                                            </div>
                                                        @else
                                                            <div class="col-md-12 mt-3">
                                                                <x-kplh-file wire:model="velve_pipa_file"
                                                                    id="velve_pipa_file" placeholder="File"
                                                                    :error="'velve_pipa_file'" />
                                                            </div>
                                                        @endif
                                                    </div>
                                                </div><!-- /.wrapper_inspeksi -->
                                            </div><!-- /.col-lg-12 -->
                                        </div><!-- /.form-group velve_pipa -->

                                    </div>
                                </div>
                            </div><!-- /.form-group hydrant-k11 -->

                        </div><!-- /.content-form -->

                        <hr>
                        <div class="row form-group">
                            <label for="summary" class="col col-form-label">Ringkasan Hasil
                                Inspeksi</label>
                            <div class="col-8">
                                <x-kplh-texteditor wire:model="summary" id="summary"
                                    placeholder="Ringkasan Hasil Inspeksi" :error="'summary'" />
                            </div>
                        </div><!-- /.form-group summary -->


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
    </div><!-- /.content-inspeksi-alat -->

</div><!-- /.inner-content -->
