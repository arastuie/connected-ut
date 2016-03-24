@extends('master')

@section('content')

    @include('errors._list')



        <div class="row">
            {{--  First and last name  --}}
            <div class="profile-col col-xs-offset-1 col-xs-10 col-sm-offset-3 col-sm-6 col-md-offset-1 col-md-4">
                <div class="row">
                    <div class="col-sm-12 col-xs-12 card-title">
                        Profile
                    </div>

                    <div class="card-info">
                        <div class="col-xs-10 col-sm-10 card-content">
                            @if($user['firstname'] == null)
                                Add your name
                            @else
                                {{ $user['firstname'] . ' ' . $user['lastname']}}
                            @endif
                        </div>

                        <div class="col-xs-2 col-sm-2 edit-options">
                            <a class="card-edit-btn btn btn-link">Edit</a>
                        </div>
                    </div>

                    <div class="card-form col-sm-12 hidden">
                        <div class="row">
                            {!! Form::model($user, ['method' => 'PUT', 'action' => ['UsersController@updateInfo'], 'class' => '']) !!}
                            <div class="col-xs-7 col-sm-4 col-md-7 col-lg-4">
                                {!! Form::text('firstname', null, ['class' => 'under-line name', 'placeholder' => 'Firstname']) !!}
                            </div>
                            <div class="col-xs-7 col-sm-4 col-md-7 col-lg-4">
                                {!! Form::text('lastname', null, ['class' => 'under-line name', 'placeholder' => 'Lastname']) !!}
                            </div>

                            <div class="col-xs-2 col-sm-2 edit-options">
                                {!! Form::submit("Update", ['class' => 'btn btn-link']) !!}
                            </div>

                            <div class="col-xs-2 col-sm-2 edit-options">
                                <a class="form-cancel-btn btn btn-link">Cancel</a>
                            </div>
                            {!! Form::close() !!}
                        </div>

                    </div>

                    <div class="col-xs-12 col-sm-12 little-info">
                        {{ $user['email'] }}
                    </div>

                    <div class="col-xs-12 col-sm-12 little-info">
                        Member since {{ $user['created_at'] }}
                    </div>
                </div>
            </div>

            {{--  Email address  --}}
            <div class="profile-col col-xs-offset-1 col-xs-10 col-sm-offset-3 col-sm-6 col-md-offset-1 col-md-4 border">
                <div class="row">
                    <div class="col-sm-12 col-xs-12 card-title">
                        Email
                    </div>

                    <div class="card-info">
                        <div class="col-xs-10 col-sm-10">
                            <div class="row">
                                <div class="col-xs-12 col-sm-12 card-content-email">
                                    {{ $user['contact_email'] }}
                                </div>

                                <div class="col-xs-12 col-sm-12 option-info">
                                    @if($user['use_email'])
                                        Will show as seller contact info.
                                    @else
                                        Will not show as seller contact info.
                                    @endif
                                </div>
                            </div>
                        </div>

                        <div class="col-xs-2 col-sm-2 edit-options">
                            <a class="card-edit-btn btn btn-link">Edit</a>
                        </div>
                    </div>

                    <div class="card-form col-sm-12 hidden">
                        <div class="row">
                            {!! Form::model($user, ['method' => 'PUT', 'action' => ['UsersController@updateInfo'], 'class' => '']) !!}
                            <div class="col-xs-8 col-sm-8">
                                <div class="row">
                                    <div class="col-xs-12 col-sm-12">
                                        {!! Form::email('contact_email', null, ['class' => 'under-line email', 'placeholder' => 'Email address']) !!}
                                    </div>

                                    <div class="col-xs-12 col-sm-12 use-option">
                                        {!! Form::checkbox('use_email', 1, null) !!}
                                        List this as my contact info
                                    </div>
                                </div>
                            </div>

                            <div class="col-xs-2 col-sm-2 edit-options">
                                {!! Form::submit("Update", ['class' => 'btn btn-link']) !!}
                            </div>

                            <div class="col-xs-2 col-sm-2 edit-options">
                                <a class="form-cancel-btn btn btn-link">Cancel</a>
                            </div>
                            {!! Form::close() !!}
                        </div>
                    </div>

                    <div class="col-xs-12 col-sm-12 little-info">
                        Primary email for contact info
                    </div>
                </div>
            </div>

        </div>

        <div class="row">
            {{--  Phone number  --}}
            <div class="profile-col col-xs-offset-1 col-xs-10 col-sm-offset-3 col-sm-6 col-md-offset-1 col-md-4 border">
                <div class="row">
                    <div class="col-sm-12 col-xs-12 card-title">
                        Phone
                    </div>

                    <div class="card-info">

                        <div class="col-xs-10 col-sm-10">
                            <div class="row">
                                <div class="col-xs-12 col-sm-12 card-content-email">
                                    @if($user['phone_number'] == null)
                                        Add your phone number
                                    @else
                                        {{ $user['phone_number'] }}
                                    @endif
                                </div>

                                @if($user['phone_number'] != null)
                                    <div class="col-xs-12 col-sm-12 option-info">
                                        @if($user['use_phone'])
                                            Will show as seller contact info.
                                        @else
                                            Will not show as seller contact info.
                                        @endif
                                    </div>
                                @endif
                            </div>
                        </div>

                        <div class="col-xs-2 col-sm-2 edit-options">
                            <a class="card-edit-btn btn btn-link">Edit</a>
                        </div>
                    </div>

                    <div class="card-form col-sm-12 hidden">
                        <div class="row">
                            {!! Form::model($user, ['method' => 'PUT', 'action' => ['UsersController@updateInfo'], 'class' => '']) !!}

                            <div class="col-xs-8 col-sm-8">
                                <div class="row">
                                    <div class="col-xs-12 col-sm-12">
                                        {!! Form::text('phone_number', null, ['class' => 'under-line phone-number', 'placeholder' => '(999) 999-9999']) !!}
                                    </div>

                                    <div class="col-xs-12 col-sm-12 use-option">
                                        {!! Form::checkbox('use_phone', 1, null) !!}
                                        List this as my contact info
                                    </div>
                                </div>
                            </div>


                            <div class="col-xs-2 col-sm-2 edit-options">
                                {!! Form::submit("Update", ['class' => 'btn btn-link']) !!}
                            </div>

                            <div class="col-xs-2 col-sm-2 edit-options">
                                <a class="form-cancel-btn btn btn-link">Cancel</a>
                            </div>
                            {!! Form::close() !!}
                        </div>

                    </div>

                    <div class="col-xs-12 col-sm-12 little-info">
                        Primary phone number for contact info
                    </div>
                </div>
            </div>

            {{--  Departments --}}
            <div class="profile-col col-xs-offset-1 col-xs-10 col-sm-offset-3 col-sm-6 col-md-offset-1 col-md-4 border">
                <div class="row">
                    <div class="col-sm-12 col-xs-12 card-title">
                        Departments
                    </div>

                    <div class="card-info">
                        <div class="col-xs-10 col-sm-10 ">
                            <div class="row">
                                @if(count($user['department_list']) <= 0)
                                    <div class="col-xs-12 col-sm-12 card-content-email">
                                        Add a department you are involved with
                                    </div>
                                @else
                                    @foreach($user['department_list'] as $department)
                                        <div class="col-xs-12 col-sm-12 card-content-email">
                                            {{ $department }}
                                        </div>
                                    @endforeach
                                @endif
                            </div>
                        </div>

                        <div class="col-xs-2 col-sm-2 edit-options">
                            <a class="card-edit-btn btn btn-link">Edit</a>
                        </div>
                    </div>

                    <div class="card-form col-sm-12 hidden">
                        <div class="row">
                            {!! Form::model($userModel = Auth::user(), ['method' => 'PUT', 'action' => ['UsersController@updateInfo'], 'class' => '']) !!}

                            <div class="col-xs-8 col-sm-8">
                                {!! Form::select('department_list[]', $departments, null, ['id' => 'department_list', 'style' => 'width: 100%', 'multiple']) !!}
                            </div>

                            <div class="col-xs-2 col-sm-2 edit-options">
                                {!! Form::submit("Update", ['class' => 'btn btn-link']) !!}
                            </div>

                            <div class="col-xs-2 col-sm-2 edit-options">
                                <a class="form-cancel-btn btn btn-link">Cancel</a>
                            </div>
                            {!! Form::close() !!}
                        </div>

                    </div>

                    <div class="col-xs-12 col-sm-12 little-info">
                        Your departments
                    </div>
                </div>
            </div>
        </div>


@endsection

@section('style')
    <style>
        div.profile-col{
            font-weight: lighter;
            padding: 15px;
            border: 1px solid #CCC;
            box-shadow: 1px 2px 3px #ECECEC;
            margin-top: 20px;
            margin-bottom: 20px;
        }

        div.card-title{
            font-size: 30px;
            margin-bottom: 10px;
        }

        div.profile-col .card-content{
            font-size: 20px;
            height: 36px;
        }

        div.little-info{
            font-size: 14px;
            margin-top: 15px;
        }

        div.edit-options{
            padding: 0;
        }

        a.edit-btn:hover{
            cursor: pointer;
        }

        div.card-form{
            margin-bottom: 10px;
        }
        
        input.under-line{
            border: 0;
            border-bottom: 1px solid #999;

            width: 100%;
            height: 34px;
        }

        input.under-line:focus{
            outline: none;
            border-bottom: 1px solid #000;
        }

        input.name{
            font-size: 18px;
        }

        input.email{
            font-size: 15px;
        }

        div.card-content-email{
            font-size: 16px;
        }

        div.use-option{
            margin-top: 10px;
        }

        div.option-info{
            margin-top: 5px;
        }
    </style>
@endsection

@section('script')
    <script>
        $(function(){
            $('a.card-edit-btn').on('click', function(){
                var parent = $(this).parents('div.card-info');
                parent.addClass('hidden');
                parent.siblings('div.card-form').removeClass('hidden');
            });

            $('a.form-cancel-btn').on('click', function(){
                var parent = $(this).parents('div.card-form');
                parent.addClass('hidden');
                parent.siblings('div.card-info').removeClass('hidden');
            });

            $("input.phone-number").mask("(999) 999-9999");

            $("#department_list").select2({
                placeholder: "Select your departments",
                tags: true
            });
        });
    </script>
@endsection

@section('head')
    <script src="/js/libs/jquery.maskedinput.min.js" type="text/javascript"></script>
    <script src="/js/libs/select2.js"></script>
    <link href="/css/libs/select2.css" rel="stylesheet" />
@endsection