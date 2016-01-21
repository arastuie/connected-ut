@extends('master')

@section('content')

    <h2>Edit: {{ $book->title }}</h2>

    <hr/>

    @include('errors._list')

    {!! Form::model($book, ['method' => 'PUT', 'action' => ['BooksController@update', $book->id], 'files' => true, 'class' => 'form-horizontal']) !!}
        @include('books._form', ['submitBtnText' => 'Update', 'action' => 'edit'])
    {!! Form::close() !!}

@endsection