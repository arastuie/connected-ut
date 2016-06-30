@extends('master')

@section('content')

    <?php $respond =  json_decode($respond->getContent(), true) ?>
    @include('books._detailedSearch', ['search' => $respond['search']])

    <div class="row search-status-box">
        <div class="search-info-box col-sm-9 col-xs-6">

            @if($respond['paginator']['total_pages'] == 1)
                @if($respond['paginator']['total_count'] > 1)
                {{ $respond['paginator']['total_count'] }} books
                @elseif($respond['paginator']['total_count'] == 1)
                    1 book
                @endif

            @elseif($respond['paginator']['total_pages'] > 1)
                {{ $respond['paginator']['item_from'] }}-{{ $respond['paginator']['item_to'] }}
                of {{ $respond['paginator']['total_count'] }} books

            @else
                No book was found.
            @endif
        </div>

        {{--     Number of books per page dropdown     --}}
        <div class="per-page-dropdown col-xs-6 col-sm-3">
            <div class=" dropdown">
                <button class="btn btn-default dropdown-toggle" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">
                    Books per page
                    <span class="caret"></span>
                </button>
                <ul class="dropdown-menu" aria-labelledby="dropdownMenu1">
                    <li><a href="{{ $respond['current_url'] . "?" . $respond['query'] }}&limit=5">5</a></li>
                    <li><a href="{{ $respond['current_url'] . "?" . $respond['query'] }}&limit=10">10</a></li>
                    <li><a href="{{ $respond['current_url'] . "?" . $respond['query'] }}&limit=20">20</a></li>
                    <li><a href="{{ $respond['current_url'] . "?" . $respond['query'] }}&limit=50">50</a></li>
                </ul>
            </div>
        </div>

    </div>

    <div class="container-fluid results-container">
        @foreach($respond['data'] as $book)
            <div class="row item-row">
                <div class="col-md-4 col-lg-3 col-sm-4 col-xs-12 image-box v-center-media">
                    <a href="/books/{{ $book['id'] }}">
                        @if($book['photos'] != null)
                            <img class="item-img" src="/images/books/{{ $book['photos'] }}">
                        @else
                            <img class="item-img item-no-image" alt="No Image" src="/images/general/no-image-available.jpg">
                        @endif
                    </a>

                </div><!--
         --><div class="col-sm-8 col-md-8 col-lg-9 col-xs-12 v-center-media info-box">
                    <span class="title">{!! link_to_action('BooksController@show', $book['title'], $book['id']) !!},</span>
                    <span>{{ $book['edition'] }} edition</span>
                    <span><i>( {{ $book['condition'] }} )</i></span>

                    @if(count($book['authors']) > 0)
                        <div class="authors">
                            written by <a href="/search/books/detailed?author_list%5B%5D={{ $book['authors'][0]['id'] }}">{{ $book['authors'][0]['name'] }}</a>
                            @for($i = 1; $i < count($book['authors']); $i++)
                                and <a href="/search/books/detailed?author_list%5B%5D={{ $book['authors'][$i]['id'] }}">{{ $book['authors'][$i]['name'] }}</a>
                            @endfor
                        </div>
                    @endif


                    @if(count($book['instructors']) > 0)
                        <div class="instructors tags">
                            Taught by <a href="/search/books/detailed?instructor_list%5B%5D={{ $book['instructors'][0]['id'] }}">{{ $book['instructors'][0]['name'] }}</a>
                            @for($i = 1; $i < count($book['instructors']); $i++)
                                and <a href="/search/books/detailed?instructor_list%5B%5D={{ $book['instructors'][$i]['id'] }}">{{ $book['instructors'][$i]['name'] }}</a>
                            @endfor
                        </div>
                    @endif


                    @if(count($book['courses']) > 0)
                        <div class="courses tags">
                            Courses <a href="/search/books/detailed?course_list%5B%5D={{ $book['courses'][0]['id'] }}">{{ $book['courses'][0]['name'] }}</a>
                            @for($i = 1; $i < count($book['courses']); $i++)
                                and <a href="/search/books/detailed?course_list%5B%5D={{ $book['courses'][$i]['id'] }}">{{ $book['courses'][$i]['name'] }}</a>
                            @endfor
                        </div>
                    @endif



                    <div class="price-box">
                        <div class="price">&#36;{{ $book['price'] }}</div>
                        @if($book['obo'])
                            <div class="obo-tag">
                                <span class="label label-info">OBO</span>
                            </div>
                        @endif
                    </div>

                    <span>Available @if($book['available_by'] != 'now') by @endif {{ $book['available_by'] }}</span>
                    <br />
                    <span>Posted {{ $book['created_at'] }}</span>
                </div>
            </div>

            <hr class="style-one hidden-xs">
        @endforeach

        {{--Message if no result was found--}}
        @if($respond['paginator']['total_count'] == 0)
            <div class="row">
                <div class="col-xs-12 col-sm-offset-1 col-sm-10  col-md-offset-2 col-md-8 no-result alert alert-warning" role="alert">No listing matched you search. Please try a detailed search and fill out as many fields as you can!</div>
            </div>
        @endif

    </div>

    {{--Pagination--}}
    <div class="row pagination-row">
        <nav class="">
            {!! $respond['paginator']['html_nav'] !!}
        </nav>
    </div>




@endsection


@section('style')
    <style>
        div.results-container{
            padding: 0;
            margin: 20px 15px 0 0;
        }

        span.title a{
            font-size: 18px;
            color: #222;
            font-family: "Helvetica Neue", Helvetica, Arial, sans-serif;
        }

        div.image-box{
            padding: 10px;
            text-align: center;
        }
        
        img.item-img{
            width: 90%;
            max-width: 200px;
            border-radius: 5px;
            vertical-align: middle;
        }

        div.item-row{
            vertical-align: middle;
            padding: 5px 0;
        }

        div.info-box{
            border-left: 1px solid #777;
        }
        
        div.authors{
            color: #666;
        }

        div.tags{
            margin: 7px 0;
            font-weight: 500;
        }

        div.price-box{
            margin: 5px 0;
            height: 30px;
            display: flex;
        }

        div.price{
            font-family: "Palatino Linotype", "Book Antiqua", Palatino, serif;
            font-size: 16px;
            color: #ac2925;
            font-weight: bold;
            padding: 0 15px 0 0;
            display: inline;
            margin: auto 0;
            height: 21px;
        }
        
        div.obo-tag{
            display: inline;
            margin: auto 0;
            height: 25px;
        }

        @media screen and (min-width: 480px) {
            div.v-center-media{
                display: inline-block;
                vertical-align: middle;
                float: none;
            }
        }

        @media screen and (max-width: 767px) {
            div.item-row{
                max-width: 450px;
                border: 1px solid #555;
                margin: 40px auto;
                -webkit-border-radius: 5px;
                -moz-border-radius: 5px;
                border-radius: 5px;
                padding: 0;
                box-shadow: 1px 2px 3px #999;
            }

            div.image-box{
                width: 100%;
                text-align: center;
                border-bottom: 1px solid #000;
                margin-bottom: 10px;
                background-color: #f9f9f9;
                box-shadow: 0 2px 3px #777;
                -webkit-border-radius: 5px 5px 0 0;
                -moz-border-radius: 5px 5px 0 0;
                border-radius: 5px 5px 0 0;
            }

            img.item-img{
                max-width: 200px;
                max-height: 200px;
                border-radius: 5px;
                vertical-align: middle;
            }

            div.info-box{
                border: 0;
                padding: 15px;
            }

            img.item-no-image{
                max-width: 100px;
            }

            div.results-container{
                margin: 0;
            }
        }

        @media screen and (max-width: 460px) {
            .pagination{
                width: 85%;
            }

            .pagination > li{
                display: none;
            }

            .pagination > li:first-child, .pagination > li:last-child{
                display: inline;
            }

            .pagination > li:first-child{
                float: left;
            }

            .pagination > li:last-child{
                float: right;
            }

            .pagination > li:first-child > span:after, .pagination > li:first-child > a:after{
                content: " Previous";
            }

            .pagination > li:last-child > span:after, .pagination > li:last-child > a:before{
                content: "Next ";

            }
        }

        i.toggle-btn{
            float: right;
            margin: 5px 10px 0 0;
        }

        div.search-panel-heading{
            cursor: pointer;
        }

        div.search-panel-body{
            display: none;
        }
        
        div.no-result{
            text-align: center;
        }

        div.pagination-row{
            text-align: center;
        }

        div.search-status-box{
            border-top: 1px solid #EFEFEF;
            border-bottom: 1px solid #EFEFEF;
            box-shadow: 0 0 5px #ddd;
            -webkit-box-shadow: 0 0 5px #ddd;
            -moz-box-shadow: 0 0 5px #ddd;
            font-family: "Palatino Linotype", "Book Antiqua", Palatino, serif;
            font-size: 14px;
            height: 50px;
        }

        div.per-page-dropdown{
            padding: 6px 30px 6px 0;
        }
        
        div.per-page-dropdown .dropdown{
            float: right;
        }

        div.search-info-box{
            height: 100%;
            line-height: 50px;
        }
    </style>
@endsection