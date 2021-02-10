<?php
namespace tests;

use Germania\Renderer\RenderedMarkdownRenderer;
use Germania\Renderer\RendererInterface;
use Prophecy\Argument;
use Prophecy\PhpUnit\ProphecyTrait;

class RenderedMarkdownRendererTest extends \PHPUnit\Framework\TestCase
{
    use ProphecyTrait;


    public function testInstantiation( ) : RenderedMarkdownRenderer
    {
        $renderer_mock = $this->prophesize( RendererInterface::class );
        $renderer = $renderer_mock->reveal();

        $cb = new \cebe\markdown\Markdown;

        $sut = new RenderedMarkdownRenderer($renderer, $cb);
        $this->assertInstanceOf(RendererInterface::class, $sut);

        return $sut;
    }
}
