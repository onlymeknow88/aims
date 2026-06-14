<div class="inner-content">

    <div
        class="header-content-inspeksi-alat h-60px bg-white shadow-sm d-flex gap-2 align-items-center justify-content-between px-3">
        <div class="left-header">
            <a href="javascript:history.go(-1)" class="d-flex align-items-center gap-3">
                <span><i class="fa-solid fa-arrow-left"></i></span>
                <span>Inspeksi Alat K3 - Hose Rail</span>
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
                            <h4>Inspeksi Alat K3 - Hose Rail</h4>
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

                            <div id="hose-rail" class="section-hose-rail" x-data="{ accordionOpen: true }">
                                <button
                                    class="header-accordion d-flex justify-content-between w-100 border-0 bg-white py-3 px-0"
                                    @click.prevent="accordionOpen = ! accordionOpen">
                                    <h6 class="mb-0 fw-normal title-accordion">Inspeksi Hose Rail </h6>
                                    <span x-bind:class="accordionOpen ? 'open' : ''"><img
                                            src="{{ asset('/images/icons/angle-down.png') }}"
                                            alt="" /></span>
                                </button>
                                <div class="wrapper-content-accordion max-h-0 overflow-hidden position-relative transition-all duration-700"
                                    x-ref="hose-rail" x-bind:style="accordionOpen ? 'max-height: ' + 20000 + 'px' : ''"
                                    x-transition.delay.5000ms>

                                    <div class="content-section p-4" wire:ignore.self>

                                        <div class="row mb-3 form-group">
                                            <label for="tool_id" class="col col-form-label">No. ID Hose Rail</label>
                                            <div class="col-8">
                                                <x-inputs.text wire:model="tool_id" id="tool_id"
                                                    placeholder="No. ID Hose Rail" :error="'tool_id'" />
                                            </div>
                                        </div><!-- /.form-group tool_id -->

                                        <div class="row mb-3 form-group">
                                            <label for="tool_type" class="col-lg-4 col-md-12 col-form-label">Tipe
                                                Hose Rail</label>
                                            <div class="col-lg-8 col-md-12">
                                                <div class="wrapper_tool_type d-flex flex-column gap-3">

                                                    <x-inputs.select2 wire:model="tool_type" id="tool_type"
                                                        class="form-select" placeholder="Tipe Hose Rail">
                                                        <option value="John Morish">John Morish</option>
                                                        <option value="Machino">Machino</option>
                                                        <option value="Storz">Storz</option>
                                                        <option value="Tipe Lainnya">Tipe Lainnya</option>
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
                                                        <br>
                                                        <x-kplh-file wire:model="ukuran_coupling_file"
                                                            id="ukuran_coupling_file" placeholder="Choose File"
                                                            :error="'ukuran_coupling_file'" />
                                                    </div>
                                                </div><!-- /.wrapper_inspeksi -->
                                            </div><!-- /.col-lg-12 -->
                                        </div><!-- /.form-group ukuran_coupling -->

                                        <div class="row mb-3 form-group">
                                            <label for="jenis_hose_rail"
                                                class="col-lg-4 col-md-12 col-form-label">Jenis
                                                Hose Rail</label>
                                            <div class="col-lg-8 col-md-12">

                                                <div class="wrapper_inspeksi d-flex flex-column gap-3"
                                                    x-data="{ jenis_hose_rail_2: @entangle('jenis_hose_rail_2') }">

                                                    <x-inputs.select2 wire:model="jenis_hose_rail"
                                                        id="jenis_hose_rail" class="form-select"
                                                        placeholder="Hose Rail">
                                                        <option value="Rubber">Rubber</option>
                                                        <option value="Canvas">Canvas</option>
                                                    </x-inputs.select2>

                                                    <x-inputs.select2 wire:model="jenis_hose_rail_2"
                                                        id="jenis_hose_rail_2" class="form-select"
                                                        placeholder="Hose Rail">
                                                        <option value="Standard">Standard</option>
                                                        <option value="Tidak Standard">Tidak Standard</option>
                                                    </x-inputs.select2>

                                                    <div x-cloak x-show="jenis_hose_rail_2 === 'Tidak Standard'">
                                                        <x-inputs.select2 wire:model="jenis_hose_rail_3"
                                                            id="jenis_hose_rail_3" class="form-select"
                                                            placeholder="Kondisi Hose Rail">
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
                                                        <x-kplh-texteditor wire:model="jenis_hose_rail_note"
                                                            id="jenis_hose_rail_note" placeholder="Komentar Hose Rail"
                                                            :error="'jenis_hose_rail_note'" />
                                                        <br>
                                                        <x-kplh-file wire:model="jenis_hose_rail_file"
                                                            id="jenis_hose_rail_file" placeholder="Choose File"
                                                            :error="'jenis_hose_rail_file'" />
                                                    </div>
                                                </div><!-- /.wrapper_inspeksi -->
                                            </div><!-- /.col-lg-12 -->
                                        </div><!-- /.form-group jenis_hose_rail -->

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
                                                        <br>
                                                        <x-kplh-file wire:model="ukuran_hose_file"
                                                            id="ukuran_hose_file" placeholder="Choose File"
                                                            :error="'ukuran_hose_file'" />
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
                                                        <br>
                                                        <x-kplh-file wire:model="type_nozzle_file"
                                                            id="type_nozzle_file" placeholder="Choose File"
                                                            :error="'type_nozzle_file'" />
                                                    </div>
                                                </div><!-- /.wrapper_inspeksi -->
                                            </div><!-- /.col-lg-12 -->
                                        </div><!-- /.form-group type_nozzle -->

                                        <div class="row mb-3 form-group">
                                            <label for="box_hr" class="col-lg-4 col-md-12 col-form-label">Box
                                                Hose Rail</label>
                                            <div class="col-lg-8 col-md-12">
                                                <div class="wrapper_inspeksi d-flex flex-column gap-3"
                                                    x-data="{ box_hr: @entangle('box_hr') }">

                                                    <x-inputs.select2 wire:model="box_hr" id="box_hr"
                                                        class="form-select" placeholder="Box Hose Rail">
                                                        <option value="Standard">Standard</option>
                                                        <option value="Tidak Standard">Tidak Standard</option>
                                                    </x-inputs.select2>

                                                    <div x-cloak x-show="box_hr === 'Tidak Standard'">
                                                        <x-inputs.select2 wire:model="box_hr_2" id="box_hr_2"
                                                            class="form-select" placeholder="Kondisi Box Hose Rail">
                                                            <option value="Cat Pudar">Cat Pudar</option>
                                                            <option value="Berkarat">Berkarat</option>
                                                            <option value="Penyok">Penyok</option>
                                                        </x-inputs.select2>
                                                        <br>
                                                        <x-kplh-texteditor wire:model="box_hr_note" id="box_hr_note"
                                                            placeholder="Komentar Box Hose Rail" :error="'box_hr_note'" />
                                                        <br>
                                                        <x-kplh-file wire:model="box_hr_file" id="box_hr_file"
                                                            placeholder="Choose File" :error="'box_hr_file'" />
                                                    </div>
                                                </div><!-- /.wrapper_inspeksi -->
                                            </div><!-- /.col-lg-12 -->
                                        </div><!-- /.form-group box_hr -->

                                        <div class="row mb-3 form-group">
                                            <label for="penempatan" class="col-lg-4 col-md-12 col-form-label">Kondisi
                                                Penempatan
                                                Hose Rail</label>
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
                                                        <br>
                                                        <x-kplh-file wire:model="penempatan_file" id="penempatan_file"
                                                            placeholder="Choose File" :error="'penempatan_file'" />
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
                                                        <x-inputs.select2 id="kip_2" class="form-select"
                                                            placeholder="Kondisi KIP">
                                                            <option value="Belum Diperiksa">Belum Diperiksa</option>
                                                            <option value="KIP Hilang">KIP Hilang</option>
                                                            <option value="KIP Rusak">KIP Rusak</option>
                                                        </x-inputs.select2>
                                                        <br>
                                                        <x-kplh-texteditor wire:model="kip_note" id="kip_note"
                                                            placeholder="Komentar KIP" :error="'kip_note'" />
                                                        <br>
                                                        <x-kplh-file wire:model="kip_file" id="kip_file"
                                                            placeholder="Choose File" :error="'kip_file'" />
                                                    </div>
                                                </div><!-- /.wrapper_inspeksi -->
                                            </div><!-- /.col-lg-12 -->
                                        </div><!-- /.form-group kip -->

                                        <div class="row mb-3 form-group">
                                            <label for="label_penanda" class="col-lg-4 col-md-12 col-form-label">Label
                                                Penanda
                                                Lokasi Hose Rail</label>
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
                                                        <br>
                                                        <x-kplh-file wire:model="label_penanda_file"
                                                            id="label_penanda_file" placeholder="Choose File"
                                                            :error="'label_penanda_file'" />
                                                    </div>
                                                </div><!-- /.wrapper_inspeksi -->
                                            </div><!-- /.col-lg-12 -->
                                        </div><!-- /.form-group label_penanda -->

                                        <div class="row mb-3 form-group">
                                            <label for="demarkasi" class="col-lg-4 col-md-12 col-form-label">Demarkasi
                                                Hose Rail</label>
                                            <div class="col-lg-8 col-md-12">
                                                <div class="wrapper_inspeksi d-flex flex-column gap-3"
                                                x-data="{ demarkasi: @entangle('demarkasi') }">

                                                    <x-inputs.select2 wire:model="demarkasi" id="demarkasi"
                                                        class="form-select" placeholder="Demarkasi Hose Rail">
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
                                                        <br>
                                                        <x-kplh-file wire:model="demarkasi_file" id="demarkasi_file"
                                                            placeholder="Choose File" :error="'demarkasi_file'" />
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
                                                        <br>
                                                        <x-kplh-file wire:model="velve_pipa_file" id="velve_pipa_file"
                                                            placeholder="Choose File" :error="'velve_pipa_file'" />
                                                    </div>
                                                </div><!-- /.wrapper_inspeksi -->
                                            </div><!-- /.col-lg-12 -->
                                        </div><!-- /.form-group velve_pipa -->

                                    </div>
                                </div>
                            </div><!-- /.form-group hr-k11 -->

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
