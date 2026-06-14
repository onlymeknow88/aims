@if ($detail['filter'])
    @if ($detail['type'] == 'text')
        <tr>
            <td>{{ $column }}</td>
            <td>
                <x-inputs.text
                    wire:model="{{ $detail['model'] }}"
                    id="{{ $detail['model'] }}"
                    error="{{ $detail['model'] }}"
                    placeholder="{{ $column }}"></x-inputs.text>
            </td>
            <td>
                @if ($detail['sortable'])
                    <select class="btn-group dropdown multi-sort-order form-control"
                        wire:model="{{ $detail['model'] }}_sort"
                        id="{{ $detail['model'] }}_sort">
                        <option value="ASC">A - Z</option>
                        <option value="DESC">Z - A</option>
                    </select>
                @endif
            </td>
        </tr>
    @endif

    @if ($detail['type'] == 'select')
        <tr>
            <td>{{ $column }}</td>
            <td>
                <x-document-system-select-2
                    wire:model="{{ $detail['model'] }}"
                    id="{{ $detail['model'] }}"
                    error="{{ $detail['model'] }}">

                    <option value=""></option>
                    @foreach ($detail['option'] as $item)
                        <option value="{{ $item['id'] }}">
                            {{$item['name']}}
                        </option>
                    @endforeach

                </x-document-system-select-2>
            </td>
            <td>
                @if ($detail['sortable'])
                    <select class="btn-group dropdown multi-sort-order form-control"
                        wire:model="{{ $detail['model'] }}_sort"
                        id="{{ $detail['model'] }}_sort">
                        <option value="ASC">A - Z</option>
                        <option value="DESC">Z - A</option>
                    </select>
                @endif
            </td>
        </tr>
    @endif
@endif
