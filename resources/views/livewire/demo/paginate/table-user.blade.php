<div x-data="{ itemSelected: @entangle('itemSelected')}">

    <div class="toolbar-tables border-top border-bottom d-flex justify-content-between p-2 sticky-top">

        <div class="toolbar-left d-flex align-items-center">

            <a href="#" type="button" class="button-toolbar d-flex gap-2 align-items-center py-2 px-3 add-new">
                <span class="icon d-flex align-items-center">
                    {{-- <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15" />
                      </svg> --}}
                      <img src="{{asset('images/icons/add-new.svg')}}" alt="image add new">                    
                </span>
                <span class="text-button">Add New</span>
            </a>

            <a href="#" type="button" class="button-toolbar d-flex gap-2 align-items-center py-2 px-3">
                <span class="icon d-flex align-items-center"><img src="{{asset('images/icons/export-top.svg')}}" alt="image export"></span>
                <span class="text-button">Export</span>
            </a>

            <a href="#" type="button" class="button-toolbar d-flex gap-2 align-items-center py-2 px-3">
                <span class="icon d-flex align-items-center"><img src="{{asset('images/icons/delete-top.svg')}}" alt="image delete"></span>
                <span class="text-button">Delete</span>
            </a>
  
        </div><!-- /.toolbar-left -->

        <div class="toolbar-right d-flex align-items-center"> 

            @if($countSelected > 0 )
                <a href="#" type="button" class="button-toolbar d-flex gap-2 align-items-center py-2 px-3" wire:click="removeSeleced()">
                    <span class="icon d-flex align-items-center"><img src="{{asset('images/icons/delete-top.svg')}}" alt="image delete"></span>
                    <span class="text-button">{{ $countSelected }} Row Selected</span>
                </a>
            @endif

            @if($filtered)
                <a href="#" type="button" class="button-toolbar d-flex gap-2 align-items-center py-2 px-3">
                    <span class="icon d-flex align-items-center"><img src="{{asset('images/icons/filter-solid.png')}}" alt="image export"></span>
                </a>                
            @else
                <div class="column-sort d-flex justify-content-between">                                       
                    <a class="button-toolbar d-flex gap-2 align-items-center py-2 px-3" type="button" data-bs-toggle="dropdown" aria-expanded="false" >
                        <img src="{{asset("images/icons/filter-top.svg")}}" alt="sorting" />
                        <span>Filter</span>
                    </a>
                    <div class="dropdown-menu dropdown-menu-end shadow-lg">

                        <div class="dropdown-content p-3 d-flex gap-2 flex-column">
                            
                            <div class="sort-list d-flex gap-1 flex-column mh-200px overflow-auto">
                                <div class="form-check">
                                    <input class="form-check-input rounded-circle" type="checkbox" value="" id="flexCheckDefault">
                                    <label class="form-check-label fw-normal" for="flexCheckDefault">Name 1</label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input rounded-circle" type="checkbox" value="" id="flexCheckDefault">
                                    <label class="form-check-label fw-normal" for="flexCheckDefault">Name 2</label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input rounded-circle" type="checkbox" value="" id="flexCheckDefault">
                                    <label class="form-check-label fw-normal" for="flexCheckDefault">Name 3</label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input rounded-circle" type="checkbox" value="" id="flexCheckDefault">
                                    <label class="form-check-label fw-normal" for="flexCheckDefault">Name 4</label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input rounded-circle" type="checkbox" value="" id="flexCheckDefault">
                                    <label class="form-check-label fw-normal" for="flexCheckDefault">Name 5</label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input rounded-circle" type="checkbox" value="" id="flexCheckDefault">
                                    <label class="form-check-label fw-normal" for="flexCheckDefault">Name 6</label>
                                </div>
                            </div>

                        </div><!--./dropdown-content-->
                            
                        </div><!-- /.dropdown-menu -->
                        
                </div><!-- /.column-sort -->
                <a href="#" type="button" class="button-toolbar d-flex gap-2 align-items-center py-2 px-3">
                    <span class="icon d-flex align-items-center"><img src="{{asset('images/icons/filter-top.svg')}}" alt="image export"></span>
                </a>   
            @endif
            

        </div><!-- /.toolbar-right -->
        
    </div><!-- /.toolsbar-tables -->

    <div class="table-content table-responsive position-relative" >

        <div class="table-wrapper">
  
            <table class="table overflow-auto">
                <thead>
                    <tr
                        @if($selectAll)
                            class="selected"
                        @else
                            class="tr"                                   
                        @endif"
                    >
                        <th  class="sticky-top" wire:click="toggleSelectAll()" ><span class="icon-checked"></span></th>
                        <th class="sticky-top">
                            <div class="column-sort d-flex justify-content-between">                                       
                                <span>Nama</span>
                                <span>
                                    <button class="btn border-0 p-0" type="button" data-bs-toggle="dropdown" aria-expanded="false" >
                                        <img src="{{asset("images/icons/filter-default.svg")}}" alt="sorting" />
                                    </button>
                                    <div class="dropdown-menu dropdown-menu-end shadow-lg">

                                        <div class="dropdown-content p-3 d-flex gap-2 flex-column">

                                            <a href="#" class="sort sort-asc fw-normal d-block">Urutkan A-Z</a>
                                            <a href="#" class="sort sort-desc fw-normal d-block">Urutkan Z-A</a>
                                            <div class="pilih-all d-flex gap-2">
                                                <a href="#" class="fw-normal text-green">Pilih Semua</a>
                                                <a href="#" class="fw-normal text-green">Kosongkan</a>
                                            </div>
                                            <div class="sort-search">
                                                <div class="input-group">
                                                    <span class="input-group-text border-end-0" id="search-icon">
                                                        <img src="{{ asset("images/icons/search.png") }}" alt="Search" srcset="{{ asset("images/icons/search.png") }}">
                                                    </span>
                                                    <input type="text" class="form-control" placeholder="Cari data document" aria-label="Name" aria-describedby="search-icon">
                                                </div>
                                            </div>
                                            <div class="sort-list d-flex gap-1 flex-column mh-200px overflow-auto">
                                                <div class="form-check">
                                                    <input class="form-check-input rounded-circle" type="checkbox" value="" id="flexCheckDefault">
                                                    <label class="form-check-label fw-normal" for="flexCheckDefault">Name 1</label>
                                                </div>
                                                <div class="form-check">
                                                    <input class="form-check-input rounded-circle" type="checkbox" value="" id="flexCheckDefault">
                                                    <label class="form-check-label fw-normal" for="flexCheckDefault">Name 2</label>
                                                </div>
                                                <div class="form-check">
                                                    <input class="form-check-input rounded-circle" type="checkbox" value="" id="flexCheckDefault">
                                                    <label class="form-check-label fw-normal" for="flexCheckDefault">Name 3</label>
                                                </div>
                                                <div class="form-check">
                                                    <input class="form-check-input rounded-circle" type="checkbox" value="" id="flexCheckDefault">
                                                    <label class="form-check-label fw-normal" for="flexCheckDefault">Name 4</label>
                                                </div>
                                                <div class="form-check">
                                                    <input class="form-check-input rounded-circle" type="checkbox" value="" id="flexCheckDefault">
                                                    <label class="form-check-label fw-normal" for="flexCheckDefault">Name 5</label>
                                                </div>
                                                <div class="form-check">
                                                    <input class="form-check-input rounded-circle" type="checkbox" value="" id="flexCheckDefault">
                                                    <label class="form-check-label fw-normal" for="flexCheckDefault">Name 6</label>
                                                </div>
                                            </div>

                                        </div><!--./dropdown-content-->
                                        
                                    </div><!-- /.dropdown-menu -->
                                    
                                </span>
                            </div><!-- /.column-sort -->
                        </th>
                        <th class="sticky-top">
                            <div class="column-sort d-flex justify-content-between">                                       
                                <span>Email</span>
                                <span>
                                    <button class="btn border-0 p-0" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                                        <img src="{{asset("images/icons/filter-default.svg")}}" alt="sorting" />
                                    </button>
                                    <div class="dropdown-menu dropdown-menu-start shadow-lg">

                                        <div class="dropdown-content p-3 gap-2 d-flex flex-column">

                                            <a href="#" class="sort sort-asc fw-normal d-block">Urutkan A-Z</a>
                                            <a href="#" class="sort sort-desc fw-normal d-block">Urutkan Z-A</a>
                                            <div class="pilih-all d-flex gap-2">
                                                <a href="#" class="fw-normal text-green">Pilih Semua</a>
                                                <a href="#" class="fw-normal text-green">Kosongkan</a>
                                            </div>
                                            <div class="sort-search">
                                                <div class="input-group">
                                                    <span class="input-group-text border-end-0" id="search-icon">
                                                        <img src="{{ asset("images/icons/search.png") }}" alt="Search" srcset="{{ asset("images/icons/search.png") }}">
                                                    </span>
                                                    <input type="text" class="form-control" placeholder="Cari data document" aria-label="Name" aria-describedby="search-icon">
                                                </div>
                                            </div>
                                            <div class="sort-list d-flex gap-1 flex-column mh-200px overflow-auto">
                                                <div class="form-check">
                                                    <input class="form-check-input rounded-circle" type="checkbox" value="" id="flexCheckDefault">
                                                    <label class="form-check-label fw-normal" for="flexCheckDefault">Email 1</label>
                                                </div>
                                                <div class="form-check">
                                                    <input class="form-check-input rounded-circle" type="checkbox" value="" id="flexCheckDefault">
                                                    <label class="form-check-label fw-normal" for="flexCheckDefault">Email 2</label>
                                                </div>
                                                <div class="form-check">
                                                    <input class="form-check-input rounded-circle" type="checkbox" value="" id="flexCheckDefault">
                                                    <label class="form-check-label fw-normal" for="flexCheckDefault">Email 3</label>
                                                </div>
                                                <div class="form-check">
                                                    <input class="form-check-input rounded-circle" type="checkbox" value="" id="flexCheckDefault">
                                                    <label class="form-check-label fw-normal" for="flexCheckDefault">Email 4</label>
                                                </div>
                                                <div class="form-check">
                                                    <input class="form-check-input rounded-circle" type="checkbox" value="" id="flexCheckDefault">
                                                    <label class="form-check-label fw-normal" for="flexCheckDefault">Email 5</label>
                                                </div>
                                                <div class="form-check">
                                                    <input class="form-check-input rounded-circle" type="checkbox" value="" id="flexCheckDefault">
                                                    <label class="form-check-label fw-normal" for="flexCheckDefault">Email 6</label>
                                                </div>
                                            </div>

                                        </div><!--./dropdown-content-->
                                        
                                    </div><!-- /.dropdown-menu -->
                                    
                                </span>
                            </div><!-- /.column-sort -->
                        </th>
                        <th  class="sticky-top">
                            <div class="column-sort d-flex justify-content-between gap-5">                                       
                                <span>status</span>
                                <span>
                                    <button class="btn border-0 p-0" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                                        <img src="{{asset("images/icons/filter-default.svg")}}" alt="sorting" />
                                    </button>
                                    <div class="dropdown-menu dropdown-menu-end shadow-lg">

                                        <div class="dropdown-content p-3 gap-2 d-flex flex-column">

                                            <a href="#" class="sort sort-asc fw-normal d-block">Urutkan A-Z</a>
                                            <a href="#" class="sort sort-desc fw-normal d-block">Urutkan Z-A</a>
                                            <div class="pilih-all d-flex gap-2">
                                                <a href="#" class="fw-normal text-green">Pilih Semua</a>
                                                <a href="#" class="fw-normal text-green">Kosongkan</a>
                                            </div>
                                            <div class="sort-search">
                                                <div class="input-group">
                                                    <span class="input-group-text border-end-0" id="search-icon">
                                                        <img src="{{ asset("images/icons/search.png") }}" alt="Search" srcset="{{ asset("images/icons/search.png") }}">
                                                    </span>
                                                    <input type="text" class="form-control" placeholder="Cari data document" aria-label="Name" aria-describedby="search-icon">
                                                </div>
                                            </div>
                                            <div class="sort-list d-flex gap-1 flex-column mh-200px overflow-auto">
                                                <div class="form-check">
                                                    <input class="form-check-input rounded-circle" type="checkbox" value="" id="flexCheckDefault">
                                                    <label class="form-check-label fw-normal" for="flexCheckDefault">Email 1</label>
                                                </div>
                                                <div class="form-check">
                                                    <input class="form-check-input rounded-circle" type="checkbox" value="" id="flexCheckDefault">
                                                    <label class="form-check-label fw-normal" for="flexCheckDefault">Email 2</label>
                                                </div>
                                                <div class="form-check">
                                                    <input class="form-check-input rounded-circle" type="checkbox" value="" id="flexCheckDefault">
                                                    <label class="form-check-label fw-normal" for="flexCheckDefault">Email 3</label>
                                                </div>
                                                <div class="form-check">
                                                    <input class="form-check-input rounded-circle" type="checkbox" value="" id="flexCheckDefault">
                                                    <label class="form-check-label fw-normal" for="flexCheckDefault">Email 4</label>
                                                </div>
                                                <div class="form-check">
                                                    <input class="form-check-input rounded-circle" type="checkbox" value="" id="flexCheckDefault">
                                                    <label class="form-check-label fw-normal" for="flexCheckDefault">Email 5</label>
                                                </div>
                                                <div class="form-check">
                                                    <input class="form-check-input rounded-circle" type="checkbox" value="" id="flexCheckDefault">
                                                    <label class="form-check-label fw-normal" for="flexCheckDefault">Email 6</label>
                                                </div>
                                            </div>

                                        </div><!--./dropdown-content-->
                                        
                                    </div><!-- /.dropdown-menu -->
                                    
                                </span>
                            </div><!-- /.column-sort -->
                        </th>
                        <th  class="sticky-top">
                            <div class="column-sort d-flex justify-content-between">                                       
                                <span>search only</span>
                                <span>
                                    <button class="btn border-0 p-0" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                                        <img src="{{asset("images/icons/filter-default.svg")}}" alt="sorting" />
                                        <img src="{{asset("images/icons/filter-sort.svg")}}" alt="sorting" />
                                    </button>
                                    <div class="dropdown-menu dropdown-menu-end shadow-lg">

                                        <div class="dropdown-content p-3 gap-2 d-flex flex-column">
                                            <div class="sort-search">
                                                <div class="input-group">
                                                    <span class="input-group-text border-end-0" id="search-icon">
                                                        <img src="{{ asset("images/icons/search.png") }}" alt="Search" srcset="{{ asset("images/icons/search.png") }}">
                                                    </span>
                                                    <input type="text" class="form-control" placeholder="Cari data document" aria-label="Name" aria-describedby="search-icon">
                                                </div>
                                            </div>
                                        </div><!--./dropdown-content-->
                                        
                                    </div><!-- /.dropdown-menu -->
                                    
                                </span>
                            </div><!-- /.column-sort -->
                        </th>
                        <th class="sticky-top">
                            <div class="column-sort d-flex justify-content-between gap-5">                                       
                                <span>No data</span>
                                <span>
                                    <button class="btn border-0 p-0" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                                        <img src="{{asset("images/icons/filter-default.svg")}}" alt="sorting" />
                                    </button>
                                    <div class="dropdown-menu dropdown-menu-end shadow-lg">

                                        <div class="dropdown-content p-3 gap-2 d-flex flex-column">

                                            <a href="#" class="sort sort-asc fw-normal d-block">Urutkan A-Z</a>
                                            <a href="#" class="sort sort-desc fw-normal d-block">Urutkan Z-A</a>
                                            <div class="pilih-all d-flex gap-2">
                                                <a href="#" class="fw-normal text-green">Pilih Semua</a>
                                                <a href="#" class="fw-normal text-green">Kosongkan</a>
                                            </div>
                                            <div class="sort-search">
                                                <div class="input-group">
                                                    <span class="input-group-text border-end-0" id="search-icon">
                                                        <img src="{{ asset("images/icons/search.png") }}" alt="Search" srcset="{{ asset("images/icons/search.png") }}">
                                                    </span>
                                                    <input type="text" class="form-control" placeholder="Cari data document" aria-label="Name" aria-describedby="search-icon">
                                                </div>
                                            </div>
                                            <div class="sort-list d-flex gap-1 flex-column mh-200px overflow-auto">
                                                <div class="no-data">
                                                    No record data
                                                </div>
                                            </div>

                                        </div><!--./dropdown-content-->
                                        
                                    </div><!-- /.dropdown-menu -->
                                    
                                </span>
                            </div><!-- /.column-sort -->
                        </th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($users as $itemIndex => $items)

                        <tr wire:key="{{ $items['id'] }}" wire:click="onSelectedItem('{{ $items['id'] }}')" 
                            @if(in_array($items['id'], $itemSelected))
                                class="selected"
                            @else
                                class="tr"                                   
                            @endif"
                        >
                            <td class="td-check">   
                                <span class="icon-checked"></span>
                            </td>                          
                            <td class="title">{{$items['name']}}</td>
                            <td>{{$items['email']}}</td>
                            <td><span class="pending">pending</span><span class="cancel">Cancel</span><span class="done">DONE</span><span class="default">default</span></td>
                            <td>Lorem ipsum dolor, sit amet consectetur adipisicing elit. Molestias debitis ipsam quo fugit qui quaerat nisi, necessitatibus id inventore autem quia vitae incidunt harum vel itaque obcaecati. Beatae, impedit animi.</td>
                            <td>Lorem ipsum, dolor sit amet consectetur adipisicing elit. Fuga quibusdam earum libero provident impedit rem, expedita aut voluptatum necessitatibus blanditiis aperiam, labore atque totam deserunt, illum temporibus ad sed tenetur!</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
            
        </div><!-- /.table-wrapper -->

    </div><!-- /.table-content-->

    <div class="section-footer d-flex justify-content-between sticky-bottom bg-white align-items-center h-60px px-2">
        <div class="update-on opacity-80">{{ $latestUpdate }}</div>        
        {{ $users->links('components.paginate.paginate', ['limit'=> $limit]) }}        
    </div><!-- /.section-footer -->

</div>
@push('styles')
    <style>
        .table-content table tbody tr td:nth-child(5){
            white-space: normal;
            min-width: 300px;
        }
    </style>
@endpush

