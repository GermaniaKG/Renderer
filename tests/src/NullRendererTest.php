<?php
namespace tests;

use Germania\Renderer\NullRenderer;
use Germania\Renderer\RendererInterface;

class NullRendererTest extends \PHPUnit\Framework\TestCase
{

    /**
     * @dataProvider provideDefaultValues
     */
    public function testSimple( $default_value )
    {
        $sut = new NullRenderer( $default_value );
        $this->assertInstanceOf(RendererInterface::class, $sut);

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
