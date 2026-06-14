<html>

<head>
    <title>{{ $title }}</title>
</head>

<body>

    @if ($type == 'login')
        <a href="{{ route('coe') }}">Link untuk user login</a>
    @else
        <a href="http://127.0.0.1:8000/coe/inv?ids=@foreach ($ids as $id){{ $id }}, @endforeach">Link untuk user non login</a>
    @endif

</body>

</html>
