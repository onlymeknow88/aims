<div x-data="{ itemSelected: @entangle('itemSelected'), info: @entangle('info') }">
 
    <div class="toolbar-tables border-top border-bottom d-flex justify-content-between p-2 sticky-top">

        <div class="toolbar-left d-flex align-items-center">

            @if($countSelected > 0 )

            <a href="#" type="button" class="button-toolbar d-flex gap-2 align-items-center py-2 px-3">
                <span class="icon d-flex align-items-center"><img src="{{asset('images/icons/export.png')}}" alt="image export"></span>
                <span class="text-button">Export</span>
            </a>

            @endif
        </div><!-- /.toolbar-left -->

        <div class="toolbar-right d-flex align-items-center"> 

            @if($countSelected > 0 )
                <a href="#" type="button" class="button-toolbar d-flex gap-2 align-items-center py-2 px-3" wire:click="removeSeleced()">
                    <span class="icon d-flex align-items-center"><img src="{{asset('images/icons/delete.png')}}" alt="image delete"></span>
                    <span class="text-button">{{ $countSelected }} Row Selected</span>
                </a>
            @endif

            <a href="#" type="button" class="button-toolbar d-flex gap-2 align-items-center py-2 px-3">
                <span class="icon d-flex align-items-center"><img src="{{asset('images/icons/sort.png')}}" alt="image sort"></span>
            </a>

            <a href="#" type="button" class="button-toolbar d-flex gap-2 align-items-center py-2 px-3">
                <span class="icon d-flex align-items-center"><img src="{{asset('images/icons/filter.png')}}" alt="image export"></span>
            </a>

            <a href="#" type="button" class="button-toolbar d-flex gap-2 align-items-center py-2 px-3" wire:click="activedInfo()">
                <span class="icon d-flex align-items-center"><img src="{{asset('images/icons/info.png')}}" alt="image info"></span>
            </a>

            <a href="#" type="button" class="button-toolbar d-flex gap-2 align-items-center py-2 px-3">
                <span class="icon d-flex align-items-center"><img src="{{asset('images/icons/menu.png')}}" alt="image menu"></span>
            </a>

        </div><!-- /.toolbar-right -->
        
    </div><!-- /.toolsbar-tables -->

    <div class="table-content table-responsive position-relative" :class="info ? 'infoOpen' : ''">

        <div class="table-wrapper">

            <table class="table overflow-auto">
                <thead>
                    <tr>
                        <th></th>
                        <th>Title</th>
                        <th>Date Created</th>
                        <th>Status</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($document as $itemIndex => $item)
                        <tr wire:key="{{ $itemIndex }}" wire:click="onSelectedItem({{ $item->id }})">
                            <td class="td-check">
                                @if(in_array($item->id, $itemSelected))
                                    <span class="icon-checked selected"></span>
                                @else
                                    <span class="icon-checked"></span>                                    
                                @endif

                            </td>                          
                            <td>
                                <a href="{{ route('document-systems::review-detail', ['id' => $item->id]) }}">
                                    {{ $item->title }}
                                </a>
                            </td>
                            <td>{{ date('Y-m-d H:i:s') }}</td>
                            <td>{!! $item->status_badge !!}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table><!-- table -->
        </div><!-- /.table-wrapper -->

        <div class="info bg-white px-3" x-show="info">

            <livewire:document-systems.approval.sidebar-info />

        </div><!-- /.info -->   

    </div><!-- /.table-content-->

    
</div>

