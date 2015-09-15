@if(session('flash_message'))
    <div class="alert alert-success {{ session('flash_message_important') ? 'alert-important' : '' }}">
        @if(session('flash_message_important'))
            <button type="button" data-dismiss="alert" aria-hidden="true" class="close">&times;</button>
        @endif

        {{--{{ Session::get('flash_message') }}--}}
        {{ session('flash_message') }}
    </div>
@endif

@section('script')
<script>
        $('div.alert').not('.alert-important').delay({{ $delay }}).slideUp(300);
</script>
@endsection