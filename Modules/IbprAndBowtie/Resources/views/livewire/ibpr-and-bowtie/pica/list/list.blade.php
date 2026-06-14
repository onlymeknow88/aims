@push('styles')
    <style>
        .text-link {
            color:green;
            font-weight: bold;
        }
    </style>
@endpush

<div class="inner-content">
    <div class="section-content">
        <div class="section-title py-3 px-2">
            <h4>Daftar Risiko</h4>
        </div><!-- /.section-title -->
    
        <div class="table-maker">
            <div x-data="{ itemSelected: @entangle('itemSelected'), info: @entangle('info') }">

                <div class="toolbar-tables border-top border-bottom d-flex justify-content-between p-2 sticky-top">
            
                    <div class="toolbar-left d-flex align-items-center">
            
                    </div><!-- /.toolbar-left -->
            
                    <div class="toolbar-right d-flex align-items-center">
            
                        @if($countSelected > 0 )
                            <a href="#" type="button" class="button-toolbar d-flex gap-2 align-items-center py-2 px-3" wire:click="removeSeleced()">
                                <span class="icon d-flex align-items-center"><img src="{{asset('images/icons/delete.png')}}" alt="image delete"></span>
                                <span class="text-button">{{ $countSelected }} Row Selected</span>
                            </a>
                        @endif
            
                    </div><!-- /.toolbar-right -->
            
                </div><!-- /.toolsbar-tables -->
            
                <div class="table-content table-responsive position-relative" :class="info ? 'infoOpen' : ''">
            
                    <div class="table-wrapper">
            
                        <table class="table table-document">
                            <thead>
                                <tr>
                                    @foreach ($columns as $column => $d)
                                        <th style="min-width: 150px;">
                                            <div class="column-sort d-flex justify-content-between w-100">
                                                <span>
                                                    {{ $column }}
                                                </span>
                                            </div>
                                        </th>
                                    @endforeach
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @if (count($data) > 0)
                                    @foreach ($data as $itemIndex => $items)
            
                                        <tr>
                                            <td>{{ $items->form->ibpr->ccow->company_name ?? $items->formIadl->iadl->ccow->company_name ?? '-' }}</td>
                                            <td>{{ $items->form->ibpr->department->name ?? $items->formIadl->iadl->department->name ?? '-' }}</td>
                                            <td>{{ $items->form->activity ?? $items->formIadl->activity ?? '-'  }}</td>
                                            <td>{{ $items->form->sub_activity ?? $items->formIadl->sub_activity ?? '-' }}</td>
                                            <td>{{ $items->form->incident_risk  ?? $items->formIadl->incident_risk ?? '-' }}</td>
                                            <td>{{ $items->form->safety ?? $items->formIadl->safety ?? '-'  }}</td>
                                            <td>{{ $items->form->preliminary_consequence_k3 ?? $items->formIadl->preliminary_consequence_lh ?? '-'  }}</td>
                                            <td>{{ $items->form->preliminary_frequence ?? $items->formIadl->preliminary_frequence ?? '-'  }}</td>
                                            <td>{{ $items->form->preliminary_level_of_risk ?? $items->formIadl->preliminary_level_of_risk ?? '-' }}</td>
                                            <td>{{ $items->plan }}</td>
                                            <td>{{ $items->form->ibpr->pjs->name ?? $items->formIadl->iadl->pjs->name ?? '-' }}</td>
                                            <td>{{ $items->review_date ?? '-' }}</td>
                                            <td>
                                                {{$items->ibprRisk->name ?? '-'}}
                                            </td>
                                            <!-- <td>
                                                @foreach($items->form->risks ?? $items->formIadl->risks as $itemRiskIndex => $risk)
                                                    <p style="margin-top: 0; margin-bottom: 0;">{{ $risk->name ?? '-' }}</p>
                                                @endforeach
                                            </td> -->
                                            <td wire:click.prevent="downloadFile('{{ $items->attachment }}')">
                                                <p class="text-green-700 duration-500 hover:scale-105">{{ $items->attachment_name }}</p>
                                            </td>
                                            <td>{{ $items->target_date ?? '-' }}</td>
                                            <td>{{ $items->status ?? '-' }}</td>
                                            <td>
                                                <a href="#" class="action-icon" onclick="openModalEditPica('{{ $items->id }}')">
                                                    <i class="fa fa-edit"></i> Edit
                                                </a>
                                            </td>
                                        </tr>
                                    @endforeach
                                @else
                                        <tr>
                                            <td colspan="14" class="text-center">@lang('global.empty_data')</td>
                                        </tr>
                                @endif
                            </tbody>
                        </table>
            
                    </div><!-- /.table-wrapper -->
            
                    {{-- <div class="info bg-white px-3 pt-0" x-show="info">
                        <livewire:document-systems.maker.sidebar-info />
                    </div> --}}
            
                </div><!-- /.table-content-->
            
                {{-- filter --}}
                <div class="modal fade" id="sortModal_table" tabindex="-1" aria-labelledby="sortModal_tableLabel"
                    aria-hidden="true" style="display: none;" wire:ignore.self>
                    <div class="modal-dialog" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="sortModal_tableLabel">Filter & Sort</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <form wire:submit.prevent="filterSort">
            
                                <div class="modal-body">
                                    <div class="bootstrap-table">
                                        {{-- <div class="fixed-table-toolbar">
                                        <div class="bars">
                                            <div id="toolbar" class="pb-3">
                                                <button id="add" type="button" class="btn btn-secondary"><i
                                                        class="bi bi-plus"></i> Add Level</button>
                                                <button id="delete" type="button" class="btn btn-secondary"><i
                                                        class="bi bi-dash"></i> Delete Level</button>
                                            </div>
                                        </div>
                                    </div> --}}
                                        <div class="fixed-table-container">
                                            <table id="multi-sort" class="table">
                                                <thead>
                                                    <tr>
                                                        <th></th>
                                                        <th>
                                                            <div class="th-inner">Filtered by</div>
                                                        </th>
                                                        <th>
                                                            <div class="th-inner">Order</div>
                                                        </th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @foreach ($columns as $column => $detail)
                                                        @include('livewire.document-systems.maker.components.table-filter', [
                                                            'detail' => $detail,
                                                            'column' => $column,
                                                        ])
                                                    @endforeach
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" wire:click="resetFilterSort()">Reset</button>
                                    <button type="submit" class="btn btn-primary multi-sort-order-button"
                                        data-bs-dismiss="modal">Sort</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div> <!-- end Filter -->
            
            </div>
        </div><!-- /.table-maker -->
    </div><!-- /.section-content -->
</div>

<livewire:ibprandbowtie::pica.modal.modal-edit-pica />

@push('scripts')
<script src="https://code.jquery.com/ui/1.13.2/jquery-ui.js"></script>
<script>

    function openModalEditPica(id){
        Livewire.emit('click_edit_pica', id)
    }

    $('#modal_pica_edit').on('hide.bs.modal', function (e) {
            Livewire.emit('check_pica');
        });
    
</script>
@endpush