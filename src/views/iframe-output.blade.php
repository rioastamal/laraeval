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
          white-space: pre;
          padding-top: 20px;
          padding-left: 5px;
          font-family: Monaco, Menlo, "Andale Mono", "lucida console", "Courier New", monospace;
          line-height: 15px;
        }
    </style>
</head>
<body>
@if (Input::get('code'))
<p>EXEC TIME {{ sprintf("%s %s", $exectime['time'], $exectime['format']) }}</p>
{{ $output }}
@endif
<script>
    window.parent.showOutput();
    window.onkeydown = function(e) {
        charCode = e.which ? e.which : e.keyCode;
        console.log(charCode);

        // catch CTRL + comma
        if (e.ctrlKey && charCode == 188) {
            // show output window
            window.parent.showCode();
            window.parent.editor.focus();
        }
    }
</script>
</body>
</html>
