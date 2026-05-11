<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Reset Your Password</title>
</head>

<body style="font-family: Arial, sans-serif; background-color: #f4f4f4; padding: 40px; color: #333;">

    <div
        style="max-width: 600px; margin: auto; background-color: #ffffff; padding: 30px; border-radius: 8px; box-shadow: 0 4px 12px rgba(0,0,0,0.05);">

        <h2 style="color: #55be30; margin-bottom: 10px;">🔐 Forgot Your Password?</h2>

        <p style="margin-bottom: 20px;">
            No worries! Click the button below to reset your password. This link is valid for a limited time.
        </p>

        <div style="text-align: center; margin-bottom: 30px;">
            <a href="{{ route('reset.password.get', $token) }}"
                style="display: inline-block; background-color: #55be30; color: #ffffff; text-decoration: none; padding: 12px 25px; border-radius: 6px; font-weight: bold;">
                Reset Password
            </a>
        </div>

        <p style="font-size: 14px; color: #666;">
            If you didn’t request a password reset, you can safely ignore this email.
        </p>




    </div>

</body>

</html>
