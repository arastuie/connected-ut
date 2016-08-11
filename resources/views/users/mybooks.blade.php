@extends('master')

@section('content')
    <div class="full-width clearfix">
        <a class="style-reset" href="/books/create">
            <div class="update-info">
                <i class="fa fa-plus-circle"></i>
                <span>Sell a book</span>
                <span>&#62;</span>
            </div>
        </a>
    </div>

    <div class="posted-items row">
        <div class="table-heading col-sm-12 col-xs-12"> <i class="fa fa-list"></i> Listed Books</div>

        <? $count = 0 ?>
        @foreach($books as $book)
            @if($book->status == \App\Models\Book::STATUS['listed'])
                <? $count++ ?>
                <div class="col-sm-12 col-xs-12">
                    <div class="row item-row">
                        <div class="item-spec thumb-div col-xs-3  col-sm-2">
                            @if($book->mainPhotoThumbPath != null)
                                <img src="{{ $book->mainPhotoThumbPath }}">
                            @else
                                <i class="fa fa-picture-o"></i>
                            @endif
                        </div>

                        <div class="item-spec item-title col-sm-4 col-xs-6">
                            <a href="/books/{{$book->id}}" class="link">{{ $book-> title }}</a>
                        </div>

                        <div class="item-spec col-sm-3 col-sm-offset-1 hidden-xs">
                            <a href="/books/{{$book->id}}/edit"><i class="fa fa-pencil-square-o"></i> Update / Delete</a>
                        </div>


                        <div class="item-spec col-sm-2 hidden-xs">
                            <a class="mark-sold mark-as-sold" data-book="{{$book->id}}"><i class="fa fa-check-square-o"></i> Mark as sold</a>
                        </div>


                        <div class="item-spec btn-group col-xs-2 col-xs-offset-1 hidden-sm hidden-md hidden-lg">
                            <div class="btn-group-div">
                                <a class="options-btn btn btn-info dropdown-toggle" data-toggle="dropdown" href="#">
                                    <i class="fa fa-cog"></i>&nbsp; &nbsp;<span class="fa fa-caret-down"></span>
                                </a>
                                <ul class="dropdown-menu dropdown-menu-right">
                                    <li><a href="/books/{{$book->id}}/edit"><i class="fa fa-pencil-square-o"></i> Update / Delete</a></li>
                                    <li><a class="mark-sold mark-as-sold" data-book="{{$book->id}}"><i class="fa fa-check-square-o"></i> Mark as sold</a></li>
                                </ul>
                            </div>
                        </div>

                    </div>
                    <hr class="style-one"/>
                </div>
            @endif
        @endforeach
        @if($count == 0)
            <div class="row">
                <div class="col-xs-12 no-item">You do not have any books listed for selling. <a href="/books/create" class="link">Start selling one</a>.</div>
            </div>
        @endif
    </div>


    <div class="posted-items row">
        <div class="table-heading col-sm-12 col-xs-12"> <i class="fa fa-floppy-o"></i> Saved for later</div>
        <? $count = 0 ?>
        @foreach($books as $book)
            @if($book->status == \App\Models\Book::STATUS['saved_for_later'])
                <? $count++ ?>
                <div class="col-sm-12 col-xs-12">
                    <div class="row item-row">
                        <div class="item-spec thumb-div col-xs-3 col-sm-2">
                            @if($book->mainPhotoThumbPath != null)
                                <img src="{{ $book->mainPhotoThumbPath }}">
                            @else
                                <i class="fa fa-picture-o"></i>
                            @endif
                        </div>

                        <div class="item-spec item-title col-sm-4 col-xs-6">
                            <a href="/books/{{$book->id}}" class="link">{{ $book-> title }}</a>
                        </div>

                        <div class="item-spec btn-group item-spec-saved-edit col-sm-5 col-sm-offset-1 col-xs-2 col-xs-offset-1">
                            <div class="btn-group-div">
                                <a href="/books/{{$book->id}}/edit" class="hidden-xs"> <i class="fa fa-pencil-square-o"></i> Update / List / Delete </a>
                                <a href="/books/{{$book->id}}/edit" class="options-btn btn btn-info hidden-sm hidden-md hidden-lg"> <i class="fa fa-pencil-square-o"></i> </a>
                            </div>
                        </div>

                    </div>
                    <hr class="style-one"/>
                </div>
            @endif
        @endforeach
        @if($count == 0)
            <div class="row">
                <div class="col-xs-12 no-item">You do not have any books saved for later!.</div>
            </div>
        @endif
    </div>


        <div class="token" data-token="{{ csrf_token() }}" style="display: none;"></div>

@endsection

@section('style')
    <style>
        div.no-item{
            text-align: center;
            color: #870d0e;
        }

        div.update-info{
            width: 30%;
            min-width: 250px;
            max-width: 450px;
            height: 60px;
            margin: 20px auto;
            padding: 10px;
            display: inline-block;
            box-shadow: 1px 1px 4px #999;
            color: #666;
            font-size: 20px;
            line-height: 40px;
            cursor: pointer;
            text-align: center;
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

        div.table-heading{
            font-size: 25px;
            margin: 15px 0;
            font-weight: lighter;
        }

        div.table-heading i{
            color: #264788;
        }

        div.item-spec{
            height: 60px;
            line-height: 60px;
            padding: 0;
            font-family: "Georgia", Times, serif;
        }

        div.thumb-div{
            text-align: center;
        }

        div.thumb-div img{
            max-width: 60px;
            max-height: 60px;
            margin: 0 auto;
        }

        div.item-title{
            display:inline-block;
            white-space: nowrap;
            overflow:hidden !important;
            text-overflow: ellipsis;
            padding-right: 5px;
        }
        
        a.mark-sold:hover{
            cursor: pointer;
        }

        div.btn-group{
            display: flex;
            justify-content: center;
        }

        div.btn-group-div{
            height: 30px;
            align-self: center;
            line-height: 30px;
        }

        div.posted-items{
            padding: 25px 50px;
        }
        
        div.item-spec-saved-edit{
            text-align: center;
        }
    </style>
@endsection

@section('script')
<script>
    $(function() {
        $('a.mark-as-sold').on('click', function(){
            var token = $('div.token').attr('data-token');
            var bookID = $(this).attr('data-book');

            swal({
                title: "Is it sold?",
                text: "Once you mark it as sold, it will be gone from your listings!",
                type: "warning",
                showCancelButton: true,
                confirmButtonColor: "#3FAF3D",
                confirmButtonText: "Yes!",
                cancelButtonText: "cancel!",
                closeOnConfirm: false,
                closeOnCancel: false,
                showLoaderOnConfirm: true,
            }, function(isConfirm){
                if (isConfirm) {
                    $.ajax({
                        url: "/books/" + bookID + "/sold",
                        type: "PUT",
                        data: {_token : token}
                    }).done(function(){
                        swal({
                            title: "Glad to hear that. Sold!",
                            text: "Your book has been successfully marked as sold.",
                            type: "success",
                            timer: 1500,
                            allowOutsideClick: true
                        });
                        setTimeout(function(){
                            window.location.reload(true);
                        }, 1500);
                    }).fail(function(xhr){
                        console.log(xhr.responseText);
                        swal({
                            title: "Somwthing went wrong!",
                            text: "Please try again. If the problem persist, do not hesitate to contact us at support@connectedut.com.",
                            type: "error"
                        });
                    });
                } else {
                    swal({
                        title: "Cancelled",
                        text: "Your book is safe and still listed :)",
                        type: "error",
                        timer: 1500,
                        allowOutsideClick: true
                    });
                }
            });
        });
    });
</script>
@endsection