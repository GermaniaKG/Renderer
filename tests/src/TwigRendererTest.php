<?php
namespace tests;

use Germania\Renderer\TwigRenderer;
// use Twig\Environment as TwigEnvironment;
use \Twig_Environment as TwigEnvironment;
use \Prophecy\Argument;

class TwigRendererTest extends \PHPUnit\Framework\TestCase
{

    /**
     * @dataProvider provideDefaultValues
     */
    public function testSimple( $return_value )
    {
        $twig_mock = $this->prophesize( TwigEnvironment::class );
        $twig_mock->render(Argument::type('string'), Argument::type('array'))->willReturn($return_value);
        $twig = $twig_mock->reveal();

        $sut = new TwigRenderer( $twig );

        $rendered = $sut( "foo.tpl", array() );
        $this->assertEquals( $return_value, $rendered);

    }

    public function provideDefaultValues()
    {
        return array(
            [ "<html>" ]
        );
    }
}