<!DOCTYPE html>
<html>
<head>
    <title>Laraeval - Fatal Error</title>
<body>
    <div id="profiler" style="color: #c60000; display:none;">
        <h4>No data for profiler</h4>
    </div>
    
    <div id="output">
        <h4 style="color:#c60000">{{ $output }}</h4>
    </div>
    @include('laraeval::javascript.iframe-output-js')
</body>
</html>
