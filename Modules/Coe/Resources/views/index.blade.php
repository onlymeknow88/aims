@extends('coe::layouts.master')

@section('content')
    <h1>Hello World</h1>

    <p>
        This view is loaded from module: {!! config('coe.name') !!}
    </p>
@endsection
