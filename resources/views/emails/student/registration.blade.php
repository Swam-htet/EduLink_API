<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Welcome to EduLink</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            line-height: 1.6;
            color: #333;
            max-width: 600px;
            margin: 0 auto;
            padding: 20px;
        }
        .header {
            background-color: #4a6fdc;
            color: white;
            padding: 20px;
            text-align: center;
            border-radius: 5px 5px 0 0;
        }
        .content {
            padding: 20px;
            border: 1px solid #ddd;
            border-top: none;
            border-radius: 0 0 5px 5px;
        }
        .footer {
            text-align: center;
            margin-top: 20px;
            font-size: 12px;
            color: #777;
        }
        .button {
            display: inline-block;
            background-color: #4a6fdc;
            color: white;
            text-decoration: none;
            padding: 10px 20px;
            border-radius: 5px;
            margin: 20px 0;
        }
    </style>
</head>
<body>
    <div class="header">
        <h1>Welcome to EduLink!</h1>
    </div>
    <div class="content">
        <p>Dear {{ $student->first_name }} {{ $student->last_name }},</p>

        <p>Thank you for registering with EduLink. Your account has been successfully created!</p>

        <p><strong>Your Student ID:</strong> {{ $student->student_id }}</p>

        <p>You can now access your student portal using your email and password.</p>

        <p style="text-align: center;">
            <a href="{{ $loginUrl }}" class="button">Login to Your Account</a>
        </p>

        <p>If you have any questions or need assistance, please don't hesitate to contact our support team.</p>

        <p>Best regards,<br>The EduLink Team</p>
    </div>
    <div class="footer">
        <p>This is an automated email. Please do not reply to this message.</p>
        <p>&copy; {{ date('Y') }} EduLink. All rights reserved.</p>
    </div>
</body>
</html>
