    <script>
    var storage_prefix = '<?php echo (Config::get('laraeval::localstorage_prefix')); ?>';
    var storage_id = storage_prefix + '<?php echo (Input::get('storageid', '')); ?>';
    var main_url = '<?php echo URL::route('laraeval-main') ;?>';
    
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
        if (storage_id.replace(storage_prefix, '').length == 0) {
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
        if (storage_id.replace(storage_prefix, '').length == 0) {
            return;
        }

        localStorage.setItem( storage_id, editor.getValue() );
    }

    function getStorageList() {
        var storage_list = Array();
        var key = '';
        // We need to put some variabel to match() method so we can use the RegExp object instead
        var prefix_regex = new RegExp('^' + storage_prefix);
        
        for (var i=0; i<localStorage.length; i++) {
            // check if the storage has match the laraeval storage prefix
            key = localStorage.key(i);
            if (key.match(prefix_regex) != null) {
                // remove the storage prefix from the key
                storage_list[storage_list.length] = key.replace(storage_prefix, '');
            }
        }

        return storage_list;
    }

    function loadStorageList() {
        var storages = getStorageList();
        var li = '';

        if (storages.length == 0) {
            li = '<li style="list-style: none;">There\'s no storage at the moment.</li>';
            docID('storage-list').style.marginLeft = '0';
            docID('storage-list').style.paddingLeft = '0';
        } else {
            storages.sort();
            for (var i=0; i<storages.length; i++) {
                li += '<li><a target="_blank" href="' + main_url + '?storageid=';
                li += encodeURIComponent(storages[i]) + '">' + storages[i] + '</a></li>' + "\n";
            }
        } 

        docID('storage-list').innerHTML = li;
    }
    </script>
