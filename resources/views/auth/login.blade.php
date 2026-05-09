<!DOCTYPE html>
<html>
<head>
    <title>Login</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body class="bg-light">

<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-4">

            <div class="card p-4 shadow">

                <h4 class="text-center mb-3">Login</h4>

                <!-- Success -->
                @if(session('success'))
                    <div class="alert alert-success">
                        {{ session('success') }}
                    </div>
                @endif

                <!-- Error -->
                @if($errors->any())
                    <div class="alert alert-danger">
                        {{ $errors->first() }}
                    </div>
                @endif

          <!-- LOGIN FORM -->
                <form method="POST" action="/login">
                    @csrf

                    <input type="tel" name="mobile_no" placeholder="Mobile Number">

                    <input type="password" name="password" class="form-control mb-3" placeholder="Password">


                    <button type="submit" class="btn btn-primary w-100">
                        Log In
                    </button>

                </form>

            </div>

        </div>
    </div>
</div>

</body>
</html>