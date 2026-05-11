<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>New Feedback</title>
</head>

<body style="margin: 0; padding: 0; font-family: Arial, sans-serif; background-color: #f4f4f4;">
    <table cellpadding="0" cellspacing="0" width="100%" style="padding: 30px;">
        <tr>
            <td>
                <table cellpadding="0" cellspacing="0" width="600" align="center"
                    style="background-color: #ffffff; border-radius: 8px; box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1); overflow: hidden;">
                    <!-- Header -->
                    <tr>
                        <td style="background-color: #55be30; padding: 20px 30px;">
                            <h2 style="color: #ffffff; margin: 0; font-size: 22px;">
                                🎉 New Feedback Received
                            </h2>
                            <p style="color: #dbe2ff; margin: 5px 0 0;">From <a href="https://thetime-calculator.com"
                                    style="color: #ffffff; text-decoration: underline;">thetime-calculator.com</a></p>
                        </td>
                    </tr>

                    <!-- Body -->
                    <tr>
                        <td style="padding: 30px;">
                            <table width="100%" cellpadding="0" cellspacing="0">
                                <tr>
                                    <td style="font-weight: bold; padding: 8px 0; color: #333;">Calculator Name:</td>
                                    <td style="padding: 8px 0; color: #555;">{{ $calName }}</td>
                                </tr>
                                <tr>
                                    <td style="font-weight: bold; padding: 8px 0; color: #333;">Name:</td>
                                    <td style="padding: 8px 0; color: #555;">{{ $name }}</td>
                                </tr>
                                <tr>
                                    <td style="font-weight: bold; padding: 8px 0; color: #333;">Email:</td>
                                    <td style="padding: 8px 0; color: #555;">{{ $email }}</td>
                                </tr>
                            </table>

                            <div style="margin-top: 20px;">
                                <p style="font-weight: bold; color: #333;">📝 Message:</p>
                                <div
                                    style="background-color: #f9f9f9; border-left: 4px solid #55be30; padding: 15px; color: #444; line-height: 1.6; border-radius: 4px;">
                                    {{ $messageText }}
                                </div>
                            </div>
                        </td>
                    </tr>

                    <!-- Footer -->
                    <tr>
                        <td style="background-color: #f0f0f0; padding: 20px 30px; text-align: center;">
                            <p style="margin: 0; font-size: 13px; color: #888;">
                                This message was sent via the feedback form at
                                <a href="https://thetime-calculator.com"
                                    style="color: #55be30; text-decoration: none;">thetime-calculator.com</a>
                            </p>
                        </td>
                    </tr>

                </table>
            </td>
        </tr>
    </table>
</body>

</html>
