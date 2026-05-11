<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>New Contact Message From Logical Calculator</title>
</head>

<body style="margin: 0; padding: 0; font-family: Arial, sans-serif; background-color: #f9f9f9;">

    <table width="100%" cellpadding="0" cellspacing="0" style="background-color: #f9f9f9; padding: 20px;">
        <tr>
            <td align="center">
                <table width="600" cellpadding="0" cellspacing="0"
                    style="background-color: #ffffff; border-radius: 8px; overflow: hidden; box-shadow: 0 4px 12px rgba(0,0,0,0.1);">
                    <tr>
                        <td style="background-color: #4CAF50; padding: 20px; color: white; text-align: center;">
                            <h2 style="margin: 0;">📩 New Contact Message From thetime-calculator.com</h2>
                        </td>
                    </tr>
                    <tr>
                        <td style="padding: 30px;">
                            <p style="font-size: 16px; color: #333333;"><strong>Name:</strong> {{ $name }}</p>
                            <p style="font-size: 16px; color: #333333;"><strong>Email:</strong> {{ $email }}</p>
                            <p style="font-size: 16px; color: #333333;"><strong>Subject:</strong> {{ $subjectLine }}
                            </p>

                            <hr style="margin: 20px 0; border: none; border-top: 1px solid #eeeeee;">

                            <p style="font-size: 16px; color: #333333;"><strong>Message:</strong></p>
                            <p style="font-size: 16px; color: #555555; line-height: 1.6;">{{ $msg }}</p>
                        </td>
                    </tr>
                    <tr>
                        <td
                            style="background-color: #f0f0f0; padding: 15px; text-align: center; font-size: 12px; color: #888;">
                            This message was sent via the contact form on your thetime-calculator.com
                        </td>
                    </tr>
                </table>
            </td>
        </tr>
    </table>

</body>

</html>
