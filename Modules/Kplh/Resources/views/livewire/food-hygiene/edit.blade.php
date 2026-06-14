<div class="inner-content">

    <div
        class="header-content-inspeksi-food-hygiene h-60px bg-white shadow-sm d-flex gap-2 align-items-center justify-content-between px-3">
        <div class="left-header">
            <a href="javascript:history.go(-1)" class="d-flex align-items-center gap-3">
                <span><i class="fa-solid fa-arrow-left"></i></span>
                <span>Inspeksi Food Hygiene</span>
            </a>
        </div><!-- /.left-header -->
    </div><!-- /.header-content-inspeksi-food-hygiene -->

    <div class="content-inspeksi-food-hygiene">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-12 col-md-12 col-lg-8">

                    <form class="py-4 d-flex flex-column gap-5" action="#" action="post"
                        wire:submit.prevent='save'>

                        <div class="title-form text-center my-3">
                            <h4>Inspeksi Food Hygiene</h4>
                        </div><!-- /.title-form -->

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

                                            <x-inputs.select2 id="ccow_id" placeholder="CCOW" :error="'ccow_id'"
                                                wire:model.defer="ccow_id">
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
                                            <x-inputs.select2 wire:model="companyId" id="companyId" class="form-select"
                                                placeholder="Nama Perusahaan">
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
                                                <x-inputs.select2 wire:model="area_location_id" id="area_location_id"
                                                    data-child="area_location_id" class="form-select"
                                                    placeholder="Area Lokasi">
                                                    @foreach ($this->areaLocations as $key => $location)
                                                        <option value="{{ $location->id }}">{{ $location->name }}
                                                        </option>
                                                    @endforeach
                                                </x-inputs.select2>
                                            @else
                                                <x-inputs.select2 wire:model="area_location_id" id="area_location_id"
                                                    class="form-select" placeholder="Area Lokasi" disabled>
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
                                        <label for="pjaId" class="col-lg-4 col-md-12 col-form-label">PJA</label>
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
                                                <x-kplh-select2 wire:model="inspectionOfficer" id="inspectionOfficer"
                                                    class="form-select" placeholder="Petugas Inspeksi"
                                                    :error="'inspectionOfficer'">
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

                        <div id="bangunan" class="section-bangunan" x-data="{ accordionOpen: false }">
                            <button
                                class="header-accordion d-flex justify-content-between w-100 border-0 bg-white py-3 px-0"
                                @click.prevent="accordionOpen = ! accordionOpen">
                                <h6 class="mb-0 fw-normal title-accordion">A. Bangunan</h6>
                                <span x-bind:class="accordionOpen ? 'open' : ''"><img
                                        src="{{ asset('/images/icons/angle-down.png') }}" alt="" /></span>
                            </button>
                            <div class="wrapper-content-accordion max-h-0 overflow-hidden position-relative transition-all duration-700"
                                x-ref="bangunan" x-bind:style="accordionOpen ? 'max-height: ' + 20000 + 'px' : ''"
                                {{-- x-bind:style="accordionOpen ? 'max-height: ' + $refs.bangunan.scrollHeight + 'px' : ''" --}} x-transition.delay.5000ms>

                                <div class="content-section p-4" wire:ignore.self>

                                    <div class="row form-group mb-4">
                                        <label for="building_criteria_1_label"
                                            class="col-lg-4 col-md-12 col-form-label">Bangunan atau ruangan tempat
                                            pengolahan makanan harus dilengkapi dengan ventilasi yang memadai. Pada
                                            dapur dilengkapi dengan ventilasi alat pembuangan asap, penangkap asap, dan
                                            cerobong asap
                                        </label>
                                        <div class="col-lg-8 col-md-12">
                                            <div class="wrapper_building_criteria_1 d-flex flex-column gap-3"
                                                x-data="{ building_criteria_1_value: @entangle('building_criteria_1_value') }">
                                                <x-inputs.select2 wire:model="building_criteria_1_value"
                                                    id="building_criteria_1_value" class="form-select"
                                                    placeholder="Pemenuhan">
                                                    <option value="0">0 - Tidak Terpenuhi</option>
                                                    <option value="5">5 - Terpenuhi Sebagian</option>
                                                    <option value="10">10 - Terpenuhi Sepenuhnya</option>
                                                </x-inputs.select2>

                                                <div x-cloak
                                                    x-show="building_criteria_1_value === '0' || building_criteria_1_value === '5' || building_criteria_1_value === 0 || building_criteria_1_value === 5 ">
                                                    <div>
                                                        <x-kplh-texteditor wire:model="building_criteria_1_note"
                                                            id="building_criteria_1_note" placeholder="Keterangan"
                                                            :error="'building_criteria_1_note'" />
                                                    </div>
                                                    @if ($building_criteria_1_file && !Illuminate\Support\Str::contains($building_criteria_1_file, 'private/var/folders/'))
                                                        <div class="row mt-3">
                                                            <div class="col-md-3"><button type="button"
                                                                    class="btn btn-outline-secondary"
                                                                    wire:click="setFileNull('building_criteria_1_file')"><i
                                                                        class="fa fa-edit"></i> Ubah
                                                                    File</button></div>
                                                            <div class="col-md-9">
                                                                <a class="btn btn-outline-secondary"
                                                                    href="{{ route('kplh::download-file', ['food_hygiene', $building_criteria_1_file]) }}"
                                                                    target="_blank"><i class="fa fa-file"></i>
                                                                    {{ Illuminate\Support\Str::limit($building_criteria_1_file, 30) }}</a>
                                                            </div>
                                                        </div>
                                                    @else
                                                        <div class="col-md-12 mt-3">
                                                            <x-kplh-file wire:model="building_criteria_1_file"
                                                                id="building_criteria_1_file" placeholder="File"
                                                                :error="'building_criteria_1_file'" />
                                                        </div>
                                                    @endif
                                                </div>

                                            </div>
                                        </div>
                                    </div><!-- /.form-group building_criteria_1 -->

                                    <div class="row form-group mb-4">
                                        <label for="building_criteria_2_label"
                                            class="col-lg-4 col-md-12 col-form-label">Menyediakan pendingin ruangan
                                            seperti AC, kipas angin, atau exhauster serta jendela yang dapat berfungsi
                                            dengan baik sehingga pekerja dapat bekerja tanpa berkeringat. Merawat
                                            pendingin ruangan secara berkala sehingga tidak mengumpulkan debu
                                        </label>
                                        <div class="col-lg-8 col-md-12">
                                            <div class="wrapper_building_criteria_2 d-flex flex-column gap-3"
                                                x-data="{ building_criteria_2_value: @entangle('building_criteria_2_value') }">
                                                <x-inputs.select2 wire:model="building_criteria_2_value"
                                                    id="building_criteria_2_value" class="form-select"
                                                    placeholder="Pemenuhan">
                                                    <option value="0">0 - Tidak Terpenuhi</option>
                                                    <option value="5">5 - Terpenuhi Sebagian</option>
                                                    <option value="10">10 - Terpenuhi Sepenuhnya</option>
                                                </x-inputs.select2>

                                                <div x-cloak
                                                    x-show="building_criteria_2_value === '0' || building_criteria_2_value === '5' || building_criteria_2_value === 0 || building_criteria_2_value === 5">
                                                    <div>
                                                        <x-kplh-texteditor wire:model="building_criteria_2_note"
                                                            id="building_criteria_2_note" placeholder="Keterangan"
                                                            :error="'building_criteria_2_note'" />
                                                    </div>
                                                    @if ($building_criteria_2_file && !Illuminate\Support\Str::contains($building_criteria_2_file, 'private/var/folders/'))
                                                        <div class="row mt-3">
                                                            <div class="col-md-3"><button type="button"
                                                                    class="btn btn-outline-secondary"
                                                                    wire:click="setFileNull('building_criteria_2_file')"><i
                                                                        class="fa fa-edit"></i> Ubah
                                                                    File</button></div>
                                                            <div class="col-md-9">
                                                                <a class="btn btn-outline-secondary"
                                                                    href="{{ route('kplh::download-file', ['food_hygiene', $building_criteria_2_file]) }}"
                                                                    target="_blank"><i class="fa fa-file"></i>
                                                                    {{ Illuminate\Support\Str::limit($building_criteria_2_file, 30) }}</a>
                                                            </div>
                                                        </div>
                                                    @else
                                                        <div class="col-md-12 mt-3">
                                                            <x-kplh-file wire:model="building_criteria_2_file"
                                                                id="building_criteria_2_file" placeholder="File"
                                                                :error="'building_criteria_2_file'" />
                                                        </div>
                                                    @endif
                                                </div>

                                            </div>
                                        </div>
                                    </div><!-- /.form-group building_criteria_2 -->

                                    <div class="row form-group mb-4">
                                        <label for="building_criteria_3_label"
                                            class="col-lg-4 col-md-12 col-form-label">Menyediakan penerangan yang
                                            memadai untuk dapat melakukan pemeriksaan dan pembersihan serta melakukan
                                            pekerjaan-pekerjaan secara efektif
                                        </label>
                                        <div class="col-lg-8 col-md-12">
                                            <div class="wrapper_building_criteria_3 d-flex flex-column gap-3"
                                                x-data="{ building_criteria_3_value: @entangle('building_criteria_3_value') }">
                                                <x-inputs.select2 wire:model="building_criteria_3_value"
                                                    id="building_criteria_3_value" class="form-select"
                                                    placeholder="Pemenuhan">
                                                    <option value="0">0 - Tidak Terpenuhi</option>
                                                    <option value="5">5 - Terpenuhi Sebagian</option>
                                                    <option value="10">10 - Terpenuhi Sepenuhnya</option>
                                                </x-inputs.select2>

                                                <div x-cloak
                                                    x-show="building_criteria_3_value === '0' || building_criteria_3_value === '5' || building_criteria_3_value === 0 || building_criteria_3_value === 5">
                                                    <div>
                                                        <x-kplh-texteditor wire:model="building_criteria_3_note"
                                                            id="building_criteria_3_note" placeholder="Keterangan"
                                                            :error="'building_criteria_3_note'" />
                                                    </div>
                                                    @if ($building_criteria_3_file && !Illuminate\Support\Str::contains($building_criteria_3_file, 'private/var/folders/'))
                                                        <div class="row mt-3">
                                                            <div class="col-md-3"><button type="button"
                                                                    class="btn btn-outline-secondary"
                                                                    wire:click="setFileNull('building_criteria_3_file')"><i
                                                                        class="fa fa-edit"></i> Ubah
                                                                    File</button></div>
                                                            <div class="col-md-9">
                                                                <a class="btn btn-outline-secondary"
                                                                    href="{{ route('kplh::download-file', ['food_hygiene', $building_criteria_3_file]) }}"
                                                                    target="_blank"><i class="fa fa-file"></i>
                                                                    {{ Illuminate\Support\Str::limit($building_criteria_3_file, 30) }}</a>
                                                            </div>
                                                        </div>
                                                    @else
                                                        <div class="col-md-12 mt-3">
                                                            <x-kplh-file wire:model="building_criteria_3_file"
                                                                id="building_criteria_3_file" placeholder="File"
                                                                :error="'building_criteria_3_file'" />
                                                        </div>
                                                    @endif
                                                </div>

                                            </div>
                                        </div>
                                    </div><!-- /.form-group building_criteria_3 -->

                                    <div class="row form-group mb-4">
                                        <label for="building_criteria_4_label"
                                            class="col-lg-4 col-md-12 col-form-label">Menyediakan penangkap lemak
                                            (grease trap) pada pembuangan air kotor sebelum dialirkan ke penampungan air
                                            kotor (septic tank) atau tempat pembuangan lainnya
                                        </label>
                                        <div class="col-lg-8 col-md-12">
                                            <div class="wrapper_building_criteria_4 d-flex flex-column gap-3"
                                                x-data="{ building_criteria_4_value: @entangle('building_criteria_4_value') }">
                                                <x-inputs.select2 wire:model="building_criteria_4_value"
                                                    id="building_criteria_4_value" class="form-select"
                                                    placeholder="Pemenuhan">
                                                    <option value="0">0 - Tidak Terpenuhi</option>
                                                    <option value="5">5 - Terpenuhi Sebagian</option>
                                                    <option value="10">10 - Terpenuhi Sepenuhnya</option>
                                                </x-inputs.select2>

                                                <div x-cloak
                                                    x-show="building_criteria_4_value === '0' || building_criteria_4_value === '5' || building_criteria_4_value === 0 || building_criteria_4_value === 5">
                                                    <div>
                                                        <x-kplh-texteditor wire:model="building_criteria_4_note"
                                                            id="building_criteria_4_note" placeholder="Keterangan"
                                                            :error="'building_criteria_4_note'" />
                                                    </div>
                                                    @if ($building_criteria_4_file && !Illuminate\Support\Str::contains($building_criteria_4_file, 'private/var/folders/'))
                                                        <div class="row mt-3">
                                                            <div class="col-md-3"><button type="button"
                                                                    class="btn btn-outline-secondary"
                                                                    wire:click="setFileNull('building_criteria_4_file')"><i
                                                                        class="fa fa-edit"></i> Ubah
                                                                    File</button></div>
                                                            <div class="col-md-9">
                                                                <a class="btn btn-outline-secondary"
                                                                    href="{{ route('kplh::download-file', ['food_hygiene', $building_criteria_4_file]) }}"
                                                                    target="_blank"><i class="fa fa-file"></i>
                                                                    {{ Illuminate\Support\Str::limit($building_criteria_4_file, 30) }}</a>
                                                            </div>
                                                        </div>
                                                    @else
                                                        <div class="col-md-12 mt-3">
                                                            <x-kplh-file wire:model="building_criteria_4_file"
                                                                id="building_criteria_4_file" placeholder="File"
                                                                :error="'building_criteria_4_file'" />
                                                        </div>
                                                    @endif
                                                </div>

                                            </div>
                                        </div>
                                    </div><!-- /.form-group building_criteria_4 -->

                                    <div class="row form-group mb-4">
                                        <label for="building_criteria_5_label"
                                            class="col-lg-4 col-md-12 col-form-label">Pembuangan air kotor/ limbah
                                            tidak menimbulkan sarang serangga, jalan masuk tikus, dan dipelihara
                                            kebersihannya
                                        </label>
                                        <div class="col-lg-8 col-md-12">
                                            <div class="wrapper_building_criteria_5 d-flex flex-column gap-3"
                                                x-data="{ building_criteria_5_value: @entangle('building_criteria_5_value') }">
                                                <x-inputs.select2 wire:model="building_criteria_5_value"
                                                    id="building_criteria_5_value" class="form-select"
                                                    placeholder="Pemenuhan">
                                                    <option value="0">0 - Tidak Terpenuhi</option>
                                                    <option value="5">5 - Terpenuhi Sebagian</option>
                                                    <option value="10">10 - Terpenuhi Sepenuhnya</option>
                                                </x-inputs.select2>

                                                <div x-cloak
                                                    x-show="building_criteria_5_value === '0' || building_criteria_5_value === '5' || building_criteria_5_value === 0 || building_criteria_5_value === 5">
                                                    <div>
                                                        <x-kplh-texteditor wire:model="building_criteria_5_note"
                                                            id="building_criteria_5_note" placeholder="Keterangan"
                                                            :error="'building_criteria_5_note'" />
                                                    </div>
                                                    @if ($building_criteria_5_file && !Illuminate\Support\Str::contains($building_criteria_5_file, 'private/var/folders/'))
                                                        <div class="row mt-3">
                                                            <div class="col-md-3"><button type="button"
                                                                    class="btn btn-outline-secondary"
                                                                    wire:click="setFileNull('building_criteria_5_file')"><i
                                                                        class="fa fa-edit"></i> Ubah
                                                                    File</button></div>
                                                            <div class="col-md-9">
                                                                <a class="btn btn-outline-secondary"
                                                                    href="{{ route('kplh::download-file', ['food_hygiene', $building_criteria_5_file]) }}"
                                                                    target="_blank"><i class="fa fa-file"></i>
                                                                    {{ Illuminate\Support\Str::limit($building_criteria_5_file, 30) }}</a>
                                                            </div>
                                                        </div>
                                                    @else
                                                        <div class="col-md-12 mt-3">
                                                            <x-kplh-file wire:model="building_criteria_5_file"
                                                                id="building_criteria_5_file" placeholder="File"
                                                                :error="'building_criteria_5_file'" />
                                                        </div>
                                                    @endif
                                                </div>

                                            </div>
                                        </div>
                                    </div><!-- /.form-group building_criteria_5 -->

                                    <div class="row form-group mb-4">
                                        <label for="building_criteria_6_label"
                                            class="col-lg-4 col-md-12 col-form-label">Ruang pengolahan makanan tidak
                                            boleh berhubungan langsung dengan toilet/ jamban, peturasan dan kamar mandi
                                        </label>
                                        <div class="col-lg-8 col-md-12">
                                            <div class="wrapper_building_criteria_6 d-flex flex-column gap-3"
                                                x-data="{ building_criteria_6_value: @entangle('building_criteria_6_value') }">
                                                <x-inputs.select2 wire:model="building_criteria_6_value"
                                                    id="building_criteria_6_value" class="form-select"
                                                    placeholder="Pemenuhan">
                                                    <option value="0">0 - Tidak Terpenuhi</option>
                                                    <option value="5">5 - Terpenuhi Sebagian</option>
                                                    <option value="10">10 - Terpenuhi Sepenuhnya</option>
                                                </x-inputs.select2>

                                                <div x-cloak
                                                    x-show="building_criteria_6_value === '0' || building_criteria_6_value === '5' || building_criteria_6_value === 0 || building_criteria_6_value === 5">
                                                    <div>
                                                        <x-kplh-texteditor wire:model="building_criteria_6_note"
                                                            id="building_criteria_6_note" placeholder="Keterangan"
                                                            :error="'building_criteria_6_note'" />
                                                    </div>
                                                    @if ($building_criteria_6_file && !Illuminate\Support\Str::contains($building_criteria_6_file, 'private/var/folders/'))
                                                        <div class="row mt-3">
                                                            <div class="col-md-3"><button type="button"
                                                                    class="btn btn-outline-secondary"
                                                                    wire:click="setFileNull('building_criteria_6_file')"><i
                                                                        class="fa fa-edit"></i> Ubah
                                                                    File</button></div>
                                                            <div class="col-md-9">
                                                                <a class="btn btn-outline-secondary"
                                                                    href="{{ route('kplh::download-file', ['food_hygiene', $building_criteria_6_file]) }}"
                                                                    target="_blank"><i class="fa fa-file"></i>
                                                                    {{ Illuminate\Support\Str::limit($building_criteria_6_file, 30) }}</a>
                                                            </div>
                                                        </div>
                                                    @else
                                                        <div class="col-md-12 mt-3">
                                                            <x-kplh-file wire:model="building_criteria_6_file"
                                                                id="building_criteria_6_file" placeholder="File"
                                                                :error="'building_criteria_6_file'" />
                                                        </div>
                                                    @endif
                                                </div>

                                            </div>
                                        </div>
                                    </div><!-- /.form-group building_criteria_6 -->

                                    <div class="row form-group mb-4">
                                        <label for="building_criteria_7_label"
                                            class="col-lg-4 col-md-12 col-form-label">Bidang langit-langit harus
                                            menutupi seluruh atap bangunan
                                        </label>
                                        <div class="col-lg-8 col-md-12">
                                            <div class="wrapper_building_criteria_7 d-flex flex-column gap-3"
                                                x-data="{ building_criteria_7_value: @entangle('building_criteria_7_value') }">
                                                <x-inputs.select2 wire:model="building_criteria_7_value"
                                                    id="building_criteria_7_value" class="form-select"
                                                    placeholder="Pemenuhan">
                                                    <option value="0">0 - Tidak Terpenuhi</option>
                                                    <option value="5">5 - Terpenuhi Sebagian</option>
                                                    <option value="10">10 - Terpenuhi Sepenuhnya</option>
                                                </x-inputs.select2>

                                                <div x-cloak
                                                    x-show="building_criteria_7_value === '0' || building_criteria_7_value === '5' || building_criteria_7_value === 0 || building_criteria_7_value === 5">
                                                    <div>
                                                        <x-kplh-texteditor wire:model="building_criteria_7_note"
                                                            id="building_criteria_7_note" placeholder="Keterangan"
                                                            :error="'building_criteria_7_note'" />
                                                    </div>
                                                    @if ($building_criteria_7_file && !Illuminate\Support\Str::contains($building_criteria_7_file, 'private/var/folders/'))
                                                        <div class="row mt-3">
                                                            <div class="col-md-3"><button type="button"
                                                                    class="btn btn-outline-secondary"
                                                                    wire:click="setFileNull('building_criteria_7_file')"><i
                                                                        class="fa fa-edit"></i> Ubah
                                                                    File</button></div>
                                                            <div class="col-md-9">
                                                                <a class="btn btn-outline-secondary"
                                                                    href="{{ route('kplh::download-file', ['food_hygiene', $building_criteria_7_file]) }}"
                                                                    target="_blank"><i class="fa fa-file"></i>
                                                                    {{ Illuminate\Support\Str::limit($building_criteria_7_file, 30) }}</a>
                                                            </div>
                                                        </div>
                                                    @else
                                                        <div class="col-md-12 mt-3">
                                                            <x-kplh-file wire:model="building_criteria_7_file"
                                                                id="building_criteria_7_file" placeholder="File"
                                                                :error="'building_criteria_7_file'" />
                                                        </div>
                                                    @endif
                                                </div>

                                            </div>
                                        </div>
                                    </div><!-- /.form-group building_criteria_7 -->

                                    <div class="row form-group mb-4">
                                        <label for="building_criteria_8_label"
                                            class="col-lg-4 col-md-12 col-form-label">Pintu ruang pengolahan makanan
                                            dilengkapi peralatan anti serangga/lalat seperti kassa, tirai, pintu
                                            perangkap dan lain-lain yang dapat dibuka dan dipasang untuk dibersihkan
                                        </label>
                                        <div class="col-lg-8 col-md-12">
                                            <div class="wrapper_building_criteria_8 d-flex flex-column gap-3"
                                                x-data="{ building_criteria_8_value: @entangle('building_criteria_8_value') }">
                                                <x-inputs.select2 wire:model="building_criteria_8_value"
                                                    id="building_criteria_8_value" class="form-select"
                                                    placeholder="Pemenuhan">
                                                    <option value="0">0 - Tidak Terpenuhi</option>
                                                    <option value="5">5 - Terpenuhi Sebagian</option>
                                                    <option value="10">10 - Terpenuhi Sepenuhnya</option>
                                                </x-inputs.select2>

                                                <div x-cloak
                                                    x-show="building_criteria_8_value === '0' || building_criteria_8_value === '5' || building_criteria_8_value === 0 || building_criteria_8_value === 5">
                                                    <div>
                                                        <x-kplh-texteditor wire:model="building_criteria_8_note"
                                                            id="building_criteria_8_note" placeholder="Keterangan"
                                                            :error="'building_criteria_8_note'" />
                                                    </div>
                                                    @if ($building_criteria_8_file && !Illuminate\Support\Str::contains($building_criteria_8_file, 'private/var/folders/'))
                                                        <div class="row mt-3">
                                                            <div class="col-md-3"><button type="button"
                                                                    class="btn btn-outline-secondary"
                                                                    wire:click="setFileNull('building_criteria_8_file')"><i
                                                                        class="fa fa-edit"></i> Ubah
                                                                    File</button></div>
                                                            <div class="col-md-9">
                                                                <a class="btn btn-outline-secondary"
                                                                    href="{{ route('kplh::download-file', ['food_hygiene', $building_criteria_8_file]) }}"
                                                                    target="_blank"><i class="fa fa-file"></i>
                                                                    {{ Illuminate\Support\Str::limit($building_criteria_8_file, 30) }}</a>
                                                            </div>
                                                        </div>
                                                    @else
                                                        <div class="col-md-12 mt-3">
                                                            <x-kplh-file wire:model="building_criteria_8_file"
                                                                id="building_criteria_8_file" placeholder="File"
                                                                :error="'building_criteria_8_file'" />
                                                        </div>
                                                    @endif
                                                </div>

                                            </div>
                                        </div>
                                    </div><!-- /.form-group building_criteria_8 -->

                                    <div class="row form-group mb-4">
                                        <label for="building_criteria_9_label"
                                            class="col-lg-4 col-md-12 col-form-label">Fasilitas pencucian peralatan dan
                                            bahan makanan dari bahan yang kuat, permukaan halus dan mudah dibersihkan
                                        </label>
                                        <div class="col-lg-8 col-md-12">
                                            <div class="wrapper_building_criteria_9 d-flex flex-column gap-3"
                                                x-data="{ building_criteria_9_value: @entangle('building_criteria_9_value') }">
                                                <x-inputs.select2 wire:model="building_criteria_9_value"
                                                    id="building_criteria_9_value" class="form-select"
                                                    placeholder="Pemenuhan">
                                                    <option value="0">0 - Tidak Terpenuhi</option>
                                                    <option value="5">5 - Terpenuhi Sebagian</option>
                                                    <option value="10">10 - Terpenuhi Sepenuhnya</option>
                                                </x-inputs.select2>

                                                <div x-cloak
                                                    x-show="building_criteria_9_value === '0' || building_criteria_9_value === '5' || building_criteria_9_value === 0 || building_criteria_9_value === 5">
                                                    <div>
                                                        <x-kplh-texteditor wire:model="building_criteria_9_note"
                                                            id="building_criteria_9_note" placeholder="Keterangan"
                                                            :error="'building_criteria_9_note'" />
                                                    </div>
                                                    @if ($building_criteria_9_file && !Illuminate\Support\Str::contains($building_criteria_9_file, 'private/var/folders/'))
                                                        <div class="row mt-3">
                                                            <div class="col-md-3"><button type="button"
                                                                    class="btn btn-outline-secondary"
                                                                    wire:click="setFileNull('building_criteria_9_file')"><i
                                                                        class="fa fa-edit"></i> Ubah
                                                                    File</button></div>
                                                            <div class="col-md-9">
                                                                <a class="btn btn-outline-secondary"
                                                                    href="{{ route('kplh::download-file', ['food_hygiene', $building_criteria_9_file]) }}"
                                                                    target="_blank"><i class="fa fa-file"></i>
                                                                    {{ Illuminate\Support\Str::limit($building_criteria_9_file, 30) }}</a>
                                                            </div>
                                                        </div>
                                                    @else
                                                        <div class="col-md-12 mt-3">
                                                            <x-kplh-file wire:model="building_criteria_9_file"
                                                                id="building_criteria_9_file" placeholder="File"
                                                                :error="'building_criteria_9_file'" />
                                                        </div>
                                                    @endif
                                                </div>

                                            </div>
                                        </div>
                                    </div><!-- /.form-group building_criteria_9 -->

                                    <div class="row form-group mb-4">
                                        <label for="building_criteria_10_label"
                                            class="col-lg-4 col-md-12 col-form-label">Tersedia petugas khusus bagian
                                            tehnik pemeliharaan / perbaikan dan pembersihan dan bukan merupakan penjamah
                                            makanan. Dapur tidak dijadikan tempat untuk tidur, tempat cuci pakaian,
                                            jemur pakaian, gantung pakaian.
                                        </label>
                                        <div class="col-lg-8 col-md-12">
                                            <div class="wrapper_building_criteria_10 d-flex flex-column gap-3"
                                                x-data="{ building_criteria_10_value: @entangle('building_criteria_10_value') }">
                                                <x-inputs.select2 wire:model="building_criteria_10_value"
                                                    id="building_criteria_10_value" class="form-select"
                                                    placeholder="Pemenuhan">
                                                    <option value="0">0 - Tidak Terpenuhi</option>
                                                    <option value="5">5 - Terpenuhi Sebagian</option>
                                                    <option value="10">10 - Terpenuhi Sepenuhnya</option>
                                                </x-inputs.select2>

                                                <div x-cloak
                                                    x-show="building_criteria_10_value === '0' || building_criteria_10_value === '5' || building_criteria_10_value === 0 || building_criteria_10_value === 5">
                                                    <div>
                                                        <x-kplh-texteditor wire:model="building_criteria_10_note"
                                                            id="building_criteria_10_note" placeholder="Keterangan"
                                                            :error="'building_criteria_10_note'" />
                                                    </div>
                                                    @if ($building_criteria_10_file && !Illuminate\Support\Str::contains($building_criteria_10_file, 'private/var/folders/'))
                                                        <div class="row mt-3">
                                                            <div class="col-md-3"><button type="button"
                                                                    class="btn btn-outline-secondary"
                                                                    wire:click="setFileNull('building_criteria_10_file')"><i
                                                                        class="fa fa-edit"></i> Ubah
                                                                    File</button></div>
                                                            <div class="col-md-9">
                                                                <a class="btn btn-outline-secondary"
                                                                    href="{{ route('kplh::download-file', ['food_hygiene', $building_criteria_10_file]) }}"
                                                                    target="_blank"><i class="fa fa-file"></i>
                                                                    {{ Illuminate\Support\Str::limit($building_criteria_10_file, 30) }}</a>
                                                            </div>
                                                        </div>
                                                    @else
                                                        <div class="col-md-12 mt-3">
                                                            <x-kplh-file wire:model="building_criteria_10_file"
                                                                id="building_criteria_10_file"
                                                                placeholder="File" :error="'building_criteria_10_file'" />
                                                        </div>
                                                    @endif
                                                </div>

                                            </div>
                                        </div>
                                    </div><!-- /.form-group building_criteria_10 -->

                                    <div class="row form-group mb-4">
                                        <label for="building_criteria_11_label"
                                            class="col-lg-4 col-md-12 col-form-label">Menyediakan kotak P3K di dapur
                                            (khususnya untuk luka bakar dan terpotong). Melakukan inspeksi
                                            sekurang-kurangnya sekali sebulan untuk memastikan ketersediaan dan
                                            kecukupannya
                                        </label>
                                        <div class="col-lg-8 col-md-12">
                                            <div class="wrapper_building_criteria_11 d-flex flex-column gap-3"
                                                x-data="{ building_criteria_11_value: @entangle('building_criteria_11_value') }">
                                                <x-inputs.select2 wire:model="building_criteria_11_value"
                                                    id="building_criteria_11_value" class="form-select"
                                                    placeholder="Pemenuhan">
                                                    <option value="0">0 - Tidak Terpenuhi</option>
                                                    <option value="5">5 - Terpenuhi Sebagian</option>
                                                    <option value="10">10 - Terpenuhi Sepenuhnya</option>
                                                </x-inputs.select2>

                                                <div x-cloak
                                                    x-show="building_criteria_11_value === '0' || building_criteria_11_value === '5' || building_criteria_11_value === 0 || building_criteria_11_value === 5">
                                                    <div>
                                                        <x-kplh-texteditor wire:model="building_criteria_11_note"
                                                            id="building_criteria_11_note" placeholder="Keterangan"
                                                            :error="'building_criteria_11_note'" />
                                                    </div>
                                                    @if ($building_criteria_11_file && !Illuminate\Support\Str::contains($building_criteria_11_file, 'private/var/folders/'))
                                                        <div class="row mt-3">
                                                            <div class="col-md-3"><button type="button"
                                                                    class="btn btn-outline-secondary"
                                                                    wire:click="setFileNull('building_criteria_11_file')"><i
                                                                        class="fa fa-edit"></i> Ubah
                                                                    File</button></div>
                                                            <div class="col-md-9">
                                                                <a class="btn btn-outline-secondary"
                                                                    href="{{ route('kplh::download-file', ['food_hygiene', $building_criteria_11_file]) }}"
                                                                    target="_blank"><i class="fa fa-file"></i>
                                                                    {{ Illuminate\Support\Str::limit($building_criteria_11_file, 30) }}</a>
                                                            </div>
                                                        </div>
                                                    @else
                                                        <div class="col-md-12 mt-3">
                                                            <x-kplh-file wire:model="building_criteria_11_file"
                                                                id="building_criteria_11_file"
                                                                placeholder="File" :error="'building_criteria_11_file'" />
                                                        </div>
                                                    @endif
                                                </div>

                                            </div>
                                        </div>
                                    </div><!-- /.form-group building_criteria_11 -->


                                </div><!-- ./content-bangunan -->
                            </div>
                        </div><!-- /.bangunan -->

                        <div id="sanitasi" class="section-sanitasi" x-data="{ accordionOpen: false }">
                            <button
                                class="header-accordion d-flex justify-content-between w-100 border-0 bg-white py-3 px-0"
                                @click.prevent="accordionOpen = ! accordionOpen">
                                <h6 class="mb-0 fw-normal title-accordion">B. Fasilitas Sanitasi</h6>
                                <span x-bind:class="accordionOpen ? 'open' : ''"><img
                                        src="{{ asset('/images/icons/angle-down.png') }}" alt="" /></span>
                            </button>
                            <div class="wrapper-content-accordion max-h-0 overflow-hidden position-relative transition-all duration-700"
                                x-ref="sanitasi" x-bind:style="accordionOpen ? 'max-height: ' + 20000 + 'px' : ''"
                                x-transition.delay.5000ms>

                                <div class="content-section p-4" wire:ignore.self>

                                    <div class="row form-group mb-4">
                                        <label for="sanitation_1_label"
                                            class="col-lg-4 col-md-12 col-form-label">Menyediakan tempat sampah yang
                                            cukup dan diberi tutup, memisahkan jenis sampah organik dan non-organik,
                                            serta diberi kantong plastik untuk menampung sampah tanpa mengotori tempat
                                            sampah
                                        </label>
                                        <div class="col-lg-8 col-md-12">
                                            <div class="wrapper_sanitation_1 d-flex flex-column gap-3"
                                                x-data="{ sanitation_1_value: @entangle('sanitation_1_value') }">
                                                <x-inputs.select2 wire:model="sanitation_1_value"
                                                    id="sanitation_1_value" class="form-select"
                                                    placeholder="Pemenuhan">
                                                    <option value="0">0 - Tidak Terpenuhi</option>
                                                    <option value="5">5 - Terpenuhi Sebagian</option>
                                                    <option value="10">10 - Terpenuhi Sepenuhnya</option>
                                                </x-inputs.select2>

                                                <div x-cloak
                                                    x-show="sanitation_1_value === '0' || sanitation_1_value === '5' || sanitation_1_value === 0 || sanitation_1_value === 5">
                                                    <div>
                                                        <x-kplh-texteditor wire:model="sanitation_1_note"
                                                            id="sanitation_1_note" placeholder="Keterangan"
                                                            :error="'sanitation_1_note'" />
                                                    </div>
                                                    @if ($sanitation_1_file && !Illuminate\Support\Str::contains($sanitation_1_file, 'private/var/folders/'))
                                                        <div class="row mt-3">
                                                            <div class="col-md-3"><button type="button"
                                                                    class="btn btn-outline-secondary"
                                                                    wire:click="setFileNull('sanitation_1_file')"><i
                                                                        class="fa fa-edit"></i> Ubah
                                                                    File</button></div>
                                                            <div class="col-md-9">
                                                                <a class="btn btn-outline-secondary"
                                                                    href="{{ route('kplh::download-file', ['food_hygiene', $sanitation_1_file]) }}"
                                                                    target="_blank"><i class="fa fa-file"></i>
                                                                    {{ Illuminate\Support\Str::limit($sanitation_1_file, 30) }}</a>
                                                            </div>
                                                        </div>
                                                    @else
                                                        <div class="col-md-12 mt-3">
                                                            <x-kplh-file wire:model="sanitation_1_file"
                                                                id="sanitation_1_file" placeholder="File"
                                                                :error="'sanitation_1_file'" />
                                                        </div>
                                                    @endif
                                                </div>

                                            </div>
                                        </div>
                                    </div><!-- /.form-group sanitation_1 -->

                                    <div class="row form-group mb-4">
                                        <label for="sanitation_2_label"
                                            class="col-lg-4 col-md-12 col-form-label">Memastikan tempat sampah dan area
                                            sekelilingnya bersih dan bebas dari serangga dan binatang lainnya
                                        </label>
                                        <div class="col-lg-8 col-md-12">
                                            <div class="wrapper_sanitation_2 d-flex flex-column gap-3"
                                                x-data="{ sanitation_2_value: @entangle('sanitation_2_value') }">
                                                <x-inputs.select2 wire:model="sanitation_2_value"
                                                    id="sanitation_2_value" class="form-select"
                                                    placeholder="Pemenuhan">
                                                    <option value="0">0 - Tidak Terpenuhi</option>
                                                    <option value="5">5 - Terpenuhi Sebagian</option>
                                                    <option value="10">10 - Terpenuhi Sepenuhnya</option>
                                                </x-inputs.select2>

                                                <div x-cloak
                                                    x-show="sanitation_2_value === '0' || sanitation_2_value === '5' || sanitation_2_value === 0 || sanitation_2_value === 5">
                                                    <div>
                                                        <x-kplh-texteditor wire:model="sanitation_2_note"
                                                            id="sanitation_2_note" placeholder="Keterangan"
                                                            :error="'sanitation_2_note'" />
                                                    </div>
                                                    @if ($sanitation_2_file && !Illuminate\Support\Str::contains($sanitation_2_file, 'private/var/folders/'))
                                                        <div class="row mt-3">
                                                            <div class="col-md-3"><button type="button"
                                                                    class="btn btn-outline-secondary"
                                                                    wire:click="setFileNull('sanitation_2_file')"><i
                                                                        class="fa fa-edit"></i> Ubah
                                                                    File</button></div>
                                                            <div class="col-md-9">
                                                                <a class="btn btn-outline-secondary"
                                                                    href="{{ route('kplh::download-file', ['food_hygiene', $sanitation_2_file]) }}"
                                                                    target="_blank"><i class="fa fa-file"></i>
                                                                    {{ Illuminate\Support\Str::limit($sanitation_2_file, 30) }}</a>
                                                            </div>
                                                        </div>
                                                    @else
                                                        <div class="col-md-12 mt-3">
                                                            <x-kplh-file wire:model="sanitation_2_file"
                                                                id="sanitation_2_file" placeholder="File"
                                                                :error="'sanitation_2_file'" />
                                                        </div>
                                                    @endif
                                                </div>

                                            </div>
                                        </div>
                                    </div><!-- /.form-group sanitation_2 -->

                                    <div class="row form-group mb-4">
                                        <label for="sanitation_3_label"
                                            class="col-lg-4 col-md-12 col-form-label">Membuang sampah dan membersihkan
                                            tempat sampah setiap hari. Jika memiliki tempat pembuangan sementara (TPS)
                                            sampah, maka TPS sampah terletak minimal 500 meter dari bangunan pengelolaan
                                            makanan, penyimpanan bahan dan perlengkapan
                                        </label>
                                        <div class="col-lg-8 col-md-12">
                                            <div class="wrapper_sanitation_3 d-flex flex-column gap-3"
                                                x-data="{ sanitation_3_value: @entangle('sanitation_3_value') }">
                                                <x-inputs.select2 wire:model="sanitation_3_value"
                                                    id="sanitation_3_value" class="form-select"
                                                    placeholder="Pemenuhan">
                                                    <option value="0">0 - Tidak Terpenuhi</option>
                                                    <option value="5">5 - Terpenuhi Sebagian</option>
                                                    <option value="10">10 - Terpenuhi Sepenuhnya</option>
                                                </x-inputs.select2>

                                                <div x-cloak
                                                    x-show="sanitation_3_value === '0' || sanitation_3_value === '5' || sanitation_3_value === 0 || sanitation_3_value === 5">
                                                    <div>
                                                        <x-kplh-texteditor wire:model="sanitation_3_note"
                                                            id="sanitation_3_note" placeholder="Keterangan"
                                                            :error="'sanitation_3_note'" />
                                                    </div>
                                                    @if ($sanitation_3_file && !Illuminate\Support\Str::contains($sanitation_3_file, 'private/var/folders/'))
                                                        <div class="row mt-3">
                                                            <div class="col-md-3"><button type="button"
                                                                    class="btn btn-outline-secondary"
                                                                    wire:click="setFileNull('sanitation_3_file')"><i
                                                                        class="fa fa-edit"></i> Ubah
                                                                    File</button></div>
                                                            <div class="col-md-9">
                                                                <a class="btn btn-outline-secondary"
                                                                    href="{{ route('kplh::download-file', ['food_hygiene', $sanitation_3_file]) }}"
                                                                    target="_blank"><i class="fa fa-file"></i>
                                                                    {{ Illuminate\Support\Str::limit($sanitation_3_file, 30) }}</a>
                                                            </div>
                                                        </div>
                                                    @else
                                                        <div class="col-md-12 mt-3">
                                                            <x-kplh-file wire:model="sanitation_3_file"
                                                                id="sanitation_3_file" placeholder="File"
                                                                :error="'sanitation_3_file'" />
                                                        </div>
                                                    @endif
                                                </div>

                                            </div>
                                        </div>
                                    </div><!-- /.form-group sanitation_3 -->

                                    <div class="row form-group mb-4">
                                        <label for="sanitation_4_label"
                                            class="col-lg-4 col-md-12 col-form-label">Tersedia tempat cuci tangan yang
                                            terpisah dari tempat cuci peralatan maupun bahan makanan dilengkapi dengan
                                            air mengalir dan sabun, saluran pembuangan tertutup, bak penampungan air dan
                                            alat pengering
                                        </label>
                                        <div class="col-lg-8 col-md-12">
                                            <div class="wrapper_sanitation_4 d-flex flex-column gap-3"
                                                x-data="{ sanitation_4_value: @entangle('sanitation_4_value') }">
                                                <x-inputs.select2 wire:model="sanitation_4_value"
                                                    id="sanitation_4_value" class="form-select"
                                                    placeholder="Pemenuhan">
                                                    <option value="0">0 - Tidak Terpenuhi</option>
                                                    <option value="5">5 - Terpenuhi Sebagian</option>
                                                    <option value="10">10 - Terpenuhi Sepenuhnya</option>
                                                </x-inputs.select2>

                                                <div x-cloak
                                                    x-show="sanitation_4_value === '0' || sanitation_4_value === '5' || sanitation_4_value === 0 || sanitation_4_value === 5">
                                                    <div>
                                                        <x-kplh-texteditor wire:model="sanitation_4_note"
                                                            id="sanitation_4_note" placeholder="Keterangan"
                                                            :error="'sanitation_4_note'" />
                                                    </div>
                                                    @if ($sanitation_4_file && !Illuminate\Support\Str::contains($sanitation_4_file, 'private/var/folders/'))
                                                        <div class="row mt-3">
                                                            <div class="col-md-3"><button type="button"
                                                                    class="btn btn-outline-secondary"
                                                                    wire:click="setFileNull('sanitation_4_file')"><i
                                                                        class="fa fa-edit"></i> Ubah
                                                                    File</button></div>
                                                            <div class="col-md-9">
                                                                <a class="btn btn-outline-secondary"
                                                                    href="{{ route('kplh::download-file', ['food_hygiene', $sanitation_4_file]) }}"
                                                                    target="_blank"><i class="fa fa-file"></i>
                                                                    {{ Illuminate\Support\Str::limit($sanitation_4_file, 30) }}</a>
                                                            </div>
                                                        </div>
                                                    @else
                                                        <div class="col-md-12 mt-3">
                                                            <x-kplh-file wire:model="sanitation_4_file"
                                                                id="sanitation_4_file" placeholder="File"
                                                                :error="'sanitation_4_file'" />
                                                        </div>
                                                    @endif
                                                </div>

                                            </div>
                                        </div>
                                    </div><!-- /.form-group sanitation_4 -->

                                    <div class="row form-group mb-4">
                                        <label for="sanitation_5_label"
                                            class="col-lg-4 col-md-12 col-form-label">Halaman bersih, tidak ada
                                            tumpukan sampah, puing atau barang-barang tidak terpakai lainnya dan tidak
                                            ada genangan air
                                        </label>
                                        <div class="col-lg-8 col-md-12">
                                            <div class="wrapper_sanitation_5 d-flex flex-column gap-3"
                                                x-data="{ sanitation_5_value: @entangle('sanitation_5_value') }">
                                                <x-inputs.select2 wire:model="sanitation_5_value"
                                                    id="sanitation_5_value" class="form-select"
                                                    placeholder="Pemenuhan">
                                                    <option value="0">0 - Tidak Terpenuhi</option>
                                                    <option value="5">5 - Terpenuhi Sebagian</option>
                                                    <option value="10">10 - Terpenuhi Sepenuhnya</option>
                                                </x-inputs.select2>

                                                <div x-cloak
                                                    x-show="sanitation_5_value === '0' || sanitation_5_value === '5' || sanitation_5_value === 0 || sanitation_5_value === 5">
                                                    <div>
                                                        <x-kplh-texteditor wire:model="sanitation_5_note"
                                                            id="sanitation_5_note" placeholder="Keterangan"
                                                            :error="'sanitation_5_note'" />
                                                    </div>
                                                    @if ($sanitation_5_file && !Illuminate\Support\Str::contains($sanitation_5_file, 'private/var/folders/'))
                                                        <div class="row mt-3">
                                                            <div class="col-md-3"><button type="button"
                                                                    class="btn btn-outline-secondary"
                                                                    wire:click="setFileNull('sanitation_5_file')"><i
                                                                        class="fa fa-edit"></i> Ubah
                                                                    File</button></div>
                                                            <div class="col-md-9">
                                                                <a class="btn btn-outline-secondary"
                                                                    href="{{ route('kplh::download-file', ['food_hygiene', $sanitation_5_file]) }}"
                                                                    target="_blank"><i class="fa fa-file"></i>
                                                                    {{ Illuminate\Support\Str::limit($sanitation_5_file, 30) }}</a>
                                                            </div>
                                                        </div>
                                                    @else
                                                        <div class="col-md-12 mt-3">
                                                            <x-kplh-file wire:model="sanitation_5_file"
                                                                id="sanitation_5_file" placeholder="File"
                                                                :error="'sanitation_5_file'" />
                                                        </div>
                                                    @endif
                                                </div>

                                            </div>
                                        </div>
                                    </div><!-- /.form-group sanitation_5 -->

                                    <div class="row form-group mb-4">
                                        <label for="sanitation_6_label"
                                            class="col-lg-4 col-md-12 col-form-label">Memiliki kamar mandi, jamban, dan
                                            peturasan yang cukup sesuai jumlah karyawan dan pintu selalu tertutup
                                        </label>
                                        <div class="col-lg-8 col-md-12">
                                            <div class="wrapper_sanitation_6 d-flex flex-column gap-3"
                                                x-data="{ sanitation_6_value: @entangle('sanitation_6_value') }">
                                                <x-inputs.select2 wire:model="sanitation_6_value"
                                                    id="sanitation_6_value" class="form-select"
                                                    placeholder="Pemenuhan">
                                                    <option value="0">0 - Tidak Terpenuhi</option>
                                                    <option value="5">5 - Terpenuhi Sebagian</option>
                                                    <option value="10">10 - Terpenuhi Sepenuhnya</option>
                                                </x-inputs.select2>

                                                <div x-cloak
                                                    x-show="sanitation_6_value === '0' || sanitation_6_value === '5' || sanitation_6_value === 0 || sanitation_6_value === 5">
                                                    <div>
                                                        <x-kplh-texteditor wire:model="sanitation_6_note"
                                                            id="sanitation_6_note" placeholder="Keterangan"
                                                            :error="'sanitation_6_note'" />
                                                    </div>
                                                    @if ($sanitation_6_file && !Illuminate\Support\Str::contains($sanitation_6_file, 'private/var/folders/'))
                                                        <div class="row mt-3">
                                                            <div class="col-md-3"><button type="button"
                                                                    class="btn btn-outline-secondary"
                                                                    wire:click="setFileNull('sanitation_6_file')"><i
                                                                        class="fa fa-edit"></i> Ubah
                                                                    File</button></div>
                                                            <div class="col-md-9">
                                                                <a class="btn btn-outline-secondary"
                                                                    href="{{ route('kplh::download-file', ['food_hygiene', $sanitation_6_file]) }}"
                                                                    target="_blank"><i class="fa fa-file"></i>
                                                                    {{ Illuminate\Support\Str::limit($sanitation_6_file, 30) }}</a>
                                                            </div>
                                                        </div>
                                                    @else
                                                        <div class="col-md-12 mt-3">
                                                            <x-kplh-file wire:model="sanitation_6_file"
                                                                id="sanitation_6_file" placeholder="File"
                                                                :error="'sanitation_6_file'" />
                                                        </div>
                                                    @endif
                                                </div>

                                            </div>
                                        </div>
                                    </div><!-- /.form-group sanitation_6 -->

                                </div><!-- ./content-sanitasi -->
                            </div>
                        </div><!-- /.sanitasi -->

                        <div id="peralatan" class="section-peralatan" x-data="{ accordionOpen: false }">
                            <button
                                class="header-accordion d-flex justify-content-between w-100 border-0 bg-white py-3 px-0"
                                @click.prevent="accordionOpen = ! accordionOpen">
                                <h6 class="mb-0 fw-normal title-accordion">C. Peralatan</h6>
                                <span x-bind:class="accordionOpen ? 'open' : ''"><img
                                        src="{{ asset('/images/icons/angle-down.png') }}" alt="" /></span>
                            </button>
                            <div class="wrapper-content-accordion max-h-0 overflow-hidden position-relative transition-all duration-700"
                                x-ref="peralatan" x-bind:style="accordionOpen ? 'max-height: ' + 20000 + 'px' : ''"
                                x-transition.delay.5000ms>

                                <div class="content-section p-4" wire:ignore.self>

                                    <div class="row form-group mb-4">
                                        <label for="equipment_1_label"
                                            class="col-lg-4 col-md-12 col-form-label">Membersihkan dispenser air minum
                                            sekurang-kurangnya sekali seminggu khususnya ujung saluran air dispenser.
                                            Air yang tertampung dalam penadah dispenser dibuang setiap hari
                                        </label>
                                        <div class="col-lg-8 col-md-12">
                                            <div class="wrapper_equipment_1 d-flex flex-column gap-3"
                                                x-data="{ equipment_1_value: @entangle('equipment_1_value') }">
                                                <x-inputs.select2 wire:model="equipment_1_value"
                                                    id="equipment_1_value" class="form-select"
                                                    placeholder="Pemenuhan">
                                                    <option value="0">0 - Tidak Terpenuhi</option>
                                                    <option value="5">5 - Terpenuhi Sebagian</option>
                                                    <option value="10">10 - Terpenuhi Sepenuhnya</option>
                                                </x-inputs.select2>

                                                <div x-cloak
                                                    x-show="equipment_1_value === '0' || equipment_1_value === '5' || equipment_1_value === 0 || equipment_1_value === 5">
                                                    <div>
                                                        <x-kplh-texteditor wire:model="equipment_1_note"
                                                            id="equipment_1_note" placeholder="Keterangan"
                                                            :error="'equipment_1_note'" />
                                                    </div>
                                                    @if ($equipment_1_file && !Illuminate\Support\Str::contains($equipment_1_file, 'private/var/folders/'))
                                                        <div class="row mt-3">
                                                            <div class="col-md-3"><button type="button"
                                                                    class="btn btn-outline-secondary"
                                                                    wire:click="setFileNull('equipment_1_file')"><i
                                                                        class="fa fa-edit"></i> Ubah
                                                                    File</button></div>
                                                            <div class="col-md-9">
                                                                <a class="btn btn-outline-secondary"
                                                                    href="{{ route('kplh::download-file', ['food_hygiene', $equipment_1_file]) }}"
                                                                    target="_blank"><i class="fa fa-file"></i>
                                                                    {{ Illuminate\Support\Str::limit($equipment_1_file, 30) }}</a>
                                                            </div>
                                                        </div>
                                                    @else
                                                        <div class="col-md-12 mt-3">
                                                            <x-kplh-file wire:model="equipment_1_file"
                                                                id="equipment_1_file" placeholder="File"
                                                                :error="'equipment_1_file'" />
                                                        </div>
                                                    @endif
                                                </div>

                                            </div>
                                        </div>
                                    </div><!-- /.form-group equipment_1 -->

                                    <div class="row form-group mb-4">
                                        <label for="equipment_2_label"
                                            class="col-lg-4 col-md-12 col-form-label">Setiap peralatan dibebashamakan
                                            dengan merendam selama 5 detik dengan air mendidih 800° C-1000° C
                                        </label>
                                        <div class="col-lg-8 col-md-12">
                                            <div class="wrapper_equipment_2 d-flex flex-column gap-3"
                                                x-data="{ equipment_2_value: @entangle('equipment_2_value') }">
                                                <x-inputs.select2 wire:model="equipment_2_value"
                                                    id="equipment_2_value" class="form-select"
                                                    placeholder="Pemenuhan">
                                                    <option value="0">0 - Tidak Terpenuhi</option>
                                                    <option value="5">5 - Terpenuhi Sebagian</option>
                                                    <option value="10">10 - Terpenuhi Sepenuhnya</option>
                                                </x-inputs.select2>

                                                <div x-cloak
                                                    x-show="equipment_2_value === '0' || equipment_2_value === '5' || equipment_2_value === 0 || equipment_2_value === 5">
                                                    <div>
                                                        <x-kplh-texteditor wire:model="equipment_2_note"
                                                            id="equipment_2_note" placeholder="Keterangan"
                                                            :error="'equipment_2_note'" />
                                                    </div>
                                                    @if ($equipment_2_file && !Illuminate\Support\Str::contains($equipment_2_file, 'private/var/folders/'))
                                                        <div class="row mt-3">
                                                            <div class="col-md-3"><button type="button"
                                                                    class="btn btn-outline-secondary"
                                                                    wire:click="setFileNull('equipment_2_file')"><i
                                                                        class="fa fa-edit"></i> Ubah
                                                                    File</button></div>
                                                            <div class="col-md-9">
                                                                <a class="btn btn-outline-secondary"
                                                                    href="{{ route('kplh::download-file', ['food_hygiene', $equipment_2_file]) }}"
                                                                    target="_blank"><i class="fa fa-file"></i>
                                                                    {{ Illuminate\Support\Str::limit($equipment_2_file, 30) }}</a>
                                                            </div>
                                                        </div>
                                                    @else
                                                        <div class="col-md-12 mt-3">
                                                            <x-kplh-file wire:model="equipment_2_file"
                                                                id="equipment_2_file" placeholder="File"
                                                                :error="'equipment_2_file'" />
                                                        </div>
                                                    @endif
                                                </div>

                                            </div>
                                        </div>
                                    </div><!-- /.form-group equipment_2 -->

                                    <div class="row form-group mb-4">
                                        <label for="equipment_3_label"
                                            class="col-lg-4 col-md-12 col-form-label">Memeriksa peralatan pengolahan
                                            (kompor, oven, tabung gas, dll.) dan fasilitas dapur bekerja dengan baik
                                            minimal 1 x perbulan
                                        </label>
                                        <div class="col-lg-8 col-md-12">
                                            <div class="wrapper_equipment_3 d-flex flex-column gap-3"
                                                x-data="{ equipment_3_value: @entangle('equipment_3_value') }">
                                                <x-inputs.select2 wire:model="equipment_3_value"
                                                    id="equipment_3_value" class="form-select"
                                                    placeholder="Pemenuhan">
                                                    <option value="0">0 - Tidak Terpenuhi</option>
                                                    <option value="5">5 - Terpenuhi Sebagian</option>
                                                    <option value="10">10 - Terpenuhi Sepenuhnya</option>
                                                </x-inputs.select2>

                                                <div x-cloak
                                                    x-show="equipment_3_value === '0' || equipment_3_value === '5' || equipment_3_value === 0 || equipment_3_value === 5">
                                                    <div>
                                                        <x-kplh-texteditor wire:model="equipment_3_note"
                                                            id="equipment_3_note" placeholder="Keterangan"
                                                            :error="'equipment_3_note'" />
                                                    </div>
                                                    @if ($equipment_3_file && !Illuminate\Support\Str::contains($equipment_3_file, 'private/var/folders/'))
                                                        <div class="row mt-3">
                                                            <div class="col-md-3"><button type="button"
                                                                    class="btn btn-outline-secondary"
                                                                    wire:click="setFileNull('equipment_3_file')"><i
                                                                        class="fa fa-edit"></i> Ubah
                                                                    File</button></div>
                                                            <div class="col-md-9">
                                                                <a class="btn btn-outline-secondary"
                                                                    href="{{ route('kplh::download-file', ['food_hygiene', $equipment_3_file]) }}"
                                                                    target="_blank"><i class="fa fa-file"></i>
                                                                    {{ Illuminate\Support\Str::limit($equipment_3_file, 30) }}</a>
                                                            </div>
                                                        </div>
                                                    @else
                                                        <div class="col-md-12 mt-3">
                                                            <x-kplh-file wire:model="equipment_3_file"
                                                                id="equipment_3_file" placeholder="File"
                                                                :error="'equipment_3_file'" />
                                                        </div>
                                                    @endif
                                                </div>

                                            </div>
                                        </div>
                                    </div><!-- /.form-group equipment_3 -->

                                    <div class="row form-group mb-4">
                                        <label for="equipment_4_label"
                                            class="col-lg-4 col-md-12 col-form-label">Membersihkan lemari dingin
                                            (chiller dan freezer) dan memeriksa temperatur setiap hari. Untuk chiller
                                            antara 1° - 5° C dan freezer dibawah -100C
                                        </label>
                                        <div class="col-lg-8 col-md-12">
                                            <div class="wrapper_equipment_4 d-flex flex-column gap-3"
                                                x-data="{ equipment_4_value: @entangle('equipment_4_value') }">
                                                <x-inputs.select2 wire:model="equipment_4_value"
                                                    id="equipment_4_value" class="form-select"
                                                    placeholder="Pemenuhan">
                                                    <option value="0">0 - Tidak Terpenuhi</option>
                                                    <option value="5">5 - Terpenuhi Sebagian</option>
                                                    <option value="10">10 - Terpenuhi Sepenuhnya</option>
                                                </x-inputs.select2>

                                                <div x-cloak
                                                    x-show="equipment_4_value === '0' || equipment_4_value === '5' || equipment_4_value === 0 || equipment_4_value === 5">
                                                    <div>
                                                        <x-kplh-texteditor wire:model="equipment_4_note"
                                                            id="equipment_4_note" placeholder="Keterangan"
                                                            :error="'equipment_4_note'" />
                                                    </div>
                                                    @if ($equipment_4_file && !Illuminate\Support\Str::contains($equipment_4_file, 'private/var/folders/'))
                                                        <div class="row mt-3">
                                                            <div class="col-md-3"><button type="button"
                                                                    class="btn btn-outline-secondary"
                                                                    wire:click="setFileNull('equipment_4_file')"><i
                                                                        class="fa fa-edit"></i> Ubah
                                                                    File</button></div>
                                                            <div class="col-md-9">
                                                                <a class="btn btn-outline-secondary"
                                                                    href="{{ route('kplh::download-file', ['food_hygiene', $equipment_4_file]) }}"
                                                                    target="_blank"><i class="fa fa-file"></i>
                                                                    {{ Illuminate\Support\Str::limit($equipment_4_file, 30) }}</a>
                                                            </div>
                                                        </div>
                                                    @else
                                                        <div class="col-md-12 mt-3">
                                                            <x-kplh-file wire:model="equipment_4_file"
                                                                id="equipment_4_file" placeholder="File"
                                                                :error="'equipment_4_file'" />
                                                        </div>
                                                    @endif
                                                </div>

                                            </div>
                                        </div>
                                    </div><!-- /.form-group equipment_4 -->

                                    <div class="row form-group mb-4">
                                        <label for="equipment_5_label"
                                            class="col-lg-4 col-md-12 col-form-label">Memastikan tidak terdapat lalat,
                                            kecoa, tikus dan binatang lainnya di ruang dapur, ruang makan, ruang bahan
                                            makanan, dan tempat peralatan
                                        </label>
                                        <div class="col-lg-8 col-md-12">
                                            <div class="wrapper_equipment_5 d-flex flex-column gap-3"
                                                x-data="{ equipment_5_value: @entangle('equipment_5_value') }">
                                                <x-inputs.select2 wire:model="equipment_5_value"
                                                    id="equipment_5_value" class="form-select"
                                                    placeholder="Pemenuhan">
                                                    <option value="0">0 - Tidak Terpenuhi</option>
                                                    <option value="5">5 - Terpenuhi Sebagian</option>
                                                    <option value="10">10 - Terpenuhi Sepenuhnya</option>
                                                </x-inputs.select2>

                                                <div x-cloak
                                                    x-show="equipment_5_value === '0' || equipment_5_value === '5' || equipment_5_value === 0 || equipment_5_value === 5">
                                                    <div>
                                                        <x-kplh-texteditor wire:model="equipment_5_note"
                                                            id="equipment_5_note" placeholder="Keterangan"
                                                            :error="'equipment_5_note'" />
                                                    </div>
                                                    @if ($equipment_5_file && !Illuminate\Support\Str::contains($equipment_5_file, 'private/var/folders/'))
                                                        <div class="row mt-3">
                                                            <div class="col-md-3"><button type="button"
                                                                    class="btn btn-outline-secondary"
                                                                    wire:click="setFileNull('equipment_5_file')"><i
                                                                        class="fa fa-edit"></i> Ubah
                                                                    File</button></div>
                                                            <div class="col-md-9">
                                                                <a class="btn btn-outline-secondary"
                                                                    href="{{ route('kplh::download-file', ['food_hygiene', $equipment_5_file]) }}"
                                                                    target="_blank"><i class="fa fa-file"></i>
                                                                    {{ Illuminate\Support\Str::limit($equipment_5_file, 30) }}</a>
                                                            </div>
                                                        </div>
                                                    @else
                                                        <div class="col-md-12 mt-3">
                                                            <x-kplh-file wire:model="equipment_5_file"
                                                                id="equipment_5_file" placeholder="File"
                                                                :error="'equipment_5_file'" />
                                                        </div>
                                                    @endif
                                                </div>

                                            </div>
                                        </div>
                                    </div><!-- /.form-group equipment_5 -->

                                    <div class="row form-group mb-4">
                                        <label for="equipment_6_label" class="col-lg-4 col-md-12 col-form-label">Alat
                                            harus utuh, bentuk aman dan kebersihan alat harus bebas dari sisa makanan,
                                            lemak dan bahan pencuci.
                                        </label>
                                        <div class="col-lg-8 col-md-12">
                                            <div class="wrapper_equipment_6 d-flex flex-column gap-3"
                                                x-data="{ equipment_6_value: @entangle('equipment_6_value') }">
                                                <x-inputs.select2 wire:model="equipment_6_value"
                                                    id="equipment_6_value" class="form-select"
                                                    placeholder="Pemenuhan">
                                                    <option value="0">0 - Tidak Terpenuhi</option>
                                                    <option value="5">5 - Terpenuhi Sebagian</option>
                                                    <option value="10">10 - Terpenuhi Sepenuhnya</option>
                                                </x-inputs.select2>

                                                <div x-cloak
                                                    x-show="equipment_6_value === '0' || equipment_6_value === '5' || equipment_6_value === 0 || equipment_6_value === 5">
                                                    <div>
                                                        <x-kplh-texteditor wire:model="equipment_6_note"
                                                            id="equipment_6_note" placeholder="Keterangan"
                                                            :error="'equipment_6_note'" />
                                                    </div>
                                                    @if ($equipment_6_file && !Illuminate\Support\Str::contains($equipment_6_file, 'private/var/folders/'))
                                                        <div class="row mt-3">
                                                            <div class="col-md-3"><button type="button"
                                                                    class="btn btn-outline-secondary"
                                                                    wire:click="setFileNull('equipment_6_file')"><i
                                                                        class="fa fa-edit"></i> Ubah
                                                                    File</button></div>
                                                            <div class="col-md-9">
                                                                <a class="btn btn-outline-secondary"
                                                                    href="{{ route('kplh::download-file', ['food_hygiene', $equipment_6_file]) }}"
                                                                    target="_blank"><i class="fa fa-file"></i>
                                                                    {{ Illuminate\Support\Str::limit($equipment_6_file, 30) }}</a>
                                                            </div>
                                                        </div>
                                                    @else
                                                        <div class="col-md-12 mt-3">
                                                            <x-kplh-file wire:model="equipment_6_file"
                                                                id="equipment_6_file" placeholder="File"
                                                                :error="'equipment_6_file'" />
                                                        </div>
                                                    @endif
                                                </div>

                                            </div>
                                        </div>
                                    </div><!-- /.form-group equipment_6 -->

                                    <div class="row form-group mb-4">
                                        <label for="equipment_7_label" class="col-lg-4 col-md-12 col-form-label">Cara
                                            penyimpanan peralatan terlindung dari pencemaran, ruang penyimpanan tidak
                                            mudah berdebu, rak atau tempat penyimpanan bersih dan teratur, ruangan bebas
                                            dari lalat, kecoa, tikus dan hewan lainnya.
                                        </label>
                                        <div class="col-lg-8 col-md-12">
                                            <div class="wrapper_equipment_7 d-flex flex-column gap-3"
                                                x-data="{ equipment_7_value: @entangle('equipment_7_value') }">
                                                <x-inputs.select2 wire:model="equipment_7_value"
                                                    id="equipment_7_value" class="form-select"
                                                    placeholder="Pemenuhan">
                                                    <option value="0">0 - Tidak Terpenuhi</option>
                                                    <option value="5">5 - Terpenuhi Sebagian</option>
                                                    <option value="10">10 - Terpenuhi Sepenuhnya</option>
                                                </x-inputs.select2>

                                                <div x-cloak
                                                    x-show="equipment_7_value === '0' || equipment_7_value === '5' || equipment_7_value === 0 || equipment_7_value === 5">
                                                    <div>
                                                        <x-kplh-texteditor wire:model="equipment_7_note"
                                                            id="equipment_7_note" placeholder="Keterangan"
                                                            :error="'equipment_7_note'" />
                                                    </div>
                                                    @if ($equipment_7_file && !Illuminate\Support\Str::contains($equipment_7_file, 'private/var/folders/'))
                                                        <div class="row mt-3">
                                                            <div class="col-md-3"><button type="button"
                                                                    class="btn btn-outline-secondary"
                                                                    wire:click="setFileNull('equipment_7_file')"><i
                                                                        class="fa fa-edit"></i> Ubah
                                                                    File</button></div>
                                                            <div class="col-md-9">
                                                                <a class="btn btn-outline-secondary"
                                                                    href="{{ route('kplh::download-file', ['food_hygiene', $equipment_7_file]) }}"
                                                                    target="_blank"><i class="fa fa-file"></i>
                                                                    {{ Illuminate\Support\Str::limit($equipment_7_file, 30) }}</a>
                                                            </div>
                                                        </div>
                                                    @else
                                                        <div class="col-md-12 mt-3">
                                                            <x-kplh-file wire:model="equipment_7_file"
                                                                id="equipment_7_file" placeholder="File"
                                                                :error="'equipment_7_file'" />
                                                        </div>
                                                    @endif
                                                </div>

                                            </div>
                                        </div>
                                    </div><!-- /.form-group equipment_7 -->

                                    <div class="row form-group mb-4">
                                        <label for="equipment_8_label"
                                            class="col-lg-4 col-md-12 col-form-label">Tempat penirisan dan lap
                                            pengering dijaga kebersihannya, bahan lap tidak menimbulkan noda / sisa
                                            benang, tempat penirisan bebas debu / endapan. Mencuci dan mengeringkan kain
                                            lap setiap hari
                                        </label>
                                        <div class="col-lg-8 col-md-12">
                                            <div class="wrapper_equipment_8 d-flex flex-column gap-3"
                                                x-data="{ equipment_8_value: @entangle('equipment_8_value') }">
                                                <x-inputs.select2 wire:model="equipment_8_value"
                                                    id="equipment_8_value" class="form-select"
                                                    placeholder="Pemenuhan">
                                                    <option value="0">0 - Tidak Terpenuhi</option>
                                                    <option value="5">5 - Terpenuhi Sebagian</option>
                                                    <option value="10">10 - Terpenuhi Sepenuhnya</option>
                                                </x-inputs.select2>

                                                <div x-cloak
                                                    x-show="equipment_8_value === '0' || equipment_8_value === '5' || equipment_8_value === 0 || equipment_8_value === 5">
                                                    <div>
                                                        <x-kplh-texteditor wire:model="equipment_8_note"
                                                            id="equipment_8_note" placeholder="Keterangan"
                                                            :error="'equipment_8_note'" />
                                                    </div>
                                                    @if ($equipment_8_file && !Illuminate\Support\Str::contains($equipment_8_file, 'private/var/folders/'))
                                                        <div class="row mt-3">
                                                            <div class="col-md-3"><button type="button"
                                                                    class="btn btn-outline-secondary"
                                                                    wire:click="setFileNull('equipment_8_file')"><i
                                                                        class="fa fa-edit"></i> Ubah
                                                                    File</button></div>
                                                            <div class="col-md-9">
                                                                <a class="btn btn-outline-secondary"
                                                                    href="{{ route('kplh::download-file', ['food_hygiene', $equipment_8_file]) }}"
                                                                    target="_blank"><i class="fa fa-file"></i>
                                                                    {{ Illuminate\Support\Str::limit($equipment_8_file, 30) }}</a>
                                                            </div>
                                                        </div>
                                                    @else
                                                        <div class="col-md-12 mt-3">
                                                            <x-kplh-file wire:model="equipment_8_file"
                                                                id="equipment_8_file" placeholder="File"
                                                                :error="'equipment_8_file'" />
                                                        </div>
                                                    @endif
                                                </div>

                                            </div>
                                        </div>
                                    </div><!-- /.form-group equipment_8 -->

                                </div><!-- ./content-peralatan -->
                            </div>
                        </div><!-- /.peralatan -->

                        <div id="pengolah" class="section-pengolah" x-data="{ accordionOpen: false }">
                            <button
                                class="header-accordion d-flex justify-content-between w-100 border-0 bg-white py-3 px-0"
                                @click.prevent="accordionOpen = ! accordionOpen">
                                <h6 class="mb-0 fw-normal title-accordion">D. Pengolah/Penjamah Makanan</h6>
                                <span x-bind:class="accordionOpen ? 'open' : ''"><img
                                        src="{{ asset('/images/icons/angle-down.png') }}" alt="" /></span>
                            </button>
                            <div class="wrapper-content-accordion max-h-0 overflow-hidden position-relative transition-all duration-700"
                                x-ref="pengolah" x-bind:style="accordionOpen ? 'max-height: ' + 20000 + 'px' : ''"
                                x-transition.delay.5000ms>

                                <div class="content-section p-4" wire:ignore.self>

                                    <div class="row form-group mb-4">
                                        <label for="food_handler_1_label"
                                            class="col-lg-4 col-md-12 col-form-label">Melakukan pemeriksaan kesehatan
                                            pekerja penjamah makanan minimum 2 kali setahun dan melaporkan hasilnya
                                            kepada manajemen unit bisnis Adaro terkait
                                        </label>
                                        <div class="col-lg-8 col-md-12">
                                            <div class="wrapper_food_handler_1 d-flex flex-column gap-3"
                                                x-data="{ food_handler_1_value: @entangle('food_handler_1_value') }">
                                                <x-inputs.select2 wire:model="food_handler_1_value"
                                                    id="food_handler_1_value" class="form-select"
                                                    placeholder="Pemenuhan">
                                                    <option value="0">0 - Tidak Terpenuhi</option>
                                                    <option value="5">5 - Terpenuhi Sebagian</option>
                                                    <option value="10">10 - Terpenuhi Sepenuhnya</option>
                                                </x-inputs.select2>

                                                <div x-cloak
                                                    x-show="food_handler_1_value === '0' || food_handler_1_value === '5' || food_handler_1_value === 0 || food_handler_1_value === 5">
                                                    <div>
                                                        <x-kplh-texteditor wire:model="food_handler_1_note"
                                                            id="food_handler_1_note" placeholder="Keterangan"
                                                            :error="'food_handler_1_note'" />
                                                    </div>
                                                    @if ($food_handler_1_file && !Illuminate\Support\Str::contains($food_handler_1_file, 'private/var/folders/'))
                                                        <div class="row mt-3">
                                                            <div class="col-md-3"><button type="button"
                                                                    class="btn btn-outline-secondary"
                                                                    wire:click="setFileNull('food_handler_1_file')"><i
                                                                        class="fa fa-edit"></i> Ubah
                                                                    File</button></div>
                                                            <div class="col-md-9">
                                                                <a class="btn btn-outline-secondary"
                                                                    href="{{ route('kplh::download-file', ['food_hygiene', $food_handler_1_file]) }}"
                                                                    target="_blank"><i class="fa fa-file"></i>
                                                                    {{ Illuminate\Support\Str::limit($food_handler_1_file, 30) }}</a>
                                                            </div>
                                                        </div>
                                                    @else
                                                        <div class="col-md-12 mt-3">
                                                            <x-kplh-file wire:model="food_handler_1_file"
                                                                id="food_handler_1_file" placeholder="File"
                                                                :error="'food_handler_1_file'" />
                                                        </div>
                                                    @endif
                                                </div>

                                            </div>
                                        </div>
                                    </div><!-- /.form-group food_handler_1 -->

                                    <div class="row form-group mb-4">
                                        <label for="food_handler_2_label"
                                            class="col-lg-4 col-md-12 col-form-label">Pengelola/ penjamah makanan
                                            harus
                                            sehat dan tidak menderita penyakit menular dibuktikan dengan surat
                                            keterangan dokter/ hasil pemeriksaan kesehatan
                                        </label>
                                        <div class="col-lg-8 col-md-12">
                                            <div class="wrapper_food_handler_2 d-flex flex-column gap-3"
                                                x-data="{ food_handler_2_value: @entangle('food_handler_2_value') }">
                                                <x-inputs.select2 wire:model="food_handler_2_value"
                                                    id="food_handler_2_value" class="form-select"
                                                    placeholder="Pemenuhan">
                                                    <option value="0">0 - Tidak Terpenuhi</option>
                                                    <option value="5">5 - Terpenuhi Sebagian</option>
                                                    <option value="10">10 - Terpenuhi Sepenuhnya</option>
                                                </x-inputs.select2>

                                                <div x-cloak
                                                    x-show="food_handler_2_value === '0' || food_handler_2_value === '5' || food_handler_2_value === 0 || food_handler_2_value === 5">
                                                    <div>
                                                        <x-kplh-texteditor wire:model="food_handler_2_note"
                                                            id="food_handler_2_note" placeholder="Keterangan"
                                                            :error="'food_handler_2_note'" />
                                                    </div>
                                                    @if ($food_handler_2_file && !Illuminate\Support\Str::contains($food_handler_2_file, 'private/var/folders/'))
                                                        <div class="row mt-3">
                                                            <div class="col-md-3"><button type="button"
                                                                    class="btn btn-outline-secondary"
                                                                    wire:click="setFileNull('food_handler_2_file')"><i
                                                                        class="fa fa-edit"></i> Ubah
                                                                    File</button></div>
                                                            <div class="col-md-9">
                                                                <a class="btn btn-outline-secondary"
                                                                    href="{{ route('kplh::download-file', ['food_hygiene', $food_handler_2_file]) }}"
                                                                    target="_blank"><i class="fa fa-file"></i>
                                                                    {{ Illuminate\Support\Str::limit($food_handler_2_file, 30) }}</a>
                                                            </div>
                                                        </div>
                                                    @else
                                                        <div class="col-md-12 mt-3">
                                                            <x-kplh-file wire:model="food_handler_2_file"
                                                                id="food_handler_2_file" placeholder="File"
                                                                :error="'food_handler_2_file'" />
                                                        </div>
                                                    @endif
                                                </div>

                                            </div>
                                        </div>
                                    </div><!-- /.form-group food_handler_2 -->

                                    <div class="row form-group mb-4">
                                        <label for="food_handler_3_label"
                                            class="col-lg-4 col-md-12 col-form-label">Pekerja penjamah makanan harus
                                            memiliki pengetahuan mengenai sanitasi makanan (sertifikat kursus atau
                                            pelatihan)
                                        </label>
                                        <div class="col-lg-8 col-md-12">
                                            <div class="wrapper_food_handler_3 d-flex flex-column gap-3"
                                                x-data="{ food_handler_3_value: @entangle('food_handler_3_value') }">
                                                <x-inputs.select2 wire:model="food_handler_3_value"
                                                    id="food_handler_3_value" class="form-select"
                                                    placeholder="Pemenuhan">
                                                    <option value="0">0 - Tidak Terpenuhi</option>
                                                    <option value="5">5 - Terpenuhi Sebagian</option>
                                                    <option value="10">10 - Terpenuhi Sepenuhnya</option>
                                                </x-inputs.select2>

                                                <div x-cloak
                                                    x-show="food_handler_3_value === '0' || food_handler_3_value === '5' || food_handler_3_value === 0 || food_handler_3_value === 5">
                                                    <div>
                                                        <x-kplh-texteditor wire:model="food_handler_3_note"
                                                            id="food_handler_3_note" placeholder="Keterangan"
                                                            :error="'food_handler_3_note'" />
                                                    </div>
                                                    @if ($food_handler_3_file && !Illuminate\Support\Str::contains($food_handler_3_file, 'private/var/folders/'))
                                                        <div class="row mt-3">
                                                            <div class="col-md-3"><button type="button"
                                                                    class="btn btn-outline-secondary"
                                                                    wire:click="setFileNull('food_handler_3_file')"><i
                                                                        class="fa fa-edit"></i> Ubah
                                                                    File</button></div>
                                                            <div class="col-md-9">
                                                                <a class="btn btn-outline-secondary"
                                                                    href="{{ route('kplh::download-file', ['food_hygiene', $food_handler_3_file]) }}"
                                                                    target="_blank"><i class="fa fa-file"></i>
                                                                    {{ Illuminate\Support\Str::limit($food_handler_3_file, 30) }}</a>
                                                            </div>
                                                        </div>
                                                    @else
                                                        <div class="col-md-12 mt-3">
                                                            <x-kplh-file wire:model="food_handler_3_file"
                                                                id="food_handler_3_file" placeholder="File"
                                                                :error="'food_handler_3_file'" />
                                                        </div>
                                                    @endif
                                                </div>

                                            </div>
                                        </div>
                                    </div><!-- /.form-group food_handler_3 -->

                                    <div class="row form-group mb-4">
                                        <label for="food_handler_4_label"
                                            class="col-lg-4 col-md-12 col-form-label">Setiap hari memastikan petugas
                                            yang menangani makanan tidak dalam kondisi sakit, termasuk:
                                            · Infeksi kulit
                                            · Luka di permukaan kulit
                                            · Flu dan batuk
                                            · Diare dan muntah-muntah

                                            Petugas yang sakit dibebaskan sementara dari tugas menangani makanan
                                        </label>
                                        <div class="col-lg-8 col-md-12">
                                            <div class="wrapper_food_handler_4 d-flex flex-column gap-3"
                                                x-data="{ food_handler_4_value: @entangle('food_handler_4_value') }">
                                                <x-inputs.select2 wire:model="food_handler_4_value"
                                                    id="food_handler_4_value" class="form-select"
                                                    placeholder="Pemenuhan">
                                                    <option value="0">0 - Tidak Terpenuhi</option>
                                                    <option value="5">5 - Terpenuhi Sebagian</option>
                                                    <option value="10">10 - Terpenuhi Sepenuhnya</option>
                                                </x-inputs.select2>

                                                <div x-cloak
                                                    x-show="food_handler_4_value === '0' || food_handler_4_value === '5' || food_handler_4_value === 0 || food_handler_4_value === 5">
                                                    <div>
                                                        <x-kplh-texteditor wire:model="food_handler_4_note"
                                                            id="food_handler_4_note" placeholder="Keterangan"
                                                            :error="'food_handler_4_note'" />
                                                    </div>
                                                    @if ($food_handler_4_file && !Illuminate\Support\Str::contains($food_handler_4_file, 'private/var/folders/'))
                                                        <div class="row mt-3">
                                                            <div class="col-md-3"><button type="button"
                                                                    class="btn btn-outline-secondary"
                                                                    wire:click="setFileNull('food_handler_4_file')"><i
                                                                        class="fa fa-edit"></i> Ubah
                                                                    File</button></div>
                                                            <div class="col-md-9">
                                                                <a class="btn btn-outline-secondary"
                                                                    href="{{ route('kplh::download-file', ['food_hygiene', $food_handler_4_file]) }}"
                                                                    target="_blank"><i class="fa fa-file"></i>
                                                                    {{ Illuminate\Support\Str::limit($food_handler_4_file, 30) }}</a>
                                                            </div>
                                                        </div>
                                                    @else
                                                        <div class="col-md-12 mt-3">
                                                            <x-kplh-file wire:model="food_handler_4_file"
                                                                id="food_handler_4_file" placeholder="File"
                                                                :error="'food_handler_4_file'" />
                                                        </div>
                                                    @endif
                                                </div>

                                            </div>
                                        </div>
                                    </div><!-- /.form-group food_handler_4 -->

                                    <div class="row form-group mb-4">
                                        <label for="food_handler_5_label"
                                            class="col-lg-4 col-md-12 col-form-label">Memastikan petugas dapur memakai
                                            penutup kepala, celemek dan masker/penutup mulut, mengenakan sarung tangan
                                            plastik sekali pakai, dan sepatu tertutup (bukan sandal terbuka atau tidak
                                            beralas kaki). Memastikan APD (alat pelindung diri) yang digunakan dalam
                                            keadaan bersih
                                        </label>
                                        <div class="col-lg-8 col-md-12">
                                            <div class="wrapper_food_handler_5 d-flex flex-column gap-3"
                                                x-data="{ food_handler_5_value: @entangle('food_handler_5_value') }">
                                                <x-inputs.select2 wire:model="food_handler_5_value"
                                                    id="food_handler_5_value" class="form-select"
                                                    placeholder="Pemenuhan">
                                                    <option value="0">0 - Tidak Terpenuhi</option>
                                                    <option value="5">5 - Terpenuhi Sebagian</option>
                                                    <option value="10">10 - Terpenuhi Sepenuhnya</option>
                                                </x-inputs.select2>

                                                <div x-cloak
                                                    x-show="food_handler_5_value === '0' || food_handler_5_value === '5' || food_handler_5_value === 0 || food_handler_5_value === 5">
                                                    <div>
                                                        <x-kplh-texteditor wire:model="food_handler_5_note"
                                                            id="food_handler_5_note" placeholder="Keterangan"
                                                            :error="'food_handler_5_note'" />
                                                    </div>
                                                    @if ($food_handler_5_file && !Illuminate\Support\Str::contains($food_handler_5_file, 'private/var/folders/'))
                                                        <div class="row mt-3">
                                                            <div class="col-md-3"><button type="button"
                                                                    class="btn btn-outline-secondary"
                                                                    wire:click="setFileNull('food_handler_5_file')"><i
                                                                        class="fa fa-edit"></i> Ubah
                                                                    File</button></div>
                                                            <div class="col-md-9">
                                                                <a class="btn btn-outline-secondary"
                                                                    href="{{ route('kplh::download-file', ['food_hygiene', $food_handler_5_file]) }}"
                                                                    target="_blank"><i class="fa fa-file"></i>
                                                                    {{ Illuminate\Support\Str::limit($food_handler_5_file, 30) }}</a>
                                                            </div>
                                                        </div>
                                                    @else
                                                        <div class="col-md-12 mt-3">
                                                            <x-kplh-file wire:model="food_handler_5_file"
                                                                id="food_handler_5_file" placeholder="File"
                                                                :error="'food_handler_5_file'" />
                                                        </div>
                                                    @endif
                                                </div>

                                            </div>
                                        </div>
                                    </div><!-- /.form-group food_handler_5 -->

                                    <div class="row form-group mb-4">
                                        <label for="food_handler_6_label"
                                            class="col-lg-4 col-md-12 col-form-label">Setiap petugas dapur memiliki
                                            APD
                                            (Alat Pelindung Diri) sendiri, APD tidak dipakai bersama, dan memiliki
                                            tempat penyimpanan APD yang layak
                                        </label>
                                        <div class="col-lg-8 col-md-12">
                                            <div class="wrapper_food_handler_6 d-flex flex-column gap-3"
                                                x-data="{ food_handler_6_value: @entangle('food_handler_6_value') }">
                                                <x-inputs.select2 wire:model="food_handler_6_value"
                                                    id="food_handler_6_value" class="form-select"
                                                    placeholder="Pemenuhan">
                                                    <option value="0">0 - Tidak Terpenuhi</option>
                                                    <option value="5">5 - Terpenuhi Sebagian</option>
                                                    <option value="10">10 - Terpenuhi Sepenuhnya</option>
                                                </x-inputs.select2>

                                                <div x-cloak
                                                    x-show="food_handler_6_value === '0' || food_handler_6_value === '5' || food_handler_6_value === 0 || food_handler_6_value === 5">
                                                    <div>
                                                        <x-kplh-texteditor wire:model="food_handler_6_note"
                                                            id="food_handler_6_note" placeholder="Keterangan"
                                                            :error="'food_handler_6_note'" />
                                                    </div>
                                                    @if ($food_handler_6_file && !Illuminate\Support\Str::contains($food_handler_6_file, 'private/var/folders/'))
                                                        <div class="row mt-3">
                                                            <div class="col-md-3"><button type="button"
                                                                    class="btn btn-outline-secondary"
                                                                    wire:click="setFileNull('food_handler_6_file')"><i
                                                                        class="fa fa-edit"></i> Ubah
                                                                    File</button></div>
                                                            <div class="col-md-9">
                                                                <a class="btn btn-outline-secondary"
                                                                    href="{{ route('kplh::download-file', ['food_hygiene', $food_handler_6_file]) }}"
                                                                    target="_blank"><i class="fa fa-file"></i>
                                                                    {{ Illuminate\Support\Str::limit($food_handler_6_file, 30) }}</a>
                                                            </div>
                                                        </div>
                                                    @else
                                                        <div class="col-md-12 mt-3">
                                                            <x-kplh-file wire:model="food_handler_6_file"
                                                                id="food_handler_6_file" placeholder="File"
                                                                :error="'food_handler_6_file'" />
                                                        </div>
                                                    @endif
                                                </div>

                                            </div>
                                        </div>
                                    </div><!-- /.form-group food_handler_6 -->

                                    <div class="row form-group mb-4">
                                        <label for="food_handler_7_label"
                                            class="col-lg-4 col-md-12 col-form-label">Melarang petugas dapur untuk
                                            merokok dan mengunyah permen karet atau lainnya selama bekerja
                                        </label>
                                        <div class="col-lg-8 col-md-12">
                                            <div class="wrapper_food_handler_7 d-flex flex-column gap-3"
                                                x-data="{ food_handler_7_value: @entangle('food_handler_7_value') }">
                                                <x-inputs.select2 wire:model="food_handler_7_value"
                                                    id="food_handler_7_value" class="form-select"
                                                    placeholder="Pemenuhan">
                                                    <option value="0">0 - Tidak Terpenuhi</option>
                                                    <option value="5">5 - Terpenuhi Sebagian</option>
                                                    <option value="10">10 - Terpenuhi Sepenuhnya</option>
                                                </x-inputs.select2>

                                                <div x-cloak
                                                    x-show="food_handler_7_value === '0' || food_handler_7_value === '5' || food_handler_7_value === 0 || food_handler_7_value === 5">
                                                    <div>
                                                        <x-kplh-texteditor wire:model="food_handler_7_note"
                                                            id="food_handler_7_note" placeholder="Keterangan"
                                                            :error="'food_handler_7_note'" />
                                                    </div>
                                                    @if ($food_handler_7_file && !Illuminate\Support\Str::contains($food_handler_7_file, 'private/var/folders/'))
                                                        <div class="row mt-3">
                                                            <div class="col-md-3"><button type="button"
                                                                    class="btn btn-outline-secondary"
                                                                    wire:click="setFileNull('food_handler_7_file')"><i
                                                                        class="fa fa-edit"></i> Ubah
                                                                    File</button></div>
                                                            <div class="col-md-9">
                                                                <a class="btn btn-outline-secondary"
                                                                    href="{{ route('kplh::download-file', ['food_hygiene', $food_handler_7_file]) }}"
                                                                    target="_blank"><i class="fa fa-file"></i>
                                                                    {{ Illuminate\Support\Str::limit($food_handler_7_file, 30) }}</a>
                                                            </div>
                                                        </div>
                                                    @else
                                                        <div class="col-md-12 mt-3">
                                                            <x-kplh-file wire:model="food_handler_7_file"
                                                                id="food_handler_7_file" placeholder="File"
                                                                :error="'food_handler_7_file'" />
                                                        </div>
                                                    @endif
                                                </div>

                                            </div>
                                        </div>
                                    </div><!-- /.form-group food_handler_7 -->

                                    <div class="row form-group mb-4">
                                        <label for="food_handler_8_label"
                                            class="col-lg-4 col-md-12 col-form-label">Melarang petugas dapur memakai
                                            anting, jam tangan, cincin atau perhiasan lainnya selama bekerja
                                        </label>
                                        <div class="col-lg-8 col-md-12">
                                            <div class="wrapper_food_handler_8 d-flex flex-column gap-3"
                                                x-data="{ food_handler_8_value: @entangle('food_handler_8_value') }">
                                                <x-inputs.select2 wire:model="food_handler_8_value"
                                                    id="food_handler_8_value" class="form-select"
                                                    placeholder="Pemenuhan">
                                                    <option value="0">0 - Tidak Terpenuhi</option>
                                                    <option value="5">5 - Terpenuhi Sebagian</option>
                                                    <option value="10">10 - Terpenuhi Sepenuhnya</option>
                                                </x-inputs.select2>

                                                <div x-cloak
                                                    x-show="food_handler_8_value === '0' || food_handler_8_value === '5' || food_handler_8_value === 0 || food_handler_8_value === 5">
                                                    <div>
                                                        <x-kplh-texteditor wire:model="food_handler_8_note"
                                                            id="food_handler_8_note" placeholder="Keterangan"
                                                            :error="'food_handler_8_note'" />
                                                    </div>
                                                    @if ($food_handler_8_file && !Illuminate\Support\Str::contains($food_handler_8_file, 'private/var/folders/'))
                                                        <div class="row mt-3">
                                                            <div class="col-md-3"><button type="button"
                                                                    class="btn btn-outline-secondary"
                                                                    wire:click="setFileNull('food_handler_8_file')"><i
                                                                        class="fa fa-edit"></i> Ubah
                                                                    File</button></div>
                                                            <div class="col-md-9">
                                                                <a class="btn btn-outline-secondary"
                                                                    href="{{ route('kplh::download-file', ['food_hygiene', $food_handler_8_file]) }}"
                                                                    target="_blank"><i class="fa fa-file"></i>
                                                                    {{ Illuminate\Support\Str::limit($food_handler_8_file, 30) }}</a>
                                                            </div>
                                                        </div>
                                                    @else
                                                        <div class="col-md-12 mt-3">
                                                            <x-kplh-file wire:model="food_handler_8_file"
                                                                id="food_handler_8_file" placeholder="File"
                                                                :error="'food_handler_8_file'" />
                                                        </div>
                                                    @endif
                                                </div>

                                            </div>
                                        </div>
                                    </div><!-- /.form-group food_handler_8 -->

                                    <div class="row form-group mb-4">
                                        <label for="food_handler_9_label"
                                            class="col-lg-4 col-md-12 col-form-label">Memastikan pekerja dapur mencuci
                                            dan mengeringkan tangan dengan benar sekurang-kurangnya pada kondisi
                                            berikut:
                                            · Sebelum mulai bekerja
                                            · Sebelum memegang makanan mentah atau matang
                                            · Setelah memegang sisa makanan atau sampah lainnya
                                            · Setelah makan, merokok atau membuang ingus
                                            · Setelah dari toilet
                                        </label>
                                        <div class="col-lg-8 col-md-12">
                                            <div class="wrapper_food_handler_9 d-flex flex-column gap-3"
                                                x-data="{ food_handler_9_value: @entangle('food_handler_9_value') }">
                                                <x-inputs.select2 wire:model="food_handler_9_value"
                                                    id="food_handler_9_value" class="form-select"
                                                    placeholder="Pemenuhan">
                                                    <option value="0">0 - Tidak Terpenuhi</option>
                                                    <option value="5">5 - Terpenuhi Sebagian</option>
                                                    <option value="10">10 - Terpenuhi Sepenuhnya</option>
                                                </x-inputs.select2>

                                                <div x-cloak
                                                    x-show="food_handler_9_value === '0' || food_handler_9_value === '5' || food_handler_9_value === 0 || food_handler_9_value === 5">
                                                    <div>
                                                        <x-kplh-texteditor wire:model="food_handler_9_note"
                                                            id="food_handler_9_note" placeholder="Keterangan"
                                                            :error="'food_handler_9_note'" />
                                                    </div>
                                                    @if ($food_handler_9_file && !Illuminate\Support\Str::contains($food_handler_9_file, 'private/var/folders/'))
                                                        <div class="row mt-3">
                                                            <div class="col-md-3"><button type="button"
                                                                    class="btn btn-outline-secondary"
                                                                    wire:click="setFileNull('food_handler_9_file')"><i
                                                                        class="fa fa-edit"></i> Ubah
                                                                    File</button></div>
                                                            <div class="col-md-9">
                                                                <a class="btn btn-outline-secondary"
                                                                    href="{{ route('kplh::download-file', ['food_hygiene', $food_handler_9_file]) }}"
                                                                    target="_blank"><i class="fa fa-file"></i>
                                                                    {{ Illuminate\Support\Str::limit($food_handler_9_file, 30) }}</a>
                                                            </div>
                                                        </div>
                                                    @else
                                                        <div class="col-md-12 mt-3">
                                                            <x-kplh-file wire:model="food_handler_9_file"
                                                                id="food_handler_9_file" placeholder="File"
                                                                :error="'food_handler_9_file'" />
                                                        </div>
                                                    @endif
                                                </div>

                                            </div>
                                        </div>
                                    </div><!-- /.form-group food_handler_9 -->

                                    <div class="row form-group mb-4">
                                        <label for="food_handler_10_label"
                                            class="col-lg-4 col-md-12 col-form-label">Semua kegiatan pengolahan
                                            makanan
                                            harus dilakukan dengan cara terlindung dari kontak langsung dengan tubuh.
                                            Dapat menggunakan alat seperti sarung tangan plastik sekali pakai, penjepit
                                            makanan, dan sendok garpu
                                        </label>
                                        <div class="col-lg-8 col-md-12">
                                            <div class="wrapper_food_handler_10 d-flex flex-column gap-3"
                                                x-data="{ food_handler_10_value: @entangle('food_handler_10_value') }">
                                                <x-inputs.select2 wire:model="food_handler_10_value"
                                                    id="food_handler_10_value" class="form-select"
                                                    placeholder="Pemenuhan">
                                                    <option value="0">0 - Tidak Terpenuhi</option>
                                                    <option value="5">5 - Terpenuhi Sebagian</option>
                                                    <option value="10">10 - Terpenuhi Sepenuhnya</option>
                                                </x-inputs.select2>

                                                <div x-cloak
                                                    x-show="food_handler_10_value === '0' || food_handler_10_value === '5' || food_handler_10_value === 0 || food_handler_10_value === 5">
                                                    <div>
                                                        <x-kplh-texteditor wire:model="food_handler_10_note"
                                                            id="food_handler_10_note" placeholder="Keterangan"
                                                            :error="'food_handler_10_note'" />
                                                    </div>
                                                    @if ($food_handler_10_file && !Illuminate\Support\Str::contains($food_handler_10_file, 'private/var/folders/'))
                                                        <div class="row mt-3">
                                                            <div class="col-md-3"><button type="button"
                                                                    class="btn btn-outline-secondary"
                                                                    wire:click="setFileNull('food_handler_10_file')"><i
                                                                        class="fa fa-edit"></i> Ubah
                                                                    File</button></div>
                                                            <div class="col-md-9">
                                                                <a class="btn btn-outline-secondary"
                                                                    href="{{ route('kplh::download-file', ['food_hygiene', $food_handler_10_file]) }}"
                                                                    target="_blank"><i class="fa fa-file"></i>
                                                                    {{ Illuminate\Support\Str::limit($food_handler_10_file, 30) }}</a>
                                                            </div>
                                                        </div>
                                                    @else
                                                        <div class="col-md-12 mt-3">
                                                            <x-kplh-file wire:model="food_handler_10_file"
                                                                id="food_handler_10_file" placeholder="File"
                                                                :error="'food_handler_10_file'" />
                                                        </div>
                                                    @endif
                                                </div>

                                            </div>
                                        </div>
                                    </div><!-- /.form-group food_handler_10 -->

                                    <div class="row form-group mb-4">
                                        <label for="food_handler_11_label"
                                            class="col-lg-4 col-md-12 col-form-label">Memegang makanan yang telah
                                            dimasak menggunakan penjepit atau dengan sarung tangan plastik. Melarang
                                            memegang makanan matang langsung kontak dengan tangan
                                        </label>
                                        <div class="col-lg-8 col-md-12">
                                            <div class="wrapper_food_handler_11 d-flex flex-column gap-3"
                                                x-data="{ food_handler_11_value: @entangle('food_handler_11_value') }">
                                                <x-inputs.select2 wire:model="food_handler_11_value"
                                                    id="food_handler_11_value" class="form-select"
                                                    placeholder="Pemenuhan">
                                                    <option value="0">0 - Tidak Terpenuhi</option>
                                                    <option value="5">5 - Terpenuhi Sebagian</option>
                                                    <option value="10">10 - Terpenuhi Sepenuhnya</option>
                                                </x-inputs.select2>

                                                <div x-cloak
                                                    x-show="food_handler_11_value === '0' || food_handler_11_value === '5' || food_handler_11_value === 0 || food_handler_11_value === 5">
                                                    <div>
                                                        <x-kplh-texteditor wire:model="food_handler_11_note"
                                                            id="food_handler_11_note" placeholder="Keterangan"
                                                            :error="'food_handler_11_note'" />
                                                    </div>
                                                    @if ($food_handler_11_file && !Illuminate\Support\Str::contains($food_handler_11_file, 'private/var/folders/'))
                                                        <div class="row mt-3">
                                                            <div class="col-md-3"><button type="button"
                                                                    class="btn btn-outline-secondary"
                                                                    wire:click="setFileNull('food_handler_11_file')"><i
                                                                        class="fa fa-edit"></i> Ubah
                                                                    File</button></div>
                                                            <div class="col-md-9">
                                                                <a class="btn btn-outline-secondary"
                                                                    href="{{ route('kplh::download-file', ['food_hygiene', $food_handler_11_file]) }}"
                                                                    target="_blank"><i class="fa fa-file"></i>
                                                                    {{ Illuminate\Support\Str::limit($food_handler_11_file, 30) }}</a>
                                                            </div>
                                                        </div>
                                                    @else
                                                        <div class="col-md-12 mt-3">
                                                            <x-kplh-file wire:model="food_handler_11_file"
                                                                id="food_handler_11_file" placeholder="File"
                                                                :error="'food_handler_11_file'" />
                                                        </div>
                                                    @endif
                                                </div>

                                            </div>
                                        </div>
                                    </div><!-- /.form-group food_handler_11 -->

                                    <div class="row form-group mb-4">
                                        <label for="food_handler_12_label"
                                            class="col-lg-4 col-md-12 col-form-label">Menyiapkan makanan di atas meja.
                                            Melarang pekerja meletakkan makanan dan alat masak di lantai
                                        </label>
                                        <div class="col-lg-8 col-md-12">
                                            <div class="wrapper_food_handler_12 d-flex flex-column gap-3"
                                                x-data="{ food_handler_12_value: @entangle('food_handler_12_value') }">
                                                <x-inputs.select2 wire:model="food_handler_12_value"
                                                    id="food_handler_12_value" class="form-select"
                                                    placeholder="Pemenuhan">
                                                    <option value="0">0 - Tidak Terpenuhi</option>
                                                    <option value="5">5 - Terpenuhi Sebagian</option>
                                                    <option value="10">10 - Terpenuhi Sepenuhnya</option>
                                                </x-inputs.select2>

                                                <div x-cloak
                                                    x-show="food_handler_12_value === '0' || food_handler_12_value === '5' || food_handler_12_value === 0 || food_handler_12_value === 5">
                                                    <div>
                                                        <x-kplh-texteditor wire:model="food_handler_12_note"
                                                            id="food_handler_12_note" placeholder="Keterangan"
                                                            :error="'food_handler_12_note'" />
                                                    </div>
                                                    @if ($food_handler_12_file && !Illuminate\Support\Str::contains($food_handler_12_file, 'private/var/folders/'))
                                                        <div class="row mt-3">
                                                            <div class="col-md-3"><button type="button"
                                                                    class="btn btn-outline-secondary"
                                                                    wire:click="setFileNull('food_handler_12_file')"><i
                                                                        class="fa fa-edit"></i> Ubah
                                                                    File</button></div>
                                                            <div class="col-md-9">
                                                                <a class="btn btn-outline-secondary"
                                                                    href="{{ route('kplh::download-file', ['food_hygiene', $food_handler_12_file]) }}"
                                                                    target="_blank"><i class="fa fa-file"></i>
                                                                    {{ Illuminate\Support\Str::limit($food_handler_12_file, 30) }}</a>
                                                            </div>
                                                        </div>
                                                    @else
                                                        <div class="col-md-12 mt-3">
                                                            <x-kplh-file wire:model="food_handler_12_file"
                                                                id="food_handler_12_file" placeholder="File"
                                                                :error="'food_handler_12_file'" />
                                                        </div>
                                                    @endif
                                                </div>

                                            </div>
                                        </div>
                                    </div><!-- /.form-group food_handler_12 -->
                                </div><!-- ./content-pengolah -->
                            </div>
                        </div><!-- /.pengolah -->

                        <div id="penyimpanan" class="section-penyimpanan" x-data="{ accordionOpen: false }">
                            <button
                                class="header-accordion d-flex justify-content-between w-100 border-0 bg-white py-3 px-0"
                                @click.prevent="accordionOpen = ! accordionOpen">
                                <h6 class="mb-0 fw-normal title-accordion">E. Penyimpanan Bahan Makanan</h6>
                                <span x-bind:class="accordionOpen ? 'open' : ''"><img
                                        src="{{ asset('/images/icons/angle-down.png') }}" alt="" /></span>
                            </button>
                            <div class="wrapper-content-accordion max-h-0 overflow-hidden position-relative transition-all duration-700"
                                x-ref="penyimpanan" x-bind:style="accordionOpen ? 'max-height: ' + 20000 + 'px' : ''"
                                x-transition.delay.5000ms>

                                <div class="content-section p-4" wire:ignore.self>

                                    <div class="row form-group mb-4">
                                        <label for="food_storage_1_label"
                                            class="col-lg-4 col-md-12 col-form-label">Tempat penyimpanan bahan makanan
                                            harus terhindar dari kemungkinan kontaminasi baik oleh bakteri, serangga,
                                            tikus dan hewan lainnya maupun bahan berbahaya
                                        </label>
                                        <div class="col-lg-8 col-md-12">
                                            <div class="wrapper_food_storage_1 d-flex flex-column gap-3"
                                                x-data="{ food_storage_1_value: @entangle('food_storage_1_value') }">
                                                <x-inputs.select2 wire:model="food_storage_1_value"
                                                    id="food_storage_1_value" class="form-select"
                                                    placeholder="Pemenuhan">
                                                    <option value="0">0 - Tidak Terpenuhi</option>
                                                    <option value="5">5 - Terpenuhi Sebagian</option>
                                                    <option value="10">10 - Terpenuhi Sepenuhnya</option>
                                                </x-inputs.select2>

                                                <div x-cloak
                                                    x-show="food_storage_1_value === '0' || food_storage_1_value === '5' || food_storage_1_value === 0 || food_storage_1_value === 5">
                                                    <div>
                                                        <x-kplh-texteditor wire:model="food_storage_1_note"
                                                            id="food_storage_1_note" placeholder="Keterangan"
                                                            :error="'food_storage_1_note'" />
                                                    </div>
                                                    @if ($food_storage_1_file && !Illuminate\Support\Str::contains($food_storage_1_file, 'private/var/folders/'))
                                                        <div class="row mt-3">
                                                            <div class="col-md-3"><button type="button"
                                                                    class="btn btn-outline-secondary"
                                                                    wire:click="setFileNull('food_storage_1_file')"><i
                                                                        class="fa fa-edit"></i> Ubah
                                                                    File</button></div>
                                                            <div class="col-md-9">
                                                                <a class="btn btn-outline-secondary"
                                                                    href="{{ route('kplh::download-file', ['food_hygiene', $food_storage_1_file]) }}"
                                                                    target="_blank"><i class="fa fa-file"></i>
                                                                    {{ Illuminate\Support\Str::limit($food_storage_1_file, 30) }}</a>
                                                            </div>
                                                        </div>
                                                    @else
                                                        <div class="col-md-12 mt-3">
                                                            <x-kplh-file wire:model="food_storage_1_file"
                                                                id="food_storage_1_file" placeholder="File"
                                                                :error="'food_storage_1_file'" />
                                                        </div>
                                                    @endif
                                                </div>

                                            </div>
                                        </div>
                                    </div><!-- /.form-group food_storage_1 -->

                                    <div class="row form-group mb-4">
                                        <label for="food_storage_2_label"
                                            class="col-lg-4 col-md-12 col-form-label">Penyimpanan termasuk pada gudang
                                            kering dan gudang basah, harus memerhatikan prinsip First In First Out
                                            (FIFO) dan First Expired First Out (FEFO) yaitu bahan makanan yang disimpan
                                            terlebih dahulu dan yang mendekati masa kadaluarsa dimanfaatkan/digunakan
                                            lebih dahulu
                                        </label>
                                        <div class="col-lg-8 col-md-12">
                                            <div class="wrapper_food_storage_2 d-flex flex-column gap-3"
                                                x-data="{ food_storage_2_value: @entangle('food_storage_2_value') }">
                                                <x-inputs.select2 wire:model="food_storage_2_value"
                                                    id="food_storage_2_value" class="form-select"
                                                    placeholder="Pemenuhan">
                                                    <option value="0">0 - Tidak Terpenuhi</option>
                                                    <option value="5">5 - Terpenuhi Sebagian</option>
                                                    <option value="10">10 - Terpenuhi Sepenuhnya</option>
                                                </x-inputs.select2>

                                                <div x-cloak
                                                    x-show="food_storage_2_value === '0' || food_storage_2_value === '5' || food_storage_2_value === 0 || food_storage_2_value === 5">
                                                    <div>
                                                        <x-kplh-texteditor wire:model="food_storage_2_note"
                                                            id="food_storage_2_note" placeholder="Keterangan"
                                                            :error="'food_storage_2_note'" />
                                                    </div>
                                                    @if ($food_storage_2_file && !Illuminate\Support\Str::contains($food_storage_2_file, 'private/var/folders/'))
                                                        <div class="row mt-3">
                                                            <div class="col-md-3"><button type="button"
                                                                    class="btn btn-outline-secondary"
                                                                    wire:click="setFileNull('food_storage_2_file')"><i
                                                                        class="fa fa-edit"></i> Ubah
                                                                    File</button></div>
                                                            <div class="col-md-9">
                                                                <a class="btn btn-outline-secondary"
                                                                    href="{{ route('kplh::download-file', ['food_hygiene', $food_storage_2_file]) }}"
                                                                    target="_blank"><i class="fa fa-file"></i>
                                                                    {{ Illuminate\Support\Str::limit($food_storage_2_file, 30) }}</a>
                                                            </div>
                                                        </div>
                                                    @else
                                                        <div class="col-md-12 mt-3">
                                                            <x-kplh-file wire:model="food_storage_2_file"
                                                                id="food_storage_2_file" placeholder="File"
                                                                :error="'food_storage_2_file'" />
                                                        </div>
                                                    @endif
                                                </div>

                                            </div>
                                        </div>
                                    </div><!-- /.form-group food_storage_2 -->

                                    <div class="row form-group mb-4">
                                        <label for="food_storage_3_label"
                                            class="col-lg-4 col-md-12 col-form-label">Tempat atau wadah penyimpanan
                                            harus sesuai dengan jenis bahan makanan contohnya bahan makanan yang cepat
                                            rusak disimpan dalam lemari pendingin dan bahan makanan kering disimpan
                                            ditempat yang kering dan tidak lembab
                                        </label>
                                        <div class="col-lg-8 col-md-12">
                                            <div class="wrapper_food_storage_3 d-flex flex-column gap-3"
                                                x-data="{ food_storage_3_value: @entangle('food_storage_3_value') }">
                                                <x-inputs.select2 wire:model="food_storage_3_value"
                                                    id="food_storage_3_value" class="form-select"
                                                    placeholder="Pemenuhan">
                                                    <option value="0">0 - Tidak Terpenuhi</option>
                                                    <option value="5">5 - Terpenuhi Sebagian</option>
                                                    <option value="10">10 - Terpenuhi Sepenuhnya</option>
                                                </x-inputs.select2>

                                                <div x-cloak
                                                    x-show="food_storage_3_value === '0' || food_storage_3_value === '5' || food_storage_3_value === 0 || food_storage_3_value === 5">
                                                    <div>
                                                        <x-kplh-texteditor wire:model="food_storage_3_note"
                                                            id="food_storage_3_note" placeholder="Keterangan"
                                                            :error="'food_storage_3_note'" />
                                                    </div>
                                                    @if ($food_storage_3_file && !Illuminate\Support\Str::contains($food_storage_3_file, 'private/var/folders/'))
                                                        <div class="row mt-3">
                                                            <div class="col-md-3"><button type="button"
                                                                    class="btn btn-outline-secondary"
                                                                    wire:click="setFileNull('food_storage_3_file')"><i
                                                                        class="fa fa-edit"></i> Ubah
                                                                    File</button></div>
                                                            <div class="col-md-9">
                                                                <a class="btn btn-outline-secondary"
                                                                    href="{{ route('kplh::download-file', ['food_hygiene', $food_storage_3_file]) }}"
                                                                    target="_blank"><i class="fa fa-file"></i>
                                                                    {{ Illuminate\Support\Str::limit($food_storage_3_file, 30) }}</a>
                                                            </div>
                                                        </div>
                                                    @else
                                                        <div class="col-md-12 mt-3">
                                                            <x-kplh-file wire:model="food_storage_3_file"
                                                                id="food_storage_3_file" placeholder="File"
                                                                :error="'food_storage_3_file'" />
                                                        </div>
                                                    @endif
                                                </div>

                                            </div>
                                        </div>
                                    </div><!-- /.form-group food_storage_3 -->

                                    <div class="row form-group mb-4">
                                        <label for="food_storage_4_label"
                                            class="col-lg-4 col-md-12 col-form-label">Menyediakan tempat khusus
                                            penyimpanan bahan makanan basah dan makanan kering. Menjaga suhu tempat
                                            penyimpanan disesuaikan dengan jenis bahan makanan
                                        </label>
                                        <div class="col-lg-8 col-md-12">
                                            <div class="wrapper_food_storage_4 d-flex flex-column gap-3"
                                                x-data="{ food_storage_4_value: @entangle('food_storage_4_value') }">
                                                <x-inputs.select2 wire:model="food_storage_4_value"
                                                    id="food_storage_4_value" class="form-select"
                                                    placeholder="Pemenuhan">
                                                    <option value="0">0 - Tidak Terpenuhi</option>
                                                    <option value="5">5 - Terpenuhi Sebagian</option>
                                                    <option value="10">10 - Terpenuhi Sepenuhnya</option>
                                                </x-inputs.select2>

                                                <div x-cloak
                                                    x-show="food_storage_4_value === '0' || food_storage_4_value === '5' || food_storage_4_value === 0 || food_storage_4_value === 5">
                                                    <div>
                                                        <x-kplh-texteditor wire:model="food_storage_4_note"
                                                            id="food_storage_4_note" placeholder="Keterangan"
                                                            :error="'food_storage_4_note'" />
                                                    </div>
                                                    @if ($food_storage_4_file && !Illuminate\Support\Str::contains($food_storage_4_file, 'private/var/folders/'))
                                                        <div class="row mt-3">
                                                            <div class="col-md-3"><button type="button"
                                                                    class="btn btn-outline-secondary"
                                                                    wire:click="setFileNull('food_storage_4_file')"><i
                                                                        class="fa fa-edit"></i> Ubah
                                                                    File</button></div>
                                                            <div class="col-md-9">
                                                                <a class="btn btn-outline-secondary"
                                                                    href="{{ route('kplh::download-file', ['food_hygiene', $food_storage_4_file]) }}"
                                                                    target="_blank"><i class="fa fa-file"></i>
                                                                    {{ Illuminate\Support\Str::limit($food_storage_4_file, 30) }}</a>
                                                            </div>
                                                        </div>
                                                    @else
                                                        <div class="col-md-12 mt-3">
                                                            <x-kplh-file wire:model="food_storage_4_file"
                                                                id="food_storage_4_file" placeholder="File"
                                                                :error="'food_storage_4_file'" />
                                                        </div>
                                                    @endif
                                                </div>

                                            </div>
                                        </div>
                                    </div><!-- /.form-group food_storage_4 -->

                                    <div class="row form-group mb-4">
                                        <label for="food_storage_5_label"
                                            class="col-lg-4 col-md-12 col-form-label">Menyediakan rak penyimpan dan
                                            meja penyiapan makanan dan bahan makanan yang terbuat dari stainless steel
                                            dan terlindungi dari cemaran/ debu. Rak atau meja kayu tidak diperbolehkan
                                            dengan alasan mudah tumbuh jamur, rayap, serta mikroorganisme lainnya
                                        </label>
                                        <div class="col-lg-8 col-md-12">
                                            <div class="wrapper_food_storage_5 d-flex flex-column gap-3"
                                                x-data="{ food_storage_5_value: @entangle('food_storage_5_value') }">
                                                <x-inputs.select2 wire:model="food_storage_5_value"
                                                    id="food_storage_5_value" class="form-select"
                                                    placeholder="Pemenuhan">
                                                    <option value="0">0 - Tidak Terpenuhi</option>
                                                    <option value="5">5 - Terpenuhi Sebagian</option>
                                                    <option value="10">10 - Terpenuhi Sepenuhnya</option>
                                                </x-inputs.select2>

                                                <div x-cloak
                                                    x-show="food_storage_5_value === '0' || food_storage_5_value === '5' || food_storage_5_value === 0 || food_storage_5_value === 5">
                                                    <div>
                                                        <x-kplh-texteditor wire:model="food_storage_5_note"
                                                            id="food_storage_5_note" placeholder="Keterangan"
                                                            :error="'food_storage_5_note'" />
                                                    </div>
                                                    @if ($food_storage_5_file && !Illuminate\Support\Str::contains($food_storage_5_file, 'private/var/folders/'))
                                                        <div class="row mt-3">
                                                            <div class="col-md-3"><button type="button"
                                                                    class="btn btn-outline-secondary"
                                                                    wire:click="setFileNull('food_storage_5_file')"><i
                                                                        class="fa fa-edit"></i> Ubah
                                                                    File</button></div>
                                                            <div class="col-md-9">
                                                                <a class="btn btn-outline-secondary"
                                                                    href="{{ route('kplh::download-file', ['food_hygiene', $food_storage_5_file]) }}"
                                                                    target="_blank"><i class="fa fa-file"></i>
                                                                    {{ Illuminate\Support\Str::limit($food_storage_5_file, 30) }}</a>
                                                            </div>
                                                        </div>
                                                    @else
                                                        <div class="col-md-12 mt-3">
                                                            <x-kplh-file wire:model="food_storage_5_file"
                                                                id="food_storage_5_file" placeholder="File"
                                                                :error="'food_storage_5_file'" />
                                                        </div>
                                                    @endif
                                                </div>

                                            </div>
                                        </div>
                                    </div><!-- /.form-group food_storage_5 -->

                                </div><!-- ./content-penyimpanan -->
                            </div>
                        </div><!-- /.penyimpanan -->

                        <div id="pengolahan" class="section-pengolahan" x-data="{ accordionOpen: false }">
                            <button
                                class="header-accordion d-flex justify-content-between w-100 border-0 bg-white py-3 px-0"
                                @click.prevent="accordionOpen = ! accordionOpen">
                                <h6 class="mb-0 fw-normal title-accordion">F. Pengolah Makanan</h6>
                                <span x-bind:class="accordionOpen ? 'open' : ''"><img
                                        src="{{ asset('/images/icons/angle-down.png') }}" alt="" /></span>
                            </button>
                            <div class="wrapper-content-accordion max-h-0 overflow-hidden position-relative transition-all duration-700"
                                x-ref="pengolahan" x-bind:style="accordionOpen ? 'max-height: ' + 20000 + 'px' : ''"
                                x-transition.delay.5000ms>

                                <div class="content-section p-4" wire:ignore.self>

                                    <div class="row form-group mb-4">
                                        <label for="food_processers_1_label"
                                            class="col-lg-4 col-md-12 col-form-label">Peracikan bahan, persiapan
                                            bumbu, persiapan pengolahan dan prioritas dalam memasak harus dilakukan
                                            sesuai tahapan dan harus higienis dan semua bahan yang siap dimasak harus
                                            dicuci dengan air mengalir
                                        </label>
                                        <div class="col-lg-8 col-md-12">
                                            <div class="wrapper_food_processers_1 d-flex flex-column gap-3"
                                                x-data="{ food_processers_1_value: @entangle('food_processers_1_value') }">
                                                <x-inputs.select2 wire:model="food_processers_1_value"
                                                    id="food_processers_1_value" class="form-select"
                                                    placeholder="Pemenuhan">
                                                    <option value="0">0 - Tidak Terpenuhi</option>
                                                    <option value="5">5 - Terpenuhi Sebagian</option>
                                                    <option value="10">10 - Terpenuhi Sepenuhnya</option>
                                                </x-inputs.select2>

                                                <div x-cloak
                                                    x-show="food_processers_1_value === '0' || food_processers_1_value === '5' || food_processers_1_value === 0 || food_processers_1_value === 5">
                                                    <div>
                                                        <x-kplh-texteditor wire:model="food_processers_1_note"
                                                            id="food_processers_1_note" placeholder="Keterangan"
                                                            :error="'food_processers_1_note'" />
                                                    </div>
                                                    @if ($food_processers_1_file && !Illuminate\Support\Str::contains($food_processers_1_file, 'private/var/folders/'))
                                                        <div class="row mt-3">
                                                            <div class="col-md-3"><button type="button"
                                                                    class="btn btn-outline-secondary"
                                                                    wire:click="setFileNull('food_processers_1_file')"><i
                                                                        class="fa fa-edit"></i> Ubah
                                                                    File</button></div>
                                                            <div class="col-md-9">
                                                                <a class="btn btn-outline-secondary"
                                                                    href="{{ route('kplh::download-file', ['food_hygiene', $food_processers_1_file]) }}"
                                                                    target="_blank"><i class="fa fa-file"></i>
                                                                    {{ Illuminate\Support\Str::limit($food_processers_1_file, 30) }}</a>
                                                            </div>
                                                        </div>
                                                    @else
                                                        <div class="col-md-12 mt-3">
                                                            <x-kplh-file wire:model="food_processers_1_file"
                                                                id="food_processers_1_file" placeholder="File"
                                                                :error="'food_processers_1_file'" />
                                                        </div>
                                                    @endif
                                                </div>

                                            </div>
                                        </div>
                                    </div><!-- /.form-group food_processers_1 -->

                                    <div class="row form-group mb-4">
                                        <label for="food_processers_2_label"
                                            class="col-lg-4 col-md-12 col-form-label">Peralatan masak dan peralatan
                                            makan terbuat dari bahan selain kayu, kuat dan tidak melepas bahan beracun
                                            serta aman bagi kesehatan
                                        </label>
                                        <div class="col-lg-8 col-md-12">
                                            <div class="wrapper_food_processers_2 d-flex flex-column gap-3"
                                                x-data="{ food_processers_2_value: @entangle('food_processers_2_value') }">
                                                <x-inputs.select2 wire:model="food_processers_2_value"
                                                    id="food_processers_2_value" class="form-select"
                                                    placeholder="Pemenuhan">
                                                    <option value="0">0 - Tidak Terpenuhi</option>
                                                    <option value="5">5 - Terpenuhi Sebagian</option>
                                                    <option value="10">10 - Terpenuhi Sepenuhnya</option>
                                                </x-inputs.select2>

                                                <div x-cloak
                                                    x-show="food_processers_2_value === '0' || food_processers_2_value === '5' || food_processers_2_value === 0 || food_processers_2_value === 5">
                                                    <div>
                                                        <x-kplh-texteditor wire:model="food_processers_2_note"
                                                            id="food_processers_2_note" placeholder="Keterangan"
                                                            :error="'food_processers_2_note'" />
                                                    </div>
                                                    @if ($food_processers_2_file && !Illuminate\Support\Str::contains($food_processers_2_file, 'private/var/folders/'))
                                                        <div class="row mt-3">
                                                            <div class="col-md-3"><button type="button"
                                                                    class="btn btn-outline-secondary"
                                                                    wire:click="setFileNull('food_processers_2_file')"><i
                                                                        class="fa fa-edit"></i> Ubah
                                                                    File</button></div>
                                                            <div class="col-md-9">
                                                                <a class="btn btn-outline-secondary"
                                                                    href="{{ route('kplh::download-file', ['food_hygiene', $food_processers_2_file]) }}"
                                                                    target="_blank"><i class="fa fa-file"></i>
                                                                    {{ Illuminate\Support\Str::limit($food_processers_2_file, 30) }}</a>
                                                            </div>
                                                        </div>
                                                    @else
                                                        <div class="col-md-12 mt-3">
                                                            <x-kplh-file wire:model="food_processers_2_file"
                                                                id="food_processers_2_file" placeholder="File"
                                                                :error="'food_processers_2_file'" />
                                                        </div>
                                                    @endif
                                                </div>

                                            </div>
                                        </div>
                                    </div><!-- /.form-group food_processers_2 -->

                                    <div class="row form-group mb-4">
                                        <label for="food_processers_3_label"
                                            class="col-lg-4 col-md-12 col-form-label">Perlengkapan pengolahan seperti
                                            kompor, tabung gas, lampu, kipas angin harus bersih, kuat dan berfungsi
                                            dengan baik, tidak menjadi sumber pencemaran dan tidak menyebabkan sumber
                                            bencana (kecelakaan)
                                        </label>
                                        <div class="col-lg-8 col-md-12">
                                            <div class="wrapper_food_processers_3 d-flex flex-column gap-3"
                                                x-data="{ food_processers_3_value: @entangle('food_processers_3_value') }">
                                                <x-inputs.select2 wire:model="food_processers_3_value"
                                                    id="food_processers_3_value" class="form-select"
                                                    placeholder="Pemenuhan">
                                                    <option value="0">0 - Tidak Terpenuhi</option>
                                                    <option value="5">5 - Terpenuhi Sebagian</option>
                                                    <option value="10">10 - Terpenuhi Sepenuhnya</option>
                                                </x-inputs.select2>

                                                <div x-cloak
                                                    x-show="food_processers_3_value === '0' || food_processers_3_value === '5' || food_processers_3_value === 0 || food_processers_3_value === 5">
                                                    <div>
                                                        <x-kplh-texteditor wire:model="food_processers_3_note"
                                                            id="food_processers_3_note" placeholder="Keterangan"
                                                            :error="'food_processers_3_note'" />
                                                    </div>
                                                    @if ($food_processers_3_file && !Illuminate\Support\Str::contains($food_processers_3_file, 'private/var/folders/'))
                                                        <div class="row mt-3">
                                                            <div class="col-md-3"><button type="button"
                                                                    class="btn btn-outline-secondary"
                                                                    wire:click="setFileNull('food_processers_3_file')"><i
                                                                        class="fa fa-edit"></i> Ubah
                                                                    File</button></div>
                                                            <div class="col-md-9">
                                                                <a class="btn btn-outline-secondary"
                                                                    href="{{ route('kplh::download-file', ['food_hygiene', $food_processers_3_file]) }}"
                                                                    target="_blank"><i class="fa fa-file"></i>
                                                                    {{ Illuminate\Support\Str::limit($food_processers_3_file, 30) }}</a>
                                                            </div>
                                                        </div>
                                                    @else
                                                        <div class="col-md-12 mt-3">
                                                            <x-kplh-file wire:model="food_processers_3_file"
                                                                id="food_processers_3_file" placeholder="File"
                                                                :error="'food_processers_3_file'" />
                                                        </div>
                                                    @endif
                                                </div>

                                            </div>
                                        </div>
                                    </div><!-- /.form-group food_processers_3 -->

                                    <div class="row form-group mb-4">
                                        <label for="food_processers_4_label"
                                            class="col-lg-4 col-md-12 col-form-label">Wadah penyimpanan makanan yang
                                            digunakan harus mempunyai tutup yang dapat menutup sempurna dan dapat
                                            mengeluarkan udara panas dari makanan untuk mencegah pengembunan atau
                                            kontaminasi ulang, terpisah untuk setiap jenis makanan
                                        </label>
                                        <div class="col-lg-8 col-md-12">
                                            <div class="wrapper_food_processers_4 d-flex flex-column gap-3"
                                                x-data="{ food_processers_4_value: @entangle('food_processers_4_value') }">
                                                <x-inputs.select2 wire:model="food_processers_4_value"
                                                    id="food_processers_4_value" class="form-select"
                                                    placeholder="Pemenuhan">
                                                    <option value="0">0 - Tidak Terpenuhi</option>
                                                    <option value="5">5 - Terpenuhi Sebagian</option>
                                                    <option value="10">10 - Terpenuhi Sepenuhnya</option>
                                                </x-inputs.select2>

                                                <div x-cloak
                                                    x-show="food_processers_4_value === '0' || food_processers_4_value === '5' || food_processers_4_value === 0 || food_processers_4_value === 5">
                                                    <div>
                                                        <x-kplh-texteditor wire:model="food_processers_4_note"
                                                            id="food_processers_4_note" placeholder="Keterangan"
                                                            :error="'food_processers_4_note'" />
                                                    </div>
                                                    @if ($food_processers_4_file && !Illuminate\Support\Str::contains($food_processers_4_file, 'private/var/folders/'))
                                                        <div class="row mt-3">
                                                            <div class="col-md-3"><button type="button"
                                                                    class="btn btn-outline-secondary"
                                                                    wire:click="setFileNull('food_processers_4_file')"><i
                                                                        class="fa fa-edit"></i> Ubah
                                                                    File</button></div>
                                                            <div class="col-md-9">
                                                                <a class="btn btn-outline-secondary"
                                                                    href="{{ route('kplh::download-file', ['food_hygiene', $food_processers_4_file]) }}"
                                                                    target="_blank"><i class="fa fa-file"></i>
                                                                    {{ Illuminate\Support\Str::limit($food_processers_4_file, 30) }}</a>
                                                            </div>
                                                        </div>
                                                    @else
                                                        <div class="col-md-12 mt-3">
                                                            <x-kplh-file wire:model="food_processers_4_file"
                                                                id="food_processers_4_file" placeholder="File"
                                                                :error="'food_processers_4_file'" />
                                                        </div>
                                                    @endif
                                                </div>

                                            </div>
                                        </div>
                                    </div><!-- /.form-group food_processers_4 -->

                                    <div class="row form-group mb-4">
                                        <label for="food_processers_5_label"
                                            class="col-lg-4 col-md-12 col-form-label">Keadaan peralatan harus utuh,
                                            tidak cacat, tidak retak, tidak gompal dan mudah dibersihkan
                                        </label>
                                        <div class="col-lg-8 col-md-12">
                                            <div class="wrapper_food_processers_5 d-flex flex-column gap-3"
                                                x-data="{ food_processers_5_value: @entangle('food_processers_5_value') }">
                                                <x-inputs.select2 wire:model="food_processers_5_value"
                                                    id="food_processers_5_value" class="form-select"
                                                    placeholder="Pemenuhan">
                                                    <option value="0">0 - Tidak Terpenuhi</option>
                                                    <option value="5">5 - Terpenuhi Sebagian</option>
                                                    <option value="10">10 - Terpenuhi Sepenuhnya</option>
                                                </x-inputs.select2>

                                                <div x-cloak
                                                    x-show="food_processers_5_value === '0' || food_processers_5_value === '5' || food_processers_5_value === 0 || food_processers_5_value === 5">
                                                    <div>
                                                        <x-kplh-texteditor wire:model="food_processers_5_note"
                                                            id="food_processers_5_note" placeholder="Keterangan"
                                                            :error="'food_processers_5_note'" />
                                                    </div>
                                                    @if ($food_processers_5_file && !Illuminate\Support\Str::contains($food_processers_5_file, 'private/var/folders/'))
                                                        <div class="row mt-3">
                                                            <div class="col-md-3"><button type="button"
                                                                    class="btn btn-outline-secondary"
                                                                    wire:click="setFileNull('food_processers_5_file')"><i
                                                                        class="fa fa-edit"></i> Ubah
                                                                    File</button></div>
                                                            <div class="col-md-9">
                                                                <a class="btn btn-outline-secondary"
                                                                    href="{{ route('kplh::download-file', ['food_hygiene', $food_processers_5_file]) }}"
                                                                    target="_blank"><i class="fa fa-file"></i>
                                                                    {{ Illuminate\Support\Str::limit($food_processers_5_file, 30) }}</a>
                                                            </div>
                                                        </div>
                                                    @else
                                                        <div class="col-md-12 mt-3">
                                                            <x-kplh-file wire:model="food_processers_5_file"
                                                                id="food_processers_5_file" placeholder="File"
                                                                :error="'food_processers_5_file'" />
                                                        </div>
                                                    @endif
                                                </div>

                                            </div>
                                        </div>
                                    </div><!-- /.form-group food_processers_5 -->

                                    <div class="row form-group mb-4">
                                        <label for="food_processers_6_label"
                                            class="col-lg-4 col-md-12 col-form-label">Proses pencairan makanan beku
                                            dilakukan secara perlahan pada suhu 10°C sampai kekenyalan makanan
                                            jadi/matang menjadi normal kembali (thawing) atau dengan menggunakan mesin
                                            thawing.
                                        </label>
                                        <div class="col-lg-8 col-md-12">
                                            <div class="wrapper_food_processers_6 d-flex flex-column gap-3"
                                                x-data="{ food_processers_6_value: @entangle('food_processers_6_value') }">
                                                <x-inputs.select2 wire:model="food_processers_6_value"
                                                    id="food_processers_6_value" class="form-select"
                                                    placeholder="Pemenuhan">
                                                    <option value="0">0 - Tidak Terpenuhi</option>
                                                    <option value="5">5 - Terpenuhi Sebagian</option>
                                                    <option value="10">10 - Terpenuhi Sepenuhnya</option>
                                                </x-inputs.select2>

                                                <div x-cloak
                                                    x-show="food_processers_6_value === '0' || food_processers_6_value === '5' || food_processers_6_value === 0 || food_processers_6_value === 5">
                                                    <div>
                                                        <x-kplh-texteditor wire:model="food_processers_6_note"
                                                            id="food_processers_6_note" placeholder="Keterangan"
                                                            :error="'food_processers_6_note'" />
                                                    </div>
                                                    @if ($food_processers_6_file && !Illuminate\Support\Str::contains($food_processers_6_file, 'private/var/folders/'))
                                                        <div class="row mt-3">
                                                            <div class="col-md-3"><button type="button"
                                                                    class="btn btn-outline-secondary"
                                                                    wire:click="setFileNull('food_processers_6_file')"><i
                                                                        class="fa fa-edit"></i> Ubah
                                                                    File</button></div>
                                                            <div class="col-md-9">
                                                                <a class="btn btn-outline-secondary"
                                                                    href="{{ route('kplh::download-file', ['food_hygiene', $food_processers_6_file]) }}"
                                                                    target="_blank"><i class="fa fa-file"></i>
                                                                    {{ Illuminate\Support\Str::limit($food_processers_6_file, 30) }}</a>
                                                            </div>
                                                        </div>
                                                    @else
                                                        <div class="col-md-12 mt-3">
                                                            <x-kplh-file wire:model="food_processers_6_file"
                                                                id="food_processers_6_file" placeholder="File"
                                                                :error="'food_processers_6_file'" />
                                                        </div>
                                                    @endif
                                                </div>

                                            </div>
                                        </div>
                                    </div><!-- /.form-group food_processers_6 -->

                                    <div class="row form-group mb-4">
                                        <label for="food_processers_7_label"
                                            class="col-lg-4 col-md-12 col-form-label">Tidak menjamah makanan jadi /
                                            masak dengan tangan tetapi harus menggunakan alat seperti penjepit atau
                                            sendok yang selalu dicuci
                                        </label>
                                        <div class="col-lg-8 col-md-12">
                                            <div class="wrapper_food_processers_7 d-flex flex-column gap-3"
                                                x-data="{ food_processers_7_value: @entangle('food_processers_7_value') }">
                                                <x-inputs.select2 wire:model="food_processers_7_value"
                                                    id="food_processers_7_value" class="form-select"
                                                    placeholder="Pemenuhan">
                                                    <option value="0">0 - Tidak Terpenuhi</option>
                                                    <option value="5">5 - Terpenuhi Sebagian</option>
                                                    <option value="10">10 - Terpenuhi Sepenuhnya</option>
                                                </x-inputs.select2>

                                                <div x-cloak
                                                    x-show="food_processers_7_value === '0' || food_processers_7_value === '5' || food_processers_7_value === 0 || food_processers_7_value === 5">
                                                    <div>
                                                        <x-kplh-texteditor wire:model="food_processers_7_note"
                                                            id="food_processers_7_note" placeholder="Keterangan"
                                                            :error="'food_processers_7_note'" />
                                                    </div>
                                                    @if ($food_processers_7_file && !Illuminate\Support\Str::contains($food_processers_7_file, 'private/var/folders/'))
                                                        <div class="row mt-3">
                                                            <div class="col-md-3"><button type="button"
                                                                    class="btn btn-outline-secondary"
                                                                    wire:click="setFileNull('food_processers_7_file')"><i
                                                                        class="fa fa-edit"></i> Ubah
                                                                    File</button></div>
                                                            <div class="col-md-9">
                                                                <a class="btn btn-outline-secondary"
                                                                    href="{{ route('kplh::download-file', ['food_hygiene', $food_processers_7_file]) }}"
                                                                    target="_blank"><i class="fa fa-file"></i>
                                                                    {{ Illuminate\Support\Str::limit($food_processers_7_file, 30) }}</a>
                                                            </div>
                                                        </div>
                                                    @else
                                                        <div class="col-md-12 mt-3">
                                                            <x-kplh-file wire:model="food_processers_7_file"
                                                                id="food_processers_7_file" placeholder="File"
                                                                :error="'food_processers_7_file'" />
                                                        </div>
                                                    @endif
                                                </div>

                                            </div>
                                        </div>
                                    </div><!-- /.form-group food_processers_7 -->

                                </div><!-- ./content-pengolahan -->
                            </div>
                        </div><!-- /.pengolahan -->

                        <div id="pengangkutan" class="section-pengangkutan" x-data="{ accordionOpen: false }">
                            <button
                                class="header-accordion d-flex justify-content-between w-100 border-0 bg-white py-3 px-0"
                                @click.prevent="accordionOpen = ! accordionOpen">
                                <h6 class="mb-0 fw-normal title-accordion">G. Pengangkutan Makanan</h6>
                                <span x-bind:class="accordionOpen ? 'open' : ''"><img
                                        src="{{ asset('/images/icons/angle-down.png') }}" alt="" /></span>
                            </button>
                            <div class="wrapper-content-accordion max-h-0 overflow-hidden position-relative transition-all duration-700"
                                x-ref="pengangkutan"
                                x-bind:style="accordionOpen ? 'max-height: ' + 20000 + 'px' : ''"
                                x-transition.delay.5000ms>

                                <div class="content-section p-4" wire:ignore.self>

                                    <div class="row form-group mb-4">
                                        <h4 class="col-lg-12 col-md-12 col-form-label">1. Pengangkutan Bahan Makanan
                                        </h4>
                                    </div>

                                    <div class="row form-group mb-4">
                                        <label for="food_transport_1_1_label"
                                            class="col-lg-4 col-md-12 col-form-label">Tidak bercampur dengan Bahan
                                            Berbahaya dan Beracun (B3)
                                        </label>
                                        <div class="col-lg-8 col-md-12">
                                            <div class="wrapper_food_transport_1_1 d-flex flex-column gap-3"
                                                x-data="{ food_transport_1_1_value: @entangle('food_transport_1_1_value') }">
                                                <x-inputs.select2 wire:model="food_transport_1_1_value"
                                                    id="food_transport_1_1_value" class="form-select"
                                                    placeholder="Pemenuhan">
                                                    <option value="0">0 - Tidak Terpenuhi</option>
                                                    <option value="5">5 - Terpenuhi Sebagian</option>
                                                    <option value="10">10 - Terpenuhi Sepenuhnya</option>
                                                </x-inputs.select2>

                                                <div x-cloak
                                                    x-show="food_transport_1_1_value === '0' || food_transport_1_1_value === '5' || food_transport_1_1_value === 0 || food_transport_1_1_value === 5">
                                                    <div>
                                                        <x-kplh-texteditor wire:model="food_transport_1_1_note"
                                                            id="food_transport_1_1_note" placeholder="Keterangan"
                                                            :error="'food_transport_1_1_note'" />
                                                    </div>
                                                    @if ($food_transport_1_1_file && !Illuminate\Support\Str::contains($food_transport_1_1_file, 'private/var/folders/'))
                                                        <div class="row mt-3">
                                                            <div class="col-md-3"><button type="button"
                                                                    class="btn btn-outline-secondary"
                                                                    wire:click="setFileNull('food_transport_1_1_file')"><i
                                                                        class="fa fa-edit"></i> Ubah
                                                                    File</button></div>
                                                            <div class="col-md-9">
                                                                <a class="btn btn-outline-secondary"
                                                                    href="{{ route('kplh::download-file', ['food_hygiene', $food_transport_1_1_file]) }}"
                                                                    target="_blank"><i class="fa fa-file"></i>
                                                                    {{ Illuminate\Support\Str::limit($food_transport_1_1_file, 30) }}</a>
                                                            </div>
                                                        </div>
                                                    @else
                                                        <div class="col-md-12 mt-3">
                                                            <x-kplh-file wire:model="food_transport_1_1_file"
                                                                id="food_transport_1_1_file"
                                                                placeholder="File" :error="'food_transport_1_1_file'" />
                                                        </div>
                                                    @endif
                                                </div>

                                            </div>
                                        </div>
                                    </div><!-- /.form-group food_transport_1_1 -->

                                    <div class="row form-group mb-4">
                                        <label for="food_transport_1_2_label"
                                            class="col-lg-4 col-md-12 col-form-label">Bahan makanan tidak boleh
                                            diinjak, dibanting, dan diduduki
                                        </label>
                                        <div class="col-lg-8 col-md-12">
                                            <div class="wrapper_food_transport_1_2 d-flex flex-column gap-3"
                                                x-data="{ food_transport_1_2_value: @entangle('food_transport_1_2_value') }">
                                                <x-inputs.select2 wire:model="food_transport_1_2_value"
                                                    id="food_transport_1_2_value" class="form-select"
                                                    placeholder="Pemenuhan">
                                                    <option value="0">0 - Tidak Terpenuhi</option>
                                                    <option value="5">5 - Terpenuhi Sebagian</option>
                                                    <option value="10">10 - Terpenuhi Sepenuhnya</option>
                                                </x-inputs.select2>

                                                <div x-cloak
                                                    x-show="food_transport_1_2_value === '0' || food_transport_1_2_value === '5' || food_transport_1_2_value === 0 || food_transport_1_2_value === 5">
                                                    <div>
                                                        <x-kplh-texteditor wire:model="food_transport_1_2_note"
                                                            id="food_transport_1_2_note" placeholder="Keterangan"
                                                            :error="'food_transport_1_2_note'" />
                                                    </div>
                                                    @if ($food_transport_1_2_file && !Illuminate\Support\Str::contains($food_transport_1_2_file, 'private/var/folders/'))
                                                        <div class="row mt-3">
                                                            <div class="col-md-3"><button type="button"
                                                                    class="btn btn-outline-secondary"
                                                                    wire:click="setFileNull('food_transport_1_2_file')"><i
                                                                        class="fa fa-edit"></i> Ubah
                                                                    File</button></div>
                                                            <div class="col-md-9">
                                                                <a class="btn btn-outline-secondary"
                                                                    href="{{ route('kplh::download-file', ['food_hygiene', $food_transport_1_2_file]) }}"
                                                                    target="_blank"><i class="fa fa-file"></i>
                                                                    {{ Illuminate\Support\Str::limit($food_transport_1_2_file, 30) }}</a>
                                                            </div>
                                                        </div>
                                                    @else
                                                        <div class="col-md-12 mt-3">
                                                            <x-kplh-file wire:model="food_transport_1_2_file"
                                                                id="food_transport_1_2_file"
                                                                placeholder="File" :error="'food_transport_1_2_file'" />
                                                        </div>
                                                    @endif
                                                </div>

                                            </div>
                                        </div>
                                    </div><!-- /.form-group food_transport_1_2 -->

                                    <div class="row form-group mb-4">
                                        <label for="food_transport_1_3_label"
                                            class="col-lg-4 col-md-12 col-form-label">Bahan makanan yang harus selalu
                                            dalam keadaan dingin, diangkut dengan menggunakan alat pendingin
                                        </label>
                                        <div class="col-lg-8 col-md-12">
                                            <div class="wrapper_food_transport_1_3 d-flex flex-column gap-3"
                                                x-data="{ food_transport_1_3_value: @entangle('food_transport_1_3_value') }">
                                                <x-inputs.select2 wire:model="food_transport_1_3_value"
                                                    id="food_transport_1_3_value" class="form-select"
                                                    placeholder="Pemenuhan">
                                                    <option value="0">0 - Tidak Terpenuhi</option>
                                                    <option value="5">5 - Terpenuhi Sebagian</option>
                                                    <option value="10">10 - Terpenuhi Sepenuhnya</option>
                                                </x-inputs.select2>

                                                <div x-cloak
                                                    x-show="food_transport_1_3_value === '0' || food_transport_1_3_value === '5' || food_transport_1_3_value === 0 || food_transport_1_3_value === 5">
                                                    <div>
                                                        <x-kplh-texteditor wire:model="food_transport_1_3_note"
                                                            id="food_transport_1_3_note" placeholder="Keterangan"
                                                            :error="'food_transport_1_3_note'" />
                                                    </div>
                                                    @if ($food_transport_1_3_file && !Illuminate\Support\Str::contains($food_transport_1_3_file, 'private/var/folders/'))
                                                        <div class="row mt-3">
                                                            <div class="col-md-3"><button type="button"
                                                                    class="btn btn-outline-secondary"
                                                                    wire:click="setFileNull('food_transport_1_3_file')"><i
                                                                        class="fa fa-edit"></i> Ubah
                                                                    File</button></div>
                                                            <div class="col-md-9">
                                                                <a class="btn btn-outline-secondary"
                                                                    href="{{ route('kplh::download-file', ['food_hygiene', $food_transport_1_3_file]) }}"
                                                                    target="_blank"><i class="fa fa-file"></i>
                                                                    {{ Illuminate\Support\Str::limit($food_transport_1_3_file, 30) }}</a>
                                                            </div>
                                                        </div>
                                                    @else
                                                        <div class="col-md-12 mt-3">
                                                            <x-kplh-file wire:model="food_transport_1_3_file"
                                                                id="food_transport_1_3_file"
                                                                placeholder="File" :error="'food_transport_1_3_file'" />
                                                        </div>
                                                    @endif
                                                </div>

                                            </div>
                                        </div>
                                    </div><!-- /.form-group food_transport_1_3 -->

                                    <div class="row form-group mb-4">
                                        <h4 class="col-lg-12 col-md-12 col-form-label">2. Pengangkutan Makanan Jadi/
                                            Masak</h4>
                                    </div>

                                    <div class="row form-group mb-4">
                                        <label for="food_transport_2_1_label"
                                            class="col-lg-4 col-md-12 col-form-label">Tidak bercampur dengan Bahan
                                            Berbahaya dan Beracun (B3)
                                        </label>
                                        <div class="col-lg-8 col-md-12">
                                            <div class="wrapper_food_transport_2_1 d-flex flex-column gap-3"
                                                x-data="{ food_transport_2_1_value: @entangle('food_transport_2_1_value') }">
                                                <x-inputs.select2 wire:model="food_transport_2_1_value"
                                                    id="food_transport_2_1_value" class="form-select"
                                                    placeholder="Pemenuhan">
                                                    <option value="0">0 - Tidak Terpenuhi</option>
                                                    <option value="5">5 - Terpenuhi Sebagian</option>
                                                    <option value="10">10 - Terpenuhi Sepenuhnya</option>
                                                </x-inputs.select2>

                                                <div x-cloak
                                                    x-show="food_transport_2_1_value === '0' || food_transport_2_1_value === '5' || food_transport_2_1_value === 0 || food_transport_2_1_value === 5">
                                                    <div>
                                                        <x-kplh-texteditor wire:model="food_transport_2_1_note"
                                                            id="food_transport_2_1_note" placeholder="Keterangan"
                                                            :error="'food_transport_2_1_note'" />
                                                    </div>
                                                    @if ($food_transport_2_1_file && !Illuminate\Support\Str::contains($food_transport_2_1_file, 'private/var/folders/'))
                                                        <div class="row mt-3">
                                                            <div class="col-md-3"><button type="button"
                                                                    class="btn btn-outline-secondary"
                                                                    wire:click="setFileNull('food_transport_2_1_file')"><i
                                                                        class="fa fa-edit"></i> Ubah
                                                                    File</button></div>
                                                            <div class="col-md-9">
                                                                <a class="btn btn-outline-secondary"
                                                                    href="{{ route('kplh::download-file', ['food_hygiene', $food_transport_2_1_file]) }}"
                                                                    target="_blank"><i class="fa fa-file"></i>
                                                                    {{ Illuminate\Support\Str::limit($food_transport_2_1_file, 30) }}</a>
                                                            </div>
                                                        </div>
                                                    @else
                                                        <div class="col-md-12 mt-3">
                                                            <x-kplh-file wire:model="food_transport_2_1_file"
                                                                id="food_transport_2_1_file"
                                                                placeholder="File" :error="'food_transport_2_1_file'" />
                                                        </div>
                                                    @endif
                                                </div>

                                            </div>
                                        </div>
                                    </div><!-- /.form-group food_transport_2_1 -->

                                    <div class="row form-group mb-4">
                                        <label for="food_transport_2_2_label"
                                            class="col-lg-4 col-md-12 col-form-label">Menggunakan kendaraan khusus
                                            pengangkut makanan jadi / masak dan harus selalu higienis
                                        </label>
                                        <div class="col-lg-8 col-md-12">
                                            <div class="wrapper_food_transport_2_2 d-flex flex-column gap-3"
                                                x-data="{ food_transport_2_2_value: @entangle('food_transport_2_2_value') }">
                                                <x-inputs.select2 wire:model="food_transport_2_2_value"
                                                    id="food_transport_2_2_value" class="form-select"
                                                    placeholder="Pemenuhan">
                                                    <option value="0">0 - Tidak Terpenuhi</option>
                                                    <option value="5">5 - Terpenuhi Sebagian</option>
                                                    <option value="10">10 - Terpenuhi Sepenuhnya</option>
                                                </x-inputs.select2>

                                                <div x-cloak
                                                    x-show="food_transport_2_2_value === '0' || food_transport_2_2_value === '5' || food_transport_2_2_value === 0 || food_transport_2_2_value === 5">
                                                    <div>
                                                        <x-kplh-texteditor wire:model="food_transport_2_2_note"
                                                            id="food_transport_2_2_note" placeholder="Keterangan"
                                                            :error="'food_transport_2_2_note'" />
                                                    </div>
                                                    @if ($food_transport_2_2_file && !Illuminate\Support\Str::contains($food_transport_2_2_file, 'private/var/folders/'))
                                                        <div class="row mt-3">
                                                            <div class="col-md-3"><button type="button"
                                                                    class="btn btn-outline-secondary"
                                                                    wire:click="setFileNull('food_transport_2_2_file')"><i
                                                                        class="fa fa-edit"></i> Ubah
                                                                    File</button></div>
                                                            <div class="col-md-9">
                                                                <a class="btn btn-outline-secondary"
                                                                    href="{{ route('kplh::download-file', ['food_hygiene', $food_transport_2_2_file]) }}"
                                                                    target="_blank"><i class="fa fa-file"></i>
                                                                    {{ Illuminate\Support\Str::limit($food_transport_2_2_file, 30) }}</a>
                                                            </div>
                                                        </div>
                                                    @else
                                                        <div class="col-md-12 mt-3">
                                                            <x-kplh-file wire:model="food_transport_2_2_file"
                                                                id="food_transport_2_2_file"
                                                                placeholder="File" :error="'food_transport_2_2_file'" />
                                                        </div>
                                                    @endif
                                                </div>

                                            </div>
                                        </div>
                                    </div><!-- /.form-group food_transport_2_2 -->

                                    <div class="row form-group mb-4">
                                        <label for="food_transport_2_3_label"
                                            class="col-lg-4 col-md-12 col-form-label">Setiap jenis makanan jadi
                                            mempunyai wadah masing-masing yang utuh, kuat, tidak karat dan ukurannya
                                            memadai dan bertutup
                                        </label>
                                        <div class="col-lg-8 col-md-12">
                                            <div class="wrapper_food_transport_2_3 d-flex flex-column gap-3"
                                                x-data="{ food_transport_2_3_value: @entangle('food_transport_2_3_value') }">
                                                <x-inputs.select2 wire:model="food_transport_2_3_value"
                                                    id="food_transport_2_3_value" class="form-select"
                                                    placeholder="Pemenuhan">
                                                    <option value="0">0 - Tidak Terpenuhi</option>
                                                    <option value="5">5 - Terpenuhi Sebagian</option>
                                                    <option value="10">10 - Terpenuhi Sepenuhnya</option>
                                                </x-inputs.select2>

                                                <div x-cloak
                                                    x-show="food_transport_2_3_value === '0' || food_transport_2_3_value === '5' || food_transport_2_3_value === 0 || food_transport_2_3_value === 5">
                                                    <div>
                                                        <x-kplh-texteditor wire:model="food_transport_2_3_note"
                                                            id="food_transport_2_3_note" placeholder="Keterangan"
                                                            :error="'food_transport_2_3_note'" />
                                                    </div>
                                                    @if ($food_transport_2_3_file && !Illuminate\Support\Str::contains($food_transport_2_3_file, 'private/var/folders/'))
                                                        <div class="row mt-3">
                                                            <div class="col-md-3"><button type="button"
                                                                    class="btn btn-outline-secondary"
                                                                    wire:click="setFileNull('food_transport_2_3_file')"><i
                                                                        class="fa fa-edit"></i> Ubah
                                                                    File</button></div>
                                                            <div class="col-md-9">
                                                                <a class="btn btn-outline-secondary"
                                                                    href="{{ route('kplh::download-file', ['food_hygiene', $food_transport_2_3_file]) }}"
                                                                    target="_blank"><i class="fa fa-file"></i>
                                                                    {{ Illuminate\Support\Str::limit($food_transport_2_3_file, 30) }}</a>
                                                            </div>
                                                        </div>
                                                    @else
                                                        <div class="col-md-12 mt-3">
                                                            <x-kplh-file wire:model="food_transport_2_3_file"
                                                                id="food_transport_2_3_file"
                                                                placeholder="File" :error="'food_transport_2_3_file'" />
                                                        </div>
                                                    @endif
                                                </div>

                                            </div>
                                        </div>
                                    </div><!-- /.form-group food_transport_2_3 -->

                                </div><!-- ./content-pengangkutan -->
                            </div>
                        </div><!-- /.pengangkutan -->

                        <div id="pencegahan" class="section-pencegahan" x-data="{ accordionOpen: false }">
                            <button
                                class="header-accordion d-flex justify-content-between w-100 border-0 bg-white py-3 px-0"
                                @click.prevent="accordionOpen = ! accordionOpen">
                                <h6 class="mb-0 fw-normal title-accordion">H. Pencegahan Umum</h6>
                                <span x-bind:class="accordionOpen ? 'open' : ''"><img
                                        src="{{ asset('/images/icons/angle-down.png') }}" alt="" /></span>
                            </button>
                            <div class="wrapper-content-accordion max-h-0 overflow-hidden position-relative transition-all duration-700"
                                x-ref="pencegahan" x-bind:style="accordionOpen ? 'max-height: ' + 20000 + 'px' : ''"
                                x-transition.delay.5000ms>

                                <div class="content-section p-4" wire:ignore.self>

                                    <div class="row form-group mb-4">
                                        <label for="general_precautions_1_label"
                                            class="col-lg-4 col-md-12 col-form-label">Setiap menu makanan harus ada
                                            satu porsi sampel (contoh) makanan yang disimpan sebagai bank sampel
                                        </label>
                                        <div class="col-lg-8 col-md-12">
                                            <div class="wrapper_general_precautions_1 d-flex flex-column gap-3"
                                                x-data="{ general_precautions_1_value: @entangle('general_precautions_1_value') }">
                                                <x-inputs.select2 wire:model="general_precautions_1_value"
                                                    id="general_precautions_1_value" class="form-select"
                                                    placeholder="Pemenuhan">
                                                    <option value="0">0 - Tidak Terpenuhi</option>
                                                    <option value="5">5 - Terpenuhi Sebagian</option>
                                                    <option value="10">10 - Terpenuhi Sepenuhnya</option>
                                                </x-inputs.select2>

                                                <div x-cloak
                                                    x-show="general_precautions_1_value === '0' || general_precautions_1_value === '5' || general_precautions_1_value === 0 || general_precautions_1_value === 5">
                                                    <div>
                                                        <x-kplh-texteditor wire:model="general_precautions_1_note"
                                                            id="general_precautions_1_note" placeholder="Keterangan"
                                                            :error="'general_precautions_1_note'" />
                                                    </div>
                                                    @if (
                                                        $general_precautions_1_file &&
                                                            !Illuminate\Support\Str::contains($general_precautions_1_file, 'private/var/folders/'))
                                                        <div class="row mt-3">
                                                            <div class="col-md-3"><button type="button"
                                                                    class="btn btn-outline-secondary"
                                                                    wire:click="setFileNull('general_precautions_1_file')"><i
                                                                        class="fa fa-edit"></i> Ubah
                                                                    File</button></div>
                                                            <div class="col-md-9">
                                                                <a class="btn btn-outline-secondary"
                                                                    href="{{ route('kplh::download-file', ['food_hygiene', $general_precautions_1_file]) }}"
                                                                    target="_blank"><i class="fa fa-file"></i>
                                                                    {{ Illuminate\Support\Str::limit($general_precautions_1_file, 30) }}</a>
                                                            </div>
                                                        </div>
                                                    @else
                                                        <div class="col-md-12 mt-3">
                                                            <x-kplh-file wire:model="general_precautions_1_file"
                                                                id="general_precautions_1_file"
                                                                placeholder="File" :error="'general_precautions_1_file'" />
                                                        </div>
                                                    @endif
                                                </div>

                                            </div>
                                        </div>
                                    </div><!-- /.form-group general_precautions_1 -->

                                    <div class="row form-group mb-4">
                                        <label for="general_precautions_2_label"
                                            class="col-lg-4 col-md-12 col-form-label">Penempatan sampel makanan untuk
                                            setiap jenis makanan harus steril, disimpan dalam suhu 100C selama minimal 1
                                            x 24 jam
                                        </label>
                                        <div class="col-lg-8 col-md-12">
                                            <div class="wrapper_general_precautions_2 d-flex flex-column gap-3"
                                                x-data="{ general_precautions_2_value: @entangle('general_precautions_2_value') }">
                                                <x-inputs.select2 wire:model="general_precautions_2_value"
                                                    id="general_precautions_2_value" class="form-select"
                                                    placeholder="Pemenuhan">
                                                    <option value="0">0 - Tidak Terpenuhi</option>
                                                    <option value="5">5 - Terpenuhi Sebagian</option>
                                                    <option value="10">10 - Terpenuhi Sepenuhnya</option>
                                                </x-inputs.select2>

                                                <div x-cloak
                                                    x-show="general_precautions_2_value === '0' || general_precautions_2_value === '5' || general_precautions_2_value === 0 || general_precautions_2_value === 5">
                                                    <div>
                                                        <x-kplh-texteditor wire:model="general_precautions_2_note"
                                                            id="general_precautions_2_note" placeholder="Keterangan"
                                                            :error="'general_precautions_2_note'" />
                                                    </div>
                                                    @if (
                                                        $general_precautions_2_file &&
                                                            !Illuminate\Support\Str::contains($general_precautions_2_file, 'private/var/folders/'))
                                                        <div class="row mt-3">
                                                            <div class="col-md-3"><button type="button"
                                                                    class="btn btn-outline-secondary"
                                                                    wire:click="setFileNull('general_precautions_2_file')"><i
                                                                        class="fa fa-edit"></i> Ubah
                                                                    File</button></div>
                                                            <div class="col-md-9">
                                                                <a class="btn btn-outline-secondary"
                                                                    href="{{ route('kplh::download-file', ['food_hygiene', $general_precautions_2_file]) }}"
                                                                    target="_blank"><i class="fa fa-file"></i>
                                                                    {{ Illuminate\Support\Str::limit($general_precautions_2_file, 30) }}</a>
                                                            </div>
                                                        </div>
                                                    @else
                                                        <div class="col-md-12 mt-3">
                                                            <x-kplh-file wire:model="general_precautions_2_file"
                                                                id="general_precautions_2_file"
                                                                placeholder="File" :error="'general_precautions_2_file'" />
                                                        </div>
                                                    @endif
                                                </div>

                                            </div>
                                        </div>
                                    </div><!-- /.form-group general_precautions_2 -->

                                    <div class="row form-group mb-4">
                                        <label for="general_precautions_3_label"
                                            class="col-lg-4 col-md-12 col-form-label">Memiliki mekanisme / prosedur
                                            tanggap darurat food outbreak
                                        </label>
                                        <div class="col-lg-8 col-md-12">
                                            <div class="wrapper_general_precautions_3 d-flex flex-column gap-3"
                                                x-data="{ general_precautions_3_value: @entangle('general_precautions_3_value') }">
                                                <x-inputs.select2 wire:model="general_precautions_3_value"
                                                    id="general_precautions_3_value" class="form-select"
                                                    placeholder="Pemenuhan">
                                                    <option value="0">0 - Tidak Terpenuhi</option>
                                                    <option value="5">5 - Terpenuhi Sebagian</option>
                                                    <option value="10">10 - Terpenuhi Sepenuhnya</option>
                                                </x-inputs.select2>

                                                <div x-cloak
                                                    x-show="general_precautions_3_value === '0' || general_precautions_3_value === '5' || general_precautions_3_value === 0 || general_precautions_3_value === 5">
                                                    <div>
                                                        <x-kplh-texteditor wire:model="general_precautions_3_note"
                                                            id="general_precautions_3_note" placeholder="Keterangan"
                                                            :error="'general_precautions_3_note'" />
                                                    </div>
                                                    @if (
                                                        $general_precautions_3_file &&
                                                            !Illuminate\Support\Str::contains($general_precautions_3_file, 'private/var/folders/'))
                                                        <div class="row mt-3">
                                                            <div class="col-md-3"><button type="button"
                                                                    class="btn btn-outline-secondary"
                                                                    wire:click="setFileNull('general_precautions_3_file')"><i
                                                                        class="fa fa-edit"></i> Ubah
                                                                    File</button></div>
                                                            <div class="col-md-9">
                                                                <a class="btn btn-outline-secondary"
                                                                    href="{{ route('kplh::download-file', ['food_hygiene', $general_precautions_3_file]) }}"
                                                                    target="_blank"><i class="fa fa-file"></i>
                                                                    {{ Illuminate\Support\Str::limit($general_precautions_3_file, 30) }}</a>
                                                            </div>
                                                        </div>
                                                    @else
                                                        <div class="col-md-12 mt-3">
                                                            <x-kplh-file wire:model="general_precautions_3_file"
                                                                id="general_precautions_3_file"
                                                                placeholder="File" :error="'general_precautions_3_file'" />
                                                        </div>
                                                    @endif
                                                </div>

                                            </div>
                                        </div>
                                    </div><!-- /.form-group general_precautions_3 -->

                                    <div class="row form-group mb-4">
                                        <label for="general_precautions_4_label"
                                            class="col-lg-4 col-md-12 col-form-label">Melakukan pengujian kualitas air
                                            minum sekurang-kurangnya sekali dalam sebulan
                                        </label>
                                        <div class="col-lg-8 col-md-12">
                                            <div class="wrapper_general_precautions_4 d-flex flex-column gap-3"
                                                x-data="{ general_precautions_4_value: @entangle('general_precautions_4_value') }">
                                                <x-inputs.select2 wire:model="general_precautions_4_value"
                                                    id="general_precautions_4_value" class="form-select"
                                                    placeholder="Pemenuhan">
                                                    <option value="0">0 - Tidak Terpenuhi</option>
                                                    <option value="5">5 - Terpenuhi Sebagian</option>
                                                    <option value="10">10 - Terpenuhi Sepenuhnya</option>
                                                </x-inputs.select2>

                                                <div x-cloak
                                                    x-show="general_precautions_4_value === '0' || general_precautions_4_value === '5' || general_precautions_4_value === 0 || general_precautions_4_value === 5">
                                                    <div>
                                                        <x-kplh-texteditor wire:model="general_precautions_4_note"
                                                            id="general_precautions_4_note" placeholder="Keterangan"
                                                            :error="'general_precautions_4_note'" />
                                                    </div>
                                                    @if (
                                                        $general_precautions_4_file &&
                                                            !Illuminate\Support\Str::contains($general_precautions_4_file, 'private/var/folders/'))
                                                        <div class="row mt-3">
                                                            <div class="col-md-3"><button type="button"
                                                                    class="btn btn-outline-secondary"
                                                                    wire:click="setFileNull('general_precautions_4_file')"><i
                                                                        class="fa fa-edit"></i> Ubah
                                                                    File</button></div>
                                                            <div class="col-md-9">
                                                                <a class="btn btn-outline-secondary"
                                                                    href="{{ route('kplh::download-file', ['food_hygiene', $general_precautions_4_file]) }}"
                                                                    target="_blank"><i class="fa fa-file"></i>
                                                                    {{ Illuminate\Support\Str::limit($general_precautions_4_file, 30) }}</a>
                                                            </div>
                                                        </div>
                                                    @else
                                                        <div class="col-md-12 mt-3">
                                                            <x-kplh-file wire:model="general_precautions_4_file"
                                                                id="general_precautions_4_file"
                                                                placeholder="File" :error="'general_precautions_4_file'" />
                                                        </div>
                                                    @endif
                                                </div>

                                            </div>
                                        </div>
                                    </div><!-- /.form-group general_precautions_4 -->

                                    <div class="row form-group mb-4">
                                        <label for="general_precautions_5_label"
                                            class="col-lg-4 col-md-12 col-form-label">Melakukan pemeriksaan vektor
                                            penyakit di lingkungan kerja katering (termasuk mess di lokasi katering dan
                                            di luar katering)
                                        </label>
                                        <div class="col-lg-8 col-md-12">
                                            <div class="wrapper_general_precautions_5 d-flex flex-column gap-3"
                                                x-data="{ general_precautions_5_value: @entangle('general_precautions_5_value') }">
                                                <x-inputs.select2 wire:model="general_precautions_5_value"
                                                    id="general_precautions_5_value" class="form-select"
                                                    placeholder="Pemenuhan">
                                                    <option value="0">0 - Tidak Terpenuhi</option>
                                                    <option value="5">5 - Terpenuhi Sebagian</option>
                                                    <option value="10">10 - Terpenuhi Sepenuhnya</option>
                                                </x-inputs.select2>

                                                <div x-cloak
                                                    x-show="general_precautions_5_value === '0' || general_precautions_5_value === '5' || general_precautions_5_value === 0 || general_precautions_5_value === 5">
                                                    <div>
                                                        <x-kplh-texteditor wire:model="general_precautions_5_note"
                                                            id="general_precautions_5_note" placeholder="Keterangan"
                                                            :error="'general_precautions_5_note'" />
                                                    </div>
                                                    @if (
                                                        $general_precautions_5_file &&
                                                            !Illuminate\Support\Str::contains($general_precautions_5_file, 'private/var/folders/'))
                                                        <div class="row mt-3">
                                                            <div class="col-md-3"><button type="button"
                                                                    class="btn btn-outline-secondary"
                                                                    wire:click="setFileNull('general_precautions_5_file')"><i
                                                                        class="fa fa-edit"></i> Ubah
                                                                    File</button></div>
                                                            <div class="col-md-9">
                                                                <a class="btn btn-outline-secondary"
                                                                    href="{{ route('kplh::download-file', ['food_hygiene', $general_precautions_5_file]) }}"
                                                                    target="_blank"><i class="fa fa-file"></i>
                                                                    {{ Illuminate\Support\Str::limit($general_precautions_5_file, 30) }}</a>
                                                            </div>
                                                        </div>
                                                    @else
                                                        <div class="col-md-12 mt-3">
                                                            <x-kplh-file wire:model="general_precautions_5_file"
                                                                id="general_precautions_5_file"
                                                                placeholder="File" :error="'general_precautions_5_file'" />
                                                        </div>
                                                    @endif
                                                </div>

                                            </div>
                                        </div>
                                    </div><!-- /.form-group general_precautions_5 -->

                                </div><!-- ./content-pencegahan -->
                            </div>
                        </div><!-- /.pencegahan -->

                        <hr>
                        <div class="row form-group">
                            <label for="tanggal_service" class="col col-form-label">Ringkasan Hasil Inspeksi</label>
                            <div class="col-8">
                                <x-kplh-texteditor wire:model="summary" id="summary"
                                    placeholder="Ringkasan Hasil Inspeksi" :error="'summary'" />
                            </div>
                        </div><!-- /.form-group tanggal_service -->

                        <div class="space">
                            <hr>
                        </div>

                        <div class="footer-action mb-2 p-3">
                            <div class="action-wrapper d-flex align-items-center justify-content-end gap-2">

                                <a href="javascript:history.go(-1)" class="btn btn-outline-secondary">Cancel</a>
                                <button type="submit" wire:click="$set('mode','draft')"
                                    class="btn btn-outline-warning d-flex justify-content-center align-item-center position-relative px-4">Save
                                    Draft</button>
                                <button type="submit" {{-- @if (is_null($ok)) disabled
                                    @else --}} wire:click="$set('mode','save')"
                                    {{-- @endif --}}
                                    class="btn btn-outline-default bg-green d-flex justify-content-center align-item-center text-white position-relative px-4">Save</button>

                            </div>
                        </div>

                    </form>

                </div>
            </div>
        </div>
    </div><!-- /.content-inspeksi-food-hygiene -->

</div><!-- /.inner-content -->
