@extends('admin.layouts.app')

@section('content')
    <h1>Manage Transactions</h1>
    
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>User</th>
                <th>Video</th>
                <th>Amount</th>
                <th>Status</th>
                <th>Date</th>
            </tr>
        </thead>
        <tbody>
            @foreach($transactions as $transaction)
                <tr>
                    <td>{{ $transaction->user->name }}</td>
                    <td>{{ $transaction->video->title }}</td>
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
                    <td>{{ $transaction->created_at->format('d M Y') }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
    {{ $transactions->links() }}
@endsection
