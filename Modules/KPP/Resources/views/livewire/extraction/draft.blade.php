<div class="inner-content">

    <div class="section-content">

        <div class="section-title py-3 px-2">
            <h4>Draft Ekstraksi</h4>
        </div><!-- /.section-title -->

        <div class="table-maker">

            <div x-data="{ itemSelected: @entangle('itemSelected'), info: @entangle('info') }">

			    <div class="toolbar-tables border-top border-bottom d-flex justify-content-between p-2">


			        <div class="toolbar-left d-flex align-items-center">

			            <!-- <a href="/kpp/obedience/create" type="button" class="button-toolbar d-flex gap-2 align-items-center py-2 px-3"
			                data-bs-toggle="modal" data-bs-target="#FLTypeModal">
			                <span class="icon d-flex align-items-center"><img src="{{ asset('images/icons/add.png') }}"
			                        alt="image add"></span>
			                <span class="text-button">Add New</span>
			            </a> -->
			            @if ($countSelected > 0)
			                <!-- <a href="#" type="button" class="button-toolbar d-flex gap-2 align-items-center py-2 px-3">
			                    <span class="icon d-flex align-items-center"><img src="{{ asset('images/icons/export.png') }}"
			                            alt="image export"></span>
			                    <span class="text-button">Export</span>
			                </a>

			                <a href="#" type="button" class="button-toolbar d-flex gap-2 align-items-center py-2 px-3"
			                    wire:click="$emit('remove-item')">
			                    <span class="icon d-flex align-items-center"><img src="{{ asset('images/icons/delete.png') }}"
			                            alt="image delete"></span>
			                    <span class="text-button">Delete</span>
			                </a> -->
			            @endif
			        </div><!-- /.toolbar-left -->

			        <div class="toolbar-right d-flex align-items-center">

			            @if ($countSelected > 0)
			                <a href="#" type="button" class="button-toolbar d-flex gap-2 align-items-center py-2 px-3"
			                    wire:click="removeSeleced()">
			                    <span class="icon d-flex align-items-center"><img src="{{ asset('images/icons/delete.png') }}"
			                            alt="image delete"></span>
			                    <span class="text-button">{{ $countSelected }} Row Selected</span>
			                </a>
			            @endif

			            <a href="#" type="button" class="button-toolbar d-flex gap-2 align-items-center py-2 px-3">
			                <span class="icon d-flex align-items-center"><img src="{{ asset('images/icons/sort.png') }}"
			                        alt="image add"></span>
			            </a>

			            <a href="#" type="button" class="button-toolbar d-flex gap-2 align-items-center py-2 px-3">
			                <span class="icon d-flex align-items-center"><img src="{{ asset('images/icons/filter.png') }}"
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

			    <div class="">

			        <table class="table">
			            <thead>
			                <tr>
			                    <th></th>
			                    <th>Nomor Ekstraksi</th>
			                    <th>Company</th>
			                    <th>Nomor Peraturan</th>
			                    <th>Judul Peraturan</th>
			                    <th>Pasal</th>
			                    <th>Ayat</th>
			                    <th>Status</th>
			                    <th>Action</th>
			                </tr>
			            </thead>
			            <tbody>
			                @foreach ($this->extractions as $itemIndex => $item)
			                    <tr wire:key="{{ $itemIndex }}" wire:click="onSelectedItem('{{ $item->id }}')" 
                                    @if(in_array($item->id, $itemSelected))
                                        class="selected"
                                    @else
                                        class="tr"                                   
                                    @endif"
                                >
                                    <td class="td-check">
                                        <span class="icon-checked"></span>
                                    </td>
			                        <td scope="row">
			                            <a href="{{route('kpp::extractions.detail', ['id' => $item->id])}}">
			                                {{ $item->id }}
			                            </a>
			                        </td>
			                        <td>{{ $item->obedience->company->company_name ?? '-' }}</td>
			                        <td>{{ $item->obedience->rule->number }}</td>
			                        <td>{{ $item->obedience->rule->title }}</td>
			                        <td>{{ $item->article->name }}</td>
			                        <td>
			                            {{ $item->sub_section }}
			                        </td>
			                        <td>{{ $item->status }}</td>
			                        <td>
	                                    <a href="{{ route('kpp::extractions.edit', ['id' => $item->id]) }}" class="action-icon">
	                                        <i class="fa fa-edit"></i> Edit
	                                    </a>
	                                </td>
			                    </tr>
			                @endforeach
			            </tbody>
			        </table>

			        <!-- <div class="info" x-show="info">test</div> -->

			    </div><!-- /.table-content-->

			</div>

        </div><!-- /.table-maker -->

    </div><!-- /.section-content -->

    <div class="section-footer d-flex justify-content-between">
        {{-- <div class="update-on opacity-80">Update on Sep 24, 2022 . 15.00 pm</div>
        <div class="row-data opacity-80">1,000 Document Active</div> --}}
    </div><!-- /.section-footer -->
</div>
