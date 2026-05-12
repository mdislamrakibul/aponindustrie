@extends('admin.layouts.app')

@section('content')

<div class="card">
    <div class="card-header d-flex justify-content-between">
        <h3 class="card-title">Users</h3>
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
                <div class="modal fade" id="editUserModal{{ $user->id }}" tabindex="-1">

                    <div class="modal-dialog">

                        <form method="POST"
                            action="{{ route('admin.users.update', $user->id) }}">

                            @csrf

                            <div class="modal-content">

                                <div class="modal-header">
                                    <h5 class="modal-title">Edit User</h5>
                                    <button type="button" class="close" data-dismiss="modal">
                                        &times;
                                    </button>
                                </div>

                                <div class="modal-body">

                                    <input type="text"
                                        name="first_name"
                                        value="{{ $user->first_name }}"
                                        class="form-control mb-2">

                                    <input type="text"
                                        name="mobile_no"
                                        value="{{ $user->mobile_no }}"
                                        class="form-control mb-2">

                                    <select name="role" class="form-control mb-2">
                                        <option value="admin" {{ $user->role=='admin'?'selected':'' }}>Admin</option>
                                        <option value="user" {{ $user->role=='user'?'selected':'' }}>User</option>
                                    </select>

                                    <select name="status" class="form-control mb-2">
                                        <option value="active" {{ $user->status=='active'?'selected':'' }}>Active</option>
                                        <option value="inactive" {{ $user->status=='inactive'?'selected':'' }}>Inactive</option>
                                    </select>

                                    <input type="number"
                                        name="salary"
                                        value="{{ $user->salary }}"
                                        class="form-control">

                                </div>

                                <div class="modal-footer">
                                    <button class="btn btn-success">Update</button>
                                </div>

                            </div>

                        </form>

                    </div>

                </div>
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


                        
                        <div class="d-flex gap-1">

                            {{-- Edit --}}
                            <button class="action-icon"
                                    data-toggle="modal"
                                    data-target="#editUserModal{{ $user->id }}">

                                <i class="fas fa-edit"></i>
                            </button>

                            {{-- Salary --}}
                            <a href="{{ route('admin.accounts.create', $user->id) }}"
                            class="btn btn-sm"
                            title="Salary">

                                <i class="fas fa-money-bill-wave"></i>
                            </a>

                            {{-- Delete --}}
                            <form action="{{ route('admin.users.delete', $user->id) }}"
                                method="POST"
                                style="display:inline;">

                                @csrf
                                @method('DELETE')

                                <button class="btn btn-sm"
                                        title="Delete User">

                                    <i class="fas fa-trash"></i>
                                </button>

                            </form>

                        </div>

                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>

@endsection