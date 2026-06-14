<div class="p-3" style="z-index:999">
    <div class="content-sidebar sidebar-filter">
        <div class="p-2">
            <div class="text-secondary mb-3">Pilih Bulan</div>
            <div class="">
                @foreach ($months as $list)
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" name="month_name"
                            wire:click="SelectMonth('{{ $list['month'] }}')"
                            @if ($list['checked'] == true) checked @endif>
                        <label class="form-check-label text-secondary" for="flexRadioDefault1">
                            {{ ucfirst($list['month_name']) }}
                        </label>
                    </div>
                @endforeach

                <div class="p-3">
                    @if ($monthCount == 3)
                        <a href="#" class="text-primary text-center" wire:click="dataMonths('12')">Show More</a>
                    @else
                        <a href="#" class="text-primary text-center" wire:click="dataMonths('3')">Show Less</a>
                    @endif
                </div>

            </div>
        </div>

        <div class="p-2">
            <div class="text-secondary mb-3">Pilih Tahun</div>
            <div class="">

                @foreach ($years as $list)
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" name="year"
                            wire:click="SelectYear('{{ $list['year'] }}')"
                            @if ($list['checked'] == true) checked @endif>
                        <label class="form-check-label text-secondary" for="flexRadioDefault1">
                            {{ $list['year'] }}
                        </label>
                    </div>
                    {{-- <button class="btn btn-sm text-secondary {{ $list['checked'] == true ? 'btn-primary' : 'btn-light' }}"
                    wire:click="SelectYear({{ $list['year'] }})"> {{ $list['year'] }} </button> --}}
                @endforeach

                <div class="p-3">
                    @if ($yearCount == 3)
                        <a href="#" class="text-primary text-center" wire:click="dataYears('100')">Show More</a>
                    @else
                        <a href="#" class="text-primary text-center" wire:click="dataYears('3')">Show Less</a>
                    @endif
                </div>

            </div>
        </div>

        <div class="p-2">
            <div class="text-secondary mb-3">Pilih Perusahaan</div>
            <div class="">

                @foreach ($companies as $list)
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" name="company"
                            wire:click="SelectCompany('{{ $list['id'] }}')"
                            @if ($list['checked'] == true) checked @endif>
                        <label class="form-check-label text-secondary" for="flexRadioDefault1">
                            {{ $list['company_name'] }}
                        </label>
                    </div>
                    {{-- <button class="btn btn-sm text-secondary {{ $list['checked'] == true ? 'btn-primary' : 'btn-light' }}"
                    wire:click="SelectCompany('{{ $list['id'] }}')"> {{ $list['company_name'] }}</button> --}}
                @endforeach

                <div class="p-3">
                    @if ($companyCount == 3)
                        <a href="#" class="text-primary text-center" wire:click="dataCompanies('10000')">Show
                            More</a>
                    @else
                        <a href="#" class="text-primary text-center" wire:click="dataCompanies('3')">Show Less</a>
                    @endif
                </div>
            </div>
        </div>

        <div class="p-2">
            <button type="submit" class="btn btn-sm btn-success" wire:click="FilterAction()">Filter</Button>
        </div>


        <style>
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

    </div>

</div>
