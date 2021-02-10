<?php
namespace Germania\Renderer;

use \Psr\Log\LoggerAwareTrait;
use \Psr\Log\LoggerAwareInterface;

abstract class RendererAbstract implements RendererInterface, LoggerAwareInterface
{

    use LoggerAwareTrait;


    /**
     * @inheritDoc
     */
    abstract public function render( $template, array $context = array()) : string;


    /**
     * @inheritDoc
     */
    public function __invoke( $template, array $context = array())
    {
        return $this->render($template, $context);
    }

}
