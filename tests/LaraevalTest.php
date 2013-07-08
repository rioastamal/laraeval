<?php
/**
 * Unit testing for Laraeval model.
 *
 * @author Rio Astamal <me@rioastamal.net>
 */
class LaraevalTest extends TestCase {
    public function testFoo() {
        $this->assertTrue('foo' === 'foo');
    }

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
}
