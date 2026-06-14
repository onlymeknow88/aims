<div class="px-4">
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            @isset($trees)
                @foreach($trees as $tree)
                <li class="breadcrumb-item {{$loop->last?"active":""}}"><a href="{{$tree['url']??'javascript:void(0)'}}">{{$tree['name']??"-"}}</a></li>
                @endforeach
            @endisset
        </ol>
    </nav>
</div>

