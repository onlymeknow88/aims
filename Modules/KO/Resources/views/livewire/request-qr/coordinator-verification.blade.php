<div class="inner-content">

    <div class="section-content">

        <div class="section-title py-3 px-2">
            <h4>Request QR - Coordinator Verification</h4>
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
                            <a href="#" type="button" class="button-toolbar d-flex gap-2 align-items-center py-2 px-3" data-bs-toggle="modal" data-bs-target="#reject">
                                <span class="icon d-flex align-items-center"><img src="{{ asset('images/icons/export.png') }}"
                                        alt="image export"></span>
                                <span class="text-button">Reject</span>
                            </a>
                            <a href="#" type="button" class="button-toolbar d-flex gap-2 align-items-center py-2 px-3" data-bs-toggle="modal" data-bs-target="#approve">
                                <span class="icon d-flex align-items-center"><img src="{{ asset('images/icons/export.png') }}"
                                        alt="image export"></span>
                                <span class="text-button">Approve</span>
                            </a>
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
                                    <th></th>
                                    <th>Number</th>
                                    <th>CCOW</th>
                                    <th>Area</th>
                                    <th>SPIP Desc</th>
                                    <th>Call Sign</th>
                                    <th>Status</th>
                                    <th>Masa Aktif Sementara</th>
                                    <th>Attachment</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($koProposals as $itemIndex => $item)
                                    <tr wire:key="{{ $itemIndex }}" wire:click="onSelectedItem('{{ $item->id }}')" 
                                        @if(in_array($item->id, $itemSelected))
                                            class="selected"
                                        @else
                                            class="tr"                                   
                                        @endif"
                                    >
                                        <td class="td-check">
                                            <span class="icon-checked"></span>
                                        </td>
                                        <td scope="row">
                                            <a style="color: green; font-weight: bold" href="#">
                                                {{ $item->number }}
                                            </a>
                                        </td>
                                        <td>{{ $item->ccow->company_name }}</td>
                                        <td>{{ $item->area }}</td>
                                        <td>{{ $item->koUnit->koSpipUnit->name }}</td>
                                        <td>{{ $item->koUnit->call_sign }}</td>
                                        <td>{{ $item->status }}</td>
                                        <td>{{ $item->temporary_validity_period }}</td>
                                        <td>
                                            @foreach($item->koQrRequestFiles as $attachment)
                                            <a target="blank" style="color: green;" href="{{asset('storage/'.$attachment->attachment)}}">
                                                <!-- <img src="{{ asset('/images/icons/pdf.png') }}" alt="pdf" /> -->
                                                <span>
                                                    - {{ $attachment->name }}
                                                </span>
                                            </a><br>
                                            @endforeach
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

    <div class="modal fade" id="approve" data-bs-backdrop="static" data-bs-keyboard="false"
         tabindex="-1"
         aria-labelledby="ContractorModallLabel" aria-hidden="true" wire:ignore.self>
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Approve</h5>
                    <button type="button" class="btn-close" wire:click="closeModal()"
                            data-bs-dismiss="modal"
                            aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-sm-12">
                            QR sementara akan di approve, lanjutkan?
                            {{--<x-inputs.textarea wire:model="note" class="form-control" id="note" placeholder="Note" :error="'note'"></x-inputs.textarea>--}}
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal"
                            wire:click="closeModal()">Close
                    </button>
                    <button type="button" wire:click="approve()"
                            class="btn btn-outline-success bg-green text-white bg-hover-light-success">
                        Submit
                    </button>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="reject" data-bs-backdrop="static" data-bs-keyboard="false"
         tabindex="-1"
         aria-labelledby="ContractorModallLabel" aria-hidden="true" wire:ignore.self>
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="ContractorModallLabel">Reject</h5>
                    <button type="button" class="btn-close" wire:click="closeModal()"
                            data-bs-dismiss="modal"
                            aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-sm-12">
                            QR sementara akan di reject, lanjutkan?
                            <!-- <x-inputs.textarea wire:model="returned_message" class="form-control" id="returned_message" placeholder="Note" :error="'returned_message'"></x-inputs.textarea> -->
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal"
                            wire:click="closeModal()">Close
                    </button>
                    <button type="button" wire:click="reject()"
                            class="btn btn-outline-success bg-green text-white bg-hover-light-success">
                        Return
                    </button>
                </div>
            </div>
        </div>
    </div>

</div>

<script>

</script>
