<x-slot name="sidebar">
    @include('audit::livewire.layouts.sidebar')
</x-slot>
<div class="inner-content">
    @include('audit::livewire.layouts.breadcrumb',[
     'trees'=>[
        ['name' => 'Audit','url'=>route('audit::dashboard')],
        ['name'=>'ISO45001'],
     ]
 ])
    <div class="section-content p-3">
        <div class="title-form text-center mb-3 p-2">
            <h3>AUDIT ISO45001</h3>
        </div><!-- /.title-form -->
        <div class="table-maker"> 
             <div x-data="{ itemSelected: @entangle('itemSelected'), info: @entangle('info') }">

                <div class="toolbar-tables border-top border-bottom d-flex justify-content-between p-2">

                    <div class="toolbar-left d-flex align-items-center">
                       

                        <a href="{{ route('audit::iso45001.create') }}" type="button"
                            class="button-toolbar d-flex gap-2 align-items-center py-2 px-3">
                            <span class="icon d-flex align-items-center">
                                <img src="{{asset('images/icons/add.png')}}" alt="image add">
                            </span>
                            <span class="text-button">Add New</span>
                        </a>  
                        
                        @if($countSelected > 0 ) 
                       <!-- <a href="#" 
                            type="button" class="button-toolbar d-flex gap-2 align-items-center py-2 px-3"> 
                            <span class="icon d-flex align-items-center">
                                <img src="{{asset('images/icons/export.png')}}" alt="image export">
                            </span>
                            <span class="text-button">Export</span>
                        </a> -->

                        <a href="#" 
                            wire:click.prevent="confirmBulkDelete()"
                            type="button" class="button-toolbar d-flex gap-2 align-items-center py-2 px-3">
                            <span class="icon d-flex align-items-center">
                                <img src="{{asset('images/icons/delete.png')}}" alt="image delete">
                            </span>
                            <span class="text-button">Delete</span>
                        </a>
                        @endif
                    </div><!-- /.toolbar-left -->

                    
                </div><!-- /.toolsbar-tables -->
                <div class="table-responsive position-relative overflow-auto d-flex">

                    <table class="table">
                        <thead>
                        <tr>
                            <th style="width: 2%;" rowspan="2"></th>
                            <th rowspan="2">Nomor Audit</th>
                            <th rowspan="2">Nama Perusahaan</th>
                            <th rowspan="2">Tim Auditor</th>
                            <th rowspan="2">Tanggal Audit</th>
                            <th rowspan="2">Jenis Audit</th>
                            <th>
                                <table class="table p-0 m-0">
                                    <tr>
                                        <th colspan="3" class="text-center">Kategori Temuan Audit</th>
                                    </tr>
                                    <tr>
                                        <th> Sesuai</th>
                                        <th> Tidak Sesuai</th>
                                        <th> Tidak Berhubungan</th>
                                    </tr>
                                </table>
                            </th>
                            <th rowspan="2"> Persentase Nilai Audit</th>
                            <th rowspan="2">Status Laporan</th>
                        </tr>
                        </thead>
                        <tbody>
                        @forelse($this->lists as $itemIndex => $list)
                            <tr wire:key="{{ $itemIndex }}" wire:click="onSelectedItem('{{ $list->id }}')">
                                <!-- <td>{{++$startNumber}}</td> -->
                                <td>
                                    <input 
                                        class="form-check-input" 
                                        name="selected" type="checkbox" 
                                        value="{{ $list->id }}"
                                        id="selected" x-model="itemSelected">
                                </td>
                                <td><a href="{{route('audit::iso45001.detail.index',['id'=>$list->id])}}"
                                       style="text-decoration: underline;">{{$list->audit_number}}</a></td>
                                <td>{{$list->company->company_name}}</td>
                                <td>
                                    <ul class="mb-0">
                                        @foreach($list->auditors as $auditor)
                                            <li>{{$auditor->name." ( ".$auditor->role->name." )"}}</li>

                                        @endforeach


                                    </ul>
                                </td>
                                <td>{{$list->created_at->translatedFormat('d M Y')}}</td>
                                <td>{{$list->audit_type}}</td>
                                <td>
                                    <table class="table m-0 p-0 table-borderless">
                                        <tr>
                                            <td colspan="3"></td>
                                        </tr>
                                        <tr>
                                            <td>{{$list->critical}}</td>
                                            <td>{{$list->mayor}}</td>
                                            <td>{{$list->minor}}</td>
                                        </tr>
                                    </table>
                                </td>

                                <td>{{$list->percent}}</td>
                                <td>{{$list->status}}</td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="9" class="text-center">@lang('global.no_entry_found')</td>
                            </tr>
                        @endforelse
                        </tbody>
                        
                    </table>

                </div><!-- /.table-wrapper -->

            </div>


        </div><!-- /.table-maker -->
    </div>
</div>
@push('styles')
    <style>
        table.table#table-smkp th {
            padding: 2px 1rem !important;
        }

        table.table#table-smkp th > table tr:last-child > th {
            border-bottom: none !important;
        }
    </style>
@endpush

@push('scripts')
    <script>
        window.addEventListener('confirmBulkDelete', () => {
            newSwal.fire({
                title: "{{ trans('global.bulk_confirmation') }}",
                text: "{{ trans('global.confirm_delete') }}",
                icon: 'info',
                showCancelButton: true,
                confirmButtonText: "{{ trans('global.yes') }}" + ' ' + "{{ trans('global.delete') }}",
                cancelButtonText : "{{ trans('global.cancel') }}",
                allowOutsideClick: () => !Swal.isLoading(),
                preConfirm: function(result) {
                    if (result) {
                        return @this.call('submitBulkDelete')
                    }
                },
            });
        });
    </script>

@endpush
