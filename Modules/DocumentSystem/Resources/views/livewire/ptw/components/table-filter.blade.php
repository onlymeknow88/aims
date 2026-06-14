@if ($detail['filter'])
    @if ($detail['type'] == 'text')

        <div class="form-group row mb-2">
            <label for="" class="col-form-label col-md-4">{{ $column }}</label>
            <div class="col-md-6">
                <x-inputs.text wire:model.defer="{{ $detail['model'] }}" name="{{ $detail['model'] }}"
                    id="{{ $detail['model'] }}" error="{{ $detail['model'] }}" placeholder="{{ $column }}">
                </x-inputs.text>
            </div>
            @if ($detail['sortable'])
                <div class="col-md-2">
                    <select class="btn-group dropdown multi-sort-order form-control" name="{{ $detail['model'] }}_sort"
                        id="{{ $detail['model'] }}_sort">
                        <option value="ASC">A - Z</option>
                        <option value="DESC">Z - A</option>
                    </select>
                </div>
            @endif
        </div>
    @endif

    @if ($detail['type'] == 'select')

        <div class="form-group row mb-2">
            <label for="" class="col-form-label col-md-4">{{ $column }}</label>
            <div class="col-md-6" wire:ignore>
                <x-document-system-select-2 wire:model.defer="{{ $detail['model'] }}" id="{{ $detail['model'] }}"
                    error="{{ $detail['model'] }}" name="{{ $detail['model'] }}" parent="sortModal_table"
                    :disableChange="false">

                    @foreach ($detail['option'] as $item)
                        <option value="{{ $item['id'] }}">
                            {{ $item['name'] }}
                        </option>
                    @endforeach

                </x-document-system-select-2>
            </div>
            @if ($detail['sortable'])
                <div class="col-md-2">
                    <select class="btn-group dropdown multi-sort-order form-control" name="{{ $detail['model'] }}_sort"
                        id="{{ $detail['model'] }}_sort">
                        <option value="ASC">A - Z</option>
                        <option value="DESC">Z - A</option>
                    </select>
                </div>
            @endif
        </div>
    @endif
@endif
