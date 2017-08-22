<?php
namespace Germania\Renderer;

use cebe\markdown\Parser;

class RenderedMarkdownRenderer implements RendererInterface
{

    /**
     * @var RendererInterface
     */
    public $renderer;

    /**
     * @var Parser
     */
    public $markdown_parser;


    /**pu

     * @param RendererInterface $renderer        RendererInterface instance
     * @param Parser            $markdown_parser Carsten Brandt's cebe/markdown parser
     */
    public function __construct( RendererInterface $renderer, Parser $markdown_parser )
    {
        $this->renderer = $renderer;
        $this->markdown_parser = $markdown_parser;
    }


    /**
     * Returns parsed template output.
     *
     * @param  string $template The template file
     * @param  array  $context  Associative template variables array
     *
     * @return string Template output
     */
    public function __invoke( $template, array $context = array())
    {
        $renderer = $this->renderer;
        $markdown_parser = $this->markdown_parser;

        $markdown_content = $renderer($template, $context);
        return $markdown_parser->parse( $markdown_content );
    }


}
