<table class="table table-bordered">

<tr>
    <th>SL.</th>
    <th>Name</th>
    <th>Email</th>
    <th>Role</th>
    <th>Salary</th>
    <th>Status</th>
</tr>

@foreach($users as $user)

<tr>

<td>{{ $loop->iteration }}.</td>
<td>{{ $user->name }}</td>
<td>{{ $user->email }}</td>
<td>{{ $user->role }}</td>
<td>{{ $user->salary }}</td>
<td>{{ $user->status }}</td>

</tr>

@endforeach

</table>
