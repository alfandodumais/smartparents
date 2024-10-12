@extends('layouts.app')

@section('title', 'Your Purchased Videos')

@section('content')
<div class="container">
    <h1>Your Pending Transaction</h1>

    @if($transactions->count() > 0)
        <div class="row">
            @foreach($transactions as $transaction)
                <div class="col-md-4 mb-4">
                    <div class="card mb-3">
                        <div class="card-body">
                            <h5 class="card-title">{{ $transaction->video->title }}</h5>
                            <img src="{{ asset('storage/' . $transaction->video->thumbnail) }}" class="card-img-top" alt="Thumbnail">
                            <p class="card-text">Price: {{ $transaction->video->price == 0 ? 'Free' : 'Rp. ' . $transaction->video->price }}</p>
                            {{-- <a href="{{ route('videos.show', $transaction->video->id) }}" class="btn btn-primary">Watch</a> --}}
                            {{-- <a href="{{ route('videos.download', $transaction->video->id) }}" class="btn btn-success">Download</a> --}}
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    @else
        <p>You have not pending transaction any videos yet.</p>
    @endif
</div>
@endsection
