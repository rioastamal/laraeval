<!DOCTYPE html>
<html>
<head>
    <title>Laraeval - Output</title>
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
        }
        #profiler {
            display: none;
        }
        #profiler p {
            border-bottom: 1px dashed #666;
            margin-bottom: 10px;
            padding-bottom: 2px;
        }
        #output {
          white-space: pre;
        }
    </style>
</head>
<body>
@if (Input::get('code')) 
    <div id="profiler">
        <p>Code Execution Time: {{ sprintf("<strong>%f</strong> %s", $exectime['time'], $exectime['short_format']) }}</p>
        <p>Memory Usage: {{ sprintf("<strong>%s</strong> %s", $memory['usage'], "MB") }}</p>
        <p>Memory Peak: {{ sprintf("<strong>%s</strong> %s", $memory['peak'], "MB") }}</p>
        <p><?php print_r($queries); ?></p>
    </div>
    
    <div id="output" tabindex="0">{{ $output }}</div>
@endif 
<script>
    window.onload = function() {
        window.parent.showOutput();
        document.getElementById('output').focus();
    }

    function showOutput() {
        document.getElementById('profiler').style.display = 'none';
        document.getElementById('output').style.display = 'block';
    }

    function showProfiler() {
        document.getElementById('profiler').style.display = 'block';
        document.getElementById('output').style.display = 'none';
    }
    
    window.onkeydown = function(e) {
        charCode = e.which ? e.which : e.keyCode;
        console.log(charCode);

        // catch CTRL + comma
        if (e.ctrlKey && charCode == 188) {
            // show output window
            window.parent.showCode();
            window.parent.editor.focus();
        }
        // catch CTRL + semicolon
        if (e.ctrlKey && charCode == 59) {
            // show output window
            window.parent.showProfiler();
        }
    }
</script>
</body>
</html>
