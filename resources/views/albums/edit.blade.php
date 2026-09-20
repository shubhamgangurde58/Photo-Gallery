@extends('layouts.app')

@section('content')
    <h3 class="mb-3">Edit Album</h3>
    <form method="POST" action="{{ route('albums.update', $album) }}" class="card card-body">
        @method('PUT')
        @include('albums._form')
    </form>
@endsection