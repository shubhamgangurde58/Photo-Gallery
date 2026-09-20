@extends('layouts.app')

@section('content')
    <h3 class="mb-3">Albums</h3>

    <div class="row g-4">
        @forelse ($albums as $album)
            <div class="col-sm-6 col-lg-3">
                <a href="{{ route('albums.show', $album) }}" class="text-decoration-none text-dark">
                    <div class="card h-100 shadow-sm">
                        @if ($album->coverPhoto)
                            <img src="{{ $album->coverPhoto->thumbnail_url }}" class="card-img-top album-cover" alt="">
                        @else
                            <div class="placeholder-cover d-flex align-items-center justify-content-center text-muted">
                                No photos yet
                            </div>
                        @endif
                        <div class="card-body">
                            <h6 class="card-title mb-1">{{ $album->title }}</h6>
                            <small class="text-muted">{{ $album->photos_count }} photo(s)</small>
                        </div>
                    </div>
                </a>
            </div>
        @empty
            <p class="text-muted">No albums yet. Create your first one!</p>
        @endforelse
    </div>

    <div class="mt-4">{{ $albums->links() }}</div>
@endsection