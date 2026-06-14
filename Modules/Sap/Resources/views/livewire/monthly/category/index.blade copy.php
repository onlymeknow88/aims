@section('title')
    Monthly {{ $year }}
@endsection

<div x-data="{ itemSelected: @entangle('itemSelected'), info: @entangle('info') }" wire:poll="getData">

    @if (session()->has('message'))
        <div class="alert alert-success">
            {{ session('message') }}
        </div>
    @endif

    @if ($errors->any())
        @foreach ($errors->all() as $error)
            <div class="alert alert-danger">
                {{ $error }}
            </div>
        @endforeach
    @endif
    {{ json_encode($filters) }}
    <button wire:click="getData"> getdata </button>
    <button wire:click="render"> refresh </button>
    <div class="toolbar-tables border-top border-bottom d-flex justify-content-between p-2 sticky-top">

        <div class="toolbar-left d-flex align-items-center">
            <a class="button-toolbar d-flex gap-2 align-items-center py-2 px-3"
                href="{{ route('sap-monthly-create', 'monthly') }}">
                <span class="icon d-flex align-items-center"><img src="{{ asset('images/icons/add.png') }}"
                        alt="image add"></span>
                <span class="text-button">Add User</span>
            </a>

            <a type="button" class="button-toolbar d-flex gap-2 align-items-center py-2 px-3"
                onclick="confirmDeleteEmployee()">
                <span class="icon d-flex align-items-center"><img src="{{ asset('images/icons/delete.png') }}"
                        alt="image delete"></span>
                <span class="text-button">Delete Employee</span>
            </a>
        </div><!-- /.toolbar-left -->

        <div class="toolbar-right d-flex align-items-center">
            <a href="#" class="btn btn-sm container-btn-spinner m-0 p-0" wire:click="download">
                <svg height="25px" width="25px" id="Layer_1" version="1.1" viewBox="0 0 30 30"
                    xml:space="preserve" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink">
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

        <div class="spinner-center spinner-border" role="status" wire:loading wire:target="UpdateMonth">
            <span class="visually-hidden">Loading...</span>
        </div>

        <div class="spinner-center spinner-border" role="status" wire:loading>
            <span class="visually-hidden">Loading...</span>
        </div>

        {{-- @foreach ($filter as $index => $list)
            {{ $index }} = {{ json_encode($list) }}
        @endforeach --}}

        <div class="table-responsive" style="height:500px">
            <table class="table table-document">
                <thead>
                    <tr>
                        <th></th>
                        <th>No</th>
                        <th>JDE</th>
                        <th>Nama Karyawan</th>
                        <th>Posisi</th>
                        <th>Dept</th>
                        <th>Grade</th>
                        @foreach ($months as $month)
                            <th>{{ ucfirst($month['month_name']) }}</th>
                        @endforeach
                        <th>Action</th>
                    </tr>
                </thead>

                <tbody>
                    @foreach ($data as $i => $list)
                        {{-- KATEGORI --}}
                        <tr>
                            <th></th>
                            <th colspan="6">{{ $list['name'] }}</th>
                            @foreach ($months as $month)
                                <th></th>
                            @endforeach
                            <th>
                                @php
                                    $employeList = isset($list['employee_list']) ? $list['employee_list'] : [];
                                    $employeCount = count($list['employee_list']);
                                @endphp
                                @if ($employeCount == 0)
                                @endif
                            </th>
                        </tr>

                        <tr>
                            <td></td>
                            <td colspan="6"></td>
                            @foreach ($months as $month)
                                <td></td>
                            @endforeach
                            <td></td>
                        </tr>

                        {{-- EMPLOYEE LIST BY CATEGORY --}}
                        @foreach ($list['employee_list'] as $index => $row)
                            <tr wire:key="{{ $index }}"
                                wire:click="SelectRowEmployee('{{ $row['id_employee'] }}')">
                                <td>
                                    @if (in_array($row['id_employee'], $itemSelectedEmployee))
                                        <span class="icon-checked selected"></span>
                                    @else
                                        <span class="icon-checked"></span>
                                    @endif
                                </td>
                                <td>{{ ++$index }}</td>
                                <td>{{ $row['id_number'] }}</td>
                                <td>{{ $row['name'] }}</td>
                                <td>{{ $row['position'] }}</td>
                                <td>{{ $list['code'] }}</td>
                                <td>{{ isset($row['grade']) ? $row['grade'] : null }}</td>
                                @foreach ($months as $month)
                                    <td>
                                        <input type="text" class="form-control form-control-sm input-month"
                                            value="{{ $row[$month['month_name']] }}"
                                            wire:change="UpdateMonth('{{ $row['id_employee'] }}','{{ $month['month_name'] }}', $event.target.value)">
                                    </td>
                                @endforeach
                                <td>
                                    {{-- <a href="#" wire:click="edit('{{ json_encode($row) }}')"> aaaaaa</a> --}}

                                    @if ($row['id_employee'])
                                        <span>
                                            <a
                                                href="{{ route('sap-monthly-update', [$list['id'], $row['id_employee']]) }}">
                                                <i class="fas fa-pencil-alt fa-1x"></i>
                                            </a>
                                        </span>
                                    @endif
                                </td>
                            </tr>
                        @endforeach
                    @endforeach
                </tbody>
            </table>

        </div><!-- /.table-wrapper -->

    </div><!-- /.table-content-->

    {{-- @livewire('sap::setup.create') --}}

    {{-- include popup --}}
    @include('sap::livewire.monthly.category.modalEmployeeCategory', [
        'data' => $dataCategory,
        'id' => 'ModalEmployeeCategory',
    ])

    {{-- include popup --}}
    @include('sap::livewire.monthly.category.modalEmployeeCreate', [
        'input' => $edit_input,
        'id' => 'ModalEmployeeCreate',
    ])

    @push('scripts')
        <script>
            /**set monthly  */
            function confirmDeleteDepartement(id) {
                Swal.fire({
                    title: 'Are you sure?',
                    text: "You won't be able to revert this!",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Yes, delete it!'
                }).then((result) => {
                    if (result.isConfirmed) {
                        return @this.call('confirmDeleteDepartement', id)

                    }
                })
            };


            function confirmDeleteEmployee() {
                Swal.fire({
                    title: 'Are you sure?',
                    text: "You won't be able to revert this!",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Yes, delete it!'
                }).then((result) => {
                    if (result.isConfirmed) {
                        return @this.call('confirmDeleteEmployee')
                    }
                })
            };

            async function edit($data) {
                await @this.call('edit', $data)
            }
        </script>
    @endpush

</div>


@push('styles')
    <style>
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
