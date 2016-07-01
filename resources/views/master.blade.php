<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0, shrink-to-fit=no">
        <meta http-equiv="x-ua-compatible" content="ie=edge">
        <title>Connected UT</title>

        <link href="/css/libs/normalize.css" rel="stylesheet" type="text/css">
        <link href="//maxcdn.bootstrapcdn.com/font-awesome/4.3.0/css/font-awesome.min.css" rel="stylesheet" type="text/css">
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.4/css/bootstrap.min.css">
        <link href='http://fonts.googleapis.com/css?family=Roboto:700italic,300,700,400' rel='stylesheet' type='text/css'>
        <link rel="stylesheet" type="text/css" href="/css/libs/sweetalert.css">

        <link href="/css/main-style.css" rel="stylesheet" type="text/css">

        <script src="/js/libs/jquery.min.js" type="text/javascript"></script>
        <script src="/js/libs/bootstrap.min.js" type="text/javascript"></script>
        <script src="/js/libs/modernizr.custom.13737.js" type="text/javascript"></script>
        <script src="/js/libs/sweetalert.min.js"></script>
        @yield('head')

        @yield('style')
    </head>

    <body>

        <div class="container-fluid wrapper">
            <header>
                <div id="top-portion" class="row">
                    {{-------------------------- LOGO ----------------------------}}
                    <div class="logo_div col-md-2 col-sm-3 col-xs-4">
                        <a href="/">Connected<span class="ut">UT</span></a>
                    </div>

                    {{--------------------- Primary search box --------------------}}

                    <div class="header-search-box col-md-7 col-md-offset-0 col-sm-5 col-xs-12">
                        <div class="row">
                            <i class="fa fa-search search-box-icon col-sm-1 col-xs-1"></i>

                            {!! Form::model($master_search_query, ['method' => 'GET', 'action' => ['SearchController@books'], 'class' => 'main-search-form col-sm-11 col-xs-11', 'autocomplete' => 'off']) !!}
                                <div class="row">
                                    {!! Form::text('keywords', null, ['class' => 'search-input col-md-7 col-sm-6 col-xs-6', 'placeholder' => 'Search...']) !!}
                                    {!! Form::button('Go', ['type' => 'submit', 'class' => 'go-search search-btn col-sm-2 col-xs-2']) !!}
                                    {!! Form::button('Go Detailed', ['type' => 'submit', 'class' => 'adv-search search-btn col-sm-4 col-md-3 col-xs-4', 'formaction' => '/search/books/detailed']) !!}
                                </div>
                            {!! Form::close() !!}
                        </div>
                    </div>

                    {{------------------- LOGIN & SIGN UP --------------------}}
                    @if(!$user)
                        <div class="login_box col-md-3 col-md-offset-0 col-sm-4 col-sm-offset-0 col-xs-7 col-xs-offset-1">

                            <div class="row">
                                <a href="/auth/login">
                                    <div class="btn btn-default col-md-5 col-sm-5 col-xs-5 col-md-offset-1 col-sm-offset-1 col-xs-offset-1">
                                        <span>Login</span>
                                    </div>
                                </a>
                                <a href="/auth/register">
                                    <div class="btn btn-primary col-md-5 col-sm-5 col-xs-5 col-md-offset-1 col-sm-offset-1 col-xs-offset-1">
                                        <span>Sign up</span>
                                    </div>
                                </a>
                            </div>

                        </div>
                    @else

                    {{--------------------- Account & Logout -----------------------}}

                        <div class="loggedin-box col-md-3 col-md-offset-0 col-sm-4 col-sm-offset-0 col-xs-7 col-xs-offset-1">
                            <div class="row">
                                <div class="account-ctr-wrap col-md-8 col-md-offset-1 col-sm-8 col-sm-offset-1 col-xs-9 col-xs-offset-0">
                                    <div class="btn-group account-ctr">
                                        <a class="btn btn-primary your-account-btn" href="/account"><i class="fa fa-user fa-fw"></i> Your Account</a>
                                        <a class="btn btn-primary dropdown-toggle your-account-btn" data-toggle="dropdown" href="#">
                                            <span class="fa fa-caret-down"></span></a>
                                        <ul class="dropdown-menu">
                                            <li><a href="/books/create"><i class="fa fa-plus-circle fa-fw"></i> Sell a book</a></li>
                                            <li class="divider"></li>
                                            <li><a href="/account/mybooks"><i class="fa fa-book fa-fw"></i> Your listings</a></li>
                                        </ul>
                                    </div>
                                </div>

                                <div class="logout-btn col-md-2 col-md-offset-1 col-sm-3 col-sm-offset-0 col-xs-3 col-xs-offset-0">
                                    <a href="/auth/logout" class=""><i class="loggedin-btn fa fa-sign-out fa-2x"></i></a>
                                </div>
                            </div>
                        </div>

                    @endif
                </div>
            </header>

            @yield('index-top')

            <main class="container-fluid">
                {{------------------All the content goes here-----------------}}
                @yield('content')
            </main>

            <footer>

                <div class="copyright">
                    <span>Copyright &copy; <?= date("Y"); ?> Connected UT <br>All rights reserved</span>
                </div>

            </footer>

            @if(session('flash_type'))
                @include('partials._flash')
            @endif
        </div>

        @yield('script')
    </body>
</html>