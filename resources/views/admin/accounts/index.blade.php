@extends('admin.layouts.app')

@section('content')

<h3>Account Management</h3>

<a href="{{ route('admin.accounts.create') }}" class="btn btn-primary">
    Add Salary
</a>

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
            <a href="{{ route('admin.accounts.edit', $acc->id) }}" class="btn btn-warning btn-sm">
                Edit
            </a>

            <form action="{{ route('admin.accounts.delete', $acc->id) }}" method="POST">
                @csrf
                @method('DELETE')
                <button class="btn btn-danger btn-sm">Delete</button>
            </form>
        </td>
    </tr>
    @endforeach
</table>

@endsection