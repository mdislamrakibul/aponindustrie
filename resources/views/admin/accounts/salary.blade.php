@extends('admin.layouts.app')

@section('content')

<div class="card">
    <div class="card-header">
        <h3>Salary Management</h3>
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