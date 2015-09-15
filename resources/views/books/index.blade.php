@extends('master')

@section('content')

    <h1>All the books</h1>
    <hr />

    @foreach($books as $book)
        <div class="item clearfix">
            @if($book->photos != null)
                {!! '<img class="item-photo" src="/images/books/' . $book->photos . '" />' !!}
            @endif
            <div class="item-info">
                <span class="title">{!! link_to_action('BooksController@show', $book->title, $book->id) !!}</span>
                <span><i>( {{ $conditions[$book->condition] }} )</i></span>
                <h5>&#36;{{ $book->price }}</h5>
                <h5>Available by {{ $book->available_by }}</h5>
                {{--<h4> By: {{ $book->author }} </h4>--}}
                <h5>Posted {{ $book->created_at }}</h5>
            </div>
        </div>
    @endforeach

@endsection


@section('style')
    <style>
        div.item{
            width: 100%;
            height: auto;
            border-bottom: 1px inset #444;
            padding: 20px 0;
        }

        img.item-photo{
            float: left;
            width: 200px;
            border-right: 1px dashed #555;
            padding: 0 15px 0 0;
            margin: 0 15px 0 0;
        }
        
        div.item-info{
            float: left;
        }

        span.title{
            font-size: 20px;
        }
    </style>
@endsection