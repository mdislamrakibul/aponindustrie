<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Register</title>
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
            max-width: 440px;
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

        .error-msg {
            color: var(--accent);
            font-size: 13px;
            margin-top: 5px;
            font-weight: bold;
        }

        .name-row {
            display: flex;
            gap: 15px;
        }

        .name-row .input-group {
            flex: 1;
            min-width: 0;
        }

        @media (max-width: 380px) {
            .name-row {
                flex-direction: column;
                gap: 0;
            }
        }
    </style>
</head>

<body>
    <div class="login-container">
        <h1>REGISTER</h1>

        <form method="POST" action="{{ route('register.post') }}">
            @csrf

            <div class="name-row">
                <div class="input-group">
                    <label for="first_name">FIRST NAME</label>
                    <input type="text" id="first_name" name="first_name"
                           placeholder="First" value="{{ old('first_name') }}">
                    @error('first_name')
                        <div class="error-msg">{{ $message }}</div>
                    @enderror
                </div>

                <div class="input-group">
                    <label for="last_name">LAST NAME</label>
                    <input type="text" id="last_name" name="last_name"
                           placeholder="Last" value="{{ old('last_name') }}">
                    @error('last_name')
                        <div class="error-msg">{{ $message }}</div>
                    @enderror
                </div>
            </div>

            <div class="input-group">
                <label for="mobile_no">MOBILE NUMBER</label>
                <input type="tel" id="mobile_no" name="mobile_no"
                       placeholder="01XXXXXXXXX" value="{{ old('mobile_no') }}">
                @error('mobile_no')
                    <div class="error-msg">{{ $message }}</div>
                @enderror
            </div>

            <div class="input-group">
                <label for="password">PASSWORD</label>
                <input type="password" id="password" name="password"
                       placeholder="••••••••">
                @error('password')
                    <div class="error-msg">{{ $message }}</div>
                @enderror
            </div>

            <button type="submit">REGISTER</button>
        </form>

        <div class="divider">CREATE YOUR ACCOUNT</div>

        <div class="footer">
            Already have an account? <a href="{{ route('login') }}">Log In</a>
        </div>
    </div>
</body>
</html>
