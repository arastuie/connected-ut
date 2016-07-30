// Select 2 tags
$("#instructor_list").select2({
    placeholder: "Select all the instructors who use this book",
    allowClear: true,
    selectOnClose: true,
    minimumInputLength: 2
});

$("#course_list").select2({
    placeholder: "Select all the courses which use this book",
    allowClear: true,
    selectOnClose: true,
    minimumInputLength: 2
});

$("#author_list").select2({
    placeholder: "Select or add all the authors of this book",
    tags: true,
    allowClear: true,
    selectOnClose: true,
    minimumInputLength: 2
});

// Date picker
$(function() {
    $("input.available_by").datepicker({
        format: 'mm/dd/yyyy',
        minDate: 'd'
    });
});

// Delete book confirmation box
$(function() {
    $('a.delete-book').on('click', function(){
        var token = $(this).attr('data-token');
        var bookID = $(this).attr('data-book');

        swal({
            title: "Are you sure?",
            text: "It will be permanently deleted!",
            type: "warning",
            showCancelButton: true,
            confirmButtonColor: "#DD6B55",
            confirmButtonText: "Yes, delete it!",
            cancelButtonText: "No, cancel!",
            closeOnConfirm: false,
            closeOnCancel: false,
            showLoaderOnConfirm: true,
        }, function(isConfirm){
            if (isConfirm) {
                $.ajax({
                    url: "/books/" + bookID,
                    type: "DELETE",
                    data: {_token : token},
                }).done(function(){
                    swal({
                        title: "Deleted!",
                        text: "Your book has been successfully deleted.",
                        type: "success",
                        timer: 1500,
                        allowOutsideClick: true
                    });
                    setTimeout(function(){
                        window.location.replace("/account/mybooks");
                    }, 1500);
                }).fail(function(){
                    swal({
                        title: "Deletion Failed!",
                        text: "Something went wrong. Please try again. If the problem persist do not hesitate to contact us.",
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


// Photo selection
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
