<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset=utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">


    <script src="/js/libs/jquery.min.js" type="text/javascript"></script>

    <link href="/css/main-style.css" rel="stylesheet" type="text/css">

    <link href="//maxcdn.bootstrapcdn.com/font-awesome/4.3.0/css/font-awesome.min.css" rel="stylesheet" type="text/css">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.4/css/bootstrap.min.css">

    <link href='http://fonts.googleapis.com/css?family=Roboto:700italic,300,700,400' rel='stylesheet' type='text/css'>

    <script src="/js/libs/modernizr.custom.13737.js" type="text/javascript"></script>

    @yield('head')

    <title>Connected UT</title>

    @yield('style')
</head>

<body>

<div class="container-fluid wrapper">
    <header>
        <div id="top-portion" class="row"> <!-- if screen width goes under (768px), it keeps background separate than search box -->
            <!-------------------------- LOGO --------------------------!-->
            <div class="logo_div col-md-2 col-sm-2 col-xs-3">
                {{--<div>Connected</div>--}}
                {{--<br />--}}
                {{--<div><span class="ut_yellow">U</span><span class="ut_blue">T</span></div>--}}

                <img src="/images/general/connected-living-logo.png" alt=""/>
            </div>

            <!-------------------- Primary search box -------------------!-->

            <div class="header-search_box col-md-6 col-sm-6 col-xs-9 col-md-offset-1 col-sm-offset-1">
                <div class="row">
                        <i class="fa fa-search col-md-1 col-sm-1 col-xs-1"></i>

                        <form class="main_search_form col-md-11 col-sm-11 col-xs-11">

                            <div class="row">
                                <input class="search_input col-md-10 col-sm-10 col-xs-10" type="text" placeholder="Search for the book ">
                                <button class="search_btn col-md-2 col-sm-2 col-xs-2">Go</button>
                            </div>

                        </form>
                </div>

            </div>

            <!-------------------- LOGIN & SIGN UP -------------------!-->

            <div class="login_box col-md-2 col-sm-3 col-xs-6 col-md-offset-1 col-xs-offset-3 col-sm-offset-0">

                <div class="row">
                    <div class="log_in col-md-5 col-sm-5 col-xs-5 col-md-offset-1 col-sm-offset-1 col-xs-offset-1">
                        <a href="/auth/login">Log In</a>
                    </div>

                    <div class="sign_up col-md-5 col-sm-5 col-xs-5 col-md-offset-1 col-sm-offset-1 col-xs-offset-1">
                        <a href="/auth/register">Sign Up</a>
                    </div>
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
            <span>Copyright &copy; <?= date("Y"); ?> Connected UT <br>All rights reserved</span>
        </div>

    </footer>

    @yield('script')
</div>
</body>
</html>