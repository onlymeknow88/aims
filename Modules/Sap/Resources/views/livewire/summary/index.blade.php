@section('title')
    {{ $title }}
@endsection

<div x-data="{ itemSelected: @entangle('itemSelected'), info: @entangle('info') }">

    @section('page_title')
        {{ isset($data['safety_accountability_progam']) ? $data['safety_accountability_progam'] : null }}
    @endsection


    @if (session()->has('message'))
        <div class="alert alert-success">
            {{ session('message') }}
        </div>
    @endif

    <div class="toolbar-tables border-top border-bottom d-flex justify-content-between p-2 sticky-top">

        <div class="toolbar-left d-flex align-items-center">

        </div><!-- /.toolbar-left -->

        <div class="toolbar-right d-flex align-items-center">
            <a href="#" class="btn btn-sm container-btn-spinner m-0 p-0" wire:click="download">
                <svg height="25px" width="25px" id="Layer_1" version="1.1" viewBox="0 0 30 30" xml:space="preserve"
                    xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink">
                    <g>
                        <path clip-rule="evenodd"
                            d="M28.705,7.506l-5.461-6.333l-1.08-1.254H9.262   c-1.732,0-3.133,1.403-3.133,3.136V7.04h1.942L8.07,3.818c0.002-0.975,0.786-1.764,1.758-1.764l11.034-0.01v5.228   c0.002,1.947,1.575,3.523,3.524,3.523h3.819l-0.188,15.081c-0.003,0.97-0.79,1.753-1.759,1.761l-16.57-0.008   c-0.887,0-1.601-0.87-1.605-1.942v-1.277H6.138v1.904c0,1.912,1.282,3.468,2.856,3.468l17.831-0.004   c1.732,0,3.137-1.41,3.137-3.139V8.966L28.705,7.506"
                            fill="#434440" fill-rule="evenodd" />
                        <path d="M20.223,25.382H0V6.068h20.223V25.382 M1.943,23.438h16.333V8.012H1.943"
                            fill="#08743B" />
                        <polyline fill="#08743B"
                            points="15.73,20.822 12.325,20.822 10.001,17.538 7.561,20.822 4.14,20.822 8.384,15.486 4.957,10.817    8.412,10.817 10.016,13.355 11.726,10.817 15.242,10.817 11.649,15.486 15.73,20.822  " />
                    </g>
                </svg>
                <span class="btn-spinner" style="z-index:999" wire:loading wire:target="download">
                    <i class="fa-solid fa-spinner fa-spin"></i>
                </span>
            </a>

            <a href="#" type="button" class="button-toolbar d-flex gap-2 align-items-center py-2 px-3"
                onclick="openNav()"><span class="icon d-flex align-items-center">
                    <img src="{{ asset('images/icons/filter.png') }}"alt="image export"></span>
            </a>
        </div><!-- /.toolbar-right -->

    </div><!-- /.toolsbar-tables -->


    <div class="container-spinner ">
        <div class="spinner-center spinner-border" role="status" wire:loading wire:target="search">
            <span class="visually-hidden">Loading...</span>
        </div>

        <div class="table-responsive">
            <table class=" table  table-document">
                <thead>
                    <tr>
                        <th colspan="7" class="text-center"></th>
                        @foreach ($months as $list)
                            <th colspan="3" class="text-center" style="border-left:1px solid #ddd">
                                {{ strtoupper($list['month_name']) }}</th>
                        @endforeach
                    </tr>
                    <tr>
                        <th>No</th>
                        <th>ID</th>
                        <th>Nama Karyawan</th>
                        <th>Posisi Target SAP</th>
                        <th>Dept</th>
                        <th>Company</th>
                        <th>Grade</th>
                        @foreach ($months as $list)
                            <th style="border-left:1px solid #ddd">TARGET</th>
                            <th>ACTUAL</th>
                            <th>ACH</th>
                        @endforeach
                    </tr>
                </thead>

                <tbody>
                    @foreach ($employee['data'] as $index => $list)
                        <tr>
                            <td>{{ ++$index }}</td>
                            <td>{{ $list['jde'] }}</td>
                            <td>{{ $list['name'] }}</td>
                            <td>{{ $list['position'] }}</td>
                            <td>{{ $list['dept'] }}</td>
                            <td>{{ $list['company_name'] }}</td>
                            <td>{{ $list['grade'] }}</td>
                            @foreach ($list['months'] as $row)
                                <td style="border-left:1px solid #ddd">{{ $row['target'] }}</td>
                                <td>{{ $row['actual'] == 0.0 ? null : $row['actual'] }}</td>
                                <td>{{ $row['ach'] }}</td>
                            @endforeach
                        </tr>
                    @endforeach
                </tbody>
            </table>

        </div><!-- /.table-wrapper -->
    </div>
</div><!-- /.table-content-->

{{-- @livewire('sap::setup.create') --}}

</div>


@push('styles')
    <style>
        /* width */
        ::-webkit-scrollbar {
            width: 10px !important;
            height: 10px !important
        }

        /* Track */
        ::-webkit-scrollbar-track {
            box-shadow: inset 0 0 5px grey;
            border-radius: 10px;
        }

        /* Handle */
        ::-webkit-scrollbar-thumb {
            background: rgb(193, 192, 192);
            border-radius: 10px;
        }

        /* Handle on hover */
        ::-webkit-scrollbar-thumb:hover {
            background: #a3a2a2;
        }

        .table-document {
            width: 100%;
        }

        .table-document thead tr th {
            background: rgb(242, 242, 242) !important;
            border-bottom: 1px solid #ddd;
            text-align:center;
        }

        .table-document tbody tr th,
        .tbody-th {
            background: rgb(228, 228, 228);
            border-bottom: 1px solid #ddd;
        }


        .table-document thead tr th:nth-child(4) {
            white-space: nowrap;
            overflow-y: hidden;
        }

        .table-document tbody tr td {
            border-bottom: 1px solid #ddd;
            color: gray;
        }

        .input-month {
            width: 50px !important;
        }

        .container-btn-spinner {
            position: relative;
        }

        .btn-spinner {
            z-index: 1100;
            position: absolute;
            bottom: 0;
            left: 0;
            top: 0;
            right: 0;
            width: 20px;
            height: 20px;
            margin: auto;
            text-align: center;
        }
    </style>
@endpush
