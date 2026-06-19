<div>
    <div class="section-content">

        <div class="section-title py-3 px-2">
            <h4>Field Leadership</h4>
        </div><!-- /.section-title -->

        <div class="table-demo position-relative">

            <div x-data="{ 
                itemSelected: @entangle('itemSelected').defer, 
                info: @entangle('info'),
                toggleItem(id) {
                    id = String(id);
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
                <!-- /.toolsbar-tables -->

                <div class="table-content table-responsive position-relative">

                    <div class="table-wrapper overflow-auto">

                        <table class="table" style="height: fit-content">
                            <thead>
                                <tr>
                                    @if (in_array('Company', $selectedColumns))
                                        <th>
                                            <div class="column-sort d-flex justify-content-between">
                                                <span>
                                                    Company
                                                </span>
                                            </div>
                                        </th>
                                    @endif
                                    @if (in_array('Date', $selectedColumns))
                                        <th>
                                            <div class="column-sort d-flex justify-content-between">
                                                <span>
                                                    Date
                                                </span>
                                            </div>
                                        </th>
                                    @endif
                                    @if (in_array('CCOW', $selectedColumns))
                                        <th>
                                            <div class="column-sort d-flex justify-content-between">
                                                <span>
                                                    CCOW
                                                </span>
                                            </div>
                                        </th>
                                    @endif
                                    @if (in_array('Detail Company', $selectedColumns))
                                        <th>
                                            <div class="column-sort d-flex justify-content-between">
                                                <span>
                                                    Detail Company
                                                </span>
                                            </div>
                                        </th>
                                    @endif
                                    @if (in_array('Department', $selectedColumns))
                                        <th>
                                            <div class="column-sort d-flex justify-content-between">
                                                <span>
                                                    Department
                                                </span>
                                            </div>
                                        </th>
                                    @endif
                                    @if (in_array('Section', $selectedColumns))
                                        <th>
                                            <div class="column-sort d-flex justify-content-between">
                                                <span>
                                                    Section
                                                </span>
                                            </div>
                                        </th>
                                    @endif
                                    @if (in_array('Location', $selectedColumns))
                                        <th>
                                            <div class="column-sort d-flex justify-content-between">
                                                <span>
                                                    Location
                                                </span>
                                            </div>
                                        </th>
                                    @endif
                                    @if (in_array('Detail Location', $selectedColumns))
                                        <th>
                                            <div class="column-sort d-flex justify-content-between">
                                                <span>
                                                    Detail Location
                                                </span>
                                            </div>
                                        </th>
                                    @endif
                                    @if (in_array('Type', $selectedColumns))
                                        <th>
                                            <div class="column-sort d-flex justify-content-between">
                                                <span>
                                                    Type
                                                </span>
                                            </div>
                                        </th>
                                    @endif
                                    @if (in_array('Members', $selectedColumns))
                                        <th>
                                            <div class="column-sort d-flex justify-content-between">
                                                <span>
                                                    Member
                                                </span>
                                            </div>
                                        </th>
                                    @endif
                                    @if (in_array('Positive Condition', $selectedColumns))
                                        <th>
                                            <div class="column-sort d-flex justify-content-between">
                                                <span>
                                                    Positive Condition
                                                </span>
                                            </div>
                                        </th>
                                    @endif
                                    @if (in_array('Risk Condition', $selectedColumns))
                                        <th>
                                            <div class="column-sort d-flex justify-content-between">
                                                <span>
                                                    Risk Condition
                                                </span>
                                            </div>
                                        </th>
                                        <th>
                                            <div class="column-sort d-flex justify-content-between">
                                                <span>
                                                    Category
                                                </span>
                                            </div>
                                        </th>
                                        <th>
                                            <div class="column-sort d-flex justify-content-between">
                                                <span>
                                                    Potency
                                                </span>
                                            </div>
                                        </th>
                                    @endif
                                    @if (in_array('Repair Action', $selectedColumns))
                                        <th>
                                            <div class="column-sort d-flex justify-content-between">
                                                <span>
                                                    Repair Action
                                                </span>
                                            </div>
                                        </th>
                                        <th>
                                            <div class="column-sort d-flex justify-content-between">
                                                <span>
                                                    PJA
                                                </span>
                                            </div>
                                        </th>
                                        <th>Due Date</th>
                                    @endif
                                    @if (in_array('Status', $selectedColumns))
                                        <th>Status</th>
                                    @endif
                                    <th>Published</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($this->activeListings as $itemIndex => $items)
                                    <tr wire:key="fl-row-{{ $items->id }}"
                                        @click="toggleItem('{{ $items->id }}')"
                                        :class="itemSelected.includes('{{ $items->id }}') ? 'selected' : 'tr'"
                                        style="cursor: pointer;">
                                        @if (in_array('Company', $selectedColumns))
                                            <td>
                                                <a href="{{ route('field-leadership::listing.active.detail', $items->id) }}"
                                                    style="font-weight: 600; color: #00552f;">
                                                    {{ $items->company->company_name ?? '-' }}
                                                </a>
                                            </td>
                                        @endif
                                        @if (in_array('Date', $selectedColumns))
                                            <td scope="row">
                                                {{ Carbon\Carbon::parse($items->date)->format('F d, Y') }}
                                            </td>
                                        @endif
                                        @if (in_array('CCOW', $selectedColumns))
                                            <td>{{ $items->ccow->company_name ?? '-' }}</td>
                                        @endif
                                        @if (in_array('Detail Company', $selectedColumns))
                                            <td>{{ $items->detail_company ?? '-' }}</td>
                                        @endif
                                        @if (in_array('Department', $selectedColumns))
                                            <td>{{ $items->department->name ?? '-' }}</td>
                                        @endif
                                        @if (in_array('Section', $selectedColumns))
                                            <td>{{ $items->section->name ?? '-' }}</td>
                                        @endif
                                        @if (in_array('Location', $selectedColumns))
                                            <td>{{ $items->areaLocation->name ?? '-' }}</td>
                                        @endif
                                        @if (in_array('Detail Location', $selectedColumns))
                                            <td>
                                                <div style="white-space:normal; width: 200px;">
                                                    {{ $items->detail_location ?? '-' }}
                                                </div>
                                            </td>
                                        @endif
                                        @if (in_array('Type', $selectedColumns))
                                            <td>{{ $items->type ?? '-' }}</td>
                                        @endif
                                        @if (in_array('Members', $selectedColumns))
                                            <td>
                                                <ol>
                                                    @foreach ($items->members as $member)
                                                        <li>
                                                            {{ $member->employee->name ?? '-' }}
                                                        </li>
                                                    @endforeach
                                                </ol>
                                            </td>
                                        @endif
                                        @if (in_array('Positive Condition', $selectedColumns))
                                            <td>
                                                <div style="white-space:normal; width: 400px">
                                                    <ol>
                                                        @foreach ($items->positives as $positive)
                                                            <li>
                                                                {{ $positive->description ?? '-' }}
                                                            </li>
                                                        @endforeach
                                                    </ol>
                                                </div>
                                            </td>
                                        @endif
                                        @if (in_array('Risk Condition', $selectedColumns))
                                            <td>
                                                <div style="white-space:normal; width: 400px">
                                                    <ol>
                                                        @foreach ($items->risks as $risk)
                                                            <li>
                                                                {{ $risk->risk_condition ?? '-' }}
                                                            </li>
                                                        @endforeach
                                                    </ol>
                                                </div>
                                            </td>
                                            <td>
                                                <ol>
                                                    @foreach ($items->risks as $risk)
                                                        <li>
                                                            {{ $risk->category->name ?? '-' }}
                                                        </li>
                                                    @endforeach
                                                </ol>
                                            </td>
                                            <td>
                                                <ol>
                                                    @foreach ($items->risks as $risk)
                                                        <li>
                                                            {{ $risk->potency->name ?? '-' }}
                                                        </li>
                                                    @endforeach
                                                </ol>
                                            </td>
                                        @endif
                                        @if (in_array('Repair Action', $selectedColumns))
                                            <td>
                                                <div style="white-space:normal; width: 400px">
                                                    <ol>
                                                        @foreach ($items->risks as $risk)
                                                            <li>
                                                                {{ $risk->repair_action ?? '-' }}
                                                            </li>
                                                        @endforeach
                                                    </ol>
                                                </div>
                                            </td>
                                            <td>
                                                {{ $items->pja->user->name ?? '-' }}
                                            </td>
                                            <td>
                                                <ol>
                                                    @foreach ($items->risks as $risk)
                                                        <li>
                                                            {{ Carbon\Carbon::parse($risk->due_date)->format('F d, Y') }}
                                                        </li>
                                                    @endforeach
                                                </ol>
                                            </td>
                                        @endif
                                        @if (in_array('Status', $selectedColumns))
                                            <td>
                                                <span
                                                    class="badge rounded-pill {{ $items->status == App\Enums\FieldLeadership\FieldLeadershipType::Open ? 'bg-danger' : ($items->status == App\Enums\FieldLeadership\FieldLeadershipType::Close ? 'bg-success' : ($items->status == App\Enums\FieldLeadership\FieldLeadershipType::OnReviewPja ? 'bg-info' : 'bg-primary')) }}">
                                                    {{ $items->status }}
                                                </span>
                                            </td>
                                        @endif
                                        <td>
                                            <span
                                                class="badge rounded-pill {{ $items->published == 'Draft' ? 'bg-secondary' : 'bg-success' }}">
                                                {{ $items->published }}
                                            </span>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>

                        {{-- <div class="info" x-show="info">test</div> --}}

                    </div><!-- /.table-wrapper -->

                </div><!-- /.table-content-->

            </div><!-- /.table-container -->

        </div><!-- /.table-maker -->

    </div><!-- /.section-content -->

    <div class="section-footer d-flex justify-content-between sticky-bottom bg-white align-items-center h-60px p-3">
        <div class="update-on opacity-80">{{ $latestUpdate }}</div>

        <div class="row-data opacity-80 d-flex gap-2 align-items-center">
            <span class="input-limit w-100px">
                <x-inputs.text wire:model="limit" id="limit" placeholder="0" value="{{ $limit }}"
                    :error="'limit'" />
            </span>
            <span>{!! __('of') !!}</span>
            <span class="font-medium">{{ $countData }}</span>
            <span>{!! __('Row Data') !!}</span>
        </div>

    </div><!-- /.section-footer -->

    {{-- Modal --}}

    <div class="modal fade" id="sortModal_table" tabindex="-1" aria-labelledby="sortModal_tableLabel"
        aria-hidden="true" style="display: none;">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="sortModal_tableLabel">Multiple Sort</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="bootstrap-table">
                        {{-- <div class="fixed-table-toolbar">
                    <div class="bars">
                        <div id="toolbar" class="pb-3">
                            <button id="add" type="button" class="btn btn-secondary"><i
                                    class="bi bi-plus"></i> Add Level</button>
                            <button id="delete" type="button" class="btn btn-secondary"><i
                                    class="bi bi-dash"></i> Delete Level</button>
                        </div>
                    </div>
                </div> --}}
                        <div class="fixed-table-container">
                            <table id="multi-sort" class="table">
                                <thead>
                                    <tr>
                                        <th></th>
                                        <th>
                                            <div class="th-inner">Column</div>
                                        </th>
                                        <th>
                                            <div class="th-inner">Order</div>
                                        </th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td>Sort by</td>
                                        <td><select class="btn-group dropdown multi-sort-name form-control">
                                                <option value="github.name">Name</option>
                                                <option value="github.count.stargazers">Stargazers</option>
                                                <option value="github.count.forks" selected="selected">Forks</option>
                                                <option value="github.description">Description</option>
                                            </select></td>
                                        <td><select class="btn-group dropdown multi-sort-order form-control">
                                                <option value="asc">Ascending</option>
                                                <option value="desc" selected="selected">Descending</option>
                                            </select></td>
                                    </tr>
                                    <tr>
                                        <td>Then by</td>
                                        <td><select class="btn-group dropdown multi-sort-name form-control">
                                                <option value="github.name">Name</option>
                                                <option value="github.count.stargazers" selected="selected">Stargazers
                                                </option>
                                                <option value="github.count.forks">Forks</option>
                                                <option value="github.description">Description</option>
                                            </select></td>
                                        <td><select class="btn-group dropdown multi-sort-order form-control">
                                                <option value="asc">Ascending</option>
                                                <option value="desc" selected="selected">Descending</option>
                                            </select></td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="button" class="btn btn-primary multi-sort-order-button">Sort</button>
                </div>
            </div>
        </div>
    </div>
</div>

@push('scripts')
    <script type="text/javascript">
        document.addEventListener('DOMContentLoaded', function() {

            @this.on('remove-item', () => {
                Swal.fire({
                    title: 'Are You Sure?',
                    text: 'Yakin akan menghapus data ini?',
                    icon: "warning",
                    showCancelButton: true,
                    confirmButtonText: 'Hapus'
                }).then((result) => {

                    if (result.value) {

                        @this.call('removeItem')

                    }

                });
            });
        });
    </script>
@endpush
