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
        removeClass('anchor-profiler', 'active');
        addClass('anchor-output', 'active');

        try {
            docID('output_iframe').contentWindow.showOutput();
        } catch (e) {
        }
    }

    function showCode() {
        docID('output').style.display = 'none';
        removeClass('anchor-output', 'active');
        removeClass('anchor-profiler', 'active');
        addClass('anchor-code', 'active');
    }

    function showProfiler() {
        docID('output').style.display = 'block';
        removeClass('anchor-code', 'active');
        removeClass('anchor-output', 'active');
        addClass('anchor-profiler', 'active');

        try {
            docID('output_iframe').contentWindow.showProfiler();
        } catch (e) {
        }
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
        editor.focus();
    }

    // catch the user keyboard event
    window.onkeydown = function(e) {
        // catch CTRL + ENTER event
        charCode = e.which ? e.which : e.keyCode;	// Firefox/Mozilla => keyCode
        if (e.ctrlKey && charCode == 13) {
            document.frmlaraeval.submit();
            return false;
        }
        // catch CTRL + comma
        if (e.ctrlKey && charCode == 188) {
            // show output window
            showCode();
            editor.focus();
        }
        // catch CTRL + dot
        if (e.ctrlKey && charCode == 190) {
            // show code window
            showOutput();
        }
        // catch CTRL + semi colon
        if (e.ctrlKey && charCode == 59) {
            // show profiler window
            showProfiler();
        }
    }
    window.onresize = function() {
        docID('output').style.height = winHeight() + "px";
    }
    </script>
