@extends('master')

@section('content')

    <h2>Edit: {{ $book->title }}</h2>

    <hr/>

    @include('errors._list')

    {!! Form::model($book, ['method' => 'PUT', 'action' => ['BooksController@update', $book->id], 'files' => true, 'class' => 'form-horizontal']) !!}
        @include('books._form', ['submitBtnText' => 'Update', 'action' => 'edit'])
    {!! Form::close() !!}

    <a class="btn btn-danger form-control" data-toggle="modal" data-target=".bs-modal-sm">Delete</a>

    {{--Modal confirmation for delete--}}
    <div class="modal fade bs-modal-sm" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel">
        <div class="modal-dialog modal-sm">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h5 class="modal-title" id="gridSystemModalLabel">Are you sure you want to delete it?</h5>
                </div>

                <div class="modal-footer">
                    <a class="btn btn-primary btn-danger" href="/books/{{$book->id}}/sold/false"><i class="fa fa-trash"></i> Delete</a>
                    <button type="button" class="btn btn-default" data-dismiss="modal"><i class="fa fa-ban"></i> Cancel</button>
                </div>
            </div>
        </div>
    </div>
@endsection
