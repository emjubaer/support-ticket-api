<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>{{ $subject ?? 'Demo Email' }}</title>
</head>
<body style="font-family: Arial, sans-serif; background-color: #f4f4f4; padding: 20px;">

    <div style="max-width: 600px; margin: auto; background: #ffffff; padding: 20px; border-radius: 8px;">

        <h2 style="color: #333;">Hello, {{ $name ?? 'User' }} 👋</h2>

        <p style="color: #555;">
            {{ $messageBody ?? 'This is a demo email sent from Laravel Blade template.' }}
        </p>

        <div style="margin: 20px 0;">
            <a href="{{ $actionUrl ?? '#' }}"
               style="display: inline-block; padding: 10px 20px; background: #007bff; color: #fff; text-decoration: none; border-radius: 5px;">
                {{ $actionText ?? 'Click Here' }}
            </a>
        </div>

        <p style="color: #888; font-size: 12px;">
            If you did not request this email, please ignore it.
        </p>

        <hr>

        <p style="font-size: 12px; color: #aaa;">
            &copy; {{ date('Y') }} Your Company. All rights reserved.
        </p>

    </div>

</body>
</html>
