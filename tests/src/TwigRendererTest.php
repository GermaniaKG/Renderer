<?php
namespace tests;

use Germania\Renderer\TwigRenderer;
use Twig_Environment as TwigEnvironment;
use Prophecy\Argument;
use Prophecy\PhpUnit\ProphecyTrait;

class TwigRendererTest extends \PHPUnit\Framework\TestCase
{
    use ProphecyTrait;

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
