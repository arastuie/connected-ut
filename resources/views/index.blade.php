@extends('master')

@section('content')
    <div id="bgd"></div>

    <div class="row attg">
        <div class="ut-only-message col-sm-offset-1 col-sm-10 col-xs-12 white-shadow ">
            <span>A service, only for the <br>
                <span class="message-uft"><span class="ut-yellow black-shadow">University</span> of <span class="ut-blue white-shadow">Toledo</span></span> <br>
                students
            </span>
        </div>

        <div class="brief-desc col-sm-offset-1 col-sm-10 col-xs-12 white-shadow">
            <span>
                Buy your friends' textbook directly, or <br>sing up and start selling one for free!
            </span>
        </div>
    </div>

    
    <div class="row cards-row">
        <div class="col-sm-12 col-xs-12 engaging-title">
            <span>let's get started</span>
        </div>

        <div class="col-sm-12 col-xs-12">
            <div class="row">
                <div class="col-md-4 col-sm-6 col-xs-12">
                    <div class="nav-card">
                        <a href="/books" class="card-link">
                            <div class="nav-card-icon view-card">
                                <i class="fa fa-eye" aria-hidden="true"></i>
                            </div>
                            <div class="nav-card-title">
                                See All the Books
                            </div>
                        </a>
                    </div>
                </div>

                <div class="col-md-4 col-sm-6 col-xs-12">
                    <div class="nav-card">
                        <a href="/books/create" class="card-link">
                            <div class="nav-card-icon list-book-card">
                                <i class="fa fa-list-alt" aria-hidden="true"></i>
                            </div>
                            <div class="nav-card-title">
                                List a Book For Sale
                            </div>
                        </a>
                    </div>
                </div>

                <div class="col-md-4 col-sm-12 col-xs-12">
                    <div class="nav-card">
                        <a href="/search/books/detailed?keywords" class="card-link">
                            <div class="nav-card-icon search-card">
                                <i class="fa fa-search" aria-hidden="true"></i>
                            </div>
                            <div class="nav-card-title">
                                Find the Book You Need
                            </div>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row mission-div">
        <div class="col-sm-12 col-xs-12">
            <div class="row mission-inner-row-div">
                <div class="col-sm-6 hidden-xs mission-img">
                    <img src="/images/general/work-env.png" alt="" class="student-design">
                </div>

                <div class="col-sm-6 col-xs-12 mission-quote">
                    This is a private platform made by, and exclusively for the University of Toledo students. Our mission is to help UT students connect easier and make college more affordable. Help us improve this platform by your suggestions and your feedback.
                    <br>
                    <a href="/" class="btn btn-info mission-contact">Contact us</a>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('style')
    <style>
        div#top-portion{
            background-color: transparent !important;
        }

        div.logo_div a{
            text-shadow: 0 0 1px #ccc, -1px -1px #ccc, 1px 1px #ccc !important;
        }

        /********** Cards ********/

        div.cards-row{
            background-color: #f5f5f1;
            padding: 40px 0;
            z-index: 1;
        }
        
        div.engaging-title{
            text-align: center;
            position: relative;
            padding-bottom: 20px;
        }

        div.engaging-title span{
            position: relative;
            text-transform: uppercase;
            letter-spacing: 3px;
            font-family: 'Lato', sans-serif;
            font-weight: 300;
            font-size: 2vw;
        }

        div.engaging-title span:after, div.engaging-title span:before{
            content: "";
            position: absolute;
            border-top: 3px solid #5e5e5e;
            width: 10vw;
            height: 1vw;
            top: 50%;
        }

        div.engaging-title span:before{
             right: 100%;
             margin-right: 30px;
         }

        div.engaging-title span:after{
             left: 100%;
             margin-left: 30px;
         }

        div.nav-card{
            width: 70%;
            height:300px;
            max-width: 300px;
            min-width: 200px;
            margin:30px auto;
            box-shadow: 1px 2px 3px #999;
            -webkit-border-radius: 4px;
            -moz-border-radius: 4px;
            border-radius: 4px;
            cursor: pointer;
            opacity: 0.9;
            background-color: #FFFFFF;
        }

        div.nav-card-icon{
            border:1px solid #000;
            width: 100%;
            height: 70%;
            text-align: center;
            font-size: 150px;
            -webkit-border-radius: 4px 4px 0 0;
            -moz-border-radius: 4px 4px 0 0;
            border-radius: 4px 4px 0 0;
        }

        div.nav-card-title{
            width: 100%;
            height:30%;
            border: 1px solid #000;
            display: flex;
            -webkit-box-align: center;
            align-items: center;
            justify-content: center;
            text-align: center;
            font-size: 20px;
            font-family: "Lucida Grande", "Lucida Sans Unicode", Verdana, Arial, Helvetica, sans-serif;
            font-weight: 300;
            padding: 8px 12px;
            -webkit-border-radius: 0 0 4px 4px;
            -moz-border-radius: 0 0 4px 4px;
            border-radius: 0 0 4px 4px;
            -webkit-box-shadow:  0 -3px 3px #666;
            -moz-box-shadow:  0 -3px 3px #666;
            box-shadow:  0 -3px 3px #666;
        }

        div.nav-card:hover{
            opacity: 1;
        }

        div.nav-card:hover div.nav-card-icon{
            -webkit-box-shadow:  0 3px 3px #666;
            -moz-box-shadow:  0 3px 3px #666;
            box-shadow: 0 3px 3px #666;
        }

        div.nav-card:hover div.nav-card-title{
            -webkit-box-shadow:  0 0 0 #666;
            -moz-box-shadow:  0 0 0 #666;
            box-shadow: 0 0 0 #666;
        }

        div.view-card{
            background-color: #98EFFC;
        }

        div.list-book-card{
            background-color: #ffd818;
        }

        div.search-card{
            background-color: #40E0D0;
        }

        a.card-link {
            text-decoration: none;
        }

        /********** UT header ********/

        #bgd{
            position:absolute;
            top:0;
            left:0;
            bottom:0;
            right:0;
            background: url('/images/general/unioftoledo1.jpg') no-repeat center center fixed;
            width: 100%;
            -webkit-background-size: cover;
            -moz-background-size: cover;
            -o-background-size: cover;
            background-size: cover;
            z-index: -100;
            -webkit-filter: blur(4px);
            -ms-filter: blur(4px);
            filter: blur(4px);
            filter: alpha(opacity=75);
            opacity:0.75;
        }

        div.attg{
            height: 35vw;
            -webkit-box-shadow: 10px 20px 3px #666;
            -moz-box-shadow: 10px 20px 3px #666;
            box-shadow: 10px 20px 3px #666;
            z-index: 200;
        }

        div.ut-only-message{
            font-family: 'Helvetica Neue', sans-serif;
            font-size: 5vw;
            letter-spacing: 2px;
            font-weight: bold;
            color: #111;
            line-height: 6vw;
        }

        span.message-uft{
            font-style: italic;
        }

        div.brief-desc {
            font-family: "Lucida Grande", "Lucida Sans Unicode", Verdana, Arial, Helvetica, sans-serif;
            font-size: 2.5vw;
            padding-top:7vw;
            color: #000;
            text-align: right;
        }

        .white-shadow{
            text-shadow: 0 0 1px #ccc, -1px -1px #ccc, 1px 1px #ccc;
        }

        .black-shadow{
            text-shadow: 0 0 3px #000, -1px -1px #000, 1px 1px #000;
        }

        /********** Mission Message ********/

        div.mission-div{
            background-color: #9ED5D6;
            padding: 20px 0;
        }

        div.mission-inner-row-div{
            display: flex;
            align-items: center;
        }

        div.mission-img{
            height: 100%;
        }

        img.student-design{
            width: 100%;
            max-width: 600px;
            min-width: 300px;
        }

        div.mission-quote{
            color: #FFF;
            line-height: 1.85em;
            letter-spacing: 1px;
            font-size: 20px;
            font-family: "Roboto", Helvetica, Arial, sans-serif;
            font-weight: lighter;
        }

        a.mission-contact{
            margin: 20px 50px;
            padding: 15px 30px;
        }

        @media screen and (max-width: 767px) {
            div.attg{
                height: 60vw;
            }

            div.ut-only-message{
                margin-top: 20px;
                font-size: 7vw;
                line-height: 10vw;
            }

            div.brief-desc {
                font-size: 4.5vw;
                padding-top: 6vw;
            }

            div.mission-quote{
                font-size: 17px;
            }

            div.mission-div{
                padding: 20px 80px;
            }

            div.engaging-title span{
                font-size: 4vw;
            }
        }

        @media screen and (max-width: 991px) {
            div.engaging-title span{
                font-size: 3vw;
            }
        }

    </style>
@endsection