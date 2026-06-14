@section('title')
    Personal Data
    @if ($Id)
        Update
    @else
        Create
    @endif
@endsection


<div class="inner-content">

    <div class="header-add-maker h-60px border d-flex gap-2 align-items-center justify-content-between px-3">
        <div class="left-header">
            <a href="{{ route('sap-monthly-category-index') }}" class="d-flex align-items-center gap-3 ">
                <span><i class="fa-solid fa-arrow-left"></i></span>
                <span>Personal Data
                </span>
            </a>
        </div><!-- /.left-header -->
        <div class="right-header">
            <div class="text-white">
                {{-- Last update Sep 24, 2022 . 15.00 pm --}}
            </div>
        </div><!-- /.right-header -->

    </div>

    <div class="addnew-maker-content container py-5 px-3">

        <div class="row justify-content-center">

            <div class="col-8">
                {{-- Validate --}}
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


                <form action="#" class="form-horizontal" wire:submit.prevent="store">

                    <div class="mb-3 form-group row ">
                        <label for="inputEmail3" class="col-sm-4 col-form-label">Nomor Karyawan</label>
                        <div class="col-sm-8">
                            <input type="text" wire:model.lazy="input.id_number" class="form-control" placeholder=""
                                disabled />
                            @error('input.id_number')
                                <small class="error text-danger">{{ $message }}</small>
                            @enderror
                        </div>
                    </div>

                    <div class="mb-3 form-group row ">
                        <label for="inputEmail3" class="col-sm-4 col-form-label">Name</label>
                        <div class="col-sm-8">
                            <div class="input-dropdown">
                                <input type="text" id="inputDropdown" wire:model.lazy="input.name"
                                    onclick="getUser()" class="form-control" placeholder="" readonly>
                                <div id="dropdown-body" class="input-dropdown-content container-spinner"
                                    wire:ignore.self>

                                    <div class="spinner-center spinner-border" role="status" wire:loading
                                        wire:target="Users">
                                        <span class="visually-hidden">Loading...</span>
                                    </div>

                                    <input type="text" placeholder="Search.." id="input-text-dropdown"
                                        wire:model="search" wire:keydown="Users()">

                                    <table class="table-user">
                                        @foreach ($users as $list)
                                            <tr wire:click="selectUser('{{ $list['name'] }}','{{ $list['id_number'] }}')"
                                                onclick="selectUser()">
                                                <td> {{ $list['name'] }}</td>
                                                <td> {{ $list['id_number'] }}</td>
                                            </tr>
                                        @endforeach
                                    </table>

                                </div>
                            </div>

                            @error('input.name')
                                <small class="error text-danger">{{ $message }}</small>
                            @enderror
                        </div>
                    </div>


                    <div class="mb-3 form-group row ">
                        <label for="inputEmail3" class="col-sm-4 col-form-label">Position</label>
                        <div class="col-sm-8">
                            <input type="text" wire:model.lazy="input.position" class="form-control"
                                placeholder="" />
                            @error('input.position')
                                <small class="error text-danger">{{ $message }}</small>
                            @enderror
                        </div>
                    </div>



                    <div class="mb-3 form-group row ">
                        <label for="inputEmail3" class="col-sm-4 col-form-label">Dept.</label>
                        <div class="col-sm-8">
                            <input type="text" wire:model.lazy="input.code" class="form-control" placeholder=""
                                disabled />
                            @error('input.department')
                                <small class="error text-danger">{{ $message }}</small>
                            @enderror
                        </div>
                    </div>


                    <div class="mb-3 form-group row ">
                        <label for="inputEmail3" class="col-sm-4 col-form-label">Company</label>
                        <div class="col-sm-8">
                            <input type="text" wire:model.lazy="input.company_name" class="form-control"
                                placeholder="" disabled />
                            @error('input.company_name')
                                <small class="error text-danger">{{ $message }}</small>
                            @enderror
                        </div>
                    </div>


                    @php
                        $grade = [['grade' => 'Dept Head', 'grade_code' => 'pjo'], ['grade' => 'Foreman, Spv, S/H', 'grade_code' => 'pja'], ['grade' => 'Karyawan', 'grade_code' => 'maker']];
                    @endphp
                    <div class="mb-3 form-group row ">
                        <label for="inputEmail3" class="col-sm-4 col-form-label">Grade</label>
                        <div class="col-sm-8">
                            <select wire:model.lazy="input.grade" class="form-control" placeholder=""
                                onchange="selectGrade(event)">
                                <option value="" class="text-secondary">--Select--</option>
                                @foreach ($grade as $list)
                                    <option value="{{ $list['grade'] }}" data-code="{{ $list['grade_code'] }}">
                                        {{ $list['grade'] }}
                                    </option>
                                @endforeach
                            </select>

                            @error('input.grade')
                                <small class="error text-danger">{{ $message }}</small>
                            @enderror
                        </div>
                    </div>

                    <input type="hidden" wire:model.lazy="input.grade_code" class="form-control" placeholder="" />

                    <div wire:loading wire:target="store,edit,selectUser" class="spinner" style="z-index:999">
                        <div class="spinner-border" style="width: 3rem; height: 3rem;" role="status">
                            <span class="visually-hidden">Loading...</span>
                        </div>
                    </div>

                    <div class="footer-action mb-2">
                        <div class="action-wrapper d-flex align-items-center justify-content-end gap-2">
                            <a href="{{ route('sap-monthly-category-index') }}"
                                class="btn btn-outline-secondary">Cancel</a>
                            <button type="submit" class="btn btn-success" wire:target="input.file"
                                wire:loading.attr="disabled">
                                @if ($Id)
                                    Update
                                @else
                                    Create
                                @endif
                            </button>
                        </div>
                    </div>

                </form>

            </div>

        </div>

    </div>
    <!---/.addnew-maker-content -->
</div>


@push('styles')
    <style>
        .spinner {
            z-index: 1100;
            position: absolute;
            top: 35%;
            right: 50%;
        }
    </style>
@endpush

<style>
    .table-user {}

    .dropbtn {
        background-color: #04AA6D;
        color: white;
        padding: 16px;
        font-size: 16px;
        border: none;
        cursor: pointer;
    }

    .dropbtn:hover,
    .dropbtn:focus {
        background-color: #3e8e41;
    }

    /**input dropdown*/
    #input-text-dropdown {
        box-sizing: border-box;
        background-image: url('searchicon.png');
        background-position: 14px 12px;
        background-repeat: no-repeat;
        font-size: 16px;
        padding: 14px 20px 12px 45px;
        border: none;
        border-bottom: 1px solid #ddd;
        width: 100%;
    }

    #input-text-dropdown:focus {
        outline: 3px solid #ddd;
    }

    .input-dropdown {
        position: relative;
        display: inline-block;
        width: 100%;
    }

    .input-dropdown-content {
        display: none;
        position: absolute;
        background-color: #f6f6f6;
        width: 100%;
        overflow: auto;
        border: 1px solid #ddd;
        z-index: 1;
        height: 250px;
    }

    .show {
        display: block;
    }
</style>


@push('scripts')
    <script>
        Livewire.on('clearEmailInput', () => {
            $('input#invited_people').val('').focus()
        })

        function selectGrade(event) {
            var x = event.target;
            if (x) {
                var value = x.value;
                var grade_code = x.options[x.selectedIndex].dataset.code;
                console.log(value);
                console.log(grade_code);
                @this.set('input.grade_code', grade_code);
            }
        }


        //dropdown
        function selectUser() {
            document.getElementById("inputDropdown").click();
        }

        function getUser() {
            document.getElementById("dropdown-body").classList.toggle("show");
            document.getElementById("input-text-dropdown").focus();

        }

        function filterUser() {
            var input, filter, ul, li, a, i;
            input = document.getElementById("myInput");
            filter = input.value.toUpperCase();
            div = document.getElementById("myDropdown");
            a = div.getElementsByTagName("td");
            for (i = 0; i < a.length; i++) {
                txtValue = a[i].textContent || a[i].innerText;
                if (txtValue.toUpperCase().indexOf(filter) > -1) {
                    a[i].style.display = "";
                } else {
                    a[i].style.display = "none";
                }
            }
        }
    </script>
@endpush
