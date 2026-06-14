<div class="inner-content">
    <div class="container mt-4">
        <div class="row">

            <div class="alert @if (!empty(session('alert'))) alert-{{ session('alert') }} @else d-none @endif">
                @if (!empty(session('msg')))
                    {{ session('msg') }}
                @endif
            </div>

            <div class="col">
                <div class="card border-dark mb-3">
                    <div class="card-header">
                        <h5 class="card-title">Blood Pressure</h5>
                    </div>
                    <div class="card-body text-dark">

                        <div class="toolbar-tables border-top border-bottom d-flex justify-content-between p-2">
                            <div class="toolbar-left d-flex align-items-center">
                                <a type="button" data-toggle="modal" data-target="#modaladdformulabloodpressure"
                                    class="button-toolbar d-flex gap-2 align-items-center py-2 px-3">
                                    <span class="icon d-flex align-items-center"><img
                                            src="{{ asset('images/icons/add.png') }}" alt="image add"></span>
                                    <span class="text-button">Add New</span>
                                </a>
                            </div><!-- /.toolbar-left -->
                        </div><!-- /.toolsbar-tables -->

                        <div class="modal fade" id="modaladdformulabloodpressure" tabindex="-1" role="dialog"
                            aria-labelledby="modaladdformulabloodpressureLabel"
                            aria-hidden="{{ $modalAddFormulaBloodPressure }}" wire:ignore.self>
                            <div class="modal-dialog modal-lg" role="document">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="modaladdformulabloodpressureLabel">Tambah Formula
                                            Blood Pressure
                                        </h5>
                                        <button class="btn btn-danger" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
                                    <form wire:submit.prevent="saveFormulaBloodPressure">

                                        <div class="modal-body">
                                            <div class="mb-3 row form-group">
                                                <div class="col">
                                                    <label for="normal_a" class="col col-form-label">Normal A</label>
                                                    <x-inputs.number wire:model="normal_a" id="normal_a"
                                                        placeholder="0" :error="'normal_a'" />
                                                </div>
                                                <div class="col">
                                                    <label for="normal_b" class="col col-form-label">Normal B</label>
                                                    <x-inputs.number wire:model="normal_b" id="normal_b"
                                                        placeholder="0" :error="'normal_a'" />
                                                </div>
                                                <div class="col">
                                                    <label for="pre_a_1" class="col col-form-label">Pre Hipertensi A
                                                        1</label>
                                                    <x-inputs.number wire:model="pre_a_1" id="pre_a_1" placeholder="0"
                                                        :error="'pre_a_1'" />
                                                </div>
                                                <div class="col">
                                                    <label for="pre_b_1" class="col col-form-label">Pre Hipertensi B
                                                        1</label>
                                                    <x-inputs.number wire:model="pre_b_1" id="pre_b_1" placeholder="0"
                                                        :error="'pre_b_1'" />
                                                </div>
                                            </div>
                                            <div class="mb-3 row form-group">
                                                <div class="col">
                                                    <label for="pre_a_2" class="col col-form-label">Pre Hipertensi A
                                                        2</label>
                                                    <x-inputs.number wire:model="pre_a_2" id="pre_a_2" placeholder="0"
                                                        :error="'pre_a_2'" />
                                                </div>
                                                <div class="col">
                                                    <label for="pre_b_2" class="col col-form-label">Pre Hipertensi A
                                                        2</label>
                                                    <x-inputs.number wire:model="pre_b_2" id="pre_b_2" placeholder="0"
                                                        :error="'pre_b_2'" />
                                                </div>

                                                <div class="col">
                                                    <label for="ht1_a_1" class="col col-form-label">Hipertensi Tingkat
                                                        1 A 1</label>
                                                    <x-inputs.number wire:model="ht1_a_1" id="ht1_a_1" placeholder="0"
                                                        :error="'ht1_a_1'" />
                                                </div>
                                                <div class="col">
                                                    <label for="ht1_b_1" class="col col-form-label">Hipertensi Tingkat
                                                        1 B 1</label>
                                                    <x-inputs.number wire:model="ht1_b_1" id="ht1_b_1" placeholder="0"
                                                        :error="'ht1_b_1'" />
                                                </div>
                                            </div>


                                            <div class="mb-3 row form-group">

                                                <div class="col">
                                                    <label for="ht1_a_2" class="col col-form-label">Hipertensi Tingkat
                                                        1 A 2</label>
                                                    <x-inputs.number wire:model="ht1_a_2" id="ht1_a_2" placeholder="0"
                                                        :error="'ht1_a_2'" />
                                                </div>
                                                <div class="col">
                                                    <label for="ht1_b_2" class="col col-form-label">Hipertensi Tingkat
                                                        1 B 2</label>
                                                    <x-inputs.number wire:model="ht1_b_2" id="ht1_b_2" placeholder="0"
                                                        :error="'ht1_b_2'" />
                                                </div>
                                                <div class="col">
                                                    <label for="ht2_a" class="col col-form-label">Hipertensi
                                                        Tingkat
                                                        2 A</label>
                                                    <x-inputs.number wire:model="ht2_a" id="ht2_a"
                                                        placeholder="0" :error="'ht2_a'" />
                                                </div>
                                                <div class="col">
                                                    <label for="ht2_b" class="col col-form-label">Hipertensi
                                                        Tingkat 2 B</label>
                                                    <x-inputs.number wire:model="ht2_b" id="ht2_b"
                                                        placeholder="0" :error="'ht2_b'" />
                                                </div>
                                            </div>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary"
                                                data-dismiss="modal">Close</button>
                                            <button type="submit" class="btn btn-primary">Save changes</button>
                                        </div>
                                    </form>

                                </div>
                            </div>
                        </div>

                        <div class="table-content table-responsive position-relative overflow-auto d-flex">
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Formula ID</th>
                                        <th>Tanggal Dibuat</th>
                                        <th>Pembuat</th>
                                        <th></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($FormulaBloodPressure as $itemIndex => $items)
                                        <tr wire:key="{{ $itemIndex }}"">
                                            <td>{{ $itemIndex + 1 }}</td>
                                            <td>
                                                <a
                                                    wire:click="editFormulaBloodPressure({{ $items['id'] }})">FBP-00{{ $items['id'] }}</a>
                                            </td>
                                            <td>{{ $items['created_at'] }}</td>
                                            <td><span><img src="{{ asset('images/icons/user.png') }}"
                                                        alt=""></span>
                                                Staff 1</td>
                                            <td>
                                                <center>
                                                    @if ($items['status'] == 'inactive')
                                                        <span class="btn btn-success btn-sm"
                                                            wire:click="setActiveBloodPressure({{ $items['id'] }})">Set
                                                            Active</span>
                                                    @else
                                                        <span style="color:blue;">Active</span>
                                                    @endif
                                                </center>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div><!-- /.table-content-->
                    </div>
                </div>
            </div> {{-- Blood Pressure --}}

            <div class="col">
                <div class="card border-dark mb-3">
                    <div class="card-header">
                        <h5 class="card-title">Dislipidemia Status</h5>
                    </div>
                    <div class="card-body text-dark">

                        <div class="toolbar-tables border-top border-bottom d-flex justify-content-between p-2">
                            <div class="toolbar-left d-flex align-items-center">
                                <a type="button" data-toggle="modal" data-target="#modal-add-f2"
                                    class="button-toolbar d-flex gap-2 align-items-center py-2 px-3">
                                    <span class="icon d-flex align-items-center"><img
                                            src="{{ asset('images/icons/add.png') }}" alt="image add"></span>
                                    <span class="text-button">Add New</span>
                                </a>
                            </div><!-- /.toolbar-left -->
                        </div><!-- /.toolsbar-tables -->

                        <div class="modal fade" id="modal-add-f2" tabindex="-1" role="dialog"
                            aria-labelledby="modal-add-f1Label" aria-hidden="true" wire:ignore.self>
                            <div class="modal-dialog modal-lg" role="document">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="modal-add-f1Label">Tambah Formula Dislipidemia
                                        </h5>
                                        <button class="btn btn-danger" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
                                    <form wire:submit.prevent="saveFormulaDislipidemia">

                                        <div class="modal-body">
                                            <div class="mb-3 row form-group">
                                                <div class="col">
                                                    <label for="col_total" class="col col-form-label">Batas Kolesterol
                                                        Total</label>
                                                    <x-inputs.number wire:model="col_total" id="col_total"
                                                        placeholder="0" :error="'col_total'" />
                                                </div>
                                                <div class="col">
                                                    <label for="tga" class="col col-form-label">Batas TGA</label>
                                                    <x-inputs.number wire:model="tga" id="tga" placeholder="0"
                                                        :error="'tga'" />
                                                </div>
                                            </div>

                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary"
                                                data-dismiss="modal">Close</button>
                                            <button type="submit" class="btn btn-primary">Save changes</button>
                                        </div>
                                    </form>

                                </div>
                            </div>
                        </div>

                        <div class="table-content table-responsive position-relative overflow-auto d-flex">
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th>ID</th>
                                        <th>Formula Name</th>
                                        <th>Tanggal Dibuat</th>
                                        <th>Pembuat</th>
                                        <th></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($FormulaDislipidemia as $itemIndex => $items)
                                        <tr wire:key="{{ $itemIndex }}"">
                                            <td>{{ $items['id'] }}</td>
                                            <td>
                                                <a data-toggle="modal" data-target="#modal-add-f2"
                                                    data-id="id nya">FDP-00{{ $items['id'] }}</a>
                                            </td>
                                            <td>{{ $items['created_at'] }}</td>
                                            <td><span><img src="{{ asset('images/icons/user.png') }}"
                                                        alt=""></span>
                                                Staff 1</td>
                                            <td>
                                                <center>
                                                    @if ($items['status'] == 'inactive')
                                                        <span class="btn btn-success btn-sm"
                                                            wire:click="setActiveBloodPressure({{ $items['id'] }})">Set
                                                            Active</span>
                                                    @else
                                                        <span style="color:blue;">Active</span>
                                                    @endif
                                                </center>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div><!-- /.table-content-->
                    </div>
                </div>
            </div> {{-- Dislipidemia --}}

        </div>
    </div>

    {{-- <div class="">


    </div> --}}

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.1.3/dist/js/bootstrap.min.js"
        integrity="sha384-ChfqqxuZUCnJSK3+MXmPNIyE6ZbWh2IMqE241rYiqJxyMiZ6OW/JmZQ5stwEULTy" crossorigin="anonymous">
    </script>

    <script>
        $(document).on("click", ".open-AddBookDialog", function() {
            var myBookId = $(this).data('id');
            $(".modal-body #bookId").val(myBookId);
        });
    </script>
</div>
