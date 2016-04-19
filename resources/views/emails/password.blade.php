<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
</head>
<body>
    <h4>
        Did you forget your password?
    </h4>

    <p>
        No problem. <a href="{{ url('password/reset/'.$token) }}">Click here</a> to reset your password.
    </p>

    <p>
        If you believe you have received this email by mistake please <a href="{{ url('password/reset/cancel/'.$token) }}">click here</a>.
    </p>
</body>
</html>
