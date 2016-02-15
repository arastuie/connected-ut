@extends('master')

@section('content')

    <h2>List a New Book</h2>

    <hr/>

    @include('errors._list')

    {!! Form::model($book = new \App\Book, ['method' => 'POST', 'action' => ['BooksController@store'], 'files' => true, 'class' => 'form-horizontal book-request-form']) !!}
        @include('books._form', ['submitBtnText' => 'Start Selling', 'action' => 'create', 'available_by' => date('m/d/Y')])
    {!! Form::close() !!}

@endsection
