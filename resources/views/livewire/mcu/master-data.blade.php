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
                        <h5 class="card-title">Dokter Spesialis</h5>
                    </div>
                    <div class="card-body text-dark">

                        <div class="toolbar-tables border-top border-bottom d-flex justify-content-between p-2">
                            <div class="toolbar-left d-flex align-items-center">
                                <a type="button" data-toggle="modal" data-target="#modal-add-doctor"
                                    class="button-toolbar d-flex gap-2 align-items-center py-2 px-3">
                                    <span class="icon d-flex align-items-center"><img
                                            src="{{ asset('images/icons/add.png') }}" alt="image add"></span>
                                    <span class="text-button">Add New</span>
                                </a>
                            </div><!-- /.toolbar-left -->
                        </div><!-- /.toolsbar-tables -->

                        <div class="modal fade" id="modal-add-doctor" tabindex="-1" role="dialog"
                            aria-labelledby="modal-add-doctorLabel" aria-hidden="true" wire:ignore.self>
                            <div class="modal-dialog modal-lg" role="document">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="modal-add-doctorLabel">Tambah Dokter
                                        </h5>
                                        <button class="btn btn-danger" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
                                    <form wire:submit.prevent="saveDoctor">

                                        <div class="modal-body">
                                            <div class="mb-3 row form-group">
                                                <div class="col">
                                                    <label for="doctor_name" class="col col-form-label">Nama Dokter</label>
                                                    <x-inputs.text wire:model="doctor_name" id="doctor_name"
                                                        placeholder="" :error="'doctor_name'" />
                                                </div>
                                            </div>
                                            <div class="mb-3 row form-group">
                                                <div class="col">
                                                    <label for="specialist" class="col col-form-label">Spesialis</label>
                                                    <x-inputs.text wire:model="specialist" id="specialist" placeholder=""
                                                        :error="'specialist'" />
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
                                        <th>ID</th>
                                        <th>Nama Dokter</th>
                                        <th>Spesialis</th>
                                        <th>Tanggal Dibuat</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($Doctor as $itemIndex => $items)
                                        <tr wire:key="{{ $itemIndex }}"">
                                            <td>{{ $itemIndex + 1 }}</td>
                                            <td>
                                                <a data-toggle="modal"
                                                    data-target="#modal-add-doctor">SPE-00{{ $items['id'] }}</a>
                                            </td>
                                            <td>{{ $items['name'] }}</td>
                                            <td>{{ $items['specialist'] }}</td>
                                            <td>{{ $items['created_at'] }}</td>
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
                        <h5 class="card-title">Master Provider MCU</h5>
                    </div>
                    <div class="card-body text-dark">

                        <div class="toolbar-tables border-top border-bottom d-flex justify-content-between p-2">
                            <div class="toolbar-left d-flex align-items-center">
                                <a type="button" data-toggle="modal" data-target="#modal-add-provider"
                                    class="button-toolbar d-flex gap-2 align-items-center py-2 px-3">
                                    <span class="icon d-flex align-items-center"><img
                                            src="{{ asset('images/icons/add.png') }}" alt="image add"></span>
                                    <span class="text-button">Add New</span>
                                </a>
                            </div><!-- /.toolbar-left -->
                        </div><!-- /.toolsbar-tables -->

                        <div class="modal fade" id="modal-add-provider" tabindex="-1" role="dialog"
                            aria-labelledby="modal-add-doctorLabel" aria-hidden="true" wire:ignore.self>
                            <div class="modal-dialog modal-lg" role="document">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="modal-add-doctorLabel">Tambah Formula Dislipidemia
                                        </h5>
                                        <button class="btn btn-danger" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
                                    <form wire:submit.prevent="saveProvider">

                                        <div class="modal-body">
                                            <div class="mb-3 row form-group">
                                                <div class="col">
                                                    <label for="name" class="col col-form-label">Nama Provider</label>
                                                    <x-inputs.text wire:model="name" id="name"
                                                        placeholder="" :error="'name'" />
                                                </div>
                                                <div class="col">
                                                    <label for="status" class="col col-form-label">Status</label>
                                                    <x-inputs.text wire:model="status" id="status" placeholder=""
                                                        :error="'status'" />
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
                                        <th>ID</th>
                                        <th>Nama Provider</th>
                                        <th>Status</th>
                                        <th>Tanggal Dibuat</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($Provider as $itemIndex => $items)
                                        <tr wire:key="{{ $itemIndex }}"">
                                            <td>{{ $itemIndex+1 }}</td>
                                            <td>
                                                <a data-toggle="modal"
                                                    data-target="#modal-add-provider">PRV-00{{ $items['id'] }}</a>
                                            </td>
                                            <td>{{ $items['name'] }}</td>
                                            <td>{{ $items['created_at'] }}</td>
                                            <td>{{ $items['created_at'] }}</td>
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
</div>
