@section('title')
    {{ $data->title }}
@endsection

<div class="inner-dashboard px-3 body-content">

    <div class="row justify-content-center">

        <div class="col-sm-7">

            <nav class="navbar  navbar-dark container-fluid  bg-transparent m-0" style="height:60px">
                <div class="container-fluid">
                    <!-- Start Toggle -->
                    <div class=" d-flex align-items-center gap-3">
                        <a href="{{ url('/') }}" class="nav-back text-secondary pr-3"> <i
                                class="fas fa-arrow-left fa-2x"></i> </a>
                        <span class="text-secondary pl-3 index-title">Dashboard</span>
                    </div>
                </div>
            </nav>

            <hr>

            <div class="row">

                <div class="col-sm-12">
                    <div class="show">

                        @if ($data->url)
                            <img class="img" src="{{ url($data->url) }}" alt="Image" width="100%" srcset="{{ url($data->url) }}">
                        @endif

                        <div class="title"> {{ $data->title }} </div>
                        <div class="meta-blog"><span class="date-create">{{ $data->post_at }}</span>
                            <span></span>
                        </div>
                        <div class="description  mt-3"> {!! $data->description !!}</div>
                    </div>
                </div><!-- /.col main content -->

            </div><!-- /.row -->
        </div>
    </div><!-- row justify-center -->

</div><!-- /.inner-dashboard -->

@once
    @push('styles')
        <style>
            .body-content {
                padding: 30px 0 60px 0;
            }

            .body-content .navbar {
                margin-bottom: 10px !important;
            }

            .body-content .navbar .index-title {
                font-size: 18px;
                font-weight: 500;
                color: rgba(50, 49, 48, 1) !important;
            }

            .body-content .navbar .nav-back i {
                font-size: 18px;
                color: rgba(50, 49, 48, 1) !important;
            }

            .body-content .show {
                padding-top: 20px;
            }

            .body-content .show .title {
                font-size: 32px;
                font-weight: 700;
                color: rgba(50, 49, 48, 1);
                line-height: 1.5;
                padding: 15px 0;
            }

            .body-content .show .description {
                color: rgba(50, 49, 48, .8);
                font-weight: 400;
            }

            .body-content .show .meta-blog {
                color: rgba(50, 49, 48, .8);
                font-weight: 400;
                font-size: 14px;
                border: 1px solid #dddddd;
                border-right-width: 0;
                border-left-width: 0;
                padding: 15px 0;
            }
        </style>
    @endpush
@endonce
