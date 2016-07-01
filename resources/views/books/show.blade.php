<?php $respond =  json_decode($respond->getContent(), true) ?>

@extends('master')

@section('content')
<div class="item clearfix container-fliud">

    <?php
        $noPhoto = $respond['data']['photos'] == null;

        // Check if item has any of the more info
        $moreDetails = ($respond['data']['publisher'] != "" ||
                        $respond['data']['ISBN_10'] != "" ||
                        $respond['data']['ISBN_13'] != "");
    ?>

    {{--    Photos    --}}
    <div class="item-info clearfix row">
        <div class="col-sm-12 col-xs-12">
            <div class="panel panel-default">
                <div class="panel-body">
                    <h2 class="title">{{ $respond['data']['title'] }}
                        @if($respond['data']['edition'] != "")
                            <span>, {{$respond['data']['edition']}} edition</span>
                        @endif
                    </h2>
                </div>
            </div>
        </div>

        @if(! $noPhoto)
            <div class="col-sm-6 col-xs-12">
                <div class="photos">
                    <div class="main-photo row">
                        <div class="main-photo-box col-sm-12 col-xs-12">
                            <img class="show-photo" src="/images/books/{{ $respond['data']['photos'][0] }}"/>
                        </div>
                    </div>

                    <div class="sub-photos col-sm-12 col-xs-12">
                        <div class="row">
                            <?php $bootstrapSize = 12 / count($respond['data']['photos']) ?>
                            @foreach($respond['data']['photos'] as $photo)
                                <div class="col-sm-{{$bootstrapSize}} col-xs-{{$bootstrapSize}}">
                                    <img class="sub-photo" src="/images/books/{{ $photo }}">
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        @endif

        <div class="col-sm-6 col-xs-12">
            <div class="panel panel-primary">

                <div class="panel-heading">
                    <h3 class="panel-title">
                        Item Information
                    </h3>
                </div>
                <ul class="list-group">

                    <li class="item-detail list-group-item">
                        Price: <span>&#36;{{ $respond['data']['price'] }}</span>
                        @if($respond['data']['obo'])
                            <span>/ or better offer</span>
                        @endif
                    </li>

                    <li class="item-detail list-group-item">
                        Condition: <span>{{ $respond['data']['condition'] }}</span>
                    </li>

                    <li class="item-detail list-group-item">
                        Available by <span>{{ $respond['data']['available_by'] }}</span>
                    </li>

                    <li class="item-detail list-group-item">
                        Posted <span>{{ $respond['data']['created_at'] }}</span>
                    </li>



                </ul>

            </div>
        </div>

        @if(count($respond['data']['instructors']) > 0 || count($respond['data']['courses']) > 0)
            <div class="col-sm-6  col-xs-12">
                <div class="panel panel-warning">
                    <div class="panel-heading">
                        <h3 class="panel-title">UT Specific Details</h3>
                    </div>

                    <ul class="list-group">
                        @unless(count($respond['data']['instructors']) == 0)
                            <li class="item-detail list-group-item">Instructors:
                                <ul>
                                    @foreach($respond['data']['instructors'] as $instructor)
                                        <li>{{ $instructor['name'] }}</li>
                                    @endforeach
                                </ul>
                            </li>
                        @endunless

                        @unless(count($respond['data']['courses']) == 0)
                            <li class="item-detail list-group-item">Courses:
                                <ul>
                                    @foreach($respond['data']['courses'] as $course)
                                        <li>{{ $course['name'] }}</li>
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
            <div class="col-sm-6 col-xs-12">
                <div class="panel panel-info">
                    <div class="panel-heading">
                        <h3 class="panel-title">Item Details</h3>
                    </div>

                    <ul class="list-group">

                        @unless(count($respond['data']['authors']) == 0)
                            <li class="item-detail list-group-item">Authors:
                                <ul>
                                    @foreach($respond['data']['authors'] as $author)
                                        <li>{{ $author['name'] }}</li>
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
                                ISBN-10: <span>{{ $respond['data']['ISBN_10'] }}</span>
                            </li>
                        @endif

                        @if($respond['data']['ISBN_13'] != "")
                            <li class="item-detail list-group-item">
                                ISBN-13: <span>{{ $respond['data']['ISBN_13'] }}</span>
                            </li>
                        @endif
                    </ul>
                </div>

            </div>
        @endif

        @if($respond['data']['description'] != "")
            <div class="col-sm-6 col-xs-12">
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


        {{--    Seller Info    --}}
        <div class="item-contact col-sm-12 col-xs-12">
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
    </div>
</div>
@endsection


@section('style')
<style>
    h2.title{
        margin: 20px 0;
        font-family: 'Roboto', sans-serif;
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
        height: 70vh;
        border: 1px dashed #666;
        border-radius: 3% 1% 3% 1%;
        min-height: 200px;
        max-height: 600px;
    }

    div.main-photo{
        text-align: center;
        height: 56vh;
        min-height: 160px;
        max-height: 480px;
    }
    
    div.main-photo-box
    {
        height: 100%;
        -webkit-transform-style: preserve-3d;
        -moz-transform-style: preserve-3d;
        transform-style: preserve-3d;
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
        height: 14vh;
        padding-bottom: 5px;
        min-height: 40px;
        max-height: 120px;
    }

    div.sub-photos div{
        height: 100%;
        text-align: center;
    }

    img.sub-photo{
        padding: 1px;
        border: 1px solid #888;
        border-radius: 5px;
        cursor: pointer;
        max-height: 100%;
        max-width: 100%;
        position: relative;
        top: 50%;
        transform: translateY(-50%);
    }

    div.sub-photos div:first-child img{
        border-color: blue;
    }

    @media only screen and (max-width: 767px) {
        div.photos{
            height: 50vh;
            margin-bottom: 15px;
        }

        div.main-photo{
            height: 40vh;
        }

        div.sub-photos{
            height: 10vh;
        }
    }
</style>
@endsection

@section('script')
<script>
    $(function(){
        var mainPhoto = $('img.show-photo');
        var subPhoto = $('img.sub-photo');

        subPhoto.on('click', function(){
            if(mainPhoto.attr('src') != $(this).attr('src')){
                subPhoto.css('border-color', '#888');
                $(this).css('border-color', 'blue');
                $(this).css('border-width', '2px');

                mainPhoto.finish().slideUp(150);
                mainPhoto.attr('src', $(this).attr('src'));
                mainPhoto.slideDown(150);
            }
        });
    })
</script>
@endsection