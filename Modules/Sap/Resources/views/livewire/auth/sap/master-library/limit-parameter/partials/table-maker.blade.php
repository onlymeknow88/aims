<div x-data="{ itemSelected: @entangle('itemSelected'), info: @entangle('info') }">

    <div class="toolbar-tables border-top border-bottom d-flex justify-content-between p-2">

        <div class="toolbar-left d-flex align-items-center">

            @if (count($this->parameters) == 0)
                <a href="#" type="button" class="button-toolbar d-flex gap-2 align-items-center py-2 px-3"
                    data-bs-toggle="modal" data-bs-target="#FLParameterModal">
                    <span class="icon d-flex align-items-center"><img src="{{ asset('images/icons/add.png') }}"
                            alt="image add"></span>
                    <span class="text-button">Add New</span>
                </a>
            @endif

            @if ($countSelected > 0)
                <a href="#" type="button" class="button-toolbar d-flex gap-2 align-items-center py-2 px-3">
                    <span class="icon d-flex align-items-center"><img src="{{ asset('images/icons/export.png') }}"
                            alt="image export"></span>
                    <span class="text-button">Export</span>
                </a>

                <a href="#" type="button" class="button-toolbar d-flex gap-2 align-items-center py-2 px-3"
                    wire:click="$emit('remove-item')">
                    <span class="icon d-flex align-items-center"><img src="{{ asset('images/icons/delete.png') }}"
                            alt="image delete"></span>
                    <span class="text-button">Delete</span>
                </a>
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

            <a href="#" type="button" class="button-toolbar d-flex gap-2 align-items-center py-2 px-3">
                <span class="icon d-flex align-items-center"><img src="{{ asset('images/icons/sort.png') }}"
                        alt="image add"></span>
            </a>

            <a href="#" type="button" class="button-toolbar d-flex gap-2 align-items-center py-2 px-3">
                <span class="icon d-flex align-items-center"><img src="{{ asset('images/icons/filter.png') }}"
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
            </a>

        </div><!-- /.toolbar-right -->

    </div><!-- /.toolsbar-tables -->

    <div class="table-content table-responsive position-relative overflow-auto d-flex">

        <table class="table">
            <thead>
                <tr>
                    <th></th>
                    <th>Max Item Member</th>
                    <th>Max Item Positive Condition</th>
                    <th>Max Item Risk Condition</th>
                    <th>Max Item Corrective Action</th>
                    <th>Date Created</th>
                    {{-- <th>Action</th> --}}
                </tr>
            </thead>
            <tbody>
                @foreach ($this->parameters as $itemIndex => $items)
                    <tr wire:key="{{ $itemIndex }}" wire:click="onSelectedItem('{{ $items->id }}')">
                        <td class="td-check">
                            @if (in_array($items->id, $itemSelected))
                                <span class="icon-checked selected"></span>
                            @else
                                <span class="icon-checked"></span>
                            @endif
                        </td>
                        <td scope="row" wire:click="edit('{{ $items->id }}')">
                            {{ $items->max_item_member }}
                        </td>
                        <td scope="row" wire:click="edit('{{ $items->id }}')">
                            {{ $items->max_item_positive_condition }}
                        </td>
                        <td scope="row" wire:click="edit('{{ $items->id }}')">
                            {{ $items->max_item_risk_condition }}
                        </td>
                        <td scope="row" wire:click="edit('{{ $items->id }}')">
                            {{ $items->max_item_corrective_action }}
                        </td>
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

        <div class="info" x-show="info">test</div>

    </div><!-- /.table-content-->

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
