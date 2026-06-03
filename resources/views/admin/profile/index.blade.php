@extends('admin.layouts.app')

@section('title')
    Admin Profile
@endsection

@section('content')

    <div class="container-fluid">

        <div class="card shadow-sm">

            <div class="card-header">

                <h3 class="card-title">
                    My Profile
                </h3>

            </div>

            <div class="card-body">

                <form action="{{ route('admin.profile.update') }}" method="POST" enctype="multipart/form-data">

                    @csrf

                    <div class="row">
                        <div class="col-md-12 text-center mb-4">

                            <img src="{{
        $user->profile_photo
        ?
        asset(
            'storage/' .
            $user->profile_photo
        )
        :
        asset(
            'admin/dist/img/user2-160x160.jpg'
        )
                                                }}" class="img-circle elevation-2" style="
                                                    width:120px;
                                                    height:120px;
                                                    object-fit:cover;
                                                ">

                        </div>

                        <div class="form-group">

                            <label>

                                Profile Picture

                            </label>

                            <input type="file" name="profile_photo" class="form-control">

                        </div>

                        <div class="col-md-12 mb-3">

                            <label>First Name</label>

                            <input type="text" name="first_name" class="form-control" value="{{ $user->first_name }}">

                        </div>

                        <div class="col-md-12 mb-3">

                            <label>Last Name</label>

                            <input type="text" name="last_name" class="form-control" value="{{ $user->last_name }}">

                        </div>

                        <div class="col-md-12 mb-3">

                            <label>Mobile</label>

                            <input type="text" name="mobile_no" class="form-control" value="{{ $user->mobile_no }}">

                        </div>

                        <div class="col-md-12 mb-3">

                            <label>Email</label>

                            <input type="email" name="email" class="form-control" value="{{ $user->email }}">

                        </div>

                        <div class="col-md-12 mb-3">

                            <label>Role</label>

                            <input type="text" class="form-control" value="{{ strtoupper($user->role) }}" readonly>

                        </div>

                        <div class="col-md-12 mb-3">

                            <label>Status</label>

                            <input type="text" class="form-control" value="{{ ucfirst($user->status) }}" readonly>

                        </div>

                    </div>

                    <button type="submit" class="btn btn-primary">

                        Update Profile

                    </button>

                </form>

            </div>

        </div>

    </div>

@endsection