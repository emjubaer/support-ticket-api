<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Ticket Created</title>
</head>
<body style="margin:0; padding:0; background:#f4f6f8; font-family: Arial, sans-serif;">

    <table width="100%" cellpadding="0" cellspacing="0">
        <tr>
            <td align="center">

                <!-- Main Container -->
                <table width="600" cellpadding="0" cellspacing="0" style="background:#ffffff; margin:40px auto; border-radius:8px; overflow:hidden; box-shadow:0 4px 10px rgba(0,0,0,0.05);">

                    <!-- Header -->
                    <tr>
                        <td style="background:#4f46e5; padding:20px; text-align:center; color:#ffffff; font-size:20px; font-weight:bold;">
                            🎫 Ticket Created Successfully
                        </td>
                    </tr>

                    <!-- Body -->
                    <tr>
                        <td style="padding:30px; color:#333;">

                            <p style="font-size:16px; margin-bottom:15px;">
                                Hello, 👋
                            </p>

                            <p style="font-size:14px; margin-bottom:20px;">
                                Your support ticket has been created successfully. Here are the details:
                            </p>

                            <!-- Ticket Box -->
                            <table width="100%" cellpadding="10" cellspacing="0" style="border:1px solid #eee; border-radius:6px;">

                                <tr>
                                    <td style="font-weight:bold; width:150px;">Ticket ID:</td>
                                    <td>#{{ $ticket->id }}</td>
                                </tr>

                                <tr style="background:#fafafa;">
                                    <td style="font-weight:bold;">Title:</td>
                                    <td>{{ $ticket->subject }}</td>
                                </tr>

                                <tr>
                                    <td style="font-weight:bold;">Description:</td>
                                    <td>{{ $ticket->messages->first()->message ?? 'No Description Provided' }}</td>
                                </tr>

                                <tr style="background:#fafafa;">
                                    <td style="font-weight:bold;">Status:</td>
                                    <td>
                                        <span style="background:#e0f2fe; color:#0369a1; padding:5px 10px; border-radius:20px; font-size:12px;">
                                            {{ $ticket->status->label()}}
                                        </span>
                                    </td>
                                </tr>

                            </table>

                            <p style="font-size:14px; margin-top:25px;">
                                Our team will review your ticket and get back to you shortly.
                            </p>

                            <p style="font-size:14px; margin-top:20px;">
                                Thank you 🙏
                            </p>

                        </td>
                    </tr>

                    <!-- Footer -->
                    <tr>
                        <td style="background:#f9fafb; text-align:center; padding:15px; font-size:12px; color:#777;">
                            © {{ date('Y') }} Your Support System. All rights reserved.
                        </td>
                    </tr>

                </table>

            </td>
        </tr>
    </table>

</body>
</html>
