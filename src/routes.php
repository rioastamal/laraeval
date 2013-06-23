<?php
/*
|--------------------------------------------------------------------------
| Laraeval Routes
|--------------------------------------------------------------------------
|
*/

// Main page for entering the code
Route::get('laraeval', function() {
	$data = array(
		'code' => '// enter your code here',
		'output' => ''
	);
	return View::make('laraeval::form-code', $data);
});

// Let's eval the code
Route::post('laraeval', array('as' => 'laraeval-main', function() {
	$post = Input::get();
	
	// start output buffering so we can catch the output of the code
	ob_start();
	eval($post['code']);
	$output = ob_get_contents();
	ob_end_clean();
	
	if (strlen($output) === 0) {
		$output = 'Code produces no output.';
	}
	
	$data = array(
		'code' => $post['code'],
		'output' => $output
	);
	return View::make('laraeval::form-code', $data);
}));
