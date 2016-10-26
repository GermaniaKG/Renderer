<?php
namespace Germania\Renderer;

use \Psr\Log\LoggerInterface;
use \Psr\Log\NullLogger;

class SmartyRenderer implements RendererInterface {

    /**
     * @var Smarty
     */
    public $smarty;

    /**
     * @var LoggerInterface
     */
    public $logger;

    /**
     * @param \Smarty              $smarty Your Smarty instance
     * @param LoggerInterface|null $logger Optional: PSR-3 Logger
     */
    public function __construct (\Smarty $smarty, LoggerInterface $logger = null )
    {
        $this->smarty = $smarty;
        $this->logger = $logger ?: new NullLogger;
    }

    /**
     * {@inheritDoc }
     */
    public function __invoke( $template, array $context = array())
    {
        $this->logger->info("Render Smarty template: " . $template, [
            'context'  => $context
        ]);

        $this->logger->debug("Create template object");
        $tpl = $this->smarty->createTemplate(  $template, $this->smarty );

        $this->logger->debug("Assign context variables");
        $tpl->assign( $context );

        $this->logger->info("Return template output");

        return $this->smarty->fetch($tpl);
    }
}
