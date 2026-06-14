<x-slot name="sidebar">
    @include('audit::livewire.layouts.sidebar')
</x-slot>
@push('styles')
    <style>
        .card {
            border-radius: 5px;
            -webkit-box-shadow: 0 1px 2.94px 0.06px rgba(4,26,55,0.16);
            box-shadow: 0 1px 2.94px 0.06px rgba(4,26,55,0.16);
            border: none;
            margin-bottom: 30px;
            -webkit-transition: all 0.3s ease-in-out;
            transition: all 0.3s ease-in-out;
        }

        .card .card-block {
            padding: 25px;
        }

        .order-card {
            color: #fff;
        }

        .order-card i {
            font-size: 26px;
        }

      

        .bg-c-blue {
            background: linear-gradient(45deg,#4099ff,#73b4ff);
        }

        .bg-c-green {
            background: linear-gradient(45deg,#2ed8b6,#59e0c5);
        }

        .bg-c-yellow {
            background: linear-gradient(45deg,#FFB64D,#ffcb80);
        }

        .bg-c-pink {
            background: linear-gradient(45deg,#FF5370,#ff869a);
        }

        .f-left {
            float: left;
        }

        .f-right {
            float: right;
        }
    </style>
    
@endpush
<div class="inner-content">
    @include('audit::livewire.layouts.breadcrumb',[
        'trees'=>[
            ['name'=>'Audit'],
           {{--  ['name'=>'Dashboard'] --}}
        ]
    ])
    <div class="container">
        <div class="row justify-content-center mb-5">
            <div class="col-sm-12">
                <div class="row">
                    <div class="title-form text-center mb-3 p-3">
                    <h3>AIMS - AUDIT</h3>
                    </div>
                </div>
                
            </div>
        </div>
        <div class="row justify-content-left mb-5">
            @foreach ($counts as $count )
                <div class="col-md-4 col-xl-3 mb-3">
                    <div class="card bg-c-{{$count['color']}} order-card">
                        <div class="card-block">
                            <h5 class="m-b-20">{{$count['category']}}</h5>
                            <h2 class="text-right"></i><span>{{$count['total']}}</span></h2>
                            <!-- <p class="m-b-0"><span class="f-right">351</span></p> -->
                            <a href="{{ route('audit::'.strtolower($count['category']).'.index') }}" type="button"
                                class="button-toolbar d-flex gap-2 align-items-center py-2 px-3">
                                <span class="icon d-flex align-items-center">
                                    <img src="{{asset('images/icons/add.png')}}" alt="image add">
                                </span>
                                <span class="text-button">List</span>
                            </a>  
                            <a href="{{route('audit::'.strtolower($count['category']).'.dashboard') }}" type="button"
                                class="button-toolbar d-flex gap-2 align-items-center py-2 px-3">
                                <span class="icon d-flex align-items-center">
                                    <img src="{{asset('images/icons/view.png')}}" alt="image add">
                                </span>
                                <span class="text-button">Dashboard</span>
                            </a>  
                        </div>
                    </div>
                </div>
                
            @endforeach
        </div>
       
    </div>

</div>

