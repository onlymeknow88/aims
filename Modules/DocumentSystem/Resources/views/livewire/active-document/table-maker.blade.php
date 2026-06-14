{{-- @component('document-systems', ['notif' => 1])

@endcomponent --}}
<div x-data="{ itemSelected: @entangle('itemSelected'), info: @entangle('info') }">

    <div class="toolbar-tables border-top border-bottom d-flex justify-content-between p-2">

        <div class="toolbar-left d-flex align-items-center">

            <a href="{{ route('document-systems::active-document.create') }}" type="button"
                class="button-toolbar d-flex gap-2 align-items-center py-2 px-3">
                <span class="icon d-flex align-items-center">
                    <img src="{{ asset('images/icons/add.png') }}" alt="image add">
                </span>
                <span class="text-button">Add New</span>
            </a>
            @if ($countSelected > 0)
                <a href="#" type="button" class="button-toolbar d-flex gap-2 align-items-center py-2 px-3">
                    <span class="icon d-flex align-items-center">
                        <img src="{{ asset('images/icons/export-top.svg') }}" alt="image export">
                    </span>
                    <span class="text-button">Export</span>
                </a>

                <a href="#" type="button" class="button-toolbar d-flex gap-2 align-items-center py-2 px-3">
                    <span class="icon d-flex align-items-center">
                        <img src="{{ asset('images/icons/delete.png') }}" alt="image delete">
                    </span>
                    <span class="text-button">Delete</span>
                </a>
            @endif
        </div><!-- /.toolbar-left -->

        <div class="toolbar-right d-flex align-items-center">

            @if ($countSelected > 0)
                <a href="#" type="button" class="button-toolbar d-flex gap-2 align-items-center py-2 px-3">
                    <span class="icon d-flex align-items-center">
                        <img src="{{ asset('images/icons/delete.png') }}" alt="image delete">
                    </span>
                    <span class="text-button">{{ $countSelected }} Row Selected</span>
                </a>
            @endif

            {{-- <a href="#" type="button" class="button-toolbar d-flex gap-2 align-items-center py-2 px-3">
                <span class="icon d-flex align-items-center">
                    <img src="{{asset('images/icons/sort.png')}}" alt="image add">
                </span>
            </a> --}}
            <button class="dropdown-toggle btn btn-outline-default d-flex text-white position-relative py-2 px-3"
                role="button" data-bs-toggle="dropdown" aria-expanded="false">
                <span class="icon d-flex align-items-center">
                    <img src="{{ asset('images/icons/filter-top.svg') }}" alt="image-filter">
                </span>
            </button>
            <ul class="dropdown-menu">
                <li class="ms-2">
                    <input class="form-check-input" name="selected" type="checkbox" selected="selected"> Title
                </li>
                <li class="ms-2">
                    <input class="form-check-input" name="selected" type="checkbox" selected="selected"> Id Document
                </li>
                <li class="ms-2">
                    <input class="form-check-input" name="selected" type="checkbox" selected="selected"> Company
                </li>
                <li class="ms-2">
                    <input class="form-check-input" name="selected" type="checkbox" selected="selected"> Penanggung
                    Jawab
                </li>
                <li class="ms-2">
                    <input class="form-check-input" name="selected" type="checkbox" selected="selected"> Modul
                </li>
                <li class="ms-2">
                    <input class="form-check-input" name="selected" type="checkbox" selected="selected"> Status
                </li>
            </ul>

            {{-- <a href="#" type="button" class="button-toolbar d-flex gap-2 align-items-center py-2 px-3">
                <span class="icon d-flex align-items-center">
                    <img src="{{asset('images/icons/filter-top.svg')}}" alt="image export">
                </span>
            </a> --}}

            <a href="#" type="button" class="button-toolbar d-flex gap-2 align-items-center py-2 px-3"
                wire:click="activedInfo()">
                <span class="icon d-flex align-items-center">
                    <img src="{{ asset('images/icons/info.png') }}" alt="image info">
                </span>
            </a>

            <a href="#" type="button" class="button-toolbar d-flex gap-2 align-items-center py-2 px-3">
                <span class="icon d-flex align-items-center">
                    <img src="{{ asset('images/icons/menu.png') }}" alt="image menu">
                </span>
            </a>

        </div><!-- /.toolbar-right -->

    </div><!-- /.toolsbar-tables -->

    <div class="table-content table-responsive position-relative overflow-auto d-flex">

        <table class="table">
            <thead>
                <tr>
                    <th></th>
                    <th>Title </th>
                    <th>ID Document</th>
                    <th>Company</th>
                    <th>Department</th>
                    <th>Penanggung Jawab</th>
                    <th>Modul</th>
                    <th>Date Created</th>
                    <th>Status</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($document as $itemIndex => $item)
                    <tr wire:key="{{ $itemIndex }}" wire:click="onSelectedItem({{ $item->id }})">
                        <td>
                            <input class=" form-check-input" name="selected" type="checkbox"
                                value="{{ $item->id }}" id="selected" x-model="itemSelected">
                        </td>
                        <td scope="row">
                            <a href="{{ route('document-systems::active-document.detail', ['id' => $item->id]) }}">
                                {{ $item->title }}
                            </a>
                        </td>
                        <td>{{ \App\Enums\DocumentSystem\DocumentLevel::fromValue($item->document_level)->description }}
                        </td>
                        <td>{{ $item->department->company->company_name }}</td>
                        <td>{{ $item->department->name }}</td>
                        <td>{{ $item->areaManager->user->name }}</td>
                        <td>{{ $item->mapping->category->module->name }}</td>
                        <td>{{ \Carbon\Carbon::parse($item->doc_created)->toFormattedDateString() }}</td>
                        <td>{!! $item->status_badge !!}</td>
                    </tr>
                @endforeach
                {{-- <td colspan='9' align="center">
                    Data Not Found
                </td> --}}
            </tbody>
        </table>

        <div class="info" x-show="info">test</div>

    </div><!-- /.table-content-->

</div>
