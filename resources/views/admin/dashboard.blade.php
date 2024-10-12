@extends('admin.layouts.app')

@section('content')
<div class="container">
    <h1>Admin Dashboard</h1>

    <!-- Videos Section -->
    <div class="row mb-4">
        <div class="col-lg-6 col-md-12">
            <h3>Latest Videos</h3>
            <table class="table table-responsive table-bordered">
                <thead>
                    <tr>
                        <th>Thumbnail</th>
                        <th>Title</th>
                        <th>Price</th>
                        <th>Uploaded By</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($videos as $video)
                    <tr>
                        <td><img src="{{ asset('storage/' . $video->thumbnail) }}" alt="Thumbnail" width="100"></td>
                        <td>{{ $video->title }}</td>
                        <td>@currency($video->price)</td>
                        <td>{{ $video->user->name }}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <!-- Latest Registered Users -->
        <div class="col-lg-6 col-md-12">
            <h3>Latest Registered Users</h3>
            <table class="table table-responsive table-bordered">
                <thead>
                    <tr>
                        <th>Name</th>
                        <th>Email</th>
                        <th>Registered At</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($latestUsers as $user)
                    <tr>
                        <td>{{ $user->name }}</td>
                        <td>{{ $user->email }}</td>
                        <td>{{ $user->created_at->format('d M Y, H:i') }}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

    <!-- Latest Transactions Section -->
    <div class="row mb-4">
        <div class="col-lg-12">
            <h3>Latest Transactions</h3>
            <table class="table table-responsive table-bordered">
                <thead>
                    <tr>
                        <th>User</th>
                        <th>Video</th>
                        <th>Amount</th>
                        <th>Payment Status</th>
                        <th>Transaction Date</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($recentTransactions as $transaction)
                    <tr>
                        <td>{{ $transaction->user->name }}</td>
                        <td>{{ $transaction->video->title }}</td>
                        <td>@currency($transaction->amount)</td>
                        <td>{{ ucfirst($transaction->status) }}</td>
                        <td>{{ $transaction->created_at->format('d M Y, H:i') }}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

    <!-- Dashboard Statistics -->
    <div class="row">
        <div class="col-lg-3 col-md-6 mb-4">
            <div class="card bg-primary text-white">
                <div class="card-body">
                    <h4>Total Users</h4>
                    <h2>{{ $totalUsers }}</h2>
                </div>
            </div>
        </div>

        <div class="col-lg-3 col-md-6 mb-4">
            <div class="card bg-success text-white">
                <div class="card-body">
                    <h4>Total Videos</h4>
                    <h2>{{ $totalVideos }}</h2>
                </div>
            </div>
        </div>

        <div class="col-lg-3 col-md-6 mb-4">
            <div class="card bg-warning text-white">
                <div class="card-body">
                    <h4>Total Transactions</h4>
                    <h2>{{ $totalTransactions }}</h2>
                </div>
            </div>
        </div>

        <div class="col-lg-3 col-md-6 mb-4">
            <div class="card bg-danger text-white">
                <div class="card-body">
                    <h4>Total Revenue</h4>
                    <h2>@currency($totalRevenue)</h2>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
