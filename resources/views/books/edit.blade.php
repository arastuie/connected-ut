@extends('master')

@section('content')
    <div class="row">
        {!! Form::model($book, ['method' => 'PUT', 'action' => ['BooksController@update', $book->id], 'files' => true, 'class' => 'form-horizontal book-request-form']) !!}

        <div class="col-xs-12 col-sm-12">
            <h2 class="title">Edit: {{ $book->title }}</h2>
            <hr/>
        </div>

        @include('errors._list')

        @include('books._form', [
                'submitBtnText' => ($book->status == \App\Models\Book::STATUS['saved_for_later'])? 'List it' : 'Unlist it',
                'doneBtnText' => ($book->status == \App\Models\Book::STATUS['saved_for_later'])? 'Save for later' : 'Done editing'
            ])

        <div class="col-xs-12 col-sm-12">
            <div class="form-group">
                <a class="btn btn-danger form-control delete-book">Delete</a>
            </div>
        </div>

        {!! Form::close() !!}
    </div>
@endsection