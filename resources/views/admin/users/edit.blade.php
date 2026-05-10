@extends('admin.layouts.app')

@section('content')

<div class="row justify-content-center">
    <div class="col-md-6">

        <div class="card card-warning">
            <div class="card-header">
                <h3 class="card-title">Edit User</h3>
            </div>

            <form action="{{ route('admin.users.update', $user->id) }}" method="POST">
                @csrf
                @method('PUT')

                <div class="card-body">

                    {{-- First Name --}}
                    <div class="form-group">
                        <label>First Name</label>
                        <input type="text"
                               name="first_name"
                               value="{{ $user->first_name }}"
                               class="form-control">
                    </div>

                    {{-- Mobile --}}
                    <div class="form-group">
                        <label>Mobile</label>
                        <input type="text"
                               name="mobile_no"
                               value="{{ $user->mobile_no }}"
                               class="form-control">
                    </div>

                    {{-- Role --}}
                    <div class="form-group">
                        <label>Role</label>
                        <select name="role" class="form-control">
                            <option value="admin" {{ $user->role == 'admin' ? 'selected' : '' }}>Admin</option>
                            <option value="user" {{ $user->role == 'user' ? 'selected' : '' }}>User</option>
                        </select>
                    </div>

                    {{-- Status --}}
                    <div class="form-group">
                        <label>Status</label>
                        <select name="status" class="form-control">
                            <option value="active" {{ $user->status == 'active' ? 'selected' : '' }}>Active</option>
                            <option value="inactive" {{ $user->status == 'inactive' ? 'selected' : '' }}>Inactive</option>
                        </select>
                    </div>

                    {{-- Salary --}}
                    <div class="form-group">
                        <label>Salary</label>
                        <input type="number"
                               name="salary"
                               value="{{ $user->salary }}"
                               class="form-control">
                    </div>

                </div>

                <div class="card-footer">
                    <button type="submit" class="btn btn-warning">
                        Update User
                    </button>
                </div>

            </form>

        </div>

    </div>
</div>

@endsection