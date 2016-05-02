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
        @if(! $noPhoto)
            <div class="col-sm-5 col-xs-12">
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

        <div class="item-details clearfix col-sm-{{($noPhoto)? "10 col-sm-offset-1" : "7"}} col-xs-12">
            <div class="row">
                <div class="col-sm-12 col-xs-12">
                    <h3 class="title">{{ $respond['data']['title'] }}, <span>{{$respond['data']['edition']}} edition</span></h3>
                </div>

                <div class="col-sm-{{($moreDetails)? "7" : "12"}} col-xs-12">
                    <span class="item-detail">
                        Price: <span>&#36;{{ $respond['data']['price'] }}</span>
                        @if($respond['data']['obo'])
                            <span>/ or better offer</span>
                        @endif
                    </span> <br/>
                    <span class="item-detail">Condition: <span>{{ $respond['data']['condition'] }}</span></span> <br/>
                    <span class="item-detail">Available by <span>{{ $respond['data']['available_by'] }}</span></span> <br/>
                    <span class="item-detail">Posted <span>{{ $respond['data']['created_at'] }}</span></span> <br/>

                    @unless(count($respond['data']['instructors']) == 0)
                        <span class="item-detail">Instructors:</span>
                        <ul>
                            @foreach($respond['data']['instructors'] as $instructor)
                                <li>{{ $instructor['name'] }}</li>
                            @endforeach
                        </ul>
                    @endunless

                    @unless(count($respond['data']['authors']) == 0)
                        <span class="item-detail">Authors:</span>
                        <ul>
                            @foreach($respond['data']['authors'] as $author)
                                <li>{{ $author['name'] }}</li>
                            @endforeach
                        </ul>
                    @endunless

                    @unless(count($respond['data']['courses']) == 0)
                        <span class="item-detail">Courses:</span>
                        <ul>
                            @foreach($respond['data']['courses'] as $course)
                                <li>{{ $course['name'] }}</li>
                            @endforeach
                        </ul>
                    @endunless

                    @if($respond['data']['description'] != "")
                        <span class="item-detail item-description"> Description: <br/>
                            <p>{{ $respond['data']['description'] }}</p>
                         </span>
                    @endif
                </div>

                {{--   More details   --}}
                @if($moreDetails)
                    <div class="col-sm-5 col-xs-12">
                        <div class="info-header">More Details:</div>

                        <div class="more-detail">
                            @if($respond['data']['publisher'] != "")
                                <span class="item-detail">Publisher:
                        <span>
                            {{ $respond['data']['publisher'] }},
                            @if($respond['data']['published_year'] != "")
                                ({{ $respond['data']['published_year'] }})
                            @endif
                        </span>
                    </span> <br>
                            @endif

                            @if($respond['data']['edition'] != "")
                                <span class="item-detail">Edition: <span>{{ $respond['data']['edition'] }}</span></span><br>
                            @endif

                            @if($respond['data']['ISBN_10'] != "")
                                <span class="item-detail">ISBN-10: <span>{{ $respond['data']['ISBN_10'] }}</span></span><br>
                            @endif

                            @if($respond['data']['ISBN_13'] != "")
                                <span class="item-detail">ISBN-13: <span>{{ $respond['data']['ISBN_13'] }}</span></span><br>
                            @endif
                        </div>
                    </div>
                @endif

            </div>
        </div>

        {{--    Seller Info    --}}
        <div class="item-contact col-sm-12 col-xs-12">
            <hr class="style-one"/>
            <div class="info-header"> Seller Contact Info: </div>
            <div class="contact-info">
                @if($respond['seller-info']['email'] != "")
                    <span class="item-emailaddress item-detail"> Email: <span>{!!  Html::email($respond['seller-info']['email']) !!} </span></span> <br />
                @endif

                @if($respond['seller-info']['phone'] != "")
                        <span class="item-emailaddress item-detail"> Phone number: <span>{{ $respond['seller-info']['phone'] }}</span></span>
                @endif
            </div>

        </div>
    </div>
</div>
@endsection


@section('style')
<style>
    h3.title{
        margin: 20px 0;
        font-family: 'Roboto', sans-serif;
    }

    h3.title span{
        font-weight: lighter;
    }

    span.item-detail{
        font-family: "Helvetica Neue", Helvetica, Arial, sans-serif;
        font-size: 15px;
        color: #000;
        line-height: 30px;
        font-weight: bold;
    }

    span.item-detail span {
        /*font-style: italic;*/
        color: #333;
        font-weight: lighter;
    }

    span.item-description p{
        margin: 5px 0 0 15px;
        color: #000000;
        font-weight: normal;
    }

    div.more-detail{
        margin-left: 25px;
    }

    div.info-header{
        font-size: 20px;
        margin: 10px 0;
    }

    div.item-contact{
        padding-top: 20px;
        padding-bottom: 20px;
    }

    div.contact-info{
        margin-left: 25px;
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