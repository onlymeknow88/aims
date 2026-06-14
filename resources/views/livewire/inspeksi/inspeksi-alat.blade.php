<div class="inner-content">
    
    <div class="section-content">

        <div class="section-title py-3 px-2">
            <h4>Data Inspeksi K3</h4>
        </div><!-- /.section-title -->

        <div class="content-inspeksi">
            <div x-data="{ itemSelected: @entangle('itemSelected')}">

                <div class="toolbar-tables border-top border-bottom d-flex justify-content-between p-2 sticky-top">
            
                    <div class="toolbar-left d-flex align-items-center">

                        <div class="new-wrapper">

                            <button href="#" type="button" class="button-toolbar d-flex gap-2 align-items-center py-2 px-3" data-bs-toggle="dropdown" data-bs-auto-close="outside" aria-expanded="false">
                                <span class="icon d-flex align-items-center"><img src="{{asset('images/icons/add.png')}}" alt="image add"></span>
                                <span class="text-button">Add New</span>
                            </button>

                            <ul class="dropdown-menu" wire:ignore.self>
                                <li>
                                    <form action="#">
                                    <div class="dropdown-content p-3 d-flex gap-3 flex-column">
                                        <div class="sort-search" >
                                            <div class="input-group" wire:ignore>
                                                <span class="input-group-text border-end-0"
                                                    id="search-icon">
                                                    <img src="{{ asset('images/icons/search.png') }}"
                                                        alt="Search"
                                                        srcset="{{ asset('images/icons/search.png') }}">
                                                </span>
                                                <input type="text" class="form-control"
                                                    wire:model="searcInspectionType"
                                                    id="searcInspectionType" placeholder="Cari tipe inspeksi"
                                                    aria-label="Jenis Inspeksi"
                                                    aria-describedby="search-icon">
                                            </div>
                                        </div>
                                    </div>
                                </form>
                                </li>
                                <li><a class="dropdown-item" href="{{ route('inspeksi-apar') }}">inspeksi Alat K3 APAR</a></li>
                                <li><a class="dropdown-item" href="{{ route('inspeksi-apab') }}">inspeksi Alat K3 APAB</a></li>
                                <li><a class="dropdown-item" href="{{ route('inspeksi-hydrant') }}">inspeksi Alat K3 Hydrant</a></li>
                                <li><a class="dropdown-item" href="{{ route('inspeksi-hose-rail') }}">inspeksi Alat K3 Hose Rail</a></li>
                                <li><a class="dropdown-item" href="{{ route('inspeksi-eye-wash') }}">inspeksi Alat K3 Eyewash</a></li>
                            </ul>
                        </div>
            
                        @if($countSelected > 0 )
                        <a href="#" type="button" class="button-toolbar d-flex gap-2 align-items-center py-2 px-3">
                            <span class="icon d-flex align-items-center"><img src="{{asset('images/icons/export.png')}}" alt="image export"></span>
                            <span class="text-button">Export</span>
                        </a>
            
                        <a href="#" type="button" class="button-toolbar d-flex gap-2 align-items-center py-2 px-3">
                            <span class="icon d-flex align-items-center"><img src="{{asset('images/icons/delete.png')}}" alt="image delete"></span>
                            <span class="text-button">Delete</span>
                        </a>
                        @endif
                    </div><!-- /.toolbar-left -->
            
                    <div class="toolbar-right d-flex align-items-center"> 
            
                        @if($countSelected > 0 )
                            <a href="#" type="button" class="button-toolbar d-flex gap-2 align-items-center py-2 px-3" wire:click="removeSeleced()">
                                <span class="icon d-flex align-items-center"><img src="{{asset('images/icons/delete.png')}}" alt="image delete"></span>
                                <span class="text-button">{{ $countSelected }} Row Selected</span>
                            </a>
                        @endif
            
                        <a href="#" type="button" class="button-toolbar d-flex gap-2 align-items-center py-2 px-3">
                            <span class="icon d-flex align-items-center"><img src="{{asset('images/icons/sort.png')}}" alt="image add"></span>
                        </a>
            
                        <a href="#" type="button" class="button-toolbar d-flex gap-2 align-items-center py-2 px-3">
                            <span class="icon d-flex align-items-center"><img src="{{asset('images/icons/filter.png')}}" alt="image export"></span>
                        </a>
            
                        <a href="#" type="button" class="button-toolbar d-flex gap-2 align-items-center py-2 px-3" wire:click="">
                            <span class="icon d-flex align-items-center"><img src="{{asset('images/icons/info.png')}}" alt="image info"></span>
                        </a>
            
                        <a href="#" type="button" class="button-toolbar d-flex gap-2 align-items-center py-2 px-3">
                            <span class="icon d-flex align-items-center"><img src="{{asset('images/icons/menu.png')}}" alt="image menu"></span>
                        </a>
            
                    </div><!-- /.toolbar-right -->
                    
                </div><!-- /.toolsbar-tables -->
            
                <div class="table-content table-responsive position-relative" >
            
                    <div class="table-wrapper overflow-auto">
              
                        <table class="table table-bordered align-items-center table-sm">
                            <thead class="sticky-top z-index-10">
                                <tr>
                                    <th class="sticky-top">No</th>
                                    <th class="sticky-top">
                                        <div class="column-sort d-flex justify-content-between">                                       
                                            <span>Id Identitas</span>
                                            <span>
                                                <button class="btn border-0 p-0" type="button" data-bs-toggle="dropdown" aria-expanded="false" >
                                                    <img src="{{asset("images/icons/sorting.png")}}" alt="sorting" />
                                                </button>
                                                <div class="dropdown-menu dropdown-menu-end">

                                                    <div class="dropdown-content p-3 d-flex gap-3 flex-column">          
                                                        <div class="sort-search">
                                                            <div class="input-group">
                                                                <input type="text" class="form-control" placeholder="Cari id Identitas" aria-label="Name" aria-describedby="search-icon">
                                                            </div>
                                                        </div>

                                                    </div><!--./dropdown-content-->
                                                    
                                                </div><!-- /.dropdown-menu -->
                                                
                                            </span>
                                        </div><!-- /.column-sort -->
                                    </th>
                                    <th class="sticky-top">
                                        <div class="column-sort d-flex justify-content-between">                                       
                                            <span>Tanggal</span>
                                            <span>
                                                <button class="btn border-0 p-0" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                                                    <img src="{{asset("images/icons/sorting.png")}}" alt="sorting" />
                                                </button>
                                                <div class="dropdown-menu dropdown-menu-end">

                                                    <div class="dropdown-content p-3 d-flex gap-3 flex-column">

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
                                                        <div class="sort-list d-flex gap-3 flex-column mh-200px overflow-auto">
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
                                    <th class="sticky-top">
                                        Jenis Inspeksi
                                    </th>
                                    <th class="sticky-top">
                                        CCOW    
                                    </th>
                                    <th class="sticky-top">
                                        Departemen
                                    </th>
                                    <th class="sticky-top">
                                        Section
                                    </th>
                                    <th class="sticky-top">
                                        Lokasi
                                    </th>
                                    <th class="sticky-top">
                                        Detail Lokasi
                                    </th>
                                    <th class="sticky-top">
                                        KTT
                                    </th>
                                    <th class="sticky-top">
                                        PJA
                                    </th>
                                    <th class="sticky-top">
                                        Inisiator
                                    </th>
                                    <th class="sticky-top">
                                        Keterangan Temuan
                                    </th>
                                    <th class="sticky-top">
                                        Target Closing
                                    </th>
                                    <th class="sticky-top">
                                        Settlement Date
                                    </th>
                                    <th class="sticky-top">
                                        Status
                                    </th>
                                </tr>
                            </thead>
                            <tbody>                               
                                <tr>
                                    <td class="td-check">1</td>                          
                                    <td class="title"></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                </tr>
                            </tbody>
                        </table>
                        
                    </div><!-- /.table-wrapper -->
            
                </div><!-- /.table-content-->     
                           
            </div><!-- /.item-selected -->

        </div><!-- /.content-inspeksi -->

    </div><!-- /.section-content -->
</div>
