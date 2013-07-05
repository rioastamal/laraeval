<script>
    window.onload = function() {
        window.parent.showOutput();
        window.parent.hideProgress();
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
