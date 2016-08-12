<?php $respond =  json_decode($respond->getContent(), true); ?>

@extends('master')

@section('content')
<div class="item clearfix container-fliud">

    <?php
//    dd($respond);
        $noPhoto = $respond['data']['photos'] == null;

        // Check if item has any of the more info
        $moreDetails = ($respond['data']['publisher'] != "" ||
                        $respond['data']['ISBN_10'] != "" ||
                        $respond['data']['ISBN_13'] != "" ||
                        $respond['data']['authors'] != null ||
                        $respond['data']['edition'] != "");
    ?>


    <div class="item-info row">
        <div class="must-know-info {{ (! $noPhoto)? "must-know-info-xs" : "must-know-info-no-photo" }}">
            <div class="title-container">

                <div class="title">
                    {{ $respond['data']['title'] }}
                    @if($respond['data']['edition'] != "")
                        <span class="title-edition"> - {{$respond['data']['edition']}} edition</span>
                    @endif
                </div>

                @unless($respond['data']['authors'] == null)
                    <div class="title-sub-info">
                        by
                        @for($i = 0; $i < count($respond['data']['authors']); $i++)
                            <a href="{{ action("SearchController@booksDetailed", ['author_list[]' => $respond['data']['authors'][$i]['id']]) }}">{{ $respond['data']['authors'][$i]['name'] }}</a>

                            @if(count($respond['data']['authors']) - $i > 2)
                                {{ ", " }}
                            @elseif(count($respond['data']['authors']) - $i == 2 && $i != 1)
                                {{ " and " }}
                            @endif

                            @if($i == 1 && count($respond['data']['authors']) > 2)
                                {{ " and ..." }}
                                {{--*/ $i = count($respond['data']['authors']) /*--}}
                            @endif
                        @endfor
                    </div>
                @endunless

                @unless($respond['data']['ISBN_13'] == null)
                    <div class="title-sub-info">
                        ISBN 13: <a href="{{ action("SearchController@booksDetailed", ['ISBN_13' => $respond['data']['ISBN_13']]) }}">{{ $respond['data']['ISBN_13'] }}</a>
                    </div>
                @endunless
            </div>

            <div class="price">
                @if($respond['data']['price'] != 0)
                    <i class="fa fa-usd" aria-hidden="true"></i>{{ $respond['data']['price'] }}
                    @if($respond['data']['obo'])
                        <span>/ or best offer</span>
                    @endif
                @else
                    Grab it for free!
                @endif
            </div>

            <div class="more-info">
                Condition: {{ $respond['data']['condition'] }}
            </div>

            <div class="more-info">
                Available
                @if($respond['data']['available_by'] == "now")
                    {{ $respond['data']['available_by'] }}
                @else
                    by {{ $respond['data']['available_by'] }}
                @endif
            </div>

            <div class="more-info">
                Posted {{ $respond['data']['created_at'] }}
            </div>

            <hr class="style-two">
        </div>

        {{--    Photos    --}}
        @if(! $noPhoto)
            <div class="photos">
                <div class="main-photo">
                    @if($respond['data']['main_photo'] != null)
                        <img class="show-photo" src="{{ $respond['data']['main_photo']['path'] }}"/>
                    @else
                        <img class="show-photo" src="{{ $respond['data']['photos'][0]['path'] }}"/>
                    @endif
                </div>

                <div class="sub-photos">
                    @foreach($respond['data']['photos'] as $photo)
                        <div class="sub-photo-div">
                            <img class="sub-photo {{ ($photo['is_main'])? "main-pic" : ""}}" data-path="{{ $photo['path'] }}" src="{{ $photo['thumbnail_path'] }}">
                        </div>
                    @endforeach
                </div>
            </div>


        <div class="must-know-info must-know-info-sm">
            <div class="title-container">

                <div class="title">
                    {{ $respond['data']['title'] }}
                    @if($respond['data']['edition'] != "")
                        <span class="title-edition"> - {{$respond['data']['edition']}} edition</span>
                    @endif
                </div>

                @unless($respond['data']['authors'] == null)
                    <div class="title-sub-info">
                        by
                        @for($i = 0; $i < count($respond['data']['authors']); $i++)
                            <a href="{{ action("SearchController@booksDetailed", ['author_list[]' => $respond['data']['authors'][$i]['id']]) }}">{{ $respond['data']['authors'][$i]['name'] }}</a>

                            @if(count($respond['data']['authors']) - $i > 2)
                                {{ ", " }}
                            @elseif(count($respond['data']['authors']) - $i == 2 && $i != 1)
                                {{ " and " }}
                            @endif

                            @if($i == 1 && count($respond['data']['authors']) > 2)
                                {{ " and ..." }}
                                {{--*/ $i = count($respond['data']['authors']) /*--}}
                            @endif
                        @endfor
                    </div>
                @endunless

                @unless($respond['data']['ISBN_13'] == null)
                    <div class="title-sub-info">
                        ISBN 13: <a href="{{ action("SearchController@booksDetailed", ['ISBN_13' => $respond['data']['ISBN_13']]) }}">{{ $respond['data']['ISBN_13'] }}</a>
                    </div>
                @endunless
            </div>

            <div class="price">
                @if($respond['data']['price'] != 0)
                <i class="fa fa-usd" aria-hidden="true"></i>{{ $respond['data']['price'] }}
                    @if($respond['data']['obo'])
                        <span>/ or best offer</span>
                    @endif
                @else
                    Grab it for free!
                @endif
            </div>

            <div class="more-info">
                Condition: {{ $respond['data']['condition'] }}
            </div>

            <div class="more-info">
                Available
                @if($respond['data']['available_by'] == "now")
                    {{ $respond['data']['available_by'] }}
                @else
                    by {{ $respond['data']['available_by'] }}
                @endif
            </div>

            <div class="more-info">
                Posted {{ $respond['data']['created_at'] }}
            </div>
        </div>
        @endif

        {{--    Seller Info    --}}
        <div class="info-box item-contact col-sm-6 col-xs-12">
            <div class="panel panel-success">
                <div class="panel-heading">
                    <h3 class="panel-title">Seller Contact Info</h3>
                </div>

                <ul class="list-group">
                    @if($respond['seller-info']['email'] != "")
                        <li class="item-emailaddress item-detail list-group-item">
                            Email: <span>{!!  Html::email($respond['seller-info']['email']) !!}</span>
                        </li>
                    @endif

                    @if($respond['seller-info']['phone'] != "")
                        <li class="item-emailaddress item-detail list-group-item">
                            Phone number: <span>{{ $respond['seller-info']['phone'] }}</span>
                        </li>
                    @endif
                </ul>
            </div>
        </div>

        {{--UT Related Detail--}}
        @if(count($respond['data']['instructors']) > 0 || count($respond['data']['courses']) > 0)
            <div class="info-box col-sm-6 col-xs-12">
                <div class="panel panel-warning">
                    <div class="panel-heading">
                        <h3 class="panel-title">UT Related Details</h3>
                    </div>

                    <ul class="list-group">
                        @unless(count($respond['data']['instructors']) == 0)
                            <li class="item-detail list-group-item">Instructors:
                                <ul>
                                    @foreach($respond['data']['instructors'] as $instructor)
                                        <a href="{{ action("SearchController@booksDetailed", ['instructor_list[]' => $instructor['id']]) }}">
                                            <li>{{ $instructor['name'] }}</li>
                                        </a>
                                    @endforeach
                                </ul>
                            </li>
                        @endunless

                        @unless(count($respond['data']['courses']) == 0)
                            <li class="item-detail list-group-item">Courses:
                                <ul>
                                    @foreach($respond['data']['courses'] as $course)
                                        <a href="{{ action("SearchController@booksDetailed", ['course_list[]' => $course['id']]) }}">
                                            <li>{{ $course['name'] }}</li>
                                        </a>
                                    @endforeach
                                </ul>
                            </li>
                        @endunless
                    </ul>
                </div>
            </div>
        @endif

        {{--   More details   --}}
        @if($moreDetails)
            <div class="info-box col-sm-6 col-xs-12">
                <div class="panel panel-info">
                    <div class="panel-heading">
                        <h3 class="panel-title">Item Details</h3>
                    </div>

                    <ul class="list-group">
                        <li class="item-detail list-group-item">
                            Title: <span>{{ $respond['data']['title'] }}</span>
                        </li>
                        @unless(count($respond['data']['authors']) == 0)
                            <li class="item-detail list-group-item">Authors:
                                <ul>
                                    @foreach($respond['data']['authors'] as $author)
                                        <a href="{{ action("SearchController@booksDetailed", ['author_list[]' => $author['id']]) }}">
                                            <li>{{ $author['name'] }}</li>
                                        </a>
                                    @endforeach
                                </ul>
                            </li>
                        @endunless

                        @if($respond['data']['publisher'] != "")
                            <li class="item-detail list-group-item">Publisher:
                                <span>
                                    {{ $respond['data']['publisher'] }},
                                    @if($respond['data']['published_year'] != "")
                                        ({{ $respond['data']['published_year'] }})
                                    @endif
                                </span>
                            </li>
                        @endif

                        @if($respond['data']['edition'] != "")
                            <li class="item-detail list-group-item">
                                Edition: <span>{{ $respond['data']['edition'] }}</span>
                            </li>
                        @endif

                        @if($respond['data']['ISBN_10'] != "")
                            <li class="item-detail list-group-item">
                                ISBN-10: <span><a href="{{ action("SearchController@booksDetailed", ['ISBN_10' => $respond['data']['ISBN_10']]) }}">{{ $respond['data']['ISBN_10'] }}</a></span>
                            </li>
                        @endif

                        @if($respond['data']['ISBN_13'] != "")
                            <li class="item-detail list-group-item">
                                ISBN-13: <span><a href="{{ action("SearchController@booksDetailed", ['ISBN_13' => $respond['data']['ISBN_13']]) }}">{{ $respond['data']['ISBN_13'] }}</a></span>
                            </li>
                        @endif
                    </ul>
                </div>

            </div>
        @endif

        @if($respond['data']['description'] != "")
            <div class="info-box col-sm-6 col-xs-12">
                <div class="panel panel-info">
                    <div class="panel-heading">
                        <h3 class="panel-title">Item Description</h3>
                    </div>
                    <div class="panel-body item-description">
                        <p>{{ $respond['data']['description'] }}</p>
                    </div>
                </div>
            </div>
        @endif

    </div>
</div>
@endsection


@section('style')
<style>
    div.must-know-info-xs{
        display: none;
    }

    div.must-know-info-sm{
        display: block;
    }

    h2.title{
        margin: 20px 0;
        font-family: 'Roboto', sans-serif;
        font-weight: lighter;
    }

    h2.title span{
        font-weight: lighter;
    }

    li.item-detail{
        font-family: "Helvetica Neue", Helvetica, Arial, sans-serif;
        font-size: 15px;
        color: #000;
        line-height: 30px;
        font-weight: bold;
    }

    li.item-detail span, li.item-detail ul {
        color: #333;
        font-weight: lighter;
    }

    div.item-description p{
        color: #333;
        font-weight: normal;
        font-family: "Roboto", Helvetica, Arial, sans-serif;
        line-height: 27px;
        font-size: 18px;
    }

    /* Photos' Style */

    div.photos{
        width: 35%;
        max-width: 450px;
        height: 70vh;
        max-height: 350px;
        min-height: 350px;
        border-right: 1px dashed #666;
        padding-right: 20px;
        padding-left: 40px;
        float: left;
    }

    div.main-photo{
        max-width: 90%;
        height: 75%;
        margin: 0 auto;
        text-align: center;
    }

    img.show-photo{
        width: auto;
        min-width: 45%;
        max-width: 95%;
        height: auto;
        min-height: 45%;
        max-height: 95%;
        padding: 2px;
        border: 1px solid #888;
        border-radius: 5px;
        position: relative;
        top: 50%;
        transform: translateY(-50%);
    }

    div.sub-photos{
        width: 100%;
        height: 25%;
        display: flex;
        flex-flow: row;
        justify-content: center;
        align-items: center;
    }

    div.sub-photo-div{
        margin: 2px 10px;
        align-self: center;
        height: 90%;
    }

    img.sub-photo{
        max-width: 100%;
        max-height: 100%;
        padding: 1px;
        border: 1px solid #888;
        border-radius: 5px;
        cursor: pointer;
    }

    img.main-pic{
        border-color: blue;
    }

    /*Must know info*/

    div.must-know-info{
        width: 65%;
        padding-left: 20px;
        padding-right: 20px;
        height: 350px;
        float: left;
        margin-bottom: 30px;
    }

    div.must-know-info > div{
        margin-top: 20px;
    }

    div.title{
        font-family: "Roboto", Helvetica, Arial, sans-serif;
        font-size: 25px;
        margin-top: 5px;
        padding: 0;
        height: auto;
    }

    div.title span{
        font-weight: lighter;
        font-size: 20px;
    }

    div.title-sub-info{
        padding-left: 10px;
        font-weight: lighter;
    }

    div.must-know-info div.price{
        font-size: 40px;
        font-family: 'Lato', sans-serif;
        font-weight: lighter;
        margin-bottom: 20px;
    }

    div.must-know-info div.price i{
        font-size: 30px;
    }

    div.must-know-info div.price span{
        font-size: 25px;
    }

    div.must-know-info div.more-info{
        font-size: 18px;
        font-family: 'Trebuchet', 'Trebuchet', 'Trebuchet', sans-serif;
        color: #333;
        font-weight: lighter;
        margin-top: 10px;
    }

    div.must-know-info-no-photo{
        width: 100%;
        margin-bottom: 0;
        height: auto;
    }

    @media only screen and (max-width: 767px) {
        div.photos{
            width: 100%;
            max-width: 400px;
            min-width: 50%;
            max-height: 90vh;
            min-height: 350px;
            padding-right: 20px;
            padding-left: 20px;
            display: inline-block;
            float: none;
            margin-bottom: 20px;
            border: none;
        }

        div.item-info{
            text-align: center;
        }

        div.must-know-info-xs{
            display: inline-block;
            width: 100%;
            text-align: left;
            margin-bottom: 0;
            height: auto;
        }

        div.must-know-info-no-photo{
            display: inline-block;
            text-align: left;
            margin-bottom: 0;
            height: auto;
        }

        div.must-know-info-sm{
            display: none;
        }

        div.must-know-info div.price{
            font-size: 20px;
        }

        div.must-know-info div.price i{
            font-size: 15px;
        }

        div.must-know-info div.price span{
            font-size: 15px;
        }

        div.title{
            font-size: 18px;
        }

        div.title span{
            font-weight: lighter;
            font-size: 15px;
        }

        div.title-sub-info{
            padding-left: 5px;
            font-size: 12px;
        }

        div.must-know-info div.more-info{
            font-size: 15px;
            font-family: 'Trebuchet', 'Trebuchet', 'Trebuchet', sans-serif;
            color: #333;
            font-weight: lighter;
            margin-top: 10px;
        }

        div.info-box{
            text-align: left;
        }

        div.item-description p{
            font-size: 15px;
        }
    }
</style>
@endsection

@section('script')
<script>
    $(function(){
        var mainPhoto = $('img.show-photo');
        var subPhoto = $('img.sub-photo');
        var $this = null;

        subPhoto.on('click', function(){
            $this = $(this);
            if(mainPhoto.attr('src') != $this.attr('data-path')){
                subPhoto.css('border-color', '#888');
                $this.css('border-color', 'blue');
                $this.css('border-width', '2px');

                mainPhoto.finish().slideUp(150);
                mainPhoto.attr('src', $this.attr('data-path'));
                mainPhoto.slideDown(150);
            }
        });
    })
</script>
@endsection