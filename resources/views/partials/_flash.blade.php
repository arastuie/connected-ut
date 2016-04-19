@if(session('flash_type') == "success")
    <script>
        swal({
            type: "success",
            title: "{{ session('flash_title') }}",
            text: "{{ session('flash_message') }}",
            timer: 2000,
            showConfirmButton: false,
            allowOutsideClick: true
        });
    </script>

@elseif(session('flash_type') == 'error')
    <script>
        swal({
            type: "error",
            title: "{{ session('flash_title') }}",
            text: "{{ session('flash_message') }}",
            showConfirmButton: true
        });
    </script>

@elseif(session('flash_type') == 'info')
    <script>
        swal({
            type: "info",
            title: "{{ session('flash_title') }}",
            text: "{{ session('flash_message') }}",
            showConfirmButton: true,
        });
    </script>

@elseif(session('flash_type') == 'update_persoanl_info')
    <script>
        swal({
            type: "info",
            title: "{{ session('flash_title') }}",
            text: "{{ session('flash_message') }}",
            showConfirmButton: true,
            closeOnConfirmation: false,
            showCancelButton: true,
            confirmButtonText: "Take me there"
        }, function(isConfirm){
            if(isConfirm){
                window.location.href = "/account/update";
            }
        });
    </script>

@elseif(session('flash_type') == "success-important")
        <script>
            swal({
                type: "success",
                title: "{{ session('flash_title') }}",
                text: "{{ session('flash_message') }}",
            });
        </script>
@endif


<?php Session::forget('flash_type'); ?>