@extends('admin.layouts.app')

@section('content')

<h3 class="font-weight-bold mb-4">
    Accounts
</h3>

@if(session('success'))
    <div class="alert alert-success">
        {{ session('success') }}
    </div>
@endif

<table class="table table-bordered mt-3">
    <tr>
        <th>User</th>
        <th>Amount</th>
        <th>Type</th>
        <th>Note</th>
        <th>Action</th>
    </tr>

    @foreach($accounts as $acc)
    <tr>
        <td>{{ $acc->first_name ?? 'N/A' }}</td>
        <td>{{ $acc->amount }}</td>
        <td>{{ $acc->type }}</td>
        <td>{{ $acc->note }}</td>
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
                    action="{{ route('admin.accounts.delete', $acc->id) }}"
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

</style>

@endpush
@push('js')

<script>

$('.edit-account-btn').on('click', function () {

    const id = $(this).data('id');

    const amount = $(this).data('amount');

    const type = $(this).data('type');

    const note = $(this).data('note');

    $('#edit-amount').val(amount);

    $('#edit-type').val(type);

    $('#edit-note').val(note);

    $('#editAccountForm').attr(
        'action',
        '/admin/accounts/' + id + '/update'
    );

    $('#editAccountModal').modal('show');

});

</script>

@endpush