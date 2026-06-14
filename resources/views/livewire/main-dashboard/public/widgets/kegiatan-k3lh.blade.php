<div class="k3lh-activity">
    <div class="container-right-top">
        <h6>Kegiatan K3LH</h6>
        <div class="item">
            <a href="{{ route('k3lh_activities_public_index') }}"> Show all</a>
        </div>
    </div><!-- /.coe-list-title -->

    <div class="k3lh-activity-body"> {{--  style="text-align: justify;" --}}
        @foreach ($data as $list)
            @if ($list['url'] && !is_array($list['url']))
                <a href="{{ route('k3lh_activities_public_show', $list->slug) }}">
                    <img class="k3lh-activity-img" src="{{ url($list['url']) }}" alt="">
                </a>
            @endif
        @endforeach
    </div>

</div>

@push('styles')
    <style>
        .k3lh-activity-body {
            display: flex;
            flex-wrap: wrap;
        }

        .k3lh-activity-body a:nth-child(1),
        .k3lh-activity-body a:nth-child(2),
        .k3lh-activity-body a:nth-child(3),
        .k3lh-activity-body a:nth-child(4) {
            display: flex;
            width: 25%;
            object-fit: contain;
        }

        .k3lh-activity-body a:nth-child(5),
        .k3lh-activity-body a:nth-child(6),
        .k3lh-activity-body a:nth-child(7) {
            display: flex;
            width: 33%;
            object-fit: contain;
        }

        .k3lh-activity-body a img {
            width: 100%;
        }
    </style>
@endpush
