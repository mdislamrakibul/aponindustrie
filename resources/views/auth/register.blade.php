<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Register</title>

    <!-- AdminLTE -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/admin-lte@3.2/dist/css/adminlte.min.css">

    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
</head>

<body class="hold-transition register-page">

<div class="register-box">

    <div class="register-logo">
        <b>User</b> Register
    </div>

    <div class="card">

        <div class="card-body register-card-body">

            <p class="login-box-msg">
                Create a new account
            </p>

            <form method="POST" action="{{ route('register.post') }}">
                @csrf

                <div class="input-group mb-3">

                    <input type="text"
                           name="first_name"
                           class="form-control"
                           placeholder="First Name">

                    <div class="input-group-append">
                        <div class="input-group-text">
                            <span class="fas fa-user"></span>
                        </div>
                    </div>

                </div>

                <div class="input-group mb-3">

                    <input type="text"
                           name="last_name"
                           class="form-control"
                           placeholder="Last Name">

                    <div class="input-group-append">
                        <div class="input-group-text">
                            <span class="fas fa-user"></span>
                        </div>
                    </div>

                </div>

                <div class="input-group mb-3">

                    <input type="tel"
                           name="mobile_no"
                           class="form-control"
                           placeholder="01XXXXXXXXX">

                    <div class="input-group-append">
                        <div class="input-group-text">
                            <span class="fas fa-phone"></span>
                        </div>
                    </div>

                </div>

                <div class="input-group mb-3">

                    <input type="password"
                           name="password"
                           class="form-control"
                           placeholder="Password">

                    <div class="input-group-append">
                        <div class="input-group-text">
                            <span class="fas fa-lock"></span>
                        </div>
                    </div>

                </div>

                <button type="submit" class="btn btn-success btn-block">
                    Register
                </button>

            </form>

        </div>

    </div>

</div>

</body>
</html>