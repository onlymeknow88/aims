@php
    $data = $data['data'];
    $monthly = $data['monthly'];
@endphp

<div>

    <div class="p-2">
        <div class="container-spinner ">

            {{-- <div class="spinner-center spinner-border" role="status" wire:loading>
                <span class="visually-hidden">Loading...</span>
            </div> --}}

            @foreach ($monthly as $month)
                <div>
                    <span> <b>PENCAPAIAN {{ strtoupper($month['month']) }}
                            {{ $data['year_now'] }}</b></span>
                </div>
                <div class="table-responsive">
                    <table class="table table-bordered table-grafik">
                        <tr>
                            <th></th>
                            @foreach ($month['data'] as $index => $list)
                                <th>{{ $index }}</th>
                            @endforeach
                        </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>Target Dept</td>
                                @foreach ($month['data'] as $index => $list)
                                    <td>{{ $list['target_dept'] }}</td>
                                @endforeach
                            </tr>
                            <tr>
                                <td>Ach Dept</td>
                                @foreach ($month['data'] as $index => $list)
                                    <td>{{ $list['actual_dept'] }}</td>
                                @endforeach
                            </tr>
                            <tr>
                                <td>(%)Dept</td>
                                @foreach ($month['data'] as $index => $list)
                                    <td>{{ $list['persentase_dept'] }}%</td>
                                @endforeach
                            </tr>
                            <tr>
                                <td>Deficiency</td>
                                @foreach ($month['data'] as $index => $list)
                                    <td>{{ $list['deficiency'] }}</td>
                                @endforeach
                            </tr>
                        </tbody>
                    </table>
            @endforeach
        </div>
    </div>

</div>
</div>
