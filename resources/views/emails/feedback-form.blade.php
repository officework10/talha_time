<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>New Feedback Received</title>
    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background-color: #f4f7fa;
            margin: 0;
            padding: 30px 15px;
            color: #2e2e2e;
        }

        .email-wrapper {
            max-width: 650px;
            margin: auto;
            background: #ffffff;
            border-radius: 16px;
            overflow: hidden;
            box-shadow: 0 8px 30px rgba(0, 0, 0, 0.07);
            border-top: 8px solid #55be30;
        }

        .email-header {
            background-color: #55be30;
            color: #ffffff;
            padding: 24px 30px;
            text-align: center;
        }

        .email-header h1 {
            margin: 0;
            font-size: 22px;
        }

        .email-body {
            padding: 30px;
        }

        .info-section {
            margin-bottom: 24px;
        }

        .info-title {
            font-weight: bold;
            color: #555;
            margin-bottom: 6px;
        }

        .info-value {
            font-size: 16px;
            color: #1a1a1a;
        }

        .message-section {
            margin-top: 30px;
        }

        .message-box {
            background: #f2f7ff;
            padding: 20px;
            border-left: 4px solid #55be30;
            border-radius: 8px;
            font-size: 15px;
            line-height: 1.6;
            white-space: pre-line;
        }

        .email-footer {
            padding: 20px 30px;
            background: #f9fafc;
            text-align: center;
            font-size: 13px;
            color: #999;
        }
    </style>
</head>

<body>
    <div class="email-wrapper">
        <!-- Header -->
        <div class="email-header">
            <h1>You've Received New Feedback 🎉</h1>
            <p style="margin-top: 6px;">From <a style="color: white;" href="thetime-calculator.com">thetime-calculator.com</a></p>
        </div>

        <!-- Body -->
        <div class="email-body">
            <div class="info-section">
                <div class="info-title">👤 Name</div>
                <div class="info-value">{{ $name }}</div>
            </div>

            <div class="info-section">
                <div class="info-title">📧 Email</div>
                <div class="info-value">{{ $email }}</div>
            </div>

            <div class="info-section">
                <div class="info-title">📝 Subject</div>
                <div class="info-value">{{ $subjectLine }}</div>
            </div>

            <div class="message-section">
                <div class="info-title">💬 Message</div>
                <div class="message-box">
                    {{ $msg }}
                </div>
            </div>
        </div>

        <!-- Footer -->
        <div class="email-footer">
            This email was sent automatically from your thetime-calculator.com feedback form.
        </div>
    </div>
</body>

</html>
