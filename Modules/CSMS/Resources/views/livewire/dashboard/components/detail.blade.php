<div class="container-spinner container-detail rounded-2 p-3">

    @if (count($data['data']) == 0)
        <div class="spinner spinner-border" role="status">
            <span class="visually-hidden">Loading...</span>
        </div>
    @endif

    <label class="text-secondary">YTD</label>

    <div class="detail-count">
        {{ $data['ytd'] != '' ? $data['ytd'] : '-' }}
    </div>


    <div class="row">
        @foreach ($data['data'] as $list)
            <div class="col-sm-6">

                <table class="detail-table">
                    <thead>
                        <tr>
                            @if ($list['name_b'])
                                <td colspan="2">{{ $list['name_a'] }}</td>
                                <td colspan="2">{{ $list['name_b'] }}</td>
                            @else
                                <td colspan="4">{{ $list['name_a'] }}</td>
                            @endif
                        </tr>
                    </thead>

                    <tbody>
                        <tr>
                            <td>{{ $list['a1'] }}</td>
                            <td>
                                @if ($list['a2_mark'] == 'up')
                                    <span class="icon text-success"><i class="fa-solid fa-caret-up"></i></span>
                                @elseif ($list['a2_mark'] == 'down')
                                    <span class="icon text-danger"><i class="fa-solid fa-caret-down"></i></span>
                                @endif

                                @if ($list['a1'] != '')
                                    <span class="text-secondary">{{ $list['a3'] }}%</span>
                                    <span class="text-secondary">VS LY</span>
                                @endif
                            </td>
                            <td>{{ $list['b1'] }}</td>
                            <td>
                                @if ($list['b2_mark'] == 'up')
                                    <span class="icon text-success"><i class="fa-solid fa-caret-up"></i></span>
                                @elseif ($list['b2_mark'] == 'down')
                                    <span class="icon text-danger"><i class="fa-solid fa-caret-down"></i></span>
                                @endif

                                @if ($list['b1'] != '')
                                    <span class="text-secondary">{{ $list['b3'] }}%</span>
                                    <span class="text-secondary">VS LY</span>
                                @endif
                            </td>
                        </tr>
                    </tbody>

                </table>

            </div>
        @endforeach
    </div>

</div>

@push('styles')
    <style>
        .detail-table {
            width: 100%
        }

        .detail-table th,
        .detail-table td {
            white-space: unset;
            position: unset;
            padding: 5px !important;
            margin: 0px !important;
            height: 45px;
            border-bottom: 1px solid transparent;
            color: gray;
        }
    </style>
@endpush
