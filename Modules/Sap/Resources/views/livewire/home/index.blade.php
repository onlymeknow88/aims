<div x-data="{ itemSelected: @entangle('itemSelected'), info: @entangle('info') }">
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

    @foreach ($data_all as $data)
        <div style="margin-bottom:50px; margin-top:10px">
            <h6 class="text-center text-dark"> {{ strtoupper($data['data']['name']) }}</h6>

            <div style="margin-bottom:100px">
                @include('sap::livewire.home.widgets.yearly-table', [
                    'data' => $data,
                ])
                <div wire:ignore>
                    @include('sap::livewire.home.widgets.yearly-chart', [
                        'data' => $data,
                    ])
                </div>
            </div>

            <div>
                @include('sap::livewire.home.widgets.monthly-table', [
                    'data' => $data,
                ])
                <div wire:ignore>
                    @include('sap::livewire.home.widgets.monthly-chart', [
                        'data' => $data,
                    ])
                </div>

            </div>
        </div>
    @endforeach

</div>

@push('scripts')
    <script>
        // var query = null;
        // // Livewire.on('filter', value => {
        // //     query = value['query'];
        // //     SapChart();
        // //     // console.log(query);
        // // })

        // // window.addEventListener("load", (event) => {
        // //     SapChart();
        // // });

        // async function SapChart() {
        //     const url = window.location.origin + '/api/sap/chart/category-all?' + query;
        //     const response = await fetch(url);
        //     var data = await response.json();

        //     for (var index in data) {
        //         var getData = data[index]['data'];
        //         var yearly = getData['yearly'];
        //         var slug = getData['slug'];
        //         slug = slug.replace("-", "");
        //         console.log(slug);

        //         var label = [];
        //         var target = [];
        //         var actual = [];
        //         for (var index in yearly) {
        //             label.push(capitalizeFirstLetter(index));
        //             target.push(yearly[index].target_dept);
        //             actual.push(yearly[index].actual_dept);
        //         }
        //         var dataChart = [{
        //                 label: 'Target',
        //                 backgroundColor: '#FFC0CB',
        //                 data: target
        //             },
        //             {
        //                 label: 'Actual',
        //                 backgroundColor: '#FF00FF',
        //                 data: actual
        //             }
        //         ];
        //         await chart("sapYearlyChart" + slug + "Main", label, dataChart);

        //         var monthly = getData['monthly'];
        //         for (var index in monthly) {
        //             var month = monthly[index]['data'];
        //             for (var index in month) {
        //                 var label = [];
        //                 var target = [];
        //                 var actual = [];

        //                 label.push(capitalizeFirstLetter(index));
        //                 target.push(yearly[index].target_dept);
        //                 actual.push(yearly[index].actual_dept);
        //                 var dataChart = [{
        //                         label: 'Target',
        //                         backgroundColor: '#FFC0CB',
        //                         data: target
        //                     },
        //                     {
        //                         label: 'Actual',
        //                         backgroundColor: '#FF00FF',
        //                         data: actual
        //                     }
        //                 ];
        //                 await chart("sapMonthlyChart" + slug + "Main", label, dataChart);
        //             }
        //         }
        //     }
        // }

        // function chart(id, label, data) {
        //     if (window[id]) {
        //         window[id].data.labels = label;
        //         window[id].data.datasets = data;
        //         window[id].update();
        //     }
        // }
    </script>
@endpush

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

        .input-standar {
            border: 1px solid transparent;
            background: transparent;
            border-radius: 5px;
            font-weight: bold;
        }

        .table-grafik {
            width: 100%;
        }

        .table-grafik thead tr th {
            background: rgb(242, 242, 242) !important;
            border-bottom: 1px solid #ddd;
        }

        .table-grafik tbody tr th,
        .tbody-th {
            background: rgb(228, 228, 228);
            border-bottom: 1px solid #ddd;
            text-align: center;
        }


        .table-grafik thead tr th:nth-child(4) {
            white-space: nowrap;
            overflow-y: hidden;
        }

        .table-grafik tbody tr td {
            border-bottom: 1px solid #ddd;
            color: gray;
            text-align: center;

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
