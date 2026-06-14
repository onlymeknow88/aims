<div class="inner-content">

    <div class="section-content">

        <div class="section-title py-3 px-2">
            <h4>Unit Demob Request - Coordinator</h4>
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
                            <a href="#" type="button" class="button-toolbar d-flex gap-2 align-items-center py-2 px-3" data-bs-toggle="modal" data-bs-target="#revoke">
                                <span class="icon d-flex align-items-center"><img src="{{ asset('images/icons/export.png') }}"
                                        alt="image export"></span>
                                <span class="text-button">Approve</span>
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
                                <tr @if ($selectAll) class="selected" @else class="tr" @endif>
                                    <th class="sticky-top" wire:click="toggleSelectAll">
                                        <span class="icon-checked"></span>
                                    </th>
                                    <th>
                                        <div class="column-sort d-flex justify-content-between">
                                            <span>
                                                Call Sign
                                            </span>
                                            <span>
                                                <button class="btn border-0 p-0" type="button"
                                                    data-bs-toggle="dropdown" aria-expanded="false">
                                                    <img src="{{ !empty($this->searchCallSign) ? asset('images/icons/filter-solid.png') : asset('images/icons/filter-default.svg') }}"
                                                        alt="sorting" />
                                                </button>
                                                <div class="dropdown-menu dropdown-menu-end">

                                                    <div class="dropdown-content p-3 d-flex gap-3 flex-column">
                                                        <div class="sort-search">
                                                            <div class="input-group">
                                                                <span class="input-group-text border-end-0"
                                                                    id="search-icon">
                                                                    <img src="{{ asset('images/icons/search.png') }}"
                                                                        alt="Search"
                                                                        srcset="{{ asset('images/icons/search.png') }}">
                                                                </span>
                                                                <input type="text" class="form-control"
                                                                    wire:model.1500ms="searchCallSign"
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

                                    @if (in_array('Description Unit', $selectedColumns))
                                        <th>
                                            <div class="column-sort d-flex justify-content-between">
                                                <span>
                                                    Description Unit
                                                </span>
                                                <span>
                                                    <button class="btn border-0 p-0" type="button"
                                                        data-bs-toggle="dropdown" aria-expanded="false">
                                                        <img src="{{ $this->sortFieldSelected == 'ko_spip_unit_id' ? asset('images/icons/filter-solid.png') : asset('images/icons/filter-default.svg') }}"
                                                            alt="sorting" />
                                                    </button>
                                                    <div class="dropdown-menu dropdown-menu-end">

                                                        <div class="dropdown-content p-3 d-flex gap-3 flex-column">
                                                            <div
                                                                class="sort-list d-flex gap-3 flex-column mh-200px overflow-auto">
                                                                @foreach ($fieldSpipUnit as $index => $item)
                                                                    <div class="form-check">
                                                                        <input class="form-check-input rounded-circle"
                                                                            type="checkbox" value=""
                                                                            id="flexCheckDefault"
                                                                            wire:click="sortCheck('ko_spip_unit_id', '{{ $item->id }}')">
                                                                        <label class="form-check-label fw-normal"
                                                                            for="flexCheckDefault">{{ $item->name }}</label>
                                                                    </div>
                                                                @endforeach
                                                            </div>
                                                        </div>
                                                    </div>
                                                </span>
                                            </div>
                                        </th>
                                    @endif

                                    @if (in_array('Identity Number', $selectedColumns))
                                        <th>
                                            <div class="column-sort d-flex justify-content-between">
                                                <span>
                                                    Identity Number
                                                </span>
                                                <span>
                                                    <button class="btn border-0 p-0" type="button"
                                                        data-bs-toggle="dropdown" aria-expanded="false">
                                                        <img src="{{ !empty($this->searchIdentityNumber) ? asset('images/icons/filter-solid.png') : asset('images/icons/filter-default.svg') }}"
                                                            alt="sorting" />
                                                    </button>
                                                    <div class="dropdown-menu dropdown-menu-end">

                                                        <div class="dropdown-content p-3 d-flex gap-3 flex-column">
                                                            <div class="sort-search">
                                                                <div class="input-group">
                                                                    <span class="input-group-text border-end-0"
                                                                        id="search-icon">
                                                                        <img src="{{ asset('images/icons/search.png') }}"
                                                                            alt="Search"
                                                                            srcset="{{ asset('images/icons/search.png') }}">
                                                                    </span>
                                                                    <input type="text" class="form-control"
                                                                        wire:model.1500ms="searchIdentityNumber"
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

                                    @if (in_array('Brand', $selectedColumns))
                                        <th>
                                            Brand
                                        </th>
                                    @endif

                                    @if (in_array('Serial Number', $selectedColumns))
                                        <th>
                                            <div class="column-sort d-flex justify-content-between">
                                                <span>
                                                    Serial Number
                                                </span>
                                                <span>
                                                    <button class="btn border-0 p-0" type="button"
                                                        data-bs-toggle="dropdown" aria-expanded="false">
                                                        <img src="{{ !empty($this->searchSerialNumber) ? asset('images/icons/filter-solid.png') : asset('images/icons/filter-default.svg') }}"
                                                            alt="sorting" />
                                                    </button>
                                                    <div class="dropdown-menu dropdown-menu-end">

                                                        <div class="dropdown-content p-3 d-flex gap-3 flex-column">
                                                            <div class="sort-search">
                                                                <div class="input-group">
                                                                    <span class="input-group-text border-end-0"
                                                                        id="search-icon">
                                                                        <img src="{{ asset('images/icons/search.png') }}"
                                                                            alt="Search"
                                                                            srcset="{{ asset('images/icons/search.png') }}">
                                                                    </span>
                                                                    <input type="text" class="form-control"
                                                                        wire:model.1500ms="searchSerialNumber"
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

                                    @if (in_array('Model Unit', $selectedColumns))
                                        <th>Model Unit</th>
                                    @endif

                                    @if (in_array('Production Year', $selectedColumns))
                                        <th>Production Year</th>
                                    @endif

                                    @if (in_array('Total Komisioning', $selectedColumns))
                                        <th>Total Komisioning</th>
                                    @endif

                                    <th>Demob Note</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($this->units as $itemIndex => $item)
                                    <tr wire:key="{{ $itemIndex }}" wire:click="onSelectedItem('{{ $item->id }}')" 
                                        @if(in_array($item->id, $itemSelected))
                                            class="selected"
                                        @else
                                            class="tr"                                   
                                        @endif"
                                    >
                                        <td class="td-check">
                                            <span class="icon-checked"></span>
                                        </td>

                                        <td scope="row">
                                            <a style="color: green; font-weight: bold" href="#">
                                                {{ $item->call_sign }}
                                            </a>
                                        </td>

                                        @if (in_array('Description Unit', $selectedColumns))
                                            <td>{{ $item->koSpipUnit->name }}</td>
                                        @endif

                                        @if (in_array('Identity Number', $selectedColumns))
                                            <td>{{ $item->identity_number }}</td>
                                        @endif

                                        @if (in_array('Brand', $selectedColumns))
                                            <td>{{ $item->koBrand->name ?? '-' }}</td>
                                        @endif

                                        @if (in_array('Serial Number', $selectedColumns))
                                            <td>{{ $item->serial_number }}</td>
                                        @endif

                                        @if (in_array('Production Year', $selectedColumns))
                                            <td>{{ $item->production_year }}</td>
                                        @endif

                                        @if (in_array('Total Komisioning', $selectedColumns))
                                            <td>{{ $item->commissioning_count }}</td>
                                        @endif

                                        <td>{{ $item->revoke_request_note }}</td>
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

    <div class="modal fade" id="revoke" data-bs-backdrop="static" data-bs-keyboard="false"
         tabindex="-1"
         aria-labelledby="ContractorModallLabel" aria-hidden="true" wire:ignore.self>
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="ContractorModallLabel">Approve Revoke</h5>
                    <button type="button" class="btn-close" wire:click="closeModal()"
                            data-bs-dismiss="modal"
                            aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-sm-12">
                            {{--<x-inputs.textarea wire:model="revoke_request_note" class="form-control" id="revoke_request_note"
                                               placeholder="Note"
                                               :error="'comment'"></x-inputs.textarea>
                            @error('comment')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                            @enderror--}}
                            Are you sure?
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal"
                            wire:click="closeModal()">Close
                    </button>
                    <button type="button" wire:click="revoke()"
                            class="btn btn-outline-success bg-green text-white bg-hover-light-success">
                        Approve
                    </button>
                </div>
            </div>
        </div>
    </div>

</div>

<script>
    window.addEventListener('closeModal', event => {
        $('#revoke').modal('hide');
        @this.set('revoke_request_note', null);
    });
</script>
