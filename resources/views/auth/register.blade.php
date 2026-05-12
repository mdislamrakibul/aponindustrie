<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Register</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body class="bg-light">

<div class="container py-5">

    <div class="row justify-content-center align-items-center min-vh-100">

        <div class="col-lg-5 col-md-7">

            <div class="card border-0 shadow-lg rounded-4 overflow-hidden">

                <div class="card-body p-5">

                    <div class="text-center mb-4">
                        <h4 class="fw-bold">User Register</h4>
                        <p class="text-muted">Create a new account</p>
                    </div>

                    <form method="POST" action="{{ route('register.post') }}">
                        @csrf

                        <div class="mb-3">
                            <input type="text" name="first_name" class="form-control form-control-lg rounded-3" placeholder="First Name">
                        </div>

                        <div class="mb-3">
                            <input type="text" name="last_name" class="form-control form-control-lg rounded-3" placeholder="Last Name">
                        </div>

                        <div class="mb-3">
                            <input type="tel" name="mobile_no" class="form-control form-control-lg rounded-3" placeholder="01XXXXXXXXX">
                        </div>

                        <div class="mb-4">
                            <input type="password" name="password" class="form-control form-control-lg rounded-3" placeholder="Password">
                        </div>

                        <div class="d-grid">
                            <button type="submit" class="btn btn-dark btn-lg rounded-3">
                                Register
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