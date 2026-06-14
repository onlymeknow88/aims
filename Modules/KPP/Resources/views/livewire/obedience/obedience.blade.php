<div class="inner-content">

    <div class="section-content">

        <div class="section-title py-3 px-2">
            <h4>Kepatuhan</h4>
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

                        <div class="column-sort d-flex justify-content-between">
                            <a class="button-toolbar d-flex gap-2 align-items-center py-2 px-3" type="button"
                                data-bs-toggle="dropdown" aria-expanded="false">
                                <img src="{{ asset('images/icons/filter-top.svg') }}" alt="sorting" />
                                <span>Filter</span>
                            </a>
                            <div class="dropdown-menu dropdown-menu-end shadow-lg">
                                <div class="dropdown-content p-3 d-flex gap-2 flex-column">

                                    <div class="sort-list d-flex gap-1 flex-column mh-200px overflow-auto">
                                        @foreach ($columns as $column)
                                            <div class="form-check">
                                                <input class="form-check-input rounded-circle" type="checkbox"
                                                    id="flexCheckDefault" wire:model="selectedColumns"
                                                    value="{{ $column }}">
                                                <label class="form-check-label fw-normal" for="flexCheckDefault">
                                                    {{ $column }}
                                                </label>
                                            </div>
                                        @endforeach
                                    </div>
                                </div><!--./dropdown-content-->

                            </div><!-- /.dropdown-menu -->

                        </div><!-- /.column-sort -->

                    </div><!-- /.toolbar-right -->

                </div><!-- /.toolsbar-tables -->

                <div class="table-content table-responsive position-relative">
                    <div class="table-wrapper overflow-auto">

                        <table class="table" style="height: fit-content">
                        <thead>
                            <tr>
                                @if (in_array('Nomor Peraturan', $selectedColumns))
                                    <th style="vertical-align: middle;">
                                        <div class="column-sort d-flex justify-content-between">
                                            <div class="column-sort d-flex justify-content-between gap-5">
                                                <span>
                                                    Nomor Peraturan
                                                </span>
                                                <span>
                                                    <button class="btn border-0 p-0" type="button"
                                                        data-bs-toggle="dropdown" aria-expanded="false">
                                                        <img src="{{ !empty($this->searchNumber) ? asset('images/icons/filter-solid.png') : asset('images/icons/filter-default.svg') }}"
                                                            alt="sorting" />
                                                    </button>
                                                    <div class="dropdown-menu dropdown-menu-end" wire:ignore.self>

                                                        <div class="dropdown-content p-3 d-flex gap-3 flex-column">

                                                            <div class="pilih-all d-flex gap-2">
                                                                <a href="#" class="fw-normal text-green"
                                                                    wire:click="removeItemFilter('searchNumber')">
                                                                    Hapus Filter
                                                                </a>
                                                            </div>

                                                            <div class="sort-search">
                                                                <div class="input-group">
                                                                    <span class="input-group-text border-end-0"
                                                                        id="search-icon">
                                                                        <img src="{{ asset('images/icons/search.png') }}"
                                                                            alt="Search"
                                                                            srcset="{{ asset('images/icons/search.png') }}">
                                                                    </span>
                                                                    <input type="text" class="form-control" wire:model.1500ms="searchNumber" placeholder="Cari data" aria-label="Name" aria-describedby="search-icon">
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </span>
                                            </div>
                                        </div>
                                    </th>
                                @endif
                                
                                @if (in_array('Judul Peraturan', $selectedColumns))
                                    <th style="vertical-align: middle; text-align: center">
                                        <div class="column-sort d-flex justify-content-between">
                                            <div class="column-sort d-flex justify-content-between gap-5">
                                                <span>
                                                    Judul Peraturan
                                                </span>
                                                <span>
                                                    <button class="btn border-0 p-0" type="button"
                                                        data-bs-toggle="dropdown" aria-expanded="false">
                                                        <img src="{{ !empty($this->searchTitle) ? asset('images/icons/filter-solid.png') : asset('images/icons/filter-default.svg') }}"
                                                            alt="sorting" />
                                                    </button>
                                                    <div class="dropdown-menu dropdown-menu-end" wire:ignore.self>

                                                        <div class="dropdown-content p-3 d-flex gap-3 flex-column">
                                                            
                                                            <div class="pilih-all d-flex gap-2">
                                                                <a href="#" class="fw-normal text-green"
                                                                    wire:click="removeItemFilter('searchTitle')">
                                                                    Hapus Filter
                                                                </a>
                                                            </div>

                                                            <div class="sort-search">
                                                                <div class="input-group">
                                                                    <span class="input-group-text border-end-0"
                                                                        id="search-icon">
                                                                        <img src="{{ asset('images/icons/search.png') }}"
                                                                            alt="Search"
                                                                            srcset="{{ asset('images/icons/search.png') }}">
                                                                    </span>
                                                                    <input type="text" class="form-control" wire:model.1500ms="searchTitle" placeholder="Cari data" aria-label="Name" aria-describedby="search-icon">
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </span>
                                            </div>
                                        </div>
                                    </th>
                                @endif

                                @if(Auth::user()->department->company->type == 'INTERNAL')
                                    <th>CCOW</th>
                                    <th>Contractor</th>
                                    <th>Subcontractor</th>
                                @endif
                                @if(Auth::user()->department->company->type == 'CONTRACTOR')
                                    <th>Contractor</th>
                                    <th>Subcontractor</th>
                                @endif
                                @if(Auth::user()->department->company->type == 'SUBCONTRACTOR')
                                    <th>Subcontractor</th>
                                @endif

                                @if (in_array('Status Peraturan', $selectedColumns))
                                    <th>Status Peraturan</th>
                                @endif
                                @if (in_array('Draft Ekstraksi', $selectedColumns))
                                    <th>Draft Ekstraksi</th>
                                @endif
                                @if (in_array('Submitted Ekstraksi', $selectedColumns))
                                    <th>Submitted Ekstraksi</th>
                                @endif
                                @if (in_array('Date Created', $selectedColumns))
                                    <th>Date Created</th>
                                @endif
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($this->obediences as $itemIndex => $item)
                                <tr>
                                    @if (in_array('Nomor Peraturan', $selectedColumns))
                                        <td scope="row">
                                            <a style="color: green; font-weight: bold" href="{{ route('kpp::obediences.detail', ['id' => $item->id]) }}">
                                                {{ $item->rule->number }}
                                            </a>
                                        </td>
                                    @endif

                                    @if (in_array('Judul Peraturan', $selectedColumns))
                                        <td style="min-width: 500px; white-space: normal">{{ $item->rule->title }}</td>
                                    @endif

                                    @if(Auth::user()->department->company->type == 'INTERNAL')
                                        <td><b>{{ $item->company->company_name ?? '-'}}</b></td>
                                        <td>
                                            @foreach($item->contractorObediences() as $key => $obedience)
                                                - {{$obedience->company->company_name}}<br>
                                            @endforeach
                                        </td>
                                        <td>
                                            @foreach($item->subcontractorObediences() as $key => $obedience)
                                                - {{$obedience->company->company_name}}<br>
                                            @endforeach
                                        </td>
                                    @endif
                                    @if(Auth::user()->department->company->type == 'CONTRACTOR')
                                        <td><b>{{ $item->company->company_name ?? '-'}}</b></td>
                                        <td>
                                            @foreach($item->contractorObediences() as $key => $obedience)
                                                - {{$obedience->company->company_name}}<br>
                                            @endforeach
                                        </td>
                                    @endif
                                    @if(Auth::user()->department->company->type == 'SUBCONTRACTOR')
                                        <td><b>{{ $item->company->company_name ?? '-'}}</b></td>
                                    @endif

                                    <!-- @if (in_array('CCOW', $selectedColumns))
                                        <td>
                                            @if($item->company->type == 'INTERNAL')
                                                {{ $item->company->company_name ?? '-'}}
                                            @elseif($item->company->type == 'CONTRACTOR')
                                                {{ $item->company->parent->company_name ?? '-'}}
                                            @elseif($item->company->type == 'SUBCONTRACTOR')
                                                {{ $item->company->parent->parent->company_name ?? '-'}}
                                            @endif
                                        </td>
                                    @endif

                                    @if (in_array('Contractor', $selectedColumns))
                                        <td>
                                            @if($item->company->type == 'INTERNAL')
                                                -
                                            @elseif($item->company->type == 'CONTRACTOR')
                                                {{ $item->company->company_name ?? '-'}}
                                            @elseif($item->company->type == 'SUBCONTRACTOR')
                                                {{ $item->company->parent->company_name ?? '-'}}
                                            @endif
                                        </td>
                                    @endif

                                    @if (in_array('Subcontractor', $selectedColumns))
                                        <td>
                                            @if($item->company->type == 'INTERNAL')
                                                -
                                            @elseif($item->company->type == 'CONTRACTOR')
                                                -
                                            @elseif($item->company->type == 'SUBCONTRACTOR')
                                                {{ $item->company->company_name ?? '-'}}
                                            @endif
                                        </td>
                                    @endif -->

                                    @if (in_array('Status Peraturan', $selectedColumns))
                                        <td>{{ $item->rule->status ?? '-'}}</td>
                                    @endif

                                    @if (in_array('Draft Ekstraksi', $selectedColumns))
                                        <td>{{ $item->extractions->where('status', 'Draft')->count() ?? '-'}}</td>
                                    @endif

                                    @if (in_array('Submitted Ekstraksi', $selectedColumns))
                                        <td>{{ $item->extractions->where('status', '!=', 'Draft')->count() ?? '-'}}</td>
                                    @endif

                                    @if (in_array('Date Created', $selectedColumns))
                                        <td>{{ Carbon\Carbon::parse($item->created_at)->format('F d, Y') }}</td>
                                    @endif
                                </tr>
                            @endforeach
                        </tbody>
                    </table>

                    <!-- <div class="info" x-show="info">test</div> -->

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
            <span>{!! __('Row Data') !!}</span>
        </div>

    </div><!-- /.section-footer -->

    <div class="section-footer d-flex justify-content-between">
        {{-- <div class="update-on opacity-80">Update on Sep 24, 2022 . 15.00 pm</div>
        <div class="row-data opacity-80">1,000 Document Active</div> --}}
    </div><!-- /.section-footer -->
</div>

@push('scripts')

<script type="text/javascript">
    document.addEventListener('DOMContentLoaded', function() {

        @this.on('remove-item', () => {
            Swal.fire({
                title: 'Are You Sure?',
                text: 'Yakin akan menghapus data ini?',
                icon: "warning",
                showCancelButton: true,
                confirmButtonText: 'Hapus'
            }).then((result) => {

                if (result.value) {

                    @this.call('removeItem')

                }

            });
        });
    });

    function unCheck() {
        return {
            selectAllCheckboxes(id) {
                checkboxes = document.querySelectorAll('[id^=' + id + ']');
                [...checkboxes].map((el) => {
                    el.checked = false;
                })
            }
        }
    };
</script>

@endpush
