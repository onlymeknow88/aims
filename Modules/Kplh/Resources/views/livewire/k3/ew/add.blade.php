<div class="inner-content">

    <div
        class="header-content-inspeksi-alat h-60px bg-white shadow-sm d-flex gap-2 align-items-center justify-content-between px-3">
        <div class="left-header">
            <a href="javascript:history.go(-1)" class="d-flex align-items-center gap-3">
                <span><i class="fa-solid fa-arrow-left"></i></span>
                <span>Inspeksi Alat K3 - Eye Wash</span>
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
                            <h4>Inspeksi Alat K3 - Eye Wash</h4>
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
                                                        <select class="form-control" disabled></select>
                                                    @endif --}}

                                                </div><!-- /.wrapper_petugas -->
                                            </div>
                                        </div><!-- /.form-group inspectionOfficer -->

                                    </div><!-- ./content-label -->
                                </div>
                            </div><!-- /.label -->

                            <div id="eye-wash" class="section-eye-wash" x-data="{ accordionOpen: true }">
                                <button
                                    class="header-accordion d-flex justify-content-between w-100 border-0 bg-white py-3 px-0"
                                    @click.prevent="accordionOpen = ! accordionOpen">
                                    <h6 class="mb-0 fw-normal title-accordion">Inspeksi Eye Wash</h6>
                                    <span x-bind:class="accordionOpen ? 'open' : ''"><img
                                            src="{{ asset('/images/icons/angle-down.png') }}"
                                            alt="" /></span>
                                </button>
                                <div class="wrapper-content-accordion max-h-0 overflow-hidden position-relative transition-all duration-700"
                                    x-ref="eye-wash" x-bind:style="accordionOpen ? 'max-height: ' + 20000 + 'px' : ''"
                                    x-transition.delay.5000ms>

                                    <div class="content-section p-4" wire:ignore.self>

                                        <div class="row mb-3 form-group">
                                            <label for="tool_id" class="col col-form-label">No. ID Eye Wash</label>
                                            <div class="col-8">
                                                <x-inputs.text wire:model="tool_id" id="tool_id"
                                                    placeholder="No. ID Eye Wash" :error="'tool_id'" />
                                            </div>
                                        </div><!-- /.form-group tool_id -->

                                        <div class="row mb-3 form-group">
                                            <label for="tool_type" class="col-lg-4 col-md-12 col-form-label">Merk Eye
                                                Wash</label>
                                            <div class="col-lg-8 col-md-12">
                                                <div class="wrapper_tool_type d-flex flex-column gap-3">

                                                    <x-inputs.select2 wire:model="tool_type" id="tool_type"
                                                        class="form-select" placeholder="Merk Eye Wash">
                                                        <option value="Sperian">Sperian</option>
                                                        <option value="Haws">Haws</option>
                                                        <option value="Honeywell">Honeywell</option>
                                                        <option value="Krisbow">Krisbow</option>
                                                        <option value="Tipe Lainnya">Tipe Lainnya</option>
                                                    </x-inputs.select2>

                                                </div><!-- /.wrapper_tool_type -->
                                            </div><!-- /.col-lg-12 -->
                                        </div><!-- /.form-group tool_type -->

                                        <div class="row mb-3 form-group">
                                            <label for="type_eye_wash" class="col-lg-4 col-md-12 col-form-label">Tipe
                                                Eye Wash</label>
                                            <div class="col-lg-8 col-md-12">
                                                <div class="wrapper_inspeksi d-flex flex-column gap-3"
                                                    x-data="{ type_eye_wash: @entangle('type_eye_wash') }">

                                                    <x-inputs.select2 wire:model="type_eye_wash" id="type_eye_wash"
                                                        class="form-select" placeholder="Type Eye Wash">
                                                        <option value="Permanen">Permanen</option>
                                                        <option value="Portable">Portable</option>
                                                    </x-inputs.select2>

                                                    <div x-cloak x-show="type_eye_wash">
                                                        <x-kplh-texteditor wire:model="type_eye_wash_note"
                                                            id="type_eye_wash_note"
                                                            placeholder="Komentar Type Eye Wash" :error="'type_eye_wash_note'" />
                                                        <br>
                                                        <x-kplh-file wire:model="type_eye_wash_file"
                                                            id="type_eye_wash_file" placeholder="Choose File"
                                                            :error="'type_eye_wash_file'" />
                                                    </div>

                                                </div><!-- /.wrapper_inspeksi -->
                                            </div><!-- /.col-lg-12 -->
                                        </div><!-- /.form-group type_eye_wash -->

                                        <div class="row mb-3 form-group">
                                            <label for="kondisi_tangki"
                                                class="col-lg-4 col-md-12 col-form-label">Kondisi Tangki</label>
                                            <div class="col-lg-8 col-md-12">
                                                <div class="wrapper_inspeksi d-flex flex-column gap-3"
                                                    x-data="{ kondisi_tangki: @entangle('kondisi_tangki') }">

                                                    <x-inputs.select2 wire:model="kondisi_tangki" id="kondisi_tangki"
                                                        class="form-select" placeholder="Kondisi Tangki">
                                                        <option value="Standard">Standard</option>
                                                        <option value="Tidak Standard">Tidak Standard</option>
                                                    </x-inputs.select2>

                                                    <div x-cloak x-show="kondisi_tangki === 'Tidak Standard'">

                                                        <x-inputs.select2 wire:model="kondisi_tangki_2"
                                                            id="kondisi_tangki_2" class="form-select"
                                                            placeholder="Kondisi Tangki">
                                                            <option value="Pecah">Pecah</option>
                                                            <option value="Penutup Hilang">Penutup Hilang</option>
                                                            <option value="Rusak Lainnya">Rusak Lainnya</option>
                                                        </x-inputs.select2>
                                                        <br>
                                                        <x-kplh-texteditor wire:model="kondisi_tangki_note"
                                                            id="kondisi_tangki_note"
                                                            placeholder="Komentar Kondisi Tangki" :error="'kondisi_tangki_note'" />
                                                        <br>
                                                        <x-kplh-file wire:model="kondisi_tangki_file"
                                                            id="kondisi_tangki_file" placeholder="Choose File"
                                                            :error="'kondisi_tangki_file'" />
                                                    </div>
                                                </div><!-- /.wrapper_inspeksi -->
                                            </div><!-- /.col-lg-12 -->
                                        </div><!-- /.form-group kondisi_tangki -->

                                        <div class="row mb-3 form-group">
                                            <label for="kondisi_air" class="col-lg-4 col-md-12 col-form-label">Kondisi
                                                Air Didalam Tangki</label>
                                            <div class="col-lg-8 col-md-12">

                                                <div class="wrapper_inspeksi d-flex flex-column gap-3"
                                                    x-data="{ kondisi_air: @entangle('kondisi_air') }">

                                                    <x-inputs.select2 wire:model="kondisi_air" id="kondisi_air"
                                                        class="form-select" placeholder="Kondisi Air">
                                                        <option value="Standard">Standard</option>
                                                        <option value="Tidak Standard">Tidak Standard</option>
                                                    </x-inputs.select2>

                                                    <div x-cloak x-show="kondisi_air === 'Tidak Standard'">
                                                        <x-inputs.select2 wire:model="kondisi_air_2"
                                                            id="kondisi_air_2" class="form-select"
                                                            placeholder="Kondisi Air">
                                                            <option value="Keruh">Keruh</option>
                                                            <option value="Bau">Bau</option>
                                                            <option value="Kurang">Kurang</option>
                                                            <option value="Habis / Kosong">Habis / Kosong</option>
                                                        </x-inputs.select2>
                                                        <br>
                                                        <x-kplh-texteditor wire:model="kondisi_air_note"
                                                            id="kondisi_air_note" placeholder="Komentar Kondisi Air"
                                                            :error="'kondisi_air_note'" />
                                                        <br>
                                                        <x-kplh-file wire:model="kondisi_air_file"
                                                            id="kondisi_air_file" placeholder="Choose File"
                                                            :error="'kondisi_air_file'" />
                                                    </div>
                                                </div><!-- /.wrapper_inspeksi -->
                                            </div><!-- /.col-lg-12 -->
                                        </div><!-- /.form-group kondisi_air -->

                                        <div class="row mb-3 form-group">
                                            <label for="pancuran_air"
                                                class="col-lg-4 col-md-12 col-form-label">Pancuran Air</label>
                                            <div class="col-lg-8 col-md-12">
                                                <div class="wrapper_inspeksi d-flex flex-column gap-3"
                                                    x-data="{ pancuran_air: @entangle('pancuran_air') }">

                                                    <x-inputs.select2 wire:model="pancuran_air" id="pancuran_air"
                                                        class="form-select" placeholder="Kondisi Pancuran Air">
                                                        <option value="Standard">Standard</option>
                                                        <option value="Tidak Standard">Tidak Standard</option>
                                                    </x-inputs.select2>

                                                    <di x-cloak x-show="pancuran_air === 'Tidak Standard'">
                                                        <x-inputs.select2 wire:model="pancuran_air_2"
                                                            id="pancuran_air_2" class="form-select"
                                                            placeholder="Kondisi Pancuran Air">
                                                            <option value="Tersumbat">Tersumbat</option>
                                                            <option value="Lainnya">Lainnya</option>
                                                        </x-inputs.select2>
                                                        <br>
                                                        <x-kplh-texteditor wire:model="pancuran_air_note"
                                                            id="pancuran_air_note" placeholder="Komentar Pancuran Air"
                                                            :error="'pancuran_air_note'" />
                                                        <br>
                                                        <x-kplh-file wire:model="pancuran_air_file"
                                                            id="pancuran_air_file" placeholder="Choose File"
                                                            :error="'pancuran_air_file'" />
                                                </div>
                                            </div><!-- /.wrapper_inspeksi -->
                                        </div><!-- /.col-lg-12 -->
                                    </div><!-- /.form-group pancuran_air -->

                                </div>
                            </div>
                        </div><!-- /.form-group hr-k11 -->

                        <hr>
                        <div class="row mb-3 form-group">
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

                </div><!-- /.content-form -->

            </div>
        </div>
    </div>
</div><!-- /.content-inspeksi-alat -->

</div><!-- /.inner-content -->
