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
    // catch all error
    App::error(function(Exception $e, $code) {
        $error = array(
            'line' => $e->getLine(),
            'message' => $e->getMessage()
        );

        ob_end_clean();
        
        // return it to fatal view
        return Response::make( View::make('laraeval::fatal-output', $error), 500 );
    });
    
    $laraeval = new Laraeval();
    try {
        $output = $laraeval->execute( Input::get('code') );
    } catch (PDOException $e) {
        // Errors from PDOException i.e. wrong database credential, SQL Query errors, etc
        // are not catchable by PHP parser so function error_get_last() return NULL
        //
        // So, we're getting the error message from the thrown PDOException
        $error = array(
            'message' => $e->getMessage(),
            'line' => '?'
        );

        ob_end_clean();

        // Fatal Error View
        return Response::make( View::make('laraeval::fatal-output', $error), 500 );
    } catch (Exception $e) {
        // just return empty, let the App::error() above handle the error
        return '';
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
