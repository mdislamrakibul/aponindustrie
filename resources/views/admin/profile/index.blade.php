@extends('admin.layouts.app')

@section('title')
Admin Profile
@endsection

@section('content')

<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0">My Profile</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="#">Home</a></li>
                    <li class="breadcrumb-item active">Profile</li>
                </ol>
            </div>
        </div>
    </div>
</div>

<div class="container-fluid">

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="close" data-dismiss="alert"><span>&times;</span></button>
        </div>
    @endif

    @if($errors->any())
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <ul class="mb-0">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
            <button type="button" class="close" data-dismiss="alert"><span>&times;</span></button>
        </div>
    @endif

    <div class="card shadow-sm">
        <div class="card-header bg-white border-bottom">
            <h3 class="card-title font-weight-bold mb-0">Update Profile</h3>
        </div>
        <div class="card-body">
            <form id="profileForm" action="{{ route('admin.profile.update') }}" method="POST" enctype="multipart/form-data">
                @csrf

                <div class="row">

                    {{-- Profile Photo Preview --}}
                    <div class="col-12 text-center mb-4">
                        <img id="profilePreview"
                             src="{{ $user->profile_photo
                                ? asset($user->profile_photo)
                                : asset('admin/dist/img/user2-160x160.jpg') }}"
                             class="img-circle elevation-2"
                             style="width:120px;height:120px;object-fit:cover;border:3px solid #dee2e6;">
                        <div class="mt-2">
                            <small class="text-muted">Click "Choose File" below to change photo</small>
                        </div>
                    </div>

                    {{-- Profile Photo Upload --}}
                    <div class="col-md-6 mb-3">
                        <label class="font-weight-bold">Profile Picture</label>
                        <input type="file"
                               id="profilePhotoInput"
                               name="profile_photo"
                               class="form-control @error('profile_photo') is-invalid @enderror"
                               accept="image/jpeg,image/jpg,image/png,image/webp">
                        @error('profile_photo')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                        <small class="text-muted">JPG, PNG or WEBP — max 2 MB</small>
                    </div>

                    <div class="col-md-6 mb-3">
                        <label class="font-weight-bold">Role</label>
                        <input type="text" class="form-control" value="{{ strtoupper($user->role) }}" readonly>
                    </div>

                    {{-- Name --}}
                    <div class="col-md-6 mb-3">
                        <label class="font-weight-bold">First Name <span class="text-danger">*</span></label>
                        <input type="text" name="first_name" class="form-control @error('first_name') is-invalid @enderror"
                               value="{{ old('first_name', $user->first_name) }}">
                        @error('first_name')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>

                    <div class="col-md-6 mb-3">
                        <label class="font-weight-bold">Last Name <span class="text-danger">*</span></label>
                        <input type="text" name="last_name" class="form-control @error('last_name') is-invalid @enderror"
                               value="{{ old('last_name', $user->last_name) }}">
                        @error('last_name')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>

                    <div class="col-md-6 mb-3">
                        <label class="font-weight-bold">Mobile <span class="text-danger">*</span></label>
                        <div class="input-group">
                            <div class="input-group-prepend">
                                <span class="input-group-text">+880</span>
                            </div>
                            <input type="text" id="mobile_no_input" name="mobile_no" inputmode="numeric" maxlength="12"
                                   class="form-control @error('mobile_no') is-invalid @enderror"
                                   value="{{ old('mobile_no', $user->mobile_no) }}"
                                   placeholder="01888888881">
                            @error('mobile_no')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>
                    </div>

                    <div class="col-md-6 mb-3">
                        <label class="font-weight-bold">Email</label>
                        <input type="email" name="email" class="form-control @error('email') is-invalid @enderror"
                               value="{{ old('email', $user->email) }}"
                               placeholder="admin@example.com">
                        @error('email')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>

                    <div class="col-md-6 mb-3">
                        <label class="font-weight-bold">Status</label>
                        <input type="text" class="form-control" value="{{ ucfirst($user->status) }}" readonly>
                    </div>

                </div>

                <hr>
                <button type="submit" class="btn btn-primary px-4">
                    <i class="fas fa-save mr-1"></i> Update Profile
                </button>
            </form>
        </div>
    </div>
</div>

@endsection

@push('js')
<script>
    $('#profilePhotoInput').on('change', function () {
        var file = this.files[0];
        if (file) {
            var reader = new FileReader();
            reader.onload = function (e) {
                $('#profilePreview').attr('src', e.target.result);
            };
            reader.readAsDataURL(file);
        }
    });

    // Mobile: show as 01888-888881 while typing (dash inserted after the 5th
    // digit, purely for readability) — the dash is stripped again right
    // before submit, so the server always receives the plain 11-digit
    // 01XXXXXXXXX format it validates against.
    (function () {
        var mobileInput = document.getElementById('mobile_no_input');
        var form = document.getElementById('profileForm');
        if (!mobileInput || !form) return;

        function formatMobile(digits) {
            digits = digits.slice(0, 11);
            return digits.length > 5
                ? digits.slice(0, 5) + '-' + digits.slice(5)
                : digits;
        }

        mobileInput.addEventListener('input', function () {
            var digits = mobileInput.value.replace(/\D/g, '');
            mobileInput.value = formatMobile(digits);
        });

        // Format the initial value (e.g. when editing an existing profile)
        mobileInput.value = formatMobile(mobileInput.value.replace(/\D/g, ''));

        form.addEventListener('submit', function () {
            mobileInput.value = mobileInput.value.replace(/\D/g, '');
        });
    })();
</script>
@endpush
