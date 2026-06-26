<div class="slider-wrapper">

    <div id="dashboardCarousel" class="carousel slide" data-bs-ride="carousel">
        <div class="carousel-inner">
            <div class="carousel-item active">
                <video controls autoplay loop muted>
                    <source src="{{ asset('images/videos/video-1.mp4') }}" type="video/mp4">
                </video>
            </div>
            <div class="carousel-item">
                <video controls autoplay loop muted>
                    <source src="{{ asset('images/videos/video-2.mp4') }}" type="video/mp4">
                </video>
            </div>
            <div class="carousel-item">
                <video controls autoplay loop muted>
                    <source src="{{ asset('images/videos/video-3.mp4') }}" type="video/mp4">
                </video>
            </div>
        </div>

        <button class="carousel-control-prev" type="button" data-bs-target="#dashboardCarousel" data-bs-slide="prev">
            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
            <span class="visually-hidden">Previous</span>
        </button>

        <button class="carousel-control-next" type="button" data-bs-target="#dashboardCarousel" data-bs-slide="next">
            <span class="carousel-control-next-icon" aria-hidden="true"></span>
            <span class="visually-hidden">Next</span>
        </button>
    </div>

</div><!-- /.slider-wrapper -->

@push('styles')
    <style>
        .dashboard-wrapper #dashboardCarousel.slide .carousel-item {
            max-width: 100%;
        }

        .dashboard-wrapper #dashboardCarousel.slide .carousel-item video {
            width: 100%;
            height: 100%;
        }
    </style>
@endpush

@push('scripts')
    <script type="text/javascript">
        let allVids = $("#dashboardCarousel").find('.carousel-item');

        allVids.each(function (index, el) {
            if (index !== 0) {
                $(this).find('video')[0].pause();
            }
        });

        $("#dashboardCarousel").on('slide.bs.carousel', function (ev) {
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