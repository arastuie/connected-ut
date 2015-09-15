<div class="form-group">
    {!! Form::label('title', 'Title:') !!}
    {!! Form::text('title', null, ['class' => 'form-control', 'placeholder' => 'Title']) !!}
</div>

<div class="form-group">
    {!! Form::label('description', 'Description:') !!}
    {!! Form::textarea('description', null, ['class' => 'form-control', 'placeholder' => 'Description']) !!}
</div>

<div class="form-group">
    {!! Form::label('condition', 'Condition:') !!}
    {!! Form::select('condition', ['New', 'Used - Like New', 'Used - Very Good', 'Used - Good', 'Used - Acceptable'], null, ['class' => 'form-control', 'placeholder' => 'Condition']) !!}
</div>

<div class="form-group">
    {!! Form::label('price', 'Price: $') !!}
    {!! Form::input('number', 'price', null, ['class' => 'form-control', 'step' => '0.01', 'placeholder' => 'Price']) !!}
</div>

@if($action === 'create')
    <div class="form-group photo-group clearfix">
        {!! Form::label('photo', 'Add Up to 4 Photos:', ['style' => 'display:block']) !!}
        {!! Form::file('pics[0]', array('id' => 'photo_0', 'class' => 'photo', 'accept' => '.jpg, .png', 'style' => 'display:none')) !!}
        {!! Form::file('pics[1]', array('id' => 'photo_1', 'class' => 'photo', 'accept' => '.jpg, .png', 'style' => 'display:none')) !!}
        {!! Form::file('pics[2]', array('id' => 'photo_2', 'class' => 'photo', 'accept' => '.jpg, .png', 'style' => 'display:none')) !!}
        {!! Form::file('pics[3]', array('id' => 'photo_3', 'class' => 'photo', 'accept' => '.jpg, .png', 'style' => 'display:none')) !!}
        <div class="browse-photo">
            <i class="fa fa-plus-square-o fa-3x"></i>
        </div>
    </div>
@endif

@if($action === 'edit')
    <div class="form-group photo-group clearfix">
        {!! Form::label('photo', 'Add Up to 4 Photos:', ['style' => 'display:block']) !!}

        @if($book->photos != null)
            @foreach($book->photos as $key => $photo)
                <div class="thumb-photo-div uploaded-pic">
                    <img class="uploaded-photo-{{ $key }}" src="/images/books/{{ $photo }}" alt="" />
                    @if($key === 0)
                        <i class="check-mark fa fa-check-square fa-2x"></i>
                    @endif
                    <i class="fa fa-times-circle-o fa-3x"></i>
                </div>
            @endforeach
        @endif

        {!! Form::file('pics[0]', array('id' => 'photo_0', 'class' => 'photo', 'accept' => '.jpg, .png', 'style' => 'display:none')) !!}
        {!! Form::file('pics[1]', array('id' => 'photo_1', 'class' => 'photo', 'accept' => '.jpg, .png', 'style' => 'display:none')) !!}
        {!! Form::file('pics[2]', array('id' => 'photo_2', 'class' => 'photo', 'accept' => '.jpg, .png', 'style' => 'display:none')) !!}
        {!! Form::file('pics[3]', array('id' => 'photo_3', 'class' => 'photo', 'accept' => '.jpg, .png', 'style' => 'display:none')) !!}

        <input type="hidden" value="" class="deleted-pics" name="deleted_pics"/>

        <div class="browse-photo">
            <i class="fa fa-plus-square-o fa-3x"></i>
        </div>
    </div>
@endif

<div class="form-group">
    {!! Form::label('available_by', 'Available by:') !!}
    {!! Form::input('text', 'available_by', $available_by, ['class' => 'form-control available_by']) !!}
</div>

<div class="form-group">
    {!! Form::submit($submitBtnText, ['class' => 'form-control btn btn-primary']) !!}
</div>

@section('style')
    <style>
        div.browse-photo{
            width: 15%;
            min-width: 200px;
            max-width: 300px;
            border: 1px solid #CCC;
            border-radius: 1rem;
            text-align: center;
            cursor: pointer;
            float: left;
        }
        div.browse-photo:hover{
            background-color: #F9F9F9;
        }
        i.fa-plus-square-o{
            margin: 20% 30%;
        }

        div.thumb-photo-div img{
            width: 100%;
            max-height: 300px;
            padding: 0.25rem;
        }

        div.thumb-photo-div{
            border: 1px solid #CCC;
            width: 20%;
            min-width: 200px;
            height: auto;
            max-height: 350px;
            border-radius: 1rem;
            float: left;
            margin: 0 1rem 1rem 0;
            position: relative;
        }

        i.fa-times-circle-o{
            position: absolute;
            top: 3%;
            right: 3%;
            cursor: pointer;
        }

        i.fa-times-circle-o:hover{
            color: #A00000;
        }

        i.check-mark{
            position: absolute;
            top: 3%;
            left: 3%;
            color: #33CC33;
        }

    </style>
@endsection

@section('script')

<script>
   $(function() {
       $("input.available_by").datepicker({
           format: 'mm/dd/yyyy',
           minDate: 'd'
       });
   });
</script>

<script>
    $(function() {
       // Rest of the javascript is for photo selection

       // uploaded pic div for edit form
       var uploadedPic = $('div.uploaded-pic');

        //  photoArray and file inputs, limits the selection to 4
       var photoArray = [false, false, false, false];

        for(var i = 0; i < uploadedPic.length; i++)
        {
            photoArray[i] = true;
        }

       var inputId = $.inArray(false, photoArray);
       var photoNum;
       var browsePhoto = $('div.browse-photo');

       browsePhoto.on('click', function(){
           $('input#photo_' + inputId).trigger('click');
       });


       // Clicking on delete btn for chosen photos
       $('div.photo-group').on('click', 'i.delete-btn', function(){
           inputId = $(this).siblings('img').attr('class').substr(-1);
           inputId = parseInt(inputId);

           $(this).parent('div.thumb-photo-div').remove();

           $('input#photo_' + inputId).val("");
           deleteCleanUp();
       });

        // Clicking on delete btn for uploaded photos
        if(uploadedPic.length > 0)
        {
            uploadedPic.children('i.fa-times-circle-o').on('click', function(){
                inputId = $(this).siblings('img').attr('class').substr(-1);
                inputId = parseInt(inputId);

                var deletedPicsInput = $('input.deleted-pics');
                var deletedPics = deletedPicsInput.attr('value');
                deletedPics = (deletedPics)? (deletedPics + ';' + inputId): inputId;
                deletedPicsInput.attr('value', deletedPics);

                $(this).parent('div.uploaded-pic').remove();

                deleteCleanUp();
            });
        }

       // takes care of deleting and adding a new photo
       $('input.photo').on('change', function(){

           photoArray[inputId] = true;
           photoNum = inputId + 1;
           inputId = $.inArray(false, photoArray);
           readURL(this);

           if($.inArray(false, photoArray) === -1) {
               browsePhoto.hide();
           }

           indicateMainPhoto();
       });

       //  Displays photos right after user's selection
       function readURL(input) {
           if (input.files) {
               browsePhoto.before('<div class="thumb-photo-div"><img src="#" class="photo_' + (photoNum - 1) +
                                        '"alt="" /><i class="fa delete-btn fa-times-circle-o fa-3x"></i></div>');

               var reader = new FileReader();

               reader.onload = function (e) {
                   $('img.photo_' + (photoNum - 1)).attr('src', e.target.result)
               };

               reader.readAsDataURL(input.files[0]);
           }
       }

        //  Do necessary stuff after deleting a photo
        function deleteCleanUp(){
            photoArray[inputId] = false;
            inputId = $.inArray(false, photoArray);
            browsePhoto.show();

            indicateMainPhoto();
        }

        function indicateMainPhoto()
        {
            $('i.check-mark').remove();
            var mainPhoto = $.inArray(true, photoArray);
            $('img.photo_' + mainPhoto + ', img.uploaded-photo-' + mainPhoto).after('<i class="check-mark fa fa-check-square fa-2x"></i>');
        }
   });
</script>

@if(false)
    <script>
        $(function() {
            // Rest of the javascript is for photo selection

            var photoArray = [false, false, false, false];
            var inputId = 0;
            var photoNum;
            var browsePhoto = $('div.browse-photo');

            browsePhoto.on('click', function(){
                $('input#photo_' + inputId).trigger('click');
            });


            // Clicking on delete btn for chosen photos

            $('div.photo-group').on('click', 'i.delete-btn', function(){
                inputId = $(this).siblings('img').attr('class').substr(-1);
                inputId = parseInt(inputId);

                $(this).parent('div.thumb-photo-div').remove();

                $('input#photo_' + inputId).val("").trigger('change');
            });

            // takes care of deleting and adding a new photo
            $('input.photo').on('change', function(){
                if($(this).val() != "")
                {
                    photoArray[inputId] = true;

                    photoNum = inputId + 1;

                    inputId = $.inArray(false, photoArray);

                    readURL(this);
                }
                else{
                    photoArray[inputId] = false;
                    inputId = $.inArray(false, photoArray);

                    browsePhoto.show();
                }


                if($.inArray(false, photoArray) === -1)
                {
                    browsePhoto.hide();
                }else{
                    browsePhoto.css('border', '0px solid #CCC');
                }


                if($.inArray(true, photoArray) === -1){
                    browsePhoto.css('border', '1px solid #CCC');
                }


                $('i.check-mark').remove();

                var mainPhoto = $.inArray(true, photoArray);
                $('img.photo_' + mainPhoto).after('<i class="check-mark fa fa-check-square fa-2x"></i>');
            });

            //  Displays photos right after user's selection and limits the selection to 4
            function readURL(input) {
                if (input.files) {
                    browsePhoto.before('<div class="thumb-photo-div clearfix"><img src="#" class="photo_'
                    + (photoNum - 1) + '"alt="" /><i class="fa delete-btn fa-times-circle-o fa-3x"></i></div>');

                    var reader = new FileReader();

                    reader.onload = function (e) {
                        $('img.photo_' + (photoNum - 1))
                                .attr('src', e.target.result)
                    };

                    reader.readAsDataURL(input.files[0]);
                }
            }
        });
    </script>
@endif

@endsection



@section('head')
<script src="//code.jquery.com/ui/1.11.4/jquery-ui.js"></script>
<link rel="stylesheet" href="//code.jquery.com/ui/1.11.4/themes/smoothness/jquery-ui.css">
@endsection

