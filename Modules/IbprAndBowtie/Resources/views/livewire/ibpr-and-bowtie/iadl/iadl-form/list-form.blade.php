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
                <p class="text-xl text-black">Form IADL List</p>
            </div>
            <div class="flex items-end">
                <p class="text-sm text-gray-600">{{ $iadl->document_no }}</p>
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

                        <!-- <a href="/ibpr-and-bowtie/iadl/export/{{ $iadl->id  }}" type="button" class="button-toolbar d-flex gap-2 align-items-center py-2 px-3">
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
                                            <td wire:click.prevent="onSelectedItem('{{ $item->id }}')">{{ $item->safety_opportunity }}</td>
                                            <td wire:click.prevent="onSelectedItem('{{ $item->id }}')">{{ $item->relevant_legislation }}</td>
                                            <td wire:click.prevent="onSelectedItem('{{ $item->id }}')">{{ $item->preliminary_consequence_lh }}</td>
                                            <td wire:click.prevent="onSelectedItem('{{ $item->id }}')">{{ $item->preliminary_frequence }}</td>
                                            <td wire:click.prevent="onSelectedItem('{{ $item->id }}')">{{ $item->preliminary_level_of_risk }}</td>
                                            <td wire:click.prevent="onSelectedItem('{{ $item->id }}')">{{ $item->preliminary_main_risk }}</td>
                                            <td wire:click.prevent="onSelectedItem('{{ $item->id }}')">{{ $item->modal_of_current }}</td>
                                            <td wire:click.prevent="onSelectedItem('{{ $item->id }}')">{{ $item->effective_control }}</td>

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


    <div wire:ignore.self class="modal fade" id="staticBackdrop" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg">
          <div class="modal-content">
            <div class="modal-header">
              <div class="modal-title" id="staticBackdropLabel"></div>
              <button class="" data-bs-dismiss="modal" aria-label="Close">X</button>
            </div>
            <div class="modal-body">
                <div class="mb-3 row form-group">
                    <label for="activity" class="col-sm-4 col-form-label flex">Proses
                        <span class="text-red-600">*</span>

                    </label>
                    <div class="col-sm-8">
                        <x-inputs.text
                            id="activity"
                            error="activity"
                            wire:model.defer="activity"
                            placeholder="Proses"/>
                    </div>
                </div>
                <div class="mb-3 row form-group">
                    <label for="sub_activity" class="col-sm-4 col-form-label flex">Aktifitas
                        <span class="text-red-600">*</span>

                    </label>
                    <div class="col-sm-8">
                        <x-inputs.text
                            wire:model.defer="sub_activity"
                            id="sub_activity"
                            error="sub_activity"
                            placeholder="Aktifitas"
                        />
                    </div>
                </div>
                <div class="mb-3 row form-group">
                    <label for="kondition" class="col-sm-4 col-form-label flex">Aspek Lingkungan Hidup
                        <span class="text-red-600">*</span>

                    </label>
                    <div class="col-sm-8">
                        <x-inputs.text
                            wire:model.defer="kondition"
                            id="kondition"
                            error="kondition"
                            placeholder="Aspek Lingkungan Hidup"
                        />
                    </div>
                </div>
                <div class="mb-3 row form-group">
                    <label for="safety" class="col-sm-4 col-form-label flex">Dampak Lingkungan Hidup
                        <span class="text-red-600">*</span>

                    </label>
                    <div class="col-sm-8">
                        <x-inputs.text
                            wire:model.defer="safety"
                            id="safety"
                            error="safety"
                            placeholder="Dampak Lingkungan Hidup"
                        />
                    </div>
                </div>
                <div class="mb-3 row form-group">
                    <label for="incident_risk" class="col-sm-4 col-form-label flex">Peluang LH
                        <span class="text-red-600">*</span>

                    </label>
                    <div class="col-sm-8">
                        <x-inputs.text
                            wire:model.defer="incident_risk"
                            id="incident_risk"
                            error="incident_risk"
                            placeholder="Peluang LH "
                        />
                    </div>
                </div>
                {{-- <div class="mb-3 row form-group ">
                    <label for="kondition" class="col-sm-4 col-form-label">Type of Activity <span class="text-red-600">*</span></label>
                    <div class="col-sm-8">
                        <x-ibprandbowtie-select-2
                            id="kondition"
                            placeholder="Select"
                            :error="'kondition'"
                            wire:model.defer="kondition"
                            >
                            <option value="Rutin">Rutin</option>
                            <option value="Tidak Rutin">Tidak Rutin</option>
                        </x-ibprandbowtie-select-2>
                    </div>
                </div> --}}
                <div class="mb-3 row form-group ">
                    <label for="safety_opportunity" class="col-sm-4 col-form-label flex">Kondisi Aspek
                        <span class="text-red-600">*</span>

                    </label>
                    <div class="col-sm-8">
                        <x-ibprandbowtie-select-2
                            id="safety_opportunity"
                            placeholder="Select"
                            :error="'safety_opportunity'"
                            wire:model.defer="safety_opportunity"
                            >
                                <option value="Normal">Normal</option>
                                <option value="Abnormal">Abnormal</option>
                                <option value="Darurat">Darurat</option>
                        </x-ibprandbowtie-select-2>
                    </div>
                </div>
                {{-- <div class="mb-3 row form-group">
                    <label for="incident_risk" class="col-sm-4 col-form-label">Incident Risk <span class="text-red-600">*</span></label>
                    <div class="col-sm-8">
                        <x-inputs.text
                            wire:model.defer="incident_risk"
                            id="incident_risk"
                            error="incident_risk"
                            placeholder="Incident Risk"/>
                    </div>
                </div> --}}
                <div class="mb-3 row form-group">
                    <label for="relevant_legislation" class="col-sm-4 col-form-label">Peraturan Relevan <span class="text-red-600">*</span></label>
                    <div class="col-sm-8">
                        <x-inputs.text
                            wire:model.defer="relevant_legislation"
                            id="relevant_legislation"
                            error="relevant_legislation"
                            placeholder="Peraturan Relevan"/>
                    </div>
                </div>
                <br />
                <div class="col-md-6">
                    <h5 class="font-semibold">Penilaian Aspek & Dampak LH</h4>
                </div>
                <img src="{{ asset('images/ibpr-and-bowtie/matrix-ibpr.jpg') }}" alt="" width="100%">
                <br />
                <div class="row mb-3">
                    <div class="col-sm-4 flex items-center">
                        <label for="preliminary_frequence" class="col-form-label flex">Keparahan
                            <span class="text-red-600">*</span>

                        </label>
                    </div>
                    <div class="col-sm-8 flex">
                         <div class="mb-3 col-md form-group relative">
                             <div class="flex items-center">
                              <div class="cursor-pointer duration-500 hover:scale-105">
                                  <button id="btn-togle-lh" type="button" class="flex text-xs text-gray-500 mr-2 items-center justify-center border rounded-full h-5 w-5">
                                      !
                                  </button>
                              </div>
                              <label for="title" class="col-sm-4 col-form-label">LH</label>
                             </div>
                             <div id="tooltip_lh" class="border tooltip_custom hidden w-96 bg-white shadow-sm rounded-md absolute z-10 h-[500px] overflow-scroll">
                                  <div class="grid grid-cols-1">
                                    <div wire:click="change_consequences(5, 'preliminary_consequence_lh')" class="border-b duration-700 hover:bg-gray-200 cursor-pointer">
                                          <div class="py-3 px-4">
                                             Mengakibatkan kematian dikarenakan kecelakaan kerja / cacat permanen
                                              <div class="mt-2 text-sm text-blue-500 font-bold">
                                                  Konsekuensi (5)
                                              </div>
                                          </div>
                                      </div>
                                      <div wire:click="change_consequences(5, 'preliminary_consequence_lh')" class="border-b duration-700 hover:bg-gray-200 cursor-pointer">
                                          <div class="py-3 px-4">
                                             Terpapar PAK yang tidak dapat pulih/ sembuh
                                             <div class="mt-2 text-sm text-blue-500 font-bold">
                                                  Konsekuensi (5)
                                              </div>
                                          </div>
                                      </div>
                                      <div wire:click="change_consequences(4, 'preliminary_consequence_lh')" class="border-b duration-700 hover:bg-gray-200 cursor-pointer">
                                          <div class="py-3 px-4">
                                             Mengakibatkan Cidera berat dikarenakan kecelakaan kerja
                                              <div class="mt-2 text-sm text-blue-500 font-bold">
                                                  Konsekuensi (4)
                                              </div>
                                          </div>
                                      </div>
                                      <div wire:click="change_consequences(4, 'preliminary_consequence_lh')" class="border-b duration-700 hover:bg-gray-200 cursor-pointer">
                                          <div class="py-3 px-4">
                                             Mengakibatkan munculnya PAK yang dapat pulih dengan jumlah karyawan terpapar di atas 10 orang
                                              <div class="mt-2 text-sm text-blue-500 font-bold">
                                                  Konsekuensi (4)
                                              </div>
                                          </div>
                                      </div>
                                      <div wire:click="change_consequences(3, 'preliminary_consequence_lh')" class="border-b duration-700 hover:bg-gray-200 cursor-pointer">
                                          <div class="py-3 px-4">
                                             Mengakibatkan kematian dikarenakan kecelakaan kerja / cacat permanen
                                              <div class="mt-2 text-sm text-blue-500 font-bold">
                                                  Konsekuensi (3)
                                              </div>
                                          </div>
                                      </div>
                                      <div wire:click="change_consequences(3, 'preliminary_consequence_lh')" class="border-b duration-700 hover:bg-gray-200 cursor-pointer">
                                          <div class="py-3 px-4">
                                             Terpapar PAK yang tidak dapat pulih/ sembuh
                                              <div class="mt-2 text-sm text-blue-500 font-bold">
                                                  Konsekuensi (3)
                                              </div>
                                          </div>
                                      </div>
                                      <div wire:click="change_consequences(2, 'preliminary_consequence_lh')" class="border-b duration-700 hover:bg-gray-200 cursor-pointer">
                                          <div class="py-3 px-4">
                                             Mengakibatkan Cidera berat dikarenakan kecelakaan kerja
                                              <div class="mt-2 text-sm text-blue-500 font-bold">
                                                  Konsekuensi (2)
                                              </div>
                                          </div>
                                      </div>
                                      <div wire:click="change_consequences(2, 'preliminary_consequence_lh')" class="border-b duration-700 hover:bg-gray-200 cursor-pointer">
                                          <div class="py-3 px-4">
                                             Mengakibatkan munculnya PAK yang dapat pulih dengan jumlah karyawan terpapar di atas 10 orang
                                              <div class="mt-2 text-sm text-blue-500 font-bold">
                                                  Konsekuensi (2)
                                              </div>
                                          </div>
                                      </div>
                                      <div wire:click="change_consequences(1, 'preliminary_consequence_lh')" class="border-b duration-700 hover:bg-gray-200 cursor-pointer">
                                         <div class="py-3 px-4">
                                             Mengakibatkan kematian dikarenakan kecelakaan kerja / cacat permanen
                                             <div class="mt-2 text-sm text-blue-500 font-bold">
                                                 Konsekuensi (1)
                                             </div>
                                         </div>
                                     </div>
                                     <div wire:click="change_consequences(1, 'preliminary_consequence_lh')" class="border-b duration-700 hover:bg-gray-200 cursor-pointer">
                                          <div class="py-3 px-4">
                                             Terpapar PAK yang tidak dapat pulih/ sembuh
                                              <div class="mt-2 text-sm text-blue-500 font-bold">
                                                  Konsekuensi (1)
                                              </div>
                                          </div>
                                      </div>
                                  </div>
                             </div>
                             <div class="col-sm-12">
                                 <x-inputs.number
                                     disabled
                                     wire:model.defer="preliminary_consequence_lh"
                                     id="preliminary_consequence_lh"
                                     error="preliminary_consequence_lh"
                                     placeholder="LH"/>
                             </div>
                         </div>
                    </div>
                </div>
                <div class="mb-3 row form-group" style="z-index: 9">
                    <label for="preliminary_frequence" class="col-sm-4 col-form-label flex">Kemungkinan
                        <span class="text-red-600">*</span>
                        <span class="ml-2 relative">
                            <img class="cursor-pointer duration-500 hover:scale-125" onmouseover="show_preliminary_frequence_info()" onmouseout="show_preliminary_frequence_info()" src="{{ asset('./images/icons/info.png') }}" alt="info">
                            {{-- <span id="preliminary_frequence_info" class="bg-white w-[600px] border rounded absolute p-3 transition-all z-10">
                                <div class="bg-white grid grid-cols-1 w-full">
                                    <div class="flex w-full">
                                        <p class="w-5 font-[500] text-[13px]">A</p>
                                        <p class="w-3 font-[500] text-[13px]">:</p>
                                        <p class="font-[500] text-[13px]">Terjadi dalam banyak keadaan (mulai dari tiap saat/hari hingga 1x/ minggu)</p>
                                    </div>
                                    <div class="flex w-full">
                                        <p class="w-5 font-[500] text-[13px]">B</p>
                                        <p class="w-3 font-[500] text-[13px]">:</p>
                                        <p class="font-[500] text-[13px]">Kemungkinan terjadi dalam tiap bulan</p>
                                    </div>
                                    <div class="flex w-full">
                                        <p class="w-5 font-[500] text-[13px]">C</p>
                                        <p class="w-3 font-[500] text-[13px]">:</p>
                                        <p class="font-[500] text-[13px]">Kemungkinan terjadi beberapa kali dalam 1 tahun</p>
                                    </div>
                                    <div class="flex w-full">
                                        <p class="w-5 font-[500] text-[13px]">D</p>
                                        <p class="w-3 font-[500] text-[13px]">:</p>
                                        <p class="font-[500] text-[13px]">Kemungkinan terjadi lebih dari 1 tahun</p>
                                    </div>
                                    <div class="flex w-full">
                                        <p class="w-5 font-[500] text-[13px]">E</p>
                                        <p class="w-3 font-[500] text-[13px]">:</p>
                                        <p class="font-[500] text-[13px]">Kemungkinan terjadi tetapi dalam situasi yang luar biasa</p>
                                    </div>
                                </div>
                            </span> --}}
                        </span>
                    </label>
                    <div class="col-sm-8">
                        <select
                            class="form-control"
                            id="preliminary_frequence"
                            placeholder="Select Frequence"
                            :error="'preliminary_frequence'"
                            wire:model.defer="preliminary_frequence"
                            >
                                <option>Select Frequence</option>
                                <option value="A">A</option>
                                <option value="B">B</option>
                                <option value="C">C</option>
                                <option value="D">D</option>
                                <option value="E">E</option>
                        </select>
                    </div>
                </div>
                <div class="mb-3 row form-group">
                    <label for="preliminary_level_of_risk" class="col-sm-4 col-form-label flex">Tingkat Rasio
                        <span class="text-red-600">*</span>

                    </label>
                    <div class="col-sm-8">
                        <x-inputs.text
                            disabled
                            wire:model.defer="preliminary_level_of_risk_label"
                            id="preliminary_level_of_risk_label"
                            error="preliminary_level_of_risk"
                            placeholder="Tingkat Rasio"/>
                    </div>
                </div>
                <div class="mb-3 row form-group">
                    <label for="preliminary_main_risk" class="col-sm-4 col-form-label flex">Aspek Significan
                        <span class="text-red-600">*</span>

                    </label>
                    <div class="col-sm-8">
                        <x-inputs.text
                            disabled
                            wire:model.defer="preliminary_main_risk"
                            id="preliminary_main_risk"
                            error="preliminary_main_risk"
                            placeholder="Aspek Significan "/>
                    </div>
                </div>
                <br />
                <div class="col-md-6">
                    <h5 class="font-semibold"></h4>
                </div>
                <br />
                <div id="sembunyi" class="mb-3 row form-group" >
                    <label for="modal_of_current" class="col-sm-4 col-form-label truncate">Hirarki kendali</label>
                    <div class="col-sm-8">
                        <x-ibprandbowtie-select-2
                            id="modal_of_current"
                            placeholder="Select"
                            :error="'modal_of_current'"
                            wire:model.defer="modal_of_current"
                            >
                                @foreach($ibprHirarki as $hirarki)
                                    <option value="{{$hirarki->name}}">{{$hirarki->name}}</option>
                                @endforeach
                        </x-ibprandbowtie-select-2>
                    </div>
                </div>
                {{-- <div class="mb-3 row form-group ">
                    <label for="effective_control" class="col-sm-4 col-form-label flex">Detail Pengendalian
                        <span class="text-red-600">*</span>

                    </label>
                    <div class="col-sm-8">
                        <x-ibprandbowtie-select-2
                            id="effective_control"
                            placeholder="Select"
                            :error="'effective_control'"
                            wire:model.defer="effective_control"
                            >

                            <option value="Yes">Yes</option>
                            <option value="No">No</option>
                        </x-ibprandbowtie-select-2>
                    </div>
                </div> --}}
                <div class="mb-3 row form-group">
                    <label for="effective_control" class="col-sm-4 col-form-label flex">Detail Pengendalian
                        <span class="text-red-600">*</span>

                    </label>
                    <div class="col-sm-8">
                        <x-inputs.text
                            wire:model.defer="effective_control"
                            id="effective_control"
                            error="effective_control"
                            placeholder="Detail Pengendalian "/>
                    </div>
                </div>
                <br />

            </div>
            <div class="modal-footer w-full flex justify-end footer-action">
              {{-- <div wire:click.stop="push_form" class="bg-[#F5FAF8] cursor-pointer w-full p-3 border_add_modal flex justify-center items-center rounded-md">
                <p class="text-green-700">+ @if(!is_null($index_edit)) Change @else Add @endif form</p>
              </div> --}}
              <div>
                <button type="button" onclick="closeModal()"  class="btn btn-outline-secondary">Cancel</button>
              </div>
              <div>
                <button type="button" wire:click.stop="push_form" class="btn btn-outline-default bg-green align-item-center text-white position-relative px-4">Save activity</button>
              </div>
            </div>

          </div>
        </div>
      </div>
    </div>


@push('scripts')
    <script src="https://code.jquery.com/ui/1.13.2/jquery-ui.js"></script>
    <script>
        window.addEventListener('confirm-delete', () => {
            newSwal.fire({
                title: 'Are you sure?',
                text: "{{ trans('global.confirm_delete') }}",
                icon: 'info',
                showCancelButton: true,
                confirmButtonText: "{{ trans('global.yes') }}" + ' ' + "{{ trans('global.delete') }}",
                cancelButtonText : "{{ trans('global.cancel') }}",
                allowOutsideClick: () => !Swal.isLoading(),
                preConfirm: function(result) {
                    if (result) {
                        return @this.call('submitDelete')
                    }
                },
            });
        });

        function toggle_dropdown_submit(){
            $('#dropdown_submit').toggle();
        }

        function close_dropdown_submit(){
            console.log('tes')
            // $('#dropdown_submit').toggle();
        }

        $(document).ready(function() {
            $('#menu_dropdown').blur(function() {
                alert('The input field lost focus');
            });
        });

        $('#btn-togle-k3').click(function() {
            $('#tooltip_lh').addClass('hidden');
            $('#tooltip_kp').addClass('hidden');
            $('#tooltip_ksl').addClass('hidden');
            $('#tooltip_kk').addClass('hidden');
            $('#tooltip_k3').toggleClass('hidden');
        });

        $('#btn-togle-lh').click(function() {
            $('#tooltip_k3').addClass('hidden');
            $('#tooltip_kp').addClass('hidden');
            $('#tooltip_ksl').addClass('hidden');
            $('#tooltip_kk').addClass('hidden');
            $('#tooltip_lh').toggleClass('hidden');
        });

        $('#btn-togle-kp').click(function() {
            $('#tooltip_k3').addClass('hidden');
            $('#tooltip_lh').addClass('hidden');
            $('#tooltip_ksl').addClass('hidden');
            $('#tooltip_kk').addClass('hidden');
            $('#tooltip_kp').toggleClass('hidden');
        });

        $('#btn-togle-ksl').click(function() {
            $('#tooltip_k3').addClass('hidden');
            $('#tooltip_lh').addClass('hidden');
            $('#tooltip_kk').addClass('hidden');
            $('#tooltip_kp').addClass('hidden');
            $('#tooltip_ksl').toggleClass('hidden');
        });

        $('#btn-togle-kk').click(function() {
            $('#tooltip_k3').addClass('hidden');
            $('#tooltip_lh').addClass('hidden');
            $('#tooltip_kp').addClass('hidden');
            $('#tooltip_ksl').addClass('hidden');
            $('#tooltip_kk').toggleClass('hidden');
        });




        $('#btn-togle-k3-v2').click(function() {
            $('#tooltip_lh-v2').addClass('hidden');
            $('#tooltip_kp-v2').addClass('hidden');
            $('#tooltip_ksl-v2').addClass('hidden');
            $('#tooltip_kk-v2').addClass('hidden');
            $('#tooltip_k3-v2').toggleClass('hidden');
        });

        $('#btn-togle-lh-v2').click(function() {
            $('#tooltip_k3-v2').addClass('hidden');
            $('#tooltip_kp-v2').addClass('hidden');
            $('#tooltip_ksl-v2').addClass('hidden');
            $('#tooltip_kk-v2').addClass('hidden');
            $('#tooltip_lh-v2').toggleClass('hidden');
        });

        $('#btn-togle-kp-v2').click(function() {
            $('#tooltip_k3-v2').addClass('hidden');
            $('#tooltip_lh-v2').addClass('hidden');
            $('#tooltip_ksl-v2').addClass('hidden');
            $('#tooltip_kk-v2').addClass('hidden');
            $('#tooltip_kp-v2').toggleClass('hidden');
        });

        $('#btn-togle-ksl-v2').click(function() {
            $('#tooltip_k3-v2').addClass('hidden');
            $('#tooltip_lh-v2').addClass('hidden');
            $('#tooltip_kk-v2').addClass('hidden');
            $('#tooltip_kp-v2').addClass('hidden');
            $('#tooltip_ksl-v2').toggleClass('hidden');
        });

        $('#btn-togle-kk-v2').click(function() {
            $('#tooltip_k3-v2').addClass('hidden');
            $('#tooltip_lh-v2').addClass('hidden');
            $('#tooltip_kp-v2').addClass('hidden');
            $('#tooltip_ksl-v2').addClass('hidden');
            $('#tooltip_kk-v2').toggleClass('hidden');
        });


        Livewire.on('openModal', (e) => {
            let preliminary_main_risk = $('#preliminary_main_risk').val();
            chooseModaelOfCurrent(preliminary_main_risk);

            $("#staticBackdrop").modal("show");
        });

        function tryToOpenModal() {
            let doc = $('#document_no').val();
            $('#staticBackdropLabel').text(doc);
            $("#staticBackdrop").modal("show");
        }


        function closeModal() {
            $("#staticBackdrop").modal("hide");
        }

        Livewire.on('closeModal', () => {
            $("#staticBackdrop").modal("hide");
        });

        Livewire.on('closeAllToooltip', () => {
            closeAllToooltip();
        });

        function closeAllToooltip() {
            $('#tooltip_k3-v2').addClass('hidden');
            $('#tooltip_lh-v2').addClass('hidden');
            $('#tooltip_kp-v2').addClass('hidden');
            $('#tooltip_ksl-v2').addClass('hidden');
            $('#tooltip_kk-v2').addClass('hidden');
            $('#tooltip_k3').addClass('hidden');
            $('#tooltip_lh').addClass('hidden');
            $('#tooltip_kp').addClass('hidden');
            $('#tooltip_ksl').addClass('hidden');
            $('#tooltip_kk').addClass('hidden');
        }


        $('#preliminary_frequence').on('input', function() {
            // Call your function here
            let preliminary_frequence = $('#preliminary_frequence').val();
            Livewire.emit('event_formula_level_of_risk', preliminary_frequence);
        });

        $('#residual_frequence').on('input', function() {
            // Call your function here
            let residual_frequence = $('#residual_frequence').val();
            Livewire.emit('event_formula_level_of_risk_residual', residual_frequence);
        });

        $(document).ready(function() {
            // Attach a change event handler to the form
            $('#document_no').change(function() {
                // Code to execute when the form value changes
                let val =  $('#document_no').val();
                $('#staticBackdropLabel').text(val);
            });
        });

        Livewire.on('chooseModaelOfCurrent', (preliminary_main_risk) => {
            chooseModaelOfCurrent(preliminary_main_risk);
        });

        $('#staticBackdrop').on('hide.bs.modal', function() {
            Livewire.emit('event_unset_index_edit');
        });

        function chooseModaelOfCurrent(preliminary_main_risk) {
            // if(preliminary_main_risk === 'Ya') {
            //     let options = `
            //         <option value="Interaksi kendaraan">Interaksi kendaraan</option>
            //         <option value="Pengangkatan">Pengangkatan</option>
            //         <option value="Penanganan ban">Penanganan ban</option>
            //         <option value="Bekerja dekat Air">Bekerja dekat Air</option>
            //     `
            //     $('#modal_of_current').empty();
            //     $('#modal_of_current').append(options);
            // }

            // if(preliminary_main_risk === 'Tidak') {
            //     let options = `
            //         <option value="ELIMINASI">ELIMINASI</option>
            //         <option value="SUBSTITUSI">SUBSTITUSI</option>
            //         <option value="TEKNIK REKAYASA">TEKNIK REKAYASA</option>
            //         <option value="ADMINISTRASI">ADMINISTRASI</option>
            //         <option value="ALAT PELINDUNG DIRI">ALAT PELINDUNG DIRI</option>
            //     `
            //     $('#modal_of_current').empty();
            //     $('#modal_of_current').append(options);

            // }
        }

        // $(document).ready(function() {
        //     $(window).on('popstate', function() {
        //         // Redirect the user to a specific page
        //         console.log('tes')
        //         window.history.pushState(null, null, '/testoing');
        //     });
        // });
    </script>
@endpush
