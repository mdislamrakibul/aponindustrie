@extends('admin.layouts.app')

@section('content')

<div class="card">

    <div class="d-flex justify-content-between align-items-center mb-4">

        <h3 class="mb-0">
            Salary Management
        </h3>

        <button
            class="btn btn-primary"
            data-toggle="modal"
            data-target="#salaryModal"
        >
            <i class="fas fa-plus mr-1"></i>
            Add Salary
        </button>

    </div>
    <div class="modal fade" id="salaryModal">

        <div class="modal-dialog">

            <div class="modal-content">

                <form action="{{ route('accounts.salary.store') }}" method="POST">

                    @csrf

                    <div class="modal-header">
                        <h5 class="modal-title">
                            Add Salary
                        </h5>
                    </div>

                    <div class="modal-body">

                        <div class="form-group">
                            <label>User</label>

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
                                        ({{ $user->role }})
                                    </option>

                                @endforeach

                            </select>
                        </div>

                        <div class="form-group">
                            <label>Salary Type</label>

                            <select
                                name="salary_type"
                                class="form-control"
                            >
                                <option value="salary">Salary</option>
                                <option value="bonus">Bonus</option>
                                <option value="advance">Advance</option>
                            </select>
                        </div>

                        <div class="form-group">
                            <label>Amount</label>

                            <input
                                type="number"
                                name="salary"
                                class="form-control"
                                required
                            >
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
                            class="btn btn-success"
                        >
                            Save Salary
                        </button>

                    </div>

                </form>

            </div>

        </div>

    </div>
    

    <div class="card-body">
        <table class="table table-bordered">
            <tr>
                <th>User</th>
                <th>Salary</th>
                <th>Month</th>
            </tr>

            @foreach($salaries as $salary)
            <tr>
                <td>{{ $salary->first_name }}</td>
                <td>{{ $salary->total_salary }}</td>
                <td>{{ $salary->month }}</td>
            </tr>
            @endforeach
        </table>
    </div>
</div>

@endsection