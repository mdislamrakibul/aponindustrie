<!DOCTYPE html>
<html>
<head>
    <title>Admin Login</title>
</head>
<body>

<h2>Admin Login</h2>

@if ($errors->any())
    <div style="color:red;">
        {{ $errors->first() }}
    </div>
@endif

<form action="/admin/login" method="POST">

    @csrf

    <input type="text"
           name="mobile_no"
           placeholder="Mobile Number"
           maxlength="11"
           required>

    <br><br>

    <input type="password"
           name="password"
           placeholder="Password"
           required>

    <br><br>

    <button type="submit">
        Login
    </button>

</form>

</body>
</html>