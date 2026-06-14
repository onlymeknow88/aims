@section('title')
    Department Code
@endsection

<div x-data="{ itemSelected: @entangle('itemSelected'), info: @entangle('info') }">

    <div class="toolbar-tables border-top border-bottom d-flex justify-content-between p-2 sticky-top">

        <div class="toolbar-left d-flex align-items-center">

            <div class="dropdown">
                <a href="#" type="button" class="button-toolbar d-flex gap-2 align-items-center py-2 px-3"
                    onclick="getCodes()" data-bs-toggle="dropdown" aria-expanded="false" data-bs-auto-close="outside">
                    <span class="icon d-flex align-items-center"><img src="{{ asset('images/icons/add.png') }}"
                            alt="image add"></span>
                    <span class="text-button">Add New </span>
                </a>

                <form class="dropdown-menu p-4 form-dropdown">
                    {{-- <input type="text" placeholder="Search.." id="input-text-dropdown" onkeyup="filterCode()"> --}}
                    <table class="table">
                        @foreach ($codes as $list)
                            <tr wire:click="selectAddCode('{{ $list->id }}')">
                                <td> {{ $list->code }}</td>
                            </tr>
                        @endforeach
                    </table>
                </form>
            </div>

            <a type="button" class="button-toolbar d-flex gap-2 align-items-center py-2 px-3"
                wire:click="confirmSelectedUpdate">
                <span class="icon d-flex align-items-center"><img src="{{ asset('images/icons/delete.png') }}"
                        alt="image delete"></span>
                <span class="text-button">Delete</span>
            </a>

        </div><!-- /.toolbar-left -->

        <div class="toolbar-right d-flex align-items-center">

        </div><!-- /.toolbar-right -->

    </div><!-- /.toolsbar-tables -->

    <div class="table-content ">
        <div class="table-wrapper">
            <table class="table table-document">
                <thead>
                    <tr class="bg-white">
                        <th></th>
                        <th>Code</th>
                    </tr>
                </thead>
                <tbody>
                    @if (count($data) > 0)
                        @foreach ($data as $index => $list)
                            <tr>
                                <td class="td-check" wire:key="{{ $index }}"
                                    wire:click="SelectRow('{{ $list->id }}')">
                                    @if (in_array($list['id'], $itemSelected))
                                        <span class="icon-checked selected"></span>
                                    @else
                                        <span class="icon-checked"></span>
                                    @endif
                                </td>
                                <td>{{ $list->code }} </td>
                        @endforeach
                    @else
                        <tr>
                            <td colspan="9" class="text-center">@lang('global.empty_data')</td>
                        </tr>
                    @endif
                </tbody>
            </table>

        </div><!-- /.table-wrapper -->

    </div><!-- /.table-content-->

    {{-- @livewire('sap::setup.create') --}}

</div>

<style>
    .form-dropdown {
        height: 300px;
        overflow-y: scroll
    }

    .table {
        width: 100%;
    }

    table th,
    table td {
        white-space: unset;
        position: unset;
    }
</style>


@push('scripts')
    <script>
        //Livewire.on('clearEmailInput', () => {
        //    $('input#invited_people').val('').focus()
        //})

        function selectGrade(event) {
            var x = event.target;
            if (x) {
                var value = x.value;
                var grade_code = x.options[x.selectedIndex].dataset.code;
                console.log(value);
                console.log(grade_code);
                @this.set('input.grade_code', grade_code);
            }
        }
    </script>
@endpush
