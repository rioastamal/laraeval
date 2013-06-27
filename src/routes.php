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
    return View::make('laraeval::form-code', $data);
});

// Let's eval the code
Route::post('laraeval', array('as' => 'laraeval-main', function() {
    $post = Input::get();
    $laraeval = new Laraeval($post['code']);
    $output = $laraeval->execute();
    
    if (strlen($output) === 0) {
        $output = 'Code produces no output.';
    }
    
    $data = array(
        'code' => $post['code'],
        'output' => $output
    );
    return View::make('laraeval::form-code', $data);
}));
