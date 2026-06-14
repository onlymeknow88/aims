<x-slot name="sidebar">
    @livewire('audit::layouts.sidebar-smkp',['id'=>$audit->id])
</x-slot>
@push('styles')
    <style>
        .col-form-label + div {
            padding-top: calc(0.375rem + 2px);
            padding-bottom: calc(0.375rem + 2px);

        }
    </style>
@endpush

<div class="inner-content">
    @include('audit::livewire.layouts.breadcrumb',[
        'trees'=>[
            ['name'=>'Audit','url'=>route('audit::dashboard')],
            ['name'=> 'SMKP','url'=>route('audit::smkp.index')],
            ['name'=>$audit->title,'url'=>route('audit::smkp.detail.index',['id'=>$audit->id])],
            ['name'=>'Berita Acara Hasil Pelaksanaan Tahapan Awal Audit Internal SMKP'],
        ]
    ])
    @include('audit::livewire.smkp.implementation-report.modal_team')
    @include('audit::livewire.smkp.implementation-report.modals')
    <div class="container">
        <div class="row justify-content-center mb-5">
            <div class="col-sm-10">
                <div class="row">
                    <div class="title-form text-center mb-3 p-3">
                    <h3>BERITA ACARA HASIL PELAKSANAAN TAHAPAN AWAL AUDIT INTERNAL SMKP</h3>
                    </div>
                </div>
                <div class="row">
                    <div class="col-2">
                        Judul
                    </div>
                    <div class="col-8">
                        : {{$audit->title}}
                    </div>
                </div>
                <div class="row">
                    <div class="col-2">
                        Nama Perusahaan
                    </div>
                    <div class="col-8">
                        : {{$audit->company->company_name}}
                    </div>
                </div>
                <div class="row">
                    <div class="col-2">
                        Tanggal Audit
                    </div>
                    <div class="col-8">
                        : {{date('d F Y',strtotime($audit->start_at))}} - {{date('d F Y',strtotime($audit->end_at))}}
                    </div>
                </div>
                <div class="row">
                    <div class="col-2">Progress </div><div class="col-8">: {{$progress}} %</div>
                </div>
            </div>
        </div>
        <div class="row justify-content-center">
            <div class="col-sm-10">
                <form wire:submit.prevent='store' id="form-audit-init" class="py-4 d-flex flex-column gap-5">
                    <div class="content-form d-flex flex-column gap-3">
                        <h6>1. INFORMASI PELAKSANAAN AUDIT SMKP</h6>
                        <h6>A. Data Perusahaan Auditee</h6>
                        <div class="row form-group">
                            <label for="company_id" class="col col-form-label">Perusahaan
                                Auditee</label>
                            <div class="col-6">
                                <x-inputs.select2
                                    id="company_id"
                                    error="company_id"
                                    wire:model='company_id'
                                    style="width: 100%"
                                >
                                    @foreach ($companies as $company)
                                        <option value="{{ $company->id }}">
                                            {{ $company->company_name }}
                                        </option>
                                    @endforeach

                                </x-inputs.select2>
                            </div>
                        </div>
                        
                        <div class="row form-group">
                            <label for="audit.implementation_report.detail.permission_type" class="col col-form-label">Jenis
                                Perizinan</label>
                            <div class="col-6">
                                <x-inputs.text
                                    id="permission_type"
                                    error="audit.implementation_report.detail.permission_type"
                                    wire:model='audit.implementation_report.detail.permission_type'
                                    placeholder="Jenis Perizinan"></x-inputs.text>
                            </div>
                        </div>
                        <div class="row form-group">
                            <label for="audit.implementation_report.detail.commodity_type" class="col col-form-label">Jenis
                                Komoditas</label>
                            <div class="col-6">
                                <x-inputs.text
                                    id="permission_type"
                                    error="audit.implementation_report.detail.commodity_type"
                                    wire:model='audit.implementation_report.detail.commodity_type'
                                    placeholder="Jenis Komoditas"></x-inputs.text>
                            </div>
                        </div>
                    </div>
                    <div class="content-form d-flex flex-column gap-3">
                        <h6>Data Kinerja Keselamatan Pertambangan pada Periode Audit</h6>
                        @foreach($audit->implementation_report->detail->safety_performances as $key =>$value)
                            <div class="row form-group">
                                <label for="audit.implementation_report.detail.safety_performances.{{$key}}.pivot.value"
                                       class="col col-form-label">{{$value->title}}</label>
                                <div class="col-6">
                                    <x-inputs.text
                                        onkeypress="return isNumberKey(this,event)"
                                        id="audit.implementation_report.detail.safety_performances.{{$key}}.pivot.value"
                                        error="audit.implementation_report.detail.safety_performances.{{$key}}.pivot.value"
                                        wire:model='audit.implementation_report.detail.safety_performances.{{$key}}.pivot.value'
                                        placeholder="{{$value->title}}"></x-inputs.text>
                                </div>
                            </div>
                        @endforeach
                    </div>
                    <div class="content-form d-flex flex-column gap-3">
                        <h6>Dasar Faktor Penyesuaian</h6>
                        @foreach($audit->implementation_report->detail->adjustment_factors as $key =>$value)
                            <div class="row form-group">
                                <label for="audit.implementation_report.detail.adjustment_factors.{{$key}}.pivot.value"
                                       class="col col-form-label">{{$value->title}}</label>
                                <div class="col-6">
                                    <x-inputs.select2
                                        data-search-off="true"
                                        id="audit.implementation_report.detail.adjustment_factors.{{$key}}.pivot.value"
                                        wire:model="audit.implementation_report.detail.adjustment_factors.{{$key}}.pivot.value"
                                        error="audit.implementation_report.detail.adjustment_factors.{{$key}}.pivot.value"
                                        style="width: 100%">
                                        <option value="1">Ya</option>
                                        <option value="0">Tidak</option>
                                    </x-inputs.select2>
                                </div>
                            </div>
                        @endforeach
                    </div>
                    <div class="content-form d-flex flex-column gap-3">
                        <h6>B. Perhitungan Hari Kerja Audit dan Jumlah Auditor</h6>
                        <div class="row form-group">
                            <label for="total_man_power" class="col col-form-label">Jumlah Pekerja Auditi
                                (Manpower)</label>
                            <div class="col-6">
                                <x-inputs.text
                                    onkeypress="return isNumericOnly(this,event)"
                                    id="total_man_power"
                                    error="total_man_power"
                                    wire:model='total_man_power'
                                    placeholder="Jumlah Pekerja"></x-inputs.text>
                            </div>
                        </div>
                        <div class="row form-group">
                            <label for="severity_id" class="col col-form-label">Kelas Resiko</label>
                            <div class="col-6">
                                <x-inputs.select2
                                    id="severity_id"
                                    error="severity_id"
                                    wire:model='severity_id'
                                    style="width: 100%"
                                >
                                    @foreach ($severities as $severity)
                                        <option value="{{ $severity->id }}">
                                            {{ $severity->name }}
                                        </option>
                                    @endforeach

                                </x-inputs.select2>
                            </div>
                        </div>
                        <div class="row form-group">
                            <label for="mandays_id" class="col col-form-label">Nomor Kategori</label>
                            <div class="col-6">
                                <x-inputs.text
                                    disabled
                                    id="mandays_id"
                                    error="mandays_id"
                                    wire:model='mandays_id'
                                    placeholder="Nomor Kategori"></x-inputs.text>
                            </div>
                        </div>
                        <div class="row form-group">
                            <label for="total_auditor" class="col col-form-label">Jumlah Auditor</label>
                            <div class="col-6">
                                <x-inputs.text
                                    id="total_auditor"
                                    error="total_auditor"
                                    wire:model="total_auditor"
                                    disabled
                                ></x-inputs.text>
                            </div>
                        </div>
                        <div class="row form-group">
                            <label for="mandays" class="col col-form-label">Mandays</label>
                            <div class="col-6">
                                <x-inputs.text
                                    disabled
                                    id="mandays"
                                    error="mandays"
                                    wire:model="mandays"
                                ></x-inputs.text>
                            </div>
                        </div>
                        <div class="row form-group">
                            <label for="adjustment" class="col col-form-label">Faktor Penyesuaian</label>
                            <div class="col-6">
                                <x-inputs.text
                                    id="adjustment"
                                    error="adjustment"
                                    disabled
                                    wire:model="adjustment"
                                ></x-inputs.text>
                            </div>
                        </div>
                        <div class="row form-group">
                            <label for="total_man_days" class="col col-form-label">Total Mandays</label>
                            <div class="col-6">
                                <x-inputs.text
                                    id="total_man_days"
                                    error="total_man_days"
                                    disabled
                                    wire:model="total_man_days"
                                ></x-inputs.text>
                            </div>
                        </div>
                        <div class="row form-group">
                            <label for="firstStep" class="col col-form-label">Alokasi Mandays untuk Tahap I Audit
                                (Maksimal 10% dari Total)</label>
                            <div class="col-6">
                                <x-inputs.text
                                    id="firstStep"
                                    error="firstStep"
                                    disabled
                                    wire:model="firstStep"
                                ></x-inputs.text>
                            </div>
                        </div>
                        <div class="row form-group">
                            <label for="secondStep" class="col col-form-label">Alokasi Mandays untuk Tahap II Audit
                                (Maksimal 90% dari Total)</label>
                            <div class="col-6">
                                <x-inputs.text
                                    id="secondStep"
                                    error="secondStep"
                                    disabled
                                    wire:model="secondStep"
                                ></x-inputs.text>
                            </div>
                        </div>
                    </div>

                    <div class="content-form d-flex flex-column gap-3">
                        <h6>2. HASIL PERMULAAN AUDIT DAN PENINJAUAN DOKUMEN</h6>
                        <h6>A. Penetapan Tim Audit Tahap I</h6>
                        <div class="row form-group">
                            <label for="head_company_id" class="col col-form-label">Kepala Teknik Tambang PT</label>
                            <div class="col-6">
                                <x-inputs.select2
                                    id="head_company_id"
                                    error="head_company_id"
                                    wire:model='head_company_id'
                                    style="width: 100%"
                                >
                                    @foreach ($companies as $company)
                                        <option value="{{ $company->id }}">
                                            {{ $company->company_name }}
                                        </option>
                                    @endforeach

                                </x-inputs.select2>
                            </div>
                        </div>
                        <div class="row form-group">
                            <label for="appointment_letter_number" class="col col-form-label">Nomor Surat Pengangkatan</label>
                            <div class="col-6">
                                <x-inputs.text
                                    id="appointment_letter_number"
                                    error="appointment_letter_number"
                                    wire:model="appointment_letter_number"
                                ></x-inputs.text>
                            </div>
                        </div>
                        <div class="row form-group">
                            <label for="letter_date" class="col col-form-label">Tanggal Surat</label>
                            <div class="col-6">
                                <x-inputs.datepicker placeholder="" wire:model="letter_date" id="letter_date" :error="'letter_date'"></x-inputs.datepicker>
                            </div>
                        </div>
                        <div class="row form-group">
                            <label for="audited_company_id" class="col col-form-label">Perusahaan Di Audit</label>
                            <div class="col-6">
                                <x-inputs.select2
                                    id="audited_company_id"
                                    error="audited_company_id"
                                    wire:model='audited_company_id'
                                    style="width: 100%"
                                >
                                    @foreach ($companies as $company)
                                        <option value="{{ $company->id }}">
                                            {{ $company->company_name }}
                                        </option>
                                    @endforeach

                                </x-inputs.select2>
                            </div>
                        </div>

                        <h6>Tim Audit</h6>
                        <div class="loop-element d-flex flex-column gap-5">
                            @foreach($auditors_1 as $auditor)
                                <div class="items-loop row">
                                    <div class="col-12 d-flex flex-column gap-3">
                                        <div class="row form-group">
                                            <label for="title" class="col col-form-label">Role</label>
                                            <div class="col-6">
                                                <div class="row">
                                                    <div class="col-10">
                                                        <x-inputs.text id="role[{{$loop->index}}]" disabled error=""
                                                                       value="{{$auditor->role->name}}"></x-inputs.text>
                                                    </div>
                                                    <div class="col-2">
                                                        <button type="button" class="btn btn-danger btn-small"
                                                                wire:click="deleteTeam('{{$auditor->id}}')">&times;
                                                        </button>
                                                    </div>
                                                </div>

                                            </div>

                                        </div>
                                        <div class="row form-group">
                                            <label for="title" class="col col-form-label">Nama</label>
                                            <div class="col-6">
                                                <div class="row">
                                                    <div class="col-10">
                                                        <x-inputs.text id="role[{{$loop->index}}]" disabled error=""
                                                                       value="{{$auditor->name}}"></x-inputs.text>
                                                    </div>
                                                    <div class="col-2">

                                                    </div>
                                                </div>

                                            </div>

                                        </div>
                                        @if($auditor->audit_team_role_id != 3)
                                        <div class="row form-group">
                                            <label for="title" class="col col-form-label">Nomor Registrasi</label>
                                            <div class="col-6">
                                                <div class="row">
                                                    <div class="col-10">
                                                        <x-inputs.text id="role[{{$loop->index}}]" disabled error=""
                                                                       value="{{$auditor->registration_number}}"></x-inputs.text>
                                                    </div>
                                                    <div class="col-2">

                                                    </div>
                                                </div>

                                            </div>

                                        </div>
                                        @endif
                                    </div>
                                </div>
                            @endforeach
                            <div class="add_loop">
                                <button type="button" class="btn btn-outline-success d-block" data-bs-toggle="modal"
                                        data-bs-target="#modalFormTeam" wire:click="phase(1)">+ Add Team
                                </button>
                            </div>
                        </div>
                    </div>

                    <div class="content-form d-flex flex-column gap-3">
                        <h6>B. Pelaksanaan Kontak Awal dengan Auditi</h6>
                        <div class="row form-group">
                            <label for="initial_contact_date" class="col col-form-label">Tanggal</label>
                            <div class="col-6">
                                <x-inputs.datepicker placeholder="" wire:model="initial_contact_date" id="initial_contact_date" :error="'initial_contact_date'"></x-inputs.datepicker>
                            </div>
                        </div>
                        <div class="row form-group">
                            <label for="media" class="col col-form-label">Media</label>
                            <div class="col-6">
                                <x-inputs.text
                                    id="media"
                                    error="media"
                                    wire:model="media"
                                ></x-inputs.text>
                            </div>
                        </div>
                        <div class="row form-group">
                            <label for="auditi_delegation" class="col col-form-label">Perwakilan Auditi</label>
                            <div class="col-6">
                                <x-inputs.text
                                    id="auditi_delegation"
                                    error="auditi_delegation"
                                    wire:model="auditi_delegation"
                                ></x-inputs.text>
                            </div>
                        </div>
                        <div class="row form-group">
                            <label for="auditi_delegation_position" class="col col-form-label">Jabatan Perwakilan Auditi</label>
                            <div class="col-6">
                                <x-inputs.text
                                    id="auditi_delegation_position"
                                    error="auditi_delegation_position"
                                    wire:model="auditi_delegation_position"
                                ></x-inputs.text>
                            </div>
                        </div>
                    </div>

                    <div class="content-form d-flex flex-column gap-3">
                        <h6>C. Penentuan Kelayakan Audit</h6>
                        <div class="row form-group">
                            <label for="determination_of_eligibility_date" class="col col-form-label">Tanggal</label>
                            <div class="col-6">
                                <x-inputs.datepicker placeholder="" wire:model="determination_of_eligibility_date" id="determination_of_eligibility_date" :error="'determination_of_eligibility_date'"></x-inputs.datepicker>
                            </div>
                        </div>
                        <div class="row form-group">
                            <label for="organizational_profile" class="col col-form-label">Informasi untuk Pengembangan Program Audit: Profil Organisasi</label>
                            <div class="col-6">
                                <x-inputs.select2
                                    id="organizational_profile"
                                    error="organizational_profile"
                                    wire:model='organizational_profile'
                                    style="width: 100%"
                                >
                                    <option value="Laik">Laik</option>
                                    <option value="Tidak Laik">Tidak Laik</option>
                                </x-inputs.select2>
                            </div>
                        </div>
                        <div class="row form-group">
                            <label for="risk_profile" class="col col-form-label">Informasi untuk Pengembangan Program Audit: Profil Risiko</label>
                            <div class="col-6">
                                <x-inputs.select2
                                    id="risk_profile"
                                    error="risk_profile"
                                    wire:model='risk_profile'
                                    style="width: 100%"
                                >
                                    <option value="Laik">Laik</option>
                                    <option value="Tidak Laik">Tidak Laik</option>
                                </x-inputs.select2>
                            </div>
                        </div>
                        <div class="row form-group">
                            <label for="safety_performance_data" class="col col-form-label">Informasi untuk Pengembangan Program Audit: Data Kinerja Keselamatan Pertambangan pada Periode Audit</label>
                            <div class="col-6">
                                <x-inputs.select2
                                    id="safety_performance_data"
                                    error="safety_performance_data"
                                    wire:model='safety_performance_data'
                                    style="width: 100%"
                                >
                                    <option value="Laik">Laik</option>
                                    <option value="Tidak Laik">Tidak Laik</option>
                                </x-inputs.select2>
                            </div>
                        </div>
                        <div class="row form-group">
                            <label for="auditi_collaboration" class="col col-form-label">Kerjasama dari Auditi</label>
                            <div class="col-6">
                                <x-inputs.select2
                                    id="auditi_collaboration"
                                    error="auditi_collaboration"
                                    wire:model='auditi_collaboration'
                                    style="width: 100%"
                                >
                                    <option value="Laik">Laik</option>
                                    <option value="Tidak Laik">Tidak Laik</option>
                                </x-inputs.select2>
                            </div>
                        </div>
                        <div class="row form-group">
                            <label for="time_availability" class="col col-form-label">Ketersediaan Waktu</label>
                            <div class="col-6">
                                <x-inputs.select2
                                    id="time_availability"
                                    error="time_availability"
                                    wire:model='time_availability'
                                    style="width: 100%"
                                >
                                    <option value="Laik">Laik</option>
                                    <option value="Tidak Laik">Tidak Laik</option>
                                </x-inputs.select2>
                            </div>
                        </div>
                        <div class="row form-group">
                            <label for="other_resources_availability" class="col col-form-label">Ketersediaan Sumberdaya lainnya</label>
                            <div class="col-6">
                                <x-inputs.select2
                                    id="other_resources_availability"
                                    error="other_resources_availability"
                                    wire:model='other_resources_availability'
                                    style="width: 100%"
                                >
                                    <option value="Laik">Laik</option>
                                    <option value="Tidak Laik">Tidak Laik</option>
                                </x-inputs.select2>
                            </div>
                        </div>
                        <div class="row form-group">
                            <label for="fulfillment_of_safety" class="col col-form-label">Pemenuhan Persyaratan Keselamatan dan Keamanan</label>
                            <div class="col-6">
                                <x-inputs.select2
                                    id="fulfillment_of_safety"
                                    error="fulfillment_of_safety"
                                    wire:model='fulfillment_of_safety'
                                    style="width: 100%"
                                >
                                    <option value="Laik">Laik</option>
                                    <option value="Tidak Laik">Tidak Laik</option>
                                </x-inputs.select2>
                            </div>
                        </div>
                        <div class="row form-group">
                            <label for="eligibility_status" class="col col-form-label">Status Kelayakan</label>
                            <div class="col-6">
                                <x-inputs.text
                                    id="eligibility_status"
                                    error="eligibility_status"
                                    wire:model="eligibility_status"
                                    disabled
                                ></x-inputs.text>
                            </div>
                        </div>
                    </div>

                    <div class="content-form d-flex flex-column gap-3">
                        <h6>D. Penentuan Kecukupan Dokumentasi</h6>
                        <div class="row form-group">
                            <label for="adequacy_company_id" class="col col-form-label">Perusahaan</label>
                            <div class="col-6">
                                <x-inputs.select2
                                    id="adequacy_company_id"
                                    error="adequacy_company_id"
                                    wire:model='adequacy_company_id'
                                    style="width: 100%"
                                >
                                    @foreach ($companies as $company)
                                        <option value="{{ $company->id }}">
                                            {{ $company->company_name }}
                                        </option>
                                    @endforeach

                                </x-inputs.select2>
                            </div>
                        </div>
                        <div class="row form-group">
                            <label for="element_1" class="col col-form-label">Elemen I Kebijakan</label>
                            <div class="col-6">
                                <x-inputs.select2
                                    id="element_1"
                                    error="element_1"
                                    wire:model='element_1'
                                    style="width: 100%"
                                >
                                    <option value="Cukup">Cukup</option>
                                    <option value="Tidak Cukup">Tidak Cukup</option>
                                </x-inputs.select2>
                            </div>
                        </div>
                        <div class="row form-group">
                            <label for="element_2" class="col col-form-label">Elemen II Perencanaan</label>
                            <div class="col-6">
                                <x-inputs.select2
                                    id="element_2"
                                    error="element_2"
                                    wire:model='element_2'
                                    style="width: 100%"
                                >
                                    <option value="Cukup">Cukup</option>
                                    <option value="Tidak Cukup">Tidak Cukup</option>
                                </x-inputs.select2>
                            </div>
                        </div>
                        <div class="row form-group">
                            <label for="element_3" class="col col-form-label">Elemen III Organisasi dan Personel</label>
                            <div class="col-6">
                                <x-inputs.select2
                                    id="element_3"
                                    error="element_3"
                                    wire:model='element_3'
                                    style="width: 100%"
                                >
                                    <option value="Cukup">Cukup</option>
                                    <option value="Tidak Cukup">Tidak Cukup</option>
                                </x-inputs.select2>
                            </div>
                        </div>
                        <div class="row form-group">
                            <label for="element_4" class="col col-form-label">Elemen IV Implementasi</label>
                            <div class="col-6">
                                <x-inputs.select2
                                    id="element_4"
                                    error="element_4"
                                    wire:model='element_4'
                                    style="width: 100%"
                                >
                                    <option value="Cukup">Cukup</option>
                                    <option value="Tidak Cukup">Tidak Cukup</option>
                                </x-inputs.select2>
                            </div>
                        </div>
                        <div class="row form-group">
                            <label for="element_5" class="col col-form-label">Elemen V Pemantauan, Evaluasi, dan Tindak Lanjut</label>
                            <div class="col-6">
                                <x-inputs.select2
                                    id="element_5"
                                    error="element_5"
                                    wire:model='element_5'
                                    style="width: 100%"
                                >
                                    <option value="Cukup">Cukup</option>
                                    <option value="Tidak Cukup">Tidak Cukup</option>
                                </x-inputs.select2>
                            </div>
                        </div>
                        <div class="row form-group">
                            <label for="element_6" class="col col-form-label">Elemen VI Dokumentasi</label>
                            <div class="col-6">
                                <x-inputs.select2
                                    id="element_6"
                                    error="element_6"
                                    wire:model='element_6'
                                    style="width: 100%"
                                >
                                    <option value="Cukup">Cukup</option>
                                    <option value="Tidak Cukup">Tidak Cukup</option>
                                </x-inputs.select2>
                            </div>
                        </div>
                        <div class="row form-group">
                            <label for="element_7" class="col col-form-label">Elemen VII Tinjauan Manajemen dan Peningkatan Kinerja</label>
                            <div class="col-6">
                                <x-inputs.select2
                                    id="element_7"
                                    error="element_7"
                                    wire:model='element_7'
                                    style="width: 100%"
                                >
                                    <option value="Cukup">Cukup</option>
                                    <option value="Tidak Cukup">Tidak Cukup</option>
                                </x-inputs.select2>
                            </div>
                        </div>
                        <div class="row form-group">
                            <label for="evaluation_of_documentation " class="col col-form-label">Evaluasi Kecukupan Dokumentasi</label>
                            <div class="col-6">
                                <x-inputs.text
                                    id="evaluation_of_documentation"
                                    error="evaluation_of_documentation"
                                    wire:model="evaluation_of_documentation"
                                    disabled
                                ></x-inputs.text>
                            </div>
                        </div>

                        @if(in_array('Tidak Cukup', [$this->element_1, $this->element_2, $this->element_3, $this->element_4, $this->element_5, $this->element_6, $this->element_7]))
                        <h6>Dokumen yang harus dilengkapi</h6>
                        <div class="loop-element d-flex flex-column gap-3">
                            @foreach($complementary_documents as $complementary_document)
                                <div class="items-loop row">
                                    <div class="col-12 d-flex flex-column gap-3">
                                        <div class="row form-group">
                                            <label for="title" class="col col-form-label">Dokumen</label>
                                            <div class="col-6">
                                                <div class="row">
                                                    <div class="col-10">
                                                        <x-inputs.text id="role[{{$loop->index}}]" disabled error=""
                                                                       value="{{$complementary_document->document}}"></x-inputs.text>
                                                    </div>
                                                    <div class="col-2">
                                                        <button type="button" class="btn btn-danger btn-small"
                                                                wire:click="deleteComplementaryDocument('{{$complementary_document->id}}')">&times;
                                                        </button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                            <div class="add_loop">
                                <button type="button" class="btn btn-outline-success d-block" data-bs-toggle="modal"
                                        data-bs-target="#modalComplementaryDocument">+ Add
                                </button>
                            </div>
                        </div>
                        @endif

                    </div>
                    <div class="content-form d-flex flex-column gap-3">
                        <h6>3. PERSIAPAN AUDIT LAPANGAN</h6>
                        <h6>A. Penetapan Tim Audit Tahap II</h6>
                        <div class="row form-group">
                            <label for="audited_company_id_2" class="col col-form-label">Perusahaan Di Audit</label>
                            <div class="col-6">
                                <x-inputs.select2
                                    id="audited_company_id_2"
                                    error="audited_company_id_2"
                                    wire:model='audited_company_id_2'
                                    style="width: 100%"
                                >
                                    @foreach ($companies as $company)
                                        <option value="{{ $company->id }}">
                                            {{ $company->company_name }}
                                        </option>
                                    @endforeach
                                </x-inputs.select2>
                            </div>
                        </div>
                        <div class="row form-group">
                            <label for="proven_by" class="col col-form-label">Dibuktikan dengan</label>
                            <div class="col-6">
                                <x-inputs.text
                                    id="proven_by"
                                    error="proven_by"
                                    wire:model="proven_by"
                                ></x-inputs.text>
                            </div>
                        </div>
                        
                        <h6>Tim Audit</h6>
                        <div class="loop-element d-flex flex-column gap-5">
                            @foreach($auditors_2 as $auditor)
                                <div class="items-loop row">
                                    <div class="col-12 d-flex flex-column gap-3">
                                        <div class="row form-group">
                                            <label for="title" class="col col-form-label">Role</label>
                                            <div class="col-6">
                                                <div class="row">
                                                    <div class="col-10">
                                                        <x-inputs.text id="role[{{$loop->index}}]" disabled error=""
                                                                       value="{{$auditor->role->name}}"></x-inputs.text>
                                                    </div>
                                                    <div class="col-2">
                                                        <button type="button" class="btn btn-danger btn-small"
                                                                wire:click="deleteTeam('{{$auditor->id}}')">&times;
                                                        </button>
                                                    </div>
                                                </div>

                                            </div>

                                        </div>
                                        <div class="row form-group">
                                            <label for="title" class="col col-form-label">Nama</label>
                                            <div class="col-6">
                                                <div class="row">
                                                    <div class="col-10">
                                                        <x-inputs.text id="role[{{$loop->index}}]" disabled error=""
                                                                       value="{{$auditor->name}}"></x-inputs.text>
                                                    </div>
                                                    <div class="col-2">

                                                    </div>
                                                </div>

                                            </div>

                                        </div>
                                        @if($auditor->audit_team_role_id != 3)
                                        <div class="row form-group">
                                            <label for="title" class="col col-form-label">Nomor Registrasi</label>
                                            <div class="col-6">
                                                <div class="row">
                                                    <div class="col-10">
                                                        <x-inputs.text id="role[{{$loop->index}}]" disabled error=""
                                                                       value="{{$auditor->registration_number}}"></x-inputs.text>
                                                    </div>
                                                    <div class="col-2">

                                                    </div>
                                                </div>

                                            </div>

                                        </div>
                                        @endif
                                    </div>
                                </div>
                            @endforeach
                            <div class="add_loop">
                                <button type="button" class="btn btn-outline-success d-block" data-bs-toggle="modal"
                                        data-bs-target="#modalFormTeam" wire:click="phase(2)">+ Add Team
                                </button>
                            </div>
                        </div>

                        <div class="content-form d-flex flex-column gap-3">
                        <h6>B. Penyiapan Rencana Audit</h6>
                        <div class="row form-group">
                            <label for="company_form_number" class="col col-form-label">Nomor</label>
                            <div class="col-6">
                                <x-inputs.text
                                    id="company_form_number"
                                    error="company_form_number"
                                    wire:model="company_form_number"
                                ></x-inputs.text>
                            </div>
                        </div>
                        <div class="row form-group">
                            <label for="risk_of_present_year" class="col col-form-label">Periode Data Top Risks aspek Keselamatan Pertambangan (Risk of Present)</label>
                            <div class="col-6">
                                <x-inputs.text
                                    id="risk_of_present_year"
                                    error="risk_of_present_year"
                                    wire:model="risk_of_present_year"
                                    type="number"
                                ></x-inputs.text>
                            </div>
                        </div>
                        <h6 class="mt-2">Data Top Risks aspek Keselamatan Pertambangan (Risk of Present)</h6>
                        <div class="loop-element d-flex flex-column gap-5">
                            @foreach($risk_of_presents as $data)
                                <div class="items-loop row">
                                    <div class="col-12 d-flex flex-column gap-3">
                                        <div class="row form-group">
                                            <label for="title" class="col col-form-label">Kegiatan</label>
                                            <div class="col-6">
                                                <div class="row">
                                                    <div class="col-10">
                                                        <x-inputs.text id="role[{{$loop->index}}]" disabled error=""
                                                                       value="{{$data->activity}}"></x-inputs.text>
                                                    </div>
                                                    <div class="col-2">
                                                        <button type="button" class="btn btn-danger btn-small"
                                                                wire:click="deleteRiskOfPresents('{{$data->id}}')">&times;
                                                        </button>
                                                    </div>
                                                </div>

                                            </div>

                                        </div>
                                        <div class="row form-group">
                                            <label for="title" class="col col-form-label">Risiko</label>
                                            <div class="col-6">
                                                <div class="row">
                                                    <div class="col-10">
                                                        <x-inputs.text id="role[{{$loop->index}}]" disabled error=""
                                                                       value="{{$data->risk}}"></x-inputs.text>
                                                    </div>
                                                    <div class="col-2">

                                                    </div>
                                                </div>

                                            </div>

                                        </div>

                                        <div class="row form-group">
                                            <label for="title" class="col col-form-label">Nilai Risiko</label>
                                            <div class="col-6">
                                                <div class="row">
                                                    <div class="col-10">
                                                        <x-inputs.text id="role[{{$loop->index}}]" disabled error=""
                                                                       value="{{$data->risk_value}}"></x-inputs.text>
                                                    </div>
                                                    <div class="col-2">

                                                    </div>
                                                </div>

                                            </div>

                                        </div>

                                    </div>
                                </div>
                            @endforeach
                            <div class="add_loop">
                                <button type="button" class="btn btn-outline-success d-block" data-bs-toggle="modal"
                                        data-bs-target="#modalFormRiskPresent">+ Add
                                </button>
                            </div>
                        </div>
                    </div>

                    <div class="content-form d-flex flex-column gap-3">
                        <div class="row form-group">
                            <label for="risk_of_future_year" class="col col-form-label">Periode Data Top Risks aspek Keselamatan Pertambangan (Risk of Future)</label>
                            <div class="col-6">
                                <x-inputs.text
                                    id="risk_of_future_year"
                                    error="risk_of_future_year"
                                    wire:model="risk_of_future_year"
                                    type="number"
                                ></x-inputs.text>
                            </div>
                        </div>
                        <h6 class="mt-2">Data Top Risks aspek Keselamatan Pertambangan (Risk of Future)</h6>
                        <div class="loop-element d-flex flex-column gap-5">
                            @foreach($risk_of_futures as $data)
                                <div class="items-loop row">
                                    <div class="col-12 d-flex flex-column gap-3">
                                        <div class="row form-group">
                                            <label for="title" class="col col-form-label">Kegiatan</label>
                                            <div class="col-6">
                                                <div class="row">
                                                    <div class="col-10">
                                                        <x-inputs.text id="role[{{$loop->index}}]" disabled error=""
                                                                       value="{{$data->activity}}"></x-inputs.text>
                                                    </div>
                                                    <div class="col-2">
                                                        <button type="button" class="btn btn-danger btn-small"
                                                                wire:click="deleteRiskOfFuture('{{$data->id}}')">&times;
                                                        </button>
                                                    </div>
                                                </div>

                                            </div>

                                        </div>
                                        <div class="row form-group">
                                            <label for="title" class="col col-form-label">Risiko</label>
                                            <div class="col-6">
                                                <div class="row">
                                                    <div class="col-10">
                                                        <x-inputs.text id="role[{{$loop->index}}]" disabled error=""
                                                                       value="{{$data->risk}}"></x-inputs.text>
                                                    </div>
                                                    <div class="col-2">

                                                    </div>
                                                </div>

                                            </div>

                                        </div>

                                        <div class="row form-group">
                                            <label for="title" class="col col-form-label">Nilai Risiko</label>
                                            <div class="col-6">
                                                <div class="row">
                                                    <div class="col-10">
                                                        <x-inputs.text id="role[{{$loop->index}}]" disabled error=""
                                                                       value="{{$data->risk_value}}"></x-inputs.text>
                                                    </div>
                                                    <div class="col-2">

                                                    </div>
                                                </div>

                                            </div>

                                        </div>

                                    </div>
                                </div>
                            @endforeach
                            <div class="add_loop">
                                <button type="button" class="btn btn-outline-success d-block" data-bs-toggle="modal"
                                        data-bs-target="#modalFormRiskFuture">+ Add
                                </button>
                            </div>
                        </div>
                    </div>

                    <div class="content-form d-flex flex-column gap-3">
                        <div class="row form-group">
                            <label for="trend_factor_year" class="col col-form-label">Periode Data Trend Faktor Penyebab Near Miss, Property Damage, Kejadian Berbahaya, dan/atau Kecelakaan</label>
                            <div class="col-6">
                                <x-inputs.text
                                    id="trend_factor_year"
                                    error="trend_factor_year"
                                    wire:model="trend_factor_year"
                                    type="number"
                                ></x-inputs.text>
                            </div>
                        </div>
                        <h6 class="mt-2">Data Trend Faktor Penyebab Near Miss, Property Damage, Kejadian Berbahaya, dan/atau Kecelakaan</h6>
                        <div class="loop-element d-flex flex-column gap-5">
                            @foreach($trend_factors as $data)
                                <div class="items-loop row">
                                    <div class="col-12 d-flex flex-column gap-3">
                                        <div class="row form-group">
                                            <label for="title" class="col col-form-label">Faktor Penyebab Dominan</label>
                                            <div class="col-6">
                                                <div class="row">
                                                    <div class="col-10">
                                                        <x-inputs.text id="role[{{$loop->index}}]" disabled error=""
                                                                       value="{{$data->factor}}"></x-inputs.text>
                                                    </div>
                                                    <div class="col-2">
                                                        <button type="button" class="btn btn-danger btn-small"
                                                                wire:click="deleteFactor('{{$data->id}}')">&times;
                                                        </button>
                                                    </div>
                                                </div>

                                            </div>

                                        </div>

                                    </div>
                                </div>
                            @endforeach
                            <div class="add_loop">
                                <button type="button" class="btn btn-outline-success d-block" data-bs-toggle="modal"
                                        data-bs-target="#modalFactor">+ Add
                                </button>
                            </div>
                        </div>
                    </div>

                    <div class="content-form d-flex flex-column gap-3">
                        <div class="row form-group">
                            <label for="trend_location_year" class="col col-form-label">Periode Data Trend Lokasi Terjadinya Near Miss, Property Damage, Kejadian Berbahaya, dan/atau Kecelakaan</label>
                            <div class="col-6">
                                <x-inputs.text
                                    id="trend_location_year"
                                    error="trend_location_year"
                                    wire:model="trend_location_year"
                                    type="number"
                                ></x-inputs.text>
                            </div>
                        </div>
                        <h6 class="mt-2">Data Trend Lokasi Terjadinya Near Miss, Property Damage, Kejadian Berbahaya, dan/atau Kecelakaan</h6>
                        <div class="loop-element d-flex flex-column gap-5">
                            @foreach($trend_locations as $data)
                                <div class="items-loop row">
                                    <div class="col-12 d-flex flex-column gap-3">
                                        <div class="row form-group">
                                            <label for="title" class="col col-form-label">Lokasi</label>
                                            <div class="col-6">
                                                <div class="row">
                                                    <div class="col-10">
                                                        <x-inputs.text id="role[{{$loop->index}}]" disabled error=""
                                                                       value="{{$data->location}}"></x-inputs.text>
                                                    </div>
                                                    <div class="col-2">
                                                        <button type="button" class="btn btn-danger btn-small"
                                                                wire:click="deleteLocation('{{$data->id}}')">&times;
                                                        </button>
                                                    </div>
                                                </div>

                                            </div>

                                        </div>

                                    </div>
                                </div>
                            @endforeach
                            <div class="add_loop">
                                <button type="button" class="btn btn-outline-success d-block" data-bs-toggle="modal"
                                        data-bs-target="#modalLocation">+ Add
                                </button>
                            </div>
                        </div>
                    </div>

                    <div class="content-form d-flex flex-column gap-3">
                        <div class="row form-group">
                            <label for="trend_activity_year" class="col col-form-label">Periode Data Trend Jenis Kegiatan terkait Kejadian Near Miss, Property Damage, Kejadian Berbahaya, dan/atau Kecelakaan</label>
                            <div class="col-6">
                                <x-inputs.text
                                    id="trend_activity_year"
                                    error="trend_activity_year"
                                    wire:model="trend_activity_year"
                                    type="number"
                                ></x-inputs.text>
                            </div>
                        </div>
                        <h6 class="mt-2">Data Trend Jenis Kegiatan terkait Kejadian Near Miss, Property Damage, Kejadian Berbahaya, dan/atau Kecelakaan</h6>
                        <div class="loop-element d-flex flex-column gap-5">
                            @foreach($trend_activitys as $data)
                                <div class="items-loop row">
                                    <div class="col-12 d-flex flex-column gap-3">
                                        <div class="row form-group">
                                            <label for="title" class="col col-form-label">Activity</label>
                                            <div class="col-6">
                                                <div class="row">
                                                    <div class="col-10">
                                                        <x-inputs.text id="role[{{$loop->index}}]" disabled error=""
                                                                       value="{{$data->activity}}"></x-inputs.text>
                                                    </div>
                                                    <div class="col-2">
                                                        <button type="button" class="btn btn-danger btn-small"
                                                                wire:click="deleteActivity('{{$data->id}}')">&times;
                                                        </button>
                                                    </div>
                                                </div>

                                            </div>

                                        </div>

                                    </div>
                                </div>
                            @endforeach
                            <div class="add_loop">
                                <button type="button" class="btn btn-outline-success d-block" data-bs-toggle="modal"
                                        data-bs-target="#modalActivity">+ Add
                                </button>
                            </div>
                        </div>
                    </div>

                    <div class="content-form d-flex flex-column gap-3">
                        <div class="row form-group">
                            <label for="trend_position_year" class="col col-form-label">Periode Data Trend Jenis Jabatan terkait Kejadian Near Miss, Property Damage, Kejadian Berbahaya, dan/atau Kecelakaan</label>
                            <div class="col-6">
                                <x-inputs.text
                                    id="trend_position_year"
                                    error="trend_position_year"
                                    wire:model="trend_position_year"
                                    type="number"
                                ></x-inputs.text>
                            </div>
                        </div>
                        <h6 class="mt-2">Data Trend Jenis Jabatan terkait Kejadian Near Miss, Property Damage, Kejadian Berbahaya, dan/atau Kecelakaan</h6>
                        <div class="loop-element d-flex flex-column gap-5">
                            @foreach($trend_positions as $data)
                                <div class="items-loop row">
                                    <div class="col-12 d-flex flex-column gap-3">
                                        <div class="row form-group">
                                            <label for="title" class="col col-form-label">Activity</label>
                                            <div class="col-6">
                                                <div class="row">
                                                    <div class="col-10">
                                                        <x-inputs.text id="role[{{$loop->index}}]" disabled error=""
                                                                       value="{{$data->position}}"></x-inputs.text>
                                                    </div>
                                                    <div class="col-2">
                                                        <button type="button" class="btn btn-danger btn-small"
                                                                wire:click="deletePosition('{{$data->id}}')">&times;
                                                        </button>
                                                    </div>
                                                </div>

                                            </div>

                                        </div>

                                    </div>
                                </div>
                            @endforeach
                            <div class="add_loop">
                                <button type="button" class="btn btn-outline-success d-block" data-bs-toggle="modal"
                                        data-bs-target="#modalPosition">+ Add
                                </button>
                            </div>
                        </div>
                    </div>

                    <div class="content-form d-flex flex-column gap-3">
                        <div class="row form-group">
                            <label for="trend_deviation_year" class="col col-form-label">Periode Data Trend Deviasi Keselamatan Pertambangan berdasarkan Hasil Temuan Inspeksi</label>
                            <div class="col-6">
                                <x-inputs.text
                                    id="trend_deviation_year"
                                    error="trend_deviation_year"
                                    wire:model="trend_deviation_year"
                                    type="number"
                                ></x-inputs.text>
                            </div>
                        </div>
                        <h6 class="mt-2">Data Trend Deviasi Keselamatan Pertambangan berdasarkan Hasil Temuan Inspeksi</h6>
                        <div class="loop-element d-flex flex-column gap-5">
                            @foreach($trend_deviations as $data)
                                <div class="items-loop row">
                                    <div class="col-12 d-flex flex-column gap-3">
                                        <div class="row form-group">
                                            <label for="title" class="col col-form-label">deviation</label>
                                            <div class="col-6">
                                                <div class="row">
                                                    <div class="col-10">
                                                        <x-inputs.text id="role[{{$loop->index}}]" disabled error=""
                                                                       value="{{$data->deviation}}"></x-inputs.text>
                                                    </div>
                                                    <div class="col-2">
                                                        <button type="button" class="btn btn-danger btn-small"
                                                                wire:click="deleteDeviation('{{$data->id}}')">&times;
                                                        </button>
                                                    </div>
                                                </div>

                                            </div>

                                        </div>

                                    </div>
                                </div>
                            @endforeach
                            <div class="add_loop">
                                <button type="button" class="btn btn-outline-success d-block" data-bs-toggle="modal"
                                        data-bs-target="#modalDeviation">+ Add
                                </button>
                            </div>
                        </div>
                    </div>

                    <div class="content-form d-flex flex-column gap-3">
                        <div class="row form-group">
                            <label for="trend_factors_causing_year" class="col col-form-label">Periode Data Trend Faktor Penyebab Kejadian Akibat Penyakit Tenaga Kerja dan/atau Penyakit Akibat Kerja</label>
                            <div class="col-6">
                                <x-inputs.text
                                    id="trend_factors_causing_year"
                                    error="trend_factors_causing_year"
                                    wire:model="trend_factors_causing_year"
                                    type="number"
                                ></x-inputs.text>
                            </div>
                        </div>
                        <h6 class="mt-2">Data Trend Faktor Penyebab Kejadian Akibat Penyakit Tenaga Kerja dan/atau Penyakit Akibat Kerja</h6>
                        <div class="loop-element d-flex flex-column gap-5">
                            @foreach($trend_factors_causings as $data)
                                <div class="items-loop row">
                                    <div class="col-12 d-flex flex-column gap-3">
                                        <div class="row form-group">
                                            <label for="title" class="col col-form-label">Faktor Penyebab Dominan</label>
                                            <div class="col-6">
                                                <div class="row">
                                                    <div class="col-10">
                                                        <x-inputs.text id="role[{{$loop->index}}]" disabled error=""
                                                                       value="{{$data->causing}}"></x-inputs.text>
                                                    </div>
                                                    <div class="col-2">
                                                        <button type="button" class="btn btn-danger btn-small"
                                                                wire:click="deleteCausing('{{$data->id}}')">&times;
                                                        </button>
                                                    </div>
                                                </div>

                                            </div>

                                        </div>

                                    </div>
                                </div>
                            @endforeach
                            <div class="add_loop">
                                <button type="button" class="btn btn-outline-success d-block" data-bs-toggle="modal"
                                        data-bs-target="#modalCausing">+ Add
                                </button>
                            </div>
                        </div>
                    </div>

                    <div class="content-form d-flex flex-column gap-3">
                        <div class="row form-group">
                            <label for="trend_factors_causing_year" class="col col-form-label">Periode Data Unjuk Kerja Peralatan Pertambangan</label>
                            <div class="col-6">
                                <x-inputs.text
                                    id="mining_equipment_work_year"
                                    error="mining_equipment_work_year"
                                    wire:model="mining_equipment_work_year"
                                    type="number"
                                ></x-inputs.text>
                            </div>
                        </div>
                        <h6 class="mt-2">Data Unjuk Kerja Peralatan Pertambangan</h6>
                        <div class="loop-element d-flex flex-column gap-5">
                            @foreach($mining_equipment_works as $data)
                                <div class="items-loop row">
                                    <div class="col-12 d-flex flex-column gap-3">
                                        <div class="row form-group">
                                            <label for="title" class="col col-form-label">Jenis Peralatan</label>
                                            <div class="col-6">
                                                <div class="row">
                                                    <div class="col-10">
                                                        <x-inputs.text id="role[{{$loop->index}}]" disabled error=""
                                                                       value="{{$data->equipment}}"></x-inputs.text>
                                                    </div>
                                                    <div class="col-2">
                                                        <button type="button" class="btn btn-danger btn-small"
                                                                wire:click="deleteMiningEquipmentWork('{{$data->id}}')">&times;
                                                        </button>
                                                    </div>
                                                </div>

                                            </div>

                                        </div>
                                        <div class="row form-group">
                                            <label for="title" class="col col-form-label">Physical Availability</label>
                                            <div class="col-6">
                                                <div class="row">
                                                    <div class="col-10">
                                                        <x-inputs.text id="role[{{$loop->index}}]" disabled error=""
                                                                       value="{{$data->physical_availability}}"></x-inputs.text>
                                                    </div>
                                                    <div class="col-2">

                                                    </div>
                                                </div>

                                            </div>

                                        </div>

                                        <div class="row form-group">
                                            <label for="title" class="col col-form-label">Mechanical Availability</label>
                                            <div class="col-6">
                                                <div class="row">
                                                    <div class="col-10">
                                                        <x-inputs.text id="role[{{$loop->index}}]" disabled error=""
                                                                       value="{{$data->mechanical_availability}}"></x-inputs.text>
                                                    </div>
                                                    <div class="col-2">

                                                    </div>
                                                </div>

                                            </div>

                                        </div>

                                    </div>
                                </div>
                            @endforeach
                            <div class="add_loop">
                                <button type="button" class="btn btn-outline-success d-block" data-bs-toggle="modal"
                                        data-bs-target="#modalMiningEquipmentWork">+ Add
                                </button>
                            </div>
                        </div>
                    </div>

                    <div class="content-form d-flex flex-column gap-3">
                        <div class="row form-group">
                            <label for="trend_factors_causing_year" class="col col-form-label">Periode Data Capaian Key Leading Indicator</label>
                            <div class="col-6">
                                <x-inputs.text
                                    id="key_leading_indicator_year"
                                    error="key_leading_indicator_year"
                                    wire:model="key_leading_indicator_year"
                                    type="number"
                                ></x-inputs.text>
                            </div>
                        </div>
                        <h6 class="mt-2">Data Capaian Key Leading Indicator</h6>
                        <div class="loop-element d-flex flex-column gap-5">
                            @foreach($key_leading_indicators as $data)
                                <div class="items-loop row">
                                    <div class="col-12 d-flex flex-column gap-3">
                                        <div class="row form-group">
                                            <label for="title" class="col col-form-label">Key Leading Indicator</label>
                                            <div class="col-6">
                                                <div class="row">
                                                    <div class="col-10">
                                                        <x-inputs.text id="role[{{$loop->index}}]" disabled error=""
                                                                       value="{{$data->key_leading_indicator}}"></x-inputs.text>
                                                    </div>
                                                    <div class="col-2">
                                                        <button type="button" class="btn btn-danger btn-small"
                                                                wire:click="deleteKeyLeadingIndicator('{{$data->id}}')">&times;
                                                        </button>
                                                    </div>
                                                </div>

                                            </div>

                                        </div>
                                        <div class="row form-group">
                                            <label for="title" class="col col-form-label">Status Pencapaian hingga Tanggal Pelaksanaan Audit</label>
                                            <div class="col-6">
                                                <div class="row">
                                                    <div class="col-10">
                                                        <x-inputs.text id="role[{{$loop->index}}]" disabled error=""
                                                                       value="{{$data->status}}"></x-inputs.text>
                                                    </div>
                                                    <div class="col-2">

                                                    </div>
                                                </div>

                                            </div>

                                        </div>

                                    </div>
                                </div>
                            @endforeach
                            <div class="add_loop">
                                <button type="button" class="btn btn-outline-success d-block" data-bs-toggle="modal"
                                        data-bs-target="#modalKeyLeadingIndicator">+ Add
                                </button>
                            </div>
                        </div>
                    </div>

                    <div class="content-form d-flex flex-column gap-3">
                        <div class="row form-group">
                            <label for="internal_audit_year" class="col col-form-label">Periode Data Audit Internal</label>
                            <div class="col-6">
                                <x-inputs.text
                                    id="internal_audit_year"
                                    error="internal_audit_year"
                                    wire:model="internal_audit_year"
                                    type="number"
                                ></x-inputs.text>
                            </div>
                        </div>

                        <div class="row form-group">
                            <label for="data_audit_1" class="col col-form-label">Capaian Nilai Audit</label>
                            <div class="col-6">
                                <x-inputs.text
                                    id="data_audit_1"
                                    error="data_audit_1"
                                    wire:model="data_audit_1"
                                    type="text"
                                ></x-inputs.text>
                            </div>
                        </div>

                        <div class="row form-group">
                            <label for="data_audit_2" class="col col-form-label">Status Penyelesaian Tindak Lanjut Audit untuk Ketidaksesuaian Kategori Kritikal</label>
                            <div class="col-6">
                                <x-inputs.text
                                    id="data_audit_2"
                                    error="data_audit_2"
                                    wire:model="data_audit_2"
                                    type="text"
                                ></x-inputs.text>
                            </div>
                        </div>

                        <div class="row form-group">
                            <label for="data_audit_3" class="col col-form-label">Status Penyelesaian Tindak Lanjut Audit untuk Ketidaksesuaian Kategori Mayor</label>
                            <div class="col-6">
                                <x-inputs.text
                                    id="data_audit_3"
                                    error="data_audit_3"
                                    wire:model="data_audit_3"
                                    type="text"
                                ></x-inputs.text>
                            </div>
                        </div>

                        <div class="row form-group">
                            <label for="data_audit_4" class="col col-form-label">Status Penyelesaian Tindak Lanjut Audit untuk Ketidaksesuaian Kategori Minor</label>
                            <div class="col-6">
                                <x-inputs.text
                                    id="data_audit_4"
                                    error="data_audit_4"
                                    wire:model="data_audit_4"
                                    type="text"
                                ></x-inputs.text>
                            </div>
                        </div>

                        <div class="row form-group">
                            <label for="data_audit_5" class="col col-form-label">Catatan Hasil Evaluasi dari Instansi Pembina Sektor</label>
                            <div class="col-6">
                                <x-inputs.text
                                    id="data_audit_5"
                                    error="data_audit_5"
                                    wire:model="data_audit_5"
                                    type="text"
                                ></x-inputs.text>
                            </div>
                        </div>

                        <div class="row form-group">
                            <label for="previous_period_year" class="col col-form-label">Periode Audit Tahun Sebelumnya</label>
                            <div class="col-6">
                                <x-inputs.text
                                    id="previous_period_year"
                                    error="previous_period_year"
                                    wire:model="previous_period_year"
                                    type="number"
                                ></x-inputs.text>
                            </div>
                        </div>

                        <div class="row form-group">
                            <label for="internal_audit_verification_year" class="col col-form-label">Periode Verifikasi Audit Internal SMKP</label>
                            <div class="col-6">
                                <x-inputs.text
                                    id="internal_audit_verification_year"
                                    error="internal_audit_verification_year"
                                    wire:model="internal_audit_verification_year"
                                    type="number"
                                ></x-inputs.text>
                            </div>
                        </div>

                        <div class="row form-group">
                            <label for="achievement_assessment_verification_year" class="col col-form-label">Verifikasi Penilaian Prestasi Pengelolaan Keselamatan Pertambangan</label>
                            <div class="col-6">
                                <x-inputs.text
                                    id="achievement_assessment_verification_year"
                                    error="achievement_assessment_verification_year"
                                    wire:model="achievement_assessment_verification_year"
                                    type="number"
                                ></x-inputs.text>
                            </div>
                        </div>

                        <h6 class="mt-2">Masukan dari Pemangku Kepentingan</h6>
                        <div class="loop-element d-flex flex-column gap-3">
                            @foreach($stakeholders as $data)
                                <div class="items-loop row">
                                    <div class="col-12 d-flex flex-column gap-3">
                                        <div class="row form-group">
                                            <label for="title" class="col col-form-label">Masukan</label>
                                            <div class="col-6">
                                                <div class="row">
                                                    <div class="col-10">
                                                        <x-inputs.text id="role[{{$loop->index}}]" disabled error=""
                                                                       value="{{$data->stakeholder_input}}"></x-inputs.text>
                                                    </div>
                                                    <div class="col-2">
                                                        <button type="button" class="btn btn-danger btn-small"
                                                                wire:click="deleteStakeholder('{{$data->id}}')">&times;
                                                        </button>
                                                    </div>
                                                </div>

                                            </div>

                                        </div>

                                    </div>
                                </div>
                            @endforeach
                            <div class="add_loop">
                                <button type="button" class="btn btn-outline-success d-block" data-bs-toggle="modal"
                                        data-bs-target="#modalStakeholder">+ Add
                                </button>
                            </div>
                        </div>
                    </div>

                    <div class="content-form d-flex flex-column gap-3">
                        <h6>C. Penyiapan Dokumen Kerja</h6>    
                        <div class="row form-group">
                            <label for="sampling_plan_number" class="col col-form-label">Nomor Rencana Sampling yang dimuat pada Formulir Rencana Audit</label>
                            <div class="col-6">
                                <x-inputs.text
                                    id="sampling_plan_number"
                                    error="sampling_plan_number"
                                    wire:model="sampling_plan_number"
                                    type="text"
                                ></x-inputs.text>
                            </div>
                        </div>

                        <div class="row form-group">
                            <label for="audit_conformity_number" class="col col-form-label">Nomor Formulir Kesesuaian Audit</label>
                            <div class="col-6">
                                <x-inputs.text
                                    id="audit_conformity_number"
                                    error="audit_conformity_number"
                                    wire:model="audit_conformity_number"
                                    type="text"
                                ></x-inputs.text>
                            </div>
                        </div>

                        <div class="row form-group">
                            <label for="audit_non_conformity_number" class="col col-form-label">Nomor Formulir Ketidaksesuaian dan Tindak Lanjut Ketidaksesuaian Audit</label>
                            <div class="col-6">
                                <x-inputs.text
                                    id="audit_non_conformity_number"
                                    error="audit_non_conformity_number"
                                    wire:model="audit_non_conformity_number"
                                    type="text"
                                ></x-inputs.text>
                            </div>
                        </div>

                        <div class="row form-group">
                            <label for="non_conformity_recapitulation_number" class="col col-form-label">Nomor Formulir Rekapitulasi Ketidaksesuaian</label>
                            <div class="col-6">
                                <x-inputs.text
                                    id="non_conformity_recapitulation_number"
                                    error="non_conformity_recapitulation_number"
                                    wire:model="non_conformity_recapitulation_number"
                                    type="text"
                                ></x-inputs.text>
                            </div>
                        </div>

                        <div class="row form-group">
                            <label for="follow_up_plan_number" class="col col-form-label">Nomor Formulir Rencana Tindak Lanjut Audit</label>
                            <div class="col-6">
                                <x-inputs.text
                                    id="follow_up_plan_number"
                                    error="follow_up_plan_number"
                                    wire:model="follow_up_plan_number"
                                    type="text"
                                ></x-inputs.text>
                            </div>
                        </div>

                        <div class="row form-group">
                            <label for="recommendation_number" class="col col-form-label">Nomor Formulir Rekomendasi dan Peluang untuk Perbaikan</label>
                            <div class="col-6">
                                <x-inputs.text
                                    id="recommendation_number"
                                    error="recommendation_number"
                                    wire:model="recommendation_number"
                                    type="text"
                                ></x-inputs.text>
                            </div>
                        </div>

                        <div class="row form-group">
                            <label for="meeting_recording_number" class="col col-form-label">Nomor Formulir Rekaman Rapat</label>
                            <div class="col-6">
                                <x-inputs.text
                                    id="meeting_recording_number"
                                    error="meeting_recording_number"
                                    wire:model="meeting_recording_number"
                                    type="text"
                                ></x-inputs.text>
                            </div>
                        </div>

                        <div class="row form-group">
                            <label for="initial_implementation_date" class="col col-form-label">Berita Acara Hasil Pelaksanaan Tahapan Awal Audit Internal Sistem Manajemen Keselamatan Pertambangan ini dibuat pada tanggal</label>
                            <div class="col-6">
                                <x-inputs.datepicker placeholder="" wire:model="initial_implementation_date" id="initial_implementation_date" :error="'initial_implementation_date'"></x-inputs.datepicker>
                            </div>
                        </div>

                    </div>

                    <div class="footer-action mb-2 p-3">
                        <div class="action-wrapper d-flex align-items-center justify-content-end gap-2">

                            <div class="form-group d-flex justify-content-end gap-2">
                                
                                <!-- <button type="button" class="btn btn-outline-secondary" wire:loading.remove
                                        wire:target='saveStatus'
                                        wire:click="">Save as Draft
                                </button> -->
                                <a href="{{route('audit::smkp.detail.implementation-report.export-word',['id'=>$audit->id])}}" class="btn btn-outline-danger">Export</a>
                                <button
                                    class="btn btn-outline-default bg-green d-flex justify-content-center align-item-center text-white position-relative px-4"
                                    wire:loading.remove wire:target='saveStatus'
                                    type="button"
                                    wire:click="saveCalculatingMandays">
                                    Submit
                                </button>
                                <x-button-spinner
                                    target="saveStatus"
                                    :text="trans('global.processing')"></x-button-spinner>

                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<script type="text/javascript">
    function isNumberKey(txt, evt) {
        var charCode = (evt.which) ? evt.which : evt.keyCode;
        if (charCode === 46) {
            //Check if the text already contains the . character
            if (txt.value.indexOf('.') === -1) {
                return true;
            } else {
                return false;
            }
        } else {
            if (charCode > 31 &&
                (charCode < 48 || charCode > 57))
                return false;
        }
        return true;
    }

    function isNumericOnly(txt, evt) {
        var charCode = (evt.which) ? evt.which : evt.keyCode;

        return !(charCode > 31 &&
            (charCode < 48 || charCode > 57));

    }

</script>

@push('scripts')
    <script>
        window.addEventListener('closeModal', event => {
            $('.modal').modal('hide');
        });
        window.addEventListener('openTeamModal', event => {
            $('#modalFormTeam').modal('show');
        });
    </script>
@endpush
@once
    @push('styles')
        <!-- Select2 -->
        <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet"/>
        <link rel="stylesheet"
              href="https://cdn.jsdelivr.net/npm/select2-bootstrap-5-theme@1.3.0/dist/select2-bootstrap-5-theme.min.css"/>
    @endpush
@endonce

@once
    @push('scripts')
        <!-- Select2 -->
        <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    @endpush
@endonce

@push('scripts')
    <script>
        $(function () {
            $('.select2-multiple').select2({
                theme: 'bootstrap-5',
            });

            $(document).on('change', '.select2-multiple', function (e) {
                var data = $(this).select2("val");
                let elementName = $(this).attr('id');
                @this.
                set(elementName, data);
            });
        })
    </script>
@endpush