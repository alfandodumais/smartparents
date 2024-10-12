@extends('admin.layouts.app')

@section('content')
    <h1>View Video</h1>
    <div class="card">
        {{-- <img src="{{ asset('storage/' . $video->thumbnail) }}" class="card-img-top" alt="Thumbnail"> --}}
        <div class="card-body">
            <h5 class="card-title">{{ $video->title }}</h5>
            <p class="card-text">Price: @currency($video->price)</p>
            <video controls class="w-100" height="400" preload="metadata">
                <source src="{{ asset('storage/' . $video->video_path) }}" type="video/mp4"> <!-- Pastikan tipe MIME sesuai -->
                Your browser does not support the video tag.
            </video>
            <p class="mt-3">Uploaded By: {{ $video->user->name }}</p>
            <p>Uploaded At: {{ $video->created_at->format('d M Y') }}</p>
        </div>
    </div>
    <a href="{{ route('admin.videos.index') }}" class="btn btn-secondary mt-3">Back</a>
@endsection
