@extends('admin.layouts.app')

@section('content')
    <h1>Edit Video</h1>
    <form action="{{ route('admin.videos.update', $video) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')
        
        <div class="mb-3">
            <label for="title" class="form-label">Video Title</label>
            <input type="text" class="form-control" id="title" name="title" value="{{ $video->title }}" required>
        </div>
        <div class="mb-3">
            <label for="thumbnail" class="form-label">Thumbnail</label>
            <input type="file" class="form-control" id="thumbnail" name="thumbnail" accept="image/*">
            <img src="{{ asset('storage/' . $video->thumbnail) }}" alt="Thumbnail" width="150" class="mt-2">
        </div>
        <div class="mb-3">
            <label for="video" class="form-label">Video File</label>
            <input type="file" class="form-control" id="video" name="video" accept="video/*">
            <video src="{{ asset('storage/' . $video->video_path) }}" controls class="mt-2" width="300"></video>
        </div>
        <div class="mb-3">
            <label for="price" class="form-label">Price (IDR)</label>
            <input type="number" class="form-control" id="price" name="price" min="0" step="0.01" value="{{ $video->price }}" required>
        </div>
        
        <button type="submit" class="btn btn-primary">Update Video</button>
        <a href="{{ route('admin.videos.index') }}" class="btn btn-secondary">Back</a>
    </form>
@endsection
