<x-slot name="sidebar">
    @livewire('audit::layouts.sidebar')
</x-slot>

<div class="inner-content">
    @include('audit::livewire.layouts.breadcrumb',[
        'trees'=>[
            ['name'=>'Audit','url'=>route('audit::dashboard')],
            ['name'=>strtoupper($category),'url'=>route('audit::'.strtolower($category).'.index')],
            ['name'=>'Glossary'],
        ]
    ])
    <div class="addnew-maker-content container-fluid py-3 px-1" id="init">

        <div class="row justify-content-center mb-5">
            <div class="col-10">
                <div class="row">
                    <div class="title-form text-center mb-3 p-3">
                        <h3>GLOSSARY {{strtoupper($category)}}</h3>
                    </div>
                </div>
            </div>
        </div>
        <div class="row justify-content-center mb-5">
            <div class="col-10">
                <form wire:submit.prevent='saveDoc' id="form-audit-init" enctype="multipart/form-data">

                    <div class="card">
                        <div class="card-body">

                            <div class="row form-group mb-3">
                                <label for="document_name" class="col-2 col-form-label">Nama Dokumen</label>
                                <div class="col-6">
                                    <x-inputs.text
                                        id="document_name"
                                        error="document_name"
                                        wire:model='document_name'
                                        placeholder="Nama Dokumen"></x-inputs.text>
                                    </div>
                                </div>
                            <div class="form-group mb-3">
                                <label for="doc" class="form-label">Upload Dokumen</label>
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

        <div class="row justify-content-center mb-5">
            <div class="col-10">
                <div class="card">
                    <div class="card-body">
                        <table class="table table-bordered align-items-center table-sm">
                            <thead class="thead-light">
                                <tr style="border-left:1px solid #dddddd;">
                                    <th style="width:40px;padding-left:8px">#</th>
                                    <th style="padding-left:8px">Nama Dokumen</th>
                                    <!-- <th>Link</th> -->
                                    <th style="width:50px;text-align:center">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($documents as $document )
                                    <tr>
                                        <td>
                                            {{$loop->index + 1}}
                                        </td>
                                        <td>
                                                {{$document->document_name}}

                                        </td>

                                        <td>
                                        <a class="btn btn-secondary btn-sm" target="_blank"
                                        href="{{route('audit::glossary.download',['id'=>$document->id])}}"> <i class="fa fa-download"></i></a>
                                        <a class="btn btn-info btn-sm text-white" href="javascript:void(0)"
                                        onclick="previewBlobFile('{{$document->id}}', '{{$document->document_name}}', 'glossary')" data-id="{{$document->id}}" data-type="glossary">
                                            <i class="fa fa-eye"></i>
                                        </a>
                                        <button type="button" class="btn btn-danger btn-sm"><i
                                                                class="fa fa-trash"
                                                                wire:click="delete('{{$document->id}}')"></i>
                                                        </button>
                                        </td>
                                    </tr>
                                @endforeach
                           </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

