<div class="inner-content">

    <div class="section-content">

        {{-- <div class="section-title py-3 px-2">
            <h4>Demo Sorting Tables</h4>
        </div><!-- /.section-title --> --}}

        <div class="table-demo position-relative">

            <div x-data="{ itemSelected: @entangle('itemSelected') }">

                {{-- <div class="toolbar-tables border-top border-bottom d-flex justify-content-between p-2 sticky-top">

                    <div class="toolbar-left d-flex align-items-center">

                            @can('COE - Create COE')
                                <a href="{{ route('coe::add-event') }}" type="button"
                                    class="button-toolbar d-flex gap-2 align-items-center py-2 px-3">
                                    <span class="icon d-flex align-items-center"><img
                                            src="{{ asset('images/icons/add.png') }}" alt="image add"></span>
                                    <span class="text-button">Add New</span>
                                </a>
                            @endcan
                    </div><!-- /.toolbar-left -->

                    <div class="toolbar-right d-flex align-items-center">

                        @if ($countSelected > 0)
                            <a href="#" type="button"
                                class="button-toolbar d-flex gap-2 align-items-center py-2 px-3"
                                wire:click="removeSeleced()">
                                <span class="icon d-flex align-items-center"><img
                                        src="{{ asset('images/icons/delete.png') }}" alt="image delete"></span>
                                <span class="text-button">{{ $countSelected }} Row Selected</span>
                            </a>
                        @endif

                        <a href="#" type="button"
                            class="button-toolbar d-flex gap-2 align-items-center py-2 px-3">
                            <span class="icon d-flex align-items-center"><img src="{{ asset('images/icons/sort.png') }}"
                                    alt="image add"></span>
                        </a>

                    </div><!-- /.toolbar-right -->

                </div><!-- /.toolsbar-tables --> --}}

                <div class="table-content table-responsive position-relative">

                    <div class="table-wrapper overflow-auto">

                        <table class="table">
                            <thead class="sticky-top">
                                <tr>
                                    {{-- <th class="sticky-top"></th> --}}
                                    <th class="sticky-top">
                                        Nama
                                    </th>
                                    <th class="sticky-top">
                                        Penyelenggara Event
                                    </th>
                                    <th class="sticky-top">
                                        Tanggal Mulai
                                    </th>
                                    <th class="sticky-top">
                                        Tanggal Akhir
                                    </th>
                                    <th class="sticky-top">
                                        Status
                                    </th>
                                    <th class="sticky-top">
                                        Deskripsi
                                    </th>
                                </tr>
                            </thead>
                            <tbody>

                                @foreach ($CalendarOfEvent as $itemIndex => $items)
                                    <tr
                                    {{-- wire:key="'{{ $items['id'] }}'"
                                        wire:click="onSelectedItem('{{ $items['id'] }}')" --}}
                                        >
                                        {{-- <td class="td-check">
                                            @if (in_array($items['id'], $itemSelected))
                                                <span class="icon-checked selected"></span>
                                            @else
                                                <span class="icon-checked"></span>
                                            @endif
                                        </td> --}}
                                        <td class="title">{{ $items['title'] }}</td>
                                        <td>
                                            {{ $items->user ? $items->user->email : '-' }}
                                            {{-- <small>
                                                @if ($items['invited_emails'])
                                                    @foreach ($items['invited_emails'] as $emails)
                                                        @if ($loop->iteration < 3)
                                                            @if ($loop->iteration % 2 == 0)
                                                                {{ $emails }}<br>
                                                            @else
                                                                {{ $emails }}<br>
                                                            @endif
                                                        @else
                                                            {{ $emails }}<br>
                                                        @endif
                                                    @endforeach
                                                @endif
                                            </small> --}}
                                        </td>
                                        <td>{{ \Carbon\Carbon::parse($items['start_date'])->format('d M Y') }}</td>
                                        <td>{{ \Carbon\Carbon::parse($items['end_date'])->format('d M Y') }}</td>
                                        <td>{!! $items['status'] !!}</td>
                                        <td>{!! $items['description'] !!}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>

                    </div><!-- /.table-wrapper -->

                </div><!-- /.table-content-->

            </div>

        </div><!-- /.table-maker -->

    </div><!-- /.section-content -->

    <div class="section-footer d-flex justify-content-between sticky-bottom bg-white align-items-center h-60px">
        <div class="update-on opacity-80">{{ $latestUpdate }}</div>

        <div class="row-data opacity-80 d-flex gap-2 align-items-center">
            <span class="input-limit w-100px">
                <x-inputs.text wire:model="limit" id="limit" placeholder="0" value="{{ $limit }}"
                    :error="'limit'" />
            </span>
            <span>{!! __('of') !!}</span>
            <span class="font-medium">{{ $countData }}</span>
            <span>{!! __('Document Active') !!}</span>
        </div>

    </div><!-- /.section-footer -->

</div>
