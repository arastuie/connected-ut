@extends('master')

@section('content')

    <div class="content-404 col-xs-12 col-md-12">
        <div class="title-404">404 <br> This is not the page that you are looking for!</div>
    </div>

@endsection

@section('style')
    <style>
        div.content-404 {
            text-align: center;
            display: inline-block;
        }

        div.title-404 {
            font-size: 72px;
            font-size: 8vw;
            margin-bottom: 40px;
            color: #B0BEC5;
            font-weight: 100;
            font-family: 'Lato';
        }
    </style>
@endsection

@section('head')
    <link href='//fonts.googleapis.com/css?family=Lato:100' rel='stylesheet' type='text/css'>
@endsection