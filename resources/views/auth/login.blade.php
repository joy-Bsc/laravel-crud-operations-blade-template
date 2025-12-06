<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <meta name="csrf-token" content="{{ csrf_token() }}" />
    <title>Login</title>
    <style>
        body { margin:0; font-family: system-ui, -apple-system, sans-serif; background:#f5f5f8; color:#111; }
        .shell { max-width:420px; margin:60px auto; background:#fff; padding:32px; border-radius:12px; box-shadow:0 10px 30px -12px rgba(0,0,0,0.18); border:1px solid #e5e7eb; }
        h1 { margin:0 0 12px 0; font-size:24px; }
        .muted { color:#6b7280; font-size:14px; margin:0 0 24px 0; }
        label { display:block; margin-top:12px; font-weight:600; font-size:14px; }
        input { width:100%; padding:10px 12px; border:1px solid #e5e7eb; border-radius:10px; font-size:15px; margin-top:6px; }
        input:focus { outline:2px solid #4f46e5; border-color:#4f46e5; }
        button { width:100%; padding:12px; margin-top:20px; background:#4f46e5; color:#fff; border:none; border-radius:10px; font-weight:700; font-size:15px; cursor:pointer; }
        button:hover { background:#4338ca; }
        .links { display:flex; justify-content:space-between; margin-top:12px; font-size:14px; }
        a { color:#4f46e5; text-decoration:none; }
    </style>
</head>
<body>
    <div class="shell">
        <h1>Sign in</h1>
        @if(session('status'))
            <p class="muted">{{ session('status') }}</p>
        @endif
        @if($errors->any())
            <ul style="color:#b91c1c; padding-left:18px;">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        @endif
        <form method="POST" action="{{ route('login') }}">
            @csrf
            <label for="email">Email</label>
            <input id="email" type="email" name="email" value="{{ old('email') }}" required autofocus />

            <label for="password">Password</label>
            <input id="password" type="password" name="password" required autocomplete="current-password" />

            <div style="margin-top:12px; display:flex; align-items:center; gap:8px;">
                <input id="remember" type="checkbox" name="remember" style="width:16px; height:16px;" />
                <label for="remember" style="margin:0; font-weight:500;">Remember me</label>
            </div>

            <button type="submit">Login</button>
        </form>

        <div class="links">
            @if (Route::has('password.request'))
                <a href="{{ route('password.request') }}">Forgot password?</a>
            @endif
            @if (!empty($canRegister) && Route::has('register'))
                <a href="{{ route('register') }}">Create account</a>
            @endif
        </div>
    </div>
</body>
</html>
