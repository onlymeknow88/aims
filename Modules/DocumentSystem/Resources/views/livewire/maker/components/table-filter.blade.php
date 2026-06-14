@if ($detail['filter'])
    @if ($detail['type'] == 'text')
        {{-- <tr>
            <td>{{ $column }}</td>
            <td>
                <x-inputs.text
                    name="{{ $detail['model'] }}"
                    id="{{ $detail['model'] }}"
                    error="{{ $detail['model'] }}"
                    placeholder="{{ $column }}"></x-inputs.text>
            </td>
            <td>
                @if ($detail['sortable'])
                    <select class="btn-group dropdown multi-sort-order form-control"
                        name="{{ $detail['model'] }}_sort"
                        id="{{ $detail['model'] }}_sort">
                        <option value="ASC">A - Z</option>
                        <option value="DESC">Z - A</option>
                    </select>
                @endif
            </td>
        </tr> --}}

        <div class="form-group row mb-2">
            <label for="" class="col-form-label col-md-4">{{ $column }}</label>
            <div class="col-md-6">
                <x-inputs.text
                    name="{{ $detail['model'] }}"
                    id="{{ $detail['model'] }}"
                    error="{{ $detail['model'] }}"
                    placeholder="{{ $column }}"></x-inputs.text>
            </div>
            @if ($detail['sortable'])
                <div class="col-md-2">
                    <select class="btn-group dropdown multi-sort-order form-control"
                        name="{{ $detail['model'] }}_sort"
                        id="{{ $detail['model'] }}_sort">
                        <option value="ASC">A - Z</option>
                        <option value="DESC">Z - A</option>
                    </select>
                </div>
            @endif
        </div>
    @endif

    @if ($detail['type'] == 'select')
        {{-- <tr wire:ignore>
            <td>{{ $column }}</td>
            <td>
                <x-inputs.select2
                    wire:model.defer='{{ $detail["model"] }}'
                    id="{{ $detail['model'] }}"
                    error="{{ $detail['model'] }}"
                    name="{{ $detail['model'] }}"
                    parent="sortModal_table"
                    :disableChange='false'>

                    <option value=""></option>
                    @foreach ($detail['option'] as $item)
                        <option value="{{ $item['id'] }}">
                            {{$item['name']}}
                        </option>
                    @endforeach

                </x-inputs.select2>
            </td>
            <td>
                @if ($detail['sortable'])
                    <select class="btn-group dropdown multi-sort-order form-control"
                        name="{{ $detail['model'] }}_sort"
                        id="{{ $detail['model'] }}_sort">
                        <option value="ASC">A - Z</option>
                        <option value="DESC">Z - A</option>
                    </select>
                @endif
            </td>
        </tr> --}}

        <div class="form-group row mb-2">
            <label for="" class="col-form-label col-md-4">{{ $column }}</label>
            <div class="col-md-6" wire:ignore>
                <x-inputs.select2
                    wire:model.defer='{{ $detail["model"] }}'
                    id="{{ $detail['model'] }}"
                    error="{{ $detail['model'] }}"
                    name="{{ $detail['model'] }}"
                    parent="sortModal_table"
                    :disableChange='false'>

                    @foreach ($detail['option'] as $item)
                        <option value="{{ $item['id'] }}">
                            {{$item['name']}}
                        </option>
                    @endforeach

                </x-inputs.select2>
            </div>
            @if ($detail['sortable'])
                <div class="col-md-2">
                    <select class="btn-group dropdown multi-sort-order form-control"
                        name="{{ $detail['model'] }}_sort"
                        id="{{ $detail['model'] }}_sort">
                        <option value="ASC">A - Z</option>
                        <option value="DESC">Z - A</option>
                    </select>
                </div>
            @endif
        </div>
    @endif
@endif
