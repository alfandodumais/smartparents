@extends('admin.layouts.app')

@section('content')
    <h1>Edit User Role</h1>

    <form action="{{ route('admin.users.update', $user) }}" method="POST">
        @csrf
        @method('PATCH')

        <div class="form-group">
            <label for="role">Role</label>
            <select name="role" id="role" class="form-control">
                <option value="user" {{ $user->role === 'user' ? 'selected' : '' }}>User</option>
                <option value="admin" {{ $user->role === 'admin' ? 'selected' : '' }}>Admin</option>
            </select>
            @error('role')
                <div class="alert alert-danger">{{ $message }}</div>
            @enderror
        </div>

        <button type="submit" class="btn btn-primary">Update Role</button>
        <a href="{{ route('admin.users.index') }}" class="btn btn-secondary">Cancel</a>
    </form>
@endsection
