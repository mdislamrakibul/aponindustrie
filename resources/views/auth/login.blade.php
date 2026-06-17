{{-- <!DOCTYPE html>
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


                    @include('components.alerts')
                    <form method="POST" action="{{ route('login.post') }}">
                        @csrf

                        <div class="mb-4">
                            <label class="form-label fw-semibold">
                                Mobile Number
                            </label>
                            <input type="text" name="mobile_no" class="form-control form-control-lg rounded-3"
                                placeholder="Enter mobile number" value="{{ old('mobile_no') }}" required>
                        </div>


                        <div class="mb-4">
                            <label class="form-label fw-semibold">
                                Password
                            </label>
                            <input type="password" name="password" class="form-control form-control-lg rounded-3"
                                placeholder="Enter Password" required>
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
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html> --}}





<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Login</title>


    <style>
        :root {
            --primary: #000000;
            --secondary: #FFFFFF;
            --accent: #FF5E5B;
            --shadow: 8px 8px 0px var(--primary);
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Courier New', monospace;
        }

        body {
            background-color: var(--secondary);
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
            padding: 20px;
        }

        .login-container {
            width: 100%;
            max-width: 400px;
            border: 1px solid var(--primary);
            padding: 40px 30px;
            background-color: var(--secondary);
            box-shadow: var(--shadow);
            position: relative;
            border-radius: 12px;
        }

        .login-container::before {
            content: '';
            position: absolute;
            top: 6px;
            left: 6px;
            right: -6px;
            bottom: -6px;
            border: 1px solid var(--primary);
            z-index: -1;
            border-radius: 12px;
        }

        h1 {
            color: var(--primary);
            margin-bottom: 30px;
            font-size: 28px;
            font-weight: 700;
            text-align: center;
        }

        .input-group {
            margin-bottom: 20px;
            position: relative;
        }

        label {
            display: block;
            margin-bottom: 8px;
            font-weight: bold;
            color: var(--primary);
        }

        input {
            width: 100%;
            padding: 12px 15px;
            border: 2px solid var(--primary);
            background-color: var(--secondary);
            font-size: 16px;
            outline: none;
            transition: all 0.3s;
        }

        input:focus {
            box-shadow: 4px 4px 0px var(--primary);
        }

        button {
            width: 100%;
            padding: 12px;
            background-color: var(--accent);
            color: var(--secondary);
            border: 2px solid var(--primary);
            font-size: 16px;
            font-weight: bold;
            cursor: pointer;
            margin-top: 10px;
            transition: all 0.3s;
        }

        button:hover {
            box-shadow: 4px 4px 0px var(--primary);
            transform: translate(-2px, -2px);
        }

        .divider {
            display: flex;
            align-items: center;
            margin: 25px 0;
            color: var(--primary);
            font-weight: bold;
        }

        .divider::before,
        .divider::after {
            content: "";
            flex: 1;
            border-bottom: 2px solid var(--primary);
            margin: 0 10px;
        }

        .social-login {
            display: flex;
            justify-content: center;
            gap: 15px;
        }

        .social-btn {
            width: 50px;
            height: 50px;
            border: 2px solid var(--primary);
            display: flex;
            justify-content: center;
            align-items: center;
            cursor: pointer;
            transition: all 0.3s;
        }

        .social-btn:hover {
            box-shadow: 4px 4px 0px var(--primary);
            transform: translate(-2px, -2px);
        }

        .footer {
            text-align: center;
            margin-top: 20px;
            color: var(--primary);
        }

        .footer a {
            color: var(--primary);
            font-weight: bold;
            text-decoration: underline;
        }

        .pwd-wrapper { position: relative; }
        .pwd-wrapper input { width: 100%; padding-right: 60px; }
        #togglePwd {
            position: absolute;
            right: 0;
            top: 0;
            height: 100%;
            display: flex;
            align-items: center;
            padding: 0 12px;
            border-left: 2px solid var(--primary);
            cursor: pointer;
            font-size: 11px;
            font-weight: bold;
            letter-spacing: 1px;
            color: var(--primary);
            user-select: none;
            background: transparent;
        }
        #togglePwd:hover { background: #f0f0f0; }
    </style>
</head>

<body class="bg-light">



    <div class="login-container">
        <h1>LOGIN</h1>
        @include('components.alerts')
        <form action="{{ route('login.post') }}" method="POST">
            @csrf

            <div class="input-group">
                <label for="mobile_no">MOBILE NUMBER</label>
                {{-- <input type="text" id="mobile_no" name="mobile_no" placeholder="01XXXXXXXXX"> --}}
                <input type="text" id="mobile_no" name="mobile_no" class="form-control form-control-lg rounded-3"
                                placeholder="Enter mobile number" value="{{ old('mobile_no') }}" required>
            </div>

            <div class="input-group">
                <label for="password">PASSWORD</label>
                <div class="pwd-wrapper">
                    <input type="password" id="password" name="password" placeholder="••••••••" required>
                    <span id="togglePwd" onclick="var p=document.getElementById('password');var on=p.type==='password';p.type=on?'text':'password';this.textContent=on?'HIDE':'SHOW';">SHOW</span>
                </div>
            </div>

            <button type="submit">LOG IN</button>
        </form>

        <div class="divider">OR</div>

        <div class="footer">
            Don't have an account? <a href="{{ route('register') }}">Sign Up</a>
        </div>
    </div>



</body>

</html>
