    <script>
    var storage_id = '<?php echo (Input::get('storageid', '')); ?>'
    
    // Imitate localstorage object for older browser
    //
    // Credit Mozilla:
    // ---------------
    // https://developer.mozilla.org/en-US/docs/Web/Guide/DOM/Storage
    if (!window.localStorage) {
        window.localStorage = {
            getItem: function (sKey) {
                if (!sKey || !this.hasOwnProperty(sKey)) { return null; }
                return unescape(document.cookie.replace(new RegExp("(?:^|.*;\\s*)" + escape(sKey).replace(/[\-\.\+\*]/g, "\\$&") + "\\s*\\=\\s*((?:[^;](?!;))*[^;]?).*"), "$1"));
            },
            key: function (nKeyId) {
                return unescape(document.cookie.replace(/\s*\=(?:.(?!;))*$/, "").split(/\s*\=(?:[^;](?!;))*[^;]?;\s*/)[nKeyId]);
            },
            setItem: function (sKey, sValue) {
                if(!sKey) { return; }
                document.cookie = escape(sKey) + "=" + escape(sValue) + "; expires=Tue, 19 Jan 2038 03:14:07 GMT; path=/";
                this.length = document.cookie.match(/\=/g).length;
            },
            length: 0,
            removeItem: function (sKey) {
                if (!sKey || !this.hasOwnProperty(sKey)) { return; }
                document.cookie = escape(sKey) + "=; expires=Thu, 01 Jan 1970 00:00:00 GMT; path=/";
                this.length--;
            },
            hasOwnProperty: function (sKey) {
                return (new RegExp("(?:^|;\\s*)" + escape(sKey).replace(/[\-\.\+\*]/g, "\\$&") + "\\s*\\=")).test(document.cookie);
            }
        };
        window.localStorage.length = (document.cookie.match(/\=/g) || window.localStorage).length;
    }

    /**
     * Function to open the previous state that saved into local storage object. This function
     * should be called on window onload event.
     */
    function restorePreviousContent() {
        if (storage_id.length == 0) {
            return;
        }

        if ( localStorage.getItem(storage_id) ) {
            var text = localStorage.getItem(storage_id).toString();
            if (text.length > 0) {
                editor.setValue(text);
            }
        }
    }

    function saveContent() {
        if (storage_id.length == 0) {
            return;
        }

        localStorage.setItem( storage_id, editor.getValue() );
    }
    </script>
