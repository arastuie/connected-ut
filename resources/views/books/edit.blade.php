@extends('master')

@section('content')

    <h2>Edit: {{ $book->title }}</h2>

    <hr/>

    @include('errors._list')

    {!! Form::model($book, ['method' => 'PUT', 'action' => ['BooksController@update', $book->id], 'files' => true, 'class' => 'form-horizontal book-request-form']) !!}
        @include('books._form', ['submitBtnText' => 'Update', 'action' => 'edit'])
    {!! Form::close() !!}

    <div style="margin-bottom: 20px">
        <a class="btn btn-danger form-control delete-book" data-book="{{$book->id}}" data-token="{{ csrf_token() }}">Delete</a>
    </div>
@endsection