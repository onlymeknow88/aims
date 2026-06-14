<div class="news-update-index rounded-4">

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
                            <div class="m-1 ">
                                <div class="container-search">
                                    <input wire:model="search" type="text" class="search-class"
                                        placeholder="Pencarian Berita" />
                                    <i class="fas fa-search icon"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </nav>

            <hr>

            @foreach ($data as $index => $list)
                <a href="{{ route('news_and_update_show',$list->slug) }}">
                    @if ($index != 0)
                        <hr>
                    @endif
                    <div class="grid-container-news-update-index text-secondary row align-items-center">
                        <div class="item-grid col-lg-8 col-sm-12">
                            <div class="item-grid-title">{{ $list['title'] }}</div>
                            <div class="item-grid-body">{{ $list['description'] }}</div>
                            <div class="item-grid-footer"><span class="date-create">{{ $list['post_at'] }}</span>
                                <span></span>
                            </div>
                        </div>

                        <div class="item-grid-image col-lg-4 col-sm-12">
                            <img class="img-responsive" src="{{ $list['url'] }}" alt="{{ $list['title'] }}" />
                        </div>

                    </div>

                </a>
            @endforeach

            <div class="pagination">

            </div>

        </div>
    </div>


</div><!-- /.news-update -->

@push('styles')
    <style>
        .news-update-index {
            padding: 30px 0 60px 0;
        }

        /** search news*/
        .container-search {
            position: relative;
            color: white;
        }

        .container-search>.search-class {
            border-radius: 30px;
            border: 1px solid rgba(242, 243, 248, 1);
            background: rgba(242, 243, 248, 1);
            height: 40px;
            padding: 15px 15px 15px 35px;
        }

        .container-search>.icon {
            position: absolute;
            bottom: 12px;
            left: 12px;
            color: #6c757d;
            z-index: 10;
        }

        .container-right-top {
            position: relative;
            color: white;
        }

        .container-right-top>.item {
            position: absolute;
            top: 0px;
            right: 10px;
            color: rgb(128, 128, 128);
        }

        .news-update-index .navbar {
            margin-bottom: 30px !important;
        }

        .news-update-index .navbar .index-title {
            font-size: 18px;
            font-weight: 500;
            color: rgba(50, 49, 48, 1) !important;
        }

        .news-update-index .navbar .nav-back i {
            font-size: 18px;
            color: rgba(50, 49, 48, 1) !important;
        }

        .item-grid {
            display: flex;
            flex-direction: column;
            gap: 10px;
        }

        .item-grid .item-grid-title {
            font-size: 16px;
            font-weight: 700;
            color: rgba(50, 49, 48, 1);
        }

        .item-grid .item-grid-body {
            color: rgba(50, 49, 48, .8);
            font-weight: 400;
        }

        .item-grid .item-grid-footer {
            color: rgba(50, 49, 48, .8);
            font-weight: 400;
            font-size: 14px;
        }

        .item-grid-image img {
            width: 100%;
            object-fit: cover;
            border-radius: 12px;
        }
    </style>
@endpush
