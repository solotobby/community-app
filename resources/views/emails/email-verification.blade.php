<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Email Verification - Famlic</title>
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <style>
    body {
      font-family: Arial, sans-serif;
      background-color: #f9f9f9;
      color: #333333;
      margin: 0;
      padding: 0;
    }
    .container {
      max-width: 600px;
      margin: 30px auto;
      background: #ffffff;
      border-radius: 8px;
      overflow: hidden;
      box-shadow: 0 2px 8px rgba(0,0,0,0.1);
    }
    .header {
      background: #0d6efd;
      color: #ffffff;
      padding: 20px;
      text-align: center;
      font-size: 22px;
      font-weight: bold;
    }
    .content {
      padding: 30px 25px;
      text-align: center;
    }
    .token-box {
      font-size: 28px;
      font-weight: bold;
      letter-spacing: 8px;
      color: #0d6efd;
      margin: 20px 0;
      padding: 15px;
      border: 2px dashed #0d6efd;
      display: inline-block;
      border-radius: 6px;
      background: #f0f8ff;
    }
    .note {
      font-size: 14px;
      color: #666666;
      margin-top: 15px;
    }
    .footer {
      font-size: 12px;
      color: #999999;
      text-align: center;
      padding: 20px;
      border-top: 1px solid #eeeeee;
      background: #fafafa;
    }
    @media (max-width: 600px) {
      .token-box {
        font-size: 22px;
        letter-spacing: 6px;
      }
    }
  </style>
</head>
<body>
  <div class="container">
    <div class="header">
      Famlic Email Verification
    </div>
    <div class="content">
      <p>Hello,</p>
      <p>Use the 6-digit code below to verify your email address with <strong>Famlic</strong>:</p>

      <div class="token-box">
        {{ $code }}
      </div>

      <p class="note">
        This code will expire in <strong>10 minutes</strong>.
        If you did not request this verification, please ignore this message.
      </p>
    </div>
    <div class="footer">
      © {{ date('Y') }} Famlic. All rights reserved.<br>
      Securely powered by Famlic.
    </div>
  </div>
</body>
</html>
