<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <meta name="csrf-token" content="{{ csrf_token() }}" />
    <title>Register</title>
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
        .links { margin-top:12px; font-size:14px; text-align:right; }
        a { color:#4f46e5; text-decoration:none; }
    </style>
</head>
<body>
    <div class="shell">
        <h1>Create account</h1>
        @if($errors->any())
            <ul style="color:#b91c1c; padding-left:18px;">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        @endif
        <form method="POST" action="{{ route('register') }}">
            @csrf
            <label for="name">Name</label>
            <input id="name" type="text" name="name" value="{{ old('name') }}" required autofocus />

            <label for="email">Email</label>
            <input id="email" type="email" name="email" value="{{ old('email') }}" required />

            <label for="password">Password</label>
            <input id="password" type="password" name="password" required autocomplete="new-password" />

            <label for="password_confirmation">Confirm Password</label>
            <input id="password_confirmation" type="password" name="password_confirmation" required autocomplete="new-password" />

            <button type="submit">Register</button>
        </form>

        <div class="links">
            <a href="{{ route('login') }}">Back to login</a>
        </div>
    </div>
</body>
</html>
