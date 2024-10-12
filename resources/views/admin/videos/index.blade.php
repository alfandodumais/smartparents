@extends('admin.layouts.app')

@section('content')
    <h1>Manage Videos</h1>
    <button class="btn btn-primary mb-3" data-bs-toggle="modal" data-bs-target="#createVideoModal">Upload Video</button>
    
    <!-- Videos Table -->
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Thumbnail</th>
                <th>Title</th>
                <th>Price</th>
                <th>Uploaded By</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach($videos as $video)
                <tr>
                    <td><img src="{{ asset('storage/' . $video->thumbnail) }}" alt="Thumbnail" width="100"></td>
                    <td>{{ $video->title }}</td>
                    <td>@currency($video->price)</td>
                    <td>{{ $video->user->name }}</td>
                    <td>
                        <a href="{{ route('admin.videos.edit', $video) }}" class="btn btn-sm btn-warning">Edit</a>
                        <form action="{{ route('admin.videos.destroy', $video) }}" method="POST" class="d-inline" onsubmit="return confirm('Are you sure you want to delete this video?');">
                            @csrf
                            @method('DELETE')
                            <button class="btn btn-sm btn-danger" type="submit">Delete</button>
                        </form>
                        <a href="{{ route('admin.videos.show', $video) }}" class="btn btn-sm btn-info">View</a>
                        <form action="{{ route('admin.videos.generateLink', $video) }}" method="POST" class="d-inline">
                            @csrf
                            <button class="btn btn-sm btn-primary" type="submit">Generate Share Link</button>
                        </form>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
    {{ $videos->links() }}
    
    <!-- Create Video Modal -->
    @include('admin.videos.create_modal')
@endsection
