<div class="inner-content">
    <div class="header-detail-maker h-60px border d-flex gap-2 align-items-center px-3">
        <div class="left-header">
            <a href="#" onclick="history.back();"
               class="d-flex align-items-center gap-3">
                <span><i class="fa-solid fa-arrow-left"></i></span>
                <span>KO</span>
            </a>
        </div>
        <div class="right-header">
            <div class="text-white">
                {{-- Last update Sep 24, 2022 . 15.00 pm --}}
            </div>
        </div>
    </div>

    <div class="addnew-maker-content container py-5 px-3">

        <div class="row justify-content-center m-5">
            <div class="col-sm-3">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title text-center">NOMOR URUT KOMISIONING</h5>
                        <h2 class="card-text text-center">{{$ko_proposal->number}}</h2>
                    </div>
                </div>
            </div>
        </div>

        <form enctype="multipart/form-data" wire:submit.prevent="store">
            <div class="row justify-content-center">
                <div class="col-8">
                    <div class="form-horizontal">
                        <div class="own-info mb-5">
                            <div class="mb-3 text-center">
                                <h2 class="fw-normal">Data Sarana</h2>
                            </div>

                            <div class="mb-3 row form-group required">
                                <label for="brand" class="col-sm-4 col-form-label">Tanggal Pra / Komisioning</label>
                                <div class="col-sm-8">
                                    <x-inputs.datepicker wire:model.defer="date" id="approved_date" :error="'date'" required></x-inputs.datepicker>
                                </div>
                            </div>

                            <div class="mb-3 row form-group required">
                                <label for="brand" class="col-sm-4 col-form-label">Perusahaan</label>
                                <div class="col-sm-8">
                                    <x-inputs.text type="text" wire:model="company" class="form-control" id="company" placeholder="" :error="'company_id'" readonly></x-inputs.text>
                                </div>
                            </div>

                            {{--<div class="mb-3 row form-group required">
                                <label for="brand" class="col-sm-4 col-form-label">Sub-kontraktor</label>
                                <div class="col-sm-8">
                                    <x-inputs.text type="text" wire:model="" class="form-control" id="identity_number" placeholder="" :error="'identity_number'"></x-inputs.text>
                                </div>
                            </div>--}}

                            <div class="mb-3 row form-group required">
                                <label for="brand" class="col-sm-4 col-form-label">Nomor Unit</label>
                                <div class="col-sm-8">
                                    <x-inputs.text type="text" wire:model="call_sign" class="form-control" id="identity_number" placeholder="" :error="'identity_number'" readonly></x-inputs.text>
                                </div>
                            </div>

                            <div class="mb-3 row form-group required">
                                <label for="brand" class="col-sm-4 col-form-label">Nomor Serial</label>
                                <div class="col-sm-8">
                                    <x-inputs.text type="text" wire:model="serial_number" class="form-control" id="serial_number" placeholder="" :error="'serial_number'" readonly></x-inputs.text>
                                </div>
                            </div>

                            @if($engine_status != 'Baru')
                            <div class="mb-3 row form-group required">
                                <label for="brand" class="col-sm-4 col-form-label">Tanggal Lulus Komisioning</label>
                                <div class="col-sm-8">
                                    <x-inputs.datepicker wire:model.defer="commissioning_completion_date" id="approved_date" :error="'commissioning_completion_date'" required></x-inputs.datepicker>
                                </div>
                            </div>
                            @endif

                            <div class="mb-3 row form-group required">
                                <label for="brand" class="col-sm-4 col-form-label">Komisioning Periode</label>
                                <div class="col-sm-8">
                                    <x-inputs.text type="text" wire:model="period" class="form-control" id="period" placeholder="" :error="'period'" readonly></x-inputs.text>
                                </div>
                            </div>

                            <div class="mb-3 row form-group required">
                                <label for="brand" class="col-sm-4 col-form-label">Merk / Brand SPIP</label>
                                <div class="col-sm-8">
                                    <x-inputs.text type="text" wire:model="brand" class="form-control" id="brand" placeholder="" :error="'brand'" value="" readonly></x-inputs.text>
                                </div>
                            </div>

                            <div class="mb-3 row form-group required">
                                <label for="brand" class="col-sm-4 col-form-label">Model Unit</label>
                                <div class="col-sm-8">
                                    <x-inputs.text type="text" wire:model="model_unit" class="form-control" id="model_unit" placeholder="" :error="'model_unit'" readonly></x-inputs.text>
                                </div>
                            </div>

                            <div class="mb-3 row form-group required">
                                <label for="brand" class="col-sm-4 col-form-label">Tahun Pembuatan</label>
                                <div class="col-sm-8">
                                    <x-inputs.text type="text" wire:model="production_year" class="form-control" id="production_year" placeholder="" :error="'production_year'" readonly></x-inputs.text>
                                </div>
                            </div>

                            <div class="mb-3 row form-group required">
                                <label for="brand" class="col-sm-4 col-form-label">SMU / ODO Meter</label>
                                <div class="col-sm-8">
                                    <x-inputs.text type="text" wire:model.defer="smu_odo_meter" class="form-control" id="smu_odo_meter" placeholder="" :error="'smu_odo_meter'" required></x-inputs.text>
                                </div>
                            </div>

                            <div class="mb-3 row form-group required">
                                <label for="brand" class="col-sm-4 col-form-label">Status mesin</label>
                                <div class="col-sm-8">
                                    <x-ko-select-2 wire:model="engine_status" id="engine_status" placeholder="Select Status Mesin" required>
                                        <option value="Baru">Baru</option>
                                        <option value="Re-comm">Re-comm</option>
                                    </x-ko-select-2>
                                </div>
                            </div>

                            @if($engine_status != 'Baru')
                            <div class="mb-3 row form-group required">
                                <label for="brand" class="col-sm-4 col-form-label">Tanggal Kadaluarsa</label>
                                <div class="col-sm-8">
                                    <x-inputs.datepicker wire:model.defer="expired_date" id="expired_date" :error="'expired_date'" required></x-inputs.datepicker>
                                </div>
                            </div>
                            @endif

                            <div class="mb-3 row form-group required">
                                <label for="brand" class="col-sm-4 col-form-label">Nama Komisioner</label>
                                <div class="col-sm-8">
                                    <x-inputs.text type="text" wire:model.defer="created_by" class="form-control" id="created_by" placeholder="" :error="'created_by'"></x-inputs.text>
                                </div>
                            </div>

                            {{--<div class="mb-3 row form-group required">
                                <label for="brand" class="col-sm-4 col-form-label">Status komisioning</label>
                                <div class="col-sm-8">
                                    <x-ko-select-2 wire:model="" id="" placeholder="Select Status komisioning" required>
                                        <option value="Baru">Lulus</option>
                                        <option value="Re-Comm">Tidak Lulus</option>
                                    </x-ko-select-2>
                                </div>
                            </div>--}}

                        </div>
                    </div>
                </div>
            </div>

            <div class="row justify-content-center">

                <div class="col-sm-12">

                    <div class="form-susunan-kegiatan py-4 d-flex flex-column gap-5" action="#">

                        <div class="title-form text-center">
                            <h2>Formulir Komisioning</h2>
                        </div><!-- /.title-form -->

                        <div class="content-form d-flex flex-column gap-3">

                            <div class="kegiatan-loop">

                                <div class="mb-3">

                                    <table class="table table-bordered align-items-center table-sm">

                                        <thead class="thead-light">
                                            <tr style="border-left:1px solid #dddddd;">
                                                <th>#</th>
                                                <th>ITEMS / DESKRIPSI</th>
                                                <th>KONDISI / FUNGSI</th>
                                                <th>KETERANGAN dan DEVIASI</th>
                                                <th>ATTACHMENT</th>
                                                <th style="width: 10px; white-space: normal">KODE BAHAYA</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach($ko_proposal->koUnit->koSpipUnit->koCommisioningHeaders as $key => $header)
                                            <tr style="border-left:1px solid #dddddd;">
                                                <td>{{$header->number}}.</td>
                                                <td colspan="5"><b>DOKUMEN KENDARAAN</b></td>
                                            </tr>
                                                @foreach($header->koCommisioningFields as $key => $field)
                                                <tr style="border-left:1px solid #dddddd;">
                                                    <td>{{$field->number}}.</td>
                                                    <td style="white-space: normal">
                                                        @php
                                                            echo $field->question;
                                                        @endphp
                                                    </td>
                                                    <td>
                                                        <select wire:model="commissionings.{{ $field->id }}.condition" placeholder="select Kondisi" class="form-select w-100 select2" required>
                                                            <option value="">--Select--</option>
                                                            <option value="Baik">Baik</option>
                                                            <option value="Gagal">Gagal</option>
                                                            <option value="N/A">N/A</option>
                                                        </select>
                                                    </td>
                                                    <td>
                                                        @if(isset($this->commissionings[$field->id]['condition']))
                                                            @if($this->commissionings[$field->id]['condition'] == 'Gagal')
                                                                <x-inputs.textarea type="text" id="commissionings.{{ $field->id }}.note" wire:model="commissionings.{{ $field->id }}.note" placeholder="keterangan" class="form-control" :error="'commissionings.{{ $field->id }}.note'" required></x-inputs.textarea>
                                                            @endif
                                                        @endif
                                                    </td>
                                                    <td>
                                                        @if(isset($this->commissionings[$field->id]['condition']))
                                                            @if($this->commissionings[$field->id]['condition'] == 'Gagal')
                                                                <x-inputs.file type="file" wire:model="commissionings.{{ $field->id }}.attachments" multiple id="commissionings.{{ $field->id }}.attachments" :error="'commissionings.{{ $field->id }}.attachments'" required></x-inputs.file>
                                                            @endif
                                                        @endif
                                                    </td>
                                                    <td>{{$field->hazard_code}}</td>
                                                </tr>
                                                @endforeach
                                            @endforeach

                                        </tbody>
                                    </table>

                                </div>

                            </div><!-- /.kegiatan-loop -->

                        </div><!-- /.content-form -->

                        <div class="space">
                            <hr>
                        </div>

                        <div class="footer-action mb-2 p-3">
                            <div class="action-wrapper d-flex align-items-center justify-content-end gap-2">
                                <a href="#" class="btn btn-outline-secondary" onclick="history.back();">Cancel</a>
                                <button type="submit" class="btn btn-outline-default bg-green d-flex justify-content-center align-item-center text-white position-relative px-4" wire:loading.attr="disabled">Simpan</button>
                            </div>
                        </div>

                    </div>
                </div><!-- /.col-sm-12 -->

            </div><!-- /.row -->

        </form>

    </div>
</div>
