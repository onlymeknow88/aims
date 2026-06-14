<div class="inner-content">

    <div class="section-content">

        {{-- <div class="section-title py-3 px-2">
            <h4>Demo Sorting Tables</h4>
        </div><!-- /.section-title --> --}}

        <div class="table-demo position-relative">

            <div x-data="{ itemSelected: @entangle('itemSelected') }">

                <div class="toolbar-tables border-top border-bottom d-flex justify-content-between p-2 sticky-top">

                    <div class="toolbar-left d-flex align-items-center">

                        @if ($countSelected < 1)
                            <a data-toggle="modal" data-target="#modaladdCoeCategory" type="button"
                                class="button-toolbar d-flex gap-2 align-items-center py-2 px-3">
                                <span class="icon d-flex align-items-center"><img
                                        src="{{ asset('images/icons/add.png') }}" alt="image add"></span>
                                <span class="text-button">Add New</span>
                            </a>
                        @endif

                        @if ($countSelected > 0)
                            <a href="#" type="button"
                                class="button-toolbar d-flex gap-2 align-items-center py-2 px-3">
                                <span class="icon d-flex align-items-center"><img
                                        src="{{ asset('images/icons/export.png') }}" alt="image export"></span>
                                <span class="text-button">Export</span>
                            </a>

                            @if ($countSelected == 1)

                            <a href="#" wire:click="delete()" type="button"
                            class="button-toolbar d-flex gap-2 align-items-center py-2 px-3">
                            <span class="icon d-flex align-items-center"><img
                                    src="{{ asset('images/icons/delete.png') }}" alt="image delete"></span>
                            <span class="text-button">Delete</span>
                        </a>
                            @endif
                        @endif
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

                        <a href="#" type="button"
                            class="button-toolbar d-flex gap-2 align-items-center py-2 px-3">
                            <span class="icon d-flex align-items-center"><img
                                    src="{{ asset('images/icons/filter.png') }}" alt="image export"></span>
                        </a>

                        <a href="#" type="button"
                            class="button-toolbar d-flex gap-2 align-items-center py-2 px-3" wire:click="">
                            <span class="icon d-flex align-items-center"><img src="{{ asset('images/icons/info.png') }}"
                                    alt="image info"></span>
                        </a>

                        <a href="#" type="button"
                            class="button-toolbar d-flex gap-2 align-items-center py-2 px-3">
                            <span class="icon d-flex align-items-center"><img src="{{ asset('images/icons/menu.png') }}"
                                    alt="image menu"></span>
                        </a>

                    </div><!-- /.toolbar-right -->

                </div><!-- /.toolsbar-tables -->

                <div class="table-content table-responsive position-relative">

                    <div class="table-wrapper overflow-auto">

                        <table class="table">
                            <thead class="sticky-top">
                                <tr>
                                    <th class="sticky-top"></th>
                                    <th class="sticky-top">
                                        <div class="column-sort d-flex justify-content-between">
                                            <span>Nama Kategori</span>
                                            <span>
                                                <button class="btn border-0 p-0" type="button"
                                                    data-bs-toggle="dropdown" aria-expanded="false">
                                                    <img src="{{ asset('images/icons/sorting.png') }}" alt="sorting" />
                                                </button>
                                                <div class="dropdown-menu dropdown-menu-end">

                                                    <div class="dropdown-content p-3 d-flex gap-3 flex-column">

                                                        <a href="#"
                                                            class="sort sort-asc fw-normal d-block">Urutkan A-Z</a>
                                                        <a href="#"
                                                            class="sort sort-desc fw-normal d-block">Urutkan Z-A</a>
                                                        <div class="pilih-all d-flex gap-2">
                                                            <a href="#" class="fw-normal text-green">Pilih
                                                                Semua</a>
                                                            <a href="#" class="fw-normal text-green">Kosongkan</a>
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
                                                                    placeholder="Cari data document" aria-label="Name"
                                                                    aria-describedby="search-icon">
                                                            </div>
                                                        </div>
                                                        <div
                                                            class="sort-list d-flex gap-3 flex-column mh-200px overflow-auto">
                                                            <div class="form-check">
                                                                <input class="form-check-input rounded-circle"
                                                                    type="checkbox" value=""
                                                                    id="flexCheckDefault">
                                                                <label class="form-check-label fw-normal"
                                                                    for="flexCheckDefault">Name 1</label>
                                                            </div>
                                                            <div class="form-check">
                                                                <input class="form-check-input rounded-circle"
                                                                    type="checkbox" value=""
                                                                    id="flexCheckDefault">
                                                                <label class="form-check-label fw-normal"
                                                                    for="flexCheckDefault">Name 2</label>
                                                            </div>
                                                            <div class="form-check">
                                                                <input class="form-check-input rounded-circle"
                                                                    type="checkbox" value=""
                                                                    id="flexCheckDefault">
                                                                <label class="form-check-label fw-normal"
                                                                    for="flexCheckDefault">Name 3</label>
                                                            </div>
                                                            <div class="form-check">
                                                                <input class="form-check-input rounded-circle"
                                                                    type="checkbox" value=""
                                                                    id="flexCheckDefault">
                                                                <label class="form-check-label fw-normal"
                                                                    for="flexCheckDefault">Name 4</label>
                                                            </div>
                                                            <div class="form-check">
                                                                <input class="form-check-input rounded-circle"
                                                                    type="checkbox" value=""
                                                                    id="flexCheckDefault">
                                                                <label class="form-check-label fw-normal"
                                                                    for="flexCheckDefault">Name 5</label>
                                                            </div>
                                                            <div class="form-check">
                                                                <input class="form-check-input rounded-circle"
                                                                    type="checkbox" value=""
                                                                    id="flexCheckDefault">
                                                                <label class="form-check-label fw-normal"
                                                                    for="flexCheckDefault">Name 6</label>
                                                            </div>
                                                        </div>

                                                    </div>
                                                    <!--./dropdown-content-->

                                                </div><!-- /.dropdown-menu -->

                                            </span>
                                        </div><!-- /.column-sort -->
                                    </th>
                                    <th class="sticky-top">
                                        Tanggal Dibuat
                                    </th>
                                </tr>
                            </thead>
                            <tbody>

                                @foreach ($CalenderCategory as $itemIndex => $items)
                                    <tr wire:key="{{ $itemIndex }}"
                                        wire:click="onSelectedItem('{{ $items['id'] }}')">
                                        <td class="td-check">
                                            @if (in_array($items['id'], $itemSelected))
                                                <span class="icon-checked selected"></span>
                                            @else
                                                <span class="icon-checked"></span>
                                            @endif
                                        </td>
                                        <td class="title">{{ $items['name'] }}</td>
                                        <td>{{ \Carbon\Carbon::parse($items['created_at'])->format('d M Y') }}</td>

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


    <div class="modal fade" id="modaladdCoeCategory" tabindex="-1" role="dialog"
        aria-labelledby="modaladdCoeCategoryLabel" wire:ignore.self>
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modaladdCoeCategoryLabel">Add New CoE Category
                    </h5>
                    <button class="btn btn-danger" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form wire:submit.prevent="saveCoECategory">

                    <div class="modal-body">
                        <div class="mb-3 row form-group">
                            <div class="col-3">
                                <label for="category_name" class="col col-form-label">Category Name</label>
                            </div>
                            <div class="col-9">
                                <x-inputs.text wire:model="category_name" id="category_name" placeholder=""
                                    :error="'category_name'" />
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Save changes</button>
                    </div>
                </form>

            </div>
        </div>
    </div>


    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.1.3/dist/js/bootstrap.min.js"
        integrity="sha384-ChfqqxuZUCnJSK3+MXmPNIyE6ZbWh2IMqE241rYiqJxyMiZ6OW/JmZQ5stwEULTy" crossorigin="anonymous">
    </script>

</div>

