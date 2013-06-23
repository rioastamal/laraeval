@extends('laraeval::master')

@section('content')
	<form action="{{ URL::route('laraeval-main') }}" method="post">
		<textarea style="width:99%;height:300px;" name="code">{{{ $code }}}</textarea><br/>
		<input type="submit" name="laravel_submit" value="Eval the code"/>
	</form>
	
	@if (Input::get('laravel_submit'))
		@if (strlen($output) > 0)
			<h4>Output:</h4><pre>{{{ $output }}}</pre>
		@else
			<h4>Output:</h4><pre>{{{ $output }}}</pre>
		@endif
	@endif
@stop
