<div x-data="{ itemSelected: @entangle('itemSelected'), info: @entangle('info') }">

    <div class="toolbar-tables border-top border-bottom d-flex justify-content-between p-2">

        <div class="toolbar-left d-flex align-items-center">

            <a href="#" type="button" class="button-toolbar d-flex gap-2 align-items-center py-2 px-3 add-new"
                data-bs-toggle="modal" data-bs-target="#FLCategoryModal">
                <span class="icon d-flex align-items-center">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                        stroke="currentColor" class="w-6 h-6">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15" />
                    </svg>
                </span>
                <span class="text-button">Add New</span>
            </a>
            @if ($countSelected > 0)
                <a href="#" type="button" class="button-toolbar d-flex gap-2 align-items-center py-2 px-3">
                    <span class="icon d-flex align-items-center"><img src="{{ asset('images/icons/export-top.svg') }}"
                            alt="image export"></span>
                    <span class="text-button">Export</span>
                </a>

                <a href="#" type="button" class="button-toolbar d-flex gap-2 align-items-center py-2 px-3"
                    wire:click="$emit('remove-item')">
                    <span class="icon d-flex align-items-center"><img src="{{ asset('images/icons/delete-top.svg') }}"
                            alt="image delete"></span>
                    <span class="text-button">Delete</span>
                </a>
            @endif
        </div><!-- /.toolbar-left -->

        <div class="toolbar-right d-flex align-items-center">

            @if ($countSelected > 0)
                <a href="#" type="button" class="button-toolbar d-flex gap-2 align-items-center py-2 px-3"
                    wire:click="removeSeleced()">
                    <span class="icon d-flex align-items-center"><img src="{{ asset('images/icons/delete-top.svg') }}"
                            alt="image delete"></span>
                    <span class="text-button">{{ $countSelected }} Row Selected</span>
                </a>
            @endif

            {{-- <a href="#" type="button" class="button-toolbar d-flex gap-2 align-items-center py-2 px-3">
                <span class="icon d-flex align-items-center"><img src="{{ asset('images/icons/sort.png') }}"
                        alt="image add"></span>
            </a>

            <a href="#" type="button" class="button-toolbar d-flex gap-2 align-items-center py-2 px-3">
                <span class="icon d-flex align-items-center"><img src="{{ asset('images/icons/filter-top.svg') }}"
                        alt="image export"></span>
            </a>

            <a href="#" type="button" class="button-toolbar d-flex gap-2 align-items-center py-2 px-3"
                wire:click="activedInfo()">
                <span class="icon d-flex align-items-center"><img src="{{ asset('images/icons/info.png') }}"
                        alt="image info"></span>
            </a>

            <a href="#" type="button" class="button-toolbar d-flex gap-2 align-items-center py-2 px-3">
                <span class="icon d-flex align-items-center"><img src="{{ asset('images/icons/menu.png') }}"
                        alt="image menu"></span>
            </a> --}}

        </div><!-- /.toolbar-right -->

    </div><!-- /.toolsbar-tables -->

    <div class="table-content table-responsive position-relative">

        <div class="table-wrapper overflow-auto">

            <table class="table" style="height: fit-content">
                <thead>
                    <tr @if ($selectAll) class="selected" @else class="tr" @endif>
                        <th class="sticky-top" wire:click="toggleSelectAll">
                            <span class="icon-checked"></span>
                        </th>
                        <th class="sticky-top">Title</th>
                        <th class="sticky-top">Date Created</th>
                        {{-- <th>Action</th> --}}
                    </tr>
                </thead>
                <tbody>
                    @foreach ($this->categories as $itemIndex => $items)
                        <tr wire:key="{{ $itemIndex }}" wire:click="onSelectedItem('{{ $items->id }}')"
                            @if (in_array($items->id, $itemSelected)) class="selected" @else class="tr" @endif>
                            <td class="td-check">
                                <span class="icon-checked"></span>
                            </td>
                            <td scope="row" wire:click="edit('{{ $items->id }}')">{{ $items->name }}</td>
                            <td>{{ Carbon\Carbon::parse($items->created_at)->format('F d, Y') }}</td>
                            {{-- <td>
                            <a href="#" class="action-icon" wire:click="edit('{{ $items->id }}')">
                                <i class="fa fa-edit"></i> Edit
                            </a>
                        </td> --}}
                        </tr>
                    @endforeach
                </tbody>
            </table>
            {{-- <div class="info" x-show="info">test</div> --}}
        </div>
    </div><!-- /.table-content-->

    <div class="section-footer d-flex justify-content-between sticky-bottom bg-white align-items-center h-60px">
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

    </div><!-- /.section-footer -->

</div>

@push('scripts')
    <script type="text/javascript">
        document.addEventListener('DOMContentLoaded', function() {

            @this.on('remove-item', () => {
                Swal.fire({
                    title: 'Are You Sure?',
                    text: 'Yakin akan menghapus data ini?',
                    icon: "warning",
                    showCancelButton: true,
                    confirmButtonText: 'Hapus'
                }).then((result) => {

                    if (result.value) {

                        @this.call('removeItem')

                    }

                });
            });
        });
    </script>
@endpush
