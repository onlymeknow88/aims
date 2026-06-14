@push('styles')
    <style>
        td.bx-0 {
            border-left: none;
            border-right: none;
        }

        td.bl {
            border-left: 1px solid #ddd;
        }

        td.bb {
            border-bottom: 1px solid #ddd;
        }

        .tabs-link {
            display: flex;
            flex-wrap: wrap;
            padding-left: 0;
            margin-bottom: 0;
            list-style: none;
            border-bottom: 1px solid #dee2e6;
        }

        .tab-link {
            margin-bottom: -1px;
            background: 0 0;
            border: 1px solid transparent;
            border-top-left-radius: 0.25rem;
            border-top-right-radius: 0.25rem;
            display: block;
            padding: 0.5rem 1rem;
            color: #00552f;
            text-decoration: none;
            transition: color .15s ease-in-out, background-color .15s ease-in-out, border-color .15s ease-in-out;
        }

        .tab-link.active {
            color: #495057;
            background-color: #fff;
            border-color: #dee2e6 #dee2e6 #fff;
        }

        .tab-content {
            padding: 15px;
        }
    </style>
@endpush
<x-slot name="sidebar">
    @livewire('audit::layouts.sidebar-' . $module_category, ['id' => $audit->id])
</x-slot>
<div class="inner-content with_right_sidebar">
    <div class="wrapper_with_sidebar_right" x-data="{ tab: window.location.hash ? window.location.hash : '#summary' }">

        <div class="tabs-link">

            <a class="tab-link" href="#summary" x-on:click="tab='#summary'"
                :class="tab == '#summary' && 'active'">Summary</a>

            @foreach ($this->locations as $location)
                <a class="tab-link" href="#tab_{{ $location->id }}" x-on:click="tab='#tab_{{ $location->id }}'"
                    :class="tab == '#tab_{{ $location->id }}' && 'active'">{{ $location->location }}</a>
            @endforeach

        </div>

        <div class="tab-content" id="myTabContent">

            <div id="summary" role="tabpanel" aria-labelledby="summary-tab" x-show="tab == '#summary'">
                <div class="section-content">

                    <div class="row justify-content-center">

                        <div class="form-wrapper col-sm-8">
                            <div class="title-form text-center p-2">
                                <h3>KRITERIA AUDIT</h3>
                            </div><!-- /.title-form -->
                            <form class="py-4 d-flex flex-column gap-5">
                                <div class="title-form text-left mb-3">
                                    <h4>RINGKASAN DARI SETIAP LOKASI</h4>

                                    @if ($auditSubCriteria->parent)
                                        @if ($auditSubCriteria->parent->parent)
                                            @if ($auditSubCriteria->parent->parent->parent)
                                                <h6>{{ $auditSubCriteria->parent->parent->parent->title }}</h5><br>
                                            @endif
                                            <h6>{{ $auditSubCriteria->parent->parent->title }}</h5><br>
                                        @endif
                                        <h6>{{ $auditSubCriteria->parent->title }}</h5><br>
                                    @endif
                                    {{ $auditSubCriteria->title }}
                                </div><!-- /.title-form -->
                                <div class="content-form d-flex flex-column gap-3">

                                    <div class="row form-group">
                                        <label for="point" class="col col-form-label">Nilai Sub Elemen</label>
                                        <div class="col-9">

                                            @if ($critical && !$critical_done)
                                                <x-inputs.select2 wire:model="point" id="point"
                                                    placeholder="Pilih Nilai Sub Elemen" disabled>
                                                    @foreach ($auditSubCriteria->list_points as $point)
                                                        <option value="{{ $point->point }}">{{ $point->point }}
                                                        </option>
                                                    @endforeach
                                                </x-inputs.select2>
                                            @else
                                                <x-inputs.select2 wire:model="point" id="point"
                                                    placeholder="Pilih Nilai Sub Elemen">
                                                    @foreach ($auditSubCriteria->list_points as $point)
                                                        <option value="{{ $point->point }}">{{ $point->point }}
                                                        </option>
                                                    @endforeach
                                                </x-inputs.select2>
                                            @endif
                                        </div>

                                    </div><!-- /.form-group nilai_sub_elemen -->

                                    <div class="row form-group">
                                        <label for="keterangan"
                                            class="col col-form-label d-flex flex-column">Keterangan</label>
                                        <div class="col-9">
                                            @if ($critical && !$critical_done)
                                                <x-inputs.texteditor-custom-audit wire:model="description"
                                                    id="description" placeholder="Keterangan Audit"
                                                    error="'description'" disabled />
                                            @else
                                                <x-inputs.texteditor-custom-audit wire:model="description"
                                                    id="description" placeholder="Keterangan Audit"
                                                    error="'description'" />
                                            @endif
                                        </div>
                                    </div><!-- /.form-group keterangan -->

                                    @if (isset($status))
                                        <div class="row form-group">
                                            <span class="col col-form-label d-flex flex-column">Konfirmasi</span>
                                            <div class="col-9">
                                                <div class="btn-group" role="group"
                                                    aria-label="Basic radio toggle button group">

                                                    <button class="btn btn-outline-primary" type="button"
                                                        wire:click="confirm">{{ $status == 'non relation' ? 'Non Relation' : ($status == 'non confirmance' ? 'Non Confirmance ' : 'Confirmance') }}
                                                    </button>

                                                </div>
                                            </div>
                                        </div><!-- /.form-group keterangan -->
                                        <div class="space">
                                            <hr>
                                        </div>
                                    @endif

                                    @if ($isConfirm && !$isRelation)
                                        <div class="confirmance_wrapper">

                                            <div class="inner_confirmance d-flex flex-column gap-3">

                                                <div class="row form-group">
                                                    <label for="fix_recommendation"
                                                        class="col col-form-label d-flex flex-column">Rekomendasi
                                                        Peluang Perbaikan</label>
                                                    <div class="col-9">

                                                        @if ($critical && !$critical_done)
                                                            <x-inputs.texteditor-custom-audit
                                                                wire:model="fix_recommendation" id="fix_recommendation"
                                                                placeholder="Rekomendasi Peluang Perbaikan"
                                                                error="fix_recommendation" disabled />
                                                        @else
                                                            <x-inputs.texteditor-custom-audit
                                                                wire:model="fix_recommendation" id="fix_recommendation"
                                                                placeholder="Rekomendasi Peluang Perbaikan"
                                                                error="fix_recommendation" />
                                                        @endif
                                                    </div>
                                                </div><!-- /.form-group rekomendasi -->

                                            </div><!-- /.inner_confirmance -->

                                        </div><!-- /.confirmance_wrapper -->
                                    @endif

                                    @if (isset($isConfirm) && !$isConfirm && (isset($isRelation) && !$isRelation))
                                        <div class="non_confirmance_wrapper">

                                            <div class="inner_non_confirmance d-flex flex-column gap-3">

                                                <div class="row form-group">
                                                    <label for="non_confirmance_number"
                                                        class="col col-form-label d-flex flex-column">Non
                                                        Confirmance Number</label>
                                                    <div class="col-9">
                                                        <x-inputs.text wire:model="non_confirmance_number"
                                                            id="non_confirmance_number" disabled
                                                            placeholder="No Non Confirmance"
                                                            error="non_confirmance_number" />
                                                    </div>
                                                </div><!-- /.form-group no_non_confirmance -->

                                                <div class="row form-group">
                                                    <label for="problem_description"
                                                        class="col col-form-label d-flex flex-column">
                                                        <span>Uraian Masalah</span>
                                                        <span class="fst-italic">Problem</span>
                                                    </label>
                                                    <div class="col-9">
                                                        @if ($critical && !$critical_done)
                                                            <x-inputs.texteditor-custom-audit
                                                                wire:model="problem_description"
                                                                id="problem_description" placeholder="Uraian Masalah"
                                                                error="problem_description" disabled />
                                                        @else
                                                            <x-inputs.texteditor-custom-audit
                                                                wire:model="problem_description"
                                                                id="problem_description" placeholder="Uraian Masalah"
                                                                error="problem_description" />
                                                        @endif
                                                        @error('problem_description')
                                                            <div class="is-invalid">
                                                            </div>
                                                            <div class="invalid-feedback">
                                                                {{ $message }}
                                                            </div>
                                                        @enderror
                                                    </div>
                                                </div><!-- /.form-group masalah -->

                                                <div class="row form-group">
                                                    <label for="area" class="col col-form-label d-flex flex-column">
                                                        <span>Area / Lokasi & Departemen</span>
                                                        <span class="fst-italic">Location</span>
                                                    </label>
                                                    <div class="col-9">
                                                        @if ($critical && !$critical_done)
                                                            <x-inputs.texteditor-custom-audit
                                                                wire:model="area_location_department"
                                                                id="area_location_department"
                                                                placeholder="Area / Lokasi & Departemen"
                                                                error="area_location_department" disabled />
                                                        @else
                                                            <x-inputs.texteditor-custom-audit
                                                                wire:model="area_location_department"
                                                                id="area_location_department"
                                                                placeholder="Area / Lokasi & Departemen"
                                                                error="area_location_department" />
                                                        @endif
                                                        @error('area_location_department')
                                                            <div class="is-invalid">
                                                            </div>
                                                            <div class="invalid-feedback">
                                                                {{ $message }}
                                                            </div>
                                                        @enderror
                                                    </div>
                                                </div><!-- /.form-group area -->

                                                <div class="row form-group">
                                                    <label for="bukti"
                                                        class="col col-form-label d-flex flex-column">
                                                        <span>Bukti</span>
                                                        <span class="fst-italic">Objective Evidence</span>
                                                    </label>
                                                    <div class="col-9">
                                                        @if ($critical && !$critical_done)
                                                            <x-inputs.texteditor-custom-audit wire:model="proof"
                                                                id="proof" placeholder="Bukti" error="proof"
                                                                disabled />
                                                        @else
                                                            <x-inputs.texteditor-custom-audit wire:model="proof"
                                                                id="proof" placeholder="Bukti" error="proof" />
                                                        @endif
                                                        @error('proof')
                                                            <div class="is-invalid">
                                                            </div>
                                                            <div class="invalid-feedback">
                                                                {{ $message }}
                                                            </div>
                                                        @enderror
                                                    </div>
                                                </div><!-- /.form-group bukti -->

                                                <div class="row form-group">
                                                    <label for="referensi"
                                                        class="col col-form-label d-flex flex-column">
                                                        <span>Referensi</span>
                                                        <span class="fst-italic">Reference</span>
                                                    </label>
                                                    <div class="col-9">
                                                        <ul>
                                                            <li>{{ $auditSubCriteria->criteria->title }}</li>
                                                            @if ($auditSubCriteria->parent)
                                                                <li>{{ $auditSubCriteria->parent->title }}</li>
                                                            @endif
                                                        </ul>
                                                    </div>
                                                </div><!-- /.form-group referensi -->

                                                <div class="row form-group">
                                                    <label for="description"
                                                        class="col col-form-label d-flex flex-column">
                                                        <span>Deskripsi</span>
                                                        <span class="fst-italic">Description</span>
                                                    </label>
                                                    <div class="col-9">
                                                        @if ($critical && !$critical_done)
                                                            <x-inputs.texteditor-custom-audit
                                                                wire:model="non_confirmance_description"
                                                                id="non_confirmance_description"
                                                                placeholder="Deskripsi"
                                                                error="non_confirmance_description" disabled />
                                                        @else
                                                            <x-inputs.texteditor-custom-audit
                                                                wire:model="non_confirmance_description"
                                                                id="non_confirmance_description"
                                                                placeholder="Deskripsi"
                                                                error="non_confirmance_description" />
                                                        @endif
                                                        @error('non_confirmance_description')
                                                            <div class="is-invalid">
                                                            </div>
                                                            <div class="invalid-feedback">
                                                                {{ $message }}
                                                            </div>
                                                        @enderror
                                                    </div>
                                                </div><!-- /.form-group deskripsi -->
                                                <div class="row form-group">

                                                    {{-- <span class="col col-form-label">Apakah masuk kategori
                                                            kritikal?</span> --}}
                                                    <span class="col col-form-label"></span>

                                                    <div class="col-9">

                                                        @if ($critical)
                                                            <div class="form-check mb-5">
                                                                {{-- <input class="form-check-input" id="category"
                                                                        wire:model='category' type="checkbox"
                                                                        disabled> --}}
                                                                @if (auth()->user()->hasRole('Audit - Lead Auditor'))
                                                                    <input class="form-check-input"
                                                                        wire:change="IsCritical()"
                                                                        wire:model='critical' {{-- wire:change="IsCritical('{{ $location->id }}')" --}}
                                                                        type="checkbox" {{-- value="1" --}}
                                                                        id="critical">
                                                                @else
                                                                    <input class="form-check-input"
                                                                        wire:model='critical' type="checkbox"
                                                                        id="critical" disabled>
                                                                @endif
                                                                <label class="form-check-label" for="critical">
                                                                    Apakah masuk kategori kritikal?
                                                                </label>
                                                            </div>
                                                            @if (auth()->user()->hasAnyPermission(['Audit - Lead Auditor']))
                                                                {{-- @can('Audit - Lead Auditor') --}}
                                                                <div class="form-check mb-5">
                                                                    <input
                                                                        class="form-check-input @error('critical_done') is-invalid @enderror"
                                                                        wire:change="IsCriticalDone()"
                                                                        wire:model='critical_done' type="checkbox"
                                                                        {{-- value="critical" --}} id="critical_done">
                                                                    <label class="form-check-label"
                                                                        for="critical_done">
                                                                        Apakah sudah dilakukan tindakan perbaikan?
                                                                    </label>
                                                                </div>
                                                                {{-- @endcan --}}
                                                            @else
                                                                <div class="form-check mb-5">
                                                                    <input class="form-check-input"
                                                                        wire:model='critical_done' type="checkbox"
                                                                        id="critical_done" disabled>
                                                                    <label class="form-check-label"
                                                                        for="critical_done">
                                                                        Apakah sudah dilakukan tindakan perbaikan?
                                                                    </label>
                                                                </div>
                                                            @endif
                                                        @else
                                                            <div class="form-check mb-5">
                                                                <input
                                                                    class="form-check-input @error('critical') is-invalid @enderror"
                                                                    wire:change="IsCritical()" wire:model='critical'
                                                                    type="checkbox" {{-- value="1" --}}
                                                                    id="critical">
                                                                <label class="form-check-label" for="critical">
                                                                    Apakah masuk kategori kritikal?
                                                                </label>
                                                            </div>
                                                        @endif
                                                    </div>
                                                    @error('critical')
                                                        <div class="is-invalid">
                                                        </div>
                                                        <div class="invalid-feedback">
                                                            {{ $message }}
                                                        </div>
                                                    @enderror
                                                </div><!-- /.form-group kategori -->
                                                <div class="row form-group">
                                                    <label for="batas_waktu" class="col col-form-label">Batas
                                                        Waktu
                                                        Perbaikan</label>
                                                    <div class="col-9">
                                                        @if ($critical && !$critical_done)
                                                            <x-inputs.datepicker wire:model="due_date" id="due_date"
                                                                error="due_date" disabled />
                                                        @else
                                                            <x-inputs.datepicker wire:model="due_date" id="due_date"
                                                                error="due_date" />
                                                        @endif
                                                    </div>
                                                </div><!-- /.form-group batas_waktu -->

                                                <div class="row form-group">
                                                    <label for="audit_team_id" class="col-3 col-form-label">Nama
                                                        Auditor<i style="color:red">*</i></label>
                                                    <div class="col-4">

                                                        @if ($critical && !$critical_done)
                                                            <x-inputs.select2 wire:model="audit_team_id"
                                                                id="audit_team_id" placeholder="Nama Auditor"
                                                                error="audit_team_id" disabled>
                                                                @foreach ($teams as $team)
                                                                    <option value="{{ $team->id }}">
                                                                        {{ $team->name }}
                                                                    </option>
                                                                @endforeach
                                                            </x-inputs.select2>
                                                        @else
                                                            <x-inputs.select2 wire:model="audit_team_id"
                                                                id="audit_team_id" placeholder="Nama Auditor"
                                                                error="audit_team_id">
                                                                @foreach ($teams as $team)
                                                                    <option value="{{ $team->id }}">
                                                                        {{ $team->name }}
                                                                    </option>
                                                                @endforeach
                                                            </x-inputs.select2>
                                                        @endif
                                                    </div>
                                                    <label for="auditor_date"
                                                        class="col-2 col-form-label">Tanggal</label>
                                                    <div class="col-3">
                                                        @if ($critical && !$critical_done)
                                                            <x-inputs.datepicker wire:model="auditor_date"
                                                                id="auditor_date" error="auditor_date" disabled />
                                                        @else
                                                            <x-inputs.datepicker wire:model="auditor_date"
                                                                id="auditor_date" error="auditor_date" />
                                                        @endif
                                                    </div>
                                                </div><!-- /.form-group nama_auditor -->

                                                <div class="row form-group mb-5">
                                                    <label for="auditee" class="col-3 col-form-label">Nama
                                                        Auditi <i style="color:red">*</i></label>
                                                    <div class="col-4">
                                                        @if ($critical && !$critical_done)
                                                            <x-inputs.text wire:model="auditee" id="auditee"
                                                                placeholder="Nama Auditi" error="auditee" disabled />
                                                        @else
                                                            <x-inputs.text wire:model="auditee" id="auditee"
                                                                placeholder="Nama Auditi" error="auditee" />
                                                        @endif
                                                    </div>
                                                    <label for="tanggal_auditi"
                                                        class="col-2 col-form-label">Tanggal</label>
                                                    <div class="col-3">
                                                        @if ($critical && !$critical_done)
                                                            <x-inputs.datepicker wire:model="auditee_date"
                                                                id="auditee_date" error="auditee_date" disabled />
                                                        @else
                                                            <x-inputs.datepicker wire:model="auditee_date"
                                                                id="auditee_date" error="auditee_date" />
                                                        @endif
                                                    </div>
                                                </div><!-- /.form-group nama_auditi -->

                                                <h6>Tidak Lanjut Audit</h6>

                                                <div class="row form-group">
                                                    <label for="akar_masalah" class="col col-form-label">Investigasi
                                                        Akar
                                                        Masalah</label>
                                                    <div class="col-9">
                                                        @if ($critical && !$critical_done)
                                                            <x-inputs.texteditor-custom-audit
                                                                wire:model="root_cause_investigation"
                                                                id="root_cause_investigation"
                                                                placeholder="Investigasi Akar Masalah"
                                                                error="root_cause_investigation" disabled />
                                                        @else
                                                            <x-inputs.texteditor-custom-audit
                                                                wire:model="root_cause_investigation"
                                                                id="root_cause_investigation"
                                                                placeholder="Investigasi Akar Masalah"
                                                                error="root_cause_investigation" />
                                                        @endif
                                                        @error('root_cause_investigation')
                                                            <div class="is-invalid">
                                                            </div>
                                                            <div class="invalid-feedback">
                                                                {{ $message }}
                                                            </div>
                                                        @enderror
                                                    </div>
                                                </div><!-- /.form-group akar_masalah -->

                                                <div class="row form-group">
                                                    <label for="fix_action" class="col col-form-label">Tindakan
                                                        Perbaikan</label>
                                                    <div class="col-9">
                                                        @if ($critical && !$critical_done)
                                                            <x-inputs.texteditor-custom-audit wire:model="fix_action"
                                                                id="fix_action" placeholder="Tindakan Perbaikan"
                                                                error="fix_action" disabled />
                                                        @else
                                                            <x-inputs.texteditor-custom-audit wire:model="fix_action"
                                                                id="fix_action" placeholder="Tindakan Perbaikan"
                                                                error="fix_action" />
                                                        @endif
                                                        @error('fix_action')
                                                            <div class="is-invalid">
                                                            </div>
                                                            <div class="invalid-feedback">
                                                                {{ $message }}
                                                            </div>
                                                        @enderror
                                                    </div>
                                                </div><!-- /.form-group tindakan_perbaikan -->

                                            </div><!-- inner_non_confirmance -->

                                        </div><!-- /.non_confirmance_wrapper -->
                                    @endif


                                </div><!-- /.content-form -->
                                @if (isset($isConfirm) || isset($isRelation))
                                    <div class="footer-action mb-2">
                                        <div
                                            class="action-wrapper d-flex align-items-center justify-content-end gap-2">
                                            <!-- <a href="" class="btn btn-outline-secondary">Cancel</a> -->
                                            <button type="button" wire:click="save"
                                                class="btn btn-outline-default bg-green d-flex justify-content-center align-item-center text-white position-relative px-4">
                                                Simpan
                                            </button>
                                        </div>
                                    </div>
                                @endif

                            </form>
                        </div><!-- /.form-wrapper -->
                        <div class="col-sm-3" style="padding-top:170px">
                            <div class="row">
                                <div class="col-sm-12" style="padding:5px"><b>Nilai Sub Elemen</b></div>
                            </div>
                            @foreach ($auditSubCriteria->list_points as $list_point)
                                <div class="row">
                                    <div class="col-sm-12" style="padding:5px">
                                        Nilai : {{ $list_point->point }}
                                    </div>
                                    <div class="col-sm-12" style="padding:5px">
                                        {{ $list_point->tooltip }}
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>

                </div><!-- /.section-content-->
            </div>

            @foreach ($this->locations as $index => $location)
                <div x-show="tab == '#tab_{{ $location->id }}'" x-cloak>

                    <div class="section-content">

                        <div class="row justify-content-center">

                            <div class="form-wrapper col-sm-8">
                                <div class="title-form text-center p-2">
                                    <h3>KRITERIA AUDIT</h3>
                                </div><!-- /.title-form -->
                                <form class="py-4 d-flex flex-column gap-5">
                                    <div class="title-form text-left mb-3">

                                        @if ($auditSubCriteria->parent)
                                            @if ($auditSubCriteria->parent->parent)
                                                @if ($auditSubCriteria->parent->parent->parent)
                                                    <h6>{{ $auditSubCriteria->parent->parent->parent->title }}</h5><br>
                                                @endif
                                                <h6>{{ $auditSubCriteria->parent->parent->title }}</h5><br>
                                            @endif
                                            <h6>{{ $auditSubCriteria->parent->title }}</h5><br>
                                        @endif
                                        {{ $auditSubCriteria->title }}
                                    </div><!-- /.title-form -->
                                    <div class="content-form d-flex flex-column gap-3">

                                        <div class="row form-group">
                                            <label for="point_{{ $location->id }}" class="col col-form-label">Nilai
                                                Sub Elemen</label>
                                            <div class="col-9">
                                                {{-- @if ($this->{'category_' . $location->id} == 'critical' && $this->{'is_critical_done_' . $location->id} != 'done') --}}
                                                @if ($critical && !$critical_done)
                                                    <x-inputs.select2 class="form-control"
                                                        id="point_{{ $location->id }}"
                                                        placeholder="Pilih Nilai Sub Elemen" disabled>
                                                        <option></option>

                                                        @foreach ($auditSubCriteria->list_points as $point)
                                                            <option value="{{ $point->point }}">
                                                                {{ $point->point }}
                                                            </option>
                                                        @endforeach
                                                    </x-inputs.select2>
                                                @else
                                                    <select class="form-control"
                                                        wire:model="point_{{ $location->id }}"
                                                        wire:change="PointLocation('{{ $location->id }}')"
                                                        id="point_{{ $location->id }}"
                                                        placeholder="Pilih Nilai Sub Elemen">
                                                        <option></option>

                                                        @foreach ($auditSubCriteria->list_points as $point)
                                                            <option value="{{ $point->point }}">
                                                                {{ $point->point }}
                                                            </option>
                                                        @endforeach
                                                    </select>
                                                @endif
                                            </div>

                                        </div><!-- /.form-group nilai_sub_elemen -->

                                        <div class="row form-group">
                                            <label for="description{{ $location->id }}"
                                                class="col col-form-label d-flex flex-column">Keterangan</label>
                                            <div class="col-9">
                                                @if ($critical && !$critical_done)
                                                    <x-inputs.texteditor-custom-audit
                                                        wire:model="description_{{ $location->id }}"
                                                        id="description_{{ $location->id }}"
                                                        placeholder="Keterangan Audit"
                                                        error="'description_{{ $location->id }}'" disabled />
                                                @else
                                                    <x-inputs.texteditor-custom-audit
                                                        wire:model="description_{{ $location->id }}"
                                                        id="description_{{ $location->id }}"
                                                        placeholder="Keterangan Audit"
                                                        error="'description_{{ $location->id }}'" />
                                                @endif
                                            </div>
                                        </div><!-- /.form-group keterangan -->

                                        @if (isset($this->{'status_' . $location->id}))
                                            <div class="row form-group">
                                                <span class="col col-form-label d-flex flex-column">Konfirmasi</span>
                                                <div class="col-9">
                                                    <div class="btn-group" role="group"
                                                        aria-label="Basic radio toggle button group">
                                                        <button class="btn btn-outline-primary" type="button"
                                                            disabled>{{ $this->{'status_' . $location->id} == 'non relation' ? 'Non Relation' : ($this->{'status_' . $location->id} == 'non confirmance' ? 'Non Confirmance ' : 'Confirmance') }}
                                                        </button>

                                                    </div>
                                                </div>
                                            </div><!-- /.form-group keterangan -->
                                            <div class="space">
                                                <hr>
                                            </div>
                                        @endif

                                        @if ($this->{'status_' . $location->id} == 'confirmance')
                                            <div class="confirmance_wrapper">

                                                <div class="inner_confirmance d-flex flex-column gap-3">

                                                    <div class="row form-group">
                                                        <label for="fix_recommendation_{{ $location->id }}"
                                                            class="col col-form-label d-flex flex-column">Rekomendasi
                                                            Peluang Perbaikan</label>
                                                        <div class="col-9">
                                                            @if ($critical && !$critical_done)
                                                                <x-inputs.texteditor-custom-audit
                                                                    wire:model="fix_recommendation_{{ $location->id }}"
                                                                    id="fix_recommendation_{{ $location->id }}"
                                                                    placeholder="Rekomendasi Peluang Perbaikan"
                                                                    error="fix_recommendation_{{ $location->id }}"
                                                                    disabled />
                                                            @else
                                                                <x-inputs.texteditor-custom-audit
                                                                    wire:model="fix_recommendation_{{ $location->id }}"
                                                                    id="fix_recommendation_{{ $location->id }}"
                                                                    placeholder="Rekomendasi Peluang Perbaikan"
                                                                    error="fix_recommendation_{{ $location->id }}" />
                                                            @endif
                                                        </div>
                                                    </div><!-- /.form-group rekomendasi -->

                                                </div><!-- /.inner_confirmance -->

                                            </div><!-- /.confirmance_wrapper -->
                                        @endif

                                        @if ($this->{'status_' . $location->id} == 'non confirmance')
                                            <div class="non_confirmance_wrapper">

                                                <div class="inner_non_confirmance d-flex flex-column gap-3">

                                                    <div class="row form-group">
                                                        <label for="problem_description_{{ $location->id }}"
                                                            class="col col-form-label d-flex flex-column">
                                                            <span>Uraian Masalah</span>
                                                            <span class="fst-italic">Problem</span>
                                                        </label>
                                                        <div class="col-9">
                                                            @if ($critical && !$critical_done)
                                                                <x-inputs.texteditor-custom-audit
                                                                    wire:model="problem_description_{{ $location->id }}"
                                                                    id="problem_description_{{ $location->id }}"
                                                                    placeholder="Uraian Masalah"
                                                                    error="problem_description_{{ $location->id }}"
                                                                    disabled />
                                                            @else
                                                                <x-inputs.texteditor-custom-audit
                                                                    wire:model="problem_description_{{ $location->id }}"
                                                                    id="problem_description_{{ $location->id }}"
                                                                    placeholder="Uraian Masalah"
                                                                    error="problem_description_{{ $location->id }}" />
                                                            @endif
                                                            @error('problem_description_{{ $location->id }}')
                                                                <div class="is-invalid">
                                                                </div>
                                                                <div class="invalid-feedback">
                                                                    {{ $message }}
                                                                </div>
                                                            @enderror
                                                        </div>
                                                    </div><!-- /.form-group masalah -->

                                                    <div class="row form-group">
                                                        <label for="area_location_department_{{ $location->id }}"
                                                            class="col col-form-label d-flex flex-column">
                                                            <span>Area / Lokasi & Departemen</span>
                                                            <span class="fst-italic">Location</span>
                                                        </label>
                                                        <div class="col-9">
                                                            @if ($critical && !$critical_done)
                                                                <x-inputs.texteditor-custom-audit
                                                                    wire:model="area_location_department_{{ $location->id }}"
                                                                    id="area_location_department_{{ $location->id }}"
                                                                    placeholder="Area / Lokasi & Departemen"
                                                                    error="area_location_department_{{ $location->id }}"
                                                                    disabled />
                                                            @else
                                                                <x-inputs.texteditor-custom-audit
                                                                    wire:model="area_location_department_{{ $location->id }}"
                                                                    id="area_location_department_{{ $location->id }}"
                                                                    placeholder="Area / Lokasi & Departemen"
                                                                    error="area_location_department_{{ $location->id }}" />
                                                            @endif
                                                            @error('area_location_department_{{ $location->id }}')
                                                                <div class="is-invalid">
                                                                </div>
                                                                <div class="invalid-feedback">
                                                                    {{ $message }}
                                                                </div>
                                                            @enderror
                                                        </div>
                                                    </div><!-- /.form-group area -->

                                                    <div class="row form-group">
                                                        <label for="proof_{{ $location->id }}"
                                                            class="col col-form-label d-flex flex-column">
                                                            <span>Bukti</span>
                                                            <span class="fst-italic">Objective Evidence</span>
                                                        </label>
                                                        <div class="col-9">
                                                            @if ($critical && !$critical_done)
                                                                <x-inputs.texteditor-custom-audit
                                                                    wire:model="proof_{{ $location->id }}"
                                                                    id="proof_{{ $location->id }}"
                                                                    placeholder="Bukti"
                                                                    error="proof_{{ $location->id }}" disabled />
                                                            @else
                                                                <x-inputs.texteditor-custom-audit
                                                                    wire:model="proof_{{ $location->id }}"
                                                                    id="proof_{{ $location->id }}"
                                                                    placeholder="Bukti"
                                                                    error="proof_{{ $location->id }}" />
                                                            @endif
                                                            @error('proof_{{ $location->id }}')
                                                                <div class="is-invalid">
                                                                </div>
                                                                <div class="invalid-feedback">
                                                                    {{ $message }}
                                                                </div>
                                                            @enderror
                                                        </div>
                                                    </div><!-- /.form-group bukti -->

                                                    <div class="row form-group">
                                                        <label for="referensi"
                                                            class="col col-form-label d-flex flex-column">
                                                            <span>Referensi</span>
                                                            <span class="fst-italic">Reference</span>
                                                        </label>
                                                        <div class="col-9">
                                                            <ul>
                                                                <li>{{ $auditSubCriteria->criteria->title }}</li>
                                                                @if ($auditSubCriteria->parent)
                                                                    <li>{{ $auditSubCriteria->parent->title }}</li>
                                                                @endif
                                                            </ul>
                                                        </div>
                                                    </div><!-- /.form-group referensi -->

                                                    <div class="row form-group">
                                                        <label for="non_confirmance_description_{{ $location->id }}"
                                                            class="col col-form-label d-flex flex-column">
                                                            <span>Deskripsi</span>
                                                            <span class="fst-italic">Description</span>
                                                        </label>
                                                        <div class="col-9">
                                                            @if ($critical && !$critical_done)
                                                                <x-inputs.texteditor-custom-audit
                                                                    wire:model="non_confirmance_description_{{ $location->id }}"
                                                                    id="non_confirmance_description_{{ $location->id }}"
                                                                    placeholder="Deskripsi"
                                                                    error="non_confirmance_description_{{ $location->id }}"
                                                                    disabled />
                                                            @else
                                                                <x-inputs.texteditor-custom-audit
                                                                    wire:model="non_confirmance_description_{{ $location->id }}"
                                                                    id="non_confirmance_description_{{ $location->id }}"
                                                                    placeholder="Deskripsi"
                                                                    error="non_confirmance_description_{{ $location->id }}" />
                                                            @endif
                                                            @error('non_confirmance_description_{{ $location->id }}')
                                                                <div class="is-invalid">
                                                                </div>
                                                                <div class="invalid-feedback">
                                                                    {{ $message }}
                                                                </div>
                                                            @enderror
                                                        </div>
                                                    </div><!-- /.form-group deskripsi -->
                                                    <div class="row form-group">

                                                        <span class="col col-form-label"></span>
                                                        <div class="col-9">

                                                            @if ($critical)
                                                                <div class="form-check mb-5">
                                                                    @if (auth()->user()->hasRole('Audit - Lead Auditor'))
                                                                        <input class="form-check-input"
                                                                            wire:model='category_{{ $location->id }}'
                                                                            wire:change="IsCritical('{{ $location->id }}')"
                                                                            type="checkbox" {{-- value="critical" --}}
                                                                            id="category_{{ $location->id }}">
                                                                    @else
                                                                        <input class="form-check-input"
                                                                            wire:model='category_{{ $location->id }}'
                                                                            type="checkbox"
                                                                            id="category_{{ $location->id }}"
                                                                            disabled>
                                                                    @endif
                                                                    <label class="form-check-label"
                                                                        for="category_{{ $location->id }}">
                                                                        Apakah masuk kategori kritikal?
                                                                    </label>
                                                                </div>
                                                                @if (auth()->user()->hasAnyPermission(['Audit - Lead Auditor']))
                                                                    <div class="form-check mb-5">
                                                                        <input
                                                                            class="form-check-input @error('is_critical_done_{{ $location->id }}') is-invalid @enderror"
                                                                            type="checkbox"
                                                                            wire:model='is_critical_done_{{ $location->id }}'
                                                                            wire:change="IsCriticalDone('{{ $location->id }}')"
                                                                            id="is_critical_done_{{ $location->id }}">
                                                                        <label class="form-check-label"
                                                                            for="is_critical_done_{{ $location->id }}">
                                                                            Apakah sudah dilakukan tindakan
                                                                            perbaikan?
                                                                        </label>
                                                                    </div>
                                                                @else
                                                                    <div class="form-check mb-5">
                                                                        <input class="form-check-input"
                                                                            type="checkbox"
                                                                            wire:model='is_critical_done_{{ $location->id }}'
                                                                            id="is_critical_done_{{ $location->id }}"
                                                                            disabled>
                                                                        <label class="form-check-label"
                                                                            for="is_critical_done_{{ $location->id }}">
                                                                            Apakah sudah dilakukan tindakan
                                                                            perbaikan?
                                                                        </label>
                                                                    </div>
                                                                @endif
                                                            @else
                                                                <div class="form-check mb-5">
                                                                    <input
                                                                        class="form-check-input @error('category_{{ $location->id }}') is-invalid @enderror"
                                                                        wire:model='category_{{ $location->id }}'
                                                                        wire:change="IsCritical('{{ $location->id }}')"
                                                                        type="checkbox"
                                                                        id="category_{{ $location->id }}">
                                                                    <label class="form-check-label"
                                                                        for="category_{{ $location->id }}">
                                                                        Apakah masuk kategori kritikal?
                                                                    </label>
                                                                </div>
                                                            @endif

                                                            @error('category_{{ $location->id }}')
                                                                <div class="is-invalid">
                                                                </div>
                                                                <div class="invalid-feedback">
                                                                    {{ $message }}
                                                                </div>
                                                            @enderror
                                                        </div>
                                                    </div><!-- /.form-group kategori -->
                                                    <div class="row form-group">
                                                        <label for="due_date_{{ $location->id }}"
                                                            class="col col-form-label">Batas
                                                            Waktu
                                                            Perbaikan</label>
                                                        <div class="col-9">
                                                            @if ($critical && !$critical_done)
                                                                <x-inputs.datepicker
                                                                    wire:model="due_date_{{ $location->id }}"
                                                                    id="due_date_{{ $location->id }}"
                                                                    error="due_date_{{ $location->id }}" disabled />
                                                            @else
                                                                <x-inputs.datepicker class="form-control"
                                                                    wire:model="due_date_{{ $location->id }}"
                                                                    id="due_date_{{ $location->id }}"
                                                                    error="due_date_{{ $location->id }}" />
                                                            @endif
                                                        </div>
                                                    </div><!-- /.form-group batas_waktu -->

                                                    <div class="row form-group">
                                                        <label for="audit_team_id_{{ $location->id }}"
                                                            class="col-3 col-form-label">Nama
                                                            Auditor</label>
                                                        <div class="col-4">

                                                            @if ($critical && !$critical_done)
                                                                <x-inputs.select2
                                                                    wire:model="audit_team_id_{{ $location->id }}"
                                                                    id="audit_team_id_{{ $location->id }}"
                                                                    placeholder="Nama Auditor"
                                                                    error="audit_team_id_{{ $location->id }}"
                                                                    disabled>
                                                                    @foreach ($teams as $team)
                                                                        <option value="{{ $team->id }}">
                                                                            {{ $team->name }}
                                                                        </option>
                                                                    @endforeach
                                                                </x-inputs.select2>
                                                            @else
                                                                <x-inputs.select2
                                                                    wire:model="audit_team_id_{{ $location->id }}"
                                                                    id="audit_team_id_{{ $location->id }}"
                                                                    placeholder="Nama Auditor"
                                                                    error="audit_team_id_{{ $location->id }}">
                                                                    @foreach ($teams as $team)
                                                                        <option value="{{ $team->id }}">
                                                                            {{ $team->name }}
                                                                        </option>
                                                                    @endforeach
                                                                </x-inputs.select2>
                                                            @endif
                                                        </div>
                                                        <label for="auditor_date_{{ $location->id }}"
                                                            class="col-2 col-form-label">Tanggal</label>
                                                        <div class="col-3">

                                                            @if ($critical && !$critical_done)
                                                                <x-inputs.datepicker
                                                                    wire:model="auditor_date_{{ $location->id }}"
                                                                    id="auditor_date_{{ $location->id }}"
                                                                    error="auditor_date_{{ $location->id }}"
                                                                    disabled />
                                                            @else
                                                                <x-inputs.datepicker class="form-control"
                                                                    wire:model="auditor_date_{{ $location->id }}"
                                                                    id="auditor_date_{{ $location->id }}"
                                                                    error="auditor_date_{{ $location->id }}" />
                                                            @endif
                                                        </div>
                                                    </div><!-- /.form-group nama_auditor -->

                                                    <div class="row form-group mb-5">
                                                        <label for="auditee_{{ $location->id }}"
                                                            class="col-3 col-form-label">Nama
                                                            Auditi</label>
                                                        <div class="col-4">
                                                            @if ($critical && !$critical_done)
                                                                <x-inputs.text
                                                                    wire:model="auditee_{{ $location->id }}"
                                                                    id="auditee_{{ $location->id }}"
                                                                    placeholder="Nama Auditi"
                                                                    error="auditee_{{ $location->id }}" disabled />
                                                            @else
                                                                <x-inputs.text
                                                                    wire:model="auditee_{{ $location->id }}"
                                                                    id="auditee_{{ $location->id }}"
                                                                    placeholder="Nama Auditi"
                                                                    error="auditee_{{ $location->id }}" />
                                                            @endif
                                                        </div>
                                                        <label for="auditee_date_{{ $location->id }}"
                                                            class="col-2 col-form-label">Tanggal</label>
                                                        <div class="col-3">
                                                            @if ($critical && !$critical_done)
                                                                <x-inputs.datepicker
                                                                    wire:model="auditee_date_{{ $location->id }}"
                                                                    id="auditee_date_{{ $location->id }}"
                                                                    error="auditee_date_{{ $location->id }}"
                                                                    disabled />
                                                            @else
                                                                <x-inputs.datepicker class="form-control"
                                                                    wire:model="auditee_date_{{ $location->id }}"
                                                                    id="auditee_date_{{ $location->id }}"
                                                                    error="auditee_date_{{ $location->id }}" />
                                                            @endif
                                                        </div>
                                                    </div><!-- /.form-group nama_auditi -->

                                                    <h6>Tidak Lanjut Audit</h6>

                                                    <div class="row form-group">
                                                        <label for="root_cause_investigation_{{ $location->id }}"
                                                            class="col col-form-label">Investigasi Akar
                                                            Masalah</label>
                                                        <div class="col-9">
                                                            @if ($critical && !$critical_done)
                                                                <x-inputs.texteditor-custom-audit
                                                                    wire:model="root_cause_investigation_{{ $location->id }}"
                                                                    id="root_cause_investigation_{{ $location->id }}"
                                                                    placeholder="Investigasi Akar Masalah"
                                                                    error="root_cause_investigation_{{ $location->id }}"
                                                                    disabled />
                                                            @else
                                                                <x-inputs.texteditor-custom-audit
                                                                    wire:model="root_cause_investigation_{{ $location->id }}"
                                                                    id="root_cause_investigation_{{ $location->id }}"
                                                                    placeholder="Investigasi Akar Masalah"
                                                                    error="root_cause_investigation_{{ $location->id }}" />
                                                            @endif
                                                            @error('root_cause_investigation_{{ $location->id }}')
                                                                <div class="is-invalid">
                                                                </div>
                                                                <div class="invalid-feedback">
                                                                    {{ $message }}
                                                                </div>
                                                            @enderror
                                                        </div>
                                                    </div><!-- /.form-group akar_masalah -->

                                                    <div class="row form-group">
                                                        <label for="fix_action_{{ $location->id }}"
                                                            class="col col-form-label">Tindakan
                                                            Perbaikan</label>
                                                        <div class="col-9">
                                                            @if ($critical && !$critical_done)
                                                                <x-inputs.texteditor-custom-audit
                                                                    wire:model="fix_action_{{ $location->id }}"
                                                                    id="fix_action_{{ $location->id }}"
                                                                    placeholder="Tindakan Perbaikan"
                                                                    error="fix_action_{{ $location->id }}"
                                                                    disabled />
                                                            @else
                                                                <x-inputs.texteditor-custom-audit
                                                                    wire:model="fix_action_{{ $location->id }}"
                                                                    id="fix_action_{{ $location->id }}"
                                                                    placeholder="Tindakan Perbaikan"
                                                                    error="fix_action_{{ $location->id }}" />
                                                            @endif
                                                            @error('fix_action_{{ $location->id }}')
                                                                <div class="is-invalid">
                                                                </div>
                                                                <div class="invalid-feedback">
                                                                    {{ $message }}
                                                                </div>
                                                            @enderror
                                                        </div>
                                                    </div><!-- /.form-group tindakan_perbaikan -->

                                                </div><!-- inner_non_confirmance -->

                                            </div><!-- /.non_confirmance_wrapper -->
                                        @endif


                                    </div><!-- /.content-form -->
                                    {{-- @if (isset($this->{'isConfirm_' . $location->id}) || isset($this->{'isRelation_' . $location->id})) --}}
                                    <div class="footer-action mb-2">
                                        <div
                                            class="action-wrapper d-flex align-items-center justify-content-end gap-2">
                                            <!-- <a href="" class="btn btn-outline-secondary">Cancel</a> -->
                                            <button type="button" wire:click="save_location('{{ $location->id }}')"
                                                class="btn btn-outline-default bg-green d-flex justify-content-center align-item-center text-white position-relative px-4">
                                                Simpan
                                            </button>

                                            {{-- <button class="btn btn-outline-default bg-green d-flex justify-content-center align-item-center text-white position-relative px-4" type="submit">Simpan</button> --}}
                                        </div>
                                    </div>
                                    {{-- @endif --}}

                                </form>
                            </div><!-- /.form-wrapper -->
                            <div class="col-sm-3" style="padding-top:170px">
                                <div class="row">
                                    <div class="col-sm-12" style="padding:5px"><b>Nilai Sub Elemen</b></div>
                                </div>
                                @foreach ($auditSubCriteria->list_points as $list_point)
                                    <div class="row">
                                        <div class="col-sm-12" style="padding:5px">
                                            Nilai : {{ $list_point->point }}
                                        </div>
                                        <div class="col-sm-12" style="padding:5px">
                                            {{ $list_point->tooltip }}
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>

                    </div><!-- /.section-content-->
                </div>
            @endforeach
        </div>
        <!-- end content -->

        <!-- sidebar right start -->
        @livewire('audit::layouts.sidebar-' . $module_category . '-criteria', ['audit' => $audit, 'selected' => $auditSubCriteria->id])

    </div>

</div>
@push('scripts')
    <script>
        window.addEventListener('refresh-page', event => {
            window.location.reload(false);
        })

        window.addEventListener('closeModal', event => {
            $('.modal').modal('hide');
        });

        window.addEventListener('showModal', event => {
            $('#modalFormSampel').modal('show');
        });
        window.addEventListener('summerNote', event => {
            $(document).find('.summernote.disabled hello').each(function(i, e) {
                $(e).summernote({
                    height: 200,
                    toolbar: [],
                });
                $(e).summernote('disable')
            })
        });
        window.Livewire.on('summernote', () => {
            $('.summernote').each(function(i, e) {
                const id = $(e).attr('id')
                $(e).summernote({
                    height: 300,
                    toolbar: [
                        ['style', ['style']],
                        ['font', ['bold', 'underline', 'clear']],
                        ['color', ['color']],
                        ['para', ['ul', 'ol', 'paragraph']],
                    ],
                    callbacks: {
                        onChange: function(contents, $editable) {
                            @this.
                            set(id, contents);
                        }
                    },
                })
            })
        })
    </script>
@endpush
