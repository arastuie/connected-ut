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

    <!--Keep welcome-style.css after main-style.css to overwrite on it for login from-->
    <link href="/css/welcome-style.css" rel="stylesheet"  type="text/css">
    <link href='http://fonts.googleapis.com/css?family=Roboto:700italic,300,700,400' rel='stylesheet' type='text/css'>


</head>

<!--Search bar stylesheet-->
<style>
/************** Primary Search Section ****************/

    section.primary_search{
        width: 100%;
        height: 5rem;
        margin: 0.1875rem auto;
        position: relative;
    }

    div.search_box {
        width: 90%;
        min-width: 23rem;
        max-width: 56.25rem;
        height: 3.125rem;
        border: 0.0625rem solid #555;
        z-index: 2;
        background-color:#FFF;
        border-radius: 0.625rem;
        -moz-border-radius: 0.625rem;
        -ms-border-radius: 0.625rem;
        -webkit-border-radius: 0.625rem;
        overflow: hidden;
        margin: 2rem auto;
        box-shadow: 0 0 0.25rem 0.0625rem #777;
        -moz-box-shadow: 0 0 0.25rem 0.0625rem #777;
        -ms-box-shadow: 0 0 0.25rem 0.0625rem #777;
        -webkit-box-shadow: 0 0 0.25rem 0.0625rem #777;
    }

    div.header-search_box > img{
        width: 7%;
        max-width: 2.5rem;
        line-height: 3.125rem;
        margin: 0.3125rem 0.5% 0 1%;
        float: left;
        -webkit-user-select: none;
        -moz-user-select: none;
        -ms-user-select: none;
        user-select: none;
        -webkit-user-drag: none;
    }

    input.search_input{
        float: right;
        height: 3.125rem;
        width: 85%;
        max-width: 48.75rem;
        font-size: 1.125rem;
        padding: 0 0.9375rem 0 0.9375rem;
        border: none;
        outline: none;
    }

    input.search_input:focus{
        -webkit-appearance:none;
    }

    button.search_btn{
        width: 15%;
        max-width: 6.75rem;
        height: 3.125rem;
        float: right;
        font-size: 1.5625rem;
        background-color: #09F;
        border: none;
        cursor: pointer;
        color: #FFF;
    }


    button.search_btn:hover{
        background-color: #3366FF;
    }

    form.main_search_form{
        width: 91.5%;
        min-width: 19.7rem;
        height: 3.125rem;
        float: right;
    }
</style>

<body>

<div id="wrapper"> <!--The only purpose of #wrapper is to keep the footer at the bottom.-->

    <header>
    <!-------------------- LOGO -------------------!-->
        <div class="logo_div">
            <div>Connected</div>
            <div><span class="ut_yellow">U</span><span class="ut_blue">T</span></div>
        </div>

    <!-------------------- LOGIN & SIGN UP -------------------!-->
        <div class="login_box">

            <form class="login_form">

                <div class="login_input_div">
                    <input class="login_input" type="text" placeholder="Email address" />
                    <div>
                        <span>?</span>
                    </div>
                </div>

                <div class="login_input_div">
                    <input class="login_input" type="password" placeholder="Password" />
                    <div>
                        <span>?</span>
                    </div>
                </div>

                <label for="login"></label><button class="login_btn">Log In</button>

            </form>

            <div id="divider"></div>

            <div class="sign_up">
                <span>Sign Up</span>
            </div>

        </div>
    </header>

    <main>
    <!-------------------- Search bar -------------------!-->
        <section class="primary_search">
            <div class="search_box">

                <i class="fa fa-search"></i>

                <form class="main_search_form">
                    <button class="search_btn">Go</button>
                    <input class="search_input" type="text" placeholder="Search for the book ">
                </form>

            </div>
        </section>

        <fieldset class="developer_quote">
            <legend>
                <i class="fa fa-quote-left"></i>
            </legend>

            <P>
                Our primary goal is to provide an <em>easier</em> and more <em>affordable</em> experience
                for all <span class="ut_yellow">University</span> of <span class="ut_blue">Toledo</span>
                students. This website is for <span class="ut_yellow">U</span><span class="ut_blue">T</span>
                students only and it comes at no cost at all. Why selling your books for
                a low price to book stores and let them sell your books to your friends
                for a lot more. Let's help each other in both ways.
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

