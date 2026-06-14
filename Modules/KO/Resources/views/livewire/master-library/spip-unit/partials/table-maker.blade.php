<div x-data="{ itemSelected: @entangle('itemSelected'), info: @entangle('info') }">

    <div class="table-content table-responsive position-relative">
        <div class="table-wrapper overflow-auto">
            <table class="table">
                <thead>
                    <tr>
                        <th>Name</th>
                        <th>Tipe</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($this->spipUnits as $itemIndex => $items)
                        <tr>
                            <td scope="row">
                                <a href="{{ route('ko::master-library.spip-unit.show', $items->id) }}" class="action-icon" style="color: green; font-weight: bold">
                                    {{ $items->name }}
                                </a>
                            </td>
                            <td scope="row">
                                {{ $items->koSpipType->name }}
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

    </div><!-- /.table-content-->

</div>
