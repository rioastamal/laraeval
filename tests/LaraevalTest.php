<?php
/**
 * Unit testing for Laraeval model.
 *
 * Emulating PHP Fatal Error that happens inside eval is very tricky since Laravel also catching
 * that error. I didn't find any good way to that even with phpunit --proces-isolation.
 *
 * @author Rio Astamal <me@rioastamal.net>
 */
class LaraevalTest extends PHPUnit_Framework_TestCase {
    public function testLaraevalInstance() {
        $laraeval = new Laraeval();
        $this->assertInstanceOf('Laraeval', $laraeval);

        $laraeval = NULL;
    }

    public function testSimpleEcho() {
        $laraeval = new Laraeval('echo 123;');
        $value = $laraeval->execute();
        $expect = '123';

        $this->assertEquals($expect, $value);
    }

    public function testSimpleIf() {
        $if = <<<IF
\$me = 'Laraeval';
if (\$me === 'Laraeval') {
    echo 'OK Good!';
} else {
    echo 'Not Good!';
}
IF;
        $laraeval = new Laraeval($if);
        $value = $laraeval->execute();
        $expect = 'OK Good!';

        $this->assertEquals($expect, $value);
    }

    public function testSimpleLoop() {
        $loop = <<<LOOP
for (\$i=0; \$i<3; \$i++) {
    printf("%s\n", 'Laraeval');
}
LOOP;
        $laraeval = new Laraeval($loop);
        $value = $laraeval->execute();
        $expect = "Laraeval\nLaraeval\nLaraeval\n";

        $this->assertEquals($expect, $value);
    }

    public function testLaravelConfigFacade() {
        $laraeval = new Laraeval();
        $value = $laraeval->execute( "echo Config::get('app.timezone');" );
        $expect = Config::get('app.timezone');

        $this->assertEquals($expect, $value);
    }

    public function testLaravelHashFacade() {
        $code = <<<CODE
\$hash = Hash::make('laraeval');
echo (Hash::check('laraeval', \$hash) ? 'TRUE' : 'FALSE');
CODE;
        $laraeval = new Laraeval();
        $value = $laraeval->execute( $code );

        $hash = Hash::make('laraeval');
        $expect = (Hash::check('laraeval', $hash) ? 'TRUE' : 'FALSE');

        $this->assertEquals($expect, $value);
    }

    public function testRouteGetLaraeval() {
        $request = Request::create('/laraeval', 'GET');
        $content = Route::dispatch($request)->getContent();

        // check the response content, it should containts something like
        // '// Laraeval Shortcut'
        $this->assertGreaterThan( 0, strpos($content, '// Laraeval Shortcut') );
    }

    public function testRoutePostLaraeval() {
        $code = <<<CODE
echo "Foo Bar";
CODE;
        $post = array('code' => $code);
        Input::merge($post);
        
        $request = Request::create('/laraeval', 'POST', $post);
        
        $content = Route::dispatch($request)->getContent();

        // check the response content, it should containts string 'Foo Bar'
        // inside the div output
        $this->assertGreaterThan( 0, strpos($content, '<div id="output" tabindex="0">Foo Bar</div>') );
    }
}
