<div class="slider-wrapper">
    <div id="dashboardCarousel" class="carousel slide" data-bs-ride="carousel">
        <div class="carousel-inner ">

            @foreach ($slideshow as $index => $list)
                <div class="carousel-item @if ($index == 0) active @endif ">
                    <video class="border rounded-4" controls autoplay loop muted>
                        <source src="{{ url($list->url) }}" type="video/mp4">
                    </video>
                </div>
            @endforeach

        </div>

        <button class="carousel-control-prev" style="height:80%" type="button" data-bs-target="#dashboardCarousel"
            data-bs-slide="prev">
            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
            <span class="visually-hidden">Previous</span>
        </button>

        <button class="carousel-control-next" style="height:80%" type="button" data-bs-target="#dashboardCarousel"
            data-bs-slide="next">
            <span class="carousel-control-next-icon" aria-hidden="true"></span>
            <span class="visually-hidden">Next</span>
        </button>
    </div>

</div><!-- /.slider-wrapper -->

@push('styles')
    <style>
        .carousel>.carousel-control-prev,
        .carousel>.carousel-control-next {
            z-index: unset
        }

        .dashboard-wrapper #dashboardCarousel.slide .carousel-item {
            max-width: 100%;
            height: 350px;
            box-shadow: 0 6px 20px 0 rgba(0, 0, 0, .08);
        }

        .dashboard-wrapper #dashboardCarousel.slide .carousel-item video {
            width: 100%;
            height: 100%;
            border-radius: 12px;
            object-fit: cover;
        }
    </style>
@endpush

@push('scripts')
    <script type="text/javascript">
        let allVids = $("#dashboardCarousel").find('.carousel-item');

        allVids.each(function(index, el) {
            if (index !== 0) {
                $(this).find('video')[0].pause();
            }
        });

        $("#dashboardCarousel").on('slide.bs.carousel', function(ev) {
            let slides = $(this).find('.carousel-item');
            let pvid = slides[ev.from].querySelectorAll('video')[0];
            let vid = slides[ev.to].querySelectorAll('video')[0];
            let isPlaying = vid.currentTime > 0 && vid.readyState > 2;

            vid.play();

            if (isPlaying) {
                pvid.pause();
            }
        });
    </script>
@endpush
