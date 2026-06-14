<div class="inner-content">

    <div class="header-add-maker h-60px bg-green d-flex gap-2 align-items-center justify-content-between px-3">
        <div class="left-header">
            <a href="{{ route('maker') }}" class="d-flex align-items-center gap-3 text-white">
                <span><i class="fa-solid fa-arrow-left"></i></span>
                <span>Dokumen Kebijakan</span>
            </a>
        </div><!-- /.left-header -->
        <div class="right-header">
            <div class="text-white">Last update Sep 24, 2022 . 15.00 pm</div>
        </div><!-- /.right-header -->
        
    </div>

    <div class="addnew-maker-content container py-5 px-3">

        <div class="row justify-content-center">

            <div class="col-8">

                <form action="#" class="form-horizontal"  enctype="multipart/form-data">

                    <div class="own-info mb-5">

                        <div class="mb-5">
                            <h5 class="fw-normal">Owner Information</h4>
                        </div>

                        <div class="mb-3 row form-group required">

                            <label for="company" class="col-sm-4 col-form-label">Company</label>

                            <div class="col-sm-8">

                                <x-inputs.select2 wire:model="company" id="company" placeholder="Select Company">

                                    @foreach ($companies as $key => $company)
                                        <option value="{{ $company['id'] }}" @if($company['id'] == $company) 'selected' @else not-selected @endif >{{$company['name']}}</option>
                                    @endforeach

                                </x-inputs.select2>

                            </div>

                        </div><!-- /.form-group -->
                        
                        <div class="mb-3 row form-group required">

                            <label for="department" class="col-sm-4 col-form-label">Department</label>
                            
                            <div class="col-sm-8">

                                <x-inputs.select2 wire:model="department" id="department" placeholder="Select Department">

                                    @foreach ($departments as $key => $department)
                                        <option value="{{ $department['id'] }}">{{$department['name']}}</option>
                                    @endforeach

                                </x-inputs.select2>

                            </div>

                        </div><!-- /.form-group --> 

                        <div class="mb-3 row form-group required">

                            <label for="pj" class="col-sm-4 col-form-label">Penanggung Jawab</label>
                            
                            <div class="col-sm-8"> 

                                <x-inputs.select2-avatar wire:model="pjSelected" id="pj" name="pj" class="form-select" placeholder="Select Penanggung Jawab">

                                    @foreach ($pjs as $key => $itemPj)
                                        <option class="d-flex gap-2 align-items-center" value="{{ $itemPj['id'] }}" data-avatar="@if ($itemPj['avatar']) $itemPj['avatar'] @else {{ asset('./images/profile.png') }}  @endif" data-email="@if ($itemPj['email']) {{ $itemPj['email'] }}  @endif">{{$itemPj['name']}}</option>
                                    @endforeach

                                </x-inputs-select2-avatar >

                            </div>

                        </div><!-- /.form-group --> 

                    </div><!-- /.own-info -->

                    <div class="map-info mb-5">

                        <div class="mb-5">
                            <h5 class="fw-normal">Mapping Information</h4>
                        </div>

                        <div class="mb-3 row form-group required">

                            <label for="modules" class="col-sm-4 col-form-label">Module</label>

                            <div class="col-sm-8">

                                <x-inputs.select2 wire:model="module" id="module" class="form-select" placeholder="Select Module">

                                    @foreach ($modules as $key => $module)
                                        <option value="{{ $module['id'] }}">{{$module['name']}}</option>
                                    @endforeach

                                </x-inputs.select2>

                            </div>

                        </div><!-- /.form-group -->
                        
                        <div class="mb-3 row form-group required">

                            <label for="category" class="col-sm-4 col-form-label">Category</label>
                            
                            <div class="col-sm-8">

                                <x-inputs.select2 wire:model="category" id="category" class="form-select" placeholder="Select Category Module">

                                    @foreach ($categories as $key => $category)
                                        <option value="{{ $category['id'] }}">{{$category['name']}}</option>
                                    @endforeach

                                </x-inputs.select2>

                            </div>

                        </div><!-- /.form-group --> 

                        <div class="mb-3 row form-group required">

                            <label for="mapping" class="col-sm-4 col-form-label">Mapping</label>
                            
                            <div class="col-sm-8">

                                <x-inputs.select2 wire:model="map" id="map" class="form-select" placeholder="Select Mapping">
                                    <option value="">Select Mapping</option>
                                    @foreach ($mapping as $key => $map)
                                        <option value="{{ $map['id'] }}">{{$map['name']}}</option>
                                    @endforeach

                                </x-inputs.select2>

                            </div>

                        </div><!-- /.form-group --> 

                    </div><!-- /.map-info -->

                    <div class="doc-info mb-5">

                        <div class="mb-5">
                            <h5 class="fw-normal">Document</h4>
                        </div>

                        <div class="mb-3 row form-group">

                            <label for="jenis_upload" class="col-sm-4 col-form-label">Jenis Upload</label>

                            <div class="col-sm-8">

                                <x-inputs.select2 wire:model="jenis_upload" id="jenis_upload" class="form-select" placeholder="Select upload metode">
                                    <option value="">Select Jenis Upload</option>
                                    <option value="document">Document</option>
                                    <option value="record">Record</option>
                                </x-inputs.select2>

                            </div>

                        </div><!-- /.form-group -->

                        <div class="mb-3 row form-group">

                            <label for="jenis_doc" class="col-sm-4 col-form-label">Jenis Document</label>

                            <div class="col-sm-8">
                                <x-inputs.select2 wire:model="jenis_doc" id="jenis_doc" class="form-select" placeholder="Choose document">
                                    <option value="">Choose document</option>
                                    <option value="sop">SOP</option>
                                    <option value="other">Other</option>
                                </x-inputs.select2>
                            </div>

                        </div><!-- /.form-group -->
                        @if($jenis_doc === 'sop')

                        <div class="mb-3 row form-group">

                            <label for="sop_number" class="col-sm-4 col-form-label">SOP Number</label>
                            
                            <div class="col-sm-8">
                                <input type="text" wire:model="sop_number" class="form-control" id="sop_number" placeholder="Your ID Document" />
                            </div>

                        </div><!-- /.form-group --> 

                        <div class="mb-3 row form-group">

                            <label for="win_number" class="col-sm-4 col-form-label">WIN Number</label>
                            
                            <div class="col-sm-8">
                                <input type="text" wire:model="win_number" class="form-control" id="win_number" placeholder="Your ID Document" />
                            </div>

                        </div><!-- /.form-group --> 

                        <div class="mb-3 row form-group">

                            <label for="form_number" class="col-sm-4 col-form-label">Form Number</label>
                            
                            <div class="col-sm-8">
                                <input type="text" wire:model="form_number" class="form-control" id="form_number" placeholder="Your ID Document" />
                            </div>

                        </div><!-- /.form-group --> 

                        @endif

                    </div><!-- /.doc-info -->

                    <div class="detail-doc mb-5">

                        <div class="mb-5">
                            <h5 class="fw-normal">Detailed Document</h4>
                        </div>
                        
                        <div class="mb-3 row form-group">

                            <label for="title" class="col-sm-4 col-form-label">Title</label>
                            
                            <div class="col-sm-8">
                                <input type="text" wire:model="title" class="form-control" id="title" placeholder="Title" />
                            </div>

                        </div><!-- /.form-group --> 

                        <div class="mb-3 row form-group required">

                            <label for="title" class="col-sm-4 col-form-label">Date of Create Document</label>
                            
                            <div class="col-sm-8">
                                <x-inputs.datepicker wire:model="doc_created" id="doc_created" :error="'date'" />
                            </div>

                        </div><!-- /.form-group --> 


                    </div><!-- /.detail-doc -->

                    <div class="invited-people mb-5">

                        <div class="mb-5">
                            <h5 class="fw-normal">Invited People</h4>
                        </div>
                        
                        <div class="mb-3 row form-group">
                            
                            <div class="col-sm-12">
                                <div class="position-relative input-group">
                                    <span class="input-group-text">
                                        <i class="fa fa-envelope"></i>
                                    </span>
                                    <input class="form-control" type="email" id="invited_people" wire:model="inputInvited" wire:keydown.enter.prevent="addInvitedPeople()" />                                    
                                </div>
                            </div>

                        </div><!-- /.form-group --> 

                        <div class="mb-3 row form-group d-flex gap-3 flex-wrap">
                            @if($invitedPeople)
                                @foreach ($invitedPeople as $key => $people)
                                    <div class="list-people position-relative px-3 py-2 border rounded w-auto d-flex gap-2 align-items-center">
                                        <span class="opacity-80">{{$people}}</span>
                                        <button class="btn-closed"><img src="{{asset('/images/icons/delete.png')}}" wire:click.prevent="removeInvited('{{$people}}')" alt=""></button>
                                    </div>
                                @endforeach
                            @endif
                        </div><!-- /.form-group --> 


                    </div><!-- /.invited-people -->

                    <div class="description mb-5">

                        <div class="mb-5">
                            <h5 class="fw-normal">Description</h4>
                        </div>                    

                        <div class="mb-3 row form-group required">
                            
                            <div class="col-sm-12">
                                <x-inputs.texteditor wire:model="description" id="description" :error="'description'" />
                            </div>

                        </div><!-- /.form-group --> 


                    </div><!-- /.description -->

                    <div class="attachment mb-5">

                        <div class="mb-5">
                            <h5 class="fw-normal">Attachment</h4>
                        </div>                    

                        <div class="mb-3 row form-group required">
                            
                            <div class="col-sm-12">
                                <x-inputs.upload-files :docs="$docs" id="docs" :error="'docs'" />
                            </div>

                        </div><!-- /.form-group --> 

                    </div><!-- /.attachment -->

                    <div class="footer-action mb-2">
                        <div class="action-wrapper d-flex align-items-center justify-content-end gap-2">
                            <a href="{{ route('maker') }}" class="btn btn-outline-secondary" >Cancel</a>
                            <div class="button-document">
                                <button class="dropdown-toggle btn btn-outline-default bg-green d-flex justify-content-center align-item-center text-white position-relative px-4"  role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                    Submit Action
                                </button>
                                <ul class="dropdown-menu">
                                    <li><a class="dropdown-item" href="#">Save as draft</a></li>
                                    <li><a class="dropdown-item" href="#">Submit for review</a></li>
                                  </ul>
                            </div>                    
                        </div>
                    </div>

                </form>

            </div>

        </div>        

    </div><!---/.addnew-maker-content -->

</div>