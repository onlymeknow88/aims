<div x-data="{ 
    itemSelected: @entangle('itemSelected').defer, 
    info: @entangle('info'),
    toggleItem(id) {
        id = parseInt(id) || id;
        let current = [...this.itemSelected];
        let idx = current.indexOf(id);
        if (idx > -1) {
            current.splice(idx, 1);
        } else {
            current.push(id);
        }
        this.itemSelected = current;
    }
}">

    <div class="toolbar-tables border-top border-bottom d-flex justify-content-between p-2 sticky-top">

        <div class="toolbar-left d-flex align-items-center">

            <a href="#" type="button" 
                x-bind:class="itemSelected.length > 0 ? 'd-flex' : 'd-none'"
                class="button-toolbar gap-2 align-items-center py-2 px-3">
                <span class="icon d-flex align-items-center"><img src="{{ asset('images/icons/export-top.svg') }}"
                        alt="image export"></span>
                <span class="text-button">Export</span>
            </a>
        </div><!-- /.toolbar-left -->

        <div class="toolbar-right d-flex align-items-center">

            <a href="#" type="button" 
                x-bind:class="itemSelected.length > 0 ? 'd-flex' : 'd-none'"
                class="button-toolbar gap-2 align-items-center py-2 px-3"
                @click.prevent="itemSelected = [];">
                <span class="icon d-flex align-items-center"><img src="{{ asset('images/icons/delete.png') }}"
                        alt="image delete"></span>
                <span class="text-button" x-text="itemSelected.length + ' Row Selected'"></span>
            </a>

            <a href="#" type="button" class="button-toolbar d-flex gap-2 align-items-center py-2 px-3">
                <span class="icon d-flex align-items-center"><img src="{{ asset('images/icons/sort.png') }}"
                        alt="image sort"></span>
            </a>

            <a href="#" type="button" class="button-toolbar d-flex gap-2 align-items-center py-2 px-3">
                <span class="icon d-flex align-items-center"><img src="{{ asset('images/icons/filter-top.svg') }}"
                        alt="image export"></span>
            </a>

            <a href="#" type="button" class="button-toolbar d-flex gap-2 align-items-center py-2 px-3"
                wire:click="activedInfo()">
                <span class="icon d-flex align-items-center"><img src="{{ asset('images/icons/info.png') }}"
                        alt="image info"></span>
            </a>

            <a href="#" type="button" class="button-toolbar d-flex gap-2 align-items-center py-2 px-3">
                <span class="icon d-flex align-items-center"><img src="{{ asset('images/icons/menu.png') }}"
                        alt="image menu"></span>
            </a>

        </div><!-- /.toolbar-right -->

    </div><!-- /.toolsbar-tables -->

    <div class="table-content table-responsive position-relative" :class="info ? 'infoOpen' : ''">

        <div class="table-wrapper">

            <table class="table overflow-auto">
                <thead>
                    <tr>
                        <th></th>
                        <th>Title</th>
                        <th>Date Created</th>
                        <th>Status</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($dataTables as $itemIndex => $items)
                        <tr wire:key="row-{{ $items->id }}" 
                            @click="toggleItem({{ $items->id }})"
                            :class="itemSelected.includes({{ $items->id }}) ? 'selected' : 'tr'"
                            style="cursor: pointer;">
                            <td class="td-check">
                                <span class="icon-checked" :class="itemSelected.includes({{ $items->id }}) ? 'selected' : ''"></span>
                            </td>
                            <td><a @click.stop
                                    href="{{ route('detail-approval', ['id' => $items['id']]) }}">{{ $items['title'] }}</a>
                            </td>
                            <td>{{ $items['Created'] }}</td>
                            <td>{!! $items->status_badge !!}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table><!-- table -->
        </div><!-- /.table-wrapper -->

        <div class="info bg-white px-3" x-show="info">

            <livewire:documentsystem::approval.sidebar-info />

        </div><!-- /.info -->

    </div><!-- /.table-content-->

    <div class="section-footer d-flex justify-content-between sticky-bottom bg-white align-items-center h-60px">
        <div class="update-on opacity-80">Update on Sep 24, 2022 . 15.00 pm</div>
        <div class="row-data opacity-80">1,000 Document Active</div>
    </div><!-- /.section-footer -->


</div>
