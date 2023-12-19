@extends('template_preview')

@section("content")
    <div id="ve-components">
        @foreach($blocs as $bloc)
            @include('blocs.'.$bloc['_name'], $bloc)
        @endforeach
    </div>
@endsection
