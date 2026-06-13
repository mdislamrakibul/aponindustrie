@extends('admin.layouts.app')

@section('title')
Admin Profile
@endsection

@section('content')


<!-- Content Header (Page header) -->
<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0">Dashboard</h1>
            </div><!-- /.col -->
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="#">Home</a></li>
                    <li class="breadcrumb-item active">Profile</li>
                </ol>
            </div><!-- /.col -->
        </div><!-- /.row -->
    </div><!-- /.container-fluid -->
</div>
<!-- /.content-header -->

<div class="container-fluid">
    <div class="card shadow-sm mt-6">
        <div class="card-header bg-white border-bottom d-flex align-items-center">

            <div class="flex-grow-1">
                <h3 class="card-title font-weight-bold mb-0">
                    My Profile
                </h3>
            </div>



        </div>
        <div class="card-body">
            <form action="{{ route('admin.profile.update') }}" method="POST" enctype="multipart/form-data">
                @csrf


                <div class="row">


                    <div class="col-md-6 text-center mb-4">

                        <img id="profilePreview" src="{{ $user->profile_photo ?
                        asset('storage/' . $user->profile_photo):
                        asset('admin/dist/img/user2-160x160.jpg')
                                    }}" class="img-circle elevation-2"
                            style="  width:120px; height:120px; object-fit:cover; ">
                    </div>
                    <div class="form-group">
                        <label>
                            Profile Picture
                        </label>
                        <input type="file" id="profilePhotoInput" name="profile_photo" class="form-control"
                            accept="image/*">
                    </div>
                    <div class="col-md-6 mb-3">
                        <label>First Name</label>
                        <input type="text" name="first_name" class="form-control" value="{{ $user->first_name }}">
                    </div>

                    <div class="col-md-6 mb-3">
                        <label>Last Name</label>
                        <input type="text" name="last_name" class="form-control" value="{{ $user->last_name }}">
                    </div>

                    <div class="col-md-6 mb-3">
                        <label>Mobile</label>
                        <input type="text" name="mobile_no" class="form-control" value="{{ $user->mobile_no }}">
                    </div>

                    <div class="col-md-6 mb-3">
                        <label>Email</label>
                        <input type="email" name="email" class="form-control" value="{{ $user->email }}">
                    </div>
                    <div class="col-md-6 mb-3">
                        <label>Role</label>
                        <input type="text" class="form-control" value="{{ strtoupper($user->role) }}" readonly>
                    </div>

                    <div class="col-md-6 mb-3">
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
@push('js')

<script>
    $(document).ready(function () {

            $('#profilePhotoInput').on('change', function () {

                let file = this.files[0];

                if (file) {

                    let reader = new FileReader();

                    reader.onload = function (e) {

                        $('#profilePreview').attr(
                            'src',
                            e.target.result
                        );

                    }

                    reader.readAsDataURL(file);

                }

            });

        });

</script>

@endpush
