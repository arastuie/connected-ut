<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>ConnectedUT</title>

    <style>
        div.logo_div{
            font-family: 'Helvetica Neue', sans-serif;
            font-weight: bold;
            font-size: 25px;
        }

        div.logo_div a{
            text-decoration: none;
            color: #222;
        }

        div.logo_div a:hover{
            color: #333;
        }

        span.ut{
            padding-left: 2px;
        }
    </style>
</head>
<body>
    <h1>Thanks for signing up!</h1>

    <p>
        We just need to <a href='{{ url("auth/register/confirm/{$token}") }}'>confrim your email address</a> real quick! Keep in mind that this link will be expired within 24 hours.
    </p>

    <p>
        If you believe you received this email by mistake and you did not sign up for a ConnectedUT account, please <a href='{{ url("auth/register/disconfirm/{$token}") }}'>click here</a>.
    </p>

    <br>

    <p>
        Happy connecting!
    </p>

    <p>
        Team ConnectedUT
    </p>

    <div class="logo_div col-md-2 col-sm-3 col-xs-4">
        <a href="//connectedut.com">Connected<span class="ut">UT</span></a>
    </div>
</body>
</html>