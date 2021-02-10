<?php
namespace Germania\Renderer;

use \Psr\Log\LoggerInterface;
use \Psr\Log\NullLogger;
use Twig_Environment;

class TwigRenderer extends RendererAbstract implements RendererInterface {


    /**
     * @var Twig_Environment
     */
    public $twig;

    /**
     * @param \Twig_Environment    $twig   Your Twig_Environment instance
     * @param LoggerInterface|null $logger Optional: PSR-3 Logger
     */
    public function __construct (Twig_Environment $twig, LoggerInterface $logger = null )
    {
        $this->setTwig($twig);
        $this->setLogger( $logger ?: new NullLogger );
    }


    /**
     * @param \Twig_Environment    $twig   Your Twig_Environment instance
     */
    public function setTwig(Twig_Environment $twig)  : self
    {
        $this->twig = $twig;
        return $this;
    }


    /**
     * @inheritDoc
     */
    public function render( $template, array $context = array()) : string
    {
        $this->logger->info("Render Twig template: " . $template, [
            'context'  => $context
        ]);

        $result = $this->twig->render($template, $context );

        $this->logger->info("Return template output");

        return $result;

    }
}
