@extends('master')

@section('content')
    <div id="bgd"></div>

    <div class="row attention-grabber">
        <div class="ut-only-message col-sm-offset-1 col-sm-10 col-xs-offset-1 col-xs-10" style="text-align: center">
            <h1>A service only for <br>
                <span class="ut-blue">University</span> of <span class="ut-yellow black-shadow">Toledo</span> <br>
                students
            </h1>
        </div>

        <div class="brif-desc col-sm-offset-1 col-sm-10 col-xs-offset-1 col-xs-10" style="text-align: center">
            <h3>
                Buy your friends' textbook directy or singup and start selling one for free
            </h3>
        </div>
    </div>
    
    <div class="row secondRow">
        <div class="col-sm-12">
            <h1>Here is a new part</h1>
        </div>
    </div>


    {{--<fieldset class="developer_quote">--}}
        {{--<legend>--}}
            {{--<i class="fa fa-quote-left"></i>--}}
        {{--</legend>--}}

        {{--<P>--}}
            {{--Our primary goal is to provide an <em>easier</em> and more <em>affordable</em> experience--}}
            {{--for all <span class="ut_yellow">University</span> of <span class="ut_blue">Toledo</span>--}}
            {{--students. This website is for <span class="ut_yellow">U</span><span class="ut_blue">T</span>--}}
            {{--students only and it comes at no cost at all. Why sell your books for--}}
            {{--a low price to book stores and let them sell your books back to your friends--}}
            {{--for a lot more?!--}}
        {{--</P>--}}

        {{--<span>-- Developer team</span>--}}
    {{--</fieldset>--}}
@endsection

@section('style')
    <style>
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

        #bgd{
            position:absolute;
            top:0;
            left:0;
            bottom:0;
            right:0;
            background: url('/images/general/unioftoledo1.jpg') no-repeat center center fixed;
            filter: alpha(opacity=70);
            opacity:.7;
            -webkit-background-size: cover;
            -moz-background-size: cover;
            -o-background-size: cover;
            background-size: cover;
            z-index: -100;
            -webkit-filter: blur(5px);
            -moz-filter: blur(5px);
            -o-filter: blur(5px);
            -ms-filter: blur(5px);
            filter: blur(5px);
        }
        
        div.attention-grabber{
            height: 100vh;
            margin-top: -6rem;
            padding-top: 6rem;
            -webkit-box-shadow: 1px 2px 3px #888;
            -moz-box-shadow: 1px 2px 3px #888;
            box-shadow: 1px 2px 3px #888;
        }

        div.ut-only-message{
            font-family: Bitter,sans-serif;
            font-size: 20px;
            font-size: 1.5vw;
            text-shadow: 0px 0px 3px #EEE, -1px -1px #EEE, 1px 1px #EEE;
        }

        div.brif-desc{
            font-family:'Montserrat', sans-serif;
            font-size: 2vw;
            text-shadow: 0px 0px 3px #EEE, -1px -1px #EEE, 1px 1px #EEE;
        }

        .black-shadow{
            text-shadow: 0px 0px 3px #333, -1px -1px #333, 1px 1px #333;
        }

        div.secondRow{
            height: 500px;
            background-color: #ECECEC;
        }
    </style>
@endsection

@section('head')
    <link href='https://fonts.googleapis.com/css?family=Bitter:700' rel='stylesheet' type='text/css'>
@endsection