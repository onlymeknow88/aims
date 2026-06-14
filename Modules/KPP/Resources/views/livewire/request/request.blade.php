<div class="inner-content">
    
    <div class="section-content">

        <div class="section-title py-3 px-2">
            <h4>Request Kepatuhan</h4>
        </div><!-- /.section-title -->

        <div class="table-rule">

            <div x-data="{ itemSelected: @entangle('itemSelected'), info: @entangle('info') }">

                <div class="toolbar-tables border-top border-bottom d-flex justify-content-between p-2">

                    <div class="toolbar-left d-flex align-items-center">
                        @if ($countSelected > 0)
                            <div class="button-document">
                                <button
                                    class="dropdown-toggle btn btn-outline-default d-flex justify-content-center position-relative px-4"
                                    role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                    <span class="icon d-flex align-items-center"><img src="{{ asset('images/icons/export.png') }}"
                                        alt="image export"></span>
                                <span class="text-button"> Action</span>
                                </button>
                                <ul class="dropdown-menu">
                                    <li>
                                        <a href="#" type="button" class="button-toolbar d-flex gap-2 align-items-center py-2 px-3"
                                            data-bs-toggle="modal" data-bs-target="#addCCOW">
                                            <span class="text-button">Approve</span>
                                        </a>
                                    </li>
                                </ul>
                            </div>
                        @endif
                    </div><!-- /.toolbar-left -->

                    <div class="toolbar-right d-flex align-items-center"> 

                        @if ($countSelected > 0)
                            <a href="#" type="button" class="button-toolbar d-flex gap-2 align-items-center py-2 px-3"
                                wire:click="removeSeleced()">
                                <span class="icon d-flex align-items-center"><img src="{{ asset('images/icons/delete.png') }}"
                                        alt="image delete"></span>
                                <span class="text-button">{{ $countSelected }} Row Selected</span>
                            </a>
                        @endif

                    </div><!-- /.toolbar-right -->
                    
                </div><!-- /.toolsbar-tables -->

                <div class="table-content table-responsive position-relative">
                    <div class="table-wrapper overflow-auto">
                        <table class="table">
                            <thead>
                                <tr @if ($selectAll) class="selected" @else class="tr" @endif>
                                    <th style="text-align: center; vertical-align: middle;" class="sticky-top" wire:click="toggleSelectAll">
                                        <span class="icon-checked"></span>
                                    </th>
                                    <th>Requested By</th>
                                    <th>Nomor Perturan</th>
                                    <th>Judul Peraturan</th>
                                    <th>Jenis Peraturan</th>
                                    <th>Otoritas Instansi</th>
                                    <th>Comment</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($dataTables as $itemIndex => $item)
                                
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
                                        <td>{{$item->company->company_name ?? '-'}}</td>                        
                                        <td>
                                            {{ $item->rule->number }}
                                        </td>
                                        <td style="min-width: 500px; white-space: normal">{{$item->rule->title}}</td>
                                        <td>{{$item->rule->ruleType->name ?? '-'}}</td>
                                        <td>{{$item->rule->agencyAuthority->name ?? '-'}}</td>
                                        <td>
                                            {{$item->comment}}
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
              

                    <div class="modal fade" id="addCCOW" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
                    aria-labelledby="CCOWModalLabel" aria-hidden="true" wire:ignore.self>
                        <div class="modal-dialog modal-dialog-centered">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="CCOWModalLabel">Add Kepatuhan</h5>
                                    <button type="button" class="btn-close "wire:click="closeModal()" data-bs-dismiss="modal"
                                        aria-label="Close"></button>
                                </div>
                                <div class="modal-body">
                                    <div class="mb-3 row form-group">
                                        <div class="col-sm-12">
                                            <label for="agency_authority" class="col-sm-12 col-form-label">Comment</label>
                                            <x-inputs.textarea wire:model="comment" class="form-control" id="comment" placeholder="Comment" :error="'comment'"></x-inputs.textarea>
                                        </div>
                                    </div>

                                    <div class="invited-people mb-5">
                                        <div class="mb-3">
                                            <h5 class="fw-normal">Invited People</h4>
                                        </div>
                                        <div class="mb-3 row form-group">
                                            
                                            <div class="col-sm-12">
                                                <div class="position-relative input-group">
                                                    <span class="input-group-text">
                                                        <i class="fa fa-envelope"></i>
                                                    </span>
                                                    <input class="form-control" type="email" id="invited_people" wire:model="inputInvited" wire:keydown.enter.prevent="addInvitedPeople()" />                                    
                                                </div>
                                            </div>

                                        </div><!-- /.form-group --> 

                                        <div class="mb-3 row form-group d-flex gap-3 flex-wrap">
                                            @if($invitedPeople)
                                                @foreach ($invitedPeople as $key => $people)
                                                    <div class="list-people position-relative px-3 py-2 border rounded w-auto d-flex gap-2 align-items-center mx-3">
                                                        <span class="opacity-80">{{$people}}</span>
                                                        <button class="btn-closed"><img src="{{asset('/images/icons/delete.png')}}" wire:click.prevent="removeInvited('{{$people}}')" alt=""></button>
                                                    </div>
                                                @endforeach
                                            @endif
                                        </div><!-- /.form-group --> 
                                    </div><!-- /.invited-people -->

                                    <div class="mb-3 row form-group required">
                                        <label for="notify_to" class="col-sm-12 col-form-label">Would you like to notify them by email?</label>
                                        <div class="col-sm-12">
                                            <div class="form-check">
                                                <input wire:model="notify_to" class="form-check-input" type="radio" name="notify_to" value="both" id="radio1" checked>
                                                <label class="form-check-label" for="radio1">
                                                    Both Company and Personal User
                                                </label>
                                            </div>
                                            <div class="form-check">
                                                <input wire:model="notify_to" class="form-check-input" type="radio" name="notify_to"
                                                       value="company">
                                                <label class="form-check-label" for="radio2">
                                                    Only Company
                                                </label>
                                            </div>
                                            <div class="form-check">
                                                <input wire:model="notify_to" class="form-check-input" type="radio" name="notify_to" value="user">
                                                <label class="form-check-label" for="radio3">
                                                    Only Personal User
                                                </label>
                                            </div>
                                            <div class="form-check">
                                                <input wire:model="notify_to" class="form-check-input" type="radio" name="notify_to" value="none">
                                                <label class="form-check-label" for="radio4">
                                                    None
                                                </label>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal"
                                        wire:click="closeModal()">Close</button>
                                    <button type="button" wire:click="storeObedience()"
                                        class="btn btn-outline-success bg-green text-white bg-hover-light-success">
                                        Submit
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>


                </div><!-- /.table-content-->

            </div>

        </div><!-- /.table-maker -->

    </div><!-- /.section-content -->

    {{--<div class="section-footer d-flex justify-content-between">
        <div class="update-on opacity-80">Update on Sep 24, 2022 . 15.00 pm</div>
        <div class="row-data opacity-80">1,000 Document Active</div>
    </div><!-- /.section-footer -->--}}

</div>

<script>
    window.addEventListener('closeModal', event => {
        $('#addCCOW').modal('hide');
        $('#addContractor').modal('hide');
        $('#addSubContractor').modal('hide');
        $('#requestObedience').modal('hide');
        // @this.set('comment', null);

    });
</script>
