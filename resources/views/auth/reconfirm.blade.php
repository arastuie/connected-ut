@extends('master')

@section('content')

<div class="container">
    <div class="alert alert-warning" style="text-align: center;">
        You need to confirm your email ({{ $email }}) before you login. Please go to your rocket email and confirm your email address.
        <br>
        If you did not receive an email or you want us to resend you email confirmation for any reason, <a href="#" class="alert-link resend-confirmation">click here</a>.
        <br>
        Also if you used a wrong email address, please sign up with your correct email address again.
    </div>
</div>
<input type="hidden" class="token" value="{{ csrf_token() }}">
<input type="hidden" class="email" value="{{ $email }}">
@endsection

@section('script')
    <script>
        $(function(){
            $('a.resend-confirmation').on('click', function(){
                swal({
                    title: "Confirm your password!",
                    text: "Type in your password here:",
                    type: "input",
                    showCancelButton: true,
                    closeOnConfirm: false,
                    inputPlaceholder: "Type your password",
                    inputType: "password",
                    showLoaderOnConfirm: true,
                    confirmButtonText: "Resend Email Confirmation"
                },
                function(inputValue){
                    if(inputValue === false) return false;

                    if(inputValue === "") {
                        swal.showInputError("Please type in your password!");
                        return false;
                    }

                    $.ajax({
                        url: "/auth/register/confirm/resend",
                        type: "PUT",
                        data: {
                            _token : $('input.token').val(),
                            email : $('input.email').val(),
                            password : inputValue
                        },
                        error: function (xhr, ajaxOptions, thrownError) {
                            console.log(xhr.status);
                            console.log(xhr.responseText);
                            console.log(thrownError);
                        }
                    }).done(function(){
                        swal({
                            title: "Resent!",
                            text: "Check your email and confirm your email address!",
                            type: "success",
                        }, function(isConfirm){
                            window.location.replace("/auth/login");
                        });
                    }).fail(function(){
                        swal({
                            title: "Resending Failed!",
                            text: "Something went wrong. Please try again. If the problem persist do not hesitate to contact us.",
                            type: "error"
                        });
                    });

                });
            });
        });
    </script>
@endsection