
        <div id="storage">
            <h3>Create New Storage</h3>
            <p>Laraeval storage is much like a file name that saved inside your browser's localstorage.
            Enter the name of the storage, i.e: 'mytest', 'playing-around', or 'anything-you-like'
            (without quotes) and then hit the ENTER key. Start typing your code and it will persist
            in the storage even after your browser is closed.</p>
            <form action="{{ URL::route('laraeval-main') }}" method="get">
                <input type="text" name="storageid" value="" id="storageid">
            </form>
            
            <h3>List of Storage</h3>
            <ol id="storage-list">
            </ol>
        </div>
