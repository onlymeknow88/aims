<div class="inner-content">

    <div class="header-add-maker h-60px bg-green d-flex gap-2 align-items-center justify-content-between px-3">
        <div class="left-header">
            <a href="{{ route('field-leadership::listing.active.index') }}"
                class="d-flex align-items-center gap-3 text-white">
                <span><i class="fa-solid fa-arrow-left"></i></span>
                <span>New Field Leadership</span>
            </a>
        </div><!-- /.left-header -->
        <div class="right-header">
            <div class="text-white">Last update {{ Carbon\Carbon::now()->format('M d, Y . H.i A') }}</div>
        </div><!-- /.right-header -->

    </div>

    <div class="addnew-maker-content container py-5 px-3">

        <div class="row justify-content-center">

            <div class="col-8">

                <form class="form-horizontal" method="post" enctype="multipart/form-data">

                    <div class="own-info mb-5">

                        <div class="mb-5">
                            <h5 class="fw-normal">Informasi Umum</h5>
                        </div>

                        <div class="mb-3 row form-group required">

                            <label for="title" class="col-sm-4 col-form-label">Tanggal</label>

                            <div class="col-sm-8">
                                <x-inputs.datepicker wire:model="date" id="date" :error="'date'"
                                    placeholder="Select Date" />
                            </div>

                        </div><!-- /.form-group -->

                        <div class="mb-3 row form-group required">

                            <label for="ccow" class="col-sm-4 col-form-label">CCOW</label>

                            <div class="col-sm-8">

                                <x-inputs.select2 wire:model="ccow_id" id="ccow_id" placeholder="Select CCOW"
                                    data-child="ccow_id">

                                    @foreach ($this->ccows as $key => $company)
                                        <option value="{{ $company->id }}">{{ $company->company_name }}</option>
                                    @endforeach

                                </x-inputs.select2>

                            </div>

                        </div><!-- /.form-group -->

                        <div class="mb-3 row form-group required">

                            <label for="company" class="col-sm-4 col-form-label">Perusahaan</label>

                            <div class="col-sm-8">

                                <x-inputs.select2 wire:model="company_id" id="company_id" placeholder="Select Company"
                                    data-child="company_id">

                                    @foreach ($this->companies as $key => $company)
                                        <option value="{{ $company->id }}">{{ $company->company_name }}</option>
                                    @endforeach

                                </x-inputs.select2>

                            </div>

                        </div><!-- /.form-group -->

                        <div class="mb-3 row form-group required">

                            <label for="company" class="col-sm-4 col-form-label">Detail Perusahaan</label>

                            <div class="col-sm-8">

                                <x-inputs.select2 wire:model="detail_company" id="detail_company"
                                    placeholder="Select Detail Company" data-child="detail_company">

                                    @foreach (App\Enums\CompanyType::asSelectArray() as $key => $item)
                                        <option value="{{ $item }}">{{ $item }}</option>
                                    @endforeach

                                </x-inputs.select2>

                            </div>

                        </div><!-- /.form-group -->

                        <div class="mb-3 row form-group required">

                            <label for="department" class="col-sm-4 col-form-label">Department</label>

                            <div class="col-sm-8">

                                <x-inputs.select2 wire:model="department_id" id="department_id"
                                    placeholder="Select Department">

                                    @foreach ($this->departments as $key => $department)
                                        <option value="{{ $department->id }}">{{ $department->name }}</option>
                                    @endforeach

                                </x-inputs.select2>

                            </div>

                        </div><!-- /.form-group -->

                        <div class="mb-3 row form-group required">

                            <label for="company" class="col-sm-4 col-form-label">Section</label>

                            <div class="col-sm-8">

                                <x-inputs.select2 wire:model="section_id" id="section_id" placeholder="Select Section"
                                    data-child="section_id">

                                    @foreach ($this->sections as $key => $section)
                                        <option value="{{ $section->id }}">{{ $section->name }}</option>
                                    @endforeach

                                </x-inputs.select2>

                            </div>

                        </div><!-- /.form-group -->

                        <div class="mb-3 row form-group required">

                            <label for="company" class="col-sm-4 col-form-label">Location</label>

                            <div class="col-sm-8">

                                <x-inputs.select2 wire:model="area_location_id" id="area_location_id"
                                    placeholder="Select Area Location" data-child="department">

                                    @foreach ($this->areaLocations as $key => $location)
                                        <option value="{{ $location->id }}">{{ $location->name }}</option>
                                    @endforeach

                                </x-inputs.select2>

                            </div>

                        </div><!-- /.form-group -->

                        <div class="mb-3 row form-group">

                            <label for="company" class="col-sm-4 col-form-label">Detail Location</label>

                            <div class="col-sm-8">

                                <textarea class="form-control" rows="4" wire:model="detail_location" placeholder="Detail Location"></textarea>

                            </div>

                        </div><!-- /.form-group -->

                    </div><!-- /.own-info -->

                    <div class="map-info mb-5">

                        <div class="mb-5">
                            <h5 class="fw-normal">Penanggung Jawab</h5>
                        </div>

                        <div class="mb-3 row form-group required">

                            <label for="pj" class="col-sm-4 col-form-label">Select PJA</label>

                            <div class="col-sm-8">

                                <x-inputs.select2 wire:model="pja_id" id="pja_id" name="pja_id"
                                    placeholder="Select Select PJA">

                                    @foreach ($this->areaManagers as $key => $areaManager)
                                        <option value="{{ $areaManager->id }}">{{ $areaManager->user->name }}</option>
                                    @endforeach

                                    </x-inputs-select2>

                            </div>

                        </div><!-- /.form-group -->

                        <div class="mb-3 row form-group required">

                            <label for="pj" class="col-sm-4 col-form-label">Select PJO/KTT</label>

                            <div class="col-sm-8">

                                <x-inputs.select2 wire:model="pjo_id" id="pjo_id" name="pjo_id"
                                    placeholder="Select Select PJO/KTT">

                                    @foreach ($this->employees as $key => $item)
                                        <option value="{{ $item->user->employee->id }}">
                                            {{ $item->user->employee->name }}
                                        </option>
                                    @endforeach

                                    </x-inputs-select2>

                            </div>

                        </div><!-- /.form-group -->

                        <div class="mb-3 row form-group required">

                            <label for="modules" class="col-sm-4 col-form-label">Jenis Field Leadership</label>

                            <div class="col-sm-8">

                                <x-inputs.type-field-leadership wire:model="type" id="type" :error="'type'" />
                            </div>

                        </div><!-- /.form-group -->

                        <div class="mb-3 row form-group required">

                            <label for="modules" class="col-sm-4 col-form-label">Tugas / SOP / WI yang diamati
                            </label>

                            <div class="col-sm-8">

                                <textarea class="form-control" rows="4" wire:model="job" placeholder="Tugas / SOP / WI yang diamati"></textarea>
                            </div>

                        </div><!-- /.form-group -->

                        @if ($showQuestion)
                            <div class="mb-3 row form-group required">

                                <label for="modules" class="col-sm-4 col-form-label">Pertanyaan
                                </label>

                                <div class="col-sm-8">
                                    <div class="row mb-3">
                                        <div class="col-sm-8">
                                            <x-inputs.select2 wire:model="question1" id="question1" name="question1"
                                                placeholder="Select Question">

                                                <option
                                                    value="Apakah risiko yang ada di area Anda yang dapat  membahayakan nyawa Anda?">
                                                    Apakah risiko yang ada di area Anda yang dapat membahayakan nyawa
                                                    Anda?
                                                </option>
                                                <option
                                                    value="Apakah tersedia pengendalian penting tersedia untuk melindungi  Anda?">
                                                    Apakah tersedia pengendalian penting tersedia untuk melindungi Anda?
                                                </option>
                                                <option
                                                    value="Bagaimana Anda mengetahui pengendalian penting tersebut  efektif?">
                                                    Bagaimana Anda mengetahui pengendalian penting tersebut efektif?
                                                </option>
                                                <option
                                                    value="Apakah semua langkah kerja di dalam SOP/INK/JSA telah berkesusaian dengan pekerjaan yg dilakukan?">
                                                    Apakah semua langkah kerja di dalam SOP/INK/JSA telah berkesusaian
                                                    dengan pekerjaan yg dilakukan?
                                                </option>
                                                <option value="Pekerja memahami SOP/INK/JSA tersebut?">
                                                    Pekerja memahami SOP/INK/JSA tersebut?
                                                </option>
                                                <option
                                                    value="Apakah ada opportunity untuk proses SOP/INK/JSA yg lebih efisien, produktif dan aman?">
                                                    Apakah ada opportunity untuk proses SOP/INK/JSA yg lebih efisien,
                                                    produktif dan aman?
                                                </option>

                                                </x-inputs-select2>
                                        </div>
                                        <div class="col-sm-4">
                                            @if ($question1 == 'Bagaimana Anda mengetahui pengendalian penting tersebut  efektif?')
                                                <input type="text" wire:model="answer1" class="form-control"
                                                    placeholder="Answer">
                                            @else
                                                <x-inputs.select2 wire:model="answer1" id="answer1" name="answer1"
                                                    placeholder="Select Answer">

                                                    <option value="Ya">
                                                        Ya
                                                    </option>
                                                    <option value="Tidak">
                                                        Tidak
                                                    </option>

                                                    </x-inputs-select2>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="row mb-3">
                                        <div class="col-sm-8">
                                            <x-inputs.select2 wire:model="question2" id="question2" name="question2"
                                                placeholder="Select Question">

                                                <option
                                                    value="Apakah risiko yang ada di area Anda yang dapat  membahayakan nyawa Anda?">
                                                    Apakah risiko yang ada di area Anda yang dapat membahayakan nyawa
                                                    Anda?
                                                </option>
                                                <option
                                                    value="Apakah tersedia pengendalian penting tersedia untuk melindungi  Anda?">
                                                    Apakah tersedia pengendalian penting tersedia untuk melindungi Anda?
                                                </option>
                                                <option
                                                    value="Bagaimana Anda mengetahui pengendalian penting tersebut  efektif?">
                                                    Bagaimana Anda mengetahui pengendalian penting tersebut efektif?
                                                </option>
                                                <option
                                                    value="Apakah semua langkah kerja di dalam SOP/INK/JSA telah berkesusaian dengan pekerjaan yg dilakukan?">
                                                    Apakah semua langkah kerja di dalam SOP/INK/JSA telah berkesusaian
                                                    dengan pekerjaan yg dilakukan?
                                                </option>
                                                <option value="Pekerja memahami SOP/INK/JSA tersebut?">
                                                    Pekerja memahami SOP/INK/JSA tersebut?
                                                </option>
                                                <option
                                                    value="Apakah ada opportunity untuk proses SOP/INK/JSA yg lebih efisien, produktif dan aman?">
                                                    Apakah ada opportunity untuk proses SOP/INK/JSA yg lebih efisien,
                                                    produktif dan aman?
                                                </option>

                                                </x-inputs-select2>
                                        </div>
                                        <div class="col-sm-4">
                                            @if ($question2 == 'Bagaimana Anda mengetahui pengendalian penting tersebut  efektif?')
                                                <input type="text" wire:model="answer2" class="form-control"
                                                    placeholder="Answer">
                                            @else
                                                <x-inputs.select2 wire:model="answer2" id="answer2" name="answer2"
                                                    placeholder="Select Answer">

                                                    <option value="Ya">
                                                        Ya
                                                    </option>
                                                    <option value="Tidak">
                                                        Tidak
                                                    </option>

                                                    </x-inputs-select2>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="row mb-3">
                                        <div class="col-sm-8">
                                            <x-inputs.select2 wire:model="question3" id="question3" name="question3"
                                                placeholder="Select Question">

                                                <option
                                                    value="Apakah risiko yang ada di area Anda yang dapat  membahayakan nyawa Anda?">
                                                    Apakah risiko yang ada di area Anda yang dapat membahayakan nyawa
                                                    Anda?
                                                </option>
                                                <option
                                                    value="Apakah tersedia pengendalian penting tersedia untuk melindungi  Anda?">
                                                    Apakah tersedia pengendalian penting tersedia untuk melindungi Anda?
                                                </option>
                                                <option
                                                    value="Bagaimana Anda mengetahui pengendalian penting tersebut  efektif?">
                                                    Bagaimana Anda mengetahui pengendalian penting tersebut efektif?
                                                </option>
                                                <option
                                                    value="Apakah semua langkah kerja di dalam SOP/INK/JSA telah berkesusaian dengan pekerjaan yg dilakukan?">
                                                    Apakah semua langkah kerja di dalam SOP/INK/JSA telah berkesusaian
                                                    dengan pekerjaan yg dilakukan?
                                                </option>
                                                <option value="Pekerja memahami SOP/INK/JSA tersebut?">
                                                    Pekerja memahami SOP/INK/JSA tersebut?
                                                </option>
                                                <option
                                                    value="Apakah ada opportunity untuk proses SOP/INK/JSA yg lebih efisien, produktif dan aman?">
                                                    Apakah ada opportunity untuk proses SOP/INK/JSA yg lebih efisien,
                                                    produktif dan aman?
                                                </option>

                                                </x-inputs-select2>
                                        </div>
                                        <div class="col-sm-4">
                                            @if ($question3 == 'Bagaimana Anda mengetahui pengendalian penting tersebut  efektif?')
                                                <input type="text" wire:model="answer3" class="form-control"
                                                    placeholder="Answer">
                                            @else
                                                <x-inputs.select2 wire:model="answer3" id="answer3" name="answer3"
                                                    placeholder="Select Answer">

                                                    <option value="Ya">
                                                        Ya
                                                    </option>
                                                    <option value="Tidak">
                                                        Tidak
                                                    </option>

                                                    </x-inputs-select2>
                                            @endif
                                        </div>
                                    </div>
                                </div>

                            </div><!-- /.form-group -->
                        @endif


                    </div><!-- /.map-info -->

                    <div class="map-info mb-5">

                        <div class="mb-5">
                            <h5 class="fw-normal">Anggota Tim</h5>
                        </div>

                        @foreach ($member as $item)
                            <div class="row mb-3 form-group required">

                                <div class="col-sm-4">

                                    <x-inputs.select2 wire:model="member.{{ $loop->index }}.type"
                                        id="member.{{ $loop->index }}.type" placeholder="Select Type"
                                        data-child="member.{{ $loop->index }}.type">

                                        @foreach (App\Enums\CompanyType::asSelectArray() as $key => $item)
                                            <option value="{{ $item }}">{{ $item }}</option>
                                        @endforeach

                                    </x-inputs.select2>

                                </div>

                                <div class="{{ count($member) == 1 ? 'col-sm-8' : 'col-sm-7' }}">

                                    <x-inputs.select2 wire:model="member.{{ $loop->index }}.employee_id"
                                        id="member.{{ $loop->index }}.employee_id" name="employee_id"
                                        placeholder="Select Employee">

                                        @foreach ($this->employees as $key => $item)
                                            <option value="{{ $item->user->employee->id }}">
                                                {{ $item->user->employee->name }}
                                            </option>
                                        @endforeach

                                        </x-inputs-select2>

                                </div>

                                <div class="col-sm-1 text-center {{ count($member) == 1 ? 'd-none' : 'd-block' }}"
                                    wire:click="removeMember({{ $loop->index }})">

                                    <button type="button" class="btn btn-light-secondary text-center"
                                        wire:click="removeMember({{ $loop->index }})">
                                        <i class="fa fa-x"></i>
                                    </button>

                                </div>

                            </div><!-- /.form-group -->
                        @endforeach

                        <div class="mb-3 row form-group required">

                            <div class="col-sm-4 pb-3">

                                <button type="button" class="btn btn-light-secondary text-center mt-3"
                                    wire:click="addMember" style="width: 100%;"
                                    {{ count($member) < $limit_param->max_item_member ? '' : 'disabled' }}>
                                    <i class="fa fa-plus"></i> Add More Teams
                                </button>

                            </div>
                            <div
                                class="col-sm-8 align-self-center {{ count($member) < $limit_param->max_item_member ? 'd-none' : 'd-block' }}">

                                <span>Maximum {{ $limit_param->max_item_member }} Person</span>

                            </div>

                        </div><!-- /.form-group -->

                    </div><!-- /.map-info -->

                    <div class="map-info mb-5">

                        <div class="mb-5">
                            <h5 class="fw-normal">Jumlah Waktu Kunjungan</h5>
                        </div>

                        <div class="mb-3 row form-group required">

                            <div class="col-sm-4">
                                <input type="number" wire:model="visit_time" class="form-control"
                                    placeholder="0 Minute">
                            </div>

                        </div><!-- /.form-group -->

                    </div><!-- /.map-info -->

                    <div class="map-info {{ $hazard_report_label ? 'd-none' : '' }}">

                        <div class="mb-5">
                            <h5 class="fw-normal">
                                {{ $hazard_report_label ? 'Kondisi' : 'Perilaku/Kondisi' }} Positif Yang Diamati
                            </h5>
                        </div>

                        @foreach ($positive_condition as $item)
                            <div class="mb-3 row form-group required">

                                <div class=" {{ count($positive_condition) == 1 ? 'col-sm-12' : 'col-sm-11' }}">
                                    <input type="text"
                                        wire:model="positive_condition.{{ $loop->index }}.description"
                                        class="form-control" placeholder="Description">
                                </div>

                                <div class="col-sm-1 text-center {{ count($positive_condition) == 1 ? 'd-none' : 'd-block' }}"
                                    wire:click="removePositiveCondition({{ $loop->index }})">

                                    <button type="button" class="btn btn-light-secondary text-center"
                                        wire:click="removePositiveCondition({{ $loop->index }})">
                                        <i class="fa fa-x"></i>
                                    </button>

                                </div>

                            </div><!-- /.form-group -->
                        @endforeach

                    </div><!-- /.map-info -->

                    <div class="mb-5 row form-group required {{ $hazard_report_label ? 'd-none' : '' }}">

                        <div class="col-sm-4 pb-3">

                            <button type="button" class="btn btn-light-secondary text-center mt-3"
                                wire:click="addPositiveCondition" style="width: 100%;"
                                {{ count($positive_condition) < $limit_param->max_item_positive_condition ? '' : 'disabled' }}>
                                <i class="fa fa-plus"></i> Add Positive Condition
                            </button>

                        </div>
                        <div
                            class="col-sm-8 align-self-center {{ count($positive_condition) < $limit_param->max_item_positive_condition ? 'd-none' : 'd-block' }}">

                            <span>Maximum {{ $limit_param->max_item_positive_condition }} Positive Condition</span>

                        </div>

                    </div><!-- /.form-group -->

                    <div class="map-info mb-5">

                        <div class="mb-5">
                            <h5 class="fw-normal">
                                {{ $hazard_report_label ? 'Kondisi' : 'Perilaku/Kondisi' }} Beresiko yang Diamati
                            </h5>
                        </div>

                        @foreach ($risk_condition as $key => $item)
                            <div class="mb-3 form-group required activity-item">

                                <div class="row {{ count($risk_condition) == 1 ? 'd-none' : 'd-block' }}">
                                    <div class="col-sm-1 offset-11 text-center"
                                        wire:click="removeRiskCondition({{ $loop->index }})">

                                        <button type="button" class="btn btn-light-secondary text-center"
                                            wire:click="removeRiskCondition({{ $loop->index }})">
                                            <i class="fa fa-x"></i>
                                        </button>

                                    </div>
                                </div>

                                <div class="row mb-3">
                                    <div class="col-sm-8">
                                        <label
                                            for="">{{ $hazard_report_label ? 'Kondisi' : 'Perilaku/Kondisi' }}
                                            Beresiko yang Diamati</label>

                                        <textarea class="form-control" rows="7" wire:model="risk_condition.{{ $loop->index }}.description"
                                            placeholder="{{ $hazard_report_label ? 'Kondisi' : 'Perilaku/Kondisi' }} Beresiko yang Diamati"></textarea>
                                    </div>

                                    <div class="col-sm-4">
                                        <label for="">Kategori</label>
                                        <x-inputs.select2 wire:model="risk_condition.{{ $loop->index }}.category"
                                            id="risk_condition.{{ $loop->index }}.category"
                                            name="risk_condition.{{ $loop->index }}.category"
                                            placeholder="Select Category">

                                            @foreach ($this->categories as $key => $category)
                                                <option value="{{ $category->id }}">{{ $category->name }}
                                                </option>
                                            @endforeach

                                            </x-inputs-select2>
                                    </div>
                                </div>

                                <div class="row mb-3">
                                    <div class="col-sm-8">
                                        <label for="">Jenis Kondisi Tidak Aman / Tindakan Tidak Aman</label>

                                        <x-inputs.select2 wire:model="risk_condition.{{ $loop->index }}.type"
                                            id="risk_condition.{{ $loop->index }}.type"
                                            name="risk_condition.{{ $loop->index }}.type" placeholder="Select Type">

                                            @foreach ($this->typeKtaTta as $key => $type)
                                                <option value="{{ $type->id }}">{{ $type->code }}
                                                    {{ $type->name }}
                                                </option>
                                            @endforeach

                                            </x-inputs-select2>
                                    </div>

                                    <div class="col-sm-4">
                                        <label for="">Tingkat Risiko / Potensi</label>
                                        <x-inputs.select2 wire:model="risk_condition.{{ $loop->index }}.level"
                                            id="risk_condition.{{ $loop->index }}.level"
                                            name="risk_condition.{{ $loop->index }}.level"
                                            placeholder="Select Type">

                                            @foreach ($this->potencies as $key => $potency)
                                                <option value="{{ $potency->id }}">{{ $potency->name }}
                                                </option>
                                            @endforeach

                                            </x-inputs-select2>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-sm-8">
                                        <label for="">Tindakan Perbaikan</label>
                                        <textarea class="form-control" rows="7" wire:model="risk_condition.{{ $loop->index }}.action"
                                            placeholder="Tindakan"></textarea>
                                    </div>

                                    <div class="col-sm-4" wire:ignore>
                                        <label for="">Target Waktu Penyelesaian</label>
                                        <x-inputs.datepicker wire:model="risk_condition.{{ $loop->index }}.due_date"
                                            id="risk_condition.{{ $loop->index }}.due_date" :error="'risk_condition.{{ $loop->index }}.due_date'"
                                            placeholder="Select Date" autocomplete="off" />
                                    </div>
                                </div>

                                <div class="row mb-3 form-group required">

                                    <div class="col-sm-12">
                                        <div class="mt-5">
                                            <button class="btn btn-outline-upload w-100 position-relative h-128px"
                                                style="border: 1px dashed #810DA8; background-color: #810DA80A;"
                                                type="button">
                                                <span><img src="{{ asset('/images/icons/upload.png') }}"
                                                        alt="image upload" /></span>
                                                <span class="text-upload">Drop or <a href="#">Select
                                                        File</a></span>
                                                <input type="file" name="" id=""
                                                    wire:model="temporaryFile.{{ $loop->index }}"
                                                    accept=".pdf, .png, .jpeg, .jpg" multiple />

                                            </button>
                                        </div>
                                    </div>

                                </div><!-- /.form-group -->

                                @foreach ($item['files'] as $keyFile => $itemFile)
                                    <div class="row form-group mb-3 m-1">
                                        <div class="col-sm-11 bg-white d-flex justify-content-between p-2 file-list">
                                            <div>
                                                <img src="{{ asset('/images/icons/pdf.png') }}" alt="pdf" />
                                                <span>
                                                    {{ Str::limit(explode('/', $itemFile['name'])[4], 15) }}
                                                </span>
                                            </div>
                                            <span>
                                                {{ $itemFile['size'] }}
                                            </span>
                                        </div>
                                        <div class="col-sm-1 text-center p-2"
                                            wire:click="removeFile({{ $loop->parent->index }}, {{ $loop->index }})">
                                            <button type="button" class="btn btn-light-secondary text-center"
                                                wire:click="removeFile({{ $loop->parent->index }}, {{ $loop->index }})">
                                                <i class="fa fa-x"></i>
                                            </button>
                                        </div>
                                    </div>
                                @endforeach

                            </div><!-- /.form-group -->
                        @endforeach

                        <div class="mb-3 row form-group required">

                            <div class="col-sm-4 pb-3">

                                <button type="button" class="btn btn-light-secondary text-center mt-3"
                                    wire:click="addRiskCondition" style="width: 100%;">
                                    <i class="fa fa-plus"></i> Add More Condition
                                </button>

                            </div>

                        </div><!-- /.form-group -->

                    </div><!-- /.map-info -->

                    <div class="footer-action mb-2">
                        <div class="action-wrapper d-flex align-items-center justify-content-end gap-2">
                            <a href="{{ route('field-leadership::listing.active.index') }}"
                                class="btn btn-outline-secondary">Cancel</a>
                            <div class="button-document">
                                <button
                                    class="dropdown-toggle btn btn-outline-default bg-green d-flex justify-content-center align-item-center text-white position-relative px-4"
                                    role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                    Submit Action
                                </button>
                                <ul class="dropdown-menu">
                                    <li>
                                        <button type="button" wire:click="saved('Draft')" class="dropdown-item"
                                            href="#">
                                            Submit as draft
                                        </button>
                                    </li>
                                    <li>
                                        <button type="button" wire:click="saved('Publish')" class="dropdown-item"
                                            href="#">
                                            Submit for review
                                        </button>
                                    </li>
                                    <li class="{{ $hazard_report_label ? '' : 'd-none' }}">
                                        <button type="button" wire:click="saved('HR')" class="dropdown-item"
                                            href="#">
                                            Close Action
                                        </button>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>

                </form>

            </div>

        </div>

    </div>
    <!---/.addnew-maker-content -->

</div>

@push('styles')
    <style>
        .btn-light-secondary {
            background-color: #f5f5f5;
            color: #000;
        }

        .btn-light-secondary:hover {
            background-color: #adadad;
            color: #fff;
        }

        .file-list {
            border: 1px solid #cdcdcd;
            border-radius: 5px;
        }
    </style>
@endpush

@push('scripts')
    <script>
        $(document).ready(function() {
            //    
        });
    </script>
@endpush
