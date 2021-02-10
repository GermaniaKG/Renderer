<?php
namespace tests;

use Germania\Renderer\SmartyRenderer;
use Germania\Renderer\RendererInterface;
use Prophecy\Argument;
use Prophecy\PhpUnit\ProphecyTrait;
use Smarty;

class SmartyRendererTest extends \PHPUnit\Framework\TestCase
{
    use ProphecyTrait;


    public function testInstantiation( ) : SmartyRenderer
    {
        $smarty_mock = $this->prophesize( Smarty::class );
        $smarty = $smarty_mock->reveal();


        $sut = new SmartyRenderer( $smarty );
        $this->assertInstanceOf(RendererInterface::class, $sut);

        return $sut;
    }

}
