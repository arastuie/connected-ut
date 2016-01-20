@extends('master')

@section('content')

    <div class="full-width clearfix">
        <a class="style-reset" href="/books/create">
            <div class="update-info">
                <i class="fa fa-plus-circle"></i>
                <span>Start selling a book</span>
                <span>&#62;</span>
            </div>
        </a>
    </div>

    <div class="posted-items clearfix">
        <div class="table-heading"> <i class="fa fa-book"></i> Posted Books</div>

        @forelse($books as $book)
            <div class="row item-row">
                <div class="item-spec thumb-div col-xs-3  col-sm-2">
                    @if($book->photos != null)
                        <img src="/images/books/{{ $book->photos }}">
                    @else
                        <i class="fa fa-picture-o"></i>
                    @endif
                </div>

                <div class="item-spec item-title col-sm-4 col-xs-7">
                    <a href="/books/{{$book->id}}" class="link">{{ $book-> title }}</a>
                </div>

                <div class="item-spec col-sm-3 col-sm-offset-1 hidden-xs">
                    <a href="/books/{{$book->id}}/edit"><i class="fa fa-pencil-square-o"></i> Update / Delete</a>
                </div>

                <div class="item-spec col-sm-2 hidden-xs"><a href="#">
                        <i class="fa fa-check-square-o"></i> Mark as sold</a>
                </div>

                <div class="item-spec btn-group col-xs-2 col-xs-offset-0 hidden-sm hidden-md hidden-lg">
                    <a class="options-btn btn btn-info dropdown-toggle" data-toggle="dropdown" href="#">
                        <i class="fa fa-cog"></i>  <span class="fa fa-caret-down"></span>
                    </a>
                    <ul class="dropdown-menu dropdown-menu-right">
                        <li><a href="#"><i class="fa fa-check-square-o"></i> Mark as sold</a></li>
                        <li><a href="/books/{{$book->id}}/edit"><i class="fa fa-pencil-square-o"></i> Update / Delete</a></li>
                    </ul>
                </div>
            </div>
            <hr class="style-one"/>

        @empty
            <div class="row">
                <div class="col-xs-12 no-item" style="text-align: center;">You do not have any books listed for selling. <a href="/books/create" class="link">Start selling one</a>.</div>
            </div>
        @endforelse

    </div>
@endsection

@section('style')
    <style>
        div.no-item{
            text-align: center;
            color: #870d0e;
        }
        div.update-info{
            width: 30%;
            min-width: 250px;
            max-width: 450px;
            height: 60px;
            margin: 20px auto;
            padding: 10px;
            display: inline-block;
            box-shadow: 1px 1px 4px #999;
            color: #666;
            font-size: 20px;
            line-height: 40px;
            cursor: pointer;
            text-align: center;
            border-radius: 3px;
        }
        div.update-info i{
            color: #285C99;
            margin-right: 5px;
        }
        div.update-info span:nth-child(3){
            float: right;
        }

        div.update-info:hover{
            color: #285C99;
            background-color: #FAFAFA;
        }

        div.table-heading{
            font-size: 30px;
            margin: 15px 0;
        }

        div.table-heading i{
            color: #264788;
        }

        div.item-spec{
            min-height: 60px;
            line-height: 60px;
            padding: 0;
            font-family: "Georgia", Times, serif;
        }

        div.thumb-div{
            text-align: center;
        }
        div.thumb-div img{
            max-width: 60px;
            max-height: 60px;
            margin: 0 auto;
        }

        a.options-btn {
            margin-top: 26px;
        }

        div.item-title{
            display:inline-block;
            white-space: nowrap;
            overflow:hidden !important;
            text-overflow: ellipsis;
            padding-right: 5px;
        }
    </style>

@endsection