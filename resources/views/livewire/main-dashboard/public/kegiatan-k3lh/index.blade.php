<div class="news-update  rounded-4">


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
                    <!-- center -->
                    <div class="d-flex text-danger">

                    </div>
                    <!-- end -->
                    <div>
                        <div class="d-flex">
                            {{-- <div class="m-1 ">
                                <div class="container-search">
                                    <input type="text" class="search-class" />
                                    <i class="fas fa-search icon"></i>
                                </div>
                            </div> --}}
                        </div>
                    </div>
                </div>
            </nav>
            @foreach ($data as $list)
                <a href="{{ route('k3lh_activities_public_show', $list->slug) }}">
                    <img class="k3lh-activity-index" src="{{ url($list->url) }}" alt="">
                </a>
            @endforeach

            {{--             <div class="grid-container-k3lh-index">
                @foreach ($data as $index => $list)
                    <a class="item-grid" href="{{ route('k3lh_activities_public_show', $list->slug) }}"
                        style="background-image: url({{ $list->url }}); background-repeat: no-repeat;   background-size: 100% 100%; ">
                    </a>
                @endforeach
            </div> --}}

            <div>
                {{ $data->links('pagination::bootstrap-5') }}
            </div>
        </div>
    </div>

    @push('styles')
        <link rel="stylesheet" href="{{ asset('assets/css/main-dashboard.css') }}" />
        <link rel="stylesheet" href="{{ asset('assets/css/dashboard.css') }}">
    @endpush

</div><!-- /.news-update -->
