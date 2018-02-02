<?php
namespace Germania\Renderer;

use \Psr\Log\LoggerInterface;
use \Psr\Log\LoggerAwareTrait;
use \Psr\Log\LoggerAwareInterface;
use \Psr\Log\NullLogger;

class NullRenderer implements RendererInterface, LoggerAwareInterface
{

    use LoggerAwareTrait;

    public $default_return = null;

    /**
     * @param null $return_value Custom return value, defaults to null.
     */
    public function __construct( $return_value = null, LoggerInterface $logger = null )
    {
        $this->default_return = $return_value;
        $this->setLogger( $logger ?: new NullLogger );
    }


    /**
     * Returns null.
     *
     * @param  string $template The template file
     * @param  array  $context  Associative template variables array
     *
     * @return null
     */
    public function __invoke( $template, array $context = array())
    {
        $this->logger->info("Null-render template", [
            'template' => $template,
            'return' => $this->default_return
        ]);
        return $this->default_return;

    }
}
