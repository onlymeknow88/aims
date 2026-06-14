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

                <form action="#" wire:submit.prevent='save' class="form-horizontal" method="post" enctype="multipart/form-data">

                    <div class="own-info mb-5">

                        <div class="mb-5">
                            <h5 class="fw-normal">Owner Information</h4>
                        </div>

                        <div class="mb-3 row form-group required">

                            <label for="company" class="col-sm-4 col-form-label">Company</label>

                            <div class="col-sm-8">

                                <x-inputs.select2 wire:model="company" id="company" placeholder="Select Company" data-child="department">

                                    @foreach ($companies as $key => $company)
                                        <option value="{{ $company['id'] }}">{{$company['name']}}</option>
                                    @endforeach

                                </x-inputs.select2>
                                

                            </div>

                        </div><!-- /.form-group -->
                        
                        <div class="mb-3 row form-group required"> 

                             <label for="department" class="col-sm-4 col-form-label">Department</label>
                            
                            <div class="col-sm-8">

                                <x-inputs.select2_multiple wire:model="department" id="department" placeholder="Select Department">

                                    @foreach ($departments as $key => $department)
                                        <option value="{{ $department['id'] }}">{{$department['name']}}</option>
                                    @endforeach

                                </x-inputs.select2_multiple>

                            </div>

                        </div><!-- /.form-group --> 

                        <div class="mb-3 row form-group required"> 

                            <label for="department" class="col-sm-4 col-form-label">Department</label>
                           
                           <div class="col-sm-8">

                               <x-inputs.datepicker wire:model="datepicker" id="datepicker" :error="'datepicker'" />

                           </div>

                       </div><!-- /.form-group --> 

                       <div class="mb-3 row form-group required"> 

                        <label for="department" class="col-sm-4 col-form-label">Department</label>
                       
                       <div class="col-sm-8">

                           <x-inputs.texteditor-noignore wire:model="texteditor" id="texteditor" :error="'texteditor'" data-value="{{$texteditor}}" />

                       </div>

                   </div><!-- /.form-group --> 

                    </div><!-- /.own-info -->


                    {{-- <div class="attachment mb-5">

                        <div class="mb-5">
                            <h5 class="fw-normal">Attachment</h4>
                        </div>                    

                        <div class="upload-file mb-5">
                            <x-inputs.upload_progress id="docs1" :error="'docs1'" :files="$files" />
                        </div>

                    </div><!-- /.attachment --> --}}

                    <div class="attachment mb-5">

                        <div class="mb-5">
                            <h5 class="fw-normal">Attachment</h4>
                        </div>                    

                        <div class="upload-file mb-5">
                            <input wire:model='stnk' type="file" class="form-control @error('stnk') is-invalid @enderror" id="file_upload" />
                        </div>

                    </div><!-- /.attachment -->

                    <div class="attachment mb-5">

                        <div class="mb-5">
                            <h5 class="fw-normal">Attachment</h4>
                        </div>                    

                        <div class="upload-file mb-5">
                            <input wire:model='test' type="file" class="form-control @error('test') is-invalid @enderror" id="file_upload" />
                        </div>

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
                                    <li><button type="submit" class="dropdown-item" href="#">Submit for review</button></li>
                                  </ul>
                            </div>                    
                        </div>
                    </div>

                </form>

            </div>

        </div>        

    </div><!---/.addnew-maker-content -->

</div>

@push('scripts')
    <script>
        const Toast = Swal.mixin({
            toast: true,
            position: 'top-end',
            showConfirmButton: false,
            timer: 3000,
            timerProgressBar: true,
        });
        document.addEventListener("DOMContentLoaded", () => {
            Livewire.hook('component.initialized', (component) => {
                console.log('component init');
            })
            Livewire.hook('element.initialized', (el, component) => {
                console.log('element init');
            })
            Livewire.hook('element.updating', (fromEl, toEl, component) => {
                console.log('element updating');
            })
            Livewire.hook('element.updated', (el, component) => {
                console.log('element updated');
            })
            Livewire.hook('element.removed', (el, component) => {
                console.log('element removed');
            })
            Livewire.hook('message.received', (message, component) => {
                console.log('element received');
            })
            Livewire.hook('message.processed', (message, component) => {
                console.log(component);
                $('.summernote').summernote({
                    height: 300,
                    toolbar: [
                        ['style', ['style']],
                        ['style', ['style']],
                        ['font', ['bold', 'underline', 'clear']],
                        ['color', ['color']],
                        ['para', ['ul', 'ol', 'paragraph']],
                        ['insert', ['picture', 'link']],
                    ],
                    callbacks: {
                        onChange: function(contents, $editable) {
                            $('#texteditor').val(contents)
                            //@this.set('description', contents);
                        }
                    }
                });
            })
        }); 
        document.addEventListener("DOMContentLoaded", () => {
            
            Livewire.hook('message.sent', (message, component) => {
                
                if (message.updateQueue[0].payload.method === 'startUpload') {
                    Toast.fire({
                        icon: 'success',
                        title: 'Proses Upload ' + message.updateQueue[0].payload.params[0],
                        timer: false,
                        didOpen: (toast) => {
                            Toast.showLoading();
                        }
                    });
                }

                if (message.updateQueue[0].payload.method === "finishUpload") {
                    console.log(message.updateQueue[0].payload.params[0])
                    Toast.fire({
                        icon: 'success',
                        title: 'Proses Upload ' + message.updateQueue[0].payload.params[0] + ' Success',
                        timer: 2000,
                    });
                }
                
            })

        });
        
    </script>
@endpush