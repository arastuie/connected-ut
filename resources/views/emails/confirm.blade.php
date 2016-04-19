<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Document</title>
</head>
<body>
    <h1>Thanks for signing up!</h1>

    <p>
        We just need to <a href='{{ url("auth/register/confirm/{$token}") }}'>confrim your email address</a> real quick! Keep in mind that this link will be expired within 24 hours.
    </p>

    <p>
        If you believe you received this email by mistake and you did not sign up for a ConnectedUT account, please <a href='{{ url("auth/register/disconfirm/{$token}") }}'>click here</a>.
    </p>
</body>
</html>