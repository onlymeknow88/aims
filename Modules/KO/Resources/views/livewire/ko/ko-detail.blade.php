<div class="inner-content">

    <div class="header-detail-maker h-60px border d-flex gap-2 align-items-center px-3">
        <a href="#" onclick="history.back();" class="d-flex align-items-center gap-3">
            <span><i class="fa-solid fa-arrow-left"></i></span>
            <span>KO</span>
        </a>
    </div>

    <div class="detail-approval-content d-flex">

        <div class="detail-left border-end border-1">

            <div class="info bg-white">

                <div class="info-item p-3 border-bottom border-1">

                    <div class="created d-flex flex-column gap-2">

                        <h6 class="fw-normal">Status</h6>

                        <div class="item-content d-flex gap-1 align-items-center">
                            <span class="opacity-50"></span>
                            <span>
                                {{$koProposal->status}}
                            </span>
                        </div>

                    </div><!-- /.author -->

                </div><!-- /.info-items -->

                <div class="info-item p-3 border-bottom border-1">

                    <div class="created d-flex flex-column gap-2">

                        <h6 class="fw-normal">Created</h6>

                        <div class="item-content d-flex gap-1 align-items-center">
                            <span class="opacity-50">at</span>
                            <span>
                                {{date("d-F-Y", strtotime($koProposal->created_at))}}
                            </span>
                        </div>

                    </div><!-- /.author -->

                </div><!-- /.info-items -->

            </div><!-- /.info -->

        </div>

        <!-- center -->
        <div class="section-content w-100 py-3 px-5 d-flex flex-column gap-3">

            <div class="section-info py-3 px-2 d-flex flex-column gap-2">

                <h5 class="fw-normal">DATA SARANA, PRASANA, INSTALASI DAN PERALATAN PERTAMBANGAN</h5>

                <div class="content-section d-flex flex-column gap-1">

                    <div class="module-info-items row">
                        <div class="col-4 opacity-50">Number</div>
                        <div class="col-8">{{$koProposal->number}}</div>
                    </div><!-- /.module-info-items -->

                    <div class="module-info-items row">
                        <div class="col-4 opacity-50">CCOW</div>
                        <div class="col-8">{{$koProposal->ccow->company_name}}</div>
                    </div><!-- /.module-info-items -->

                    <div class="module-info-items row">
                        <div class="col-4 opacity-50">Area Kerja</div>
                        <div class="col-8">{{$koProposal->area}}</div>
                    </div><!-- /.module-info-items -->

                    <div class="module-info-items row">
                        <div class="col-4 opacity-50">Kategori SPIP</div>
                        <div class="col-8">{{$koProposal->koUnit->koSpipUnit->koSpipType->koSpipCategory->name}}</div>
                    </div><!-- /.module-info-items -->

                    <div class="module-info-items row">
                        <div class="col-4 opacity-50">Klasifikasi SPIP</div>
                        <div class="col-8">{{$koProposal->koUnit->koSpipUnit->koSpipType->name}}</div>
                    </div><!-- /.module-info-items -->

                    <div class="module-info-items row">
                        <div class="col-4 opacity-50">Deskripsi SPIP</div>
                        <div class="col-8">{{$koProposal->koUnit->koSpipUnit->name}}</div>
                    </div><!-- /.module-info-items -->

                    <div class="module-info-items row">
                        <div class="col-4 opacity-50">Call Sign</div>
                        <div class="col-8">{{$koProposal->koUnit->call_sign}}</div>
                    </div><!-- /.module-info-items -->

                    <div class="module-info-items row">
                        <div class="col-4 opacity-50">Nomor IMB/STNK</div>
                        <div class="col-8">{{$koProposal->koUnit->identity_number ?? '-'}}</div>
                    </div><!-- /.module-info-items -->

                    <div class="module-info-items row">
                        <div class="col-4 opacity-50">Merk / Brand SPIP</div>
                        <div class="col-8">{{$koProposal->koUnit->koBrand->name ?? '-' }}</div>
                    </div><!-- /.module-info-items -->

                    <div class="module-info-items row">
                        <div class="col-4 opacity-50">Nomor Serial SPIP</div>
                        <div class="col-8">{{$koProposal->koUnit->serial_number}}</div>
                    </div><!-- /.module-info-items -->

                    <div class="module-info-items row">
                        <div class="col-4 opacity-50">Tahun Pembuatan Unit SPIP</div>
                        <div class="col-8">{{$koProposal->koUnit->production_year}}</div>
                    </div><!-- /.module-info-items -->

                    <div class="module-info-items row">
                        <div class="col-4 opacity-50">Tanggal Komisioning</div>
                        <div class="col-8">
                            {{ $koProposal->koCommissioning ? date("d-m-Y", strtotime($koProposal->koCommissioning->created_at)) : '-' }}
                        </div>
                    </div><!-- /.module-info-items -->

                    <div class="module-info-items row">
                        <div class="col-4 opacity-50">Jadwal Komisioning</div>
                        <div class="col-8">{{$koProposal->internal_komisioning_schedule ?? '-'}}</div>
                    </div><!-- /.module-info-items -->

                    <div class="module-info-items row">
                        <div class="col-4 opacity-50">Komisioning Selanjutnya</div>
                        <div class="col-8">{{$koProposal->next_commissioning ?? '-'}}</div>
                    </div><!-- /.module-info-items -->

                    <div class="module-info-items row">
                        <div class="col-4 opacity-50">Period Komisionong</div>
                        <div class="col-8">{{$koProposal->commissioning_period}}</div>
                    </div><!-- /.module-info-items -->

                </div><!-- /.content-section -->

            </div><!-- /.section-info -->


            <div class="section-info py-3 px-2 d-flex flex-column gap-2">

                <h5 class="fw-normal">DATA PENGGUNA</h5>

                <div class="content-section d-flex flex-column gap-1">

                    <div class="module-info-items row">
                        <div class="col-4 opacity-50">Company</div>
                        <div class="col-8">{{$koProposal->company->company_name}}</div>
                    </div><!-- /.module-info-items -->

                    <div class="module-info-items row">
                        <div class="col-4 opacity-50">Departement</div>
                        <div class="col-8">
                            {{ $koProposal->department ? $koProposal->department->name : $koProposal->other_department }}
                        </div>
                    </div><!-- /.module-info-items -->

                    <div class="module-info-items row">
                        <div class="col-4 opacity-50">Alamat Email Pemohon</div>
                        <div class="col-8">{{$koProposal->applicant_email}}</div>
                    </div><!-- /.module-info-items -->

                    <div class="module-info-items row">
                        <div class="col-4 opacity-50">PJO</div>
                        <div class="col-8">{{$koProposal->pjo->name ?? '-'}}</div>
                    </div><!-- /.module-info-items -->

                </div><!-- /.content-section -->

            </div><!-- /.section-info -->

            <div class="section-attachment py-3 px-2 d-flex flex-column gap-2">

                <h5 class="fw-normal">Attachment</h5>

                <div class="content-section d-flex flex-column gap-1">

                    <div class="module-attachment-items d-flex flex-wrap gap-2">

                        @if($koProposal->koAttachment->stnk)
                        <div class="files-content d-flex gap-2 flex-wrap">

                            <a target="blank" href="{{asset('storage/'.$koProposal->koAttachment->stnk)}}">
                                <div class="image d-flex flex-column align-items-start justify-content-center bg-white rounded p-3 border border-1">
                                    <div class="thumb mb-2">
                                        <img src="{{url('images/icons/pdf.png')}}" alt="pdf">
                                    </div>
                                    <div class="img-name">stnk</div>
                                    <div class="img-size opacity-50"></div>
                                </div><!-- image -->
                            </a>

                        </div><!-- /.files-content -->
                        @endif

                        @if($koProposal->koAttachment->nota_pajak)
                        <div class="files-content d-flex gap-2 flex-wrap">

                            <a target="blank" href="{{asset('storage/'.$koProposal->koAttachment->nota_pajak)}}">
                                <div class="image d-flex flex-column align-items-start justify-content-center bg-white rounded p-3 border border-1">
                                    <div class="thumb mb-2">
                                        <img src="{{url('images/icons/pdf.png')}}" alt="pdf">
                                    </div>
                                    <div class="img-name">nota_pajak</div>
                                    <div class="img-size opacity-50"></div>
                                </div><!-- image -->
                            </a>

                        </div><!-- /.files-content -->
                        @endif

                        @if($koProposal->koAttachment->surat_pengantar)
                        <div class="files-content d-flex gap-2 flex-wrap">

                            <a target="blank" href="{{asset('storage/'.$koProposal->koAttachment->surat_pengantar)}}">
                                <div class="image d-flex flex-column align-items-start justify-content-center bg-white rounded p-3 border border-1">
                                    <div class="thumb mb-2">
                                        <img src="{{url('images/icons/pdf.png')}}" alt="pdf">
                                    </div>
                                    <div class="img-name">surat_pengantar</div>
                                    <div class="img-size opacity-50"></div>
                                </div><!-- image -->
                            </a>

                        </div><!-- /.files-content -->
                        @endif

                        @if($koProposal->koAttachment->re_manufacture)
                        <div class="files-content d-flex gap-2 flex-wrap">

                            <a target="blank" href="{{asset('storage/'.$koProposal->koAttachment->re_manufacture)}}">
                                <div class="image d-flex flex-column align-items-start justify-content-center bg-white rounded p-3 border border-1">
                                    <div class="thumb mb-2">
                                        <img src="{{url('images/icons/pdf.png')}}" alt="pdf">
                                    </div>
                                    <div class="img-name">re_manufacture</div>
                                    <div class="img-size opacity-50"></div>
                                </div><!-- image -->
                            </a>

                        </div><!-- /.files-content -->
                        @endif

                        @if($koProposal->koAttachment->oem)
                        <div class="files-content d-flex gap-2 flex-wrap">

                            <a target="blank" href="{{asset('storage/'.$koProposal->koAttachment->oem)}}">
                                <div class="image d-flex flex-column align-items-start justify-content-center bg-white rounded p-3 border border-1">
                                    <div class="thumb mb-2">
                                        <img src="{{url('images/icons/pdf.png')}}" alt="pdf">
                                    </div>
                                    <div class="img-name">oem</div>
                                    <div class="img-size opacity-50"></div>
                                </div><!-- image -->
                            </a>

                        </div><!-- /.files-content -->
                        @endif

                        @if($koProposal->koAttachment->dokumen_sertifikat)
                        <div class="files-content d-flex gap-2 flex-wrap">

                            <a target="blank" href="{{asset('storage/'.$koProposal->koAttachment->dokumen_sertifikat)}}">
                                <div class="image d-flex flex-column align-items-start justify-content-center bg-white rounded p-3 border border-1">
                                    <div class="thumb mb-2">
                                        <img src="{{url('images/icons/pdf.png')}}" alt="pdf">
                                    </div>
                                    <div class="img-name">dokumen_sertifikat</div>
                                    <div class="img-size opacity-50"></div>
                                </div><!-- image -->
                            </a>

                        </div><!-- /.files-content -->
                        @endif

                        @if($koProposal->koAttachment->inspeksi_p3k)
                        <div class="files-content d-flex gap-2 flex-wrap">

                            <a target="blank" href="{{asset('storage/'.$koProposal->koAttachment->inspeksi_p3k)}}">
                                <div class="image d-flex flex-column align-items-start justify-content-center bg-white rounded p-3 border border-1">
                                    <div class="thumb mb-2">
                                        <img src="{{url('images/icons/pdf.png')}}" alt="pdf">
                                    </div>
                                    <div class="img-name">inspeksi_p3k</div>
                                    <div class="img-size opacity-50"></div>
                                </div><!-- image -->
                            </a>

                        </div><!-- /.files-content -->
                        @endif

                        @if($koProposal->koAttachment->kir)
                        <div class="files-content d-flex gap-2 flex-wrap">

                            <a target="blank" href="{{asset('storage/'.$koProposal->koAttachment->kir)}}">
                                <div class="image d-flex flex-column align-items-start justify-content-center bg-white rounded p-3 border border-1">
                                    <div class="thumb mb-2">
                                        <img src="{{url('images/icons/pdf.png')}}" alt="pdf">
                                    </div>
                                    <div class="img-name">kir</div>
                                    <div class="img-size opacity-50"></div>
                                </div><!-- image -->
                            </a>

                        </div><!-- /.files-content -->
                        @endif

                        @if($koProposal->koAttachment->uji_pjit)
                        <div class="files-content d-flex gap-2 flex-wrap">

                            <a target="blank" href="{{asset('storage/'.$koProposal->koAttachment->uji_pjit)}}">
                                <div class="image d-flex flex-column align-items-start justify-content-center bg-white rounded p-3 border border-1">
                                    <div class="thumb mb-2">
                                        <img src="{{url('images/icons/pdf.png')}}" alt="pdf">
                                    </div>
                                    <div class="img-name">uji_pjit</div>
                                    <div class="img-size opacity-50"></div>
                                </div><!-- image -->
                            </a>

                        </div><!-- /.files-content -->
                        @endif

                        @if($koProposal->koAttachment->pra_komisioning)
                        <div class="files-content d-flex gap-2 flex-wrap">

                            <a target="blank" href="{{asset('storage/'.$koProposal->koAttachment->pra_komisioning)}}">
                                <div class="image d-flex flex-column align-items-start justify-content-center bg-white rounded p-3 border border-1">
                                    <div class="thumb mb-2">
                                        <img src="{{url('images/icons/pdf.png')}}" alt="pdf">
                                    </div>
                                    <div class="img-name">pra_komisioning</div>
                                    <div class="img-size opacity-50"></div>
                                </div><!-- image -->
                            </a>

                        </div><!-- /.files-content -->
                        @endif

                        @if($koProposal->koAttachment->setting_radio)
                        <div class="files-content d-flex gap-2 flex-wrap">

                            <a target="blank" href="{{asset('storage/'.$koProposal->koAttachment->setting_radio)}}">
                                <div class="image d-flex flex-column align-items-start justify-content-center bg-white rounded p-3 border border-1">
                                    <div class="thumb mb-2">
                                        <img src="{{url('images/icons/pdf.png')}}" alt="pdf">
                                    </div>
                                    <div class="img-name">setting_radio</div>
                                    <div class="img-size opacity-50"></div>
                                </div><!-- image -->
                            </a>

                        </div><!-- /.files-content -->
                        @endif

                        @if($koProposal->koAttachment->slo)
                        <div class="files-content d-flex gap-2 flex-wrap">

                            <a target="blank" href="{{asset('storage/'.$koProposal->koAttachment->slo)}}">
                                <div class="image d-flex flex-column align-items-start justify-content-center bg-white rounded p-3 border border-1">
                                    <div class="thumb mb-2">
                                        <img src="{{url('images/icons/pdf.png')}}" alt="pdf">
                                    </div>
                                    <div class="img-name">slo</div>
                                    <div class="img-size opacity-50"></div>
                                </div><!-- image -->
                            </a>

                        </div><!-- /.files-content -->
                        @endif

                        @if($koProposal->koAttachment->komisioning_internal)
                        <div class="files-content d-flex gap-2 flex-wrap">

                            <a target="blank" href="{{asset('storage/'.$koProposal->koAttachment->komisioning_internal)}}">
                                <div class="image d-flex flex-column align-items-start justify-content-center bg-white rounded p-3 border border-1">
                                    <div class="thumb mb-2">
                                        <img src="{{url('images/icons/pdf.png')}}" alt="pdf">
                                    </div>
                                    <div class="img-name">komisioning_internal</div>
                                    <div class="img-size opacity-50"></div>
                                </div><!-- image -->
                            </a>

                        </div><!-- /.files-content -->
                        @endif

                        @if($koProposal->koAttachment->com)
                        <div class="files-content d-flex gap-2 flex-wrap">

                            <a target="blank" href="{{asset('storage/'.$koProposal->koAttachment->com)}}">
                                <div class="image d-flex flex-column align-items-start justify-content-center bg-white rounded p-3 border border-1">
                                    <div class="thumb mb-2">
                                        <img src="{{url('images/icons/pdf.png')}}" alt="pdf">
                                    </div>
                                    <div class="img-name">com</div>
                                    <div class="img-size opacity-50"></div>
                                </div><!-- image -->
                            </a>

                        </div><!-- /.files-content -->
                        @endif

                    </div><!-- /.module-attachment-items -->

                </div><!-- /.content-section -->

            </div><!-- /.section-Attachment -->

            @if($koProposal->koIssueReports->count() != 0)
            <div class="section-info py-3 px-2 d-flex flex-column gap-2">

                <h5 class="fw-normal">Berita Acara</h5>

                <div class="content-section d-flex flex-column gap-1">

                    <table class="table table-bordered align-items-center table-sm">

                        <thead class="thead-light">
                            <tr style="border-left:1px solid #dddddd;">
                                <th>#</th>
                                <th>Tanggal</th>
                                <th>Desc Temuan</th>
                                <th>Kode Bahaya</th>
                                <th>Status</th>
                                <th>Attachment</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($koProposal->koIssueReports as $key => $item)
                            <tr style="border-left:1px solid #dddddd;">
                                <td>{{$key+1}}</td>
                                <td scope="row">
                                    <a style="color: green; font-weight: bold" href="#">
                                        {{ date('d-m-Y', strtotime($item->created_at)) }}
                                    </a>
                                </td>
                                <td>{{ $item->note }}</td>
                                <td>{{ $item->hazard_code }}</td>
                                <td>{{ $item->status }}</td>
                                <td>
                                    @foreach($item->attachments as $attachment)
                                    <a target="blank" style="color: green;" href="{{asset('storage/'.$attachment->attachment)}}">
                                        <!-- <img src="{{ asset('/images/icons/pdf.png') }}" alt="pdf" /> -->
                                        <span>
                                            - {{ $attachment->name }}
                                        </span>
                                    </a><br>
                                    @endforeach
                                </td>
                            </tr>
                            @endforeach

                        </tbody>
                    </table>

                </div><!-- /.content-section -->

            </div><!-- /.section-info -->
            @endif

            @if($koProposal->koCommissioning)
            <div class="row justify-content-center">

                <div class="col-sm-12">

                    <div class="form-susunan-kegiatan py-4 d-flex flex-column gap-5" action="#">

                        <div class="title-form text-center">
                            <h2>Formulir Komisioning</h2>
                            <a href="#" wire:click="export()" class="btn btn-outline-default bg-green align-item-center text-white position-relative px-4">
                                Export
                            </a>
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
                                                <th style="width: 10px; white-space: normal">KODE BAHAYA</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach($koProposal->koUnit->koSpipUnit->koCommisioningHeaders as $key => $header)
                                            <tr style="border-left:1px solid #dddddd;">
                                                <td>{{$header->number}}.</td>
                                                <td colspan="4"><b>DOKUMEN KENDARAAN</b></td>
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
                                                        {{$field->koCommissioningItem($koProposal->koCommissioning->id)->first()->condition}}
                                                    </td>
                                                    <td style="white-space: normal">
                                                        {{$field->koCommissioningItem($koProposal->koCommissioning->id)->first()->note ?? '-'}}
                                                    </td>
                                                    <td class="text-center">{{$field->hazard_code}}</td>
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

                    </div>
                </div><!-- /.col-sm-12 -->

            </div><!-- /.row -->
            @endif

            <div class="footer-action mb-2">
                <div class="action-wrapper d-flex align-items-center justify-content-end gap-2">

                </div>
            </div>
        </div><!-- /.section-content -->


        
        <div class="detail-right border-start border-1">
            <div class="info bg-white px-3">
            </div>
        </div>

    </div>
</div>
