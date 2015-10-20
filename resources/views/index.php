<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset=utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Connected UT</title>

    <script src="/js/libs/jquery.min.js" type="text/javascript"></script>
    <script src="/js/libs/modernizr.custom.13737.js" type="text/javascript"></script>

    <link href="/css/main-style.css" rel="stylesheet" type="text/css">

    <link href="/css/libs/normalize.css" rel="stylesheet" type="text/css">
    <link href="//maxcdn.bootstrapcdn.com/font-awesome/4.3.0/css/font-awesome.min.css" rel="stylesheet" type="text/css">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.4/css/bootstrap.min.css">
    <!--Keep welcome-style.css after main-style.css to overwrite on it for login from-->
<!--    <link href="/css/welcome-style.css" rel="stylesheet"  type="text/css">-->
    <link href='http://fonts.googleapis.com/css?family=Roboto:700italic,300,700,400' rel='stylesheet' type='text/css'>


</head>

<!--Search bar stylesheet-->
<style>
/*/!************** Primary Search Section ****************!/*/

    /*section.primary_search{*/
        /*width: 100%;*/
        /*height: 5rem;*/
        /*margin: 0.1875rem auto;*/
        /*position: relative;*/
    /*}*/

    /*div.search_box {*/
        /*width: 90%;*/
        /*min-width: 23rem;*/
        /*max-width: 56.25rem;*/
        /*height: 3.125rem;*/
        /*border: 0.0625rem solid #555;*/
        /*z-index: 2;*/
        /*background-color:#FFF;*/
        /*border-radius: 0.625rem;*/
        /*-moz-border-radius: 0.625rem;*/
        /*-ms-border-radius: 0.625rem;*/
        /*-webkit-border-radius: 0.625rem;*/
        /*overflow: hidden;*/
        /*margin: 2rem auto;*/
        /*box-shadow: 0 0 0.25rem 0.0625rem #777;*/
        /*-moz-box-shadow: 0 0 0.25rem 0.0625rem #777;*/
        /*-ms-box-shadow: 0 0 0.25rem 0.0625rem #777;*/
        /*-webkit-box-shadow: 0 0 0.25rem 0.0625rem #777;*/
    /*}*/

    /*div.header-search_box > img{*/
        /*width: 7%;*/
        /*max-width: 2.5rem;*/
        /*line-height: 3.125rem;*/
        /*margin: 0.3125rem 0.5% 0 1%;*/
        /*float: left;*/
        /*-webkit-user-select: none;*/
        /*-moz-user-select: none;*/
        /*-ms-user-select: none;*/
        /*user-select: none;*/
        /*-webkit-user-drag: none;*/
    /*}*/

    /*input.search_input{*/
        /*float: right;*/
        /*height: 3.125rem;*/
        /*width: 85%;*/
        /*max-width: 48.75rem;*/
        /*font-size: 1.125rem;*/
        /*padding: 0 0.9375rem 0 0.9375rem;*/
        /*border: none;*/
        /*outline: none;*/
    /*}*/

    /*input.search_input:focus{*/
        /*-webkit-appearance:none;*/
    /*}*/

    /*button.search_btn{*/
        /*width: 15%;*/
        /*max-width: 6.75rem;*/
        /*height: 3.125rem;*/
        /*float: right;*/
        /*font-size: 1.5625rem;*/
        /*background-color: #09F;*/
        /*border: none;*/
        /*cursor: pointer;*/
        /*color: #FFF;*/
    /*}*/


    /*button.search_btn:hover{*/
        /*background-color: #3366FF;*/
    /*}*/

    /*form.main_search_form{*/
        /*width: 91.5%;*/
        /*min-width: 19.7rem;*/
        /*height: 3.125rem;*/
        /*float: right;*/
    /*}*/
fieldset.developer_quote{
    margin: 1rem auto;
    width: 40%;
    max-width: 43.75rem;
    min-width: 23rem;
    padding: 0 0.9rem 0.9rem 0.9rem;
    border: 0.09rem dashed #666666;
    border-radius: 0.9rem;
}

fieldset.developer_quote p{
    margin: 0 1rem 0 1rem;
}

i.fa-quote-left{
    font-size: 2rem;
    color: #444444;
    margin: 0 0.3125rem 0 0.3125rem;
}

fieldset.developer_quote > span{
    float: right;
    font-weight: lighter;
    font-style: italic;
    font-size: 0.85rem;
}
</style>

<body>

<div class="container-fluid wrapper"><!--The only purpose of #wrapper is to keep the footer at the bottom.-->

    <header>
        <div id="top-portion" class="row">

            <!-------------------- LOGO -------------------!-->
            <div class="logo_div col-md-2 col-sm-2 col-xs-3">
    <!--            <div>Connected</div>-->
    <!--            <br />-->
    <!--            <div><span class="ut_yellow">U</span><span class="ut_blue">T</span></div>-->

                <img src="/images/general/connected-living-logo.png" alt=""/>
            </div>

            <!-------------------- Search bar -------------------!-->
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
                    <a href="/auth/login">
                        <div class="log_in col-md-5 col-sm-5 col-xs-5 col-md-offset-1 col-sm-offset-1 col-xs-offset-1">
                            <span>Log In</span>
                        </div>
                    </a>

                    <a href="/auth/register">
                        <div class="sign_up col-md-5 col-sm-5 col-xs-5 col-md-offset-1 col-sm-offset-1 col-xs-offset-1">
                            <span>Sign Up</span>
                        </div>
                    </a>
                </div>

            </div>


    <!--        <div class="login_box">-->
    <!---->
    <!--            <form class="login_form">-->
    <!---->
    <!--                <div class="login_input_div">-->
    <!--                    <input class="login_input" type="text" placeholder="Email address" />-->
    <!--                    <div>-->
    <!--                        <span>?</span>-->
    <!--                    </div>-->
    <!--                </div>-->
    <!---->
    <!--                <div class="login_input_div">-->
    <!--                    <input class="login_input" type="password" placeholder="Password" />-->
    <!--                    <div>-->
    <!--                        <span>?</span>-->
    <!--                    </div>-->
    <!--                </div>-->
    <!---->
    <!--                <label for="login"></label><button class="login_btn">Log In</button>-->
    <!---->
    <!--            </form>-->
    <!---->
    <!--            <div id="divider"></div>-->
    <!---->
    <!--            <div class="sign_up">-->
    <!--                <span>Sign Up</span>-->
    <!--            </div>-->
    <!---->
    <!--        </div>-->
            </div>
    </header>

    <main>

        <fieldset class="developer_quote">
            <legend>
                <i class="fa fa-quote-left"></i>
            </legend>

            <P>
                Our primary goal is to provide an <em>easier</em> and more <em>affordable</em> experience
                for all <span class="ut_yellow">University</span> of <span class="ut_blue">Toledo</span>
                students. This website is for <span class="ut_yellow">U</span><span class="ut_blue">T</span>
                students only and it comes at no cost at all. Why sell your books for
                a low price to book stores and let them sell your books back to your friends
                for a lot more?!
            </P>

            <span>-- Developer team</span>
        </fieldset>

    </main>

<!------------------- Footer -------------------------->
    <footer>

        <div class="copyright">
            <span>Copyright &copy; <?= date("Y"); ?> Connected UT <br> All rights reserved. </span>
        </div>

    </footer>

</div>



<script>

    (function(){
        $('input.login_input').on('focusin', function(){
            $(this).parent().css('border' , '1px ridge #03F');
        }).on('focusout', function(){
            $(this).parent().css('border' , '1px solid #09F');
        });
    })();

</script>
</body>
</html>

