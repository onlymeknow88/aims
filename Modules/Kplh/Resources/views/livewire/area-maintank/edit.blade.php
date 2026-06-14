<div class="inner-content">

    <div
        class="header-content-inspeksi-area-maintank h-60px bg-white shadow-sm d-flex gap-2 align-items-center justify-content-between px-3">
        <div class="left-header">
            <a href="javascript:history.go(-1)" class="d-flex align-items-center gap-3">
                <span><i class="fa-solid fa-arrow-left"></i></span>
                <span>Inspeksi Area Maintank</span>
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
                            <h4>Inspeksi Area Maintank</h4>
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

                        <div id="pipes" class="section-pipes" x-data="{ accordionOpen: false }">
                            <button
                                class="header-accordion d-flex justify-content-between w-100 border-0 bg-white py-3 px-0"
                                @click.prevent="accordionOpen = ! accordionOpen">
                                <h6 class="mb-0 fw-normal title-accordion">A. Jalur Pipa</h6>
                                <span x-bind:class="accordionOpen ? 'open' : ''"><img
                                        src="{{ asset('/images/icons/angle-down.png') }}" alt="" /></span>
                            </button>
                            <div class="wrapper-content-accordion max-h-0 overflow-hidden position-relative transition-all duration-700"
                                x-ref="pipes" x-bind:style="accordionOpen ? 'max-height: ' + 20000 + 'px' : ''"
                                x-transition.delay.5000ms>

                                <div class="content-section p-4" wire:ignore.self>

                                    <div class="row form-group mb-4">
                                        <h4 class="col-lg-12 col-md-12 col-form-label">1. Pipa
                                        </h4>
                                    </div>

                                    <div class="row form-group mb-4">
                                        <label for="maintank_pipes_1_1_label"
                                            class="col-lg-4 col-md-12 col-form-label">Pastikan tidak ada rembesan atau
                                            retakan pada pipa.
                                        </label>
                                        <div class="col-lg-8 col-md-12">
                                            <div class="wrapper_maintank_pipes_1_1 d-flex flex-column gap-3"
                                                x-data="{ maintank_pipes_1_1_value: @entangle('maintank_pipes_1_1_value') }">
                                                <x-inputs.select2 wire:model="maintank_pipes_1_1_value"
                                                    id="maintank_pipes_1_1_value" class="form-select"
                                                    placeholder="Pemenuhan">
                                                    <option value="Ya">Ya</option>
                                                    <option value="Tidak">Tidak</option>
                                                    <option value="N/A">N/A</option>
                                                </x-inputs.select2>

                                                <div x-cloak
                                                    x-show="maintank_pipes_1_1_value === 'Tidak' || maintank_pipes_1_1_value === '5' ">
                                                    <div>
                                                        <x-kplh-texteditor wire:model="maintank_pipes_1_1_note"
                                                            id="maintank_pipes_1_1_note" placeholder="Keterangan"
                                                            :error="'maintank_pipes_1_1_note'" />
                                                    </div>
                                                    @if ($maintank_pipes_1_1_file && !Illuminate\Support\Str::contains($maintank_pipes_1_1_file, 'private/var/folders/'))
                                                        <div class="row mt-3">
                                                            <div class="col-md-3"><button type="button"
                                                                    class="btn btn-outline-secondary"
                                                                    wire:click="setFileNull('maintank_pipes_1_1_file')"><i
                                                                        class="fa fa-edit"></i> Ubah
                                                                    File</button></div>
                                                            <div class="col-md-9">
                                                                <a class="btn btn-outline-secondary"
                                                                    href="{{ route('kplh::download-file', ['maintank', $maintank_pipes_1_1_file]) }}"
                                                                    target="_blank"><i class="fa fa-file"></i>
                                                                    {{ Illuminate\Support\Str::limit($maintank_pipes_1_1_file, 30) }}</a>
                                                            </div>
                                                        </div>
                                                    @else
                                                        <div class="col-md-12 mt-3">
                                                            <x-kplh-file wire:model="maintank_pipes_1_1_file"
                                                                id="maintank_pipes_1_1_file" placeholder="File"
                                                                :error="'maintank_pipes_1_1_file'" />
                                                        </div>
                                                    @endif
                                                </div>

                                            </div>
                                        </div>
                                    </div><!-- /.form-group maintank_pipes_1_1 -->

                                    <div class="row form-group mb-4">
                                        <h4 class="col-lg-12 col-md-12 col-form-label">2. Sambungan antar Pipa</h4>
                                    </div>

                                    <div class="row form-group mb-4">
                                        <label for="maintank_pipes_2_1_label"
                                            class="col-lg-4 col-md-12 col-form-label">Pastikan terdapat packing/
                                            gasket.
                                        </label>
                                        <div class="col-lg-8 col-md-12">
                                            <div class="wrapper_maintank_pipes_2_1 d-flex flex-column gap-3"
                                                x-data="{ maintank_pipes_2_1_value: @entangle('maintank_pipes_2_1_value') }">
                                                <x-inputs.select2 wire:model="maintank_pipes_2_1_value"
                                                    id="maintank_pipes_2_1_value" class="form-select"
                                                    placeholder="Pemenuhan">
                                                    <option value="Ya">Ya</option>
                                                    <option value="Tidak">Tidak</option>
                                                    <option value="N/A">N/A</option>
                                                </x-inputs.select2>

                                                <div x-cloak
                                                    x-show="maintank_pipes_2_1_value === 'Tidak' || maintank_pipes_2_1_value === '5' ">
                                                    <div>
                                                        <x-kplh-texteditor wire:model="maintank_pipes_2_1_note"
                                                            id="maintank_pipes_2_1_note" placeholder="Keterangan"
                                                            :error="'maintank_pipes_2_1_note'" />
                                                    </div>
                                                    @if ($maintank_pipes_2_1_file && !Illuminate\Support\Str::contains($maintank_pipes_2_1_file, 'private/var/folders/'))
                                                        <div class="row mt-3">
                                                            <div class="col-md-3"><button type="button"
                                                                    class="btn btn-outline-secondary"
                                                                    wire:click="setFileNull('maintank_pipes_2_1_file')"><i
                                                                        class="fa fa-edit"></i> Ubah
                                                                    File</button></div>
                                                            <div class="col-md-9">
                                                                <a class="btn btn-outline-secondary"
                                                                    href="{{ route('kplh::download-file', ['maintank', $maintank_pipes_2_1_file]) }}"
                                                                    target="_blank"><i class="fa fa-file"></i>
                                                                    {{ Illuminate\Support\Str::limit($maintank_pipes_2_1_file, 30) }}</a>
                                                            </div>
                                                        </div>
                                                    @else
                                                        <div class="col-md-12 mt-3">
                                                            <x-kplh-file wire:model="maintank_pipes_2_1_file"
                                                                id="maintank_pipes_2_1_file" placeholder="File"
                                                                :error="'maintank_pipes_2_1_file'" />
                                                        </div>
                                                    @endif
                                                </div>

                                            </div>
                                        </div>
                                    </div><!-- /.form-group maintank_pipes_2_1 -->

                                    <div class="row form-group mb-4">
                                        <label for="maintank_pipes_2_2_label"
                                            class="col-lg-4 col-md-12 col-form-label">Pastikan sambungan antar pipa
                                            fully bolted.
                                        </label>
                                        <div class="col-lg-8 col-md-12">
                                            <div class="wrapper_maintank_pipes_2_2 d-flex flex-column gap-3"
                                                x-data="{ maintank_pipes_2_2_value: @entangle('maintank_pipes_2_2_value') }">
                                                <x-inputs.select2 wire:model="maintank_pipes_2_2_value"
                                                    id="maintank_pipes_2_2_value" class="form-select"
                                                    placeholder="Pemenuhan">
                                                    <option value="Ya">Ya</option>
                                                    <option value="Tidak">Tidak</option>
                                                    <option value="N/A">N/A</option>
                                                </x-inputs.select2>

                                                <div x-cloak
                                                    x-show="maintank_pipes_2_2_value === 'Tidak' || maintank_pipes_2_2_value === '5' ">
                                                    <div>
                                                        <x-kplh-texteditor wire:model="maintank_pipes_2_2_note"
                                                            id="maintank_pipes_2_2_note" placeholder="Keterangan"
                                                            :error="'maintank_pipes_2_2_note'" />
                                                    </div>
                                                    @if ($maintank_pipes_2_2_file && !Illuminate\Support\Str::contains($maintank_pipes_2_2_file, 'private/var/folders/'))
                                                        <div class="row mt-3">
                                                            <div class="col-md-3"><button type="button"
                                                                    class="btn btn-outline-secondary"
                                                                    wire:click="setFileNull('maintank_pipes_2_2_file')"><i
                                                                        class="fa fa-edit"></i> Ubah
                                                                    File</button></div>
                                                            <div class="col-md-9">
                                                                <a class="btn btn-outline-secondary"
                                                                    href="{{ route('kplh::download-file', ['maintank', $maintank_pipes_2_2_file]) }}"
                                                                    target="_blank"><i class="fa fa-file"></i>
                                                                    {{ Illuminate\Support\Str::limit($maintank_pipes_2_2_file, 30) }}</a>
                                                            </div>
                                                        </div>
                                                    @else
                                                        <div class="col-md-12 mt-3">
                                                            <x-kplh-file wire:model="maintank_pipes_2_2_file"
                                                                id="maintank_pipes_2_2_file" placeholder="File"
                                                                :error="'maintank_pipes_2_2_file'" />
                                                        </div>
                                                    @endif
                                                </div>

                                            </div>
                                        </div>
                                    </div><!-- /.form-group maintank_pipes_2_2 -->

                                    <div class="row form-group mb-4">
                                        <label for="maintank_pipes_2_3_label"
                                            class="col-lg-4 col-md-12 col-form-label">Pastikan tidak ada rembesan pada
                                            sambungan.
                                        </label>
                                        <div class="col-lg-8 col-md-12">
                                            <div class="wrapper_maintank_pipes_2_3 d-flex flex-column gap-3"
                                                x-data="{ maintank_pipes_2_3_value: @entangle('maintank_pipes_2_3_value') }">
                                                <x-inputs.select2 wire:model="maintank_pipes_2_3_value"
                                                    id="maintank_pipes_2_3_value" class="form-select"
                                                    placeholder="Pemenuhan">
                                                    <option value="Ya">Ya</option>
                                                    <option value="Tidak">Tidak</option>
                                                    <option value="N/A">N/A</option>
                                                </x-inputs.select2>

                                                <div x-cloak
                                                    x-show="maintank_pipes_2_3_value === 'Tidak' || maintank_pipes_2_3_value === '5' ">
                                                    <div>
                                                        <x-kplh-texteditor wire:model="maintank_pipes_2_3_note"
                                                            id="maintank_pipes_2_3_note" placeholder="Keterangan"
                                                            :error="'maintank_pipes_2_3_note'" />
                                                    </div>
                                                    @if ($maintank_pipes_2_3_file && !Illuminate\Support\Str::contains($maintank_pipes_2_3_file, 'private/var/folders/'))
                                                        <div class="row mt-3">
                                                            <div class="col-md-3"><button type="button"
                                                                    class="btn btn-outline-secondary"
                                                                    wire:click="setFileNull('maintank_pipes_2_3_file')"><i
                                                                        class="fa fa-edit"></i> Ubah
                                                                    File</button></div>
                                                            <div class="col-md-9">
                                                                <a class="btn btn-outline-secondary"
                                                                    href="{{ route('kplh::download-file', ['maintank', $maintank_pipes_2_3_file]) }}"
                                                                    target="_blank"><i class="fa fa-file"></i>
                                                                    {{ Illuminate\Support\Str::limit($maintank_pipes_2_3_file, 30) }}</a>
                                                            </div>
                                                        </div>
                                                    @else
                                                        <div class="col-md-12 mt-3">
                                                            <x-kplh-file wire:model="maintank_pipes_2_3_file"
                                                                id="maintank_pipes_2_3_file" placeholder="File"
                                                                :error="'maintank_pipes_2_3_file'" />
                                                        </div>
                                                    @endif
                                                </div>

                                            </div>
                                        </div>
                                    </div><!-- /.form-group maintank_pipes_2_3 -->

                                    <div class="row form-group mb-4">
                                        <h4 class="col-lg-12 col-md-12 col-form-label">3. Penahan Pipa</h4>
                                    </div>

                                    <div class="row form-group mb-4">
                                        <label for="maintank_pipes_3_1_label"
                                            class="col-lg-4 col-md-12 col-form-label">Pastikan U-bolt tidak lepas, drat
                                            tidak rusak, tidak dapat diputar dengan tangan.
                                        </label>
                                        <div class="col-lg-8 col-md-12">
                                            <div class="wrapper_maintank_pipes_3_1 d-flex flex-column gap-3"
                                                x-data="{ maintank_pipes_3_1_value: @entangle('maintank_pipes_3_1_value') }">
                                                <x-inputs.select2 wire:model="maintank_pipes_3_1_value"
                                                    id="maintank_pipes_3_1_value" class="form-select"
                                                    placeholder="Pemenuhan">
                                                    <option value="Ya">Ya</option>
                                                    <option value="Tidak">Tidak</option>
                                                    <option value="N/A">N/A</option>
                                                </x-inputs.select2>

                                                <div x-cloak
                                                    x-show="maintank_pipes_3_1_value === 'Tidak' || maintank_pipes_3_1_value === '5' ">
                                                    <div>
                                                        <x-kplh-texteditor wire:model="maintank_pipes_3_1_note"
                                                            id="maintank_pipes_3_1_note" placeholder="Keterangan"
                                                            :error="'maintank_pipes_3_1_note'" />
                                                    </div>
                                                    @if ($maintank_pipes_3_1_file && !Illuminate\Support\Str::contains($maintank_pipes_3_1_file, 'private/var/folders/'))
                                                        <div class="row mt-3">
                                                            <div class="col-md-3"><button type="button"
                                                                    class="btn btn-outline-secondary"
                                                                    wire:click="setFileNull('maintank_pipes_3_1_file')"><i
                                                                        class="fa fa-edit"></i> Ubah
                                                                    File</button></div>
                                                            <div class="col-md-9">
                                                                <a class="btn btn-outline-secondary"
                                                                    href="{{ route('kplh::download-file', ['maintank', $maintank_pipes_3_1_file]) }}"
                                                                    target="_blank"><i class="fa fa-file"></i>
                                                                    {{ Illuminate\Support\Str::limit($maintank_pipes_3_1_file, 30) }}</a>
                                                            </div>
                                                        </div>
                                                    @else
                                                        <div class="col-md-12 mt-3">
                                                            <x-kplh-file wire:model="maintank_pipes_3_1_file"
                                                                id="maintank_pipes_3_1_file" placeholder="File"
                                                                :error="'maintank_pipes_3_1_file'" />
                                                        </div>
                                                    @endif
                                                </div>

                                            </div>
                                        </div>
                                    </div><!-- /.form-group maintank_pipes_3_1 -->

                                    <div class="row form-group mb-4">
                                        <label for="maintank_pipes_3_2_label"
                                            class="col-lg-4 col-md-12 col-form-label">Pastikan Mur untuk pengunci harus
                                            kuat menahan U-bolt dan tidak berputar ketika ada tekanan atau diputar
                                            dengan tangan.
                                        </label>
                                        <div class="col-lg-8 col-md-12">
                                            <div class="wrapper_maintank_pipes_3_2 d-flex flex-column gap-3"
                                                x-data="{ maintank_pipes_3_2_value: @entangle('maintank_pipes_3_2_value') }">
                                                <x-inputs.select2 wire:model="maintank_pipes_3_2_value"
                                                    id="maintank_pipes_3_2_value" class="form-select"
                                                    placeholder="Pemenuhan">
                                                    <option value="Ya">Ya</option>
                                                    <option value="Tidak">Tidak</option>
                                                    <option value="N/A">N/A</option>
                                                </x-inputs.select2>

                                                <div x-cloak
                                                    x-show="maintank_pipes_3_2_value === 'Tidak' || maintank_pipes_3_2_value === '5' ">
                                                    <div>
                                                        <x-kplh-texteditor wire:model="maintank_pipes_3_2_note"
                                                            id="maintank_pipes_3_2_note" placeholder="Keterangan"
                                                            :error="'maintank_pipes_3_2_note'" />
                                                    </div>
                                                    @if ($maintank_pipes_3_2_file && !Illuminate\Support\Str::contains($maintank_pipes_3_2_file, 'private/var/folders/'))
                                                        <div class="row mt-3">
                                                            <div class="col-md-3"><button type="button"
                                                                    class="btn btn-outline-secondary"
                                                                    wire:click="setFileNull('maintank_pipes_3_2_file')"><i
                                                                        class="fa fa-edit"></i> Ubah
                                                                    File</button></div>
                                                            <div class="col-md-9">
                                                                <a class="btn btn-outline-secondary"
                                                                    href="{{ route('kplh::download-file', ['maintank', $maintank_pipes_3_2_file]) }}"
                                                                    target="_blank"><i class="fa fa-file"></i>
                                                                    {{ Illuminate\Support\Str::limit($maintank_pipes_3_2_file, 30) }}</a>
                                                            </div>
                                                        </div>
                                                    @else
                                                        <div class="col-md-12 mt-3">
                                                            <x-kplh-file wire:model="maintank_pipes_3_2_file"
                                                                id="maintank_pipes_3_2_file" placeholder="File"
                                                                :error="'maintank_pipes_3_2_file'" />
                                                        </div>
                                                    @endif
                                                </div>

                                            </div>
                                        </div>
                                    </div><!-- /.form-group maintank_pipes_3_2 -->

                                    <div class="row form-group mb-4">
                                        <label for="maintank_pipes_3_3_label"
                                            class="col-lg-4 col-md-12 col-form-label">Pastikan Pondasi tidak retak,
                                            hancur dan kuat menahan pipa agar tidak turun).
                                        </label>
                                        <div class="col-lg-8 col-md-12">
                                            <div class="wrapper_maintank_pipes_3_3 d-flex flex-column gap-3"
                                                x-data="{ maintank_pipes_3_3_value: @entangle('maintank_pipes_3_3_value') }">
                                                <x-inputs.select2 wire:model="maintank_pipes_3_3_value"
                                                    id="maintank_pipes_3_3_value" class="form-select"
                                                    placeholder="Pemenuhan">
                                                    <option value="Ya">Ya</option>
                                                    <option value="Tidak">Tidak</option>
                                                    <option value="N/A">N/A</option>
                                                </x-inputs.select2>

                                                <div x-cloak
                                                    x-show="maintank_pipes_3_3_value === 'Tidak' || maintank_pipes_3_3_value === '5' ">
                                                    <div>
                                                        <x-kplh-texteditor wire:model="maintank_pipes_3_3_note"
                                                            id="maintank_pipes_3_3_note" placeholder="Keterangan"
                                                            :error="'maintank_pipes_3_3_note'" />
                                                    </div>
                                                    @if ($maintank_pipes_3_3_file && !Illuminate\Support\Str::contains($maintank_pipes_3_3_file, 'private/var/folders/'))
                                                        <div class="row mt-3">
                                                            <div class="col-md-3"><button type="button"
                                                                    class="btn btn-outline-secondary"
                                                                    wire:click="setFileNull('maintank_pipes_3_3_file')"><i
                                                                        class="fa fa-edit"></i> Ubah
                                                                    File</button></div>
                                                            <div class="col-md-9">
                                                                <a class="btn btn-outline-secondary"
                                                                    href="{{ route('kplh::download-file', ['maintank', $maintank_pipes_3_3_file]) }}"
                                                                    target="_blank"><i class="fa fa-file"></i>
                                                                    {{ Illuminate\Support\Str::limit($maintank_pipes_3_3_file, 30) }}</a>
                                                            </div>
                                                        </div>
                                                    @else
                                                        <div class="col-md-12 mt-3">
                                                            <x-kplh-file wire:model="maintank_pipes_3_3_file"
                                                                id="maintank_pipes_3_3_file" placeholder="File"
                                                                :error="'maintank_pipes_3_3_file'" />
                                                        </div>
                                                    @endif
                                                </div>

                                            </div>
                                        </div>
                                    </div><!-- /.form-group maintank_pipes_3_3 -->

                                    <div class="row form-group mb-4">
                                        <label for="maintank_pipes_3_4_label"
                                            class="col-lg-4 col-md-12 col-form-label">Pastikan besi penahan (holder)
                                            tidak patah, bengkok/tidak kuat menahan beban.
                                        </label>
                                        <div class="col-lg-8 col-md-12">
                                            <div class="wrapper_maintank_pipes_3_4 d-flex flex-column gap-3"
                                                x-data="{ maintank_pipes_3_4_value: @entangle('maintank_pipes_3_4_value') }">
                                                <x-inputs.select2 wire:model="maintank_pipes_3_4_value"
                                                    id="maintank_pipes_3_4_value" class="form-select"
                                                    placeholder="Pemenuhan">
                                                    <option value="Ya">Ya</option>
                                                    <option value="Tidak">Tidak</option>
                                                    <option value="N/A">N/A</option>
                                                </x-inputs.select2>

                                                <div x-cloak
                                                    x-show="maintank_pipes_3_4_value === 'Tidak' || maintank_pipes_3_4_value === '5' ">
                                                    <div>
                                                        <x-kplh-texteditor wire:model="maintank_pipes_3_4_note"
                                                            id="maintank_pipes_3_4_note" placeholder="Keterangan"
                                                            :error="'maintank_pipes_3_4_note'" />
                                                    </div>
                                                    <div class="mt-3">
                                                        @if ($maintank_pipes_3_4_file && !Illuminate\Support\Str::contains($maintank_pipes_3_4_file, 'private/var/folders/'))
                                                            <div class="row mt-3">
                                                                <div class="col-md-3"><button type="button"
                                                                        class="btn btn-outline-secondary"
                                                                        wire:click="setFileNull('maintank_pipes_3_4_file')"><i
                                                                            class="fa fa-edit"></i> Ubah
                                                                        File</button></div>
                                                                <div class="col-md-9">
                                                                    <a class="btn btn-outline-secondary"
                                                                        href="{{ route('kplh::download-file', ['maintank', $maintank_pipes_3_4_file]) }}"
                                                                        target="_blank"><i class="fa fa-file"></i>
                                                                        {{ Illuminate\Support\Str::limit($maintank_pipes_3_4_file, 30) }}</a>
                                                                </div>
                                                            </div>
                                                        @else
                                                            <div class="col-md-12 mt-3">
                                                                <x-kplh-file wire:model="maintank_pipes_3_4_file"
                                                                    id="maintank_pipes_3_4_file"
                                                                    placeholder="File" :error="'maintank_pipes_3_4_file'" />
                                                            </div>
                                                        @endif
                                                    </div>

                                                </div>
                                            </div>
                                        </div><!-- /.form-group maintank_pipes_3_4 -->

                                    </div><!-- ./content-pipes -->

                                </div>
                            </div><!-- /.pipes -->

                            <div id="maintank" class="section-maintank" x-data="{ accordionOpen: false }">
                                <button
                                    class="header-accordion d-flex justify-content-between w-100 border-0 bg-white py-3 px-0"
                                    @click.prevent="accordionOpen = ! accordionOpen">
                                    <h6 class="mb-0 fw-normal title-accordion">B. Main Tank</h6>
                                    <span x-bind:class="accordionOpen ? 'open' : ''"><img
                                            src="{{ asset('/images/icons/angle-down.png') }}"
                                            alt="" /></span>
                                </button>
                                <div class="wrapper-content-accordion max-h-0 overflow-hidden position-relative transition-all duration-700"
                                    x-ref="maintank" x-bind:style="accordionOpen ? 'max-height: ' + 20000 + 'px' : ''"
                                    x-transition.delay.5000ms>

                                    <div class="content-section p-4" wire:ignore.self>

                                        <div class="row form-group mb-4">
                                            <h4 class="col-lg-12 col-md-12 col-form-label">1. Dinding Maintank
                                            </h4>
                                        </div>

                                        <div class="row form-group mb-4">
                                            <label for="maintank_1_1_label"
                                                class="col-lg-4 col-md-12 col-form-label">Dinding plat tidak ada
                                                rembesan,
                                                Berkarat & penyok.
                                            </label>
                                            <div class="col-lg-8 col-md-12">
                                                <div class="wrapper_maintank_1_1 d-flex flex-column gap-3"
                                                    x-data="{ maintank_1_1_value: @entangle('maintank_1_1_value') }">
                                                    <x-inputs.select2 wire:model="maintank_1_1_value"
                                                        id="maintank_1_1_value" class="form-select"
                                                        placeholder="Pemenuhan">
                                                        <option value="Ya">Ya</option>
                                                        <option value="Tidak">Tidak</option>
                                                        <option value="N/A">N/A</option>
                                                    </x-inputs.select2>

                                                    <div x-cloak
                                                        x-show="maintank_1_1_value === 'Tidak' || maintank_1_1_value === '5' ">
                                                        <div>
                                                            <x-kplh-texteditor wire:model="maintank_1_1_note"
                                                                id="maintank_1_1_note" placeholder="Keterangan"
                                                                :error="'maintank_1_1_note'" />
                                                        </div>
                                                        @if ($maintank_1_1_file && !Illuminate\Support\Str::contains($maintank_1_1_file, 'private/var/folders/'))
                                                            <div class="row mt-3">
                                                                <div class="col-md-3"><button type="button"
                                                                        class="btn btn-outline-secondary"
                                                                        wire:click="setFileNull('maintank_1_1_file')"><i
                                                                            class="fa fa-edit"></i> Ubah
                                                                        File</button></div>
                                                                <div class="col-md-9">
                                                                    <a class="btn btn-outline-secondary"
                                                                        href="{{ route('kplh::download-file', ['maintank', $maintank_1_1_file]) }}"
                                                                        target="_blank"><i class="fa fa-file"></i>
                                                                        {{ Illuminate\Support\Str::limit($maintank_1_1_file, 30) }}</a>
                                                                </div>
                                                            </div>
                                                        @else
                                                            <div class="col-md-12 mt-3">
                                                                <x-kplh-file wire:model="maintank_1_1_file"
                                                                    id="maintank_1_1_file" placeholder="File"
                                                                    :error="'maintank_1_1_file'" />
                                                            </div>
                                                        @endif
                                                    </div>

                                                </div>
                                            </div>
                                        </div><!-- /.form-group maintank_1_1 -->

                                        <div class="row form-group mb-4">
                                            <label for="maintank_1_2_label"
                                                class="col-lg-4 col-md-12 col-form-label">Pastikan Keliling maintank
                                                bagian
                                                bawah tidak mengeluarkan minyak.
                                            </label>
                                            <div class="col-lg-8 col-md-12">
                                                <div class="wrapper_maintank_1_2 d-flex flex-column gap-3"
                                                    x-data="{ maintank_1_2_value: @entangle('maintank_1_2_value') }">
                                                    <x-inputs.select2 wire:model="maintank_1_2_value"
                                                        id="maintank_1_2_value" class="form-select"
                                                        placeholder="Pemenuhan">
                                                        <option value="Ya">Ya</option>
                                                        <option value="Tidak">Tidak</option>
                                                        <option value="N/A">N/A</option>
                                                    </x-inputs.select2>
                                                    <div x-cloak
                                                        x-show="maintank_1_2_value === 'Tidak' || maintank_1_2_value === '5' ">
                                                        <div>
                                                            <x-kplh-texteditor wire:model="maintank_1_2_note"
                                                                id="maintank_1_2_note" placeholder="Keterangan"
                                                                :error="'maintank_1_2_note'" />
                                                        </div>
                                                        @if ($maintank_1_2_file && !Illuminate\Support\Str::contains($maintank_1_2_file, 'private/var/folders/'))
                                                            <div class="row mt-3">
                                                                <div class="col-md-3"><button type="button"
                                                                        class="btn btn-outline-secondary"
                                                                        wire:click="setFileNull('maintank_1_2_file')"><i
                                                                            class="fa fa-edit"></i> Ubah
                                                                        File</button></div>
                                                                <div class="col-md-9">
                                                                    <a class="btn btn-outline-secondary"
                                                                        href="{{ route('kplh::download-file', ['maintank', $maintank_1_2_file]) }}"
                                                                        target="_blank"><i class="fa fa-file"></i>
                                                                        {{ Illuminate\Support\Str::limit($maintank_1_2_file, 30) }}</a>
                                                                </div>
                                                            </div>
                                                        @else
                                                            <div class="col-md-12 mt-3">
                                                                <x-kplh-file wire:model="maintank_1_2_file"
                                                                    id="maintank_1_2_file" placeholder="File"
                                                                    :error="'maintank_1_2_file'" />
                                                            </div>
                                                        @endif
                                                    </div>
                                                </div>
                                            </div>
                                        </div><!-- /.form-group maintank_1_2 -->

                                        <div class="row form-group mb-4">
                                            <label for="maintank_1_3_label"
                                                class="col-lg-4 col-md-12 col-form-label">Sambungan antar plat tidak
                                                ada
                                                rembesan, & las rata dengan dinding plat.
                                            </label>
                                            <div class="col-lg-8 col-md-12">
                                                <div class="wrapper_maintank_1_3 d-flex flex-column gap-3"
                                                    x-data="{ maintank_1_3_value: @entangle('maintank_1_3_value') }">
                                                    <x-inputs.select2 wire:model="maintank_1_3_value"
                                                        id="maintank_1_3_value" class="form-select"
                                                        placeholder="Pemenuhan">
                                                        <option value="Ya">Ya</option>
                                                        <option value="Tidak">Tidak</option>
                                                        <option value="N/A">N/A</option>
                                                    </x-inputs.select2>
                                                    <div x-cloak
                                                        x-show="maintank_1_3_value === 'Tidak' || maintank_1_3_value === '5' ">
                                                        <div>
                                                            <x-kplh-texteditor wire:model="maintank_1_3_note"
                                                                id="maintank_1_3_note" placeholder="Keterangan"
                                                                :error="'maintank_1_3_note'" />
                                                        </div>
                                                        @if ($maintank_1_3_file && !Illuminate\Support\Str::contains($maintank_1_3_file, 'private/var/folders/'))
                                                            <div class="row mt-3">
                                                                <div class="col-md-3"><button type="button"
                                                                        class="btn btn-outline-secondary"
                                                                        wire:click="setFileNull('maintank_1_3_file')"><i
                                                                            class="fa fa-edit"></i> Ubah
                                                                        File</button></div>
                                                                <div class="col-md-9">
                                                                    <a class="btn btn-outline-secondary"
                                                                        href="{{ route('kplh::download-file', ['maintank', $maintank_1_3_file]) }}"
                                                                        target="_blank"><i class="fa fa-file"></i>
                                                                        {{ Illuminate\Support\Str::limit($maintank_1_3_file, 30) }}</a>
                                                                </div>
                                                            </div>
                                                        @else
                                                            <div class="col-md-12 mt-3">
                                                                <x-kplh-file wire:model="maintank_1_3_file"
                                                                    id="maintank_1_3_file" placeholder="File"
                                                                    :error="'maintank_1_3_file'" />
                                                            </div>
                                                        @endif
                                                    </div>
                                                </div>
                                            </div>
                                        </div><!-- /.form-group maintank_1_3 -->

                                        <div class="row form-group mb-4">
                                            <h4 class="col-lg-12 col-md-12 col-form-label">2. Pressure Safety Valve
                                            </h4>
                                        </div>

                                        <div class="row form-group mb-4">
                                            <label for="maintank_2_1_label"
                                                class="col-lg-4 col-md-12 col-form-label">Pastikan segel tidak rusak.
                                            </label>
                                            <div class="col-lg-8 col-md-12">
                                                <div class="wrapper_maintank_2_1 d-flex flex-column gap-3"
                                                    x-data="{ maintank_2_1_value: @entangle('maintank_2_1_value') }">
                                                    <x-inputs.select2 wire:model="maintank_2_1_value"
                                                        id="maintank_2_1_value" class="form-select"
                                                        placeholder="Pemenuhan">
                                                        <option value="Ya">Ya</option>
                                                        <option value="Tidak">Tidak</option>
                                                        <option value="N/A">N/A</option>
                                                    </x-inputs.select2>

                                                    <div x-cloak
                                                        x-show="maintank_2_1_value === 'Tidak' || maintank_2_1_value === '5' ">
                                                        <div>
                                                            <x-kplh-texteditor wire:model="maintank_2_1_note"
                                                                id="maintank_2_1_note" placeholder="Keterangan"
                                                                :error="'maintank_2_1_note'" />
                                                        </div>
                                                        @if ($maintank_2_1_file && !Illuminate\Support\Str::contains($maintank_2_1_file, 'private/var/folders/'))
                                                            <div class="row mt-3">
                                                                <div class="col-md-3"><button type="button"
                                                                        class="btn btn-outline-secondary"
                                                                        wire:click="setFileNull('maintank_2_1_file')"><i
                                                                            class="fa fa-edit"></i> Ubah
                                                                        File</button></div>
                                                                <div class="col-md-9">
                                                                    <a class="btn btn-outline-secondary"
                                                                        href="{{ route('kplh::download-file', ['maintank', $maintank_2_1_file]) }}"
                                                                        target="_blank"><i class="fa fa-file"></i>
                                                                        {{ Illuminate\Support\Str::limit($maintank_2_1_file, 30) }}</a>
                                                                </div>
                                                            </div>
                                                        @else
                                                            <div class="col-md-12 mt-3">
                                                                <x-kplh-file wire:model="maintank_2_1_file"
                                                                    id="maintank_2_1_file" placeholder="File"
                                                                    :error="'maintank_2_1_file'" />
                                                            </div>
                                                        @endif
                                                    </div>

                                                </div>
                                            </div>
                                        </div><!-- /.form-group maintank_2_1 -->

                                        <div class="row form-group mb-4">
                                            <label for="maintank_2_2_label"
                                                class="col-lg-4 col-md-12 col-form-label">Pastikan sambungan PSV dengan
                                                pipa tidak ada rembesan dan tidak pecah.
                                            </label>
                                            <div class="col-lg-8 col-md-12">
                                                <div class="wrapper_maintank_2_2 d-flex flex-column gap-3"
                                                    x-data="{ maintank_2_2_value: @entangle('maintank_2_2_value') }">
                                                    <x-inputs.select2 wire:model="maintank_2_2_value"
                                                        id="maintank_2_2_value" class="form-select"
                                                        placeholder="Pemenuhan">
                                                        <option value="Ya">Ya</option>
                                                        <option value="Tidak">Tidak</option>
                                                        <option value="N/A">N/A</option>
                                                    </x-inputs.select2>

                                                    <div x-cloak
                                                        x-show="maintank_2_2_value === 'Tidak' || maintank_2_2_value === '5' ">
                                                        <div>
                                                            <x-kplh-texteditor wire:model="maintank_2_2_note"
                                                                id="maintank_2_2_note" placeholder="Keterangan"
                                                                :error="'maintank_2_2_note'" />
                                                        </div>
                                                        @if ($maintank_2_2_file && !Illuminate\Support\Str::contains($maintank_2_2_file, 'private/var/folders/'))
                                                            <div class="row mt-3">
                                                                <div class="col-md-3"><button type="button"
                                                                        class="btn btn-outline-secondary"
                                                                        wire:click="setFileNull('maintank_2_2_file')"><i
                                                                            class="fa fa-edit"></i> Ubah
                                                                        File</button></div>
                                                                <div class="col-md-9">
                                                                    <a class="btn btn-outline-secondary"
                                                                        href="{{ route('kplh::download-file', ['maintank', $maintank_2_2_file]) }}"
                                                                        target="_blank"><i class="fa fa-file"></i>
                                                                        {{ Illuminate\Support\Str::limit($maintank_2_2_file, 30) }}</a>
                                                                </div>
                                                            </div>
                                                        @else
                                                            <div class="col-md-12 mt-3">
                                                                <x-kplh-file wire:model="maintank_2_2_file"
                                                                    id="maintank_2_2_file" placeholder="File"
                                                                    :error="'maintank_2_2_file'" />
                                                            </div>
                                                        @endif
                                                    </div>

                                                </div>
                                            </div>
                                        </div><!-- /.form-group maintank_2_2 -->

                                        <div class="row form-group mb-4">
                                            <label for="maintank_2_3_label"
                                                class="col-lg-4 col-md-12 col-form-label">Pastikan tuas sebelum PSV
                                                dalam
                                                keadaan open jika ada kegiatan.
                                            </label>
                                            <div class="col-lg-8 col-md-12">
                                                <div class="wrapper_maintank_2_3 d-flex flex-column gap-3"
                                                    x-data="{ maintank_2_3_value: @entangle('maintank_2_3_value') }">
                                                    <x-inputs.select2 wire:model="maintank_2_3_value"
                                                        id="maintank_2_3_value" class="form-select"
                                                        placeholder="Pemenuhan">
                                                        <option value="Ya">Ya</option>
                                                        <option value="Tidak">Tidak</option>
                                                        <option value="N/A">N/A</option>
                                                    </x-inputs.select2>

                                                    <div x-cloak
                                                        x-show="maintank_2_3_value === 'Tidak' || maintank_2_3_value === '5' ">
                                                        <div>
                                                            <x-kplh-texteditor wire:model="maintank_2_3_note"
                                                                id="maintank_2_3_note" placeholder="Keterangan"
                                                                :error="'maintank_2_3_note'" />
                                                        </div>
                                                        @if ($maintank_2_3_file && !Illuminate\Support\Str::contains($maintank_2_3_file, 'private/var/folders/'))
                                                            <div class="row mt-3">
                                                                <div class="col-md-3"><button type="button"
                                                                        class="btn btn-outline-secondary"
                                                                        wire:click="setFileNull('maintank_2_3_file')"><i
                                                                            class="fa fa-edit"></i> Ubah
                                                                        File</button></div>
                                                                <div class="col-md-9">
                                                                    <a class="btn btn-outline-secondary"
                                                                        href="{{ route('kplh::download-file', ['maintank', $maintank_2_3_file]) }}"
                                                                        target="_blank"><i class="fa fa-file"></i>
                                                                        {{ Illuminate\Support\Str::limit($maintank_2_3_file, 30) }}</a>
                                                                </div>
                                                            </div>
                                                        @else
                                                            <div class="col-md-12 mt-3">
                                                                <x-kplh-file wire:model="maintank_2_3_file"
                                                                    id="maintank_2_3_file" placeholder="File"
                                                                    :error="'maintank_2_3_file'" />
                                                            </div>
                                                        @endif
                                                    </div>

                                                </div>
                                            </div>
                                        </div><!-- /.form-group maintank_2_3 -->

                                        <div class="row form-group mb-4">
                                            <label for="maintank_2_4_label"
                                                class="col-lg-4 col-md-12 col-form-label">Pastikan pipa PSV Tidak ada
                                                retak, rembesan minyak, tidak pecah & berubah bentuk.
                                            </label>
                                            <div class="col-lg-8 col-md-12">
                                                <div class="wrapper_maintank_2_4 d-flex flex-column gap-3"
                                                    x-data="{ maintank_2_4_value: @entangle('maintank_2_4_value') }">
                                                    <x-inputs.select2 wire:model="maintank_2_4_value"
                                                        id="maintank_2_4_value" class="form-select"
                                                        placeholder="Pemenuhan">
                                                        <option value="Ya">Ya</option>
                                                        <option value="Tidak">Tidak</option>
                                                        <option value="N/A">N/A</option>
                                                    </x-inputs.select2>
                                                    <div x-cloak
                                                        x-show="maintank_2_4_value === 'Tidak' || maintank_2_4_value === '5' ">
                                                        <div>
                                                            <x-kplh-texteditor wire:model="maintank_2_4_note"
                                                                id="maintank_2_4_note" placeholder="Keterangan"
                                                                :error="'maintank_2_4_note'" />
                                                        </div>
                                                        @if ($maintank_2_4_file && !Illuminate\Support\Str::contains($maintank_2_4_file, 'private/var/folders/'))
                                                            <div class="row mt-3">
                                                                <div class="col-md-3"><button type="button"
                                                                        class="btn btn-outline-secondary"
                                                                        wire:click="setFileNull('maintank_2_4_file')"><i
                                                                            class="fa fa-edit"></i> Ubah
                                                                        File</button></div>
                                                                <div class="col-md-9">
                                                                    <a class="btn btn-outline-secondary"
                                                                        href="{{ route('kplh::download-file', ['maintank', $maintank_2_4_file]) }}"
                                                                        target="_blank"><i class="fa fa-file"></i>
                                                                        {{ Illuminate\Support\Str::limit($maintank_2_4_file, 30) }}</a>
                                                                </div>
                                                            </div>
                                                        @else
                                                            <div class="col-md-12 mt-3">
                                                                <x-kplh-file wire:model="maintank_2_4_file"
                                                                    id="maintank_2_4_file" placeholder="File"
                                                                    :error="'maintank_2_4_file'" />
                                                            </div>
                                                        @endif
                                                    </div>
                                                </div>
                                            </div>
                                        </div><!-- /.form-group maintank_2_4 -->

                                        <div class="row form-group mb-4">
                                            <h4 class="col-lg-12 col-md-12 col-form-label">3. Flexible Hose</h4>
                                        </div>

                                        <div class="row form-group mb-4">
                                            <label for="maintank_3_1_label"
                                                class="col-lg-4 col-md-12 col-form-label">Pastikan kondisi fisik tidak
                                                pecah dan tidak baret.
                                            </label>
                                            <div class="col-lg-8 col-md-12">
                                                <div class="wrapper_maintank_3_1 d-flex flex-column gap-3"
                                                    x-data="{ maintank_3_1_value: @entangle('maintank_3_1_value') }">
                                                    <x-inputs.select2 wire:model="maintank_3_1_value"
                                                        id="maintank_3_1_value" class="form-select"
                                                        placeholder="Pemenuhan">
                                                        <option value="Ya">Ya</option>
                                                        <option value="Tidak">Tidak</option>
                                                        <option value="N/A">N/A</option>
                                                    </x-inputs.select2>

                                                    <div x-cloak
                                                        x-show="maintank_3_1_value === 'Tidak' || maintank_3_1_value === '5' ">
                                                        <div>
                                                            <x-kplh-texteditor wire:model="maintank_3_1_note"
                                                                id="maintank_3_1_note" placeholder="Keterangan"
                                                                :error="'maintank_3_1_note'" />
                                                        </div>
                                                        @if ($maintank_3_1_file && !Illuminate\Support\Str::contains($maintank_3_1_file, 'private/var/folders/'))
                                                            <div class="row mt-3">
                                                                <div class="col-md-3"><button type="button"
                                                                        class="btn btn-outline-secondary"
                                                                        wire:click="setFileNull('maintank_3_1_file')"><i
                                                                            class="fa fa-edit"></i> Ubah
                                                                        File</button></div>
                                                                <div class="col-md-9">
                                                                    <a class="btn btn-outline-secondary"
                                                                        href="{{ route('kplh::download-file', ['maintank', $maintank_3_1_file]) }}"
                                                                        target="_blank"><i class="fa fa-file"></i>
                                                                        {{ Illuminate\Support\Str::limit($maintank_3_1_file, 30) }}</a>
                                                                </div>
                                                            </div>
                                                        @else
                                                            <div class="col-md-12 mt-3">
                                                                <x-kplh-file wire:model="maintank_3_1_file"
                                                                    id="maintank_3_1_file" placeholder="File"
                                                                    :error="'maintank_3_1_file'" />
                                                            </div>
                                                        @endif
                                                    </div>

                                                </div>
                                            </div>
                                        </div><!-- /.form-group maintank_3_1 -->

                                        <div class="row form-group mb-4">
                                            <label for="maintank_3_2_label"
                                                class="col-lg-4 col-md-12 col-form-label">Flexible Hose harus tidak
                                                menggelembung ditiap sisi.
                                            </label>
                                            <div class="col-lg-8 col-md-12">
                                                <div class="wrapper_maintank_3_2 d-flex flex-column gap-3"
                                                    x-data="{ maintank_3_2_value: @entangle('maintank_3_2_value') }">
                                                    <x-inputs.select2 wire:model="maintank_3_2_value"
                                                        id="maintank_3_2_value" class="form-select"
                                                        placeholder="Pemenuhan">
                                                        <option value="Ya">Ya</option>
                                                        <option value="Tidak">Tidak</option>
                                                        <option value="N/A">N/A</option>
                                                    </x-inputs.select2>

                                                    <div x-cloak
                                                        x-show="maintank_3_2_value === 'Tidak' || maintank_3_2_value === '5' ">
                                                        <div>
                                                            <x-kplh-texteditor wire:model="maintank_3_2_note"
                                                                id="maintank_3_2_note" placeholder="Keterangan"
                                                                :error="'maintank_3_2_note'" />
                                                        </div>
                                                        @if ($maintank_3_2_file && !Illuminate\Support\Str::contains($maintank_3_2_file, 'private/var/folders/'))
                                                            <div class="row mt-3">
                                                                <div class="col-md-3"><button type="button"
                                                                        class="btn btn-outline-secondary"
                                                                        wire:click="setFileNull('maintank_3_2_file')"><i
                                                                            class="fa fa-edit"></i> Ubah
                                                                        File</button></div>
                                                                <div class="col-md-9">
                                                                    <a class="btn btn-outline-secondary"
                                                                        href="{{ route('kplh::download-file', ['maintank', $maintank_3_2_file]) }}"
                                                                        target="_blank"><i class="fa fa-file"></i>
                                                                        {{ Illuminate\Support\Str::limit($maintank_3_2_file, 30) }}</a>
                                                                </div>
                                                            </div>
                                                        @else
                                                            <div class="col-md-12 mt-3">
                                                                <x-kplh-file wire:model="maintank_3_2_file"
                                                                    id="maintank_3_2_file" placeholder="File"
                                                                    :error="'maintank_3_2_file'" />
                                                            </div>
                                                        @endif
                                                    </div>

                                                </div>
                                            </div>
                                        </div><!-- /.form-group maintank_3_2 -->

                                        <div class="row form-group mb-4">
                                            <label for="maintank_3_3_label"
                                                class="col-lg-4 col-md-12 col-form-label">Baut
                                                penghubung flexible hose harus lengkap dan tidak bisa diputar dengan
                                                tangan.
                                            </label>
                                            <div class="col-lg-8 col-md-12">
                                                <div class="wrapper_maintank_3_3 d-flex flex-column gap-3"
                                                    x-data="{ maintank_3_3_value: @entangle('maintank_3_3_value') }">
                                                    <x-inputs.select2 wire:model="maintank_3_3_value"
                                                        id="maintank_3_3_value" class="form-select"
                                                        placeholder="Pemenuhan">
                                                        <option value="Ya">Ya</option>
                                                        <option value="Tidak">Tidak</option>
                                                        <option value="N/A">N/A</option>
                                                    </x-inputs.select2>

                                                    <div x-cloak
                                                        x-show="maintank_3_3_value === 'Tidak' || maintank_3_3_value === '5' ">
                                                        <div>
                                                            <x-kplh-texteditor wire:model="maintank_3_3_note"
                                                                id="maintank_3_3_note" placeholder="Keterangan"
                                                                :error="'maintank_3_3_note'" />
                                                        </div>
                                                        @if ($maintank_3_3_file && !Illuminate\Support\Str::contains($maintank_3_3_file, 'private/var/folders/'))
                                                            <div class="row mt-3">
                                                                <div class="col-md-3"><button type="button"
                                                                        class="btn btn-outline-secondary"
                                                                        wire:click="setFileNull('maintank_3_3_file')"><i
                                                                            class="fa fa-edit"></i> Ubah
                                                                        File</button></div>
                                                                <div class="col-md-9">
                                                                    <a class="btn btn-outline-secondary"
                                                                        href="{{ route('kplh::download-file', ['maintank', $maintank_3_3_file]) }}"
                                                                        target="_blank"><i class="fa fa-file"></i>
                                                                        {{ Illuminate\Support\Str::limit($maintank_3_3_file, 30) }}</a>
                                                                </div>
                                                            </div>
                                                        @else
                                                            <div class="col-md-12 mt-3">
                                                                <x-kplh-file wire:model="maintank_3_3_file"
                                                                    id="maintank_3_3_file" placeholder="File"
                                                                    :error="'maintank_3_3_file'" />
                                                            </div>
                                                        @endif
                                                    </div>

                                                </div>
                                            </div>
                                        </div><!-- /.form-group maintank_3_3 -->

                                        <div class="row form-group mb-4">
                                            <h4 class="col-lg-12 col-md-12 col-form-label">4. Meter Ketinggian / volume
                                                maintank</h4>
                                        </div>

                                        <div class="row form-group mb-4">
                                            <label for="maintank_4_1_label"
                                                class="col-lg-4 col-md-12 col-form-label">Pastikan Bandul terpasang di
                                                maintank dan dapat digerakan naik turun sesuai level.
                                            </label>
                                            <div class="col-lg-8 col-md-12">
                                                <div class="wrapper_maintank_4_1 d-flex flex-column gap-3"
                                                    x-data="{ maintank_4_1_value: @entangle('maintank_4_1_value') }">
                                                    <x-inputs.select2 wire:model="maintank_4_1_value"
                                                        id="maintank_4_1_value" class="form-select"
                                                        placeholder="Pemenuhan">
                                                        <option value="Ya">Ya</option>
                                                        <option value="Tidak">Tidak</option>
                                                        <option value="N/A">N/A</option>
                                                    </x-inputs.select2>

                                                    <div x-cloak
                                                        x-show="maintank_4_1_value === 'Tidak' || maintank_4_1_value === '5' ">
                                                        <div>
                                                            <x-kplh-texteditor wire:model="maintank_4_1_note"
                                                                id="maintank_4_1_note" placeholder="Keterangan"
                                                                :error="'maintank_4_1_note'" />
                                                        </div>
                                                        @if ($maintank_4_1_file && !Illuminate\Support\Str::contains($maintank_4_1_file, 'private/var/folders/'))
                                                            <div class="row mt-3">
                                                                <div class="col-md-3"><button type="button"
                                                                        class="btn btn-outline-secondary"
                                                                        wire:click="setFileNull('maintank_4_1_file')"><i
                                                                            class="fa fa-edit"></i> Ubah
                                                                        File</button></div>
                                                                <div class="col-md-9">
                                                                    <a class="btn btn-outline-secondary"
                                                                        href="{{ route('kplh::download-file', ['maintank', $maintank_4_1_file]) }}"
                                                                        target="_blank"><i class="fa fa-file"></i>
                                                                        {{ Illuminate\Support\Str::limit($maintank_4_1_file, 30) }}</a>
                                                                </div>
                                                            </div>
                                                        @else
                                                            <div class="col-md-12 mt-3">
                                                                <x-kplh-file wire:model="maintank_4_1_file"
                                                                    id="maintank_4_1_file" placeholder="File"
                                                                    :error="'maintank_4_1_file'" />
                                                            </div>
                                                        @endif
                                                    </div>

                                                </div>
                                            </div>
                                        </div><!-- /.form-group maintank_4_1 -->

                                        <div class="row form-group mb-4">
                                            <label for="maintank_4_2_label"
                                                class="col-lg-4 col-md-12 col-form-label">Pastikan Tali pengikat bandul
                                                tidak rapuh, tidak putus, tidak terlilit & tidak dapat di putus dengan
                                                tangan.
                                            </label>
                                            <div class="col-lg-8 col-md-12">
                                                <div class="wrapper_maintank_4_2 d-flex flex-column gap-3"
                                                    x-data="{ maintank_4_2_value: @entangle('maintank_4_2_value') }">
                                                    <x-inputs.select2 wire:model="maintank_4_2_value"
                                                        id="maintank_4_2_value" class="form-select"
                                                        placeholder="Pemenuhan">
                                                        <option value="Ya">Ya</option>
                                                        <option value="Tidak">Tidak</option>
                                                        <option value="N/A">N/A</option>
                                                    </x-inputs.select2>

                                                    <div x-cloak
                                                        x-show="maintank_4_2_value === 'Tidak' || maintank_4_2_value === '5' ">
                                                        <div>
                                                            <x-kplh-texteditor wire:model="maintank_4_2_note"
                                                                id="maintank_4_2_note" placeholder="Keterangan"
                                                                :error="'maintank_4_2_note'" />
                                                        </div>
                                                        @if ($maintank_4_2_file && !Illuminate\Support\Str::contains($maintank_4_2_file, 'private/var/folders/'))
                                                            <div class="row mt-3">
                                                                <div class="col-md-3"><button type="button"
                                                                        class="btn btn-outline-secondary"
                                                                        wire:click="setFileNull('maintank_4_2_file')"><i
                                                                            class="fa fa-edit"></i> Ubah
                                                                        File</button></div>
                                                                <div class="col-md-9">
                                                                    <a class="btn btn-outline-secondary"
                                                                        href="{{ route('kplh::download-file', ['maintank', $maintank_4_2_file]) }}"
                                                                        target="_blank"><i class="fa fa-file"></i>
                                                                        {{ Illuminate\Support\Str::limit($maintank_4_2_file, 30) }}</a>
                                                                </div>
                                                            </div>
                                                        @else
                                                            <div class="col-md-12 mt-3">
                                                                <x-kplh-file wire:model="maintank_4_2_file"
                                                                    id="maintank_4_2_file" placeholder="File"
                                                                    :error="'maintank_4_2_file'" />
                                                            </div>
                                                        @endif
                                                    </div>

                                                </div>
                                            </div>
                                        </div><!-- /.form-group maintank_4_2 -->

                                        <div class="row form-group mb-4">
                                            <label for="maintank_4_3_label"
                                                class="col-lg-4 col-md-12 col-form-label">Pastikan Lubang bandul tidak
                                                berubah bentuk.
                                            </label>
                                            <div class="col-lg-8 col-md-12">
                                                <div class="wrapper_maintank_4_3 d-flex flex-column gap-3"
                                                    x-data="{ maintank_4_3_value: @entangle('maintank_4_3_value') }">
                                                    <x-inputs.select2 wire:model="maintank_4_3_value"
                                                        id="maintank_4_3_value" class="form-select"
                                                        placeholder="Pemenuhan">
                                                        <option value="Ya">Ya</option>
                                                        <option value="Tidak">Tidak</option>
                                                        <option value="N/A">N/A</option>
                                                    </x-inputs.select2>

                                                    <div x-cloak
                                                        x-show="maintank_4_3_value === 'Tidak' || maintank_4_3_value === '5' ">
                                                        <div>
                                                            <x-kplh-texteditor wire:model="maintank_4_3_note"
                                                                id="maintank_4_3_note" placeholder="Keterangan"
                                                                :error="'maintank_4_3_note'" />
                                                        </div>
                                                        @if ($maintank_4_3_file && !Illuminate\Support\Str::contains($maintank_4_3_file, 'private/var/folders/'))
                                                            <div class="row mt-3">
                                                                <div class="col-md-3"><button type="button"
                                                                        class="btn btn-outline-secondary"
                                                                        wire:click="setFileNull('maintank_4_3_file')"><i
                                                                            class="fa fa-edit"></i> Ubah
                                                                        File</button></div>
                                                                <div class="col-md-9">
                                                                    <a class="btn btn-outline-secondary"
                                                                        href="{{ route('kplh::download-file', ['maintank', $maintank_4_3_file]) }}"
                                                                        target="_blank"><i class="fa fa-file"></i>
                                                                        {{ Illuminate\Support\Str::limit($maintank_4_3_file, 30) }}</a>
                                                                </div>
                                                            </div>
                                                        @else
                                                            <div class="col-md-12 mt-3">
                                                                <x-kplh-file wire:model="maintank_4_3_file"
                                                                    id="maintank_4_3_file" placeholder="File"
                                                                    :error="'maintank_4_3_file'" />
                                                            </div>
                                                        @endif
                                                    </div>

                                                </div>
                                            </div>
                                        </div><!-- /.form-group maintank_4_3 -->

                                        <div class="row form-group mb-4">
                                            <label for="maintank_4_4_label"
                                                class="col-lg-4 col-md-12 col-form-label">Pastikan Meter ketinggian
                                                volume
                                                isi maintank dapat dibaca dengan jelas.
                                            </label>
                                            <div class="col-lg-8 col-md-12">
                                                <div class="wrapper_maintank_4_4 d-flex flex-column gap-3"
                                                    x-data="{ maintank_4_4_value: @entangle('maintank_4_4_value') }">
                                                    <x-inputs.select2 wire:model="maintank_4_4_value"
                                                        id="maintank_4_4_value" class="form-select"
                                                        placeholder="Pemenuhan">
                                                        <option value="Ya">Ya</option>
                                                        <option value="Tidak">Tidak</option>
                                                        <option value="N/A">N/A</option>
                                                    </x-inputs.select2>

                                                    <div x-cloak
                                                        x-show="maintank_4_4_value === 'Tidak' || maintank_4_4_value === '5' ">
                                                        <div>
                                                            <x-kplh-texteditor wire:model="maintank_4_4_note"
                                                                id="maintank_4_4_note" placeholder="Keterangan"
                                                                :error="'maintank_4_4_note'" />
                                                        </div>
                                                        @if ($maintank_4_4_file && !Illuminate\Support\Str::contains($maintank_4_4_file, 'private/var/folders/'))
                                                            <div class="row mt-3">
                                                                <div class="col-md-3"><button type="button"
                                                                        class="btn btn-outline-secondary"
                                                                        wire:click="setFileNull('maintank_4_4_file')"><i
                                                                            class="fa fa-edit"></i> Ubah
                                                                        File</button></div>
                                                                <div class="col-md-9">
                                                                    <a class="btn btn-outline-secondary"
                                                                        href="{{ route('kplh::download-file', ['maintank', $maintank_4_4_file]) }}"
                                                                        target="_blank"><i class="fa fa-file"></i>
                                                                        {{ Illuminate\Support\Str::limit($maintank_4_4_file, 30) }}</a>
                                                                </div>
                                                            </div>
                                                        @else
                                                            <div class="col-md-12 mt-3">
                                                                <x-kplh-file wire:model="maintank_4_4_file"
                                                                    id="maintank_4_4_file" placeholder="File"
                                                                    :error="'maintank_4_4_file'" />
                                                            </div>
                                                        @endif
                                                    </div>

                                                </div>
                                            </div>
                                        </div><!-- /.form-group maintank_4_4 -->

                                        <div class="row form-group mb-4">
                                            <label for="maintank_4_5_label"
                                                class="col-lg-4 col-md-12 col-form-label">Pastikan Katrol dapat
                                                berputar,
                                                tidak macet (perlu diberi grease 2 minggu sekali).
                                            </label>
                                            <div class="col-lg-8 col-md-12">
                                                <div class="wrapper_maintank_4_5 d-flex flex-column gap-3"
                                                    x-data="{ maintank_4_5_value: @entangle('maintank_4_5_value') }">
                                                    <x-inputs.select2 wire:model="maintank_4_5_value"
                                                        id="maintank_4_5_value" class="form-select"
                                                        placeholder="Pemenuhan">
                                                        <option value="Ya">Ya</option>
                                                        <option value="Tidak">Tidak</option>
                                                        <option value="N/A">N/A</option>
                                                    </x-inputs.select2>

                                                    <div x-cloak
                                                        x-show="maintank_4_5_value === 'Tidak' || maintank_4_5_value === '5' ">
                                                        <div>
                                                            <x-kplh-texteditor wire:model="maintank_4_5_note"
                                                                id="maintank_4_5_note" placeholder="Keterangan"
                                                                :error="'maintank_4_5_note'" />
                                                        </div>
                                                        @if ($maintank_4_5_file && !Illuminate\Support\Str::contains($maintank_4_5_file, 'private/var/folders/'))
                                                            <div class="row mt-3">
                                                                <div class="col-md-3"><button type="button"
                                                                        class="btn btn-outline-secondary"
                                                                        wire:click="setFileNull('maintank_4_5_file')"><i
                                                                            class="fa fa-edit"></i> Ubah
                                                                        File</button></div>
                                                                <div class="col-md-9">
                                                                    <a class="btn btn-outline-secondary"
                                                                        href="{{ route('kplh::download-file', ['maintank', $maintank_4_5_file]) }}"
                                                                        target="_blank"><i class="fa fa-file"></i>
                                                                        {{ Illuminate\Support\Str::limit($maintank_4_5_file, 30) }}</a>
                                                                </div>
                                                            </div>
                                                        @else
                                                            <div class="col-md-12 mt-3">
                                                                <x-kplh-file wire:model="maintank_4_5_file"
                                                                    id="maintank_4_5_file" placeholder="File"
                                                                    :error="'maintank_4_5_file'" />
                                                            </div>
                                                        @endif
                                                    </div>

                                                </div>
                                            </div>
                                        </div><!-- /.form-group maintank_4_5 -->

                                        <div class="row form-group mb-4">
                                            <h4 class="col-lg-12 col-md-12 col-form-label">5. Hydrant Maintank</h4>
                                        </div>

                                        <div class="row form-group mb-4">
                                            <label for="maintank_5_1_label"
                                                class="col-lg-4 col-md-12 col-form-label">Pastikan Pipa Hydrant tidak
                                                bocor, tidak Berkarat, mengalirkan air ketika valve dalam posisi open.
                                            </label>
                                            <div class="col-lg-8 col-md-12">
                                                <div class="wrapper_maintank_5_1 d-flex flex-column gap-3"
                                                    x-data="{ maintank_5_1_value: @entangle('maintank_5_1_value') }">
                                                    <x-inputs.select2 wire:model="maintank_5_1_value"
                                                        id="maintank_5_1_value" class="form-select"
                                                        placeholder="Pemenuhan">
                                                        <option value="Ya">Ya</option>
                                                        <option value="Tidak">Tidak</option>
                                                        <option value="N/A">N/A</option>
                                                    </x-inputs.select2>

                                                    <div x-cloak
                                                        x-show="maintank_5_1_value === 'Tidak' || maintank_5_1_value === '5' ">
                                                        <div>
                                                            <x-kplh-texteditor wire:model="maintank_5_1_note"
                                                                id="maintank_5_1_note" placeholder="Keterangan"
                                                                :error="'maintank_5_1_note'" />
                                                        </div>
                                                        @if ($maintank_5_1_file && !Illuminate\Support\Str::contains($maintank_5_1_file, 'private/var/folders/'))
                                                            <div class="row mt-3">
                                                                <div class="col-md-3"><button type="button"
                                                                        class="btn btn-outline-secondary"
                                                                        wire:click="setFileNull('maintank_5_1_file')"><i
                                                                            class="fa fa-edit"></i> Ubah
                                                                        File</button></div>
                                                                <div class="col-md-9">
                                                                    <a class="btn btn-outline-secondary"
                                                                        href="{{ route('kplh::download-file', ['maintank', $maintank_5_1_file]) }}"
                                                                        target="_blank"><i class="fa fa-file"></i>
                                                                        {{ Illuminate\Support\Str::limit($maintank_5_1_file, 30) }}</a>
                                                                </div>
                                                            </div>
                                                        @else
                                                            <div class="col-md-12 mt-3">
                                                                <x-kplh-file wire:model="maintank_5_1_file"
                                                                    id="maintank_5_1_file" placeholder="File"
                                                                    :error="'maintank_5_1_file'" />
                                                            </div>
                                                        @endif
                                                    </div>

                                                </div>
                                            </div>
                                        </div><!-- /.form-group maintank_5_1 -->

                                        <div class="row form-group mb-4">
                                            <label for="maintank_5_2_label"
                                                class="col-lg-4 col-md-12 col-form-label">Pastikan sambungan pipa
                                                hydrant
                                                tidak ada rembesan & tidak lepas.
                                            </label>
                                            <div class="col-lg-8 col-md-12">
                                                <div class="wrapper_maintank_5_2 d-flex flex-column gap-3"
                                                    x-data="{ maintank_5_2_value: @entangle('maintank_5_2_value') }">
                                                    <x-inputs.select2 wire:model="maintank_5_2_value"
                                                        id="maintank_5_2_value" class="form-select"
                                                        placeholder="Pemenuhan">
                                                        <option value="Ya">Ya</option>
                                                        <option value="Tidak">Tidak</option>
                                                        <option value="N/A">N/A</option>
                                                    </x-inputs.select2>

                                                    <div x-cloak
                                                        x-show="maintank_5_2_value === 'Tidak' || maintank_5_2_value === '5' ">
                                                        <div>
                                                            <x-kplh-texteditor wire:model="maintank_5_2_note"
                                                                id="maintank_5_2_note" placeholder="Keterangan"
                                                                :error="'maintank_5_2_note'" />
                                                        </div>
                                                        @if ($maintank_5_2_file && !Illuminate\Support\Str::contains($maintank_5_2_file, 'private/var/folders/'))
                                                            <div class="row mt-3">
                                                                <div class="col-md-3"><button type="button"
                                                                        class="btn btn-outline-secondary"
                                                                        wire:click="setFileNull('maintank_5_2_file')"><i
                                                                            class="fa fa-edit"></i> Ubah
                                                                        File</button></div>
                                                                <div class="col-md-9">
                                                                    <a class="btn btn-outline-secondary"
                                                                        href="{{ route('kplh::download-file', ['maintank', $maintank_5_2_file]) }}"
                                                                        target="_blank"><i class="fa fa-file"></i>
                                                                        {{ Illuminate\Support\Str::limit($maintank_5_2_file, 30) }}</a>
                                                                </div>
                                                            </div>
                                                        @else
                                                            <div class="col-md-12 mt-3">
                                                                <x-kplh-file wire:model="maintank_5_2_file"
                                                                    id="maintank_5_2_file" placeholder="File"
                                                                    :error="'maintank_5_2_file'" />
                                                            </div>
                                                        @endif
                                                    </div>

                                                </div>
                                            </div>
                                        </div><!-- /.form-group maintank_5_2 -->

                                        <div class="row form-group mb-4">
                                            <h4 class="col-lg-12 col-md-12 col-form-label">6. Kabel Penangkal Petir /
                                                Grounding</h4>
                                        </div>

                                        <div class="row form-group mb-4">
                                            <label for="maintank_6_1_label"
                                                class="col-lg-4 col-md-12 col-form-label">Pastikan Kabel penangkal
                                                petir
                                                maintank tidak putus dari saluran grounding dan tidak Berkarat.
                                            </label>
                                            <div class="col-lg-8 col-md-12">
                                                <div class="wrapper_maintank_6_1 d-flex flex-column gap-3"
                                                    x-data="{ maintank_6_1_value: @entangle('maintank_6_1_value') }">
                                                    <x-inputs.select2 wire:model="maintank_6_1_value"
                                                        id="maintank_6_1_value" class="form-select"
                                                        placeholder="Pemenuhan">
                                                        <option value="Ya">Ya</option>
                                                        <option value="Tidak">Tidak</option>
                                                        <option value="N/A">N/A</option>
                                                    </x-inputs.select2>

                                                    <div x-cloak
                                                        x-show="maintank_6_1_value === 'Tidak' || maintank_6_1_value === '5' ">
                                                        <div>
                                                            <x-kplh-texteditor wire:model="maintank_6_1_note"
                                                                id="maintank_6_1_note" placeholder="Keterangan"
                                                                :error="'maintank_6_1_note'" />
                                                        </div>
                                                        @if ($maintank_6_1_file && !Illuminate\Support\Str::contains($maintank_6_1_file, 'private/var/folders/'))
                                                            <div class="row mt-3">
                                                                <div class="col-md-3"><button type="button"
                                                                        class="btn btn-outline-secondary"
                                                                        wire:click="setFileNull('maintank_6_1_file')"><i
                                                                            class="fa fa-edit"></i> Ubah
                                                                        File</button></div>
                                                                <div class="col-md-9">
                                                                    <a class="btn btn-outline-secondary"
                                                                        href="{{ route('kplh::download-file', ['maintank', $maintank_6_1_file]) }}"
                                                                        target="_blank"><i class="fa fa-file"></i>
                                                                        {{ Illuminate\Support\Str::limit($maintank_6_1_file, 30) }}</a>
                                                                </div>
                                                            </div>
                                                        @else
                                                            <div class="col-md-12 mt-3">
                                                                <x-kplh-file wire:model="maintank_6_1_file"
                                                                    id="maintank_6_1_file" placeholder="File"
                                                                    :error="'maintank_6_1_file'" />
                                                            </div>
                                                        @endif
                                                    </div>

                                                </div>
                                            </div>
                                        </div><!-- /.form-group maintank_6_1 -->

                                        <div class="row form-group mb-4">
                                            <label for="maintank_6_2_label"
                                                class="col-lg-4 col-md-12 col-form-label">Pastikan grounding system
                                                tidak
                                                digunakan untuk antena, peralatan listrik dan instalasi listrik.
                                            </label>
                                            <div class="col-lg-8 col-md-12">
                                                <div class="wrapper_maintank_6_2 d-flex flex-column gap-3"
                                                    x-data="{ maintank_6_2_value: @entangle('maintank_6_2_value') }">
                                                    <x-inputs.select2 wire:model="maintank_6_2_value"
                                                        id="maintank_6_2_value" class="form-select"
                                                        placeholder="Pemenuhan">
                                                        <option value="Ya">Ya</option>
                                                        <option value="Tidak">Tidak</option>
                                                        <option value="N/A">N/A</option>
                                                    </x-inputs.select2>

                                                    <div x-cloak
                                                        x-show="maintank_6_2_value === 'Tidak' || maintank_6_2_value === '5' ">
                                                        <div>
                                                            <x-kplh-texteditor wire:model="maintank_6_2_note"
                                                                id="maintank_6_2_note" placeholder="Keterangan"
                                                                :error="'maintank_6_2_note'" />
                                                        </div>
                                                        @if ($maintank_6_2_file && !Illuminate\Support\Str::contains($maintank_6_2_file, 'private/var/folders/'))
                                                            <div class="row mt-3">
                                                                <div class="col-md-3"><button type="button"
                                                                        class="btn btn-outline-secondary"
                                                                        wire:click="setFileNull('maintank_6_2_file')"><i
                                                                            class="fa fa-edit"></i> Ubah
                                                                        File</button></div>
                                                                <div class="col-md-9">
                                                                    <a class="btn btn-outline-secondary"
                                                                        href="{{ route('kplh::download-file', ['maintank', $maintank_6_2_file]) }}"
                                                                        target="_blank"><i class="fa fa-file"></i>
                                                                        {{ Illuminate\Support\Str::limit($maintank_6_2_file, 30) }}</a>
                                                                </div>
                                                            </div>
                                                        @else
                                                            <div class="col-md-12 mt-3">
                                                                <x-kplh-file wire:model="maintank_6_2_file"
                                                                    id="maintank_6_2_file" placeholder="File"
                                                                    :error="'maintank_6_2_file'" />
                                                            </div>
                                                        @endif
                                                    </div>

                                                </div>
                                            </div>
                                        </div><!-- /.form-group maintank_6_2 -->

                                        <div class="row form-group mb-4">
                                            <label for="maintank_6_3_label"
                                                class="col-lg-4 col-md-12 col-form-label">Pastikan grounding system
                                                dan
                                                down conductor tidak memiliki hambatan melebihi 5 Ω.
                                            </label>
                                            <div class="col-lg-8 col-md-12">
                                                <div class="wrapper_maintank_6_3 d-flex flex-column gap-3"
                                                    x-data="{ maintank_6_3_value: @entangle('maintank_6_3_value') }">
                                                    <x-inputs.select2 wire:model="maintank_6_3_value"
                                                        id="maintank_6_3_value" class="form-select"
                                                        placeholder="Pemenuhan">
                                                        <option value="Ya">Ya</option>
                                                        <option value="Tidak">Tidak</option>
                                                        <option value="N/A">N/A</option>
                                                    </x-inputs.select2>

                                                    <div x-cloak
                                                        x-show="maintank_6_3_value === 'Tidak' || maintank_6_3_value === '5' ">
                                                        <div>
                                                            <x-kplh-texteditor wire:model="maintank_6_3_note"
                                                                id="maintank_6_3_note" placeholder="Keterangan"
                                                                :error="'maintank_6_3_note'" />
                                                        </div>
                                                        @if ($maintank_6_3_file && !Illuminate\Support\Str::contains($maintank_6_3_file, 'private/var/folders/'))
                                                            <div class="row mt-3">
                                                                <div class="col-md-3"><button type="button"
                                                                        class="btn btn-outline-secondary"
                                                                        wire:click="setFileNull('maintank_6_3_file')"><i
                                                                            class="fa fa-edit"></i> Ubah
                                                                        File</button></div>
                                                                <div class="col-md-9">
                                                                    <a class="btn btn-outline-secondary"
                                                                        href="{{ route('kplh::download-file', ['maintank', $maintank_6_3_file]) }}"
                                                                        target="_blank"><i class="fa fa-file"></i>
                                                                        {{ Illuminate\Support\Str::limit($maintank_6_3_file, 30) }}</a>
                                                                </div>
                                                            </div>
                                                        @else
                                                            <div class="col-md-12 mt-3">
                                                                <x-kplh-file wire:model="maintank_6_3_file"
                                                                    id="maintank_6_3_file" placeholder="File"
                                                                    :error="'maintank_6_3_file'" />
                                                            </div>
                                                        @endif
                                                    </div>
                                                </div>
                                            </div>
                                        </div><!-- /.form-group maintank_6_3 -->

                                        <div class="row form-group mb-4">
                                            <label for="maintank_6_4_label"
                                                class="col-lg-4 col-md-12 col-form-label">Pastikan Kabel grounding
                                                tertanam
                                                ke tanah, test point dilengkapi box pelindung.
                                            </label>
                                            <div class="col-lg-8 col-md-12">
                                                <div class="wrapper_maintank_6_4 d-flex flex-column gap-3"
                                                    x-data="{ maintank_6_4_value: @entangle('maintank_6_4_value') }">
                                                    <x-inputs.select2 wire:model="maintank_6_4_value"
                                                        id="maintank_6_4_value" class="form-select"
                                                        placeholder="Pemenuhan">
                                                        <option value="Ya">Ya</option>
                                                        <option value="Tidak">Tidak</option>
                                                        <option value="N/A">N/A</option>
                                                    </x-inputs.select2>

                                                    <div x-cloak
                                                        x-show="maintank_6_4_value === 'Tidak' || maintank_6_4_value === '5' ">
                                                        <div>
                                                            <x-kplh-texteditor wire:model="maintank_6_4_note"
                                                                id="maintank_6_4_note" placeholder="Keterangan"
                                                                :error="'maintank_6_4_note'" />
                                                        </div>
                                                        @if ($maintank_6_4_file && !Illuminate\Support\Str::contains($maintank_6_4_file, 'private/var/folders/'))
                                                            <div class="row mt-3">
                                                                <div class="col-md-3"><button type="button"
                                                                        class="btn btn-outline-secondary"
                                                                        wire:click="setFileNull('maintank_6_4_file')"><i
                                                                            class="fa fa-edit"></i> Ubah
                                                                        File</button></div>
                                                                <div class="col-md-9">
                                                                    <a class="btn btn-outline-secondary"
                                                                        href="{{ route('kplh::download-file', ['maintank', $maintank_6_4_file]) }}"
                                                                        target="_blank"><i class="fa fa-file"></i>
                                                                        {{ Illuminate\Support\Str::limit($maintank_6_4_file, 30) }}</a>
                                                                </div>
                                                            </div>
                                                        @else
                                                            <div class="col-md-12 mt-3">
                                                                <x-kplh-file wire:model="maintank_6_4_file"
                                                                    id="maintank_6_4_file" placeholder="File"
                                                                    :error="'maintank_6_4_file'" />
                                                            </div>
                                                        @endif
                                                    </div>

                                                </div>
                                            </div>
                                        </div><!-- /.form-group maintank_6_4 -->

                                        <div class="row form-group mb-4">
                                            <h4 class="col-lg-12 col-md-12 col-form-label">7. Gate Valve</h4>
                                        </div>

                                        <div class="row form-group mb-4">
                                            <label for="maintank_7_1_label"
                                                class="col-lg-4 col-md-12 col-form-label">Tanda aliran (panah arah
                                                minyak)
                                                terlihat jelas
                                            </label>
                                            <div class="col-lg-8 col-md-12">
                                                <div class="wrapper_maintank_7_1 d-flex flex-column gap-3"
                                                    x-data="{ maintank_7_1_value: @entangle('maintank_7_1_value') }">
                                                    <x-inputs.select2 wire:model="maintank_7_1_value"
                                                        id="maintank_7_1_value" class="form-select"
                                                        placeholder="Pemenuhan">
                                                        <option value="Ya">Ya</option>
                                                        <option value="Tidak">Tidak</option>
                                                        <option value="N/A">N/A</option>
                                                    </x-inputs.select2>

                                                    <div x-cloak
                                                        x-show="maintank_7_1_value === 'Tidak' || maintank_7_1_value === '5' ">
                                                        <div>
                                                            <x-kplh-texteditor wire:model="maintank_7_1_note"
                                                                id="maintank_7_1_note" placeholder="Keterangan"
                                                                :error="'maintank_7_1_note'" />
                                                        </div>
                                                        @if ($maintank_7_1_file && !Illuminate\Support\Str::contains($maintank_7_1_file, 'private/var/folders/'))
                                                            <div class="row mt-3">
                                                                <div class="col-md-3"><button type="button"
                                                                        class="btn btn-outline-secondary"
                                                                        wire:click="setFileNull('maintank_7_1_file')"><i
                                                                            class="fa fa-edit"></i> Ubah
                                                                        File</button></div>
                                                                <div class="col-md-9">
                                                                    <a class="btn btn-outline-secondary"
                                                                        href="{{ route('kplh::download-file', ['maintank', $maintank_7_1_file]) }}"
                                                                        target="_blank"><i class="fa fa-file"></i>
                                                                        {{ Illuminate\Support\Str::limit($maintank_7_1_file, 30) }}</a>
                                                                </div>
                                                            </div>
                                                        @else
                                                            <div class="col-md-12 mt-3">
                                                                <x-kplh-file wire:model="maintank_7_1_file"
                                                                    id="maintank_7_1_file" placeholder="File"
                                                                    :error="'maintank_7_1_file'" />
                                                            </div>
                                                        @endif
                                                    </div>
                                                </div>
                                            </div>
                                        </div><!-- /.form-group maintank_7_1 -->

                                        <div class="row form-group mb-4">
                                            <label for="maintank_7_2_label"
                                                class="col-lg-4 col-md-12 col-form-label">Drat
                                                baut pada gate valve dilumuri grease
                                            </label>
                                            <div class="col-lg-8 col-md-12">
                                                <div class="wrapper_maintank_7_2 d-flex flex-column gap-3"
                                                    x-data="{ maintank_7_2_value: @entangle('maintank_7_2_value') }">
                                                    <x-inputs.select2 wire:model="maintank_7_2_value"
                                                        id="maintank_7_2_value" class="form-select"
                                                        placeholder="Pemenuhan">
                                                        <option value="Ya">Ya</option>
                                                        <option value="Tidak">Tidak</option>
                                                        <option value="N/A">N/A</option>
                                                    </x-inputs.select2>

                                                    <div x-cloak
                                                        x-show="maintank_7_2_value === 'Tidak' || maintank_7_2_value === '5' ">
                                                        <div>
                                                            <x-kplh-texteditor wire:model="maintank_7_2_note"
                                                                id="maintank_7_2_note" placeholder="Keterangan"
                                                                :error="'maintank_7_2_note'" />
                                                        </div>
                                                        @if ($maintank_7_2_file && !Illuminate\Support\Str::contains($maintank_7_2_file, 'private/var/folders/'))
                                                            <div class="row mt-3">
                                                                <div class="col-md-3"><button type="button"
                                                                        class="btn btn-outline-secondary"
                                                                        wire:click="setFileNull('maintank_7_2_file')"><i
                                                                            class="fa fa-edit"></i> Ubah
                                                                        File</button></div>
                                                                <div class="col-md-9">
                                                                    <a class="btn btn-outline-secondary"
                                                                        href="{{ route('kplh::download-file', ['maintank', $maintank_7_2_file]) }}"
                                                                        target="_blank"><i class="fa fa-file"></i>
                                                                        {{ Illuminate\Support\Str::limit($maintank_7_2_file, 30) }}</a>
                                                                </div>
                                                            </div>
                                                        @else
                                                            <div class="col-md-12 mt-3">
                                                                <x-kplh-file wire:model="maintank_7_2_file"
                                                                    id="maintank_7_2_file" placeholder="File"
                                                                    :error="'maintank_7_2_file'" />
                                                            </div>
                                                        @endif
                                                    </div>
                                                </div>
                                            </div>
                                        </div><!-- /.form-group maintank_7_2 -->

                                        <div class="row form-group mb-4">
                                            <label for="maintank_7_3_label"
                                                class="col-lg-4 col-md-12 col-form-label">Gate
                                                valve tidak mengeluarkan minyak
                                            </label>
                                            <div class="col-lg-8 col-md-12">
                                                <div class="wrapper_maintank_7_3 d-flex flex-column gap-3"
                                                    x-data="{ maintank_7_3_value: @entangle('maintank_7_3_value') }">
                                                    <x-inputs.select2 wire:model="maintank_7_3_value"
                                                        id="maintank_7_3_value" class="form-select"
                                                        placeholder="Pemenuhan">
                                                        <option value="Ya">Ya</option>
                                                        <option value="Tidak">Tidak</option>
                                                        <option value="N/A">N/A</option>
                                                    </x-inputs.select2>

                                                    <div x-cloak
                                                        x-show="maintank_7_3_value === 'Tidak' || maintank_7_3_value === '5' ">
                                                        <div>
                                                            <x-kplh-texteditor wire:model="maintank_7_3_note"
                                                                id="maintank_7_3_note" placeholder="Keterangan"
                                                                :error="'maintank_7_3_note'" />
                                                        </div>
                                                        @if ($maintank_7_3_file && !Illuminate\Support\Str::contains($maintank_7_3_file, 'private/var/folders/'))
                                                            <div class="row mt-3">
                                                                <div class="col-md-3"><button type="button"
                                                                        class="btn btn-outline-secondary"
                                                                        wire:click="setFileNull('maintank_7_3_file')"><i
                                                                            class="fa fa-edit"></i> Ubah
                                                                        File</button></div>
                                                                <div class="col-md-9">
                                                                    <a class="btn btn-outline-secondary"
                                                                        href="{{ route('kplh::download-file', ['maintank', $maintank_7_3_file]) }}"
                                                                        target="_blank"><i class="fa fa-file"></i>
                                                                        {{ Illuminate\Support\Str::limit($maintank_7_3_file, 30) }}</a>
                                                                </div>
                                                            </div>
                                                        @else
                                                            <div class="col-md-12 mt-3">
                                                                <x-kplh-file wire:model="maintank_7_3_file"
                                                                    id="maintank_7_3_file" placeholder="File"
                                                                    :error="'maintank_7_3_file'" />
                                                            </div>
                                                        @endif
                                                    </div>

                                                </div>
                                            </div>
                                        </div><!-- /.form-group maintank_7_3 -->

                                    </div><!-- ./content-maintank -->
                                </div>
                            </div><!-- /.maintank -->

                            <div id="maintank_roof" class="section-maintank_roof" x-data="{ accordionOpen: false }">
                                <button
                                    class="header-accordion d-flex justify-content-between w-100 border-0 bg-white py-3 px-0"
                                    @click.prevent="accordionOpen = ! accordionOpen">
                                    <h6 class="mb-0 fw-normal title-accordion">C. Atap Maintank</h6>
                                    <span x-bind:class="accordionOpen ? 'open' : ''"><img
                                            src="{{ asset('/images/icons/angle-down.png') }}"
                                            alt="" /></span>
                                </button>
                                <div class="wrapper-content-accordion max-h-0 overflow-hidden position-relative transition-all duration-700"
                                    x-ref="maintank_roof"
                                    x-bind:style="accordionOpen ? 'max-height: ' + 20000 + 'px' : ''"
                                    x-transition.delay.5000ms>

                                    <div class="content-section p-4" wire:ignore.self>

                                        <div class="row form-group mb-4">
                                            <h4 class="col-lg-12 col-md-12 col-form-label">1. Tangga
                                            </h4>
                                        </div>

                                        <div class="row form-group mb-4">
                                            <label for="maintank_roof_1_1_label"
                                                class="col-lg-4 col-md-12 col-form-label">Pastikan Handrail tidak
                                                rapuh,
                                                tidak patah, tidak retak, & tidak Berkarat.
                                            </label>
                                            <div class="col-lg-8 col-md-12">
                                                <div class="wrapper_maintank_roof_1_1 d-flex flex-column gap-3"
                                                    x-data="{ maintank_roof_1_1_value: @entangle('maintank_roof_1_1_value') }">
                                                    <x-inputs.select2 wire:model="maintank_roof_1_1_value"
                                                        id="maintank_roof_1_1_value" class="form-select"
                                                        placeholder="Pemenuhan">
                                                        <option value="Ya">Ya</option>
                                                        <option value="Tidak">Tidak</option>
                                                        <option value="N/A">N/A</option>
                                                    </x-inputs.select2>

                                                    <div x-cloak
                                                        x-show="maintank_roof_1_1_value === 'Tidak' || maintank_roof_1_1_value === '5' ">
                                                        <div>
                                                            <x-kplh-texteditor wire:model="maintank_roof_1_1_note"
                                                                id="maintank_roof_1_1_note" placeholder="Keterangan"
                                                                :error="'maintank_roof_1_1_note'" />
                                                        </div>
                                                        @if ($maintank_roof_1_1_file && !Illuminate\Support\Str::contains($maintank_roof_1_1_file, 'private/var/folders/'))
                                                            <div class="row mt-3">
                                                                <div class="col-md-3"><button type="button"
                                                                        class="btn btn-outline-secondary"
                                                                        wire:click="setFileNull('maintank_roof_1_1_file')"><i
                                                                            class="fa fa-edit"></i> Ubah
                                                                        File</button></div>
                                                                <div class="col-md-9">
                                                                    <a class="btn btn-outline-secondary"
                                                                        href="{{ route('kplh::download-file', ['maintank', $maintank_roof_1_1_file]) }}"
                                                                        target="_blank"><i class="fa fa-file"></i>
                                                                        {{ Illuminate\Support\Str::limit($maintank_roof_1_1_file, 30) }}</a>
                                                                </div>
                                                            </div>
                                                        @else
                                                            <div class="col-md-12 mt-3">
                                                                <x-kplh-file wire:model="maintank_roof_1_1_file"
                                                                    id="maintank_roof_1_1_file"
                                                                    placeholder="File" :error="'maintank_roof_1_1_file'" />
                                                            </div>
                                                        @endif
                                                    </div>
                                                </div>
                                            </div>
                                        </div><!-- /.form-group maintank_roof_1_1 -->

                                        <div class="row form-group mb-4">
                                            <label for="maintank_roof_1_2_label"
                                                class="col-lg-4 col-md-12 col-form-label">Pastikan Pijakan tangga
                                                tidak
                                                rapuh, tidak berlubang, & lengkap tiap pijakan.
                                            </label>
                                            <div class="col-lg-8 col-md-12">
                                                <div class="wrapper_maintank_roof_1_2 d-flex flex-column gap-3"
                                                    x-data="{ maintank_roof_1_2_value: @entangle('maintank_roof_1_2_value') }">
                                                    <x-inputs.select2 wire:model="maintank_roof_1_2_value"
                                                        id="maintank_roof_1_2_value" class="form-select"
                                                        placeholder="Pemenuhan">
                                                        <option value="Ya">Ya</option>
                                                        <option value="Tidak">Tidak</option>
                                                        <option value="N/A">N/A</option>
                                                    </x-inputs.select2>
                                                    <div x-cloak
                                                        x-show="maintank_roof_1_2_value === 'Tidak' || maintank_roof_1_2_value === '5' ">
                                                        <div>
                                                            <x-kplh-texteditor wire:model="maintank_roof_1_2_note"
                                                                id="maintank_roof_1_2_note" placeholder="Keterangan"
                                                                :error="'maintank_roof_1_2_note'" />
                                                        </div>
                                                        @if ($maintank_roof_1_2_file && !Illuminate\Support\Str::contains($maintank_roof_1_2_file, 'private/var/folders/'))
                                                            <div class="row mt-3">
                                                                <div class="col-md-3"><button type="button"
                                                                        class="btn btn-outline-secondary"
                                                                        wire:click="setFileNull('maintank_roof_1_2_file')"><i
                                                                            class="fa fa-edit"></i> Ubah
                                                                        File</button></div>
                                                                <div class="col-md-9">
                                                                    <a class="btn btn-outline-secondary"
                                                                        href="{{ route('kplh::download-file', ['maintank', $maintank_roof_1_2_file]) }}"
                                                                        target="_blank"><i class="fa fa-file"></i>
                                                                        {{ Illuminate\Support\Str::limit($maintank_roof_1_2_file, 30) }}</a>
                                                                </div>
                                                            </div>
                                                        @else
                                                            <div class="col-md-12 mt-3">
                                                                <x-kplh-file wire:model="maintank_roof_1_2_file"
                                                                    id="maintank_roof_1_2_file"
                                                                    placeholder="File" :error="'maintank_roof_1_2_file'" />
                                                            </div>
                                                        @endif
                                                    </div>
                                                </div>
                                            </div>
                                        </div><!-- /.form-group maintank_roof_1_2 -->

                                        <div class="row form-group mb-4">
                                            <h4 class="col-lg-12 col-md-12 col-form-label">2. Handrail atap maintank
                                            </h4>
                                        </div>

                                        <div class="row form-group mb-4">
                                            <label for="maintank_roof_2_1_label"
                                                class="col-lg-4 col-md-12 col-form-label">Pastikan sambungan tiap
                                                handrail
                                                tidak lepas, retak, dan miring.
                                            </label>
                                            <div class="col-lg-8 col-md-12">
                                                <div class="wrapper_maintank_roof_2_1 d-flex flex-column gap-3"
                                                    x-data="{ maintank_roof_2_1_value: @entangle('maintank_roof_2_1_value') }">
                                                    <x-inputs.select2 wire:model="maintank_roof_2_1_value"
                                                        id="maintank_roof_2_1_value" class="form-select"
                                                        placeholder="Pemenuhan">
                                                        <option value="Ya">Ya</option>
                                                        <option value="Tidak">Tidak</option>
                                                        <option value="N/A">N/A</option>
                                                    </x-inputs.select2>

                                                    <div x-cloak
                                                        x-show="maintank_roof_2_1_value === 'Tidak' || maintank_roof_2_1_value === '5' ">
                                                        <div>
                                                            <x-kplh-texteditor wire:model="maintank_roof_2_1_note"
                                                                id="maintank_roof_2_1_note" placeholder="Keterangan"
                                                                :error="'maintank_roof_2_1_note'" />
                                                        </div>
                                                        @if ($maintank_roof_2_1_file && !Illuminate\Support\Str::contains($maintank_roof_2_1_file, 'private/var/folders/'))
                                                            <div class="row mt-3">
                                                                <div class="col-md-3"><button type="button"
                                                                        class="btn btn-outline-secondary"
                                                                        wire:click="setFileNull('maintank_roof_2_1_file')"><i
                                                                            class="fa fa-edit"></i> Ubah
                                                                        File</button></div>
                                                                <div class="col-md-9">
                                                                    <a class="btn btn-outline-secondary"
                                                                        href="{{ route('kplh::download-file', ['maintank', $maintank_roof_2_1_file]) }}"
                                                                        target="_blank"><i class="fa fa-file"></i>
                                                                        {{ Illuminate\Support\Str::limit($maintank_roof_2_1_file, 30) }}</a>
                                                                </div>
                                                            </div>
                                                        @else
                                                            <div class="col-md-12 mt-3">
                                                                <x-kplh-file wire:model="maintank_roof_2_1_file"
                                                                    id="maintank_roof_2_1_file"
                                                                    placeholder="File" :error="'maintank_roof_2_1_file'" />
                                                            </div>
                                                        @endif
                                                    </div>

                                                </div>
                                            </div>
                                        </div><!-- /.form-group maintank_roof_2_1 -->

                                        <div class="row form-group mb-4">
                                            <label for="maintank_roof_2_2_label"
                                                class="col-lg-4 col-md-12 col-form-label">Pastikan Handrail tidak
                                                rapuh,
                                                tidak patah, tidak retak, & tidak Berkarat.
                                            </label>
                                            <div class="col-lg-8 col-md-12">
                                                <div class="wrapper_maintank_roof_2_2 d-flex flex-column gap-3"
                                                    x-data="{ maintank_roof_2_2_value: @entangle('maintank_roof_2_2_value') }">
                                                    <x-inputs.select2 wire:model="maintank_roof_2_2_value"
                                                        id="maintank_roof_2_2_value" class="form-select"
                                                        placeholder="Pemenuhan">
                                                        <option value="Ya">Ya</option>
                                                        <option value="Tidak">Tidak</option>
                                                        <option value="N/A">N/A</option>
                                                    </x-inputs.select2>

                                                    <div x-cloak
                                                        x-show="maintank_roof_2_2_value === 'Tidak' || maintank_roof_2_2_value === '5' ">
                                                        <div>
                                                            <x-kplh-texteditor wire:model="maintank_roof_2_2_note"
                                                                id="maintank_roof_2_2_note" placeholder="Keterangan"
                                                                :error="'maintank_roof_2_2_note'" />
                                                        </div>
                                                        @if ($maintank_roof_2_2_file && !Illuminate\Support\Str::contains($maintank_roof_2_2_file, 'private/var/folders/'))
                                                            <div class="row mt-3">
                                                                <div class="col-md-3"><button type="button"
                                                                        class="btn btn-outline-secondary"
                                                                        wire:click="setFileNull('maintank_roof_2_2_file')"><i
                                                                            class="fa fa-edit"></i> Ubah
                                                                        File</button></div>
                                                                <div class="col-md-9">
                                                                    <a class="btn btn-outline-secondary"
                                                                        href="{{ route('kplh::download-file', ['maintank', $maintank_roof_2_2_file]) }}"
                                                                        target="_blank"><i class="fa fa-file"></i>
                                                                        {{ Illuminate\Support\Str::limit($maintank_roof_2_2_file, 30) }}</a>
                                                                </div>
                                                            </div>
                                                        @else
                                                            <div class="col-md-12 mt-3">
                                                                <x-kplh-file wire:model="maintank_roof_2_2_file"
                                                                    id="maintank_roof_2_2_file"
                                                                    placeholder="File" :error="'maintank_roof_2_2_file'" />
                                                            </div>
                                                        @endif
                                                    </div>

                                                </div>
                                            </div>
                                        </div><!-- /.form-group maintank_roof_2_2 -->

                                        <div class="row form-group mb-4">
                                            <h4 class="col-lg-12 col-md-12 col-form-label">3. Plat bagian atas
                                                maintank
                                            </h4>
                                        </div>

                                        <div class="row form-group mb-4">
                                            <label for="maintank_roof_3_1_label"
                                                class="col-lg-4 col-md-12 col-form-label">Pastikan free venting
                                                maintank
                                                tidak tertutup atau tersumbat.
                                            </label>
                                            <div class="col-lg-8 col-md-12">
                                                <div class="wrapper_maintank_roof_3_1 d-flex flex-column gap-3"
                                                    x-data="{ maintank_roof_3_1_value: @entangle('maintank_roof_3_1_value') }">
                                                    <x-inputs.select2 wire:model="maintank_roof_3_1_value"
                                                        id="maintank_roof_3_1_value" class="form-select"
                                                        placeholder="Pemenuhan">
                                                        <option value="Ya">Ya</option>
                                                        <option value="Tidak">Tidak</option>
                                                        <option value="N/A">N/A</option>
                                                    </x-inputs.select2>

                                                    <div x-cloak
                                                        x-show="maintank_roof_3_1_value === 'Tidak' || maintank_roof_3_1_value === '5' ">
                                                        <div>
                                                            <x-kplh-texteditor wire:model="maintank_roof_3_1_note"
                                                                id="maintank_roof_3_1_note" placeholder="Keterangan"
                                                                :error="'maintank_roof_3_1_note'" />
                                                        </div>
                                                        @if ($maintank_roof_3_1_file && !Illuminate\Support\Str::contains($maintank_roof_3_1_file, 'private/var/folders/'))
                                                            <div class="row mt-3">
                                                                <div class="col-md-3"><button type="button"
                                                                        class="btn btn-outline-secondary"
                                                                        wire:click="setFileNull('maintank_roof_3_1_file')"><i
                                                                            class="fa fa-edit"></i> Ubah
                                                                        File</button></div>
                                                                <div class="col-md-9">
                                                                    <a class="btn btn-outline-secondary"
                                                                        href="{{ route('kplh::download-file', ['maintank', $maintank_roof_3_1_file]) }}"
                                                                        target="_blank"><i class="fa fa-file"></i>
                                                                        {{ Illuminate\Support\Str::limit($maintank_roof_3_1_file, 30) }}</a>
                                                                </div>
                                                            </div>
                                                        @else
                                                            <div class="col-md-12 mt-3">
                                                                <x-kplh-file wire:model="maintank_roof_3_1_file"
                                                                    id="maintank_roof_3_1_file"
                                                                    placeholder="File" :error="'maintank_roof_3_1_file'" />
                                                            </div>
                                                        @endif
                                                    </div>

                                                </div>
                                            </div>
                                        </div><!-- /.form-group maintank_roof_3_1 -->

                                        <div class="row form-group mb-4">
                                            <label for="maintank_roof_3_2_label"
                                                class="col-lg-4 col-md-12 col-form-label">Pastikan tampak fisik plat
                                                tidak
                                                berlubang, tidak rapuh, tidak penyok, tidak retak dan harus datar.
                                            </label>
                                            <div class="col-lg-8 col-md-12">
                                                <div class="wrapper_maintank_roof_3_2 d-flex flex-column gap-3"
                                                    x-data="{ maintank_roof_3_2_value: @entangle('maintank_roof_3_2_value') }">
                                                    <x-inputs.select2 wire:model="maintank_roof_3_2_value"
                                                        id="maintank_roof_3_2_value" class="form-select"
                                                        placeholder="Pemenuhan">
                                                        <option value="Ya">Ya</option>
                                                        <option value="Tidak">Tidak</option>
                                                        <option value="N/A">N/A</option>
                                                    </x-inputs.select2>

                                                    <div x-cloak
                                                        x-show="maintank_roof_3_2_value === 'Tidak' || maintank_roof_3_2_value === '5' ">
                                                        <div>
                                                            <x-kplh-texteditor wire:model="maintank_roof_3_2_note"
                                                                id="maintank_roof_3_2_note" placeholder="Keterangan"
                                                                :error="'maintank_roof_3_2_note'" />
                                                        </div>
                                                        @if ($maintank_roof_3_2_file && !Illuminate\Support\Str::contains($maintank_roof_3_2_file, 'private/var/folders/'))
                                                            <div class="row mt-3">
                                                                <div class="col-md-3"><button type="button"
                                                                        class="btn btn-outline-secondary"
                                                                        wire:click="setFileNull('maintank_roof_3_2_file')"><i
                                                                            class="fa fa-edit"></i> Ubah
                                                                        File</button></div>
                                                                <div class="col-md-9">
                                                                    <a class="btn btn-outline-secondary"
                                                                        href="{{ route('kplh::download-file', ['maintank', $maintank_roof_3_2_file]) }}"
                                                                        target="_blank"><i class="fa fa-file"></i>
                                                                        {{ Illuminate\Support\Str::limit($maintank_roof_3_2_file, 30) }}</a>
                                                                </div>
                                                            </div>
                                                        @else
                                                            <div class="col-md-12 mt-3">
                                                                <x-kplh-file wire:model="maintank_roof_3_2_file"
                                                                    id="maintank_roof_3_2_file"
                                                                    placeholder="File" :error="'maintank_roof_3_2_file'" />
                                                            </div>
                                                        @endif
                                                    </div>

                                                </div>
                                            </div>
                                        </div><!-- /.form-group maintank_roof_3_2 -->

                                        <div class="row form-group mb-4">
                                            <label for="maintank_roof_3_3_label"
                                                class="col-lg-4 col-md-12 col-form-label">Pastikan atap maintank
                                                bersih
                                                dari ceceran minyak dan majun/ sarung tangan.
                                            </label>
                                            <div class="col-lg-8 col-md-12">
                                                <div class="wrapper_maintank_roof_3_3 d-flex flex-column gap-3"
                                                    x-data="{ maintank_roof_3_3_value: @entangle('maintank_roof_3_3_value') }">
                                                    <x-inputs.select2 wire:model="maintank_roof_3_3_value"
                                                        id="maintank_roof_3_3_value" class="form-select"
                                                        placeholder="Pemenuhan">
                                                        <option value="Ya">Ya</option>
                                                        <option value="Tidak">Tidak</option>
                                                        <option value="N/A">N/A</option>
                                                    </x-inputs.select2>

                                                    <div x-cloak
                                                        x-show="maintank_roof_3_3_value === 'Tidak' || maintank_roof_3_3_value === '5' ">
                                                        <div>
                                                            <x-kplh-texteditor wire:model="maintank_roof_3_3_note"
                                                                id="maintank_roof_3_3_note" placeholder="Keterangan"
                                                                :error="'maintank_roof_3_3_note'" />
                                                        </div>
                                                        @if ($maintank_roof_3_3_file && !Illuminate\Support\Str::contains($maintank_roof_3_3_file, 'private/var/folders/'))
                                                            <div class="row mt-3">
                                                                <div class="col-md-3"><button type="button"
                                                                        class="btn btn-outline-secondary"
                                                                        wire:click="setFileNull('maintank_roof_3_3_file')"><i
                                                                            class="fa fa-edit"></i> Ubah
                                                                        File</button></div>
                                                                <div class="col-md-9">
                                                                    <a class="btn btn-outline-secondary"
                                                                        href="{{ route('kplh::download-file', ['maintank', $maintank_roof_3_3_file]) }}"
                                                                        target="_blank"><i class="fa fa-file"></i>
                                                                        {{ Illuminate\Support\Str::limit($maintank_roof_3_3_file, 30) }}</a>
                                                                </div>
                                                            </div>
                                                        @else
                                                            <div class="col-md-12 mt-3">
                                                                <x-kplh-file wire:model="maintank_roof_3_3_file"
                                                                    id="maintank_roof_3_3_file"
                                                                    placeholder="File" :error="'maintank_roof_3_3_file'" />
                                                            </div>
                                                        @endif
                                                    </div>

                                                </div>
                                            </div>
                                        </div><!-- /.form-group maintank_roof_3_3 -->

                                        <div class="row form-group mb-4">
                                            <label for="maintank_roof_3_4_label"
                                                class="col-lg-4 col-md-12 col-form-label">Pastikan sambungan antar
                                                plat
                                                tidak ada rembesan & tidak lepas.
                                            </label>
                                            <div class="col-lg-8 col-md-12">
                                                <div class="wrapper_maintank_roof_3_4 d-flex flex-column gap-3"
                                                    x-data="{ maintank_roof_3_4_value: @entangle('maintank_roof_3_4_value') }">
                                                    <x-inputs.select2 wire:model="maintank_roof_3_4_value"
                                                        id="maintank_roof_3_4_value" class="form-select"
                                                        placeholder="Pemenuhan">
                                                        <option value="Ya">Ya</option>
                                                        <option value="Tidak">Tidak</option>
                                                        <option value="N/A">N/A</option>
                                                    </x-inputs.select2>

                                                    <div x-cloak
                                                        x-show="maintank_roof_3_4_value === 'Tidak' || maintank_roof_3_4_value === '5' ">
                                                        <div>
                                                            <x-kplh-texteditor wire:model="maintank_roof_3_4_note"
                                                                id="maintank_roof_3_4_note" placeholder="Keterangan"
                                                                :error="'maintank_roof_3_4_note'" />
                                                        </div>
                                                        <div class="mt-3">
                                                            @if ($maintank_roof_3_4_file && !Illuminate\Support\Str::contains($maintank_roof_3_4_file, 'private/var/folders/'))
                                                                <div class="row mt-3">
                                                                    <div class="col-md-3"><button type="button"
                                                                            class="btn btn-outline-secondary"
                                                                            wire:click="setFileNull('maintank_roof_3_4_file')"><i
                                                                                class="fa fa-edit"></i> Ubah
                                                                            File</button></div>
                                                                    <div class="col-md-9">
                                                                        <a class="btn btn-outline-secondary"
                                                                            href="{{ route('kplh::download-file', ['maintank', $maintank_roof_3_4_file]) }}"
                                                                            target="_blank"><i
                                                                                class="fa fa-file"></i>
                                                                            {{ Illuminate\Support\Str::limit($maintank_roof_3_4_file, 30) }}</a>
                                                                    </div>
                                                                </div>
                                                            @else
                                                                <div class="col-md-12 mt-3">
                                                                    <x-kplh-file wire:model="maintank_roof_3_4_file"
                                                                        id="maintank_roof_3_4_file"
                                                                        placeholder="File" :error="'maintank_roof_3_4_file'" />
                                                                </div>
                                                            @endif
                                                        </div>

                                                    </div>
                                                </div>
                                            </div><!-- /.form-group maintank_roof_3_4 -->

                                            <div class="row form-group mb-4">
                                                <h4 class="col-lg-12 col-md-12 col-form-label">4. Manhole</h4>
                                            </div>

                                            <div class="row form-group mb-4">
                                                <label for="maintank_roof_4_1_label"
                                                    class="col-lg-4 col-md-12 col-form-label">Pastikan Tutup manhole
                                                    rapat dan
                                                    baut tidak ada yang lepas.
                                                </label>
                                                <div class="col-lg-8 col-md-12">
                                                    <div class="wrapper_maintank_roof_4_1 d-flex flex-column gap-3"
                                                        x-data="{ maintank_roof_4_1_value: @entangle('maintank_roof_4_1_value') }">
                                                        <x-inputs.select2 wire:model="maintank_roof_4_1_value"
                                                            id="maintank_roof_4_1_value" class="form-select"
                                                            placeholder="Pemenuhan">
                                                            <option value="Ya">Ya</option>
                                                            <option value="Tidak">Tidak</option>
                                                            <option value="N/A">N/A</option>
                                                        </x-inputs.select2>

                                                        <div x-cloak
                                                            x-show="maintank_roof_4_1_value === 'Tidak' || maintank_roof_4_1_value === '5' ">
                                                            <div>
                                                                <x-kplh-texteditor wire:model="maintank_roof_4_1_note"
                                                                    id="maintank_roof_4_1_note"
                                                                    placeholder="Keterangan" :error="'maintank_roof_4_1_note'" />
                                                            </div>
                                                            @if ($maintank_roof_4_1_file && !Illuminate\Support\Str::contains($maintank_roof_4_1_file, 'private/var/folders/'))
                                                                <div class="row mt-3">
                                                                    <div class="col-md-3"><button type="button"
                                                                            class="btn btn-outline-secondary"
                                                                            wire:click="setFileNull('maintank_roof_4_1_file')"><i
                                                                                class="fa fa-edit"></i> Ubah
                                                                            File</button></div>
                                                                    <div class="col-md-9">
                                                                        <a class="btn btn-outline-secondary"
                                                                            href="{{ route('kplh::download-file', ['maintank', $maintank_roof_4_1_file]) }}"
                                                                            target="_blank"><i
                                                                                class="fa fa-file"></i>
                                                                            {{ Illuminate\Support\Str::limit($maintank_roof_4_1_file, 30) }}</a>
                                                                    </div>
                                                                </div>
                                                            @else
                                                                <div class="col-md-12 mt-3">
                                                                    <x-kplh-file wire:model="maintank_roof_4_1_file"
                                                                        id="maintank_roof_4_1_file"
                                                                        placeholder="File" :error="'maintank_roof_4_1_file'" />
                                                                </div>
                                                            @endif
                                                        </div>

                                                    </div>
                                                </div>
                                            </div><!-- /.form-group maintank_roof_4_1 -->

                                            <div class="row form-group mb-4">
                                                <label for="maintank_roof_4_2_label"
                                                    class="col-lg-4 col-md-12 col-form-label">Pastikan Sambungan las
                                                    pada
                                                    manhole tidak retak dan tidak bocor.
                                                </label>
                                                <div class="col-lg-8 col-md-12">
                                                    <div class="wrapper_maintank_roof_4_2 d-flex flex-column gap-3"
                                                        x-data="{ maintank_roof_4_2_value: @entangle('maintank_roof_4_2_value') }">
                                                        <x-inputs.select2 wire:model="maintank_roof_4_2_value"
                                                            id="maintank_roof_4_2_value" class="form-select"
                                                            placeholder="Pemenuhan">
                                                            <option value="Ya">Ya</option>
                                                            <option value="Tidak">Tidak</option>
                                                            <option value="N/A">N/A</option>
                                                        </x-inputs.select2>

                                                        <div x-cloak
                                                            x-show="maintank_roof_4_2_value === 'Tidak' || maintank_roof_4_2_value === '5' ">
                                                            <div>
                                                                <x-kplh-texteditor wire:model="maintank_roof_4_2_note"
                                                                    id="maintank_roof_4_2_note"
                                                                    placeholder="Keterangan" :error="'maintank_roof_4_2_note'" />
                                                            </div>
                                                            @if ($maintank_roof_4_2_file && !Illuminate\Support\Str::contains($maintank_roof_4_2_file, 'private/var/folders/'))
                                                                <div class="row mt-3">
                                                                    <div class="col-md-3"><button type="button"
                                                                            class="btn btn-outline-secondary"
                                                                            wire:click="setFileNull('maintank_roof_4_2_file')"><i
                                                                                class="fa fa-edit"></i> Ubah
                                                                            File</button></div>
                                                                    <div class="col-md-9">
                                                                        <a class="btn btn-outline-secondary"
                                                                            href="{{ route('kplh::download-file', ['maintank', $maintank_roof_4_2_file]) }}"
                                                                            target="_blank"><i
                                                                                class="fa fa-file"></i>
                                                                            {{ Illuminate\Support\Str::limit($maintank_roof_4_2_file, 30) }}</a>
                                                                    </div>
                                                                </div>
                                                            @else
                                                                <div class="col-md-12 mt-3">
                                                                    <x-kplh-file wire:model="maintank_roof_4_2_file"
                                                                        id="maintank_roof_4_2_file"
                                                                        placeholder="File" :error="'maintank_roof_4_2_file'" />
                                                                </div>
                                                            @endif
                                                        </div>

                                                    </div>
                                                </div>
                                            </div><!-- /.form-group maintank_roof_4_2 -->

                                            <div class="row form-group mb-4">
                                                <h4 class="col-lg-12 col-md-12 col-form-label">5. Tempat Sounding</h4>
                                            </div>

                                            <div class="row form-group mb-4">
                                                <label for="maintank_roof_5_1_label"
                                                    class="col-lg-4 col-md-12 col-form-label">Pastikan Tutup tersegel
                                                    dan
                                                    terkunci ketika tidak ada aktivitas sounding.
                                                </label>
                                                <div class="col-lg-8 col-md-12">
                                                    <div class="wrapper_maintank_roof_5_1 d-flex flex-column gap-3"
                                                        x-data="{ maintank_roof_5_1_value: @entangle('maintank_roof_5_1_value') }">
                                                        <x-inputs.select2 wire:model="maintank_roof_5_1_value"
                                                            id="maintank_roof_5_1_value" class="form-select"
                                                            placeholder="Pemenuhan">
                                                            <option value="Ya">Ya</option>
                                                            <option value="Tidak">Tidak</option>
                                                            <option value="N/A">N/A</option>
                                                        </x-inputs.select2>

                                                        <div x-cloak
                                                            x-show="maintank_roof_5_1_value === 'Tidak' || maintank_roof_5_1_value === '5' ">
                                                            <div>
                                                                <x-kplh-texteditor wire:model="maintank_roof_5_1_note"
                                                                    id="maintank_roof_5_1_note"
                                                                    placeholder="Keterangan" :error="'maintank_roof_5_1_note'" />
                                                            </div>
                                                            @if ($maintank_roof_5_1_file && !Illuminate\Support\Str::contains($maintank_roof_5_1_file, 'private/var/folders/'))
                                                                <div class="row mt-3">
                                                                    <div class="col-md-3"><button type="button"
                                                                            class="btn btn-outline-secondary"
                                                                            wire:click="setFileNull('maintank_roof_5_1_file')"><i
                                                                                class="fa fa-edit"></i> Ubah
                                                                            File</button></div>
                                                                    <div class="col-md-9">
                                                                        <a class="btn btn-outline-secondary"
                                                                            href="{{ route('kplh::download-file', ['maintank', $maintank_roof_5_1_file]) }}"
                                                                            target="_blank"><i
                                                                                class="fa fa-file"></i>
                                                                            {{ Illuminate\Support\Str::limit($maintank_roof_5_1_file, 30) }}</a>
                                                                    </div>
                                                                </div>
                                                            @else
                                                                <div class="col-md-12 mt-3">
                                                                    <x-kplh-file wire:model="maintank_roof_5_1_file"
                                                                        id="maintank_roof_5_1_file"
                                                                        placeholder="File" :error="'maintank_roof_5_1_file'" />
                                                                </div>
                                                            @endif
                                                        </div>

                                                    </div>
                                                </div>
                                            </div><!-- /.form-group maintank_roof_5_1 -->

                                            <div class="row form-group mb-4">
                                                <label for="maintank_roof_5_2_label"
                                                    class="col-lg-4 col-md-12 col-form-label">Pastikan angka tinggi
                                                    referensi
                                                    dan titik pengukuran pada lubang sounding terlihat jelas.
                                                </label>
                                                <div class="col-lg-8 col-md-12">
                                                    <div class="wrapper_maintank_roof_5_2 d-flex flex-column gap-3"
                                                        x-data="{ maintank_roof_5_2_value: @entangle('maintank_roof_5_2_value') }">
                                                        <x-inputs.select2 wire:model="maintank_roof_5_2_value"
                                                            id="maintank_roof_5_2_value" class="form-select"
                                                            placeholder="Pemenuhan">
                                                            <option value="Ya">Ya</option>
                                                            <option value="Tidak">Tidak</option>
                                                            <option value="N/A">N/A</option>
                                                        </x-inputs.select2>

                                                        <div x-cloak
                                                            x-show="maintank_roof_5_2_value === 'Tidak' || maintank_roof_5_2_value === '5' ">
                                                            <div>
                                                                <x-kplh-texteditor wire:model="maintank_roof_5_2_note"
                                                                    id="maintank_roof_5_2_note"
                                                                    placeholder="Keterangan" :error="'maintank_roof_5_2_note'" />
                                                            </div>
                                                            @if ($maintank_roof_5_2_file && !Illuminate\Support\Str::contains($maintank_roof_5_2_file, 'private/var/folders/'))
                                                                <div class="row mt-3">
                                                                    <div class="col-md-3"><button type="button"
                                                                            class="btn btn-outline-secondary"
                                                                            wire:click="setFileNull('maintank_roof_5_2_file')"><i
                                                                                class="fa fa-edit"></i> Ubah
                                                                            File</button></div>
                                                                    <div class="col-md-9">
                                                                        <a class="btn btn-outline-secondary"
                                                                            href="{{ route('kplh::download-file', ['maintank', $maintank_roof_5_2_file]) }}"
                                                                            target="_blank"><i
                                                                                class="fa fa-file"></i>
                                                                            {{ Illuminate\Support\Str::limit($maintank_roof_5_2_file, 30) }}</a>
                                                                    </div>
                                                                </div>
                                                            @else
                                                                <div class="col-md-12 mt-3">
                                                                    <x-kplh-file wire:model="maintank_roof_5_2_file"
                                                                        id="maintank_roof_5_2_file"
                                                                        placeholder="File" :error="'maintank_roof_5_2_file'" />
                                                                </div>
                                                            @endif
                                                        </div>

                                                    </div>
                                                </div>
                                            </div><!-- /.form-group maintank_roof_5_2 -->

                                            <div class="row form-group mb-4">
                                                <label for="maintank_roof_5_3_label"
                                                    class="col-lg-4 col-md-12 col-form-label">Pastikan Sambungan las
                                                    pada
                                                    tempat sounding tidak retak dan tidak bocor.
                                                </label>
                                                <div class="col-lg-8 col-md-12">
                                                    <div class="wrapper_maintank_roof_5_3 d-flex flex-column gap-3"
                                                        x-data="{ maintank_roof_5_3_value: @entangle('maintank_roof_5_3_value') }">
                                                        <x-inputs.select2 wire:model="maintank_roof_5_3_value"
                                                            id="maintank_roof_5_3_value" class="form-select"
                                                            placeholder="Pemenuhan">
                                                            <option value="Ya">Ya</option>
                                                            <option value="Tidak">Tidak</option>
                                                            <option value="N/A">N/A</option>
                                                        </x-inputs.select2>

                                                        <div x-cloak
                                                            x-show="maintank_roof_5_3_value === 'Tidak' || maintank_roof_5_3_value === '5' ">
                                                            <div>
                                                                <x-kplh-texteditor wire:model="maintank_roof_5_3_note"
                                                                    id="maintank_roof_5_3_note"
                                                                    placeholder="Keterangan" :error="'maintank_roof_5_3_note'" />
                                                            </div>
                                                            @if ($maintank_roof_5_3_file && !Illuminate\Support\Str::contains($maintank_roof_5_3_file, 'private/var/folders/'))
                                                                <div class="row mt-3">
                                                                    <div class="col-md-3"><button type="button"
                                                                            class="btn btn-outline-secondary"
                                                                            wire:click="setFileNull('maintank_roof_5_3_file')"><i
                                                                                class="fa fa-edit"></i> Ubah
                                                                            File</button></div>
                                                                    <div class="col-md-9">
                                                                        <a class="btn btn-outline-secondary"
                                                                            href="{{ route('kplh::download-file', ['maintank', $maintank_roof_5_3_file]) }}"
                                                                            target="_blank"><i
                                                                                class="fa fa-file"></i>
                                                                            {{ Illuminate\Support\Str::limit($maintank_roof_5_3_file, 30) }}</a>
                                                                    </div>
                                                                </div>
                                                            @else
                                                                <div class="col-md-12 mt-3">
                                                                    <x-kplh-file wire:model="maintank_roof_5_3_file"
                                                                        id="maintank_roof_5_3_file"
                                                                        placeholder="File" :error="'maintank_roof_5_3_file'" />
                                                                </div>
                                                            @endif
                                                        </div>

                                                    </div>
                                                </div>
                                            </div><!-- /.form-group maintank_roof_5_3 -->

                                        </div><!-- ./content-maintank_roof -->

                                    </div>
                                </div><!-- /.maintank_roof -->

                                <div id="maintank_area" class="section-maintank_area" x-data="{ accordionOpen: false }">
                                    <button
                                        class="header-accordion d-flex justify-content-between w-100 border-0 bg-white py-3 px-0"
                                        @click.prevent="accordionOpen = ! accordionOpen">
                                        <h6 class="mb-0 fw-normal title-accordion">D. Area Sekitar Maintank</h6>
                                        <span x-bind:class="accordionOpen ? 'open' : ''"><img
                                                src="{{ asset('/images/icons/angle-down.png') }}"
                                                alt="" /></span>
                                    </button>
                                    <div class="wrapper-content-accordion max-h-0 overflow-hidden position-relative transition-all duration-700"
                                        x-ref="maintank_area"
                                        x-bind:style="accordionOpen ? 'max-height: ' + 20000 + 'px' : ''"
                                        x-transition.delay.5000ms>

                                        <div class="content-section p-4" wire:ignore.self>

                                            <div class="row form-group mb-4">
                                                <h4 class="col-lg-12 col-md-12 col-form-label">1. Bundwall
                                                </h4>
                                            </div>

                                            <div class="row form-group mb-4">
                                                <label for="maintank_area_1_1_label"
                                                    class="col-lg-4 col-md-12 col-form-label">Pastikan kondisi konkrit
                                                    bundwall tidak berlubang, tidak retak, dan tidak ada genangan air.
                                                </label>
                                                <div class="col-lg-8 col-md-12">
                                                    <div class="wrapper_maintank_area_1_1 d-flex flex-column gap-3"
                                                        x-data="{ maintank_area_1_1_value: @entangle('maintank_area_1_1_value') }">
                                                        <x-inputs.select2 wire:model="maintank_area_1_1_value"
                                                            id="maintank_area_1_1_value" class="form-select"
                                                            placeholder="Pemenuhan">
                                                            <option value="Ya">Ya</option>
                                                            <option value="Tidak">Tidak</option>
                                                            <option value="N/A">N/A</option>
                                                        </x-inputs.select2>

                                                        <div x-cloak
                                                            x-show="maintank_area_1_1_value === 'Tidak' || maintank_area_1_1_value === '5' ">
                                                            <div>
                                                                <x-kplh-texteditor wire:model="maintank_area_1_1_note"
                                                                    id="maintank_area_1_1_note"
                                                                    placeholder="Keterangan" :error="'maintank_area_1_1_note'" />
                                                            </div>
                                                            @if ($maintank_area_1_1_file && !Illuminate\Support\Str::contains($maintank_area_1_1_file, 'private/var/folders/'))
                                                                <div class="row mt-3">
                                                                    <div class="col-md-3"><button type="button"
                                                                            class="btn btn-outline-secondary"
                                                                            wire:click="setFileNull('maintank_area_1_1_file')"><i
                                                                                class="fa fa-edit"></i> Ubah
                                                                            File</button></div>
                                                                    <div class="col-md-9">
                                                                        <a class="btn btn-outline-secondary"
                                                                            href="{{ route('kplh::download-file', ['maintank', $maintank_area_1_1_file]) }}"
                                                                            target="_blank"><i
                                                                                class="fa fa-file"></i>
                                                                            {{ Illuminate\Support\Str::limit($maintank_area_1_1_file, 30) }}</a>
                                                                    </div>
                                                                </div>
                                                            @else
                                                                <div class="col-md-12 mt-3">
                                                                    <x-kplh-file wire:model="maintank_area_1_1_file"
                                                                        id="maintank_area_1_1_file"
                                                                        placeholder="File" :error="'maintank_area_1_1_file'" />
                                                                </div>
                                                            @endif
                                                        </div>

                                                    </div>
                                                </div>
                                            </div><!-- /.form-group maintank_area_1_1 -->

                                            <div class="row form-group mb-4">
                                                <label for="maintank_area_1_2_label"
                                                    class="col-lg-4 col-md-12 col-form-label">Pastikan di pagar
                                                    bundwall
                                                    terdapat daya tampung / kapasitas tumpahan.
                                                </label>
                                                <div class="col-lg-8 col-md-12">
                                                    <div class="wrapper_maintank_area_1_2 d-flex flex-column gap-3"
                                                        x-data="{ maintank_area_1_2_value: @entangle('maintank_area_1_2_value') }">
                                                        <x-inputs.select2 wire:model="maintank_area_1_2_value"
                                                            id="maintank_area_1_2_value" class="form-select"
                                                            placeholder="Pemenuhan">
                                                            <option value="Ya">Ya</option>
                                                            <option value="Tidak">Tidak</option>
                                                            <option value="N/A">N/A</option>
                                                        </x-inputs.select2>
                                                        <div x-cloak
                                                            x-show="maintank_area_1_2_value === 'Tidak' || maintank_area_1_2_value === '5' ">
                                                            <div>
                                                                <x-kplh-texteditor wire:model="maintank_area_1_2_note"
                                                                    id="maintank_area_1_2_note"
                                                                    placeholder="Keterangan" :error="'maintank_area_1_2_note'" />
                                                            </div>
                                                            @if ($maintank_area_1_2_file && !Illuminate\Support\Str::contains($maintank_area_1_2_file, 'private/var/folders/'))
                                                                <div class="row mt-3">
                                                                    <div class="col-md-3"><button type="button"
                                                                            class="btn btn-outline-secondary"
                                                                            wire:click="setFileNull('maintank_area_1_2_file')"><i
                                                                                class="fa fa-edit"></i> Ubah
                                                                            File</button></div>
                                                                    <div class="col-md-9">
                                                                        <a class="btn btn-outline-secondary"
                                                                            href="{{ route('kplh::download-file', ['maintank', $maintank_area_1_2_file]) }}"
                                                                            target="_blank"><i
                                                                                class="fa fa-file"></i>
                                                                            {{ Illuminate\Support\Str::limit($maintank_area_1_2_file, 30) }}</a>
                                                                    </div>
                                                                </div>
                                                            @else
                                                                <div class="col-md-12 mt-3">
                                                                    <x-kplh-file wire:model="maintank_area_1_2_file"
                                                                        id="maintank_area_1_2_file"
                                                                        placeholder="File" :error="'maintank_area_1_2_file'" />
                                                                </div>
                                                            @endif
                                                        </div>
                                                    </div>
                                                </div>
                                            </div><!-- /.form-group maintank_area_1_2 -->

                                            <div class="row form-group mb-4">
                                                <label for="maintank_area_1_3_label"
                                                    class="col-lg-4 col-md-12 col-form-label">Pastikan terdapat warna
                                                    perbedaan ketinggian.
                                                </label>
                                                <div class="col-lg-8 col-md-12">
                                                    <div class="wrapper_maintank_area_1_3 d-flex flex-column gap-3"
                                                        x-data="{ maintank_area_1_3_value: @entangle('maintank_area_1_3_value') }">
                                                        <x-inputs.select2 wire:model="maintank_area_1_3_value"
                                                            id="maintank_area_1_3_value" class="form-select"
                                                            placeholder="Pemenuhan">
                                                            <option value="Ya">Ya</option>
                                                            <option value="Tidak">Tidak</option>
                                                            <option value="N/A">N/A</option>
                                                        </x-inputs.select2>
                                                        <div x-cloak
                                                            x-show="maintank_area_1_3_value === 'Tidak' || maintank_area_1_3_value === '5' ">
                                                            <div>
                                                                <x-kplh-texteditor wire:model="maintank_area_1_3_note"
                                                                    id="maintank_area_1_3_note"
                                                                    placeholder="Keterangan" :error="'maintank_area_1_3_note'" />
                                                            </div>
                                                            @if ($maintank_area_1_3_file && !Illuminate\Support\Str::contains($maintank_area_1_3_file, 'private/var/folders/'))
                                                                <div class="row mt-3">
                                                                    <div class="col-md-3"><button type="button"
                                                                            class="btn btn-outline-secondary"
                                                                            wire:click="setFileNull('maintank_area_1_3_file')"><i
                                                                                class="fa fa-edit"></i> Ubah
                                                                            File</button></div>
                                                                    <div class="col-md-9">
                                                                        <a class="btn btn-outline-secondary"
                                                                            href="{{ route('kplh::download-file', ['maintank', $maintank_area_1_3_file]) }}"
                                                                            target="_blank"><i
                                                                                class="fa fa-file"></i>
                                                                            {{ Illuminate\Support\Str::limit($maintank_area_1_3_file, 30) }}</a>
                                                                    </div>
                                                                </div>
                                                            @else
                                                                <div class="col-md-12 mt-3">
                                                                    <x-kplh-file wire:model="maintank_area_1_3_file"
                                                                        id="maintank_area_1_3_file"
                                                                        placeholder="File" :error="'maintank_area_1_3_file'" />
                                                                </div>
                                                            @endif
                                                        </div>
                                                    </div>
                                                </div>
                                            </div><!-- /.form-group maintank_area_1_3 -->

                                            <div class="row form-group mb-4">
                                                <label for="maintank_area_1_4_label"
                                                    class="col-lg-4 col-md-12 col-form-label">Warna perbedaan
                                                    ketinggian
                                                    terlihat & tidak pudar.
                                                </label>
                                                <div class="col-lg-8 col-md-12">
                                                    <div class="wrapper_maintank_area_1_4 d-flex flex-column gap-3"
                                                        x-data="{ maintank_area_1_4_value: @entangle('maintank_area_1_4_value') }">
                                                        <x-inputs.select2 wire:model="maintank_area_1_4_value"
                                                            id="maintank_area_1_4_value" class="form-select"
                                                            placeholder="Pemenuhan">
                                                            <option value="Ya">Ya</option>
                                                            <option value="Tidak">Tidak</option>
                                                            <option value="N/A">N/A</option>
                                                        </x-inputs.select2>

                                                        <div x-cloak
                                                            x-show="maintank_area_1_4_value === 'Tidak' || maintank_area_1_4_value === '5' ">
                                                            <div>
                                                                <x-kplh-texteditor wire:model="maintank_area_1_4_note"
                                                                    id="maintank_area_1_4_note"
                                                                    placeholder="Keterangan" :error="'maintank_area_1_4_note'" />
                                                            </div>
                                                            @if ($maintank_area_1_4_file && !Illuminate\Support\Str::contains($maintank_area_1_4_file, 'private/var/folders/'))
                                                                <div class="row mt-3">
                                                                    <div class="col-md-3"><button type="button"
                                                                            class="btn btn-outline-secondary"
                                                                            wire:click="setFileNull('maintank_area_1_4_file')"><i
                                                                                class="fa fa-edit"></i> Ubah
                                                                            File</button></div>
                                                                    <div class="col-md-9">
                                                                        <a class="btn btn-outline-secondary"
                                                                            href="{{ route('kplh::download-file', ['maintank', $maintank_area_1_4_file]) }}"
                                                                            target="_blank"><i
                                                                                class="fa fa-file"></i>
                                                                            {{ Illuminate\Support\Str::limit($maintank_area_1_4_file, 30) }}</a>
                                                                    </div>
                                                                </div>
                                                            @else
                                                                <div class="col-md-12 mt-3">
                                                                    <x-kplh-file wire:model="maintank_area_1_4_file"
                                                                        id="maintank_area_1_4_file"
                                                                        placeholder="File"
                                                                        :error="'maintank_area_1_4_file'" />
                                                                </div>
                                                            @endif
                                                        </div>

                                                    </div>
                                                </div>
                                            </div><!-- /.form-group maintank_area_1_4 -->

                                            <div class="row form-group mb-4">
                                                <h4 class="col-lg-12 col-md-12 col-form-label">2. Drainase</h4>
                                            </div>

                                            <div class="row form-group mb-4">
                                                <label for="maintank_area_2_1_label"
                                                    class="col-lg-4 col-md-12 col-form-label">Pastikan aliran air
                                                    limbah pada
                                                    drainase maintank mengalir ke fuel trap.
                                                </label>
                                                <div class="col-lg-8 col-md-12">
                                                    <div class="wrapper_maintank_area_2_1 d-flex flex-column gap-3"
                                                        x-data="{ maintank_area_2_1_value: @entangle('maintank_area_2_1_value') }">
                                                        <x-inputs.select2 wire:model="maintank_area_2_1_value"
                                                            id="maintank_area_2_1_value" class="form-select"
                                                            placeholder="Pemenuhan">
                                                            <option value="Ya">Ya</option>
                                                            <option value="Tidak">Tidak</option>
                                                            <option value="N/A">N/A</option>
                                                        </x-inputs.select2>

                                                        <div x-cloak
                                                            x-show="maintank_area_2_1_value === 'Tidak' || maintank_area_2_1_value === '5' ">
                                                            <div>
                                                                <x-kplh-texteditor wire:model="maintank_area_2_1_note"
                                                                    id="maintank_area_2_1_note"
                                                                    placeholder="Keterangan" :error="'maintank_area_2_1_note'" />
                                                            </div>
                                                            @if ($maintank_area_2_1_file && !Illuminate\Support\Str::contains($maintank_area_2_1_file, 'private/var/folders/'))
                                                                <div class="row mt-3">
                                                                    <div class="col-md-3"><button type="button"
                                                                            class="btn btn-outline-secondary"
                                                                            wire:click="setFileNull('maintank_area_2_1_file')"><i
                                                                                class="fa fa-edit"></i> Ubah
                                                                            File</button></div>
                                                                    <div class="col-md-9">
                                                                        <a class="btn btn-outline-secondary"
                                                                            href="{{ route('kplh::download-file', ['maintank', $maintank_area_2_1_file]) }}"
                                                                            target="_blank"><i
                                                                                class="fa fa-file"></i>
                                                                            {{ Illuminate\Support\Str::limit($maintank_area_2_1_file, 30) }}</a>
                                                                    </div>
                                                                </div>
                                                            @else
                                                                <div class="col-md-12 mt-3">
                                                                    <x-kplh-file wire:model="maintank_area_2_1_file"
                                                                        id="maintank_area_2_1_file"
                                                                        placeholder="File"
                                                                        :error="'maintank_area_2_1_file'" />
                                                                </div>
                                                            @endif
                                                        </div>

                                                    </div>
                                                </div>
                                            </div><!-- /.form-group maintank_area_2_1 -->

                                            <div class="row form-group mb-4">
                                                <label for="maintank_area_2_2_label"
                                                    class="col-lg-4 col-md-12 col-form-label">Pastikan saluran
                                                    drainase tidak
                                                    tertutup tanah maupun sampah.
                                                </label>
                                                <div class="col-lg-8 col-md-12">
                                                    <div class="wrapper_maintank_area_2_2 d-flex flex-column gap-3"
                                                        x-data="{ maintank_area_2_2_value: @entangle('maintank_area_2_2_value') }">
                                                        <x-inputs.select2 wire:model="maintank_area_2_2_value"
                                                            id="maintank_area_2_2_value" class="form-select"
                                                            placeholder="Pemenuhan">
                                                            <option value="Ya">Ya</option>
                                                            <option value="Tidak">Tidak</option>
                                                            <option value="N/A">N/A</option>
                                                        </x-inputs.select2>

                                                        <div x-cloak
                                                            x-show="maintank_area_2_2_value === 'Tidak' || maintank_area_2_2_value === '5' ">
                                                            <div>
                                                                <x-kplh-texteditor wire:model="maintank_area_2_2_note"
                                                                    id="maintank_area_2_2_note"
                                                                    placeholder="Keterangan" :error="'maintank_area_2_2_note'" />
                                                            </div>
                                                            @if ($maintank_area_2_2_file && !Illuminate\Support\Str::contains($maintank_area_2_2_file, 'private/var/folders/'))
                                                                <div class="row mt-3">
                                                                    <div class="col-md-3"><button type="button"
                                                                            class="btn btn-outline-secondary"
                                                                            wire:click="setFileNull('maintank_area_2_2_file')"><i
                                                                                class="fa fa-edit"></i> Ubah
                                                                            File</button></div>
                                                                    <div class="col-md-9">
                                                                        <a class="btn btn-outline-secondary"
                                                                            href="{{ route('kplh::download-file', ['maintank', $maintank_area_2_2_file]) }}"
                                                                            target="_blank"><i
                                                                                class="fa fa-file"></i>
                                                                            {{ Illuminate\Support\Str::limit($maintank_area_2_2_file, 30) }}</a>
                                                                    </div>
                                                                </div>
                                                            @else
                                                                <div class="col-md-12 mt-3">
                                                                    <x-kplh-file wire:model="maintank_area_2_2_file"
                                                                        id="maintank_area_2_2_file"
                                                                        placeholder="File"
                                                                        :error="'maintank_area_2_2_file'" />
                                                                </div>
                                                            @endif
                                                        </div>

                                                    </div>
                                                </div>
                                            </div><!-- /.form-group maintank_area_2_2 -->

                                            <div class="row form-group mb-4">
                                                <label for="maintank_area_2_3_label"
                                                    class="col-lg-4 col-md-12 col-form-label">Pastikan gate valve
                                                    drainage
                                                    dalam bundwall menuju Fuel Trap dalam keadaan berfungsi baik.
                                                </label>
                                                <div class="col-lg-8 col-md-12">
                                                    <div class="wrapper_maintank_area_2_3 d-flex flex-column gap-3"
                                                        x-data="{ maintank_area_2_3_value: @entangle('maintank_area_2_3_value') }">
                                                        <x-inputs.select2 wire:model="maintank_area_2_3_value"
                                                            id="maintank_area_2_3_value" class="form-select"
                                                            placeholder="Pemenuhan">
                                                            <option value="Ya">Ya</option>
                                                            <option value="Tidak">Tidak</option>
                                                            <option value="N/A">N/A</option>
                                                        </x-inputs.select2>

                                                        <div x-cloak
                                                            x-show="maintank_area_2_3_value === 'Tidak' || maintank_area_2_3_value === '5' ">
                                                            <div>
                                                                <x-kplh-texteditor wire:model="maintank_area_2_3_note"
                                                                    id="maintank_area_2_3_note"
                                                                    placeholder="Keterangan" :error="'maintank_area_2_3_note'" />
                                                            </div>
                                                            @if ($maintank_area_2_3_file && !Illuminate\Support\Str::contains($maintank_area_2_3_file, 'private/var/folders/'))
                                                                <div class="row mt-3">
                                                                    <div class="col-md-3"><button type="button"
                                                                            class="btn btn-outline-secondary"
                                                                            wire:click="setFileNull('maintank_area_2_3_file')"><i
                                                                                class="fa fa-edit"></i> Ubah
                                                                            File</button></div>
                                                                    <div class="col-md-9">
                                                                        <a class="btn btn-outline-secondary"
                                                                            href="{{ route('kplh::download-file', ['maintank', $maintank_area_2_3_file]) }}"
                                                                            target="_blank"><i
                                                                                class="fa fa-file"></i>
                                                                            {{ Illuminate\Support\Str::limit($maintank_area_2_3_file, 30) }}</a>
                                                                    </div>
                                                                </div>
                                                            @else
                                                                <div class="col-md-12 mt-3">
                                                                    <x-kplh-file wire:model="maintank_area_2_3_file"
                                                                        id="maintank_area_2_3_file"
                                                                        placeholder="File"
                                                                        :error="'maintank_area_2_3_file'" />
                                                                </div>
                                                            @endif
                                                        </div>

                                                    </div>
                                                </div>
                                            </div><!-- /.form-group maintank_area_2_3 -->

                                            <div class="row form-group mb-4">
                                                <label for="maintank_area_2_4_label"
                                                    class="col-lg-4 col-md-12 col-form-label">Kondisi konkrit tidak
                                                    boleh
                                                    rusak, pastikan minyak tidak meresap ke tanah.
                                                </label>
                                                <div class="col-lg-8 col-md-12">
                                                    <div class="wrapper_maintank_area_2_4 d-flex flex-column gap-3"
                                                        x-data="{ maintank_area_2_4_value: @entangle('maintank_area_2_4_value') }">
                                                        <x-inputs.select2 wire:model="maintank_area_2_4_value"
                                                            id="maintank_area_2_4_value" class="form-select"
                                                            placeholder="Pemenuhan">
                                                            <option value="Ya">Ya</option>
                                                            <option value="Tidak">Tidak</option>
                                                            <option value="N/A">N/A</option>
                                                        </x-inputs.select2>
                                                        <div x-cloak
                                                            x-show="maintank_area_2_4_value === 'Tidak' || maintank_area_2_4_value === '5' ">
                                                            <div>
                                                                <x-kplh-texteditor wire:model="maintank_area_2_4_note"
                                                                    id="maintank_area_2_4_note"
                                                                    placeholder="Keterangan" :error="'maintank_area_2_4_note'" />
                                                            </div>
                                                            @if ($maintank_area_2_4_file && !Illuminate\Support\Str::contains($maintank_area_2_4_file, 'private/var/folders/'))
                                                                <div class="row mt-3">
                                                                    <div class="col-md-3"><button type="button"
                                                                            class="btn btn-outline-secondary"
                                                                            wire:click="setFileNull('maintank_area_2_4_file')"><i
                                                                                class="fa fa-edit"></i> Ubah
                                                                            File</button></div>
                                                                    <div class="col-md-9">
                                                                        <a class="btn btn-outline-secondary"
                                                                            href="{{ route('kplh::download-file', ['maintank', $maintank_area_2_4_file]) }}"
                                                                            target="_blank"><i
                                                                                class="fa fa-file"></i>
                                                                            {{ Illuminate\Support\Str::limit($maintank_area_2_4_file, 30) }}</a>
                                                                    </div>
                                                                </div>
                                                            @else
                                                                <div class="col-md-12 mt-3">
                                                                    <x-kplh-file wire:model="maintank_area_2_4_file"
                                                                        id="maintank_area_2_4_file"
                                                                        placeholder="File"
                                                                        :error="'maintank_area_2_4_file'" />
                                                                </div>
                                                            @endif
                                                        </div>
                                                    </div>
                                                </div>
                                            </div><!-- /.form-group maintank_area_2_4 -->

                                            <div class="row form-group mb-4">
                                                <h4 class="col-lg-12 col-md-12 col-form-label">3. Pagar</h4>
                                            </div>

                                            <div class="row form-group mb-4">
                                                <label for="maintank_area_3_1_label"
                                                    class="col-lg-4 col-md-12 col-form-label">Pastikan pagar dalam
                                                    keadaan
                                                    bersih dan tidak rusak.
                                                </label>
                                                <div class="col-lg-8 col-md-12">
                                                    <div class="wrapper_maintank_area_3_1 d-flex flex-column gap-3"
                                                        x-data="{ maintank_area_3_1_value: @entangle('maintank_area_3_1_value') }">
                                                        <x-inputs.select2 wire:model="maintank_area_3_1_value"
                                                            id="maintank_area_3_1_value" class="form-select"
                                                            placeholder="Pemenuhan">
                                                            <option value="Ya">Ya</option>
                                                            <option value="Tidak">Tidak</option>
                                                            <option value="N/A">N/A</option>
                                                        </x-inputs.select2>

                                                        <div x-cloak
                                                            x-show="maintank_area_3_1_value === 'Tidak' || maintank_area_3_1_value === '5' ">
                                                            <div>
                                                                <x-kplh-texteditor wire:model="maintank_area_3_1_note"
                                                                    id="maintank_area_3_1_note"
                                                                    placeholder="Keterangan" :error="'maintank_area_3_1_note'" />
                                                            </div>
                                                            @if ($maintank_area_3_1_file && !Illuminate\Support\Str::contains($maintank_area_3_1_file, 'private/var/folders/'))
                                                                <div class="row mt-3">
                                                                    <div class="col-md-3"><button type="button"
                                                                            class="btn btn-outline-secondary"
                                                                            wire:click="setFileNull('maintank_area_3_1_file')"><i
                                                                                class="fa fa-edit"></i> Ubah
                                                                            File</button></div>
                                                                    <div class="col-md-9">
                                                                        <a class="btn btn-outline-secondary"
                                                                            href="{{ route('kplh::download-file', ['maintank', $maintank_area_3_1_file]) }}"
                                                                            target="_blank"><i
                                                                                class="fa fa-file"></i>
                                                                            {{ Illuminate\Support\Str::limit($maintank_area_3_1_file, 30) }}</a>
                                                                    </div>
                                                                </div>
                                                            @else
                                                                <div class="col-md-12 mt-3">
                                                                    <x-kplh-file wire:model="maintank_area_3_1_file"
                                                                        id="maintank_area_3_1_file"
                                                                        placeholder="File"
                                                                        :error="'maintank_area_3_1_file'" />
                                                                </div>
                                                            @endif
                                                        </div>

                                                    </div>
                                                </div>
                                            </div><!-- /.form-group maintank_area_3_1 -->

                                            <div class="row form-group mb-4">
                                                <label for="maintank_area_3_2_label"
                                                    class="col-lg-4 col-md-12 col-form-label">Pastikan pagar dalam
                                                    keadaan
                                                    bersih dan tidak rusak.
                                                </label>
                                                <div class="col-lg-8 col-md-12">
                                                    <div class="wrapper_maintank_area_3_2 d-flex flex-column gap-3"
                                                        x-data="{ maintank_area_3_2_value: @entangle('maintank_area_3_2_value') }">
                                                        <x-inputs.select2 wire:model="maintank_area_3_2_value"
                                                            id="maintank_area_3_2_value" class="form-select"
                                                            placeholder="Pemenuhan">
                                                            <option value="Ya">Ya</option>
                                                            <option value="Tidak">Tidak</option>
                                                            <option value="N/A">N/A</option>
                                                        </x-inputs.select2>

                                                        <div x-cloak
                                                            x-show="maintank_area_3_2_value === 'Tidak' || maintank_area_3_2_value === '5' ">
                                                            <div>
                                                                <x-kplh-texteditor wire:model="maintank_area_3_2_note"
                                                                    id="maintank_area_3_2_note"
                                                                    placeholder="Keterangan" :error="'maintank_area_3_2_note'" />
                                                            </div>
                                                            @if ($maintank_area_3_2_file && !Illuminate\Support\Str::contains($maintank_area_3_2_file, 'private/var/folders/'))
                                                                <div class="row mt-3">
                                                                    <div class="col-md-3"><button type="button"
                                                                            class="btn btn-outline-secondary"
                                                                            wire:click="setFileNull('maintank_area_3_2_file')"><i
                                                                                class="fa fa-edit"></i> Ubah
                                                                            File</button></div>
                                                                    <div class="col-md-9">
                                                                        <a class="btn btn-outline-secondary"
                                                                            href="{{ route('kplh::download-file', ['maintank', $maintank_area_3_2_file]) }}"
                                                                            target="_blank"><i
                                                                                class="fa fa-file"></i>
                                                                            {{ Illuminate\Support\Str::limit($maintank_area_3_2_file, 30) }}</a>
                                                                    </div>
                                                                </div>
                                                            @else
                                                                <div class="col-md-12 mt-3">
                                                                    <x-kplh-file wire:model="maintank_area_3_2_file"
                                                                        id="maintank_area_3_2_file"
                                                                        placeholder="File"
                                                                        :error="'maintank_area_3_2_file'" />
                                                                </div>
                                                            @endif
                                                        </div>

                                                    </div>
                                                </div>
                                            </div><!-- /.form-group maintank_area_3_2 -->

                                            <div class="row form-group mb-4">
                                                <label for="maintank_area_3_3_label"
                                                    class="col-lg-4 col-md-12 col-form-label">Pastikan pagar tidak
                                                    dapat
                                                    diakses.
                                                </label>
                                                <div class="col-lg-8 col-md-12">
                                                    <div class="wrapper_maintank_area_3_3 d-flex flex-column gap-3"
                                                        x-data="{ maintank_area_3_3_value: @entangle('maintank_area_3_3_value') }">
                                                        <x-inputs.select2 wire:model="maintank_area_3_3_value"
                                                            id="maintank_area_3_3_value" class="form-select"
                                                            placeholder="Pemenuhan">
                                                            <option value="Ya">Ya</option>
                                                            <option value="Tidak">Tidak</option>
                                                            <option value="N/A">N/A</option>
                                                        </x-inputs.select2>

                                                        <div x-cloak
                                                            x-show="maintank_area_3_3_value === 'Tidak' || maintank_area_3_3_value === '5' ">
                                                            <div>
                                                                <x-kplh-texteditor wire:model="maintank_area_3_3_note"
                                                                    id="maintank_area_3_3_note"
                                                                    placeholder="Keterangan" :error="'maintank_area_3_3_note'" />
                                                            </div>
                                                            @if ($maintank_area_3_3_file && !Illuminate\Support\Str::contains($maintank_area_3_3_file, 'private/var/folders/'))
                                                                <div class="row mt-3">
                                                                    <div class="col-md-3"><button type="button"
                                                                            class="btn btn-outline-secondary"
                                                                            wire:click="setFileNull('maintank_area_3_3_file')"><i
                                                                                class="fa fa-edit"></i> Ubah
                                                                            File</button></div>
                                                                    <div class="col-md-9">
                                                                        <a class="btn btn-outline-secondary"
                                                                            href="{{ route('kplh::download-file', ['maintank', $maintank_area_3_3_file]) }}"
                                                                            target="_blank"><i
                                                                                class="fa fa-file"></i>
                                                                            {{ Illuminate\Support\Str::limit($maintank_area_3_3_file, 30) }}</a>
                                                                    </div>
                                                                </div>
                                                            @else
                                                                <div class="col-md-12 mt-3">
                                                                    <x-kplh-file wire:model="maintank_area_3_3_file"
                                                                        id="maintank_area_3_3_file"
                                                                        placeholder="File"
                                                                        :error="'maintank_area_3_3_file'" />
                                                                </div>
                                                            @endif
                                                        </div>

                                                    </div>
                                                </div>
                                            </div><!-- /.form-group maintank_area_3_3 -->

                                            <div class="row form-group mb-4">
                                                <h4 class="col-lg-12 col-md-12 col-form-label">4. Kebersihan</h4>
                                            </div>

                                            <div class="row form-group mb-4">
                                                <label for="maintank_area_4_1_label"
                                                    class="col-lg-4 col-md-12 col-form-label">Pastikan tidak ada
                                                    sampah di
                                                    area maintank.
                                                </label>
                                                <div class="col-lg-8 col-md-12">
                                                    <div class="wrapper_maintank_area_4_1 d-flex flex-column gap-3"
                                                        x-data="{ maintank_area_4_1_value: @entangle('maintank_area_4_1_value') }">
                                                        <x-inputs.select2 wire:model="maintank_area_4_1_value"
                                                            id="maintank_area_4_1_value" class="form-select"
                                                            placeholder="Pemenuhan">
                                                            <option value="Ya">Ya</option>
                                                            <option value="Tidak">Tidak</option>
                                                            <option value="N/A">N/A</option>
                                                        </x-inputs.select2>

                                                        <div x-cloak
                                                            x-show="maintank_area_4_1_value === 'Tidak' || maintank_area_4_1_value === '5' ">
                                                            <div>
                                                                <x-kplh-texteditor wire:model="maintank_area_4_1_note"
                                                                    id="maintank_area_4_1_note"
                                                                    placeholder="Keterangan" :error="'maintank_area_4_1_note'" />
                                                            </div>
                                                            @if ($maintank_area_4_1_file && !Illuminate\Support\Str::contains($maintank_area_4_1_file, 'private/var/folders/'))
                                                                <div class="row mt-3">
                                                                    <div class="col-md-3"><button type="button"
                                                                            class="btn btn-outline-secondary"
                                                                            wire:click="setFileNull('maintank_area_4_1_file')"><i
                                                                                class="fa fa-edit"></i> Ubah
                                                                            File</button></div>
                                                                    <div class="col-md-9">
                                                                        <a class="btn btn-outline-secondary"
                                                                            href="{{ route('kplh::download-file', ['maintank', $maintank_area_4_1_file]) }}"
                                                                            target="_blank"><i
                                                                                class="fa fa-file"></i>
                                                                            {{ Illuminate\Support\Str::limit($maintank_area_4_1_file, 30) }}</a>
                                                                    </div>
                                                                </div>
                                                            @else
                                                                <div class="col-md-12 mt-3">
                                                                    <x-kplh-file wire:model="maintank_area_4_1_file"
                                                                        id="maintank_area_4_1_file"
                                                                        placeholder="File"
                                                                        :error="'maintank_area_4_1_file'" />
                                                                </div>
                                                            @endif
                                                        </div>

                                                    </div>
                                                </div>
                                            </div><!-- /.form-group maintank_area_4_1 -->

                                            <div class="row form-group mb-4">
                                                <h4 class="col-lg-12 col-md-12 col-form-label">5. Tempat Sampah</h4>
                                            </div>

                                            <div class="row form-group mb-4">
                                                <label for="maintank_area_5_1_label"
                                                    class="col-lg-4 col-md-12 col-form-label">Ada dan tidak bocor.
                                                </label>
                                                <div class="col-lg-8 col-md-12">
                                                    <div class="wrapper_maintank_area_5_1 d-flex flex-column gap-3"
                                                        x-data="{ maintank_area_5_1_value: @entangle('maintank_area_5_1_value') }">
                                                        <x-inputs.select2 wire:model="maintank_area_5_1_value"
                                                            id="maintank_area_5_1_value" class="form-select"
                                                            placeholder="Pemenuhan">
                                                            <option value="Ya">Ya</option>
                                                            <option value="Tidak">Tidak</option>
                                                            <option value="N/A">N/A</option>
                                                        </x-inputs.select2>

                                                        <div x-cloak
                                                            x-show="maintank_area_5_1_value === 'Tidak' || maintank_area_5_1_value === '5' ">
                                                            <div>
                                                                <x-kplh-texteditor wire:model="maintank_area_5_1_note"
                                                                    id="maintank_area_5_1_note"
                                                                    placeholder="Keterangan" :error="'maintank_area_5_1_note'" />
                                                            </div>
                                                            @if ($maintank_area_5_1_file && !Illuminate\Support\Str::contains($maintank_area_5_1_file, 'private/var/folders/'))
                                                                <div class="row mt-3">
                                                                    <div class="col-md-3"><button type="button"
                                                                            class="btn btn-outline-secondary"
                                                                            wire:click="setFileNull('maintank_area_5_1_file')"><i
                                                                                class="fa fa-edit"></i> Ubah
                                                                            File</button></div>
                                                                    <div class="col-md-9">
                                                                        <a class="btn btn-outline-secondary"
                                                                            href="{{ route('kplh::download-file', ['maintank', $maintank_area_5_1_file]) }}"
                                                                            target="_blank"><i
                                                                                class="fa fa-file"></i>
                                                                            {{ Illuminate\Support\Str::limit($maintank_area_5_1_file, 30) }}</a>
                                                                    </div>
                                                                </div>
                                                            @else
                                                                <div class="col-md-12 mt-3">
                                                                    <x-kplh-file wire:model="maintank_area_5_1_file"
                                                                        id="maintank_area_5_1_file"
                                                                        placeholder="File"
                                                                        :error="'maintank_area_5_1_file'" />
                                                                </div>
                                                            @endif
                                                        </div>

                                                    </div>
                                                </div>
                                            </div><!-- /.form-group maintank_area_5_1 -->

                                            <div class="row form-group mb-4">
                                                <h4 class="col-lg-12 col-md-12 col-form-label">6. Rambu-rambu</h4>
                                            </div>

                                            <div class="row form-group mb-4">
                                                <label for="maintank_area_6_1_label"
                                                    class="col-lg-4 col-md-12 col-form-label">Pastikan Rambu-rambu
                                                    tidak rusak
                                                    dan dapat terbaca.
                                                </label>
                                                <div class="col-lg-8 col-md-12">
                                                    <div class="wrapper_maintank_area_6_1 d-flex flex-column gap-3"
                                                        x-data="{ maintank_area_6_1_value: @entangle('maintank_area_6_1_value') }">
                                                        <x-inputs.select2 wire:model="maintank_area_6_1_value"
                                                            id="maintank_area_6_1_value" class="form-select"
                                                            placeholder="Pemenuhan">
                                                            <option value="Ya">Ya</option>
                                                            <option value="Tidak">Tidak</option>
                                                            <option value="N/A">N/A</option>
                                                        </x-inputs.select2>

                                                        <div x-cloak
                                                            x-show="maintank_area_6_1_value === 'Tidak' || maintank_area_6_1_value === '5' ">
                                                            <div>
                                                                <x-kplh-texteditor wire:model="maintank_area_6_1_note"
                                                                    id="maintank_area_6_1_note"
                                                                    placeholder="Keterangan" :error="'maintank_area_6_1_note'" />
                                                            </div>
                                                            @if ($maintank_area_6_1_file && !Illuminate\Support\Str::contains($maintank_area_6_1_file, 'private/var/folders/'))
                                                                <div class="row mt-3">
                                                                    <div class="col-md-3"><button type="button"
                                                                            class="btn btn-outline-secondary"
                                                                            wire:click="setFileNull('maintank_area_6_1_file')"><i
                                                                                class="fa fa-edit"></i> Ubah
                                                                            File</button></div>
                                                                    <div class="col-md-9">
                                                                        <a class="btn btn-outline-secondary"
                                                                            href="{{ route('kplh::download-file', ['maintank', $maintank_area_6_1_file]) }}"
                                                                            target="_blank"><i
                                                                                class="fa fa-file"></i>
                                                                            {{ Illuminate\Support\Str::limit($maintank_area_6_1_file, 30) }}</a>
                                                                    </div>
                                                                </div>
                                                            @else
                                                                <div class="col-md-12 mt-3">
                                                                    <x-kplh-file wire:model="maintank_area_6_1_file"
                                                                        id="maintank_area_6_1_file"
                                                                        placeholder="File"
                                                                        :error="'maintank_area_6_1_file'" />
                                                                </div>
                                                            @endif
                                                        </div>

                                                    </div>
                                                </div>
                                            </div><!-- /.form-group maintank_area_6_1 -->

                                            <div class="row form-group mb-4">
                                                <h4 class="col-lg-12 col-md-12 col-form-label">7. Pintu/gerbang</h4>
                                            </div>

                                            <div class="row form-group mb-4">
                                                <label for="maintank_area_7_1_label"
                                                    class="col-lg-4 col-md-12 col-form-label">Dapat ditutup dengan
                                                    rapat dan
                                                    terkunci.
                                                </label>
                                                <div class="col-lg-8 col-md-12">
                                                    <div class="wrapper_maintank_area_7_1 d-flex flex-column gap-3"
                                                        x-data="{ maintank_area_7_1_value: @entangle('maintank_area_7_1_value') }">
                                                        <x-inputs.select2 wire:model="maintank_area_7_1_value"
                                                            id="maintank_area_7_1_value" class="form-select"
                                                            placeholder="Pemenuhan">
                                                            <option value="Ya">Ya</option>
                                                            <option value="Tidak">Tidak</option>
                                                            <option value="N/A">N/A</option>
                                                        </x-inputs.select2>

                                                        <div x-cloak
                                                            x-show="maintank_area_7_1_value === 'Tidak' || maintank_area_7_1_value === '5' ">
                                                            <div>
                                                                <x-kplh-texteditor wire:model="maintank_area_7_1_note"
                                                                    id="maintank_area_7_1_note"
                                                                    placeholder="Keterangan" :error="'maintank_area_7_1_note'" />
                                                            </div>
                                                            @if ($maintank_area_7_1_file && !Illuminate\Support\Str::contains($maintank_area_7_1_file, 'private/var/folders/'))
                                                                <div class="row mt-3">
                                                                    <div class="col-md-3"><button type="button"
                                                                            class="btn btn-outline-secondary"
                                                                            wire:click="setFileNull('maintank_area_7_1_file')"><i
                                                                                class="fa fa-edit"></i> Ubah
                                                                            File</button></div>
                                                                    <div class="col-md-9">
                                                                        <a class="btn btn-outline-secondary"
                                                                            href="{{ route('kplh::download-file', ['maintank', $maintank_area_7_1_file]) }}"
                                                                            target="_blank"><i
                                                                                class="fa fa-file"></i>
                                                                            {{ Illuminate\Support\Str::limit($maintank_area_7_1_file, 30) }}</a>
                                                                    </div>
                                                                </div>
                                                            @else
                                                                <div class="col-md-12 mt-3">
                                                                    <x-kplh-file wire:model="maintank_area_7_1_file"
                                                                        id="maintank_area_7_1_file"
                                                                        placeholder="File"
                                                                        :error="'maintank_area_7_1_file'" />
                                                                </div>
                                                            @endif
                                                        </div>

                                                    </div>
                                                </div>
                                            </div><!-- /.form-group maintank_area_7_1 -->

                                        </div><!-- ./content-maintank_area -->
                                    </div>
                                </div><!-- /.maintank_area -->

                                <div id="maintank_maintenance" class="section-maintank_maintenance"
                                    x-data="{ accordionOpen: false }">
                                    <button
                                        class="header-accordion d-flex justify-content-between w-100 border-0 bg-white py-3 px-0"
                                        @click.prevent="accordionOpen = ! accordionOpen">
                                        <h6 class="mb-0 fw-normal title-accordion">E. Perawatan dan Perbaikan</h6>
                                        <span x-bind:class="accordionOpen ? 'open' : ''"><img
                                                src="{{ asset('/images/icons/angle-down.png') }}"
                                                alt="" /></span>
                                    </button>
                                    <div class="wrapper-content-accordion max-h-0 overflow-hidden position-relative transition-all duration-700"
                                        x-ref="maintank_maintenance"
                                        x-bind:style="accordionOpen ? 'max-height: ' + 20000 + 'px' : ''"
                                        x-transition.delay.5000ms>

                                        <div class="content-section p-4" wire:ignore.self>

                                            <div class="row form-group mb-4">
                                                <h4 class="col-lg-12 col-md-12 col-form-label">1. Perawatan dan
                                                    Perbaikan
                                                </h4>
                                            </div>

                                            <div class="row form-group mb-4">
                                                <label for="maintank_maintenance_1_1_label"
                                                    class="col-lg-4 col-md-12 col-form-label">P2H Peralatan
                                                </label>
                                                <div class="col-lg-8 col-md-12">
                                                    <div class="wrapper_maintank_maintenance_1_1 d-flex flex-column gap-3"
                                                        x-data="{ maintank_maintenance_1_1_value: @entangle('maintank_maintenance_1_1_value') }">
                                                        <x-inputs.select2 wire:model="maintank_maintenance_1_1_value"
                                                            id="maintank_maintenance_1_1_value" class="form-select"
                                                            placeholder="Pemenuhan">
                                                            <option value="Ya">Ya</option>
                                                            <option value="Tidak">Tidak</option>
                                                            <option value="N/A">N/A</option>
                                                        </x-inputs.select2>

                                                        <div x-cloak
                                                            x-show="maintank_maintenance_1_1_value === 'Tidak' || maintank_maintenance_1_1_value === '5' ">
                                                            <div>
                                                                <x-kplh-texteditor
                                                                    wire:model="maintank_maintenance_1_1_note"
                                                                    id="maintank_maintenance_1_1_note"
                                                                    placeholder="Keterangan" :error="'maintank_maintenance_1_1_note'" />
                                                            </div>
                                                            @if (
                                                                $maintank_maintenance_1_1_file &&
                                                                    !Illuminate\Support\Str::contains($maintank_maintenance_1_1_file, 'private/var/folders/'))
                                                                <div class="row mt-3">
                                                                    <div class="col-md-3"><button type="button"
                                                                            class="btn btn-outline-secondary"
                                                                            wire:click="setFileNull('maintank_maintenance_1_1_file')"><i
                                                                                class="fa fa-edit"></i> Ubah
                                                                            File</button></div>
                                                                    <div class="col-md-9">
                                                                        <a class="btn btn-outline-secondary"
                                                                            href="{{ route('kplh::download-file', ['maintank', $maintank_maintenance_1_1_file]) }}"
                                                                            target="_blank"><i
                                                                                class="fa fa-file"></i>
                                                                            {{ Illuminate\Support\Str::limit($maintank_maintenance_1_1_file, 30) }}</a>
                                                                    </div>
                                                                </div>
                                                            @else
                                                                <div class="col-md-12 mt-3">
                                                                    <x-kplh-file
                                                                        wire:model="maintank_maintenance_1_1_file"
                                                                        id="maintank_maintenance_1_1_file"
                                                                        placeholder="File"
                                                                        :error="'maintank_maintenance_1_1_file'" />
                                                                </div>
                                                            @endif
                                                        </div>

                                                    </div>
                                                </div>
                                            </div><!-- /.form-group maintank_maintenance_1_1 -->

                                            <div class="row form-group mb-4">
                                                <label for="maintank_maintenance_1_2_label"
                                                    class="col-lg-4 col-md-12 col-form-label">Perawatan drainase dan
                                                    oil trap
                                                    sesuai jadwal
                                                </label>
                                                <div class="col-lg-8 col-md-12">
                                                    <div class="wrapper_maintank_maintenance_1_2 d-flex flex-column gap-3"
                                                        x-data="{ maintank_maintenance_1_2_value: @entangle('maintank_maintenance_1_2_value') }">
                                                        <x-inputs.select2 wire:model="maintank_maintenance_1_2_value"
                                                            id="maintank_maintenance_1_2_value" class="form-select"
                                                            placeholder="Pemenuhan">
                                                            <option value="Ya">Ya</option>
                                                            <option value="Tidak">Tidak</option>
                                                            <option value="N/A">N/A</option>
                                                        </x-inputs.select2>
                                                        <div x-cloak
                                                            x-show="maintank_maintenance_1_2_value === 'Tidak' || maintank_maintenance_1_2_value === '5' ">
                                                            <div>
                                                                <x-kplh-texteditor
                                                                    wire:model="maintank_maintenance_1_2_note"
                                                                    id="maintank_maintenance_1_2_note"
                                                                    placeholder="Keterangan" :error="'maintank_maintenance_1_2_note'" />
                                                            </div>
                                                            @if (
                                                                $maintank_maintenance_1_2_file &&
                                                                    !Illuminate\Support\Str::contains($maintank_maintenance_1_2_file, 'private/var/folders/'))
                                                                <div class="row mt-3">
                                                                    <div class="col-md-3"><button type="button"
                                                                            class="btn btn-outline-secondary"
                                                                            wire:click="setFileNull('maintank_maintenance_1_2_file')"><i
                                                                                class="fa fa-edit"></i> Ubah
                                                                            File</button></div>
                                                                    <div class="col-md-9">
                                                                        <a class="btn btn-outline-secondary"
                                                                            href="{{ route('kplh::download-file', ['maintank', $maintank_maintenance_1_2_file]) }}"
                                                                            target="_blank"><i
                                                                                class="fa fa-file"></i>
                                                                            {{ Illuminate\Support\Str::limit($maintank_maintenance_1_2_file, 30) }}</a>
                                                                    </div>
                                                                </div>
                                                            @else
                                                                <div class="col-md-12 mt-3">
                                                                    <x-kplh-file
                                                                        wire:model="maintank_maintenance_1_2_file"
                                                                        id="maintank_maintenance_1_2_file"
                                                                        placeholder="File"
                                                                        :error="'maintank_maintenance_1_2_file'" />
                                                                </div>
                                                            @endif
                                                        </div>
                                                    </div>
                                                </div>
                                            </div><!-- /.form-group maintank_maintenance_1_2 -->

                                        </div><!-- ./content-maintank_maintenance -->
                                    </div>
                                </div><!-- /.maintank_maintenance -->

                                <hr>
                                <div class="row form-group">
                                    <label for="tanggal_service" class="col col-form-label">Ringkasan Hasil
                                        Inspeksi</label>
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

                                        <a href="javascript:history.go(-1)"
                                            class="btn btn-outline-secondary">Cancel</a>
                                        <button type="submit" wire:click="$set('mode','draft')"
                                            class="btn btn-outline-warning d-flex justify-content-center align-item-center position-relative px-4">Save
                                            Draft</button>
                                        <button type="submit" {{-- @if (is_null($ok)) disabled
                                    @else --}}
                                            wire:click="$set('mode','save')" {{-- @endif --}}
                                            class="btn btn-outline-default bg-green d-flex justify-content-center align-item-center text-white position-relative px-4">Save</button>

                                    </div>
                                </div>

                    </form>

                </div>
            </div>
        </div>
    </div><!-- /.content-inspeksi-area-maintank -->

</div><!-- /.inner-content -->
