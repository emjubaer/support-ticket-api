<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>New Ticket Alert</title>
</head>
<body style="margin:0; padding:0; background:#f4f6f8; font-family: Arial, sans-serif;">

<table width="100%" cellpadding="0" cellspacing="0">
    <tr>
        <td align="center">

            <!-- Main Container -->
            <table width="600" cellpadding="0" cellspacing="0"
                   style="background:#ffffff; margin:40px auto; border-radius:8px; overflow:hidden; box-shadow:0 4px 10px rgba(0,0,0,0.05);">

                <!-- Header -->
                <tr>
                    <td style="background:#dc2626; padding:20px; text-align:center; color:#ffffff; font-size:20px; font-weight:bold;">
                        🚨 New Ticket Received
                    </td>
                </tr>

                <!-- Body -->
                <tr>
                    <td style="padding:30px; color:#333;">

                        <p style="font-size:16px; margin-bottom:10px;">
                            Hello Admin, 👋
                        </p>

                        <p style="font-size:14px; margin-bottom:20px;">
                            A new support ticket has been created and requires your attention.
                        </p>

                        <!-- Ticket Info Box -->
                        <table width="100%" cellpadding="10" cellspacing="0"
                               style="border:1px solid #eee; border-radius:6px;">

                            <tr>
                                <td style="font-weight:bold; width:150px;">Ticket ID:</td>
                                <td>#{{ $ticket->id }}</td>
                            </tr>

                            <tr style="background:#fafafa;">
                                <td style="font-weight:bold;">Subject:</td>
                                <td>{{ $ticket->subject }}</td>
                            </tr>

                            <tr>
                                <td style="font-weight:bold;">Created By:</td>
                                <td>{{ $ticket->customer->name ?? 'Unknown User' }}</td>
                            </tr>

                            <tr style="background:#fafafa;">
                                <td style="font-weight:bold;">Email:</td>
                                <td>{{ $ticket->customer->email ?? 'N/A' }}</td>
                            </tr>

                            <tr>
                                <td style="font-weight:bold;">Message:</td>
                                <td>
                                    {{ $ticket->messages->first()->message ?? 'No message provided' }}
                                </td>
                            </tr>

                            <tr style="background:#fafafa;">
                                <td style="font-weight:bold;">Status:</td>
                                <td>
                                    <span style="background:#fef3c7; color:#92400e; padding:5px 10px; border-radius:20px; font-size:12px;">
                                        {{ $ticket->status->label() }}
                                    </span>
                                </td>
                            </tr>

                        </table>

                        <p style="font-size:14px; margin-top:25px;">
                            Please review and assign this ticket to an agent as soon as possible.
                        </p>

                    </td>
                </tr>

                <!-- Footer -->
                <tr>
                    <td style="background:#f9fafb; text-align:center; padding:15px; font-size:12px; color:#777;">
                        © {{ date('Y') }} Support System Admin Panel
                    </td>
                </tr>

            </table>

        </td>
    </tr>
</table>

</body>
</html>
