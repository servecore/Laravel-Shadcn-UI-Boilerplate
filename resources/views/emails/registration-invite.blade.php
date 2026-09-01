<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Complete your registration</title>
</head>
<body style="margin:0;padding:0;background-color:#f4f5f7;font-family:Arial,Helvetica,sans-serif;">
    <table role="presentation" width="100%" cellpadding="0" cellspacing="0" style="background-color:#f4f5f7;padding:32px 16px;">
        <tr>
            <td align="center">
                <table role="presentation" width="100%" cellpadding="0" cellspacing="0" style="max-width:480px;background-color:#ffffff;border-radius:12px;overflow:hidden;">
                    <tr>
                        <td style="padding:32px;">
                            <h1 style="margin:0 0 8px;font-size:20px;line-height:1.3;color:#18181b;">Complete your registration</h1>
                            <p style="margin:0 0 16px;font-size:14px;line-height:1.6;color:#52525b;">
                                Hi there,
                            </p>
                            <p style="margin:0 0 16px;font-size:14px;line-height:1.6;color:#52525b;">
                                We received a request to create an account for
                                <strong style="color:#18181b;">{{ $invite->email }}</strong>.
                                Click the button below to choose your name, username, and password.
                            </p>
                            <p style="margin:0 0 24px;font-size:14px;line-height:1.6;color:#52525b;">
                                This link expires in 1 hour.
                            </p>
                            <table role="presentation" cellpadding="0" cellspacing="0" style="margin:0 0 24px;">
                                <tr>
                                    <td bgcolor="#18181b" style="border-radius:8px;">
                                        <a href="{{ $url }}" style="display:inline-block;padding:12px 24px;color:#ffffff;text-decoration:none;font-size:14px;font-weight:bold;">
                                            Set up your account
                                        </a>
                                    </td>
                                </tr>
                            </table>
                            <p style="margin:0 0 8px;font-size:13px;line-height:1.5;color:#71717a;">
                                If the button doesn't work, copy and paste this link into your browser:
                            </p>
                            <p style="margin:0;font-size:12px;line-height:1.5;color:#71717a;word-break:break-all;">
                                {{ $url }}
                            </p>
                        </td>
                    </tr>
                    <tr>
                        <td style="padding:16px 32px;background-color:#fafafa;border-top:1px solid #e4e4e7;">
                            <p style="margin:0;font-size:12px;color:#a1a1aa;">
                                If you didn't request this, you can safely ignore this email.
                            </p>
                        </td>
                    </tr>
                </table>
            </td>
        </tr>
    </table>
</body>
</html>
