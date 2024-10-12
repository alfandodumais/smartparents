@extends('admin.layouts.app')

@section('content')
    <h1>All Transactions</h1>

    <!-- Form pencarian -->
    <form action="{{ route('admin.transactions.index') }}" method="GET" class="mb-4">
        <div class="input-group">
            <input type="text" name="search" class="form-control" placeholder="Search by User, Video, or Order ID ..." value="{{ request('search') }}">
            <button class="btn btn-primary" type="submit">Search</button>
        </div>
    </form>

    <table class="table table-bordered">
        <thead>
            <tr>
                <th>User</th>
                <th>Video</th>
                <th>Order ID</th>
                <th>Amount</th>
                <th>Status</th>
                <th>Date / Time</th>
            </tr>
        </thead>
        <tbody>
            @if($transactions->count() > 0)
                @foreach($transactions as $transaction)
                    <tr>
                        <td>{{ $transaction->user->name }}</td>
                        <td>{{ $transaction->video->title }}</td>
                        <td>{{ $transaction->order_id }}</td>
                        <td>@currency($transaction->amount)</td>
                        <td>
                            @if($transaction->payment_status == 'completed')
                                <span class="badge bg-success">Completed</span>
                            @elseif($transaction->payment_status == 'pending')
                                <span class="badge bg-warning">Pending</span>
                            @else
                                <span class="badge bg-danger">Failed</span>
                            @endif
                        </td>
                        <td>{{ $transaction->created_at->format('d M Y / H:i') }}</td>
                    </tr>
                @endforeach
            @else
                <tr>
                    <td colspan="6" class="text-center">No transactions found.</td>
                </tr>
            @endif
        </tbody>
    </table>

    {{ $transactions->links() }}
@endsection
