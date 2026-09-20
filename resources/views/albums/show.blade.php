@extends('layouts.app')

@section('content')
    <div class="d-flex justify-content-between align-items-start mb-3">
        <div>
            <h3 class="mb-0">{{ $album->title }}</h3>
            <p class="text-muted mb-0">{{ $album->description }}</p>
        </div>
        <div class="d-flex gap-2">
            <a href="{{ route('albums.edit', $album) }}" class="btn btn-outline-secondary btn-sm">Edit</a>
            <form method="POST" action="{{ route('albums.destroy', $album) }}"
                  onsubmit="return confirm('Delete this album and all its photos?')">
                @csrf @method('DELETE')
                <button class="btn btn-outline-danger btn-sm">Delete</button>
            </form>
        </div>
    </div>

    {{-- Upload box --}}
    <form method="POST" action="{{ route('albums.photos.store', $album) }}"
          enctype="multipart/form-data" class="card card-body mb-4">
        @csrf
        <label class="form-label fw-semibold">Upload photos (max 20, 5 MB each)</label>
        <input type="file" id="photoInput" name="photos[]" multiple accept="image/*"
               class="form-control @error('photos') is-invalid @enderror @error('photos.*') is-invalid @enderror">
        @error('photos') <div class="invalid-feedback">{{ $message }}</div> @enderror
        @foreach ($errors->get('photos.*') as $messages)
            @foreach ($messages as $m)
                <div class="text-danger small">{{ $m }}</div>
            @endforeach
        @endforeach

        <div id="preview" class="row g-2 mt-2"></div>

        <div class="mt-3">
            <button class="btn btn-primary" id="uploadBtn">Upload</button>
        </div>
    </form>

    {{-- Gallery grid --}}
    <div class="row g-3">
        @forelse ($photos as $photo)
            <div class="col-6 col-md-3 col-lg-2">
                <div class="card shadow-sm">
                    <img src="{{ $photo->thumbnail_url }}" class="thumb card-img-top" alt="{{ $photo->original_name }}"
                         data-full="{{ $photo->url }}" data-bs-toggle="modal" data-bs-target="#lightbox">
                    <div class="card-body p-2 d-flex justify-content-between align-items-center">
                        <small class="text-muted">{{ number_format($photo->size / 1024) }} KB</small>
                        <form method="POST" action="{{ route('photos.destroy', $photo) }}"
                              onsubmit="return confirm('Delete this photo?')">
                            @csrf @method('DELETE')
                            <button class="btn btn-sm btn-outline-danger py-0">✕</button>
                        </form>
                    </div>
                </div>
            </div>
        @empty
            <p class="text-muted">No photos in this album yet.</p>
        @endforelse
    </div>

    <div class="mt-4">{{ $photos->links() }}</div>

    {{-- Lightbox --}}
    <div class="modal fade" id="lightbox" tabindex="-1">
        <div class="modal-dialog modal-xl modal-dialog-centered">
            <div class="modal-content bg-dark">
                <div class="modal-body p-0 text-center">
                    <img id="lightboxImg" src="" class="img-fluid" alt="">
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
<script>
    // Live preview of selected files
    const input = document.getElementById('photoInput');
    const preview = document.getElementById('preview');

    input.addEventListener('change', () => {
        preview.innerHTML = '';
        [...input.files].forEach(file => {
            if (!file.type.startsWith('image/')) return;
            const reader = new FileReader();
            reader.onload = e => {
                const col = document.createElement('div');
                col.className = 'col-4 col-md-2';
                col.innerHTML = `<img src="${e.target.result}" class="thumb rounded border">`;
                preview.appendChild(col);
            };
            reader.readAsDataURL(file);
        });
    });


    input.form.addEventListener('submit', () => {
        const btn = document.getElementById('uploadBtn');
        btn.disabled = true;
        btn.textContent = 'Uploading...';
    });

    document.getElementById('lightbox').addEventListener('show.bs.modal', e => {
        document.getElementById('lightboxImg').src = e.relatedTarget.dataset.full;
    });
</script>
@endpush