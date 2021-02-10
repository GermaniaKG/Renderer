<?php
namespace Germania\Renderer;

use cebe\markdown\Parser;

use \Psr\Log\LoggerInterface;
use \Psr\Log\NullLogger;


class RenderedMarkdownRenderer extends RendererAbstract implements RendererInterface, RendererAwareInterface
{
    use RendererAwareTrait;

    /**
     * @var \cebe\markdown\Parser
     */
    public $markdown_parser;


    /**
     * @param RendererInterface      $renderer        RendererInterface instance
     * @param \cebe\markdown\Parser  $markdown_parser Carsten Brandt's cebe/markdown parser
     */
    public function __construct( RendererInterface $renderer, Parser $markdown_parser, LoggerInterface $logger = null )
    {
        $this->setRenderer($renderer);
        $this->setMarkdownParser($markdown_parser);
        $this->setLogger( $logger ?: new NullLogger );
    }


    /**
     * @param \cebe\markdown\Parser $markdown_parser Carsten Brandt's cebe/markdown parser
     */
    public function setMarkdownParser( Parser $markdown_parser ) : static
    {
        $this->markdown_parser = $markdown_parser;
        return $this;
    }


    /**
     * @inheritDoc
     */
    public function render( $template, array $context = array()) : string
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
