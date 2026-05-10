@extends('admin.layouts.app')

@section('content')

<div class="card">
    <div class="card-header d-flex justify-content-between">
        <h3 class="card-title">User List</h3>
        <a href="{{ route('admin.users.create') }}" class="btn btn-primary btn-sm">
            + Add User
        </a>
    </div>

    <div class="card-body">
        <table class="table table-bordered table-hover">
            <thead>
                <tr>
                    <th>Name</th>
                    <th>Mobile</th>
                    <th>Role</th>
                    <th>Status</th>
                    <th width="150">Action</th>
                </tr>
            </thead>

            <tbody>
                @foreach($users as $user)
                <tr>
                    <td>{{ $user->first_name }}</td>
                    <td>{{ $user->mobile_no }}</td>
                    <td>
                        <span class="badge badge-info">
                            {{ $user->role }}
                        </span>
                    </td>
                    <td>
                        <span class="badge badge-success">
                            {{ $user->status }}
                        </span>
                    </td>
                    <td>
                        <a href="{{ route('admin.users.edit', $user->id) }}" class="btn btn-sm btn-warning">Edit</a>

                        <form action="{{ route('admin.users.delete', $user->id) }}" method="POST" style="display:inline;">
                            @csrf
                            @method('DELETE')
                            <button class="btn btn-sm btn-danger">Delete</button>
                        </form>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>

@endsection