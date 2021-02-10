<?php
namespace Germania\Renderer;

use \Psr\Log\LoggerInterface;
use \Psr\Log\NullLogger;

class SmartyRenderer extends RendererAbstract implements RendererInterface {


    /**
     * @var Smarty
     */
    public $smarty;


    /**
     * @param \Smarty              $smarty Your Smarty instance
     * @param LoggerInterface|null $logger Optional: PSR-3 Logger
     */
    public function __construct (\Smarty $smarty, LoggerInterface $logger = null )
    {
        $this->setSmarty( $smarty );
        $this->setLogger( $logger ?: new NullLogger );
    }


    /**
     * @param \Smarty              $smarty Your Smarty instance
     */
    public function setSmarty( \Smarty $smarty ) : self
    {
        $this->smarty = $smarty;
        return $this;
    }


    /**
     * @inheritDoc
     */
    public function render( $template, array $context = array()) : string
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
