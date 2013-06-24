@extends('laraeval::master')

@section('content')
    <div id="wrapper">
        <form action="{{ URL::route('laraeval-main') }}" method="post" name="frmlaraeval">
            <textarea name="code" id="code">{{{ $code }}}</textarea>
        </form>
        <div id="output">
        @if (Input::get('code'))
            <pre>{{ $output }}</pre>
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

        if (indexPosition == -1) {
            // 1) not found
            // 2) check to see if some other class exits or not, if not we do not need to add space
            //    chararacter
            if (docID(element).className.length == 0) {
                // empty class
                space = '';
            }

            docID(element).className = docID(element).className + space + cssClass;
        }

        return docID(element);
    }

    function removeClass(element, cssClass) {
        var indexPosition = docID(element).className.indexOf(cssClass);
        var space = ' ';

        if (indexPosition == -1) {
            // no class found
            return docID(element);
        }

        if (indexPosition == 0) {
            // empty class
            space = '';
        }

        docID(element).className = docID(element).className.replace(space + cssClass, '');
    }
    
    function showOutput() {
        docID('output').style.display = 'block';
        removeClass('anchor-code', 'active');
        addClass('anchor-output', 'active');
    }

    function showCode() {
        docID('output').style.display = 'none';
        removeClass('anchor-output', 'active');
        addClass('anchor-code', 'active');
    }

    docID('anchor-output').onclick = function() {
        showOutput();
    }
    docID('anchor-code').onclick = function() {
        showCode();
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
        @if (Input::get('code')) 
        showOutput();
        @endif 
    }

    // catch the user keyboard event
    window.onkeydown = function(e) {
        // catch CTRL + ENTER event
        charCode = e.which ? e.which : e.keyCode;	// Firefox/Mozilla => keyCode
        if (e.ctrlKey && charCode == 13) {
            document.frmlaraeval.submit();
            return false;
        }
        // catch CTRL + Right Arrow
        if (e.ctrlKey && charCode == 37) {
            // show output window
            showCode();
            editor.focus();
        }
        // catch CTRL + Left Arrow
        if (e.ctrlKey && charCode == 39) {
            // show code window
            showOutput();
        }
    }
    window.onresize = function() {
        docID('output').style.height = winHeight() + "px";
    }
    </script>
@stop