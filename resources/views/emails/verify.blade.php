<!-- resources/views/emails/verify.blade.php -->

<!DOCTYPE html>
<html>

<head>
    <title>Verify Your Email Address</title>
</head>

<body>
    <h1>Hi {{ $user->name ?? 'User' }},</h1>

    <p>Thank you for registering! Please click the link below to verify your email address:</p>

    <p>
        <a href="{!! $verificationUrl !!}">Verify Email Address</a>
    </p>

    <p>If you did not create an account, no further action is required.</p>

    <p>Thanks,<br>Your App Team</p>
</body>

</html>