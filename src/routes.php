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
// CTRL+SHIFT+. for switching to profiler window
CODE;

    $data = array(
        'code' => $default_code,
        'output' => ''
    );
    return View::make('laraeval::code-editor', $data);
});

// Let's eval the code
Route::post('laraeval', array('as' => 'laraeval-main', function() {
    $laraeval = new Laraeval();
    try {
        $output = $laraeval->execute( Input::get('code') );
    } catch (Exception $e) {
        // Oops something bad happens,
        return sprintf('<span style="color:#c60000;">%s</span>', $e->getMessage());
    }

    $data = array(
        'output' => $output,
        'exectime' => $laraeval->getExecTime(),
        'memory' => array(
                'usage' => $laraeval->getMemoryUsage(),
                'peak' => $laraeval->getMemoryUsage('peak')
        ),
        'queries' => $laraeval->getQueries()
    );

    return View::make('laraeval::iframe-output', $data);
}));
