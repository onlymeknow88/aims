<div class="inner-content">

    <div class="section-content">

        <div class="section-title py-3 px-2">
            <h4>Berita Acara - Commissioner Verification</h4>
        </div><!-- /.section-title -->

        <div class="table-maker">

            <div x-data="{ itemSelected: @entangle('itemSelected'), info: @entangle('info') }">

                <div class="toolbar-tables border-top border-bottom d-flex justify-content-between p-2">


                    <div class="toolbar-left d-flex align-items-center">
                        {{--<a href="{{ route('ko::ko.create.proposal') }}" type="button"
                           class="button-toolbar d-flex gap-2 align-items-center py-2 px-3">
                            <span class="icon d-flex align-items-center"><img src="{{asset('images/icons/add.png')}}" alt="image add"></span>
                            <span class="text-button">Add New</span>
                        </a>--}}
                        @if ($countSelected > 0)
                            <!-- <a href="#" type="button" class="button-toolbar d-flex gap-2 align-items-center py-2 px-3">
                                <span class="icon d-flex align-items-center"><img src="{{ asset('images/icons/export.png') }}"
                                        alt="image export"></span>
                                <span class="text-button">Export</span>
                            </a> -->
                            <a href="#" type="button" class="button-toolbar d-flex gap-2 align-items-center py-2 px-3" data-bs-toggle="modal" data-bs-target="#return">
                                <span class="icon d-flex align-items-center"><img src="{{ asset('images/icons/export.png') }}"
                                        alt="image export"></span>
                                <span class="text-button">Return</span>
                            </a>
                            <a href="#" type="button" class="button-toolbar d-flex gap-2 align-items-center py-2 px-3" data-bs-toggle="modal" data-bs-target="#submit">
                                <span class="icon d-flex align-items-center"><img src="{{ asset('images/icons/export.png') }}"
                                        alt="image export"></span>
                                <span class="text-button">Submit to Coordinator</span>
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
                                    <th>Tanggal</th>
                                    <th>Call Sign</th>
                                    <th>Merk</th>
                                    <th>Serial Number</th>
                                    <th>Identity Number</th>
                                    <th>Desc Temuan</th>
                                    <th>Kode Bahaya</th>
                                    <th>Attachment</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($issueReports as $itemIndex => $item)
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
                                                {{ date('d-m-Y', strtotime($item->created_at)) }}
                                            </a>
                                        </td>

                                        <td>{{ $item->koUnit->call_sign }}</td>
                                        <td>{{ $item->koUnit->koBrand->name ?? '-'}}</td>
                                        <td>{{ $item->koUnit->serial_number }}</td>
                                        <td>{{ $item->koUnit->identity_number }}</td>
                                        <td>{{ $item->note }}</td>
                                        <td>{{ $item->hazard_code }}</td>
                                        <td>
                                            @foreach($item->attachments as $attachment)
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

    <div class="modal fade" id="submit" data-bs-backdrop="static" data-bs-keyboard="false"
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
                <div class="modal-body">
                    <div class="row">
                        <div class="col-sm-12">
                            Berita Acara akan di Submit ke Coordinator, lanjutkan?
                            {{--<x-inputs.textarea wire:model="note" class="form-control" id="note" placeholder="Note" :error="'note'"></x-inputs.textarea>--}}
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal"
                            wire:click="closeModal()">Close
                    </button>
                    <button type="button" wire:click="submitToCoordinator()"
                            class="btn btn-outline-success bg-green text-white bg-hover-light-success">
                        Submit
                    </button>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="return" data-bs-backdrop="static" data-bs-keyboard="false"
         tabindex="-1"
         aria-labelledby="ContractorModallLabel" aria-hidden="true" wire:ignore.self>
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="ContractorModallLabel">Return</h5>
                    <button type="button" class="btn-close" wire:click="closeModal()"
                            data-bs-dismiss="modal"
                            aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-sm-12">
                            <x-inputs.textarea wire:model="returned_message" class="form-control" id="returned_message" placeholder="Note" :error="'returned_message'"></x-inputs.textarea>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal"
                            wire:click="closeModal()">Close
                    </button>
                    <button type="button" wire:click="return()"
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
