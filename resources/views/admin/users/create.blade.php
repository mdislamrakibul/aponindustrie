@extends('admin.layouts.app')

@section('content')

<div class="row justify-content-center">
    <div class="col-md-6">

        <div class="card card-primary">
            <div class="card-header">
                <h3 class="card-title">Create User</h3>
            </div>

            <form method="POST"
                action="{{ route('admin.users.store') }}">
                @csrf

                <div class="card-body">

                    {{-- First Name --}}
                    <div class="form-group">
                        <label>First Name</label>
                        <input type="text"
                               name="first_name"
                               value="{{ old('first_name') }}"
                               class="form-control"
                               placeholder="Enter name">
                    </div>

                    {{-- Mobile --}}
                    <div class="form-group">
                        <label>Mobile</label>
                        <input type="text"
                               name="mobile_no"
                               value="{{ old('mobile_no') }}"
                               class="form-control">
                    </div>

                    {{-- Role --}}
                    <div class="form-group">
                        <label>Role</label>
                        <select name="role" class="form-control">
                            <option value="admin">Admin</option>
                            <option value="user">User</option>
                        </select>
                    </div>

                    {{-- Status (NEW - IMPORTANT) --}}
                    <div class="form-group">
                        <label>Status</label>
                        <select name="status" class="form-control">
                            <option value="active">Active</option>
                            <option value="inactive">Inactive</option>
                        </select>
                    </div>

                    {{-- Salary (optional for future account module) --}}
                    <div class="form-group">
                        <label>Salary</label>
                        <input type="number"
                               name="salary"
                               value="{{ old('salary', 0) }}"
                               class="form-control">
                    </div>

                </div>

                <div class="card-footer">
                    <button type="submit" class="btn btn-success">
                        Save User
                    </button>
                </div>

            </form>

        </div>

    </div>
</div>

@endsection