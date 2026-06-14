<div x-data="{ itemSelected: @entangle('itemSelected'), info: @entangle('info') }">

    <div class="table-content table-responsive position-relative">
        <div class="table-wrapper overflow-auto">
            <table class="table">
                <thead>
                    <tr>
                        <th>Name</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($this->spipCategories as $itemIndex => $items)
                        <tr>
                            <td scope="row">
                                <a style="color: green; font-weight: bold" href="{{ route('ko::master-library.spip-category.show', $items->id) }}">
                                    {{ $items->name }}
                                </a>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

    </div><!-- /.table-content-->

</div>
