<?php
namespace Germania\Renderer;

use \Psr\Log\LoggerInterface;
use \Psr\Log\NullLogger;

class NullRenderer extends RendererAbstract implements RendererInterface
{

    public $default_return = "";

    /**
     * @param null $return_value Custom return value, defaults to null.
     */
    public function __construct( string $return_value = "", LoggerInterface $logger = null )
    {
        $this->default_return = $return_value;
        $this->setLogger( $logger ?: new NullLogger );
    }


    /**
     * Returns empty string
     *
     * @inheritDoc
     */
    public function render( $template, array $context = array()) : string
    {
        $this->logger->info("Null-render template", [
            'template' => $template,
            'return' => $this->default_return
        ]);
        return $this->default_return;

    }
}
