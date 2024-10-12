@extends('layouts.app')

@section('content')
    <h1>Available Videos</h1>
    <div class="row">
        @foreach($videos as $video)
            <div class="col-md-3 mb-4">
                <div class="card">
                    <img src="{{ asset('storage/' . $video->thumbnail) }}" class="card-img-top" alt="Thumbnail">
                    <div class="card-body">
                        <h5 class="card-title">{{ $video->title }}</h5>
                        <p class="card-text">
                            @if($video->price > 0)
                                Price: @currency($video->price)
                            @else
                                <span class="badge bg-success">Free</span>
                            @endif
                        </p>
                        {{-- <a href="{{ route('videos.show', $video) }}" class="btn btn-primary btn-sm">View</a> --}}
                        @if($video->price > 0)
                            <a href="{{ route('purchase', $video) }}" class="btn btn-success btn-sm">Buy</a>
                        @else
                            <a href="{{ route('videos.download', $video) }}" class="btn btn-secondary btn-sm">Download</a>
                        @endif
                    </div>
                </div>
            </div>
        @endforeach
    </div>
    {{ $videos->links() }}
@endsection
