<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Admin Login</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body class="bg-light">

<div class="container py-5">

    <div class="row justify-content-center align-items-center min-vh-100">

        <div class="col-lg-5 col-md-7">

            <div class="card border-0 shadow-lg rounded-4 overflow-hidden">

                <div class="card-body p-5">

                    <div class="text-center mb-4">
                        <h4 class="fw-bold">Admin Login</h4>
                        <p class="text-muted">Sign in to start your session</p>
                    </div>

                    <form action="{{ url('/admin/login') }}" method="POST">
                        @csrf

                        <div class="mb-3">
                            <input type="text" name="mobile_no" class="form-control form-control-lg rounded-3" placeholder="Phone Number">
                        </div>

                        <div class="mb-3">
                            <input type="password" name="password" class="form-control form-control-lg rounded-3" placeholder="Password" autocomplete="new-password">
                        </div>

                        <div class="d-flex justify-content-between align-items-center mb-3">

                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" id="remember" name="remember">
                                <label class="form-check-label" for="remember">
                                    Remember Me
                                </label>
                            </div>

                            <a href="#" class="text-decoration-none small">
                                Forgot password?
                            </a>

                        </div>

                        <div class="d-grid">
                            <button type="submit" class="btn btn-dark btn-lg rounded-3">
                                Login
                            </button>
                        </div>

                    </form>

                </div>

            </div>

        </div>

    </div>

</div>

</body>
</html>