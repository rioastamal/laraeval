@extends('laraeval::master')

@section('content')
    <div id="progress">Executing...</div>
    <div id="wrapper">
        <div id="switcher">
            <ul>
                <li><a href="javascript:void(0)" class="active" id="anchor-code">Code</a></li>
                <li><a href="javascript:void(0)" class="" id="anchor-output">Output</a></li>
                <li><a href="javascript:void(0)" class="" id="anchor-profiler">Profiler</a></li>
                <li><a href="javascript:void(0)" class="last" id="anchor-storage">Storage</a></li>
            </ul>
        </div>
        
        <form action="{{ URL::route('laraeval-main') }}" method="post" name="frmlaraeval" target="output_iframe">
            <textarea name="code" id="code">{{{ $code }}}</textarea>

            @if (Input::get('storageid')) 
            <input type="hidden" name="storageid" value="{{{ Input::get('storageid') }}}">
            @endif 
        </form>
        <div id="output">
            <iframe id="output_iframe" name="output_iframe" src=""></iframe>
        </div>
    </div>
    @include('laraeval::javascript.local-storage-js') 
    @include('laraeval::javascript.main-js')
@stop
