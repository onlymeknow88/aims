<div class="inner-content">
    <div class="mt-4" x-data="{ itemSelected: @entangle('itemSelected'), info: @entangle('info') }">

        <div class="table-content table-responsive position-relative overflow-auto d-flex">

            <table class="table">
                <thead>
                    <tr>
                        <th>Tanggal MCU</th>
                        <th>Jakarta Cardiovascular</th>
                        <th>Framingham Risk</th>
                        <th>Status</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($dataTables as $itemIndex => $items)
                        <tr wire:key="{{ $itemIndex }}">
                            <td>
                                <a
                                    href="{{ route('mcu::patient-detail', $items['id']) }}">{{ $items['mcu_date'] }}</a>
                            </td>
                            <td>{{ $items['jakarta_cardiovascular_risk_level'] }}</td>
                            <td>{{ $items['frammingham_risk_level'] }}</td>
                            <td><span
                                    style="color:@if ($items['doctor_status_review'] == 'Fit') green
                                @elseif ($items['doctor_status_review'] == 'Fit With Recomendation') cyan
                                @elseif ($items['doctor_status_review'] == 'Curently Unfit') orange
                                @elseif ($items['doctor_status_review'] == 'Unfit') red
                                @else black @endif;">
                                    @if (empty($items['doctor_status_review']))
                                        {{ 'In Review' }}
                                    @else
                                        {{ $items['doctor_status_review'] }}
                                    @endif
                                </span>
                            </td>
                            <td><a href="{{ route('mcu::patient-detail', $items['id']) }}" style="color: blue;">Lihat
                                    Detail</a></td>
                        </tr>
                    @endforeach
                </tbody>
            </table>

            <div class="info" x-show="info">test</div>

        </div><!-- /.table-content-->

    </div>
</div>
