<?php
/*
|--------------------------------------------------------------------------
| Laraeval Routes
|--------------------------------------------------------------------------
|
*/

// Main page for entering the code
Route::get('laraeval', function() {
    $default_code = <<<CODE
// Laraeval Shortcut
// -----------------
// CTRL+ENTER for executing the code
// CTRL+, for switching to code window
// CTRL+. for switching to output window
CODE;

    $data = array(
        'code' => $default_code,
        'output' => ''
    );
    return View::make('laraeval::code-editor', $data);
});

// Let's eval the code
Route::post('laraeval', array('as' => 'laraeval-main', function() {
    $laraeval = new Laraeval(Input::get('code'));
    $output = $laraeval->execute();
    
    if (strlen($output) === 0) {
        return Response::make('Code produced no output.', '500');
    }

    $data = array(
        'output' => $output
    );

    return View::make('laraeval::iframe-output', $data);
}));
