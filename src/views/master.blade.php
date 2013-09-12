<!DOCTYPE html>
<html>
<head>
    <title>Laraeval - Eval the PHP script</title>
    <link rel="stylesheet" href="{{ asset('packages/laraeval/laraeval/codemirror/lib/codemirror.css') }}" />
    <link rel="stylesheet" href="{{ asset('packages/laraeval/laraeval/codemirror/theme/ambiance.css') }}" />
    <script src="{{ asset('packages/laraeval/laraeval/codemirror/lib/codemirror.js') }}"></script>
    <script src="{{ asset('packages/laraeval/laraeval/codemirror/addon/edit/matchbrackets.js') }}"></script>
    <script src="{{ asset('packages/laraeval/laraeval/codemirror/mode/clike/clike.js') }}"></script>
    <script src="{{ asset('packages/laraeval/laraeval/codemirror/mode/php/php.js') }}"></script>
    <style type="text/css">
    .CodeMirror-fullscreen {
      display: block;
      position: absolute;
      top: 0; left: 0;
      width: 100%;
      z-index: 999;
    }
    body {
        font-family: Monaco, Menlo,"Andale Mono","lucida console","Courier New",monospace !important;
    }
    #switcher {
        height: 30px;
        z-index: 9999;
        position: absolute;
        top: 0; right: 14px;
        background: transparent;
        width: 208px;
        overflow: hidden;
        font-size: 12px;
    }
    #output, #storage {
      display: none;
      position: absolute;
      top: 0; left: 0;
      width: 100%;
      z-index: 1000;
      background: #202020;
      font-size: 12px;
      color: #999;
      overflow-y: none;
    }
    #output #output_iframe {
        position: absolute;
        top: 10px; left: 0;
        border: none;
        width: 100%;
        height: 98%;
        min-height: 98%;
    }
    #switcher ul {
        position: absolute;
        width: 100%;
        display: inline;
        right: 0;
        top: -5px;
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
        color: #f1f1f1;
    }
    #switcher ul li a:hover {
        border-bottom: 3px solid #999;
        color: #999;
    }
    #switcher ul li a.last {
        margin-right: 0;
    }
    #progress {
        position: absolute;
        z-index: 11000;
        right: 0; bottom: 0;
        padding: 2px 10px;
        background: #c60000;
        color: #fff;
        display: none;
    }
    #storage {
        padding: 8px;
        overflow-y: none;
        overflow-x: auto;
        min-height: 100%;
        height: 100%;
    }
    #storage h1, h2, h3 {
        font-size: 200%;
        margin: 0;
        padding: 0;
        font-family: Tahoma, Arial, Monospace;
    }
    #storage form {
        margin-bottom: 2em;
    }
    #storage p {
        line-height: 20px;
        width: 92%;
    }
    #storage form input {
        border: 1px solid #333;
        background: #666;
        font-size: 110%;
        padding: 4px;
        width: 30%;
    }
    #storage a, #storage a:visited {
        text-decoration: none;
        color: #666;
        padding: 4px;
    }
    #storage a:hover {
        text-decoration: underline;
        color: #999;
    }
    #storage #storage-list li {
        padding-bottom: 8px;
    }
    </style>
</head>
<body>
    @yield('content')
</body>
</html>
