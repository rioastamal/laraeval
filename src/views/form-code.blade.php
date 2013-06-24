@extends('laraeval::master')

@section('content')
    <div id="wrapper">
        <form action="{{ URL::route('laraeval-main') }}" method="post">
            <textarea name="code" id="code">{{{ $code }}}</textarea>
        </form>
        <div id="output">
            hjfsdahfjsa

            fdsafkdsjfkldsf

            flsdafkldaslkf

            flkasfkljdaf

            f;sajflkjsdaf

            
        @if (Input::get('laravel_submit'))
            {{ $output }}
        @endif
        </div>
        <div id="switcher">
            <ul>
                <li><a href="javascript:void(0)" class="active" id="anchor-code">Code</a></li>
                <li><a href="javascript:void(0)" class="last" id="anchor-output">Output</a></li>
            </ul>
        </div>
    </div>
    <script>
    var editor = null;
    function docID(elementID) {
        return document.getElementById(elementID);
    }
    function addClass(element, cssClass) {
        var indexPosition = docID(element).className.indexOf(cssClass);
        var space = ' ';
        var oldClass = '';

        if (indexPosition == -1) {
            // 1) not found
            // 2) check to see if some other class exits or not, if not we do not need to add space
            //    chararacter
            if (docID(element).className.length == 0) {
                // empty class
                space = '';
            }
        } else {
            
        }
    }

    docID('anchor-output').onclick = function() {
        docID('output').style.display = 'block';
    }
    docID('anchor-code').onclick = function() {
        docID('output').style.display = 'none';
    }

    /**
     * This javascript code is taken from CodeMirror.net FullScreen Editing Mode
     */
    function isFullScreen(cm) {
      return /\bCodeMirror-fullscreen\b/.test(cm.getWrapperElement().className);
    }
    function winHeight() {
      return window.innerHeight || (document.documentElement || document.body).clientHeight;
    }
    function setFullScreen(cm, full) {
      var wrap = cm.getWrapperElement();
      if (full) {
        wrap.className += " CodeMirror-fullscreen";
        wrap.style.height = winHeight() + "px";
        document.documentElement.style.overflow = "hidden";
      } else {
        wrap.className = wrap.className.replace(" CodeMirror-fullscreen", "");
        wrap.style.height = "";
        document.documentElement.style.overflow = "";
      }
      cm.refresh();
    }
    CodeMirror.on(window, "resize", function() {
      var showing = document.body.getElementsByClassName("CodeMirror-fullscreen")[0];
      if (!showing) return;
      showing.CodeMirror.getWrapperElement().style.height = winHeight() + "px";
    });
    var editor = CodeMirror.fromTextArea(document.getElementById("code"), {
        lineNumbers: true,
        matchBrackets: true,
        mode: "text/x-php",
        indentUnit: 4,
        indentWithTabs: true,
        tabMode: "shift",
        theme: 'ambiance'
    });
    window.onload = function() {
        setFullScreen(editor, true);
        docID('output').style.height = winHeight() + "px";
    }
    </script>
@stop
