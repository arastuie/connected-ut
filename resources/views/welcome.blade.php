@extends('master')

@section('content')

	<h2>Search Result</h2>
	<ul class="list-group">
		@foreach($results as $actor)
			<li class="list-group-item">{{ $actor['name'] }}</li>
		@endforeach
	</ul>
@endsection