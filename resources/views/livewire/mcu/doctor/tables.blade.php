<div class="inner-content">
    <div class="alert @if (!empty(session('alert'))) alert-{{ session('alert') }} @else d-none @endif">
        @if (!empty(session('msg')))
            {{ session('msg') }}
        @endif
    </div>
    <div class="mt-0" x-data="{ itemSelected: @entangle('itemSelected'), info: @entangle('info') }">
        <div class="toolbar-tables border-top border-bottom d-flex justify-content-between p-2">
            <div class="toolbar-left d-flex align-items-center">
            </div><!-- /.toolbar-left -->
            <div class="toolbar-right d-flex align-items-center">
                <div class="keep-open btn-group" title="Columns">
                    <a href="#" type="button" class="button-toolbar d-flex gap-2 align-items-center py-2 px-3"
                        data-bs-toggle="dropdown">
                        <span class="icon d-flex align-items-center"><img src="{{ asset('images/icons/sort.png') }}"
                                alt="image add"></span>
                    </a>
                    <div class="dropdown-menu dropdown-menu-right" style="">
                        @foreach ($columns as $column)
                            <label class="dropdown-item dropdown-item-marker"><input type="checkbox"
                                    wire:model="selectedColumns" value="{{ $column }}"checked="checked">
                                <span>{{ $column }}</span></label>
                        @endforeach
                    </div>
                </div>

                <a href="#" type="button" class="button-toolbar d-flex gap-2 align-items-center py-2 px-3"
                    data-bs-toggle="modal" data-bs-target="#sortModal_table"><span
                        class="icon d-flex align-items-center">
                        <img src="{{ asset('images/icons/filter.png') }}"alt="image export"></span>
                </a>

                <a href="#" type="button" class="button-toolbar d-flex gap-2 align-items-center py-2 px-3"
                    wire:click="activedInfo()">
                    <span class="icon d-flex align-items-center"><img src="{{ asset('images/icons/info.png') }}"
                            alt="image info"></span>
                </a>

                <a href="#" type="button" class="button-toolbar d-flex gap-2 align-items-center py-2 px-3">
                    <span class="icon d-flex align-items-center"><img src="{{ asset('images/icons/menu.png') }}"
                            alt="image menu"></span>
                </a>
                <div class="float-right search btn-group">
                    <input class="form-control search-input" type="search" placeholder="Search" autocomplete="off"
                        wire:model="searchTerm">
                </div>
            </div><!-- /.toolbar-right -->
        </div><!-- /.toolsbar-tables -->

        <div class="table-content table-responsive position-relative overflow-auto d-flex">

            <table class="table">
                <thead>
                    <tr>
                        @foreach ($columns as $column)
                            @if ($this->showColumn('{{ $column }}'))
                                <td>{{ $column }}</td>
                            @endif
                        @endforeach

                        @if (in_array('Date', $selectedColumns))
                            <th>Date</th>
                        @endif
                        @if (in_array('Name', $selectedColumns))
                            <th>Name</th>
                        @endif
                        @if (in_array('Tanggal Lahir', $selectedColumns))
                            <th>Tanggal Lahir</th>
                        @endif
                        @if (in_array('Company', $selectedColumns))
                            <th>Company</th>
                        @endif
                        @if (in_array('Department', $selectedColumns))
                            <th>Department</th>
                        @endif
                        @if (in_array('Status Review', $selectedColumns))
                            <th>Status Review</th>
                        @endif
                        @if (in_array('Status', $selectedColumns))
                            <th>Status MCU</th>
                        @endif
                        @if (in_array('Aksi', $selectedColumns))
                            <th>
                                <center>Aksi</center>
                            </th>
                        @endif
                    </tr>
                </thead>
                <tbody>
                    @foreach ($dataTables as $itemIndex => $items)
                        <tr wire:key="{{ $itemIndex }}">

                            @if (in_array('Date', $selectedColumns))
                                <td>
                                    <a
                                        href="{{ route('mcu::doctor-detail', $items['id']) }}">{{ $items['mcu_date'] }}</a>
                                </td>
                            @endif
                            @if (in_array('Name', $selectedColumns))
                                <td><a href="{{ route('mcu::doctor-detail', $items['id']) }}"><span><img
                                                src="{{ asset('images/icons/user.png') }}" alt=""></span>
                                        {{ $items['employee']['name'] }}</a></td>
                            @endif
                            @if (in_array('Tanggal Lahir', $selectedColumns))
                                <td>{{ \Carbon\Carbon::parse($items['employee']['date_of_birth'])->format('d M Y') }}
                                </td>
                            @endif
                            @if (in_array('Company', $selectedColumns))
                                <td>{{ $items['employee']['company'] }}</td>
                            @endif
                            @if (in_array('Department', $selectedColumns))
                                <td>{{ $items['employee']['department'] }}</td>
                            @endif
                            @if (in_array('Status Review', $selectedColumns))
                                <td>{{ $items['amc_matrix_compliance'] }}</td>
                            @endif
                            @if (in_array('Status', $selectedColumns))
                                <td>
                                    <span
                                        style="color:@if ($items['doctor_status_review'] == 'Fit') green
                            @elseif ($items['doctor_status_review'] == 'Fit With Recomendation') blue
                            @elseif ($items['doctor_status_review'] == 'Curently Unfit') orange
                            @elseif ($items['doctor_status_review'] == 'Unfit') red
                            @else grey @endif;">
                                        @if (empty($items['doctor_status_review']))
                                            {{ 'In Review' }}
                                        @else
                                            {{ $items['doctor_status_review'] }}
                                        @endif
                                    </span>
                                </td>
                            @endif
                            @if (in_array('Aksi', $selectedColumns))
                                <td>
                                    <center>
                                        <a href="{{ route('mcu::doctor-detail', $items['id']) }}" target="_blank"
                                                class="btn btn-sm btn-primary">Detail</a>
                                        {{-- @if ($items['doctor_status_review'] == 'Fit')

                                        @elseif ($items['doctor_status_review'] == 'Fit With Recomendation')

                                        @elseif ($items['doctor_status_review'] == 'Curently Unfit')

                                        @elseif ($items['doctor_status_review'] == 'Unfit')

                                        @else

                                        @endif --}}
                                    </center>
                                </td>
                            @endif
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div><!-- /.table-content-->

        <div class="text-xs-center">
            <div class="section-footer d-flex justify-content-between sticky-bottom bg-white align-items-center h-60px">
                <div class="update-on opacity-80">{{ $latestUpdate }}</div>
                {{ $dataTables->links('components.paginate.paginate') }}
            </div><!-- /.section-footer -->
        </div>
    </div>
</div>
