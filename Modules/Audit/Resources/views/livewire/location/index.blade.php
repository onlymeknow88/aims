<x-slot name="sidebar">
    @livewire('audit::layouts.sidebar-'.$category,['id'=>$audit->id])
</x-slot>
<div class="inner-content">
    @include('audit::livewire.layouts.breadcrumb',[
        'trees'=>[
            ['name'=>'Audit','url'=>route('audit::dashboard')],
            ['name'=>strtoupper($category),'url'=>route('audit::'.$category.'.index')],
            ['name'=>$audit->title],
        ]
    ])
    @include('audit::livewire.location.modal_location')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-sm-8">
                <form wire:submit.prevent='store' id="form-audit-init" class="py-4 d-flex flex-column gap-5">
                    <div class="title-form text-center mb-3">
                        <h4>{{$audit->audit_number}}</h4>
                    </div><!-- /.title-form -->

                    <div class="content-form d-flex flex-column gap-3">
                        <h5>Master Lokasi</h5>

                        <div class="table-maker">
                            <div class="toolbar-tables border-top border-bottom d-flex justify-content-between p-2 sticky-top">
                                <div class="toolbar-right d-flex align-items-center">
                                    <a
                                            href="#"
                                            class="button-toolbar d-flex gap-2 align-items-center py-2 px-3 bg-success text-white" data-bs-toggle="modal"
                                        data-bs-target="#modalFormLocation">
                                        <span class="text-button">Add Lokasi</span>
                                    </a>


                                </div><!-- /.toolbar-left -->

                                <div class="toolbar-right d-flex align-items-center">


                                </div><!-- /.toolbar-right -->

                            </div><!-- /.toolbar-tables -->

                            <div class="table-content table-responsive position-relative">

                                <div class="table-wrapper">

                                    <table class="table overflow-auto" id="table-mandays">
                                        <thead>
                                        <tr>
                                            <th style="width: 5%;" rowspan="2">No</th>
                                            <th class="text-center">Nama Lokasi</th>
                                            <th style="width: 10%;" class="text-center">Action</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        @forelse($audit->locations as $location)
                                            <tr>
                                                <td>{{++$loop->index}}</td>
                                                <td>{{$location->location}}</td>
                                                <td>
                                                    <button type="button" class="btn btn-secondary btn-small" wire:click="editLocation('{{$location->id}}')"><i class="fa fa-edit"></i>
                                                    </button>
                                                    <button type="button" class="btn btn-danger btn-small ml-1"
                                                            wire:click="deleteConfirmation('{{$location->id}}')">&times;
                                                    </button>
                                                </td>

                                            </tr>
                                        @empty
                                            <tr>
                                                <td colspan="3" class="text-center">@lang('global.no_entry_found')</td>
                                            </tr>
                                        @endforelse
                                        </tbody>
                                    </table>

                                    
                                </div><!-- /.table-wrapper -->

                            </div><!-- /.table-content-->

                        </div><!-- /.table-maker -->

                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@push('scripts')
    <script>
        window.addEventListener('closeModal', event => {
            $('.modal').modal('hide');
        });
        window.addEventListener('openLocationModal', event => {
            $('#modalFormLocation').modal('show');
        });
    </script>

    <script>
        window.addEventListener('deleteLocation', (detail) => {

            newSwal.fire({
                title: 'Lokasi akan di hapus',
                text: detail.detail.text,
                icon: 'info',
                showCancelButton: true,
                confirmButtonText: "Yes",
                cancelButtonText: "No",
                allowOutsideClick: () => !Swal.isLoading(),
                preConfirm: function(result) {
                    if (result) {
                        return @this.call('deleteLocation');
                    }
                },
            });
        });
    </script>
@endpush
