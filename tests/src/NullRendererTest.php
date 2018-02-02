<?php
namespace tests;

use Germania\Renderer\NullRenderer;

class NullRendererTest extends \PHPUnit\Framework\TestCase
{

    /**
     * @dataProvider provideDefaultValues
     */
    public function testSimple( $default_value )
    {
        $sut = new NullRenderer( $default_value );

        $rendered = $sut( "foo.tpl", array() );
        $this->assertEquals( $default_value, $rendered);

    }

    public function provideDefaultValues()
    {
        return array(
            [ null ],
            [ "ABCD" ]
        );
    }
}
