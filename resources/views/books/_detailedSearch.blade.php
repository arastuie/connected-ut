<div class="row detailed-search-row">

    <div class="col-sm-offset-2 col-sm-8 col-xs-12">

        <div class="panel panel-default">
            <div class="search-panel-heading panel-heading">
                <span class="panel-title">Detailed Search</span>
                <i class="toggle-btn fa-lg fa fa-bars"></i>
            </div>

            <div class="search-panel-body panel-body">
                {!! Form::model($search, ['method' => 'GET', 'action' => ['SearchController@booksDetailed'], 'class' => 'form-horizontal', 'autocomplete' => 'off']) !!}

                <div class="form-group">
                    {!! Form::label('title', 'Title:', ['class' => 'control-label col-sm-2']) !!}
                    <div class="col-sm-10">
                        {!! Form::text('title', null, ['class' => 'form-control', 'placeholder' => 'eg: Thomas\' Calculus: Early Transcendentals']) !!}
                    </div>
                </div>

                <div class="form-group">
                    {!! Form::label('author_list', 'Authors:', ['class' => 'control-label col-sm-2']) !!}
                    <div class="col-sm-10">
                        {!! Form::select('author_list[]', $authors, null, ['id' => 'author_list', 'class' => 'form-control', 'style' => 'width: 100%', 'multiple']) !!}
                    </div>
                </div>

                <div class="form-group">
                    {!! Form::label('instructor_list', 'Instructors:', ['class' => 'control-label col-sm-2']) !!}
                    <div class="col-sm-10">
                        {!! Form::select('instructor_list[]', $instructors, null, ['id' => 'instructor_list', 'class' => 'form-control', 'style' => 'width: 100%', 'multiple']) !!}
                    </div>
                </div>

                <div class="form-group">
                    {!! Form::label('course_list', 'Courses:', ['class' => 'control-label col-sm-2']) !!}
                    <div class="col-sm-10">
                        {!! Form::select('course_list[]', $courses, null, ['id' => 'course_list', 'class' => 'form-control', 'style' => 'width: 100%', 'multiple']) !!}
                    </div>
                </div>

                <div class="form-group">
                    {!! Form::label('ISBN_13', 'ISBN-13:', ['class' => 'control-label col-sm-2']) !!}
                    <div class="col-sm-10">
                        {!! Form::text('ISBN_13', null, ['class' => 'form-control', 'placeholder' => 'eg: 9780321588760']) !!}
                    </div>
                </div>

                <div class="form-group">
                    {!! Form::label('ISBN_10', 'ISBN-10:', ['class' => 'control-label col-sm-2']) !!}
                    <div class="col-sm-10">
                        {!! Form::text('ISBN_10', null, ['class' => 'form-control', 'placeholder' => 'eg: 0321588762']) !!}
                    </div>
                </div>

                <div class="form-group">
                    <div class="col-xs-offset-7 col-xs-4 col-sm-offset-9 col-sm-2">
                        {!! Form::button('Let&#39;s Go', ['type' => 'submit', 'class' => 'form-control btn btn-info']) !!}
                    </div>
                </div>
                {!! Form::close() !!}
            </div>
        </div>

    </div>
</div>

@section('script')

    <script>
        $(function(){
            $("#instructor_list, #course_list, #author_list").select2({
                placeholder: "Select all",
                allowClear: true,
                selectOnClose: true,
                minimumInputLength: 2
            });

            $("div.search-panel-heading").on('click', function(){
                $(this).children(".toggle-btn").toggleClass("fa-bars fa-times");
                $("div.search-panel-body").stop().slideToggle(400);
            })
        })
    </script>

    @if(session('flash_type') == "detailed_search_open")
        <script>
            $(function(){
                $("div.panel").animate({
                    opacity: "hide"
                }, 300, function(){
                    $("div.panel").animate({
                        opacity: "show"
                    }, 500);

                    $("div.search-panel-body").stop().slideToggle(500);
                })
            })
        </script>
    @endif
@endsection

@section('head')
    <script src="/js/libs/select2.js"></script>
    <link href="/css/libs/select2.css" rel="stylesheet" />
@endsection