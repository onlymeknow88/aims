<div class="inner-content">

    <div class="section-content">

        <div class="section-title py-3 px-2">
            <h4>In Review PJA/PJO Extraction</h4>
        </div><!-- /.section-title -->

        <div class="table-maker">

            <div x-data="{ itemSelected: @entangle('itemSelected'), info: @entangle('info') }">

                <div class="toolbar-tables border-top border-bottom d-flex justify-content-between p-2">


                    <div class="toolbar-left d-flex align-items-center">
                        @if ($countSelected > 0)
                            <!-- <a href="#" type="button" class="button-toolbar d-flex gap-2 align-items-center py-2 px-3">
                                <span class="icon d-flex align-items-center"><img src="{{ asset('images/icons/export.png') }}"
                                        alt="image export"></span>
                                <span class="text-button">Export</span>
                            </a> -->
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
                        <table class="table" style="height: fit-content" x-data="unCheck">
                            <thead>
                                <tr>
                                    @if (in_array('ID Ekstraksi', $selectedColumns))
                                        <th>ID Ekstraksi</th>
                                    @endif
                                    @if (in_array('Company', $selectedColumns))
                                        <th>
                                            <div class="column-sort d-flex justify-content-between">
                                                <span>
                                                    Company
                                                </span>
                                                <span>
                                                    <button class="btn border-0 p-0" type="button"
                                                        data-bs-toggle="dropdown" aria-expanded="false">
                                                        <img src="{{ !empty($this->sortSelected) && isset($this->sortSelected['company_id']) ? asset('images/icons/filter-solid.png') : asset('images/icons/filter-default.svg') }}"
                                                            alt="sorting" />
                                                    </button>
                                                    <div class="dropdown-menu dropdown-menu-end" wire:ignore.self>

                                                        <div class="dropdown-content p-3 d-flex gap-3 flex-column">

                                                            <div class="pilih-all d-flex gap-2">
                                                                <a href="#" class="fw-normal text-green"
                                                                    x-on:click="selectAllCheckboxes('company_id')"
                                                                    wire:click="removeItemFilter('company_id')">
                                                                    Hapus Filter
                                                                </a>
                                                            </div>

                                                            <div
                                                                class="sort-list d-flex gap-3 flex-column mh-200px overflow-auto">
                                                                @foreach ($fieldCompany as $index => $item)
                                                                    <div class="form-check">
                                                                        <input class="form-check-input rounded-circle"
                                                                            type="checkbox" value=""
                                                                            id="company_id"
                                                                            wire:click="sortCheck('company_id', '{{ $item->id }}')">
                                                                        <label class="form-check-label fw-normal"
                                                                            for="flexCheckDefault">{{ $item->company_name }}</label>
                                                                    </div>
                                                                @endforeach
                                                            </div>
                                                        </div>
                                                    </div>
                                                </span>
                                            </div>
                                        </th>
                                    @endif
                                    @if (in_array('Nomor Peraturan', $selectedColumns))
                                        <th>
                                            <div class="column-sort d-flex justify-content-between">
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
                                                                    <input type="text" class="form-control"
                                                                        wire:model.1500ms="searchNumber"
                                                                        placeholder="Cari data" aria-label="Name"
                                                                        aria-describedby="search-icon">
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <!--./dropdown-content-->

                                                    </div><!-- /.dropdown-menu -->
                                                </span>
                                            </div>
                                        </th>
                                    @endif
                                    @if (in_array('Judul Peraturan', $selectedColumns))
                                        <th>
                                            <div class="column-sort d-flex justify-content-between">
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
                                                                    <input type="text" class="form-control"
                                                                        wire:model.1500ms="searchTitle"
                                                                        placeholder="Cari data" aria-label="Name"
                                                                        aria-describedby="search-icon">
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <!--./dropdown-content-->

                                                    </div><!-- /.dropdown-menu -->
                                                </span>
                                            </div>
                                        </th>
                                    @endif

                                    @if (in_array('Pasal', $selectedColumns))
                                        <th>
                                            Pasal
                                        </th>
                                    @endif

                                    @if (in_array('Ayat', $selectedColumns))
                                        <th>Ayat</th>
                                    @endif

                                    @if (in_array('Penanggung Jawab', $selectedColumns))
                                        <th>Penanggung Jawab</th>
                                    @endif

                                    @if (in_array('Status', $selectedColumns))
                                        <th>Status Ekstraksi</th>
                                    @endif

                                    @if (in_array('Date Created', $selectedColumns))
                                        <th>Date Created</th>
                                    @endif
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($this->extractions as $itemIndex => $item)
                                    <tr>
                                        @if (in_array('ID Ekstraksi', $selectedColumns))
                                            <td scope="row">
                                                <a style="color: green; font-weight: bold" href="{{route('kpp::extractions.checking.detail', ['id' => $item->id])}}">
                                                    {{ $item->id }}
                                                </a>
                                            </td>
                                        @endif

                                        @if (in_array('Company', $selectedColumns))
                                            <td>{{ $item->obedience->company->company_name ?? '-' }}</td>
                                        @endif

                                        @if (in_array('Nomor Peraturan', $selectedColumns))
                                            <td>{{ $item->obedience->rule->number }}</td>
                                        @endif

                                        @if (in_array('Judul Peraturan', $selectedColumns))
                                            <td style="min-width: 500px; white-space: normal">{{ $item->obedience->rule->title }}</td>
                                        @endif

                                        @if (in_array('Pasal', $selectedColumns))
                                            <td>{{ $item->article->name }}</td>
                                        @endif

                                        @if (in_array('Ayat', $selectedColumns))
                                            <td>{{ $item->sub_section }}</td>
                                        @endif

                                        @if (in_array('Penanggung Jawab', $selectedColumns))
                                            <th>{{ $item->responsibleUser->name }}</th>
                                        @endif

                                        @if (in_array('Status', $selectedColumns))
                                            <td>
                                                @if($item->status == 'Draft')
                                                    <span class="pending">{{ $item->status }}</span>
                                                @elseif($item->status == 'Checking')
                                                    <span class="pending">{{ $item->status }}</span>
                                                @elseif($item->status == 'In Review')
                                                    <span class="pending">{{ $item->status }}</span>
                                                @elseif($item->status == 'Patuh')
                                                    <span class="default">{{ $item->status }}</span>
                                                @elseif($item->status == 'Tidak Patuh')
                                                    <span class="cancel">{{ $item->status }}</span>
                                                @elseif($item->status == 'Tidak Berlaku')
                                                    <span class="cancel">{{ $item->status }}</span>
                                                @endif
                                            </td>
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

</div>

@push('scripts')

<script type="text/javascript">

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
