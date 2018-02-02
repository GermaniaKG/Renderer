<?php
namespace Germania\Renderer;

use cebe\markdown\Parser;

use \Psr\Log\LoggerInterface;
use \Psr\Log\LoggerAwareTrait;
use \Psr\Log\LoggerAwareInterface;


class RenderedMarkdownRenderer implements RendererInterface, LoggerAwareInterface
{
    use LoggerAwareTrait;

    /**
     * @var RendererInterface
     */
    public $renderer;

    /**
     * @var Parser
     */
    public $markdown_parser;


    /**
     * @param RendererInterface $renderer        RendererInterface instance
     * @param Parser            $markdown_parser Carsten Brandt's cebe/markdown parser
     */
    public function __construct( RendererInterface $renderer, Parser $markdown_parser, LoggerInterface $logger = null )
    {
        $this->renderer = $renderer;
        $this->markdown_parser = $markdown_parser;
        $this->setLogger( $logger ?: new NullLogger );
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
        $this->logger->info("Render template", [
            'template' => $template
        ]);

        $renderer = $this->renderer;

        $markdown_content = $renderer($template, $context);
        $markdown_parser = $this->markdown_parser;

        return $markdown_parser->parse( $markdown_content );
    }


}
