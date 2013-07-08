<!DOCTYPE html>
<html>
<head>
    <title>Laraeval - Fatal Error</title>
    <style>
        * {
            padding: 0; margin: 0;
        }
        body {
          background: #202020;
          font-size: 14px;
          color: #999;
          padding-top: 20px;
          padding-left: 5px;
          font-family: Monaco, Menlo, "Andale Mono", "lucida console", "Courier New", monospace;
          line-height: 15px;
          width: 99%;
        }
        #profiler {
            display: none;
        }
        h1, h2, h3, h4 {
            margin: 10px 2px 10px 0;
            border-bottom: 1px dashed #666;
            padding-bottom: 4px;
        }
        p {
            margin: 8px 4px;
        }
    </style>
<body>
    <div id="profiler" style="display:none;">
        <h4>No data for profiler</h4>
    </div>

    <div id="output">
        <h3>Error (Line: {{ $line }})</h4>
        <p>{{ $message }}</p>
    </div>
    @include('laraeval::javascript.iframe-output-js')
</body>
</html>
