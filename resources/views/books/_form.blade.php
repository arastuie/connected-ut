<div class="alert alert-info" role="alert"><strong>Keep in mind that books with more info sell faster!</strong></div>
<div class="form-group">
    {!! Form::label('title', '*Title:') !!}
    {!! Form::text('title', null, ['class' => 'form-control', 'placeholder' => 'eg: Thomas\' Calculus: Early Transcendentals']) !!}
</div>

<div class="form-group">
    {!! Form::label('edition', 'Edition:') !!}
    {!! Form::text('edition', null, ['class' => 'form-control', 'placeholder' => 'eg: 12th']) !!}
</div>

<div class="form-group">
    {!! Form::label('author_list', 'Authors:') !!}
    {!! Form::select('author_list[]', $authors, null, ['id' => 'author_list', 'class' => 'form-control', 'style' => 'width: 100%', 'multiple']) !!}
</div>

<div class="form-group">
    {!! Form::label('instructor_list', 'Instructors:') !!}
    {!! Form::select('instructor_list[]', $instructors, null, ['id' => 'instructor_list', 'class' => 'form-control', 'style' => 'width: 100%', 'multiple']) !!}
</div>

<div class="form-group">
    {!! Form::label('course_list', 'Courses:') !!}
    {!! Form::select('course_list[]', $courses, null, ['id' => 'course_list', 'class' => 'form-control', 'style' => 'width: 100%', 'multiple']) !!}
</div>

<div class="form-group">
    {!! Form::label('condition', '*Condition:') !!}
    {!! Form::select('condition', ['New', 'Used - Like New', 'Used - Very Good', 'Used - Good', 'Used - Acceptable'], null, ['class' => 'form-control', 'placeholder' => 'Condition']) !!}
</div>

<div class="form-group">
    {!! Form::label('price', '*Price:') !!}
    <div class="input-group">
        <span class="input-group-addon"><i class="fa fa-usd fa-fw"></i></span>

        {!! Form::input('number', 'price', null, ['class' => 'form-control', 'step' => '0.01', 'placeholder' => 'eg: 12.50']) !!}

        <span class="input-group-addon">
            Or Better Offer
            {!! Form::checkbox('obo', 1, null, ['class' => 'form-horizental']) !!}
        </span>
    </div>
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
    {!! Form::label('available_by', '*Available by:') !!}
    {!! Form::input('text', 'available_by', $available_by, ['class' => 'form-control available_by']) !!}
</div>

<div class="form-group">
    {!! Form::label('description', 'Description:') !!}
    {!! Form::textarea('description', null, ['class' => 'form-control', 'placeholder' => 'Description']) !!}
</div>

<div class="form-group">
    {!! Form::label('ISBN_13', 'ISBN-13:') !!}
    {!! Form::text('ISBN_13', null, ['class' => 'form-control', 'placeholder' => 'eg: 9780321588760']) !!}
</div>

<div class="form-group">
    {!! Form::label('ISBN_10', 'ISBN-10:') !!}
    {!! Form::text('ISBN_10', null, ['class' => 'form-control', 'placeholder' => 'eg: 0321588762']) !!}
</div>

<div class="form-group">
    {!! Form::label('publisher', 'Publisher:') !!}
    {!! Form::text('publisher', null, ['class' => 'form-control', 'placeholder' => 'eg: Pearson']) !!}
</div>

<div class="form-group">
    {!! Form::label('published_year', 'Published year:') !!}
    {!! Form::text('published_year', null, ['class' => 'form-control', 'placeholder' => 'eg: 2009']) !!}
</div>

<div class="form-group">
    {!! Form::submit($submitBtnText, ['class' => 'form-control btn btn-primary']) !!}
</div>

@section('style')
    <style>
        form.book-request-form{
            padding: 5px 30px;
            position: relative;
        }

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
            border-radius: 1rem;
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
    <script src="/js/book-form.js"></script>
@endsection

@section('head')
<script src="/js/libs/jquery-ui-1.11.4.min.js"></script>
{{--Leave the smoothness stylesheet to be a cdn. Pulls images form its online directory--}}
<link rel="stylesheet" href="//code.jquery.com/ui/1.11.4/themes/smoothness/jquery-ui.css">

<script src="/js/libs/select2.js"></script>
<link href="/css/libs/select2.css" rel="stylesheet" />
@endsection