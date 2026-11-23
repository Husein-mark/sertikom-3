<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>@yield('title', 'Autentikasi') - The Nice Park Rumpin</title>
    <link rel="stylesheet" href="{{ asset('css/app.css') }}" />
    <style>
        .auth-container {
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 2rem 1rem;
            background-color: var(--bg-main);
        }
        .auth-box {
            width: 100%;
            max-width: 440px;
            background-color: var(--bg-card);
            border: 1px solid var(--border-color);
            border-radius: var(--radius-md);
            padding: 2.25rem;
        }
        .auth-logo {
            text-align: center;
            margin-bottom: 2rem;
        }
        .auth-logo a {
            font-family: 'Plus Jakarta Sans', sans-serif;
            font-size: 1.25rem;
            font-weight: 900;
            color: #ffffff;
            letter-spacing: 0.1em;
        }
        .auth-logo a span {
            color: var(--color-primary);
        }
        .auth-header {
            margin-bottom: 1.75rem;
            text-align: center;
        }
        .auth-header h2 {
            font-size: 1.2rem;
            color: #ffffff;
            margin-bottom: 0.35rem;
        }
        .auth-header p {
            font-size: 0.85rem;
            color: var(--text-muted);
        }
        .auth-footer-links {
            margin-top: 1.75rem;
            text-align: center;
            font-size: 0.82rem;
            color: var(--text-sub);
            border-top: 1px solid var(--border-color);
            padding-top: 1.25rem;
        }
    </style>
</head>
<body>
    <div class="auth-container">
        <div class="auth-box">
            <div class="auth-logo">
                <a href="{{ url('/') }}">NICEPARK <span>RUMPIN</span></a>
            </div>
            @yield('content')
        </div>
    </div>
</body>
</html>
