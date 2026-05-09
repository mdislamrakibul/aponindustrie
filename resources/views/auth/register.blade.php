<form method="POST" action="{{ route('register.post') }}">
    @csrf

    <input type="text" name="first_name" placeholder="First Name" class="form-control mb-2">

    <input type="text" name="last_name" placeholder="Last Name" class="form-control mb-2">
    <input type="tel" name="mobile_no" placeholder="01XXXXXXXXX">
    <input type="password" name="password" placeholder="Password" class="form-control mb-3">

    <button type="submit" class="btn btn-success w-100">
        Sign Up
    </button>
</form>