const maxNumPhotos = 4;

$(function() {
    var CSRFToken = $('form.book-request-form input[name="_token"]').attr('value');
    var bookID = $('form.book-request-form input[name="_bookID"]').attr('value');


    /**********************************************************************
     *                               Select 2
     **********************************************************************/
    $("#instructor_list").select2({
        placeholder: "Select all the instructors who use this book",
        selectOnClose: true,
        minimumInputLength: 2
    });

    $("#course_list").select2({
        placeholder: "Select all the courses which use this book",
        selectOnClose: true,
        minimumInputLength: 2
    });

    $("#author_list").select2({
        placeholder: "Select or add all the authors of this book",
        tags: true,
        selectOnClose: true,
        minimumInputLength: 2
    });



    /**********************************************************************
     *                               Date Picker
     **********************************************************************/
    $("input.available_by").datepicker({
        format: 'mm/dd/yyyy',
        minDate: 'd'
    });



    /**********************************************************************
     *                        Delete Book AJAX
     **********************************************************************/
    $('a.delete-book').on('click', function(){

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
            showLoaderOnConfirm: true
        }, function(isConfirm){
            if (isConfirm) {
                $.ajax({
                    url: "/books/" + bookID,
                    type: "DELETE",
                    data: {_token : CSRFToken}
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
                        text: "Something went wrong. Please try again. If the problem persist do not hesitate to contact us at support@connectedut.com.",
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



    /**********************************************************************
     *                        List/Unlist Book AJAX
     **********************************************************************/
    $('div.list-it-btn').on('click', function(){
        $.ajax({
            url: "/books/" + bookID + '/status',
            type: "PUT",
            data: {_token : CSRFToken}
        }).done(function(xhr){
            var msg = (xhr.bookStatus == 1) ? "Listed!" : "Unlisted!";
            swal({
                title: msg,
                text: "Your book has been successfully " + msg + " You can access it under Your Account -> My books",
                type: "success",
                confirmButtonText: "Got it!",
                closeOnConfirm: false
            }, function() {
                window.location.replace("/account/mybooks");
            });
        }).fail(function(xhr){
            var msg = (xhr.bookStatus == 1) ? "Unlisting" : "Listing";
            if(xhr.status == 400)
            {
                swal({
                    title: msg + " Failed!",
                    text: "Please fill out all the required (indicated with * ) fields before listing the book.",
                    type: "error",
                    closeOnConfirm: true,
                    confirmButtonText: "Got it!"
                });
            }
            else
            {
                swal({
                    title: msg + " Failed!",
                    text: "Something went wrong. Please try again. If the problem persist do not hesitate to contact us at support@connectedut.com.",
                    type: "error"
                });
            }
        });
    });


    /**********************************************************************
     *                       Update Form Fields AJAX
     **********************************************************************/
    $('.item-info').on('change', function(){
        var $this = $(this);
        var fieldName = $this.attr('name');
        var fieldValue = null;

        if($this.attr('type') == 'checkbox')
            fieldValue = ($this.prop('checked'))? 1 : 0;
        else
            fieldValue = $this.val();

        var data = {
            _token : CSRFToken
        };

        data[fieldName] = fieldValue;

        console.log(data);
        updateBookInfo(data, bookID, $this);
    });



    /**********************************************************************
     *                      Upload Photo (Drop Zone)
     **********************************************************************/
    var previewTemplate = $('div.preview-template').html();
    var photoUploaderDiv = $("div.photo-uploader");
    var photoPrevDiv = $('div.photo-preview');

    var dzDefMessage = "Drop files here <br /> or click to upload";
    if( /Android|webOS|iPhone|iPad|iPod|BlackBerry|IEMobile|Opera Mini/i.test(navigator.userAgent) )
        dzDefMessage = "Tap here to upload";

    letMorePhotoUpload(photoUploaderDiv, $('div.photo-prev-box').length - 1);

    Dropzone.autoDiscover = false;
    photoUploaderDiv.dropzone({
        url: "/books/" + bookID + "/update/photo",
        method: "post",
        paramName: "photo",
        headers: { 'X-CSRF-TOKEN': CSRFToken },
        maxFilesize: 4,
        dictFileTooBig: "Image must be smaller than 4MB.",
        dictMaxFilesExceeded: "A book cannot have more than 4 photos.",
        uploadMultiple: false,
        parallelUploads: 1,
        addRemoveLinks: false,
        dictRemoveFile: 'Remove',
        acceptedFiles: "image/jpeg, image/png, image/jpg",
        dictInvalidFileType: "Use only .jpeg, .jpg and/or .png image types.",
        previewsContainer: "div.photo-preview",
        thumbnailWidth: 150,
        thumbnailHeight: 150,
        previewTemplate: previewTemplate,
        dictDefaultMessage: "<i class='fa fa-plus-square-o fa-4x photo-add-square'></i>" + dzDefMessage,
        success: function (file, response) {
            var $this = $(file.previewElement);
            var infoDiv = $this.find('div.thumb-prev-info');
            infoDiv.show();
            var mainPhotoRadio = infoDiv.find('input.main-photo');
            mainPhotoRadio.attr('value', response.photo.id);
            if(response.photo.isMain)
                mainPhotoRadio.attr('checked', 'checked');
            infoDiv.find('div.delete-photo').attr('data-photo-id', response.photo.id);
            letMorePhotoUpload(photoUploaderDiv, response.photoCount);
        },
        error: function (file, response, xhr) {
            var $this = $(file.previewElement);
            $this.find('img.thumb-prev-photo').css('opacity', '0.5');
            var errorDiv = $this.find('div.thumb-prev-error');
            errorDiv.show();
            var errorMessage = 2;
            if(xhr && xhr.status == 422)
                errorMessage = response.photo[0];
            else if(xhr)
                errorMessage = response.message;
            else
                errorMessage = response;
            errorDiv.children('div.alert').html('<b>Upload failed!</b> ' + errorMessage);
        },
        complete: function (file) {
            $(file.previewElement).find('div.thumb-prev-upload').hide();
        }
    });



    /**********************************************************************
     *                          Delete Photo AJAX
     **********************************************************************/
    photoPrevDiv.on('click', 'div.delete-photo', function(){
        var $this = $(this);
        var photoID = $this.attr('data-photo-id');

        swal({
            title: "Are you sure?",
            text: "It will be permanently deleted!",
            type: "warning",
            showCancelButton: true,
            confirmButtonColor: "#DD6B55",
            confirmButtonText: "Yes, delete it!",
            cancelButtonText: "No, cancel!",
            closeOnConfirm: false,
            closeOnCancel: true,
            showLoaderOnConfirm: true
        }, function(isConfirm){
            if (isConfirm) {
                $.ajax({
                    url: "/books/" + bookID + "/photo",
                    type: "DELETE",
                    data: {
                        _token : CSRFToken,
                        photoID : photoID
                    }
                }).done(function(xhr){
                    console.log(xhr.photoCount);
                    letMorePhotoUpload(photoUploaderDiv, xhr.photoCount);

                    if(xhr.mainPhotoID != null)
                        $("div.photo-preview input[value='" + xhr.mainPhotoID + "']").attr('checked', 'checked');

                    $this.parents('div.photo-prev-box').hide();
                    swal({
                        title: "Deleted!",
                        text: "The photo has been deleted successfully.",
                        type: "success",
                        timer: 500,
                        allowOutsideClick: true
                    });
                }).fail(function(xhr){
                    console.log(xhr.responseText);
                    swal({
                        title: "Deletion Failed!",
                        text: "Something went wrong. Please try again. If the problem persist do not hesitate to contact us at support@connectedut.com.",
                        type: "error"
                    });
                });
            }
        });
    });



    /**********************************************************************
     *                          Update Main Photo
     **********************************************************************/
    photoPrevDiv.on('change', 'input.main-photo', function(){
        var $this = $(this);
        var data = {
            _token: CSRFToken,
            mainPhotoID: $this.attr('value')
        };

        updateBookInfo(data, bookID, $this);
    });
});

/**********************************************************************
 *                          Helper Functions
 **********************************************************************/
function updateBookInfo(data, bookID, $this)
{
    $.ajax({
        url: "/books/" + bookID + "/update",
        type: "PUT",
        data: data,
        dataType: "json",
        beforeSend: function(){
            stopFailureNotifier($this);
            stopSuccessNotifier($this);
            notifyProgress($this);
        }
    }).done(function(){
        stopProgressNotifier($this);
        notifySuccess($this);
    }).fail(function(xhr){
        stopProgressNotifier($this);
        notifyFailure($this, xhr.responseJSON[Object.keys(xhr.responseJSON)[0]][0]);
    });
}

function notifySuccess($this)
{
    $this.parents('div.form-group').addClass('has-success has-feedback');
    $this.after('<span class="glyphicon glyphicon-ok form-control-feedback" aria-hidden="true"></span>');
}

function notifyProgress($this)
{
    $this.parents('div.form-group').addClass('has-feedback');
    $this.after('<span class="form-control-feedback" aria-hidden="true"><i class="fa fa-spinner fa-pulse" aria-hidden="true"></i></span>');
}

function stopProgressNotifier($this)
{
    $this.parents('div.form-group').removeClass('has-feedback');
    $this.siblings("span.form-control-feedback").remove();
}

function stopSuccessNotifier($this)
{
    $this.parents('div.form-group').removeClass('has-success has-feedback');
    $this.siblings("span.form-control-feedback").remove();
}

function notifyFailure($this, msg)
{
    $this.parents('div.form-group').addClass('has-error has-feedback');

    console.log($this.parents('div.input-group').length > 0);
    if($this.parents('div.input-group').length > 0) {
        $this.after('<span class="glyphicon glyphicon-remove form-control-feedback" aria-hidden="true"></span>');
        $this.parents('div.input-group').after('<div class="help-block with-errors">' + msg + '</div>');
    }
    else{
        $this.after('<span class="glyphicon glyphicon-remove form-control-feedback" aria-hidden="true"></span>' +
            '<div class="help-block with-errors">' + msg + '</div>');
    }
}

function stopFailureNotifier($this)
{
    $this.parents('div.form-group').removeClass('has-error has-feedback');
    $this.siblings("span.form-control-feedback, div.help-block").remove();
    $this.parents('div.input-group').siblings("div.help-block").remove();
}

function letMorePhotoUpload(photoUploader, photoCount)
{
    // Check if abigale to upload more photo, -1 because of dz template
    if(photoCount >= maxNumPhotos)
        photoUploader.hide();
    else
        photoUploader.show();
}