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
          width: 100%;
        }
        #profiler {
            display: none;
        }
        #profiler p {
            border-bottom: 1px dashed #666;
            margin-bottom: 10px;
            padding-bottom: 2px;
        }
        #profiler p.query {
            margin-bottom: 10px;
            padding-bottom: 2px;
            width: 100%;
            border-bottom: none;
        }
        #profiler p.query span.query-time {
            float: left;
            width: 90px;
            margin-right: 12px;
            text-align: right;
        }
        #profiler p.query span.query-value {
            width: auto;
            float: left;
        }
        #output {
          white-space: pre;
        }
        .hightlight { color: #DADA05; }
        .clear { clear: both; }
    </style>
</head>
<body>
@if (Input::get('code')) 
    <div id="profiler">
        <p>Eval Execution Time: {{ sprintf("<span class=\"hightlight\">%s %s</span>", $exectime['time'], $exectime['short_format']) }}</p>
        <p>Memory Usage: {{ sprintf("<span class=\"hightlight\">%s %s</span>", $memory['usage'], "MB") }}</p>
        <p>Memory Peak: {{ sprintf("<span class=\"hightlight\">%s %s</span>", $memory['peak'], "MB") }}</p>

        @if (count($queries) === 0) 
        <p>SQL Query: <strong>No query given.</strong></p>
        @else 
                <p>SQL Query: <strong class="hightlight">{{ count($queries) }}</strong> {{ (count($queries) === 1 ? 'query' : 'queries') }} performed.</p>
                @foreach ($queries as $query) 
                <p class="query"><span class="query-time hightlight">{{ $query['time'] }} ms</span><span class="query-value">{{ $query['query'] }}</span></p>
                <div class="clear"></div>
                @endforeach 
        @endif 
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
        // catch CTRL + SHIFT + dot
        if (e.ctrlKey && e.shiftKey && charCode == 190) {
            // show profiler window
            window.parent.showProfiler();
        }
    }
</script>
</body>
</html>
