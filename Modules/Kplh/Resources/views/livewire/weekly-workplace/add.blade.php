<div class="inner-content">

    <div
        class="header-content-inspeksi-area-maintank h-60px bg-white shadow-sm d-flex gap-2 align-items-center justify-content-between px-3">
        <div class="left-header">
            <a href="javascript:history.go(-1)" class="d-flex align-items-center gap-3">
                <span><i class="fa-solid fa-arrow-left"></i></span>
                <span>Inspeksi Tempat Kerja Mingguan</span>
            </a>
        </div><!-- /.left-header -->
    </div><!-- /.header-content-inspeksi-area-maintank -->

    <div class="content-inspeksi-area-maintank">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-12 col-md-12 col-lg-8">

                    <form class="py-4 d-flex flex-column gap-5" action="#" action="post"
                        wire:submit.prevent='save'>

                        <div class="title-form text-center my-3">
                            <h4>Inspeksi Tempat Kerja Mingguan</h4>
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

                        <div id="workplace_a" class="section-workplace_a" x-data="{ accordionOpen: false }">
                            <button
                                class="header-accordion d-flex justify-content-between w-100 border-0 bg-white py-3 px-0"
                                @click.prevent="accordionOpen = ! accordionOpen">
                                <h6 class="mb-0 fw-normal title-accordion">A. PERILAKU KARYAWAN SAAT BEKERJA</h6>
                                <span x-bind:class="accordionOpen ? 'open' : ''"><img
                                        src="{{ asset('/images/icons/angle-down.png') }}" alt="" /></span>
                            </button>
                            <div class="wrapper-content-accordion max-h-0 overflow-hidden position-relative transition-all duration-700"
                                x-ref="workplace_a" x-bind:style="accordionOpen ? 'max-height: ' + 20000 + 'px' : ''"
                                x-transition.delay.5000ms>

                                <div class="content-section p-4" wire:ignore.self>

                                    <div class="row form-group mb-4">
                                        <label for="workplace_a_1_label"
                                            class="col-lg-4 col-md-12 col-form-label">Apakah karyawan menggunakan
                                            Sepatu Safety, Helmet dan Kacamata Safety?
                                        </label>
                                        <div class="col-lg-8 col-md-12">
                                            <div class="wrapper_workplace_a_1 d-flex flex-column gap-3"
                                                x-data="{ workplace_a_1_value: @entangle('workplace_a_1_value') }">
                                                <x-inputs.select2 wire:model="workplace_a_1_value"
                                                    id="workplace_a_1_value" class="form-select"
                                                    placeholder="Pemenuhan">
                                                    <option value="Ya">Ya</option>
                                                    <option value="Tidak">Tidak</option>
                                                    <option value="N/A">N/A</option>
                                                </x-inputs.select2>

                                                <div x-cloak
                                                    x-show="workplace_a_1_value === 'Tidak' || workplace_a_1_value === '5' ">
                                                    <div>
                                                        <x-kplh-texteditor wire:model="workplace_a_1_note"
                                                            id="workplace_a_1_note" placeholder="Keterangan"
                                                            :error="'workplace_a_1_note'" />
                                                    </div>
                                                    <div class="mt-3">
                                                        <x-kplh-file wire:model="workplace_a_1_file"
                                                            id="workplace_a_1_file" placeholder="Upload foto temuan"
                                                            :error="'workplace_a_1_file'" />
                                                    </div>
                                                </div>

                                            </div>
                                        </div>
                                    </div><!-- /.form-group workplace_a_1 -->

                                    <div class="row form-group mb-4">
                                        <label for="workplace_a_2_label"
                                            class="col-lg-4 col-md-12 col-form-label">Apakah kondisi alat pelindung
                                            diri tersebut dalam kondisi baik?
                                        </label>
                                        <div class="col-lg-8 col-md-12">
                                            <div class="wrapper_workplace_a_2 d-flex flex-column gap-3"
                                                x-data="{ workplace_a_2_value: @entangle('workplace_a_2_value') }">
                                                <x-inputs.select2 wire:model="workplace_a_2_value"
                                                    id="workplace_a_2_value" class="form-select"
                                                    placeholder="Pemenuhan">
                                                    <option value="Ya">Ya</option>
                                                    <option value="Tidak">Tidak</option>
                                                    <option value="N/A">N/A</option>
                                                </x-inputs.select2>
                                                <div x-cloak
                                                    x-show="workplace_a_2_value === 'Tidak' || workplace_a_2_value === '5' ">
                                                    <div>
                                                        <x-kplh-texteditor wire:model="workplace_a_2_note"
                                                            id="workplace_a_2_note" placeholder="Keterangan"
                                                            :error="'workplace_a_2_note'" />
                                                    </div>
                                                    <div class="mt-3">
                                                        <x-kplh-file wire:model="workplace_a_2_file"
                                                            id="workplace_a_2_file" placeholder="Upload foto temuan"
                                                            :error="'workplace_a_2_file'" />
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div><!-- /.form-group workplace_a_2 -->

                                    <div class="row form-group mb-4">
                                        <label for="workplace_a_3_label"
                                            class="col-lg-4 col-md-12 col-form-label">Apakah karyawan yang sedang
                                            bekerja telah menggunakan Alat Pelindung Diri yang sesuai dengan resiko dan
                                            bahaya dalam pekerjaannya?
                                        </label>
                                        <div class="col-lg-8 col-md-12">
                                            <div class="wrapper_workplace_a_3 d-flex flex-column gap-3"
                                                x-data="{ workplace_a_3_value: @entangle('workplace_a_3_value') }">
                                                <x-inputs.select2 wire:model="workplace_a_3_value"
                                                    id="workplace_a_3_value" class="form-select"
                                                    placeholder="Pemenuhan">
                                                    <option value="Ya">Ya</option>
                                                    <option value="Tidak">Tidak</option>
                                                    <option value="N/A">N/A</option>
                                                </x-inputs.select2>
                                                <div x-cloak
                                                    x-show="workplace_a_3_value === 'Tidak' || workplace_a_3_value === '5' ">
                                                    <div>
                                                        <x-kplh-texteditor wire:model="workplace_a_3_note"
                                                            id="workplace_a_3_note" placeholder="Keterangan"
                                                            :error="'workplace_a_3_note'" />
                                                    </div>
                                                    <div class="mt-3">
                                                        <x-kplh-file wire:model="workplace_a_3_file"
                                                            id="workplace_a_3_file" placeholder="Upload foto temuan"
                                                            :error="'workplace_a_3_file'" />
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div><!-- /.form-group workplace_a_3 -->

                                    <div class="row form-group mb-4">
                                        <label for="workplace_a_4_label"
                                            class="col-lg-4 col-md-12 col-form-label">Apakah posisi karyawan yang
                                            sedang bekerja tersebut, akan TIDAK mungkin (atau kecil sekali
                                            kemungkinanya) bagi dirinya untuk dapat terjepit, tertabrak, terkena,
                                            tertimpa, terjatuh atau tersandung oleh suatu benda?
                                        </label>
                                        <div class="col-lg-8 col-md-12">
                                            <div class="wrapper_workplace_a_4 d-flex flex-column gap-3"
                                                x-data="{ workplace_a_4_value: @entangle('workplace_a_4_value') }">
                                                <x-inputs.select2 wire:model="workplace_a_4_value"
                                                    id="workplace_a_4_value" class="form-select"
                                                    placeholder="Pemenuhan">
                                                    <option value="Ya">Ya</option>
                                                    <option value="Tidak">Tidak</option>
                                                    <option value="N/A">N/A</option>
                                                </x-inputs.select2>
                                                <div x-cloak
                                                    x-show="workplace_a_4_value === 'Tidak' || workplace_a_4_value === '5' ">
                                                    <div>
                                                        <x-kplh-texteditor wire:model="workplace_a_4_note"
                                                            id="workplace_a_4_note" placeholder="Keterangan"
                                                            :error="'workplace_a_4_note'" />
                                                    </div>
                                                    <div class="mt-3">
                                                        <x-kplh-file wire:model="workplace_a_4_file"
                                                            id="workplace_a_4_file" placeholder="Upload foto temuan"
                                                            :error="'workplace_a_4_file'" />
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div><!-- /.form-group workplace_a_4 -->

                                    <div class="row form-group mb-4">
                                        <label for="workplace_a_5_label"
                                            class="col-lg-4 col-md-12 col-form-label">Apakah cara naik/turun yang
                                            dilakukan karyawan itu benar dan aman? Selalu berpegangan pada handrail?
                                            Menginjak anak tangga satu per satu? Tidak terburu-buru? Selalu menjaga tiga
                                            titik kontak saat naik/turun? Tidak membawa serta peralatan kerja/barang
                                            saat naik/turun?
                                        </label>
                                        <div class="col-lg-8 col-md-12">
                                            <div class="wrapper_workplace_a_5 d-flex flex-column gap-3"
                                                x-data="{ workplace_a_5_value: @entangle('workplace_a_5_value') }">
                                                <x-inputs.select2 wire:model="workplace_a_5_value"
                                                    id="workplace_a_5_value" class="form-select"
                                                    placeholder="Pemenuhan">
                                                    <option value="Ya">Ya</option>
                                                    <option value="Tidak">Tidak</option>
                                                    <option value="N/A">N/A</option>
                                                </x-inputs.select2>
                                                <div x-cloak
                                                    x-show="workplace_a_5_value === 'Tidak' || workplace_a_5_value === '5' ">
                                                    <div>
                                                        <x-kplh-texteditor wire:model="workplace_a_5_note"
                                                            id="workplace_a_5_note" placeholder="Keterangan"
                                                            :error="'workplace_a_5_note'" />
                                                    </div>
                                                    <div class="mt-3">
                                                        <x-kplh-file wire:model="workplace_a_5_file"
                                                            id="workplace_a_5_file" placeholder="Upload foto temuan"
                                                            :error="'workplace_a_5_file'" />
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div><!-- /.form-group workplace_a_5 -->

                                    <div class="row form-group mb-4">
                                        <label for="workplace_a_6_label"
                                            class="col-lg-4 col-md-12 col-form-label">Apakah selama bekerja, karyawan
                                            selalu memperhatikan tangannya saat bekerja atau memperhatikan tempat saat
                                            menginjakkan kakinya?
                                        </label>
                                        <div class="col-lg-8 col-md-12">
                                            <div class="wrapper_workplace_a_6 d-flex flex-column gap-3"
                                                x-data="{ workplace_a_6_value: @entangle('workplace_a_6_value') }">
                                                <x-inputs.select2 wire:model="workplace_a_6_value"
                                                    id="workplace_a_6_value" class="form-select"
                                                    placeholder="Pemenuhan">
                                                    <option value="Ya">Ya</option>
                                                    <option value="Tidak">Tidak</option>
                                                    <option value="N/A">N/A</option>
                                                </x-inputs.select2>
                                                <div x-cloak
                                                    x-show="workplace_a_6_value === 'Tidak' || workplace_a_6_value === '5' ">
                                                    <div>
                                                        <x-kplh-texteditor wire:model="workplace_a_6_note"
                                                            id="workplace_a_6_note" placeholder="Keterangan"
                                                            :error="'workplace_a_6_note'" />
                                                    </div>
                                                    <div class="mt-3">
                                                        <x-kplh-file wire:model="workplace_a_6_file"
                                                            id="workplace_a_6_file" placeholder="Upload foto temuan"
                                                            :error="'workplace_a_6_file'" />
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div><!-- /.form-group workplace_a_6 -->

                                    <div class="row form-group mb-4">
                                        <label for="workplace_a_7_label"
                                            class="col-lg-4 col-md-12 col-form-label">Apakah penempatan material,
                                            perkakas kerja dan sampah itu dikumpulkan pada satu tempat yang terpisah?
                                            Tidak menghambat jalan? Tidak mempersempit lokasi kerja?
                                        </label>
                                        <div class="col-lg-8 col-md-12">
                                            <div class="wrapper_workplace_a_7 d-flex flex-column gap-3"
                                                x-data="{ workplace_a_7_value: @entangle('workplace_a_7_value') }">
                                                <x-inputs.select2 wire:model="workplace_a_7_value"
                                                    id="workplace_a_7_value" class="form-select"
                                                    placeholder="Pemenuhan">
                                                    <option value="Ya">Ya</option>
                                                    <option value="Tidak">Tidak</option>
                                                    <option value="N/A">N/A</option>
                                                </x-inputs.select2>
                                                <div x-cloak
                                                    x-show="workplace_a_7_value === 'Tidak' || workplace_a_7_value === '5' ">
                                                    <div>
                                                        <x-kplh-texteditor wire:model="workplace_a_7_note"
                                                            id="workplace_a_7_note" placeholder="Keterangan"
                                                            :error="'workplace_a_7_note'" />
                                                    </div>
                                                    <div class="mt-3">
                                                        <x-kplh-file wire:model="workplace_a_7_file"
                                                            id="workplace_a_7_file" placeholder="Upload foto temuan"
                                                            :error="'workplace_a_7_file'" />
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div><!-- /.form-group workplace_a_7 -->

                                    <div class="row form-group mb-4">
                                        <label for="workplace_a_8_label"
                                            class="col-lg-4 col-md-12 col-form-label">Apakah karyawan telah menggunakan
                                            peralatan/perkakas kerja dengan cara yang aman dan benar?
                                        </label>
                                        <div class="col-lg-8 col-md-12">
                                            <div class="wrapper_workplace_a_8 d-flex flex-column gap-3"
                                                x-data="{ workplace_a_8_value: @entangle('workplace_a_8_value') }">
                                                <x-inputs.select2 wire:model="workplace_a_8_value"
                                                    id="workplace_a_8_value" class="form-select"
                                                    placeholder="Pemenuhan">
                                                    <option value="Ya">Ya</option>
                                                    <option value="Tidak">Tidak</option>
                                                    <option value="N/A">N/A</option>
                                                </x-inputs.select2>
                                                <div x-cloak
                                                    x-show="workplace_a_8_value === 'Tidak' || workplace_a_8_value === '5' ">
                                                    <div>
                                                        <x-kplh-texteditor wire:model="workplace_a_8_note"
                                                            id="workplace_a_8_note" placeholder="Keterangan"
                                                            :error="'workplace_a_8_note'" />
                                                    </div>
                                                    <div class="mt-3">
                                                        <x-kplh-file wire:model="workplace_a_8_file"
                                                            id="workplace_a_8_file" placeholder="Upload foto temuan"
                                                            :error="'workplace_a_8_file'" />
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div><!-- /.form-group workplace_a_8 -->

                                    <div class="row form-group mb-4">
                                        <label for="workplace_a_9_label"
                                            class="col-lg-4 col-md-12 col-form-label">Apakah peralatan/perkakas kerja
                                            yang digunakan itu dalam kondisi baik? Tidak menggunakan peralatan kerja
                                            yang rusak? Pegangan dari peralatan kerja itu bersih? Bebas dari oli atau
                                            sejenisnya?
                                        </label>
                                        <div class="col-lg-8 col-md-12">
                                            <div class="wrapper_workplace_a_9 d-flex flex-column gap-3"
                                                x-data="{ workplace_a_9_value: @entangle('workplace_a_9_value') }">
                                                <x-inputs.select2 wire:model="workplace_a_9_value"
                                                    id="workplace_a_9_value" class="form-select"
                                                    placeholder="Pemenuhan">
                                                    <option value="Ya">Ya</option>
                                                    <option value="Tidak">Tidak</option>
                                                    <option value="N/A">N/A</option>
                                                </x-inputs.select2>
                                                <div x-cloak
                                                    x-show="workplace_a_9_value === 'Tidak' || workplace_a_9_value === '5' ">
                                                    <div>
                                                        <x-kplh-texteditor wire:model="workplace_a_9_note"
                                                            id="workplace_a_9_note" placeholder="Keterangan"
                                                            :error="'workplace_a_9_note'" />
                                                    </div>
                                                    <div class="mt-3">
                                                        <x-kplh-file wire:model="workplace_a_9_file"
                                                            id="workplace_a_9_file" placeholder="Upload foto temuan"
                                                            :error="'workplace_a_9_file'" />
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div><!-- /.form-group workplace_a_9 -->

                                    <div class="row form-group mb-4">
                                        <label for="workplace_a_10_label"
                                            class="col-lg-4 col-md-12 col-form-label">Apakah kerapihan dan kebersihan
                                            tempat kerja itu baik? Tidak menghambat jalan? Perkakas kerja tersimpan atau
                                            ditempatkan dengan rapi?
                                        </label>
                                        <div class="col-lg-8 col-md-12">
                                            <div class="wrapper_workplace_a_10 d-flex flex-column gap-3"
                                                x-data="{ workplace_a_10_value: @entangle('workplace_a_10_value') }">
                                                <x-inputs.select2 wire:model="workplace_a_10_value"
                                                    id="workplace_a_10_value" class="form-select"
                                                    placeholder="Pemenuhan">
                                                    <option value="Ya">Ya</option>
                                                    <option value="Tidak">Tidak</option>
                                                    <option value="N/A">N/A</option>
                                                </x-inputs.select2>
                                                <div x-cloak
                                                    x-show="workplace_a_10_value === 'Tidak' || workplace_a_10_value === '5' ">
                                                    <div>
                                                        <x-kplh-texteditor wire:model="workplace_a_10_note"
                                                            id="workplace_a_10_note" placeholder="Keterangan"
                                                            :error="'workplace_a_10_note'" />
                                                    </div>
                                                    <div class="mt-3">
                                                        <x-kplh-file wire:model="workplace_a_10_file"
                                                            id="workplace_a_10_file" placeholder="Upload foto temuan"
                                                            :error="'workplace_a_10_file'" />
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div><!-- /.form-group workplace_a_10 -->

                                    <div class="row form-group mb-4">
                                        <label for="workplace_a_11_label"
                                            class="col-lg-4 col-md-12 col-form-label">Apakah sisa material yang dipakai
                                            itu telah disimpan dengan benar, aman dan tidak mengganggu?
                                        </label>
                                        <div class="col-lg-8 col-md-12">
                                            <div class="wrapper_workplace_a_11 d-flex flex-column gap-3"
                                                x-data="{ workplace_a_11_value: @entangle('workplace_a_11_value') }">
                                                <x-inputs.select2 wire:model="workplace_a_11_value"
                                                    id="workplace_a_11_value" class="form-select"
                                                    placeholder="Pemenuhan">
                                                    <option value="Ya">Ya</option>
                                                    <option value="Tidak">Tidak</option>
                                                    <option value="N/A">N/A</option>
                                                </x-inputs.select2>
                                                <div x-cloak
                                                    x-show="workplace_a_11_value === 'Tidak' || workplace_a_11_value === '5' ">
                                                    <div>
                                                        <x-kplh-texteditor wire:model="workplace_a_11_note"
                                                            id="workplace_a_11_note" placeholder="Keterangan"
                                                            :error="'workplace_a_11_note'" />
                                                    </div>
                                                    <div class="mt-3">
                                                        <x-kplh-file wire:model="workplace_a_11_file"
                                                            id="workplace_a_11_file" placeholder="Upload foto temuan"
                                                            :error="'workplace_a_11_file'" />
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div><!-- /.form-group workplace_a_11 -->

                                    <div class="row form-group mb-4">
                                        <label for="workplace_a_12_label"
                                            class="col-lg-4 col-md-12 col-form-label">Apakah karyawan tidak
                                            mengindahkan rambu-rambu keselamatan kerja dan pita barikade?
                                        </label>
                                        <div class="col-lg-8 col-md-12">
                                            <div class="wrapper_workplace_a_12 d-flex flex-column gap-3"
                                                x-data="{ workplace_a_12_value: @entangle('workplace_a_12_value') }">
                                                <x-inputs.select2 wire:model="workplace_a_12_value"
                                                    id="workplace_a_12_value" class="form-select"
                                                    placeholder="Pemenuhan">
                                                    <option value="Ya">Ya</option>
                                                    <option value="Tidak">Tidak</option>
                                                    <option value="N/A">N/A</option>
                                                </x-inputs.select2>
                                                <div x-cloak
                                                    x-show="workplace_a_12_value === 'Tidak' || workplace_a_12_value === '5' ">
                                                    <div>
                                                        <x-kplh-texteditor wire:model="workplace_a_12_note"
                                                            id="workplace_a_12_note" placeholder="Keterangan"
                                                            :error="'workplace_a_12_note'" />
                                                    </div>
                                                    <div class="mt-3">
                                                        <x-kplh-file wire:model="workplace_a_12_file"
                                                            id="workplace_a_12_file" placeholder="Upload foto temuan"
                                                            :error="'workplace_a_12_file'" />
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div><!-- /.form-group workplace_a_12 -->

                                    <div class="row form-group mb-4">
                                        <label for="workplace_a_13_label"
                                            class="col-lg-4 col-md-12 col-form-label">Apakah karyawan tidak
                                            mengindahkan rambu-rambu keselamatan kerja dan pita barikade?
                                        </label>
                                        <div class="col-lg-8 col-md-12">
                                            <div class="wrapper_workplace_a_13 d-flex flex-column gap-3"
                                                x-data="{ workplace_a_13_value: @entangle('workplace_a_13_value') }">
                                                <x-inputs.select2 wire:model="workplace_a_13_value"
                                                    id="workplace_a_13_value" class="form-select"
                                                    placeholder="Pemenuhan">
                                                    <option value="Ya">Ya</option>
                                                    <option value="Tidak">Tidak</option>
                                                    <option value="N/A">N/A</option>
                                                </x-inputs.select2>
                                                <div x-cloak
                                                    x-show="workplace_a_13_value === 'Tidak' || workplace_a_13_value === '5' ">
                                                    <div>
                                                        <x-kplh-texteditor wire:model="workplace_a_13_note"
                                                            id="workplace_a_13_note" placeholder="Keterangan"
                                                            :error="'workplace_a_13_note'" />
                                                    </div>
                                                    <div class="mt-3">
                                                        <x-kplh-file wire:model="workplace_a_13_file"
                                                            id="workplace_a_13_file" placeholder="Upload foto temuan"
                                                            :error="'workplace_a_13_file'" />
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div><!-- /.form-group workplace_a_13 -->

                                </div><!-- ./content-workplace_a -->

                            </div>
                        </div><!-- /.workplace_a -->

                        <div id="workplace_b" class="section-workplace_b" x-data="{ accordionOpen: false }">
                            <button
                                class="header-accordion d-flex justify-content-between w-100 border-0 bg-white py-3 px-0"
                                @click.prevent="accordionOpen = ! accordionOpen">
                                <h6 class="mb-0 fw-normal title-accordion">B. KONDISI TEMPAT KERJA (WORKPLACE
                                    AMENITIES)</h6>
                                <span x-bind:class="accordionOpen ? 'open' : ''"><img
                                        src="{{ asset('/images/icons/angle-down.png') }}" alt="" /></span>
                            </button>
                            <div class="wrapper-content-accordion max-h-0 overflow-hidden position-relative transition-all duration-700"
                                x-ref="workplace_b" x-bind:style="accordionOpen ? 'max-height: ' + 20000 + 'px' : ''"
                                x-transition.delay.5000ms>

                                <div class="content-section p-4" wire:ignore.self>

                                    <div class="row form-group mb-4">
                                        <label for="workplace_b_1_label"
                                            class="col-lg-4 col-md-12 col-form-label">Apakah jalan masuk dan keluar
                                            tempat kerja anda cukup aman dan memadai?
                                        </label>
                                        <div class="col-lg-8 col-md-12">
                                            <div class="wrapper_workplace_b_1 d-flex flex-column gap-3"
                                                x-data="{ workplace_b_1_value: @entangle('workplace_b_1_value') }">
                                                <x-inputs.select2 wire:model="workplace_b_1_value"
                                                    id="workplace_b_1_value" class="form-select"
                                                    placeholder="Pemenuhan">
                                                    <option value="Ya">Ya</option>
                                                    <option value="Tidak">Tidak</option>
                                                    <option value="N/A">N/A</option>
                                                </x-inputs.select2>

                                                <div x-cloak
                                                    x-show="workplace_b_1_value === 'Tidak' || workplace_b_1_value === '5' ">
                                                    <div>
                                                        <x-kplh-texteditor wire:model="workplace_b_1_note"
                                                            id="workplace_b_1_note" placeholder="Keterangan"
                                                            :error="'workplace_b_1_note'" />
                                                    </div>
                                                    <div class="mt-3">
                                                        <x-kplh-file wire:model="workplace_b_1_file"
                                                            id="workplace_b_1_file" placeholder="Upload foto temuan"
                                                            :error="'workplace_b_1_file'" />
                                                    </div>
                                                </div>

                                            </div>
                                        </div>
                                    </div><!-- /.form-group workplace_b_1 -->

                                    <div class="row form-group mb-4">
                                        <label for="workplace_b_2_label"
                                            class="col-lg-4 col-md-12 col-form-label">Apakah pencahayaan dan ventilasi
                                            tempat kerja anda cukup memadai?
                                        </label>
                                        <div class="col-lg-8 col-md-12">
                                            <div class="wrapper_workplace_b_2 d-flex flex-column gap-3"
                                                x-data="{ workplace_b_2_value: @entangle('workplace_b_2_value') }">
                                                <x-inputs.select2 wire:model="workplace_b_2_value"
                                                    id="workplace_b_2_value" class="form-select"
                                                    placeholder="Pemenuhan">
                                                    <option value="Ya">Ya</option>
                                                    <option value="Tidak">Tidak</option>
                                                    <option value="N/A">N/A</option>
                                                </x-inputs.select2>
                                                <div x-cloak
                                                    x-show="workplace_b_2_value === 'Tidak' || workplace_b_2_value === '5' ">
                                                    <div>
                                                        <x-kplh-texteditor wire:model="workplace_b_2_note"
                                                            id="workplace_b_2_note" placeholder="Keterangan"
                                                            :error="'workplace_b_2_note'" />
                                                    </div>
                                                    <div class="mt-3">
                                                        <x-kplh-file wire:model="workplace_b_2_file"
                                                            id="workplace_b_2_file" placeholder="Upload foto temuan"
                                                            :error="'workplace_b_2_file'" />
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div><!-- /.form-group workplace_b_2 -->

                                    <div class="row form-group mb-4">
                                        <label for="workplace_b_3_label"
                                            class="col-lg-4 col-md-12 col-form-label">Apakah tempat kerja telah
                                            dilengkapi dengan demarkasi area kerja?
                                        </label>
                                        <div class="col-lg-8 col-md-12">
                                            <div class="wrapper_workplace_b_3 d-flex flex-column gap-3"
                                                x-data="{ workplace_b_3_value: @entangle('workplace_b_3_value') }">
                                                <x-inputs.select2 wire:model="workplace_b_3_value"
                                                    id="workplace_b_3_value" class="form-select"
                                                    placeholder="Pemenuhan">
                                                    <option value="Ya">Ya</option>
                                                    <option value="Tidak">Tidak</option>
                                                    <option value="N/A">N/A</option>
                                                </x-inputs.select2>
                                                <div x-cloak
                                                    x-show="workplace_b_3_value === 'Tidak' || workplace_b_3_value === '5' ">
                                                    <div>
                                                        <x-kplh-texteditor wire:model="workplace_b_3_note"
                                                            id="workplace_b_3_note" placeholder="Keterangan"
                                                            :error="'workplace_b_3_note'" />
                                                    </div>
                                                    <div class="mt-3">
                                                        <x-kplh-file wire:model="workplace_b_3_file"
                                                            id="workplace_b_3_file" placeholder="Upload foto temuan"
                                                            :error="'workplace_b_3_file'" />
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div><!-- /.form-group workplace_b_3 -->

                                    <div class="row form-group mb-4">
                                        <label for="workplace_b_4_label"
                                            class="col-lg-4 col-md-12 col-form-label">Apakah demarkasi area kerja telah
                                            memenuhi persyaratan?
                                        </label>
                                        <div class="col-lg-8 col-md-12">
                                            <div class="wrapper_workplace_b_4 d-flex flex-column gap-3"
                                                x-data="{ workplace_b_4_value: @entangle('workplace_b_4_value') }">
                                                <x-inputs.select2 wire:model="workplace_b_4_value"
                                                    id="workplace_b_4_value" class="form-select"
                                                    placeholder="Pemenuhan">
                                                    <option value="Ya">Ya</option>
                                                    <option value="Tidak">Tidak</option>
                                                    <option value="N/A">N/A</option>
                                                </x-inputs.select2>
                                                <div x-cloak
                                                    x-show="workplace_b_4_value === 'Tidak' || workplace_b_4_value === '5' ">
                                                    <div>
                                                        <x-kplh-texteditor wire:model="workplace_b_4_note"
                                                            id="workplace_b_4_note" placeholder="Keterangan"
                                                            :error="'workplace_b_4_note'" />
                                                    </div>
                                                    <div class="mt-3">
                                                        <x-kplh-file wire:model="workplace_b_4_file"
                                                            id="workplace_b_4_file" placeholder="Upload foto temuan"
                                                            :error="'workplace_b_4_file'" />
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div><!-- /.form-group workplace_b_4 -->

                                    <div class="row form-group mb-4">
                                        <label for="workplace_b_5_label"
                                            class="col-lg-4 col-md-12 col-form-label">Apakah terdapat toilet? Dalam
                                            kondisi bersih dan tidak licin?
                                        </label>
                                        <div class="col-lg-8 col-md-12">
                                            <div class="wrapper_workplace_b_5 d-flex flex-column gap-3"
                                                x-data="{ workplace_b_5_value: @entangle('workplace_b_5_value') }">
                                                <x-inputs.select2 wire:model="workplace_b_5_value"
                                                    id="workplace_b_5_value" class="form-select"
                                                    placeholder="Pemenuhan">
                                                    <option value="Ya">Ya</option>
                                                    <option value="Tidak">Tidak</option>
                                                    <option value="N/A">N/A</option>
                                                </x-inputs.select2>
                                                <div x-cloak
                                                    x-show="workplace_b_5_value === 'Tidak' || workplace_b_5_value === '5' ">
                                                    <div>
                                                        <x-kplh-texteditor wire:model="workplace_b_5_note"
                                                            id="workplace_b_5_note" placeholder="Keterangan"
                                                            :error="'workplace_b_5_note'" />
                                                    </div>
                                                    <div class="mt-3">
                                                        <x-kplh-file wire:model="workplace_b_5_file"
                                                            id="workplace_b_5_file" placeholder="Upload foto temuan"
                                                            :error="'workplace_b_5_file'" />
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div><!-- /.form-group workplace_b_5 -->

                                    <div class="row form-group mb-4">
                                        <label for="workplace_b_6_label"
                                            class="col-lg-4 col-md-12 col-form-label">Perbedaan tinggi rendah pada
                                            lantai kerja diberikan pagar atau sticker kuning-hitam ?
                                        </label>
                                        <div class="col-lg-8 col-md-12">
                                            <div class="wrapper_workplace_b_6 d-flex flex-column gap-3"
                                                x-data="{ workplace_b_6_value: @entangle('workplace_b_6_value') }">
                                                <x-inputs.select2 wire:model="workplace_b_6_value"
                                                    id="workplace_b_6_value" class="form-select"
                                                    placeholder="Pemenuhan">
                                                    <option value="Ya">Ya</option>
                                                    <option value="Tidak">Tidak</option>
                                                    <option value="N/A">N/A</option>
                                                </x-inputs.select2>
                                                <div x-cloak
                                                    x-show="workplace_b_6_value === 'Tidak' || workplace_b_6_value === '5' ">
                                                    <div>
                                                        <x-kplh-texteditor wire:model="workplace_b_6_note"
                                                            id="workplace_b_6_note" placeholder="Keterangan"
                                                            :error="'workplace_b_6_note'" />
                                                    </div>
                                                    <div class="mt-3">
                                                        <x-kplh-file wire:model="workplace_b_6_file"
                                                            id="workplace_b_6_file" placeholder="Upload foto temuan"
                                                            :error="'workplace_b_6_file'" />
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div><!-- /.form-group workplace_b_6 -->

                                    <div class="row form-group mb-4">
                                        <label for="workplace_b_7_label"
                                            class="col-lg-4 col-md-12 col-form-label">Apakah kondisi kebersihan tempat
                                            kerja telah memadai?
                                        </label>
                                        <div class="col-lg-8 col-md-12">
                                            <div class="wrapper_workplace_b_7 d-flex flex-column gap-3"
                                                x-data="{ workplace_b_7_value: @entangle('workplace_b_7_value') }">
                                                <x-inputs.select2 wire:model="workplace_b_7_value"
                                                    id="workplace_b_7_value" class="form-select"
                                                    placeholder="Pemenuhan">
                                                    <option value="Ya">Ya</option>
                                                    <option value="Tidak">Tidak</option>
                                                    <option value="N/A">N/A</option>
                                                </x-inputs.select2>
                                                <div x-cloak
                                                    x-show="workplace_b_7_value === 'Tidak' || workplace_b_7_value === '5' ">
                                                    <div>
                                                        <x-kplh-texteditor wire:model="workplace_b_7_note"
                                                            id="workplace_b_7_note" placeholder="Keterangan"
                                                            :error="'workplace_b_7_note'" />
                                                    </div>
                                                    <div class="mt-3">
                                                        <x-kplh-file wire:model="workplace_b_7_file"
                                                            id="workplace_b_7_file" placeholder="Upload foto temuan"
                                                            :error="'workplace_b_7_file'" />
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div><!-- /.form-group workplace_b_7 -->

                                </div><!-- ./content-workplace_b -->

                            </div>
                        </div><!-- /.workplace_b -->

                        <div id="workplace_c" class="section-workplace_c" x-data="{ accordionOpen: false }">
                            <button
                                class="header-accordion d-flex justify-content-between w-100 border-0 bg-white py-3 px-0"
                                @click.prevent="accordionOpen = ! accordionOpen">
                                <h6 class="mb-0 fw-normal title-accordion">C. TABUNG GAS BERTEKANAN </h6>
                                <span x-bind:class="accordionOpen ? 'open' : ''"><img
                                        src="{{ asset('/images/icons/angle-down.png') }}" alt="" /></span>
                            </button>
                            <div class="wrapper-content-accordion max-h-0 overflow-hidden position-relative transition-all duration-700"
                                x-ref="workplace_c" x-bind:style="accordionOpen ? 'max-height: ' + 20000 + 'px' : ''"
                                x-transition.delay.5000ms>

                                <div class="content-section p-4" wire:ignore.self>

                                    <div class="row form-group mb-4">
                                        <label for="workplace_c_1_label"
                                            class="col-lg-4 col-md-12 col-form-label">Apakah terdapat tabung gas
                                            bertekanan diposisikan berdiri dan terikat ?
                                        </label>
                                        <div class="col-lg-8 col-md-12">
                                            <div class="wrapper_workplace_c_1 d-flex flex-column gap-3"
                                                x-data="{ workplace_c_1_value: @entangle('workplace_c_1_value') }">
                                                <x-inputs.select2 wire:model="workplace_c_1_value"
                                                    id="workplace_c_1_value" class="form-select"
                                                    placeholder="Pemenuhan">
                                                    <option value="Ya">Ya</option>
                                                    <option value="Tidak">Tidak</option>
                                                    <option value="N/A">N/A</option>
                                                </x-inputs.select2>

                                                <div x-cloak
                                                    x-show="workplace_c_1_value === 'Tidak' || workplace_c_1_value === '5' ">
                                                    <div>
                                                        <x-kplh-texteditor wire:model="workplace_c_1_note"
                                                            id="workplace_c_1_note" placeholder="Keterangan"
                                                            :error="'workplace_c_1_note'" />
                                                    </div>
                                                    <div class="mt-3">
                                                        <x-kplh-file wire:model="workplace_c_1_file"
                                                            id="workplace_c_1_file" placeholder="Upload foto temuan"
                                                            :error="'workplace_c_1_file'" />
                                                    </div>
                                                </div>

                                            </div>
                                        </div>
                                    </div><!-- /.form-group workplace_c_1 -->

                                    <div class="row form-group mb-4">
                                        <label for="workplace_c_2_label"
                                            class="col-lg-4 col-md-12 col-form-label">Tabung gas bertekanan disimpan
                                            dengan jarak yang aman? Oxygen dan acetylene ditempatkan minimal pada jarak
                                            3 meter
                                        </label>
                                        <div class="col-lg-8 col-md-12">
                                            <div class="wrapper_workplace_c_2 d-flex flex-column gap-3"
                                                x-data="{ workplace_c_2_value: @entangle('workplace_c_2_value') }">
                                                <x-inputs.select2 wire:model="workplace_c_2_value"
                                                    id="workplace_c_2_value" class="form-select"
                                                    placeholder="Pemenuhan">
                                                    <option value="Ya">Ya</option>
                                                    <option value="Tidak">Tidak</option>
                                                    <option value="N/A">N/A</option>
                                                </x-inputs.select2>
                                                <div x-cloak
                                                    x-show="workplace_c_2_value === 'Tidak' || workplace_c_2_value === '5' ">
                                                    <div>
                                                        <x-kplh-texteditor wire:model="workplace_c_2_note"
                                                            id="workplace_c_2_note" placeholder="Keterangan"
                                                            :error="'workplace_c_2_note'" />
                                                    </div>
                                                    <div class="mt-3">
                                                        <x-kplh-file wire:model="workplace_c_2_file"
                                                            id="workplace_c_2_file" placeholder="Upload foto temuan"
                                                            :error="'workplace_c_2_file'" />
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div><!-- /.form-group workplace_c_2 -->

                                    <div class="row form-group mb-4">
                                        <label for="workplace_c_3_label"
                                            class="col-lg-4 col-md-12 col-form-label">Kondisi tabung gas bertekanan
                                            tidak korosif?
                                        </label>
                                        <div class="col-lg-8 col-md-12">
                                            <div class="wrapper_workplace_c_3 d-flex flex-column gap-3"
                                                x-data="{ workplace_c_3_value: @entangle('workplace_c_3_value') }">
                                                <x-inputs.select2 wire:model="workplace_c_3_value"
                                                    id="workplace_c_3_value" class="form-select"
                                                    placeholder="Pemenuhan">
                                                    <option value="Ya">Ya</option>
                                                    <option value="Tidak">Tidak</option>
                                                    <option value="N/A">N/A</option>
                                                </x-inputs.select2>
                                                <div x-cloak
                                                    x-show="workplace_c_3_value === 'Tidak' || workplace_c_3_value === '5' ">
                                                    <div>
                                                        <x-kplh-texteditor wire:model="workplace_c_3_note"
                                                            id="workplace_c_3_note" placeholder="Keterangan"
                                                            :error="'workplace_c_3_note'" />
                                                    </div>
                                                    <div class="mt-3">
                                                        <x-kplh-file wire:model="workplace_c_3_file"
                                                            id="workplace_c_3_file" placeholder="Upload foto temuan"
                                                            :error="'workplace_c_3_file'" />
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div><!-- /.form-group workplace_c_3 -->

                                </div><!-- ./content-workplace_c -->

                            </div>
                        </div><!-- /.workplace_c -->

                        <div id="workplace_d" class="section-workplace_d" x-data="{ accordionOpen: false }">
                            <button
                                class="header-accordion d-flex justify-content-between w-100 border-0 bg-white py-3 px-0"
                                @click.prevent="accordionOpen = ! accordionOpen">
                                <h6 class="mb-0 fw-normal title-accordion">D. BEKERJA DI ATAS KETINGGIAN (WORKING AT
                                    HEIGHT)</h6>
                                <span x-bind:class="accordionOpen ? 'open' : ''"><img
                                        src="{{ asset('/images/icons/angle-down.png') }}" alt="" /></span>
                            </button>
                            <div class="wrapper-content-accordion max-h-0 overflow-hidden position-relative transition-all duration-700"
                                x-ref="workplace_d" x-bind:style="accordionOpen ? 'max-height: ' + 20000 + 'px' : ''"
                                x-transition.delay.5000ms>

                                <div class="content-section p-4" wire:ignore.self>

                                    <div class="row form-group mb-4">
                                        <label for="workplace_d_1_label" class="col-lg-4 col-md-12 col-form-label">
                                            Apakah “Fullbody Harness” dan tali pengamannya telah diperiksa dan
                                            diregistrasi setiap bulannya oleh karyawan yang berkompeten?
                                        </label>
                                        <div class="col-lg-8 col-md-12">
                                            <div class="wrapper_workplace_d_1 d-flex flex-column gap-3"
                                                x-data="{ workplace_d_1_value: @entangle('workplace_d_1_value') }">
                                                <x-inputs.select2 wire:model="workplace_d_1_value"
                                                    id="workplace_d_1_value" class="form-select"
                                                    placeholder="Pemenuhan">
                                                    <option value="Ya">Ya</option>
                                                    <option value="Tidak">Tidak</option>
                                                    <option value="N/A">N/A</option>
                                                </x-inputs.select2>

                                                <div x-cloak
                                                    x-show="workplace_d_1_value === 'Tidak' || workplace_d_1_value === '5' ">
                                                    <div>
                                                        <x-kplh-texteditor wire:model="workplace_d_1_note"
                                                            id="workplace_d_1_note" placeholder="Keterangan"
                                                            :error="'workplace_d_1_note'" />
                                                    </div>
                                                    <div class="mt-3">
                                                        <x-kplh-file wire:model="workplace_d_1_file"
                                                            id="workplace_d_1_file" placeholder="Upload foto temuan"
                                                            :error="'workplace_d_1_file'" />
                                                    </div>
                                                </div>

                                            </div>
                                        </div>
                                    </div><!-- /.form-group workplace_d_1 -->

                                    <div class="row form-group mb-4">
                                        <label for="workplace_d_2_label"
                                            class="col-lg-4 col-md-12 col-form-label">Apakah sudah dilakukan
                                            pemeriksaan terhadap ”Fullbody Harness” dan tali pengamannya sebelum
                                            digunakan?
                                        </label>
                                        <div class="col-lg-8 col-md-12">
                                            <div class="wrapper_workplace_d_2 d-flex flex-column gap-3"
                                                x-data="{ workplace_d_2_value: @entangle('workplace_d_2_value') }">
                                                <x-inputs.select2 wire:model="workplace_d_2_value"
                                                    id="workplace_d_2_value" class="form-select"
                                                    placeholder="Pemenuhan">
                                                    <option value="Ya">Ya</option>
                                                    <option value="Tidak">Tidak</option>
                                                    <option value="N/A">N/A</option>
                                                </x-inputs.select2>
                                                <div x-cloak
                                                    x-show="workplace_d_2_value === 'Tidak' || workplace_d_2_value === '5' ">
                                                    <div>
                                                        <x-kplh-texteditor wire:model="workplace_d_2_note"
                                                            id="workplace_d_2_note" placeholder="Keterangan"
                                                            :error="'workplace_d_2_note'" />
                                                    </div>
                                                    <div class="mt-3">
                                                        <x-kplh-file wire:model="workplace_d_2_file"
                                                            id="workplace_d_2_file" placeholder="Upload foto temuan"
                                                            :error="'workplace_d_2_file'" />
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div><!-- /.form-group workplace_d_2 -->

                                    <div class="row form-group mb-4">
                                        <label for="workplace_d_3_label"
                                            class="col-lg-4 col-md-12 col-form-label">Apakah “Fullbody Harness”
                                            dilengkapi dengan double lanyard?
                                        </label>
                                        <div class="col-lg-8 col-md-12">
                                            <div class="wrapper_workplace_d_3 d-flex flex-column gap-3"
                                                x-data="{ workplace_d_3_value: @entangle('workplace_d_3_value') }">
                                                <x-inputs.select2 wire:model="workplace_d_3_value"
                                                    id="workplace_d_3_value" class="form-select"
                                                    placeholder="Pemenuhan">
                                                    <option value="Ya">Ya</option>
                                                    <option value="Tidak">Tidak</option>
                                                    <option value="N/A">N/A</option>
                                                </x-inputs.select2>
                                                <div x-cloak
                                                    x-show="workplace_d_3_value === 'Tidak' || workplace_d_3_value === '5' ">
                                                    <div>
                                                        <x-kplh-texteditor wire:model="workplace_d_3_note"
                                                            id="workplace_d_3_note" placeholder="Keterangan"
                                                            :error="'workplace_d_3_note'" />
                                                    </div>
                                                    <div class="mt-3">
                                                        <x-kplh-file wire:model="workplace_d_3_file"
                                                            id="workplace_d_3_file" placeholder="Upload foto temuan"
                                                            :error="'workplace_d_3_file'" />
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div><!-- /.form-group workplace_d_3 -->

                                    <div class="row form-group mb-4">
                                        <label for="workplace_d_4_label"
                                            class="col-lg-4 col-md-12 col-form-label">Ijin bekerja diketinggian untuk
                                            kegiatan bekerja di ketinggian 1.8m pada perancah atau 4 meter pada tangga.
                                        </label>
                                        <div class="col-lg-8 col-md-12">
                                            <div class="wrapper_workplace_d_4 d-flex flex-column gap-3"
                                                x-data="{ workplace_d_4_value: @entangle('workplace_d_4_value') }">
                                                <x-inputs.select2 wire:model="workplace_d_4_value"
                                                    id="workplace_d_4_value" class="form-select"
                                                    placeholder="Pemenuhan">
                                                    <option value="Ya">Ya</option>
                                                    <option value="Tidak">Tidak</option>
                                                    <option value="N/A">N/A</option>
                                                </x-inputs.select2>
                                                <div x-cloak
                                                    x-show="workplace_d_4_value === 'Tidak' || workplace_d_4_value === '5' ">
                                                    <div>
                                                        <x-kplh-texteditor wire:model="workplace_d_4_note"
                                                            id="workplace_d_4_note" placeholder="Keterangan"
                                                            :error="'workplace_d_4_note'" />
                                                    </div>
                                                    <div class="mt-3">
                                                        <x-kplh-file wire:model="workplace_d_4_file"
                                                            id="workplace_d_4_file" placeholder="Upload foto temuan"
                                                            :error="'workplace_d_4_file'" />
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div><!-- /.form-group workplace_d_4 -->

                                    <div class="row form-group mb-4">
                                        <label for="workplace_d_5_label"
                                            class="col-lg-4 col-md-12 col-form-label">Pemeriksaan kesehatan dilakukan
                                            sebelum bekerja di ketinggian 15 meter
                                        </label>
                                        <div class="col-lg-8 col-md-12">
                                            <div class="wrapper_workplace_d_5 d-flex flex-column gap-3"
                                                x-data="{ workplace_d_5_value: @entangle('workplace_d_5_value') }">
                                                <x-inputs.select2 wire:model="workplace_d_5_value"
                                                    id="workplace_d_5_value" class="form-select"
                                                    placeholder="Pemenuhan">
                                                    <option value="Ya">Ya</option>
                                                    <option value="Tidak">Tidak</option>
                                                    <option value="N/A">N/A</option>
                                                </x-inputs.select2>
                                                <div x-cloak
                                                    x-show="workplace_d_5_value === 'Tidak' || workplace_d_5_value === '5' ">
                                                    <div>
                                                        <x-kplh-texteditor wire:model="workplace_d_5_note"
                                                            id="workplace_d_5_note" placeholder="Keterangan"
                                                            :error="'workplace_d_5_note'" />
                                                    </div>
                                                    <div class="mt-3">
                                                        <x-kplh-file wire:model="workplace_d_5_file"
                                                            id="workplace_d_5_file" placeholder="Upload foto temuan"
                                                            :error="'workplace_d_5_file'" />
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div><!-- /.form-group workplace_d_5 -->

                                    <div class="row form-group mb-4">
                                        <label for="workplace_d_6_label"
                                            class="col-lg-4 col-md-12 col-form-label">Apakah karyawan sudah pernah
                                            mengikuti pelatihan dalam menggunakannya?
                                        </label>
                                        <div class="col-lg-8 col-md-12">
                                            <div class="wrapper_workplace_d_6 d-flex flex-column gap-3"
                                                x-data="{ workplace_d_6_value: @entangle('workplace_d_6_value') }">
                                                <x-inputs.select2 wire:model="workplace_d_6_value"
                                                    id="workplace_d_6_value" class="form-select"
                                                    placeholder="Pemenuhan">
                                                    <option value="Ya">Ya</option>
                                                    <option value="Tidak">Tidak</option>
                                                    <option value="N/A">N/A</option>
                                                </x-inputs.select2>
                                                <div x-cloak
                                                    x-show="workplace_d_6_value === 'Tidak' || workplace_d_6_value === '5' ">
                                                    <div>
                                                        <x-kplh-texteditor wire:model="workplace_d_6_note"
                                                            id="workplace_d_6_note" placeholder="Keterangan"
                                                            :error="'workplace_d_6_note'" />
                                                    </div>
                                                    <div class="mt-3">
                                                        <x-kplh-file wire:model="workplace_d_6_file"
                                                            id="workplace_d_6_file" placeholder="Upload foto temuan"
                                                            :error="'workplace_d_6_file'" />
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div><!-- /.form-group workplace_d_6 -->

                                    <div class="row form-group mb-4">
                                        <label for="workplace_d_7_label"
                                            class="col-lg-4 col-md-12 col-form-label">Apakah karyawan memiliki akses
                                            naik dan turun yang aman?
                                        </label>
                                        <div class="col-lg-8 col-md-12">
                                            <div class="wrapper_workplace_d_7 d-flex flex-column gap-3"
                                                x-data="{ workplace_d_7_value: @entangle('workplace_d_7_value') }">
                                                <x-inputs.select2 wire:model="workplace_d_7_value"
                                                    id="workplace_d_7_value" class="form-select"
                                                    placeholder="Pemenuhan">
                                                    <option value="Ya">Ya</option>
                                                    <option value="Tidak">Tidak</option>
                                                    <option value="N/A">N/A</option>
                                                </x-inputs.select2>
                                                <div x-cloak
                                                    x-show="workplace_d_7_value === 'Tidak' || workplace_d_7_value === '5' ">
                                                    <div>
                                                        <x-kplh-texteditor wire:model="workplace_d_7_note"
                                                            id="workplace_d_7_note" placeholder="Keterangan"
                                                            :error="'workplace_d_7_note'" />
                                                    </div>
                                                    <div class="mt-3">
                                                        <x-kplh-file wire:model="workplace_d_7_file"
                                                            id="workplace_d_7_file" placeholder="Upload foto temuan"
                                                            :error="'workplace_d_7_file'" />
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div><!-- /.form-group workplace_d_7 -->

                                    <div class="row form-group mb-4">
                                        <label for="workplace_d_8_label"
                                            class="col-lg-4 col-md-12 col-form-label">Apakah area kerja di bawah orang
                                            yang bekerja di ketinggian itu telah dipasang barikade dengan benar??
                                        </label>
                                        <div class="col-lg-8 col-md-12">
                                            <div class="wrapper_workplace_d_8 d-flex flex-column gap-3"
                                                x-data="{ workplace_d_8_value: @entangle('workplace_d_8_value') }">
                                                <x-inputs.select2 wire:model="workplace_d_8_value"
                                                    id="workplace_d_8_value" class="form-select"
                                                    placeholder="Pemenuhan">
                                                    <option value="Ya">Ya</option>
                                                    <option value="Tidak">Tidak</option>
                                                    <option value="N/A">N/A</option>
                                                </x-inputs.select2>
                                                <div x-cloak
                                                    x-show="workplace_d_8_value === 'Tidak' || workplace_d_8_value === '5' ">
                                                    <div>
                                                        <x-kplh-texteditor wire:model="workplace_d_8_note"
                                                            id="workplace_d_8_note" placeholder="Keterangan"
                                                            :error="'workplace_d_8_note'" />
                                                    </div>
                                                    <div class="mt-3">
                                                        <x-kplh-file wire:model="workplace_d_8_file"
                                                            id="workplace_d_8_file" placeholder="Upload foto temuan"
                                                            :error="'workplace_d_8_file'" />
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div><!-- /.form-group workplace_d_8 -->

                                    <div class="row form-group mb-4">
                                        <label for="workplace_d_9_label"
                                            class="col-lg-4 col-md-12 col-form-label">Apakah karyawan menggunakan
                                            static line (digunakan bila tidak ada tempat untuk mengaitkan tali pengaman
                                            di atas kepalanya)? Apakah dalam kondisi baik? Sudah diinspeksi oleh
                                            karyawan yang kompeten? Mempunyai SWL yang memadai?
                                        </label>
                                        <div class="col-lg-8 col-md-12">
                                            <div class="wrapper_workplace_d_9 d-flex flex-column gap-3"
                                                x-data="{ workplace_d_9_value: @entangle('workplace_d_9_value') }">
                                                <x-inputs.select2 wire:model="workplace_d_9_value"
                                                    id="workplace_d_9_value" class="form-select"
                                                    placeholder="Pemenuhan">
                                                    <option value="Ya">Ya</option>
                                                    <option value="Tidak">Tidak</option>
                                                    <option value="N/A">N/A</option>
                                                </x-inputs.select2>
                                                <div x-cloak
                                                    x-show="workplace_d_9_value === 'Tidak' || workplace_d_9_value === '5' ">
                                                    <div>
                                                        <x-kplh-texteditor wire:model="workplace_d_9_note"
                                                            id="workplace_d_9_note" placeholder="Keterangan"
                                                            :error="'workplace_d_9_note'" />
                                                    </div>
                                                    <div class="mt-3">
                                                        <x-kplh-file wire:model="workplace_d_9_file"
                                                            id="workplace_d_9_file" placeholder="Upload foto temuan"
                                                            :error="'workplace_d_9_file'" />
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div><!-- /.form-group workplace_d_9 -->

                                </div><!-- ./content-workplace_d -->

                            </div>
                        </div><!-- /.workplace_d -->

                        <div id="workplace_e" class="section-workplace_e" x-data="{ accordionOpen: false }">
                            <button
                                class="header-accordion d-flex justify-content-between w-100 border-0 bg-white py-3 px-0"
                                @click.prevent="accordionOpen = ! accordionOpen">
                                <h6 class="mb-0 fw-normal title-accordion">E. PERANCAH (SCAFFOLD)</h6>
                                <span x-bind:class="accordionOpen ? 'open' : ''"><img
                                        src="{{ asset('/images/icons/angle-down.png') }}" alt="" /></span>
                            </button>
                            <div class="wrapper-content-accordion max-h-0 overflow-hidden position-relative transition-all duration-700"
                                x-ref="workplace_e" x-bind:style="accordionOpen ? 'max-height: ' + 20000 + 'px' : ''"
                                x-transition.delay.5000ms>

                                <div class="content-section p-4" wire:ignore.self>

                                    <div class="row form-group mb-4">
                                        <label for="workplace_e_1_label"
                                            class="col-lg-4 col-md-12 col-form-label">Apakah pekerjaan
                                            pembuatan/pembongkaran perancah telah memiliki ijin kerja yang diperlukan?
                                        </label>
                                        <div class="col-lg-8 col-md-12">
                                            <div class="wrapper_workplace_e_1 d-flex flex-column gap-3"
                                                x-data="{ workplace_e_1_value: @entangle('workplace_e_1_value') }">
                                                <x-inputs.select2 wire:model="workplace_e_1_value"
                                                    id="workplace_e_1_value" class="form-select"
                                                    placeholder="Pemenuhan">
                                                    <option value="Ya">Ya</option>
                                                    <option value="Tidak">Tidak</option>
                                                    <option value="N/A">N/A</option>
                                                </x-inputs.select2>

                                                <div x-cloak
                                                    x-show="workplace_e_1_value === 'Tidak' || workplace_e_1_value === '5' ">
                                                    <div>
                                                        <x-kplh-texteditor wire:model="workplace_e_1_note"
                                                            id="workplace_e_1_note" placeholder="Keterangan"
                                                            :error="'workplace_e_1_note'" />
                                                    </div>
                                                    <div class="mt-3">
                                                        <x-kplh-file wire:model="workplace_e_1_file"
                                                            id="workplace_e_1_file" placeholder="Upload foto temuan"
                                                            :error="'workplace_e_1_file'" />
                                                    </div>
                                                </div>

                                            </div>
                                        </div>
                                    </div><!-- /.form-group workplace_e_1 -->

                                    <div class="row form-group mb-4">
                                        <label for="workplace_e_2_label"
                                            class="col-lg-4 col-md-12 col-form-label">Apakah perancah dibangun oleh
                                            karyawan sudah mengikuti pelatihan scaffold?
                                        </label>
                                        <div class="col-lg-8 col-md-12">
                                            <div class="wrapper_workplace_e_2 d-flex flex-column gap-3"
                                                x-data="{ workplace_e_2_value: @entangle('workplace_e_2_value') }">
                                                <x-inputs.select2 wire:model="workplace_e_2_value"
                                                    id="workplace_e_2_value" class="form-select"
                                                    placeholder="Pemenuhan">
                                                    <option value="Ya">Ya</option>
                                                    <option value="Tidak">Tidak</option>
                                                    <option value="N/A">N/A</option>
                                                </x-inputs.select2>
                                                <div x-cloak
                                                    x-show="workplace_e_2_value === 'Tidak' || workplace_e_2_value === '5' ">
                                                    <div>
                                                        <x-kplh-texteditor wire:model="workplace_e_2_note"
                                                            id="workplace_e_2_note" placeholder="Keterangan"
                                                            :error="'workplace_e_2_note'" />
                                                    </div>
                                                    <div class="mt-3">
                                                        <x-kplh-file wire:model="workplace_e_2_file"
                                                            id="workplace_e_2_file" placeholder="Upload foto temuan"
                                                            :error="'workplace_e_2_file'" />
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div><!-- /.form-group workplace_e_2 -->

                                    <div class="row form-group mb-4">
                                        <label for="workplace_e_3_label"
                                            class="col-lg-4 col-md-12 col-form-label">Apakah perancah dilengkapi dengan
                                            toe-board atau kick board dengan benar?
                                        </label>
                                        <div class="col-lg-8 col-md-12">
                                            <div class="wrapper_workplace_e_3 d-flex flex-column gap-3"
                                                x-data="{ workplace_e_3_value: @entangle('workplace_e_3_value') }">
                                                <x-inputs.select2 wire:model="workplace_e_3_value"
                                                    id="workplace_e_3_value" class="form-select"
                                                    placeholder="Pemenuhan">
                                                    <option value="Ya">Ya</option>
                                                    <option value="Tidak">Tidak</option>
                                                    <option value="N/A">N/A</option>
                                                </x-inputs.select2>
                                                <div x-cloak
                                                    x-show="workplace_e_3_value === 'Tidak' || workplace_e_3_value === '5' ">
                                                    <div>
                                                        <x-kplh-texteditor wire:model="workplace_e_3_note"
                                                            id="workplace_e_3_note" placeholder="Keterangan"
                                                            :error="'workplace_e_3_note'" />
                                                    </div>
                                                    <div class="mt-3">
                                                        <x-kplh-file wire:model="workplace_e_3_file"
                                                            id="workplace_e_3_file" placeholder="Upload foto temuan"
                                                            :error="'workplace_e_3_file'" />
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div><!-- /.form-group workplace_e_3 -->

                                    <div class="row form-group mb-4">
                                        <label for="workplace_e_4_label"
                                            class="col-lg-4 col-md-12 col-form-label">Apakah perancah dilengkapi dengan
                                            handrail dan midrail dengan benar?
                                        </label>
                                        <div class="col-lg-8 col-md-12">
                                            <div class="wrapper_workplace_e_4 d-flex flex-column gap-3"
                                                x-data="{ workplace_e_4_value: @entangle('workplace_e_4_value') }">
                                                <x-inputs.select2 wire:model="workplace_e_4_value"
                                                    id="workplace_e_4_value" class="form-select"
                                                    placeholder="Pemenuhan">
                                                    <option value="Ya">Ya</option>
                                                    <option value="Tidak">Tidak</option>
                                                    <option value="N/A">N/A</option>
                                                </x-inputs.select2>
                                                <div x-cloak
                                                    x-show="workplace_e_4_value === 'Tidak' || workplace_e_4_value === '5' ">
                                                    <div>
                                                        <x-kplh-texteditor wire:model="workplace_e_4_note"
                                                            id="workplace_e_4_note" placeholder="Keterangan"
                                                            :error="'workplace_e_4_note'" />
                                                    </div>
                                                    <div class="mt-3">
                                                        <x-kplh-file wire:model="workplace_e_4_file"
                                                            id="workplace_e_4_file" placeholder="Upload foto temuan"
                                                            :error="'workplace_e_4_file'" />
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div><!-- /.form-group workplace_e_4 -->

                                    <div class="row form-group mb-4">
                                        <label for="workplace_e_5_label"
                                            class="col-lg-4 col-md-12 col-form-label">Apakah lantai perancah dipasang
                                            dengan aman?
                                        </label>
                                        <div class="col-lg-8 col-md-12">
                                            <div class="wrapper_workplace_e_5 d-flex flex-column gap-3"
                                                x-data="{ workplace_e_5_value: @entangle('workplace_e_5_value') }">
                                                <x-inputs.select2 wire:model="workplace_e_5_value"
                                                    id="workplace_e_5_value" class="form-select"
                                                    placeholder="Pemenuhan">
                                                    <option value="Ya">Ya</option>
                                                    <option value="Tidak">Tidak</option>
                                                    <option value="N/A">N/A</option>
                                                </x-inputs.select2>
                                                <div x-cloak
                                                    x-show="workplace_e_5_value === 'Tidak' || workplace_e_5_value === '5' ">
                                                    <div>
                                                        <x-kplh-texteditor wire:model="workplace_e_5_note"
                                                            id="workplace_e_5_note" placeholder="Keterangan"
                                                            :error="'workplace_e_5_note'" />
                                                    </div>
                                                    <div class="mt-3">
                                                        <x-kplh-file wire:model="workplace_e_5_file"
                                                            id="workplace_e_5_file" placeholder="Upload foto temuan"
                                                            :error="'workplace_e_5_file'" />
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div><!-- /.form-group workplace_e_5 -->

                                    <div class="row form-group mb-4">
                                        <label for="workplace_e_6_label"
                                            class="col-lg-4 col-md-12 col-form-label">Apakah perancah telah dipasangkan
                                            Scaffold Tag dengan benar? Pada jalan masuk atau tangga untuk naik/turun?
                                            Apakah karyawan menggunakan tangga yang telah disediakan saat naik/turun?
                                        </label>
                                        <div class="col-lg-8 col-md-12">
                                            <div class="wrapper_workplace_e_6 d-flex flex-column gap-3"
                                                x-data="{ workplace_e_6_value: @entangle('workplace_e_6_value') }">
                                                <x-inputs.select2 wire:model="workplace_e_6_value"
                                                    id="workplace_e_6_value" class="form-select"
                                                    placeholder="Pemenuhan">
                                                    <option value="Ya">Ya</option>
                                                    <option value="Tidak">Tidak</option>
                                                    <option value="N/A">N/A</option>
                                                </x-inputs.select2>
                                                <div x-cloak
                                                    x-show="workplace_e_6_value === 'Tidak' || workplace_e_6_value === '5' ">
                                                    <div>
                                                        <x-kplh-texteditor wire:model="workplace_e_6_note"
                                                            id="workplace_e_6_note" placeholder="Keterangan"
                                                            :error="'workplace_e_6_note'" />
                                                    </div>
                                                    <div class="mt-3">
                                                        <x-kplh-file wire:model="workplace_e_6_file"
                                                            id="workplace_e_6_file" placeholder="Upload foto temuan"
                                                            :error="'workplace_e_6_file'" />
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div><!-- /.form-group workplace_e_6 -->

                                </div><!-- ./content-workplace_e -->

                            </div>
                        </div><!-- /.workplace_e -->

                        <div id="workplace_f" class="section-workplace_f" x-data="{ accordionOpen: false }">
                            <button
                                class="header-accordion d-flex justify-content-between w-100 border-0 bg-white py-3 px-0"
                                @click.prevent="accordionOpen = ! accordionOpen">
                                <h6 class="mb-0 fw-normal title-accordion">F. TANGGA (LADDER)</h6>
                                <span x-bind:class="accordionOpen ? 'open' : ''"><img
                                        src="{{ asset('/images/icons/angle-down.png') }}" alt="" /></span>
                            </button>
                            <div class="wrapper-content-accordion max-h-0 overflow-hidden position-relative transition-all duration-700"
                                x-ref="workplace_f" x-bind:style="accordionOpen ? 'max-height: ' + 20000 + 'px' : ''"
                                x-transition.delay.5000ms>

                                <div class="content-section p-4" wire:ignore.self>

                                    <div class="row form-group mb-4">
                                        <label for="workplace_f_1_label"
                                            class="col-lg-4 col-md-12 col-form-label">Apakah tangga dipasangkan dengan
                                            sudut kemiringan yang aman (ratio 4:1)? Apakah terdapat bagian tangga yang
                                            dilebihkan sekitar 1 meter pada bagian lantai atas suatu struktur bangunan?
                                        </label>
                                        <div class="col-lg-8 col-md-12">
                                            <div class="wrapper_workplace_f_1 d-flex flex-column gap-3"
                                                x-data="{ workplace_f_1_value: @entangle('workplace_f_1_value') }">
                                                <x-inputs.select2 wire:model="workplace_f_1_value"
                                                    id="workplace_f_1_value" class="form-select"
                                                    placeholder="Pemenuhan">
                                                    <option value="Ya">Ya</option>
                                                    <option value="Tidak">Tidak</option>
                                                    <option value="N/A">N/A</option>
                                                </x-inputs.select2>

                                                <div x-cloak
                                                    x-show="workplace_f_1_value === 'Tidak' || workplace_f_1_value === '5' ">
                                                    <div>
                                                        <x-kplh-texteditor wire:model="workplace_f_1_note"
                                                            id="workplace_f_1_note" placeholder="Keterangan"
                                                            :error="'workplace_f_1_note'" />
                                                    </div>
                                                    <div class="mt-3">
                                                        <x-kplh-file wire:model="workplace_f_1_file"
                                                            id="workplace_f_1_file" placeholder="Upload foto temuan"
                                                            :error="'workplace_f_1_file'" />
                                                    </div>
                                                </div>

                                            </div>
                                        </div>
                                    </div><!-- /.form-group workplace_f_1 -->

                                    <div class="row form-group mb-4">
                                        <label for="workplace_f_2_label"
                                            class="col-lg-4 col-md-12 col-form-label">Apakah tangga diikat pada bagian
                                            atasnya? Atau ada karyawan lain yang memegang di bawahnya, saat tangga
                                            digunakan?
                                        </label>
                                        <div class="col-lg-8 col-md-12">
                                            <div class="wrapper_workplace_f_2 d-flex flex-column gap-3"
                                                x-data="{ workplace_f_2_value: @entangle('workplace_f_2_value') }">
                                                <x-inputs.select2 wire:model="workplace_f_2_value"
                                                    id="workplace_f_2_value" class="form-select"
                                                    placeholder="Pemenuhan">
                                                    <option value="Ya">Ya</option>
                                                    <option value="Tidak">Tidak</option>
                                                    <option value="N/A">N/A</option>
                                                </x-inputs.select2>
                                                <div x-cloak
                                                    x-show="workplace_f_2_value === 'Tidak' || workplace_f_2_value === '5' ">
                                                    <div>
                                                        <x-kplh-texteditor wire:model="workplace_f_2_note"
                                                            id="workplace_f_2_note" placeholder="Keterangan"
                                                            :error="'workplace_f_2_note'" />
                                                    </div>
                                                    <div class="mt-3">
                                                        <x-kplh-file wire:model="workplace_f_2_file"
                                                            id="workplace_f_2_file" placeholder="Upload foto temuan"
                                                            :error="'workplace_f_2_file'" />
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div><!-- /.form-group workplace_f_2 -->

                                    <div class="row form-group mb-4">
                                        <label for="workplace_f_3_label"
                                            class="col-lg-4 col-md-12 col-form-label">Apakah terdapat bagian “anti
                                            slip” pada kaki tangga?
                                        </label>
                                        <div class="col-lg-8 col-md-12">
                                            <div class="wrapper_workplace_f_3 d-flex flex-column gap-3"
                                                x-data="{ workplace_f_3_value: @entangle('workplace_f_3_value') }">
                                                <x-inputs.select2 wire:model="workplace_f_3_value"
                                                    id="workplace_f_3_value" class="form-select"
                                                    placeholder="Pemenuhan">
                                                    <option value="Ya">Ya</option>
                                                    <option value="Tidak">Tidak</option>
                                                    <option value="N/A">N/A</option>
                                                </x-inputs.select2>
                                                <div x-cloak
                                                    x-show="workplace_f_3_value === 'Tidak' || workplace_f_3_value === '5' ">
                                                    <div>
                                                        <x-kplh-texteditor wire:model="workplace_f_3_note"
                                                            id="workplace_f_3_note" placeholder="Keterangan"
                                                            :error="'workplace_f_3_note'" />
                                                    </div>
                                                    <div class="mt-3">
                                                        <x-kplh-file wire:model="workplace_f_3_file"
                                                            id="workplace_f_3_file" placeholder="Upload foto temuan"
                                                            :error="'workplace_f_3_file'" />
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div><!-- /.form-group workplace_f_3 -->

                                    <div class="row form-group mb-4">
                                        <label for="workplace_f_4_label"
                                            class="col-lg-4 col-md-12 col-form-label">Apakah semua bagian tangga tidak
                                            terdapat suatu keretakan atau bengkok?
                                        </label>
                                        <div class="col-lg-8 col-md-12">
                                            <div class="wrapper_workplace_f_4 d-flex flex-column gap-3"
                                                x-data="{ workplace_f_4_value: @entangle('workplace_f_4_value') }">
                                                <x-inputs.select2 wire:model="workplace_f_4_value"
                                                    id="workplace_f_4_value" class="form-select"
                                                    placeholder="Pemenuhan">
                                                    <option value="Ya">Ya</option>
                                                    <option value="Tidak">Tidak</option>
                                                    <option value="N/A">N/A</option>
                                                </x-inputs.select2>
                                                <div x-cloak
                                                    x-show="workplace_f_4_value === 'Tidak' || workplace_f_4_value === '5' ">
                                                    <div>
                                                        <x-kplh-texteditor wire:model="workplace_f_4_note"
                                                            id="workplace_f_4_note" placeholder="Keterangan"
                                                            :error="'workplace_f_4_note'" />
                                                    </div>
                                                    <div class="mt-3">
                                                        <x-kplh-file wire:model="workplace_f_4_file"
                                                            id="workplace_f_4_file" placeholder="Upload foto temuan"
                                                            :error="'workplace_f_4_file'" />
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div><!-- /.form-group workplace_f_4 -->

                                    <div class="row form-group mb-4">
                                        <label for="workplace_f_5_label"
                                            class="col-lg-4 col-md-12 col-form-label">Apakah terdapat nomor registrasi
                                            inspeksi pada tangga?
                                        </label>
                                        <div class="col-lg-8 col-md-12">
                                            <div class="wrapper_workplace_f_5 d-flex flex-column gap-3"
                                                x-data="{ workplace_f_5_value: @entangle('workplace_f_5_value') }">
                                                <x-inputs.select2 wire:model="workplace_f_5_value"
                                                    id="workplace_f_5_value" class="form-select"
                                                    placeholder="Pemenuhan">
                                                    <option value="Ya">Ya</option>
                                                    <option value="Tidak">Tidak</option>
                                                    <option value="N/A">N/A</option>
                                                </x-inputs.select2>
                                                <div x-cloak
                                                    x-show="workplace_f_5_value === 'Tidak' || workplace_f_5_value === '5' ">
                                                    <div>
                                                        <x-kplh-texteditor wire:model="workplace_f_5_note"
                                                            id="workplace_f_5_note" placeholder="Keterangan"
                                                            :error="'workplace_f_5_note'" />
                                                    </div>
                                                    <div class="mt-3">
                                                        <x-kplh-file wire:model="workplace_f_5_file"
                                                            id="workplace_f_5_file" placeholder="Upload foto temuan"
                                                            :error="'workplace_f_5_file'" />
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div><!-- /.form-group workplace_f_5 -->

                                    <div class="row form-group mb-4">
                                        <label for="workplace_f_6_label"
                                            class="col-lg-4 col-md-12 col-form-label">Apakah “Tangga Ekstensi” dapat
                                            dipanjangkan atau dipendekkan dengan mudah? Apakah sistem pengunci/pengaman
                                            untuk ”Tangga Ekstensi” masih dalam kondisi baik?
                                        </label>
                                        <div class="col-lg-8 col-md-12">
                                            <div class="wrapper_workplace_f_6 d-flex flex-column gap-3"
                                                x-data="{ workplace_f_6_value: @entangle('workplace_f_6_value') }">
                                                <x-inputs.select2 wire:model="workplace_f_6_value"
                                                    id="workplace_f_6_value" class="form-select"
                                                    placeholder="Pemenuhan">
                                                    <option value="Ya">Ya</option>
                                                    <option value="Tidak">Tidak</option>
                                                    <option value="N/A">N/A</option>
                                                </x-inputs.select2>
                                                <div x-cloak
                                                    x-show="workplace_f_6_value === 'Tidak' || workplace_f_6_value === '5' ">
                                                    <div>
                                                        <x-kplh-texteditor wire:model="workplace_f_6_note"
                                                            id="workplace_f_6_note" placeholder="Keterangan"
                                                            :error="'workplace_f_6_note'" />
                                                    </div>
                                                    <div class="mt-3">
                                                        <x-kplh-file wire:model="workplace_f_6_file"
                                                            id="workplace_f_6_file" placeholder="Upload foto temuan"
                                                            :error="'workplace_f_6_file'" />
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div><!-- /.form-group workplace_f_6 -->

                                    <div class="row form-group mb-4">
                                        <label for="workplace_f_7_label"
                                            class="col-lg-4 col-md-12 col-form-label">Apakah tali penarik dari “Tangga
                                            Ekstensi” masih dalam kondisi baik?
                                        </label>
                                        <div class="col-lg-8 col-md-12">
                                            <div class="wrapper_workplace_f_7 d-flex flex-column gap-3"
                                                x-data="{ workplace_f_7_value: @entangle('workplace_f_7_value') }">
                                                <x-inputs.select2 wire:model="workplace_f_7_value"
                                                    id="workplace_f_7_value" class="form-select"
                                                    placeholder="Pemenuhan">
                                                    <option value="Ya">Ya</option>
                                                    <option value="Tidak">Tidak</option>
                                                    <option value="N/A">N/A</option>
                                                </x-inputs.select2>
                                                <div x-cloak
                                                    x-show="workplace_f_7_value === 'Tidak' || workplace_f_7_value === '5' ">
                                                    <div>
                                                        <x-kplh-texteditor wire:model="workplace_f_7_note"
                                                            id="workplace_f_7_note" placeholder="Keterangan"
                                                            :error="'workplace_f_7_note'" />
                                                    </div>
                                                    <div class="mt-3">
                                                        <x-kplh-file wire:model="workplace_f_7_file"
                                                            id="workplace_f_7_file" placeholder="Upload foto temuan"
                                                            :error="'workplace_f_7_file'" />
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div><!-- /.form-group workplace_f_7 -->

                                    <div class="row form-group mb-4">
                                        <label for="workplace_f_8_label"
                                            class="col-lg-4 col-md-12 col-form-label">Apakah “Tangga Lipat” masih
                                            memiliki sistem pengunci/pengaman dalam kondisi baik?
                                        </label>
                                        <div class="col-lg-8 col-md-12">
                                            <div class="wrapper_workplace_f_8 d-flex flex-column gap-3"
                                                x-data="{ workplace_f_8_value: @entangle('workplace_f_8_value') }">
                                                <x-inputs.select2 wire:model="workplace_f_8_value"
                                                    id="workplace_f_8_value" class="form-select"
                                                    placeholder="Pemenuhan">
                                                    <option value="Ya">Ya</option>
                                                    <option value="Tidak">Tidak</option>
                                                    <option value="N/A">N/A</option>
                                                </x-inputs.select2>
                                                <div x-cloak
                                                    x-show="workplace_f_8_value === 'Tidak' || workplace_f_8_value === '5' ">
                                                    <div>
                                                        <x-kplh-texteditor wire:model="workplace_f_8_note"
                                                            id="workplace_f_8_note" placeholder="Keterangan"
                                                            :error="'workplace_f_8_note'" />
                                                    </div>
                                                    <div class="mt-3">
                                                        <x-kplh-file wire:model="workplace_f_8_file"
                                                            id="workplace_f_8_file" placeholder="Upload foto temuan"
                                                            :error="'workplace_f_8_file'" />
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div><!-- /.form-group workplace_f_8 -->

                                    <div class="row form-group mb-4">
                                        <label for="workplace_f_9_label"
                                            class="col-lg-4 col-md-12 col-form-label">Apakah karyawan tidak duduk pada
                                            bagian paling atas dari “Tangga Lipat” atau tidak berdiri pada anak tangga
                                            kedua dari anak tangga paling atas?
                                        </label>
                                        <div class="col-lg-8 col-md-12">
                                            <div class="wrapper_workplace_f_9 d-flex flex-column gap-3"
                                                x-data="{ workplace_f_9_value: @entangle('workplace_f_9_value') }">
                                                <x-inputs.select2 wire:model="workplace_f_9_value"
                                                    id="workplace_f_9_value" class="form-select"
                                                    placeholder="Pemenuhan">
                                                    <option value="Ya">Ya</option>
                                                    <option value="Tidak">Tidak</option>
                                                    <option value="N/A">N/A</option>
                                                </x-inputs.select2>
                                                <div x-cloak
                                                    x-show="workplace_f_9_value === 'Tidak' || workplace_f_9_value === '5' ">
                                                    <div>
                                                        <x-kplh-texteditor wire:model="workplace_f_9_note"
                                                            id="workplace_f_9_note" placeholder="Keterangan"
                                                            :error="'workplace_f_9_note'" />
                                                    </div>
                                                    <div class="mt-3">
                                                        <x-kplh-file wire:model="workplace_f_9_file"
                                                            id="workplace_f_9_file" placeholder="Upload foto temuan"
                                                            :error="'workplace_f_9_file'" />
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div><!-- /.form-group workplace_f_9 -->

                                </div><!-- ./content-workplace_f -->

                            </div>
                        </div><!-- /.workplace_f -->

                        <div id="workplace_g" class="section-workplace_g" x-data="{ accordionOpen: false }">
                            <button
                                class="header-accordion d-flex justify-content-between w-100 border-0 bg-white py-3 px-0"
                                @click.prevent="accordionOpen = ! accordionOpen">
                                <h6 class="mb-0 fw-normal title-accordion">G. PESAWAT ANGKAT (CRANE, FORKLIFT,
                                    OVERHEAD CRANE)</h6>
                                <span x-bind:class="accordionOpen ? 'open' : ''"><img
                                        src="{{ asset('/images/icons/angle-down.png') }}" alt="" /></span>
                            </button>
                            <div class="wrapper-content-accordion max-h-0 overflow-hidden position-relative transition-all duration-700"
                                x-ref="workplace_g" x-bind:style="accordionOpen ? 'max-height: ' + 20000 + 'px' : ''"
                                x-transition.delay.5000ms>

                                <div class="content-section p-4" wire:ignore.self>

                                    <div class="row form-group mb-4">
                                        <label for="workplace_g_1_label"
                                            class="col-lg-4 col-md-12 col-form-label">Apakah karyawan yang telah
                                            terlatih dan diijinkan untuk mengoperasikan Pesawat Angkat?
                                        </label>
                                        <div class="col-lg-8 col-md-12">
                                            <div class="wrapper_workplace_g_1 d-flex flex-column gap-3"
                                                x-data="{ workplace_g_1_value: @entangle('workplace_g_1_value') }">
                                                <x-inputs.select2 wire:model="workplace_g_1_value"
                                                    id="workplace_g_1_value" class="form-select"
                                                    placeholder="Pemenuhan">
                                                    <option value="Ya">Ya</option>
                                                    <option value="Tidak">Tidak</option>
                                                    <option value="N/A">N/A</option>
                                                </x-inputs.select2>

                                                <div x-cloak
                                                    x-show="workplace_g_1_value === 'Tidak' || workplace_g_1_value === '5' ">
                                                    <div>
                                                        <x-kplh-texteditor wire:model="workplace_g_1_note"
                                                            id="workplace_g_1_note" placeholder="Keterangan"
                                                            :error="'workplace_g_1_note'" />
                                                    </div>
                                                    <div class="mt-3">
                                                        <x-kplh-file wire:model="workplace_g_1_file"
                                                            id="workplace_g_1_file" placeholder="Upload foto temuan"
                                                            :error="'workplace_g_1_file'" />
                                                    </div>
                                                </div>

                                            </div>
                                        </div>
                                    </div><!-- /.form-group workplace_g_1 -->

                                    <div class="row form-group mb-4">
                                        <label for="workplace_g_2_label"
                                            class="col-lg-4 col-md-12 col-form-label">Apakah operator Crane dan
                                            Forklift memiliki SIO yang masih berlaku dan sesuai?
                                        </label>
                                        <div class="col-lg-8 col-md-12">
                                            <div class="wrapper_workplace_g_2 d-flex flex-column gap-3"
                                                x-data="{ workplace_g_2_value: @entangle('workplace_g_2_value') }">
                                                <x-inputs.select2 wire:model="workplace_g_2_value"
                                                    id="workplace_g_2_value" class="form-select"
                                                    placeholder="Pemenuhan">
                                                    <option value="Ya">Ya</option>
                                                    <option value="Tidak">Tidak</option>
                                                    <option value="N/A">N/A</option>
                                                </x-inputs.select2>
                                                <div x-cloak
                                                    x-show="workplace_g_2_value === 'Tidak' || workplace_g_2_value === '5' ">
                                                    <div>
                                                        <x-kplh-texteditor wire:model="workplace_g_2_note"
                                                            id="workplace_g_2_note" placeholder="Keterangan"
                                                            :error="'workplace_g_2_note'" />
                                                    </div>
                                                    <div class="mt-3">
                                                        <x-kplh-file wire:model="workplace_g_2_file"
                                                            id="workplace_g_2_file" placeholder="Upload foto temuan"
                                                            :error="'workplace_g_2_file'" />
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div><!-- /.form-group workplace_g_2 -->

                                    <div class="row form-group mb-4">
                                        <label for="workplace_g_3_label"
                                            class="col-lg-4 col-md-12 col-form-label">Apakah karyawan mengetahui
                                            batasan berat aman (SWL) yang diperbolehkan? Mengetahui radius kerja aman
                                            dari Crane?
                                        </label>
                                        <div class="col-lg-8 col-md-12">
                                            <div class="wrapper_workplace_g_3 d-flex flex-column gap-3"
                                                x-data="{ workplace_g_3_value: @entangle('workplace_g_3_value') }">
                                                <x-inputs.select2 wire:model="workplace_g_3_value"
                                                    id="workplace_g_3_value" class="form-select"
                                                    placeholder="Pemenuhan">
                                                    <option value="Ya">Ya</option>
                                                    <option value="Tidak">Tidak</option>
                                                    <option value="N/A">N/A</option>
                                                </x-inputs.select2>
                                                <div x-cloak
                                                    x-show="workplace_g_3_value === 'Tidak' || workplace_g_3_value === '5' ">
                                                    <div>
                                                        <x-kplh-texteditor wire:model="workplace_g_3_note"
                                                            id="workplace_g_3_note" placeholder="Keterangan"
                                                            :error="'workplace_g_3_note'" />
                                                    </div>
                                                    <div class="mt-3">
                                                        <x-kplh-file wire:model="workplace_g_3_file"
                                                            id="workplace_g_3_file" placeholder="Upload foto temuan"
                                                            :error="'workplace_g_3_file'" />
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div><!-- /.form-group workplace_g_3 -->

                                    <div class="row form-group mb-4">
                                        <label for="workplace_g_4_label"
                                            class="col-lg-4 col-md-12 col-form-label">Apakah karyawan telah terlatih
                                            yang dapat memberikan instruksi kepada operator Crane?
                                        </label>
                                        <div class="col-lg-8 col-md-12">
                                            <div class="wrapper_workplace_g_4 d-flex flex-column gap-3"
                                                x-data="{ workplace_g_4_value: @entangle('workplace_g_4_value') }">
                                                <x-inputs.select2 wire:model="workplace_g_4_value"
                                                    id="workplace_g_4_value" class="form-select"
                                                    placeholder="Pemenuhan">
                                                    <option value="Ya">Ya</option>
                                                    <option value="Tidak">Tidak</option>
                                                    <option value="N/A">N/A</option>
                                                </x-inputs.select2>
                                                <div x-cloak
                                                    x-show="workplace_g_4_value === 'Tidak' || workplace_g_4_value === '5' ">
                                                    <div>
                                                        <x-kplh-texteditor wire:model="workplace_g_4_note"
                                                            id="workplace_g_4_note" placeholder="Keterangan"
                                                            :error="'workplace_g_4_note'" />
                                                    </div>
                                                    <div class="mt-3">
                                                        <x-kplh-file wire:model="workplace_g_4_file"
                                                            id="workplace_g_4_file" placeholder="Upload foto temuan"
                                                            :error="'workplace_g_4_file'" />
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div><!-- /.form-group workplace_g_4 -->

                                    <div class="row form-group mb-4">
                                        <label for="workplace_g_5_label"
                                            class="col-lg-4 col-md-12 col-form-label">Apakah karyawan telah terlatih
                                            yang menentukan konfigurasi alat bantu angkat pada beban yang akan diangkat?
                                        </label>
                                        <div class="col-lg-8 col-md-12">
                                            <div class="wrapper_workplace_g_5 d-flex flex-column gap-3"
                                                x-data="{ workplace_g_5_value: @entangle('workplace_g_5_value') }">
                                                <x-inputs.select2 wire:model="workplace_g_5_value"
                                                    id="workplace_g_5_value" class="form-select"
                                                    placeholder="Pemenuhan">
                                                    <option value="Ya">Ya</option>
                                                    <option value="Tidak">Tidak</option>
                                                    <option value="N/A">N/A</option>
                                                </x-inputs.select2>
                                                <div x-cloak
                                                    x-show="workplace_g_5_value === 'Tidak' || workplace_g_5_value === '5' ">
                                                    <div>
                                                        <x-kplh-texteditor wire:model="workplace_g_5_note"
                                                            id="workplace_g_5_note" placeholder="Keterangan"
                                                            :error="'workplace_g_5_note'" />
                                                    </div>
                                                    <div class="mt-3">
                                                        <x-kplh-file wire:model="workplace_g_5_file"
                                                            id="workplace_g_5_file" placeholder="Upload foto temuan"
                                                            :error="'workplace_g_5_file'" />
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div><!-- /.form-group workplace_g_5 -->

                                    <div class="row form-group mb-4">
                                        <label for="workplace_g_6_label"
                                            class="col-lg-4 col-md-12 col-form-label">Apakah daerah kerja pengangkatan
                                            dipasangkan pita barikade? Tidak ada karyawan yang berjalan di bawah beban
                                            yang diangkat?
                                        </label>
                                        <div class="col-lg-8 col-md-12">
                                            <div class="wrapper_workplace_g_6 d-flex flex-column gap-3"
                                                x-data="{ workplace_g_6_value: @entangle('workplace_g_6_value') }">
                                                <x-inputs.select2 wire:model="workplace_g_6_value"
                                                    id="workplace_g_6_value" class="form-select"
                                                    placeholder="Pemenuhan">
                                                    <option value="Ya">Ya</option>
                                                    <option value="Tidak">Tidak</option>
                                                    <option value="N/A">N/A</option>
                                                </x-inputs.select2>
                                                <div x-cloak
                                                    x-show="workplace_g_6_value === 'Tidak' || workplace_g_6_value === '5' ">
                                                    <div>
                                                        <x-kplh-texteditor wire:model="workplace_g_6_note"
                                                            id="workplace_g_6_note" placeholder="Keterangan"
                                                            :error="'workplace_g_6_note'" />
                                                    </div>
                                                    <div class="mt-3">
                                                        <x-kplh-file wire:model="workplace_g_6_file"
                                                            id="workplace_g_6_file" placeholder="Upload foto temuan"
                                                            :error="'workplace_g_6_file'" />
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div><!-- /.form-group workplace_g_6 -->

                                    <div class="row form-group mb-4">
                                        <label for="workplace_g_7_label"
                                            class="col-lg-4 col-md-12 col-form-label">Apakah karyawan yang operasikan
                                            Crane/Forklift tetap berada di dalam kabinnya, hingga proses pengangkatan
                                            selesai?
                                        </label>
                                        <div class="col-lg-8 col-md-12">
                                            <div class="wrapper_workplace_g_7 d-flex flex-column gap-3"
                                                x-data="{ workplace_g_7_value: @entangle('workplace_g_7_value') }">
                                                <x-inputs.select2 wire:model="workplace_g_7_value"
                                                    id="workplace_g_7_value" class="form-select"
                                                    placeholder="Pemenuhan">
                                                    <option value="Ya">Ya</option>
                                                    <option value="Tidak">Tidak</option>
                                                    <option value="N/A">N/A</option>
                                                </x-inputs.select2>
                                                <div x-cloak
                                                    x-show="workplace_g_7_value === 'Tidak' || workplace_g_7_value === '5' ">
                                                    <div>
                                                        <x-kplh-texteditor wire:model="workplace_g_7_note"
                                                            id="workplace_g_7_note" placeholder="Keterangan"
                                                            :error="'workplace_g_7_note'" />
                                                    </div>
                                                    <div class="mt-3">
                                                        <x-kplh-file wire:model="workplace_g_7_file"
                                                            id="workplace_g_7_file" placeholder="Upload foto temuan"
                                                            :error="'workplace_g_7_file'" />
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div><!-- /.form-group workplace_g_7 -->

                                    <div class="row form-group mb-4">
                                        <label for="workplace_g_8_label"
                                            class="col-lg-4 col-md-12 col-form-label">Apakah bantalan, penyangga atau
                                            penopang untuk barang yang diangkat itu dalam kondisi baik dan memiliki
                                            kekuatan yang memadai?
                                        </label>
                                        <div class="col-lg-8 col-md-12">
                                            <div class="wrapper_workplace_g_8 d-flex flex-column gap-3"
                                                x-data="{ workplace_g_8_value: @entangle('workplace_g_8_value') }">
                                                <x-inputs.select2 wire:model="workplace_g_8_value"
                                                    id="workplace_g_8_value" class="form-select"
                                                    placeholder="Pemenuhan">
                                                    <option value="Ya">Ya</option>
                                                    <option value="Tidak">Tidak</option>
                                                    <option value="N/A">N/A</option>
                                                </x-inputs.select2>
                                                <div x-cloak
                                                    x-show="workplace_g_8_value === 'Tidak' || workplace_g_8_value === '5' ">
                                                    <div>
                                                        <x-kplh-texteditor wire:model="workplace_g_8_note"
                                                            id="workplace_g_8_note" placeholder="Keterangan"
                                                            :error="'workplace_g_8_note'" />
                                                    </div>
                                                    <div class="mt-3">
                                                        <x-kplh-file wire:model="workplace_g_8_file"
                                                            id="workplace_g_8_file" placeholder="Upload foto temuan"
                                                            :error="'workplace_g_8_file'" />
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div><!-- /.form-group workplace_g_8 -->

                                </div><!-- ./content-workplace_g -->

                            </div>
                        </div><!-- /.workplace_g -->

                        <div id="workplace_h" class="section-workplace_h" x-data="{ accordionOpen: false }">
                            <button
                                class="header-accordion d-flex justify-content-between w-100 border-0 bg-white py-3 px-0"
                                @click.prevent="accordionOpen = ! accordionOpen">
                                <h6 class="mb-0 fw-normal title-accordion">H. PERALATAN BANTU ANGKAT (LIFTING GEARS
                                    and SLINGS)</h6>
                                <span x-bind:class="accordionOpen ? 'open' : ''"><img
                                        src="{{ asset('/images/icons/angle-down.png') }}" alt="" /></span>
                            </button>
                            <div class="wrapper-content-accordion max-h-0 overflow-hidden position-relative transition-all duration-700"
                                x-ref="workplace_h" x-bind:style="accordionOpen ? 'max-height: ' + 20000 + 'px' : ''"
                                x-transition.delay.5000ms>

                                <div class="content-section p-4" wire:ignore.self>

                                    <div class="row form-group mb-4">
                                        <label for="workplace_h_1_label"
                                            class="col-lg-4 col-md-12 col-form-label">Apakah setiap Alat Bantu Angkat
                                            yang digunakan memiliki Tag Identifikasi?
                                        </label>
                                        <div class="col-lg-8 col-md-12">
                                            <div class="wrapper_workplace_h_1 d-flex flex-column gap-3"
                                                x-data="{ workplace_h_1_value: @entangle('workplace_h_1_value') }">
                                                <x-inputs.select2 wire:model="workplace_h_1_value"
                                                    id="workplace_h_1_value" class="form-select"
                                                    placeholder="Pemenuhan">
                                                    <option value="Ya">Ya</option>
                                                    <option value="Tidak">Tidak</option>
                                                    <option value="N/A">N/A</option>
                                                </x-inputs.select2>

                                                <div x-cloak
                                                    x-show="workplace_h_1_value === 'Tidak' || workplace_h_1_value === '5' ">
                                                    <div>
                                                        <x-kplh-texteditor wire:model="workplace_h_1_note"
                                                            id="workplace_h_1_note" placeholder="Keterangan"
                                                            :error="'workplace_h_1_note'" />
                                                    </div>
                                                    <div class="mt-3">
                                                        <x-kplh-file wire:model="workplace_h_1_file"
                                                            id="workplace_h_1_file" placeholder="Upload foto temuan"
                                                            :error="'workplace_h_1_file'" />
                                                    </div>
                                                </div>

                                            </div>
                                        </div>
                                    </div><!-- /.form-group workplace_h_1 -->

                                    <div class="row form-group mb-4">
                                        <label for="workplace_h_2_label"
                                            class="col-lg-4 col-md-12 col-form-label">Apakah setiap Alat Bantu Angkat
                                            yang digunakan memiliki tanda SWL?
                                        </label>
                                        <div class="col-lg-8 col-md-12">
                                            <div class="wrapper_workplace_h_2 d-flex flex-column gap-3"
                                                x-data="{ workplace_h_2_value: @entangle('workplace_h_2_value') }">
                                                <x-inputs.select2 wire:model="workplace_h_2_value"
                                                    id="workplace_h_2_value" class="form-select"
                                                    placeholder="Pemenuhan">
                                                    <option value="Ya">Ya</option>
                                                    <option value="Tidak">Tidak</option>
                                                    <option value="N/A">N/A</option>
                                                </x-inputs.select2>
                                                <div x-cloak
                                                    x-show="workplace_h_2_value === 'Tidak' || workplace_h_2_value === '5' ">
                                                    <div>
                                                        <x-kplh-texteditor wire:model="workplace_h_2_note"
                                                            id="workplace_h_2_note" placeholder="Keterangan"
                                                            :error="'workplace_h_2_note'" />
                                                    </div>
                                                    <div class="mt-3">
                                                        <x-kplh-file wire:model="workplace_h_2_file"
                                                            id="workplace_h_2_file" placeholder="Upload foto temuan"
                                                            :error="'workplace_h_2_file'" />
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div><!-- /.form-group workplace_h_2 -->

                                    <div class="row form-group mb-4">
                                        <label for="workplace_h_3_label"
                                            class="col-lg-4 col-md-12 col-form-label">Apakah semua Alat Bantu Angkat
                                            memiliki warna Tag Inspeksi yang masih berlaku? Dan diperiksa oleh karyawan
                                            yang berkompeten?
                                        </label>
                                        <div class="col-lg-8 col-md-12">
                                            <div class="wrapper_workplace_h_3 d-flex flex-column gap-3"
                                                x-data="{ workplace_h_3_value: @entangle('workplace_h_3_value') }">
                                                <x-inputs.select2 wire:model="workplace_h_3_value"
                                                    id="workplace_h_3_value" class="form-select"
                                                    placeholder="Pemenuhan">
                                                    <option value="Ya">Ya</option>
                                                    <option value="Tidak">Tidak</option>
                                                    <option value="N/A">N/A</option>
                                                </x-inputs.select2>
                                                <div x-cloak
                                                    x-show="workplace_h_3_value === 'Tidak' || workplace_h_3_value === '5' ">
                                                    <div>
                                                        <x-kplh-texteditor wire:model="workplace_h_3_note"
                                                            id="workplace_h_3_note" placeholder="Keterangan"
                                                            :error="'workplace_h_3_note'" />
                                                    </div>
                                                    <div class="mt-3">
                                                        <x-kplh-file wire:model="workplace_h_3_file"
                                                            id="workplace_h_3_file" placeholder="Upload foto temuan"
                                                            :error="'workplace_h_3_file'" />
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div><!-- /.form-group workplace_h_3 -->

                                    <div class="row form-group mb-4">
                                        <label for="workplace_h_4_label"
                                            class="col-lg-4 col-md-12 col-form-label">Apakah orang yang menggunakan
                                            Alat Bantu Angkat telah mengikuti pelatihan yang sesuai untuk pekerjaan
                                            angkat mengangkat?
                                        </label>
                                        <div class="col-lg-8 col-md-12">
                                            <div class="wrapper_workplace_h_4 d-flex flex-column gap-3"
                                                x-data="{ workplace_h_4_value: @entangle('workplace_h_4_value') }">
                                                <x-inputs.select2 wire:model="workplace_h_4_value"
                                                    id="workplace_h_4_value" class="form-select"
                                                    placeholder="Pemenuhan">
                                                    <option value="Ya">Ya</option>
                                                    <option value="Tidak">Tidak</option>
                                                    <option value="N/A">N/A</option>
                                                </x-inputs.select2>
                                                <div x-cloak
                                                    x-show="workplace_h_4_value === 'Tidak' || workplace_h_4_value === '5' ">
                                                    <div>
                                                        <x-kplh-texteditor wire:model="workplace_h_4_note"
                                                            id="workplace_h_4_note" placeholder="Keterangan"
                                                            :error="'workplace_h_4_note'" />
                                                    </div>
                                                    <div class="mt-3">
                                                        <x-kplh-file wire:model="workplace_h_4_file"
                                                            id="workplace_h_4_file" placeholder="Upload foto temuan"
                                                            :error="'workplace_h_4_file'" />
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div><!-- /.form-group workplace_h_4 -->

                                    <div class="row form-group mb-4">
                                        <label for="workplace_h_5_label"
                                            class="col-lg-4 col-md-12 col-form-label">Apakah alat angkat tersebut
                                            telah memiliki sertifikat uji kelayakan?
                                        </label>
                                        <div class="col-lg-8 col-md-12">
                                            <div class="wrapper_workplace_h_5 d-flex flex-column gap-3"
                                                x-data="{ workplace_h_5_value: @entangle('workplace_h_5_value') }">
                                                <x-inputs.select2 wire:model="workplace_h_5_value"
                                                    id="workplace_h_5_value" class="form-select"
                                                    placeholder="Pemenuhan">
                                                    <option value="Ya">Ya</option>
                                                    <option value="Tidak">Tidak</option>
                                                    <option value="N/A">N/A</option>
                                                </x-inputs.select2>
                                                <div x-cloak
                                                    x-show="workplace_h_5_value === 'Tidak' || workplace_h_5_value === '5' ">
                                                    <div>
                                                        <x-kplh-texteditor wire:model="workplace_h_5_note"
                                                            id="workplace_h_5_note" placeholder="Keterangan"
                                                            :error="'workplace_h_5_note'" />
                                                    </div>
                                                    <div class="mt-3">
                                                        <x-kplh-file wire:model="workplace_h_5_file"
                                                            id="workplace_h_5_file" placeholder="Upload foto temuan"
                                                            :error="'workplace_h_5_file'" />
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div><!-- /.form-group workplace_h_5 -->

                                    <div class="row form-group mb-4">
                                        <label for="workplace_h_6_label"
                                            class="col-lg-4 col-md-12 col-form-label">Apakah Alat Bantu Angkat yang
                                            tidak digunakan itu disimpan dengan baik dan aman?
                                        </label>
                                        <div class="col-lg-8 col-md-12">
                                            <div class="wrapper_workplace_h_6 d-flex flex-column gap-3"
                                                x-data="{ workplace_h_6_value: @entangle('workplace_h_6_value') }">
                                                <x-inputs.select2 wire:model="workplace_h_6_value"
                                                    id="workplace_h_6_value" class="form-select"
                                                    placeholder="Pemenuhan">
                                                    <option value="Ya">Ya</option>
                                                    <option value="Tidak">Tidak</option>
                                                    <option value="N/A">N/A</option>
                                                </x-inputs.select2>
                                                <div x-cloak
                                                    x-show="workplace_h_6_value === 'Tidak' || workplace_h_6_value === '5' ">
                                                    <div>
                                                        <x-kplh-texteditor wire:model="workplace_h_6_note"
                                                            id="workplace_h_6_note" placeholder="Keterangan"
                                                            :error="'workplace_h_6_note'" />
                                                    </div>
                                                    <div class="mt-3">
                                                        <x-kplh-file wire:model="workplace_h_6_file"
                                                            id="workplace_h_6_file" placeholder="Upload foto temuan"
                                                            :error="'workplace_h_6_file'" />
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div><!-- /.form-group workplace_h_6 -->

                                </div><!-- ./content-workplace_h -->

                            </div>
                        </div><!-- /.workplace_h -->

                        <div id="workplace_i" class="section-workplace_i" x-data="{ accordionOpen: false }">
                            <button
                                class="header-accordion d-flex justify-content-between w-100 border-0 bg-white py-3 px-0"
                                @click.prevent="accordionOpen = ! accordionOpen">
                                <h6 class="mb-0 fw-normal title-accordion">I. GALIAN dan PARITAN (EXCAVATION and
                                    TRENCHING)</h6>
                                <span x-bind:class="accordionOpen ? 'open' : ''"><img
                                        src="{{ asset('/images/icons/angle-down.png') }}" alt="" /></span>
                            </button>
                            <div class="wrapper-content-accordion max-h-0 overflow-hidden position-relative transition-all duration-700"
                                x-ref="workplace_i" x-bind:style="accordionOpen ? 'max-height: ' + 20000 + 'px' : ''"
                                x-transition.delay.5000ms>

                                <div class="content-section p-4" wire:ignore.self>

                                    <div class="row form-group mb-4">
                                        <label for="workplace_i_1_label"
                                            class="col-lg-4 col-md-12 col-form-label">Apakah pekerjaan untuk Galian
                                            (lebih dari 30cm) atau Paritan itu telah memiliki ijin kerja yang
                                            diperlukan?
                                        </label>
                                        <div class="col-lg-8 col-md-12">
                                            <div class="wrapper_workplace_i_1 d-flex flex-column gap-3"
                                                x-data="{ workplace_i_1_value: @entangle('workplace_i_1_value') }">
                                                <x-inputs.select2 wire:model="workplace_i_1_value"
                                                    id="workplace_i_1_value" class="form-select"
                                                    placeholder="Pemenuhan">
                                                    <option value="Ya">Ya</option>
                                                    <option value="Tidak">Tidak</option>
                                                    <option value="N/A">N/A</option>
                                                </x-inputs.select2>

                                                <div x-cloak
                                                    x-show="workplace_i_1_value === 'Tidak' || workplace_i_1_value === '5' ">
                                                    <div>
                                                        <x-kplh-texteditor wire:model="workplace_i_1_note"
                                                            id="workplace_i_1_note" placeholder="Keterangan"
                                                            :error="'workplace_i_1_note'" />
                                                    </div>
                                                    <div class="mt-3">
                                                        <x-kplh-file wire:model="workplace_i_1_file"
                                                            id="workplace_i_1_file" placeholder="Upload foto temuan"
                                                            :error="'workplace_i_1_file'" />
                                                    </div>
                                                </div>

                                            </div>
                                        </div>
                                    </div><!-- /.form-group workplace_i_1 -->

                                    <div class="row form-group mb-4">
                                        <label for="workplace_i_2_label"
                                            class="col-lg-4 col-md-12 col-form-label">Apakah dilakukan pemeriksaan
                                            fasilitas bawah tanah telah dilakukan sebelum ijin kerja dikeluarkan?
                                        </label>
                                        <div class="col-lg-8 col-md-12">
                                            <div class="wrapper_workplace_i_2 d-flex flex-column gap-3"
                                                x-data="{ workplace_i_2_value: @entangle('workplace_i_2_value') }">
                                                <x-inputs.select2 wire:model="workplace_i_2_value"
                                                    id="workplace_i_2_value" class="form-select"
                                                    placeholder="Pemenuhan">
                                                    <option value="Ya">Ya</option>
                                                    <option value="Tidak">Tidak</option>
                                                    <option value="N/A">N/A</option>
                                                </x-inputs.select2>
                                                <div x-cloak
                                                    x-show="workplace_i_2_value === 'Tidak' || workplace_i_2_value === '5' ">
                                                    <div>
                                                        <x-kplh-texteditor wire:model="workplace_i_2_note"
                                                            id="workplace_i_2_note" placeholder="Keterangan"
                                                            :error="'workplace_i_2_note'" />
                                                    </div>
                                                    <div class="mt-3">
                                                        <x-kplh-file wire:model="workplace_i_2_file"
                                                            id="workplace_i_2_file" placeholder="Upload foto temuan"
                                                            :error="'workplace_i_2_file'" />
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div><!-- /.form-group workplace_i_2 -->

                                    <div class="row form-group mb-4">
                                        <label for="workplace_i_3_label"
                                            class="col-lg-4 col-md-12 col-form-label">Bila pemeriksaan fasilitas bawah
                                            tanah belum dilakukan, apakah pekerjaan galian atau paritan dilakukan dengan
                                            manual (tidak menggunakan kendaraan berat atau mesin penggali)?
                                        </label>
                                        <div class="col-lg-8 col-md-12">
                                            <div class="wrapper_workplace_i_3 d-flex flex-column gap-3"
                                                x-data="{ workplace_i_3_value: @entangle('workplace_i_3_value') }">
                                                <x-inputs.select2 wire:model="workplace_i_3_value"
                                                    id="workplace_i_3_value" class="form-select"
                                                    placeholder="Pemenuhan">
                                                    <option value="Ya">Ya</option>
                                                    <option value="Tidak">Tidak</option>
                                                    <option value="N/A">N/A</option>
                                                </x-inputs.select2>
                                                <div x-cloak
                                                    x-show="workplace_i_3_value === 'Tidak' || workplace_i_3_value === '5' ">
                                                    <div>
                                                        <x-kplh-texteditor wire:model="workplace_i_3_note"
                                                            id="workplace_i_3_note" placeholder="Keterangan"
                                                            :error="'workplace_i_3_note'" />
                                                    </div>
                                                    <div class="mt-3">
                                                        <x-kplh-file wire:model="workplace_i_3_file"
                                                            id="workplace_i_3_file" placeholder="Upload foto temuan"
                                                            :error="'workplace_i_3_file'" />
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div><!-- /.form-group workplace_i_3 -->

                                    <div class="row form-group mb-4">
                                        <label for="workplace_i_4_label"
                                            class="col-lg-4 col-md-12 col-form-label">Untuk pekerjaan Paritan (tinggi
                                            dinding lebih besar dari lebar dasar galian) yang lebih 2 meter, apakah
                                            diberikan tiang penyangga agar dinding galian tidak runtuh?
                                        </label>
                                        <div class="col-lg-8 col-md-12">
                                            <div class="wrapper_workplace_i_4 d-flex flex-column gap-3"
                                                x-data="{ workplace_i_4_value: @entangle('workplace_i_4_value') }">
                                                <x-inputs.select2 wire:model="workplace_i_4_value"
                                                    id="workplace_i_4_value" class="form-select"
                                                    placeholder="Pemenuhan">
                                                    <option value="Ya">Ya</option>
                                                    <option value="Tidak">Tidak</option>
                                                    <option value="N/A">N/A</option>
                                                </x-inputs.select2>
                                                <div x-cloak
                                                    x-show="workplace_i_4_value === 'Tidak' || workplace_i_4_value === '5' ">
                                                    <div>
                                                        <x-kplh-texteditor wire:model="workplace_i_4_note"
                                                            id="workplace_i_4_note" placeholder="Keterangan"
                                                            :error="'workplace_i_4_note'" />
                                                    </div>
                                                    <div class="mt-3">
                                                        <x-kplh-file wire:model="workplace_i_4_file"
                                                            id="workplace_i_4_file" placeholder="Upload foto temuan"
                                                            :error="'workplace_i_4_file'" />
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div><!-- /.form-group workplace_i_4 -->

                                    <div class="row form-group mb-4">
                                        <label for="workplace_i_5_label"
                                            class="col-lg-4 col-md-12 col-form-label">Apakah pada galian dan paritan
                                            itu telah di-barikade dengan benar (minimal 2.5 meter dari tepi galian)?
                                        </label>
                                        <div class="col-lg-8 col-md-12">
                                            <div class="wrapper_workplace_i_5 d-flex flex-column gap-3"
                                                x-data="{ workplace_i_5_value: @entangle('workplace_i_5_value') }">
                                                <x-inputs.select2 wire:model="workplace_i_5_value"
                                                    id="workplace_i_5_value" class="form-select"
                                                    placeholder="Pemenuhan">
                                                    <option value="Ya">Ya</option>
                                                    <option value="Tidak">Tidak</option>
                                                    <option value="N/A">N/A</option>
                                                </x-inputs.select2>
                                                <div x-cloak
                                                    x-show="workplace_i_5_value === 'Tidak' || workplace_i_5_value === '5' ">
                                                    <div>
                                                        <x-kplh-texteditor wire:model="workplace_i_5_note"
                                                            id="workplace_i_5_note" placeholder="Keterangan"
                                                            :error="'workplace_i_5_note'" />
                                                    </div>
                                                    <div class="mt-3">
                                                        <x-kplh-file wire:model="workplace_i_5_file"
                                                            id="workplace_i_5_file" placeholder="Upload foto temuan"
                                                            :error="'workplace_i_5_file'" />
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div><!-- /.form-group workplace_i_5 -->

                                    <div class="row form-group mb-4">
                                        <label for="workplace_i_6_label"
                                            class="col-lg-4 col-md-12 col-form-label">Apakah tanah yang tergali itu
                                            ditumpuk atau ditempatkan jauh dari bibir galian dan paritan (tidak ada
                                            kemungkinan tanah tergali dapat jatuh kembali ke dalam galian atau paritan)?
                                        </label>
                                        <div class="col-lg-8 col-md-12">
                                            <div class="wrapper_workplace_i_6 d-flex flex-column gap-3"
                                                x-data="{ workplace_i_6_value: @entangle('workplace_i_6_value') }">
                                                <x-inputs.select2 wire:model="workplace_i_6_value"
                                                    id="workplace_i_6_value" class="form-select"
                                                    placeholder="Pemenuhan">
                                                    <option value="Ya">Ya</option>
                                                    <option value="Tidak">Tidak</option>
                                                    <option value="N/A">N/A</option>
                                                </x-inputs.select2>
                                                <div x-cloak
                                                    x-show="workplace_i_6_value === 'Tidak' || workplace_i_6_value === '5' ">
                                                    <div>
                                                        <x-kplh-texteditor wire:model="workplace_i_6_note"
                                                            id="workplace_i_6_note" placeholder="Keterangan"
                                                            :error="'workplace_i_6_note'" />
                                                    </div>
                                                    <div class="mt-3">
                                                        <x-kplh-file wire:model="workplace_i_6_file"
                                                            id="workplace_i_6_file" placeholder="Upload foto temuan"
                                                            :error="'workplace_i_6_file'" />
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div><!-- /.form-group workplace_i_6 -->

                                    <div class="row form-group mb-4">
                                        <label for="workplace_i_7_label"
                                            class="col-lg-4 col-md-12 col-form-label">Apakah pada galian dan paritan
                                            itu telah disediakan tangga atau jalan masuk/keluar yang aman?
                                        </label>
                                        <div class="col-lg-8 col-md-12">
                                            <div class="wrapper_workplace_i_7 d-flex flex-column gap-3"
                                                x-data="{ workplace_i_7_value: @entangle('workplace_i_7_value') }">
                                                <x-inputs.select2 wire:model="workplace_i_7_value"
                                                    id="workplace_i_7_value" class="form-select"
                                                    placeholder="Pemenuhan">
                                                    <option value="Ya">Ya</option>
                                                    <option value="Tidak">Tidak</option>
                                                    <option value="N/A">N/A</option>
                                                </x-inputs.select2>
                                                <div x-cloak
                                                    x-show="workplace_i_7_value === 'Tidak' || workplace_i_7_value === '5' ">
                                                    <div>
                                                        <x-kplh-texteditor wire:model="workplace_i_7_note"
                                                            id="workplace_i_7_note" placeholder="Keterangan"
                                                            :error="'workplace_i_7_note'" />
                                                    </div>
                                                    <div class="mt-3">
                                                        <x-kplh-file wire:model="workplace_i_7_file"
                                                            id="workplace_i_7_file" placeholder="Upload foto temuan"
                                                            :error="'workplace_i_7_file'" />
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div><!-- /.form-group workplace_i_7 -->

                                    <div class="row form-group mb-4">
                                        <label for="workplace_i_8_label"
                                            class="col-lg-4 col-md-12 col-form-label">Apakah tangga atau jalan masuk
                                            tersebut telah dilengkapi dengan handrail (bila memungkinkan)? Memiliki
                                            pijakan/anak tangga yang lebar dengan jarak yang memadai? Tangga atau jalan
                                            masuk yang tidak curam?
                                        </label>
                                        <div class="col-lg-8 col-md-12">
                                            <div class="wrapper_workplace_i_8 d-flex flex-column gap-3"
                                                x-data="{ workplace_i_8_value: @entangle('workplace_i_8_value') }">
                                                <x-inputs.select2 wire:model="workplace_i_8_value"
                                                    id="workplace_i_8_value" class="form-select"
                                                    placeholder="Pemenuhan">
                                                    <option value="Ya">Ya</option>
                                                    <option value="Tidak">Tidak</option>
                                                    <option value="N/A">N/A</option>
                                                </x-inputs.select2>
                                                <div x-cloak
                                                    x-show="workplace_i_8_value === 'Tidak' || workplace_i_8_value === '5' ">
                                                    <div>
                                                        <x-kplh-texteditor wire:model="workplace_i_8_note"
                                                            id="workplace_i_8_note" placeholder="Keterangan"
                                                            :error="'workplace_i_8_note'" />
                                                    </div>
                                                    <div class="mt-3">
                                                        <x-kplh-file wire:model="workplace_i_8_file"
                                                            id="workplace_i_8_file" placeholder="Upload foto temuan"
                                                            :error="'workplace_i_8_file'" />
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div><!-- /.form-group workplace_i_8 -->

                                </div><!-- ./content-workplace_i -->

                            </div>
                        </div><!-- /.workplace_i -->

                        <div id="workplace_j" class="section-workplace_j" x-data="{ accordionOpen: false }">
                            <button
                                class="header-accordion d-flex justify-content-between w-100 border-0 bg-white py-3 px-0"
                                @click.prevent="accordionOpen = ! accordionOpen">
                                <h6 class="mb-0 fw-normal title-accordion">J. LISTRIK (ELECTRICAL)</h6>
                                <span x-bind:class="accordionOpen ? 'open' : ''"><img
                                        src="{{ asset('/images/icons/angle-down.png') }}" alt="" /></span>
                            </button>
                            <div class="wrapper-content-accordion max-h-0 overflow-hidden position-relative transition-all duration-700"
                                x-ref="workplace_j" x-bind:style="accordionOpen ? 'max-height: ' + 20000 + 'px' : ''"
                                x-transition.delay.5000ms>

                                <div class="content-section p-4" wire:ignore.self>

                                    <div class="row form-group mb-4">
                                        <label for="workplace_j_1_label"
                                            class="col-lg-4 col-md-12 col-form-label">Apakah karyawan menggunakan
                                            peralatan kerja listrik dengan benar dan aman? Mengetahui cara
                                            menggunakannya?
                                        </label>
                                        <div class="col-lg-8 col-md-12">
                                            <div class="wrapper_workplace_j_1 d-flex flex-column gap-3"
                                                x-data="{ workplace_j_1_value: @entangle('workplace_j_1_value') }">
                                                <x-inputs.select2 wire:model="workplace_j_1_value"
                                                    id="workplace_j_1_value" class="form-select"
                                                    placeholder="Pemenuhan">
                                                    <option value="Ya">Ya</option>
                                                    <option value="Tidak">Tidak</option>
                                                    <option value="N/A">N/A</option>
                                                </x-inputs.select2>

                                                <div x-cloak
                                                    x-show="workplace_j_1_value === 'Tidak' || workplace_j_1_value === '5' ">
                                                    <div>
                                                        <x-kplh-texteditor wire:model="workplace_j_1_note"
                                                            id="workplace_j_1_note" placeholder="Keterangan"
                                                            :error="'workplace_j_1_note'" />
                                                    </div>
                                                    <div class="mt-3">
                                                        <x-kplh-file wire:model="workplace_j_1_file"
                                                            id="workplace_j_1_file" placeholder="Upload foto temuan"
                                                            :error="'workplace_j_1_file'" />
                                                    </div>
                                                </div>

                                            </div>
                                        </div>
                                    </div><!-- /.form-group workplace_j_1 -->

                                    <div class="row form-group mb-4">
                                        <label for="workplace_j_2_label"
                                            class="col-lg-4 col-md-12 col-form-label">Apakah karyawan menggunakan APD
                                            yang berbahan “tidak menghantar listrik” atau tidak basah (tetap kering)?
                                        </label>
                                        <div class="col-lg-8 col-md-12">
                                            <div class="wrapper_workplace_j_2 d-flex flex-column gap-3"
                                                x-data="{ workplace_j_2_value: @entangle('workplace_j_2_value') }">
                                                <x-inputs.select2 wire:model="workplace_j_2_value"
                                                    id="workplace_j_2_value" class="form-select"
                                                    placeholder="Pemenuhan">
                                                    <option value="Ya">Ya</option>
                                                    <option value="Tidak">Tidak</option>
                                                    <option value="N/A">N/A</option>
                                                </x-inputs.select2>
                                                <div x-cloak
                                                    x-show="workplace_j_2_value === 'Tidak' || workplace_j_2_value === '5' ">
                                                    <div>
                                                        <x-kplh-texteditor wire:model="workplace_j_2_note"
                                                            id="workplace_j_2_note" placeholder="Keterangan"
                                                            :error="'workplace_j_2_note'" />
                                                    </div>
                                                    <div class="mt-3">
                                                        <x-kplh-file wire:model="workplace_j_2_file"
                                                            id="workplace_j_2_file" placeholder="Upload foto temuan"
                                                            :error="'workplace_j_2_file'" />
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div><!-- /.form-group workplace_j_2 -->

                                    <div class="row form-group mb-4">
                                        <label for="workplace_j_3_label"
                                            class="col-lg-4 col-md-12 col-form-label">Apakah semua peralatan kerja
                                            listrik telah diinspeksi? Apakah diberi label inspeksi yang benar dan
                                            sesuai? Apakah masih dalam kondisi baik?
                                        </label>
                                        <div class="col-lg-8 col-md-12">
                                            <div class="wrapper_workplace_j_3 d-flex flex-column gap-3"
                                                x-data="{ workplace_j_3_value: @entangle('workplace_j_3_value') }">
                                                <x-inputs.select2 wire:model="workplace_j_3_value"
                                                    id="workplace_j_3_value" class="form-select"
                                                    placeholder="Pemenuhan">
                                                    <option value="Ya">Ya</option>
                                                    <option value="Tidak">Tidak</option>
                                                    <option value="N/A">N/A</option>
                                                </x-inputs.select2>
                                                <div x-cloak
                                                    x-show="workplace_j_3_value === 'Tidak' || workplace_j_3_value === '5' ">
                                                    <div>
                                                        <x-kplh-texteditor wire:model="workplace_j_3_note"
                                                            id="workplace_j_3_note" placeholder="Keterangan"
                                                            :error="'workplace_j_3_note'" />
                                                    </div>
                                                    <div class="mt-3">
                                                        <x-kplh-file wire:model="workplace_j_3_file"
                                                            id="workplace_j_3_file" placeholder="Upload foto temuan"
                                                            :error="'workplace_j_3_file'" />
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div><!-- /.form-group workplace_j_3 -->

                                    <div class="row form-group mb-4">
                                        <label for="workplace_j_4_label"
                                            class="col-lg-4 col-md-12 col-form-label">Apakah kabel dan sambungan
                                            listrik tidak berserakan di permukaan lantai dan jauh dari genangan air?
                                        </label>
                                        <div class="col-lg-8 col-md-12">
                                            <div class="wrapper_workplace_j_4 d-flex flex-column gap-3"
                                                x-data="{ workplace_j_4_value: @entangle('workplace_j_4_value') }">
                                                <x-inputs.select2 wire:model="workplace_j_4_value"
                                                    id="workplace_j_4_value" class="form-select"
                                                    placeholder="Pemenuhan">
                                                    <option value="Ya">Ya</option>
                                                    <option value="Tidak">Tidak</option>
                                                    <option value="N/A">N/A</option>
                                                </x-inputs.select2>
                                                <div x-cloak
                                                    x-show="workplace_j_4_value === 'Tidak' || workplace_j_4_value === '5' ">
                                                    <div>
                                                        <x-kplh-texteditor wire:model="workplace_j_4_note"
                                                            id="workplace_j_4_note" placeholder="Keterangan"
                                                            :error="'workplace_j_4_note'" />
                                                    </div>
                                                    <div class="mt-3">
                                                        <x-kplh-file wire:model="workplace_j_4_file"
                                                            id="workplace_j_4_file" placeholder="Upload foto temuan"
                                                            :error="'workplace_j_4_file'" />
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div><!-- /.form-group workplace_j_4 -->

                                    <div class="row form-group mb-4">
                                        <label for="workplace_j_5_label" class="col-lg-4 col-md-12 col-form-label">
                                            Apakah pengaman masih terpasang pada peralatan kerja tersebut? Masih
                                            memberikan perlindungan yang memadai?
                                        </label>
                                        <div class="col-lg-8 col-md-12">
                                            <div class="wrapper_workplace_j_5 d-flex flex-column gap-3"
                                                x-data="{ workplace_j_5_value: @entangle('workplace_j_5_value') }">
                                                <x-inputs.select2 wire:model="workplace_j_5_value"
                                                    id="workplace_j_5_value" class="form-select"
                                                    placeholder="Pemenuhan">
                                                    <option value="Ya">Ya</option>
                                                    <option value="Tidak">Tidak</option>
                                                    <option value="N/A">N/A</option>
                                                </x-inputs.select2>
                                                <div x-cloak
                                                    x-show="workplace_j_5_value === 'Tidak' || workplace_j_5_value === '5' ">
                                                    <div>
                                                        <x-kplh-texteditor wire:model="workplace_j_5_note"
                                                            id="workplace_j_5_note" placeholder="Keterangan"
                                                            :error="'workplace_j_5_note'" />
                                                    </div>
                                                    <div class="mt-3">
                                                        <x-kplh-file wire:model="workplace_j_5_file"
                                                            id="workplace_j_5_file" placeholder="Upload foto temuan"
                                                            :error="'workplace_j_5_file'" />
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div><!-- /.form-group workplace_j_5 -->

                                    <div class="row form-group mb-4">
                                        <label for="workplace_j_6_label"
                                            class="col-lg-4 col-md-12 col-form-label">Apakah ELCB atau GFCI terpasang?
                                            Atau sejenis pelindung “earth leakage” lainnya, telah terpasang?
                                        </label>
                                        <div class="col-lg-8 col-md-12">
                                            <div class="wrapper_workplace_j_6 d-flex flex-column gap-3"
                                                x-data="{ workplace_j_6_value: @entangle('workplace_j_6_value') }">
                                                <x-inputs.select2 wire:model="workplace_j_6_value"
                                                    id="workplace_j_6_value" class="form-select"
                                                    placeholder="Pemenuhan">
                                                    <option value="Ya">Ya</option>
                                                    <option value="Tidak">Tidak</option>
                                                    <option value="N/A">N/A</option>
                                                </x-inputs.select2>
                                                <div x-cloak
                                                    x-show="workplace_j_6_value === 'Tidak' || workplace_j_6_value === '5' ">
                                                    <div>
                                                        <x-kplh-texteditor wire:model="workplace_j_6_note"
                                                            id="workplace_j_6_note" placeholder="Keterangan"
                                                            :error="'workplace_j_6_note'" />
                                                    </div>
                                                    <div class="mt-3">
                                                        <x-kplh-file wire:model="workplace_j_6_file"
                                                            id="workplace_j_6_file" placeholder="Upload foto temuan"
                                                            :error="'workplace_j_6_file'" />
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div><!-- /.form-group workplace_j_6 -->

                                    <div class="row form-group mb-4">
                                        <label for="workplace_j_7_label"
                                            class="col-lg-4 col-md-12 col-form-label">Apakah menggunakan sambungan
                                            listrik yang sesuai dan dipasang dengan benar?
                                        </label>
                                        <div class="col-lg-8 col-md-12">
                                            <div class="wrapper_workplace_j_7 d-flex flex-column gap-3"
                                                x-data="{ workplace_j_7_value: @entangle('workplace_j_7_value') }">
                                                <x-inputs.select2 wire:model="workplace_j_7_value"
                                                    id="workplace_j_7_value" class="form-select"
                                                    placeholder="Pemenuhan">
                                                    <option value="Ya">Ya</option>
                                                    <option value="Tidak">Tidak</option>
                                                    <option value="N/A">N/A</option>
                                                </x-inputs.select2>
                                                <div x-cloak
                                                    x-show="workplace_j_7_value === 'Tidak' || workplace_j_7_value === '5' ">
                                                    <div>
                                                        <x-kplh-texteditor wire:model="workplace_j_7_note"
                                                            id="workplace_j_7_note" placeholder="Keterangan"
                                                            :error="'workplace_j_7_note'" />
                                                    </div>
                                                    <div class="mt-3">
                                                        <x-kplh-file wire:model="workplace_j_7_file"
                                                            id="workplace_j_7_file" placeholder="Upload foto temuan"
                                                            :error="'workplace_j_7_file'" />
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div><!-- /.form-group workplace_j_7 -->

                                    <div class="row form-group mb-4">
                                        <label for="workplace_j_8_label"
                                            class="col-lg-4 col-md-12 col-form-label">Apakah peralatan dan perkakas
                                            kerja yang tidak sedang digunakan, telah ditempatkan dengan benar dan aman?
                                        </label>
                                        <div class="col-lg-8 col-md-12">
                                            <div class="wrapper_workplace_j_8 d-flex flex-column gap-3"
                                                x-data="{ workplace_j_8_value: @entangle('workplace_j_8_value') }">
                                                <x-inputs.select2 wire:model="workplace_j_8_value"
                                                    id="workplace_j_8_value" class="form-select"
                                                    placeholder="Pemenuhan">
                                                    <option value="Ya">Ya</option>
                                                    <option value="Tidak">Tidak</option>
                                                    <option value="N/A">N/A</option>
                                                </x-inputs.select2>
                                                <div x-cloak
                                                    x-show="workplace_j_8_value === 'Tidak' || workplace_j_8_value === '5' ">
                                                    <div>
                                                        <x-kplh-texteditor wire:model="workplace_j_8_note"
                                                            id="workplace_j_8_note" placeholder="Keterangan"
                                                            :error="'workplace_j_8_note'" />
                                                    </div>
                                                    <div class="mt-3">
                                                        <x-kplh-file wire:model="workplace_j_8_file"
                                                            id="workplace_j_8_file" placeholder="Upload foto temuan"
                                                            :error="'workplace_j_8_file'" />
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div><!-- /.form-group workplace_j_8 -->

                                </div><!-- ./content-workplace_j -->

                            </div>
                        </div><!-- /.workplace_j -->

                        <div id="workplace_k" class="section-workplace_k" x-data="{ accordionOpen: false }">
                            <button
                                class="header-accordion d-flex justify-content-between w-100 border-0 bg-white py-3 px-0"
                                @click.prevent="accordionOpen = ! accordionOpen">
                                <h6 class="mb-0 fw-normal title-accordion">K. RUANG TERBATAS</h6>
                                <span x-bind:class="accordionOpen ? 'open' : ''"><img
                                        src="{{ asset('/images/icons/angle-down.png') }}" alt="" /></span>
                            </button>
                            <div class="wrapper-content-accordion max-h-0 overflow-hidden position-relative transition-all duration-700"
                                x-ref="workplace_k" x-bind:style="accordionOpen ? 'max-height: ' + 20000 + 'px' : ''"
                                x-transition.delay.5000ms>

                                <div class="content-section p-4" wire:ignore.self>

                                    <div class="row form-group mb-4">
                                        <label for="workplace_k_1_label"
                                            class="col-lg-4 col-md-12 col-form-label">Apakah pekerjaan di ruang kerja
                                            terbatas telah memiliki ijin kerja dan ada di tempat kerja?
                                        </label>
                                        <div class="col-lg-8 col-md-12">
                                            <div class="wrapper_workplace_k_1 d-flex flex-column gap-3"
                                                x-data="{ workplace_k_1_value: @entangle('workplace_k_1_value') }">
                                                <x-inputs.select2 wire:model="workplace_k_1_value"
                                                    id="workplace_k_1_value" class="form-select"
                                                    placeholder="Pemenuhan">
                                                    <option value="Ya">Ya</option>
                                                    <option value="Tidak">Tidak</option>
                                                    <option value="N/A">N/A</option>
                                                </x-inputs.select2>

                                                <div x-cloak
                                                    x-show="workplace_k_1_value === 'Tidak' || workplace_k_1_value === '5' ">
                                                    <div>
                                                        <x-kplh-texteditor wire:model="workplace_k_1_note"
                                                            id="workplace_k_1_note" placeholder="Keterangan"
                                                            :error="'workplace_k_1_note'" />
                                                    </div>
                                                    <div class="mt-3">
                                                        <x-kplh-file wire:model="workplace_k_1_file"
                                                            id="workplace_k_1_file" placeholder="Upload foto temuan"
                                                            :error="'workplace_k_1_file'" />
                                                    </div>
                                                </div>

                                            </div>
                                        </div>
                                    </div><!-- /.form-group workplace_k_1 -->

                                    <div class="row form-group mb-4">
                                        <label for="workplace_k_2_label"
                                            class="col-lg-4 col-md-12 col-form-label">Apakah pemeriksaan gas beracun
                                            di ruang terbatas telah dilakukan?
                                        </label>
                                        <div class="col-lg-8 col-md-12">
                                            <div class="wrapper_workplace_k_2 d-flex flex-column gap-3"
                                                x-data="{ workplace_k_2_value: @entangle('workplace_k_2_value') }">
                                                <x-inputs.select2 wire:model="workplace_k_2_value"
                                                    id="workplace_k_2_value" class="form-select"
                                                    placeholder="Pemenuhan">
                                                    <option value="Ya">Ya</option>
                                                    <option value="Tidak">Tidak</option>
                                                    <option value="N/A">N/A</option>
                                                </x-inputs.select2>
                                                <div x-cloak
                                                    x-show="workplace_k_2_value === 'Tidak' || workplace_k_2_value === '5' ">
                                                    <div>
                                                        <x-kplh-texteditor wire:model="workplace_k_2_note"
                                                            id="workplace_k_2_note" placeholder="Keterangan"
                                                            :error="'workplace_k_2_note'" />
                                                    </div>
                                                    <div class="mt-3">
                                                        <x-kplh-file wire:model="workplace_k_2_file"
                                                            id="workplace_k_2_file" placeholder="Upload foto temuan"
                                                            :error="'workplace_k_2_file'" />
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div><!-- /.form-group workplace_k_2 -->

                                    <div class="row form-group mb-4">
                                        <label for="workplace_k_3_label"
                                            class="col-lg-4 col-md-12 col-form-label">Apakah pekerja berwenang
                                            melakukan Kerja di ruang terbatas ?
                                        </label>
                                        <div class="col-lg-8 col-md-12">
                                            <div class="wrapper_workplace_k_3 d-flex flex-column gap-3"
                                                x-data="{ workplace_k_3_value: @entangle('workplace_k_3_value') }">
                                                <x-inputs.select2 wire:model="workplace_k_3_value"
                                                    id="workplace_k_3_value" class="form-select"
                                                    placeholder="Pemenuhan">
                                                    <option value="Ya">Ya</option>
                                                    <option value="Tidak">Tidak</option>
                                                    <option value="N/A">N/A</option>
                                                </x-inputs.select2>
                                                <div x-cloak
                                                    x-show="workplace_k_3_value === 'Tidak' || workplace_k_3_value === '5' ">
                                                    <div>
                                                        <x-kplh-texteditor wire:model="workplace_k_3_note"
                                                            id="workplace_k_3_note" placeholder="Keterangan"
                                                            :error="'workplace_k_3_note'" />
                                                    </div>
                                                    <div class="mt-3">
                                                        <x-kplh-file wire:model="workplace_k_3_file"
                                                            id="workplace_k_3_file" placeholder="Upload foto temuan"
                                                            :error="'workplace_k_3_file'" />
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div><!-- /.form-group workplace_k_3 -->

                                    <div class="row form-group mb-4">
                                        <label for="workplace_k_4_label"
                                            class="col-lg-4 col-md-12 col-form-label">Apakah ruang kerja terbatas di
                                            tempat anda bekerja sudah dilengkapi dengan rambu yang memadai?
                                        </label>
                                        <div class="col-lg-8 col-md-12">
                                            <div class="wrapper_workplace_k_4 d-flex flex-column gap-3"
                                                x-data="{ workplace_k_4_value: @entangle('workplace_k_4_value') }">
                                                <x-inputs.select2 wire:model="workplace_k_4_value"
                                                    id="workplace_k_4_value" class="form-select"
                                                    placeholder="Pemenuhan">
                                                    <option value="Ya">Ya</option>
                                                    <option value="Tidak">Tidak</option>
                                                    <option value="N/A">N/A</option>
                                                </x-inputs.select2>
                                                <div x-cloak
                                                    x-show="workplace_k_4_value === 'Tidak' || workplace_k_4_value === '5' ">
                                                    <div>
                                                        <x-kplh-texteditor wire:model="workplace_k_4_note"
                                                            id="workplace_k_4_note" placeholder="Keterangan"
                                                            :error="'workplace_k_4_note'" />
                                                    </div>
                                                    <div class="mt-3">
                                                        <x-kplh-file wire:model="workplace_k_4_file"
                                                            id="workplace_k_4_file" placeholder="Upload foto temuan"
                                                            :error="'workplace_k_4_file'" />
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div><!-- /.form-group workplace_k_4 -->

                                    <div class="row form-group mb-4">
                                        <label for="workplace_k_5_label"
                                            class="col-lg-4 col-md-12 col-form-label">Apakah jalan akses masuk dan
                                            keluar Ruang Terbatas aman dan memadai?
                                        </label>
                                        <div class="col-lg-8 col-md-12">
                                            <div class="wrapper_workplace_k_5 d-flex flex-column gap-3"
                                                x-data="{ workplace_k_5_value: @entangle('workplace_k_5_value') }">
                                                <x-inputs.select2 wire:model="workplace_k_5_value"
                                                    id="workplace_k_5_value" class="form-select"
                                                    placeholder="Pemenuhan">
                                                    <option value="Ya">Ya</option>
                                                    <option value="Tidak">Tidak</option>
                                                    <option value="N/A">N/A</option>
                                                </x-inputs.select2>
                                                <div x-cloak
                                                    x-show="workplace_k_5_value === 'Tidak' || workplace_k_5_value === '5' ">
                                                    <div>
                                                        <x-kplh-texteditor wire:model="workplace_k_5_note"
                                                            id="workplace_k_5_note" placeholder="Keterangan"
                                                            :error="'workplace_k_5_note'" />
                                                    </div>
                                                    <div class="mt-3">
                                                        <x-kplh-file wire:model="workplace_k_5_file"
                                                            id="workplace_k_5_file" placeholder="Upload foto temuan"
                                                            :error="'workplace_k_5_file'" />
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div><!-- /.form-group workplace_k_5 -->

                                    <div class="row form-group mb-4">
                                        <label for="workplace_k_6_label"
                                            class="col-lg-4 col-md-12 col-form-label">Apakah sistem ventilasi memadai?
                                            Jika tidak diperlukan penambahan ventilasi buatan.
                                        </label>
                                        <div class="col-lg-8 col-md-12">
                                            <div class="wrapper_workplace_k_6 d-flex flex-column gap-3"
                                                x-data="{ workplace_k_6_value: @entangle('workplace_k_6_value') }">
                                                <x-inputs.select2 wire:model="workplace_k_6_value"
                                                    id="workplace_k_6_value" class="form-select"
                                                    placeholder="Pemenuhan">
                                                    <option value="Ya">Ya</option>
                                                    <option value="Tidak">Tidak</option>
                                                    <option value="N/A">N/A</option>
                                                </x-inputs.select2>
                                                <div x-cloak
                                                    x-show="workplace_k_6_value === 'Tidak' || workplace_k_6_value === '5' ">
                                                    <div>
                                                        <x-kplh-texteditor wire:model="workplace_k_6_note"
                                                            id="workplace_k_6_note" placeholder="Keterangan"
                                                            :error="'workplace_k_6_note'" />
                                                    </div>
                                                    <div class="mt-3">
                                                        <x-kplh-file wire:model="workplace_k_6_file"
                                                            id="workplace_k_6_file" placeholder="Upload foto temuan"
                                                            :error="'workplace_k_6_file'" />
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div><!-- /.form-group workplace_k_6 -->

                                    <div class="row form-group mb-4">
                                        <label for="workplace_k_7_label"
                                            class="col-lg-4 col-md-12 col-form-label">Apakah pencahayaan itu sudah
                                            mencukupi?
                                        </label>
                                        <div class="col-lg-8 col-md-12">
                                            <div class="wrapper_workplace_k_7 d-flex flex-column gap-3"
                                                x-data="{ workplace_k_7_value: @entangle('workplace_k_7_value') }">
                                                <x-inputs.select2 wire:model="workplace_k_7_value"
                                                    id="workplace_k_7_value" class="form-select"
                                                    placeholder="Pemenuhan">
                                                    <option value="Ya">Ya</option>
                                                    <option value="Tidak">Tidak</option>
                                                    <option value="N/A">N/A</option>
                                                </x-inputs.select2>
                                                <div x-cloak
                                                    x-show="workplace_k_7_value === 'Tidak' || workplace_k_7_value === '5' ">
                                                    <div>
                                                        <x-kplh-texteditor wire:model="workplace_k_7_note"
                                                            id="workplace_k_7_note" placeholder="Keterangan"
                                                            :error="'workplace_k_7_note'" />
                                                    </div>
                                                    <div class="mt-3">
                                                        <x-kplh-file wire:model="workplace_k_7_file"
                                                            id="workplace_k_7_file" placeholder="Upload foto temuan"
                                                            :error="'workplace_k_7_file'" />
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div><!-- /.form-group workplace_k_7 -->

                                    <div class="row form-group mb-4">
                                        <label for="workplace_k_8_label"
                                            class="col-lg-4 col-md-12 col-form-label">Jika diperlukan ada penerangan
                                            tambahan, telah dilakukan analisa risiko dan pengendalian yang memadai?
                                        </label>
                                        <div class="col-lg-8 col-md-12">
                                            <div class="wrapper_workplace_k_8 d-flex flex-column gap-3"
                                                x-data="{ workplace_k_8_value: @entangle('workplace_k_8_value') }">
                                                <x-inputs.select2 wire:model="workplace_k_8_value"
                                                    id="workplace_k_8_value" class="form-select"
                                                    placeholder="Pemenuhan">
                                                    <option value="Ya">Ya</option>
                                                    <option value="Tidak">Tidak</option>
                                                    <option value="N/A">N/A</option>
                                                </x-inputs.select2>
                                                <div x-cloak
                                                    x-show="workplace_k_8_value === 'Tidak' || workplace_k_8_value === '5' ">
                                                    <div>
                                                        <x-kplh-texteditor wire:model="workplace_k_8_note"
                                                            id="workplace_k_8_note" placeholder="Keterangan"
                                                            :error="'workplace_k_8_note'" />
                                                    </div>
                                                    <div class="mt-3">
                                                        <x-kplh-file wire:model="workplace_k_8_file"
                                                            id="workplace_k_8_file" placeholder="Upload foto temuan"
                                                            :error="'workplace_k_8_file'" />
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div><!-- /.form-group workplace_k_8 -->

                                    <div class="row form-group mb-4">
                                        <label for="workplace_k_9_label"
                                            class="col-lg-4 col-md-12 col-form-label">Apakah menggunakan peralatan
                                            kerja dan APD yang sesuai?
                                        </label>
                                        <div class="col-lg-8 col-md-12">
                                            <div class="wrapper_workplace_k_9 d-flex flex-column gap-3"
                                                x-data="{ workplace_k_9_value: @entangle('workplace_k_9_value') }">
                                                <x-inputs.select2 wire:model="workplace_k_9_value"
                                                    id="workplace_k_9_value" class="form-select"
                                                    placeholder="Pemenuhan">
                                                    <option value="Ya">Ya</option>
                                                    <option value="Tidak">Tidak</option>
                                                    <option value="N/A">N/A</option>
                                                </x-inputs.select2>
                                                <div x-cloak
                                                    x-show="workplace_k_9_value === 'Tidak' || workplace_k_9_value === '5' ">
                                                    <div>
                                                        <x-kplh-texteditor wire:model="workplace_k_9_note"
                                                            id="workplace_k_9_note" placeholder="Keterangan"
                                                            :error="'workplace_k_9_note'" />
                                                    </div>
                                                    <div class="mt-3">
                                                        <x-kplh-file wire:model="workplace_k_9_file"
                                                            id="workplace_k_9_file" placeholder="Upload foto temuan"
                                                            :error="'workplace_k_9_file'" />
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div><!-- /.form-group workplace_k_9 -->

                                    <div class="row form-group mb-4">
                                        <label for="workplace_k_10_label"
                                            class="col-lg-4 col-md-12 col-form-label">Apakah ada karyawan yang selalu
                                            standby di luar Ruang Kerja Terbatas?
                                        </label>
                                        <div class="col-lg-8 col-md-12">
                                            <div class="wrapper_workplace_k_10 d-flex flex-column gap-3"
                                                x-data="{ workplace_k_10_value: @entangle('workplace_k_10_value') }">
                                                <x-inputs.select2 wire:model="workplace_k_10_value"
                                                    id="workplace_k_10_value" class="form-select"
                                                    placeholder="Pemenuhan">
                                                    <option value="Ya">Ya</option>
                                                    <option value="Tidak">Tidak</option>
                                                    <option value="N/A">N/A</option>
                                                </x-inputs.select2>
                                                <div x-cloak
                                                    x-show="workplace_k_10_value === 'Tidak' || workplace_k_10_value === '5' ">
                                                    <div>
                                                        <x-kplh-texteditor wire:model="workplace_k_10_note"
                                                            id="workplace_k_10_note" placeholder="Keterangan"
                                                            :error="'workplace_k_10_note'" />
                                                    </div>
                                                    <div class="mt-3">
                                                        <x-kplh-file wire:model="workplace_k_10_file"
                                                            id="workplace_k_10_file"
                                                            placeholder="Upload foto temuan" :error="'workplace_k_10_file'" />
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div><!-- /.form-group workplace_k_10 -->

                                    <div class="row form-group mb-4">
                                        <label for="workplace_k_11_label"
                                            class="col-lg-4 col-md-12 col-form-label">Peralatan rescue Ruang terbatas
                                            tersedia?
                                        </label>
                                        <div class="col-lg-8 col-md-12">
                                            <div class="wrapper_workplace_k_11 d-flex flex-column gap-3"
                                                x-data="{ workplace_k_11_value: @entangle('workplace_k_11_value') }">
                                                <x-inputs.select2 wire:model="workplace_k_11_value"
                                                    id="workplace_k_11_value" class="form-select"
                                                    placeholder="Pemenuhan">
                                                    <option value="Ya">Ya</option>
                                                    <option value="Tidak">Tidak</option>
                                                    <option value="N/A">N/A</option>
                                                </x-inputs.select2>
                                                <div x-cloak
                                                    x-show="workplace_k_11_value === 'Tidak' || workplace_k_11_value === '5' ">
                                                    <div>
                                                        <x-kplh-texteditor wire:model="workplace_k_11_note"
                                                            id="workplace_k_11_note" placeholder="Keterangan"
                                                            :error="'workplace_k_11_note'" />
                                                    </div>
                                                    <div class="mt-3">
                                                        <x-kplh-file wire:model="workplace_k_11_file"
                                                            id="workplace_k_11_file"
                                                            placeholder="Upload foto temuan" :error="'workplace_k_11_file'" />
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div><!-- /.form-group workplace_k_11 -->

                                    <div class="row form-group mb-4">
                                        <label for="workplace_k_12_label"
                                            class="col-lg-4 col-md-12 col-form-label">Rescuer telah memahami tindakan
                                            atau tehnik penyelamatan dari kecelakaan di Ruang Kerja Terbatas tersebut?
                                        </label>
                                        <div class="col-lg-8 col-md-12">
                                            <div class="wrapper_workplace_k_12 d-flex flex-column gap-3"
                                                x-data="{ workplace_k_12_value: @entangle('workplace_k_12_value') }">
                                                <x-inputs.select2 wire:model="workplace_k_12_value"
                                                    id="workplace_k_12_value" class="form-select"
                                                    placeholder="Pemenuhan">
                                                    <option value="Ya">Ya</option>
                                                    <option value="Tidak">Tidak</option>
                                                    <option value="N/A">N/A</option>
                                                </x-inputs.select2>
                                                <div x-cloak
                                                    x-show="workplace_k_12_value === 'Tidak' || workplace_k_12_value === '5' ">
                                                    <div>
                                                        <x-kplh-texteditor wire:model="workplace_k_12_note"
                                                            id="workplace_k_12_note" placeholder="Keterangan"
                                                            :error="'workplace_k_12_note'" />
                                                    </div>
                                                    <div class="mt-3">
                                                        <x-kplh-file wire:model="workplace_k_12_file"
                                                            id="workplace_k_12_file"
                                                            placeholder="Upload foto temuan" :error="'workplace_k_12_file'" />
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div><!-- /.form-group workplace_k_12 -->

                                </div><!-- ./content-workplace_k -->

                            </div>
                        </div><!-- /.workplace_k -->

                        <div id="workplace_l" class="section-workplace_l" x-data="{ accordionOpen: false }">
                            <button
                                class="header-accordion d-flex justify-content-between w-100 border-0 bg-white py-3 px-0"
                                @click.prevent="accordionOpen = ! accordionOpen">
                                <h6 class="mb-0 fw-normal title-accordion">L. PROSEDUR ISOLASI (ISOLATION PROCEDURE)
                                </h6>
                                <span x-bind:class="accordionOpen ? 'open' : ''"><img
                                        src="{{ asset('/images/icons/angle-down.png') }}" alt="" /></span>
                            </button>
                            <div class="wrapper-content-accordion max-h-0 overflow-hidden position-relative transition-all duration-700"
                                x-ref="workplace_l" x-bind:style="accordionOpen ? 'max-height: ' + 20000 + 'px' : ''"
                                x-transition.delay.5000ms>

                                <div class="content-section p-4" wire:ignore.self>

                                    <div class="row form-group mb-4">
                                        <label for="workplace_l_1_label"
                                            class="col-lg-4 col-md-12 col-form-label">Apakah ijin kerja isolasi telah
                                            diperoleh?
                                        </label>
                                        <div class="col-lg-8 col-md-12">
                                            <div class="wrapper_workplace_l_1 d-flex flex-column gap-3"
                                                x-data="{ workplace_l_1_value: @entangle('workplace_l_1_value') }">
                                                <x-inputs.select2 wire:model="workplace_l_1_value"
                                                    id="workplace_l_1_value" class="form-select"
                                                    placeholder="Pemenuhan">
                                                    <option value="Ya">Ya</option>
                                                    <option value="Tidak">Tidak</option>
                                                    <option value="N/A">N/A</option>
                                                </x-inputs.select2>

                                                <div x-cloak
                                                    x-show="workplace_l_1_value === 'Tidak' || workplace_l_1_value === '5' ">
                                                    <div>
                                                        <x-kplh-texteditor wire:model="workplace_l_1_note"
                                                            id="workplace_l_1_note" placeholder="Keterangan"
                                                            :error="'workplace_l_1_note'" />
                                                    </div>
                                                    <div class="mt-3">
                                                        <x-kplh-file wire:model="workplace_l_1_file"
                                                            id="workplace_l_1_file" placeholder="Upload foto temuan"
                                                            :error="'workplace_l_1_file'" />
                                                    </div>
                                                </div>

                                            </div>
                                        </div>
                                    </div><!-- /.form-group workplace_l_1 -->

                                    <div class="row form-group mb-4">
                                        <label for="workplace_l_2_label"
                                            class="col-lg-4 col-md-12 col-form-label">Apakah MCC atau lokal switch
                                            telah dipasangkan gembok (Isolasi Lock) dan Tanda Bahaya Pribadi (Isolasi
                                            Tag), sebelum pekerjaan dimulai?
                                        </label>
                                        <div class="col-lg-8 col-md-12">
                                            <div class="wrapper_workplace_l_2 d-flex flex-column gap-3"
                                                x-data="{ workplace_l_2_value: @entangle('workplace_l_2_value') }">
                                                <x-inputs.select2 wire:model="workplace_l_2_value"
                                                    id="workplace_l_2_value" class="form-select"
                                                    placeholder="Pemenuhan">
                                                    <option value="Ya">Ya</option>
                                                    <option value="Tidak">Tidak</option>
                                                    <option value="N/A">N/A</option>
                                                </x-inputs.select2>
                                                <div x-cloak
                                                    x-show="workplace_l_2_value === 'Tidak' || workplace_l_2_value === '5' ">
                                                    <div>
                                                        <x-kplh-texteditor wire:model="workplace_l_2_note"
                                                            id="workplace_l_2_note" placeholder="Keterangan"
                                                            :error="'workplace_l_2_note'" />
                                                    </div>
                                                    <div class="mt-3">
                                                        <x-kplh-file wire:model="workplace_l_2_file"
                                                            id="workplace_l_2_file" placeholder="Upload foto temuan"
                                                            :error="'workplace_l_2_file'" />
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div><!-- /.form-group workplace_l_2 -->

                                    <div class="row form-group mb-4">
                                        <label for="workplace_l_3_label"
                                            class="col-lg-4 col-md-12 col-form-label">Apakah penanggung jawab
                                            pekerjaan atau team leader telah juga memasangkan gemboknya, sebelum
                                            pekerjaan dimulai?
                                        </label>
                                        <div class="col-lg-8 col-md-12">
                                            <div class="wrapper_workplace_l_3 d-flex flex-column gap-3"
                                                x-data="{ workplace_l_3_value: @entangle('workplace_l_3_value') }">
                                                <x-inputs.select2 wire:model="workplace_l_3_value"
                                                    id="workplace_l_3_value" class="form-select"
                                                    placeholder="Pemenuhan">
                                                    <option value="Ya">Ya</option>
                                                    <option value="Tidak">Tidak</option>
                                                    <option value="N/A">N/A</option>
                                                </x-inputs.select2>
                                                <div x-cloak
                                                    x-show="workplace_l_3_value === 'Tidak' || workplace_l_3_value === '5' ">
                                                    <div>
                                                        <x-kplh-texteditor wire:model="workplace_l_3_note"
                                                            id="workplace_l_3_note" placeholder="Keterangan"
                                                            :error="'workplace_l_3_note'" />
                                                    </div>
                                                    <div class="mt-3">
                                                        <x-kplh-file wire:model="workplace_l_3_file"
                                                            id="workplace_l_3_file" placeholder="Upload foto temuan"
                                                            :error="'workplace_l_3_file'" />
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div><!-- /.form-group workplace_l_3 -->

                                    <div class="row form-group mb-4">
                                        <label for="workplace_l_4_label"
                                            class="col-lg-4 col-md-12 col-form-label">Apakah ruang kerja tertutup
                                            tempat anda bekerja sudah dilengkapi dengan “Lock Box” (kotak gembok)? Dan
                                            papan informasi? Apakah dapat diketahui jumlah karyawan yang masuk ke dalam?
                                        </label>
                                        <div class="col-lg-8 col-md-12">
                                            <div class="wrapper_workplace_l_4 d-flex flex-column gap-3"
                                                x-data="{ workplace_l_4_value: @entangle('workplace_l_4_value') }">
                                                <x-inputs.select2 wire:model="workplace_l_4_value"
                                                    id="workplace_l_4_value" class="form-select"
                                                    placeholder="Pemenuhan">
                                                    <option value="Ya">Ya</option>
                                                    <option value="Tidak">Tidak</option>
                                                    <option value="N/A">N/A</option>
                                                </x-inputs.select2>
                                                <div x-cloak
                                                    x-show="workplace_l_4_value === 'Tidak' || workplace_l_4_value === '5' ">
                                                    <div>
                                                        <x-kplh-texteditor wire:model="workplace_l_4_note"
                                                            id="workplace_l_4_note" placeholder="Keterangan"
                                                            :error="'workplace_l_4_note'" />
                                                    </div>
                                                    <div class="mt-3">
                                                        <x-kplh-file wire:model="workplace_l_4_file"
                                                            id="workplace_l_4_file" placeholder="Upload foto temuan"
                                                            :error="'workplace_l_4_file'" />
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div><!-- /.form-group workplace_l_4 -->

                                    <div class="row form-group mb-4">
                                        <label for="workplace_l_5_label"
                                            class="col-lg-4 col-md-12 col-form-label">Apakah MCC dan “Push Button”
                                            untuk ruang kerja terbatas tempat di mana anda bekerja sudah terdapat
                                            faslitas untuk memasang gembok?
                                        </label>
                                        <div class="col-lg-8 col-md-12">
                                            <div class="wrapper_workplace_l_5 d-flex flex-column gap-3"
                                                x-data="{ workplace_l_5_value: @entangle('workplace_l_5_value') }">
                                                <x-inputs.select2 wire:model="workplace_l_5_value"
                                                    id="workplace_l_5_value" class="form-select"
                                                    placeholder="Pemenuhan">
                                                    <option value="Ya">Ya</option>
                                                    <option value="Tidak">Tidak</option>
                                                    <option value="N/A">N/A</option>
                                                </x-inputs.select2>
                                                <div x-cloak
                                                    x-show="workplace_l_5_value === 'Tidak' || workplace_l_5_value === '5' ">
                                                    <div>
                                                        <x-kplh-texteditor wire:model="workplace_l_5_note"
                                                            id="workplace_l_5_note" placeholder="Keterangan"
                                                            :error="'workplace_l_5_note'" />
                                                    </div>
                                                    <div class="mt-3">
                                                        <x-kplh-file wire:model="workplace_l_5_file"
                                                            id="workplace_l_5_file" placeholder="Upload foto temuan"
                                                            :error="'workplace_l_5_file'" />
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div><!-- /.form-group workplace_l_5 -->

                                    <div class="row form-group mb-4">
                                        <label for="workplace_l_6_label"
                                            class="col-lg-4 col-md-12 col-form-label">Apakah sistem penguncian dan
                                            Tanda Bahaya Pribadi telah terpasang dengan benar?
                                        </label>
                                        <div class="col-lg-8 col-md-12">
                                            <div class="wrapper_workplace_l_6 d-flex flex-column gap-3"
                                                x-data="{ workplace_l_6_value: @entangle('workplace_l_6_value') }">
                                                <x-inputs.select2 wire:model="workplace_l_6_value"
                                                    id="workplace_l_6_value" class="form-select"
                                                    placeholder="Pemenuhan">
                                                    <option value="Ya">Ya</option>
                                                    <option value="Tidak">Tidak</option>
                                                    <option value="N/A">N/A</option>
                                                </x-inputs.select2>
                                                <div x-cloak
                                                    x-show="workplace_l_6_value === 'Tidak' || workplace_l_6_value === '5' ">
                                                    <div>
                                                        <x-kplh-texteditor wire:model="workplace_l_6_note"
                                                            id="workplace_l_6_note" placeholder="Keterangan"
                                                            :error="'workplace_l_6_note'" />
                                                    </div>
                                                    <div class="mt-3">
                                                        <x-kplh-file wire:model="workplace_l_6_file"
                                                            id="workplace_l_6_file" placeholder="Upload foto temuan"
                                                            :error="'workplace_l_6_file'" />
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div><!-- /.form-group workplace_l_6 -->

                                    <div class="row form-group mb-4">
                                        <label for="workplace_l_7_label"
                                            class="col-lg-4 col-md-12 col-form-label">Prosedur isolasi (LOTO)
                                            diimplementasikan dengan benar?
                                        </label>
                                        <div class="col-lg-8 col-md-12">
                                            <div class="wrapper_workplace_l_7 d-flex flex-column gap-3"
                                                x-data="{ workplace_l_7_value: @entangle('workplace_l_7_value') }">
                                                <x-inputs.select2 wire:model="workplace_l_7_value"
                                                    id="workplace_l_7_value" class="form-select"
                                                    placeholder="Pemenuhan">
                                                    <option value="Ya">Ya</option>
                                                    <option value="Tidak">Tidak</option>
                                                    <option value="N/A">N/A</option>
                                                </x-inputs.select2>
                                                <div x-cloak
                                                    x-show="workplace_l_7_value === 'Tidak' || workplace_l_7_value === '5' ">
                                                    <div>
                                                        <x-kplh-texteditor wire:model="workplace_l_7_note"
                                                            id="workplace_l_7_note" placeholder="Keterangan"
                                                            :error="'workplace_l_7_note'" />
                                                    </div>
                                                    <div class="mt-3">
                                                        <x-kplh-file wire:model="workplace_l_7_file"
                                                            id="workplace_l_7_file" placeholder="Upload foto temuan"
                                                            :error="'workplace_l_7_file'" />
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div><!-- /.form-group workplace_l_7 -->

                                    <div class="row form-group mb-4">
                                        <label for="workplace_l_8_label"
                                            class="col-lg-4 col-md-12 col-form-label">Apakah karyawan melakukan
                                            pemeriksaan terhadap mesin (memastikan bahwa mesin telah mati dan
                                            terisolasi) sebelum melakukan pekerjaan?
                                        </label>
                                        <div class="col-lg-8 col-md-12">
                                            <div class="wrapper_workplace_l_8 d-flex flex-column gap-3"
                                                x-data="{ workplace_l_8_value: @entangle('workplace_l_8_value') }">
                                                <x-inputs.select2 wire:model="workplace_l_8_value"
                                                    id="workplace_l_8_value" class="form-select"
                                                    placeholder="Pemenuhan">
                                                    <option value="Ya">Ya</option>
                                                    <option value="Tidak">Tidak</option>
                                                    <option value="N/A">N/A</option>
                                                </x-inputs.select2>
                                                <div x-cloak
                                                    x-show="workplace_l_8_value === 'Tidak' || workplace_l_8_value === '5' ">
                                                    <div>
                                                        <x-kplh-texteditor wire:model="workplace_l_8_note"
                                                            id="workplace_l_8_note" placeholder="Keterangan"
                                                            :error="'workplace_l_8_note'" />
                                                    </div>
                                                    <div class="mt-3">
                                                        <x-kplh-file wire:model="workplace_l_8_file"
                                                            id="workplace_l_8_file" placeholder="Upload foto temuan"
                                                            :error="'workplace_l_8_file'" />
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div><!-- /.form-group workplace_l_8 -->

                                    <div class="row form-group mb-4">
                                        <label for="workplace_l_9_label"
                                            class="col-lg-4 col-md-12 col-form-label">Apakah karyawan mengetahui
                                            tombol gawat darurat pada mesin (bila ada)?
                                        </label>
                                        <div class="col-lg-8 col-md-12">
                                            <div class="wrapper_workplace_l_9 d-flex flex-column gap-3"
                                                x-data="{ workplace_l_9_value: @entangle('workplace_l_9_value') }">
                                                <x-inputs.select2 wire:model="workplace_l_9_value"
                                                    id="workplace_l_9_value" class="form-select"
                                                    placeholder="Pemenuhan">
                                                    <option value="Ya">Ya</option>
                                                    <option value="Tidak">Tidak</option>
                                                    <option value="N/A">N/A</option>
                                                </x-inputs.select2>
                                                <div x-cloak
                                                    x-show="workplace_l_9_value === 'Tidak' || workplace_l_9_value === '5' ">
                                                    <div>
                                                        <x-kplh-texteditor wire:model="workplace_l_9_note"
                                                            id="workplace_l_9_note" placeholder="Keterangan"
                                                            :error="'workplace_l_9_note'" />
                                                    </div>
                                                    <div class="mt-3">
                                                        <x-kplh-file wire:model="workplace_l_9_file"
                                                            id="workplace_l_9_file" placeholder="Upload foto temuan"
                                                            :error="'workplace_l_9_file'" />
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div><!-- /.form-group workplace_l_9 -->

                                    <div class="row form-group mb-4">
                                        <label for="workplace_l_10_label"
                                            class="col-lg-4 col-md-12 col-form-label">Apakah karyawan menginformasikan
                                            pekerjaan yang selesai kepada penanggung jawab pekerjaan?
                                        </label>
                                        <div class="col-lg-8 col-md-12">
                                            <div class="wrapper_workplace_l_10 d-flex flex-column gap-3"
                                                x-data="{ workplace_l_10_value: @entangle('workplace_l_10_value') }">
                                                <x-inputs.select2 wire:model="workplace_l_10_value"
                                                    id="workplace_l_10_value" class="form-select"
                                                    placeholder="Pemenuhan">
                                                    <option value="Ya">Ya</option>
                                                    <option value="Tidak">Tidak</option>
                                                    <option value="N/A">N/A</option>
                                                </x-inputs.select2>
                                                <div x-cloak
                                                    x-show="workplace_l_10_value === 'Tidak' || workplace_l_10_value === '5' ">
                                                    <div>
                                                        <x-kplh-texteditor wire:model="workplace_l_10_note"
                                                            id="workplace_l_10_note" placeholder="Keterangan"
                                                            :error="'workplace_l_10_note'" />
                                                    </div>
                                                    <div class="mt-3">
                                                        <x-kplh-file wire:model="workplace_l_10_file"
                                                            id="workplace_l_10_file"
                                                            placeholder="Upload foto temuan" :error="'workplace_l_10_file'" />
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div><!-- /.form-group workplace_l_10 -->

                                    <div class="row form-group mb-4">
                                        <label for="workplace_l_11_label"
                                            class="col-lg-4 col-md-12 col-form-label">Apakah karyawan memasang kembali
                                            pengaman mesin setelah pekerjaan selesai?
                                        </label>
                                        <div class="col-lg-8 col-md-12">
                                            <div class="wrapper_workplace_l_11 d-flex flex-column gap-3"
                                                x-data="{ workplace_l_11_value: @entangle('workplace_l_11_value') }">
                                                <x-inputs.select2 wire:model="workplace_l_11_value"
                                                    id="workplace_l_11_value" class="form-select"
                                                    placeholder="Pemenuhan">
                                                    <option value="Ya">Ya</option>
                                                    <option value="Tidak">Tidak</option>
                                                    <option value="N/A">N/A</option>
                                                </x-inputs.select2>
                                                <div x-cloak
                                                    x-show="workplace_l_11_value === 'Tidak' || workplace_l_11_value === '5' ">
                                                    <div>
                                                        <x-kplh-texteditor wire:model="workplace_l_11_note"
                                                            id="workplace_l_11_note" placeholder="Keterangan"
                                                            :error="'workplace_l_11_note'" />
                                                    </div>
                                                    <div class="mt-3">
                                                        <x-kplh-file wire:model="workplace_l_11_file"
                                                            id="workplace_l_11_file"
                                                            placeholder="Upload foto temuan" :error="'workplace_l_11_file'" />
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div><!-- /.form-group workplace_l_11 -->

                                    <div class="row form-group mb-4">
                                        <label for="workplace_l_12_label"
                                            class="col-lg-4 col-md-12 col-form-label">Apakah hanya karyawan yang
                                            mamasang Isolasi Lock dan Isolasi Tag adalah yang hanya dapat melepaskannya?
                                        </label>
                                        <div class="col-lg-8 col-md-12">
                                            <div class="wrapper_workplace_l_12 d-flex flex-column gap-3"
                                                x-data="{ workplace_l_12_value: @entangle('workplace_l_12_value') }">
                                                <x-inputs.select2 wire:model="workplace_l_12_value"
                                                    id="workplace_l_12_value" class="form-select"
                                                    placeholder="Pemenuhan">
                                                    <option value="Ya">Ya</option>
                                                    <option value="Tidak">Tidak</option>
                                                    <option value="N/A">N/A</option>
                                                </x-inputs.select2>
                                                <div x-cloak
                                                    x-show="workplace_l_12_value === 'Tidak' || workplace_l_12_value === '5' ">
                                                    <div>
                                                        <x-kplh-texteditor wire:model="workplace_l_12_note"
                                                            id="workplace_l_12_note" placeholder="Keterangan"
                                                            :error="'workplace_l_12_note'" />
                                                    </div>
                                                    <div class="mt-3">
                                                        <x-kplh-file wire:model="workplace_l_12_file"
                                                            id="workplace_l_12_file"
                                                            placeholder="Upload foto temuan" :error="'workplace_l_12_file'" />
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div><!-- /.form-group workplace_l_12 -->

                                    <div class="row form-group mb-4">
                                        <label for="workplace_l_13_label"
                                            class="col-lg-4 col-md-12 col-form-label">Apakah penanggung jawab
                                            pekerjaan atau team leader telah memeriksa pekerjaan yang telah selesai,
                                            Isolasi Lock dan Isolasi Tag milik karyawan lain, sebelum melepas Isolasi
                                            Lock dan Isolasi Tag miliknya sendiri?
                                        </label>
                                        <div class="col-lg-8 col-md-12">
                                            <div class="wrapper_workplace_l_13 d-flex flex-column gap-3"
                                                x-data="{ workplace_l_13_value: @entangle('workplace_l_13_value') }">
                                                <x-inputs.select2 wire:model="workplace_l_13_value"
                                                    id="workplace_l_13_value" class="form-select"
                                                    placeholder="Pemenuhan">
                                                    <option value="Ya">Ya</option>
                                                    <option value="Tidak">Tidak</option>
                                                    <option value="N/A">N/A</option>
                                                </x-inputs.select2>
                                                <div x-cloak
                                                    x-show="workplace_l_13_value === 'Tidak' || workplace_l_13_value === '5' ">
                                                    <div>
                                                        <x-kplh-texteditor wire:model="workplace_l_13_note"
                                                            id="workplace_l_13_note" placeholder="Keterangan"
                                                            :error="'workplace_l_13_note'" />
                                                    </div>
                                                    <div class="mt-3">
                                                        <x-kplh-file wire:model="workplace_l_13_file"
                                                            id="workplace_l_13_file"
                                                            placeholder="Upload foto temuan" :error="'workplace_l_13_file'" />
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div><!-- /.form-group workplace_l_13 -->

                                </div><!-- ./content-workplace_l -->

                            </div>
                        </div><!-- /.workplace_l -->

                        <div id="workplace_m" class="section-workplace_m" x-data="{ accordionOpen: false }">
                            <button
                                class="header-accordion d-flex justify-content-between w-100 border-0 bg-white py-3 px-0"
                                @click.prevent="accordionOpen = ! accordionOpen">
                                <h6 class="mb-0 fw-normal title-accordion">M. BAGIAN KOMPONEN BERPUTAR (ROTATING PART)
                                </h6>
                                <span x-bind:class="accordionOpen ? 'open' : ''"><img
                                        src="{{ asset('/images/icons/angle-down.png') }}" alt="" /></span>
                            </button>
                            <div class="wrapper-content-accordion max-h-0 overflow-hidden position-relative transition-all duration-700"
                                x-ref="workplace_m" x-bind:style="accordionOpen ? 'max-height: ' + 20000 + 'px' : ''"
                                x-transition.delay.5000ms>

                                <div class="content-section p-4" wire:ignore.self>

                                    <div class="row form-group mb-4">
                                        <label for="workplace_m_1_label"
                                            class="col-lg-4 col-md-12 col-form-label">Apakah semua mesin atau bagian
                                            berputar telah terlindungi dengan guarding yang sesuai?
                                        </label>
                                        <div class="col-lg-8 col-md-12">
                                            <div class="wrapper_workplace_m_1 d-flex flex-column gap-3"
                                                x-data="{ workplace_m_1_value: @entangle('workplace_m_1_value') }">
                                                <x-inputs.select2 wire:model="workplace_m_1_value"
                                                    id="workplace_m_1_value" class="form-select"
                                                    placeholder="Pemenuhan">
                                                    <option value="Ya">Ya</option>
                                                    <option value="Tidak">Tidak</option>
                                                    <option value="N/A">N/A</option>
                                                </x-inputs.select2>

                                                <div x-cloak
                                                    x-show="workplace_m_1_value === 'Tidak' || workplace_m_1_value === '5' ">
                                                    <div>
                                                        <x-kplh-texteditor wire:model="workplace_m_1_note"
                                                            id="workplace_m_1_note" placeholder="Keterangan"
                                                            :error="'workplace_m_1_note'" />
                                                    </div>
                                                    <div class="mt-3">
                                                        <x-kplh-file wire:model="workplace_m_1_file"
                                                            id="workplace_m_1_file" placeholder="Upload foto temuan"
                                                            :error="'workplace_m_1_file'" />
                                                    </div>
                                                </div>

                                            </div>
                                        </div>
                                    </div><!-- /.form-group workplace_m_1 -->

                                    <div class="row form-group mb-4">
                                        <label for="workplace_m_2_label"
                                            class="col-lg-4 col-md-12 col-form-label">Karyawan TIDAK menggunakan
                                            ROMPI, baju kerja yang longgar, berambut panjang atau kalung yang berjuntai
                                            keluar dari baju?
                                        </label>
                                        <div class="col-lg-8 col-md-12">
                                            <div class="wrapper_workplace_m_2 d-flex flex-column gap-3"
                                                x-data="{ workplace_m_2_value: @entangle('workplace_m_2_value') }">
                                                <x-inputs.select2 wire:model="workplace_m_2_value"
                                                    id="workplace_m_2_value" class="form-select"
                                                    placeholder="Pemenuhan">
                                                    <option value="Ya">Ya</option>
                                                    <option value="Tidak">Tidak</option>
                                                    <option value="N/A">N/A</option>
                                                </x-inputs.select2>
                                                <div x-cloak
                                                    x-show="workplace_m_2_value === 'Tidak' || workplace_m_2_value === '5' ">
                                                    <div>
                                                        <x-kplh-texteditor wire:model="workplace_m_2_note"
                                                            id="workplace_m_2_note" placeholder="Keterangan"
                                                            :error="'workplace_m_2_note'" />
                                                    </div>
                                                    <div class="mt-3">
                                                        <x-kplh-file wire:model="workplace_m_2_file"
                                                            id="workplace_m_2_file" placeholder="Upload foto temuan"
                                                            :error="'workplace_m_2_file'" />
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div><!-- /.form-group workplace_m_2 -->

                                    <div class="row form-group mb-4">
                                        <label for="workplace_m_3_label"
                                            class="col-lg-4 col-md-12 col-form-label">Apakah terdapat rambu peringatan
                                            mengenai bahaya / resiko saat menggunakan mesin berputar?
                                        </label>
                                        <div class="col-lg-8 col-md-12">
                                            <div class="wrapper_workplace_m_3 d-flex flex-column gap-3"
                                                x-data="{ workplace_m_3_value: @entangle('workplace_m_3_value') }">
                                                <x-inputs.select2 wire:model="workplace_m_3_value"
                                                    id="workplace_m_3_value" class="form-select"
                                                    placeholder="Pemenuhan">
                                                    <option value="Ya">Ya</option>
                                                    <option value="Tidak">Tidak</option>
                                                    <option value="N/A">N/A</option>
                                                </x-inputs.select2>
                                                <div x-cloak
                                                    x-show="workplace_m_3_value === 'Tidak' || workplace_m_3_value === '5' ">
                                                    <div>
                                                        <x-kplh-texteditor wire:model="workplace_m_3_note"
                                                            id="workplace_m_3_note" placeholder="Keterangan"
                                                            :error="'workplace_m_3_note'" />
                                                    </div>
                                                    <div class="mt-3">
                                                        <x-kplh-file wire:model="workplace_m_3_file"
                                                            id="workplace_m_3_file" placeholder="Upload foto temuan"
                                                            :error="'workplace_m_3_file'" />
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div><!-- /.form-group workplace_m_3 -->

                                    <div class="row form-group mb-4">
                                        <label for="workplace_m_4_label"
                                            class="col-lg-4 col-md-12 col-form-label">Emergency line pada Conveyor
                                            baik di CHPP maupun Port dapat dilakukan pengetesan secara reguler dan di
                                            record
                                        </label>
                                        <div class="col-lg-8 col-md-12">
                                            <div class="wrapper_workplace_m_4 d-flex flex-column gap-3"
                                                x-data="{ workplace_m_4_value: @entangle('workplace_m_4_value') }">
                                                <x-inputs.select2 wire:model="workplace_m_4_value"
                                                    id="workplace_m_4_value" class="form-select"
                                                    placeholder="Pemenuhan">
                                                    <option value="Ya">Ya</option>
                                                    <option value="Tidak">Tidak</option>
                                                    <option value="N/A">N/A</option>
                                                </x-inputs.select2>
                                                <div x-cloak
                                                    x-show="workplace_m_4_value === 'Tidak' || workplace_m_4_value === '5' ">
                                                    <div>
                                                        <x-kplh-texteditor wire:model="workplace_m_4_note"
                                                            id="workplace_m_4_note" placeholder="Keterangan"
                                                            :error="'workplace_m_4_note'" />
                                                    </div>
                                                    <div class="mt-3">
                                                        <x-kplh-file wire:model="workplace_m_4_file"
                                                            id="workplace_m_4_file" placeholder="Upload foto temuan"
                                                            :error="'workplace_m_4_file'" />
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div><!-- /.form-group workplace_m_4 -->

                                </div><!-- ./content-workplace_m -->

                            </div>
                        </div><!-- /.workplace_m -->

                        <div id="workplace_n" class="section-workplace_n" x-data="{ accordionOpen: false }">
                            <button
                                class="header-accordion d-flex justify-content-between w-100 border-0 bg-white py-3 px-0"
                                @click.prevent="accordionOpen = ! accordionOpen">
                                <h6 class="mb-0 fw-normal title-accordion">N. GERINDA, PENGELASAN dan PEMOTONGAN
                                    (GRINDING, WELDING and CUTTING)</h6>
                                <span x-bind:class="accordionOpen ? 'open' : ''"><img
                                        src="{{ asset('/images/icons/angle-down.png') }}" alt="" /></span>
                            </button>
                            <div class="wrapper-content-accordion max-h-0 overflow-hidden position-relative transition-all duration-700"
                                x-ref="workplace_n" x-bind:style="accordionOpen ? 'max-height: ' + 20000 + 'px' : ''"
                                x-transition.delay.5000ms>

                                <div class="content-section p-4" wire:ignore.self>

                                    <div class="row form-group mb-4">
                                        <label for="workplace_n_1_label"
                                            class="col-lg-4 col-md-12 col-form-label">Apakah ijin kerja panas telah
                                            diperoleh, sebelum pekerjaan dimulai?
                                        </label>
                                        <div class="col-lg-8 col-md-12">
                                            <div class="wrapper_workplace_n_1 d-flex flex-column gap-3"
                                                x-data="{ workplace_n_1_value: @entangle('workplace_n_1_value') }">
                                                <x-inputs.select2 wire:model="workplace_n_1_value"
                                                    id="workplace_n_1_value" class="form-select"
                                                    placeholder="Pemenuhan">
                                                    <option value="Ya">Ya</option>
                                                    <option value="Tidak">Tidak</option>
                                                    <option value="N/A">N/A</option>
                                                </x-inputs.select2>

                                                <div x-cloak
                                                    x-show="workplace_n_1_value === 'Tidak' || workplace_n_1_value === '5' ">
                                                    <div>
                                                        <x-kplh-texteditor wire:model="workplace_n_1_note"
                                                            id="workplace_n_1_note" placeholder="Keterangan"
                                                            :error="'workplace_n_1_note'" />
                                                    </div>
                                                    <div class="mt-3">
                                                        <x-kplh-file wire:model="workplace_n_1_file"
                                                            id="workplace_n_1_file" placeholder="Upload foto temuan"
                                                            :error="'workplace_n_1_file'" />
                                                    </div>
                                                </div>

                                            </div>
                                        </div>
                                    </div><!-- /.form-group workplace_n_1 -->

                                    <div class="row form-group mb-4">
                                        <label for="workplace_n_2_label"
                                            class="col-lg-4 col-md-12 col-form-label">Apakah karyawan menggunakan APD
                                            yang sesuai dengan pekerjaan panas (gerinda, pengelasan atau pemotongan)?
                                        </label>
                                        <div class="col-lg-8 col-md-12">
                                            <div class="wrapper_workplace_n_2 d-flex flex-column gap-3"
                                                x-data="{ workplace_n_2_value: @entangle('workplace_n_2_value') }">
                                                <x-inputs.select2 wire:model="workplace_n_2_value"
                                                    id="workplace_n_2_value" class="form-select"
                                                    placeholder="Pemenuhan">
                                                    <option value="Ya">Ya</option>
                                                    <option value="Tidak">Tidak</option>
                                                    <option value="N/A">N/A</option>
                                                </x-inputs.select2>
                                                <div x-cloak
                                                    x-show="workplace_n_2_value === 'Tidak' || workplace_n_2_value === '5' ">
                                                    <div>
                                                        <x-kplh-texteditor wire:model="workplace_n_2_note"
                                                            id="workplace_n_2_note" placeholder="Keterangan"
                                                            :error="'workplace_n_2_note'" />
                                                    </div>
                                                    <div class="mt-3">
                                                        <x-kplh-file wire:model="workplace_n_2_file"
                                                            id="workplace_n_2_file" placeholder="Upload foto temuan"
                                                            :error="'workplace_n_2_file'" />
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div><!-- /.form-group workplace_n_2 -->

                                    <div class="row form-group mb-4">
                                        <label for="workplace_n_3_label"
                                            class="col-lg-4 col-md-12 col-form-label">Apakah terdapat jarak yang aman
                                            antara lokasi pekerjaan panas dengan bahan-bahan yang dapat/mudah terbakar?
                                        </label>
                                        <div class="col-lg-8 col-md-12">
                                            <div class="wrapper_workplace_n_3 d-flex flex-column gap-3"
                                                x-data="{ workplace_n_3_value: @entangle('workplace_n_3_value') }">
                                                <x-inputs.select2 wire:model="workplace_n_3_value"
                                                    id="workplace_n_3_value" class="form-select"
                                                    placeholder="Pemenuhan">
                                                    <option value="Ya">Ya</option>
                                                    <option value="Tidak">Tidak</option>
                                                    <option value="N/A">N/A</option>
                                                </x-inputs.select2>
                                                <div x-cloak
                                                    x-show="workplace_n_3_value === 'Tidak' || workplace_n_3_value === '5' ">
                                                    <div>
                                                        <x-kplh-texteditor wire:model="workplace_n_3_note"
                                                            id="workplace_n_3_note" placeholder="Keterangan"
                                                            :error="'workplace_n_3_note'" />
                                                    </div>
                                                    <div class="mt-3">
                                                        <x-kplh-file wire:model="workplace_n_3_file"
                                                            id="workplace_n_3_file" placeholder="Upload foto temuan"
                                                            :error="'workplace_n_3_file'" />
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div><!-- /.form-group workplace_n_3 -->

                                    <div class="row form-group mb-4">
                                        <label for="workplace_n_4_label"
                                            class="col-lg-4 col-md-12 col-form-label">Apakah batu gerinda yang
                                            dipasang memiliki RPM yang sama atau kurang dari RPM mesin gerinda?
                                        </label>
                                        <div class="col-lg-8 col-md-12">
                                            <div class="wrapper_workplace_n_4 d-flex flex-column gap-3"
                                                x-data="{ workplace_n_4_value: @entangle('workplace_n_4_value') }">
                                                <x-inputs.select2 wire:model="workplace_n_4_value"
                                                    id="workplace_n_4_value" class="form-select"
                                                    placeholder="Pemenuhan">
                                                    <option value="Ya">Ya</option>
                                                    <option value="Tidak">Tidak</option>
                                                    <option value="N/A">N/A</option>
                                                </x-inputs.select2>
                                                <div x-cloak
                                                    x-show="workplace_n_4_value === 'Tidak' || workplace_n_4_value === '5' ">
                                                    <div>
                                                        <x-kplh-texteditor wire:model="workplace_n_4_note"
                                                            id="workplace_n_4_note" placeholder="Keterangan"
                                                            :error="'workplace_n_4_note'" />
                                                    </div>
                                                    <div class="mt-3">
                                                        <x-kplh-file wire:model="workplace_n_4_file"
                                                            id="workplace_n_4_file" placeholder="Upload foto temuan"
                                                            :error="'workplace_n_4_file'" />
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div><!-- /.form-group workplace_n_4 -->

                                    <div class="row form-group mb-4">
                                        <label for="workplace_n_5_label"
                                            class="col-lg-4 col-md-12 col-form-label">Apakah karyawan menggunakan
                                            jenis batu gerinda yang sesuai dengan pekerjaannya?
                                        </label>
                                        <div class="col-lg-8 col-md-12">
                                            <div class="wrapper_workplace_n_5 d-flex flex-column gap-3"
                                                x-data="{ workplace_n_5_value: @entangle('workplace_n_5_value') }">
                                                <x-inputs.select2 wire:model="workplace_n_5_value"
                                                    id="workplace_n_5_value" class="form-select"
                                                    placeholder="Pemenuhan">
                                                    <option value="Ya">Ya</option>
                                                    <option value="Tidak">Tidak</option>
                                                    <option value="N/A">N/A</option>
                                                </x-inputs.select2>
                                                <div x-cloak
                                                    x-show="workplace_n_5_value === 'Tidak' || workplace_n_5_value === '5' ">
                                                    <div>
                                                        <x-kplh-texteditor wire:model="workplace_n_5_note"
                                                            id="workplace_n_5_note" placeholder="Keterangan"
                                                            :error="'workplace_n_5_note'" />
                                                    </div>
                                                    <div class="mt-3">
                                                        <x-kplh-file wire:model="workplace_n_5_file"
                                                            id="workplace_n_5_file" placeholder="Upload foto temuan"
                                                            :error="'workplace_n_5_file'" />
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div><!-- /.form-group workplace_n_5 -->

                                    <div class="row form-group mb-4">
                                        <label for="workplace_n_6_label"
                                            class="col-lg-4 col-md-12 col-form-label">Apakah pelindung pada mesin
                                            gerinda terpasang dengan benar?
                                        </label>
                                        <div class="col-lg-8 col-md-12">
                                            <div class="wrapper_workplace_n_6 d-flex flex-column gap-3"
                                                x-data="{ workplace_n_6_value: @entangle('workplace_n_6_value') }">
                                                <x-inputs.select2 wire:model="workplace_n_6_value"
                                                    id="workplace_n_6_value" class="form-select"
                                                    placeholder="Pemenuhan">
                                                    <option value="Ya">Ya</option>
                                                    <option value="Tidak">Tidak</option>
                                                    <option value="N/A">N/A</option>
                                                </x-inputs.select2>
                                                <div x-cloak
                                                    x-show="workplace_n_6_value === 'Tidak' || workplace_n_6_value === '5' ">
                                                    <div>
                                                        <x-kplh-texteditor wire:model="workplace_n_6_note"
                                                            id="workplace_n_6_note" placeholder="Keterangan"
                                                            :error="'workplace_n_6_note'" />
                                                    </div>
                                                    <div class="mt-3">
                                                        <x-kplh-file wire:model="workplace_n_6_file"
                                                            id="workplace_n_6_file" placeholder="Upload foto temuan"
                                                            :error="'workplace_n_6_file'" />
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div><!-- /.form-group workplace_n_6 -->

                                    <div class="row form-group mb-4">
                                        <label for="workplace_n_7_label"
                                            class="col-lg-4 col-md-12 col-form-label">Apakah karyawan telah terlatih
                                            dan trampil dalam pekerjaan pengelasan atau pemotongan?
                                        </label>
                                        <div class="col-lg-8 col-md-12">
                                            <div class="wrapper_workplace_n_7 d-flex flex-column gap-3"
                                                x-data="{ workplace_n_7_value: @entangle('workplace_n_7_value') }">
                                                <x-inputs.select2 wire:model="workplace_n_7_value"
                                                    id="workplace_n_7_value" class="form-select"
                                                    placeholder="Pemenuhan">
                                                    <option value="Ya">Ya</option>
                                                    <option value="Tidak">Tidak</option>
                                                    <option value="N/A">N/A</option>
                                                </x-inputs.select2>
                                                <div x-cloak
                                                    x-show="workplace_n_7_value === 'Tidak' || workplace_n_7_value === '5' ">
                                                    <div>
                                                        <x-kplh-texteditor wire:model="workplace_n_7_note"
                                                            id="workplace_n_7_note" placeholder="Keterangan"
                                                            :error="'workplace_n_7_note'" />
                                                    </div>
                                                    <div class="mt-3">
                                                        <x-kplh-file wire:model="workplace_n_7_file"
                                                            id="workplace_n_7_file" placeholder="Upload foto temuan"
                                                            :error="'workplace_n_7_file'" />
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div><!-- /.form-group workplace_n_7 -->

                                    <div class="row form-group mb-4">
                                        <label for="workplace_n_8_label"
                                            class="col-lg-4 col-md-12 col-form-label">Apakah pengelasan telah
                                            dipasangkan Flash Back Arrestor pada silinder dan stang?
                                        </label>
                                        <div class="col-lg-8 col-md-12">
                                            <div class="wrapper_workplace_n_8 d-flex flex-column gap-3"
                                                x-data="{ workplace_n_8_value: @entangle('workplace_n_8_value') }">
                                                <x-inputs.select2 wire:model="workplace_n_8_value"
                                                    id="workplace_n_8_value" class="form-select"
                                                    placeholder="Pemenuhan">
                                                    <option value="Ya">Ya</option>
                                                    <option value="Tidak">Tidak</option>
                                                    <option value="N/A">N/A</option>
                                                </x-inputs.select2>
                                                <div x-cloak
                                                    x-show="workplace_n_8_value === 'Tidak' || workplace_n_8_value === '5' ">
                                                    <div>
                                                        <x-kplh-texteditor wire:model="workplace_n_8_note"
                                                            id="workplace_n_8_note" placeholder="Keterangan"
                                                            :error="'workplace_n_8_note'" />
                                                    </div>
                                                    <div class="mt-3">
                                                        <x-kplh-file wire:model="workplace_n_8_file"
                                                            id="workplace_n_8_file" placeholder="Upload foto temuan"
                                                            :error="'workplace_n_8_file'" />
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div><!-- /.form-group workplace_n_8 -->

                                    <div class="row form-group mb-4">
                                        <label for="workplace_n_9_label"
                                            class="col-lg-4 col-md-12 col-form-label">Apakah selang botol oksigen dan
                                            botol asetelin telah terpasang dengan aman dan kuat? Kondisi masih layak
                                            pakai?
                                        </label>
                                        <div class="col-lg-8 col-md-12">
                                            <div class="wrapper_workplace_n_9 d-flex flex-column gap-3"
                                                x-data="{ workplace_n_9_value: @entangle('workplace_n_9_value') }">
                                                <x-inputs.select2 wire:model="workplace_n_9_value"
                                                    id="workplace_n_9_value" class="form-select"
                                                    placeholder="Pemenuhan">
                                                    <option value="Ya">Ya</option>
                                                    <option value="Tidak">Tidak</option>
                                                    <option value="N/A">N/A</option>
                                                </x-inputs.select2>
                                                <div x-cloak
                                                    x-show="workplace_n_9_value === 'Tidak' || workplace_n_9_value === '5' ">
                                                    <div>
                                                        <x-kplh-texteditor wire:model="workplace_n_9_note"
                                                            id="workplace_n_9_note" placeholder="Keterangan"
                                                            :error="'workplace_n_9_note'" />
                                                    </div>
                                                    <div class="mt-3">
                                                        <x-kplh-file wire:model="workplace_n_9_file"
                                                            id="workplace_n_9_file" placeholder="Upload foto temuan"
                                                            :error="'workplace_n_9_file'" />
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div><!-- /.form-group workplace_n_9 -->

                                    <div class="row form-group mb-4">
                                        <label for="workplace_n_10_label"
                                            class="col-lg-4 col-md-12 col-form-label">Apakah Penghalang Las atau
                                            Welding Screen digunakan? Masih dalam kondisi baik?
                                        </label>
                                        <div class="col-lg-8 col-md-12">
                                            <div class="wrapper_workplace_n_10 d-flex flex-column gap-3"
                                                x-data="{ workplace_n_10_value: @entangle('workplace_n_10_value') }">
                                                <x-inputs.select2 wire:model="workplace_n_10_value"
                                                    id="workplace_n_10_value" class="form-select"
                                                    placeholder="Pemenuhan">
                                                    <option value="Ya">Ya</option>
                                                    <option value="Tidak">Tidak</option>
                                                    <option value="N/A">N/A</option>
                                                </x-inputs.select2>
                                                <div x-cloak
                                                    x-show="workplace_n_10_value === 'Tidak' || workplace_n_10_value === '5' ">
                                                    <div>
                                                        <x-kplh-texteditor wire:model="workplace_n_10_note"
                                                            id="workplace_n_10_note" placeholder="Keterangan"
                                                            :error="'workplace_n_10_note'" />
                                                    </div>
                                                    <div class="mt-3">
                                                        <x-kplh-file wire:model="workplace_n_10_file"
                                                            id="workplace_n_10_file"
                                                            placeholder="Upload foto temuan" :error="'workplace_n_10_file'" />
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div><!-- /.form-group workplace_n_10 -->

                                    <div class="row form-group mb-4">
                                        <label for="workplace_n_11_label"
                                            class="col-lg-4 col-md-12 col-form-label">Apakah peralatan pengelasan
                                            (stang, selang, gauges, silinder, kabel listrik, clamp dan leads) dalam
                                            kondisi dan berfungsi dengan baik? Penempatannya jauh dari genangan air?
                                            Dapat membuat orang tersandung?
                                        </label>
                                        <div class="col-lg-8 col-md-12">
                                            <div class="wrapper_workplace_n_11 d-flex flex-column gap-3"
                                                x-data="{ workplace_n_11_value: @entangle('workplace_n_11_value') }">
                                                <x-inputs.select2 wire:model="workplace_n_11_value"
                                                    id="workplace_n_11_value" class="form-select"
                                                    placeholder="Pemenuhan">
                                                    <option value="Ya">Ya</option>
                                                    <option value="Tidak">Tidak</option>
                                                    <option value="N/A">N/A</option>
                                                </x-inputs.select2>
                                                <div x-cloak
                                                    x-show="workplace_n_11_value === 'Tidak' || workplace_n_11_value === '5' ">
                                                    <div>
                                                        <x-kplh-texteditor wire:model="workplace_n_11_note"
                                                            id="workplace_n_11_note" placeholder="Keterangan"
                                                            :error="'workplace_n_11_note'" />
                                                    </div>
                                                    <div class="mt-3">
                                                        <x-kplh-file wire:model="workplace_n_11_file"
                                                            id="workplace_n_11_file"
                                                            placeholder="Upload foto temuan" :error="'workplace_n_11_file'" />
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div><!-- /.form-group workplace_n_11 -->

                                    <div class="row form-group mb-4">
                                        <label for="workplace_n_12_label"
                                            class="col-lg-4 col-md-12 col-form-label">Apakah karyawan menggunakan
                                            pemantik las yang sesuai (bukan korek api atau korek gas) saat memulai
                                            pengelasan?
                                        </label>
                                        <div class="col-lg-8 col-md-12">
                                            <div class="wrapper_workplace_n_12 d-flex flex-column gap-3"
                                                x-data="{ workplace_n_12_value: @entangle('workplace_n_12_value') }">
                                                <x-inputs.select2 wire:model="workplace_n_12_value"
                                                    id="workplace_n_12_value" class="form-select"
                                                    placeholder="Pemenuhan">
                                                    <option value="Ya">Ya</option>
                                                    <option value="Tidak">Tidak</option>
                                                    <option value="N/A">N/A</option>
                                                </x-inputs.select2>
                                                <div x-cloak
                                                    x-show="workplace_n_12_value === 'Tidak' || workplace_n_12_value === '5' ">
                                                    <div>
                                                        <x-kplh-texteditor wire:model="workplace_n_12_note"
                                                            id="workplace_n_12_note" placeholder="Keterangan"
                                                            :error="'workplace_n_12_note'" />
                                                    </div>
                                                    <div class="mt-3">
                                                        <x-kplh-file wire:model="workplace_n_12_file"
                                                            id="workplace_n_12_file"
                                                            placeholder="Upload foto temuan" :error="'workplace_n_12_file'" />
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div><!-- /.form-group workplace_n_12 -->

                                    <div class="row form-group mb-4">
                                        <label for="workplace_n_13_label"
                                            class="col-lg-4 col-md-12 col-form-label">Apakah konektor pada trafo las
                                            telah terpasang dengan aman dan kuat? Sesuai dengan besar tegangannya?
                                        </label>
                                        <div class="col-lg-8 col-md-12">
                                            <div class="wrapper_workplace_n_13 d-flex flex-column gap-3"
                                                x-data="{ workplace_n_13_value: @entangle('workplace_n_13_value') }">
                                                <x-inputs.select2 wire:model="workplace_n_13_value"
                                                    id="workplace_n_13_value" class="form-select"
                                                    placeholder="Pemenuhan">
                                                    <option value="Ya">Ya</option>
                                                    <option value="Tidak">Tidak</option>
                                                    <option value="N/A">N/A</option>
                                                </x-inputs.select2>
                                                <div x-cloak
                                                    x-show="workplace_n_13_value === 'Tidak' || workplace_n_13_value === '5' ">
                                                    <div>
                                                        <x-kplh-texteditor wire:model="workplace_n_13_note"
                                                            id="workplace_n_13_note" placeholder="Keterangan"
                                                            :error="'workplace_n_13_note'" />
                                                    </div>
                                                    <div class="mt-3">
                                                        <x-kplh-file wire:model="workplace_n_13_file"
                                                            id="workplace_n_13_file"
                                                            placeholder="Upload foto temuan" :error="'workplace_n_13_file'" />
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div><!-- /.form-group workplace_n_13 -->

                                    <div class="row form-group mb-4">
                                        <label for="workplace_n_14_label"
                                            class="col-lg-4 col-md-12 col-form-label">Apakah mesin las telah
                                            dipasangkan ground system dengan benar? Apakah kabel negatif dipasang dekat
                                            dengan tempat pengelasan?
                                        </label>
                                        <div class="col-lg-8 col-md-12">
                                            <div class="wrapper_workplace_n_14 d-flex flex-column gap-3"
                                                x-data="{ workplace_n_14_value: @entangle('workplace_n_14_value') }">
                                                <x-inputs.select2 wire:model="workplace_n_14_value"
                                                    id="workplace_n_14_value" class="form-select"
                                                    placeholder="Pemenuhan">
                                                    <option value="Ya">Ya</option>
                                                    <option value="Tidak">Tidak</option>
                                                    <option value="N/A">N/A</option>
                                                </x-inputs.select2>
                                                <div x-cloak
                                                    x-show="workplace_n_14_value === 'Tidak' || workplace_n_14_value === '5' ">
                                                    <div>
                                                        <x-kplh-texteditor wire:model="workplace_n_14_note"
                                                            id="workplace_n_14_note" placeholder="Keterangan"
                                                            :error="'workplace_n_14_note'" />
                                                    </div>
                                                    <div class="mt-3">
                                                        <x-kplh-file wire:model="workplace_n_14_file"
                                                            id="workplace_n_14_file"
                                                            placeholder="Upload foto temuan" :error="'workplace_n_14_file'" />
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div><!-- /.form-group workplace_n_14 -->

                                    <div class="row form-group mb-4">
                                        <label for="workplace_n_15_label"
                                            class="col-lg-4 col-md-12 col-form-label">Apakah jatuhan kotoran panas
                                            dari kegiatan pengelasan telah terkendali? Diberikan pita barikade? Atau
                                            dipasangkan selimut tahan api di bawah kegiatan pengelasan?
                                        </label>
                                        <div class="col-lg-8 col-md-12">
                                            <div class="wrapper_workplace_n_15 d-flex flex-column gap-3"
                                                x-data="{ workplace_n_15_value: @entangle('workplace_n_15_value') }">
                                                <x-inputs.select2 wire:model="workplace_n_15_value"
                                                    id="workplace_n_15_value" class="form-select"
                                                    placeholder="Pemenuhan">
                                                    <option value="Ya">Ya</option>
                                                    <option value="Tidak">Tidak</option>
                                                    <option value="N/A">N/A</option>
                                                </x-inputs.select2>
                                                <div x-cloak
                                                    x-show="workplace_n_15_value === 'Tidak' || workplace_n_15_value === '5' ">
                                                    <div>
                                                        <x-kplh-texteditor wire:model="workplace_n_15_note"
                                                            id="workplace_n_15_note" placeholder="Keterangan"
                                                            :error="'workplace_n_15_note'" />
                                                    </div>
                                                    <div class="mt-3">
                                                        <x-kplh-file wire:model="workplace_n_15_file"
                                                            id="workplace_n_15_file"
                                                            placeholder="Upload foto temuan" :error="'workplace_n_15_file'" />
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div><!-- /.form-group workplace_n_15 -->

                                    <div class="row form-group mb-4">
                                        <label for="workplace_n_16_label"
                                            class="col-lg-4 col-md-12 col-form-label">Apakah terdapat tabung pemadam
                                            api ringan di dekat kegiatan pekerjaan panas? Karyawan mengetahui cara
                                            menggunakannya?
                                        </label>
                                        <div class="col-lg-8 col-md-12">
                                            <div class="wrapper_workplace_n_16 d-flex flex-column gap-3"
                                                x-data="{ workplace_n_16_value: @entangle('workplace_n_16_value') }">
                                                <x-inputs.select2 wire:model="workplace_n_16_value"
                                                    id="workplace_n_16_value" class="form-select"
                                                    placeholder="Pemenuhan">
                                                    <option value="Ya">Ya</option>
                                                    <option value="Tidak">Tidak</option>
                                                    <option value="N/A">N/A</option>
                                                </x-inputs.select2>
                                                <div x-cloak
                                                    x-show="workplace_n_16_value === 'Tidak' || workplace_n_16_value === '5' ">
                                                    <div>
                                                        <x-kplh-texteditor wire:model="workplace_n_16_note"
                                                            id="workplace_n_16_note" placeholder="Keterangan"
                                                            :error="'workplace_n_16_note'" />
                                                    </div>
                                                    <div class="mt-3">
                                                        <x-kplh-file wire:model="workplace_n_16_file"
                                                            id="workplace_n_16_file"
                                                            placeholder="Upload foto temuan" :error="'workplace_n_16_file'" />
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div><!-- /.form-group workplace_n_16 -->

                                </div><!-- ./content-workplace_n -->

                            </div>
                        </div><!-- /.workplace_n -->

                        <div id="workplace_o" class="section-workplace_o" x-data="{ accordionOpen: false }">
                            <button
                                class="header-accordion d-flex justify-content-between w-100 border-0 bg-white py-3 px-0"
                                @click.prevent="accordionOpen = ! accordionOpen">
                                <h6 class="mb-0 fw-normal title-accordion">O. BERKENDARAAN DENGAN AMAN (VEHICLE SAFETY
                                    ROAD)</h6>
                                <span x-bind:class="accordionOpen ? 'open' : ''"><img
                                        src="{{ asset('/images/icons/angle-down.png') }}" alt="" /></span>
                            </button>
                            <div class="wrapper-content-accordion max-h-0 overflow-hidden position-relative transition-all duration-700"
                                x-ref="workplace_o" x-bind:style="accordionOpen ? 'max-height: ' + 20000 + 'px' : ''"
                                x-transition.delay.5000ms>

                                <div class="content-section p-4" wire:ignore.self>

                                    <div class="row form-group mb-4">
                                        <label for="workplace_o_1_label"
                                            class="col-lg-4 col-md-12 col-form-label">Apakah supir kendaraan
                                            ringan/mobil atau operator alat berat telah melakukan pemeriksaan awal
                                            sebelum mobil atau alat berat dijalankan? Apakah pemeriksaan awal tersebut
                                            telah tercatat? Apakah pemeriksaan awal itu termasuk pemeriksaan oli mesin,
                                            radiator, oli rem, kemudi, lampu-lampu, dan lainnya?
                                        </label>
                                        <div class="col-lg-8 col-md-12">
                                            <div class="wrapper_workplace_o_1 d-flex flex-column gap-3"
                                                x-data="{ workplace_o_1_value: @entangle('workplace_o_1_value') }">
                                                <x-inputs.select2 wire:model="workplace_o_1_value"
                                                    id="workplace_o_1_value" class="form-select"
                                                    placeholder="Pemenuhan">
                                                    <option value="Ya">Ya</option>
                                                    <option value="Tidak">Tidak</option>
                                                    <option value="N/A">N/A</option>
                                                </x-inputs.select2>

                                                <div x-cloak
                                                    x-show="workplace_o_1_value === 'Tidak' || workplace_o_1_value === '5' ">
                                                    <div>
                                                        <x-kplh-texteditor wire:model="workplace_o_1_note"
                                                            id="workplace_o_1_note" placeholder="Keterangan"
                                                            :error="'workplace_o_1_note'" />
                                                    </div>
                                                    <div class="mt-3">
                                                        <x-kplh-file wire:model="workplace_o_1_file"
                                                            id="workplace_o_1_file" placeholder="Upload foto temuan"
                                                            :error="'workplace_o_1_file'" />
                                                    </div>
                                                </div>

                                            </div>
                                        </div>
                                    </div><!-- /.form-group workplace_o_1 -->

                                    <div class="row form-group mb-4">
                                        <label for="workplace_o_2_label"
                                            class="col-lg-4 col-md-12 col-form-label">Apakah supir atau operator telah
                                            memiliki SIMPER yang masih berlaku dan sesuai?
                                        </label>
                                        <div class="col-lg-8 col-md-12">
                                            <div class="wrapper_workplace_o_2 d-flex flex-column gap-3"
                                                x-data="{ workplace_o_2_value: @entangle('workplace_o_2_value') }">
                                                <x-inputs.select2 wire:model="workplace_o_2_value"
                                                    id="workplace_o_2_value" class="form-select"
                                                    placeholder="Pemenuhan">
                                                    <option value="Ya">Ya</option>
                                                    <option value="Tidak">Tidak</option>
                                                    <option value="N/A">N/A</option>
                                                </x-inputs.select2>
                                                <div x-cloak
                                                    x-show="workplace_o_2_value === 'Tidak' || workplace_o_2_value === '5' ">
                                                    <div>
                                                        <x-kplh-texteditor wire:model="workplace_o_2_note"
                                                            id="workplace_o_2_note" placeholder="Keterangan"
                                                            :error="'workplace_o_2_note'" />
                                                    </div>
                                                    <div class="mt-3">
                                                        <x-kplh-file wire:model="workplace_o_2_file"
                                                            id="workplace_o_2_file" placeholder="Upload foto temuan"
                                                            :error="'workplace_o_2_file'" />
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div><!-- /.form-group workplace_o_2 -->

                                    <div class="row form-group mb-4">
                                        <label for="workplace_o_3_label"
                                            class="col-lg-4 col-md-12 col-form-label">Apakah supir atau operator
                                            menggunakan sabuk pengaman? Semua penumpangnya menggunakan sabuk pengaman
                                            dengan benar?
                                        </label>
                                        <div class="col-lg-8 col-md-12">
                                            <div class="wrapper_workplace_o_3 d-flex flex-column gap-3"
                                                x-data="{ workplace_o_3_value: @entangle('workplace_o_3_value') }">
                                                <x-inputs.select2 wire:model="workplace_o_3_value"
                                                    id="workplace_o_3_value" class="form-select"
                                                    placeholder="Pemenuhan">
                                                    <option value="Ya">Ya</option>
                                                    <option value="Tidak">Tidak</option>
                                                    <option value="N/A">N/A</option>
                                                </x-inputs.select2>
                                                <div x-cloak
                                                    x-show="workplace_o_3_value === 'Tidak' || workplace_o_3_value === '5' ">
                                                    <div>
                                                        <x-kplh-texteditor wire:model="workplace_o_3_note"
                                                            id="workplace_o_3_note" placeholder="Keterangan"
                                                            :error="'workplace_o_3_note'" />
                                                    </div>
                                                    <div class="mt-3">
                                                        <x-kplh-file wire:model="workplace_o_3_file"
                                                            id="workplace_o_3_file" placeholder="Upload foto temuan"
                                                            :error="'workplace_o_3_file'" />
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div><!-- /.form-group workplace_o_3 -->

                                    <div class="row form-group mb-4">
                                        <label for="workplace_o_4_label"
                                            class="col-lg-4 col-md-12 col-form-label">Apakah supir atau operator
                                            mematuhi semua aturan dan rambu berlalu lintas?
                                        </label>
                                        <div class="col-lg-8 col-md-12">
                                            <div class="wrapper_workplace_o_4 d-flex flex-column gap-3"
                                                x-data="{ workplace_o_4_value: @entangle('workplace_o_4_value') }">
                                                <x-inputs.select2 wire:model="workplace_o_4_value"
                                                    id="workplace_o_4_value" class="form-select"
                                                    placeholder="Pemenuhan">
                                                    <option value="Ya">Ya</option>
                                                    <option value="Tidak">Tidak</option>
                                                    <option value="N/A">N/A</option>
                                                </x-inputs.select2>
                                                <div x-cloak
                                                    x-show="workplace_o_4_value === 'Tidak' || workplace_o_4_value === '5' ">
                                                    <div>
                                                        <x-kplh-texteditor wire:model="workplace_o_4_note"
                                                            id="workplace_o_4_note" placeholder="Keterangan"
                                                            :error="'workplace_o_4_note'" />
                                                    </div>
                                                    <div class="mt-3">
                                                        <x-kplh-file wire:model="workplace_o_4_file"
                                                            id="workplace_o_4_file" placeholder="Upload foto temuan"
                                                            :error="'workplace_o_4_file'" />
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div><!-- /.form-group workplace_o_4 -->

                                    <div class="row form-group mb-4">
                                        <label for="workplace_o_5_label"
                                            class="col-lg-4 col-md-12 col-form-label">Apakah supir atau operator telah
                                            mengikatkan barang yang dibawa di belakangnya?
                                        </label>
                                        <div class="col-lg-8 col-md-12">
                                            <div class="wrapper_workplace_o_5 d-flex flex-column gap-3"
                                                x-data="{ workplace_o_5_value: @entangle('workplace_o_5_value') }">
                                                <x-inputs.select2 wire:model="workplace_o_5_value"
                                                    id="workplace_o_5_value" class="form-select"
                                                    placeholder="Pemenuhan">
                                                    <option value="Ya">Ya</option>
                                                    <option value="Tidak">Tidak</option>
                                                    <option value="N/A">N/A</option>
                                                </x-inputs.select2>
                                                <div x-cloak
                                                    x-show="workplace_o_5_value === 'Tidak' || workplace_o_5_value === '5' ">
                                                    <div>
                                                        <x-kplh-texteditor wire:model="workplace_o_5_note"
                                                            id="workplace_o_5_note" placeholder="Keterangan"
                                                            :error="'workplace_o_5_note'" />
                                                    </div>
                                                    <div class="mt-3">
                                                        <x-kplh-file wire:model="workplace_o_5_file"
                                                            id="workplace_o_5_file" placeholder="Upload foto temuan"
                                                            :error="'workplace_o_5_file'" />
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div><!-- /.form-group workplace_o_5 -->

                                    <div class="row form-group mb-4">
                                        <label for="workplace_o_6_label"
                                            class="col-lg-4 col-md-12 col-form-label">Apakah supir atau operator telah
                                            memparkirkan kendaraannya dengan benar? Sesuai dengan rambu parkir?
                                        </label>
                                        <div class="col-lg-8 col-md-12">
                                            <div class="wrapper_workplace_o_6 d-flex flex-column gap-3"
                                                x-data="{ workplace_o_6_value: @entangle('workplace_o_6_value') }">
                                                <x-inputs.select2 wire:model="workplace_o_6_value"
                                                    id="workplace_o_6_value" class="form-select"
                                                    placeholder="Pemenuhan">
                                                    <option value="Ya">Ya</option>
                                                    <option value="Tidak">Tidak</option>
                                                    <option value="N/A">N/A</option>
                                                </x-inputs.select2>
                                                <div x-cloak
                                                    x-show="workplace_o_6_value === 'Tidak' || workplace_o_6_value === '5' ">
                                                    <div>
                                                        <x-kplh-texteditor wire:model="workplace_o_6_note"
                                                            id="workplace_o_6_note" placeholder="Keterangan"
                                                            :error="'workplace_o_6_note'" />
                                                    </div>
                                                    <div class="mt-3">
                                                        <x-kplh-file wire:model="workplace_o_6_file"
                                                            id="workplace_o_6_file" placeholder="Upload foto temuan"
                                                            :error="'workplace_o_6_file'" />
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div><!-- /.form-group workplace_o_6 -->

                                </div><!-- ./content-workplace_o -->

                            </div>
                        </div><!-- /.workplace_o -->

                        <div id="workplace_p" class="section-workplace_p" x-data="{ accordionOpen: false }">
                            <button
                                class="header-accordion d-flex justify-content-between w-100 border-0 bg-white py-3 px-0"
                                @click.prevent="accordionOpen = ! accordionOpen">
                                <h6 class="mb-0 fw-normal title-accordion">P. PENYIMPANAN HIDROKARBON (HYDROCARBON
                                    STORAGE)</h6>
                                <span x-bind:class="accordionOpen ? 'open' : ''"><img
                                        src="{{ asset('/images/icons/angle-down.png') }}" alt="" /></span>
                            </button>
                            <div class="wrapper-content-accordion max-h-0 overflow-hidden position-relative transition-all duration-700"
                                x-ref="workplace_p" x-bind:style="accordionOpen ? 'max-height: ' + 20000 + 'px' : ''"
                                x-transition.delay.5000ms>

                                <div class="content-section p-4" wire:ignore.self>

                                    <div class="row form-group mb-4">
                                        <label for="workplace_p_1_label"
                                            class="col-lg-4 col-md-12 col-form-label">Apakah terdapat tempat
                                            peyimpanan hidrokarbon diletakan pada tempat yang dilengkapi secondary
                                            containment?
                                        </label>
                                        <div class="col-lg-8 col-md-12">
                                            <div class="wrapper_workplace_p_1 d-flex flex-column gap-3"
                                                x-data="{ workplace_p_1_value: @entangle('workplace_p_1_value') }">
                                                <x-inputs.select2 wire:model="workplace_p_1_value"
                                                    id="workplace_p_1_value" class="form-select"
                                                    placeholder="Pemenuhan">
                                                    <option value="Ya">Ya</option>
                                                    <option value="Tidak">Tidak</option>
                                                    <option value="N/A">N/A</option>
                                                </x-inputs.select2>

                                                <div x-cloak
                                                    x-show="workplace_p_1_value === 'Tidak' || workplace_p_1_value === '5' ">
                                                    <div>
                                                        <x-kplh-texteditor wire:model="workplace_p_1_note"
                                                            id="workplace_p_1_note" placeholder="Keterangan"
                                                            :error="'workplace_p_1_note'" />
                                                    </div>
                                                    <div class="mt-3">
                                                        <x-kplh-file wire:model="workplace_p_1_file"
                                                            id="workplace_p_1_file" placeholder="Upload foto temuan"
                                                            :error="'workplace_p_1_file'" />
                                                    </div>
                                                </div>

                                            </div>
                                        </div>
                                    </div><!-- /.form-group workplace_p_1 -->

                                    <div class="row form-group mb-4">
                                        <label for="workplace_p_2_label"
                                            class="col-lg-4 col-md-12 col-form-label">Secondary containment memiliki
                                            kapastas 110% dari volume tangki penyimpanan hidrokarbon
                                        </label>
                                        <div class="col-lg-8 col-md-12">
                                            <div class="wrapper_workplace_p_2 d-flex flex-column gap-3"
                                                x-data="{ workplace_p_2_value: @entangle('workplace_p_2_value') }">
                                                <x-inputs.select2 wire:model="workplace_p_2_value"
                                                    id="workplace_p_2_value" class="form-select"
                                                    placeholder="Pemenuhan">
                                                    <option value="Ya">Ya</option>
                                                    <option value="Tidak">Tidak</option>
                                                    <option value="N/A">N/A</option>
                                                </x-inputs.select2>
                                                <div x-cloak
                                                    x-show="workplace_p_2_value === 'Tidak' || workplace_p_2_value === '5' ">
                                                    <div>
                                                        <x-kplh-texteditor wire:model="workplace_p_2_note"
                                                            id="workplace_p_2_note" placeholder="Keterangan"
                                                            :error="'workplace_p_2_note'" />
                                                    </div>
                                                    <div class="mt-3">
                                                        <x-kplh-file wire:model="workplace_p_2_file"
                                                            id="workplace_p_2_file" placeholder="Upload foto temuan"
                                                            :error="'workplace_p_2_file'" />
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div><!-- /.form-group workplace_p_2 -->

                                    <div class="row form-group mb-4">
                                        <label for="workplace_p_3_label"
                                            class="col-lg-4 col-md-12 col-form-label">Apakah fasilitas penyimpanan
                                            hidrokarbon memiliki Oil Separator yang memadai dan berfungsi dengan baik?
                                        </label>
                                        <div class="col-lg-8 col-md-12">
                                            <div class="wrapper_workplace_p_3 d-flex flex-column gap-3"
                                                x-data="{ workplace_p_3_value: @entangle('workplace_p_3_value') }">
                                                <x-inputs.select2 wire:model="workplace_p_3_value"
                                                    id="workplace_p_3_value" class="form-select"
                                                    placeholder="Pemenuhan">
                                                    <option value="Ya">Ya</option>
                                                    <option value="Tidak">Tidak</option>
                                                    <option value="N/A">N/A</option>
                                                </x-inputs.select2>
                                                <div x-cloak
                                                    x-show="workplace_p_3_value === 'Tidak' || workplace_p_3_value === '5' ">
                                                    <div>
                                                        <x-kplh-texteditor wire:model="workplace_p_3_note"
                                                            id="workplace_p_3_note" placeholder="Keterangan"
                                                            :error="'workplace_p_3_note'" />
                                                    </div>
                                                    <div class="mt-3">
                                                        <x-kplh-file wire:model="workplace_p_3_file"
                                                            id="workplace_p_3_file" placeholder="Upload foto temuan"
                                                            :error="'workplace_p_3_file'" />
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div><!-- /.form-group workplace_p_3 -->

                                    <div class="row form-group mb-4">
                                        <label for="workplace_p_4_label"
                                            class="col-lg-4 col-md-12 col-form-label">Apakah outlet buangan atau drain
                                            dari secondary containment dalam kondisi baik dan selalu tertutup?
                                        </label>
                                        <div class="col-lg-8 col-md-12">
                                            <div class="wrapper_workplace_p_4 d-flex flex-column gap-3"
                                                x-data="{ workplace_p_4_value: @entangle('workplace_p_4_value') }">
                                                <x-inputs.select2 wire:model="workplace_p_4_value"
                                                    id="workplace_p_4_value" class="form-select"
                                                    placeholder="Pemenuhan">
                                                    <option value="Ya">Ya</option>
                                                    <option value="Tidak">Tidak</option>
                                                    <option value="N/A">N/A</option>
                                                </x-inputs.select2>
                                                <div x-cloak
                                                    x-show="workplace_p_4_value === 'Tidak' || workplace_p_4_value === '5' ">
                                                    <div>
                                                        <x-kplh-texteditor wire:model="workplace_p_4_note"
                                                            id="workplace_p_4_note" placeholder="Keterangan"
                                                            :error="'workplace_p_4_note'" />
                                                    </div>
                                                    <div class="mt-3">
                                                        <x-kplh-file wire:model="workplace_p_4_file"
                                                            id="workplace_p_4_file" placeholder="Upload foto temuan"
                                                            :error="'workplace_p_4_file'" />
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div><!-- /.form-group workplace_p_4 -->

                                    <div class="row form-group mb-4">
                                        <label for="workplace_p_5_label"
                                            class="col-lg-4 col-md-12 col-form-label">Oil trap diinspeksi dan
                                            dibersihkan secara teratur?
                                        </label>
                                        <div class="col-lg-8 col-md-12">
                                            <div class="wrapper_workplace_p_5 d-flex flex-column gap-3"
                                                x-data="{ workplace_p_5_value: @entangle('workplace_p_5_value') }">
                                                <x-inputs.select2 wire:model="workplace_p_5_value"
                                                    id="workplace_p_5_value" class="form-select"
                                                    placeholder="Pemenuhan">
                                                    <option value="Ya">Ya</option>
                                                    <option value="Tidak">Tidak</option>
                                                    <option value="N/A">N/A</option>
                                                </x-inputs.select2>
                                                <div x-cloak
                                                    x-show="workplace_p_5_value === 'Tidak' || workplace_p_5_value === '5' ">
                                                    <div>
                                                        <x-kplh-texteditor wire:model="workplace_p_5_note"
                                                            id="workplace_p_5_note" placeholder="Keterangan"
                                                            :error="'workplace_p_5_note'" />
                                                    </div>
                                                    <div class="mt-3">
                                                        <x-kplh-file wire:model="workplace_p_5_file"
                                                            id="workplace_p_5_file" placeholder="Upload foto temuan"
                                                            :error="'workplace_p_5_file'" />
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div><!-- /.form-group workplace_p_5 -->

                                    <div class="row form-group mb-4">
                                        <label for="workplace_p_6_label"
                                            class="col-lg-4 col-md-12 col-form-label">Oil trap dilengkapi dengan stick
                                            pemeriksaan.
                                        </label>
                                        <div class="col-lg-8 col-md-12">
                                            <div class="wrapper_workplace_p_6 d-flex flex-column gap-3"
                                                x-data="{ workplace_p_6_value: @entangle('workplace_p_6_value') }">
                                                <x-inputs.select2 wire:model="workplace_p_6_value"
                                                    id="workplace_p_6_value" class="form-select"
                                                    placeholder="Pemenuhan">
                                                    <option value="Ya">Ya</option>
                                                    <option value="Tidak">Tidak</option>
                                                    <option value="N/A">N/A</option>
                                                </x-inputs.select2>
                                                <div x-cloak
                                                    x-show="workplace_p_6_value === 'Tidak' || workplace_p_6_value === '5' ">
                                                    <div>
                                                        <x-kplh-texteditor wire:model="workplace_p_6_note"
                                                            id="workplace_p_6_note" placeholder="Keterangan"
                                                            :error="'workplace_p_6_note'" />
                                                    </div>
                                                    <div class="mt-3">
                                                        <x-kplh-file wire:model="workplace_p_6_file"
                                                            id="workplace_p_6_file" placeholder="Upload foto temuan"
                                                            :error="'workplace_p_6_file'" />
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div><!-- /.form-group workplace_p_6 -->

                                    <div class="row form-group mb-4">
                                        <label for="workplace_p_7_label"
                                            class="col-lg-4 col-md-12 col-form-label">Apakah keran atau valve dari
                                            sump pit suatu bund wall dalam kondisi tertutup?
                                        </label>
                                        <div class="col-lg-8 col-md-12">
                                            <div class="wrapper_workplace_p_7 d-flex flex-column gap-3"
                                                x-data="{ workplace_p_7_value: @entangle('workplace_p_7_value') }">
                                                <x-inputs.select2 wire:model="workplace_p_7_value"
                                                    id="workplace_p_7_value" class="form-select"
                                                    placeholder="Pemenuhan">
                                                    <option value="Ya">Ya</option>
                                                    <option value="Tidak">Tidak</option>
                                                    <option value="N/A">N/A</option>
                                                </x-inputs.select2>
                                                <div x-cloak
                                                    x-show="workplace_p_7_value === 'Tidak' || workplace_p_7_value === '5' ">
                                                    <div>
                                                        <x-kplh-texteditor wire:model="workplace_p_7_note"
                                                            id="workplace_p_7_note" placeholder="Keterangan"
                                                            :error="'workplace_p_7_note'" />
                                                    </div>
                                                    <div class="mt-3">
                                                        <x-kplh-file wire:model="workplace_p_7_file"
                                                            id="workplace_p_7_file" placeholder="Upload foto temuan"
                                                            :error="'workplace_p_7_file'" />
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div><!-- /.form-group workplace_p_7 -->

                                    <div class="row form-group mb-4">
                                        <label for="workplace_p_8_label"
                                            class="col-lg-4 col-md-12 col-form-label">Apakah spill kit tersedia pada
                                            tempat penyimpanan hidrokarbon?
                                        </label>
                                        <div class="col-lg-8 col-md-12">
                                            <div class="wrapper_workplace_p_8 d-flex flex-column gap-3"
                                                x-data="{ workplace_p_8_value: @entangle('workplace_p_8_value') }">
                                                <x-inputs.select2 wire:model="workplace_p_8_value"
                                                    id="workplace_p_8_value" class="form-select"
                                                    placeholder="Pemenuhan">
                                                    <option value="Ya">Ya</option>
                                                    <option value="Tidak">Tidak</option>
                                                    <option value="N/A">N/A</option>
                                                </x-inputs.select2>
                                                <div x-cloak
                                                    x-show="workplace_p_8_value === 'Tidak' || workplace_p_8_value === '5' ">
                                                    <div>
                                                        <x-kplh-texteditor wire:model="workplace_p_8_note"
                                                            id="workplace_p_8_note" placeholder="Keterangan"
                                                            :error="'workplace_p_8_note'" />
                                                    </div>
                                                    <div class="mt-3">
                                                        <x-kplh-file wire:model="workplace_p_8_file"
                                                            id="workplace_p_8_file" placeholder="Upload foto temuan"
                                                            :error="'workplace_p_8_file'" />
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div><!-- /.form-group workplace_p_8 -->

                                </div><!-- ./content-workplace_p -->

                            </div>
                        </div><!-- /.workplace_p -->

                        <div id="workplace_q" class="section-workplace_q" x-data="{ accordionOpen: false }">
                            <button
                                class="header-accordion d-flex justify-content-between w-100 border-0 bg-white py-3 px-0"
                                @click.prevent="accordionOpen = ! accordionOpen">
                                <h6 class="mb-0 fw-normal title-accordion">Q. BAHAN BERBAHAYA dan BERACUN (HAZARDOUS
                                    SUBSTANCES)</h6>
                                <span x-bind:class="accordionOpen ? 'open' : ''"><img
                                        src="{{ asset('/images/icons/angle-down.png') }}" alt="" /></span>
                            </button>
                            <div class="wrapper-content-accordion max-h-0 overflow-hidden position-relative transition-all duration-700"
                                x-ref="workplace_q" x-bind:style="accordionOpen ? 'max-height: ' + 20000 + 'px' : ''"
                                x-transition.delay.5000ms>

                                <div class="content-section p-4" wire:ignore.self>

                                    <div class="row form-group mb-4">
                                        <label for="workplace_q_1_label"
                                            class="col-lg-4 col-md-12 col-form-label">Apakah pekerjaan menggunakan
                                            bahan kimia? Apakah terdapat MSDS yang sesuai dengan bahan kimia yang
                                            digunakan di lokasi kerja?
                                        </label>
                                        <div class="col-lg-8 col-md-12">
                                            <div class="wrapper_workplace_q_1 d-flex flex-column gap-3"
                                                x-data="{ workplace_q_1_value: @entangle('workplace_q_1_value') }">
                                                <x-inputs.select2 wire:model="workplace_q_1_value"
                                                    id="workplace_q_1_value" class="form-select"
                                                    placeholder="Pemenuhan">
                                                    <option value="Ya">Ya</option>
                                                    <option value="Tidak">Tidak</option>
                                                    <option value="N/A">N/A</option>
                                                </x-inputs.select2>

                                                <div x-cloak
                                                    x-show="workplace_q_1_value === 'Tidak' || workplace_q_1_value === '5' ">
                                                    <div>
                                                        <x-kplh-texteditor wire:model="workplace_q_1_note"
                                                            id="workplace_q_1_note" placeholder="Keterangan"
                                                            :error="'workplace_q_1_note'" />
                                                    </div>
                                                    <div class="mt-3">
                                                        <x-kplh-file wire:model="workplace_q_1_file"
                                                            id="workplace_q_1_file" placeholder="Upload foto temuan"
                                                            :error="'workplace_q_1_file'" />
                                                    </div>
                                                </div>

                                            </div>
                                        </div>
                                    </div><!-- /.form-group workplace_q_1 -->

                                    <div class="row form-group mb-4">
                                        <label for="workplace_q_2_label"
                                            class="col-lg-4 col-md-12 col-form-label">Apakah karyawan memahami dan
                                            mengerti persyaratan kerja aman dari MSDS tersebut?
                                        </label>
                                        <div class="col-lg-8 col-md-12">
                                            <div class="wrapper_workplace_q_2 d-flex flex-column gap-3"
                                                x-data="{ workplace_q_2_value: @entangle('workplace_q_2_value') }">
                                                <x-inputs.select2 wire:model="workplace_q_2_value"
                                                    id="workplace_q_2_value" class="form-select"
                                                    placeholder="Pemenuhan">
                                                    <option value="Ya">Ya</option>
                                                    <option value="Tidak">Tidak</option>
                                                    <option value="N/A">N/A</option>
                                                </x-inputs.select2>
                                                <div x-cloak
                                                    x-show="workplace_q_2_value === 'Tidak' || workplace_q_2_value === '5' ">
                                                    <div>
                                                        <x-kplh-texteditor wire:model="workplace_q_2_note"
                                                            id="workplace_q_2_note" placeholder="Keterangan"
                                                            :error="'workplace_q_2_note'" />
                                                    </div>
                                                    <div class="mt-3">
                                                        <x-kplh-file wire:model="workplace_q_2_file"
                                                            id="workplace_q_2_file" placeholder="Upload foto temuan"
                                                            :error="'workplace_q_2_file'" />
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div><!-- /.form-group workplace_q_2 -->

                                    <div class="row form-group mb-4">
                                        <label for="workplace_q_3_label"
                                            class="col-lg-4 col-md-12 col-form-label">Apakah karyawan bekerja sesuai
                                            dengan persyaratan kerja dari MSDS bahan kimia tersebut?
                                        </label>
                                        <div class="col-lg-8 col-md-12">
                                            <div class="wrapper_workplace_q_3 d-flex flex-column gap-3"
                                                x-data="{ workplace_q_3_value: @entangle('workplace_q_3_value') }">
                                                <x-inputs.select2 wire:model="workplace_q_3_value"
                                                    id="workplace_q_3_value" class="form-select"
                                                    placeholder="Pemenuhan">
                                                    <option value="Ya">Ya</option>
                                                    <option value="Tidak">Tidak</option>
                                                    <option value="N/A">N/A</option>
                                                </x-inputs.select2>
                                                <div x-cloak
                                                    x-show="workplace_q_3_value === 'Tidak' || workplace_q_3_value === '5' ">
                                                    <div>
                                                        <x-kplh-texteditor wire:model="workplace_q_3_note"
                                                            id="workplace_q_3_note" placeholder="Keterangan"
                                                            :error="'workplace_q_3_note'" />
                                                    </div>
                                                    <div class="mt-3">
                                                        <x-kplh-file wire:model="workplace_q_3_file"
                                                            id="workplace_q_3_file" placeholder="Upload foto temuan"
                                                            :error="'workplace_q_3_file'" />
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div><!-- /.form-group workplace_q_3 -->

                                    <div class="row form-group mb-4">
                                        <label for="workplace_q_4_label"
                                            class="col-lg-4 col-md-12 col-form-label">Apakah terdapat label bahan B3
                                            pada tempat penyimpanan atau kontainernya?
                                        </label>
                                        <div class="col-lg-8 col-md-12">
                                            <div class="wrapper_workplace_q_4 d-flex flex-column gap-3"
                                                x-data="{ workplace_q_4_value: @entangle('workplace_q_4_value') }">
                                                <x-inputs.select2 wire:model="workplace_q_4_value"
                                                    id="workplace_q_4_value" class="form-select"
                                                    placeholder="Pemenuhan">
                                                    <option value="Ya">Ya</option>
                                                    <option value="Tidak">Tidak</option>
                                                    <option value="N/A">N/A</option>
                                                </x-inputs.select2>
                                                <div x-cloak
                                                    x-show="workplace_q_4_value === 'Tidak' || workplace_q_4_value === '5' ">
                                                    <div>
                                                        <x-kplh-texteditor wire:model="workplace_q_4_note"
                                                            id="workplace_q_4_note" placeholder="Keterangan"
                                                            :error="'workplace_q_4_note'" />
                                                    </div>
                                                    <div class="mt-3">
                                                        <x-kplh-file wire:model="workplace_q_4_file"
                                                            id="workplace_q_4_file" placeholder="Upload foto temuan"
                                                            :error="'workplace_q_4_file'" />
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div><!-- /.form-group workplace_q_4 -->

                                    <div class="row form-group mb-4">
                                        <label for="workplace_q_5_label"
                                            class="col-lg-4 col-md-12 col-form-label">Apakah tempat penyimpanan atau
                                            kontainernya dalam kondisi baik?
                                        </label>
                                        <div class="col-lg-8 col-md-12">
                                            <div class="wrapper_workplace_q_5 d-flex flex-column gap-3"
                                                x-data="{ workplace_q_5_value: @entangle('workplace_q_5_value') }">
                                                <x-inputs.select2 wire:model="workplace_q_5_value"
                                                    id="workplace_q_5_value" class="form-select"
                                                    placeholder="Pemenuhan">
                                                    <option value="Ya">Ya</option>
                                                    <option value="Tidak">Tidak</option>
                                                    <option value="N/A">N/A</option>
                                                </x-inputs.select2>
                                                <div x-cloak
                                                    x-show="workplace_q_5_value === 'Tidak' || workplace_q_5_value === '5' ">
                                                    <div>
                                                        <x-kplh-texteditor wire:model="workplace_q_5_note"
                                                            id="workplace_q_5_note" placeholder="Keterangan"
                                                            :error="'workplace_q_5_note'" />
                                                    </div>
                                                    <div class="mt-3">
                                                        <x-kplh-file wire:model="workplace_q_5_file"
                                                            id="workplace_q_5_file" placeholder="Upload foto temuan"
                                                            :error="'workplace_q_5_file'" />
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div><!-- /.form-group workplace_q_5 -->

                                    <div class="row form-group mb-4">
                                        <label for="workplace_q_6_label"
                                            class="col-lg-4 col-md-12 col-form-label">Apakah bahan kimia yang tidak
                                            digunakan atau tersisa, telah disimpan dalam container yang masih baik
                                            kondisinya?
                                        </label>
                                        <div class="col-lg-8 col-md-12">
                                            <div class="wrapper_workplace_q_6 d-flex flex-column gap-3"
                                                x-data="{ workplace_q_6_value: @entangle('workplace_q_6_value') }">
                                                <x-inputs.select2 wire:model="workplace_q_6_value"
                                                    id="workplace_q_6_value" class="form-select"
                                                    placeholder="Pemenuhan">
                                                    <option value="Ya">Ya</option>
                                                    <option value="Tidak">Tidak</option>
                                                    <option value="N/A">N/A</option>
                                                </x-inputs.select2>
                                                <div x-cloak
                                                    x-show="workplace_q_6_value === 'Tidak' || workplace_q_6_value === '5' ">
                                                    <div>
                                                        <x-kplh-texteditor wire:model="workplace_q_6_note"
                                                            id="workplace_q_6_note" placeholder="Keterangan"
                                                            :error="'workplace_q_6_note'" />
                                                    </div>
                                                    <div class="mt-3">
                                                        <x-kplh-file wire:model="workplace_q_6_file"
                                                            id="workplace_q_6_file" placeholder="Upload foto temuan"
                                                            :error="'workplace_q_6_file'" />
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div><!-- /.form-group workplace_q_6 -->

                                    <div class="row form-group mb-4">
                                        <label for="workplace_q_7_label"
                                            class="col-lg-4 col-md-12 col-form-label">Apakah bahan kimia B3 disimpan
                                            pada tempat penyimpanan yang baik?
                                        </label>
                                        <div class="col-lg-8 col-md-12">
                                            <div class="wrapper_workplace_q_7 d-flex flex-column gap-3"
                                                x-data="{ workplace_q_7_value: @entangle('workplace_q_7_value') }">
                                                <x-inputs.select2 wire:model="workplace_q_7_value"
                                                    id="workplace_q_7_value" class="form-select"
                                                    placeholder="Pemenuhan">
                                                    <option value="Ya">Ya</option>
                                                    <option value="Tidak">Tidak</option>
                                                    <option value="N/A">N/A</option>
                                                </x-inputs.select2>
                                                <div x-cloak
                                                    x-show="workplace_q_7_value === 'Tidak' || workplace_q_7_value === '5' ">
                                                    <div>
                                                        <x-kplh-texteditor wire:model="workplace_q_7_note"
                                                            id="workplace_q_7_note" placeholder="Keterangan"
                                                            :error="'workplace_q_7_note'" />
                                                    </div>
                                                    <div class="mt-3">
                                                        <x-kplh-file wire:model="workplace_q_7_file"
                                                            id="workplace_q_7_file" placeholder="Upload foto temuan"
                                                            :error="'workplace_q_7_file'" />
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div><!-- /.form-group workplace_q_7 -->

                                    <div class="row form-group mb-4">
                                        <label for="workplace_q_8_label"
                                            class="col-lg-4 col-md-12 col-form-label">Apakah tempat penyimpanan bahan
                                            B3 memiliki sistem ventilasi yang baik?
                                        </label>
                                        <div class="col-lg-8 col-md-12">
                                            <div class="wrapper_workplace_q_8 d-flex flex-column gap-3"
                                                x-data="{ workplace_q_8_value: @entangle('workplace_q_8_value') }">
                                                <x-inputs.select2 wire:model="workplace_q_8_value"
                                                    id="workplace_q_8_value" class="form-select"
                                                    placeholder="Pemenuhan">
                                                    <option value="Ya">Ya</option>
                                                    <option value="Tidak">Tidak</option>
                                                    <option value="N/A">N/A</option>
                                                </x-inputs.select2>
                                                <div x-cloak
                                                    x-show="workplace_q_8_value === 'Tidak' || workplace_q_8_value === '5' ">
                                                    <div>
                                                        <x-kplh-texteditor wire:model="workplace_q_8_note"
                                                            id="workplace_q_8_note" placeholder="Keterangan"
                                                            :error="'workplace_q_8_note'" />
                                                    </div>
                                                    <div class="mt-3">
                                                        <x-kplh-file wire:model="workplace_q_8_file"
                                                            id="workplace_q_8_file" placeholder="Upload foto temuan"
                                                            :error="'workplace_q_8_file'" />
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div><!-- /.form-group workplace_q_8 -->

                                    <div class="row form-group mb-4">
                                        <label for="workplace_q_9_label"
                                            class="col-lg-4 col-md-12 col-form-label">Apakah tempat penyimpanan bahan
                                            B3 memiliki rambu “Penyimpanan bahan Kimia”
                                        </label>
                                        <div class="col-lg-8 col-md-12">
                                            <div class="wrapper_workplace_q_9 d-flex flex-column gap-3"
                                                x-data="{ workplace_q_9_value: @entangle('workplace_q_9_value') }">
                                                <x-inputs.select2 wire:model="workplace_q_9_value"
                                                    id="workplace_q_9_value" class="form-select"
                                                    placeholder="Pemenuhan">
                                                    <option value="Ya">Ya</option>
                                                    <option value="Tidak">Tidak</option>
                                                    <option value="N/A">N/A</option>
                                                </x-inputs.select2>
                                                <div x-cloak
                                                    x-show="workplace_q_9_value === 'Tidak' || workplace_q_9_value === '5' ">
                                                    <div>
                                                        <x-kplh-texteditor wire:model="workplace_q_9_note"
                                                            id="workplace_q_9_note" placeholder="Keterangan"
                                                            :error="'workplace_q_9_note'" />
                                                    </div>
                                                    <div class="mt-3">
                                                        <x-kplh-file wire:model="workplace_q_9_file"
                                                            id="workplace_q_9_file" placeholder="Upload foto temuan"
                                                            :error="'workplace_q_9_file'" />
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div><!-- /.form-group workplace_q_9 -->

                                    <div class="row form-group mb-4">
                                        <label for="workplace_q_10_label"
                                            class="col-lg-4 col-md-12 col-form-label">Apakah tempat penyimpanan
                                            kontainer-kontainer bahan B3 memiliki pemadam api yang sesuai dan MSDS
                                            Register?
                                        </label>
                                        <div class="col-lg-8 col-md-12">
                                            <div class="wrapper_workplace_q_10 d-flex flex-column gap-3"
                                                x-data="{ workplace_q_10_value: @entangle('workplace_q_10_value') }">
                                                <x-inputs.select2 wire:model="workplace_q_10_value"
                                                    id="workplace_q_10_value" class="form-select"
                                                    placeholder="Pemenuhan">
                                                    <option value="Ya">Ya</option>
                                                    <option value="Tidak">Tidak</option>
                                                    <option value="N/A">N/A</option>
                                                </x-inputs.select2>
                                                <div x-cloak
                                                    x-show="workplace_q_10_value === 'Tidak' || workplace_q_10_value === '5' ">
                                                    <div>
                                                        <x-kplh-texteditor wire:model="workplace_q_10_note"
                                                            id="workplace_q_10_note" placeholder="Keterangan"
                                                            :error="'workplace_q_10_note'" />
                                                    </div>
                                                    <div class="mt-3">
                                                        <x-kplh-file wire:model="workplace_q_10_file"
                                                            id="workplace_q_10_file"
                                                            placeholder="Upload foto temuan" :error="'workplace_q_10_file'" />
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div><!-- /.form-group workplace_q_10 -->

                                </div><!-- ./content-workplace_q -->

                            </div>
                        </div><!-- /.workplace_q -->

                        <div id="workplace_r" class="section-workplace_r" x-data="{ accordionOpen: false }">
                            <button
                                class="header-accordion d-flex justify-content-between w-100 border-0 bg-white py-3 px-0"
                                @click.prevent="accordionOpen = ! accordionOpen">
                                <h6 class="mb-0 fw-normal title-accordion">R. MANAJEMEN SAMPAH (WASTE MANAGEMENT)</h6>
                                <span x-bind:class="accordionOpen ? 'open' : ''"><img
                                        src="{{ asset('/images/icons/angle-down.png') }}" alt="" /></span>
                            </button>
                            <div class="wrapper-content-accordion max-h-0 overflow-hidden position-relative transition-all duration-700"
                                x-ref="workplace_r" x-bind:style="accordionOpen ? 'max-height: ' + 20000 + 'px' : ''"
                                x-transition.delay.5000ms>

                                <div class="content-section p-4" wire:ignore.self>

                                    <div class="row form-group mb-4">
                                        <label for="workplace_r_1_label"
                                            class="col-lg-4 col-md-12 col-form-label">Apakah terdapat tempat sampah
                                            organik dan tempat sampah non-organik? Dalam kondisi dan berfungsi baik?
                                        </label>
                                        <div class="col-lg-8 col-md-12">
                                            <div class="wrapper_workplace_r_1 d-flex flex-column gap-3"
                                                x-data="{ workplace_r_1_value: @entangle('workplace_r_1_value') }">
                                                <x-inputs.select2 wire:model="workplace_r_1_value"
                                                    id="workplace_r_1_value" class="form-select"
                                                    placeholder="Pemenuhan">
                                                    <option value="Ya">Ya</option>
                                                    <option value="Tidak">Tidak</option>
                                                    <option value="N/A">N/A</option>
                                                </x-inputs.select2>

                                                <div x-cloak
                                                    x-show="workplace_r_1_value === 'Tidak' || workplace_r_1_value === '5' ">
                                                    <div>
                                                        <x-kplh-texteditor wire:model="workplace_r_1_note"
                                                            id="workplace_r_1_note" placeholder="Keterangan"
                                                            :error="'workplace_r_1_note'" />
                                                    </div>
                                                    <div class="mt-3">
                                                        <x-kplh-file wire:model="workplace_r_1_file"
                                                            id="workplace_r_1_file" placeholder="Upload foto temuan"
                                                            :error="'workplace_r_1_file'" />
                                                    </div>
                                                </div>

                                            </div>
                                        </div>
                                    </div><!-- /.form-group workplace_r_1 -->

                                    <div class="row form-group mb-4">
                                        <label for="workplace_r_2_label"
                                            class="col-lg-4 col-md-12 col-form-label">Apakah sampah-sampah terpisahkan
                                            saat membuangnya pada tempat sampah (tidak bercampur)?
                                        </label>
                                        <div class="col-lg-8 col-md-12">
                                            <div class="wrapper_workplace_r_2 d-flex flex-column gap-3"
                                                x-data="{ workplace_r_2_value: @entangle('workplace_r_2_value') }">
                                                <x-inputs.select2 wire:model="workplace_r_2_value"
                                                    id="workplace_r_2_value" class="form-select"
                                                    placeholder="Pemenuhan">
                                                    <option value="Ya">Ya</option>
                                                    <option value="Tidak">Tidak</option>
                                                    <option value="N/A">N/A</option>
                                                </x-inputs.select2>
                                                <div x-cloak
                                                    x-show="workplace_r_2_value === 'Tidak' || workplace_r_2_value === '5' ">
                                                    <div>
                                                        <x-kplh-texteditor wire:model="workplace_r_2_note"
                                                            id="workplace_r_2_note" placeholder="Keterangan"
                                                            :error="'workplace_r_2_note'" />
                                                    </div>
                                                    <div class="mt-3">
                                                        <x-kplh-file wire:model="workplace_r_2_file"
                                                            id="workplace_r_2_file" placeholder="Upload foto temuan"
                                                            :error="'workplace_r_2_file'" />
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div><!-- /.form-group workplace_r_2 -->

                                    <div class="row form-group mb-4">
                                        <label for="workplace_r_3_label"
                                            class="col-lg-4 col-md-12 col-form-label">Apakah tempat sampah dikosongkan
                                            secara rutin setiap hari dari lokasi kerja?
                                        </label>
                                        <div class="col-lg-8 col-md-12">
                                            <div class="wrapper_workplace_r_3 d-flex flex-column gap-3"
                                                x-data="{ workplace_r_3_value: @entangle('workplace_r_3_value') }">
                                                <x-inputs.select2 wire:model="workplace_r_3_value"
                                                    id="workplace_r_3_value" class="form-select"
                                                    placeholder="Pemenuhan">
                                                    <option value="Ya">Ya</option>
                                                    <option value="Tidak">Tidak</option>
                                                    <option value="N/A">N/A</option>
                                                </x-inputs.select2>
                                                <div x-cloak
                                                    x-show="workplace_r_3_value === 'Tidak' || workplace_r_3_value === '5' ">
                                                    <div>
                                                        <x-kplh-texteditor wire:model="workplace_r_3_note"
                                                            id="workplace_r_3_note" placeholder="Keterangan"
                                                            :error="'workplace_r_3_note'" />
                                                    </div>
                                                    <div class="mt-3">
                                                        <x-kplh-file wire:model="workplace_r_3_file"
                                                            id="workplace_r_3_file" placeholder="Upload foto temuan"
                                                            :error="'workplace_r_3_file'" />
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div><!-- /.form-group workplace_r_3 -->

                                    <div class="row form-group mb-4">
                                        <label for="workplace_r_4_label"
                                            class="col-lg-4 col-md-12 col-form-label">Apakah sampah-sampah besi,
                                            kaleng, atau logam lainnya itu dipisahkan pada tempat sampah khusus?
                                        </label>
                                        <div class="col-lg-8 col-md-12">
                                            <div class="wrapper_workplace_r_4 d-flex flex-column gap-3"
                                                x-data="{ workplace_r_4_value: @entangle('workplace_r_4_value') }">
                                                <x-inputs.select2 wire:model="workplace_r_4_value"
                                                    id="workplace_r_4_value" class="form-select"
                                                    placeholder="Pemenuhan">
                                                    <option value="Ya">Ya</option>
                                                    <option value="Tidak">Tidak</option>
                                                    <option value="N/A">N/A</option>
                                                </x-inputs.select2>
                                                <div x-cloak
                                                    x-show="workplace_r_4_value === 'Tidak' || workplace_r_4_value === '5' ">
                                                    <div>
                                                        <x-kplh-texteditor wire:model="workplace_r_4_note"
                                                            id="workplace_r_4_note" placeholder="Keterangan"
                                                            :error="'workplace_r_4_note'" />
                                                    </div>
                                                    <div class="mt-3">
                                                        <x-kplh-file wire:model="workplace_r_4_file"
                                                            id="workplace_r_4_file" placeholder="Upload foto temuan"
                                                            :error="'workplace_r_4_file'" />
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div><!-- /.form-group workplace_r_4 -->

                                    <div class="row form-group mb-4">
                                        <label for="workplace_r_5_label"
                                            class="col-lg-4 col-md-12 col-form-label">Apakah sampah-sampah yang belum
                                            dikosongkan atau dipindahkan dari lokasi kerja itu telah dikumpulkan atau
                                            diletakkan pada jarak yang aman dari lokasi kerja?
                                        </label>
                                        <div class="col-lg-8 col-md-12">
                                            <div class="wrapper_workplace_r_5 d-flex flex-column gap-3"
                                                x-data="{ workplace_r_5_value: @entangle('workplace_r_5_value') }">
                                                <x-inputs.select2 wire:model="workplace_r_5_value"
                                                    id="workplace_r_5_value" class="form-select"
                                                    placeholder="Pemenuhan">
                                                    <option value="Ya">Ya</option>
                                                    <option value="Tidak">Tidak</option>
                                                    <option value="N/A">N/A</option>
                                                </x-inputs.select2>
                                                <div x-cloak
                                                    x-show="workplace_r_5_value === 'Tidak' || workplace_r_5_value === '5' ">
                                                    <div>
                                                        <x-kplh-texteditor wire:model="workplace_r_5_note"
                                                            id="workplace_r_5_note" placeholder="Keterangan"
                                                            :error="'workplace_r_5_note'" />
                                                    </div>
                                                    <div class="mt-3">
                                                        <x-kplh-file wire:model="workplace_r_5_file"
                                                            id="workplace_r_5_file" placeholder="Upload foto temuan"
                                                            :error="'workplace_r_5_file'" />
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div><!-- /.form-group workplace_r_5 -->

                                </div><!-- ./content-workplace_r -->

                            </div>
                        </div><!-- /.workplace_r -->

                        <div id="workplace_s" class="section-workplace_s" x-data="{ accordionOpen: false }">
                            <button
                                class="header-accordion d-flex justify-content-between w-100 border-0 bg-white py-3 px-0"
                                @click.prevent="accordionOpen = ! accordionOpen">
                                <h6 class="mb-0 fw-normal title-accordion">S. GAWAT DARURAT dan P3K (EMERGENCY and
                                    FIRST AID)</h6>
                                <span x-bind:class="accordionOpen ? 'open' : ''"><img
                                        src="{{ asset('/images/icons/angle-down.png') }}" alt="" /></span>
                            </button>
                            <div class="wrapper-content-accordion max-h-0 overflow-hidden position-relative transition-all duration-700"
                                x-ref="workplace_s" x-bind:style="accordionOpen ? 'max-height: ' + 20000 + 'px' : ''"
                                x-transition.delay.5000ms>

                                <div class="content-section p-4" wire:ignore.self>

                                    <div class="row form-group mb-4">
                                        <label for="workplace_s_1_label"
                                            class="col-lg-4 col-md-12 col-form-label">Apakah terdapat kotak P3K di
                                            lokasi kerja?
                                        </label>
                                        <div class="col-lg-8 col-md-12">
                                            <div class="wrapper_workplace_s_1 d-flex flex-column gap-3"
                                                x-data="{ workplace_s_1_value: @entangle('workplace_s_1_value') }">
                                                <x-inputs.select2 wire:model="workplace_s_1_value"
                                                    id="workplace_s_1_value" class="form-select"
                                                    placeholder="Pemenuhan">
                                                    <option value="Ya">Ya</option>
                                                    <option value="Tidak">Tidak</option>
                                                    <option value="N/A">N/A</option>
                                                </x-inputs.select2>

                                                <div x-cloak
                                                    x-show="workplace_s_1_value === 'Tidak' || workplace_s_1_value === '5' ">
                                                    <div>
                                                        <x-kplh-texteditor wire:model="workplace_s_1_note"
                                                            id="workplace_s_1_note" placeholder="Keterangan"
                                                            :error="'workplace_s_1_note'" />
                                                    </div>
                                                    <div class="mt-3">
                                                        <x-kplh-file wire:model="workplace_s_1_file"
                                                            id="workplace_s_1_file" placeholder="Upload foto temuan"
                                                            :error="'workplace_s_1_file'" />
                                                    </div>
                                                </div>

                                            </div>
                                        </div>
                                    </div><!-- /.form-group workplace_s_1 -->

                                    <div class="row form-group mb-4">
                                        <label for="workplace_s_2_label"
                                            class="col-lg-4 col-md-12 col-form-label">Apakah ditunjuk karyawan yang
                                            bertanggung jawab dalam memberikan P3K dan telah mengikuti pelatihan P3K?
                                        </label>
                                        <div class="col-lg-8 col-md-12">
                                            <div class="wrapper_workplace_s_2 d-flex flex-column gap-3"
                                                x-data="{ workplace_s_2_value: @entangle('workplace_s_2_value') }">
                                                <x-inputs.select2 wire:model="workplace_s_2_value"
                                                    id="workplace_s_2_value" class="form-select"
                                                    placeholder="Pemenuhan">
                                                    <option value="Ya">Ya</option>
                                                    <option value="Tidak">Tidak</option>
                                                    <option value="N/A">N/A</option>
                                                </x-inputs.select2>
                                                <div x-cloak
                                                    x-show="workplace_s_2_value === 'Tidak' || workplace_s_2_value === '5' ">
                                                    <div>
                                                        <x-kplh-texteditor wire:model="workplace_s_2_note"
                                                            id="workplace_s_2_note" placeholder="Keterangan"
                                                            :error="'workplace_s_2_note'" />
                                                    </div>
                                                    <div class="mt-3">
                                                        <x-kplh-file wire:model="workplace_s_2_file"
                                                            id="workplace_s_2_file" placeholder="Upload foto temuan"
                                                            :error="'workplace_s_2_file'" />
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div><!-- /.form-group workplace_s_2 -->

                                    <div class="row form-group mb-4">
                                        <label for="workplace_s_3_label"
                                            class="col-lg-4 col-md-12 col-form-label">Apakah kotak P3K diinspeksi
                                            secara rutin?
                                        </label>
                                        <div class="col-lg-8 col-md-12">
                                            <div class="wrapper_workplace_s_3 d-flex flex-column gap-3"
                                                x-data="{ workplace_s_3_value: @entangle('workplace_s_3_value') }">
                                                <x-inputs.select2 wire:model="workplace_s_3_value"
                                                    id="workplace_s_3_value" class="form-select"
                                                    placeholder="Pemenuhan">
                                                    <option value="Ya">Ya</option>
                                                    <option value="Tidak">Tidak</option>
                                                    <option value="N/A">N/A</option>
                                                </x-inputs.select2>
                                                <div x-cloak
                                                    x-show="workplace_s_3_value === 'Tidak' || workplace_s_3_value === '5' ">
                                                    <div>
                                                        <x-kplh-texteditor wire:model="workplace_s_3_note"
                                                            id="workplace_s_3_note" placeholder="Keterangan"
                                                            :error="'workplace_s_3_note'" />
                                                    </div>
                                                    <div class="mt-3">
                                                        <x-kplh-file wire:model="workplace_s_3_file"
                                                            id="workplace_s_3_file" placeholder="Upload foto temuan"
                                                            :error="'workplace_s_3_file'" />
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div><!-- /.form-group workplace_s_3 -->

                                    <div class="row form-group mb-4">
                                        <label for="workplace_s_4_label"
                                            class="col-lg-4 col-md-12 col-form-label">Apakah kotak P3K terdapat lembar
                                            registrasi penggunaan kotak P3K? Terisi dengan baik dan memadai?
                                        </label>
                                        <div class="col-lg-8 col-md-12">
                                            <div class="wrapper_workplace_s_4 d-flex flex-column gap-3"
                                                x-data="{ workplace_s_4_value: @entangle('workplace_s_4_value') }">
                                                <x-inputs.select2 wire:model="workplace_s_4_value"
                                                    id="workplace_s_4_value" class="form-select"
                                                    placeholder="Pemenuhan">
                                                    <option value="Ya">Ya</option>
                                                    <option value="Tidak">Tidak</option>
                                                    <option value="N/A">N/A</option>
                                                </x-inputs.select2>
                                                <div x-cloak
                                                    x-show="workplace_s_4_value === 'Tidak' || workplace_s_4_value === '5' ">
                                                    <div>
                                                        <x-kplh-texteditor wire:model="workplace_s_4_note"
                                                            id="workplace_s_4_note" placeholder="Keterangan"
                                                            :error="'workplace_s_4_note'" />
                                                    </div>
                                                    <div class="mt-3">
                                                        <x-kplh-file wire:model="workplace_s_4_file"
                                                            id="workplace_s_4_file" placeholder="Upload foto temuan"
                                                            :error="'workplace_s_4_file'" />
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div><!-- /.form-group workplace_s_4 -->

                                    <div class="row form-group mb-4">
                                        <label for="workplace_s_5_label"
                                            class="col-lg-4 col-md-12 col-form-label">Apakah pemadam api telah
                                            diinspeksi dan kondisi baik?
                                        </label>
                                        <div class="col-lg-8 col-md-12">
                                            <div class="wrapper_workplace_s_5 d-flex flex-column gap-3"
                                                x-data="{ workplace_s_5_value: @entangle('workplace_s_5_value') }">
                                                <x-inputs.select2 wire:model="workplace_s_5_value"
                                                    id="workplace_s_5_value" class="form-select"
                                                    placeholder="Pemenuhan">
                                                    <option value="Ya">Ya</option>
                                                    <option value="Tidak">Tidak</option>
                                                    <option value="N/A">N/A</option>
                                                </x-inputs.select2>
                                                <div x-cloak
                                                    x-show="workplace_s_5_value === 'Tidak' || workplace_s_5_value === '5' ">
                                                    <div>
                                                        <x-kplh-texteditor wire:model="workplace_s_5_note"
                                                            id="workplace_s_5_note" placeholder="Keterangan"
                                                            :error="'workplace_s_5_note'" />
                                                    </div>
                                                    <div class="mt-3">
                                                        <x-kplh-file wire:model="workplace_s_5_file"
                                                            id="workplace_s_5_file" placeholder="Upload foto temuan"
                                                            :error="'workplace_s_5_file'" />
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div><!-- /.form-group workplace_s_5 -->

                                    <div class="row form-group mb-4">
                                        <label for="workplace_s_6_label"
                                            class="col-lg-4 col-md-12 col-form-label">Apakah rambu pemadam api
                                            tersedia? Dipasang dengan benar?
                                        </label>
                                        <div class="col-lg-8 col-md-12">
                                            <div class="wrapper_workplace_s_6 d-flex flex-column gap-3"
                                                x-data="{ workplace_s_6_value: @entangle('workplace_s_6_value') }">
                                                <x-inputs.select2 wire:model="workplace_s_6_value"
                                                    id="workplace_s_6_value" class="form-select"
                                                    placeholder="Pemenuhan">
                                                    <option value="Ya">Ya</option>
                                                    <option value="Tidak">Tidak</option>
                                                    <option value="N/A">N/A</option>
                                                </x-inputs.select2>
                                                <div x-cloak
                                                    x-show="workplace_s_6_value === 'Tidak' || workplace_s_6_value === '5' ">
                                                    <div>
                                                        <x-kplh-texteditor wire:model="workplace_s_6_note"
                                                            id="workplace_s_6_note" placeholder="Keterangan"
                                                            :error="'workplace_s_6_note'" />
                                                    </div>
                                                    <div class="mt-3">
                                                        <x-kplh-file wire:model="workplace_s_6_file"
                                                            id="workplace_s_6_file" placeholder="Upload foto temuan"
                                                            :error="'workplace_s_6_file'" />
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div><!-- /.form-group workplace_s_6 -->

                                    <div class="row form-group mb-4">
                                        <label for="workplace_s_7_label"
                                            class="col-lg-4 col-md-12 col-form-label">Apakah Emergency Layout
                                            tersedia? ditempatkan dengan benar?
                                        </label>
                                        <div class="col-lg-8 col-md-12">
                                            <div class="wrapper_workplace_s_7 d-flex flex-column gap-3"
                                                x-data="{ workplace_s_7_value: @entangle('workplace_s_7_value') }">
                                                <x-inputs.select2 wire:model="workplace_s_7_value"
                                                    id="workplace_s_7_value" class="form-select"
                                                    placeholder="Pemenuhan">
                                                    <option value="Ya">Ya</option>
                                                    <option value="Tidak">Tidak</option>
                                                    <option value="N/A">N/A</option>
                                                </x-inputs.select2>
                                                <div x-cloak
                                                    x-show="workplace_s_7_value === 'Tidak' || workplace_s_7_value === '5' ">
                                                    <div>
                                                        <x-kplh-texteditor wire:model="workplace_s_7_note"
                                                            id="workplace_s_7_note" placeholder="Keterangan"
                                                            :error="'workplace_s_7_note'" />
                                                    </div>
                                                    <div class="mt-3">
                                                        <x-kplh-file wire:model="workplace_s_7_file"
                                                            id="workplace_s_7_file" placeholder="Upload foto temuan"
                                                            :error="'workplace_s_7_file'" />
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div><!-- /.form-group workplace_s_7 -->

                                    <div class="row form-group mb-4">
                                        <label for="workplace_s_8_label"
                                            class="col-lg-4 col-md-12 col-form-label">Apakah karyawan mengetahui
                                            Tempat Berkumpul terdekat?
                                        </label>
                                        <div class="col-lg-8 col-md-12">
                                            <div class="wrapper_workplace_s_8 d-flex flex-column gap-3"
                                                x-data="{ workplace_s_8_value: @entangle('workplace_s_8_value') }">
                                                <x-inputs.select2 wire:model="workplace_s_8_value"
                                                    id="workplace_s_8_value" class="form-select"
                                                    placeholder="Pemenuhan">
                                                    <option value="Ya">Ya</option>
                                                    <option value="Tidak">Tidak</option>
                                                    <option value="N/A">N/A</option>
                                                </x-inputs.select2>
                                                <div x-cloak
                                                    x-show="workplace_s_8_value === 'Tidak' || workplace_s_8_value === '5' ">
                                                    <div>
                                                        <x-kplh-texteditor wire:model="workplace_s_8_note"
                                                            id="workplace_s_8_note" placeholder="Keterangan"
                                                            :error="'workplace_s_8_note'" />
                                                    </div>
                                                    <div class="mt-3">
                                                        <x-kplh-file wire:model="workplace_s_8_file"
                                                            id="workplace_s_8_file" placeholder="Upload foto temuan"
                                                            :error="'workplace_s_8_file'" />
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div><!-- /.form-group workplace_s_8 -->

                                    <div class="row form-group mb-4">
                                        <label for="workplace_s_9_label"
                                            class="col-lg-4 col-md-12 col-form-label">Apakah Eye and Body Wash Station
                                            tersedia? Dalam kondisi dan berfungsi dengan baik?
                                        </label>
                                        <div class="col-lg-8 col-md-12">
                                            <div class="wrapper_workplace_s_9 d-flex flex-column gap-3"
                                                x-data="{ workplace_s_9_value: @entangle('workplace_s_9_value') }">
                                                <x-inputs.select2 wire:model="workplace_s_9_value"
                                                    id="workplace_s_9_value" class="form-select"
                                                    placeholder="Pemenuhan">
                                                    <option value="Ya">Ya</option>
                                                    <option value="Tidak">Tidak</option>
                                                    <option value="N/A">N/A</option>
                                                </x-inputs.select2>
                                                <div x-cloak
                                                    x-show="workplace_s_9_value === 'Tidak' || workplace_s_9_value === '5' ">
                                                    <div>
                                                        <x-kplh-texteditor wire:model="workplace_s_9_note"
                                                            id="workplace_s_9_note" placeholder="Keterangan"
                                                            :error="'workplace_s_9_note'" />
                                                    </div>
                                                    <div class="mt-3">
                                                        <x-kplh-file wire:model="workplace_s_9_file"
                                                            id="workplace_s_9_file" placeholder="Upload foto temuan"
                                                            :error="'workplace_s_9_file'" />
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div><!-- /.form-group workplace_s_9 -->

                                </div><!-- ./content-workplace_s -->

                            </div>
                        </div><!-- /.workplace_s -->

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
                                <button type="submit" wire:click="$set('mode','save')"
                                    class="btn btn-outline-default bg-green d-flex justify-content-center align-item-center text-white position-relative px-4">Save</button>

                            </div>
                        </div>

                    </form>

                </div>
            </div>
        </div>
    </div><!-- /.content-inspeksi-area-maintank -->

</div><!-- /.inner-content -->
