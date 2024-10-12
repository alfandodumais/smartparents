@extends('layouts.app')

@section('content')
    <h1>{{ $video->title }}</h1>
    <div class="mb-3">
        {{-- <img src="{{ asset('storage/' . $video->thumbnail) }}" alt="Thumbnail" class="img-fluid"> --}}
    </div>
    <video src="{{ asset('storage/' . $video->video_path) }}" controls class="w-100" height="500"></video>
    
@endsection
