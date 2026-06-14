<x-slot name="sidebar">
    @include('audit::livewire.layouts.sidebar')
</x-slot>
<div class="inner-content">
    @include('audit::livewire.layouts.breadcrumb',[
     'trees'=>[
         ['name'=>'Mandays'],
     ]
 ])

 <div class="section-content p-3">
        <div class="table-maker">
            <div class="toolbar-tables border-top border-bottom d-flex justify-content-between p-2 sticky-top">
                <div class="toolbar-right d-flex align-items-center">
                    <a
                            href="{{route('audit::smkp.mandays.create')}}"
                            class="button-toolbar d-flex gap-2 align-items-center py-2 px-3 bg-success text-white">
                        <span class="text-button">Buat Mandays</span>
                    </a>


                </div><!-- /.toolbar-left -->

                <div class="toolbar-right d-flex align-items-center">


                </div><!-- /.toolbar-right -->

            </div><!-- /.toolbar-tables -->

            <div class="table-content table-responsive position-relative">

                <div class="table-wrapper">

                    <table class="table overflow-auto" id="table-mandays">
                        <thead>
                        <tr>
                            <th style="width: 5%;" rowspan="2">No</th>
                            <th rowspan="2">Jumlah Tenaga Kerja (Orang) </th>
                            <th colspan="3" class="text-center">Jumlah Hari Kerja Auditor</th>
                               
                            </th>
                            <th rowspan="2">Action</th>
                        </tr>
                        <tr>
                            <th>Risiko Tinggi</th>
                            <th>Risiko Menegah</th>
                            <th>Risiko Rendah</th>
                        </tr>
                        </thead>
                        <tbody>
                        @forelse($this->lists as $list)
                            <tr>
                                <td>{{++$startNumber}}</td>
                                <td>{{$list->minimum_people}} - {{$list->maximum_people}}</td>
                                
                                <td>{{$list->severities[0]->pivot->value}}</td>
                                <td>{{$list->severities[1]->pivot->value}}</td>
                                <td>{{$list->severities[2]->pivot->value}}</td>
                                <td> 
                               
                                <a href="{{ route('audit::smkp.mandays.edit', $list->id) }}" 
                                    type="button" 
                                    class="btn btn-secondary btn-sm"><i
                                    class="fa fa-pencil"></i></a>
                                    <button type="button"   
                                        class="btn btn-danger btn-sm"><i
                                        class="fa fa-trash"
                                        wire:click="delete('{{$list->id}}')"></i> 
                                    </button>
                                </td>

                            </tr>
                        @empty
                            <tr>
                                <td colspan="9" class="text-center">@lang('global.no_entry_found')</td>
                            </tr>
                        @endforelse
                        </tbody>
                    </table>

                    <nav class="mt-5" aria-label="Page navigation example">
                    {{ $this->lists->links() }}
                    </nav>
                    
                </div><!-- /.table-wrapper -->

            </div><!-- /.table-content-->

        </div><!-- /.table-maker -->
      
    </div>
</div>

@push('styles')
    <style>
        table.table#table-mandays th {
            padding: 2px 1rem !important;
        }

        table.table#table-mandays th > table tr:last-child > th {
            border-bottom: none !important;
        }
    </style>
@endpush
