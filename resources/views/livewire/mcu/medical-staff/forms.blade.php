<div class="inner-content">

    <div class="header-content-csms-add-new-bidding h-60px bg-white shadow-sm d-flex gap-2 align-items-center justify-content-between px-3">
        <div class="left-header">
            <a href="{{ route('mcu::medical-staff-list') }}" class="d-flex align-items-center gap-3 text-white">
                <span><i class="fa-solid fa-arrow-left"></i></span>
                <span>New Annual MCU</span>
            </a>
        </div><!-- /.left-header -->
        <div class="right-header">
        </div><!-- /.right-header -->
    </div><!-- /.header-edit-event -->

    <div class="mcu-form-content d-flex">
        <div class="col-3">
            <div class="section-sidebar-nav position-sticky top-0 py-4">

                <div class="info bg-white">

                    <div class="info-item p-3 border-bottom border-1">

                        <div class="author d-flex flex-column gap-2">
                            <h6 class="fw-normal">Penanggung Jawab</h6>
                            <div class="item-content d-flex gap-2 align-items-center">
                                <div class="thumb">
                                    <img src="{{ asset('./images/author.png') }}" alt="Author">
                                </div>
                                <div class="author-name">{{ $staff->name }}</div>
                            </div>
                        </div><!-- /.author -->

                    </div><!-- /.info-items -->

                    <div class="info-item p-3 border-bottom border-1">

                        <div class="pt d-flex flex-column gap-2">
                            <h6 class="fw-normal">{{ $staff->company }}</h6>
                            <div class="item-content d-flex gap-2 align-items-start">
                                <div class="thumb">
                                    <img src="{{ asset('./images/icons/position.png') }}" alt="Position">
                                </div>
                                <div class="position-name d-flex flex-column">
                                    <span class="opacity-50">Position</span>
                                    <span>{{ $staff->position }}</span>
                                </div>
                            </div>
                            <div class="item-content d-flex gap-2 align-items-start">
                                <div class="thumb">
                                    <img src="{{ asset('./images/icons/map.png') }}" alt="Location">
                                </div>
                                <div class="location-name d-flex flex-column">
                                    <span class="opacity-50">Location Detail</span>
                                    <span>{{ $staff->location }}</span>
                                </div>
                            </div>
                            <div class="item-content d-flex gap-2 align-items-start">
                                <div class="thumb">
                                    <img class="w-18px" src="{{ asset('./images/icons/blank.png') }}" alt="Blank">
                                </div>
                                <div class="department-name d-flex flex-column">
                                    <span class="opacity-50">Department</span>
                                    <span>{{ $staff->department }}</span>
                                </div>
                            </div>
                        </div><!-- /.author -->

                    </div><!-- /.info-items -->

                    <div class="info-item p-3 border-bottom border-1">

                        <div class="created d-flex flex-column gap-2">

                            <h6 class="fw-normal">Created</h6>

                            <div class="item-content d-flex gap-1 align-items-center">
                                <span class="opacity-50">by</span>
                                <span>{{ $staff->company }}</span>
                                <span class="opacity-50">on</span>
                                <span>{{ $staff->created_at }}</span>
                            </div>

                        </div><!-- /.author -->

                    </div><!-- /.info-items -->

                    <div class="info-item p-3 border-bottom border-1">

                        <div class="expired d-flex flex-column gap-2">

                            <h6 class="fw-normal">Expired</h6>

                            <div class="item-content d-flex gap-1 align-items-center">
                                <span class="opacity-50">by</span>
                                <span>System</span>
                                <span class="opacity-50">on</span>
                                <span>{{ $staff->created_at }}</span>
                            </div>

                        </div><!-- /.author -->

                    </div><!-- /.info-items -->

                    <div class="info-item p-3 border-bottom border-1">

                        <div class="author d-flex flex-column gap-2">
                            <h6 class="fw-normal">Maker</h6>
                            <div class="item-content d-flex gap-2 align-items-center">
                                <div class="thumb">
                                    <img src="{{ asset('./images/author.png') }}" alt="Author">
                                </div>
                                <div class="author-name">Arli Rahman</div>
                            </div>
                        </div><!-- /.author -->

                    </div><!-- /.info-items -->

                </div><!-- /.info -->

            </div><!-- /.sidebar-left -->
        </div>

        <div class="col p-4">
            <form wire:submit.prevent="save">

                <div class="alert @if (!empty(session('alert'))) alert-{{ session('alert') }} @else d-none @endif">
                    @if (!empty(session('msg')))
                        {{ session('msg') }}
                    @endif
                </div>

                <div id="karyawan" class="section-karyawan" x-data="{ accordionOpen: true }">

                    <button class="header-accordion d-flex justify-content-between w-100 border-0 bg-white py-3 px-0"
                        @click.prevent="accordionOpen = ! accordionOpen">
                        <h6 class="mb-0 fw-normal title-accordion">Karyawan</h6>
                        <span x-bind:class="accordionOpen ? 'open' : ''"><img
                                src="{{ asset('/images/icons/angle-down.png') }}" alt="" /></span>
                    </button>
                    <div class="wrapper-content-accordion max-h-0 overflow-hidden position-relative transition-all duration-700"
                        x-ref="karyawan"
                        x-bind:style="accordionOpen ? 'max-height: ' + $refs.karyawan.scrollHeight + 'px' : ''"
                        x-transition.delay.5000ms>

                        <div class="content-section p-4">

                            <div class="mb-3 row form-group required">
                                <label for="employee_id" class="col col-form-label">NIK & Nama Karyawan</label>
                                <div class="col-8">
                                    @if ((strlen($type)) > 15)
                                        <select wire:model="employee_id" id="employee_id" class="form-select"
                                            placeholder="Pilih Karyawan" disabled>
                                            @foreach ($employee as $e)
                                                <option value="{{ $e->id }}">{{ $e->name }} -
                                                    {{ $e->id_number }}</option>
                                            @endforeach
                                        </select>
                                    @else
                                        <x-inputs.select2 wire:model="employee_id" id="employee_id" class="form-select"
                                            placeholder="Pilih Karyawan">
                                            @foreach ($employee as $e)
                                                <option value="{{ $e->id }}">{{ $e->name }} -
                                                    {{ $e->id_number }}</option>
                                            @endforeach
                                        </x-inputs.select2>
                                    @endif
                                    {{-- <x-inputs.select2 wire:model="employee_id" id="employee_id" class="form-select"
                                        placeholder="Pilih Karyawan" {{ $type }}>
                                        @foreach ($employee as $e)
                                            <option value="{{ $e->id }}">{{ $e->name }} -
                                                {{ $e->id_number }}</option>
                                        @endforeach
                                    </x-inputs.select2> --}}
                                    {{-- <button class="btn btn-primary"
                                        wire:click="ShowEmployee({{ $employee_id }})">Karyawan</button>
                                    <div>{{ $employee_view }}</div> --}}
                                </div>
                            </div><!-- /.form-group employee -->

                            <div class="mb-3 row form-group required">
                                <label for="department" class="col col-form-label">Department</label>
                                <div class="col-8">
                                    <input type="text" class="form-control" value="{{ $employee_department }}"
                                        disabled />
                                </div>
                            </div><!-- /.form-group department -->

                            <div class="mb-5 row form-group required">
                                <label for="position" class="col-sm-4 col-form-label">Posisi</label>
                                <div class="col-sm-8">
                                    <input type="text" class="form-control" value="{{ $employee_position }}"
                                        disabled />
                                </div>
                            </div><!-- /.form-group position -->

                            <div class="mb-3 row form-group required">
                                <label for="nip" class="col col-form-label">NIP</label>
                                <div class="col-8">
                                    <input type="text" class="form-control" value="{{ $employee_nip }}"
                                        disabled />
                                </div>
                            </div><!-- /.form-group nip -->

                            <div class="mb-3 row form-group required">
                                <label for="no_ktp" class="col col-form-label">No KTP</label>
                                <div class="col-8">
                                    <input type="text" class="form-control" value="{{ $employee_id_number }}"
                                        disabled />
                                </div>
                            </div><!-- /.form-group no_ktp -->

                            <div class="mb-3 row form-group required">
                                <label for="name" class="col col-form-label">Nama</label>
                                <div class="col-8">
                                    <input type="text" class="form-control" value="{{ $employee_name }}"
                                        disabled />
                                </div>
                            </div><!-- /.form-group name -->

                            <div class="mb-3 row form-group required">
                                <label for="tgl_lahir" class="col col-form-label">Tangal Lahir</label>
                                <div class="col-4">
                                    <input type="text" class="form-control"
                                        value="{{ \Carbon\Carbon::parse($employee_birthdate)->format('d M Y') }}"
                                        disabled />
                                </div>
                                <div class="col-4 input-group w-33">
                                    <input type="text" class="form-control" value="{{ $employee_age }}"
                                        disabled />
                                    <span class="input-group-text" id="addons-umur">Tahun</span>
                                </div>
                            </div><!-- /.form-group tanggal lahir -->

                            <div class="mb-5 row form-group required">
                                <label for="jk" class="col col-form-label">Jenis Kelamin</label>
                                <div class="col-8">
                                    <input type="text" class="form-control"
                                        value="@if ($employee_gender == 'male') Laki-laki @elseif($employee_gender == 'female') Perempuan @else @endif"
                                        disabled />
                                </div>
                            </div><!-- /.form-group jk -->

                            {{-- <div class="mb-3 row form-group">
                                <label for="medical_type" class="col col-form-label">Type of medical
                                    examination {{ $type }}</label>
                                <div class="col-8">
                                    <select wire:model="medical_type" id="medical_type" class="form-select"
                                        placeholder="Select of medical type" disabled>
                                        @if ($type == 'annual')
                                            <option value="annual" selected>Annual</option>
                                        @elseif ($type == 'pre-employment')
                                            <option value="pre-employment" selected>Pre Employment</option>
                                        @else
                                        @endif
                                    </select>
                                </div>
                            </div> --}}

                            <div class="mb-3 row form-group required">
                                <label for="medical_ex_type" class="col col-form-label">Item Pemeriksaan
                                    Kesehatan</label>
                                <div class="col-8">
                                    <select wire:model="medical_ex_type" id="medical_ex_type" class="form-select"
                                        placeholder="Select Item" value='{{ $medical_ex_type }}'>
                                        <option value="office-group" selected>Office Group</option>
                                        <option value="field-officer">Field Officer</option>
                                        <option value="general-housekeeping">General Houskeeping</option>
                                        <option value="food-handler">Food Handler</option>
                                    </select>
                                </div>
                            </div><!-- /.form-group Item Pemeriksaan -->

                            @if ($medical_ex_type)
                                <div class="mb-3 row form-group required">
                                    <label for="medical_type" class="col col-form-label">Medical Type</label>
                                    <div class="col-8">
                                        <select wire:model="medical_type" id="medical_type" class="form-select"
                                            placeholder="Select Type" value='{{ $medical_type }}'>
                                            <option value="pre-employment">Pre Employment</option>
                                            <option value="periodic">Periodik</option>
                                            <option value="pre-retirement">Pre Retirement</option>
                                        </select>
                                    </div>
                                </div><!-- /.form-group Medical Type -->
                            @endif

                            <div class="mb-3 row form-group required">
                                <label for="provider_id" class="col col-form-label">Provider</label>
                                <div class="col-8">
                                    <x-inputs.select2 wire:model="provider_id" id="provider_id" class="form-select"
                                        placeholder="Select Provider">
                                        @foreach ($provider as $p)
                                            <option value="{{ $p->id }}">
                                                {{ $p->name }}
                                            </option>
                                        @endforeach
                                        {{-- <option value="{{ App\Enums\MCU\MedicalExamProvider::Framingham()->value }}">
                                            {{ App\Enums\MCU\MedicalExamProvider::Framingham()->description }}
                                        </option>
                                        <option
                                            value="{{ App\Enums\MCU\MedicalExamProvider::JakartaCardioVascular()->value }}">
                                            {{ App\Enums\MCU\MedicalExamProvider::JakartaCardioVascular()->description }}
                                        </option> --}}
                                    </x-inputs.select2>
                                    {{-- <div class="invalid-feedback">
                                        @error('provider')
                                            {{ $message }}
                                        @enderror
                                    </div> --}}
                                </div>
                            </div><!-- /.form-group provider -->

                            <div class="mb-5 row form-group required">
                                <label for="mcu_date" class="col-sm-4 col-form-label">MCU's Date</label>
                                <div class="col-sm-8">
                                    <x-inputs.datepicker wire:model="mcu_date" id="mcu_date"
                                        placeholder="Pilih Tanggal" :error="'mcu_date'" />
                                </div>
                            </div><!-- /.form-group mcu_date -->

                            {{-- <div class="mb-3 row form-group required">
                                <label for="mcu_exp_date" class="col col-form-label">MCU's Expiration Date</label>
                                <div class="col-8">
                                    <x-inputs.datepicker wire:model="mcu_exp_date" id="mcu_exp_date"
                                        placeholder="Pilih Tanggal" :error="'mcu_exp_date'" />
                                </div>
                            </div><!-- /.form-group mcu_exp_date -->

                            <div class="mb-3 row form-group required">
                                <label for="mcu_review_date" class="col col-form-label">Reviewing date</label>
                                <div class="col-8">
                                    <x-inputs.datepicker wire:model="mcu_review_date" id="mcu_review_date"
                                        placeholder="Pilih Tanggal" :error="'mcu_review_date'" />
                                </div>
                            </div><!-- /.form-group mcu_review_date --> --}}

                        </div><!-- ./content-karyawan -->
                    </div>
                </div><!-- /.karyawan -->

                <!-- Anamnesis dan Riwayat Kesehatan -->
                <div id="anamnesis" class="section-anamnesis" x-data="{ accordionOpen: true }">

                    <button class="header-accordion d-flex justify-content-between w-100 border-0 bg-white py-3 px-0"
                        @click.prevent="accordionOpen = ! accordionOpen">
                        <h6 class="mb-0 fw-normal title-accordion">Anamnesis dan Riwayat Kesehatan</h6>
                        <span x-bind:class="accordionOpen ? 'open' : ''"><img
                                src="{{ asset('/images/icons/angle-down.png') }}" alt="" /></span>
                    </button>
                    <div class="wrapper-content-accordion max-h-0 overflow-hidden position-relative transition-all duration-700"
                        x-ref="karyawan"
                        x-bind:style="accordionOpen ? 'max-height: ' + $refs.karyawan.scrollHeight + 'px' : ''">

                        <div class="content-section p-4">

                            <h6 class="fw-normal mb-5">Penyakit</h6>

                            <div class="mb-3 row form-group required">
                                <label for="complaint" class="col col-form-label">Keluhan</label>
                                <div class="col-8">
                                    <x-inputs.textarea wire:model="complaint" id="complaint" rows="7"
                                        placeholder="Keluhan" :error="'complaint'" />
                                    {{-- <text class="form-control mt-2 @error('complaint') is-invalid @enderror" id="complaint" rows="5"
                                        wire:model="complaint"></text> --}}
                                    {{-- <div class="invalid-feedback">
                                        @error('complaint')
                                            {{ $message }}
                                        @enderror
                                    </div> --}}
                                </div>

                            </div><!-- /.form-group keluhan -->

                            <div class="mb-3 row form-group required">
                                <label for="previous_disease_history" class="col-sm-4 col-form-label">Riwayat Penyakit
                                    Dahulu</label>
                                <div class="col-sm-8">
                                    <x-inputs.text wire:model="previous_disease_history" id="previous_disease_history"
                                        rows="7" placeholder="Riwayat Penyakit Terdahulu" :error="'previous_disease_history'" />
                                    {{-- <text class="form-control mb-5 @error('previous_disease_history') is-invalid @enderror"
                                        id="previous_disease_history" rows="5" wire:model='previous_disease_history'></text>
                                    <div class="invalid-feedback">
                                        @error('previous_disease_history')
                                            {{ $message }}
                                        @enderror
                                    </div> --}}
                                </div>
                            </div><!-- /.form-group previous_disease_history -->

                            <div class="mb-3 row form-group required">
                                <label for="family_disease_history" class="col-sm-4 col-form-label">Riwayat
                                    Penyakit
                                    Keluarga </label>
                                <div class="col-sm-8 @error('family_disease_history') is-invalid @enderror">
                                    <x-inputs.select2_multiple wire:model="family_disease_history"
                                        id="family_disease_history" class="form-select"
                                        placeholder="Pilih beberapa penyakit">
                                        <option value="{{ App\Enums\MCU\FamilyDiseaseHistory::Jantung()->value }}"
                                            selected>
                                            {{ App\Enums\MCU\FamilyDiseaseHistory::Jantung()->description }}
                                        </option>
                                        <option value="{{ App\Enums\MCU\FamilyDiseaseHistory::Diabetes()->value }}">
                                            {{ App\Enums\MCU\FamilyDiseaseHistory::Diabetes()->description }}
                                        </option>
                                        <option value="{{ App\Enums\MCU\FamilyDiseaseHistory::Kanker()->value }}">
                                            {{ App\Enums\MCU\FamilyDiseaseHistory::Kanker()->description }}
                                        </option>
                                        <option value="{{ App\Enums\MCU\FamilyDiseaseHistory::Asma()->value }}">
                                            {{ App\Enums\MCU\FamilyDiseaseHistory::Asma()->description }}
                                        </option>
                                        {{-- tambah asma --}}
                                    </x-inputs.select2_multiple>
                                    @error('family_disease_history')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>

                            </div><!-- /.form-group family_disease_history -->

                            <div class="mb-3 row form-group required">
                                <label for="alergi" class="col-sm-4 col-form-label">Alergi</label>
                                <div class="col-sm-8">
                                    <x-inputs.text wire:model="alergy" id="alergy" rows="7"
                                        placeholder="Riwayat Alergi" :error="'alergy'" />
                                </div>
                            </div><!-- /.form-group alergy -->

                            <h6 class="fw-normal mb-5">Gaya Hidup</h6>

                            <div class="mb-3 row form-group required">
                                <label for="smoking" class="col col-form-label">Apakah anda merokok</label>
                                <div class="col-8">
                                    <div class="form-check form-check-inline">
                                        <input wire:model="smoking"
                                            class="form-check-input @error('smoking') is-invalid @enderror"
                                            type="radio" id="smoking-1" value="yes">
                                        <label class="form-check-label" for="keluhan-1">Ya</label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                        <input wire:model="smoking"
                                            class="form-check-input @error('smoking') is-invalid @enderror"
                                            type="radio" id="smoking-2" value="no">
                                        <label class="form-check-label" for="keluhan-2">Tidak</label>
                                    </div>
                                </div>

                                @error('smoking')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div><!-- /.form-group smoking -->

                            <div class="mb-3 row form-group">
                                <label for="smoking_per_day" class="col"></label>
                                <div class="col-8 input-group">
                                    <x-inputs.text wire:model="smoking_per_day" id="smoking_per_day" placeholder="0"
                                        value="0" :error="'smoking_per_day'" />
                                    <span class="input-group-text" id="addons-jumlah-rokok">Batang/Hari</span>
                                </div>
                            </div><!-- /.form-group jumlah smoking_per_day -->

                            <div class="mb-3 row form-group required">
                                <label for="olahraga" class="col col-form-label">Apakah anda berolahraga</label>
                                <div class="col-8">
                                    <div class="form-check form-check-inline">
                                        <input wire:model="sports"
                                            class="form-check-input @error('sports') is-invalid @enderror"
                                            type="radio" id="sports-1" value="yes">
                                        <label class="form-check-label" for="sports-1">Ya</label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                        <input wire:model="sports"
                                            class="form-check-input @error('sports') is-invalid @enderror"
                                            type="radio" id="sports-2" value="no">
                                        <label class="form-check-label" for="sports-2">Tidak</label>
                                    </div>
                                    @error('sports')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                            </div><!-- /.form-group sports -->

                            <div class="mb-3 row form-group">
                                <label for="sports_per_week" class="col col-form-label">Per minggu</label>
                                <div class="col-8">
                                    <x-inputs.select2 wire:model="sports_per_week" id="sports_per_week"
                                        class="form-select" placeholder="Pilih Frekuensi">
                                        <option value="{{ App\Enums\MCU\ActivityStatus::No()->value }}">
                                            {{ App\Enums\MCU\ActivityStatus::No()->description }}</option>
                                        <option value="{{ App\Enums\MCU\ActivityStatus::Low()->value }}">
                                            {{ App\Enums\MCU\ActivityStatus::Low()->description }}</option>
                                        <option value="{{ App\Enums\MCU\ActivityStatus::Medium()->value }}">
                                            {{ App\Enums\MCU\ActivityStatus::Medium()->description }}</option>
                                        <option value="{{ App\Enums\MCU\ActivityStatus::High()->value }}">
                                            {{ App\Enums\MCU\ActivityStatus::High()->description }}</option>
                                    </x-inputs.select2>
                                </div>
                            </div><!-- /.form-group sports_per_week -->

                            <div class="mb-3 row form-group">
                                <label for="sports_type" class="col"></label>
                                <div class="col-8">
                                    <x-inputs.text wire:model="sports_type" id="sports_type" rows="7"
                                        placeholder="Jenis Olahraga" :error="'sports_type'" />
                                </div>
                            </div><!-- /.form-group sports_type -->

                            <div class="mb-3 row form-group required">
                                <label for="alcohol" class="col col-form-label">Apakah anda meminum
                                    alkohol</label>
                                <div class="col-7">
                                    <div class="form-check form-check-inline">
                                        <input wire:model="alcohol"
                                            class="form-check-input @error('alcohol') is-invalid @enderror"
                                            type="radio" id="alcohol-1" value="yes">
                                        <label class="form-check-label" for="alcohol-1">Ya</label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                        <input wire:model="alcohol"
                                            class="form-check-input @error('alcohol') is-invalid @enderror"
                                            type="radio" id="alcohol-2" value="no">
                                        <label class="form-check-label" for="alcohol-2">Tidak</label>
                                    </div>
                                    @error('alcohol')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                            </div><!-- /.form-group alcohol -->

                            @if ($employee_gender == 'female')
                                <h6 class="fw-normal mb-5">Menstruasi</h6>

                                <div class="mb-3 row form-group">
                                    <label for="menstrual_menarche" class="col">Kondisi
                                        menstruasi</label>
                                    <div class="col-8">
                                        <x-inputs.text wire:model="menstrual_menarche" id="menstrual_menarche"
                                            placeholder="Type Condition" :error="'menstrual_menarche'" />
                                    </div>
                                </div><!-- /.form-group menstrual_menarche -->

                                <div class="mb-3 row form-group">
                                    <label for="menstrual_cycle" class="col">Kondisi keteraturan
                                        siklus</label>
                                    <div class="col-8">
                                        <div class="form-check form-check-inline">
                                            <input wire:model="menstrual_cycle" class="form-check-input"
                                                type="radio" id="menstrual_cycle-1" value="Ya">
                                            <label class="form-check-label" for="menstrual_cycle-2">Ya</label>
                                        </div>
                                        <div class="form-check form-check-inline">
                                            <input wire:model="menstrual_cycle" class="form-check-input"
                                                type="radio" id="menstrual_cycle-2" value="Tidak">
                                            <label class="form-check-label" for="menstrual_cycle-2">Tidak</label>
                                        </div>
                                    </div>
                                </div><!-- /.form-group siklus_m_1 -->

                                <div class="mb-3 row form-group">
                                    <label for="menstrual_pain" class="col">Kondisi haid</label>

                                    <div class="col-8">
                                        <div class="form-check form-check-inline">
                                            <input wire:model="menstrual_pain" class="form-check-input"
                                                type="radio" id="menstrual_pain-1" value="Ya">
                                            <label class="form-check-label" for="menstrual_pain-2">Ya</label>
                                        </div>
                                        <div class="form-check form-check-inline">
                                            <input wire:model="menstrual_pain" class="form-check-input"
                                                type="radio" id="menstrual_pain-2" value="Tidak">
                                            <label class="form-check-label" for="menstrual_pain-2">Tidak</label>
                                        </div>
                                    </div>
                                    {{-- <div class="col-8 input-group">
                                        <x-inputs.text wire:model="menstrual_pain" id="menstrual_pain" placeholder=""
                                            :error="'menstrual_pain'" />
                                    </div> --}}
                                </div><!-- /.form-group menstrual_period -->

                                <div class="mb-3 row form-group">
                                    <label for="menstrual_period" class="col">Kondisi lama haid</label>
                                    <div class="col-8 input-group">
                                        <x-inputs.number wire:model="menstrual_period" id="menstrual_period"
                                            placeholder="0" value="0" :error="'menstrual_period'" />
                                        <span class="input-group-text" id="addons-lama-haid">Hari</span>
                                    </div>
                                </div><!-- /.form-group menstrual_period -->

                                <h6 class="fw-normal mb-5">Kehamilan</h6>

                                <div class="mb-3 row form-group">
                                    <label for="pregnant_period" class="col">Riwayat Hamil</label>
                                    <div class="col-8">
                                        <x-inputs.number wire:model="pregnant_period" id="pregnant_period"
                                            placeholder="0" value="0" :error="'pregnant_period'" />
                                    </div>
                                </div><!-- /.form-group pregnant_period -->

                                <div class="mb-3 row form-group">
                                    <label for="pregnant_spontan" class="col">pregnant_spontan</label>
                                    <div class="col-8">
                                        <x-inputs.number wire:model="pregnant_spontan" id="pregnant_spontan"
                                            placeholder="0" value="0" :error="'pregnant_spontan'" />
                                    </div>
                                </div><!-- /.form-group pregnant_spontan -->

                                <div class="mb-3 row form-group">
                                    <label for="pregnant_surgery" class="col">Bantuan /
                                        Operasi</label>
                                    <div class="col-8">
                                        <x-inputs.number wire:model="pregnant_surgery" id="pregnant_surgery"
                                            placeholder="0" value="0" :error="'pregnant_surgery'" />
                                    </div>
                                </div><!-- /.form-group pregnant_surgery -->

                                <div class="mb-3 row form-group">
                                    <label for="pregnant_abortion" class="col">Keguguran</label>
                                    <div class="col-8">
                                        <x-inputs.number wire:model="pregnant_abortion" id="pregnant_abortion"
                                            placeholder="0" value="0" :error="'pregnant_abortion'" />
                                    </div>
                                </div><!-- /.form-group pregnant_abortion -->

                                <div class="mb-3 row form-group">
                                    <label for="contraception" class="col">Apakah menggunakan alat
                                        kontrasepsi</label>
                                    <div class="col-8">
                                        <div class="form-check form-check-inline">
                                            <input wire:model="contraception" class="form-check-input" type="radio"
                                                name="contraception" id="contraception-1" value="yes">
                                            <label class="form-check-label" for="contraception-1">Ya</label>
                                        </div>
                                        <div class="form-check form-check-inline">
                                            <input wire:model="contraception" class="form-check-input" type="radio"
                                                name="contraception" id="contraception-2" value="no">
                                            <label class="form-check-label" for="contraception-2">Tidak</label>
                                        </div>
                                    </div>
                                </div><!-- /.form-group contraception -->

                                <div class="mb-3 row form-group">
                                    <label for="contraception_type" class="col"></label>
                                    <div class="col-8">
                                        <x-inputs.textarea wire:model="contraception_type" id="contraception_type"
                                            placeholder="" :error="'contraception_type'" />
                                    </div>
                                </div><!-- /.form-group contraception_type -->
                            @endif

                            <h6 class="fw-normal mb-5">Pekerjaan</h6>

                            <div class="mb-3 row form-group">
                                <label for="current_job" class="col">Pekerjaan saat ini</label>
                                <div class="col-8">
                                    <x-inputs.textarea wire:model="current_job" id="current_job" rows="7"
                                        placeholder="" :error="'current_job'" />
                                </div>
                            </div><!-- /.form-group current_job -->

                            <div class="mb-3 row form-group">
                                <label for="previous_job" class="col">Pekerjaan
                                    sebelumnya</label>
                                <div class="col-8">
                                    <x-inputs.textarea wire:model="previous_job" id="previous_job" rows="7"
                                        placeholder="" :error="'previous_job'" />
                                </div>
                            </div><!-- /.form-group previous_job -->

                            <div class="mb-3 row form-group">
                                <label for="current_job_details" class="col">Detail Pekerjaan Saat
                                    Ini</label>
                                <div class="col-8">
                                    <x-inputs.textarea wire:model="current_job_details" id="current_job_details"
                                        rows="7" placeholder="" :error="'current_job_details'" />
                                </div>
                            </div><!-- /.form-group current_job_details -->

                            <h6 class="fw-normal mb-5">Vaksin Khusus Food Handler</h6>

                            {{-- Tanggal --}}
                            <div class="mb-3 row form-group">
                                <label for="vaccination_hep_a1" class="col">Hep A - 1st</label>
                                <div class="col-8">
                                    <x-inputs.datepicker wire:model="vaccination_hep_a1" id="vaccination_hep_a1"
                                        placeholder="Pilih Tanggal" :error="'vaccination_hep_a1'" />
                                </div>
                            </div><!-- /.form-group vaccination_hep_a1 -->

                            <div class="mb-3 row form-group">
                                <label for="vaccination_hep_a2" class="col">Hep A - 2nd</label>
                                <div class="col-8">
                                    <x-inputs.datepicker wire:model="vaccination_hep_a2" id="vaccination_hep_a2"
                                        placeholder="Pilih Tanggal" :error="'vaccination_hep_a2'" />
                                </div>
                            </div><!-- /.form-group vaccination_hep_a2 -->

                            <div class="mb-3 row form-group">
                                <label for="vaccination_hep_a3" class="col">Hep A - 3 years</label>
                                <div class="col-8">
                                    <x-inputs.datepicker wire:model="vaccination_hep_a3" id="vaccination_hep_a3"
                                        placeholder="Pilih Tanggal" :error="'vaccination_hep_a3'" />
                                </div>
                            </div><!-- /.form-group vaccination_hep_a3 -->

                            <div class="mb-3 row form-group">
                                <label for="vaccination_typhoid_1" class="col">Typhoid -
                                    1st</label>
                                <div class="col-8">
                                    <x-inputs.datepicker wire:model="vaccination_typhoid_1" id="vaccination_typhoid_1"
                                        placeholder="Pilih Tanggal" :error="'vaccination_typhoid_1'" />
                                </div>
                            </div><!-- /.form-group vaccination_typhoid_1 -->

                            <div class="mb-3 row form-group">
                                <label for="vaccination_typhoid_3" class="col">Typhoid - 3
                                    years</label>
                                <div class="col-8">
                                    <x-inputs.datepicker wire:model="vaccination_typhoid_3" id="vaccination_typhoid_3"
                                        placeholder="Pilih Tanggal" :error="'vaccination_typhoid_3'" />
                                </div>
                            </div><!-- /.form-group vaccination_typhoid_3 -->

                            <div class="mb-3 row form-group">
                                <label for="vaccination_albendandazole" class="col">Albendandazole
                                    400mg</label>
                                <div class="col-8">
                                    <x-inputs.datepicker wire:model="vaccination_albendandazole"
                                        id="vaccination_albendandazole" placeholder="Pilih Tanggal"
                                        :error="'vaccination_albendandazole'" />
                                </div>
                            </div><!-- /.form-group vaccination_albendandazole -->

                        </div><!-- /.content-section -->
                    </div><!-- /.wrapper-content-accordion -->
                </div><!-- /.Anamnesis dan Riwayat Kesehatan -->

                <!-- anamnesis_2 Accordion -->
                <div id="tanda-vital" class="section-anamnesis_2" x-data="{ accordionOpen: true }">
                    <button class="header-accordion d-flex justify-content-between w-100 border-0 bg-white py-3 px-0"
                        @click.prevent="accordionOpen = ! accordionOpen">
                        <h6 class="mb-0 fw-normal title-accordion">Anamnesis dan Riwayat Kesehatan</h6>
                        <span x-bind:class="accordionOpen ? 'open' : ''"><img
                                src="{{ asset('/images/icons/angle-down.png') }}" alt="" /></span>
                    </button>
                    <div class="wrapper-content-accordion max-h-0 overflow-hidden position-relative transition-all duration-700"
                        x-ref="karyawan"
                        x-bind:style="accordionOpen ? 'max-height: ' + $refs.karyawan.scrollHeight + 'px' : ''">

                        <div class="content-section p-4">

                            <div class="mb-3 row form-group">
                                <label for="tinggi" class="col col-form-label">Tanda-tanda vital dan
                                    antropometry</label>
                                <div class="col-4 input-group w-33">
                                    <x-inputs.number wire:model="height" id="height" placeholder="Masukkan tinggi"
                                        value="0" :error="'height'" />
                                    <span class="input-group-text" id="addons-tinggi">/cm</span>
                                </div>
                                <div class="col-4 input-group w-33">
                                    <x-inputs.number wire:model="weight" {{-- wire:change="NutritionalStatus({{ $height }},{{ $weight }})" --}}
                                        wire:change="IdealFormula({{ $height }},{{ $weight }})"
                                        id="weight" placeholder="Masukkan berat badan" value="0"
                                        :error="'weight'" />
                                    <span class="input-group-text" id="addons-berat">/kg</span>
                                </div>
                            </div><!-- /.form-group tanda vital -->

                            <div class="mb-3 row form-group">
                                <label for="name" class="col d-flex flex-column">
                                    <span class="col-form-label pb-0 lh-sm">Body Mass Index</span>
                                    <span class="opacity-50 lh-sm">Auto calculation</span>
                                </label>
                                <div class="col-8 input-group">
                                    <x-inputs.text wire:model="bmi" id="bmi" placeholder="Body Mass Index"
                                        value="0" :error="'bmi'" value="{{ $bmi }}" disabled />
                                    <span class="input-group-text" id="addons-body_mass">kg/m2</span>
                                </div>
                            </div><!-- /.form-group body mass -->

                            <div class="mb-3 row form-group">
                                <label for="gizi" class="col d-flex flex-column">
                                    <span class="col-form-label pb-0 lh-sm">Status gizi</span>
                                    <span class="opacity-50 lh-sm">Auto calculation</span>
                                </label>
                                <div class="col-8">
                                    <x-inputs.text wire:model="nutritional_status" id="nutritional_status"
                                        placeholder="Show Result" :error="'nutritional_status'"
                                        value="{{ $nutritional_status }}" disabled />
                                </div>
                            </div><!-- /.form-group gizi -->

                            <div class="mb-3 row form-group">
                                <label for="bb_terendah" class="col d-flex flex-column">
                                    <span class="col-form-label pb-0 lh-sm">BB Sehat Terendah</span>
                                    <span class="opacity-50 lh-sm">Auto calculation</span>
                                </label>
                                <div class="col-8">
                                    <x-inputs.text wire:model="bmi_lower" id="bmi_lower" placeholder="Show Result"
                                        :error="'bmi_lower'" value="{{ $bmi_lower }}" disabled />
                                </div>
                            </div><!-- /.form-group bb_terendah -->

                            <div class="mb-3 row form-group">
                                <label for="bb_tertinggi" class="col d-flex flex-column">
                                    <span class="col-form-label pb-0 lh-sm">BB Sehat Tertinggi</span>
                                    <span class="opacity-50 lh-sm">Auto calculation</span>
                                </label>
                                <div class="col-8">
                                    <x-inputs.text wire:model="bmi_upper" id="bmi_upper" placeholder="Show Result"
                                        :error="'bmi_upper'" value="{{ $bmi_upper }}" disabled />
                                </div>
                            </div><!-- /.form-group bb_tertinggi -->

                            <div class="mb-3 row form-group required">
                                <label for="systolic_blood_pressure"
                                    class="col d-flex flex-column col-form-label">Tekanan
                                    Darah
                                    Sistolik</label>
                                <div class="col-8 input-group">
                                    <x-inputs.number wire:model="systolic_blood_pressure" id="systolic_blood_pressure"
                                        placeholder="Masukkan tinggi" value="0" :error="'systolic_blood_pressure'" />
                                    <span class="input-group-text" id="addons-sistolik">mmHg</span>
                                </div>
                            </div><!-- /.form-group sistolik -->

                            <div class="mb-3 row form-group required">
                                <label for="diastolic_blood_pressure"
                                    class="col d-flex flex-column col-form-label">Tekanan
                                    Darah
                                    Diastolik</label>
                                <div class="col-8 input-group">
                                    <x-inputs.number wire:model="diastolic_blood_pressure"
                                        wire:change="BloodPressureStatus({{ $systolic_blood_pressure }},{{ $diastolic_blood_pressure }})"
                                        id="diastolic_blood_pressure" placeholder="Masukkan tinggi" value="0"
                                        :error="'diastolic_blood_pressure'" />
                                    <span class="input-group-text" id="addons-diastolik">mmHg</span>
                                </div>
                            </div><!-- /.form-group diastolik -->

                            <div class="mb-3 row form-group">
                                <label for="arteries" class="col d-flex flex-column col-form-label">Nadi</label>
                                <div class="col-8 input-group">
                                    <x-inputs.number wire:model="arteries" id="arteries"
                                        placeholder="Masukkan tinggi" value="0" :error="'arteries'" />
                                    <span class="input-group-text" id="addons-nadi">x/m</span>
                                </div>
                            </div><!-- /.form-group nadi -->

                            <div class="mb-3 row form-group">
                                <label for="rr" class="col d-flex flex-column col-form-label">Respiratory
                                    Rate</label>
                                <div class="col-8 input-group">
                                    <x-inputs.number wire:model="rr" id="rr" placeholder="Masukkan tinggi"
                                        value="0" :error="'rr'" />
                                    <span class="input-group-text" id="addons-respiratory">x/m</span>
                                </div>
                            </div><!-- /.form-group respiratory -->

                            <div class="mb-3 row form-group">
                                <label for="body_temperature" class="col d-flex flex-column col-form-label">Suhu
                                    Tubuh</label>
                                <div class="col-8 input-group">
                                    <x-inputs.number wire:model="body_temperature" id="body_temperature"
                                        placeholder="Masukkan tinggi" value="0" :error="'body_temperature'" />
                                    <span class="input-group-text" id="addons-suhu">x/m</span>
                                </div>
                            </div><!-- /.form-group suhu -->

                            <div class="mb-3 row form-group">
                                <label for="blood_pressure_status" class="col d-flex flex-column">
                                    <span class="col-form-label pb-0 lh-sm">Status tekanan darah</span>
                                    <span class="opacity-50 lh-sm">Auto calculation</span>
                                </label>
                                <div class="col-8">
                                    <x-inputs.text wire:model="blood_pressure_status" id="blood_pressure_status"
                                        placeholder="Show Result" :error="'blood_pressure_status'" disabled />
                                </div>
                            </div><!-- /.form-group tekanan_darah -->


                        </div><!-- /.content-section -->

                    </div><!-- /.wrapper-content-accordion -->

                </div><!-- /.anamnesis_2 -->

                <!-- Pemeriksaan Generalisata Accordion -->
                <div id="generalisata" class="section-generalisata" x-data="{ accordionOpen: true }">
                    <button class="header-accordion d-flex justify-content-between w-100 border-0 bg-white py-3 px-0"
                        @click.prevent="accordionOpen = ! accordionOpen">
                        <h6 class="mb-0 fw-normal title-accordion">Pemeriksaan Generalisata</h6>
                        <span x-bind:class="accordionOpen ? 'open' : ''"><img
                                src="{{ asset('/images/icons/angle-down.png') }}" alt="" /></span>
                    </button>
                    <div class="wrapper-content-accordion max-h-0 overflow-hidden position-relative transition-all duration-700"
                        x-ref="karyawan"
                        x-bind:style="accordionOpen ? 'max-height: ' + $refs.karyawan.scrollHeight + 'px' : ''">

                        <div class="content-section p-4">

                            <div class="mb-3 row form-group">
                                <label for="heent" class="col col-form-label">HEENT</label>
                                <div class="col-8">
                                    <x-inputs.text wire:model="heent" id="heent" rows="7" placeholder=""
                                        :error="'heent'" />
                                </div>
                            </div><!-- /.form-group heent -->

                            <div class="mb-3 row form-group">
                                <label for="orodental_caries" class="col col-form-label">ORODENTAL CARIES</label>
                                <div class="col-8">
                                    <x-inputs.text wire:model="orodental_caries" id="orodental_caries" rows="7"
                                        placeholder="" :error="'orodental_caries'" />
                                </div>
                            </div><!-- /.form-group orodental_caries -->

                            <div class="mb-3 row form-group">
                                <label for="orodental_gangren_radix" class="col col-form-label">ORODENTAL GANGREN
                                    RADIX</label>
                                <div class="col-8">
                                    <x-inputs.text wire:model="orodental_gangren_radix" id="orodental_gangren_radix"
                                        rows="7" placeholder="" :error="'orodental_gangren_radix'" />
                                </div>
                            </div><!-- /.form-group orodental_gangren_radix -->

                            <div class="mb-3 row form-group">
                                <label for="cardiovascular_system" class="col col-form-label">SISTEM
                                    KARDIOVASKULER</label>
                                <div class="col-8">
                                    <x-inputs.select2 wire:model="cardiovascular_system" id="cardiovascular_system"
                                        class="form-select" placeholder="Select result">
                                        <option value="Normal">Normal</option>
                                        <option value="Murmur">Murmur</option>
                                    </x-inputs.select2>
                                    {{-- <x-inputs.text wire:model="cardiovascular_system" id="cardiovascular_system"
                                        rows="7" placeholder="" :error="'cardiovascular_system'" /> --}}
                                </div>
                            </div><!-- /.form-group cardiovascular_system -->

                            <div class="mb-3 row form-group">
                                <label for="respiratorus_system" class="col col-form-label">SISTEM
                                    RESPIRATORIUS</label>
                                <div class="col-8">
                                    <x-inputs.select2 wire:model="respiratorus_system" id="respiratorus_system"
                                        class="form-select" placeholder="Select result">
                                        <option value="Normal">Normal</option>
                                        <option value="Ronkhi">Ronkhi</option>
                                        <option value="Wheezing">Wheezing</option>
                                    </x-inputs.select2>
                                    {{-- <x-inputs.text wire:model="respiratorus_system" id="respiratorus_system"
                                        rows="7" placeholder="" :error="'respiratorus_system'" /> --}}
                                </div>
                            </div><!-- /.form-group respiratorus_system -->

                            <div class="mb-3 row form-group">
                                <label for="digestivus_system" class="col col-form-label">SISTEM
                                    DIGESTIVUS</label>
                                <div class="col-8">
                                    <x-inputs.select2 wire:model="digestivus_system" id="digestivus_system"
                                        class="form-select" placeholder="Select result">
                                        <option value="Normal">Normal</option>
                                        <option value="Tidak Normal">Tidak Normal</option>
                                    </x-inputs.select2>
                                    {{-- <x-inputs.text wire:model="digestivus_system" id="digestivus_system"
                                        rows="7" placeholder="" :error="'digestivus_system'" /> --}}
                                </div>
                            </div><!-- /.form-group digestivus -->

                            <div class="mb-3 row form-group">
                                <label for="genitounrinarius_system" class="col col-form-label">SISTEM
                                    GENITOURINARIUS+KULIT</label>
                                <div class="col-8">
                                    <x-inputs.select2 wire:model="genitounrinarius_system"
                                        id="genitounrinarius_system" class="form-select" placeholder="Select result">
                                        <option value="Normal">Normal</option>
                                        <option value="Tidak Normal">Tidak Normal</option>
                                    </x-inputs.select2>
                                    {{-- <x-inputs.text wire:model="genitounrinarius_system" id="genitounrinarius_system"
                                        rows="7" placeholder="" :error="'genitounrinarius_system'" /> --}}
                                </div>
                            </div><!-- /.form-group genitourinarius -->

                            <div class="mb-3 row form-group">
                                <label for="neuromuscular_system" class="col col-form-label">SISTEM
                                    NEUROMUSKULAR</label>
                                <div class="col-8">
                                    <x-inputs.select2 wire:model="neuromuscular_system" id="neuromuscular_system"
                                        class="form-select" placeholder="Select result">
                                        <option value="Normal">Normal</option>
                                        <option value="Skoliosis">Skoliosis</option>
                                        <option value="Kyphosis">Kyphosis</option>
                                        <option value="Lordosis">Lordosis</option>
                                        <option value="Nyeri Pinggang Belakang">Nyeri Pinggang Belakang</option>
                                    </x-inputs.select2>
                                    {{-- <x-inputs.text wire:model="neuromuscular_system" id="neuromuscular_system"
                                        rows="7" placeholder="" :error="'neuromuscular_system'" /> --}}
                                </div>
                            </div><!-- /.form-group neuromuskular -->

                            <div class="mb-3 row form-group">
                                <label for="fitness_test" class="col d-flex gap-3 align-items-center">
                                    <span class="col-form-label pb-0 lh-sm">Lain-lain</span>
                                    <span
                                        class="icon-tooltip"
                                        x-data="{tooltip:false}"
                                        x-on:mouseover="tooltip = true"
                                        x-on:mouseleave="tooltip = false"
                                    >
                                        <i class="fa-solid fa-circle-question pt-2 text-info"></i>
                                        <div class="tooltip-content" x-show="tooltip">Lain-lain tooltip</div>
                                    </span>
                                </label>

                                <div class="col-8">
                                    {{-- <x-inputs.text wire:model="fitness_test" id="fitness_test" rows="7"
                                        placeholder="" :error="'fitness_test'" /> --}}
                                    <x-inputs.select2 wire:model="fitness_test" id="fitness_test" class="form-select"
                                        placeholder="Select result">
                                        <option value="Kurang">Kurang</option>
                                        <option value="Cukup">Cukup</option>
                                        <option value="Sedang">Sedang</option>
                                        <option value="Baik">Baik</option>
                                        <option value="Sangat Baik">Sangat Baik</option>
                                    </x-inputs.select2>
                                </div>
                            </div><!-- /.form-group fitness_test -->

                        </div><!-- /.content-section -->

                    </div><!-- /.wrapper-content-accordion -->
                </div><!-- /.generalisata -->

                @if ($employee_age <= 55)
                    <!-- Pemeriksaan Visus Accordion -->
                    <div id="visus" class="section-visus" x-data="{ accordionOpen: true }">
                        <button
                            class="header-accordion d-flex justify-content-between w-100 border-0 bg-white py-3 px-0"
                            @click.prevent="accordionOpen = ! accordionOpen">
                            <h6 class="mb-0 fw-normal title-accordion">Pemeriksaan Visus</h6>
                            <span x-bind:class="accordionOpen ? 'open' : ''"><img
                                    src="{{ asset('/images/icons/angle-down.png') }}" alt="" /></span>
                        </button>
                        <div class="wrapper-content-accordion max-h-0 overflow-hidden position-relative transition-all duration-700"
                            x-ref="karyawan"
                            x-bind:style="accordionOpen ? 'max-height: ' + $refs.karyawan.scrollHeight + 'px' : ''">

                            <div class="content-section p-4">
                                <h6 class="fw-normal mb-3">Non Koreksi</h6>
                                <div class="mb-3 row form-group">
                                    <div class="col">
                                        <label for="visus_non_correction_od" class="col col-form-label">Visus jauh
                                            OD</label>
                                        <x-inputs.mask wire:model="visus_non_correction_od"
                                            id="visus_non_correction_od" x-mask="9/9" placeholder="0/0"
                                            :error="'visus_non_correction_od'" />
                                    </div>
                                    <div class="col">
                                        <label for="visus_non_correction_os" class="col col-form-label">Visus jauh
                                            OS</label>
                                        <x-inputs.mask wire:model="visus_non_correction_os"
                                            id="visus_non_correction_os" x-mask="9/9" placeholder="0/0"
                                            :error="'visus_non_correction_os'" />
                                    </div>
                                    <div class="col">
                                        <label for="visus_non_correction_ods" class="col col-form-label">Visus jauh
                                            ODS</label>
                                        <x-inputs.mask wire:model="visus_non_correction_ods"
                                            id="visus_non_correction_ods" x-mask="9/9" placeholder="0/0"
                                            :error="'visus_non_correction_ods'" />
                                    </div>
                                </div><!-- /.form-group non koreksi -->

                                <h6 class="fw-normal mb-3">Koreksi</h6>
                                <div class="mb-5 row form-group">
                                    <div class="col">
                                        <label for="visus_correction_od" class="col col-form-label">Visus jauh
                                            OD</label>
                                        <x-inputs.mask wire:model="visus_correction_od" id="visus_correction_od"
                                            x-mask="9/9" placeholder="0/0" :error="'visus_correction_od'" />
                                    </div>
                                    <div class="col">
                                        <label for="visus_correction_os" class="col col-form-label">Visus jauh
                                            OS</label>
                                        <x-inputs.mask wire:model="visus_correction_os" id="visus_correction_os"
                                            x-mask="9/9" placeholder="0/0" :error="'visus_correction_os'" />
                                    </div>
                                    <div class="col">
                                        <label for="visus_correction_ods" class="col col-form-label">Visus jauh
                                            ODS</label>
                                        <x-inputs.mask wire:model="visus_correction_ods" id="visus_correction_ods"
                                            x-mask="9/9" placeholder="0/0" :error="'visus_correction_ods'" />
                                    </div>
                                </div><!-- /.form-group koreksi -->

                                <div class="mb-3 row form-group">
                                    <label for="visus_impression" class="col col-form-label">Kesan Visus Jauh</label>
                                    <div class="col-8">
                                        {{-- <x-inputs.textarea wire:model="visus_impression" id="visus_impression"
                                            placeholder="" :error="'visus_impression'" /> --}}
                                        <x-inputs.select2 wire:model="visus_impression" id="visus_impression"
                                            class="form-select" placeholder="Select result">
                                            <option value="Normal">Normal</option>
                                            <option value="Tidak Normal">Tidak Normal</option>
                                            {{-- <option value="visus_impression_3">Kesan Visus Jauh 3</option>
                                            <option value="visus_impression_4">Kesan Visus Jauh 4</option>
                                            <option value="visus_impression_5">Kesan Visus Jauh 5</option>
                                            <option value="visus_impression_6">Kesan Visus Jauh 6</option> --}}
                                        </x-inputs.select2>
                                    </div>
                                </div><!-- /.form-group visus_impression -->

                                <div class="mb-3 row form-group">
                                    <label for="visus_reading_test" class="col col-form-label">READING TEST / Visus
                                        Dekat
                                        /
                                        Jaeger Test</label>
                                    <div class="col-8">
                                        <x-inputs.select2 wire:model="visus_reading_test" id="visus_reading_test"
                                            class="form-select" placeholder="Select result">
                                            <option value="Hypermetropia">Hypermetropia</option>
                                            <option value="Normal">Normal</option>
                                        </x-inputs.select2>
                                    </div>
                                </div><!-- /.form-group visus_reading_test -->

                                <div class="mb-3 row form-group">
                                    <label for="visus_color_blind" class="col col-form-label">Buta Warna</label>
                                    <div class="col-8">
                                        <div class="form-check form-check-inline">
                                            <input wire:model="visus_color_blind" class="form-check-input"
                                                type="radio" name="visus_color_blind" id="visus_color_blind-1"
                                                value="Normal">
                                            <label class="form-check-label" for="visus_color_blind-1">Normal</label>
                                        </div>
                                        <div class="form-check form-check-inline">
                                            <input wire:model="visus_color_blind" class="form-check-input"
                                                type="radio" name="visus_color_blind" id="visus_color_blind-2"
                                                value="Abnormal">
                                            <label class="form-check-label" for="visus_color_blind-2">Abnormal</label>
                                        </div>
                                        <div class="form-check form-check-inline">
                                            <input wire:model="visus_color_blind" class="form-check-input"
                                                type="radio" name="visus_color_blind" id="visus_color_blind-3"
                                                value="Parsial">
                                            <label class="form-check-label" for="visus_color_blind-3">Parsial</label>
                                        </div>
                                    </div>
                                </div><!-- /.form-group visus_color_blind -->

                                <div class="mb-3 row form-group">
                                    <label for="visus_notes" class="col col-form-label">Catatan</label>
                                    <div class="col-8">
                                        <x-inputs.text wire:model="visus_notes" id="visus_notes" rows="7"
                                            placeholder="" :error="'visus_notes'" />
                                    </div>
                                </div><!-- /.form-group visus_notes -->
                            </div><!-- /.content-section -->
                        </div><!-- /.wrapper-content-accordion -->
                    </div><!-- /.visus -->
                @endif

                @if ($medical_ex_type != 'office-group')
                    @if ($medical_ex_type != 'food-handler' && $medical_type != 'periodic')
                        <!-- Audiometri Accordion -->
                        <div id="audiometri" class="section-audiometri" x-data="{ accordionOpen: true }">
                            <button
                                class="header-accordion d-flex justify-content-between w-100 border-0 bg-white py-3 px-0"
                                @click.prevent="accordionOpen = ! accordionOpen">
                                <h6 class="mb-0 fw-normal title-accordion">Audiometri</h6>
                                <span x-bind:class="accordionOpen ? 'open' : ''"><img
                                        src="{{ asset('/images/icons/angle-down.png') }}" alt="" /></span>
                            </button>
                            <div class="wrapper-content-accordion max-h-0 overflow-hidden position-relative transition-all duration-700"
                                x-ref="karyawan"
                                x-bind:style="accordionOpen ? 'max-height: ' + $refs.karyawan.scrollHeight + 'px' : ''">

                                <div class="content-section p-4">
                                    <h6 class="fw-normal mb-3">Air conduction Kanan</h6>

                                    <div class="mb-3 row form-group">
                                        <div class="col">
                                            <label for="audiometry_right_air_conduction_500"
                                                class="col col-form-label">500</label>
                                            <x-inputs.number wire:model="audiometry_right_air_conduction_500"
                                                id="audiometry_right_air_conduction_500" placeholder="0"
                                                :error="'audiometry_right_air_conduction_500'" />
                                        </div>
                                        <div class="col">
                                            <label for="audiometry_right_air_conduction_1000"
                                                class="col col-form-label">1000</label>
                                            <x-inputs.number wire:model="audiometry_right_air_conduction_1000"
                                                id="audiometry_right_air_conduction_1000" placeholder="0"
                                                :error="'audiometry_right_air_conduction_1000'" />
                                        </div>
                                        <div class="col">
                                            <label for="audiometry_right_air_conduction_2000"
                                                class="col col-form-label">2000</label>
                                            <x-inputs.number wire:model="audiometry_right_air_conduction_2000"
                                                id="audiometry_right_air_conduction_2000" placeholder="0"
                                                :error="'audiometry_right_air_conduction_2000'" />
                                        </div>
                                        <div class="col">
                                            <label for="audiometry_right_air_conduction_3000"
                                                class="col col-form-label">3000</label>
                                            <x-inputs.number wire:model="audiometry_right_air_conduction_3000"
                                                id="audiometry_right_air_conduction_3000" placeholder="0"
                                                :error="'audiometry_right_air_conduction_3000'" />
                                        </div>
                                    </div><!-- /.form-group audiometry_right_air_conduction -->

                                    <div class="mb-5 row form-group">
                                        <div class="col">
                                            <label for="audiometry_right_air_conduction_4000"
                                                class="col col-form-label">4000</label>
                                            <x-inputs.number wire:model="audiometry_right_air_conduction_4000"
                                                id="audiometry_right_air_conduction_4000" placeholder="0"
                                                :error="'audiometry_right_air_conduction_4000'" />
                                        </div>
                                        <div class="col">
                                            <label for="audiometry_right_air_conduction_6000"
                                                class="col col-form-label">6000</label>
                                            <x-inputs.number wire:model="audiometry_right_air_conduction_6000"
                                                id="audiometry_right_air_conduction_6000" placeholder="0"
                                                :error="'audiometry_right_air_conduction_6000'" />
                                        </div>
                                        <div class="col">
                                            <label for="audiometry_right_air_conduction_8000"
                                                class="col col-form-label">8000</label>
                                            <x-inputs.number wire:model="audiometry_right_air_conduction_8000"
                                                id="audiometry_right_air_conduction_8000" placeholder="0"
                                                :error="'audiometry_right_air_conduction_8000'" />
                                        </div>
                                        <div class="col">
                                            <label for="audiometry_right_air_conduction_htl"
                                                class="col col-form-label">HTL</label>
                                            <x-inputs.number wire:model="audiometry_right_air_conduction_htl"
                                                id="audiometry_right_air_conduction_htl" placeholder="0"
                                                :error="'audiometry_right_air_conduction_htl'" />
                                        </div>
                                    </div><!-- /.form-group ac_kanan -->

                                    <h6 class="fw-normal mb-3">Bone conduction Kanan</h6>

                                    <div class="mb-3 row form-group">
                                        <div class="col">
                                            <label for="audiometry_right_bone_conduction_500"
                                                class="col col-form-label">500</label>
                                            <x-inputs.number wire:model="audiometry_right_bone_conduction_500"
                                                id="audiometry_right_bone_conduction_500" placeholder="0"
                                                :error="'audiometry_right_bone_conduction_500'" />
                                        </div>
                                        <div class="col">
                                            <label for="audiometry_right_bone_conduction_1000"
                                                class="col col-form-label">1000</label>
                                            <x-inputs.number wire:model="audiometry_right_bone_conduction_1000"
                                                id="audiometry_right_bone_conduction_1000" placeholder="0"
                                                :error="'audiometry_right_bone_conduction_1000'" />
                                        </div>
                                        <div class="col">
                                            <label for="audiometry_right_bone_conduction_2000"
                                                class="col col-form-label">2000</label>
                                            <x-inputs.number wire:model="audiometry_right_bone_conduction_2000"
                                                id="audiometry_right_bone_conduction_2000" placeholder="0"
                                                :error="'audiometry_right_bone_conduction_2000'" />
                                        </div>
                                        <div class="col">
                                            <label for="audiometry_right_bone_conduction_3000"
                                                class="col col-form-label">3000</label>
                                            <x-inputs.number wire:model="audiometry_right_bone_conduction_3000"
                                                id="audiometry_right_bone_conduction_3000" placeholder="0"
                                                :error="'audiometry_right_bone_conduction_3000'" />
                                        </div>
                                    </div><!-- /.form-group bc_kanan -->

                                    <div class="mb-5 row form-group">
                                        <div class="col">
                                            <label for="audiometry_right_bone_conduction_4000"
                                                class="col col-form-label">4000</label>
                                            <x-inputs.number wire:model="audiometry_right_bone_conduction_4000"
                                                id="audiometry_right_bone_conduction_4000" placeholder="0"
                                                :error="'audiometry_right_bone_conduction_4000'" />
                                        </div>
                                        <div class="col">
                                            <label for="audiometry_right_bone_conduction_6000"
                                                class="col col-form-label">6000</label>
                                            <x-inputs.number wire:model="audiometry_right_bone_conduction_6000"
                                                id="audiometry_right_bone_conduction_6000" placeholder="0"
                                                :error="'audiometry_right_bone_conduction_6000'" />
                                        </div>
                                        <div class="col">
                                            <label for="audiometry_right_bone_conduction_8000"
                                                class="col col-form-label">8000</label>
                                            <x-inputs.number wire:model="audiometry_right_bone_conduction_8000"
                                                id="audiometry_right_bone_conduction_8000" placeholder="0"
                                                :error="'audiometry_right_bone_conduction_8000'" />
                                        </div>
                                        <div class="col">
                                            <label for="audiometry_right_bone_conduction_htl"
                                                class="col col-form-label">HTL</label>
                                            <x-inputs.number wire:model="audiometry_right_bone_conduction_htl"
                                                id="audiometry_right_bone_conduction_htl" placeholder="0"
                                                :error="'audiometry_right_bone_conduction_htl'" />
                                        </div>
                                    </div><!-- /.form-group bc_kanan -->

                                    <h6 class="fw-normal mb-3">Air conduction Kiri</h6>

                                    <div class="mb-3 row form-group">
                                        <div class="col">
                                            <label for="audiometry_left_air_conduction_500"
                                                class="col col-form-label">500</label>
                                            <x-inputs.number wire:model="audiometry_left_air_conduction_500"
                                                id="audiometry_left_air_conduction_500" placeholder="0"
                                                :error="'audiometry_left_air_conduction_500'" />
                                        </div>
                                        <div class="col">
                                            <label for="audiometry_left_air_conduction_1000"
                                                class="col col-form-label">1000</label>
                                            <x-inputs.number wire:model="audiometry_left_air_conduction_1000"
                                                id="audiometry_left_air_conduction_1000" placeholder="0"
                                                :error="'audiometry_left_air_conduction_1000'" />
                                        </div>
                                        <div class="col">
                                            <label for="audiometry_left_air_conduction_2000"
                                                class="col col-form-label">2000</label>
                                            <x-inputs.number wire:model="audiometry_left_air_conduction_2000"
                                                id="audiometry_left_air_conduction_2000" placeholder="0"
                                                :error="'audiometry_left_air_conduction_2000'" />
                                        </div>
                                        <div class="col">
                                            <label for="audiometry_left_air_conduction_3000"
                                                class="col col-form-label">3000</label>
                                            <x-inputs.number wire:model="audiometry_left_air_conduction_3000"
                                                id="audiometry_left_air_conduction_3000" placeholder="0"
                                                :error="'audiometry_left_air_conduction_3000'" />
                                        </div>
                                    </div><!-- /.form-group ac_kanan -->

                                    <div class="mb-5 row form-group">
                                        <div class="col">
                                            <label for="audiometry_left_air_conduction_4000"
                                                class="col col-form-label">4000</label>
                                            <x-inputs.number wire:model="audiometry_left_air_conduction_4000"
                                                id="audiometry_left_air_conduction_4000" placeholder="0"
                                                :error="'audiometry_left_air_conduction_4000'" />
                                        </div>
                                        <div class="col">
                                            <label for="audiometry_left_air_conduction_6000"
                                                class="col col-form-label">6000</label>
                                            <x-inputs.number wire:model="audiometry_left_air_conduction_6000"
                                                id="audiometry_left_air_conduction_6000" placeholder="0"
                                                :error="'audiometry_left_air_conduction_6000'" />
                                        </div>
                                        <div class="col">
                                            <label for="audiometry_left_air_conduction_8000"
                                                class="col col-form-label">8000</label>
                                            <x-inputs.number wire:model="audiometry_left_air_conduction_8000"
                                                id="audiometry_left_air_conduction_8000" placeholder="0"
                                                :error="'audiometry_left_air_conduction_8000'" />
                                        </div>
                                        <div class="col">
                                            <label for="audiometry_left_air_conduction_htl"
                                                class="col col-form-label">HTL</label>
                                            <x-inputs.number wire:model="audiometry_left_air_conduction_htl"
                                                id="audiometry_left_air_conduction_htl" placeholder="0"
                                                :error="'audiometry_left_air_conduction_htl'" />
                                        </div>
                                    </div><!-- /.form-group ac_kiri -->

                                    <h6 class="fw-normal mb-3">Bone conduction Kiri</h6>

                                    <div class="mb-3 row form-group">
                                        <div class="col">
                                            <label for="audiometry_left_bone_conduction_500"
                                                class="col col-form-label">500</label>
                                            <x-inputs.number wire:model="audiometry_left_bone_conduction_500"
                                                id="audiometry_left_bone_conduction_500" placeholder="0"
                                                :error="'audiometry_left_bone_conduction_500'" />
                                        </div>
                                        <div class="col">
                                            <label for="audiometry_left_bone_conduction_1000"
                                                class="col col-form-label">1000</label>
                                            <x-inputs.number wire:model="audiometry_left_bone_conduction_1000"
                                                id="audiometry_left_bone_conduction_1000" placeholder="0"
                                                :error="'audiometry_left_bone_conduction_1000'" />
                                        </div>
                                        <div class="col">
                                            <label for="audiometry_left_bone_conduction_2000"
                                                class="col col-form-label">2000</label>
                                            <x-inputs.number wire:model="audiometry_left_bone_conduction_2000"
                                                id="audiometry_left_bone_conduction_2000" placeholder="0"
                                                :error="'audiometry_left_bone_conduction_2000'" />
                                        </div>
                                        <div class="col">
                                            <label for="audiometry_left_bone_conduction_3000"
                                                class="col col-form-label">3000</label>
                                            <x-inputs.number wire:model="audiometry_left_bone_conduction_3000"
                                                id="audiometry_left_bone_conduction_3000" placeholder="0"
                                                :error="'audiometry_left_bone_conduction_3000'" />
                                        </div>
                                    </div><!-- /.form-group ac_kanan -->

                                    <div class="mb-5 row form-group">
                                        <div class="col">
                                            <label for="audiometry_left_bone_conduction_4000"
                                                class="col col-form-label">4000</label>
                                            <x-inputs.number wire:model="audiometry_left_bone_conduction_4000"
                                                id="audiometry_left_bone_conduction_4000" placeholder="0"
                                                :error="'audiometry_left_bone_conduction_4000'" />
                                        </div>
                                        <div class="col">
                                            <label for="audiometry_left_bone_conduction_6000"
                                                class="col col-form-label">6000</label>
                                            <x-inputs.number wire:model="audiometry_left_bone_conduction_6000"
                                                id="audiometry_left_bone_conduction_6000" placeholder="0"
                                                :error="'audiometry_left_bone_conduction_6000'" />
                                        </div>
                                        <div class="col">
                                            <label for="audiometry_left_bone_conduction_8000"
                                                class="col col-form-label">8000</label>
                                            <x-inputs.number wire:model="audiometry_left_bone_conduction_8000"
                                                id="audiometry_left_bone_conduction_8000" placeholder="0"
                                                :error="'audiometry_left_bone_conduction_8000'" />
                                        </div>
                                        <div class="col">
                                            <label for="audiometry_left_bone_conduction_htl"
                                                class="col col-form-label">HTL</label>
                                            <x-inputs.number wire:model="audiometry_left_bone_conduction_htl"
                                                id="audiometry_left_bone_conduction_htl" placeholder="0"
                                                :error="'audiometry_left_bone_conduction_htl'" />
                                        </div>
                                    </div><!-- /.form-group ac_kiri -->

                                    <div class="mb-3 row form-group">
                                        <label for="audiometry_conclusion"
                                            class="col col-form-label">Kesimpulan</label>
                                        <div class="col-8">
                                            <x-inputs.text wire:model="audiometry_conclusion"
                                                id="audiometry_conclusion" rows="7" placeholder=""
                                                :error="'audiometry_conclusion'" />
                                        </div>
                                    </div><!-- /.form-group audiometry_conclusion -->

                                    <div class="mb-3 row form-group">
                                        <label for="audiometry_impression" class="col col-form-label">Kesan</label>
                                        <div class="col-8">
                                            <x-inputs.select2 wire:model="audiometry_impression"
                                                id="audiometry_impression" class="form-select"
                                                placeholder="Select result">
                                                <option value="Normal">Normal</option>
                                                <option value="Mild">Mild</option>
                                                <option value="Tidak Normal">Tidak Normal</option>
                                            </x-inputs.select2>
                                        </div>
                                    </div><!-- /.form-group audiometry_impression -->

                                </div><!-- /.content-section -->
                            </div><!-- /.wrapper-content-accordion -->
                        </div><!-- /.audiometri -->

                        <!-- Spirometri Accordion -->
                        <div id="spirometri" class="section-spirometri" x-data="{ accordionOpen: true }">
                            <button
                                class="header-accordion d-flex justify-content-between w-100 border-0 bg-white py-3 px-0"
                                @click.prevent="accordionOpen = ! accordionOpen">
                                <h6 class="mb-0 fw-normal title-accordion">Spirometri</h6>
                                <span x-bind:class="accordionOpen ? 'open' : ''"><img
                                        src="{{ asset('/images/icons/angle-down.png') }}" alt="" /></span>
                            </button>
                            <div class="wrapper-content-accordion max-h-0 overflow-hidden position-relative transition-all duration-700"
                                x-ref="karyawan"
                                x-bind:style="accordionOpen ? 'max-height: ' + $refs.karyawan.scrollHeight + 'px' : ''">

                                <div class="content-section p-4">

                                    <div class="mb-3 row form-group">
                                        <label for="spirometry_fvc" class="col col-form-label">FVC</label>
                                        <div class="col-8">
                                            <x-inputs.number wire:model="spirometry_fvc" id="spirometry_fvc"
                                                placeholder="0" value="0" :error="'spirometry_fvc'" />
                                        </div>
                                    </div><!-- /.form-group spirometry_fvc -->

                                    <div class="mb-3 row form-group">
                                        <label for="spirometry_fev1" class="col col-form-label">FEV1</label>
                                        <div class="col-8">
                                            <x-inputs.number wire:model="spirometry_fev1" id="spirometry_fev1"
                                                placeholder="0" value="0" :error="'spirometry_fev1'" />
                                        </div>
                                    </div><!-- /.form-group spirometry_fev1 -->

                                    <div class="mb-3 row form-group">
                                        <label for="spirometry_impression" class="col col-form-label">Kesan</label>
                                        <div class="col-8">
                                            <x-inputs.select2 wire:model="spirometry_impression"
                                                id="spirometry_impression" class="form-select"
                                                placeholder="Select result">
                                                <option value="Normal">Normal</option>
                                                <option value="Restriksi Ringan">Restriksi Ringan</option>
                                                <option value="Restriksi Sedang">Restriksi Sedang</option>
                                                <option value="Berat">Berat</option>
                                            </x-inputs.select2>
                                        </div>
                                    </div><!-- /.form-group spirometry_impression -->

                                </div><!-- /.content-section -->
                            </div><!-- /.wrapper-content-accordion -->
                        </div><!-- /.spirometri -->
                    @endif
                @endif

                <!-- Pemeriksaan Penunjang Accordion -->
                <div id="penunjang" class="section-penunjang" x-data="{ accordionOpen: true }">
                    <button class="header-accordion d-flex justify-content-between w-100 border-0 bg-white py-3 px-0"
                        @click.prevent="accordionOpen = ! accordionOpen">
                        <h6 class="mb-0 fw-normal title-accordion">Pemeriksaan Penunjang</h6>
                        <span x-bind:class="accordionOpen ? 'open' : ''"><img
                                src="{{ asset('/images/icons/angle-down.png') }}" alt="" /></span>
                    </button>
                    <div class="wrapper-content-accordion max-h-0 overflow-hidden position-relative transition-all duration-700"
                        x-ref="karyawan"
                        x-bind:style="accordionOpen ? 'max-height: ' + $refs.karyawan.scrollHeight + 'px' : ''">
                        <div class="content-section p-4">

                            <div class="mb-3 row form-group">
                                <label for="xray_thorax" class="col col-form-label">X-RAY THORAX</label>
                                <div class="col-8">
                                    <x-inputs.select2_multiple wire:model="xray_thorax" id="xray_thorax"
                                        class="form-select" placeholder="Select result" multiple>
                                        <option value="Normal">Normal</option>
                                        <option value="Cardiomegali">Cardiomegali</option>
                                        <option value="Bronkopneumoni">Bronkopneumoni</option>
                                        <option value="TB Paru">TB Paru</option>
                                        <option value="PPOK">PPOK</option>
                                        <option value="Pneumotorax">Pneumotorax</option>
                                        <option value="Efusi Pleura">Efusi Pleura</option>
                                        <option value="Masa Paru">Masa Paru</option>
                                        <option value="Abses Paru">Abses Paru</option>
                                        <option value="Fraktur">Fraktur</option>
                                        <option value="Elongasi Aorta">Elongasi Aorta</option>
                                    </x-inputs.select2_multiple>
                                </div>
                            </div><!-- /.form-group xray_thorax -->

                            <div class="mb-3 row form-group">
                                <label for="ekg" class="col col-form-label">EKG</label>
                                <div class="col-8">
                                    <x-inputs.select2_multiple wire:model="ekg" id="ekg" class="form-select"
                                        placeholder="Select result" multiple>
                                        <option value="Sinus Ritme">Sinus Ritme</option>
                                        <option value="Sinus Aritmia">Sinus Aritmia</option>
                                        <option value="Sinus Takikardia">Sinus Takikardia</option>
                                        <option value="Sinus Bradikardia">Sinus Bradikardia</option>
                                        <option value="LVH">LVH</option>
                                        <option value="RVH">RVH</option>
                                        <option value="STEMI">STEMI</option>
                                        <option value="T-Inverted">T-Inverted</option>
                                        <option value="RBBB">RBBB</option>
                                        <option value="LBBB">LBBB</option>
                                    </x-inputs.select2_multiple>
                                </div>
                            </div><!-- /.form-group ekg -->

                            @if ($employee_age > 40)
                                <div class="mb-3 row form-group">
                                    <label for="treadmill" class="col d-flex gap-3 align-items-center">
                                        <span class="col-form-label pb-0 lh-sm">Treadmill</span>
                                        <span
                                            class="icon-tooltip"
                                            x-data="{tooltip:false}"
                                            x-on:mouseover="tooltip = true"
                                            x-on:mouseleave="tooltip = false"
                                        >
                                            <i class="fa-solid fa-circle-question pt-2 text-info"></i>
                                            <div class="tooltip-content" x-show="tooltip">Usia >40 tahun wajib mengikuti treadmill test</div>
                                        </span>
                                    </label>
                                    <div class="col-8">
                                        <x-inputs.select2 wire:model="treadmill" id="treadmill"
                                            class="form-select" placeholder="Select result">
                                            <option value="Negative">Negative</option>
                                            <option value="Ischemic">Ischemic</option>
                                            <option value="Response">Response</option>
                                        </x-inputs.select2>
                                    </div>
                                </div><!-- /.form-group treadmill -->

                                <div class="mb-3 row form-group">
                                    <label for="echocardiography"
                                        class="col col-form-label">ECHOCARDIOGRAPHY</label>
                                    <div class="col-8">
                                        <x-inputs.text wire:model="echocardiography" id="echocardiography"
                                            rows="7" placeholder="" :error="'echocardiography'" />
                                    </div>
                                </div><!-- /.form-group echocardiography -->

                                <div class="mb-3 row form-group">
                                    {{-- <label for="additional_diagnosis" class="col d-flex flex-column">
                                        <span class="col-form-label pb-0 lh-sm">Additional Diagnosis</span>
                                        <span class="opacity-50 lh-sm">post Cardiologist evaluation</span>
                                    </label> --}}
                                    <label for="additional_diagnosis" class="col d-flex gap-3 align-items-center">
                                        <span class="col-form-label pb-0 lh-sm">Additional Diagnosis</span>
                                        {{-- <span class="opacity-50 lh-sm">post Cardiologist evaluation</span> --}}
                                        <span
                                            class="icon-tooltip"
                                            x-data="{tooltip:false}"
                                            x-on:mouseover="tooltip = true"
                                            x-on:mouseleave="tooltip = false"
                                        >
                                            <i class="fa-solid fa-circle-question pt-2 text-info"></i>
                                            <div class="tooltip-content" x-show="tooltip">Additional Diagnosis Tooltip</div>
                                        </span>
                                    </label>
                                    <div class="col-8">
                                        <x-inputs.text wire:model="additional_diagnosis" id="additional_diagnosis"
                                            rows="7" placeholder="" :error="'additional_diagnosis'" />
                                    </div>
                                </div><!-- /.form-group additional_diagnosis -->
                            @endif

                        </div><!-- /.content-section -->
                    </div><!-- /.wrapper-content-accordion -->
                </div><!-- /.penunjang -->

                <!-- Laboratorium Accordion -->
                <div id="lab" class="section-lab" x-data="{ accordionOpen: true }">
                    <button class="header-accordion d-flex justify-content-between w-100 border-0 bg-white py-3 px-0"
                        @click.prevent="accordionOpen = ! accordionOpen">
                        <h6 class="mb-0 fw-normal title-accordion">Laboratorium</h6>
                        <span x-bind:class="accordionOpen ? 'open' : ''"><img
                                src="{{ asset('/images/icons/angle-down.png') }}" alt="" /></span>
                    </button>
                    <div class="wrapper-content-accordion max-h-0 overflow-hidden position-relative transition-all duration-700"
                        x-ref="karyawan"
                        x-bind:style="accordionOpen ? 'max-height: ' + $refs.karyawan.scrollHeight + 'px' : ''">
                        <div class="content-section p-4">
                            <h6 class="fw-normal mb-3">Complete Blood Count</h6>

                            <div class="mb-3 row form-group">
                                <div class="col">
                                    <label for="blood_hb" class="col col-form-label">Hb</label>
                                    <x-inputs.number wire:model="blood_hb" id="blood_hb" placeholder="0/0"
                                        :error="'blood_hb'" />
                                </div>
                                <div class="col">
                                    <label for="blood_ht" class="col col-form-label">Ht</label>
                                    <x-inputs.number wire:model="blood_ht" id="blood_ht" placeholder="0/0"
                                        :error="'blood_ht'" />
                                </div>
                                <div class="col">
                                    <label for="blood_leukosit" class="col col-form-label">Leukosit</label>
                                    <x-inputs.number wire:model="blood_leukosit" id="blood_leukosit"
                                        placeholder="0/0" :error="'blood_leukosit'" />
                                </div>
                                <div class="col">
                                    <label for="blood_thrombosit" class="col col-form-label">Thrombosit</label>
                                    <x-inputs.number wire:model="blood_thrombosit" id="blood_thrombosit"
                                        placeholder="0/0" :error="'blood_thrombosit'" />
                                </div>
                            </div><!-- /.form-group blood_hb, blood_ht -->

                            <div class="mb-5 row form-group">
                                <div class="col-3">
                                    <label for="blood_eritrosit" class="col col-form-label">Eritrosit</label>
                                    <x-inputs.number wire:model="blood_eritrosit" id="blood_eritrosit"
                                        placeholder="0/0" :error="'blood_eritrosit'" />
                                </div>
                                <div class="col-3">
                                    <label for="blood_led" class="col col-form-label">LED</label>
                                    <x-inputs.number wire:model="blood_led" id="blood_led" placeholder="0/0"
                                        :error="'blood_led'" />
                                </div>
                            </div><!-- /.form-group non koreksi -->

                            <h6 class="fw-normal mb-3">Blood Group</h6>

                            <div class="mb-3 row form-group">
                                <div class="col-3">
                                    <label for="blood_type" class="col col-form-label">Golongan Darah</label>
                                    <x-inputs.select2 wire:model="blood_type" id="blood_type" class="form-select"
                                        placeholder="Pilih Golongan Darah">
                                        <option id="blood_type-1"
                                            value="{{ App\Enums\MCU\BloodType::A()->value }}">
                                            {{ App\Enums\MCU\BloodType::A()->description }}</option>

                                        <option id="blood_type-2"
                                            value="{{ App\Enums\MCU\BloodType::B()->value }}">
                                            {{ App\Enums\MCU\BloodType::B()->description }}</option>

                                        <option id="blood_type-3"
                                            value="{{ App\Enums\MCU\BloodType::AB()->value }}">
                                            {{ App\Enums\MCU\BloodType::AB()->description }}</option>

                                        <option id="blood_type-4"
                                            value="{{ App\Enums\MCU\BloodType::O()->value }}">
                                            {{ App\Enums\MCU\BloodType::O()->description }}</option>
                                    </x-inputs.select2>
                                </div>

                                <div class="col-3">
                                    <label for="blood_rhesus" class="col col-form-label">Rhesus</label>
                                    <x-inputs.select2 wire:model="blood_rhesus" id="blood_rhesus"
                                        class="form-select" placeholder="Pilih">
                                        <option value="plus">Plus</option>
                                        <option value="negative">Negative</option>
                                    </x-inputs.select2>
                                </div>

                            </div><!-- /.form-group blood_type -->

                            <h6 class="fw-normal mb-3">Fungsi Hati</h6>

                            <div class="mb-5 row form-group">
                                <div class="col">
                                    <label for="blood_sgot" class="col col-form-label">SGOT</label>
                                    <x-inputs.number wire:model="blood_sgot" id="blood_sgot" placeholder="0"
                                        :error="'blood_sgot'" />
                                </div>
                                <div class="col">
                                    <label for="blood_sgpt" class="col col-form-label">SGPT</label>
                                    <x-inputs.number wire:model="blood_sgpt" id="blood_sgpt" placeholder="0"
                                        :error="'blood_sgpt'" />
                                </div>
                                <div class="col">
                                    <label for="blood_gamma_gt" class="col col-form-label">Gamma GT</label>
                                    <x-inputs.number wire:model="blood_gamma_gt" id="blood_gamma_gt"
                                        placeholder="0" :error="'blood_gamma_gt'" />
                                </div>
                            </div><!-- /.form-group fungsi hati -->

                            <h6 class="fw-normal mb-3">Profil Lipid</h6>

                            <div class="mb-3 row form-group required">
                                <div class="col">
                                    <label for="blood_hdl" class="col col-form-label">HDL</label>
                                    <x-inputs.number wire:model="blood_hdl" id="blood_hdl" placeholder="0"
                                        :error="'blood_hdl'" />
                                </div>
                                <div class="col">
                                    <label for="blood_ldl" class="col col-form-label">LDL</label>
                                    <x-inputs.number wire:model="blood_ldl" {{-- wire:change="DislipidemiaStatus()" --}}
                                        {{-- wire:change="RiskScore({{ $blood_cholesterol_total }})" --}} wire:change="RiskScore()" id="blood_ldl"
                                        placeholder="0" :error="'blood_ldl'" />
                                </div>
                                <div class="col">
                                    <label for="blood_cholesterol_total" class="col col-form-label">Kolesterol
                                        Total</label>
                                    <x-inputs.number wire:model="blood_cholesterol_total"
                                        id="blood_cholesterol_total" placeholder="Autocalculation"
                                        :error="'blood_cholesterol_total'" value="{{ $blood_cholesterol_total }}" disabled />
                                </div>
                                <div class="col">
                                    <label for="blood_tga" class="col col-form-label">TGA</label>
                                    <x-inputs.number wire:model="blood_tga" wire:change="DislipidemiaStatus()"
                                        id="blood_tga" placeholder="0" :error="'blood_tga'" />
                                </div>
                            </div><!-- /.form-group blood_cholesterol_total -->

                            <div class="mb-5 row form-group">
                                <div class="col-3">
                                    <label for="blood_billirubin_total" class="col col-form-label">Billirubin
                                        Total</label>
                                    <x-inputs.number wire:model="blood_billirubin_total" id="blood_billirubin_total"
                                        placeholder="0" :error="'blood_billirubin_total'" />
                                </div>
                                <div class="col-3">
                                    <label for="blood_billirubin_direk" class="col col-form-label">Billirubin
                                        direk</label>
                                    <x-inputs.number wire:model="blood_billirubin_direk" id="blood_billirubin_direk"
                                        placeholder="0" :error="'blood_billirubin_direk'" />
                                </div>
                                <div class="col-3">
                                    <label for="blood_billirubin_indirek" class="col col-form-label">Billirubin
                                        indirek</label>
                                    <x-inputs.number wire:model="blood_billirubin_indirek"
                                        id="blood_billirubin_indirek" placeholder="0" :error="'blood_billirubin_indirek'" />
                                </div>
                                <div class="col-3">
                                    <label for="blood_dislipidemia" class="col col-form-label">Status
                                        Dislipidemia</label>
                                    <x-inputs.text wire:model="blood_dislipidemia" id="blood_dislipidemia"
                                        placeholder="Autocalculation" :error="'blood_dislipidemia'"
                                        value="{{ $blood_dislipidemia }}" disabled />
                                </div>
                            </div><!-- /.form-group billirubin -->

                            <h6 class="fw-normal mb-3">Glukosa Darah</h6>

                            <div class="mb-3 row form-group">
                                <div class="col">
                                    <label for="blood_gdpt" class="col col-form-label">GDPt</label>
                                    <x-inputs.number wire:model="blood_gdpt" id="blood_gdpt" placeholder="0"
                                        :error="'blood_gdpt'" />
                                </div>
                                <div class="col">
                                    <label for="blood_g2pp" class="col col-form-label">G2PP</label>
                                    <x-inputs.number wire:model="blood_g2pp" wire:change="HiperglikemiaStatus()"
                                        id="blood_g2pp" placeholder="0" :error="'blood_g2pp'" />
                                </div>
                                <div class="col">
                                    <label for="blood_hyperglycemic"
                                        class="col col-form-label">HIPERGLIKEMIA</label>
                                    <x-inputs.text wire:model="blood_hyperglycemic" id="blood_hyperglycemic"
                                        placeholder="Autocalculation" :error="'blood_hyperglycemic'"
                                        value="{{ $blood_hyperglycemic }}" disabled />
                                    {{-- <small class="warning">*Autocalc</small> --}}
                                </div>
                                <div class="col">
                                    <label for="blood_hba1c" class="col col-form-label">HbA1C</label>
                                    <x-inputs.number wire:model="blood_hba1c" id="blood_hba1c" placeholder="0"
                                        :error="'blood_hba1c'" />
                                </div>
                            </div><!-- /.form-group -->

                            <div class="mb-5 row form-group">
                                <div class="col-3">
                                    <label for="blood_dm_status" class="col col-form-label">Status DM</label>
                                    <x-inputs.text wire:model="blood_dm_status" id="blood_dm_status"
                                        placeholder="0" :error="'blood_dm_status'" />
                                </div>
                            </div><!-- /.form-group Glukosa Darah -->

                            <h6 class="fw-normal mb-3">Framingham Risk</h6>
                            <div class="mb-5 row form-group">
                                <div class="col-3">
                                    <label for="framingham_score" class="col col-form-label">SCORE</label>
                                    <x-inputs.text wire:model="framingham_score" id="framingham_score"
                                        placeholder="Autocalculation" :error="'framingham_score'"
                                        value="{{ $framingham_score }}" disabled />
                                </div>
                                <div class="col-3">
                                    <label for="frammingham_risk_level" class="col col-form-label">RISK
                                        LEVEL</label>
                                    <x-inputs.text wire:model="frammingham_risk_level" id="frammingham_risk_level"
                                        placeholder="Autocalculation" :error="'frammingham_risk_level'"
                                        value="{{ $frammingham_risk_level }}" disabled />
                                </div>
                            </div><!-- /.form-group Framingham Risk -->

                            <h6 class="fw-normal mb-3">Jakarta Cardiovascular</h6>
                            <div class="mb-5 row form-group">
                                <div class="col-3">
                                    <label for="jakarta_cardiovascular_score"
                                        class="col col-form-label">SCORE</label>
                                    <x-inputs.text wire:model="jakarta_cardiovascular_score"
                                        id="jakarta_cardiovascular_score" placeholder="Autocalculation"
                                        :error="'jakarta_cardiovascular_score'" value="{{ $jakarta_cardiovascular_score }}" disabled />
                                </div>
                                <div class="col-3">
                                    <label for="jakarta_cardiovascular_risk_level" class="col col-form-label">RISK
                                        LEVEL</label>
                                    <x-inputs.text wire:model="jakarta_cardiovascular_risk_level"
                                        id="jakarta_cardiovascular_risk_level" placeholder="Autocalculation"
                                        :error="'jakarta_cardiovascular_risk_level'" value="{{ $jakarta_cardiovascular_risk_level }}"
                                        disabled />
                                </div>
                            </div><!-- /.form-group Jakarta Cardiovascular -->

                            <h6 class="fw-normal mb-3">Fungsi Ginjal</h6>

                            <div class="mb-3 row form-group">
                                <div class="col">
                                    <label for="laboratory_ureum" class="col col-form-label">Ureum</label>
                                    <x-inputs.number wire:model="laboratory_ureum" id="laboratory_ureum"
                                        placeholder="0" :error="'laboratory_ureum'" />
                                </div>
                                <div class="col">
                                    <label for="laboratory_bun" class="col col-form-label">BUN</label>
                                    <x-inputs.number wire:model="laboratory_bun" id="laboratory_bun"
                                        placeholder="0" :error="'laboratory_bun'" />
                                </div>
                                <div class="col">
                                    <label for="laboratory_creatinin" class="col col-form-label">Creatinin</label>
                                    <x-inputs.number wire:model="laboratory_creatinin"
                                        wire:change="eGFR({{ $weight }},{{ $laboratory_creatinin }})"
                                        id="laboratory_creatinin" placeholder="Input" :error="'laboratory_creatinin'" />
                                </div>
                                <div class="col">
                                    <label for="laboratory_uric_acid" class="col col-form-label">Asam
                                        urat</label>
                                    <x-inputs.number wire:model="laboratory_uric_acid" id="laboratory_uric_acid"
                                        placeholder="0" :error="'laboratory_uric_acid'" />
                                </div>
                            </div><!-- /.form-group -->

                            <div class="mb-5 row form-group">
                                <div class="col-3">
                                    <label for="laboratory_uric_egfr" class="col col-form-label">eGFR</label>
                                    <x-inputs.text wire:model="laboratory_uric_egfr" id="laboratory_uric_egfr"
                                        placeholder="0" :error="'laboratory_uric_egfr'" value="{{ $laboratory_uric_egfr }}"
                                        disabled />
                                </div>
                            </div><!-- /.form-group Fungsi Ginjal -->

                            <h6 class="fw-normal mb-3">Imunoserologi</h6>
                            <div class="mb-5 row form-group">

                                @if ($employee_age <= 55)
                                    <div class="col-3">
                                        <label for="laboratory_hbsag" class="col col-form-label">HBs-Ag</label>
                                        <x-inputs.select2 wire:model="laboratory_hbsag" id="laboratory_hbsag"
                                            class="form-select" placeholder="Pilih">
                                            <option value="Reaktif">Reaktif</option>
                                            <option value="Non Reaktif">Non Reaktif</option>
                                            <option value="Negatif">Negatif</option>
                                        </x-inputs.select2>
                                    </div>
                                    <div class="col-3">
                                        <label for="laboratory_anti_hbs" class="col col-form-label">Anti
                                            HBs</label>
                                        <x-inputs.select2 wire:model="laboratory_anti_hbs" id="laboratory_anti_hbs"
                                            class="form-select" placeholder="Pilih">
                                            <option value="Reaktif">Reaktif</option>
                                            <option value="Non Reaktif">Non Reaktif</option>
                                            <option value="Negatif">Negatif</option>
                                        </x-inputs.select2>
                                    </div>
                                @endif

                                @if ($medical_ex_type == 'office-group' && $medical_type == 'pre-employment')
                                @endif

                                @if ($employee_age <= 55)
                                    @if (
                                        ($medical_ex_type == 'food-handler' && $medical_type != 'pre-retirement') ||
                                            ($medical_ex_type == 'general-housekeeping' && $medical_type != 'pre-retirement'))
                                        <div class="col-3">
                                            <label for="laboratory_anti_havlgm" class="col col-form-label">Anti HAV
                                                IgM</label>
                                            <x-inputs.select2 wire:model="laboratory_anti_havlgm"
                                                id="laboratory_anti_havlgm" class="form-select"
                                                placeholder="Pilih">
                                                <option value="Reaktif">Reaktif</option>
                                                <option value="Non Reaktif">Non Reaktif</option>
                                                <option value="Negatif">Negatif</option>
                                            </x-inputs.select2>
                                        </div>
                                    @endif
                                    @if ($medical_ex_type == 'food-handler')
                                        <div class="col-3">
                                            <label for="laboratory_widal" class="col col-form-label">Widal</label>
                                            <x-inputs.select2 wire:model="laboratory_widal" id="laboratory_widal"
                                                class="form-select" placeholder="Pilih">
                                                <option value="Reaktif">Reaktif</option>
                                                <option value="Non Reaktif">Non Reaktif</option>
                                                <option value="Negatif">Negatif</option>
                                                <option value="Positif">Positif</option>
                                            </x-inputs.select2>
                                        </div>
                                    @endif
                                @endif

                            </div><!-- /.form-group Imunoserologi -->

                            @if ($employee_age <= 55)
                                <h6 class="fw-normal mb-3">Malaria</h6>
                                <div class="mb-3 row form-group">
                                    <div class="col-3">
                                        <label for="laboratory_malary" class="col col-form-label">Malaria</label>
                                        <x-inputs.select2 wire:model="laboratory_malary" id="laboratory_malary"
                                            class="form-select" placeholder="Pilih">
                                            <option value="Negatif">Negatif</option>
                                            <option value="Positif">Positif</option>
                                        </x-inputs.select2>
                                    </div>
                                </div><!-- /.form-group Malaria -->
                            @endif

                            <h6 class="fw-normal mb-3">Urine Analisis Makroskopis</h6>
                            <div class="mb-3 row form-group">
                                <div class="col-3">
                                    <label for="laboratory_urinalysis_color"
                                        class="col col-form-label">Warna</label>
                                    <x-inputs.select2 wire:model="laboratory_urinalysis_color"
                                        id="laboratory_urinalysis_color" class="form-select"
                                        placeholder="Pilih warna">
                                        <option value="kuning">Kuning</option>
                                        <option value="putih">Putih</option>
                                        <option value="merah">Merah</option>
                                    </x-inputs.select2>
                                </div>
                                <div class="col-3">
                                    <label for="laboratory_urinalysis_clarity"
                                        class="col col-form-label">Kejernihan</label>
                                    <x-inputs.select2 wire:model="laboratory_urinalysis_clarity"
                                        id="laboratory_urinalysis_clarity" class="form-select"
                                        placeholder="Pilih kejernihan">
                                        <option value="jernih">Jernih</option>
                                        <option value="keruh">Keruh</option>
                                        <option value="merah">Merah</option>
                                    </x-inputs.select2>
                                </div>
                                <div class="col-3">
                                    <label for="laboratory_urinalysis_ph" class="col col-form-label">pH</label>
                                    <x-inputs.number wire:model="laboratory_urinalysis_ph"
                                        id="laboratory_urinalysis_ph" placeholder="0" :error="'laboratory_urinalysis_ph'" />
                                </div>
                                <div class="col-3">
                                    <label for="laboratory_urinalysis_density" class="col col-form-label">Berat
                                        Jenis</label>
                                    <x-inputs.number wire:model="laboratory_urinalysis_density"
                                        id="laboratory_urinalysis_density" placeholder="0" :error="'laboratory_urinalysis_density'" />
                                </div>
                            </div><!-- /.form-group Urine warna, ph, berat jenis -->

                            <div class="mb-3 row form-group">
                                <div class="col-3">
                                    <label for="laboratory_urinalysis_protein"
                                        class="col col-form-label">Protein</label>
                                    <x-inputs.select2 wire:model="laboratory_urinalysis_protein"
                                        id="laboratory_urinalysis_protein" class="form-select"
                                        placeholder="Pilih">
                                        <option value="Negatif">Negatif</option>
                                        <option value="Positif">Positif</option>
                                    </x-inputs.select2>
                                </div>
                                <div class="col-3">
                                    <label for="laboratory_urinalysis_glucose"
                                        class="col col-form-label">Glukosa</label>
                                    <x-inputs.select2 wire:model="laboratory_urinalysis_glucose"
                                        id="laboratory_urinalysis_glucose" class="form-select"
                                        placeholder="Pilih">
                                        <option value="Negatif">Negatif</option>
                                        <option value="Positif">Positif</option>
                                    </x-inputs.select2>
                                </div>
                                <div class="col-3">
                                    <label for="laboratory_urinalysis_billirubin"
                                        class="col col-form-label">Bilirubin</label>
                                    <x-inputs.select2 wire:model="laboratory_urinalysis_billirubin"
                                        id="laboratory_urinalysis_billirubin" class="form-select"
                                        placeholder="Pilih">
                                        <option value="Negatif">Negatif</option>
                                        <option value="Positif">Positif</option>
                                    </x-inputs.select2>
                                </div>
                                <div class="col-3">
                                    <label for="laboratory_urinalysis_urobillin"
                                        class="col col-form-label">Urobilinogen/Urobilin</label>
                                    <x-inputs.select2 wire:model="laboratory_urinalysis_urobillin"
                                        id="laboratory_urinalysis_urobillin" class="form-select"
                                        placeholder="Pilih">
                                        <option value="Normal">Normal</option>
                                        <option value="Tidak Normal">Tidak Normal</option>
                                    </x-inputs.select2>
                                </div>
                            </div><!-- /.form-group Urine protein, glukosa, billirubin -->

                            <div class="mb-5 row form-group">
                                <div class="col-3">
                                    <label for="laboratory_urinalysis_keton"
                                        class="col col-form-label">Keton</label>
                                    <x-inputs.select2 wire:model="laboratory_urinalysis_keton"
                                        id="laboratory_urinalysis_keton" class="form-select"
                                        placeholder="Pilih">
                                        <option value="Negatif">Negatif</option>
                                        <option value="Positif">Positif</option>
                                    </x-inputs.select2>
                                </div>
                                <div class="col-3">
                                    <label for="laboratory_urinalysis_blood"
                                        class="col col-form-label">Darah</label>
                                    <x-inputs.select2 wire:model="laboratory_urinalysis_blood"
                                        id="laboratory_urinalysis_blood" class="form-select"
                                        placeholder="Pilih">
                                        <option value="Negatif">Negatif</option>
                                        <option value="Positif">Positif</option>
                                    </x-inputs.select2>
                                </div>
                                <div class="col-3">
                                    <label for="laboratory_urinalysis_lekositesterase"
                                        class="col col-form-label">Lekositesterase</label>
                                    <x-inputs.select2 wire:model="laboratory_urinalysis_lekositesterase"
                                        id="laboratory_urinalysis_lekositesterase" class="form-select"
                                        placeholder="Pilih">
                                        <option value="Negatif">Negatif</option>
                                        <option value="Positif">Positif</option>
                                    </x-inputs.select2>
                                </div>
                                <div class="col-3">
                                    <label for="laboratory_urinalysis_nitrit"
                                        class="col col-form-label">Nitrit</label>
                                    <x-inputs.select2 wire:model="laboratory_urinalysis_nitrit"
                                        id="laboratory_urinalysis_nitrit" class="form-select"
                                        placeholder="Pilih">
                                        <option value="Negatif">Negatif</option>
                                        <option value="Positif">Positif</option>
                                    </x-inputs.select2>
                                </div>
                            </div><!-- /.form-group Urine keton, darah, nitrit -->

                            <h6 class="fw-normal mb-3">Urine Analisis Mikroskopis</h6>
                            <div class="mb-3 row form-group">
                                <div class="col-3">
                                    <label for="laboratory_urinalysis_leukocyte_sediment"
                                        class="col col-form-label">Sedimen
                                        Leukosit</label>
                                    <x-inputs.number wire:model="laboratory_urinalysis_leukocyte_sediment"
                                        id="laboratory_urinalysis_leukocyte_sediment" placeholder="0"
                                        :error="'laboratory_urinalysis_leukocyte_sediment'" />
                                </div>
                                <div class="col-3">
                                    <label for="laboratory_urinalysis_erythrocyte"
                                        class="col col-form-label">Eritrosit</label>
                                    <x-inputs.number wire:model="laboratory_urinalysis_erythrocyte"
                                        id="laboratory_urinalysis_erythrocyte" placeholder="0"
                                        :error="'laboratory_urinalysis_erythrocyte'" />
                                </div>
                                <div class="col-3">
                                    <label for="laboratory_urinalysis_epitel"
                                        class="col col-form-label">Epitel</label>
                                    <x-inputs.number wire:model="laboratory_urinalysis_epitel"
                                        id="laboratory_urinalysis_epitel" placeholder="0" :error="'laboratory_urinalysis_epitel'" />
                                </div>
                                <div class="col-3">
                                    <label for="laboratory_urinalysis_cylinder"
                                        class="col col-form-label">Silinder</label>
                                    <x-inputs.select2 wire:model="laboratory_urinalysis_cylinder"
                                        id="laboratory_urinalysis_cylinder" class="form-select"
                                        placeholder="Pilih">
                                        <option value="Negatif">Negatif</option>
                                        <option value="Positif">Positif</option>
                                    </x-inputs.select2>
                                </div>
                            </div><!-- /.form-group Urine sediman, eritrosit, epitel -->

                            <div class="mb-5 row form-group">
                                <div class="col-3">
                                    <label for="laboratory_urinalysis_crystal"
                                        class="col col-form-label">Kristal</label>
                                    <x-inputs.select2 wire:model="laboratory_urinalysis_crystal"
                                        id="laboratory_urinalysis_crystal" class="form-select"
                                        placeholder="Pilih">
                                        <option value="Negatif">Negatif</option>
                                        <option value="Positif">Positif</option>
                                    </x-inputs.select2>
                                </div>
                                <div class="col-3">
                                    <label for="laboratory_urinalysis_bacteria"
                                        class="col col-form-label">Bakteri</label>
                                    <x-inputs.select2 wire:model="laboratory_urinalysis_bacteria"
                                        id="laboratory_urinalysis_bacteria" class="form-select"
                                        placeholder="Pilih">
                                        <option value="Negatif">Negatif</option>
                                        <option value="Positif">Positif</option>
                                    </x-inputs.select2>
                                </div>
                            </div><!-- /.form-group Urine kristal, bakteri -->

                            <div class="mb-5 row form-group">
                                <div class="col">
                                    <label for="laboratory_urinalysis_etc" class="col-form-label">Lainnya</label>
                                    <x-inputs.textarea wire:model="laboratory_urinalysis_etc"
                                        id="laboratory_urinalysis_etc" rows="7" placeholder=""
                                        :error="'laboratory_urinalysis_etc'" />
                                </div>
                            </div><!-- /.form-group laboratory_urinalysis_etc -->

                            @if ($employee_age <= 55)
                                <h6 class="fw-normal mb-3">Drug Test</h6>
                                <div class="mb-3 row form-group">
                                    <div class="col-3">
                                        <label for="laboratory_urinalysis_amp"
                                            class="col col-form-label">AMP</label>
                                        <x-inputs.select2 wire:model="laboratory_urinalysis_amp"
                                            id="laboratory_urinalysis_amp" class="form-select"
                                            placeholder="Pilih">
                                            <option value="Negatif">Negatif</option>
                                            <option value="Positif">Positif</option>
                                        </x-inputs.select2>
                                    </div>
                                    <div class="col-3">
                                        <label for="laboratory_urinalysis_met"
                                            class="col col-form-label">MET</label>
                                        <x-inputs.select2 wire:model="laboratory_urinalysis_met"
                                            id="laboratory_urinalysis_met" class="form-select"
                                            placeholder="Pilih">
                                            <option value="Negatif">Negatif</option>
                                            <option value="Positif">Positif</option>
                                        </x-inputs.select2>
                                    </div>
                                    <div class="col-3">
                                        <label for="laboratory_urinalysis_bdz"
                                            class="col col-form-label">BDZ</label>
                                        <x-inputs.select2 wire:model="laboratory_urinalysis_bdz"
                                            id="laboratory_urinalysis_bdz" class="form-select"
                                            placeholder="Pilih">
                                            <option value="Negatif">Negatif</option>
                                            <option value="Positif">Positif</option>
                                        </x-inputs.select2>
                                    </div>
                                    <div class="col-3">
                                        <label for="laboratory_urinalysis_coc"
                                            class="col col-form-label">COC</label>
                                        <x-inputs.select2 wire:model="laboratory_urinalysis_coc"
                                            id="laboratory_urinalysis_coc" class="form-select"
                                            placeholder="Pilih">
                                            <option value="Negatif">Negatif</option>
                                            <option value="Positif">Positif</option>
                                        </x-inputs.select2>
                                    </div>
                                </div><!-- /.form-group AMP, MET, BDZ, COC -->

                                <div class="mb-5 row form-group">
                                    <div class="col-3">
                                        <label for="laboratory_urinalysis_opi"
                                            class="col col-form-label">OPI</label>
                                        <x-inputs.select2 wire:model="laboratory_urinalysis_opi"
                                            id="laboratory_urinalysis_opi" class="form-select"
                                            placeholder="Pilih">
                                            <option value="Negatif">Negatif</option>
                                            <option value="Positif">Positif</option>
                                        </x-inputs.select2>
                                    </div>
                                    <div class="col-3">
                                        <label for="laboratory_urinalysis_thc"
                                            class="col col-form-label">THC</label>
                                        <x-inputs.select2 wire:model="laboratory_urinalysis_thc"
                                            id="laboratory_urinalysis_thc" class="form-select"
                                            placeholder="Pilih">
                                            <option value="Negatif">Negatif</option>
                                            <option value="Positif">Positif</option>
                                        </x-inputs.select2>
                                    </div>
                                </div><!-- /.form-group OPI, THC -->

                                @if (
                                    ($medical_ex_type == 'food-handler' && $medical_type != 'pre-retirement') ||
                                        ($medical_ex_type == 'general-housekeeping' && $medical_type != 'pre-retirement'))
                                    <h6 class="fw-normal mb-3">Feses</h6>
                                    <div class="mb-3 row form-group">
                                        <label for="laboratory_urinalysis_feces_analysis"
                                            class="col-4 d-flex flex-column">
                                            {{-- <span class="col-form-label pb-0 lh-sm">Analisis feses</span> --}}
                                            {{-- <span class="opacity-50 lh-sm">Khusus food handler</span> --}}
                                            <label for="laboratory_urinalysis_feces_analysis" class="col d-flex gap-3 align-items-center">
                                                <span class="col-form-label pb-0 lh-sm">Analisis feses</span>
                                                <span
                                                    class="icon-tooltip"
                                                    x-data="{tooltip:false}"
                                                    x-on:mouseover="tooltip = true"
                                                    x-on:mouseleave="tooltip = false"
                                                >
                                                    <i class="fa-solid fa-circle-question pt-2 text-info"></i>
                                                    <div class="tooltip-content" x-show="tooltip">Khusus food handler</div>
                                                </span>
                                            </label>
                                        </label>
                                        <div class="col-8">

                                            <x-inputs.select2_multiple
                                                wire:model="laboratory_urinalysis_feces_analysis"
                                                id="laboratory_urinalysis_feces_analysis" class="form-select"
                                                placeholder="Select result" multiple>
                                                <option value="Negatif">Negatif</option>
                                                <option value="Darah Positf">Darah Positf</option>
                                                <option value="Lendir Positif">Lendir Positif</option>
                                                <option value="Sel Ragi Positif">Sel Ragi Positif</option>
                                                <option value="Amoeba Positif">Amoeba Positif</option>
                                                <option value="Telur Cacing Positif">Telur Cacing Positif</option>
                                            </x-inputs.select2_multiple>
                                        </div>
                                    </div><!-- /.form-group Analisis feses -->

                                    <div class="mb-3 row form-group">
                                        {{-- <label for="laboratory_urinalysis_feces_culture"
                                            class="col-4 d-flex flex-column">
                                            <span class="col-form-label pb-0 lh-sm">Kultur feses</span>
                                            <span class="opacity-50 lh-sm">Khusus food handler</span>
                                        </label> --}}
                                        <label for="treadmill" class="col d-flex gap-3 align-items-center">
                                            <span class="col-form-label pb-0 lh-sm">Kultur feses</span>
                                            <span
                                                class="icon-tooltip"
                                                x-data="{tooltip:false}"
                                                x-on:mouseover="tooltip = true"
                                                x-on:mouseleave="tooltip = false"
                                            >
                                                <i class="fa-solid fa-circle-question pt-2 text-info"></i>
                                                <div class="tooltip-content" x-show="tooltip">Khusus food handler</div>
                                            </span>
                                        </label>
                                        <div class="col-8">
                                            <x-inputs.text wire:model="laboratory_urinalysis_feces_culture"
                                                id="laboratory_urinalysis_feces_culture" rows="7"
                                                placeholder="" :error="'laboratory_urinalysis_feces_culture'" />
                                        </div>
                                    </div><!-- /.form-group Analisis feses -->
                                @endif
                            @endif

                        </div><!-- /.content-section -->
                    </div><!-- /.wrapper-content-accordion -->
                </div><!-- /.Laboratorium -->

                <!-- Temuan Accordion -->
                {{-- Temuan hanya bisa dilihat oleh dokter ketika submit for review --}}
                {{-- <div id="temuan" class="section-temuan" x-data="{ accordionOpen: true }">

                    <button class="header-accordion d-flex justify-content-between w-100 border-0 bg-white py-3 px-0"
                        @click.prevent="accordionOpen = ! accordionOpen">
                        <h6 class="mb-0 fw-normal title-accordion">Temuan</h6>
                        <span x-bind:class="accordionOpen ? 'open' : ''"><img
                                src="{{ asset('/images/icons/angle-down.png') }}" alt="" /></span>
                    </button>
                    <div class="wrapper-content-accordion max-h-0 overflow-hidden position-relative transition-all duration-700"
                        x-ref="karyawan"
                        x-bind:style="accordionOpen ? 'max-height: ' + $refs.karyawan.scrollHeight + 'px' : ''">
                        <div class="content-section p-4">

                            <div class="mb-3 row form-group">
                                <div class="col">
                                    <label for="findings" class="col-form-label">Hasil Temuan</label>
                                    <x-inputs.text wire:model="findings" id="findings" rows="7"
                                        placeholder="" :error="'findings'" />
                                </div>
                            </div><!-- /.form-group findings -->

                            <div class="mb-3 row form-group">
                                <div class="col">
                                    <label for="amc_matrix_compliance" class="col col-form-label">Kesesuaian
                                        Matrix</label>
                                    <x-inputs.text wire:model="amc_matrix_compliance" id="amc_matrix_compliance"
                                        rows="3" placeholder="" :error="'amc_matrix_compliance'" />
                                </div>
                            </div><!-- /.form-group amc_matrix_compliance -->

                        </div><!-- /.content-section -->
                    </div><!-- /.wrapper-content-accordion -->
                </div><!-- /.temuan --> --}}

                <div class="footer-action mb-2">
                    <div class="action-wrapper d-flex align-items-center justify-content-end gap-2">
                        <a href="{{ route('mcu::medical-staff') }}" class="btn btn-outline-secondary">Cancel</a>
                        {{-- <button type="submit"
                            class="btn btn-outline-default bg-green d-flex justify-content-center align-item-center text-white position-relative px-4">Submit
                            for review</button> --}}

                        <div class="button-document">
                            <button
                                class="dropdown-toggle btn btn-outline-default bg-green d-flex justify-content-center align-item-center text-white position-relative px-4"
                                role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                Submit Action
                            </button>
                            <ul class="dropdown-menu">
                                <li><button type="submit" class="dropdown-item"
                                        wire:click="$set('mode','draft')">Save as draft</button></li>
                                <li><button type="submit" class="dropdown-item"
                                        wire:click="$set('mode','save')">Submit for
                                        review</button></li>
                            </ul>
                        </div>
                    </div>
                </div>

            </form>
        </div><!-- /.section-content -->

        <div class="col-3">
            <div class="section-sidebar-nav position-sticky top-0 py-4">
                <ul>
                    <li><a href="#"
                            @click.prevent="document.getElementById('karyawan').scrollIntoView()">Karyawan</a></li>
                    <li><a href="#"
                            @click.prevent="document.getElementById('anamnesis').scrollIntoView()">Riwayat</a></li>
                    <li><a href="#"
                            @click.prevent="document.getElementById('tanda-vital').scrollIntoView()">Tanda
                            Vital</a>
                    </li>
                    <li><a href="#"
                            @click.prevent="document.getElementById('generalisata').scrollIntoView()">Pemeriksaan
                            Generalisata</a></li>
                    <li><a href="#"
                            @click.prevent="document.getElementById('visus').scrollIntoView()">Pemeriksaan
                            Visus</a>
                    </li>
                    <li><a href="#"
                            @click.prevent="document.getElementById('audiometri').scrollIntoView()">Audiometri</a>
                    </li>
                    <li><a href="#"
                            @click.prevent="document.getElementById('spirometri').scrollIntoView()">Spirometri</a>
                    </li>
                    <li><a href="#"
                            @click.prevent="document.getElementById('penunjang').scrollIntoView()">Pemeriksaan
                            Penunjang</a></li>
                    <li><a href="#"
                            @click.prevent="document.getElementById('lab').scrollIntoView()">Laboratorium</a></li>
                </ul>
            </div><!-- /.section-sidebar-nav -->
        </div>

    </div><!-- /.mcu-form -->


    <script>
        document.addEventListener('livewire:load', function() {
            // Your JS here.
        })

        function click() {
            alert('aa');
        }
    </script>

</div>
