<div class="inner-content">

    <div class="header-formulir h-60px bg-green d-flex gap-2 align-items-center justify-content-between px-3">
        <div class="left-header">
            <a href="{{ route('/') }}" class="d-flex align-items-center gap-3 text-white">
                <span><i class="fa-solid fa-arrow-left"></i></span>
                <span>Formulir Rencana Tindak lanjut</span>
            </a>
        </div><!-- /.left-header -->        
    </div><!-- /.header-formulir -->

    <div class="content-formulir my-5">

        <div class="title-form text-center mb-3">
            <h5>FORMULIR RENCANA TINDAK LANJUT KETIDAKSESUAIAN AUDIT</h5>
            <h5>PENERAPAN SISTEM MANAJEMEN KESELAMATAN DAN KESEHATAN KERJA</h5>
        </div><!-- /.title-form -->

        <div class="formulir-content-wrapper py-5">

            <div class="container">

                <div class="row justify-content-center">

                    <div class="col-sm-12">

                        <div class="header-content mb-5">

                            <div class="content-form d-flex flex-column gap-3">
            
                                <div class="row form-group">    
                                    <label for="nama_perusahaan" class="col col-form-label">Nama Perusahaan</label>
                                    <div class="col-8">
                                        <x-inputs.text wire:model="nama_perusahaan" id="nama_perusahaan" placeholder="Nama Perusahaan" :error="'nama_perusahaan'" />
                                    </div>
                                </div><!-- /.form-group nama_perusahaan -->
            
                                <div class="row form-group">    
                                    <label for="tanggal_audit" class="col col-form-label">Tanggal Pelaksanaan Audit</label>
                                    <div class="col-8">
                                        <x-inputs.datepicker wire:model="tanggal_audit" id="tanggal_audit" :error="'tanggal_audit'" />
                                    </div>
                                </div><!-- /.form-group tanggal_audit -->
            
                            </div><!-- /.content-form -->
            
                        </div><!-- /.header-content -->

                        <div class="table-formulir-wrapper">

                            <div class="table-content table-responsive position-relative" >
            
                                <div class="table-wrapper overflow-auto">
                          
                                    <table class="table table-bordered align-items-center table-sm">
                                        <thead class="sticky-top">
                                            <tr>
                                                <th class="sticky-top"></th>
                                                <th class="sticky-top">
                                                    <div class="column-sort d-flex justify-content-between">                                       
                                                        <span>Nama</span>
                                                        <span>
                                                            <button class="btn border-0 p-0" type="button" data-bs-toggle="dropdown" aria-expanded="false" >
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
                                                    demo th
                                                </th>
                                                <th class="sticky-top">
                                                    demo th
                                                </th>
                                                <th class="sticky-top">
                                                    demo th
                                                </th>
                                                <th class="sticky-top">
                                                    demo th
                                                </th>
                                                <th class="sticky-top">
                                                    demo th
                                                </th>
                                            </tr>
                                        </thead>
                                        <tbody>
              
                                            @foreach ($users as $itemIndex => $items)
                                            
                                                <tr wire:key="{{ $itemIndex }}">
                                                    <td class="td-check">
                                                        {{ $itemIndex + 1 }}
                                                    </td>                          
                                                    <td class="title">{{$items['name']}}</td>
                                                    <td>{{$items['email']}}</td>
                                                    <td>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Ipsa</td>
                                                    <td>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Ipsa</td>
                                                    <td>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Ipsa</td>
                                                    <td>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Ipsa</td>
                                                    <td>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Ipsa</td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                    
                                </div><!-- /.table-wrapper -->
                        
                            </div><!-- /.table-content-->     

                        </div><!-- /.table-formulir-wrapper -->

                    </div><!-- /.col-sm-8 -->

                </div><!-- /.row -->

            </div><!-- /.container -->            

        </div><!-- formulir-content-wrapper -->

    </div><!-- /.content-formulir -->


</div>
