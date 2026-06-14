<div class="inner-content">

    <div class="section-content">

        <div class="section-title py-3 px-2">
            <h4>Request QR Sementara</h4>
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
                            <!-- <a href="#" type="button" class="button-toolbar d-flex gap-2 align-items-center py-2 px-3" data-bs-toggle="modal" data-bs-target="#return">
                                <span class="icon d-flex align-items-center"><img src="{{ asset('images/icons/export.png') }}"
                                        alt="image export"></span>
                                <span class="text-button">Return</span>
                            </a>
                            <a href="#" type="button" class="button-toolbar d-flex gap-2 align-items-center py-2 px-3" data-bs-toggle="modal" data-bs-target="#submit">
                                <span class="icon d-flex align-items-center"><img src="{{ asset('images/icons/export.png') }}"
                                        alt="image export"></span>
                                <span class="text-button">Submit to Coordinator</span>
                            </a> -->
                        @endif
                    </div><!-- /.toolbar-left -->

                    <div class="toolbar-right d-flex align-items-center">

                        {{--@if ($countSelected > 0)
                            <a href="#" type="button" class="button-toolbar d-flex gap-2 align-items-center py-2 px-3"
                                wire:click="removeSeleced()">
                                <span class="icon d-flex align-items-center"><img src="{{ asset('images/icons/delete.png') }}"
                                        alt="image delete"></span>
                                <span class="text-button">{{ $countSelected }} Row Selected</span>
                            </a>
                        @endif--}}

                    </div><!-- /.toolbar-right -->

                </div><!-- /.toolsbar-tables -->

                <div class="table-content table-responsive position-relative">
                    <div class="table-wrapper overflow-auto">
                        <table class="table" style="height: fit-content">
                            <thead>
                                <tr>
                                    <th>Number</th>
                                    <th>CCOW</th>
                                    <th>Area</th>
                                    <th>SPIP Desc</th>
                                    <th>Call Sign</th>
                                    <th>Status KO</th>
                                    <th>Status QR Sementara</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($koProposals as $itemIndex => $item)
                                    <tr>
                                        <td scope="row">
                                            <a style="color: green; font-weight: bold" href="{{ route('ko::request-qr.show', $item->id) }}">
                                                {{ $item->number }}
                                            </a>
                                        </td>

                                        <td>{{ $item->ccow->company_name }}</td>
                                        <td>{{ $item->area }}</td>
                                        <td>{{ $item->koUnit->koSpipUnit->name }}</td>
                                        <td>{{ $item->koUnit->call_sign }}</td>
                                        <td>{{ $item->status }}</td>
                                        <td>{{ $item->temporary_qr_status }}</td>
                                        <td class="text-center">
                                            @if($item->temporary_qr_status == null || $item->temporary_qr_status == 'Rejected')
                                            <a href="#" wire:click="submitId('{{ $item->id }}')" class="btn btn-outline-success bg-green text-white bg-hover-light-success">
                                                <i class="fa fa-check"></i> Request
                                            </a>
                                            @endif
                                        </td>

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

    {{--<div class="section-footer d-flex justify-content-between sticky-bottom bg-white align-items-center h-60px">
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

    </div><!-- /.section-footer -->--}}

    <div class="modal fade" id="sumitModal" data-bs-backdrop="static" data-bs-keyboard="false"
         tabindex="-1"
         aria-labelledby="ContractorModallLabel" aria-hidden="true" wire:ignore.self>
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="ContractorModallLabel">Submit to Coordinator</h5>
                    <button type="button" class="btn-close" wire:click="closeModal()"
                            data-bs-dismiss="modal"
                            aria-label="Close"></button>
                </div>
                <form enctype="multipart/form-data" wire:submit.prevent="submitToCoordinator">
                <div class="modal-body">
                    <div class="row">
                        <div class="row">
                            <div class="col-sm-12">
                                Tanggal Masa Aktif Sementara
                                <x-inputs.datepicker wire:model="temporary_validity_period" id="temporary_validity_period" :error="'temporary_validity_period'" required></x-inputs.datepicker>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="mb-3 row form-group">
                            <label for="area" class="col-sm-12 col-form-label">Attachment</label>
                            <div class="col-sm-12">
                                <input type="file" wire:model="file" class="form-control @error('file') is-invalid @enderror" multiple required>
                                @error('file')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal"
                            wire:click="closeModal()">Close
                    </button>
                    <button type="submit" wire:loading.attr="disabled"
                            class="btn btn-outline-success bg-green text-white bg-hover-light-success">
                        Submit
                    </button>
                </div>
                </form>
            </div>
        </div>
    </div>

</div>

@push('scripts')
    <script>
        window.addEventListener('closeModal', event => {
            $('#sumitModal').modal('hide');
        });

        window.addEventListener('openModal', event => {
            $('#sumitModal').modal('show');
        });
    </script>
@endpush

@push('scripts')
    <script>
        const Toast = Swal.mixin({
            toast: true,
            position: 'top-end',
            showConfirmButton: false,
            timer: 3000,
            timerProgressBar: true,
        })
        document.addEventListener("DOMContentLoaded", () => {
            Livewire.hook('message.sent', (message, component) => {
                
                if (message.updateQueue[0].payload.method === 'startUpload') {
                    Toast.fire({
                        icon: 'success',
                        title: 'Proses Upload ' + message.updateQueue[0].payload.params[0],
                        timer: false,
                        didOpen: (toast) => {
                            Toast.showLoading();
                        }
                    });
                }

                if (message.updateQueue[0].payload.method === "finishUpload") {
                    console.log(message.updateQueue[0].payload.params[0])
                    Toast.fire({
                        icon: 'success',
                        title: 'Proses Upload ' + message.updateQueue[0].payload.params[0] + ' Success',
                        timer: 2000,
                    });
                }
                
            })

        });
        
    </script>
@endpush