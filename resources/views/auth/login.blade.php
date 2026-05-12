<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="UTF-8">

    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Login</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

</head>

<body class="bg-light"></body>

<div class="container py-5">

    <div class="row justify-content-center align-items-center min-vh-100">

        <div class="col-lg-5 col-md-7">

            <div class="card border-0 shadow-lg rounded-4 overflow-hidden">

                <div class="card-body p-5">

                    <div class="text-center mb-4">

                        <p class="text-muted">
                            Login to your account
                        </p>

                    </div>

                    {{-- Success Message --}}
                    @if(session('success'))
                        <div class="alert alert-success rounded-3">
                            {{ session('success') }}
                        </div>
                    @endif

                    {{-- Error Message --}}
                    @if(session('error'))
                        <div class="alert alert-danger rounded-3">
                            {{ session('error') }}
                        </div>
                    @endif

                    {{-- Validation Errors --}}
                    @if($errors->any())
                        <div class="alert alert-danger rounded-3">
                            <ul class="mb-0">
                                @foreach($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <form method="POST" action="{{ url('/login') }}">

                        @csrf

                        {{-- Mobile Number --}}
                        <div class="mb-4">

                            <label class="form-label fw-semibold">
                                Mobile Number
                            </label>

                            <input
                                type="text"
                                name="mobile_no"
                                class="form-control form-control-lg rounded-3"
                                placeholder="017XXXXXXXX"
                                value="{{ old('mobile_no') }}"
                                required
                            >

                        </div>

                        {{-- Password --}}
                        <div class="mb-4">

                            <label class="form-label fw-semibold">
                                Password
                            </label>

                            <input
                                type="password"
                                name="password"
                                class="form-control form-control-lg rounded-3"
                                placeholder="Enter Password"
                                required
                            >

                        </div>

                        {{-- Login Button --}}
                        <div class="d-grid">

                            <button
                                type="submit"
                                class="btn btn-dark btn-lg rounded-3"
                            >
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