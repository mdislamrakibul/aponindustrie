@extends('admin.layouts.app')


@section('title')
User Mgmt
@endsection


@section('content')

<div class="row">
    <div class="col-12">

        <div class="card shadow-sm border-0">

            <div class="card-header bg-white border-bottom d-flex align-items-center">

                <div class="flex-grow-1">
                    <h3 class="card-title font-weight-bold mb-0">
                        Users
                    </h3>
                </div>


                <button type="button" class="btn btn-primary btn-sm px-3" onclick="toggleUserForm()">
                    <i class="fas fa-user-plus mr-1"></i>
                    Add User
                </button>

            </div>
            {{-- USER DASHBOARD CARDS --}}
            <div class="row mb-4">

                {{-- TOTAL USERS --}}
                <div class="col-lg-3 col-6">

                    <div class="small-box bg-info">

                        <div class="inner">

                            <h3>{{ $totalUsers }}</h3>

                            <p>Total Users</p>

                        </div>

                        <div class="icon">
                            <i class="fas fa-users"></i>
                        </div>

                    </div>

                </div>

                {{-- ACTIVE USERS --}}
                <div class="col-lg-3 col-6">

                    <div class="small-box bg-success">

                        <div class="inner">

                            <h3>{{ $activeUsers }}</h3>

                            <p>Active Users</p>

                        </div>

                        <div class="icon">
                            <i class="fas fa-user-check"></i>
                        </div>

                    </div>

                </div>

                {{-- INACTIVE USERS --}}
                <div class="col-lg-3 col-6">

                    <div class="small-box bg-danger">

                        <div class="inner">

                            <h3>{{ $inactiveUsers }}</h3>

                            <p>Inactive Users</p>

                        </div>

                        <div class="icon">
                            <i class="fas fa-user-times"></i>
                        </div>

                    </div>

                </div>

                {{-- CUSTOMERS --}}
                <div class="col-lg-3 col-6">

                    <div class="small-box bg-warning">

                        <div class="inner">

                            <h3>{{ $customerUsers }}</h3>

                            <p>Customers</p>

                        </div>

                        <div class="icon">
                            <i class="fas fa-user-tag"></i>
                        </div>

                    </div>

                </div>

            </div>

            {{-- INLINE CREATE FORM --}}
            <div class="card-body border-bottom bg-light" id="userCreateForm" style="display:none;">
                @if(session('success'))
                <div class="alert alert-success">
                    {{ session('success') }}
                </div>
                @endif

                @if(session('error'))
                <div class="alert alert-danger">
                    {{ session('error') }}
                </div>
                @endif


{{-- DELETE BUTTON HIDDEN TEMPORARILY

                <form action="{{ route('admin.users.store') }}" method="POST">
                    @csrf

                    <div class="row">

                        <div class="col-lg-3 col-md-6 mb-3">
                            <label class="font-weight-semibold">First Name</label>

                            <input type="text" name="first_name" class="form-control" placeholder="First Name"
                                value="{{ old('first_name') }}" required>

                            @error('first_name')
                            <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>

                        <div class="col-lg-3 col-md-6 mb-3">
                            <label class="font-weight-semibold">Last Name</label>

                            <input type="text" name="last_name" class="form-control" placeholder="Last Name (Optional)"
                                value="{{ old('last_name') }}">

                            @error('last_name')
                            <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>

                        <div class="col-lg-4 col-md-6 mb-3">
                            <label class="font-weight-semibold">Mobile Number</label>
                            <input type="text" name="mobile_no" class="form-control" placeholder="01XXXXXXXXX" required>
                        </div>

                        <div class="col-lg-2 col-md-6 mb-3">
                            <label class="font-weight-semibold">Role</label>

                            <select name="role" class="form-control" required>
                                <option value="">Select</option>
                                <option value="customer">Customer</option>
                                <option value="vendor">Vendor</option>
                                <option value="admin">Admin</option>
                            </select>
                        </div>

                        <div class="col-lg-2 col-md-6 mb-3">
                            <label class="font-weight-semibold d-block">&nbsp;</label>

                            <button type="submit" class="btn btn-success btn-block">
                                <i class="fas fa-save mr-1"></i>
                                Save User
                            </button>
                        </div>

                    </div>

                </form>
    --}}

            </div>

            {{-- USER TABLE --}}
            <div class="card-body p-2">

                <div class="table-responsive">

                    <table class="table table-hover align-middle mb-0" id="dataTable">

                        <thead class="bg-light">
                            <tr>
                                <th class="pl-4">Name</th>
                                <th>Mobile</th>
                                <th>Role</th>
                                <th>Status</th>
                                <th width="220" class="text-center">Actions</th>
                            </tr>
                        </thead>

                        <tbody>

                            @forelse($users as $user)

                            <tr id="row-{{ $user->id }}">

                                {{-- NAME --}}
                                <td>

                                    <span class="view-mode name-text">
                                        {{ $user->first_name }} {{ $user->last_name }}
                                    </span>

                                    <div class="edit-mode d-none">

                                        <div class="d-flex align-items-center gap-2">

                                            <input type="text" class="form-control form-control-sm"
                                                value="{{ $user->first_name }}" id="first-name-{{ $user->id }}"
                                                placeholder="First Name">

                                            <input type="text" class="form-control form-control-sm"
                                                value="{{ $user->last_name }}" id="last-name-{{ $user->id }}"
                                                placeholder="Last Name">

                                        </div>

                                    </div>

                                </td>

                                {{-- MOBILE --}}
                                <td>

                                    <span class="view-mode mobile-text">
                                        {{ $user->mobile_no }}
                                    </span>

                                    <input type="text" class="form-control form-control-sm edit-mode d-none"
                                        value="{{ $user->mobile_no }}" id="mobile-{{ $user->id }}">

                                </td>
                                {{-- ROLE --}}
                                <td>

                                    <span class="view-mode badge badge-info px-3 py-2 rounded-pill">
                                        {{ ucfirst($user->role) }}
                                    </span>

                                    <select class="form-control form-control-sm edit-mode d-none"
                                        id="role-{{ $user->id }}">
                                        <option value="customer" {{ $user->role == 'customer' ? 'selected' : '' }}>
                                            Customer
                                        </option>

                                        <option value="vendor" {{ $user->role == 'vendor' ? 'selected' : '' }}>
                                            Vendor
                                        </option>

                                        <option value="admin" {{ $user->role == 'admin' ? 'selected' : '' }}>
                                            Admin
                                        </option>

                                        <option value="" {{ $user->role == '' ? 'selected' : '' }}>
                                            Accountent
                                        </option>
                                    </select>

                                </td>
                                {{-- STATUS --}}
                                <td>

                                    <span
                                        class="view-mode badge px-3 py-2 rounded-pill {{ $user->status == 'active' ? 'badge-success' : 'badge-danger' }}">
                                        {{ ucfirst($user->status) }}
                                    </span>

                                    <select class="form-control form-control-sm edit-mode d-none"
                                        id="status-{{ $user->id }}">
                                        <option value="active" {{ $user->status == 'active' ? 'selected' : '' }}>
                                            Active
                                        </option>

                                        <option value="inactive" {{ $user->status == 'inactive' ? 'selected' : '' }}>
                                            Inactive
                                        </option>
                                    </select>

                                </td>
                                {{-- ACTIONS --}}
                                <td>

                                    <div class="action-btn-group">

                                        {{-- EDIT --}}
                                        <button type="button" class="icon-action-btn edit-btn" data-id="{{ $user->id }}"
                                            title="Edit User">
                                            <i class="fas fa-pen" style="color: cornflowerblue;"></i>
                                        </button>

                                        {{-- SAVE --}}
                                        <button type="button" class="icon-action-btn update-btn d-none"
                                            data-id="{{ $user->id }}" title="Save">
                                            <i class="fas fa-check" style="color: darkgreen;"></i>
                                        </button>

                                        {{-- CANCEL --}}
                                        <button type="button" class="icon-action-btn cancel-btn d-none"
                                            data-id="{{ $user->id }}" title="Cancel">
                                            <i class="fas fa-times" style="color: maroon;"></i>
                                        </button>

                                        {{-- SALARY --}}
                                        <button type="button" class="icon-action-btn open-salary-modal"
                                            data-id="{{ $user->id }}">
                                            <i class="fas fa-wallet" style="color: brown;"></i>
                                        </button>

                                        {{-- DELETE --}}
                                        <form action="{{ route('admin.users.delete', $user->id) }}" method="POST"
                                            class="delete-form d-inline-block m-0">
                                            @csrf
                                            @method('DELETE')

                                            <button type="submit" class="icon-action-btn" title="Delete User"
                                                onclick="return confirm('Delete this user?')">
                                                <i class="fas fa-trash" style="color: red"></i>
                                            </button>

                                        </form>

                                    </div>

                                </td>

                            </tr>

                            @empty

                            <tr>
                                <td colspan="5" class="text-center py-4">
                                    No users found.
                                </td>
                            </tr>

                            @endforelse

                        </tbody>

                    </table>

                </div>

            </div>

        </div>

    </div>
</div>
@endsection
@push('css')
<style>
    .table td,
    .table th {
        vertical-align: middle;
        white-space: nowrap;
    }

    .card {
        overflow: hidden;
    }

    .badge {
        font-size: 12px;
        font-weight: 600;
    }

    .edit-mode {
        min-width: 140px;
    }

    .action-btn-group {
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 5px;
    }

    .icon-action-btn {
        width: 38px;
        height: 38px;
        border-radius: 10px;
        border: none !important;
        outline: none !important;

        background: #fff !important;
        color: #000 !important;

        display: inline-flex;
        align-items: center;
        justify-content: center;

        transition: all .2s ease;

        text-decoration: none !important;

        box-shadow: none !important;
    }

    .icon-action-btn i {
        font-size: 14px;
    }

    .icon-action-btn:hover {
        background: lightgrey !important;
        color: #fff !important;

        transform: translateY(-2px);
    }

    .icon-action-btn:focus {
        outline: none !important;
        box-shadow: none !important;
    }

    .delete-form {
        margin: 0;
    }

    .gap-2 {
        gap: 8px;
    }
</style>
@endpush

@push('scripts')


<script>
    function toggleUserForm() {
    $('#userCreateForm').slideToggle(200);
}

$('.edit-btn').on('click', function () {

    const row = $(this).closest('tr');

    row.find('.view-mode').addClass('d-none');
    row.find('.edit-mode').removeClass('d-none');

    row.find('.edit-btn').addClass('d-none');
    row.find('.delete-form').addClass('d-none');

    row.find('.update-btn').removeClass('d-none');
    row.find('.cancel-btn').removeClass('d-none');

    row.data('original', {

        first_name: row.find('[id^="first-name-"]').val(),

        last_name: row.find('[id^="last-name-"]').val(),

        mobile: row.find('[id^="mobile-"]').val(),

        role: row.find('[id^="role-"]').val(),

        status: row.find('[id^="status-"]').val(),
    });

});

$('.cancel-btn').on('click', function () {

    const row = $(this).closest('tr');
    const original = row.data('original');

    row.find('[id^="first-name-"]').val(original.first_name);

    row.find('[id^="last-name-"]').val(original.last_name);
    row.find('[id^="mobile-"]').val(original.mobile);
    row.find('[id^="role-"]').val(original.role);
    row.find('[id^="status-"]').val(original.status);

    row.find('.view-mode').removeClass('d-none');
    row.find('.edit-mode').addClass('d-none');

    row.find('.edit-btn').removeClass('d-none');
    row.find('.delete-form').removeClass('d-none');

    row.find('.update-btn').addClass('d-none');
    row.find('.cancel-btn').addClass('d-none');

});
$('.update-btn').on('click', function () {

    const id = $(this).data('id');

    const row = $('#row-' + id);

    const payload = {

        _token: '{{ csrf_token() }}',

        first_name: $('#first-name-' + id).val(),

        last_name: $('#last-name-' + id).val(),

        mobile_no: $('#mobile-' + id).val(),

        role: $('#role-' + id).val(),

        status: $('#status-' + id).val()
    };

    $.ajax({
        url: '/admin/users/' + id + '/update',
        method: 'POST',
        data: payload,
        success: function (response) {

            if(response.success){
                location.reload();
            }

        },
        error: function (xhr) {
            alert(xhr.responseJSON.message || 'Update failed');
        }
    });

});


</script>
@endpush
