@extends('master')

@section('content')

@include('partials._flash', with(['delay' => 4000]))

<i class="fa fa-user fa-3x"></i><span class="heading-title">My Account</span>

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

<div class="posted-items clearfix">
    <div class="heading-title">Posted items</div> <br/>
    <div class="table-heading"> <i class="fa fa-book"></i> Books</div>

    @foreach($books as $book)
        <table class="items-table">
            <tr>
                <td class="thumb-td"> <img src="/images/books/{{ $book->photos }}"> </td>
                <td class="title-td"> {{ $book-> title }} </td>
                <td class="update-td"> <a href="/books/{{$book->id}}/edit"><i class="fa fa-pencil-square-o"></i> Update</a></td>
                <td class="sold-td"> <a href="#"><i class="fa fa-check-square-o"></i> Mark as sold</a></td>
            </tr>
        </table>
    @endforeach

</div>


@endsection


@section('style')
<style>
    span.heading-title{
        color: #333;
        font-size: 25px;
        margin-left: 15px;
    }

    i.fa-user{
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
        box-shadow: 1px 2px 3px #999;
        color: #666;
        font-size: 20px;
        line-height: 40px;
        cursor: pointer;
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