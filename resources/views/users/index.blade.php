@extends('master')

@section('content')

@include('partials._flash', with(['delay' => 4000]))

<i class="fa fa-user fa-3x user-thumb"></i><span class="heading-title">My Account</span>

<div class="full-width clearfix">

    <a class="style-reset" href="/account/update">
        <div class="update-info">
            <i class="fa fa-pencil"></i>
            <span>Update personal info</span>
            <span>&#62;</span>
        </div>
    </a>

    <a class="style-reset" href="/account/change_password">
        <div class="update-info">
            <i class="fa fa-key"></i>
            <span>Change password</span>
            <span>&#62;</span>
        </div>
    </a>

</div>

<hr class="style-two"/>

<i class="fa fa-book fa-3x user-thumb"></i><span class="heading-title">My Listings</span>

<div class="full-width clearfix">

    <a class="style-reset" href="/account/mybooks">
        <div class="update-info">
            <i class="fa fa-list"></i>
            <span>My books</span>
            <span>&#62;</span>
        </div>
    </a>

    <a class="style-reset" href="/books/create">
        <div class="update-info">
            <i class="fa fa-plus-circle"></i>
            <span>Start selling a book</span>
            <span>&#62;</span>
        </div>
    </a>

</div>

@endsection


@section('style')
<style>
    span.heading-title{
        color: #333;
        font-size: 25px;
        margin-left: 15px;
    }

    i.user-thumb{
        color: #2990a3;
    }

    div.update-info{
        width: 30%;
        min-width: 250px;
        max-width: 450px;
        height: 60px;
        margin: 20px 10px 10px 10px;
        padding: 10px;
        display: inline-block;
        box-shadow: 1px 1px 4px #999;
        color: #666;
        font-size: 20px;
        line-height: 40px;
        cursor: pointer;
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



    /* Posted Items */
    div.heading-title{
        font-size: 26px;
        color: #444;
        font-family: 'Trebuchet', 'Trebuchet', 'Trebuchet', sans-serif;
    }

    div.table-heading{
        font-size: 30px;
        margin: 20px 0;
    }

    div.table-heading i{
        color: #264788;
    }

    div.posted-items{
        width: 100%;
        height: auto;
        padding: 10px;
    }


    table.items-table{
        width: 100%;
        table-layout: fixed;
    }

    table.items-table tr{
        height: 60px;
        border-bottom: 1px solid #777;
    }

    table.items-table td{
        padding: 10px 0;
    }

    td.thumb-td{
        padding: 3px;
        width: 80px;
    }

    td.thumb-td img{
        max-width: 60px;
        max-height: 60px;
    }

    td.update-td, td.sold-td{
        padding-left: 10px;
        text-align: center;
        font-size: 18px;
    }

    td a:hover{
        text-decoration: none;
    }

</style>
@endsection