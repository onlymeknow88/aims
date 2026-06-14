<div class="inner-content">

    <div class="section-content">

        <div class="section-title py-3 px-2">
            <h4>Kepatuhan SubContractor</h4>
        </div><!-- /.section-title -->

        <div class="table-maker">

            <div x-data="{ itemSelected: @entangle('itemSelected'), info: @entangle('info') }">

                <div class="toolbar-tables border-top border-bottom d-flex justify-content-between p-2">

                    <div class="toolbar-left d-flex align-items-center">
                        @if ($countSelected > 0)
                            <a href="#" type="button" class="button-toolbar d-flex gap-2 align-items-center py-2 px-3">
                                <span class="icon d-flex align-items-center"><img src="{{ asset('images/icons/export.png') }}"
                                        alt="image export"></span>
                                <span class="text-button">Export</span>
                            </a>

                            <a href="#" type="button" class="button-toolbar d-flex gap-2 align-items-center py-2 px-3"
                                wire:click="$emit('remove-item')">
                                <span class="icon d-flex align-items-center"><img src="{{ asset('images/icons/delete.png') }}"
                                        alt="image delete"></span>
                                <span class="text-button">Delete</span>
                            </a>
                        @endif
                    </div><!-- /.toolbar-left -->

                    <div class="toolbar-right d-flex align-items-center">

                        @if ($countSelected > 0)
                            <a href="#" type="button" class="button-toolbar d-flex gap-2 align-items-center py-2 px-3"
                                wire:click="removeSeleced()">
                                <span class="icon d-flex align-items-center"><img src="{{ asset('images/icons/delete.png') }}"
                                        alt="image delete"></span>
                                <span class="text-button">{{ $countSelected }} Row Selected</span>
                            </a>
                        @endif

                    </div><!-- /.toolbar-right -->

                </div><!-- /.toolsbar-tables -->

                <div class="">

                    <table class="table">
                        <thead>
                            <tr>
                                <th>Nomor Peraturan</th>
                                <th>Judul Peraturan</th>
                                <th>Subcontractor</th>
                                <th>Status Peraturan</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($this->rules as $itemIndex => $item)
                                <tr>
                                    <td scope="row">
                                        <a href="#">
                                            {{ $item->number }}
                                        </a>
                                    </td>
                                    <td style="min-width: 500px; white-space: normal">{{ $item->title }}</td>
                                    <td>
                                        @if(Auth::user()->department->company->type == 'CONTRACTOR')
                                            @foreach($item->childSubcontractorObediences() as $key => $obedience)
                                                <a style="color: green; font-weight: bold" href="{{ route('kpp::obedience-monitoring.detail', ['id' => $obedience->id]) }}">
                                                    - {{$obedience->company->company_name}}
                                                </a><br>
                                            @endforeach
                                        @else
                                            @foreach($item->subcontractorObediences() as $key => $obedience)
                                                <a style="color: green; font-weight: bold" href="{{ route('kpp::obedience-monitoring.detail', ['id' => $obedience->id]) }}">
                                                    - {{$obedience->company->company_name}}
                                                </a><br>
                                            @endforeach
                                        @endif
                                    </td>
                                    {{--<!-- <td>{{ $item->company->company_name ?? '-'}}</td> -->
                                    <!-- <td>{{ $item->company->type ?? '-'}}</td> -->
                                    <!-- <td>
                                        @if($item->company->type == 'INTERNAL')
                                            {{ $item->company->company_name ?? '-'}}
                                        @elseif($item->company->type == 'CONTRACTOR')
                                            {{ $item->company->parent->company_name ?? '-'}}
                                        @elseif($item->company->type == 'SUBCONTRACTOR')
                                            {{ $item->company->parent->parent->company_name ?? '-'}}
                                        @endif
                                    </td>
                                    <td>
                                        @if($item->company->type == 'INTERNAL')
                                            -
                                        @elseif($item->company->type == 'CONTRACTOR')
                                            {{ $item->company->company_name ?? '-'}}
                                        @elseif($item->company->type == 'SUBCONTRACTOR')
                                            {{ $item->company->parent->company_name ?? '-'}}
                                        @endif
                                    </td>
                                    <td>
                                        @if($item->company->type == 'INTERNAL')
                                            -
                                        @elseif($item->company->type == 'CONTRACTOR')
                                            -
                                        @elseif($item->company->type == 'SUBCONTRACTOR')
                                            {{ $item->company->company_name ?? '-'}}
                                        @endif
                                    </td> -->--}}
                                    <td>{{ $item->status ?? '-'}}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>

                    <!-- <div class="info" x-show="info">test</div> -->

                </div><!-- /.table-content-->

            </div>

        </div><!-- /.table-maker -->

    </div><!-- /.section-content -->

    <div class="section-footer d-flex justify-content-between">
        {{-- <div class="update-on opacity-80">Update on Sep 24, 2022 . 15.00 pm</div>
        <div class="row-data opacity-80">1,000 Document Active</div> --}}
    </div><!-- /.section-footer -->
</div>

<script>

</script>
