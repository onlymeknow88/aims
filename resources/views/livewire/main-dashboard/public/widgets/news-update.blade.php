<div class="news-update">
    <div class="sp-title py-1 container-right-top">
        <h6>News & Update</h6>
        <div class="item">
            <a href="{{ route('news_and_update_public_index') }}"> Show all</a>
        </div>
    </div><!-- /.sp-title -->

    <div class="row news-update-body">
        @foreach ($data as $list)
            <a class="col-sm-12 col-lg-6" href="{{ route('news_and_update_show', $list->slug) }}">
                <div class="grid-container-news-update">
                    <div class="item-grid">
                        <div class="item-grid-title">
                            {{ $list->title }}</div>
                        <div class="item-grid-body"></div>
                        <div class="item-grid-footer">{{ $list->post_at }}</div>
                    </div>

                    @if ($list->url && !is_array($list->url))
                        <div class="item-grid"
                            style="background-image: url({{ $list->url }}); background-repeat: no-repeat;   background-size: 100% 100%; ">
                        </div>
                    @else
                        <div class="item-grid">aa </div>
                    @endif
                </div>
            </a>
        @endforeach
    </div>


</div><!-- /.news-update -->
