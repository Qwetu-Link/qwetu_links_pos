<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <title>Verify Your Qwetu Link Account</title>
</head>

<body>
    <div
        style="background-color: rgba(200, 255, 200, 0.5); padding: 20px; border-radius: 8px; border-left: 4px solid #28a745; max-width: 600px; margin: 20px auto; font-family: Arial, sans-serif; text-align: center;">

        <!-- Logo -->
        <header style="margin-bottom: 20px;">
            <img src="http://pos.qwetulinks.co.ke/image/qwetu_link_pos.png" alt="Qwetu Link" height="50px">
        </header>

        <!-- Greeting -->
        <h2 style="color: #28a745; text-align:center;">Hello, {{ $name }}</h2>

        <p style="text-align:center;">Thank you for registering for a <strong>{{ $role }}</strong> account with
            <strong>{{ $business }}</strong> on <strong>Qwetu Link POS</strong>.
        </p>

        <p style="text-align:center;">Please verify your email address to activate your account:</p>

        <!-- Button -->
        <div style="margin: 20px 0;">
            <a href="{{ route('verify.email', ['token' => $token, 'email' => $email]) }}"
                style="background-color: #28a745; color: white; padding: 12px 20px; text-decoration: none; border-radius: 5px; display: inline-block;">
                Verify Account
            </a>
        </div>

        <!-- EXPIRY NOTICE -->
        <p style="color: #d9534f; font-weight: bold; text-align:center;">
            ⚠️ This verification link will expire in 24 hours.
        </p>

        {{-- <p style="color: #d9534f; font-weight: bold;">
            ⚠️ This verification link expires at {{ $expires_at }}.
        </p> --}}

        <p style="color: #777; text-align:center;">If you did not request this, ignore this email.</p>

        <p style="font-size: 12px; color: #aaa; text-align:center;">
            &copy; {{ date('Y') }} {{ config('app.name') }}
        </p>

    </div>
</body>

</html>
