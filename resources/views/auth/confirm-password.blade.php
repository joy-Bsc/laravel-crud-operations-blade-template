<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}" />
    <title>Confirm Password</title>
    <style>
        body { margin:0; font-family: system-ui, -apple-system, sans-serif; background:#f5f5f8; color:#111; }
        .shell { max-width:420px; margin:60px auto; background:#fff; padding:32px; border-radius:12px; box-shadow:0 10px 30px -12px rgba(0,0,0,0.18); border:1px solid #e5e7eb; }
        h1 { margin:0 0 12px 0; font-size:24px; }
        label { display:block; margin-top:12px; font-weight:600; font-size:14px; }
        input { width:100%; padding:10px 12px; border:1px solid #e5e7eb; border-radius:10px; font-size:15px; margin-top:6px; }
        input:focus { outline:2px solid #4f46e5; border-color:#4f46e5; }
        button { width:100%; padding:12px; margin-top:20px; background:#4f46e5; color:#fff; border:none; border-radius:10px; font-weight:700; font-size:15px; cursor:pointer; }
        button:hover { background:#4338ca; }
        a { color:#4f46e5; text-decoration:none; font-size:14px; }
    </style>
</head>
<body>
    <div class="shell">
        <h1>Confirm password</h1>
        @if ($errors->any())
            <ul style="color:#b91c1c; padding-left:18px;">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        @endif
        <form method="POST" action="{{ route('password.confirm') }}">
            @csrf
            <label for="password">Password</label>
            <input id="password" type="password" name="password" required autocomplete="current-password" />
            <button type="submit">Confirm</button>
        </form>
    </div>
</body>
</html>
