@extends('master')


@section('content')
<div class="item clearfix">
    <h3 class="title">{{ $book->title }}</h3>

    <div class="item-info clearfix">
        @if($book->photos != null)
            <div class="photos">

                <div class="main-photo">
                    <span></span>
                    <img src="/images/books/{{ $book->photos[0] }}"/>
                </div>

                <div class="sub-photos">
                    @foreach($book->photos as $photo)
                        <div>
                            <img class="sub-photo" src="/images/books/{{ $photo }}">
                        </div>
                    @endforeach
                </div>
            </div>
        @endif

        <div class="item-details clearfix">
            <span class="item-price item-detail">Price: <span>&#36;{{ $book->price }}</span></span> <br/>
            <span class="item-condition item-detail">Condition: <span>{{ $conditions[$book->condition] }}</span></span> <br/>
            <span class="item-available item-detail">Available by <span>{{ $book->available_by }}</span></span> <br/>
            <span class="item-posted item-detail">Posted <span>{{ $book->created_at }}</span></span> <br/>
            @if($book->description != "")
                <span class="item-description"> Description: <br/>
                    <p>{{ $book->description }}</p>
                </span>
            @endif
        </div>

        <div class="clearfix"></div>

        <hr />

        <div class="item-contact clearfix">

            <div class="contact-info">
                <span class="item-emailaddress item-detail"> Sellers Email Address: <span>Makan.Arastuie@gmail.com</span></span> <br />
                <span class="item-emailaddress item-detail"> Sellers Phone Number: <span>(419)699-4478</span></span>
            </div>

            <br />

            <div class="item-email">
                <form>
                    <textarea>Email content</textarea>
                    <button type="submit" >Send this email to seller</button>
                </form>
            </div>


        </div>


    </div>

</div>
@endsection


@section('style')
<style>
    h3.title{
        margin: 20px 0;
    }

    div.item{
        width: 90%;
        margin: 20px auto;
        height: auto;
    }

    div.item-info{
        width: 100%;
        height: auto;
    }

    div.item-details{
        width: 60%;
        height: 100%;
        padding: 40px 20px 10px 20px;
        float: left;
    }
    
    span.item-detail{
        color: #333333;
        line-height: 30px;
    }

    span.item-detail span{
        font-style: italic;
        color: #000;
    }

    span.item-description p{
        margin: 5px 0 0 15px;
        color: #000000;
    }

    div.item-contact{
        width: 100%;
        min-height: 150px;
        height: auto;
        padding-top: 20px;
    }

    div.item-email{
        width: 100%;
        height: auto;
    }

    textarea{
        width: 100%;
        height: 200px;
    }
    
    button{
        float: right;
    }

    /* Photos' Style */

    /*  Keep the 40 to 50 ratio for photos div*/
    div.photos{
        width: 40%;
        height: 0;
        padding-bottom: 50%;
        position: relative;
        float: left;
        border: 1px dashed #666;
        border-radius: 10% 3% 10% 3%;
    }

    div.main-photo{
        width: 100%;
        height: 80%;
        position: absolute;
        top: 0;
        text-align: center;
    }

    div.main-photo span{
        display: inline-block;
        height: 100%;
        vertical-align: middle;
    }

    div.main-photo img{
        margin-top: 2%;
        width: auto;
        min-width: 45%;
        max-width: 95%;
        height: auto;
        min-height: 45%;
        max-height: 95%;
        padding: 2px;
        border: 1px solid #888;
        border-radius: 5px;
        vertical-align: middle;
    }

    div.sub-photos{
        width: 100%;
        height: 20%;
        position: absolute;
        bottom: 0;
        text-align: center;
    }

    div.sub-photos div{
        display: inline-block;
        width: 20%;
        height: 80%;
        margin: 0.5%;
    }

    img.sub-photo{
        padding: 1px;
        border: 1px solid #888;
        border-radius: 5px;
        cursor: pointer;
        max-height: 100%;
        max-width: 100%;
    }

    div.sub-photos div:first-child img{
        border-color: blue;
    }


</style>
@endsection

@section('script')
<script>
    var mainPhoto = $('div.main-photo img');
    var subPhoto = $('img.sub-photo');

    subPhoto.on('click', function(){
        if(mainPhoto.attr('src') != $(this).attr('src')){
            subPhoto.css('border-color', '#888');
            $(this).css('border-color', 'blue');

            mainPhoto.finish().slideUp(150);
            mainPhoto.attr('src', $(this).attr('src'));
            mainPhoto.slideDown(150);
        }
    });

</script>
@endsection