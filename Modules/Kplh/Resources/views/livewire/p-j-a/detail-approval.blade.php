<div class="inner-content">
    <div class="header-edit-event h-60px bg-white shadow-sm d-flex gap-2 align-items-center justify-content-between px-3">
        <div class="left-header">
            <a href="javascript:history.go(-1)" class="d-flex align-items-center gap-3">
                <span><i class="fa-solid fa-arrow-left"></i></span>
                <span>Detail Inspeksi</span>
            </a>
        </div><!-- /.left-header -->
        <div class="right-header">
        </div><!-- /.right-header -->
    </div><!-- /.header-edit-event -->

    <div class="container-fluid g-0 position-relative">
        <div class="row g-0">

            <div class="detail-left col-3">
                <div class="position-sticky top-0 bg-white pb-4">
                    <div class="info-item py-3 px-4 border-bottom border-1">

                        <div class="info-item p-3 border-bottom border-1">

                            <div class="author d-flex flex-column gap-2">
                                <h6>Maker</h6>
                                <div class="item-content d-flex gap-2 align-items-center">
                                    <div class="thumb">
                                        <img src="{{ asset('./images/author.png') }}" alt="Author">
                                    </div>
                                    <div class="author-name">{{ $staff->name }}</div>
                                </div>
                            </div><!-- /.author -->

                        </div><!-- /.info-items -->

                        <div class="pt d-flex flex-column">
                            <h6></h6>
                            <div class="item-content d-flex gap-2 align-items-start">
                                <div class="thumb">
                                    <img src="{{ asset('./images/icons/position.png') }}" alt="Position">
                                </div>
                                <div class="position-name d-flex flex-column">
                                    <span class="opacity-80">Position</span>
                                    <span>{{ $staff->employee->position }}</span>
                                </div>
                            </div>
                            <div class="item-content d-flex gap-2 align-items-start">
                                <div class="thumb">
                                    <img src="{{ asset('./images/icons/map.png') }}" alt="Location">
                                </div>
                                <div class="location-name d-flex flex-column">
                                    <span class="opacity-80">Location Detail</span>
                                    <span>
                                        @if ($staff->department)
                                            {{ $staff->department->company->address }}
                                        @else
                                            -
                                        @endif
                                    </span>
                                </div>
                            </div>
                            <div class="item-content d-flex gap-2 align-items-start">
                                <div class="thumb">
                                    <img src="{{ asset('./images/icons/map.png') }}" alt="Department">
                                </div>
                                <div class="department-name d-flex flex-column">
                                    <span class="opacity-80">Department</span>
                                    <span>
                                        @if ($staff->department)
                                            {{ $staff->department->name }}
                                        @else
                                            -
                                        @endif
                                    </span>
                                </div>
                            </div>
                        </div><!-- /.pt -->

                    </div><!-- /.info-items -->
                    <div class="info-item py-3 px-4 border-bottom border-1">
                        <div class="nip d-flex flex-column">
                            <h6>NIP/NIK</h6>
                            <div class="item-content d-flex gap-1 align-items-center">
                                <span class="opacity-80">
                                    {{ $staff->employee->number }} / {{ $staff->employee->id_number }}
                                </span>
                            </div>
                        </div><!-- /.nip -->
                    </div><!-- /.info-items -->
                    <div class="info-item py-3 px-4 border-bottom border-1">
                        <div class="created d-flex flex-column">
                            <h6>Dibuat</h6>
                            <div class="item-content d-flex gap-1 align-items-center">
                                {{-- <span class="opacity-80">oleh</span>
                                <span>{{ $staff->name }}</span>
                                <span class="opacity-80">pada</span> --}}
                                <span>
                                    {{ \Carbon\Carbon::parse($data->created_at)->format('d F Y') }}
                                </span>
                            </div>
                        </div><!-- /.created -->
                    </div><!-- /.info-items -->
                    <div class="info-item py-3 px-4 border-bottom border-1">
                        <div class="review d-flex flex-column">
                            <h6>Terakhir Diupdate</h6>
                            <div class="item-content d-flex gap-1 align-items-center">
                                {{-- <span class="opacity-80">oleh</span>
                                <span>{{ $staff->name }}</span>
                                <span class="opacity-80">pada</span> --}}
                                <span>
                                    {{ \Carbon\Carbon::parse($data->updated_at)->format('d F Y') }}
                                </span>
                            </div>
                        </div><!-- /.review -->
                    </div><!-- /.info-items -->
                </div><!-- /.info -->
            </div><!-- /.detail-left -->

            <div class="col pb-7 border-end border-start border-1">

                <div id="label" class="section border-1 border-bottom p-5">
                    <div class="text-center">
                        @if ($data->inspect_criteria == 'food-hygiene')
                        <h5 class="mb-0 fw-normal title-accordion">INSPEKSI FOOD HYGIENE</h5>
                        @elseif ($data->inspect_criteria == 'workplace')
                        <h5 class="mb-0 fw-normal title-accordion">INSPEKSI TEMPAT KERJA MINGGUAN</h5>
                        @elseif ($data->inspect_criteria == 'k3-apar')
                        <h5 class="mb-0 fw-normal title-accordion">INSPEKSI K3 APAR</h5>
                        @elseif ($data->inspect_criteria == 'k3-apab')
                        <h5 class="mb-0 fw-normal title-accordion">INSPEKSI K3 APAB</h5>
                        @elseif ($data->inspect_criteria == 'k3-hydrant')
                        <h5 class="mb-0 fw-normal title-accordion">INSPEKSI K3 HYDRANT</h5>
                        @elseif ($data->inspect_criteria == 'k3-hose-rail')
                        <h5 class="mb-0 fw-normal title-accordion">INSPEKSI K3 HOSE RAIL</h5>
                        @elseif ($data->inspect_criteria == 'area-maintank')
                        <h5 class="mb-0 fw-normal title-accordion">INSPEKSI AREA MAINTANK</h5>
                        @elseif ($data->inspect_criteria == 'area-jetty')
                        <h5 class="mb-0 fw-normal title-accordion">INSPEKSI AREA JETTY</h5>
                        @endif
                    </div>

                    <div class="wrapper-content-section overflow-hidden position-relative transition-all duration-700">
                        <div class="content-section m-4">
                            <div class="mb-3 mcu-detail-item row">
                                <label class="col-6 opacity-80">Tanggal Inspeksi</label>
                                <div class="col-6 content">
                                    <div class="content">{{ \Carbon\Carbon::parse($data->date)->format('d F Y') }}</div>
                                </div>
                            </div>
                            <div class="mb-3 mcu-detail-item row">
                                <label class="col-6 opacity-80">CCOW</label>
                                <div class="col-6 content">
                                    <div class="content">{{ $data->ccow->company_name }}</div>
                                </div>
                            </div>
                            <div class="mb-3 mcu-detail-item row">
                                <label class="col-6 opacity-80">Perusahaan</label>
                                <div class="col-6 content">
                                    <div class="content">{{ $data->company->company_name }}</div>
                                </div>
                            </div>
                            <div class="mb-3 mcu-detail-item row">
                                <label class="col-6 opacity-80">Departemen</label>
                                <div class="col-6 content">
                                    <div class="content">{{ $data->department->name }}</div>
                                </div>
                            </div>
                            <div class="mb-3 mcu-detail-item row">
                                <label class="col-6 opacity-80">Section</label>
                                <div class="col-6 content">
                                    <div class="content">{{ $data->section->name }}</div>
                                </div>
                            </div>
                            <div class="mb-3 mcu-detail-item row">
                                <label class="col-6 opacity-80">Lokasi</label>
                                <div class="col-6 content">
                                    <div class="content">{{ $data->arealocation->name }}</div>
                                </div>
                            </div>
                            <div class="mb-3 mcu-detail-item row">
                                <label class="col-6 opacity-80">Detail Lokasi</label>
                                <div class="col-6 content">
                                    <div class="content">{{ $data->location_detail }}</div>
                                </div>
                            </div>
                            <div class="mb-3 mcu-detail-item row">
                                <label class="col-6 opacity-80">KTT/PJO</label>
                                <div class="col-6 content">
                                    <div class="content">{{ $data->ktt->name }}</div>
                                </div>
                            </div>
                            <div class="mb-3 mcu-detail-item row">
                                <label class="col-6 opacity-80">PJA</label>
                                <div class="col-6 content">
                                    <div class="content">{{ $data->pja->user->name }}</div>
                                </div>
                            </div>
                            <div class="mb-3 mcu-detail-item row">
                                <label class="col-6 opacity-80">Petugas Inspeksi</label>
                                <div class="col-6 content">
                                    <div class="content">
                                        @foreach ($data->inspection_officers as $io)
                                        <a class="btn btn-sm btn-outline-secondary">{{ $io->employee->name }}</a>
                                        @endforeach
                                    </div>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>

                @if ($data->inspect_criteria == 'food-hygiene')

                        @foreach ($questions['food-hygiene'] as $question0)
                            <div id="{{ $question0['category_name'] }}" class="section border-1 border-bottom p-5">
                                <div
                                    class="header-section d-flex justify-content-between w-100 border-0 bg-white my-3 mx-4">
                                    <h6 class="mb-0 fw-normal">{{ $question0['category_order'] }}.
                                        {{ $question0['category_name'] }}</h6>
                                </div>

                                <div class="wrapper-content-section overflow-hidden position-relative transition-all duration-700">

                                    @foreach ($question0['data'] as $question1)
                                        @foreach ($data->inspection_data as $index => $inspection)
                                            @if ($inspection->criteria == $question1['criteria'])
                                                @if ($inspection->value == 10)
                                                    <div class="content-section m-4 text-success">
                                                    @else
                                                    <div class="content-section m-4 text-danger">
                                                @endif
                                                        <div class="mb-3 mcu-detail-item row">
                                                            <label class="col-8 opacity-80">{{ $question1['question'] }}</label>

                                                            <div class="col-4 content">
                                                                <div class="content">Nilai :
                                                                    {{ (isset($inspection->value)) ? $inspection->value : '-' }}</div>
                                                                @if ($inspection->value < 10)
                                                                <div class="content">
                                                                    <a class="btn btn-sm btn-outline-primary"
                                                                    href="{{ route('kplh::download-file', ['food_hygiene', (($inspection->file) ? $inspection->file : '')]) }}"
                                                                    target="_blank"><i class="fa fa-file"></i>
                                                                    Link File
                                                                    </a>
                                                                </div>
                                                                    <div class="content">Catatan :<pre>{!! $inspection->note !!}</pre></div>
                                                                @endif
                                                            </div>
                                                        </div>
                                                    </div>
                                            @endif
                                        @endforeach
                                    @endforeach

                                </div>
                            </div>
                        @endforeach

                @elseif ($data->inspect_criteria == 'workplace')

                    @foreach ($questions['workplace'] as $question0)
                        <div id="{{ $question0['category_name'] }}" class="section border-1 border-bottom p-5">
                            <div
                                class="header-section d-flex justify-content-between w-100 border-0 bg-white my-3 mx-4">
                                <h6 class="mb-0 fw-normal">{{ $question0['category_order'] }}.
                                    {{ $question0['category_name'] }}</h6>
                            </div>

                            <div class="wrapper-content-section overflow-hidden position-relative transition-all duration-700">

                            @foreach ($question0['data'] as $question1)
                                @foreach ($data->inspection_data as $index => $inspection)
                                    @if ($inspection->criteria == $question1['criteria'])
                                        @if ($inspection->k3_value != 'Tidak')
                                            <div class="content-section m-4 text-success">
                                        @else
                                            <div class="content-section m-4 text-danger">
                                        @endif
                                                <div class="mb-3 mcu-detail-item row">
                                                    <hr>
                                                    <label class="col-8 opacity-80">{{ $question1['question'] }}</label>

                                                    <div class="col-4 content">
                                                        <div class="content">
                                                            <h6>{{ (isset($inspection->k3_value)) ? $inspection->k3_value : '-' }}</h6>
                                                        </div>
                                                        @if ($inspection->k3_value == 'Tidak')

                                                        <div class="content mt-2">
                                                            <pre style="padding:0px;background:#fff;text-align:justify;font-family:calibri,arial,sans-serif;">
                                                            {!! $inspection->note !!}
                                                            </pre>
                                                        </div>
                                                        <div class="content mt-2 mb-2">
                                                            <a class="text-danger"
                                                            href="{{ route('kplh::download-file', ['workplace', (($inspection->file) ? $inspection->file : '')]) }}"
                                                            target="_blank">
                                                            <b><u>Link File</u></b>
                                                            </a>
                                                        </div>
                                                        @endif
                                                    </div>
                                                    <hr>
                                                </div>
                                            </div>
                                    @endif
                                @endforeach
                            @endforeach

                            </div>
                        </div>
                    @endforeach

                @elseif ($data->inspect_criteria == 'k3-apar')

                    @foreach ($questions['k3-apar'] as $question0)
                    @if ($data->tool_id)
                    <div class="content-section m-4 text-success">
                        <div class="mb-3 mcu-detail-item row">
                            <hr>
                            <label class="col-8 opacity-80">---</label>
                        </div>
                    </div>
                @endif
                            <div id="{{ $question0['category_name'] }}" class="section border-1 border-bottom p-5">
                                <div
                                    class="header-section d-flex justify-content-between w-100 border-0 bg-white my-3 mx-4">
                                    <h6 class="mb-0 fw-normal">{{ $question0['category_name'] }}</h6>
                                </div>

                                <div class="wrapper-content-section overflow-hidden position-relative transition-all duration-700">

                                @foreach ($question0['data'] as $question1)
                                    @foreach ($data->inspection_data as $index => $inspection)
                                        @if ($inspection->criteria == $question1['criteria'])
                                            @if ($inspection->k3_value == 'Tidak Standard' || $inspection->k3_value == 'Perlu Penggantian' || $inspection->k3_value == 'Tidak Ada' || $inspection->k3_value == 'Terdapat Penghalang' || $inspection->k3_value == 'Warna Demarkasi Pudar' )
                                                <div class="content-section m-4 text-danger">
                                            @else
                                                <div class="content-section m-4 text-success">
                                            @endif
                                                    <div class="mb-3 mcu-detail-item row">
                                                        <hr>
                                                        <label class="col-8 opacity-80">{{ $question1['question'] }}</label>

                                                        <div class="col-4 content">
                                                            <div class="content">
                                                                <h6>
                                                                    {!! (isset($inspection->k3_value)) ? $inspection->k3_value : '-' !!}
                                                                    {!! (isset($inspection->k3_value_2)) ? '<br>'. $inspection->k3_value_2.'' : '' !!}
                                                                    {!! (isset($inspection->k3_value_3)) ? '<br>'. $inspection->k3_value_3.'' : '' !!}
                                                                </h6>
                                                            </div>
                                                            @if ($inspection->k3_value == 'Tidak Standard' || $inspection->k3_value == 'Perlu Penggantian' || $inspection->k3_value == 'Tidak Ada' || $inspection->k3_value == 'Terdapat Penghalang' || $inspection->k3_value == 'Warna Demarkasi Pudar' )

                                                                <div class="content mt-2">
                                                                    <pre style="line-height:1.1em;padding:0px;background:#fff;text-align:justify;font-family:calibri,arial,sans-serif;">
                                                                    {!! $inspection->note !!}
                                                                    </pre>
                                                                </div>
                                                                <div class="content mt-2 mb-2">
                                                                    <a class="text-danger"
                                                                    href="{{ route('kplh::download-file', ['k3', (($inspection->file) ? $inspection->file : '')]) }}"
                                                                    target="_blank">
                                                                    <b><u>Link File</u></b>
                                                                    </a>
                                                                </div>
                                                            @endif
                                                        </div>
                                                        <hr>
                                                    </div>
                                                </div>
                                        @endif
                                    @endforeach
                                @endforeach

                                </div>
                            </div>
                    @endforeach

                @elseif ($data->inspect_criteria == 'k3-apab')

                    @foreach ($questions['k3-apab'] as $question0)
                            <div id="{{ $question0['category_name'] }}" class="section border-1 border-bottom p-5">
                                <div
                                    class="header-section d-flex justify-content-between w-100 border-0 bg-white my-3 mx-4">
                                    <h6 class="mb-0 fw-normal">{{ $question0['category_name'] }}</h6>
                                </div>

                                <div class="wrapper-content-section overflow-hidden position-relative transition-all duration-700">

                                @foreach ($question0['data'] as $question1)
                                    @foreach ($data->inspection_data as $index => $inspection)
                                        @if ($inspection->criteria == $question1['criteria'])
                                            @if ($inspection->k3_value == 'Tidak Standard' || $inspection->k3_value == 'Perlu Penggantian' || $inspection->k3_value == 'Tidak Ada' || $inspection->k3_value == 'Terdapat Penghalang' || $inspection->k3_value == 'Warna Demarkasi Pudar' )
                                                <div class="content-section m-4 text-danger">
                                            @else
                                                <div class="content-section m-4 text-success">
                                            @endif
                                                    <div class="mb-3 mcu-detail-item row">
                                                        <hr>
                                                        <label class="col-8 opacity-80">{{ $question1['question'] }}</label>

                                                        <div class="col-4 content">
                                                            <div class="content">
                                                                <h6>
                                                                    {!! (isset($inspection->k3_value)) ? $inspection->k3_value : '-' !!}
                                                                    {!! (isset($inspection->k3_value_2)) ? '<br>'. $inspection->k3_value_2.'' : '' !!}
                                                                    {!! (isset($inspection->k3_value_3)) ? '<br>'. $inspection->k3_value_3.'' : '' !!}
                                                                </h6>
                                                            </div>
                                                            @if ($inspection->k3_value == 'Tidak Standard' || $inspection->k3_value == 'Perlu Penggantian' || $inspection->k3_value == 'Tidak Ada' || $inspection->k3_value == 'Terdapat Penghalang' || $inspection->k3_value == 'Warna Demarkasi Pudar' )

                                                                <div class="content mt-2">
                                                                    <pre style="line-height:1.1em;padding:0px;background:#fff;text-align:justify;font-family:calibri,arial,sans-serif;">
                                                                    {!! $inspection->note !!}
                                                                    </pre>
                                                                </div>
                                                                <div class="content mt-2 mb-2">
                                                                    <a class="text-danger"
                                                                    href="{{ route('kplh::download-file', ['k3', (($inspection->file) ? $inspection->file : '')]) }}"
                                                                    target="_blank">
                                                                    <b><u>Link File</u></b>
                                                                    </a>
                                                                </div>
                                                            @endif
                                                        </div>
                                                        <hr>
                                                    </div>
                                                </div>
                                        @endif
                                    @endforeach
                                @endforeach

                                </div>
                            </div>
                    @endforeach

                @elseif ($data->inspect_criteria == 'k3-hydrant')

                    @foreach ($questions['k3-hydrant'] as $question0)
                        <div id="{{ $question0['category_name'] }}" class="section border-1 border-bottom p-5">
                            <div
                                class="header-section d-flex justify-content-between w-100 border-0 bg-white my-3 mx-4">
                                <h6 class="mb-0 fw-normal">{{ $question0['category_name'] }}</h6>
                            </div>

                            <div class="wrapper-content-section overflow-hidden position-relative transition-all duration-700">

                            @foreach ($question0['data'] as $question1)
                                @foreach ($data->inspection_data as $index => $inspection)
                                    @if ($inspection->criteria == $question1['criteria'])
                                        @if ($inspection->k3_value_2 == 'Tidak Standard' || $inspection->k3_value == 'Tidak Standard' || $inspection->k3_value == 'Perlu Penggantian' || $inspection->k3_value == 'Tidak Ada' || $inspection->k3_value == 'Terdapat Penghalang' || $inspection->k3_value == 'Warna Demarkasi Pudar' )
                                            <div class="content-section m-4 text-danger">
                                        @else
                                            <div class="content-section m-4 text-success">
                                        @endif
                                                <div class="mb-3 mcu-detail-item row">
                                                    <hr>
                                                    <label class="col-8 opacity-80">{{ $question1['question'] }}</label>

                                                    <div class="col-4 content">
                                                        <div class="content">
                                                            <h6>
                                                                {!! (isset($inspection->k3_value)) ? $inspection->k3_value : '-' !!}
                                                                {!! (isset($inspection->k3_value_2)) ? '<br>'. $inspection->k3_value_2.'' : '' !!}
                                                                {!! (isset($inspection->k3_value_3)) ? '<br>'. $inspection->k3_value_3.'' : '' !!}
                                                            </h6>
                                                        </div>

                                                        @if ($inspection->k3_value_2 == 'Tidak Standard' || $inspection->k3_value == 'Tidak Standard' || $inspection->k3_value == 'Perlu Penggantian' || $inspection->k3_value == 'Tidak Ada' || $inspection->k3_value == 'Terdapat Penghalang' || $inspection->k3_value == 'Warna Demarkasi Pudar' )
                                                            <div class="content mt-2">
                                                                <pre style="line-height:1.1em;padding:0px;background:#fff;text-align:justify;font-family:calibri,arial,sans-serif;">
                                                                {!! $inspection->note !!}
                                                                </pre>
                                                            </div>
                                                            <div class="content mt-2 mb-2">
                                                                <a class="text-danger"
                                                                href="{{ route('kplh::download-file', ['k3', (($inspection->file) ? $inspection->file : '')]) }}"
                                                                target="_blank">
                                                                <b><u>Link File</u></b>
                                                                </a>
                                                            </div>
                                                        @endif
                                                    </div>
                                                    <hr>
                                                </div>
                                            </div>
                                    @endif
                                @endforeach
                            @endforeach

                            </div>
                        </div>
                    @endforeach

                @elseif ($data->inspect_criteria == 'k3-hose-rail')

                    @foreach ($questions['k3-hose-rail'] as $question0)
                        <div id="{{ $question0['category_name'] }}" class="section border-1 border-bottom p-5">
                            <div
                                class="header-section d-flex justify-content-between w-100 border-0 bg-white my-3 mx-4">
                                <h6 class="mb-0 fw-normal">{{ $question0['category_name'] }}</h6>
                            </div>

                            <div class="wrapper-content-section overflow-hidden position-relative transition-all duration-700">

                            @foreach ($question0['data'] as $question1)
                                @foreach ($data->inspection_data as $index => $inspection)
                                    @if ($inspection->criteria == $question1['criteria'])
                                        @if ($inspection->k3_value_2 == 'Tidak Standard' || $inspection->k3_value == 'Tidak Standard' || $inspection->k3_value == 'Perlu Penggantian' || $inspection->k3_value == 'Tidak Ada' || $inspection->k3_value == 'Terdapat Penghalang' || $inspection->k3_value == 'Warna Demarkasi Pudar' )
                                            <div class="content-section m-4 text-danger">
                                        @else
                                            <div class="content-section m-4 text-success">
                                        @endif
                                                <div class="mb-3 mcu-detail-item row">
                                                    <hr>
                                                    <label class="col-6 opacity-80">{{ $question1['question'] }}</label>

                                                    <div class="col-6 content">
                                                        <div class="content">
                                                            <h6>
                                                                {!! (isset($inspection->k3_value)) ? $inspection->k3_value : '-' !!}
                                                                {!! (isset($inspection->k3_value_2)) ? '<br>'. $inspection->k3_value_2.'' : '' !!}
                                                                {!! (isset($inspection->k3_value_3)) ? '<br>'. $inspection->k3_value_3.'' : '' !!}
                                                            </h6>
                                                        </div>
                                                        @if ($inspection->k3_value_2 == 'Tidak Standard' || $inspection->k3_value == 'Tidak Standard' || $inspection->k3_value == 'Perlu Penggantian' || $inspection->k3_value == 'Tidak Ada' || $inspection->k3_value == 'Terdapat Penghalang' || $inspection->k3_value == 'Warna Demarkasi Pudar' )
                                                            <div class="content mt-2">
                                                                <pre style="line-height:1.1em;padding:0px;background:#fff;text-align:justify;font-family:calibri,arial,sans-serif;">
                                                                {!! $inspection->note !!}
                                                                </pre>
                                                            </div>
                                                            <div class="content mt-2 mb-2">
                                                                <a class="text-danger"
                                                                href="{{ route('kplh::download-file', ['k3', (($inspection->file) ? $inspection->file : '')]) }}"
                                                                target="_blank">
                                                                <b><u>Link File</u></b>
                                                                </a>
                                                            </div>
                                                        @endif
                                                    </div>
                                                    <hr>
                                                </div>
                                            </div>
                                    @endif
                                @endforeach
                            @endforeach

                            </div>
                        </div>
                    @endforeach

                @elseif ($data->inspect_criteria == 'k3-eye-wash')

                    @foreach ($questions['k3-eye-wash'] as $question0)
                        <div id="{{ $question0['category_name'] }}" class="section border-1 border-bottom p-5">
                            <div
                                class="header-section d-flex justify-content-between w-100 border-0 bg-white my-3 mx-4">
                                <h6 class="mb-0 fw-normal">{{ $question0['category_name'] }}</h6>
                            </div>

                            <div class="wrapper-content-section overflow-hidden position-relative transition-all duration-700">

                            @foreach ($question0['data'] as $question1)
                                @foreach ($data->inspection_data as $index => $inspection)
                                    @if ($inspection->criteria == $question1['criteria'])
                                        @if ($inspection->k3_value_2 == 'Tidak Standard' || $inspection->k3_value == 'Tidak Standard' || $inspection->k3_value == 'Perlu Penggantian' || $inspection->k3_value == 'Tidak Ada' || $inspection->k3_value == 'Terdapat Penghalang' || $inspection->k3_value == 'Warna Demarkasi Pudar' )
                                            <div class="content-section m-4 text-danger">
                                        @else
                                            <div class="content-section m-4 text-success">
                                        @endif
                                                <div class="mb-3 mcu-detail-item row">
                                                    <hr>
                                                    <label class="col-8 opacity-80">{{ $question1['question'] }}</label>

                                                    <div class="col-4 content">
                                                        <div class="content">
                                                            <h6>
                                                                {!! (isset($inspection->k3_value)) ? $inspection->k3_value : '-' !!}
                                                                {!! (isset($inspection->k3_value_2)) ? '<br>'. $inspection->k3_value_2.'' : '' !!}
                                                                {!! (isset($inspection->k3_value_3)) ? '<br>'. $inspection->k3_value_3.'' : '' !!}
                                                            </h6>
                                                        </div>
                                                        @if ($inspection->k3_value == 'Tidak Standard' || $inspection->k3_value == 'Perlu Penggantian' || $inspection->k3_value == 'Tidak Ada' || $inspection->k3_value == 'Terdapat Penghalang' || $inspection->k3_value == 'Warna Demarkasi Pudar' )

                                                            <div class="content mt-2">
                                                                <pre style="line-height:1.1em;padding:0px;background:#fff;text-align:justify;font-family:calibri,arial,sans-serif;">
                                                                {!! $inspection->note !!}
                                                                </pre>
                                                            </div>
                                                            <div class="content mt-2 mb-2">
                                                                <a class="text-danger"
                                                                href="{{ route('kplh::download-file', ['k3', (($inspection->file) ? $inspection->file : '')]) }}"
                                                                target="_blank">
                                                                <b><u>Link File</u></b>
                                                                </a>
                                                            </div>
                                                        @endif
                                                    </div>
                                                    <hr>
                                                </div>
                                            </div>
                                    @endif
                                @endforeach
                            @endforeach

                            </div>
                        </div>
                    @endforeach

                @elseif ($data->inspect_criteria == 'area-maintank')

                    @foreach ($questions['area-maintank'] as $question0)
                        <div id="{{ $question0['category_name'] }}" class="section border-1 border-bottom p-5">
                            <div
                                class="header-section d-flex justify-content-between w-100 border-0 bg-white my-3 mx-4">
                                <h6 class="mb-0 fw-normal">{{ $question0['category_name'] }}</h6>
                            </div>

                            <div class="wrapper-content-section overflow-hidden position-relative transition-all duration-700">

                            @foreach ($question0['data'] as $question1)
                                @foreach ($data->inspection_data as $index => $inspection)
                                    @if ($inspection->criteria == $question1['criteria'])
                                        @if ($inspection->k3_value == 'Tidak' || $inspection->k3_value == 'Warna Demarkasi Pudar' )
                                            <div class="content-section m-4 text-danger">
                                        @else
                                            <div class="content-section m-4 text-success">
                                        @endif
                                                <div class="mb-3 mcu-detail-item row">
                                                    <hr>
                                                    <label class="col-8 opacity-80">{{ $question1['question'] }}</label>

                                                    <div class="col-4 content">
                                                        <div class="content">
                                                            <h6>{{ (isset($inspection->k3_value)) ? $inspection->k3_value : '-' }}</h6>
                                                        </div>
                                                        @if ($inspection->k3_value == 'Tidak' || $inspection->k3_value == 'Perlu Penggantian' )

                                                            <div class="content mt-2">
                                                                <pre style="line-height:1.1em;padding:0px;background:#fff;text-align:justify;font-family:calibri,arial,sans-serif;">
                                                                <small>{!! $inspection->note !!}</small>
                                                                </pre>
                                                            </div>
                                                            <div class="content mt-2 mb-2">
                                                                <a class="text-danger"
                                                                href="{{ route('kplh::download-file', ['maintank', (($inspection->file) ? $inspection->file : '')]) }}"
                                                                target="_blank">
                                                                <b><u>Link File</u></b>
                                                                </a>
                                                            </div>
                                                        @endif
                                                    </div>
                                                    <hr>
                                                </div>
                                            </div>
                                    @endif
                                @endforeach
                            @endforeach

                            </div>
                        </div>
                    @endforeach

                @elseif ($data->inspect_criteria == 'area-jetty')

                    @foreach ($questions['area-jetty'] as $question0)
                        <div id="{{ $question0['category_name'] }}" class="section border-1 border-bottom p-5">
                            <div
                                class="header-section d-flex justify-content-between w-100 border-0 bg-white my-3 mx-4">
                                <h6 class="mb-0 fw-normal">{{ $question0['category_name'] }}</h6>
                            </div>

                            <div class="wrapper-content-section overflow-hidden position-relative transition-all duration-700">

                            @foreach ($question0['data'] as $question1)
                                @foreach ($data->inspection_data as $index => $inspection)
                                    @if ($inspection->criteria == $question1['criteria'])

                                        @if ($inspection->k3_value == 'Tidak' || $inspection->k3_value == 'Perlu Penggantian' )
                                            <div class="content-section m-4 text-danger">
                                        @else
                                            <div class="content-section m-4 text-success">
                                        @endif
                                                <div class="mb-3 mcu-detail-item row">
                                                    <hr>
                                                    <label class="col-8 opacity-80">{{ $question1['question'] }}</label>

                                                    <div class="col-4 content">
                                                        <div class="content">
                                                            <h6>{{ (isset($inspection->k3_value)) ? $inspection->k3_value : '-' }}</h6>
                                                        </div>
                                                        @if ($inspection->k3_value == 'Tidak' || $inspection->k3_value == 'Perlu Penggantian' )

                                                            <div class="content mt-2">
                                                                <pre style="line-height:1.1em;padding:0px;background:#fff;text-align:justify;font-family:calibri,arial,sans-serif;">
                                                                <small>{!! $inspection->note !!}</small>
                                                                </pre>
                                                            </div>
                                                            <div class="content mt-2 mb-2">
                                                                <a class="text-danger"
                                                                href="{{ route('kplh::download-file', ['jetty', (($inspection->file) ? $inspection->file : '')]) }}"
                                                                target="_blank">
                                                                <b><u>Link File</u></b>
                                                                </a>
                                                            </div>
                                                        @endif
                                                    </div>
                                                    <hr>
                                                </div>
                                            </div>
                                    @endif
                                @endforeach
                            @endforeach

                            </div>
                        </div>
                    @endforeach

                @endif

                <div id="summary" class="section border-1 border-bottom p-5">
                    <div class="header-section text-center">
                        <h6 class="mb-0 fw-normal title-accordion">RINGKASAN HASIL INSPEKSI</h6>
                    </div>
                    <hr>

                    <div
                        class="wrapper-content-section overflow-hidden position-relative transition-all duration-700">
                        <div class="content-section m-4">
                            <div class="mb-3 mcu-detail-item row">
                                <div class="col-12 content">
                                    <div class="content">{!! $data->summary !!}</div>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>

                <div id="action" class="section-action border-1 border-bottom p-5">
                    <div
                        class="wrapper-content-section overflow-hidden position-relative transition-all duration-700">
                        <div class="content-section m-4">
                            <div class="footer-action mb-2 align-center">
                                <div class="action-wrapper d-flex align-items-center justify-content-end gap-2">

                                    <a href="javascript:history.go(-1)"
                                        class="btn btn-outline-secondary">Kembali</a>

                                    @can('KPLH - Approval')
                                        @if (auth()->user()->areaManager)
                                            @if ($data->status == 'active')
                                                <a wire:click.prevent="approve"
                                                    class="btn btn-outline-default bg-green d-flex justify-content-center align-item-center text-white position-relative px-4">Approve</a>
                                            @endif
                                        @endif
                                    @endcan

                                </div>
                            </div>
                        </div>
                    </div>
                </div>

            </div>

            <div class="col-3">
                <div class="section-sidebar-nav position-sticky top-0 py-4">
                    <ul>
                        <li><a href="#" @click.prevent="document.getElementById('label').scrollIntoView()">LABEL INSPEKSI</a></li>
                        @if ($data->inspect_criteria == 'food-hygiene')
                            @foreach ($questions['food-hygiene'] as $question0)
                                <li>
                                    <a href="#" @click.prevent="document.getElementById('{{ $question0['category_name'] }}').scrollIntoView()">{{ $question0['category_order'] }}. {{ $question0['category_name'] }}</a>
                                </li>
                            @endforeach
                        @elseif ($data->inspect_criteria == 'workplace')
                            @foreach ($questions['workplace'] as $question0)
                                <li>
                                    <a href="#" @click.prevent="document.getElementById('{{ $question0['category_name'] }}').scrollIntoView()">{{ $question0['category_order'] }}. {{ $question0['category_name'] }}</a>
                                </li>
                            @endforeach
                        @elseif ($data->inspect_criteria == 'k3-apar')
                        @foreach ($questions['k3-apar'] as $question0)
                            <li>
                                <a href="#" @click.prevent="document.getElementById('{{ $question0['category_name'] }}').scrollIntoView()">{{ $question0['category_name'] }}</a>
                            </li>
                        @endforeach
                        @elseif ($data->inspect_criteria == 'k3-apab')
                        @foreach ($questions['k3-apab'] as $question0)
                            <li>
                                <a href="#" @click.prevent="document.getElementById('{{ $question0['category_name'] }}').scrollIntoView()">{{ $question0['category_name'] }}</a>
                            </li>
                        @endforeach
                        @elseif ($data->inspect_criteria == 'k3-hydrant')
                        @foreach ($questions['k3-hydrant'] as $question0)
                            <li>
                                <a href="#" @click.prevent="document.getElementById('{{ $question0['category_name'] }}').scrollIntoView()">{{ $question0['category_name'] }}</a>
                            </li>
                        @endforeach
                        @elseif ($data->inspect_criteria == 'k3-hose-rail')
                        @foreach ($questions['k3-hose-rail'] as $question0)
                            <li>
                                <a href="#" @click.prevent="document.getElementById('{{ $question0['category_name'] }}').scrollIntoView()">{{ $question0['category_name'] }}</a>
                            </li>
                        @endforeach
                        @elseif ($data->inspect_criteria == 'k3-eye-wash')
                        @foreach ($questions['k3-eye-wash'] as $question0)
                            <li>
                                <a href="#" @click.prevent="document.getElementById('{{ $question0['category_name'] }}').scrollIntoView()">{{ $question0['category_name'] }}</a>
                            </li>
                        @endforeach
                        @elseif ($data->inspect_criteria == 'area-maintank')
                        @foreach ($questions['area-maintank'] as $question0)
                            <li>
                                <a href="#" @click.prevent="document.getElementById('{{ $question0['category_name'] }}').scrollIntoView()">{{ $question0['category_order'] }}. {{ $question0['category_name'] }}</a>
                            </li>
                        @endforeach
                        @elseif ($data->inspect_criteria == 'area-jetty')
                        @foreach ($questions['area-jetty'] as $question0)
                            <li>
                                <a href="#" @click.prevent="document.getElementById('{{ $question0['category_name'] }}').scrollIntoView()">{{ $question0['category_order'] }}. {{ $question0['category_name'] }}</a>
                            </li>
                        @endforeach

                        @else

                        @endif

                    </ul>
                </div>
            </div>

        </div><!-- /.row -->
    </div><!-- /.container -->

</div>
