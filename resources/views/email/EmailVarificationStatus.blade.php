<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Email Verification Status</title>
    <style>
        body {
            font-family: sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f4f4f4;
        }
        .container {
            max-width: 600px;
            margin: 20px auto;
            background-color: #ffffff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
        }
        .header {
            text-align: center;
            padding-bottom: 20px;
            border-bottom: 1px solid #eeeeee;
        }
        .content {
            padding: 40px 20px;
            text-align: center;
        }
        .footer {
            text-align: center;
            padding-top: 20px;
            border-top: 1px solid #eeeeee;
            font-size: 12px;
            color: #999999;
        }
        .status-icon {
            font-size: 48px;
            margin-bottom: 20px;
            display: block;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h2>Email Verification Status</h2>
        </div>
        <div class="content">
            @if($status)
                <span class="status-icon" style="color: #28a745;">&#10004;</span>
                <h2 style="color: #28a745; margin-top: 0;">Verification Successful!</h2>
                <p>Your email address has been successfully verified. You can now log in to your account.</p>
            @else
                <span class="status-icon" style="color: #dc3545;">&#10008;</span>
                <h2 style="color: #dc3545; margin-top: 0;">Verification Failed</h2>
                <p>We could not verify your email address. The link may have expired or is invalid.</p>
            @endif
        </div>
        <div class="footer">
            <p>&copy; {{ date('Y') }} Tannesy. All rights reserved.</p>
        </div>
    </div>
</body>
</html>
