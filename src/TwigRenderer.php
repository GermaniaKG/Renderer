<?php
namespace Germania\Renderer;

use Psr\Log\LoggerInterface;
use Psr\Log\NullLogger;
use Twig\Environment as TwigEnvironment;

class TwigRenderer extends RendererAbstract implements RendererInterface {


    /**
     * @var \Twig\Environment
     */
    public $twig;

    /**
     * @param \Twig_Environment    $twig   Your Twig\Environment instance
     * @param LoggerInterface|null $logger Optional: PSR-3 Logger
     */
    public function __construct (TwigEnvironment $twig, LoggerInterface $logger = null )
    {
        $this->setTwig($twig);
        $this->setLogger( $logger ?: new NullLogger );
    }


    /**
     * @param \Twig\Environment    $twig   Your TwigEnvironment instance
     */
    public function setTwig(TwigEnvironment $twig)  : self
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
