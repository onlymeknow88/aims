<div x-data="{ itemSelected: @entangle('itemSelected'), info: @entangle('info') }">

    <div class="toolbar-tables border-top border-bottom d-flex justify-content-between p-2">

        <div class="toolbar-left d-flex align-items-center">
            @can('rule-maker')
            <a href="{{ route('kpp::rules.create') }}" type="button" class="button-toolbar d-flex gap-2 align-items-center py-2 px-3">
                <span class="icon d-flex align-items-center"><img src="{{asset('images/icons/add.png')}}" alt="image add"></span>
                <span class="text-button">Add New</span>
            </a>
            @endcan
            @if($countSelected > 0 )
            <a href="#" type="button" class="button-toolbar d-flex gap-2 align-items-center py-2 px-3">
                <span class="icon d-flex align-items-center"><img src="{{asset('images/icons/export.png')}}" alt="image export"></span>
                <span class="text-button">Export</span>
            </a>

            <a href="#" type="button" class="button-toolbar d-flex gap-2 align-items-center py-2 px-3">
                <span class="icon d-flex align-items-center"><img src="{{asset('images/icons/delete.png')}}" alt="image delete"></span>
                <span class="text-button">Delete</span>
            </a>
            @endif
        </div><!-- /.toolbar-left -->

        <div class="toolbar-right d-flex align-items-center"> 

            @if($countSelected > 0 )
                <a href="#" type="button" class="button-toolbar d-flex gap-2 align-items-center py-2 px-3">
                    <span class="icon d-flex align-items-center"><img src="{{asset('images/icons/delete.png')}}" alt="image delete"></span>
                    <span class="text-button">{{ $countSelected }} Row Selected</span>
                </a>
            @endif

            <a href="#" type="button" class="button-toolbar d-flex gap-2 align-items-center py-2 px-3">
                <span class="icon d-flex align-items-center"><img src="{{asset('images/icons/sort.png')}}" alt="image add"></span>
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

    <div class="table-content table-responsive position-relative overflow-auto d-flex">
  
        <table class="table">
            <thead>
                <tr>
                    <th></th>
                    <th>Number</th>
                    <th>Title</th>
                    <th>Jenis</th>
                    <th>Department</th>
                    <th>Approval Date</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($dataTables as $itemIndex => $item)
                
                    <tr wire:key="{{ $itemIndex }}" wire:click="onSelectedItem({{ $item['id'] }})"">
                        <td><input class="form-check-input" name="selected" type="checkbox" value="{{$item['id']}}" id="selected" x-model="itemSelected" ></td>                          
                        <td scope="row">
                            <a href="{{ route('kpp::rules.detail', ['id' => $item->id]) }}">
                                {{ $item->number }}
                            </a>
                        </td>
                        <td>{{$item->title}}</td>
                        <td>{{$item->type->name ?? '-'}}</td>
                        <td>{{$item->agencyAuthority->name ?? '-'}}</td>
                        <td>{{$item->approved_date}}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>

        <div class="info" x-show="info">test</div>

    </div><!-- /.table-content-->

</div>
