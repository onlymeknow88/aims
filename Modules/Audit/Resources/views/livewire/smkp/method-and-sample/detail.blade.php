@push('styles')
    <style>
        td.bx-0 {
            border-left: none;
            border-right: none;
        }

        td.bl {
            border-left: 1px solid #ddd;
        }

        td.bb {
            border-bottom: 1px solid #ddd;
        }

    </style>
@endpush
<x-slot name="sidebar">
    @livewire('audit::layouts.sidebar-smkp',['id'=>$audit->id])
</x-slot>
<div class="inner-content with_right_sidebar">
    @include('audit::livewire.layouts.breadcrumb',[
     'trees'=>[
         ['name'=>'SMKP List','url'=>route('audit::smkp.index')],
         ['name'=>'SMKP Detail','url'=>route('audit::smkp.detail.index',['id'=>$audit->id])],
         ['name'=>'Metode dan Sample Audit'],
     ]
 ])
    <div class="wrapper_with_sidebar_right">

        <div class="section-content">

            <div class="row justify-content-center">

                <div class="form-wrapper col-sm-8">

                    <form class="py-4 d-flex flex-column gap-5" action="#" action="post" wire:submit.prevent='save'>

                        <div class="title-form text-center mb-3">
                            <h3>Metode dan Sampel Audit</h3>
                            <h4>{{$auditSubCriteria->title}}</h4>
                        </div><!-- /.title-form -->

                        @foreach($auditSubCriteria->sample_methods as $sampleMethod)
                            <div class="row form-group">
                                <label for="method-{{$loop->index}}" class="col col-form-label d-flex flex-column">Metode</label>
                                <div class="col-8">
                                    <input type="text" id="method-{{$loop->index}}" class="form-control"
                                           value="{{$sampleMethod->name}}" disabled>
                                </div>
                            </div><!-- /.form-group keterangan -->

                            <div class="row form-group">
                                <label for="sample-{{$loop->index}}" class="col col-form-label d-flex flex-column">Sampel</label>
                                <div class="col-8">
                                    <x-inputs.texteditor-disabled id="sample-{{$loop->index}}" error="" disabled>
                                        {{$sampleMethod->pivot->sample}}
                                    </x-inputs.texteditor-disabled>
                                </div>
                            </div><!-- /.form-group keterangan -->
                            <div class="space">
                                <hr>
                            </div>
                        @endforeach
                        <div>
                            <button type="button"
                                    class="btn btn-outline-success" wire:click="showModalCreate">+ Tambah Metode dan
                                Sampel
                            </button>
                        </div>
                    </form>
                </div><!-- /.form-wrapper -->

            </div>

        </div><!-- /.section-content-->
        <!-- end content -->

        <!-- sidebar right start -->
        @livewire('audit::layouts.sidebar-smkp-sample',['smkp'=>$audit,'selected'=>$auditSubCriteria->id])

    </div>
    @include('audit::livewire.smkp.method-and-sample.modal')
</div>
@push('scripts')
    <script>
        window.addEventListener('closeModal', event => {
            $('.modal').modal('hide');
        });

        window.addEventListener('showModal', event => {
            $('#modalFormSampel').modal('show');
        });
        
        window.addEventListener('summerNote', event => {
            $("#sample").summernote("reset");
            $(document).find('.summernote.disabled').each(function (i, e) {
                $(e).summernote({
                    height: 200,
                    toolbar: [],
                });
                $(e).summernote('disable')
            })
        });
    </script>
@endpush
