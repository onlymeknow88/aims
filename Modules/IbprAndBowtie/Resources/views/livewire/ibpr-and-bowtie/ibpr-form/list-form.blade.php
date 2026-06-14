@push('styles')
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        .table-document {
            width: 150%;
        }

        .table-document thead tr th:nth-child(2) {
            width: 10%;
        }
        .table-document thead tr th:nth-child(3) {
            width: 5%;
        }

        .custom .select2-container--bootstrap-5 .select2-dropdown .select2-results__options .select2-results__option {
            font-size: 12px!important;
        }
    </style>
@endpush

<div class="inner-content">
    <div class="header-detail-maker h-60px border d-flex gap-2 align-items-center px-3">
        <div class="left-header">
            <a href="{{ session('route') }}" class="d-flex align-items-center gap-3">
                <span><i class="fa-solid fa-arrow-left"></i></span>
                <span>Back</span>
            </a>
        </div><!-- /.left-header -->
    </div>

    <div class="section-content">

        <div class="py-3 px-2 flex gap-4">
            <div class="section-title ">
                <p class="text-xl text-black">Form IBPR List</p>
            </div>
            <div class="flex items-end">
                <p class="text-sm text-gray-600">{{ $ibpr->document_no }}</p>
            </div>
        </div><!-- /.section-title -->

        <div class="table-maker">

            <div x-data="{ itemSelected: @entangle('itemSelected'), info: @entangle('info') }">

                <div class="toolbar-tables border-top border-bottom d-flex justify-content-between p-2 sticky-top">

                    <div class="toolbar-left d-flex align-items-center">
                        <button data-bs-toggle="modal" data-bs-target="#staticBackdrop" type="button" class="button-toolbar d-flex gap-2 align-items-center py-2 px-3">
                            <span class="icon d-flex align-items-center"><img src="{{asset('images/icons/add.png')}}" alt="image add"></span>
                            <span class="text-button">Add Form</span>
                        </button>

                        <!-- <a href="/ibpr-and-bowtie/ibpr/export/{{ $ibpr->id }}" type="button" class="button-toolbar d-flex gap-2 align-items-center py-2 px-3">
                            <span class="icon d-flex align-items-center"><img src="{{asset('images/icons/export.png')}}" alt="image export"></span>
                            <span class="text-button">Export</span>
                        </a>

                        <a type="button"
                            class="button-toolbar d-flex gap-2 align-items-center py-2 px-3"
                            wire:click.prevent="confirmDelete">
                            <span class="icon d-flex align-items-center"><img src="{{asset('images/icons/delete.png')}}" alt="image delete"></span>
                            <span class="text-button">Delete</span>
                        </a> -->
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

                <div class="table-content table-responsive position-relative">

                    <div class="table-wrapper overflow-auto">

                        <table class="table" style="height: fit-content">
                            <thead>
                                <tr>
                                    @foreach ($columns as $column => $d)
                                        <th style="min-width: 150px;">
                                            <div class="column-sort d-flex justify-content-between w-full">
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
                                @if (count($forms) > 0)
                                    @foreach ($forms as $itemIndex => $item)
                                        <tr>
                                            <td wire:click.prevent="onSelectedItem('{{ $item->id }}')">{{ $item->activity }}</td>
                                            <td wire:click.prevent="onSelectedItem('{{ $item->id }}')">{{ $item->sub_activity }}</td>
                                            <td wire:click.prevent="onSelectedItem('{{ $item->id }}')">{{ $item->kondition }}</td>
                                            <td wire:click.prevent="onSelectedItem('{{ $item->id }}')">{{ $item->safety }}</td>
                                            <td wire:click.prevent="onSelectedItem('{{ $item->id }}')">{{ $item->incident_risk }}</td>
                                            {{-- <td wire:click.prevent="onSelectedItem('{{ $item->id }}')">{{ $item->safety_opportunity }}</td> --}}
                                            <td wire:click.prevent="onSelectedItem('{{ $item->id }}')">{{ $item->relevant_legislation }}</td>
                                            <td wire:click.prevent="onSelectedItem('{{ $item->id }}')">{{ $item->preliminary_consequence_k3 }}</td>
                                            <td wire:click.prevent="onSelectedItem('{{ $item->id }}')">{{ $item->preliminary_consequence_lh }}</td>
                                            <td wire:click.prevent="onSelectedItem('{{ $item->id }}')">{{ $item->preliminary_consequence_kp }}</td>
                                            <td wire:click.prevent="onSelectedItem('{{ $item->id }}')">{{ $item->preliminary_consequence_ksl }}</td>
                                            <td wire:click.prevent="onSelectedItem('{{ $item->id }}')">{{ $item->preliminary_consequence_kk }}</td>
                                            <td wire:click.prevent="onSelectedItem('{{ $item->id }}')">{{ $item->preliminary_frequence }}</td>
                                            <td wire:click.prevent="onSelectedItem('{{ $item->id }}')">{{ $item->preliminary_level_of_risk }}</td>
                                            <td wire:click.prevent="onSelectedItem('{{ $item->id }}')">{{ $item->preliminary_main_risk }}</td>
                                            <td>
                                                @if($item->risks)
                                                    @foreach($item->risks as $key => $risk_title)
                                                        - <a href="{{$risk_title->bowtie_id ? '/ibpr-and-bowtie/bowtie/detail/'.$risk_title->bowtie_id : '#'}}">{{$risk_title->name}}</a><br>
                                                    @endforeach
                                                @endif
                                            </td>
                                            <td wire:click.prevent="onSelectedItem('{{ $item->id }}')">{{ $item->effective_control }}</td>
                                            <td wire:click.prevent="onSelectedItem('{{ $item->id }}')">{{ $item->residual_consequence_k3 }}</td>
                                            <td wire:click.prevent="onSelectedItem('{{ $item->id }}')">{{ $item->residual_consequence_lh }}</td>
                                            <td wire:click.prevent="onSelectedItem('{{ $item->id }}')">{{ $item->residual_consequence_kp }}</td>
                                            <td wire:click.prevent="onSelectedItem('{{ $item->id }}')">{{ $item->residual_consequence_ksl }}</td>
                                            <td wire:click.prevent="onSelectedItem('{{ $item->id }}')">{{ $item->residual_consequence_kk }}</td>
                                            <td wire:click.prevent="onSelectedItem('{{ $item->id }}')">{{ $item->residual_frequence }}</td>
                                            <td wire:click.prevent="onSelectedItem('{{ $item->id }}')">{{ $item->residual_level_of_risk }}</td>
                                            <td wire:click.prevent="onSelectedItem('{{ $item->id }}')">{{ $item->residual_main_risk }}</td>
                                            <td wire:click.prevent="onSelectedItem('{{ $item->id }}')">{{ $item->follow_risk }}</td>
                                            <td>
                                                <button type="submit" class="px-3 py-2 bg-green-500 rounded-md text-white duration-300 hover:bg-green-700" wire:click="open_modal_edit('{{ $itemIndex }}')">
                                                    Edit
                                                </button>
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

    @include('ibprandbowtie::livewire.ibpr-and-bowtie.form.partials.ibpr-form')

</div>
