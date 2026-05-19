<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Login — {{ config('app.name') }}</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=DM+Sans:wght@300;400;500&display=swap" rel="stylesheet">

    <style>
        *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }

        :root {
            --teal: #0f7b6c;
            --teal-hover: #0a6358;
            --teal-light: #e4f5f2;
            --n50: #f8f7f4;
            --n100: #efefeb;
            --n200: #ddddd8;
            --n400: #9a9a94;
            --n600: #5a5a55;
            --n800: #2c2c28;
            --n900: #181815;
            --danger: #c0392b;
            --danger-light: #fdf0ef;
            --font: 'DM Sans', system-ui, sans-serif;
        }

        body {
            font-family: var(--font);
            background: var(--n900);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 1.5rem;
            -webkit-font-smoothing: antialiased;
        }

        .login-wrap {
            width: 100%;
            max-width: 380px;
        }

        .login-brand {
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 0.6rem;
            margin-bottom: 2rem;
        }

        .brand-mark {
            width: 36px;
            height: 36px;
            background: var(--teal);
            border-radius: 8px;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .brand-mark svg {
            width: 18px;
            height: 18px;
            stroke: #fff;
            stroke-width: 2.5;
            stroke-linecap: round;
            fill: none;
        }

        .brand-name {
            font-size: 1.1rem;
            font-weight: 500;
            color: #fff;
        }

        .login-card {
            background: #fff;
            border-radius: 12px;
            padding: 2rem;
        }

        .login-title {
            font-size: 1rem;
            font-weight: 500;
            color: var(--n800);
            margin-bottom: 0.25rem;
        }

        .login-sub {
            font-size: 0.82rem;
            color: var(--n400);
            margin-bottom: 1.75rem;
        }

        .form-group { margin-bottom: 1rem; }

        .form-label {
            display: block;
            font-size: 0.82rem;
            font-weight: 500;
            color: var(--n600);
            margin-bottom: 0.4rem;
        }

        .form-input {
            width: 100%;
            padding: 0.6rem 0.75rem;
            border: 1px solid var(--n200);
            border-radius: 6px;
            font-size: 0.875rem;
            font-family: var(--font);
            color: var(--n800);
            background: #fff;
            outline: none;
            transition: border-color 0.15s, box-shadow 0.15s;
        }

        .form-input:focus {
            border-color: var(--teal);
            box-shadow: 0 0 0 3px rgba(15,123,108,0.1);
        }

        .error-msg {
            display: flex;
            align-items: center;
            gap: 0.5rem;
            background: var(--danger-light);
            border: 1px solid #f0b8b3;
            color: var(--danger);
            font-size: 0.82rem;
            padding: 0.6rem 0.75rem;
            border-radius: 6px;
            margin-bottom: 1.25rem;
        }

        .error-msg svg {
            width: 14px;
            height: 14px;
            stroke: currentColor;
            stroke-width: 2;
            fill: none;
            flex-shrink: 0;
        }

        .btn-login {
            width: 100%;
            padding: 0.65rem 1rem;
            background: var(--teal);
            color: #fff;
            border: none;
            border-radius: 6px;
            font-size: 0.9rem;
            font-weight: 500;
            font-family: var(--font);
            cursor: pointer;
            margin-top: 1.5rem;
            transition: background 0.15s;
        }

        .btn-login:hover { background: var(--teal-hover); }

        @media (max-width: 767px) {
            .login-wrap {
                max-width: 100%;
            }

            .login-card {
                padding: 1.5rem;
            }

            .btn-login {
                padding: 0.6rem 0.75rem;
                font-size: 0.85rem;
            }
        }
    </style>
</head>
<body>

<div class="login-wrap">
    <div class="login-brand">
        <div class="brand-mark">
            <svg viewBox="0 0 24 24"><path d="M12 2v20M2 12h20"/></svg>
        </div>
        <span class="brand-name">{{ config('app.name') }}</span>
    </div>

    <div class="login-card">
        <p class="login-title">Admin sign in</p>
        <p class="login-sub">Enter your credentials to continue</p>

        @if($errors->any())
            <div class="error-msg">
                <svg viewBox="0 0 24 24"><circle cx="12" cy="12" r="10"/><line x1="12" y1="8" x2="12" y2="12"/><line x1="12" y1="16" x2="12.01" y2="16"/></svg>
                {{ $errors->first() }}
            </div>
        @endif

        <form action="{{ route('admin.login.post') }}" method="POST">
            @csrf
            <div class="form-group">
                <label class="form-label" for="username">Username</label>
                <input class="form-input" type="text" id="username" name="username"
                       value="{{ old('username') }}" required autocomplete="username" autofocus>
            </div>
            <div class="form-group">
                <label class="form-label" for="password">Password</label>
                <input class="form-input" type="password" id="password" name="password"
                       required autocomplete="current-password">
            </div>
            <button type="submit" class="btn-login">Sign in</button>
        </form>
    </div>
</div>

</body>
</html>
