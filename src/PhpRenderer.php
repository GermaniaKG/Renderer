<?php
namespace Germania\Renderer;

use \Psr\Log\LoggerInterface;
use \Psr\Log\NullLogger;

class PhpRenderer implements RendererInterface {

    /**
     * @var LoggerInterface
     */
    public $logger;


    /**
     * @param LoggerInterface|null $logger Optional: PSR-3 Logger
     */
    public function __construct ( LoggerInterface $logger = null )
    {
        $this->logger = $logger ?: new NullLogger;
    }

    /**
     * Returns parsed template output.
     *
     * @param  string   $template The template file
     * @param  array    $context  Associative tempalte variables array
     * @param  Callable $callable Optional Callback handler for output buffering
     *
     * @return string   Template output
     *
     * @throws RuntimeException when include file is not readable somehow.
     */
    public function __invoke( $inc, array $context = array(), Callable $callback = null)
    {
        $this->logger->info("Render PHP include: " . $inc, [
            'context'  => $context,
            'callback' => $callback ?: "(not set)"
        ]);

        $error = false;

        if (is_readable( $inc )):

            $this->logger->debug("Extract variables to include scope", $context);
            extract( $context );

            $this->logger->debug("Start output buffer");
            ob_start( $callback );

            $this->logger->debug("Include file " . $inc);
            include $inc;

            $this->logger->info("Return rendered PHP output", [
                'content_length' => ob_get_length()
            ]);

            return ob_get_clean();

        elseif (!is_file($inc)):
            $error  = "PhpRenderer: Include file does not exist: " . ($inc ?: "(none)");
        else:
            $error = "PhpRenderer: Include file not readable: " . ($inc ?: "(none)");
        endif;


        if (!empty($error) and is_string( $error )):
            $this->logger->error( $error );
            throw new \RuntimeException( $error );
        endif;

    }
}
