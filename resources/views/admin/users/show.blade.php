@extends('admin.layouts.app')

@section('content')
    <h1>User Details</h1>
    <div class="card">
        <div class="card-body">
            <h5 class="card-title">{{ $user->name }}</h5>
            <p class="card-text"><strong>Email:</strong> {{ $user->email }}</p>
            <p class="card-text"><strong>Registered At:</strong> {{ $user->created_at->format('d M Y') }}</p>
        </div>
    </div>
    <a href="{{ route('admin.users.index') }}" class="btn btn-secondary mt-3">Back</a>
@endsection
