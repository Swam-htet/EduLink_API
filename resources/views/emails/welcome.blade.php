<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Welcome to EduLink</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            line-height: 1.6;
            margin: 0;
            padding: 0;
            background-color: #f6f9fc;
        }
        .container {
            max-width: 600px;
            margin: 20px auto;
            background: white;
            border-radius: 10px;
            box-shadow: 0 2px 5px rgba(0,0,0,0.1);
            overflow: hidden;
        }
        .header {
            background: #4f46e5;
            color: white;
            padding: 30px;
            text-align: center;
        }
        .content {
            padding: 30px;
            color: #333;
        }
        .footer {
            background: #f8fafc;
            padding: 20px;
            text-align: center;
            font-size: 12px;
            color: #666;
        }
        .button {
            display: inline-block;
            background: #4f46e5;
            color: white;
            padding: 12px 25px;
            text-decoration: none;
            border-radius: 5px;
            margin: 20px 0;
        }
        .social-links {
            margin-top: 20px;
        }
        .social-links a {
            color: #4f46e5;
            margin: 0 10px;
            text-decoration: none;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>Welcome to EduLink!</h1>
        </div>

        <div class="content">
            <h2>Hello {{ $name }},</h2>

            <p>Welcome to EduLink! We're thrilled to have you join our educational community.</p>

            <p>Your account has been successfully created with the email: <strong>{{ $email }}</strong></p>

            <p>With EduLink, you can:</p>
            <ul>
                <li>Access your academic records</li>
                <li>Connect with teachers and classmates</li>
                <li>Track your assignments and grades</li>
                <li>Stay updated with school announcements</li>
            </ul>

            <center>
                <a href="{{ config('app.url') }}/login" class="button">Get Started</a>
            </center>

            <p>If you have any questions or need assistance, don't hesitate to contact our support team.</p>

            <p>Best regards,<br>The EduLink Team</p>
        </div>

        <div class="footer">
            <p>© {{ date('Y') }} EduLink. All rights reserved.</p>
            <div class="social-links">
                <a href="#">Facebook</a> |
                <a href="#">Twitter</a> |
                <a href="#">Instagram</a>
            </div>
            <p>You received this email because you signed up for EduLink.</p>
        </div>
    </div>
</body>
</html>
