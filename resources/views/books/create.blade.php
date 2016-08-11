@extends('master')

@section('content')

    <h2 class="new-book-title">What book do you have for sale?</h2>

    @include('errors._list')

    {!! Form::model($book = new \App\Models\Book, ['method' => 'POST', 'action' => ['BooksController@store'], 'files' => true, 'class' => 'form-horizontal book-request-form']) !!}
        <div class="form-group">
            {!! Form::label('title', 'Title of the book:') !!}
            {!! Form::text('title', null, ['class' => 'form-control', 'placeholder' => 'eg: Thomas&#39; Calculus: Early Transcendentals']) !!}
        </div>

        <div class="form-group">
            {!! Form::submit("Let&#39;s Get Started", ['class' => 'form-control btn btn-primary']) !!}
        </div>
    {!! Form::close() !!}

@endsection

@section('style')
    <style>
        h2.new-book-title{
            text-align: center;
            font-weight: lighter;
        }

        form.book-request-form{
            padding: 5px 30px;
            position: relative;
        }
    </style>
@endsection