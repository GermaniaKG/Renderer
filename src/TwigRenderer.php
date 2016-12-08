<?php
namespace Germania\Renderer;

use \Psr\Log\LoggerInterface;
use \Psr\Log\NullLogger;

class TwigRenderer implements RendererInterface {

    /**
     * @var Twig_Environment
     */
    public $twig;

    /**
     * @var LoggerInterface
     */
    public $logger;

    /**
     * @param \Twig_Environment    $twig   Your Twig_Environment instance
     * @param LoggerInterface|null $logger Optional: PSR-3 Logger
     */
    public function __construct (\Twig_Environment $twig, LoggerInterface $logger = null )
    {
        $this->twig = $twig;
        $this->logger = $logger ?: new NullLogger;
    }

    /**
     * {@inheritDoc }
     */
    public function __invoke( $template, array $context = array())
    {
        $this->logger->info("Render Twig template: " . $template, [
            'context'  => $context
        ]);

        $result = $this->twig->render($template, $context );

        $this->logger->info("Return template output");

        return $result;

    }
}
