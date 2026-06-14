@php
    $data = $data['data'];
    $yearly = $data['yearly'];
@endphp

<div>
    <div class="p-2">

        <div>
            <span> <b>PENCAPAIAN {{ $data['year_now'] }}</b></span>
        </div>

        @if (isset($yearly))
            <div class="container-spinner ">

                {{-- <div class="spinner-center spinner-border" role="status" wire:loading>
                    <span class="visually-hidden">Loading...</span>
                </div> --}}

                <div class="table-responsive">
                    <table class="table table-bordered table-grafik">
                        <thead>
                            <tr>
                                <th></th>
                                @foreach ($yearly as $index => $list)
                                    <th>{{ $index }}</th>
                                @endforeach
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>Target Dept</td>
                                @foreach ($yearly as $index => $list)
                                    <td>{{ $list['target_dept'] }}</td>
                                @endforeach
                            </tr>
                            <tr>
                                <td>Ach Dept</td>
                                @foreach ($yearly as $index => $list)
                                    <td>{{ $list['actual_dept'] }}</td>
                                @endforeach
                            </tr>
                            <tr>
                                <td>(%)Dept</td>
                                @foreach ($yearly as $index => $list)
                                    <td>{{ $list['target_dept'] != 0 && $list['actual_dept'] != 0 ? 100 : null }}%</td>
                                @endforeach
                            </tr>
                            <tr>
                                <td>Deficiency</td>
                                @foreach ($yearly as $index => $list)
                                    <td>{{ $list['deficiency'] }}</td>
                                @endforeach
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        @endif
    </div>
</div>
