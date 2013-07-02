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
          font-size: 12px;
          color: #999;
          white-space: pre;
          padding-top: 20px;
          padding-left: 5px;
        }
    </style>
</head>
<body>
@if (Input::get('code'))
{{ $output }}
<script>window.parent.showOutput()</script>
@endif
</body>
</html>
