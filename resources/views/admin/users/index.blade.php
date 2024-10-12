@extends('admin.layouts.app')

@section('content')
    <h1>Manage Users</h1>
    
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Name</th>
                <th>Email</th>
                <th>Role</th> <!-- Menambahkan kolom untuk Role -->
                <th>Registered At</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach($users as $user)
                <tr>
                    <td>{{ $user->name }}</td>
                    <td>{{ $user->email }}</td>
                    <td>{{ ucfirst($user->role) }}</td> <!-- Menampilkan role pengguna -->
                    <td>{{ $user->created_at->format('d M Y') }}</td>
                    <td>
                        <a href="{{ route('admin.users.show', $user) }}" class="btn btn-sm btn-info">View</a>
                        <a href="{{ route('admin.users.edit', $user) }}" class="btn btn-sm btn-warning">Edit Role</a>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
    {{ $users->links() }}
@endsection
