<!DOCTYPE html>
<html>
<head>
    <title>Password Change OTP - {{ config('app.name') }}</title>
</head>
<body style="font-family: Arial, sans-serif; line-height: 1.6; color: #333;">
    <div style="max-width: 600px; margin: 0 auto; padding: 20px;">
        <h2>Password Change Confirmation</h2>

        <p>Dear {{ $data['name'] }},</p>

        <p>You have requested to change your password. Please use the following OTP to confirm:</p>

        <div style="background: #f4f4f4; padding: 15px; text-align: center; font-size: 24px; letter-spacing: 5px; margin: 20px 0;">
            {{ $data['otp'] }}
        </div>

        <p>This OTP will expire in {{ $data['expires_in'] ?? '10 minutes' }}.</p>

        <p>If you didn't initiate this password change, please contact support immediately.</p>

        <p>Best regards,<br>{{ config('app.name') }} Team</p>
    </div>
</body>
</html>
