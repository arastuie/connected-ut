<div class="col-xs-12 col-sm-12">
    <div class="alert alert-info" role="alert"><strong>Keep in mind that books with more info sell faster!</strong></div>
</div>

{{--Book ID for AJAX post request--}}
{!! Form::hidden('_bookID', $book->id) !!}

{{--Item Information--}}
<div class=" col-sm-12 col-xs-12">
    <div class="panel panel-primary">
        <div class="panel-heading">
            <h3 class="panel-title">Item Information</h3>
        </div>

        <div class="panel-body">
            <div class="form-group col-sm-12 col-xs-12">
                {!! Form::label('title', '* Title:') !!}
                {!! Form::text('title', null, ['class' => 'form-control item-info', 'placeholder' => 'eg: Thomas\' Calculus: Early Transcendentals']) !!}
            </div>

            <div class="form-group col-sm-6 col-xs-12">
                {!! Form::label('condition', '* Condition:') !!}
                {!! Form::select('condition', ['' => 'Select a condition', 'New', 'Used - Like New', 'Used - Very Good', 'Used - Good', 'Used - Acceptable'], null, ['class' => 'form-control item-info', 'placeholder' => 'Condition']) !!}
            </div>

            <div class="form-group col-sm-6 col-xs-12">
                {!! Form::label('available_by', '* Available by:') !!}
                {!! Form::input('text', 'available_by', $available_by, ['class' => 'form-control available_by item-info', 'placeholder' => 'When is the book available for sale?']) !!}
            </div>

            <div class="form-group col-sm-12 col-xs-12">
                {!! Form::label('price', '* Price:') !!}
                <div class="input-group">
                    <span class="input-group-addon"><i class="fa fa-usd fa-fw"></i></span>

                    {!! Form::input('number', 'price', null, ['class' => 'form-control item-info', 'step' => '0.01', 'placeholder' => 'eg: 12.50']) !!}

                    <div class="input-group-addon obo-addon">
                        {!! Form::checkbox('obo', 1, null, ['class' => 'form-horizental item-info']) !!} Or Best Offer
                    </div>
                </div>
            </div>

        </div>
    </div>
</div>

{{--UT Specific Details--}}
<div class=" col-sm-12 col-xs-12">
    <div class="panel panel-warning">
        <div class="panel-heading">
            <h3 class="panel-title">UT Specific Details</h3>
        </div>

        <div class="panel-body">
            <div class="form-group">
                {!! Form::label('instructor_list', 'Instructors:') !!}
                {!! Form::select('instructor_list[]', $instructors, null, ['id' => 'instructor_list', 'class' => 'form-control item-info', 'style' => 'width: 100%', 'multiple']) !!}
            </div>

            <div class="form-group">
                {!! Form::label('course_list', 'Courses:') !!}
                {!! Form::select('course_list[]', $courses, null, ['id' => 'course_list', 'class' => 'form-control item-info', 'style' => 'width: 100%', 'multiple']) !!}
            </div>
        </div>
    </div>
</div>

{{--Book Details--}}
<div class=" col-sm-12 col-xs-12">
    <div class="panel panel-info">
        <div class="panel-heading">
            <h3 class="panel-title">Book Details</h3>
        </div>

        <div class="panel-body row">
            <div class="form-group col-sm-12 col-xs-12">
                {!! Form::label('edition', 'Edition:') !!}
                {!! Form::text('edition', null, ['class' => 'form-control item-info', 'placeholder' => 'eg: 12th']) !!}
            </div>

            <div class="form-group col-sm-12 col-xs-12">
                {!! Form::label('author_list', 'Authors:') !!}
                {!! Form::select('author_list[]', $authors, null, ['id' => 'author_list', 'class' => 'form-control item-info', 'style' => 'width: 100%', 'multiple']) !!}
            </div>

            <div class="form-group col-sm-6 col-xs-12">
                {!! Form::label('publisher', 'Publisher:') !!}
                {!! Form::text('publisher', null, ['class' => 'form-control item-info', 'placeholder' => 'eg: Pearson']) !!}
            </div>

            <div class="form-group col-sm-6 col-xs-12">
                {!! Form::label('published_year', 'Published year:') !!}
                {!! Form::text('published_year', null, ['class' => 'form-control item-info', 'placeholder' => 'eg: 2009']) !!}
            </div>

            <div class="form-group col-sm-6 col-xs-12">
                {!! Form::label('ISBN_13', 'ISBN-13:') !!}
                {!! Form::text('ISBN_13', null, ['class' => 'form-control item-info', 'placeholder' => 'eg: 9780321588760']) !!}
            </div>

            <div class="form-group col-sm-6 col-xs-12">
                {!! Form::label('ISBN_10', 'ISBN-10:') !!}
                {!! Form::text('ISBN_10', null, ['class' => 'form-control item-info', 'placeholder' => 'eg: 0321588762']) !!}
            </div>
        </div>
    </div>
</div>

{{--Photos--}}
<div class=" col-sm-12 col-xs-12">
    <div class="panel panel-info">
        <div class="panel-heading">
            <h3 class="panel-title">Photos</h3>
        </div>

        <div class="panel-body">
            <div class="form-group photo-form-group">
                {!! Form::label('photo', 'Add Up to 4 Photos:', ['style' => 'display:block']) !!}
                <div class="photo-uploader dropzone">

                    <div class="photo-uploader"></div>
                </div>

                <div class="row dropzone-previews photo-preview">
                    <div class="preview-template" style="display: none">
                        <div class="photo-prev-box">
                            <div class="thumbnail thumb-thumbnail">
                                <img class="thumb-prev-photo" data-dz-thumbnail />
                                <div class="caption thumb-caption">
                                    <hr>
                                    <div class="thumb-prev-upload">
                                        <div class="progress">
                                            <div class="progress-bar progress-bar-info" role="progressbar" aria-valuemin="0" aria-valuemax="100" data-dz-uploadprogress></div>
                                        </div>
                                        <div class="thumb-prev-size">Size: <span data-dz-size></span></div>
                                        <a href="#" class="btn btn-danger" role="button" data-dz-remove>Cancel upload</a>
                                    </div>

                                    <div class="thumb-prev-error" style="display: none">
                                        <i class="thumb-error-close fa fa-times-circle-o fa-3x" aria-hidden="true" data-dz-remove></i>
                                        <div class="alert alert-danger" role="alert"></div>
                                    </div>

                                    <div class="thumb-prev-info" style="display: none">
                                        <p>
                                            <input type="radio" name="main_photo" value="" id="main-photo" class="main-photo">&nbsp;
                                            <label for="main-photo" class="label label-info"> Main photo</label>
                                        </p>
                                        <hr>
                                        <a href="" class="btn btn-danger delete-photo" role="button" data-photo-id="">Delete</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    @foreach($book->photos as $photo)
                        <div class="photo-prev-box">
                            <div class="thumbnail thumb-thumbnail">
                                <img class="thumb-prev-photo" src="{{ $photo['thumbnail_path'] }}"/>
                                <div class="caption thumb-caption">
                                    <hr>
                                    <div class="thumb-prev-info">
                                        <p>
                                            <input type="radio" name="main_photo" value="{{ $photo['id'] }}" id="main-photo" class="main-photo" {{ ($photo['is_main'])? 'checked' : '' }}>&nbsp;
                                            <label for="main-photo" class="label label-info"> Main photo</label>
                                        </p>
                                        <hr>
                                        <div class="btn btn-danger delete-photo" role="button" data-photo-id="{{ $photo['id'] }}">Delete</div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>

            </div>
        </div>
    </div>
</div>

{{--Additional Description--}}
<div class=" col-sm-12 col-xs-12">
    <div class="panel panel-info">
        <div class="panel-heading">
            <h3 class="panel-title">Additional Description</h3>
        </div>

        <div class="panel-body">
            <div class="form-group">
                {!! Form::label('description', 'Description:') !!}
                {!! Form::textarea('description', null, ['class' => 'form-control item-info', 'placeholder' => 'Add more details here']) !!}
            </div>
        </div>
    </div>
</div>


<div class="col-xs-6 col-sm-6">
    <div class="form-group">
        <a href="/account/mybooks" class="btn btn-info form-control">{{ $doneBtnText }}</a>
    </div>
</div>

<div class="col-xs-6 col-sm-6">
    <div class="form-group">
        <div class="btn btn-primary form-control list-it-btn">{{ $submitBtnText }}</div>
    </div>
</div>

@section('script')
    <script src="/js/book-form.js"></script>
@endsection

@section('head')
    <script src="/js/libs/jquery-ui-1.11.4.min.js"></script>
    {{--Leave the smoothness stylesheet to be a cdn. Pulls images form its online directory--}}
    <link rel="stylesheet" href="//code.jquery.com/ui/1.11.4/themes/smoothness/jquery-ui.css">

    <script src="/js/libs/select2.js"></script>
    <link href="/css/libs/select2.css" rel="stylesheet" />

    <script src="/js/libs/dropzone.js"></script>
    <link href="/css/libs/dropzone.css" rel="stylesheet" />

    <link href="/css/book-form.css" rel="stylesheet" />
@endsection