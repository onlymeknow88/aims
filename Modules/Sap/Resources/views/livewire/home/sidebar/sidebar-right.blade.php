<div id="rightsidebar" class="rightsidenav" wire:ignore.self>
    <div class="mb-3">
        @php
            $RequestYear = Request()->year;
            $tahun = $RequestYear ? $RequestYear : date('Y');
        @endphp

        <div class="content-sidebar sidebar-filter">

            <div class="p-2">
                <div class="text-secondary mb-3">Pilih Bulan</div>
                @if ($route_name == 'sap-home-index')
                    <select class="form-control form-control-sm" wire:model.lazy="input.month_start"
                        wire:change="SelectMonth">
                        @foreach ($months as $index => $list)
                            <option value="{{ $list['month_name'] }}"> {{ ucfirst($list['month_name']) }} </option>
                        @endforeach
                    </select>
                @else
                    <div>
                        <label class="form-check-label text-secondary">Dari </label>
                        <select class="form-control form-control-sm" wire:model.lazy="input.month_start"
                            wire:change="SelectMonths">
                            @foreach ($months as $index => $list)
                                <option value="{{ $list['month_name'] }}"> {{ ucfirst($list['month_name']) }} </option>
                            @endforeach
                        </select>
                    </div>
                    <div>
                        <label class="form-check-label text-secondary">Sampai </label>
                        <select class="form-control form-control-sm" wire:model.lazy="input.month_end"
                            wire:change="SelectMonths">
                            @foreach ($months as $index => $list)
                                <option value="{{ $list['month_name'] }}"> {{ ucfirst($list['month_name']) }} </option>
                            @endforeach
                        </select>
                    </div>
                @endif
                {{-- <div class="">
                    @foreach ($months as $index => $list)
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" name="month_name"
                                wire:change="SelectMonth('{{ $list['month_name'] }}')">
                            <label class="form-check-label text-secondary" for="flexRadioDefault1">
                                {{ ucfirst($list['month_name']) }}
                            </label>

                        </div>
                    @endforeach

                    <div class="p-3">
                        @if ($monthCount == 3)
                            <a href="#" class="text-primary text-center" wire:click="dataMonths('12')">Show
                                More</a>
                        @else
                            <a href="#" class="text-primary text-center" wire:click="dataMonths('3')">Show
                                Less</a>
                        @endif
                    </div>
                </div> --}}

                <div class="p-3">

                </div>
            </div>

            <div class="p-2">
                <div class="text-secondary mb-3">Pilih Tahun</div>
                <div class="">

                    @foreach ($years as $list)
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="year"
                                wire:change="SelectYear('{{ $list['year'] }}')"
                                @if ($list['year'] == $tahun) checked @endif>
                            <label class="form-check-label text-secondary" for="flexRadioDefault1">
                                {{ $list['year'] }}
                            </label>
                        </div>
                    @endforeach

                    <div class="p-3">
                        @if ($yearCount == 3)
                            <a href="#" class="text-primary text-center" wire:click="dataYears('100')">Show
                                More</a>
                        @else
                            <a href="#" class="text-primary text-center" wire:click="dataYears('3')">Show
                                Less</a>
                        @endif
                    </div>

                </div>
            </div>


            <div class="p-2">
                <div class="text-secondary mb-3">Pilih Department</div>
                <div class="">

                    @foreach ($departments as $list)
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" name="dept"
                                wire:change="SelectDept('{{ $list['code'] }}')"
                                @if ($list['checked'] == true) checked @endif>
                            <label class="form-check-label text-secondary" for="flexRadioDefault1">
                                {{ $list['code'] }}
                            </label>
                        </div>
                    @endforeach


                    <div class="p-3">
                        @if ($departmentCount <= 3)
                            <a href="#" class="text-primary text-center" wire:click="dataDepartment('100')">Show
                                More</a>
                        @else
                            <a href="#" class="text-primary text-center" wire:click="dataDepartment('3')">Show
                                Less</a>
                        @endif
                    </div>

                </div>
            </div>


            <div class="p-2">
                <div class="text-secondary mb-3">Pilih Grade</div>
                <div class="">

                    @foreach ($grades as $list)
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" name="grade"
                                wire:change="SelectGrade('{{ $list['grade_code'] }}')"
                                @if ($list['checked'] == true) checked @endif>
                            <label class="form-check-label text-secondary" for="flexRadioDefault1">
                                {{ $list['grade'] }}
                            </label>
                        </div>
                    @endforeach
                </div>
            </div>

        </div>
    </div>

    <div class="m-3">

        <button class="btn btn-sm btn-secondary" onclick="closeNav()">Close</button>
        <button class="btn btn-sm btn-success" wire:click="filter">Filter</button>

        @if ($route_name == 'sap-home-index')
        @else
        @endif
    </div>
</div>

<style>
    .rightsidenav {
        height: 100%;
        width: 0;
        position: fixed;
        z-index: 999;
        top: 0;
        right: 0;
        background-color: white;
        overflow-x: hidden;
        transition: 0.5s;
        padding: 90px 0px 0px 0px;

    }

    #dashboard-wrapper {
        transition: margin-right .5s;
        padding: 16px;
    }

    @media screen and (max-height: 450px) {
        .rightsidenav {
            padding-top: 15px;
        }
    }

    .content-sidebar>div>div>div>.text-secondary {
        font-size: 10pt !important
    }

    .content-sidebar.sidebar-filter {
        border-right-width: 0px;
    }

    .content-sidebar.sidebar-filter .text-secondary {
        color: rgba(50, 49, 48, 1) !important;
        font-weight: 500;
        font-size: 16px;
    }

    .content-sidebar.sidebar-filter .form-check .text-secondary {
        font-weight: 400;
        font-size: 16px;
    }
</style>


@push('scripts')
    <script>
        Livewire.on('filter', value => {
            //const url = new URL(location);
            //for (var index in value['filter']) {
            //    url.searchParams.set(index, value['filter'][index]);
            // }
            //history.pushState({}, "", url);
        })

        Livewire.on('submitFilter', value => {
            var query = value['query'];
            var baseUrl = window.location.origin;
            var partName = window.location.pathname;
            var newUrl = baseUrl + partName + "?" + query;
            window.location.replace(newUrl);
        })
    </script>
@endpush
