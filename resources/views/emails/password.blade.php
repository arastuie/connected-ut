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
    <h4>
        Did you forget your password?
    </h4>

    <p>
        No problem. <a href="{{ url('password/reset/'.$token) }}">Click here</a> to reset your password. Keep in mind that password rest links expire within 1 hour.
    </p>

    <p>
        If you believe you have received this email by mistake please <a href="{{ url('password/reset/cancel/'.$token) }}">click here</a>.
    </p>

    <br>

    <div class="logo_div col-md-2 col-sm-3 col-xs-4">
        <a href="//connectedut.com">Connected<span class="ut">UT</span></a>
    </div>
</body>
</html>
