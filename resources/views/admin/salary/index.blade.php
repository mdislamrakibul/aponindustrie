{{-- 
@extends('admin.layouts.app')

@section('content')


@if(session('success'))
    <div class="alert alert-success">
        {{ session('success') }}
    </div>
@endif
<div class="d-flex justify-content-between align-items-center mb-3">

    <h4 class="mb-0">
        Salary Management
    </h4>

    <button
        type="submit"
        class="btn btn-primary"
    >
        <i class="fas fa-plus"></i>
        Add Salary
    </button>

</div>
<div
    class="modal fade"
    id="salaryModal"
    tabindex="-1"
>
    <div class="modal-dialog">

        <form
            action="{{ route('admin.salary.store') }}"
            method="POST"
            class="modal-content"
        >
            @csrf

            <div class="modal-header">

                <h5 class="modal-title">
                    Add Salary
                </h5>

                <button
                    type="button"
                    class="close"
                    data-dismiss="modal"
                >
                    <span>&times;</span>
                </button>

            </div>

            <div class="modal-body">

                <div class="form-group">

                    <label>Select User</label>

                    <select
                        name="user_id"
                        class="form-control"
                        required
                    >
                        <option value="">
                            Select User
                        </option>

                        @foreach($users as $user)

                            <option value="{{ $user->id }}">

                                {{ $user->first_name }}
                                ({{ ucfirst($user->role) }})

                            </option>

                        @endforeach

                    </select>

                </div>

                <div class="form-group">

                    <label>Salary Amount</label>

                    <input
                        type="number"
                        name="amount"
                        class="form-control"
                        required
                    >

                </div>

                <div class="form-group">

                    <label>Salary Type</label>

                    <select
                        name="type"
                        class="form-control"
                    >
                        <option value="salary">
                            Salary
                        </option>

                        <option value="bonus">
                            Bonus
                        </option>

                        <option value="advance">
                            Advance
                        </option>

                    </select>

                </div>

                <div class="form-group">

                    <label>Note</label>

                    <textarea
                        name="note"
                        class="form-control"
                        rows="3"
                    ></textarea>

                </div>

            </div>

            <div class="modal-footer">

                <button
                    type="submit"
                    class="btn btn-primary"
                >
                    <i class="fas fa-save"></i>
                    Save Salary
                </button>

            </div>

        </form>

    </div>
</div>

<table class="table table-bordered mt-3">
    <tr>
        <th>User</th>
        <th>Amount</th>
        <th>Type</th>
        <th>Note</th>
        <th>Date</th>
        <th>Action</th>
    </tr>

    @foreach($accounts as $acc)
    <tr>

        <td>
            {{ $acc->first_name }} {{ $acc->last_name }}
        </td>

        <td>
            ৳ {{ number_format($acc->amount, 2) }}
        </td>

        <td>

            @if($acc->type == 'salary')

                <span class="badge badge-success">
                    Salary
                </span>

            @elseif($acc->type == 'bonus')

                <span class="badge badge-primary">
                    Bonus
                </span>

            @else

                <span class="badge badge-warning">
                    Advance
                </span>

            @endif

        </td>

        <td>৳ {{ number_format($acc->amount, 2) }}</td>

        <td>
            <span class="badge badge-info">
                {{ ucfirst($acc->type) }}
            </span>
        </td>

        <td>
            {{ $acc->note ?? 'N/A' }}
        </td>

        <td>
            {{ date('d M Y', strtotime($acc->created_at)) }}
        </td>
        <td>

            <div class="action-btn-group">

                <button
                    type="button"
                    class="icon-action-btn edit-account-btn"

                    data-id="{{ $acc->id }}"

                    data-amount="{{ $acc->amount }}"

                    data-type="{{ $acc->type }}"

                    data-note="{{ $acc->note }}"
                >
                    <i class="fas fa-pen"></i>
                </button>

                <form
                    action="{{ route('admin.salary.delete', $acc->id) }}"
                    method="POST"
                    class="m-0"
                >
                    @csrf
                    @method('DELETE')

                    <button
                        type="submit"
                        class="icon-action-btn"
                        onclick="return confirm('Delete this account?')"
                    >
                        <i class="fas fa-trash"></i>
                    </button>

                </form>

            </div>

        </td>
    </tr>
    @endforeach
</table>
<div
    class="modal fade"
    id="editAccountModal"
    tabindex="-1"
>

    <div class="modal-dialog modal-dialog-centered">

        <div class="modal-content border-0 shadow-lg">

            <div class="modal-header border-0">

                <h5 class="modal-title font-weight-bold">
                    Edit Salary
                </h5>

                <button
                    type="button"
                    class="close"
                    data-dismiss="modal"
                >
                    <span>&times;</span>
                </button>

            </div>

            <form
                id="editAccountForm"
                method="POST"
            >
                @csrf

                <div class="modal-body">

                    <div class="mb-3">

                        <label>Amount</label>

                        <input
                            type="number"
                            name="amount"
                            id="edit-amount"
                            class="form-control"
                            required
                        >
                    </div>

                    <div class="mb-3">

                        <label>Type</label>

                        <select
                            name="type"
                            id="edit-type"
                            class="form-control"
                        >
                            <option value="salary">Salary</option>
                            <option value="bonus">Bonus</option>
                            <option value="advance">Advance</option>
                        </select>

                    </div>

                    <div class="mb-3">

                        <label>Note</label>

                        <textarea
                            name="note"
                            id="edit-note"
                            class="form-control"
                            rows="3"
                        ></textarea>

                    </div>

                </div>

                <div class="modal-footer border-0">

                    <button
                        type="submit"
                        class="btn btn-dark px-4"
                    >
                        Update
                    </button>

                </div>

            </form>

        </div>

    </div>

</div>

@endsection
@push('css')

<style>

.icon-action-btn {

    width: 38px;
    height: 38px;

    border-radius: 10px;

    border: none !important;

    background: #fff !important;

    color: #000 !important;

    display: inline-flex;

    align-items: center;

    justify-content: center;

    transition: all .2s ease;

    text-decoration: none !important;

    box-shadow: none !important;
}

.icon-action-btn:hover {

    background: #38bdf8 !important;

    color: #fff !important;

    transform: translateY(-2px);
}

.icon-action-btn:focus {

    outline: none !important;

    box-shadow: none !important;
}

.action-btn-group {

    display: flex;

    align-items: center;

    gap: 10px;
}
.salary-card {

    border-radius: 14px;

    border: 0;

    box-shadow: 0 2px 12px rgba(0,0,0,.06);
}

.salary-table th {

    background: #f8fafc;

    font-weight: 700;
}

.badge-type {

    padding: 6px 12px;

    border-radius: 30px;

    font-size: 12px;
}

</style>

@endpush
@push('js')

<script>

$(document).ready(function () {

    $('.edit-account-btn').on('click', function () {

        let id = $(this).data('id');

        let amount = $(this).data('amount');

        let type = $(this).data('type');

        let note = $(this).data('note');

        $('#edit-amount').val(amount);

        $('#edit-type').val(type);

        $('#edit-note').val(note);

        $('#editAccountForm').attr(
            'action',
            '/admin/salary/' + id + '/update'
        );

        $('#editAccountModal').modal('show');

    });

});

</script>

@endpush

--}}