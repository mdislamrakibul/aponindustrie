@extends('admin.layouts.app')

@section('content')

<div class="card">
    <div class="card-header">
        <h3>Add Salary</h3>
    </div>

    <div class="card-body">

        <form action="{{ route('admin.accounts.store', $user->id) }}" 
              method="POST">

            @csrf

            <div class="mb-3">
                <label>User Name</label>

                <input type="text"
                       class="form-control"
                       value="{{ $user->first_name }}"
                       readonly>
            </div>

            <div class="mb-3">
                <label>Amount</label>

                <input type="number"
                       name="amount"
                       class="form-control"
                       placeholder="Enter Salary Amount">
            </div>

            <div class="mb-3">
                <label>Type</label>

                <select name="type" class="form-control">

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

            <div class="mb-3">
                <label>Note</label>

                <textarea name="note"
                          class="form-control"
                          rows="4"></textarea>
            </div>

            <button class="btn btn-success">
                Save Salary
            </button>

        </form>

    </div>
</div>

@endsection