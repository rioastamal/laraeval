<!DOCTYPE html>
<html>
<head>
    <title>Laraeval - Eval the PHP script</title>
    <link rel="stylesheet" href="{{ asset('packages/astasoft/laraeval/codemirror/lib/codemirror.css') }}" />
    <link rel="stylesheet" href="{{ asset('packages/astasoft/laraeval/codemirror/theme/ambiance.css') }}" />
    <script src="{{ asset('packages/astasoft/laraeval/codemirror/lib/codemirror.js') }}"></script>
    <script src="{{ asset('packages/astasoft/laraeval/codemirror/addon/edit/matchbrackets.js') }}"></script>
    <script src="{{ asset('packages/astasoft/laraeval/codemirror/mode/clike/clike.js') }}"></script>
    <script src="{{ asset('packages/astasoft/laraeval/codemirror/mode/php/php.js') }}"></script>
    <style type="text/css">
    .CodeMirror-fullscreen {
      display: block;
      position: absolute;
      top: 0; left: 0;
      width: 100%;
      z-index: 999;
    }
    #switcher {
        height: 30px;
        z-index: 9999;
        position: absolute;
        top: 0; right: 0;
        background: transparent;
        width: 110px;
        overflow: hidden;
        font-size: 12px;
    }
    #output {
      display: none;
      position: absolute;
      top: 0; left: 0;
      width: 100%;
      z-index: 1000;
      background: #202020;
      font-size: 12px;
      color: #999;
      overflow: auto;
    }
    #output #output_iframe {
        position: absolute;
        top: 0; left: 0;
        border: none;
        width: 100%;
        height: 100%;
        min-height: 100%;
    }
    #switcher ul {
        position: absolute;
        width: 100%;
        display: inline;
        right: 0;
        top: -5px;
        font-family: Monaco, Menlo,"Andale Mono","lucida console","Courier New",monospace !important;
    }
    #switcher ul li {
        float: left;
        list-style-type: none;
        margin-right: 8px;
    }
    #switcher ul li a {
        padding-bottom: 2px;
        text-decoration: none;
        color: #666;
    }
    #switcher ul li a.active {
        border-bottom: 3px solid #333;
    }
    #switcher ul li a:hover {
        border-bottom: 3px solid #999;
        color: #999;
    }
    #switcher ul li a.last {
        margin-right: 0;
    }
    </style>
</head>
<body>
    @yield('content')
</body>
</html>
