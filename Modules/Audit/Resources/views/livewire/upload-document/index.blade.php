<x-slot name="sidebar">
    @livewire('audit::layouts.sidebar-'.$category,['id'=>$audit->id])
</x-slot>

<div class="inner-content">
    @include('audit::livewire.layouts.breadcrumb',[
        'trees'=>[
            ['name'=>'Audit','url'=>route('audit::dashboard')],
            ['name'=>strtoupper($category),'url'=>route('audit::'.$category.'.index')],
            ['name'=>$audit->title,'url'=>route('audit::'.$category.'.detail.index',['id'=>$audit->id])],
            ['name'=>ucwords($title)],
        ]
    ])
    <div class="addnew-maker-content container-fluid py-3 px-1" id="init">
        <div class="row justify-content-center mb-5">
            <div class="col-10">
                <div class="row">
                    <div class="title-form text-center mb-3 p-3">
                        <h3>{{strtoupper($title)}}</h3>
                    </div>
                </div>
                <div class="row">
                    <div class="col-2">
                        Judul
                    </div>
                    <div class="col-8">
                        : {{$audit->title}}
                    </div>
                </div>
                <div class="row">
                    <div class="col-2">
                        Nama Perusahaan
                    </div>
                    <div class="col-8">
                        : {{$audit->company->company_name}}
                    </div>
                </div>
                <div class="row">
                    <div class="col-2">
                        Tanggal Audit
                    </div>
                    <div class="col-8">
                        : {{date('d F Y',strtotime($audit->start_at))}} - {{date('d F Y',strtotime($audit->end_at))}}
                    </div>
                </div>
            </div>
        </div>
        <div class="row justify-content-center">
            <div class="col-10">
                <form wire:submit.prevent='saveDoc' id="form-audit-init" enctype="multipart/form-data">

                    <div class="card">
                        <div class="card-body">
                            @foreach($documents as $document)
                                <div class="form-group mb-3">
                                    <div class="border p-3">
                                        <h5>Download File</h5>
                                        {{ $document->original_name }} | {{date('d F Y H:i:s',strtotime($document->created_at))}}
                                        <a class="btn btn-secondary btn-sm" target="_blank"
                                        href="{{route('audit::'.$category.'.detail.'.$module.'.download',['id'=>$audit->id,'notice_id'=>$document->id])}}"> <i class="fa fa-download"></i></a>
                                        <button class="btn btn-sm btn-danger" wire:click.prevent="delete('{{$audit->id}}','{{$document->id}}')"> <i class="fa fa-trash"></i></button>
                                    </div>
                                </div>
                            @endforeach
                            <div class="form-group mb-3">
                                <label for="doc" class="form-label">Upload {{ucwords($title)}}</label>
                                <button class="btn btn-outline-upload w-100 position-relative h-128px" type="button">
                                @if($doc)
                                        <span>{{$doc->getClientOriginalName()}}</span>
                                    @endif
                                    <span><img src="{{asset('/images/icons/upload.png')}}" alt="image upload" /></span>
                                    <span class="text-upload">Drop or <a href="#">Select File</a></span>
                                    <input type="file" wire:model.defer="doc" id="doc" />
                                </button>
                            </div>
                                <div class="form-group d-flex justify-content-end gap-2">
                                    <!-- <button type="button" class="btn btn-outline-secondary">Save as Draft</button> -->
                                    <button class="btn btn-outline-success bg-green text-white bg-hover-light-success"
                                            wire:loading.remove wire:target='saveDoc'
                                            type="button" wire:click="saveDoc" >
                                        Simpan
                                    </button>
                                    <x-button-spinner
                                        target="saveStatus"
                                        :text="trans('global.processing')"></x-button-spinner>
                                </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

