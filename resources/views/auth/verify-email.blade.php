<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}" />
    <title>Verify Email</title>
    <style>
        body { margin:0; font-family: system-ui, -apple-system, sans-serif; background:#f5f5f8; color:#111; }
        .shell { max-width:520px; margin:60px auto; background:#fff; padding:32px; border-radius:12px; box-shadow:0 10px 30px -12px rgba(0,0,0,0.18); border:1px solid #e5e7eb; text-align:center; }
        h1 { margin:0 0 12px 0; font-size:24px; }
        p { color:#374151; }
        form { margin-top:20px; }
        button { padding:12px 18px; background:#4f46e5; color:#fff; border:none; border-radius:10px; font-weight:700; font-size:15px; cursor:pointer; }
        button:hover { background:#4338ca; }
        a { color:#4f46e5; text-decoration:none; font-weight:600; }
    </style>
</head>
<body>
    <div class="shell">
        <h1>Verify your email</h1>
        @if (session('status') == 'verification-link-sent')
            <p style="color:#15803d;">A new verification link has been sent to your email.</p>
        @else
            <p>We sent a verification link to your email. Please click it to continue.</p>
        @endif
        <form method="POST" action="{{ route('verification.send') }}">
            @csrf
            <button type="submit">Resend verification email</button>
        </form>
        <p style="margin-top:16px;"><a href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">Logout</a></p>
        <form id="logout-form" method="POST" action="{{ route('logout') }}" style="display:none;">
            @csrf
        </form>
    </div>
</body>
</html>
