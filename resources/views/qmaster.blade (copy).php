<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset=utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">


    <script src="/js/libs/jquery.min.js" type="text/javascript"></script>

    <link href="/css/main-style.css" rel="stylesheet" type="text/css">
    <link href="/css/libs/normalize.css" rel="stylesheet" type="text/css">
    <link href="//maxcdn.bootstrapcdn.com/font-awesome/4.3.0/css/font-awesome.min.css" rel="stylesheet" type="text/css">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.4/css/bootstrap.min.css">

    <link href='http://fonts.googleapis.com/css?family=Roboto:700italic,300,700,400' rel='stylesheet' type='text/css'>

    <script src="/js/libs/modernizr.custom.13737.js" type="text/javascript"></script>

    @yield('head')

    <title>Connected UT</title>

    @yield('style')
</head>

<body>
<div id="wrapper">
    <header>
        <div id="top-portion"> <!-- if screen width goes under 46.9rem(~750px), it keeps background separate than search box -->
            <!-------------------------- LOGO --------------------------!-->
            <div class="logo_div">
                <div>Connected</div>
                <div><span class="ut_yellow">U</span><span class="ut_blue">T</span></div>
            </div>

            <!-------------------- Primary search box -------------------!-->

            <div class="header-search_box">

                <i class="fa fa-search"></i>

                <form class="main_search_form">
                    <button class="search_btn">Go</button>
                    <input class="search_input" type="text" placeholder="Search for the book ">
                </form>

            </div>

            <!-------------------- LOGIN & SIGN UP -------------------!-->
            <div class="login_box">

                <div class="log_in">
                    <a href="/auth/login">Log In</a>
                </div>

                <div id="divider"></div>

                <div class="sign_up">
                    <a href="/auth/register">Sign Up</a>
                </div>

            </div>
        </div>
    </header>
    <main>
        <!-----------------All the content goes here!------------------>
        @yield('content')
    </main>
    <footer>

        <div class="copyright">
            <span>Copyright &copy; <?= date("Y"); ?> Connected UT <br> All rights reserved. </span>
        </div>

    </footer>

    @yield('script')
</div>
</body>
</html>