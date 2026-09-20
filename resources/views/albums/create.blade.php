@extends('layouts.app')

@section('content')
    <h3 class="mb-3">Create Album</h3>
    <form method="POST" action="{{ route('albums.store') }}" class="card card-body">
        @include('albums._form')
    </form>
@endsection